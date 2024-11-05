<?php

namespace app\modules\dashboard\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class ActivityReport extends ActiveRecord
{
    public $audioFile;
    public $photoFile;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    public static function tableName()
    {
        return 'activity_report';
    }

    public function rules()
    {
        return [
            [['id', 'usage', 'condition', 'beneficiary_id', 'photoFile', 'activity_id', 'activity_type',], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['id', 'activity_id', 'audio', 'photo', 'beneficiary_id', 'usage', 'condition', 'recommendation', 'remarks', 'created_by', 'updated_by'], 'string', 'max' => 255],
            [['id'], 'unique'],
            // [['photoFile'], 'file', 'extensions' => 'jpg, png', 'maxSize' => 50 * 1024 * 1024, 'skipOnEmpty' => true],
            // [['audioFile'], 'file', 'extensions' => 'mp3, wav', 'maxSize' => 50 * 1024 * 1024, 'skipOnEmpty' => true],
            // Add validation rules for audioFile and photoFile
            [['audioFile', 'photoFile'], 'file', 'skipOnEmpty' => true],
            // [['audioFile', 'photoFile'], 'safe'], // Mark these fields as safe
      
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_id' => 'Activity',
            'beneficiary_id' => 'Beneficiary',
            'audio' => 'Recorded phone call (<5MBs)',
            'photo' => 'Photo of phone call data entry form',
            'usage' => 'Usage',
            'condition' => 'Condition',
            'activity_type' => 'Activity type',
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
