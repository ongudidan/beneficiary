<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'css/site.css',
        "/web/css/bootstrap.min.css",
        "/web/css/feather.css",
        "/web/css/flags.css",
        "/web/css/fontawesome.min.css",
        "/web/css/all.min.css",
        "/web/css/style.css",
        "/web/css/datatables.min.css",
        "https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css",

        "/web/css/toatr.css"


    ];
    public $js = [
        // "/web/dashboard/assets/js/jquery-3.6.0.min.js",
        "/web/js/bootstrap.bundle.min.js",
        "/web/js/feather.min.js",
        "/web/js/jquery.slimscroll.min.js",
        "/web/js/apexcharts.min.js",
        "/web/js/chart-data.js",
        "/web/js/datatables.min.js",
        "/web/js/sweetalert.min.js",
        "/web/js/custom.js",
        // "https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js",

        "/web/js/toastr.min.js",
        "/web/js/toastr.js",

        "/web/js/script.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
