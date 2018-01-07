<?php

use yii\db\Migration;

/**
 * Handles the creation of table `warning_type`.
 */
class m180106_114808_create_warning_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('warning_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->defaultValue('')->comment('预警方式'),
            'description' => $this->string()->notNull()->defaultValue('')->comment('预警描述'),
            'status' => $this->smallInteger(6)->notNull()->defaultValue(1)->comment('有效性 0无效 1无有效'),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        Yii::$app->db->createCommand()->insert('warning_type', [
            'name' => 'email',
            'description' => '邮件'
        ])->execute();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('warning_type');
    }
}
