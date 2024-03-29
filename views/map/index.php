<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->params['sub_page'] = $sub_page;
$this->params['date_tab'] = $date_tab;
$session = Yii::$app->session;
//echo "<pre>";
//var_dump($all_manager_ids);
//var_dump($session['user_id']);
//var_dump(in_array($session['user_id'],$all_manager_ids));
//die;
?>
<div class="titleAndPrevPage">
    <i class='bx bxs-log-out iconPrevPage' onclick="window.location = document.referrer"></i>
</div>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=e243c296-f6a7-46b7-950a-bd42eb4b2684" type="text/javascript"></script>
    <script src="/js/colorizer.js" type="text/javascript"></script>
    <script src="/js/multiroute_view_access.js?v=<?php echo rand(0,1000);?>" type="text/javascript"></script>
</head>

<body>
    <div class="form-group col-md-12 col-lg-12 col-sm-12 mapFilter">

        <?php if($session['role_id'] == 3) {?>
            <div class="form-group col-md-4 col-lg-4 col-sm-4 loguser">
                <label for="routeSelect">Երթուղի</label>
                <select id="routeSelect" class="form-select form-control valuemap" aria-label="Default select example">
                    <option value="">Ընտրել երթուղին</option>
                    <?php foreach ($route_deliver as $index => $deliver ){ ?>
                        <option value="<?= $deliver['route_id'] ?>"><?= $deliver['route'] ?></option>
                    <?php } ?>
                </select>
            </div>
        <?php } else {?>
            <div class="form-group col-md-4 col-lg-4 col-sm-4 loguser">
                <label for="routeSelect">Երթուղի</label>
                <select id="routeSelect" class="form-select form-control valuemap" aria-label="Default select example">
                    <option value="">Ընտրել երթուղին</option>
                    <?php foreach ($route as $index => $rout ){ ?>
                        <option value="<?= $rout['id'] ?>"><?= $rout['route'] ?></option>
                    <?php } ?>
                </select>
            </div>
        <?php } ?>

        <?php if($session['role_id'] == 1): ?>
            <div class="form-group col-md-4 col-lg-4 col-sm-4 logAction">
                <label for="myLocalDate">Ընտրել ամսաթիվը</label>
                <input id="myLocalDate" class="fil-input form-control valuemap" type="date" name="date">
            </div>
        <?php elseif($session['role_id'] == 2 || $session['role_id'] == 3): ?>
        <input type="hidden" id="myLocalDate" class="fil-input form-control valuemap" type="date" name="date">
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var today = new Date().toISOString().split('T')[0];
                    document.getElementById('myLocalDate').value = today;
                });
            </script>
        <?php endif; ?>

        <?php if($session['role_id'] == 1){ ?>
            <div class="form-group col-md-4 col-lg-4 col-sm-4 loguser">
                <label for="menegerSelect">Ընտրել մենեջերին</label>
                <select id="menegerSelect" class="form-select form-control mapManagerId" aria-label="Default select example">
                    <option value="">Ընտրել մենեջերին</option>
                    <?php foreach ($all_manager as $manager ){ ?>
                        <option value="<?= $manager['id'] ?>"><?= $manager['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        <?php } elseif($session['role_id'] == 2) {?>
            <input type="hidden" class="mapManagerId" value="<?= $session['user_id'] ?>">
        <?php } elseif($session['role_id'] == 3) { ?>
            <input type="hidden" class="araqichId" value="<?= $session['user_id'] ?>">
        <?php } ?>
    </div>
    <div id="map">
    </div>
</body>
<style>
    body, #map {
        width: 100%; height: 100%; padding: 0; margin: 0;
    }
</style>
