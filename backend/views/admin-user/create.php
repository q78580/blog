<?php

use yii\helpers\Html;
use \yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdminUser */

$this->title = Yii::t('app', 'Create Admin User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="admin-user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'profile')->textarea(['rows' => 6]) ?>


        <div class="form-group">
            <?= Html::submitButton( Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
