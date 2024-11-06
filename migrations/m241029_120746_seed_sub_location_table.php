<?php

use app\components\IdGenerator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\db\Migration;

/**
 * Class m241029_120746_seed_sub_location_table
 */
class m241029_120746_seed_sub_location_table extends Migration
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

        // Create an array to keep track of already inserted sublocations
        $insertedSubLocations = [];

        // Iterate through the rows and insert sublocations
        foreach ($data as $index => $row) {
            // Skip rows before row 5 (index 4)
            if ($index < 4) {
                continue;
            }

            $subLocation = strtoupper($row[4] ?? 'Undefined');

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
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Logic to revert sublocation changes if needed
        return false;
    }
}
