<?php

namespace app\modules\officer\controllers;

use yii\web\Controller;

/**
 * Default controller for the `officer` module
 */
class DefaultController extends Controller
{
    public $layout = 'DashboardLayout';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
