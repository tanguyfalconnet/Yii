<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
?>
<div class="post">
    <h2><?= Html::encode($model->title) ?></h2>
    <h6><?= Html::label(Html::encode($model->user->username)) ?> </h6>
    <a href="<?= Url::to(['post/view', 'id' => $model->id]); ?>" style="margin-left:30%;">
        <img src="data:image;base64,<?= $model->image ?>" alt="<?= $model->id ?>" style="max-width:40%;max-height:30%;" />
    </a>
    <h6><?= Html::label('Comments : '.$model->getComments()->count()) ?> </h6>
    <hr>
</div>