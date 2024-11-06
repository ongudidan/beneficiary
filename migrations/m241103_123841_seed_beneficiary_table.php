<?php

use app\components\IdGenerator;
use app\models\User;
use app\modules\dashboard\models\SubLocation;
use app\modules\dashboard\models\Village;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\db\Migration;

/**
 * Class m241103_123841_seed_beneficiary_table
 */
class m241103_123841_seed_beneficiary_table extends Migration
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
            $name = strtoupper($row[1] ?? 'Undefined');
            $nationalId = strtoupper($row[2] ?? 'Undefined');
            $contact = strtoupper($row[3] ?? 'Undefined');
            $subLocation = strtoupper($row[4] ?? 'Undefined');
            $village = strtoupper($row[5] ?? 'Undefined');
            $stoveNo = strtoupper($row[6] ?? 'Undefined');


            $subLocationId = SubLocation::findOne(['name' => $subLocation])->id;
            $villageId = Village::findOne(['name' => $village])->id;



            $issueDate = null;
            if (isset($row[7]) && $row[7] !== 'Undefined') {
                $dateTime = DateTime::createFromFormat('d/m/Y', $row[7]);
                if ($dateTime) {
                    $issueDate = $dateTime->getTimestamp();
                }
            }

            $lat = $row[8] ?? 'Undefined ';
            $long = $row[9] ?? 'Undefined ';
            $ambassador = strtoupper($row[12] ?? 'Undefined');
            $fieldOfficer = strtoupper($row[13] ?? 'Undefined');
            $coordinator = strtoupper($row[14] ?? 'Undefined');



            // Insert the beneficiary into the beneficiary table
            $this->insert('{{%beneficiary}}', [
                'id' => $id,
                'name' => $name,
                'national_id' => $nationalId,
                'contact' => $contact,
                'sub_location' => $subLocation,
                'sub_location_id' => $subLocationId,
                'village_id' => $villageId,
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
