<?php

namespace app\modules\dashboard\controllers;

use app\components\IdGenerator;
use app\modules\dashboard\models\ActivityReport;
use app\modules\dashboard\models\Beneficiary;
use app\modules\dashboard\models\BeneficiarySearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

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
            if ($model->load($this->request->post())) {
                $model->id = IdGenerator::generateUniqueId();

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Beneficiary created successfully.');

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
     * Updates an existing Beneficiary model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Beneficiary updated successfully.');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    // Capture model errors and set a flash message
                    $errors = implode('<br>', \yii\helpers\ArrayHelper::getColumn($model->getErrors(), 0));
                    Yii::$app->session->setFlash('error', 'Failed to update the beneficiary. Errors: <br>' . $errors);
                }
            }
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

        Yii::$app->session->setFlash('success', 'Beneficiary deleted successfully.');


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
                // Retrieve file instances from the request
                $model->audioFile = UploadedFile::getInstance($model, 'audioFile');
                $model->photoFile = UploadedFile::getInstance($model, 'photoFile');

                $model->id = IdGenerator::generateUniqueId();

                // Set up the uploads directory
                $uploadsDir = Yii::getAlias('@webroot/uploads');
                if (!is_dir($uploadsDir)) {
                    if (!mkdir($uploadsDir, 0777, true) && !is_dir($uploadsDir)) {
                        Yii::$app->session->setFlash('error', 'Failed to create uploads directory.');
                        return $this->render('/activity-report/create', ['model' => $model]);
                    }
                }

                // Handle photo file upload
                if ($model->photoFile) {
                    $photoName = uniqid('photo_') . '.' . $model->photoFile->extension;
                    $photoPath = $uploadsDir . '/' . $photoName;

                    if ($model->photoFile->saveAs($photoPath)) {
                        $model->photo = 'uploads/' . $photoName; // Save relative path
                    } else {
                        Yii::$app->session->setFlash('error', 'Failed to upload photo file.');
                        Yii::error('Photo file upload failed for path: ' . $photoPath);
                    }
                }

                // Handle audio file upload
                if ($model->audioFile) {
                    $audioName = uniqid('audio_') . '.' . $model->audioFile->extension;
                    $audioPath = $uploadsDir . '/' . $audioName;

                    if ($model->audioFile->saveAs($audioPath)) {
                        $model->audio = 'uploads/' . $audioName; // Save relative path
                    } else {
                        Yii::$app->session->setFlash('error', 'Failed to upload audio file.');
                        Yii::error('Audio file upload failed for path: ' . $audioPath);
                    }
                }

                // Attempt to save the model after handling file uploads
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Activity report created successfully.');
                    return $this->redirect(['beneficiary/report-view', 'id' => $model->id]);
                } else {
                    // Capture model errors and set a flash message
                    $errors = implode('<br>', \yii\helpers\ArrayHelper::getColumn($model->getErrors(), 0));
                    Yii::$app->session->setFlash('error', 'Failed to save the activity report. Errors: <br>' . $errors);
                    Yii::error('Model save failed: ' . $errors);
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
        $model = ActivityReport::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException('The requested activity report does not exist.');
        }

        if ($this->request->isPost) {
            // Load the model data from POST
            if ($model->load($this->request->post())) {
                // Retrieve the new file instances
                $model->audioFile = UploadedFile::getInstance($model, 'audioFile');
                $model->photoFile = UploadedFile::getInstance($model, 'photoFile');

                // Set up the uploads directory
                $uploadsDir = Yii::getAlias('@webroot/uploads');

                // Handle photo file upload
                if ($model->photoFile) {
                    // Delete the old photo file if it exists
                    if ($model->photo) {
                        $oldPhotoPath = Yii::getAlias('@webroot/' . $model->photo);
                        if (file_exists($oldPhotoPath)) {
                            unlink($oldPhotoPath);
                        }
                    }

                    // Save the new photo file
                    $photoName = uniqid('photo_') . '.' . $model->photoFile->extension;
                    $photoPath = $uploadsDir . '/' . $photoName;

                    if ($model->photoFile->saveAs($photoPath)) {
                        $model->photo = 'uploads/' . $photoName; // Save the relative path
                    } else {
                        Yii::$app->session->setFlash('error', 'Failed to upload new photo file.');
                        Yii::error('New photo file upload failed for path: ' . $photoPath);
                    }
                }

                // Handle audio file upload
                if ($model->audioFile) {
                    // Delete the old audio file if it exists
                    if ($model->audio) {
                        $oldAudioPath = Yii::getAlias('@webroot/' . $model->audio);
                        if (file_exists($oldAudioPath)) {
                            unlink($oldAudioPath);
                        }
                    }

                    // Save the new audio file
                    $audioName = uniqid('audio_') . '.' . $model->audioFile->extension;
                    $audioPath = $uploadsDir . '/' . $audioName;

                    if ($model->audioFile->saveAs($audioPath)) {
                        $model->audio = 'uploads/' . $audioName; // Save the relative path
                    } else {
                        Yii::$app->session->setFlash('error', 'Failed to upload new audio file.');
                        Yii::error('New audio file upload failed for path: ' . $audioPath);
                    }
                }

                // Attempt to save the model after handling file uploads
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Activity report updated successfully.');
                    return $this->redirect(['activity-report/view', 'id' => $model->id]);
                } else {
                    // Capture model errors and set a flash message
                    $errors = implode('<br>', \yii\helpers\ArrayHelper::getColumn($model->getErrors(), 0));
                    Yii::$app->session->setFlash('error', 'Failed to save the activity report. Errors: <br>' . $errors);
                    Yii::error('Model save failed: ' . $errors);
                }
            }
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
        // Find the model based on the ID
        $model = ActivityReport::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException('The requested activity report does not exist.');
        }

        // Delete the associated photo file if it exists
        if ($model->photo) {
            $oldPhotoPath = Yii::getAlias('@webroot/' . $model->photo);
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
        }

        // Delete the associated audio file if it exists
        if ($model->audio) {
            $oldAudioPath = Yii::getAlias('@webroot/' . $model->audio);
            if (file_exists($oldAudioPath)) {
                unlink($oldAudioPath);
            }
        }

        // Now delete the model from the database
        $model->delete();

        Yii::$app->session->setFlash('success', 'Activity report deleted successfully.');

        return $this->redirect(['/wactivity-report/index']);
    }

}
