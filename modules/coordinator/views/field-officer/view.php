<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\coordinator\models\FieldOfficer $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Field Officers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="field-officer-view">

    <div class="col-sm-12">
        <div class="card comman-shadow">
            <div class="card-body">

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'name',
                        'national_id',
                        'coordinator.name',
                        'email:email',
                        'phone_no',
                        'status',
                        [
                            'attribute' => 'created_at',
                            'value' => function ($model) {
                                return Yii::$app->formatter->asDatetime($model->created_at);
                            },
                        ],
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