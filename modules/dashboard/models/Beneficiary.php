<?php

namespace app\modules\dashboard\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "beneficiary".
 *
 * @property string $id
 * @property string $name
 * @property string|null $national_id
 * @property string $contact
 * @property string $sub_location
 * @property string $village
 * @property string $stove_no
 * @property string|null $issue_date
 * @property string $lat
 * @property string $long
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class Beneficiary extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',

            ],

        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'beneficiary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'contact', 'sub_location', 'village', 'stove_no', 'lat', 'long'], 'required'],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['id', 'name', 'national_id', 'contact', 'sub_location', 'village', 'stove_no', 'issue_date', 'lat', 'long'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'national_id' => 'National ID',
            'contact' => 'Contact',
            'sub_location' => 'Sub Location',
            'village' => 'Village',
            'stove_no' => 'Stove No',
            'issue_date' => 'Issue Date',
            'lat' => 'Lat',
            'long' => 'Long',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
