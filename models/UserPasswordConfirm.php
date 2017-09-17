<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_password_confirm".
 *
 * @property int $id
 * @property int $user_id
 * @property string $password
 * @property string $token
 * @property int $confirmed
 * @property int $not_valid
 * @property string $date
 */
class UserPasswordConfirm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_password_confirm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'password', 'token'], 'required'],
            [['user_id', 'confirmed', 'not_valid'], 'integer'],
            [['date'], 'safe'],
            [['password', 'token'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'password' => 'Password',
            'token' => 'Token',
            'confirmed' => 'Confirmed',
            'not_valid' => 'Not Valid',
            'date' => 'Date',
        ];
    }
}
