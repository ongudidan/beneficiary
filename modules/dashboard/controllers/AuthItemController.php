<?php

namespace app\modules\dashboard\controllers;

use Faker\Factory as Faker;

use app\components\AuthItemChildGenerator;
use app\components\AuthItemForm;
use app\components\AuthItemGenerator;
use app\components\IdGenerator;
use app\models\User;
use app\modules\dashboard\models\Ambassador;
use app\modules\dashboard\models\AuthAssignment;
use app\modules\dashboard\models\AuthItem;
use app\modules\dashboard\models\AuthItemSearch;
use app\modules\dashboard\models\Beneficiary;
use app\modules\dashboard\models\Coordinator;
use app\modules\dashboard\models\FieldOfficer;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\HttpException;

/**
 * AuthItemController implements the CRUD actions for AuthItem model.
 */
class AuthItemController extends Controller
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
     * Lists all AuthItem models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->query->andWhere(['type' => 1]);

        // // Drop all data from auth_item and auth_item_child tables
        // Yii::$app->db->createCommand()->delete('auth_item_child')->execute();
        // Yii::$app->db->createCommand()->delete('auth_item')->execute();

        // // Generate auth items if they don't exist
        // $authItemGenerator = new AuthItemGenerator();
        // $authItemGenerator->generateAuthItems();

        // // Generate auth item children
        // $authItemChildGenerator = new AuthItemChildGenerator();
        // $authItemChildGenerator->generateAuthItemChildren();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionItemGenerator()
    {
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->query->andWhere(['type' => 1]);

        // // Drop all data from auth_item and auth_item_child tables
        Yii::$app->db->createCommand()->delete('auth_item_child')->execute();
        // Yii::$app->db->createCommand()->delete('auth_item')->execute();

        // // Generate auth items if they don't exist
        $authItemGenerator = new AuthItemGenerator();
        $authItemGenerator->generateAuthItems();


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionImportAmbassadors()
    {
        ini_set('memory_limit', '5120M'); // Adjust this limit based on your system
        set_time_limit(300); // Set maximum execution time to 300 seconds (5 minutes), adjust as needed


        Yii::$app->db->createCommand()->delete('ambassador')->execute();


        // Load the spreadsheet file
        $spreadsheet = IOFactory::load('ALL BENEFICIARIES - APRIL -24.xlsx');
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        // Create a Faker instance
        $faker = Faker::create();

        // Create an array to keep track of already inserted ambassadors
        $insertedAmbassadors = [];

        // Second pass to insert ambassadors
        foreach ($data as $index => $row) {
            if ($index < 4) {
                continue;
            }

            $fieldOfficer = strtoupper($row[13] ?? 'Undefined');
            $ambassador = strtoupper($row[12] ?? 'Undefined');


            $fieldOfficerId = FieldOfficer::findOne(['name' => $fieldOfficer])->id;

            // Check if the ambassador has already been inserted
            if (!in_array($ambassador, $insertedAmbassadors)) {

                // Generate unique values for additional fields
                $id = IdGenerator::generateUniqueId();
                $nationalId = uniqid('NID-', true);
                $email = $faker->unique()->safeEmail; // Generate unique email using Faker
                $phoneNo = '+254' . rand(700000000, 799999999); // Random phone number
                $createdAt = time();
                $updatedAt = time();
                $createdBy = User::find()->where(['username' => 'admin'])->one()->id;
                $updatedBy = $createdBy;
                $password = 'password';


                // Insert user record
                $user = new User();
                $user->id = $id;
                $user->username = $nationalId;
                $user->email = $email;
                $user->auth_key = Yii::$app->security->generateRandomString();
                $user->password_hash = Yii::$app->security->generatePasswordHash($password);
                $user->status = 10;
                $user->created_at = $createdAt;
                $user->updated_at = $updatedAt;

                if ($user->save()) {
                    // Insert into ambassador table
                    $ambassadorModel = new Ambassador();
                    $ambassadorModel->id = $id;
                    $ambassadorModel->name = $ambassador;
                    $ambassadorModel->user_id = $id;
                    $ambassadorModel->field_officer_id = $fieldOfficerId;
                    $ambassadorModel->national_id = $nationalId;
                    $ambassadorModel->email = $email;
                    $ambassadorModel->phone_no = $phoneNo;
                    $ambassadorModel->status = 10;
                    $ambassadorModel->created_at = $createdAt;
                    $ambassadorModel->updated_at = $updatedAt;
                    $ambassadorModel->created_by = $createdBy;
                    $ambassadorModel->updated_by = $updatedBy;

                    $ambassadorModel->save();

                    // Track the ambassador
                    $insertedAmbassadors[] = $ambassador;
                }
            }
        }

        // Set a success flash message
        Yii::$app->session->setFlash('success', 'Ambassadors imported successfully.');
        return $this->redirect(['index']); // Redirect to the index or desired page
    }


    public function actionAssignRoles()
    {
        // Define the item names for the roles
        $officerItem = 'officer';
        $coordinatorItem = 'coordinator';
        $ambassadorItem = 'ambassador';

        // Fetch all field officers from the field_officer table
        $fieldOfficers = FieldOfficer::find()->all();
        // Fetch all coordinators from the coordinator table
        $coordinators = Coordinator::find()->all();
        // Fetch all ambassadors from the ambassador table
        $ambassadors = Ambassador::find()->all();

        // Prepare to track successfully assigned roles
        $assignedFieldOfficers = [];
        $failedFieldOfficerAssignments = [];
        $assignedCoordinators = [];
        $failedCoordinatorAssignments = [];
        $assignedAmbassadors = [];
        $failedAmbassadorAssignments = [];

        // Assign roles to field officers
        foreach ($fieldOfficers as $fieldOfficer) {
            $userId = $fieldOfficer->user_id; // Assuming the field officer has a user ID

            // Check if the assignment already exists
            $existingAssignment = AuthAssignment::find()
                ->where(['item_name' => $officerItem, 'user_id' => $userId])
                ->exists();

            if (!$existingAssignment) {
                // Create a new assignment for field officer
                $assignment = new AuthAssignment();
                $assignment->item_name = $officerItem;
                $assignment->user_id = $userId;
                $assignment->created_at = time(); // Set created_at to current time

                if ($assignment->save()) {
                    $assignedFieldOfficers[] = $userId; // Track successfully assigned field officers
                } else {
                    $failedFieldOfficerAssignments[] = $userId; // Track failed assignments
                }
            }
        }

        // Assign roles to coordinators
        foreach ($coordinators as $coordinator) {
            $userId = $coordinator->user_id; // Assuming the coordinator has a user ID

            // Check if the assignment already exists
            $existingAssignment = AuthAssignment::find()
                ->where(['item_name' => $coordinatorItem, 'user_id' => $userId])
                ->exists();

            if (!$existingAssignment) {
                // Create a new assignment for coordinator
                $assignment = new AuthAssignment();
                $assignment->item_name = $coordinatorItem;
                $assignment->user_id = $userId;
                $assignment->created_at = time(); // Set created_at to current time

                if ($assignment->save()) {
                    $assignedCoordinators[] = $userId; // Track successfully assigned coordinators
                } else {
                    $failedCoordinatorAssignments[] = $userId; // Track failed assignments
                }
            }
        }

        // Assign roles to ambassadors
        foreach ($ambassadors as $ambassador) {
            $userId = $ambassador->user_id; // Assuming the ambassador has a user ID

            // Check if the assignment already exists
            $existingAssignment = AuthAssignment::find()
                ->where(['item_name' => $ambassadorItem, 'user_id' => $userId])
                ->exists();

            if (!$existingAssignment) {
                // Create a new assignment for ambassador
                $assignment = new AuthAssignment();
                $assignment->item_name = $ambassadorItem;
                $assignment->user_id = $userId;
                $assignment->created_at = time(); // Set created_at to current time

                if ($assignment->save()) {
                    $assignedAmbassadors[] = $userId; // Track successfully assigned ambassadors
                } else {
                    $failedAmbassadorAssignments[] = $userId; // Track failed assignments
                }
            }
        }

        // Set flash messages for user feedback
        if (!empty($assignedFieldOfficers)) {
            Yii::$app->session->setFlash('success', 'Field officers assigned successfully: ' . implode(', ', $assignedFieldOfficers));
        }
        if (!empty($failedFieldOfficerAssignments)) {
            Yii::$app->session->setFlash('error', 'Failed to assign the following field officers: ' . implode(', ', $failedFieldOfficerAssignments));
        }
        if (!empty($assignedCoordinators)) {
            Yii::$app->session->setFlash('success', 'Coordinators assigned successfully: ' . implode(', ', $assignedCoordinators));
        }
        if (!empty($failedCoordinatorAssignments)) {
            Yii::$app->session->setFlash('error', 'Failed to assign the following coordinators: ' . implode(', ', $failedCoordinatorAssignments));
        }
        if (!empty($assignedAmbassadors)) {
            Yii::$app->session->setFlash('success', 'Ambassadors assigned successfully: ' . implode(', ', $assignedAmbassadors));
        }
        if (!empty($failedAmbassadorAssignments)) {
            Yii::$app->session->setFlash('error', 'Failed to assign the following ambassadors: ' . implode(', ', $failedAmbassadorAssignments));
        }

        // Redirect to an appropriate page, e.g., index or another relevant action
        return $this->redirect(['index']);
    }



    public function actionExport()
    {

        $uploadDir = Yii::getAlias('@webroot/exports/'); // Define the path to the exports folder

        // Clear the exports folder
        $this->clearExportsFolder($uploadDir);

        ini_set('memory_limit', '512M'); // Increase memory limit if necessary
        set_time_limit(0); // Increase execution time

        // Fetch data for export (modify as needed)
        $dataProvider = Beneficiary::find()->all(); // Adjust query to fit your needs

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header row (customize as needed)
        $headers = [
            'Sub Location',
            'Village ID',
            'Name',
            'National ID',
            'Contact',
            'Sub Location',
            'Village',
            'Stove No',
            'Issue Date',
            'Latitude',
            'Longitude',
            'Status',
            'Created At',
            'Updated At',
            'Created By',
            'Updated By',
        ];
        $sheet->fromArray($headers, NULL, 'A1');

        // Fill the sheet with data
        $row = 2; // Start from the second row
        foreach ($dataProvider as $model) {
            $sheet->fromArray([
                $model->subLocation->name,
                $model->villages->name,
                $model->name,
                $model->national_id,
                $model->contact,
                $model->stove_no,
                $model->issue_date,
                $model->lat,
                $model->long,
                $model->status,
                date('Y-m-d H:i:s', $model->created_at), // Format timestamps
                date('Y-m-d H:i:s', $model->updated_at), // Format timestamps
                $this->getPersonNameById($model->created_by),
                $this->getPersonNameById($model->updated_by),
            ], NULL, 'A' . $row++);
        }

        // Save the spreadsheet to a file on the server
        $uploadDir = Yii::getAlias('@webroot/exports/'); // Specify your directory to save the file
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Create directory if it doesn't exist
        }
        $filename = 'Beneficiaries_' . date('Y-m-d_H-i-s') . '.xlsx'; // Generate a unique filename
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




    /**
     * Displays a single AuthItem model.
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
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // public function actionCreate()
    // {
    //     $model = new AuthItem();

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
        $model = new AuthItemForm();
        $auth = Yii::$app->authManager;

        // Group permissions by model name
        $permissions = $auth->getPermissions();
        $authItemsGrouped = [];

        foreach ($permissions as $permission) {
            // Assuming permission names follow the 'ModelName-action' convention
            list($modelName, $action) = explode('-', $permission->name, 2);

            // Group by model name
            $authItemsGrouped[$modelName][$action] = $permission->name;
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $parent = $auth->createRole($model->name);
            $parent->description = $model->description;
            $auth->add($parent);

            foreach ($model->children as $childName) {
                $child = $auth->getPermission($childName);
                if ($child) {
                    $auth->addChild($parent, $child);
                }
            }

            Yii::$app->session->setFlash('success', 'Parent item created and children assigned.');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'authItemsGrouped' => $authItemsGrouped,
        ]);
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $name Name
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($name)
    // {
    //     $model = $this->findModel($name);

    //     if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'name' => $model->name]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    public function actionUpdate($name)
    {
        $modelData = AuthItem::findOne($name); // Fetch the existing auth item

        if (!$modelData || $modelData->type !== 1) {
            throw new NotFoundHttpException("The requested auth item does not exist or is not a parent item.");
        }

        // Create a new instance of the form model
        $model = new AuthItemForm();

        // Populate the form model with the retrieved data
        $model->name = $modelData->name; // Name of the parent item
        $model->description = $modelData->description; // Description of the parent item

        // Get existing child permissions for the parent auth item
        $auth = Yii::$app->authManager;
        $existingChildren = $auth->getChildren($model->name);
        $assignedChildren = array_keys($existingChildren); // Array of assigned child item names

        // Set the model's children with currently assigned children
        $model->children = $assignedChildren;

        // Retrieve auth items of type 2 (permissions) to display in the form
        $authItems = AuthItem::find()->where(['type' => 2])->all();

        // Organize auth items by model name for grouped display
        $authItemsGrouped = [];
        foreach ($authItems as $item) {
            [$modelName, $action] = explode('-', $item->name);
            $authItemsGrouped[$modelName][$action] = $item->name;
        }

        // Process form submission
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Update parent auth item
                $authItem = $auth->getRole($model->name) ?? $auth->createRole($model->name);
                $authItem->name = $model->name; // Set new name
                $authItem->description = $model->description; // Set new description if needed
                $auth->update($authItem->name, $authItem); // Update the auth item in the database

                // Update child permissions
                $auth->removeChildren($authItem); // Clear current children
                foreach ($model->children as $childName) {
                    $child = $auth->getPermission($childName);
                    if ($child) {
                        $auth->addChild($authItem, $child); // Add new children
                    }
                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Role updated successfully.');
                return $this->redirect(['index']);
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Failed to update role. Please try again.');
            }
        }

        return $this->render('update', [
            'model' => $model, // Pass the populated model to the view
            'authItemsGrouped' => $authItemsGrouped, // Now this variable is defined
        ]);
    }



    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $name Name
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($name)
    {
        $this->findModel($name)->delete();

        Yii::$app->session->setFlash('success', 'Role updated successfully.');


        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $name Name
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($name)
    {
        if (($model = AuthItem::findOne(['name' => $name])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
