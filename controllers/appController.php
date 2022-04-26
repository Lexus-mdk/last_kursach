<?php

namespace app\controllers;

use Yii;

class appController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if(!parent::beforeAction($action)){
            return false;
        }

        $session = Yii::$app->session;

        if (!$session->isActive){
            $session->open();
        }

        return true;
    }

}
