<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\Village $model */

$this->title = 'Update Village: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Villages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="village-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
