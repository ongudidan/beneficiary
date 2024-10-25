<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\FieldOfficer $model */

$this->title = 'Update Field Officer: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Field Officers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="field-officer-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
