<?php

use yii\db\Migration;

/**
 * Handles the creation of table `warning_record_id_user_id`.
 */
class m180106_114841_create_warning_config_id_user_id_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('warning_config_id_user_id', [
            'id' => $this->primaryKey(),
            'warning_config_id' => $this->integer(11)->notNull()->defaultValue(0),
            'user_id' => $this->integer(11)->notNull()->defaultValue(0)->comment('用户ID'),
            'status' => $this->smallInteger(6)->notNull()->defaultValue(1)->comment('有效性 0无效 1有效'),
            'created_at' => $this->dateTime()->notNull()->defaultValue('1000-01-01 00:00:00')->comment('创建时间'),
            'updated_at' => $this->dateTime()->notNull()->defaultValue('1000-01-01 00:00:00')->comment('最近一次修改时间'),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('warning_config_id_user_id');
    }
}
