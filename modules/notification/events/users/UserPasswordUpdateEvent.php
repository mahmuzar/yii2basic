<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\notification\events\users;

use app\modules\notification\events\ModuleEvents;

class UserPasswordUpdateEvent extends ModuleEvents {

    const EVENT_PASSWORD_UPDATE = 'passwordUpdate';

}
