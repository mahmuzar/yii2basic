<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `news`.
 */
class m170909_015655_create_news_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'user_id'=> $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'status' => $this->integer()->defaultValue(1),
            'date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            'logo' => $this->string()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('news');
    }

}
