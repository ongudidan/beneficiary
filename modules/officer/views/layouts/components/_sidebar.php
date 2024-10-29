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
        'icon' => 'fas fa-clipboard-list',  // Job Card icon
        'submenu' => true,
        'active' => $module === 'dashboard' && $controller === 'beneficiary',
        'items' => [
            [
                'label' => 'Beneficiary List',
                'url' => Url::to(['/dashboard/beneficiary/index']),
                'module' => 'dashboard',
                'controller' => 'beneficiary',
                'action' => 'index',
            ],
            [
                'label' => 'Create Beneficiary',
                'url' => Url::to(['/dashboard/beneficiary/create']),
                'module' => 'dashboard',
                'controller' => 'beneficiary',
                'action' => 'create',
            ],
        ]
    ],
    [
        'label' => 'Activities',
        'icon' => 'fas fa-clipboard-list',  // Job Card icon
        'submenu' => true,
        'active' => $module === 'dashboard' && $controller === 'activity',
        'items' => [
            [
                'label' => 'Activity List',
                'url' => Url::to(['/dashboard/activity/index']),
                'module' => 'dashboard',
                'controller' => 'activity',
                'action' => 'index',
            ],
            [
                'label' => 'Create activity',
                'url' => Url::to(['/dashboard/activity/create']),
                'module' => 'dashboard',
                'controller' => 'activity',
                'action' => 'create',
            ],
        ]
    ],
    [
        'label' => 'Field Officers',
        'icon' => 'fas fa-clipboard-list',  // Job Card icon
        'submenu' => true,
        'active' => $module === 'dashboard' && $controller === 'field-officer',
        'items' => [
            [
                'label' => 'field-officer List',
                'url' => Url::to(['/dashboard/field-officer/index']),
                'module' => 'dashboard',
                'controller' => 'field-officer',
                'action' => 'index',
            ],
            [
                'label' => 'Create field-officer',
                'url' => Url::to(['/dashboard/field-officer/create']),
                'module' => 'dashboard',
                'controller' => 'field-officer',
                'action' => 'create',
            ],
        ]
    ],
];

?>
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
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
                                            class="<?= ($module == $subItem['module'] && $controller == $subItem['controller'] && $action == $subItem['action']) ? 'active' : '' ?>">
                                            <?= $subItem['label'] ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Regular Menu -->
                        <li class="<?= ($module == $menu['module'] && $controller == $menu['controller'] && $action == $menu['action']) ? 'active' : '' ?>">
                            <a href="<?= $menu['url'] ?>"><i class="<?= $menu['icon'] ?>"></i> <span> <?= $menu['label'] ?> </span></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>

            </ul>
        </div>
    </div>
</div>