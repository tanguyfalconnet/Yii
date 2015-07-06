<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Smiley;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
?>
<div class="post">
    <h2><?= Smiley::emo(Html::encode($model->title), Smiley::$TITLE) ?></h2>
    <h6><?= Html::label(Html::encode($model->user->displayed_name)) ?> </h6>
    <a href="<?= Url::to(['post/view', 'id' => $model->id]); ?>" style="margin-left:30%;">
        <?= Html::img($model->image, [ 'alt' => $model->id, 'style' => 'max-width:40%;max-height:30%;']) ?>
    </a>
    <h6><?= Html::label('Comments : '.$model->getComments()->count()) ?> </h6>
    <hr>
</div>