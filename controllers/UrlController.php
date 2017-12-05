<?php
/**
 * Created by PhpStorm.
 * User: Stepan
 * Date: 02.12.17
 * Time: 22:31
 */

namespace app\controllers;


use app\models\forms\SearchForm;
use app\models\tables\Search;
use app\models\tables\Url as UrlTable;
use app\models\User;
use Sunra\PhpSimple\HtmlDomParser;
use yii\web\Controller;
use Yii;
use yii\helpers\Url;


class UrlController extends Controller
{
    /**
     * Метод отображает историю поиска и производит поиск, если была отправлена форма методом POST
     *
     * POST @params [string $url, string $query]
     *
     * @return string | Response
     */
    public function actionIndex()
    {
        $model = new SearchForm();

        if (Yii::$app->request->isPost === true)
        {
            $data = Yii::$app->request->post('SearchForm');

            if (($model->load(Yii::$app->request->post()) && $model->validate()) === false)
            {
                return $this->redirect(Url::to(['url/index'], true));
            }


            User::getDb()->transaction(function ($db) use ($data) {

                $url = UrlTable::firstOrCreate(['url' => $data['url']]);

                $search = new Search();
                $search->query = $data['query'];
                $search->url_id = $url->id;
                $search->result = $this->searchPage($url->url, $search->query);

                $search->link('user', Yii::$app->user->identity);
            });
        }


        $searches = Search::find()
            ->joinWith('user')
            ->joinWith('url')
            ->all();

        return $this->render('index', ['model' => $model, 'searches' => $searches]);
    }

    /**
     * Метод возвращает результат поиска слова на веб-странице или сообщает о неудаче
     *
     * @param string $url
     * @param string $word
     * @return string
     */
    private function searchPage($url, $word)
    {
        if (($result = $this->search($url, $word)) === false)
        {
            return 'Не удалось подключиться к указанному адресу';
        }
        elseif ($result === null)
        {
            return 'Ничего не найдено';
        }

        return $result;
    }

    /**
     * Метод пытается получить веб-страницу по указанному адресу и в случае удачи возвращает функцию поиска
     * Использует стороннюю библиотеку PHP Simple Html Dom Parser
     *
     * @param string $url
     * @param string $word
     * @return bool | null | string
     */
    private function search($url, $word)
    {
        try {
            $html = HtmlDomParser::file_get_html($url);
        } catch (\Exception $e)
        {
            return false;
        }

        return $this->searchInArray($html->find('text'), $word);

    }

    /**
     * Метод производит поиск искомого слова в массиве тектовых блоков
     *
     * @param array $texts
     * @param string $word
     * @return null | string
     */
    private function searchInArray(array $texts, $word)
    {
        foreach ($texts as $text)
        {
            if (mb_stripos($text->plaintext, $word) !== false)
            {
                return $text->parent()->outertext;
            }
        }

        return null;
    }

}