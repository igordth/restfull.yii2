<?php

use yii\db\Migration;

class m160417_173025_create_projects extends Migration
{
    public function up()
    {
        $this->createTable('projects', [
            'project_id'        => $this->primaryKey(11),
            'title'             => $this->string(255)->notNull(),
            'create_date'       => $this->dateTime()->notNull(),
            'expiration_date'   => $this->dateTime()->notNull(),
            'description'       => $this->text()->notNull(),
            'user_id'           => $this->integer(11)->notNull(),
            'status_id'         => $this->integer(3)->notNull()->defaultValue(0),
            'deleted'           => $this->integer(1)->notNull()->defaultValue(0),
        ]);

        $this->createIndex('idx-projects-user_id','projects','user_id');
        $this->createIndex('idx-projects-status_id','projects','status_id');

        $this->addForeignKey('fk-projects-user_id','projects','user_id','users','user_id','RESTRICT','CASCADE');
    }

    public function down()
    {
        $this->dropTable('projects');
    }
}
