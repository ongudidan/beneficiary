<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%export_files}}`.
 */
class m241110_130234_create_export_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%export_files}}', [
            'id' => $this->primaryKey(),
            'activity_id' => $this->integer()->notNull(),
            'file_path' => $this->string(255)->null(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'status' => "ENUM('pending', 'completed', 'failed') NOT NULL DEFAULT 'pending'",
        ]);

        // Add index for `activity_id` if needed, or add a foreign key to another table if required
        // $this->createIndex('idx-export_files-activity_id', '{{%export_files}}', 'activity_id');
        // Example foreign key, adjust according to your actual table name
        // $this->addForeignKey('fk-export_files-activity_id', '{{%export_files}}', 'activity_id', '{{%activity}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Uncomment if you have foreign keys or indexes
        // $this->dropForeignKey('fk-export_files-activity_id', '{{%export_files}}');
        // $this->dropIndex('idx-export_files-activity_id', '{{%export_files}}');

        $this->dropTable('{{%export_files}}');
    }
}
