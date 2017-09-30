<?php

use common\models\Poststatus;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]);?>

    <p>
        <?= Html::a('创建文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel'  => $searchModel,
        'columns'      => [
            //['class' => 'yii\grid\SerialColumn'],
//            'id',
            [
                'attribute'     => 'id',
                'contentOptions'=> ['width'=>'106px'],
            ],
            'title',
             [
                 'attribute'=> 'authorName',
                 'value'    => 'author.nickname',
             ],
//            'content:ntext',
            'tags:ntext',
            [
                'attribute'=> 'status',
                'value'    => 'postStatus.name',
                'filter'   => Poststatus::find()
                ->select(['name', 'id'])
                ->orderBy('position')
                ->indexBy('id')
                ->column(),
                'contentOptions'=> ['width'=>'106px'],
            ],
            // 'create_time:datetime',
            [
                'attribute'=> 'update_time',
                //'value'=>date('Y-m-d H:i:s')
                'format'=> ['date', 'php:Y-m-d H:i:s'],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
