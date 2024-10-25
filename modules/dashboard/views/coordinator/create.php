<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\Coordinator $model */

$this->title = 'Create Coordinator';
$this->params['breadcrumbs'][] = ['label' => 'Coordinators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coordinator-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
