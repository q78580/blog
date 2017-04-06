<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class = 'container'>
    <div class="row">

        <?php
        $this->title = Yii::t('app', 'Posts');
//        $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['index']];
        $this->params['breadcrumbs'][] = $this->title;
        ?>
        <div class="col-md-9">
            文章列表
            <?= \yii\widgets\ListView::widget([
                'id'=>'postList',
                'dataProvider' => $dataProvider,
                'itemView'=>'_listItem',//子视图，显示文章的标题等内容
                'layout'=>'{items} {pager}',
                'pager' => [
                    'maxButtonCount'=>10,
                    'nextPageLabel'=>Yii::t('app','下一页'),
                    'prevPageLabel'=>Yii::t('app','上一页'),
                ],
            ]) ?>

        </div>

        <div class="col-md-3">
            右侧

        </div>



    </div>
</div>