<?php

namespace app\models;

use Yii;
use app\components\MailSender;
/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $status
 * @property string $date
 * @property string $logo
 */
class NewsActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['user_id'],'integer'],
            [['status'], 'integer'],
            [['date'], 'safe'],
            [['title', 'logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'status' => 'Status',
            'date' => 'Date',
            'logo' => 'Logo',
        ];
    }
    
    public function afterSave($insert, $changedAttributes) {
        
         $this->on(self::EVENT_AFTER_INSERT, [new MailSender(), 'run'], [
            'notify' => [
                'view' => 'new_news',
                'class' => MailSender::className(),
            ]
        ]);
        parent::afterSave($insert, $changedAttributes);
    }
}
