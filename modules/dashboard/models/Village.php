<?php

namespace app\modules\dashboard\models;

use Yii;

/**
 * This is the model class for table "village".
 *
 * @property string $id
 * @property string|null $name
 * @property string|null $sub_location_id
 *
 * @property AmbassadorVillage[] $ambassadorVillages
 * @property Beneficiary[] $beneficiaries
 * @property SubLocation $subLocation
 */
class Village extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'village';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'name', 'sub_location_id'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['sub_location_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubLocation::class, 'targetAttribute' => ['sub_location_id' => 'id']],
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
            'sub_location_id' => 'Sub Location ID',
        ];
    }

    /**
     * Gets query for [[AmbassadorVillages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAmbassadorVillages()
    {
        return $this->hasMany(AmbassadorVillage::class, ['village_id' => 'id']);
    }

    /**
     * Gets query for [[Beneficiaries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBeneficiaries()
    {
        return $this->hasMany(Beneficiary::class, ['village_id' => 'id']);
    }

    /**
     * Gets query for [[SubLocation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubLocation()
    {
        return $this->hasOne(SubLocation::class, ['id' => 'sub_location_id']);
    }
}
