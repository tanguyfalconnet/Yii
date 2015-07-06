<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Smiley;

/* @var $this yii\web\View */
/* @var $modelPost common\models\Post */
/* @var $modelComment common\models\Comment */

$this->title = $modelPost->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Smiley::emo(Html::encode($modelPost->title),Smiley::$TITLE) ?></h1>

    <p>
        <?php 
        if(Yii::$app->user->can('updatePost', ['id' => $modelPost->user_id])){
            echo Html::a(Yii::t('frontend', 'Update'), ['update', 'id' => $modelPost->id], ['class' => 'btn btn-primary']);
        }
        if(Yii::$app->user->can('deletePost', ['id' => $modelPost->user_id])){
            echo Html::a(Yii::t('frontend', 'Delete'), ['delete', 'id' => $modelPost->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('frontend', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </p>
    <?= Html::img($modelPost->image,['alt' => $modelPost->id, 'style' => 'max-width:80%;max-height:60%;margin-left:30%;']) ?>
    <?= DetailView::widget([
        'model' => $modelPost,
        'attributes' => [
            [
                'attribute'=>'user.displayed_name',
                'label' => Yii::t('frontend', 'Created By')
            ],
        ],
    ]) ?>
    
</div>
<?= $this->render('../comment/_create', [
    'model' => $modelComment,
]) ?>

<?= $this->render('../comment/_index', [
    'dataProvider' => $dataProvider
]) ?>