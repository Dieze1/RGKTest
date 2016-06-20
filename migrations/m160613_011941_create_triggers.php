<?php

use yii\db\Migration;

/**
 * Handles the creation for table `triggers`.
 */
class m160613_011941_create_triggers extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('triggers', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique(),
            'model' => $this->string(50)->notNull(),
            'eventCode' => $this->string(50),
            'from' => $this->integer(),
            'to'=> $this->string(10)->notNull(),
            'title' => $this->string(50),
            'type' => $this->string(50),
            'body' => $this->text(),
        ]);
        $this->addForeignKey('FK_triggers_1', 'triggers', 'from', 'user', 'id');
        $this->createIndex('IX_triggers_1', 'triggers', ['eventCode', 'model']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('IX_triggers_1', 'triggers');
        $this->dropForeignKey('FK_triggers_1', 'triggers');
        $this->dropTable('triggers');
    }
}
