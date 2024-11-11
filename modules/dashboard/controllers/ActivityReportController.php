<?php

namespace app\modules\dashboard\controllers;

use app\components\IdGenerator;
use app\modules\dashboard\models\ActivityReport;
use app\modules\dashboard\models\ActivityReportSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ActivityReportController implements the CRUD actions for ActivityReport model.
 */
class ActivityReportController extends Controller
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
                        // 'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ActivityReport models.
     *
     * @return string
     */
    // public function actionIndex()
    // {
    //     $searchModel = new ActivityReportSearch();
    //     $dataProvider = $searchModel->search($this->request->queryParams);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    public function actionIndex()
    {
        $searchModel = new ActivityReportSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        // Check if activity_id is present in the query parameters and apply the filter
        if ($activityId = $this->request->get('activity_id')) {
            $dataProvider->query->andWhere(['activity_id' => $activityId]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

public function actionMyReport()
{
    $searchModel = new ActivityReportSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);

    // Check if logged-in user_id is present in the query parameters and apply the filter
    if ($userId = Yii::$app->user->id) {
        // Explicitly reference the 'created_by' field from the 'activity_report' table to avoid ambiguity
        $dataProvider->query->andWhere(['activity_report.created_by' => $userId]);
    }

    return $this->render('index', [
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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ActivityReport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
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
                        return $this->render('create', ['model' => $model]);
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
                    return $this->redirect(['view', 'id' => $model->id]);
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

        return $this->render('create', [
            'model' => $model,
            'activity_id' => $activityId ?? '',
        ]);
    }



    /**
     * Updates an existing ActivityReport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

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
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    // Capture model errors and set a flash message
                    $errors = implode('<br>', \yii\helpers\ArrayHelper::getColumn($model->getErrors(), 0));
                    Yii::$app->session->setFlash('error', 'Failed to save the activity report. Errors: <br>' . $errors);
                    Yii::error('Model save failed: ' . $errors);
                }
            }
        }

        return $this->render('update', [
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
    public function actionDelete($id)
    {
        // Find the model based on the ID
        $model = $this->findModel($id);

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

        return $this->redirect(['index']);
    }


    /**
     * Finds the ActivityReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return ActivityReport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ActivityReport::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
