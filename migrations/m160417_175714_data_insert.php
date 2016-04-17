<?php

use yii\db\Migration;

class m160417_175714_data_insert extends Migration
{
    public function up()
    {
        $this->batchInsert('users',[
            'user_id',
            'fname',
            'lname',
            'birthday',
            'picture',
            'email',
            'password',
            'access_token',
        ],
        [
            [1, 'Иван', 'Иванов', '2000-04-17', 'ivan.jpg', 'ivan@i.ru', '123', 'QWxhZGRpbjpvcGVuIHNlc2FtZQ=='],
            [2, 'Вася', 'Васильев', '1996-05-27', 'vasia.jpg', 'vasia@v.ru', '123', 'QWxhZGRpbjpvcGVuIHNlc2FtZQ22'],
        ]);

        $this->batchInsert('projects',[
            'project_id',
            'title',
            'create_date',
            'expiration_date',
            'description',
            'user_id',
            'status_id',
            'deleted',
        ],
        [
            [1, 'Тестовое задание', '2016-04-16 20:11:29', '2016-04-16 20:11:30', 'description', 1, 2, 0],
            [2, 'Project 2', '2016-04-16 20:11:29', '2016-04-16 20:11:30', 'description', 2, 2, 0],
            [3, 'Project 3', '2016-04-16 20:11:29', '2016-04-16 20:11:30', 'description', 1, 0, 0],
        ]);

        $this->batchInsert('tasks',[
            'task_id',
            'title',
            'description',
            'executor_id',
            'author_id',
            'project_id',
            'status_id',
            'expiration_date',
            'deleted',
        ],
            [
                [1, 'Task 1', 'task 1 description', 2, 1, 1, 1, '2016-04-17 11:04:51', 0],
                [2, 'Task 2', 'task 2 description', 2, 1, 1, 0, '2016-04-17 11:04:51', 0],
                [3, 'Task 3', 'task 3 description', 2, 2, 2, 0, '2016-04-17 11:04:51', 0],
            ]);
    }

    public function down()
    {
        return false;
    }

}
