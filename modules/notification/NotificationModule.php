<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\notification;

use yii\base\Module;
use app\modules\notification\models\Notifications;
use yii\base\Event;
use app\modules\notification\observer\MailObserver;
use app\modules\notification\observer\NotificationObserver;
use \SplSubject;
use \SplObserver;

class NotificationModule extends Module implements SplSubject {

    const EVENT_NEW_USER = 'newUser';
    const EVENT_PASSWORD_UPDATE = 'passwordUpdate';
    const EVENT_NEW_NEWS = 'newNews';
    const EVENT_PASSWORD_CONFIRM = 'passwordConfirm';

    /**
     *
     * @var app\modules\notification\models\Notifications
     */
    public $notification;
    public $event;
    public $storage;

    /**
     *
     * @var app\modules\notification\models\NotificationModule
     */
    private static $instance;

    public function init() {
        parent::init();
        $this->on(self::EVENT_NEW_NEWS, [$this, 'handle']);
        $this->on(self::EVENT_NEW_USER, [$this, 'handle']);
        $this->on(self::EVENT_PASSWORD_UPDATE, [$this, 'handle']);

        $this->notification = new Notifications();
        // ...  other initialization code ...
    }

    static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new self('notification');
        }
        self::$instance->storage = new \SplObjectStorage();
        return self::$instance;
    }

    public function handle(Event $event) {
        $this->event = $event;
        new MailObserver($this);
        new NotificationObserver($this);
        $this->notify();
    }

    public function attach(SplObserver $observer) {
        $this->storage->attach($observer);
    }

    public function detach(SplObserver $observer) {
        $this->storage->detach($observer);
    }

    public function notify() {
        foreach ($this->storage as $obj) {
            $obj->update($this);
        }
    }

}
