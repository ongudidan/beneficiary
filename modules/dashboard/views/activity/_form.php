<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\Activity $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php
$formAction = Yii::$app->controller->action->id === 'update'
    ? ['activity/update', 'id' => $model->id]
    : ['activity/create']; // Use 'create' action if it's not update
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
                        <h4><i class="glyphicon glyphicon-envelope"></i> Activity Details</h4>
                    </div> -->

                    <div class="col-12 col-sm-12">
                        <div class="form-group local-forms">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12">
                        <div class="form-group local-forms">
                            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12">
                        <div class="form-group local-forms">

                            <?= $form->field($model, 'start_date')->widget(DateTimePicker::classname(), [
                                'options' => ['placeholder' => 'Enter start date of activity...'],
                                'value' => date('d-M-Y H:i'), // Set current date and time as default in the correct format
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd-M-yyyy hh:ii', // Set the date format to 'dd-M-yyyy' and include time
                                    'todayHighlight' => true, // Highlight today's date
                                    'todayBtn' => true, // Add a button to quickly select today's date and time
                                    'minuteStep' => 1, // Optional: set minute interval for time picker
                                ]
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12">
                        <div class="form-group local-forms">

                            <?= $form->field($model, 'end_date')->widget(DateTimePicker::classname(), [
                                'options' => ['placeholder' => 'Enter end date of activity...'],
                                'value' => date('d-M-Y H:i'), // Set current date and time as default in the correct format
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd-M-yyyy hh:ii', // Set the date format to 'dd-M-yyyy' and include time
                                    'todayHighlight' => true, // Highlight today's date
                                    'todayBtn' => true, // Add a button to quickly select today's date and time
                                    'minuteStep' => 1, // Optional: set minute interval for time picker
                                ]
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12">
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