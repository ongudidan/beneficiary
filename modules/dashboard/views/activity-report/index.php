<?php

use app\modules\dashboard\models\ActivityReport;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\ActivityReportSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Activity Reports';
$this->params['breadcrumbs'][] = $this->title;

$activityId = Yii::$app->request->get('id');

?>
<div class="activity-report-index">

    <div class="product-group-form">
        <div class="row">
            <form method="get" action="<?= Url::to(['/dashboard/activityReport/index']) ?>">
                <div class="row">

                    <div class="col-lg-5 col-md-6">
                        <div class="form-group">
                            <input type="text" name="ActivityReportSearch[activity_id]" class="form-control" placeholder="Search by activityReport activity_id ..." value="<?= Html::encode($searchModel->activity_id) ?>">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="form-group">
                            <input type="text" name="ActivityReportSearch[created_by]" class="form-control" placeholder="Search by creator ..." value="<?= Html::encode($searchModel->created_by) ?>">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="search-student-btn">
                            <button type="submit" class="btn btn-primary">Search</button>
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
                                <a href="<?= Url::to(['/dashboard/activity-report/create', 'activity_id' => $activityId]) ?>" class="btn btn-primary"><i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="student-thread">
                                <tr>
                                    <th>#</th>
                                    <th>Activity No</th>
                                    <th>Beneficiary</th>
                                    <th>Usage</th>
                                    <th>Condition</th>
                                    <th>recommendation</th>
                                    <th>Remarks</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                    <th>Activity Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($dataProvider->getCount() > 0): // Check if there are any models 
                                ?>
                                    <?php foreach ($dataProvider->getModels() as $index => $activityReport): ?>
                                        <tr>
                                            <td><?= $dataProvider->pagination->page * $dataProvider->pagination->pageSize + $index + 1 ?></td>
                                            <td><?= $activityReport->activity->reference_no ?? '' ?></td>
                                            <td><?= $activityReport->beneficiary->name ?? '' ?></td>
                                            <td><?= $activityReport->usage ?></td>
                                            <td><?= $activityReport->condition ?></td>
                                            <td><?= $activityReport->recommendation ?></td>
                                            <td><?= $activityReport->remarks ?></td>

                                            <td><?= Yii::$app->formatter->asDatetime($activityReport->created_at) ?></td>

                                            <?php
                                            if (Yii::$app->controller->action->id === 'report-index') {
                                            ?>
                                                <!-- <td class="text-end">
                                                    <div class="actions ">
                                                        <a href="<?= Url::to(['/dashboard/activity/report-view', 'id' => $activityReport->id]) ?>" class="btn btn-sm bg-success-light me-2 ">
                                                            <i class="feather-eye"></i>
                                                        </a>
                                                        <a href="<?= Url::to(['/dashboard/activity/report-update', 'id' => $activityReport->id]) ?>" class="btn btn-sm bg-danger-light">
                                                            <i class="feather-edit"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-sm bg-danger-light delete-btn" data-url="<?= Url::to(['/dashboard/activity/report-delete', 'id' => $activityReport->id]) ?>">
                                                            <i class="feather-trash"></i>
                                                        </a>
                                                    </div>
                                                </td> -->
                                                <td>
                                                    <div class="dropdown d-inline">
                                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item has-icon" href="<?= Url::to(['/dashboard/activity/report-view', 'id' => $activityReport->id]) ?>">
                                                                <i class="feather-eye"></i> View
                                                            </a>
                                                            <?php if ($activityReport->activity->status == 10) { ?>

                                                                <a class="dropdown-item has-icon" href="<?= Url::to(['/dashboard/activity/report-update', 'id' => $activityReport->id]) ?>">
                                                                    <i class="feather-edit"></i> Update
                                                                </a>
                                                                <a class="dropdown-item has-icon delete-btn" href="#" data-url="<?= Url::to(['/dashboard/activity/report-delete', 'id' => $activityReport->id]) ?>">
                                                                    <i class="feather-trash"></i> Delete
                                                                </a>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </td>
                                            <?php } elseif (Yii::$app->controller->action->id === 'my-report') { ?>
                                                <!-- <td class="text-end">
                                                    <div class="actions ">
                                                        <a href="<?= Url::to(['/dashboard/activity-report/view', 'id' => $activityReport->id]) ?>" class="btn btn-sm bg-success-light me-2 ">
                                                            <i class="feather-eye"></i>
                                                        </a>
                                                        <a href="<?= Url::to(['/dashboard/activity-report/update', 'id' => $activityReport->id]) ?>" class="btn btn-sm bg-danger-light">
                                                            <i class="feather-edit"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-sm bg-danger-light delete-btn" data-url="<?= Url::to(['/dashboard/activity-report/delete', 'id' => $activityReport->id]) ?>">
                                                            <i class="feather-trash"></i>
                                                        </a>
                                                    </div>
                                                </td> -->
                                                <td>
                                                    <div class="dropdown d-inline">
                                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item has-icon" href="<?= Url::to(['/dashboard/activity-report/view', 'id' => $activityReport->id]) ?>">
                                                                <i class="feather-eye"></i> View
                                                            </a>
                                                            <?php if ($activityReport->activity->status == 10) { ?>

                                                                <a class="dropdown-item has-icon" href="<?= Url::to(['/dashboard/activity-report/update', 'id' => $activityReport->id]) ?>">
                                                                    <i class="feather-edit"></i> Update
                                                                </a>
                                                                <a class="dropdown-item has-icon delete-btn" href="#" data-url="<?= Url::to(['/dashboard/activity-report/delete', 'id' => $activityReport->id]) ?>">
                                                                    <i class="feather-trash"></i> Delete
                                                                </a>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                            <td>
                                                <?php if ($activityReport->activity->status == 10) { ?>
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

                </div>
            </div>
        </div>
    </div>



</div>