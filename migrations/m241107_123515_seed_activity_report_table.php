<?php

use app\components\IdGenerator;
use app\models\User;
use app\modules\dashboard\models\Activity;
use app\modules\dashboard\models\Beneficiary;
use app\modules\dashboard\models\SubLocation;
use app\modules\dashboard\models\Village;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\db\Migration;

/**
 * Class m241107_123515_seed_activity_report_table
 */
class m241107_123515_seed_activity_report_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $createdBy = User::find()->where(['username' => 'admin'])->one()->id;
        $updatedBy = User::find()->where(['username' => 'admin'])->one()->id;
        $activityId = 'test';

        $this->insert('{{%activity}}', [
            'id' => $activityId,
            'name' => 'VERIFIED',
            'reference_no' => Activity::generateReferenceNo(),
            'start_date' => time(),
            'end_date' => time(),
            'description' => 'VERIFIED LIST - BY 30TH SEPT - 2024',
            'status' => 10,
            'created_at' =>  time(),
            'updated_at' =>  time(),
            'created_by' => $createdBy,
            'updated_by' => $updatedBy,
       
        ]);


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

            $reportId = IdGenerator::generateUniqueId();


            // Set beneficiary values
            $name = strtoupper($row[1] ?? 'Undefined');
            $nationalId = strtoupper($row[2] ?? 'Undefined');
            $contact = strtoupper($row[3] ?? 'Undefined');
            $subLocation = strtoupper($row[4] ?? 'Undefined');
            $village = strtoupper($row[5] ?? 'Undefined');
            $stoveNo = strtoupper($row[6] ?? 'Undefined');


            $subLocationId = SubLocation::findOne(['name' => $subLocation])->id;
            $villageId = Village::findOne(['name' => $village])->id;



            // $issueDate = null;
            // if (isset($row[7]) && $row[7] !== 'Undefined') {
            //     $dateTime = DateTime::createFromFormat('d/m/Y', $row[7]);
            //     if ($dateTime) {
            //         $issueDate = $dateTime->getTimestamp();
            //     }
            // }

            $activityType = 'Physical Visit';
            // $beneficiaryId = Beneficiary::findOne($row[1])->id;
            $beneficiaryId = Beneficiary::find()->where(['village'=> $village, 'name' => $name])->one()->id;
            if(!isset($beneficiaryId)){

                continue;
            }

            $usage = strtoupper($row[10] ?? 'Undefined');
            $condition = '';
            $action = '';
            $audio = '';
            $photo = '';
            $recommendation = '';
            $remarks = '';



            // Insert the beneficiary into the beneficiary table
            $this->insert('{{%activity_report}}', [
                'id' => $reportId,
                'activity_id' => 'test',
                'activity_type' => $activityType,
                'beneficiary_id' => $beneficiaryId,
                'usage' => $usage,
                'condition' => $condition,
                'action' => $action,
                // 'audio' => $audio,
                // 'photo' => $photo,
                'recommendation' => $recommendation,
                'remarks' => $remarks,
                'created_at' => time(),
                'updated_at' => time(),
                'created_by' => $createdBy,
                'updated_by' => $updatedBy,
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
