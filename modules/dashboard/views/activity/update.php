<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\Activity $model */

$this->title = 'Update Activity: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="activity-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
