<?php

use yii\db\Migration;

/**
 * Class m241029_194848_seed_county_table
 */
class m241029_194848_seed_county_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Define an array of Kenyan counties
        $counties = [
            ['id' => '001', 'name' => 'Mombasa'],
            ['id' => '002', 'name' => 'Kwale'],
            ['id' => '003', 'name' => 'Kilifi'],
            ['id' => '004', 'name' => 'Tana River'],
            ['id' => '005', 'name' => 'Lamu'],
            ['id' => '006', 'name' => 'Taita-Taveta'],
            ['id' => '007', 'name' => 'Garissa'],
            ['id' => '008', 'name' => 'Wajir'],
            ['id' => '009', 'name' => 'Mandera'],
            ['id' => '010', 'name' => 'Marsabit'],
            ['id' => '011', 'name' => 'Isiolo'],
            ['id' => '012', 'name' => 'Meru'],
            ['id' => '013', 'name' => 'Tharaka-Nithi'],
            ['id' => '014', 'name' => 'Embu'],
            ['id' => '015', 'name' => 'Kitui'],
            ['id' => '016', 'name' => 'Machakos'],
            ['id' => '017', 'name' => 'Makueni'],
            ['id' => '018', 'name' => 'Nyandarua'],
            ['id' => '019', 'name' => 'Nyeri'],
            ['id' => '020', 'name' => 'Kirinyaga'],
            ['id' => '021', 'name' => 'Murang\'a'],
            ['id' => '022', 'name' => 'Kiambu'],
            ['id' => '023', 'name' => 'Turkana'],
            ['id' => '024', 'name' => 'West Pokot'],
            ['id' => '025', 'name' => 'Samburu'],
            ['id' => '026', 'name' => 'Trans-Nzoia'],
            ['id' => '027', 'name' => 'Uasin Gishu'],
            ['id' => '028', 'name' => 'Elgeyo-Marakwet'],
            ['id' => '029', 'name' => 'Nandi'],
            ['id' => '030', 'name' => 'Baringo'],
            ['id' => '031', 'name' => 'Laikipia'],
            ['id' => '032', 'name' => 'Nakuru'],
            ['id' => '033', 'name' => 'Narok'],
            ['id' => '034', 'name' => 'Kajiado'],
            ['id' => '035', 'name' => 'Kericho'],
            ['id' => '036', 'name' => 'Bomet'],
            ['id' => '037', 'name' => 'Kakamega'],
            ['id' => '038', 'name' => 'Vihiga'],
            ['id' => '039', 'name' => 'Bungoma'],
            ['id' => '040', 'name' => 'Busia'],
            ['id' => '041', 'name' => 'Siaya'],
            ['id' => '042', 'name' => 'Kisumu'],
            ['id' => '043', 'name' => 'Homa Bay'],
            ['id' => '044', 'name' => 'Migori'],
            ['id' => '045', 'name' => 'Kisii'],
            ['id' => '046', 'name' => 'Nyamira'],
            ['id' => '047', 'name' => 'Nairobi'],
        ];

        // Insert counties into the `county` table
        foreach ($counties as $county) {
            $this->insert('{{%county}}', $county);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Remove all records from the county table
        $this->truncateTable('{{%county}}');
    }
}
