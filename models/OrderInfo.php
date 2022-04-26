<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\bootstrap4\Html;


class OrderInfo extends Model
{
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function getOrderProducts()
    {
        $html = '<p class="h1">Заказ '. $this->order->order_id .'';
        if ($this->order->status == 'Ожидание принятия заказа')
        {
            $html .= Html::a('Удалить заказ', 
            ['/admin/delete', 
            'order_id' => $this->order->order_id], 
            ['class' => 'btn btn-primary']); 
        }
        $html .= '</p>';
        foreach($this->order->orderProducts as $key=>$value)
        {
            $html .= 'Тип кабеля - ' . $value['product_name'];
            $html .= ', Цена за см - ' . $value['price'];
            $html .= ' руб, Длина - ' . $value['length'];
            $html .= ' см, С коннекторами - ';
            $html .= $value['patchcord'] == 1 ? 'Да, ' : 'Нет, ';;
            $html .= 'Стоимость - ' . $value['cost'];
            $html .= ' руб</a>';
            if (count($this->order->orderProducts)>1 && $this->order->status == 'Ожидание принятия заказа')
            {
                $html .= Html::submitButton('Удалить', [
                    'class' => 'btn btn-primary', 
                    'id'=>'calculate', 
                    'name'=>$value['product_id'],
                    'form'=>'product-form',
                    'onclick' => 'handleSubmitButton(this, "#button-name")'
                    ]
                );
            }
            $html .= '<br>';
        }
        return $html;
    }
}