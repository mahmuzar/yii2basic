<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\notification\observer;

use Yii;
use yii\base\Event;
use app\modules\notification\observer\NotificationModuleObserver;
use app\modules\notification\NotificationModule;

class MailObserver extends NotificationModuleObserver {

    public $subject = '';
    public $template = '';
    public $to = [];
    public $from = ['admin@mail.ru'];
    public $notifications;

    public function init() {
        $notif = new \app\modules\notification\models\Notifications();
        $this->to = array_column($notif->getAllMailRecipients(), 'email');
    }

    public function send(Event $event) {

        $result = Yii::$app->mailer->compose($this->template, ['event' => $event])
                ->setFrom($this->from)
                ->setTo($this->to)
                ->setSubject($this->subject)
                ->send();
        if ($result) {
            
        }
        //var_dump($result);
    }

    public function doUpdate(\app\modules\notification\NotificationModule $module) {
        // var_dump($module->event);
        switch ($module->event->name) {
            case NotificationModule::EVENT_NEW_NEWS:
                $this->init();
                //var_dump('d');
                $this->template = 'new_news';
                $this->subject = 'Добавлена новая новость';
                break;
            case NotificationModule::EVENT_NEW_USER:
                //var_dump($module->event->getAttribute('email'));
                $this->to = $module->event->getAttribute('email');
                //var_dump($this->to);
                $this->template = 'new_user';
                $this->subject = 'Новый пользователь в системе';
                break;
            case NotificationModule::EVENT_PASSWORD_UPDATE:
                //var_dump($module);
                $this->template = 'update_password';
                $this->subject = 'Обновление пароля';
                $this->to = $module->event->getAttribute('email');

                break;
            case NotificationModule::EVENT_PASSWORD_CONFIRM:
                var_dump($module);
                $this->template = 'password_confirm';
                $this->subject = 'Подтверждение паролья';
                $this->to = $module->event->getAttribute('email');

                break;
        }

        $this->send($module->event);
    }

}
