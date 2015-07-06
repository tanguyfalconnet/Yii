<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'languagefrfr', 'languageenus'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'languagefrfr' => ['post'],
                    'languageenus' => ['post'],
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

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionLanguagefrfr()
    {
        Yii::$app->language = Yii::$app->cache->set('language', 'fr-FR');
        return $this->goHome();
    }
    
    public function actionLanguageenus()
    {
        Yii::$app->language = Yii::$app->cache->set('language', 'en-US');
        return $this->goHome();
    }
}
