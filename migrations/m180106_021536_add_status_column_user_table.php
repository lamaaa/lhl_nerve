<?php

use yii\db\Migration;

/**
 * Class m180106_021536_add_status_column_user_table
 */
class m180106_021536_add_status_column_user_table extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('user', 'status', $this->smallInteger(6)->notNull()->defaultValue(1)->comment('有效性 0无效 1有效'));
    }

    public function down()
    {
        $this->dropColumn('user', 'status');
    }
}
