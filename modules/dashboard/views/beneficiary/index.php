<?php

use app\modules\dashboard\models\Beneficiary;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\BeneficiarySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Beneficiaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beneficiary-index">


    <div class="product-group-form">
        <div class="row">
            <form method="get" action="<?= Url::to(['/dashboard/beneficiary/index']) ?>">
                <div class="row">

                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" name="BeneficiarySearch[name]" class="form-control" placeholder="Search by Beneficiary Name ..." value="<?= Html::encode($searchModel->name) ?>">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" name="BeneficiarySearch[national_id]" class="form-control" placeholder="Search by national ID ..." value="<?= Html::encode($searchModel->national_id) ?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <input type="text" name="BeneficiarySearch[contact]" class="form-control" placeholder="Search by  Contact ..." value="<?= Html::encode($searchModel->contact) ?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <input type="text" name="BeneficiarySearch[stove_no]" class="form-control" placeholder="Search by Stove Number ..." value="<?= Html::encode($searchModel->stove_no) ?>">
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
                                <a href="<?= Url::to('/dashboard/beneficiary/create') ?>" class="btn btn-primary"><i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="student-thread">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>National ID</th>
                                    <th>Contact</th>
                                    <th>Stove No</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($dataProvider->getCount() > 0): // Check if there are any models 
                                ?>
                                    <?php foreach ($dataProvider->getModels() as $index => $beneficiary): ?>
                                        <tr>
                                            <td><?= $dataProvider->pagination->page * $dataProvider->pagination->pageSize + $index + 1 ?></td>
                                            <td><?= $beneficiary->name ?></td>
                                            <td><?= $beneficiary->national_id ?></td>
                                            <td><?= $beneficiary->contact ?></td>
                                            <td><?= $beneficiary->stove_no ?></td>
                                            <td><?= Yii::$app->formatter->asDatetime($beneficiary->created_at) ?></td>
                                            <?php if ($beneficiary->status == 10) { ?>
                                                <td>
                                                    <span class="badge badge-success">Active</span>
                                                </td>
                                            <?php } else { ?>
                                                <td>
                                                    <span class="badge badge-warning">Inactive</span>
                                                </td>
                                            <?php } ?>
                                            <td class="text-end">
                                                <div class="actions ">
                                                    <a href="<?= Url::to(['/dashboard/beneficiary/view', 'id' => $beneficiary->id]) ?>" class="btn btn-sm bg-success-light me-2 ">
                                                        <i class="feather-eye"></i>
                                                    </a>
                                                    <a href="<?= Url::to(['/dashboard/beneficiary/update', 'id' => $beneficiary->id]) ?>" class="btn btn-sm bg-danger-light">
                                                        <i class="feather-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm bg-danger-light delete-btn" data-url="<?= Url::to(['/dashboard/beneficiary/delete', 'id' => $beneficiary->id]) ?>">
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
                    </div>

                    <!-- pagination -->
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
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>