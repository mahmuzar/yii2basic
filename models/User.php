<?php

namespace app\models;

class User extends \yii\base\Object implements \yii\web\IdentityInterface {

    public $id;
    public $username;
    public $password;
    public $status;
    public $authKey;
    public $accessToken;
    public $email;
    public $date_registration;
    public $date_of_last_authorization;
    public $role;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        $result = UsersActiveRecord::findOne($id);
        if (!empty($result)) {
            return new static($result->getAttributes());
        }
        return null;
    }
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        $user = UsersActiveRecord::findOne([
            'username'=>$username,
            'status'=>1
        ]);
        var_dump($user);
        if (!is_null($user)) {
            return new static($user->getAttributes(['id', 'username', 'password']));
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
       return  password_verify($password, $this->password);
        
    }

}
