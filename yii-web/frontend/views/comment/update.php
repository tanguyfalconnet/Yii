<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

$this->title = Yii::t('frontend', 'Update Comment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Post'), 'url' => ['post/view', 'id' => $model->post_id]];
$this->params['breadcrumbs'][] = Yii::t('frontend', 'Update');
?>
<div class="comment-update">

    <div class="comment-form">

        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'text')->textarea(['rows' => "2"]) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('frontend', 'Accept'), ['class' => 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
