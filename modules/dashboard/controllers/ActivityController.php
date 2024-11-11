<?php

namespace app\modules\dashboard\controllers;

use app\components\IdGenerator;
use app\models\User;
use app\modules\dashboard\models\Activity;
use app\modules\dashboard\models\ActivityReport;
use app\modules\dashboard\models\ActivityReportSearch;
use app\modules\dashboard\models\ActivitySearch;
use app\modules\dashboard\models\Ambassador;
use app\modules\dashboard\models\Coordinator;
use app\modules\dashboard\models\FieldOfficer;
use app\modules\dashboard\models\UserActivity;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ActivityController implements the CRUD actions for Activity model.
 */
class ActivityController extends Controller
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
     * Lists all Activity models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ActivitySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Activity model.
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
     * Creates a new Activity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Activity();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->id = IdGenerator::generateUniqueId();
                $model->reference_no = $model->generateReferenceNo();


                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Activity created successfully.');

                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    // Capture model errors and set a flash message
                    $errors = implode('<br>', \yii\helpers\ArrayHelper::getColumn($model->getErrors(), 0));
                    Yii::$app->session->setFlash('error', 'Failed to save the customer. Errors: <br>' . $errors);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Activity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Activity updated successfully.');

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Activity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Activity deleted successfully.');


        return $this->redirect(['index']);
    }

    /**
     * Finds the Activity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return Activity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Activity::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /////////////////////////////////////////////
    // public function actionReportIndex()
    // {
    //     $searchModel = new ActivityReportSearch();
    //     $dataProvider = $searchModel->search($this->request->queryParams);

    //     // Check if activity_id is present in the query parameters and apply the filter
    //     if ($activityId = $this->request->get('activity_id')) {
    //         $dataProvider->query->andWhere(['activity_id' => $activityId]);
    //     }

    //     return $this->render('/activity-report/index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    public function actionReportIndex()
    {
        $userId = Yii::$app->user->id; // Assuming the user is logged in
        $searchModel = new ActivityReportSearch();

        // Check if activity_id is provided in the URL
        $activityId = $this->request->get('activity_id');
        if ($activityId) {
            // Save or update the activity_id in the user_activity table
            $userActivity = UserActivity::findOne(['user_id' => $userId]) ?? new UserActivity();
            $userActivity->user_id = $userId;
            $userActivity->activity_id = $activityId;
            $userActivity->save();
        } else {
            // Retrieve the saved activity_id for the user if not in the URL
            $userActivity = UserActivity::findOne(['user_id' => $userId]);
            $activityId = $userActivity ? $userActivity->activity_id : null;
        }

        // Filter directly in the query without passing to queryParams
        $dataProvider = $searchModel->search($this->request->queryParams);

        if ($activityId) {
            $dataProvider->query->andWhere(['activity_id' => $activityId]);
        }

        return $this->render('/activity-report/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



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

            return $this->redirect(['activity/report-view', 'id' => $model->id]);
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


        return $this->redirect(['activity/index']);
    }

    public function actionExport($id)
    {

        $uploadDir = Yii::getAlias('@webroot/exports/'); // Define the path to the exports folder

        // Clear the exports folder
        $this->clearExportsFolder($uploadDir);

        ini_set('memory_limit', '51200M'); // Increase memory limit if necessary
        set_time_limit(300000); // Increase execution time

        // Fetch data for export (modify as needed)
        $dataProvider = ActivityReport::find()->where(['activity_id' => $id])->all(); // Adjust query to fit your needs

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header row (customize as needed)
        $headers = [
            'NO',
            'NAME',
            'ID NO',
            'TEL NO',
            'SUB-LOCATION',
            'VILLAGE',
            'STOVE NO',
            'DATE OF ISSUE',
            'LAT',
            'LONG',
            'IN USE/NOT IN USE',
            // 'REASON FOR NOT IN USE',
            'AUDIO',
            'PHOTO',
            'RECOMMENDATION',
            'REMARKS',
            'CREATED AT',
            'UPDATED AT',
            'CREATED BY',
            'UPDATED BY',
        ];
        $sheet->fromArray($headers, NULL, 'A1');
        $no = 1;
        // Fill the sheet with data
        $row = 2; // Start from the second row
        foreach ($dataProvider as $model) {
            // $no++;
            $sheet->fromArray([
                $no,
                $model->beneficiary->name,
                $model->beneficiary->national_id,
                $model->beneficiary->contact,
                $model->beneficiary->subLocation->name,
                $model->beneficiary->villages->name,
                $model->beneficiary->stove_no,
                $model->beneficiary->issue_date,
                $model->beneficiary->lat,
                $model->beneficiary->long,
                $model->usage,
                $model->audio ? 'Available' : 'N/A',
                $model->photo ? 'Available' : 'N/A',
                $model->recommendation,
                $model->remarks,
                date('Y-m-d H:i:s', $model->created_at), // Format timestamps
                date('Y-m-d H:i:s', $model->updated_at), // Format timestamps
                // User::findOne($model->created_by)->username,
                // User::findOne($model->updated_by)->username,
                $this->getPersonNameById($model->created_by),
                $this->getPersonNameById($model->updated_by),


            ], NULL, 'A' . $row++);
            $no++;
        }

        // Save the spreadsheet to a file on the server
        $uploadDir = Yii::getAlias('@webroot/exports/'); // Specify your directory to save the file
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Create directory if it doesn't exist
        }
        $filename = 'Activity_Reports_' . date('Y-m-d_H-i-s') . '.xlsx'; // Generate a unique filename
        $filepath = $uploadDir . $filename;

        $writer = new Xlsx($spreadsheet);
        $writer->save($filepath);

        // Return the filename for the download link
        return $this->redirect(['download', 'filename' => $filename]);
    }


    private function getPersonNameById($id)
    {
        $coordinator = Coordinator::findOne($id);
        if ($coordinator) {
            return $coordinator->name; // Adjust field name as necessary
        }

        $ambassador = Ambassador::findOne($id);
        if ($ambassador) {
            return $ambassador->name; // Adjust field name as necessary
        }

        $fieldOfficer = FieldOfficer::findOne($id);
        if ($fieldOfficer) {
            return $fieldOfficer->name; // Adjust field name as necessary
        }

        // If no match is found, check the User table
        $user = User::findOne($id);
        return $user ? $user->username : null; // Adjust field name as necessary
    }

    public function actionClearExports()
    {
        $uploadDir = Yii::getAlias('@webroot/exports/'); // Define the path to the exports folder

        // Clear the exports folder
        $this->clearExportsFolder($uploadDir);

        // Set a flash message to notify the user
        Yii::$app->session->setFlash('success', 'The exports folder has been cleared successfully.');

        return $this->redirect(['index']); // Redirect to the index or desired page
    }

    // Function to clear all files in the exports directory
    private function clearExportsFolder($path)
    {
        $files = glob($path . '*'); // Get all files in the directory
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file); // Delete the file
            }
        }
    }

    // New action for downloading the file
    public function actionDownload($filename)
    {
        $filepath = Yii::getAlias('@webroot/exports/' . $filename);

        if (file_exists($filepath)) {
            // Set headers for download
            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath); // Read the file
            exit; // Terminate the script
        } else {
            throw new NotFoundHttpException("The requested file does not exist.");
        }
    }


}
