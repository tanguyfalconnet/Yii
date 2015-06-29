<?php
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
/* @var dataProvider yii\data\ActiveDataProvider */
$this->title = 'Falcotatoe Company';


echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_post',
    'summary' => ''
]);
?>
