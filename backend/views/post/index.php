<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Post'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'id',
                'options'=>['width'=>'10']
            ],
            'title',
            [
                'attribute'=>'authorName',
                'value'=>'author.nickname',
                'label'=>'作者',
            ],
//            'content:ntext',
            'tags:ntext',
            [
                'value'=>'status0.name',
                'attribute'=>'status',
                'filter'=>\common\models\PostStatus::find()->select(['name','id'])->indexBy('id')->column(),
            ],
            // 'create_time:datetime',
            // 'update_time:datetime',


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
