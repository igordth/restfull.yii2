<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "history_task".
 *
 * @property integer $history_task_id
 * @property integer $old_executor_id
 * @property integer $task_id
 * @property string $comment
 * @property string $create_date
 *
 * @property Tasks $task
 * @property Users $oldExecutor
 */
class HistoryTask extends \yii\db\ActiveRecord
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
        return 'history_task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old_executor_id', 'task_id',], 'required'],
            [['old_executor_id', 'task_id'], 'integer'],
            [['comment'], 'string'],
            [['create_date'], 'safe'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'task_id']],
            [['old_executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['old_executor_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'history_task_id' => 'History Task ID',
            'old_executor_id' => 'Old Executor ID',
            'task_id' => 'Task ID',
            'comment' => 'Comment',
            'create_date' => 'Create Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['task_id' => 'task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOldExecutor()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'old_executor_id']);
    }
}
