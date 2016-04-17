<?php

/* @var $this yii\web\View */
/* @var $model app\models\ConsoleForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Web console';
?>
<div class="site-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'console-form']); ?>

            <?= $form->field($model, 'method')->dropDownList(['GET'=>'GET', 'POST'=>'POST', 'PUT'=>'PUT', 'DELETE'=>'DELETE']) ?>

            <?= $form->field($model, 'url')?>

            <?= $form->field($model, 'access_token') ?>

            <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <?php if (Yii::$app->session->hasFlash('result')):?>
                <div class="default-view-results">
                    <pre>
                        <?= Yii::$app->session->getFlash('result') ?>
                    </pre>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>
