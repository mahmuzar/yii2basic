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
 * @property int $status
 * @property string $date_registration
 * @property string $date_of_last_authorization
 * @property int $role
 */
class UserUpdateForm extends \app\models\UsersActiveRecord
{
    public $username;
    public $password;
    public $email;
    public $role;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username',  'email'], 'required'],
            [['username', 'password', 'email'], 'string', 'max' => 255],
            [['role'], 'integer']
        ];
    }
    

   
    
}
