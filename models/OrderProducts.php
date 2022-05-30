<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_products".
 *
 * @property int $order_id
 * @property string $product_name
 * @property string $length
 * @property int $patchcord
 * @property int $cost
 *
 * @property Order $order
 */
class OrderProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'product_name', 'price', 'length', 'patchcord', 'cost'], 'required'],
            [['order_id', 'patchcord'], 'integer'],
            [['price', 'cost'], 'number'],
            [['product_name', 'length'], 'string', 'max' => 255],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'order_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id'=>'Идентификатор товара',
            'order_id' => 'Идентификатор продукта',
            'product_name' => 'Наименование',
            'price' => 'Стоимость за см',
            'length' => 'Длина в см',
            'patchcord' => 'Коннектеры',
            'cost' => 'Стоимость продукта',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['order_id' => 'order_id']);
    }

    public function createOrderProducts($product, $order_id)
    {
        
        $this->order_id = $order_id;
        $this->product_name = $product['type'];
        $this->price = $product['price'];
        $this->patchcord = $product['patchcord'];
        $this->cost = $product['cost'];
        $this->length = $product['length'];
        return $this->save();
        
    }
}
