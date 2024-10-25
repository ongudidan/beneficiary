<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\Ambassador $model */

$this->title = 'Create Ambassador';
$this->params['breadcrumbs'][] = ['label' => 'Ambassadors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ambassador-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
