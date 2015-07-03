<?php

namespace frontend\controllers;

use Yii;
use common\models\Post;
use common\models\Comment;
use frontend\models\CreatePostForm;
use frontend\models\CreateCommentForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use frontend\models\Notification;
use yii\helpers\Url;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = new CreateCommentForm();
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()->where(['post_id' => $id])->orderBy(['created_at' => SORT_ASC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        
        if ($model->load(Yii::$app->request->post()) && $model->create($id)) {
            
            $post = $this->findModel($id);
            if(Yii::$app->user->id != $post->user_id){
                //Notify the one who create the post
                $notif = new Notification();
                $notif->link = Url::to(['post/view', 'id' => $id]);
                $notif->message = Yii::$app->user->identity->username.' commented on your post';
                $notif->user_id = $post->user_id;
                $notif->save();
                
            }
            //Notify those who comments the post
            $users = [Yii::$app->user->id, $post->user_id];
            foreach ($post->comments as $value) {
                if(!in_array($value->user_id, $users)){
                    $notif = new Notification();
                    $notif->link = Url::to(['post/view', 'id' => $id]);
                    $notif->message = Yii::$app->user->identity->username.' commented on a post you commented before';
                    $notif->user_id = $value->user_id;
                    $notif->save();
                    $users[] = $value->user_id;
                }
            }
            return $this->redirect(['view', 'id' => $id]);
        }
        return $this->render('view', [
            'modelPost' => $this->findModel($id),
            'modelComment' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CreatePostForm();
                
        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            
            if($model->create()){
                return $this->redirect(['site/index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if(Yii::$app->user->can('updatePost', ['id' => $id])){
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        foreach ($model->comments as $value){
            $value->delete();
        }
        
        if($model->delete() !== false){
            Yii::$app->cache->delete(Post::tableName().'_'.$id);
        }

        return $this->redirect(['site/index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Yii::$app->cache->get(Post::tableName().'_'.$id);
        if ($model === false) {
            if (($model = Post::findOne($id)) !== null) {
                Yii::$app->cache->set(Post::tableName().'_'.$id, $model);
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
        
        return $model;
    }
}
