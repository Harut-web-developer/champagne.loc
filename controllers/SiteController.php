<?php

namespace app\controllers;

use app\models\Notifications;
use app\models\Users;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        Yii::$app->language = 'hy';
    }
    public function beforeAction($action)
    {
        $session = Yii::$app->session;
        if ($action->id !== 'login' && !(isset($session['user_id']) && $session['logged'])) {
            return $this->redirect(['site/login']);
        } else if($action->id == 'login' && !(isset($session['user_id']) && $session['logged'])){
            return $this->actionLogin();
        } else if($action->id == 'login') {
            return $this->redirect('/dashboard');
        }
//        else if ($action->id === 'forgot-password'){
//            return  $this->redirect('site/forgot-password');
//        }
        return parent::beforeAction($action);
    }


//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::class,
//                'only' => ['logout'],
//                'rules' => [
//                    [
//                        'actions' => ['logout'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::class,
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
//        ];
//    }

    /**
     * {@inheritdoc}
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');
    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $session = Yii::$app->session;
        $this->layout = 'loginLayout';
//        $sub_page = [];
        if ($this->request->isPost) {
            $username = Yii::$app->request->post('username');
            $password = Yii::$app->request->post('password');
            $remember = Yii::$app->request->post('remember');
            $identity = Users::findOne(['username' => $username]);
            if ($identity && $identity->password === $password && $identity->username === $username) {
                if (isset($remember)){
                    $session->set('remember',true);
                    setcookie('username',$username, time()+60 * 60 * 24 * 30, '/');
                    setcookie('password',$password, time()+60 * 60 * 24 * 30, '/');
                }
                date_default_timezone_set('Asia/Yerevan');
                $identity->updated_at = date('Y-m-d H:i:s');
                $identity->save(false);
                $session->set('name',$identity->name);
                $session->set('username',$identity->username);
                $session->set('user_id',$identity->id);
                $session->set('role_id', $identity->role_id);
                $session->set('logged',true);
                return $this->redirect('/dashboard');
            } else {
                return $this->redirect('');
            }
        }
        else{
            return $this->render('login', [
//                'model' => $model,
            ]);
        }
//        return $this->render('login',[
//            'sub_page' => $sub_page
//        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        session_destroy();
        $this->redirect('/site/login');
    }

    public function actionForgotPassword(){
        $this->layout = 'forgotLayout';

        return $this->render('forgot');
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionGetNotifications()
    {
        $session = Yii::$app->session;
        $notifications_today = 0;
        $notifications_all = 0;
        $notification_badge_admin = null;
        $notification_badge_storekeeper = null;
        if ($session['role_id'] == '1') {
            $notifications_today = Notifications::find()
                ->select(['title', 'message', 'datetime'])
                ->andWhere(['>=', 'datetime', date('Y-m-d')])
                ->andWhere(['or', ['sort_' => 'orderscreate'], ['sort_' => 'ordersupdate'], ['sort_' => 'ordersdelivered'], ['sort_' => 'documentscreate'], ['sort_' => 'exitdocument'], ['sort_' => 'changeorderscount'], ['sort_' => 'refusalreturn']])
                ->orderBy(['datetime' => SORT_DESC])
                ->asArray()
                ->all();
            $notifications_all = Notifications::find()
                ->select(['title', 'message', 'datetime'])
                ->Where(['or', ['sort_' => 'orderscreate'], ['sort_' => 'ordersupdate'], ['sort_' => 'ordersdelivered'], ['sort_' => 'documentscreate'], ['sort_' => 'exitdocument'], ['sort_' => 'changeorderscount'], ['sort_' => 'refusalreturn']])
                ->orderBy(['datetime' => SORT_DESC])
                ->asArray()
                ->all();
            $notification_badge_admin = Notifications::find()
                ->Where(['or', ['sort_' => 'orderscreate'], ['sort_' => 'ordersupdate'], ['sort_' => 'ordersdelivered'], ['sort_' => 'documentscreate'], ['sort_' => 'exitdocument'], ['sort_' => 'changeorderscount'], ['sort_' => 'refusalreturn']])
                ->andWhere(['NOT LIKE', 'watched', ',' . $session['role_id'] . ','])
                ->count();
        }
        if ($session['role_id'] == '4') {
            $notifications_today = Notifications::find()
                ->select(['title', 'message', 'datetime'])
                ->andWhere(['>=', 'datetime', date('Y-m-d')])
                ->andWhere(['or', ['sort_' => 'orderscreate'], ['sort_' => 'ordersdelivered'], ['sort_' => 'changeorderscount']])
                ->orderBy(['datetime' => SORT_DESC])
                ->asArray()
                ->all();
            $notifications_all = Notifications::find()
                ->select(['title', 'message', 'datetime'])
                ->andWhere(['or', ['sort_' => 'orderscreate'], ['sort_' => 'ordersdelivered'], ['sort_' => 'changeorderscount']])
                ->orderBy(['datetime' => SORT_DESC])
                ->asArray()
                ->all();
            $notification_badge_storekeeper = Notifications::find()
                ->Where(['or', ['sort_' => 'orderscreate'], ['sort_' => 'ordersdelivered'], ['sort_' => 'changeorderscount']])
                ->andWhere(['NOT LIKE', 'watched', ',' . $session['role_id'] . ','])
                ->count();
        }
        return json_encode([
            'notifications_today' => $notifications_today,
            'notifications_all' => $notifications_all,
            'notification_badge_storekeeper' => $notification_badge_storekeeper,
            'notification_badge_admin' => $notification_badge_admin,
            ]);
    }

    public function actionCheckNotifications()
    {
        $session = Yii::$app->session;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $users_premissions = [];
        if ($session['role_id'] == '1') {
            $users_premissions = ['orderscreate','ordersupdate','ordersdelivered','exitdocument','documentscreate','changeorderscount','refusalreturn'];
        }
        if ($session['role_id'] == '4') {
            $users_premissions = ['orderscreate','ordersdelivered','changeorderscount'];
        }
        $notification = Notifications::find()
            ->andWhere(['>=', 'datetime', date('Y-m-d')])
            ->andWhere(['status' => '1'])
            ->andWhere(['role_id' => '2'])
            ->andWhere([
                'or',
                ['watched' => ','],
                ['NOT LIKE', 'watched', ',' . $session['role_id'] . ',']
            ])
            ->all();

        $not_count = count($notification);

        for ($i = 0; $i < $not_count; $i++){
            if (in_array($notification[$i]['sort_'], $users_premissions)) {
                $notification = $notification[$i];
                break;
            }elseif ($i == $not_count-1){
                $notification = null;
            }
        }
        if ($session['role_id'] == '1' || $session['role_id'] == '4') {
            if (!empty($notification)){
                if (!is_null($notification)){
                    if (($notification->watched != ',') && ($notification->sort_ == 'orderscreate' || $notification->sort_ == 'changeorderscount' || $notification->sort_ == 'ordersdelivered')) {
                        $watched_array = explode(',', $notification->watched);
                        if (in_array('1', $watched_array) && in_array('4', $watched_array)) {
                            $notification->status = 0;
                            $notification->save();
                            return [
                                'success' => false,
                            ];
                        } elseif (!in_array($session['role_id'], $watched_array)) {
                            $watched_value = $notification->watched . $session['role_id'] . ',';
                            $notification->watched = $watched_value;
                            $notification->save();
                            return [
                                'success' => true,
                                'notifications' => $notification,
                            ];
                        }
                    }elseif(($notification->watched == ',') && ($notification->sort_ == 'orderscreate' || $notification->sort_ == 'changeorderscount' || $notification->sort_ == 'ordersdelivered')){
                        $watched_value = $notification->watched . $session['role_id'] . ',';
                        $notification->watched = $watched_value;
                        $notification->save();
                        return [
                            'success' => true,
                            'notifications' => $notification,
                        ];
                    }
                }
            }
        }

        if ($session['role_id'] == '1') {
            if (!empty($notification)){
                if (!is_null($notification)){
                    if (($notification->watched != ',') && ($notification->sort_ == 'ordersupdate' || $notification->sort_ == 'documentscreate')) {
                        $watched_array = explode(',', $notification->watched);
                        if (in_array('1', $watched_array)) {
                            $notification->status = 0;
                            $notification->save();
                            return [
                                'success' => false
                            ];
                        } elseif (!in_array($session['role_id'], $watched_array)) {
                            $watched_value = $notification->watched . $session['role_id'] . ',';
                            $notification->watched = $watched_value;
                            $notification->save();
                            return [
                                'success' => true,
                                'notifications' => $notification,
                            ];
                        }
                    }elseif(($notification->watched == ',') && ($notification->sort_ == 'ordersupdate' || $notification->sort_ == 'documentscreate')){
                        $watched_value = $notification->watched . $session['role_id'] . ',';
                        $notification->watched = $watched_value;
                        $notification->save();
                        return [
                            'success' => true,
                            'notifications' => $notification,
                        ];
                    }
                }
            }
        }
        $notification_doc = Notifications::find()
            ->andWhere(['>=', 'datetime', date('Y-m-d')])
            ->andWhere(['status' => '1'])
            ->andWhere(['role_id' => '4'])
            ->andWhere([
                'or',
                ['watched' => ','],
                ['NOT LIKE', 'watched', ',' . $session['role_id'] . ',']
            ])
            ->all();

        $not_count = count($notification_doc);

        for ($i = 0; $i < $not_count; $i++){
            if (in_array($notification_doc[$i]['sort_'], $users_premissions)) {
                $notification_doc = $notification_doc[$i];
                break;
            }elseif ($i == $not_count-1){
                $notification_doc = null;
            }
        }

        if ($session['role_id'] == '1') {
            if (!empty($notification_doc)){
                if (!is_null($notification_doc)){
                    if (($notification_doc->watched != ',') && ($notification_doc->sort_ == 'exitdocument' || $notification_doc->sort_ == 'refusalreturn')) {
                        $watched_array = explode(',', $notification_doc->watched);
                        if (in_array('1', $watched_array)) {
                            $notification_doc->status = 0;
                            $notification_doc->save();
                            return [
                                'success' => false
                            ];
                        } elseif (!in_array($session['role_id'], $watched_array)) {
                            $watched_value = $notification_doc->watched . $session['role_id'] . ',';
                            $notification_doc->watched = $watched_value;
                            $notification_doc->save();
                            return [
                                'success' => true,
                                'notifications' => $notification_doc,
                            ];
                        }
                    }elseif(($notification_doc->watched == ',') && ($notification_doc->sort_ == 'exitdocument' || $notification_doc->sort_ == 'refusalreturn')){
                        $watched_value = $notification_doc->watched . $session['role_id'] . ',';
                        $notification_doc->watched = $watched_value;
                        $notification_doc->save();
                        return [
                            'success' => true,
                            'notifications' => $notification_doc,
                        ];
                    }
                }

            }
        }
        return [
            'success' => false,
        ];
    }

}
