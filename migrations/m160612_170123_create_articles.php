<?php

use yii\db\Migration;

/**
 * Handles the creation for table `articles`.
 */
class m160612_170123_create_articles extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('articles', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull()->unique(),
            'author' => $this->integer(),
            'shorttext' => $this->string(255),
            'text' => $this->text()
        ]);
        $this->addForeignKey('FK_articles_1', 'articles', 'author', 'user', 'id');
        $this->createIndex('IX_articles_1', 'articles', ['id', 'title', 'author']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('IX_articles_1', 'articles');
        $this->dropForeignKey('FK_articles_1', 'articles');
        $this->dropTable('articles');
        
    }
}
