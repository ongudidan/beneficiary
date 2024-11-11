<?php

namespace app\jobs;

use app\modules\dashboard\models\ActivityReport;
use app\modules\dashboard\models\ExportFiles;
use Yii;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\base\BaseObject;
use yii\queue\JobInterface;
// use app\models\ActivityReport;
// use app\models\ExportFile;

class ExportJob extends BaseObject implements JobInterface
{
    public $activityId;
    public $exportId;

    public function execute($queue)
    {
        $export = ExportFiles::findOne($this->exportId);
        $uploadDir = Yii::getAlias('@webroot/exports/');

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
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

            $chunkSize = 1000;
            $offset = 0;
            $row = 2;
            $no = 1;

            while (true) {
                $dataProvider = ActivityReport::find()
                    ->where(['activity_id' => $this->activityId])
                    ->offset($offset)
                    ->limit($chunkSize)
                    ->all();

                if (empty($dataProvider)) {
                    break;
                }

                foreach ($dataProvider as $model) {
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
                        date('Y-m-d H:i:s', $model->created_at),
                        date('Y-m-d H:i:s', $model->updated_at),
                        Yii::$app->user->identity->username,
                    ], NULL, 'A' . $row++);
                    $no++;
                }

                unset($dataProvider);
                $offset += $chunkSize;
            }

            $filename = 'Activity_Reports_' . date('Y-m-d_H-i-s') . '.xlsx';
            $filepath = $uploadDir . $filename;
            $writer = new Xlsx($spreadsheet);
            $writer->save($filepath);

            $export->file_path = $filepath;
            $export->status = 'completed';
            $export->save();
        } catch (\Exception $e) {
            $export->status = 'failed';
            $export->save();
            Yii::error("Export failed for activity $this->activityId: " . $e->getMessage(), __METHOD__);
        }
    }
}
