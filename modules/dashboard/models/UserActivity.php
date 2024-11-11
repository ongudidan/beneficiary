<?php

namespace app\modules\dashboard\models;

use app\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_activity".
 *
 * @property string $user_id
 * @property string|null $activity_id
 * @property int $updated_at
 *
 * @property User $user
 */
class UserActivity extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => false,
                'updatedAtAttribute' => 'updated_at',
            ],
            // [
            //     'class' => BlameableBehavior::class,
            //     'createdByAttribute' => 'created_by',
            //     'updatedByAttribute' => 'updated_by',

            // ],

        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['user_id', 'updated_at'], 'required'],
            [['updated_at'], 'integer'],
            [['user_id', 'activity_id'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'activity_id' => 'Activity ID',
            'updated_at' => 'Updated At',
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
