<?php

use yii\db\Migration;

/**
 * Handles the creation of table `medicine`.
 */
class m171224_132239_create_medicine_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('medicine', [
            'id' => $this->primaryKey(),
            'manufacturer' => $this->string()->notNull()->defaultValue("")->comment("出品单位"),
            'purchase_price' => $this->integer()->notNull()->defaultValue(0)->comment("进价"),
            'inventory_quantity' => $this->integer()->notNull()->defaultValue(0)->comment("库存量"),
            'total_amount' => $this->integer()->notNull()->defaultValue(0)->comment("总金额"),
            'serial_number' => $this->string()->notNull()->defaultValue("")->comment("产品批号"),
            'origin' => $this->string()->notNull()->defaultValue("")->comment("产地"),
            'validity' => $this->integer()->notNull()->defaultValue(0)->comment("有效期"),
            'deposited_at' => $this->dateTime()->notNull()->defaultValue("1001-01-01 00:00:00")->comment("入库时间"),
            'took_out_at' => $this->dateTime()->notNull()->defaultValue("1001-01-01 00:00:00")->comment("出库时间"),
            'created_at' => $this->dateTime()->notNull()->defaultValue("1001-01-01 00:00:00")->comment("创建时间"),
            'updated_at' => $this->dateTime()->notNull()->defaultValue("1001-01-01 00:00:00")->comment("最近一次修改时间"),
            'status' => $this->smallInteger(6)->notNull()->defaultValue(1)->comment("0无效 1有效")
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('medicine');
    }
}
