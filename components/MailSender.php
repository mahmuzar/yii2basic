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
class MailSender extends Component implements Sender {

    const EVENT_MAIL_SEND = 'messageSend';
    const EVENT_NEW_USER = 'new_user';

    public function send($data=null) {
        $body = "Пользователь {$data->sender->username} только что авторизовался";
        
        Yii::$app->mailer->compose()
                ->setFrom('from@domain.com')
                ->setTo('mahmuzar@yandex.ru')
                ->setSubject('Тест')
                ->setTextBody($body)
                ->send();
        
    }
    public function newUser(){
        
    }

}
