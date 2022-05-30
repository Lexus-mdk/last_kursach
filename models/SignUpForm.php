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
            [['username', 'fio', 'email', 'password', 'password_repeat'], 'string', 'max' => 255, 'min' => 6, 'tooShort'=>'Поле должно быть заполнено минимум 6 символами'],
            ['username', 'match', 'pattern'=>'/^[A-z0-9\-]*$/u', 'message'=>'Могут быть использованы символы латиницы, цифры и знак "-"'],
            ['email', 'match', 'pattern'=>'/^[a-z0-9\-\._@]*$/u', 'message'=>'Могут быть использованы символы латиницы, цифры и знаки "-", "_" и "."'],
            ['password', 'match', 'pattern'=>'/^[^\s]*$/u', 'message'=>'Пароль не должен содержать пробелы'],
            ['email', 'unique', 'targetClass' => User::class,  'message' => 'Эта почта уже занята'],
            ['username', 'unique', 'targetClass' => User::class,  'message' => 'Это имя уже занято'],
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
