<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
            if(Yii::$app->user->can('createUser')){
                echo Html::a('Create User', ['create'], ['class' => 'btn btn-success']);
            }
        ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '',
        'emptyText' => '',
        'columns' => [
            'displayed_name',
            'email:email',
            [
                'attribute'=>'authentificationAssignment.item_name',
                'header' => 'Role'
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        if(Yii::$app->user->can('updateUser', ['id' => $model->id])){
                            return Html::a('<span class="glyphicon glyphicon-pencil">', ['user/update', 'id' => $model->id]);
                        }
                        return '';
                    },
                    'delete' => function ($url, $model, $key) {
                        if(Yii::$app->user->can('deleteUser', ['id' => $model->id])){
                            return Html::a('<span class="glyphicon glyphicon-trash">', ['user/delete', 'id' => $model->id], [
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
    ]); 
    
    ?>

</div>