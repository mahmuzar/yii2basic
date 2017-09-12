<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\forms;

use yii\base\Model;
use app\models\UsersActiveRecord;

class RegistrationForm extends Model {

    public $username;
    public $password;
    public $email;

    public function rules() {
        return [
            // username and password are both required
            [['username', 'password', 'email'], 'required'],
            ['email', 'email'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['username', 'validateUsername'],
        ];
    }

    /**
     * Демонстрация возможности yii. Я бы на самом деле не ограничивал 
     * пользователя в выборе логина или пароля
     * @param type $attribute
     * @param type $params
     */
    public function validateUsername($attribute, $params) {
        if (is_numeric($this->username)) {
            $this->addError($attribute, 'Логин не может состоять только из цифр');
        }
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {

        if (is_numeric($this->password)) {
            $this->addError($attribute, 'Слишком простой пароль');
        }
    }

    

}
