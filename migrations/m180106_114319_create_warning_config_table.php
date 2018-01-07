<?php

use yii\db\Migration;

/**
 * Handles the creation of table `warning_record`.
 */
class m180106_114319_create_warning_config_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('warning_config', [
            'id' => $this->primaryKey(),
            'medicine_id' => $this->integer(11)->notNull()->defaultValue(0)->comment('药品ID'),
            'quantity' => $this->integer(11)->notNull()->defaultValue(0)->comment('预警数量'),
            'created_at' => $this->dateTime()->notNull()->defaultValue('1000-01-01 00:00:00')->comment('创建时间'),
            'updated_at' => $this->dateTime()->notNull()->defaultValue('1001-01-01 00:00:00')->comment('最近一次修改时间'),
            'status' => $this->smallInteger(6)->notNull()->defaultValue(1)->comment('有效性 0无效 1有效')
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('warning_config');
    }
}
