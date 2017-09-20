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
            'event' => $this->string()->notNull(),
            'event_id' => $this->integer()->notNull(),
            'status' => $this->boolean()->defaultValue(1),
            'date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('notifications');
    }

}
