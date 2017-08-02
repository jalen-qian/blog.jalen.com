<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Poststatus;
use \yii\helpers\ArrayHelper;
use \common\models\Adminuser;

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
    //方法一：使用ActiveRecord
//    $postStatuObjs = Poststatus::find()->all();
//    $statuses      = ArrayHelper::map($postStatuObjs, 'id', 'name');

    //方法二：使用command
//    $postStatuses = Yii::$app->db->createCommand('select * from '.Poststatus::tableName())->queryAll();
//    $statuses = ArrayHelper::map($postStatuses, 'id', 'name');

    //方法三：使用QueryBuilder
//    $rows = (new \yii\db\Query())
//    ->select(['name','id'])
//    ->from(Poststatus::tableName())
//    ->indexBy('id') //indexBy()函数传入 id ，指定id作为索引
//    ->column();//column函数返回查询结果的第一列

    //方法四： 使用ActiveRecord的find方法，并使用QueryBuilder
//    $rows = Poststatus::find()
//    ->select(['name','id'])
//    ->indexBy('id')
//    ->column();


    //方法一：
    //$rows = Poststatus::find()->all();
//    $rows = ArrayHelper::map($rows,'id','name');

    //方法二：Command
    //$rows = Yii::$app->db->createCommand('select id,name from '.Poststatus::tableName())->queryAll();
    //$rows = ArrayHelper::map($rows,'id','name');

    //方法三：

    ?>

    <?= $form->field($model, 'status')->dropDownList($rows, ['prompt'=>'请选择状态']) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?php
    $authors = Adminuser::find()->select(['nickname','id'])
    ->indexBy('id')
    ->column();
    ?>

    <?= $form->field($model, 'author_id')->dropDownList($authors,['prompt'=>'请选择作者']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
