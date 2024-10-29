<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\Beneficiary $model */

$this->title = 'Create Beneficiary';
$this->params['breadcrumbs'][] = ['label' => 'Beneficiaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beneficiary-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
