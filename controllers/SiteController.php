<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\ConsoleForm;

class SiteController extends Controller
{

    public function actionIndex()
    {
        $model = new ConsoleForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->session->setFlash('result', $model->getResult());
            return $this->refresh();
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

}
