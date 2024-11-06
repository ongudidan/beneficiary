<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\SubLocation $model */

$this->title = 'Update Sub Location: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sub Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sub-location-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
