<?php

use yii\db\Migration;

class m160417_172359_create_users extends Migration
{
    public function up()
    {
        $this->createTable('users', [
            'user_id'       => $this->primaryKey(11),
            'fname'	        => $this->string(255)->notNull(),
            'lname'	        => $this->string(255),
            'birthday'	    => $this->date(),
            'picture'	    => $this->string(255),
            'email'		    => $this->string(255)->notNull(),
            'password'		=> $this->string(255)->notNull(),
            'access_token'	=> $this->string(255)->notNull()->unique(),
        ]);
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
