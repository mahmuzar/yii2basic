<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sbr_id_and_notif_opt_id".
 *
 * @property int $id
 * @property int $subscriber_id
 * @property int $notification_option_id
 */
class SbrIdAndNotifOptId extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sbr_id_and_notif_opt_id';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subscriber_id', 'notification_option_id'], 'required'],
            [['subscriber_id', 'notification_option_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subscriber_id' => 'Subscriber ID',
            'notification_option_id' => 'Notification Option ID',
        ];
    }
}
