<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use app\components\Sender;
use yii\base\Component;
use Yii;
use yii\base\Event;

class MailSender extends Component {

    const EVENT_NEW_USER = 'afterInsert';

    public $subject = '';
    public $template = '';

    public function send(Event $event) {
        
        Yii::$app->mailer->compose($this->template, ['event' => $event])
                ->setFrom('from@domain.com')
                ->setTo('mahmuzar@yandex.ru')
                ->setSubject($this->subject)
                ->send();
    }

    public function run(Event $event) {
        switch ($event->name) {
            case self::EVENT_NEW_USER:
                $this->subject = 'Данные для авторизации на';
                $this->template = $event->data['notify']['view'];
                $this->send($event);

                break;
            default :
        }
    }

}
