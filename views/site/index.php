<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="main-wrapper d-flex justify-content-center align-items-center min-vh-100 ">
        <div class="error-box text-center p-4 shadow rounded bg-white">
            <div class="display-4 text-danger"><i class="fas fa-ban"></i> Access Denied</div>
            <p class="h4 font-weight-light mb-4">It seems you haven't been assigned a role yet.</p>
            <p class="h5 font-weight-normal mb-4">Please contact your administrator to get assigned a role and gain access to the system.</p>
            <!-- <a href="/" class="btn btn-primary btn-lg">Back to Home</a> -->
        </div>
    </div>
</div>