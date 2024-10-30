<?php

namespace app\modules\dashboard\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "activity_report".
 *
 * @property string $id
 * @property string|null $activity_id
 * @property string|null $beneficiary_id
 * @property string|null $usage
 * @property string|null $condition
 * @property string|null $recommendation
 * @property string|null $remarks
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 */
class ActivityReport extends \yii\db\ActiveRecord
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
        return 'activity_report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usage', 'condition', 'beneficiary_id', 'activity_id'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['id', 'activity_id', 'beneficiary_id', 'usage', 'condition', 'recommendation', 'remarks', 'created_by', 'updated_by'], 'string', 'max' => 255],
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
            'activity_id' => 'Activity',
            'beneficiary_id' => 'Beneficiary',
            'usage' => 'Usage',
            'condition' => 'Condition',
            'recommendation' => 'Recommendation',
            'remarks' => 'Remarks',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getActivity()
    {
        return $this->hasOne(Activity::class, ['id' => 'activity_id']);
    }

    public function getBeneficiary()
    {
        return $this->hasOne(Beneficiary::class, ['id' => 'beneficiary_id']);
    }
}
