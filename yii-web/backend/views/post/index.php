<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Smiley;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'emptyText' => '',
        'columns' => [
            [
                'header' => 'Title',
                'content' => function ($model, $key, $index, $column) {
                    return Smiley::emo(Html::encode($model->title),Smiley::$COMMENT);
                }
                
            ],
            [
                'header' => 'Image',
                'content' => function ($model, $key, $index, $column) {
                    return Html::img($model->image, ['alt' => $model->id, 'style' => 'width:10%;height:10%;']);
                }
                
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        if(Yii::$app->user->can('updatePost', ['id' => $model->user_id])){
                            return Html::a('<span class="glyphicon glyphicon-pencil">', ['update', 'id' => $model->id]);
                        }
                        return '';
                    },
                    'delete' => function ($url, $model, $key) {
                        if(Yii::$app->user->can('deletePost', ['id' => $model->user_id])){
                            return Html::a('<span class="glyphicon glyphicon-trash">', ['delete', 'id' => $model->id], [
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
