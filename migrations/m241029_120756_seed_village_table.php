<?php

use app\components\IdGenerator;
use app\modules\dashboard\models\SubLocation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\db\Migration;

/**
 * Class m241029_120756_seed_village_table
 */
class m241029_120756_seed_village_table extends Migration
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

        // Create an array to keep track of already inserted villages and sublocations
        $insertedVillages = [];

        // Second pass to insert villages
        foreach ($data as $index => $row) {
            if ($index < 4) {
                continue;
            }

            $village = $row[5] ?? 'Undefined ';
            $subLocation = $row[4] ?? 'Undefined ';
            $subLocationId = SubLocation::findOne(['name' => $subLocation])->id;


            // Check if the village has already been inserted
            if (!in_array($village, $insertedVillages)) {
                // Insert into the village table with the correct sublocation ID
                $this->insert('{{%village}}', [
                    'id' => IdGenerator::generateUniqueId(),
                    'name' => $village,
                    'sub_location_id' => $subLocationId, // Use the tracked sublocation ID
                ]);
                // Track the village
                $insertedVillages[] = $village;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Logic to revert village changes if needed
        return false;
    }
}
