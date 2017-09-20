<?php

use yii\db\Migration;

/**
 * Handles the creation of table `notif_id_and_sbr_id`.
 */
class m170917_124939_create_notif_id_and_sbr_id_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('notif_id_and_sbr_id', [
            'id' => $this->primaryKey(),
            'subscriber_id' => $this->integer()->notNull(),
            'notification_id' => $this->integer()->notNull()
        ]);
        
        $this->addForeignKey(
            'fk-notif_id_and_sbr_id-notification_id',
            'notif_id_and_sbr_id',
            'notification_id',
            'notifications',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            'idx-notif_id_and_sbr_id-subscriber_id',
            'notif_id_and_sbr_id',
            'subscriber_id'
        );
        $this->createIndex(
            'idx-notif_id_and_sbr_id-notification_id',
            'notif_id_and_sbr_id',
            'notification_id'
        );
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('notif_id_and_sbr_id');
    }

}
