<?php

namespace app\modules\dashboard\models;

use Yii;

/**
 * This is the model class for table "sub_location".
 *
 * @property string $id
 * @property string|null $name
 * @property string|null $location_id
 *
 * @property Location $location
 * @property OfficerSubLocation[] $officerSubLocations
 * @property Village[] $villages
 */
class SubLocation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sub_location';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'name', 'location_id'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::class, 'targetAttribute' => ['location_id' => 'id']],
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
            'location_id' => 'Location ID',
        ];
    }

    /**
     * Gets query for [[Location]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::class, ['id' => 'location_id']);
    }

    /**
     * Gets query for [[OfficerSubLocations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOfficerSubLocations()
    {
        return $this->hasMany(OfficerSubLocation::class, ['sub_location_id' => 'id']);
    }

    /**
     * Gets query for [[Villages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVillages()
    {
        return $this->hasMany(Village::class, ['sub_location_id' => 'id']);
    }
}
