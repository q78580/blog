<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Admin Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', '创建管理员'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=> 'id',
                'contentOptions'=>['width'=>'30px']
            ],
            'username',
            'nickname',
//            'password',
            'email:email',
            // 'profile:ntext',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {privilege} {reset}',
                'buttons'=>[
                    'reset'=>function($url,$moel,$key){
                        $options = [
                            'title'=>Yii::t('app','Reset Password'),
                            'data-label'=>Yii::t('app','Reset Password'),
                            'data-pjax'=>0,
                        ];
                        return Html::a('<span class="glyphicon glyphicon-lock"></span>',$url,$options);
                    },
                    'privilege'=>function($url,$moel,$key){
                        $options = [
                            'title'=>Yii::t('app','Check Limit'),
                            'data-label'=>Yii::t('app','Check Limit'),
                            'data-pjax'=>0,
                        ];
                        return Html::a('<span class="glyphicon glyphicon-user"></span>',$url,$options);
                    }

                ],
                'contentOptions'=>['width'=>'80px']
            ],
        ],
    ]); ?>
</div>
