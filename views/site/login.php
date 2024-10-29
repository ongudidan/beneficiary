<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-left">
                        <img class="img-fluid" src="/web/dashboard/assets/img/login.png" alt="Logo">
                    </div>
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <!-- <h1>Kaa Chonjo Dashboard</h1> -->
                            <h2>Sign in</h2>

                            <?php $form = ActiveForm::begin([
                                'id' => 'login-form',
                                'fieldConfig' => [
                                    'template' => "{label}\n{input}\n{error}",
                                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                                ],
                            ]); ?>

                            <form action="index.html">
                                <div class="form-group">
                                    <label>Email <span class="login-danger">*</span></label>
                                    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                                    <span class="profile-views"><i class="fas fa-user-circle"></i></span>
                                </div>
                                <div class="form-group">
                                    <label>Password <span class="login-danger">*</span></label>
                                    <?= $form->field($model, 'password')->passwordInput() ?>
                                    <span class="profile-views feather-eye toggle-password"></span>
                                </div>
                                <div class="forgotpass">
                                    <div class="remember-me">
                                        <?= $form->field($model, 'rememberMe')->checkbox([
                                            'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                                        ]) ?> <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Login</button>
                                </div>
                            </form>
                            <?php ActiveForm::end(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>