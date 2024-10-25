<?php

use app\components\IdGenerator;
use yii\db\Migration;

/**
 * Class m241024_054719_seed_user_table
 */
class m241024_054719_seed_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $timestamp = time(); // Current timestamp

        // Insert admin user with default values, including email, created_at, and updated_at
        $this->insert('{{%user}}', [
            'id' => IdGenerator::generateUniqueId(), // Assuming you have a UUID generator
            'username' => 'admin',
            'email' => 'admin@gmail.com', // Admin email
            'auth_key' => Yii::$app->security->generateRandomString(), // Random auth key
            'password_hash' => Yii::$app->security->generatePasswordHash('admin'), // Hashed 'admin'
            'status' => 10, // Default status for active user
            'created_at' => $timestamp, // Set created_at to current time
            'updated_at' => $timestamp, // Set updated_at to current time
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Delete the seeded user
        $this->delete('{{%user}}', ['username' => 'admin']);
    }
}
