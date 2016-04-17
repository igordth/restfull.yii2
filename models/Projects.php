<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "projects".
 *
 * @property integer $project_id
 * @property string $title
 * @property string $create_date
 * @property string $expiration_date
 * @property string $description
 * @property integer $user_id
 * @property integer $status_id
 * @property integer $deleted
 *
 * @property Users $user
 */
class Projects extends ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class'	=>	TimestampBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT	=>	['create_date'],
                ],
                'value'	=>	new Expression('NOW()'),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'create_date', 'expiration_date', 'description', 'user_id'], 'required'],
            [['create_date', 'expiration_date'], 'safe'],
            [['description'], 'string'],
            [['user_id', 'status_id', 'deleted'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'project_id' => 'Project ID',
            'title' => 'Title',
            'create_date' => 'Create Date',
            'expiration_date' => 'Expiration Date',
            'description' => 'Description',
            'user_id' => 'User ID',
            'status_id' => 'Status ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'user_id']);
    }

    public function delete()
    {
        $this->deleted = 1;
        $this->save();
    }
}
