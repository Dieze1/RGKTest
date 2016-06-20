<?php
use yii\db\Migration;
class m160612_045541_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'email'=>$this->string(100)->notNull(),
            'password'=>$this->string(255),
            'role' => $this->smallInteger(1)
        ]);
        $this->createIndex('IX_user_1', 'user', ['id', 'name']);
    }
    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('IX_user_1', 'user');
        $this->dropTable('user');
    }
}