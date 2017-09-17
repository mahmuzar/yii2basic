<?php

namespace app\models;

use Yii;
use app\components\Handler;
use app\components\MailSender;
use app\components\EventUser;
use app\models\UserPasswordConfirm;

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
        //сохраним пароль для передачи по почте
        Yii::$app->params['oldPassword'] = $this->password;
        //по событию захешируем пароль.
        $this->on(self::EVENT_BEFORE_INSERT, function() {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        });

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        $obj = new UserPasswordConfirm();
        $obj->user_id = $this->id;
        $obj->password = $this->password;
        $obj->token = bin2hex(openssl_random_pseudo_bytes(32));
        $this->on(self::EVENT_AFTER_INSERT, [$obj, 'save']);

        $this->on(self::EVENT_AFTER_INSERT, [new MailSender(), 'run'], [
            'token' => $obj->token,
            'old_password' => Yii::$app->params['oldPassword'],
            'notify' => [
                'veiw' => 'newuser',
                'class' => MailSender::className(),
            ]
        ]);
        parent::afterSave($insert, $changedAttributes);
    }

}
