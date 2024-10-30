<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\ActivityReport $model */

$this->title = 'Activity Report for :'.' '. $model->beneficiary->name;
$this->params['breadcrumbs'][] = ['label' => 'Beneficiaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="activity-report-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'activity.reference_no',
            'beneficiary.name',
            'usage',
            'condition',
            'recommendation',
            'remarks',
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at);
                },
            ],
            // 'updated_at',
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->updated_at);
                },
            ],
            // 'created_by',
            [
                'attribute' => 'created_by',
                'value' => function ($model) {
                    return User::findOne($model->created_by)->username ?? '{not set}';
                },
            ],
            // 'updated_by',
            [
                'attribute' => 'updated_by',
                'value' => function ($model) {
                    return User::findOne($model->updated_by)->username ?? '{not set}';
                },
            ],
        ],
    ]) ?>

</div>
