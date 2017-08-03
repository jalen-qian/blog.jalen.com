<?php

use \common\models\Adminuser;
use \yii\helpers\ArrayHelper;
use common\models\Poststatus;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>

    <?php
    /**
    //方法一：使用ActiveRecord
    $postStatuObjs = Poststatus::find()->all();
    $statuses      = ArrayHelper::map($postStatuObjs, 'id', 'name');

    //方法二：使用command
    $postStatuses = Yii::$app->db->createCommand('select * from '.Poststatus::tableName())->queryAll();
    $statuses = ArrayHelper::map($postStatuses, 'id', 'name');

    //方法三：使用QueryBuilder
    $rows = (new \yii\db\Query())
    ->select(['name','id'])
    ->from(Poststatus::tableName())
    ->indexBy('id') //indexBy()函数传入 id ，指定id作为索引
    ->column();//column函数返回查询结果的第一列

    //方法四： 使用ActiveRecord的find方法，并使用QueryBuilder
    $rows = Poststatus::find()
    ->select(['name','id'])
    ->indexBy('id')
    ->column();*/
    ?>

    <?= $form->field($model, 'status')->dropDownList(
        Poststatus::find()
        ->select(['name', 'id'])
        ->indexBy('id')
        ->column(), ['prompt'=>'请选择状态']) ?>

    <?= $form->field($model, 'author_id')->dropDownList(
        Adminuser::find()->select(['nickname', 'id'])
        ->indexBy('id')
        ->column(), ['prompt'=>'请选择作者']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
