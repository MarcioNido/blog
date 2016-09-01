<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cal_user".
 *
 * @property integer $user_id
 * @property string $name
 * @property string $username
 * @property string $passw
 * @property string $active
 * @property string $access_token
 * @property string $auth_key
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['username'], 'string', 'max' => 30],
            [['passw', 'access_token', 'auth_key'], 'string', 'max' => 100],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'name' => 'Name',
            'username' => 'Username',
            'passw' => 'Password',
            'active' => 'Active',
            'access_token' => 'Access Token',
            'auth_key' => 'Authentication Key',
        ];
    }
    
    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }
    
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->user_id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    
    /**
     * Generates authentication key before an insert 
     * @param type $insert
     * @return boolean
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord || $this->auth_key === null) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }    
    
    
    public function validatePassword($passw) {
        // only for generating the first two passwords 
        if ($this->passw === null && ($this->username == 'ADMIN' || $this->username == 'DEMO')) {
            $this->passw = Yii::$app->getSecurity()->generatePasswordHash($passw);
            $this->save();
        }
        return Yii::$app->getSecurity()->validatePassword($passw, $this->passw);
    }
    
}
