<?php

use app\components\IdGenerator;
use app\models\User;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\db\Migration;

/**
 * Class m241024_055916_seed_beneficiary_table
 */
class m241024_055916_seed_beneficiary_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        ini_set('memory_limit', '512M'); // Adjust this limit based on your system

        // Load the spreadsheet file
        $spreadsheet = IOFactory::load('ALL BENEFICIARIES - APRIL -24.xlsx');
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        // Create an array to keep track of already inserted sublocations
        $insertedSubLocations = [];
        $insertedVillages = [];


        // Iterate through the rows and insert them into the beneficiary table
        foreach ($data as $index => $row) {
            // Skip rows before row 5 (index 4)
            if ($index < 4) {
                continue;
            }

            $id = IdGenerator::generateUniqueId();

            $created_by = User::find()->where(['username' => 'admin'])->one()->id;
            $updated_by = User::find()->where(['username' => 'admin'])->one()->id;

            // Set beneficiary values
            $name = $row[1] ?? 'Undefined ';
            $nationalId = $row[2] ?? 'Undefined ';
            $contact = $row[3] ?? 'Undefined ';
            $subLocation = $row[4] ?? 'Undefined ';
            $village = $row[5] ?? 'Undefined ';
            $stoveNo = $row[6] ?? 'Undefined ';

            $issueDate = null;
            if (isset($row[7]) && $row[7] !== 'Undefined') {
                $dateTime = DateTime::createFromFormat('d/m/Y', $row[7]);
                if ($dateTime) {
                    $issueDate = $dateTime->getTimestamp();
                }
            }

            $lat = $row[8] ?? 'Undefined ';
            $long = $row[9] ?? 'Undefined ';
            $ambassador = $row[12] ?? 'Undefined ';
            $fieldOfficer = $row[13] ?? 'Undefined ';
            $coordinator = $row[14] ?? 'Undefined ';


            // Insert the beneficiary into the beneficiary table
            $this->insert('{{%beneficiary}}', [
                'id' => $id,
                'name' => $name,
                'national_id' => $nationalId,
                'contact' => $contact,
                'sub_location' => $subLocation,
                'village' => $village,
                'stove_no' => $stoveNo,
                'issue_date' => $issueDate,
                'lat' => $lat,
                'long' => $long,
                'created_at' => time(),
                'updated_at' => time(),
                'created_by' => $created_by,
                'updated_by' => $updated_by,
            ]);

            // Check if the sublocation has already been inserted
            if (!in_array($subLocation, $insertedSubLocations)) {
                // Insert into sub_location table if it's not a duplicate
                $this->insert('{{%sub_location}}', [
                    'id' => IdGenerator::generateUniqueId(),
                    'name' => $subLocation,
                ]);
                // Add the sublocation to the array to track it
                $insertedSubLocations[] = $subLocation;
            }

            // Check if the village has already been inserted
            if (!in_array($village, $insertedVillages)) {
                // Insert into sub_location table if it's not a duplicate
                $this->insert('{{%village}}', [
                    'id' => IdGenerator::generateUniqueId(),
                    'name' => $village,
                    'sub_location_id' => $village,

                ]);
                // Add the village to the array to track it
                $insertedVillages[] = $village;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        return false;
    }
}
