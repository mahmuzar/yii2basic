<?php

use yii\db\Migration;

/**
 * Handles the creation of table `notifications`.
 */
class m170915_133114_create_notifications_table extends Migration {

    /**
     * 
     * @inheritdoc
     */
    public function up() {
        $this->createTable('notifications', [
            'id' => $this->primaryKey(),
            'event' => $this->integer()->notNull(),
            'event_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('notifications');
    }

}
