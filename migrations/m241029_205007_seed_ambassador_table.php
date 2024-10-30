<?php

use app\components\IdGenerator;
use app\models\User;
use app\modules\dashboard\models\FieldOfficer;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\db\Migration;
use Faker\Factory as Faker;


/**
 * Class m241029_205007_seed_ambassador_table
 */
class m241029_205007_seed_ambassador_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // ini_set('memory_limit', '5120M'); // Adjust this limit based on your system

        // // Load the spreadsheet file
        // $spreadsheet = IOFactory::load('ALL BENEFICIARIES - APRIL -24.xlsx');
        // $sheet = $spreadsheet->getActiveSheet();
        // $data = $sheet->toArray();

        // // Create a Faker instance
        // $faker = Faker::create();

        // // Create an array to keep track of already inserted fieldOfficers and sublocations
        // $insertedAmbassadors = [];

        // // Second pass to insert fieldOfficers
        // foreach ($data as $index => $row) {
        //     if ($index < 4) {
        //         continue;
        //     }

        //     $fieldOfficer = $row[13] ?? 'Undefined ';
        //     $ambassador = $row[12] ?? 'Undefined ';

        //     $FieldOfficerId = FieldOfficer::findOne(['name' => $fieldOfficer])->id;

        //     // Check if the fieldOfficer has already been inserted
        //     if (!in_array($fieldOfficer, $insertedAmbassadors)) {

        //         // Generate unique values for additional fields
        //         $id = IdGenerator::generateUniqueId();
        //         $nationalId = uniqid('NID-', true);
        //         $email = $faker->unique()->safeEmail; // Generate unique email using Faker
        //         $phoneNo = '+254' . rand(700000000, 799999999); // Random phone number
        //         $createdAt = time();
        //         $updatedAt = time();
        //         $createdBy = User::find()->where(['username' => 'admin'])->one()->id;
        //         $updatedBy = $createdBy;

        //         $this->insert('{{%user}}', [
        //             'id' => $id,
        //             'username' => $nationalId,
        //             'email' => $email,
        //             'auth_key' => Yii::$app->security->generateRandomString(),
        //             'password_hash' => Yii::$app->security->generatePasswordHash($nationalId),
        //             'status' => 10,
        //             'created_at' => $createdAt,
        //             'updated_at' => $updatedAt,
        //         ]);

        //         // Insert into ambassador table if it's not a duplicate
        //         $this->insert('{{%ambassador}}', [
        //             'id' => $id,
        //             'name' => $ambassador,
        //             'user_id' => $id,
        //             'field_officer_id' => $FieldOfficerId,
        //             'national_id' => $nationalId,
        //             'email' => $email,
        //             'phone_no' => $phoneNo,
        //             'status' => 10,
        //             'created_at' => $createdAt,
        //             'updated_at' => $updatedAt,
        //             'created_by' => $createdBy,
        //             'updated_by' => $updatedBy,
        //         ]);

        //         // Track the ambassador
        //         $insertedAmbassadors[] = $ambassador;
        //     }
        // }
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Logic to revert ambassador changes if needed
        return false;
    }
}
