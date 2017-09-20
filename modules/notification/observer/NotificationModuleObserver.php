<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\notification\observer;

use app\modules\notification\NotificationModule;
use \SplObserver;
use \SplSubject;

abstract class NotificationModuleObserver implements SplObserver {

    private $NM;

    function __construct(NotificationModule $module) {
        $this->NM = $module;
        $module->attach($this);
    }

    function update(SplSubject $subject) {
        if ($subject === $this->NM) {
            $this->doUpdate($subject);
        }
    }

    abstract function doUpdate(NotificationModule $module);
}
