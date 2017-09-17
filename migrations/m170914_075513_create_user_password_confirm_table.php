<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_password_confirm`.
 */
class m170914_075513_create_user_password_confirm_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('user_password_confirm', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'password' => $this->string()->notNull(),
            'token'=>$this->string()->notNull(),
            'confirmed' => $this->integer()->defaultValue(0),
            'not_valid' => $this->integer()->defaultValue(0),
            'date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('user_password_confirm');
    }

}
