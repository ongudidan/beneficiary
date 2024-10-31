<?php

use app\modules\dashboard\models\Beneficiary;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\ActivityReport $model */

$beneficiaryId = Yii::$app->request->get('beneficiary_id');
$beneficiaryName = Beneficiary::findOne($beneficiaryId)->name;

$this->title = 'Create Activity Report for: '.$beneficiaryName;
$this->params['breadcrumbs'][] = ['label' => 'Activity Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="activity-report-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>