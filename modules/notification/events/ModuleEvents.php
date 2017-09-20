<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\notification\events;

use yii\base\Event;

abstract class ModuleEvents extends Event {

    public $changedAttributes = [];
    

    public function __construct($config = array()) {
        parent::__construct($config);
    }

    public function getAttribute($id) {
        return $this->changedAttributes[$id];
    }

}
