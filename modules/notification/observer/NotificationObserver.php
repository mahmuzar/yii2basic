<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\notification\observer;

use app\modules\notification\observer\NotificationModuleObserver;
use app\modules\notification\NotificationModule;

class NotificationObserver extends NotificationModuleObserver {

    public function doUpdate(\app\modules\notification\NotificationModule $module) {
        switch ($module->event->name) {
            case NotificationModule::EVENT_NEW_NEWS:
                //var_dump($module);
                $module->notification->event = $module->event->name;
                $module->notification->event_id = $module->event->getAttribute('id');
                $module->notification->title = $module->event->getAttribute('title');
                $module->notification->save();
                break;
        }
    }
    

}
