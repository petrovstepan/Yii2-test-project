<?php
/**
 * Created by PhpStorm.
 * User: Stepan
 * Date: 02.12.17
 * Time: 21:53
 */

namespace app\models\tables;


use yii\db\ActiveRecord;

class Url extends ActiveRecord
{
    /**
     * Метод возвращает имя таблицы
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{urls}}';
    }

    /**
     * Метод ищет или создает новую запись в таблице и возвращает ее
     * Используя массив параметров вида ['url' => $url]
     *
     * @param array $params
     * @return Url
     */
    public static function firstOrCreate(array $params)
    {
        if (($url = self::findOne($params)) === null)
        {
            $url = new self($params);
            $url->save();
        }

        return $url;
    }
}