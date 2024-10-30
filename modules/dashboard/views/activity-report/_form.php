<?php

use app\modules\dashboard\models\Activity;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\ActivityReport $model */
/** @var yii\widgets\ActiveForm $form */

$beneficiaryId = Yii::$app->request->get('beneficiary_id');

$formAction = Yii::$app->controller->action->id === 'update'
    ? ['activity-report/update', 'id' => $model->id]
    : ['activity-report/create']; // Use 'create' action if it's not update
?>

<?php $form = ActiveForm::begin([
    'id' => 'main-form',
    'enableAjaxValidation' => false,
    'action' => $formAction,
    'method' => 'post',
]); ?>

<?= $form->field($model, 'beneficiary_id')->hiddenInput(['value' => $beneficiaryId])->label(false) ?>

<div class="row">
    <div class="col-sm-12">
        <div class="card comman-shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <div class="form-group local-forms">
                            <?= $form->field($model, 'activity_id')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Activity::find()->all(), 'id', 'name'),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Select Activity ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group local-forms">
                            <?= $form->field($model, 'usage')->dropDownList([
                                'In Use' => 'In Use',
                                'Not In Use' => 'Not In Use',
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group local-forms">
                            <?= $form->field($model, 'condition')->dropDownList([
                                'Good' => 'Good',
                                'Bad' => 'Bad',
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group local-forms">
                            <?= $form->field($model, 'recommendation')->textarea(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group local-forms">
                            <?= $form->field($model, 'remarks')->textarea(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="student-submit d-flex justify-content-center">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'form' => 'main-form']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>