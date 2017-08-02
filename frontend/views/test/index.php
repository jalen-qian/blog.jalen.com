<?php

/* @var $this yii\web\View */
/* @var $model common\models\LoginForm */

use \yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'test index';
?>
<div class="test-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= HTML::tag('a', '下面是一个表单：', ['href'=>'/frontend/web/index.php?r=test/index']) ?>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id'=>'test-form', 'method'=>'post'])  ?>

            <?= $form->field($model, 'username')->textInput(['autoFocus'=>true]) ?>

            <?= $form->field($model, 'email')?>

            <?= $form->field($model, 'password')->passwordInput()?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <?//= $form->field($model, 'sex')->radioList([1=>'男',2=>'女',0=>'不详'])?>
            <?= $form->field($model, 'sex')->dropDownList([1=>'男',2=>'女',0=>'不详'])?>

            <?= $form->field($model, 'birthday')?>
            
            <?= $form->field($model, 'mood')->textarea(['cols'=>20,'rows'=>5])?>

            <div class="form-group">
                <?= Html::submitButton('提交',['class'=>'btn btn-primary','name'=>'contact-btn'])?>
            </div>
            
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
