<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use Yii;
use yii\base\Component;
use yii\helpers\Url;

class TemplateEngine extends Component {

    public $template;

    public function init() {
        parent::init();
    }

    public function engine($model, $template = null) {

       

        ob_start(function($buffer) use ($model) {

            $patterns = array();

            $patterns[0] = '/({|%7B)new_title(%7D|})/';
            $patterns[1] = '/({|%7B)link(%7D|})/';
            $patterns[2] = '/({|%7B)new_description(%7D|})/';

            $replacements = array();

            $replacements[2] = $model['title'];
            $replacements[1] = Url::to(['/news/view', 'id' => $model['id']]);

            $replacements[0] = empty($model['content']) ? ('') : ($model['content']);

            return preg_replace($patterns, $replacements, $buffer);
        }, PHP_OUTPUT_HANDLER_CLEANABLE | PHP_OUTPUT_HANDLER_REMOVABLE | PHP_OUTPUT_HANDLER_FLUSHABLE);
        echo $this->template;


        
        $data = ob_get_contents();
        ob_clean();
        return $data;
    }

}
