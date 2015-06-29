<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\CreatePostForm */

$this->title = 'Update Post';
$this->params['breadcrumbs'][] = ['label' => 'Post', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title') ?>
    
    <?= Html::img('@web/'.$model->image, ['alt' => $model->id, 'style' => 'max-width:40%;max-height:30%;']) ?>
    
    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>