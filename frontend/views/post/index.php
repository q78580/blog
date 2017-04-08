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
        $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['index']];
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
            <div class="searchbox">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>查找文章
                    </li>
                    <li class="list-group-item">
                        <form class="form-inline" action="<?= Yii::$app->urlManager->createUrl(['post/index']);?>"  id="w0" method="get">
                            <div class="form-group">
                                <input type="text" class="form-control"  name="PostSearch[title]" id="w0input" placeholder="按标题"><!--placeholder 提示-->
                            </div>
                            <button type="submit" class="btn btn-default">搜索</button>
                        </form>
                    </li>
                </ul>
            </div>
            <div class="tagcloudbox">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>标签云
                    </li>
                    <li class="list-group-item">
                        <?= \frontend\components\TagsCloudWidget::widget(['tags'=>$tags])?>
                    </li>
                </ul>
            </div>
            <div class="commentbox">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>最新评论
                    </li>
                    <li class="list-group-item">
                        <?= \frontend\components\RctReplyWidget::widget(['comments'=>$comments])?>
                    </li>
                </ul>
            </div>
        </div>



    </div>
</div>