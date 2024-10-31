<?php

use app\modules\coordinator\models\FieldOfficer;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\coordinator\models\FieldOfficerSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Field Officers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="field-officer-index">

    <div class="product-group-form">
        <div class="row">
            <form method="get" action="<?= Url::to(['/coordinator/field-officer/index']) ?>">
                <div class="row">

                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" name="FieldOfficer[name]" class="form-control" placeholder="Search by name ..." value="<?= Html::encode($searchModel->name) ?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <input type="text" name="FieldOfficer[national_id]" class="form-control" placeholder="Search by National ID ..." value="<?= Html::encode($searchModel->national_id) ?>">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" name="FieldOfficer[email]" class="form-control" placeholder="Search by  email ..." value="<?= Html::encode($searchModel->email) ?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <input type="text" name="FieldOfficer[phone_no]" class="form-control" placeholder="Search by  phone_no ..." value="<?= Html::encode($searchModel->phone_no) ?>">
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
                                    <th>Name</th>
                                    <th>ID number</th>
                                    <th>Email</th>
                                    <th>Phone No</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($dataProvider->getCount() > 0): // Check if there are any models 
                                ?>
                                    <?php foreach ($dataProvider->getModels() as $index => $field_officer): ?>
                                        <tr>
                                            <td><?= $dataProvider->pagination->page * $dataProvider->pagination->pageSize + $index + 1 ?></td>
                                            <td><?= $field_officer->name ?></td>
                                            <td><?= $field_officer->national_id ?></td>
                                            <td><?= $field_officer->email ?></td>
                                            <td><?= $field_officer->phone_no ?></td>
                                            <td><?= Yii::$app->formatter->asDatetime($field_officer->created_at) ?></td>
                                            <?php if ($field_officer->status == 10) { ?>
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
                                                    <a href="<?= Url::to(['/coordinator/field-officer/view', 'id' => $field_officer->id]) ?>" class="btn btn-sm bg-success-light me-2 ">
                                                        <i class="feather-eye"></i>
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