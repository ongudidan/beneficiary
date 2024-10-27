<?php

namespace app\modules\dashboard\controllers;

use app\models\RoleForm;
use app\modules\dashboard\models\AuthRule;
use app\modules\dashboard\models\AuthRuleSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\rbac\DbManager;

/**
 * AuthRuleController implements the CRUD actions for AuthRule model.
 */
class AuthRuleController extends Controller
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
     * Lists all AuthRule models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AuthRuleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthRule model.
     * @param string $name Name
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($name)
    {
        return $this->render('view', [
            'model' => $this->findModel($name),
        ]);
    }

    /**
     * Creates a new AuthRule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // public function actionCreate()
    // {
    //     $model = new AuthRule();

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post()) && $model->save()) {
    //             return $this->redirect(['view', 'name' => $model->name]);
    //         }
    //     } else {
    //         $model->loadDefaultValues();
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    public function actionCreate()
    {
        $model = new AuthRule();
        $auth = Yii::$app->authManager; // Ensure authManager is configured correctly

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                // Add the new rule to the authManager
                $rule = new $model->name;
                $auth->add($rule);

                // Create and assign permissions based on form input (replace with actual permission data as needed)
                $permissions = Yii::$app->request->post('permissions', []);

                foreach ($permissions as $section => $actions) {
                    foreach ($actions as $action => $checked) {
                        if ($checked) {
                            // Construct permission name based on section and action
                            $permissionName = "{$section}-{$action}";
                            $permission = $auth->getPermission($permissionName) ?: $auth->createPermission($permissionName);
                            $permission->ruleName = $model->name;
                            $permission->description = ucfirst($action) . " " . ucfirst($section);

                            // Add permission and attach the rule if it doesn't exist
                            if (!$auth->getPermission($permissionName)) {
                                $auth->add($permission);
                            }

                            // Assign this permission to the rule
                            $role = $auth->getRole($section); // Adjust according to your role structure
                            $auth->addChild($role, $permission);
                        }
                    }
                }

                Yii::$app->session->setFlash('success', 'Rule and permissions assigned successfully.');
                return $this->redirect(['view', 'name' => $model->name]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing AuthRule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $name Name
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($name)
    {
        $model = $this->findModel($name);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'name' => $model->name]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AuthRule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $name Name
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($name)
    {
        $this->findModel($name)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthRule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $name Name
     * @return AuthRule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($name)
    {
        if (($model = AuthRule::findOne(['name' => $name])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
