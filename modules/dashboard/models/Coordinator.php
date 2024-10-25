<?php

namespace app\modules\dashboard\models;

use app\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "coordinator".
 *
 * @property string $id
 * @property string $name
 * @property string $user_id
 * @property string|null $national_id
 * @property string $email
 * @property string $phone_no
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @property User $user
 */
class Coordinator extends \yii\db\ActiveRecord
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
        return 'coordinator';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'user_id', 'email', 'phone_no'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['id', 'name', 'user_id', 'national_id', 'email', 'phone_no', 'created_by', 'updated_by'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'national_id' => 'National ID',
            'email' => 'Email',
            'phone_no' => 'Phone No',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
