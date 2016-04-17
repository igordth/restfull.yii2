<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "tasks".
 *
 * @property integer $task_id
 * @property string $title
 * @property string $description
 * @property integer $executor_id
 * @property integer $author_id
 * @property integer $project_id
 * @property integer $status_id
 * @property string $expiration_date
 * @property string $deleted
 *
 * @property Users $executor
 * @property Users $author
 * @property Projects $project
 */
class Tasks extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'executor_id', 'author_id', 'project_id', 'expiration_date'], 'required'],
            [['description'], 'string'],
            [['executor_id', 'status_id', 'deleted', 'author_id', 'project_id'], 'integer'],
            [['expiration_date'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['executor_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Task ID',
            'title' => 'Title',
            'description' => 'Description',
            'executor_id' => 'Executor ID',
            'author_id' => 'Author ID',
            'project_id' => 'Project ID',
            'status_id' => 'Status ID',
            'expiration_date' => 'Expiration Date',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'executor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'author_id']);
    }

    public function getProject()
    {
        return $this->hasOne(Users::className(), ['project_id' => 'project_id']);
    }

    public function delete()
    {
        $this->deleted = 1;
        $this->save();
    }
}
