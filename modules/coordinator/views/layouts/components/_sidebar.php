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
        'url' => Url::to(['/coordinator/default/index']),
        'icon' => 'fas fa-tachometer-alt',  // Dashboard icon
        'module' => 'coordinator',
        'controller' => 'default',
        'action' => 'index',
    ],
    [
        'label' => 'Beneficiaries',
        'icon' => 'fas fa-clipboard-list',  // Job Card icon
        'submenu' => true,
        'active' => $module === 'coordinator' && $controller === 'beneficiary',
        'items' => [
            [
                'label' => 'Beneficiary List',
                'url' => Url::to(['/coordinator/beneficiary/index']),
                'module' => 'coordinator',
                'controller' => 'beneficiary',
                'action' => 'index',
            ],
        ]
    ],
    [
        'label' => 'Activities',
        'icon' => 'fas fa-clipboard-list',  // Job Card icon
        'submenu' => true,
        'active' => $module === 'coordinator' && $controller === 'activity',
        'items' => [
            [
                'label' => 'Activity List',
                'url' => Url::to(['/coordinator/activity/index']),
                'module' => 'coordinator',
                'controller' => 'activity',
                'action' => 'index',
            ],
        ]
    ],
    [
        'label' => 'Field Officers',
        'icon' => 'fas fa-clipboard-list',  // Job Card icon
        'submenu' => true,
        'active' => $module === 'coordinator' && $controller === 'field-officer',
        'items' => [
            [
                'label' => 'field-officer List',
                'url' => Url::to(['/coordinator/field-officer/index']),
                'module' => 'coordinator',
                'controller' => 'field-officer',
                'action' => 'index',
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