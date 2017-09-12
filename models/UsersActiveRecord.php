<?php

namespace app\models;

use Yii;
use app\components\Handler;
use app\components\MailSender;
use app\components\EventUser;

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

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        //$event = new EventUser();
        $this->on(self::EVENT_AFTER_INSERT, [new Handler(), 'handler']);
    }

}
