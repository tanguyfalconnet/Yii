<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

$this->title = Yii::t('backend', 'Update Comment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Comments Management'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="comment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'text')->textarea(['rows' => 2]) ?>
    
    <?= Html::img($model->post->image, ['alt' => $model->id, 'style' => 'width:40%;height:30%;']); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
