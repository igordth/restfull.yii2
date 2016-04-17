<?php

use yii\db\Migration;

class m160417_174540_create_tasks extends Migration
{
    public function up()
    {
        $this->createTable('tasks', [
            'task_id'           => $this->primaryKey(11),
            'title'             => $this->string(255)->notNull(),
            'description'       => $this->text()->notNull(),
            'executor_id'       => $this->integer(11)->notNull(),
            'author_id'         => $this->integer(11)->notNull(),
            'project_id'        => $this->integer(11)->notNull(),
            'status_id'         => $this->integer(3)->notNull()->defaultValue(0),
            'expiration_date'   => $this->dateTime()->notNull(),
            'deleted'           => $this->integer(1)->notNull()->defaultValue(0),
        ]);

        $this->createIndex('idx-tasks-executor_id','tasks','executor_id');
        $this->createIndex('idx-tasks-author_id','tasks','author_id');
        $this->createIndex('idx-tasks-project_id','tasks','project_id');
        $this->createIndex('idx-tasks-status_id','tasks','status_id');

        $this->addForeignKey('fk-tasks-executor_id','tasks','executor_id','users','user_id','RESTRICT','CASCADE');
        $this->addForeignKey('fk-tasks-author_id','tasks','author_id','users','user_id','RESTRICT','CASCADE');
        $this->addForeignKey('fk-tasks-project_id','tasks','project_id','projects','project_id','RESTRICT','CASCADE');
    }

    public function down()
    {
        $this->dropTable('tasks');
    }
}
