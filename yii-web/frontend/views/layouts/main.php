<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Tartine-toi',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => Yii::t('frontend', 'Home'), 'url' => ['/site/index']]
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => Yii::t('frontend', 'Signup'), 'url' => ['/site/signup']];
                $menuItems[] = ['label' => Yii::t('frontend', 'Login'), 'url' => ['/site/login']];
            } else {
                $notifs = Yii::$app->user->identity->getNotifications()->where(['is_watched' => 0]);
                $count = $notifs->count();
                if($count == 0){
                    $badge = '<span class="badge alert-default">'.$count.'</span>';
                }else{
                    $badge = '<span class="badge alert-info">'.$count.'</span>';
                }
                $menuItems[] = ['label' => Yii::t('frontend', 'Notifications').$badge, 
                    'url' => ['notification/index']];
                
                $menuItems[] = ['label' => Yii::t('frontend', 'Create Post'), 'url' => ['/post/create']];
                $menuItems[] = [
                    'label' => Yii::t('frontend', 'Logout').' ('.Html::encode(Yii::$app->user->identity->displayed_name).')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            
            if(Yii::$app->cache->get('language') == 'en-US'){
                $menuItems[] = ['label' => Html::img('images/flags/fr-FR.jpg'), 
                'url' => ['site/languagefrfr'],
                'linkOptions' => ['data-method' => 'post']];
            }else if(Yii::$app->cache->get('language') == 'fr-FR'){
                $menuItems[] = ['label' => Html::img('images/flags/en-US.jpg'), 
                'url' => ['site/languageenus'],
                'linkOptions' => ['data-method' => 'post']];
            }
            
            
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
                'encodeLabels' => false
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; Tartine-toi <?= date('Y') ?></p>
        <p class="pull-right"><a href="http://www.tartine.tanguy-falconnet.com/backend.php"><?= Yii::t('frontend', 'Admin') ?></a></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
