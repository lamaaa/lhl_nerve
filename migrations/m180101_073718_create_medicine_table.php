<?php

use yii\db\Migration;

/**
 * Handles the creation of table `medicine_record`.
 */
class m180101_073718_create_medicine_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('medicine', [
            'id' => $this->primaryKey(),
            'type' => $this->smallInteger(6)->notNull()->defaultValue(1)->comment("记录类型 1为入库 2为出库"),
            'medicine_name' => $this->string()->notNull()->defaultValue("")->comment("药品名称"),
            'quantity' => $this->integer()->notNull()->defaultValue(0)->comment("入库或者出库数量"),
            'validity' => $this->dateTime()->notNull()->defaultValue("1000-01-01 00:00:00")->comment("过期时间"),
            'serial_number' => $this->string()->notNull()->defaultValue("")->comment("药品批号"),
            'status' => $this->smallInteger(6)->notNull()->defaultValue(1)->comment("有效性 0无效 1有效"),
            'manufacturer' => $this->string()->notNull()->defaultValue("")->comment("出产商"),
            'purchase_price' => $this->integer()->notNull()->defaultValue(0)->comment("药品单价"),
            'origin' => $this->string()->notNull()->defaultValue("")->comment("产地"),
            'created_at' => $this->dateTime()->notNull()->defaultValue("1000-01-01 00:00:00")->comment("创建时间"),
            'updated_at' => $this->dateTime()->notNull()->defaultValue("1000-01-01 00:00:00")->comment("最近一次修改时间"),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('medicine');
    }
}
