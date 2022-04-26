<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class SignUpForm extends Model
{
    public $username;
    public $email;
    public $password;



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'email', 'password'], 'required'],
            ['email', 'unique', 'targetClass' => User::class,  'message' => 'Эта почта уже занята'],
            ['email', 'trim']
        ];
    }

    public function attributeLabels() {
        return [
            'username' => 'Логин',
            'email' => 'Почта',
            'password' => 'Пароль',
        ];
    }


}
