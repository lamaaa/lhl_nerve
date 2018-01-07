<?php

use yii\db\Migration;

/**
 * Handles the creation of table `warning_config_id_warning_type_id`.
 */
class m180106_123826_create_warning_config_id_warning_type_id_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('warning_config_id_warning_type_id', [
            'id' => $this->primaryKey(),
            'warning_config_id' => $this->integer(11)->notNull()->defaultValue(0)->comment('预警配置ID'),
            'warning_type_id' => $this->integer(11)->notNull()->defaultValue(0)->comment('预警方式ID'),
            'status' => $this->smallInteger(6)->notNull()->defaultValue(1)->comment('有效性 0无效 1有效'),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('warning_config_id_warning_type_id');
    }
}
