<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sb_id_and_notif_type_id`.
 */
class m170915_133152_create_sbr_id_and_notif_opt_id_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('sbr_id_and_notif_opt_id', [
            'id' => $this->primaryKey(),
            'subscriber_id' => $this->integer()->notNull(),
            'notification_option_id' => $this->integer()->notNull()
        ]);
        $this->addForeignKey(
            'fk-sbr_id_and_notif_opt_id-subscriber_id',
            'sbr_id_and_notif_opt_id',
            'subscriber_id',
            'subscribers',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-sbr_id_and_notif_opt_id-notification_option_id',
            'sbr_id_and_notif_opt_id',
            'notification_option_id',
            'notification_options',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            'idx-sbr_id_and_notif_opt_id-notification_option_id',
            'sbr_id_and_notif_opt_id',
            'subscriber_id'
        );
        $this->createIndex(
            'idx-sbr_id_and_notif_opt_id-subscriber_id',
            'sbr_id_and_notif_opt_id',
            'notification_option_id'
        );
        $this->insert('sbr_id_and_notif_opt_id', array(
            'subscriber_id' => 1,
            'notification_option_id' => 1,
            
        ));
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('sbr_id_and_notif_opt_id');
    }

}
