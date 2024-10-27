<?php

namespace app\components; // Adjust this namespace as needed

use Yii;
use yii\helpers\FileHelper;

class AuthItemGenerator
{
    const TYPE_PERMISSION = 2; // Value for permissions in Yii2 RBAC.

    public function generateAuthItems()
    {
        $directories = [
            Yii::getAlias('@app/models'), // Main models directory
        ];

        // Add each module's `models` folder
        $modulesPath = Yii::getAlias('@app/modules');
        $moduleFolders = scandir($modulesPath);
        foreach ($moduleFolders as $moduleFolder) {
            if ($moduleFolder === '.' || $moduleFolder === '..') continue;

            $modelsPath = $modulesPath . DIRECTORY_SEPARATOR . $moduleFolder . DIRECTORY_SEPARATOR . 'models';
            if (is_dir($modelsPath)) {
                $directories[] = $modelsPath;
            }
        }

        foreach ($directories as $directory) {
            $this->processDirectory($directory);
        }

        Yii::$app->session->setFlash('success', 'Auth items generation completed.');
    }

    protected function processDirectory($directory)
    {
        $files = FileHelper::findFiles($directory, ['only' => ['*.php']]);

        foreach ($files as $file) {
            $modelName = pathinfo($file, PATHINFO_FILENAME);
            $actions = ['create', 'view', 'update', 'delete'];

            foreach ($actions as $action) {
                $itemName = "{$modelName}.{$action}";
                $description = ucfirst($action) . " permission for {$modelName}";
                $this->addAuthItem($itemName, $description, self::TYPE_PERMISSION);
            }
        }
    }

    protected function addAuthItem($name, $description, $type)
    {
        $authItem = (new \yii\db\Query())
            ->select('name')
            ->from('{{%auth_item}}')
            ->where(['name' => $name])
            ->scalar();

        if (!$authItem) {
            Yii::$app->db->createCommand()->insert('{{%auth_item}}', [
                'name' => $name,
                'type' => $type,
                'description' => $description,
                'created_at' => time(),
                'updated_at' => time(),
            ])->execute();
        }
    }
}
