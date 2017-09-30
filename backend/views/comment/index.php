<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
//            'content:ntext',
            [
                'attribute'=> 'content',
                'value'=>'beginner'
                //可以让value为一个自定义函数，将返回结果作为显示内容
//                'value'    => function ($model) {
//                    $tmpStr = strip_tags($model->content);
//                    $tmpLen = mb_strlen($tmpStr);
//
//                    return mb_substr($tmpStr, 0, 20, 'utf-8') . (($tmpLen > 20) ? '...' : '');
//                },
            ],
            'status',
            'create_time:datetime',
            'userid',
//             'email:email',
//             'url:url',
             'post_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
