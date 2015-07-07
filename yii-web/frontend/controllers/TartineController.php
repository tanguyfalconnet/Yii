<?php

namespace frontend\controllers;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\Tartine;
use common\models\Post;
use frontend\models\Notification;
use Yii;
use yii\helpers\Url;

class TartineController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['add', 'remove'],
                'rules' => [
                    [
                        'actions' => ['add', 'remove'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add' => ['post'],
                    'remove' => ['post'],
                ],
            ],
        ];
    }
    
    function init(){
        parent::init();
        $language = Yii::$app->cache->get('language');
        if($language == false){
            Yii::$app->cache->set('language', 'en-US');
            $language = 'en-US';
        }
        Yii::$app->language = $language;
    }
    
    public function actionAdd($postId)
    {
        $tartine = new Tartine;
        $tartine->post_id = $postId;
        $tartine->user_id = Yii::$app->user->id;
        $tartine->save();
        
        $post = Post::findOne($postId);
        if($post->user_id != Yii::$app->user->id){
            $notif = new Notification();
            $notif->author = Yii::$app->user->identity->displayed_name;
            $notif->message = 'spreaded your post';
            $notif->user_id = $post->user_id;
            $notif->save(false);
            $notif->link = Url::to(['notification/view', 'idNotif' => $notif->id, 'idPost' => $postId]);
            $notif->save(false);
        }
        return $this->goHome();
    }

    public function actionRemove($postId)
    {
        $this->findModel($postId, Yii::$app->user->id)->delete();
        return $this->goHome();
    }

    
    /**
     * Finds the Tartine model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $postId
     * @param integer $userId
     * @return Tartine the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($postId, $userId)
    {
        if (($model = Tartine::findOne(['post_id' => $postId, 'user_id' => $userId])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
