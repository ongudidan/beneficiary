<?php

namespace app\modules\dashboard\controllers;

use app\components\IdGenerator;
use app\models\User;
use app\modules\dashboard\models\AuthAssignment;
use app\modules\dashboard\models\FieldOfficer;
use app\modules\dashboard\models\FieldOfficerSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FieldOfficerController implements the CRUD actions for FieldOfficer model.
 */
class FieldOfficerController extends Controller
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
     * Lists all FieldOfficer models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FieldOfficerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FieldOfficer model.
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
     * Creates a new FieldOfficer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new FieldOfficer();
        $user = new User();

        if ($this->request->isPost) {
            // Load the data into the FieldOfficer model
            if ($model->load($this->request->post())) {

                // Generate and set the unique ID
                $id = IdGenerator::generateUniqueId();
                $model->id = $id;

                // Use national_id as the username
                $username = $model->national_id;
                $password = 'ambassador';


                // Set User attributes
                $user->id = $id;
                $user->username = $username;
                $user->auth_key = Yii::$app->security->generateRandomString();
                $user->email = $model->email;
                $user->status = 10;
                $user->password_hash = Yii::$app->security->generatePasswordHash($password);  // Set password to hashed username

                // Start a transaction to ensure atomicity
                $transaction = Yii::$app->db->beginTransaction();

                try {
                    // Save the User model first
                    if ($user->save()) {
                        // Set the user_id for the FieldOfficer model
                        $model->user_id = $user->id;

                        // Save the FieldOfficer model
                        if ($model->save()) {
                            // Assign the 'officer' role to the new user
                            $authAssignment = new AuthAssignment();
                            $authAssignment->item_name = 'officer';
                            $authAssignment->user_id = $user->id;
                            $authAssignment->created_at = time();

                            if ($authAssignment->save()) {
                                // Commit the transaction
                                $transaction->commit();

                                Yii::$app->session->setFlash('success', 'Field officer created successfully and assigned officer role.');
                                return $this->redirect(['view', 'id' => $model->id]);
                            } else {
                                $transaction->rollBack();
                                Yii::$app->session->setFlash('error', 'Failed to assign officer role.');
                            }
                        } else {
                            $errors = implode('<br>', \yii\helpers\ArrayHelper::getColumn($model->getErrors(), 0));
                            $transaction->rollBack();
                            Yii::$app->session->setFlash('error', 'Failed to save field officer. Errors: <br>' . $errors);
                        }
                    } else {
                        $errors = implode('<br>', \yii\helpers\ArrayHelper::getColumn($user->getErrors(), 0));
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', 'Failed to save user. Errors: <br>' . $errors);
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
     * Updates an existing FieldOfficer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $user = User::findOne($model->user_id);  // Load the related User model

        if ($this->request->isPost && $model->load($this->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Update the email in the User model
                $user->email = $model->email;

                // Save both models in a transaction
                if ($model->save() && $user->save()) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Field officer and user email updated successfully.');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Failed to update field officer or user email.');
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'An error occurred: ' . $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing FieldOfficer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();

        $model = FieldOfficer::findOne($id);
        User::findOne($model->user_id)->delete();

        Yii::$app->session->setFlash('success', 'Field officer deleted successfully.');


        return $this->redirect(['index']);
    }

    /**
     * Finds the FieldOfficer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return FieldOfficer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FieldOfficer::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
