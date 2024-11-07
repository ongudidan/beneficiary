<?php

use app\components\IdGenerator;
use app\models\User;
use app\modules\dashboard\models\Coordinator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\db\Migration;
use Faker\Factory as Faker;


/**
 * Class m241029_131758_seed_officer_table
 */
class m241029_131758_seed_officer_table extends Migration
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

        // Create an array to keep track of already inserted fieldOfficers and sublocations
        $insertedOfficers = [];

        // Second pass to insert fieldOfficers
        foreach ($data as $index => $row) {
            if ($index < 4) {
                continue;
            }

            $fieldOfficer = strtoupper($row[13] ?? 'Undefined ');
            $coordinator = strtoupper($row[14] ?? 'Undefined ');


            $CoordinatorId = Coordinator::findOne(['name' => $coordinator])->id;


            // Check if the fieldOfficer has already been inserted
            if (!in_array($fieldOfficer, $insertedOfficers)) {

                // Generate unique values for additional fields
                $id = IdGenerator::generateUniqueId();

                $faker = Faker::create();

                $nationalId = uniqid('NID-', true);
                // $email = strtolower(str_replace(' ', '.', $fieldOfficer)) . '@gmail.com';
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

                // Insert into fieldOfficer table if it's not a duplicate
                $this->insert('{{%field_officer}}', [
                    'id' => $id,
                    'name' => $fieldOfficer,
                    'user_id' => $id,
                    'coordinator_id' => $CoordinatorId,
                    'national_id' => $nationalId,
                    'email' => $email,
                    'phone_no' => $phoneNo,
                    'status' => 10,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                    'created_by' => $createdBy,
                    'updated_by' => $updatedBy,
                ]);
                // Track the fieldOfficer
                $insertedOfficers[] = $fieldOfficer;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Logic to revert fieldOfficer changes if needed
        return false;
    }
}
