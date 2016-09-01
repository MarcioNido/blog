<?php

namespace app\modules\calendar\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "cal_event".
 *
 * @property integer $event_id
 * @property integer $user_id
 * @property integer $category_id
 * @property string $date
 * @property string $time
 * @property string $description
 * @property string $status
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
            [['date'], 'date', 'format'=>'php:Y-m-d', 'enableClientValidation' => false],
            [['time'], 'date', 'format'=>'php:H:i', 'enableClientValidation' => false],
            [['status'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'category_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'event_id' => 'Event ID',
            'user_id' => 'User ID',
            'category_id' => 'Category ID',
            'date' => 'Date',
            'time' => 'Time',
            'description' => 'Description',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['category_id' => 'category_id']);
    }
    
    public function beforeSave($insert) {
        if (isset($this->date_time_short)) unset($this->date_time_short);
        if (isset($this->date_short)) unset($this->date_short);
        return parent::beforeSave($insert);
    }
    
    public function afterFind() {
        $this->date_time_short = date('D M-d H:i', strtotime($this->date." ".$this->time));
        $this->date_short = date('l M-d', strtotime($this->date));
        parent::afterFind();
    }
    
}
