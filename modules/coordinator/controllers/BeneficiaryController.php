<?php

namespace app\modules\coordinator\controllers;

use app\components\IdGenerator;
use app\modules\dashboard\models\Beneficiary;
use app\modules\coordinator\models\BeneficiarySearch;
use app\modules\dashboard\models\ActivityReport;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BeneficiaryController implements the CRUD actions for Beneficiary model.
 */
class BeneficiaryController extends Controller
{
    public $layout = 'DashboardLayout';

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
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

    /**
     * Displays a single Beneficiary model.
     * @param string $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Beneficiary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Beneficiary();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Beneficiary model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Beneficiary model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Beneficiary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return Beneficiary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Beneficiary::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /////////////////////////////////////////////

    /**
     * Displays a single ActivityReport model.
     * @param string $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionReportView($id)
    {
        $model = ActivityReport::findOne($id);

        return $this->render('/activity-report/view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new ActivityReport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionReportCreate()
    {
        $model = new ActivityReport();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->id = IdGenerator::generateUniqueId();
                // $model->reference_no = $model->generateReferenceNo();


                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Activity report created successfully.');

                    return $this->redirect(['beneficiary/report-view', 'id' => $model->id]);
                } else {
                    // Capture model errors and set a flash message
                    $errors = implode('<br>', \yii\helpers\ArrayHelper::getColumn($model->getErrors(), 0));
                    Yii::$app->session->setFlash('error', 'Failed to save the customer. Errors: <br>' . $errors);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('/activity-report/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ActivityReport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionReportUpdate($id)
    {
        // $model = $this->findModel($id);
        $model = ActivityReport::findOne($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', 'Activity report updated successfully.');

            return $this->redirect(['activity-report/view', 'id' => $model->id]);
        }

        return $this->render('/activity-report/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ActivityReport model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionReportDelete($id)
    {
        // $this->findModel($id)->delete();
        ActivityReport::findOne($id)->delete();
        
        Yii::$app->session->setFlash('success', 'Activity report deleted successfully.');


        return $this->redirect(['beneficiary/index']);
    }
}
