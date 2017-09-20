<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notif_id_and_sbr_id".
 *
 * @property int $id
 * @property int $subscriber_id
 * @property int $notification_id
 */
class NotifIdAndSbrId extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notif_id_and_sbr_id';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subscriber_id', 'notification_id'], 'required'],
            [['subscriber_id', 'notification_id'], 'integer'],
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
            'notification_id' => 'Notification ID',
        ];
    }
}
