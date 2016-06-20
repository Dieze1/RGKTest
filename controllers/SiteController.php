<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\Signup;
use app\models\Login;
class SiteController extends Controller
{
    /**Рендерит главную страницу
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**разлогинивает и редиректит на страницу авторизации
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        if(!Yii::$app->user->isGuest)
        {
            Yii::$app->user->logout();
            return $this->redirect(['login']);
        }
        return $this->redirect(['login']);
    }

    /**
     * проводит на форму регистрации и регистрирует нового пользователя
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {
        $model = new Signup();
        if(isset($_POST['Signup']))
        {
            $model->attributes = Yii::$app->request->post('Signup');
            if($model->validate() && $model->signup())
            {
                return $this->redirect(['index']);
            }
        }
        return $this->render('signup',['model'=>$model]);
    }
    
    /**
     * Проверяет существует ли пользователь, вносит пользователя в систему(в сессию)
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if(!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        $login_model = new Login();
        if( Yii::$app->request->post('Login'))
        {
            $login_model->attributes = Yii::$app->request->post('Login');
            if($login_model->validate())
            {
                Yii::$app->user->login($login_model->getUser());
                return $this->goHome();
            }
        }
        return $this->render('login',['login_model'=>$login_model]);
    }
}