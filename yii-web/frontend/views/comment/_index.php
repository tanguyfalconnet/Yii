<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="comment-index">
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}{pager}',
        'showHeader' => false,
        'tableOptions' => ['class' => 'table'],
        'emptyText' => '',
        'columns' => [
            'user.username',
            'text:ntext',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        if(Yii::$app->user->can('updatePost', ['id' => $model->user_id])){
                            return Html::a('<span class="glyphicon glyphicon-pencil">', ['comment/update', 'id' => $model->id]);
                        }
                        return '';
                    },
                    'delete' => function ($url, $model, $key) {
                        if(Yii::$app->user->can('deletePost', ['id' => $model->user_id])){
                            return Html::a('<span class="glyphicon glyphicon-trash">', ['comment/delete', 'id' => $model->id], [
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ]]);
                            }
                        return '';
                    }
                ]
                
            ],
        ],
    ]); ?>

</div>
