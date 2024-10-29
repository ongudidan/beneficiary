<?php

namespace app\modules\dashboard\controllers;

use app\components\IdGenerator;
use app\models\User;
use app\modules\dashboard\models\Coordinator;
use app\modules\dashboard\models\CoordinatorSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CoordinatorController implements the CRUD actions for Coordinator model.
 */
class CoordinatorController extends Controller
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
     * Lists all Coordinator models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CoordinatorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Coordinator model.
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
     * Creates a new Coordinator model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Coordinator();
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
                            Yii::$app->session->setFlash('success', 'Coordinator created successfully.');

                            return $this->redirect(['view', 'id' => $model->id]);
                        } else {
                            $errors = implode('<br>', \yii\helpers\ArrayHelper::getColumn($model->getErrors(), 0));

                            $transaction->rollBack();
                            Yii::$app->session->setFlash('error', 'Failed to save coordinator Errors: <br>' . $errors);
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
     * Updates an existing Coordinator model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Coordinator updated successfully.');

            
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Coordinator model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();

        $model = Coordinator::findOne($id);
        User::findOne($model->user_id)->delete();

        Yii::$app->session->setFlash('success', 'Coordinator deleted successfully.');


        return $this->redirect(['index']);
    }

    /**
     * Finds the Coordinator model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return Coordinator the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Coordinator::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
