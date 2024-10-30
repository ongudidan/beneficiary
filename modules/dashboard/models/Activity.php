<?php

namespace app\modules\dashboard\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "activity".
 *
 * @property string $id
 * @property string $name
 * @property string $reference_no
 * @property string $date
 * @property string $description
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 */
class Activity extends \yii\db\ActiveRecord
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
        return 'activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'reference_no', 'start_date','end_date', 'description'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['id', 'name', 'reference_no', 'start_date', 'end_date', 'description', 'created_by', 'updated_by'], 'string', 'max' => 255],
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
            'reference_no' => 'Reference No',
            'date' => 'Date',
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public static function generateReferenceNo()
    {
        $year = date('Y');
        $prefix = '#ACTIVITY-';
        $yearPrefix = substr($year, -2);

        // Get the maximum card number from the database
        $lastRecord = self::find()
            ->select(['reference_no'])
            ->orderBy(['reference_no' => SORT_DESC])
            ->limit(1)
            ->one();

        // Extract the last number from the highest card number
        if ($lastRecord && preg_match('/(\d{5})' . $yearPrefix . '$/', $lastRecord->reference_no, $matches)) {
            $lastNumber = intval($matches[1]);
        } else {
            $lastNumber = 0;  // Default to 0 if no records found
        }

        // Increment the last number to create a new number
        $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

        return $prefix . $newNumber . $yearPrefix;
    }
}
