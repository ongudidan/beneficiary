<?php

namespace app\models;

use yii\base\Model;

class RoleForm extends Model
{
    public $name;
    public $permissions = [];

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 64],
            [['permissions'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Role Name',
        ];
    }
}
