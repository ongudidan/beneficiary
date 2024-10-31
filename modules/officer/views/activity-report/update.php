<?php

use app\modules\dashboard\models\Beneficiary;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\ActivityReport $model */

    $beneficiaryName = Beneficiary::findOne(['id' => $model->beneficiary_id])->name;
    $this->title = 'Update Activity Report for: ' . $beneficiaryName;
    $this->params['breadcrumbs'][] = ['label' => 'Beneficiaries', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $beneficiaryName, 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = 'Update';
?>
<div class="activity-report-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
