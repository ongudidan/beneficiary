<?php

use yii\helpers\Url;

// Get the current module, controller, and action
$module = Yii::$app->controller->module->id;
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;

// Define sidebar menu structure with module, controller, and action
$sidebarMenus = [
    [
        'label' => 'Dashboard',
        'url' => Url::to(['/officer/default/index']),
        'icon' => 'fas fa-tachometer-alt',  // Dashboard icon
        'module' => 'officer',
        'controller' => 'default',
        'action' => 'index',
    ],
    [
        'label' => 'Beneficiaries',
        'url' => Url::to(['/officer/beneficiary/index']),
        'icon' => 'fas fa-users',  // Beneficiaries icon
        'module' => 'officer',
        'controller' => 'beneficiary',
        'action' => 'index',
    ],
    [
        'label' => 'My Reports',
        'url' => Url::to(['/officer/activity-report/index']),
        'icon' => 'fas fa-file-alt',  // My Reports icon
        'module' => 'officer',
        'controller' => 'activity-report',
        'action' => 'index',
    ],
    [
        'label' => 'Ambassadors',
        'url' => Url::to(['/officer/ambassador/index']),
        'icon' => 'fas fa-user-tie',  // Ambassadors icon
        'module' => 'officer',
        'controller' => 'ambassador',
        'action' => 'index',
    ],
];


?>
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Officer Dashboard</span>
                </li>

                <?php foreach ($sidebarMenus as $menu): ?>
                    <?php if (isset($menu['submenu']) && $menu['submenu']): ?>
                        <!-- Submenu -->
                        <li class="submenu <?= $menu['active'] ? 'active' : '' ?>">
                            <a href="#"><i class="<?= $menu['icon'] ?>"></i> <span> <?= $menu['label'] ?> </span> <span class="menu-arrow"></span></a>
                            <ul>
                                <?php foreach ($menu['items'] as $subItem): ?>
                                    <li>
                                        <a href="<?= $subItem['url'] ?>"
                                            class="<?= ($module == $subItem['module'] && $controller == $subItem['controller']) ? 'active' : '' ?>">
                                            <?= $subItem['label'] ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Regular Menu -->
                        <li class="<?= ($module == $menu['module'] && $controller == $menu['controller']) ? 'active' : '' ?>">
                            <a href="<?= $menu['url'] ?>"><i class="<?= $menu['icon'] ?>"></i> <span> <?= $menu['label'] ?> </span></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>

            </ul>
        </div>
    </div>
</div>