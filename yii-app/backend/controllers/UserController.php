<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\CreateUserForm;
use backend\models\UpdateUserForm;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'roles' => ['admin'],
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['site/index']);
                }
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('createUser')) {
            $model = new CreateUserForm();
            if ($model->load(Yii::$app->request->post()) && $user = $model->create()) {
                $auth = Yii::$app->authManager;
                $auth->assign($auth->getRole($model->getAvailableRoles()[$model->role]), $user->id);
                return $this->redirect(['view', 'id' => $user->id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }else{
            return $this->redirect(['index']);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('updateUser', ['id' => $id])) {
            $model = new UpdateUserForm($id);

            if ($model->load(Yii::$app->request->post()) && $model->update()) {
                $auth = Yii::$app->authManager;
                $auth->revokeAll($id);
                $auth->assign($auth->getRole($model->getAvailableRoles()[$model->role]), $id);
                return $this->redirect(['view', 'id' => $model->getId()]);
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('deleteUser', ['id' => $id])) {
            $model = $this->findModel($id);
            foreach ($model->comments as $value){
                $value->delete();
            }
            foreach ($model->posts as $value){
                foreach ($value->comments as $value2){
                    $value2->delete();
                }
                $value->delete();
            }
            $auth = Yii::$app->authManager;
            $auth->revokeAll($model->id);
            $model->delete();
            return $this->redirect(['user/index']);
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
