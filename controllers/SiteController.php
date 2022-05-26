<?php

namespace app\controllers;

use app\models\CalculatorForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignUpForm;
use app\models\User;
use app\models\Profile;
use app\models\Order;
use app\models\Basket;
use app\models\OrderInfo;
use app\models\OrderProducts;

class SiteController extends appController
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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
        $model = new CalculatorForm();
        if(\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())){
            $model->justCalculate();
            if($model->button==='calculate')
            {
                return $model->getHTML();
            }
            elseif($model->button==='tobasket' && !Yii::$app->user->isGuest)
            {
                $basket = new Basket();
                $basket->addToBasket($model);
                return '<h2>Товар добавлен в корзину!</h2>';
            }else
            {
                return '<h2>Чтобы добавить товар в корзину, нужно авторизироваться на сайте</h2>';
            }
        }
        if(\Yii::$app->request->post()){
            return $this->goHome();
        }
        return $this->render('index',
        ['model'=>$model]
        );
    }


    public function actionUpdatebasket()
    {
        if(\Yii::$app->request->isAjax)
        {
            $basket = new Basket();

            $cost = $basket->updateBasket(\Yii::$app->request->post('id'), \Yii::$app->request->post('length'));
            
            return json_encode([
                1=>$cost, 
                2=>$basket->allCost()
            ]);
            
        }
    }


    public function actionOrderinfo()
    {

        if(\Yii::$app->request->isAjax)
        {
            $obj = OrderProducts::findOne(['order_id'=>\Yii::$app->request->get('id'), 'product_id'=>\Yii::$app->request->get('product_id')]);
            $product_cost = $obj->cost;
            $obj->delete();
            $order_object = Order::findOne(['order_id'=>\Yii::$app->request->get('id'), 'user_id'=>Yii::$app->user->identity->id]);
            if (!empty($order_object))
            {

                $order_object->products_count = count($order_object->orderProducts);
                $order_object->cost -= $product_cost;
                
                if($order_object->save())
                {
                    $model = new OrderInfo($order_object);
                    return $model->getOrderProducts();
                }

            }
        }
        $order = new Order();
        $order_object = $order::findOne(['order_id'=>\Yii::$app->request->get('id'), 'user_id'=>Yii::$app->user->identity->id]);
        
        if(!empty($order_object))
        {
            $model = new OrderInfo($order_object);
            return $this->render('orderinfo',
            ['model'=>$model]
            );
        }   
        
        return $this->goHome();
    }


    public function actionOrder()
    {
        if (Yii::$app->user->isGuest) 
        {
            return $this->goHome();
        }

        $order = new Order();
        if(\Yii::$app->request->isAjax)
        {
            return $order->createOrder(\Yii::$app->request->post('cost'));
        }
    }


    public function actionBasket()
    {
        if (Yii::$app->user->isGuest) 
        {
            return $this->goHome();
        }

        $basket = new Basket();
        // $basket->unsetBasket();
        // die;
        if(\Yii::$app->request->isAjax && $basket->load(\Yii::$app->request->post()))
        {
            $basket->delElement();
            return json_encode([
                1=>$basket->renderBasket(),
                2=>$basket->allCost()
            
            ]);
        }

        return $this->render('basket', [
            'model' => $basket,
        ]);

    }

    public function actionProfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Profile();
        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }


    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignUpForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $user = new User();
            $user->username = $model->username;
            $user->email = $model->email;
            $user->fio = $model->fio;
            $user->password = \Yii::$app->security->generatePasswordHash($model->password);
            if($user->save()){
                if (Yii::$app->user->login($user, 3600*24*30)) {
                    if (Yii::$app->user->identity->role == 'admin') {
                        return $this->redirect(['admin/index']);
                    }
                    return $this->goBack();
                }
            }
        }

        $model->password = '';
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
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
    public function actionAbout()
    {
        return $this->render('about');
    }
}
