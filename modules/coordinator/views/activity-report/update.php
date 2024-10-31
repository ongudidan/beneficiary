<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\ActivityReport $model */

$this->title = 'Update Activity Report: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Activity Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="activity-report-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
