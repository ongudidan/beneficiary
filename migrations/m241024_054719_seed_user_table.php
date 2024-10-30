<?php

use app\components\AuthItemChildGenerator;
use app\components\AuthItemGenerator;
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

        // // Generate auth items if they don't exist
        // $authItemGenerator = new AuthItemGenerator();
        // $authItemGenerator->generateAuthItems();

        // // Generate auth item children
        // $authItemChildGenerator = new AuthItemChildGenerator();
        // $authItemChildGenerator->generateAuthItemChildren();

        // Insert admin user
        $this->insert('{{%user}}', [
            'id' => IdGenerator::generateUniqueId(),
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
            'status' => 10,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        // Insert officer user
        $this->insert('{{%user}}', [
            'id' => IdGenerator::generateUniqueId(),
            'username' => 'officer',
            'email' => 'officer@gmail.com',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('officer'),
            'status' => 10,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        // Insert ambassador user
        $this->insert('{{%user}}', [
            'id' => IdGenerator::generateUniqueId(),
            'username' => 'ambassador',
            'email' => 'ambassador@gmail.com',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('ambassador'),
            'status' => 10,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        // Insert coordinator user
        $this->insert('{{%user}}', [
            'id' => IdGenerator::generateUniqueId(),
            'username' => 'coordinator',
            'email' => 'coordinator@gmail.com',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('coordinator'),
            'status' => 10,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
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
