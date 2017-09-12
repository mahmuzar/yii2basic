<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\NewsActiveRecord;

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
class AddNewsForm extends Model {

    public $title;
    public $content;

    /**
     * @var UploadedFile
     */
    public $logo;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['content'], 'string'],
            [['content'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'required'],
            [['logo'], 'file',],
            ['logo', 'validateLogo']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Title',
            'content' => 'Content',
            'logo' => 'Logo',
        ];
    }

    public function save() {
        $news = new NewsActiveRecord();
        $news->user_id = Yii::$app->user->getId();
        $news->title = $this->title;
        $news->content = $this->content;
        $news->logo = $this->logo;
        $news->loadDefaultValues();
        return $news->save();
    }
    public function update(){
        $news = new NewsActiveRecord();
        $news->user_id = $this->user_id;
        $news->title = $this->title;
        $news->content = $this->content;
        $news->logo = $this->logo;
        return $news->update();
    }
    public function validateLogo($attribute, $params) {
        if (!$this->hasErrors()) {

            if ($this->logo instanceof \yii\web\UploadedFile) {
                $this->logo->saveAs(\Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $this->logo->baseName . '.' . $this->logo->extension);
                $this->logo = $this->logo->baseName . '.' . $this->logo->extension;
                return;
            }
            $this->addError($attribute, 'ожидается тип файла \yii\web\UploadedFile ');
        }
    }

}
