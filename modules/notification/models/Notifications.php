<?php

namespace app\modules\notification\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notifications".
 *
 * @property int $id
 * @property int $event
 * @property int $event_id
 * @property int $status
 */
class Notifications extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'notifications';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['event', 'event_id'], 'required'],
            [['event_id', 'status'], 'integer'],
            [['event'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'event' => 'Event',
            'event_id' => 'Event ID',
            'status' => 'Status',
        ];
    }

    /**
     * 
     * 
     * @return array emails
     */
    public function getAllMailRecipients() {
        $sql = "
            SELECT
              `users`.`email`
            FROM
              `users`
            WHERE
              `users`.`id` IN(
              SELECT
                `subscribers`.`id`
              FROM
                `subscribers`,
                `sbr_id_and_notif_opt_id`
              WHERE
                `subscribers`.`id` = `sbr_id_and_notif_opt_id`.`subscriber_id` AND `sbr_id_and_notif_opt_id`.`notification_option_id` =(
                SELECT
                  `notification_options`.`id`
                FROM
                  `notification_options`
                WHERE
                  `notification_options`.`name` = 'mail'
              )
            )";
        $ar = new ActiveRecord();
        return $ar->findBySql($sql)->asArray()->all();
    }

    public function notViewedNotifications() {
        $sql = "
            SELECT
              *
            FROM
              `notifications`
            JOIN
              (
              SELECT
                `sbr_id_and_notif_opt_id`.`subscriber_id`
              FROM
                `sbr_id_and_notif_opt_id`
              WHERE
                `sbr_id_and_notif_opt_id`.`subscriber_id` =(
                SELECT
                  `subscribers`.`id`
                FROM
                  `subscribers`
                WHERE
                  `subscribers`.`user_id` = :user_id
              ) AND `sbr_id_and_notif_opt_id`.`notification_option_id` =(
              SELECT
                `notification_options`.`id`
              FROM
                `notification_options`
              WHERE
                `notification_options`.`name` = 'interface'
            )
            ) AS `t1`
            WHERE NOT EXISTS
              (
              SELECT
                *
              FROM
                `notif_id_and_sbr_id`
              WHERE
                `notif_id_and_sbr_id`.`notification_id` = `notifications`.`id` AND
                `notif_id_and_sbr_id`.`subscriber_id` = `t1`.`subscriber_id`
            );";
        return self::findBySql($sql, [':user_id' => Yii::$app->user->identity->id])->asArray()->all();
    }

    function getSubscriberId($userId, $notificationOptionName) {
        $sql = "
            SELECT
              `sbr_id_and_notif_opt_id`.`subscriber_id`
            FROM
              `sbr_id_and_notif_opt_id`
            WHERE
              `sbr_id_and_notif_opt_id`.`subscriber_id` =(
              SELECT
                `subscribers`.`id`
              FROM
                `subscribers`
              WHERE
                `subscribers`.`user_id` = :user_id
            ) AND `sbr_id_and_notif_opt_id`.`notification_option_id` =(
            SELECT
              `notification_options`.`id`
            FROM
              `notification_options`
            WHERE
              `notification_options`.`name` = :notification_option_name
          )
          )";
        return self::findBySql($sql, [':user_id' => $userId, ':notification_option_name' => $notificationOptionName])->asArray()->one();
    }

}
