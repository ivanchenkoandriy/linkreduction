<?php

use yii\db\Migration;

/**
 * Class m211119_071448_add_links_table
 */
class m211119_071448_add_links_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%links}}', [
            'id' => $this->primaryKey()->unsigned(),
            'usage_limit' => $this->integer()->unsigned()->notNull(),
            'reverse_counter' => $this->integer()->unsigned()->notNull(),
            'timeout' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'short' => "VARCHAR(8) BINARY NOT NULL",
            'link' => $this->string(2048)->notNull(),
        ]);

        $this->createIndex('links_usage_limit_idx', '{{%links}}', 'usage_limit');
        $this->createIndex('links_reverse_counter_idx', '{{%links}}', 'reverse_counter');
        $this->createIndex('links_timeout_idx', '{{%links}}', 'timeout');
        $this->createIndex('links_created_at_idx', '{{%links}}', 'created_at');
        $this->createIndex('links_short_idx', '{{%links}}', 'short', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('links_usage_limit_idx', '{{%links}}');
        $this->dropIndex('links_reverse_counter_idx', '{{%links}}');
        $this->dropIndex('links_timeout_idx', '{{%links}}');
        $this->dropIndex('links_created_at_idx', '{{%links}}');
        $this->dropIndex('links_short_idx', '{{%links}}');

        $this->dropTable('{{%links}}');
    }
}
