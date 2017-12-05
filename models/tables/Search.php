<?php
/**
 * Created by PhpStorm.
 * User: Stepan
 * Date: 02.12.17
 * Time: 21:57
 */

namespace app\models\tables;


use app\models\User;
use yii\db\ActiveRecord;

class Search extends ActiveRecord
{
    /**
     * Метод возвращает имя таблицы
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{searches}}';
    }

    /**
     * Метод устанавливает связь с таблицей Users
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Метод устанавливает связь с таблицей Urls
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUrl()
    {
        return $this->hasOne(Url::className(), ['id' => 'url_id']);
    }
}