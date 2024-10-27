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
        'url' => Url::to(['/dashboard/default/index']),
        'icon' => 'fas fa-tachometer-alt',  // Dashboard icon
        'module' => 'dashboard',
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
            // [
            //     'label' => 'Beneficiary settings',
            //     'url' => Url::to(['/dashboard/car-make/index']),
            //     'module' => 'dashboard',
            //     'controller' => 'car-make',
            //     'action' => 'index',
            // ],
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
        'label' => 'Coordinators',
        'icon' => 'fas fa-clipboard-list',  // Job Card icon
        'submenu' => true,
        'active' => $module === 'dashboard' && $controller === 'coordinator',
        'items' => [
            [
                'label' => 'coordinator List',
                'url' => Url::to(['/dashboard/coordinator/index']),
                'module' => 'dashboard',
                'controller' => 'coordinator',
                'action' => 'index',
            ],
            [
                'label' => 'Create coordinator',
                'url' => Url::to(['/dashboard/coordinator/create']),
                'module' => 'dashboard',
                'controller' => 'coordinator',
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
    [
        'label' => 'Ambassadors',
        'icon' => 'fas fa-clipboard-list',  // Job Card icon
        'submenu' => true,
        'active' => $module === 'dashboard' && $controller === 'ambassador',
        'items' => [
            [
                'label' => 'ambassador List',
                'url' => Url::to(['/dashboard/ambassador/index']),
                'module' => 'dashboard',
                'controller' => 'ambassador',
                'action' => 'index',
            ],
            [
                'label' => 'Create ambassador',
                'url' => Url::to(['/dashboard/ambassador/create']),
                'module' => 'dashboard',
                'controller' => 'ambassador',
                'action' => 'create',
            ],
        ]
    ],
    [
        'label' => 'Auth Rules',
        'icon' => 'fas fa-clipboard-list',  // Job Card icon
        'submenu' => true,
        'active' => $module === 'dashboard' && $controller === 'auth-rule',
        'items' => [
            [
                'label' => 'auth-rule List',
                'url' => Url::to(['/dashboard/auth-rule/index']),
                'module' => 'dashboard',
                'controller' => 'auth-rule',
                'action' => 'index',
            ],
            [
                'label' => 'Create auth-rule',
                'url' => Url::to(['/dashboard/auth-rule/create']),
                'module' => 'dashboard',
                'controller' => 'auth-rule',
                'action' => 'create',
            ],
        ]
    ],
    [
        'label' => 'Auth Item',
        'icon' => 'fas fa-clipboard-list',  // Job Card icon
        'submenu' => true,
        'active' => $module === 'dashboard' && $controller === 'auth-item',
        'items' => [
            [
                'label' => 'auth-item List',
                'url' => Url::to(['/dashboard/auth-item/index']),
                'module' => 'dashboard',
                'controller' => 'auth-item',
                'action' => 'index',
            ],
            [
                'label' => 'Create auth-item',
                'url' => Url::to(['/dashboard/auth-item/create']),
                'module' => 'dashboard',
                'controller' => 'auth-item',
                'action' => 'create',
            ],
        ]
    ],
    [
        'label' => 'Auth Item Child',
        'icon' => 'fas fa-clipboard-list',  // Job Card icon
        'submenu' => true,
        'active' => $module === 'dashboard' && $controller === 'auth-item-child',
        'items' => [
            [
                'label' => 'auth-item-child List',
                'url' => Url::to(['/dashboard/auth-item-child/index']),
                'module' => 'dashboard',
                'controller' => 'auth-item-child',
                'action' => 'index',
            ],
            [
                'label' => 'Create auth-item-child',
                'url' => Url::to(['/dashboard/auth-item-child/create']),
                'module' => 'dashboard',
                'controller' => 'auth-item-child',
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