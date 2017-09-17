<?php

use yii\db\Migration;

/**
 * Handles the creation of table `notification_options`.
 */
class m170915_132838_create_notification_options_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('notification_options', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
        $this->insert('notification_options', array(
            'name' => 'mail',
        ));
        $this->insert('notification_options', array(
            'name' => 'interface',
        ));
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('notification_options');
    }

}
