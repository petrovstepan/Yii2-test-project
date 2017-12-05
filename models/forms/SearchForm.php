<?php
/**
 * Created by PhpStorm.
 * User: Stepan
 * Date: 02.12.17
 * Time: 3:16
 */

namespace app\models\forms;

use Sunra\PhpSimple\HtmlDomParser;
use yii\base\Model;

class SearchForm extends Model
{
    public $url;
    public $query;

    /**
     * Метод содержит правила для валидации полей формы
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['url', 'query'], 'required'],
            [['url' ], 'url']
        ];
    }

}