<?php

use yii\helpers\Url;
?>
<div class="header">

    <div class="header-left">
        <a href="<?= Url::to('/officer') ?>" class="logo">
            <img src="/web/img/logo-demo5.svg" alt="Logo">
        </a>
        <a href="<?= Url::to('/officer') ?>" class="logo logo-small">
            <img src="/web/img/logo-small.png" alt="Logo" width="30" height="30">
        </a>
    </div>

    <div class="menu-toggle">
        <a href="javascript:void(0);" id="toggle_btn">
            <i class="fas fa-bars"></i>
        </a>
    </div>
    <!-- 
    <div class="top-nav-search">
        <form>
            <input type="text" class="form-control" placeholder="Search here">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div> -->


    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>


    <ul class="nav user-menu">

        <li class="nav-item dropdown has-arrow new-user-menus">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" src="/web/img/avatar-01.jpg" width="31"
                        alt="Soeng Souy">
                    <div class="user-text">
                        <h6><?= Yii::$app->user->identity->username ?? 'Guest' ?></h6>
                        <p class="text-muted mb-0">Administrator</p>
                    </div>
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="user-header">
                    <div class="avatar avatar-sm">
                        <img src="/web/img/avatar-01.jpg" alt="User Image"
                            class="avatar-img rounded-circle">
                    </div>
                    <div class="user-text">
                        <h6><?= Yii::$app->user->identity->username ?? 'Guest' ?></h6>
                        <p class="text-muted mb-0">Administrator</p>
                    </div>
                </div>
                <a class="dropdown-item" href="<?= Url::to(['/ambassador/default/index']) ?>">Ambassador Dashboard</a>
                <a class="dropdown-item" href="<?= Url::to(['/officer/default/index']) ?>">Officer Dashboard</a>
                <a class="dropdown-item" href="<?= Url::to(['/coordinator/default/index']) ?>">Coordinator Dasboard</a>
                <a class="dropdown-item" href="<?= Url::to(['/dashboard/default/index']) ?>">Admin Dashboard</a>

                <!-- <a class="dropdown-item" href="inbox.html">Inbox</a> -->
                <a class="dropdown-item" href="<?= Url::to('/site/logout') ?>">Logout</a>
            </div>
        </li>

    </ul>

</div>