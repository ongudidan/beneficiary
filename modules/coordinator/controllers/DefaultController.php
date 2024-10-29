<?php

namespace app\modules\coordinator\controllers;

use yii\web\Controller;

/**
 * Default controller for the `coordinator` module
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
