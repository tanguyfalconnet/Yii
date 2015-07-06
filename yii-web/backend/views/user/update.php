<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UpdateUserForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('backend', 'Update User') . ' ' . $model->displayed_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Users Management'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'User').' '.$model->displayed_name, 'url' => ['view', 'id' => $model->getId()]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin();
        echo $form->field($model, 'displayed_name');
        echo $form->field($model, 'email');
        echo $form->field($model, 'password')->passwordInput();
        if(array_key_exists('admin', Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))){
            echo $form->field($model, 'role')->dropDownList($model->available_role);
        }
        if(Yii::$app->user->can('updateUser', ['id' => $model->getId()])){
            echo '<div class="form-group">';
                echo Html::submitButton(Yii::t('backend', 'Update'), ['class' => 'btn btn-primary']);
            echo "</div>";
        }
    ActiveForm::end(); ?>

</div>
