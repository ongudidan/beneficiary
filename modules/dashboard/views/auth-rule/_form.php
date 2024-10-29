<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\AuthRule $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="auth-rule-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<div>
    <form class="form-create-role">
        <div class="card p-3 mb-4">
            <div class="mb-3">
                <label class="form-label">Auth rule Name</label>
                <input type="text" class="form-control" placeholder="Rule Name" name="name" required>
            </div>

            <div class="mb-3">
                <h5>Permissions</h5>
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Section</th>
                                <th>All</th>
                                <th>Index</th>
                                <th>Create</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Roles</td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                            </tr>
                            <tr>
                                <td>Users</td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                            </tr>
                            <tr>
                                <td>Product</td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                            </tr>
                            <tr>
                                <td>Attributes</td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
    </form>
</div>