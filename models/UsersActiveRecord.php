<?php

namespace app\models;

use Yii;
use app\components\EventUserConfirm;
use app\modules\notification\NotificationModule;

/**
 * This is the model class for table "Users".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $date_registration
 * @property string $date_of_last_authorization
 * @property int $role
 */
class UsersActiveRecord extends \yii\db\ActiveRecord {

    public function __construct($config = array()) {
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'Users';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['username', 'password', 'email', 'role'], 'required'],
            [['date_registration', 'date_of_last_authorization'], 'safe'],
            [['role'], 'integer'],
            [['username', 'password', 'email'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'date_registration' => 'Date Registration',
            'date_of_last_authorization' => 'Date Of Last Authorization',
            'role' => 'Role',
        ];
    }

    public function beforeSave($insert) {
        Yii::$app->params['oldPassword'] = $this->password;
        $this->on(self::EVENT_BEFORE_INSERT, function() {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        });
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        $this->on(self::EVENT_AFTER_INSERT, function() {
            $attributes = $this->getAttributes();
            $obj = new UserPasswordConfirm();
            $obj->user_id = $this->id;
            $obj->password = $this->password;
            $obj->token = bin2hex(openssl_random_pseudo_bytes(32));
            $obj->save();
            $attributes['token'] = '';
            $attributes['token'] = $obj->token;
            $attributes['password'] = Yii::$app->params['oldPassword'];
            NotificationModule::getInstance()->trigger(
                    NotificationModule::EVENT_NEW_USER, new \app\modules\notification\events\users\NewUserEvent([
                'changedAttributes' => $attributes,
                    ])
            );
        });

        parent::afterSave($insert, $changedAttributes);
    }

    public function passwordUpdate() {
        $this->status = 0;
        Yii::$app->params['oldPassword'] = $this->password;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $attributes = $this->getAttributes();
        $obj = new UserPasswordConfirm();
        $obj->user_id = $this->id;
        $obj->password = $this->password;
        $obj->token = bin2hex(openssl_random_pseudo_bytes(32));
        $obj->save();
        $attributes['token'] = '';
        $attributes['token'] = $obj->token;
        $attributes['password'] = Yii::$app->params['oldPassword'];
        NotificationModule::getInstance()->trigger(
                NotificationModule::EVENT_PASSWORD_UPDATE, new \app\modules\notification\events\users\UserPasswordUpdateEvent([
            'changedAttributes' => $attributes,
                ])
        );
    }

}
