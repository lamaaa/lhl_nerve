<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m171224_034117_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->defaultValue("")->comment("用户名"),
            'auth_key' => $this->string(32)->notNull()->defaultValue("")->comment("授权key"),
            'password_hash' => $this->string()->notNull()->defaultValue("")->comment(""),
            'email' => $this->string()->notNull()->defaultValue("")->comment(""),
            'password_reset_token' => $this->string()->notNull()->defaultValue("")->comment(""),
            'created_at' => $this->dateTime()->notNull()->defaultValue("1001-01-01 00:00:00")->comment("创建时间"),
            'updated_at' => $this->dateTime()->notNull()->defaultValue("1001-01-01 00:00:00")->comment("最近一次修改时间"),
        ], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
        $this->createIndex('idx_user_username', 'user', 'username', true);
        $this->createIndex('idx_user_email', 'user', 'email', true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
