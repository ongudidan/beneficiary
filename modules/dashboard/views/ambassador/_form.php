<?php

use app\modules\dashboard\models\FieldOfficer;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\Ambassador $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php
$formAction = Yii::$app->controller->action->id === 'update'
    ? ['ambassador/update', 'id' => $model->id]
    : ['ambassador/create']; // Use 'create' action if it's not update
?>

<?php $form = ActiveForm::begin([
    'id' => 'main-form',
    'enableAjaxValidation' => false, // Disable if you're not using AJAX
    'action' => $formAction, // Set action based on create or update
    'method' => 'post',
]); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="card comman-shadow">
            <div class="card-body">

                <div class="row">
                    <!-- <div class="panel-heading pb-3">
                        <h4><i class="glyphicon glyphicon-envelope"></i> field-officer Details</h4>
                    </div> -->

                    <div class="col-12 col-sm-6">
                        <div class="form-group local-forms">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group local-forms">
                            <?= $form->field($model, 'national_id')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="form-group local-forms">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group local-forms">
                            <?= $form->field($model, 'phone_no')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="form-group local-forms">
                            <?= $form->field($model, 'field_officer_id')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(FieldOfficer::find()->all(), 'id', 'name'),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Select Field Officer ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="form-group local-forms">
                            <?= $form->field($model, 'status')->dropDownList([
                                '10' => 'Active',
                                '9' => 'Inactive',

                            ]) ?>
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