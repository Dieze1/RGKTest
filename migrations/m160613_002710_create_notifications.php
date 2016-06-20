<?php

use yii\db\Migration;

/**
 * Handles the creation for table `notifications`.
 */
class m160613_002710_create_notifications extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('notifications', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50),
            'date' => $this->date(),
            'body' => $this->text(),
            'from' => $this->integer(),
            'to' => $this->integer(),
            'trigger_id' => $this->integer(),
            'dismissed' => $this->boolean()->notNull()->defaultValue(0)
        ]);
        $this->addForeignKey('FK_notifications_1', 'notifications', 'from', 'user', 'id');
        $this->addForeignKey('FK_notifications_2', 'notifications', 'to', 'user', 'id');
        $this->createIndex('IX_notifications_1', 'notifications', ['id', 'title', 'date', 'from']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('IX_notifications_1', 'notifications');
        $this->dropForeignKey('FK_notifications_1', 'notifications');
        $this->dropForeignKey('FK_notifications_2', 'notifications');
        $this->dropTable('notifications');

    }
}
