<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Clients $model */

$this->title = 'Հաճախորդի դաշտերի կարգավորում';
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['sub_page'] = $sub_page;
$this->params['date_tab'] = $date_tab;

?>
<div class="clients-create">

    <div class="titleAndPrevPage">
        <i class='bx bxs-log-out iconPrevPage' onclick="window.location = document.referrer"></i>
        <h3><?= Html::encode($this->title) ?></h3>
    </div>

    <?= $this->render('_form_fields', [
        'model' => $model,
        'action__'=>'configure_filds',
    ]) ?>

</div>
