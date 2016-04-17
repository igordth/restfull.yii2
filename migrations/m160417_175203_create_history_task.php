<?php

use yii\db\Migration;

class m160417_175203_create_history_task extends Migration
{
    public function up()
    {
        $this->createTable('history_task', [
            'history_task_id' => $this->primaryKey(11),
            'old_executor_id' => $this->integer(11)->notNull(),
            'task_id' => $this->integer(11)->notNull(),
            'comment' => $this->text(),
            'create_date' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex('idx-history_task-old_executor_id','history_task','old_executor_id');
        $this->createIndex('idx-history_task-task_id','history_task','task_id');

        $this->addForeignKey('fk-history_task-old_executor_id','history_task','old_executor_id','users','user_id','RESTRICT','CASCADE');
        $this->addForeignKey('fk-history_task-task_id','history_task','task_id','tasks','task_id','RESTRICT','CASCADE');
    }

    public function down()
    {
        $this->dropTable('history_task');
    }
}
