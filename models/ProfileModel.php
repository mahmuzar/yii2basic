<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\NotificationOptions;
use app\models\SbrIdAndNotifOptId;
use app\models\Subscribers;

class ProfileModel extends Model {

    /**
     *
     * @var array варианты доступные для оповещений
     */
    public $notificationOptions;

    /**
     *
     * @var array измененные данные из $notificationOptions после отправки формы
     */
    public $newNotificationOptions = [];

    public function rules() {
        return [
            [['newNotificationOptions'], 'validatorNewNotificationOptions']
        ];
    }

    public function init() {
        $sql = '
            SELECT
  `notification_options`.`id`,
  `notification_options`.`name`,
  (
  SELECT
    `notification_options`.`id`
  FROM
    `notification_options`
  WHERE
    `sbr_id_and_notif_opt_id`.`notification_option_id` = `notification_options`.`id` AND `sbr_id_and_notif_opt_id`.`subscriber_id` =(
    SELECT
      `subscribers`.`id`
    FROM
      `subscribers`
    WHERE
      `subscribers`.`user_id` = :user_id
  )
) AS `status`
FROM
  `notification_options`
LEFT JOIN
  `sbr_id_and_notif_opt_id`
ON
  `sbr_id_and_notif_opt_id`.`notification_option_id` = `notification_options`.`id` AND `sbr_id_and_notif_opt_id`.`subscriber_id` =(
  SELECT
    `subscribers`.`id`
  FROM
    `subscribers`
  WHERE
    `subscribers`.`user_id` = :user_id
)';
        $ar = new \yii\db\ActiveRecord();
        $this->notificationOptions = $ar->findBySql(
                        $sql, [':user_id' => Yii::$app->user->identity->id]
                )->asArray()->all();
        parent::init();
    }

    public function validatorNewNotificationOptions() {
        $subscriber = Subscribers::findOne(['user_id' => Yii::$app->user->identity->id]);
        $obj = new SbrIdAndNotifOptId();
        $result = $obj->findAll(['subscriber_id' => $subscriber['id']]);

        foreach ($this->notificationOptions as $key => $val) {
            foreach ($result as $obj) {
                if ($obj->notification_option_id == $val['id'] && empty($this->newNotificationOptions[$val['id']]) && !is_null($val['status'])) {
                    $obj->delete();
                }
            }
            if (!empty($this->newNotificationOptions[$val['id']]) && is_null($val['status'])) {
                $newObj = new SbrIdAndNotifOptId();
                $newObj->notification_option_id = $val['id'];
                $newObj->subscriber_id = $subscriber['id'];
                $newObj->save();
            }
        }
    }

}
