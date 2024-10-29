<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\Coordinator $model */

$this->title = 'Update Coordinator: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Coordinators', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="coordinator-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
