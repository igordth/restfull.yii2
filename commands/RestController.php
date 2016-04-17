<?php
namespace app\commands;

use yii\console\Controller;

class RestController extends Controller
{
    private $access_token = 'QWxhZGRpbjpvcGVuIHNlc2FtZQ==';

    public function actionUser($id)
    {
        $ch = curl_init();
        $url = "http://msgsoft/users/{$id}";
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->access_token);
        curl_exec($ch);
        curl_close($ch);
    }
    public function actionUser_update($id)
    {
        $ch = curl_init();
        $url = "http://msgsoft/users/{$id}";
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $this->access_token.':');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, "lname=Иванов");
        curl_exec($ch);
        curl_close($ch);
    }


    public function actionProjects()
    {
        $ch = curl_init();
        $url = "http://msgsoft/projects";
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->access_token.':');
        curl_exec($ch);
        curl_close($ch);
    }
    public function actionProject($id)
    {
        $ch = curl_init();
        $url = "http://msgsoft/projects/{$id}";
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->access_token.':');
        curl_exec($ch);
        curl_close($ch);
    }
    public function actionProject_create()
    {
        $ch = curl_init();
        $url = "http://msgsoft/projects";
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $this->access_token.':');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "title=title&description=description&create_date=2016-04-16 20:11:29&expiration_date=2016-04-16 20:11:29");
        curl_exec($ch);
        curl_close($ch);
    }
    public function actionProject_update($id)
    {
        $ch = curl_init();
        $url = "http://msgsoft/projects/{$id}";
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $this->access_token.':');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, "title=title_changed");
        curl_exec($ch);
        curl_close($ch);
    }
    public function actionProject_delete($id)
    {
        $ch = curl_init();
        $url = "http://msgsoft/projects/{$id}";
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $this->access_token.':');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_exec($ch);
        curl_close($ch);
    }



    public function actionTasks()
    {
        $ch = curl_init();
        $url = "http://msgsoft/tasks";
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->access_token.':');
        curl_exec($ch);
        curl_close($ch);
    }
    public function actionTask($id)
    {
        $ch = curl_init();
        $url = "http://msgsoft/tasks/{$id}";
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->access_token.':');
        curl_exec($ch);
        curl_close($ch);
    }
    public function actionTask_create()
    {
        $ch = curl_init();
        $url = "http://msgsoft/tasks";
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $this->access_token.':');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "title=task n&description=description&expiration_date=2016-04-16 20:11:29&executor_id=2&project_id=1");
        curl_exec($ch);
        curl_close($ch);
    }
    public function actionTask_update($id)
    {
        $ch = curl_init();
        $url = "http://msgsoft/tasks/{$id}";
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $this->access_token.':');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, "title=title_changed");
        curl_exec($ch);
        curl_close($ch);
    }
    public function actionTask_delete($id)
    {
        $ch = curl_init();
        $url = "http://msgsoft/tasks/{$id}";
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $this->access_token.':');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_exec($ch);
        curl_close($ch);
    }
}
