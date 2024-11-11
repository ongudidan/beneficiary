<?php

use app\modules\dashboard\models\Activity;
use kartik\date\DatePicker;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\ActivitySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Activities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-index">


    <div class="product-group-form">
        <div class="row">
            <form method="get" action="<?= Url::to(['/dashboard/activity/index']) ?>">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <input type="text" name="ActivitySearch[reference_no]" class="form-control form-control-lg" placeholder="Search by reference no ..." value="<?= Html::encode($searchModel->reference_no) ?>">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" name="ActivitySearch[name]" class="form-control form-control-lg" placeholder="Search by name ..." value="<?= Html::encode($searchModel->name) ?>">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <?= DatePicker::widget([
                                'name' => 'ActivitySearch[start_date]',
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd/mm/yyyy',  // Date format
                                ],
                                'options' => [
                                    'class' => 'form-control form-control-lg',  // Ensuring same height as other inputs
                                    'placeholder' => 'Search by start date'
                                ]
                            ]); ?>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="search-student-btn">
                            <button type="submit" class="btn btn-primary btn-lg">Search</button> <!-- Ensure button is the same height -->
                        </div>
                    </div>
                </div>
            </form>


        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table comman-shadow">
                <div class="card-body">
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col-auto text-end float-end ms-auto download-grp">
                                <a href="<?= Url::to('/dashboard/activity/create') ?>" class="btn btn-primary"><i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="student-thread">
                                <tr>
                                    <th>#</th>
                                    <th>Reference No</th>
                                    <th>Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($dataProvider->getCount() > 0): // Check if there are any models 
                                ?>
                                    <?php foreach ($dataProvider->getModels() as $index => $activity): ?>
                                        <tr>
                                            <td><?= $dataProvider->pagination->page * $dataProvider->pagination->pageSize + $index + 1 ?></td>
                                            <td><?= $activity->reference_no ?></td>
                                            <td><?= $activity->name ?></td>
                                            <td><?= $activity->start_date ?></td>
                                            <td><?= $activity->end_date ?></td>
                                            <td><?= Yii::$app->formatter->asDatetime($activity->created_at) ?></td>
                                                                                     
                                            <td>
                                                <div class="dropdown d-inline">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item has-icon" href="<?= Url::to(['/dashboard/activity/view', 'id' => $activity->id]) ?>">
                                                            <i class="feather-eye"></i> View
                                                        </a>
                                                        <a class="dropdown-item has-icon" href="<?= Url::to(['/dashboard/activity/update', 'id' => $activity->id]) ?>">
                                                            <i class="feather-edit"></i> Update
                                                        </a>
                                                        <a class="dropdown-item has-icon delete-btn" href="#" data-url="<?= Url::to(['/dashboard/activity/delete', 'id' => $activity->id]) ?>">
                                                            <i class="feather-trash"></i> Delete
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item has-icon" href="<?= Url::to(['/dashboard/activity/report-index', 'activity_id' => $activity->id]) ?>">
                                                            <i class="feather-message-square"></i> View Activity reports
                                                        </a>
                                                        <a class="dropdown-item has-icon" href="<?= Url::to(['/dashboard/activity/export', 'id' => $activity->id]) ?>">
                                                            <i class="feather-message-square"></i> Export to Exel
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if ($activity->status == 10) { ?>
                                                    <span class="badge bg-success text-white rounded-pill" title="Active" style="padding: 0.5rem 1rem; font-size: 1rem;">
                                                        <i class="feather-check-circle"></i> Active
                                                    </span>
                                                <?php } else { ?>
                                                    <span class="badge bg-warning text-dark rounded-pill" title="Closed" style="padding: 0.5rem 1rem; font-size: 1rem;">
                                                        <i class="feather-x-circle"></i> Closed
                                                    </span>
                                                <?php } ?>
                                            </td>


                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: // If no models found 
                                ?>
                                    <tr>
                                        <td colspan="10" class="text-center">No data found</td> <!-- Adjust colspan based on your table -->
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                        </table>
                        <!-- Pagination inside the table container -->
                        <div class="pagination-wrapper mt-3">
                            <?= \app\components\CustomLinkPager::widget([
                                'pagination' => $dataProvider->pagination,
                                'options' => ['class' => 'pagination justify-content-center mb-4'],
                                'linkOptions' => ['class' => 'page-link'],
                                'activePageCssClass' => 'active',
                                'disabledPageCssClass' => 'disabled',
                                'prevPageLabel' => '<span aria-hidden="true">«</span><span class="sr-only">Previous</span>',
                                'nextPageLabel' => '<span aria-hidden="true">»</span><span class="sr-only">Next</span>',
                            ]); ?>
                        </div>
                    </div>

                    <!-- pagination
                    <div>
                        <ul class="pagination mb-4">
                            <?= LinkPager::widget([
                                'pagination' => $dataProvider->pagination,
                                'options' => ['class' => 'pagination mb-4'],
                                'linkOptions' => ['class' => 'page-link'],
                                'activePageCssClass' => 'active',
                                'disabledPageCssClass' => 'disabled',
                                'prevPageLabel' => '<span aria-hidden="true">«</span><span class="sr-only">Previous</span>',
                                'nextPageLabel' => '<span aria-hidden="true">»</span><span class="sr-only">Next</span>',
                                // 'firstPageLabel' => '1', // You can customize this if needed
                                // 'lastPageLabel' => 'Last', // You can customize this if needed
                            ]); ?>
                        </ul>
                    </div> -->
                </div>
            </div>
        </div>
    </div>


</div>

<script>
    async function exportLargeFile(activityId) {
        // Create a new workbook and add headers
        const workbook = XLSX.utils.book_new();
        const worksheet = XLSX.utils.aoa_to_sheet([
            [
                'NO', 'NAME', 'ID NO', 'TEL NO', 'SUB-LOCATION', 'VILLAGE',
                'STOVE NO', 'DATE OF ISSUE', 'LAT', 'LONG', 'IN USE/NOT IN USE',
                'AUDIO', 'PHOTO', 'RECOMMENDATION', 'REMARKS',
                'CREATED AT', 'UPDATED AT', 'CREATED BY', 'UPDATED BY'
            ]
        ]);
        XLSX.utils.book_append_sheet(workbook, worksheet, "ActivityReport");

        let offset = 0;
        const chunkSize = 1000;

        // Fetch data in chunks
        while (true) {
            try {
                const response = await fetch(`/controller/get-activity-data-chunk?id=${activityId}&offset=${offset}&limit=${chunkSize}`);
                const data = await response.json();

                if (data.length === 0) break;

                const rows = data.map(row => [
                    row.no,
                    row.name,
                    row.national_id,
                    row.contact,
                    row.sub_location,
                    row.village,
                    row.stove_no,
                    row.issue_date,
                    row.lat,
                    row.long,
                    row.usage,
                    row.audio,
                    row.photo,
                    row.recommendation,
                    row.remarks,
                    row.created_at,
                    row.updated_at,
                    row.created_by,
                    row.updated_by
                ]);

                XLSX.utils.sheet_add_aoa(worksheet, rows, {
                    origin: -1
                });
                offset += chunkSize;
            } catch (error) {
                console.error("Error fetching data:", error);
                break;
            }
        }

        // Export workbook as Excel file
        XLSX.writeFile(workbook, `Activity_Report_${activityId}.xlsx`);
    }
</script>