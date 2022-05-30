<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $order_id
 * @property string $product_name
 * @property int $cost
 * @property int $user_id
 * @property string $status
 * @property int $date
 */
class Order extends \yii\db\ActiveRecord
{
    

    public static function tableName()
    {
        return 'order';
    }

    
    public function rules()
    {
        return [
            [['products_count', 'cost', 'user_id', 'status', 'date'], 'required'],
            [['products_count', 'user_id'], 'integer'],
            [[ 'status'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']]
        ];
    }

    
    public function attributeLabels()
    {
        return [
            'order_id' => 'Номер заказа',
            'products_count' => 'Количество товаров',
            'cost' => 'Стоимость',
            'user_id' => 'Идентификатор пользователя',
            'status' => 'Статус',
            'date' => 'Дата создания',
            'fio' => 'ФИО'
        ];
    }

    public function createOrder($cost)
    {
        $session = Yii::$app->session;
        if(count($session['basket'])<2)
        {
            return false;
        }
        $this->cost = $cost;
        $this->products_count = count($session['basket']) - 1;
        $this->status = "Ожидание принятия заказа";
        $this->date = date('Y-m-d H:i:s');
        $this->user_id = Yii::$app->user->identity->id;
        $this->fio = Yii::$app->user->identity->fio;
        if($this->save())
        {
            try{
                foreach($session->get('basket') as $key=>$value)
                {
                    if($key!=0)
                    {
                        $prods = new OrderProducts();
                        $prods->createOrderProducts($value, $this->order_id);
                    }
                }
                $basket = new Basket;
                $basket->unsetBasket();
            } catch(yii\base\Exception $e){
                echo $e->getMessage();
            }
        }else{
            return false;
        }

        return true;
    }


    public function getUserOrders()
    {
        $user_id = Yii::$app->user->id;
        return static::findAll(['user_id'=>$user_id]);
    }


    public function getOrderProducts()
    {
        return $this->hasMany(OrderProducts::class, ['order_id' => 'order_id']);
    }

    
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
