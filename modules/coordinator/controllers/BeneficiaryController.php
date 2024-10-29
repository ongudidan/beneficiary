<?php

namespace app\modules\coordinator\controllers;

use app\modules\dashboard\models\BeneficiarySearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class BeneficiaryController extends \yii\web\Controller
{
    public $layout = 'DashboardLayout';

    // public function actionIndex()
    // {
    //     return $this->render('index');
    // }


    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['logout', 'update', 'delete', 'create', 'view', 'index'],
                    'rules' => [
                        [
                            'actions' => ['logout', 'update', 'delete', 'create', 'view', 'index'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        // 'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }


    /**
     * Lists all Beneficiary models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BeneficiarySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
