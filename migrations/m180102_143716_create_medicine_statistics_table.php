<?php

use yii\db\Migration;

/**
 * Handles the creation of table `medicine_statistics`.
 */
class m180102_143716_create_medicine_statistics_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('medicine_statistics', [
            'id' => $this->primaryKey(),
            'medicine_id' => $this->integer(11)->notNull()->defaultValue(0)->comment("药品ID"),
            'type' => $this->smallInteger(6)->notNull()->defaultValue(1)->comment("统计类型 1为入库 2为出库"),
            'user_id' => $this->integer(11)->notNull()->defaultValue(0)->comment("操作用户ID"),
            'quantity' => $this->integer(11)->notNull()->defaultValue(0)->comment("操作数量"),
            'created_at' => $this->dateTime()->notNull()->defaultValue("1000-01-01 00:00:00")->comment("创建时间"),
            'updated_at' => $this->dateTime()->notNull()->defaultValue("1000-01-01 00:00:00")->comment("最近一次修改时间"),
            'status' => $this->smallInteger(6)->notNull()->defaultValue(1)->comment("有效性 0为无效 1为有效"),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->createIndex('medicine_id', 'medicine_statistics', 'medicine_id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('medicine_statistics');
    }
}
