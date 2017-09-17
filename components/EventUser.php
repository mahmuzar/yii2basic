<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use yii\base\Event;

class EventUser extends Event {

    const EVENT_NEW_USER = 'new-user';

    public $id;
    public $username;
    public $password;
    public $email;
    public $date_registration;
    public $date_of_last_authorization;
    public $role;
    public $alertOption = [];

    public function __construct($config = array()) {
        parent::__construct($config);
        
        //swith(){
    }

}
