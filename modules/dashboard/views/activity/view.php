<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\Activity $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="activity-view">

    <div class="col-sm-12">
        <div class="card comman-shadow">
            <div class="card-body">


                <div class="row align-items-center">
                    <div class="col-auto text-end float-end ms-auto download-grp">
                        <p>
                            <a href="<?= Url::to(['/dashboard/activity/update', 'id' => $model->id]) ?>" class="btn btn-sm bg-danger-light">
                                <i class="feather-edit"></i>
                            </a>
                            <a href="#" class="btn btn-sm bg-danger-light delete-btn" data-url="<?= Url::to(['/dashboard/activity/delete', 'id' => $model->id]) ?>">
                                <i class="feather-trash"></i>
                            </a>
                        </p>
                    </div>
                </div>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'name',
                        'reference_no',
                        'date',
                        'description',
                        'status',
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