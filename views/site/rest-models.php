<?php

/* @var $this yii\web\View */

$this->title = 'REST Creating the Models';
use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'REST Project', 'url' => array('site/rest')];
$this->params['breadcrumbs'][] = $this->title;
?>

<link rel="stylesheet" href="js/styles/googlecode.css">
<script src="js/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

        
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                
                <h2>REST Creating the Models</h2>
                <p>The models for the user table, category and events will be the same that we created in the Yii2 Framework Tutorial.</p>
                <p>In a real world application they could be shared in a common folder. We could also create a model inside our API module extending the original model class and making some changes if necessary.</p>
                <p>For this tutorial, I will just copy the models and change the namespaces to use it as an independent application.</p>
                <p>The models will be like this:</p>
                <pre>
                    <code>
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
            [['name'], 'string', 'max' =&gt; 50],
            [['username'], 'string', 'max' =&gt; 30],
            [['password', 'access_token', 'auth_key'], 'string', 'max' =&gt; 100],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' =&gt; 'User ID',
            'name' =&gt; 'Name',
            'username' =&gt; 'Username',
            'password' =&gt; 'Password',
            'active' =&gt; 'Active',
            'access_token' =&gt; 'Access Token',
            'auth_key' =&gt; 'Auth Key',
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
        return static::findOne(['access_token' =&gt; $token]);
    }
    
    public static function findByUsername($username)
    {
        return static::findOne(['username' =&gt; $username]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this-&gt;user_id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this-&gt;auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this-&gt;getAuthKey() === $authKey;
    }
    
    /**
     * Generates authentication key before an insert 
     * @param type $insert
     * @return boolean
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this-&gt;isNewRecord || $this-&gt;auth_key === null) {
                $this-&gt;auth_key = \Yii::$app-&gt;security-&gt;generateRandomString();
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
        return Yii::$app-&gt;getSecurity()-&gt;validatePassword($password, $this-&gt;password);
    }
    
}
                        
                    </code>
                </pre>
                
                
                <pre>
<code>
&lt;?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "cal_category".
 *
 * @property integer $category_id
 * @property string $name
 * @property integer $active
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cal_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['active'], 'integer'],
            [['name'], 'string', 'max' =&gt; 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' =&gt; 'Category ID',
            'name' =&gt; 'Name',
            'active' =&gt; 'Active',
        ];
    }
    
    
}
                        
</code>
                </pre>
                
                <pre>
                    <code>
&lt;?php

namespace app\modules\v1\models;

use Yii;
use app\models\User;
use app\modules\v1\models\Category;

/**
 * This is the model class for table "cal_event".
 *
 * @property integer $event_id
 * @property integer $user_id
 * @property integer $category_id
 * @property string $date
 * @property string $time
 * @property string $description
 * @property integer $active
 * @property integer $done
 *
 * @property User $user
 * @property Category $category
 */
class Event extends \yii\db\ActiveRecord
{
    
    public $date_time_short;
    public $date_short;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cal_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id', 'date', 'time', 'description'], 'required'],
            [['user_id', 'category_id'], 'integer'],
            [['description'], 'safe'],
            [['date'], 'date', 'format'=&gt;'php:Y-m-d', 'enableClientValidation' =&gt; false],
            [['time'], 'date', 'format'=&gt;'php:H:i:s', 'enableClientValidation' =&gt; false],
            [['active', 'done'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' =&gt; true, 'targetClass' =&gt; User::className(), 'targetAttribute' =&gt; ['user_id' =&gt; 'user_id']],
            [['category_id'], 'exist', 'skipOnError' =&gt; true, 'targetClass' =&gt; Category::className(), 'targetAttribute' =&gt; ['category_id' =&gt; 'category_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'event_id' =&gt; 'Event ID',
            'user_id' =&gt; 'User ID',
            'category_id' =&gt; 'Category ID',
            'date' =&gt; 'Date',
            'time' =&gt; 'Time',
            'description' =&gt; 'Description',
            'active' =&gt; 'Active',
            'done' =&gt; 'Done',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this-&gt;hasOne(User::className(), ['user_id' =&gt; 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this-&gt;hasOne(Category::className(), ['category_id' =&gt; 'category_id']);
    }
    
    public function beforeSave($insert) {
        if (isset($this-&gt;date_time_short)) unset($this-&gt;date_time_short);
        if (isset($this-&gt;date_short)) unset($this-&gt;date_short);
        return parent::beforeSave($insert);
    }
    
    public function afterFind() {
        $this-&gt;date_time_short = date('D M-d H:i', strtotime($this-&gt;date." ".$this-&gt;time));
        $this-&gt;date_short = date('l M-d', strtotime($this-&gt;date));
        parent::afterFind();
    }
    
    public function beforeValidate() {
        // just to validate time format
        if (strlen($this-&gt;time) == 5) $this-&gt;time .= ':00';
        return parent::beforeValidate();
    }
    
}
                        
</code>
                </pre>
                
                
              
            </div>
        </div>

    </div>
</div>
