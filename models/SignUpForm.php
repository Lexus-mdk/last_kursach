<?php
namespace app\models;

use Yii;
use yii\base\Model;


class SignUpForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $fio;
    public $password_repeat;

    public function rules()
    {
        return [
            [['username', 'fio', 'email', 'password','password_repeat'], 'required'],
            [['username', 'fio', 'email', 'password', 'password_repeat'], 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class,  'message' => 'Эта почта уже занята'],
            ['email', 'trim'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>'Пароли должны совпадать']
        ];
    }

    public function attributeLabels() {
        return [
            'username' => 'Логин',
            'fio' => 'ФИО',
            'email' => 'Почта',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль'
        ];
    }


}
