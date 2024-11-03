<?php
/* @var $this yii\web\View */
/* @var $filename string */

use yii\helpers\Html;

$this->title = 'Export Successful';
?>

<div class="export-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Your file has been successfully exported. You can download it using the link below:</p>
    <p>
        <?= Html::a('Download Beneficiaries File', ['/exports/' . $filename], ['class' => 'btn btn-success']) ?>
    </p>
</div>
