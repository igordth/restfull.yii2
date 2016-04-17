<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use app\models\Projects;
use yii\data\ActiveDataProvider;
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;

class ProjectController extends ActiveController
{

    public $modelClass = 'app\models\Projects';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index'] = [
            'class' => 'yii\rest\IndexAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'prepareDataProvider' =>  function ($action) {
                return new ActiveDataProvider([
                    'query' => Projects::find()->where([
                        'user_id'   =>  Yii::$app->user->identity->getId(),
                        'deleted'   =>  0,
                    ]),
                ]);
            }
        ];
        $actions['view'] =  [
            'class' => 'yii\rest\ViewAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkViewAccess'],
        ];
        $actions['create'] = [
            'class' => 'yii\rest\CreateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkCreateAccess'],
            'scenario' => $this->createScenario,
        ];
        $actions['update'] = [
            'class' => 'yii\rest\UpdateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkUpdateAccess'],
            'scenario' => $this->updateScenario,
        ];
        $actions['delete'] = [
            'class' => 'yii\rest\DeleteAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkDeleteAccess'],
        ];
        return $actions;
    }

    public function checkViewAccess($id, Projects $model)
    {
        if ($model->deleted==1) throw new NotFoundHttpException("Not exist: $model->project_id");
        if (Yii::$app->user->identity->getId() != $model->user_id) throw new NotAcceptableHttpException("Not Acceptable: $model->project_id");
    }

    public function checkCreateAccess()
    {
        $data = Yii::$app->getRequest()->getBodyParams();
        $data['user_id'] = Yii::$app->user->identity->getId();
        Yii::$app->getRequest()->setBodyParams($data);
    }

    public function checkUpdateAccess($id, Projects $model)
    {
        if ($model->deleted==1) throw new NotFoundHttpException("Not exist: $model->project_id");
        if (Yii::$app->user->identity->getId() != $model->user_id) throw new NotAcceptableHttpException("Not Acceptable: $model->project_id");
        $data = Yii::$app->getRequest()->getBodyParams();
        if (isset($data['user_id'])) unset($data['user_id']);
        Yii::$app->getRequest()->setBodyParams($data);
    }

    public function checkDeleteAccess($id, Projects $model)
    {
        if ($model->deleted==1) throw new NotFoundHttpException("Not exist: $model->project_id");
        if (Yii::$app->user->identity->getId() != $model->user_id) throw new NotAcceptableHttpException("Not Acceptable: $model->project_id");
    }
}
