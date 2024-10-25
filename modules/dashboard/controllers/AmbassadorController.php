<?php

namespace app\modules\dashboard\controllers;

use app\components\IdGenerator;
use app\models\User;
use app\modules\dashboard\models\Ambassador;
use app\modules\dashboard\models\AmbassadorSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AmbassadorController implements the CRUD actions for Ambassador model.
 */
class AmbassadorController extends Controller
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
     * Lists all Ambassador models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AmbassadorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ambassador model.
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
     * Creates a new Ambassador model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Ambassador();
        $user = new User();

        if ($this->request->isPost) {
            // Load the data into the Students model
            if ($model->load($this->request->post())) {

                // Generate and set the staff number
                $id = IdGenerator::generateUniqueId();
                $model->id = $id;

                // Extract staff number from the Students model
                $username = $model->national_id;

                // Set User attributes
                $user->id = $id;
                $user->username = $username;
                $user->auth_key = Yii::$app->security->generateRandomString();
                $user->email = $model->email;
                $user->password_hash = Yii::$app->security->generatePasswordHash($username);  // Set password to hashed username

                // Use a transaction to ensure both models are saved successfully
                $transaction = Yii::$app->db->beginTransaction();

                try {
                    // Save the User model first
                    if ($user->save()) {
                        // Set the student_id for the User model
                        $model->user_id = $user->id; // Assuming user_id is the primary key of the Users model

                        // Save the Students model
                        if ($model->save()) {
                            $transaction->commit();

                            Yii::$app->session->setFlash('success', 'Ambassador created successfully.');

                            return $this->redirect(['view', 'id' => $model->id]);
                        } else {
                            $errors = implode('<br>', \yii\helpers\ArrayHelper::getColumn($model->getErrors(), 0));

                            $transaction->rollBack();
                            Yii::$app->session->setFlash('error', 'Failed to save ambassador Errors: <br>' . $errors);
                        }
                    } else {
                        $errors = implode('<br>', \yii\helpers\ArrayHelper::getColumn($user->getErrors(), 0));

                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', 'Failed to save userErrors: <br>' . $errors);
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'An error occurred: ' . $e->getMessage());
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
     * Updates an existing Ambassador model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Ambassador updated successfully.');

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Ambassador model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();
        $model = Ambassador::findOne($id);
        User::findOne($model->user_id)->delete();

        Yii::$app->session->setFlash('success', 'Ambassador deleted successfully.');


        return $this->redirect(['index']);
    }

    /**
     * Finds the Ambassador model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return Ambassador the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ambassador::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
