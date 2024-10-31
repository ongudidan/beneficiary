<?php

use app\modules\officer\models\ActivityReport;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\officer\models\ActivityReportSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Activity Reports';
$this->params['breadcrumbs'][] = $this->title;

$activityId = Yii::$app->request->get('id');

?>
<div class="activity-report-index">

    <div class="product-group-form">
        <div class="row">
            <form method="get" action="<?= Url::to(['/officer/activityReport/index']) ?>">
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
                                    <!-- <th>Status</th> -->
                                    <th class="text-end">Action</th>
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

                                            <td class="text-end">
                                                <div class="actions ">
                                                    <a href="<?= Url::to(['/officer/activity-report/view', 'id' => $activityReport->id]) ?>" class="btn btn-sm bg-success-light me-2 ">
                                                        <i class="feather-eye"></i>
                                                    </a>
                                                    <a href="<?= Url::to(['/officer/activity-report/update', 'id' => $activityReport->id]) ?>" class="btn btn-sm bg-danger-light">
                                                        <i class="feather-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm bg-danger-light delete-btn" data-url="<?= Url::to(['/officer/activity-report/delete', 'id' => $activityReport->id]) ?>">
                                                        <i class="feather-trash"></i>
                                                    </a>
                                                </div>
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