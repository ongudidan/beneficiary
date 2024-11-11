<?php

namespace app\modules\dashboard\models;

use Yii;

/**
 * This is the model class for table "export_files".
 *
 * @property int $id
 * @property int $activity_id
 * @property string|null $file_path
 * @property string $created_at
 * @property string $status
 */
class ExportFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'export_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity_id'], 'required'],
            [['activity_id'], 'integer'],
            [['created_at'], 'safe'],
            [['status'], 'string'],
            [['file_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_id' => 'Activity ID',
            'file_path' => 'File Path',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
}
