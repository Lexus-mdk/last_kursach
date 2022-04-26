<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Profile extends Model
{

    public function getUsername()
    {
        return Yii::$app->user->username;
    }
    public function getEmail()
    {
        return Yii::$app->user->email;
    }
    public function getOrders()
    {
        $orders = new Order();
        $result = $orders->getUserOrders();
        if(!empty($result))
        {
            $html = '';
            foreach($result as $key=>$value)
            {
                $html .= '<a href="orderinfo?id='. $value['order_id'] .'">Номер заказа - '. $value['order_id'];
                $html .= ', Количество товаров - ' . $value['products_count'];
                $html .= ', Стоимость - ' . $value['cost'];
                $html .= ' руб, Статус - ' . $value['status'];
                $html .= ', Дата создания заказа - ' . $value['date'];
                $html .= '</a><br>';
            }
            return $html;
        }
        else
        {
            return 'заказов нет';
        }

        
    }
}


