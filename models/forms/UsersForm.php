<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property int $role
 */
class UsersForm extends Model{

    public $username;
    public $password;
    public $email;
    public $role;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['username', 'password', 'email'], 'required'],
            [['role'], 'integer'],
            [['username', 'password', 'email'], 'string', 'max' => 255],
        ];
    }

}
