<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\ActivityReport $model */

$this->title = 'Create Activity Report';
$this->params['breadcrumbs'][] = ['label' => 'Activity Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-report-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
