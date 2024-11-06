<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\SubLocation $model */

$this->title = 'Create Sub Location';
$this->params['breadcrumbs'][] = ['label' => 'Sub Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-location-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
