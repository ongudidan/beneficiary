<?php

use app\components\IdGenerator;
use app\models\User;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\db\Migration;
use Faker\Factory as Faker;


/**
 * Class m241029_124959_seed_coordinator_table
 */
class m241029_124959_seed_coordinator_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        ini_set('memory_limit', '5120M'); // Adjust this limit based on your system

        // Load the spreadsheet file
        $spreadsheet = IOFactory::load('ALL BENEFICIARIES - APRIL -24.xlsx');
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        // Create an array to keep track of already inserted coordinators
        $insertedCoordinators = [];

        // Iterate through the rows and insert coordinators
        foreach ($data as $index => $row) {
            // Skip rows before row 5 (index 4)
            if ($index < 1) {
                continue;
            }

            $coordinator = strtoupper($row[14] ?? 'Undefined ');

            // Check if the coordinator has already been inserted
            if (!in_array($coordinator, $insertedCoordinators)) {
                $id = IdGenerator::generateUniqueId();

                $faker = Faker::create();

                // Generate unique values for additional fields
                $nationalId = uniqid('NID-', true);
                // $email = strtolower(str_replace(' ', '.', $coordinator)) . '@example.com';
                $email = $faker->unique()->safeEmail; // Generate unique email using Faker

                $phoneNo = '+254' . rand(700000000, 799999999); // Random phone number
                $createdAt = time();
                $updatedAt = time();
                $createdBy = User::find()->where(['username' => 'admin'])->one()->id;
                $updatedBy = $createdBy;
                $password = 'password';


                $this->insert('{{%user}}', [
                    'id' => $id,
                    'username' => $nationalId,
                    'email' => $email,
                    'status' => 10,
                    'auth_key' => Yii::$app->security->generateRandomString(), // Random auth key
                    'password_hash' => Yii::$app->security->generatePasswordHash($password), // Hashed 'admin'
                    'status' => 10, // Default status for active user
                    'created_at' => $createdAt, // Set created_at to current time
                    'updated_at' => $updatedAt, // Set updated_at to current time
                ]);

                // Insert into coordinator table if it's not a duplicate
                $this->insert('{{%coordinator}}', [
                    'id' => $id,
                    'name' => $coordinator,
                    'user_id' => $id,
                    'national_id' => $nationalId,
                    'email' => $email,
                    'phone_no' => $phoneNo,
                    'status' => 10,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                    'created_by' => $createdBy,
                    'updated_by' => $updatedBy,
                ]);

                // Add the coordinator to the array to track it
                $insertedCoordinators[] = $coordinator;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Logic to revert coordinator changes if needed
        return false;
    }
}
