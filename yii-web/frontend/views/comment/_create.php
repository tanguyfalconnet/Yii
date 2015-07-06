<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Comment */

?>
<div class="comment-create">

    <div class="comment-form">

        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'text')->textarea(['rows' => "2"]) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('frontend', 'Comment'), ['class' => 'btn btn-success']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
