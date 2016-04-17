<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use app\models\Users;
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;

class UserController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
        ];
        return $behaviors;
    }

    public $modelClass = 'app\models\Users';

    public function actions()
    {
        return [
            'view'      =>   [
                'class' => 'yii\rest\ViewAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkViewAccess'],
            ],
            'update'    =>  [
                'class' => 'yii\rest\UpdateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkUpdateAccess'],
                'scenario' => $this->updateScenario,
            ]
        ];
    }

    public function checkViewAccess($id, Users $model)
    {
        if (Yii::$app->user->identity->getId() != $model->user_id) {
            throw new NotAcceptableHttpException("Not Acceptable.");
        }
    }

    public function checkUpdateAccess($id, Users $model)
    {
        if (Yii::$app->user->identity->getId() != $model->user_id) throw new NotAcceptableHttpException("Not Acceptable.");
        $data = Yii::$app->getRequest()->getBodyParams();
        if (isset($data['user_id'])) unset($data['user_id']);
        Yii::$app->getRequest()->setBodyParams($data);
    }
}
