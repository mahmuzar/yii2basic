<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notification_templates".
 *
 * @property int $id
 * @property string $event
 * @property string $template
 */
class NotificationTemplates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_templates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event', 'template'], 'required'],
            [['template'], 'string'],
            [['event'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event' => 'Event',
            'template' => 'Template',
        ];
    }
}
