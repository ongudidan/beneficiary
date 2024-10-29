<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\Ambassador $model */

$this->title = 'Update Ambassador: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ambassadors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ambassador-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>