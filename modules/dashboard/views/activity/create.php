<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\Activity $model */

$this->title = 'Create Activity';
$this->params['breadcrumbs'][] = ['label' => 'Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
