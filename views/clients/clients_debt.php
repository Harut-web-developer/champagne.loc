<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Clients $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['sub_page'] = $sub_page;
\yii\web\YiiAsset::register($this);
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<div class="clients-view">
    <div class="card">
        <h5 class="card-header">Վիճակագրություն</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Պատվերի Համար</th>
                    <th>պատվԵՐԻ ԱՐԺԵՔ</th>
                    <th>ՎՃԱՐված ԳՈՒՄԱՐ</th>
                    <th>հաշվեկշիռ</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0 debtPaymentBody">
                <?php
                $debt_total = 0;
                foreach ($client_orders as $keys => $client_order){ ?>
                    <tr>
                        <td><?= $keys + 1 ?></td>
                        <td class="orderIdDebt"><?= $client_order['id'] ?></td>
                        <td><?= $client_order['debt'] ?></td>
                        <td id="payments"><?= $payments; ?></td>
                        <?php
                        if ($payments) {
                            if ($payments >= intval($client_order['debt'])) {
                                $balance_order = 0;
                                $payments -= intval($client_order['debt']);
                                $view_payments = intval($client_order['debt']);
                                ?>
                                <script>
                                    $(document).ready(function () {
                                        $("table").find("#payments").empty();
                                        document.getElementById("payments").innerHTML = <?= $view_payments; ?>;
                                    });
                                </script>
                                <?php
                            } else {
                                $balance_order =  intval($client_order['debt']) - $payments;
                                $debt_total += intval($client_order['debt']) - $payments;
                                $payments = 0;
                            }
                        } else {
                            $debt_total += intval($client_order['debt']) - $payments;
                        }
                        ?>

<!--                        <td>--><?php //= $view_payments; ?><!--</td>-->
                        <td class="balance"><?= (@$debt_total) ? $debt_total : @$balance_order ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--    <h1>--><?php //= Html::encode($this->title) ?><!--</h1>-->
    <!---->
    <!--    <p>-->
    <!--        --><?php //= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <!--        --><?php //= Html::a('Delete', ['delete', 'id' => $model->id], [
    //            'class' => 'btn btn-danger',
    //            'data' => [
    //                'confirm' => 'Are you sure you want to delete this item?',
    //                'method' => 'post',
    //            ],
    //        ]) ?>
    <!--    </p>-->
    <!---->
    <!--    --><?php //= DetailView::widget([
    //        'model' => $model,
    //        'attributes' => [
    //            'id',
    //            'route_id',
    //            'name',
    //            'location',
    //            'phone',
    //            'status',
    //            'created_at',
    //            'updated_at',
    //        ],
    //    ]) ?>

</div>
