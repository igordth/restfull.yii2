<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ConsoleForm extends Model
{
    public $method;
    public $access_token;
    public $url;
    public $body;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['method', 'access_token', 'url'], 'required'],
            ['method', 'in', 'range' => ['GET', 'POST', 'PUT', 'DELETE']],
            ['body', 'trim']
        ];
    }

    public function getResult()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $this->access_token);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->body);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
