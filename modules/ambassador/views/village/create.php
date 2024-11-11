<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\Village $model */

$this->title = 'Create Village';
$this->params['breadcrumbs'][] = ['label' => 'Villages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="village-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
