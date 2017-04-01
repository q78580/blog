<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Comments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Comment'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'id',
                'options'=>['width'=>'30px']
            ],
//            'content:ntext',
            [
                'attribute'=>'content',
                'value'=>'cont'
            ],
            [
                'attribute'=>'username',
                'label'=>'评论人',
                'value'=>'user.username',
            ],
            [
                'attribute'=>'status',
                'value'=>'status0.name',
                'filter'=>\common\models\CommentStatus::find()->select(['name','id'])->indexBy('id')->column()
            ],
            [
                'attribute'=>'create_time',
                'format'=>'datetime',
                'label'=>'发布日期',
            ],

            // 'email:email',
            // 'url:url',
             [
                 'attribute'=>'post.title',
                 'label'=>'文章标题',
             ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
