<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\ambassador\models\ActivityReport $model */

$this->title = 'Activity Report for :' . ' ' . $model->beneficiary->name;
$this->params['breadcrumbs'][] = ['label' => 'Beneficiaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="activity-report-view">

    <div class="col-sm-12">
        <div class="card comman-shadow">
            <div class="card-body">

                <?php if ($model->activity->status == 10) { ?>

                    <div class="row align-items-center">
                        <div class="col-auto text-end float-end ms-auto download-grp">
                            <p>
                                <?php if (Yii::$app->controller->id === 'activity-report') { ?>
                                    <a href="<?= Url::to(['/ambassador/activity-report/update', 'id' => $model->id]) ?>" class="btn btn-sm bg-danger-light">
                                        <i class="feather-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm bg-danger-light delete-btn" data-url="<?= Url::to(['/ambassador/activity-report/delete', 'id' => $model->id]) ?>">
                                        <i class="feather-trash"></i>
                                    </a>
                                <?php } elseif (Yii::$app->controller->id === 'beneficiary') { ?>
                                    <a href="<?= Url::to(['/ambassador/beneficiary/report-update', 'id' => $model->id]) ?>" class="btn btn-sm bg-danger-light">
                                        <i class="feather-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm bg-danger-light delete-btn" data-url="<?= Url::to(['/ambassador/beneficiary/report-delete', 'id' => $model->id]) ?>">
                                        <i class="feather-trash"></i>
                                    </a>
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>

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
        </div>
    </div>
</div>