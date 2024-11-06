<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\Beneficiary $model */

$this->title = 'Update Beneficiary: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Beneficiaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="beneficiary-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
