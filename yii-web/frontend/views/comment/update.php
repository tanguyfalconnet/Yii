<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

$this->title = 'Update Comment';
$this->params['breadcrumbs'][] = ['label' => 'Post', 'url' => ['post/view', 'id' => $model->post_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="comment-update">

    <div class="comment-form">

        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'text')->textarea(['rows' => "2"]) ?>

            <div class="form-group">
                <?= Html::submitButton('Accept', ['class' => 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
