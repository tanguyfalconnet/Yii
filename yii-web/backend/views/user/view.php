<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('backend', 'User').' '.$model->displayed_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Users Management'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if(Yii::$app->user->can('updateUser', ['id' => $model->id])){
            echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        }
        if(Yii::$app->user->can('deleteUser', ['id' => $model->id])){
            echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
        }
        
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'displayed_name',
            'email:email',
            [
                'attribute'=>'authentificationAssignment.item_name',
                'label' => Yii::t('backend', 'Role')
            ],
        ],
    ]) ?>

</div>
