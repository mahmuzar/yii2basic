<?php

use yii\db\Migration;

/**
 * Handles the creation of table `notification_templates`.
 */
class m170920_230918_create_notification_templates_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('notification_templates', [
            'id' => $this->primaryKey(),
            'event' => $this->string()->notNull()->unique(),
            'template' => $this->text()->notNull()
        ]);
        
        $this->createIndex(
            'idx-notification_templates-event',
            'notification_templates',
            'event'
        );
        $this->insert('notification_templates', array(
            'event' => 'newNews',
            'template' => "Добавлена новая новость: 
<a href='{new_link}'>{new_title}</a> <br> {new_description}",
            
        ));
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('notification_templates');
    }

}
