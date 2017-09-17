<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\db\ActiveRecord;
use app\models\NotificationOptions;

class Test extends ActiveRecord {

    public function rules() {
        return [
            [['id'], NotificationOptions::className()],
            [['name']], NotificationOptions::className()
        ];
    }

}
