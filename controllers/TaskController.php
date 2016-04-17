<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use app\models\Tasks;
use yii\data\ActiveDataProvider;
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;

class TaskController extends ActiveController
{

    public $modelClass = 'app\models\Tasks';

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
            'prepareDataProvider' =>  [$this, 'actionIndex'],
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

    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => Tasks::find()->where([
                'and','deleted=0',['or', 'author_id=:user_id','executor_id=:user_id']
            ])->addParams([':user_id' => Yii::$app->user->identity->getId()]),
        ]);
    }

    public function checkViewAccess($id, Tasks $model)
    {
        if ($model->deleted==1) throw new NotFoundHttpException("Not exist: $model->task_id");
        if (Yii::$app->user->identity->getId() != $model->author_id and Yii::$app->user->identity->getId() != $model->executor_id) {
            throw new NotAcceptableHttpException("Not Acceptable: $model->task_id");
        }
    }

    public function checkCreateAccess()
    {
        $data = Yii::$app->getRequest()->getBodyParams();
        $data['author_id'] = Yii::$app->user->identity->getId();
        Yii::$app->getRequest()->setBodyParams($data);
    }

    public function checkUpdateAccess($id, Tasks $model)
    {
        if ($model->deleted==1) throw new NotFoundHttpException("Not exist: $model->task_id");
        if (Yii::$app->user->identity->getId() != $model->author_id) throw new NotAcceptableHttpException("Not Acceptable: $model->task_id");
        $data = Yii::$app->getRequest()->getBodyParams();
        if (isset($data['author_id'])) unset($data['author_id']);
        if (isset($data['executor_id']) && $data['executor_id']!=$model->executor_id){
            $historyTask = new \app\models\HistoryTask();
            $historyTask->setAttributes([
                'comment'           =>  isset($data['comment'])?$data['comment']:'',
                'old_executor_id'   =>  $model->executor_id,
                'task_id'           =>  $model->task_id,
            ]);
            $historyTask->save();
        }
        Yii::$app->getRequest()->setBodyParams($data);
    }

    public function checkDeleteAccess($id, Tasks $model)
    {
        if ($model->deleted==1) throw new NotFoundHttpException("Not exist: $model->task_id");
        if (Yii::$app->user->identity->getId() != $model->author_id) throw new NotAcceptableHttpException("Not Acceptable: $model->task_id");
    }
}
