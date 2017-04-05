<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$model = \common\models\AdminUser::findOne($id);
$this->title = '权限设置'.' '.$model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="admin-user-update">
    <h1><?= Html::encode($this->title) ?></h1>


        <div class="admin-user-privilege-form">
            <?php $form = ActiveForm::begin([]); ?>

            <?= Html::checkboxList('newPri',$authAssignments,$allPrivileges) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

</div>
