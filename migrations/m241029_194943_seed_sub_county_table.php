<?php

use yii\db\Migration;

/**
 * Class m241029_194943_seed_sub_county_table
 */
class m241029_194943_seed_sub_county_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Define an array of sub-counties with corresponding county IDs
        $subCounties = [
            // Mombasa County (001)
            ['id' => '00101', 'name' => 'Mombasa Island', 'county_id' => '001'],
            ['id' => '00102', 'name' => 'Nyali', 'county_id' => '001'],
            ['id' => '00103', 'name' => 'Kisauni', 'county_id' => '001'],
            ['id' => '00104', 'name' => 'Likoni', 'county_id' => '001'],
            ['id' => '00105', 'name' => 'Changamwe', 'county_id' => '001'],
            ['id' => '00106', 'name' => 'Jomvu', 'county_id' => '001'],
            ['id' => '00107', 'name' => 'Mombasa Central', 'county_id' => '001'],

            // Kwale County (002)
            ['id' => '00201', 'name' => 'Kwale', 'county_id' => '002'],
            ['id' => '00202', 'name' => 'Lunga Lunga', 'county_id' => '002'],
            ['id' => '00203', 'name' => 'Matuga', 'county_id' => '002'],
            ['id' => '00204', 'name' => 'Msambweni', 'county_id' => '002'],
            ['id' => '00205', 'name' => 'Kinango', 'county_id' => '002'],

            // Kilifi County (003)
            ['id' => '00301', 'name' => 'Kilifi North', 'county_id' => '003'],
            ['id' => '00302', 'name' => 'Kilifi South', 'county_id' => '003'],
            ['id' => '00303', 'name' => 'Malindi', 'county_id' => '003'],
            ['id' => '00304', 'name' => 'Rabai', 'county_id' => '003'],
            ['id' => '00305', 'name' => 'Ganze', 'county_id' => '003'],
            ['id' => '00306', 'name' => 'Kaloleni', 'county_id' => '003'],

            // Tana River County (004)
            ['id' => '00401', 'name' => 'Tana River', 'county_id' => '004'],
            ['id' => '00402', 'name' => 'Garsen', 'county_id' => '004'],
            ['id' => '00403', 'name' => 'Hola', 'county_id' => '004'],
            ['id' => '00404', 'name' => 'Bura', 'county_id' => '004'],
            ['id' => '00405', 'name' => 'Bangale', 'county_id' => '004'],

            // Lamu County (005)
            ['id' => '00501', 'name' => 'Lamu East', 'county_id' => '005'],
            ['id' => '00502', 'name' => 'Lamu West', 'county_id' => '005'],
            ['id' => '00503', 'name' => 'Hindi', 'county_id' => '005'],
            ['id' => '00504', 'name' => 'Mpeketoni', 'county_id' => '005'],

            // Taita-Taveta County (006)
            ['id' => '00601', 'name' => 'Taveta', 'county_id' => '006'],
            ['id' => '00602', 'name' => 'Wundanyi', 'county_id' => '006'],
            ['id' => '00603', 'name' => 'Mwatate', 'county_id' => '006'],
            ['id' => '00604', 'name' => 'Voi', 'county_id' => '006'],

            // Garissa County (007)
            ['id' => '00701', 'name' => 'Garissa', 'county_id' => '007'],
            ['id' => '00702', 'name' => 'Fafi', 'county_id' => '007'],
            ['id' => '00703', 'name' => 'Ijara', 'county_id' => '007'],
            ['id' => '00704', 'name' => 'Dadaab', 'county_id' => '007'],
            ['id' => '00705', 'name' => 'Lagdera', 'county_id' => '007'],

            // Wajir County (008)
            ['id' => '00801', 'name' => 'Wajir East', 'county_id' => '008'],
            ['id' => '00802', 'name' => 'Wajir North', 'county_id' => '008'],
            ['id' => '00803', 'name' => 'Wajir South', 'county_id' => '008'],
            ['id' => '00804', 'name' => 'Wajir West', 'county_id' => '008'],

            // Mandera County (009)
            ['id' => '00901', 'name' => 'Mandera East', 'county_id' => '009'],
            ['id' => '00902', 'name' => 'Mandera North', 'county_id' => '009'],
            ['id' => '00903', 'name' => 'Mandera South', 'county_id' => '009'],
            ['id' => '00904', 'name' => 'Mandera West', 'county_id' => '009'],

            // Marsabit County (010)
            ['id' => '01001', 'name' => 'Marsabit North', 'county_id' => '010'],
            ['id' => '01002', 'name' => 'Marsabit South', 'county_id' => '010'],
            ['id' => '01003', 'name' => 'North Horr', 'county_id' => '010'],
            ['id' => '01004', 'name' => 'Laisamis', 'county_id' => '010'],
            ['id' => '01005', 'name' => 'Moyale', 'county_id' => '010'],

            // Isiolo County (011)
            ['id' => '01101', 'name' => 'Isiolo', 'county_id' => '011'],
            ['id' => '01102', 'name' => 'Garbatulla', 'county_id' => '011'],
            ['id' => '01103', 'name' => 'Merti', 'county_id' => '011'],

            // Meru County (012)
            ['id' => '01201', 'name' => 'Imenti North', 'county_id' => '012'],
            ['id' => '01202', 'name' => 'Imenti South', 'county_id' => '012'],
            ['id' => '01203', 'name' => 'Meru Central', 'county_id' => '012'],
            ['id' => '01204', 'name' => 'Meru South', 'county_id' => '012'],
            ['id' => '01205', 'name' => 'Tigania East', 'county_id' => '012'],
            ['id' => '01206', 'name' => 'Tigania West', 'county_id' => '012'],

            // Tharaka-Nithi County (013)
            ['id' => '01301', 'name' => 'Chuka', 'county_id' => '013'],
            ['id' => '01302', 'name' => 'Tharaka', 'county_id' => '013'],

            // Embu County (014)
            ['id' => '01401', 'name' => 'Embu East', 'county_id' => '014'],
            ['id' => '01402', 'name' => 'Embu West', 'county_id' => '014'],
            ['id' => '01403', 'name' => 'Manyatta', 'county_id' => '014'],

            // Kitui County (015)
            [
                'id' => '01501',
                'name' => 'Kitui Central',
                'county_id' => '015'
            ],
            ['id' => '01502', 'name' => 'Kitui East', 'county_id' => '015'],
            ['id' => '01503', 'name' => 'Kitui West', 'county_id' => '015'],
            ['id' => '01504', 'name' => 'Mwingi North', 'county_id' => '015'],
            ['id' => '01505', 'name' => 'Mwingi South', 'county_id' => '015'],

            // Machakos County (016)
            [
                'id' => '01601',
                'name' => 'Machakos Town',
                'county_id' => '016'
            ],
            ['id' => '01602', 'name' => 'Masinga', 'county_id' => '016'],
            ['id' => '01603', 'name' => 'Matungulu', 'county_id' => '016'],
            ['id' => '01604', 'name' => 'Kangundo', 'county_id' => '016'],
            ['id' => '01605', 'name' => 'Athi River', 'county_id' => '016'],
            ['id' => '01606', 'name' => 'Yatta', 'county_id' => '016'],

            // Makueni County (017)
            ['id' => '01701', 'name' => 'Makueni', 'county_id' => '017'],
            ['id' => '01702', 'name' => 'Kangundo', 'county_id' => '017'],
            ['id' => '01703', 'name' => 'Kilome', 'county_id' => '017'],

            // Nyandarua County (018)
            ['id' => '01801', 'name' => 'Nyandarua North', 'county_id' => '018'],
            ['id' => '01802', 'name' => 'Nyandarua South', 'county_id' => '018'],

            // Nyeri County (019)
            ['id' => '01901', 'name' => 'Nyeri Town', 'county_id' => '019'],
            ['id' => '01902', 'name' => 'Kieni', 'county_id' => '019'],
            ['id' => '01903', 'name' => 'Mathira', 'county_id' => '019'],

            // Kirinyaga County (020)
            ['id' => '02001', 'name' => 'Kirinyaga Central', 'county_id' => '020'],
            ['id' => '02002', 'name' => 'Kirinyaga East', 'county_id' => '020'],
            ['id' => '02003', 'name' => 'Kirinyaga West', 'county_id' => '020'],

            // Murang'a County (021)
            ['id' => '02101', 'name' => 'Murang\'a South', 'county_id' => '021'],
            ['id' => '02102', 'name' => 'Murang\'a North', 'county_id' => '021'],
            ['id' => '02103', 'name' => 'Kangema', 'county_id' => '021'],
            ['id' => '02104', 'name' => 'Mathioya', 'county_id' => '021'],
            ['id' => '02105', 'name' => 'Gatanga', 'county_id' => '021'],

            // Kiambu County (022)
            ['id' => '02201', 'name' => 'Thika Town', 'county_id' => '022'],
            ['id' => '02202', 'name' => 'Ruiru', 'county_id' => '022'],
            ['id' => '02203', 'name' => 'Githunguri', 'county_id' => '022'],
            ['id' => '02204', 'name' => 'Kiambaa', 'county_id' => '022'],
            ['id' => '02205', 'name' => 'Kabete', 'county_id' => '022'],
            ['id' => '02206', 'name' => 'Limuru', 'county_id' => '022'],

            // Turkana County (023)
            ['id' => '02301', 'name' => 'Turkana South', 'county_id' => '023'],
            ['id' => '02302', 'name' => 'Turkana North', 'county_id' => '023'],
            ['id' => '02303', 'name' => 'Loima', 'county_id' => '023'],
            ['id' => '02304', 'name' => 'Turkana East', 'county_id' => '023'],
            ['id' => '02305', 'name' => 'Turkana West', 'county_id' => '023'],

            // West Pokot County (024)
            ['id' => '02401', 'name' => 'Kapenguria', 'county_id' => '024'],
            ['id' => '02402', 'name' => 'Sigor', 'county_id' => '024'],
            ['id' => '02403', 'name' => 'Kacheliba', 'county_id' => '024'],
            ['id' => '02404', 'name' => 'Pokot South', 'county_id' => '024'],

            // Samburu County (025)
            ['id' => '02501', 'name' => 'Samburu North', 'county_id' => '025'],
            ['id' => '02502', 'name' => 'Samburu East', 'county_id' => '025'],
            ['id' => '02503', 'name' => 'Samburu West', 'county_id' => '025'],

            // Trans-Nzoia County (026)
            ['id' => '02601', 'name' => 'Kitale', 'county_id' => '026'],
            ['id' => '02602', 'name' => 'Endebess', 'county_id' => '026'],
            ['id' => '02603', 'name' => 'Kiminini', 'county_id' => '026'],

            // Uasin Gishu County (027)
            ['id' => '02701', 'name' => 'Eldoret East', 'county_id' => '027'],
            ['id' => '02702', 'name' => 'Eldoret West', 'county_id' => '027'],
            ['id' => '02703', 'name' => 'Kapseret', 'county_id' => '027'],

            // Elgeyo-Marakwet County (028)
            ['id' => '02801', 'name' => 'Keiyo North', 'county_id' => '028'],
            ['id' => '02802', 'name' => 'Keiyo South', 'county_id' => '028'],
            ['id' => '02803', 'name' => 'Marakwet East', 'county_id' => '028'],
            ['id' => '02804', 'name' => 'Marakwet West', 'county_id' => '028'],

            // Nandi County (029)
            ['id' => '02901', 'name' => 'Nandi Hills', 'county_id' => '029'],
            ['id' => '02902', 'name' => 'Chesumei', 'county_id' => '029'],
            ['id' => '02903', 'name' => 'Tinderet', 'county_id' => '029'],

            // Baringo County (030)
            ['id' => '03001', 'name' => 'Baringo Central', 'county_id' => '030'],
            ['id' => '03002', 'name' => 'Baringo North', 'county_id' => '030'],
            ['id' => '03003', 'name' => 'Baringo South', 'county_id' => '030'],
            ['id' => '03004', 'name' => 'Mochongoi', 'county_id' => '030'],

            // Laikipia County (031)
            [
                'id' => '03101',
                'name' => 'Laikipia West',
                'county_id' => '031'
            ],
            [
                'id' => '03102',
                'name' => 'Laikipia East',
                'county_id' => '031'
            ],
            ['id' => '03103', 'name' => 'Nanyuki', 'county_id' => '031'],

            // Nakuru County (032)
            [
                'id' => '03201',
                'name' => 'Nakuru Town East',
                'county_id' => '032'
            ],
            ['id' => '03202', 'name' => 'Nakuru Town West', 'county_id' => '032'],
            ['id' => '03203', 'name' => 'Naivasha', 'county_id' => '032'],
            ['id' => '03204', 'name' => 'Gilgil', 'county_id' => '032'],
            ['id' => '03205', 'name' => 'Molo', 'county_id' => '032'],
            ['id' => '03206', 'name' => 'Rongai', 'county_id' => '032'],
            [
                'id' => '03207',
                'name' => 'Kuresoi North',
                'county_id' => '032'
            ],
            [
                'id' => '03208',
                'name' => 'Kuresoi South',
                'county_id' => '032'
            ],

            // Narok County (033)
            ['id' => '03301', 'name' => 'Narok North', 'county_id' => '033'],
            ['id' => '03302', 'name' => 'Narok South', 'county_id' => '033'],
            ['id' => '03303', 'name' => 'Transmara East', 'county_id' => '033'],
            ['id' => '03304', 'name' => 'Transmara West', 'county_id' => '033'],

            // Kajiado County (034)
            [
                'id' => '03401',
                'name' => 'Kajiado North',
                'county_id' => '034'
            ],
            ['id' => '03402', 'name' => 'Kajiado East', 'county_id' => '034'],
            ['id' => '03403', 'name' => 'Kajiado West', 'county_id' => '034'],
            [
                'id' => '03404',
                'name' => 'Kajiado South',
                'county_id' => '034'
            ],

            // Kericho County (035)
            ['id' => '03501', 'name' => 'Kericho Town', 'county_id' => '035'],
            ['id' => '03502', 'name' => 'Ainamoi', 'county_id' => '035'],
            ['id' => '03503', 'name' => 'Bureti', 'county_id' => '035'],
            ['id' => '03504', 'name' => 'Kapsoit', 'county_id' => '035'],

            // Bomet County (036)
            [
                'id' => '03601',
                'name' => 'Bomet Central',
                'county_id' => '036'
            ],
            ['id' => '03602', 'name' => 'Bomet East', 'county_id' => '036'],
            ['id' => '03603', 'name' => 'Bomet West', 'county_id' => '036'],

            // Kakamega County (037)
            ['id' => '03701', 'name' => 'Kakamega South', 'county_id' => '037'],
            ['id' => '03702', 'name' => 'Kakamega North', 'county_id' => '037'],
            ['id' => '03703', 'name' => 'Kakamega Central', 'county_id' => '037'],
            ['id' => '03704', 'name' => 'Lurambi', 'county_id' => '037'],
            ['id' => '03705', 'name' => 'Malava', 'county_id' => '037'],

            // Vihiga County (038)
            [
                'id' => '03801',
                'name' => 'Vihiga',
                'county_id' => '038'
            ],
            ['id' => '03802', 'name' => 'Sabatia', 'county_id' => '038'],
            ['id' => '03803', 'name' => 'Luanda', 'county_id' => '038'],
            ['id' => '03804', 'name' => 'Hamisi', 'county_id' => '038'],

            // Bungoma County (039)
            ['id' => '03901', 'name' => 'Bungoma Central', 'county_id' => '039'],
            ['id' => '03902', 'name' => 'Bungoma East', 'county_id' => '039'],
            ['id' => '03903', 'name' => 'Bungoma West', 'county_id' => '039'],
            ['id' => '03904', 'name' => 'Kimilili', 'county_id' => '039'],
            ['id' => '03905', 'name' => 'Webuye East', 'county_id' => '039'],
            ['id' => '03906', 'name' => 'Webuye West', 'county_id' => '039'],

            // Busia County (040)
            ['id' => '04001', 'name' => 'Busia Township', 'county_id' => '040'],
            ['id' => '04002', 'name' => 'Teso North', 'county_id' => '040'],
            ['id' => '04003', 'name' => 'Teso South', 'county_id' => '040'],
            ['id' => '04004', 'name' => 'Butula', 'county_id' => '040'],
            ['id' => '04005', 'name' => 'Nambale', 'county_id' => '040'],

            // Siaya County (041)
            ['id' => '04101', 'name' => 'Siaya', 'county_id' => '041'],
            ['id' => '04102', 'name' => 'Gem', 'county_id' => '041'],
            ['id' => '04103', 'name' => 'Rarieda', 'county_id' => '041'],
            ['id' => '04104', 'name' => 'Ugunja', 'county_id' => '041'],
            ['id' => '04105', 'name' => 'Bondo', 'county_id' => '041'],

            // Kisumu County (042)
            [
                'id' => '04201',
                'name' => 'Kisumu Central',
                'county_id' => '042'
            ],
            ['id' => '04202', 'name' => 'Kisumu East', 'county_id' => '042'],
            ['id' => '04203', 'name' => 'Kisumu West', 'county_id' => '042'],
            ['id' => '04204', 'name' => 'Muhoroni', 'county_id' => '042'],
            ['id' => '04205', 'name' => 'Nyando', 'county_id' => '042'],

            // Homa Bay County (043)
            [
                'id' => '04301',
                'name' => 'Homa Bay Town',
                'county_id' => '043'
            ],
            ['id' => '04302', 'name' => 'Mbita', 'county_id' => '043'],
            ['id' => '04303', 'name' => 'Suba North', 'county_id' => '043'],
            ['id' => '04304', 'name' => 'Suba South', 'county_id' => '043'],
            ['id' => '04305', 'name' => 'Rachuonyo North', 'county_id' => '043'],
            ['id' => '04306', 'name' => 'Rachuonyo South', 'county_id' => '043'],

            // Migori County (044)
            [
                'id' => '04401',
                'name' => 'Migori',
                'county_id' => '044'
            ],
            ['id' => '04402', 'name' => 'Awendo', 'county_id' => '044'],
            ['id' => '04403', 'name' => 'Rongo', 'county_id' => '044'],
            ['id' => '04404', 'name' => 'Nyatike', 'county_id' => '044'],
            ['id' => '04405', 'name' => 'Uriri', 'county_id' => '044'],

            // Kisii County (045)
            ['id' => '04501', 'name' => 'Kisii', 'county_id' => '045'],
            ['id' => '04502', 'name' => 'Bobasi', 'county_id' => '045'],
            ['id' => '04503', 'name' => 'Kitutu Chache North', 'county_id' => '045'],
            ['id' => '04504', 'name' => 'Kitutu Chache South', 'county_id' => '045'],
            ['id' => '04505', 'name' => 'Marani', 'county_id' => '045'],

            // Nyamira County (046)
            ['id' => '04601', 'name' => 'Nyamira', 'county_id' => '046'],
            ['id' => '04602', 'name' => 'Borabu', 'county_id' => '046'],
            [
                'id' => '04603',
                'name' => 'Nyamira North',
                'county_id' => '046'
            ],
            [
                'id' => '04604',
                'name' => 'Nyamira South',
                'county_id' => '046'
            ],

            // Nairobi County (047)
            ['id' => '04701', 'name' => 'Nairobi Central', 'county_id' => '047'],
            [
                'id' => '04702',
                'name' => 'Embakasi East',
                'county_id' => '047'
            ],
            [
                'id' => '04703',
                'name' => 'Embakasi West',
                'county_id' => '047'
            ],
            ['id' => '04704', 'name' => 'Lang\'ata', 'county_id' => '047'],
            ['id' => '04705', 'name' => 'Kasarani', 'county_id' => '047'],
            ['id' => '04706', 'name' => 'Ruaraka', 'county_id' => '047'],
            ['id' => '04707', 'name' => 'Westlands', 'county_id' => '047'],
        ];

        // Insert each sub-county into the database
        foreach ($subCounties as $subCounty) {
            $this->insert('sub_county', $subCounty);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('sub_county');
    }
}
