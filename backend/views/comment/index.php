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


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

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
                'filter'=>\common\models\CommentStatus::find()->select(['name','id'])->orderBy('position')->indexBy('id')->column(),
                'contentOptions'=>function($model){
                    if($model){
                        return ($model->status != 2)?['class'=>'bg-danger']:[];
                    }
                },
            ],
            [
                'attribute'=>'create_time',
                'format'=>'datetime',
                'label'=>'发布日期',
            ],

            // 'email:email',
            // 'url:url',
             [
                 'attribute'=>'post_title',
                 'label'=>'文章标题',
                 'value'=>'post.title',
             ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}<br>{update}<br>{delete}<br>{check}',
                'buttons'=>[
                    'check'=>function($url,$moel,$key){
                        $options = [
                            'title'=>Yii::t('app','审核'),
                            'aria-label'=>Yii::t('app','审核'),
                            'data-confirm'=>Yii::t('app','确定通过审核吗？'),
                            'data-method'=>'post',
                            'data-pjax'=>'0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-check"></span>>',$url,$options);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
