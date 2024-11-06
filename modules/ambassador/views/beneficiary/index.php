<?php

use app\modules\ambassador\models\Beneficiary;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\ambassador\models\BeneficiarySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Beneficiaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beneficiary-index">


    <div class="product-group-form">
        <div class="row">
            <form method="get" action="<?= Url::to(['/ambassador/beneficiary/index']) ?>">
                <div class="row">
                    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <input type="text" name="BeneficiarySearch[name]" class="form-control" placeholder="Beneficiary Name ..." value="<?= Html::encode($searchModel->name) ?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <input type="text" name="BeneficiarySearch[national_id]" class="form-control" placeholder="national ID ..." value="<?= Html::encode($searchModel->national_id) ?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <input type="text" name="BeneficiarySearch[contact]" class="form-control" placeholder=" Contact ..." value="<?= Html::encode($searchModel->contact) ?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <input type="text" name="BeneficiarySearch[sub_location]" class="form-control" placeholder="Sub-Location ..." value="<?= Html::encode($searchModel->sub_location) ?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <input type="text" name="BeneficiarySearch[village]" class="form-control" placeholder="Village ..." value="<?= Html::encode($searchModel->village) ?>">
                        </div>
                    </div>
                    <div class="col-lg-1">
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
                                <a href="<?= Url::to('/ambassador/beneficiary/create') ?>" class="btn btn-primary"><i
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
                                    <th>Sub-location</th>
                                    <th>Village</th>
                                    <th>Created At</th>
                                    <th class="text-center">Action</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($dataProvider->getCount() > 0): ?>
                                    <?php foreach ($dataProvider->getModels() as $index => $beneficiary): ?>
                                        <tr>
                                            <td><?= $dataProvider->pagination->page * $dataProvider->pagination->pageSize + $index + 1 ?></td>
                                            <td><?= Html::encode($beneficiary->name) ?></td>
                                            <td><?= Html::encode($beneficiary->national_id) ?></td>
                                            <td><?= Html::encode($beneficiary->contact) ?></td>
                                            <td><?= Html::encode($beneficiary->stove_no) ?></td>
                                            <td><?= Html::encode($beneficiary->sub_location) ?></td>
                                            <td><?= Html::encode($beneficiary->village) ?></td>
                                            <td><?= Yii::$app->formatter->asDatetime($beneficiary->created_at) ?></td>

                                            <td class="text-end">
                                                <div class="dropdown d-inline">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item has-icon" href="<?= Url::to(['/ambassador/beneficiary/view', 'id' => $beneficiary->id]) ?>">
                                                            <i class="feather-eye"></i> View
                                                        </a>
                                                        <a class="dropdown-item has-icon" href="<?= Url::to(['/ambassador/beneficiary/update', 'id' => $beneficiary->id]) ?>">
                                                            <i class="feather-eye"></i> Update
                                                        </a>
                                                        <a class="dropdown-item has-icon delete-btn" href="#" data-url="<?= Url::to(['/ambassador/beneficiary/delete', 'id' => $beneficiary->id]) ?>">
                                                            <i class="feather-trash"></i> Delete
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item has-icon" href="<?= Url::to(['/ambassador/beneficiary/report-create', 'beneficiary_id' => $beneficiary->id]) ?>">
                                                            <i class="feather-message-square"></i> Create report
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge <?= $beneficiary->status == 10 ? 'bg-success text-white rounded-pill' : 'bg-warning text-dark rounded-pill' ?>"
                                                    style="padding: 0.5rem 1rem; font-size: 1rem;">
                                                    <?= $beneficiary->status == 10 ? 'Active' : 'Inactive' ?>
                                                </span>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10" class="text-center">No data found</td>
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