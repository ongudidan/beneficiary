<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\FieldOfficer $model */

$this->title = 'Create Field Officer';
$this->params['breadcrumbs'][] = ['label' => 'Field Officers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="field-officer-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
