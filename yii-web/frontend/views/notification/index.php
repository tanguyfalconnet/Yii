<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'Notifications');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'emptyText' => '',
        'columns' => [
            [
                'header' => Yii::t('frontend', 'Message'),
                'content' => function ($model, $key, $index, $column){
                    if($model->is_watched == 1)
                    {
                        return Html::a($model->message, $model->link);
                    }
                    else
                    {
                        return Html::tag('b', Html::a($model->message, $model->link));
                    }
                    
                }
            ],
            [
                'header' => Yii::t('frontend', 'Date'),
                'content' => function ($model, $key, $index, $column){
                    return Html::encode(date('H:i:s d-m-Y ', $model->created_at));
                }
            ]
        ],
        
    ]); ?>

</div>
