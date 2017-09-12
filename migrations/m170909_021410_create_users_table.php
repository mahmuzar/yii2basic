<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m170909_021410_create_users_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->unique()->notNull(),
            'password' => $this->string()->notNull(),
            'email'=>$this->string()->unique()->notNull(),
            'date_registration' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            'date_of_last_authorization' => $this->timestamp()->notNull(),
            'role' => $this->integer()->defaultValue(10)->notNull(),
            
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('users');
    }

}
