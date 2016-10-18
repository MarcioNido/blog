<?php

/* @var $this yii\web\View */

$this->title = 'User Authentication';
use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'Yii2 Project', 'url' => array('site/php-yii')];
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="js/styles/googlecode.css">
<script src="js/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
        
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                
                <h2>User Authentication</h2>
                <p>Yii2 basic template comes with a simple user authentication that uses an array of users inside User model class. So, we will change it to authenticate users using the database.</p>

                <p>First, let's create the user model class using Gii, the Yii2 code generator. If it's not configured yet, you will have to edit @app/config/web.php file to add the gii component like this:</p>
                <pre>
<code class='php'>
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['192.168.83.*'], // adjust to your client machine IP
    ];
}                        
</code>
                </pre>
                
                <p>Now, open the browser in your client machine and access gii at: http://apps.dev/basic-calendar/web/index.php?r=gii</p>
                <p>You should see the generator page like this:</p>
                <div class='thumbnail'>
                    <img class='img-responsive' src="images/ss-gii.png" />
                </div>
                
                <p>What we want now is the Model Generator, so select this option, fill the Table Name field with "user" and keep the default options for the rest of the form. Click Preview. There is already the old User model, so we have to check the "overwrite" box for it to replace the old model class with the new one:</p>
                <div class='thumbnail'>
                    <img class='img-responsive' src="images/ss-gii-overwrite.png" />
                </div>
                
                <p>Now we have the user model which extends from \yii\db\ActiveRecord class. But it won't authenticate the users, because to do so, the class must implement the \yii\web\IdentityInterface class. For this we will have to change the generated class and add the methods. </p>
                <p>In the end our user model class will look like this:</p>
                <pre>
<code class='php'>
&lt;?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $user_id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property integer $active
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
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'username', 'password'], 'required'],
            [['active'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['username'], 'string', 'max' => 30],
            [['password', 'access_token', 'auth_key'], 'string', 'max' => 100],
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
            'password' => 'Password',
            'active' => 'Active',
            'access_token' => 'Access Token',
            'auth_key' => 'Auth Key',
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
    
    /**
     * Validates a given password 
     * @param type $password
     * @return boolean true if the password is correct
     */
    public function validatePassword($password) {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
    
}                        
</code>
                </pre>        
                <p>The auth_key field is used for cookie validation. And the findIdentityByAccessToken method may be used for RESTful application, but you will have to implement it anyway, even if it is a blank method.</p>
                <p>More about user authentication can be found here: <a target="_blank" href="http://www.yiiframework.com/doc-2.0/guide-security-authentication.html#authentication">http://www.yiiframework.com/doc-2.0/guide-security-authentication.html#authentication</a></p>
                <p>If everything went well, we will be able to authenticate to our application using ADMIN/ADMIN or DEMO/DEMO, uppercase only now.</p>

            </div>
            
        </div>

    </div>
    
</div>

