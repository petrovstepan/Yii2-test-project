<?php

namespace app\models;

use app\models\tables\Search;
use yii\db\ActiveRecord;
use Yii;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * Метод возвращает имя таблицы
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{users}}';
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {

    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['name' => $username]);
    }

    /**
     * Метод находит пользователя по email
     *
     * @param $email
     * @return null | User
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {

    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {

    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->validateBcryptPass($password, $this->password);
    }

    /**
     * Метод валидирует пароль с помощью функции шифрования bcrypt
     *
     * @param $password
     * @param $hash
     * @return bool
     */
    private function validateBcryptPass($password, $hash)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $hash);
    }

    /**
     * Метод устанавливает связь с таблицей Searches
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSearches()
    {
        return $this->hasMany(Search::className(), ['user_id' => 'id']);
    }
}
