<?php

use yii\db\Migration;

/**
 * Handles the creation of table `subscribers`.
 */
class m170915_132747_create_subscribers_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('subscribers', [
            'id' => $this->primaryKey(),
            'user_id'=> $this->integer()->notNull()->unique(),
        ]);
        $this->addForeignKey(
            'fk-subscribers-user_id',
            'subscribers',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            'idx-subscribers-user_id',
            'subscribers',
            'user_id'
        );
         $this->insert('subscribers', array(
            'user_id' => 1,
            
        ));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('subscribers');
    }
}
