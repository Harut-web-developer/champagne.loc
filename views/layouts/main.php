<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
//use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;
$session = Yii::$app->session;
AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
$sub_page = $this->params['sub_page'];
$date_tab = $this->params['date_tab'];


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
<!--    <title>--><?php //= Html::encode($this->title) ?><!--</title>-->
    <?php $this->head() ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/fonts/boxicons.css">
    <link rel="stylesheet" href="/css/core.css" class="template-customizer-core-css">
    <link rel="stylesheet" href="/css/theme-default.css" class="template-customizer-theme-css">
    <link rel="stylesheet" href="/css/demo.css">
    <link rel="stylesheet" href="/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="/css/apex-charts.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/css/price_range_style.css">
    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/helpers.js""></script>
    <script src="/js/config.js""></script>
    <?= Html::csrfMetaTags() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="bs-toast toast toast-placement-ex m-2 bg-secondary bottom-0 end-0 fade hide" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
    <div class="toast-header">
        <i class="bx bx-bell me-2"></i>
        <div class="me-auto fw-medium"></div>
        <small></small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body"></div>
</div>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" data-bg-class="bg-menu-theme">
<!--            <div class="app-brand demo logoLoc">-->
<!--                <a href="index.html" class="app-brand-link">-->
<!--              <span class="app-brand-logo demo">-->
<!--                  <img src="/img/logo.png">-->
<!--              </span>-->
<!--                    <span class="app-brand-text demo menu-text fw-bold ms-2">Champagne</span>-->
<!--                </a>-->
<!---->
<!--                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">-->
<!--                    <i class="bx bx-chevron-left bx-sm align-middle"></i>-->
<!--                </a>-->
<!--            </div>-->

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1 ps ps--active-y scrollMenu">
                <!-- Dashboards -->
                <li class="menu-item open">
                    <div class="dashboardName">
                        <img src="/img/logo.png">
<!--                        <i class="menu-icon tf-icons bx bx-home-circle"></i>-->
                        <div data-i18n="Dashboards"><a href="/dashboard">Dashboards</a></div>
                    </div>
                </li>
                <li class="menu-item open">
                    <ul class="menu-sub main_menu">
                        <li class="menu-item ">
                            <a href="/dashboard" class="menu-link">
                                <i class='bx bx-bar-chart-alt-2'></i>
                                <div data-i18n="Analytics">Վահանակ</div>
                            </a>
                        </li>
                        <li class="menu-item ">
                            <a href="/map" class="menu-link">
                                <i class='bx bx-map-alt'></i>
                                <div data-i18n="Analytics">Քարտեզ</div>
                            </a>
                        </li>
                        <li class="menu-item ">
                            <a href="/orders" class="menu-link">
                                <i class='bx bx-cart-add' ></i>
                                <div data-i18n="Analytics">Վաճառքներ</div>
                            </a>
                        </li>
                        <li class="menu-item" style="">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bx-building"></i>
                                <div data-i18n="warehouse">Պահեստներ</div>
                            </a>

                            <ul class="menu-sub sub_menu_sub">
                                <li class="menu-item">
                                    <a href="/documents" class="menu-link">
                                        <div data-i18n="documents">Փաստաթուղթ</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="/nomenclature" class="menu-link">
                                        <div data-i18n="nomenclature">Անվանակարգ</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="/products" class="menu-link">
                                        <div data-i18n="products">Ապրանքներ</div>
                                    </a>
                                </li>
                                <?php
                                if ($session['role_id'] == 1){
                                    ?>
                                    <li class="menu-item">
                                        <a href="/log" class="menu-link">
                                            <div data-i18n="log">Տեղեկամատյան</div>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>

                                <li class="menu-item">
                                    <a href="/warehouse" class="menu-link">
                                        <div data-i18n="Blank">Պահեստներ</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item" style="">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon bx bx-store-alt"></i>
                                <div data-i18n="clients">Հաճախորդներ</div>
                            </a>
                            <ul class="menu-sub sub_menu_sub">
                                <li class="menu-item">
                                    <a href="/groups-name" class="menu-link">
                                        <div data-i18n="groups-name">Խմբեր</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="/clients" class="menu-link">
                                        <div data-i18n="clients">Հաճախորդներ</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item" style="">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bx-male-female"></i>
                                <div data-i18n="users">Օգտատեր</div>
                            </a>

                            <ul class="menu-sub sub_menu_sub">
                                <li class="menu-item">
                                    <a href="/roles" class="menu-link">
                                        <div data-i18n="roles">Կարգավիճակ</div>
                                    </a>
                                </li>
<!--                                <li class="menu-item">-->
<!--                                    <a href="/premissions" class="menu-link">-->
<!--                                        <div data-i18n="premissions">Թույլտվություններ</div>-->
<!--                                    </a>-->
<!--                                </li>-->
                                <li class="menu-item">
                                    <a href="/users" class="menu-link">
                                        <div data-i18n="users">Օգտատեր</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="/manager-deliver-condition" class="menu-link">
                                        <div data-i18n="users">Մենեջեր-առաքիչ</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item" style="">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bx-money-withdraw"></i>
                                <div data-i18n="users">Վճարումներ</div>
                            </a>

                            <ul class="menu-sub sub_menu_sub">
                                <li class="menu-item">
                                    <a href="/payments" class="menu-link">
                                        <div data-i18n="roles">Վճարումներ</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="/payments/statistics" class="menu-link">
                                        <div data-i18n="premissions">Վիճակագրություն</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="/rates" class="menu-link">
                                        <div data-i18n="users">Փոխարժեք</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item" style="">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bxs-bank"></i>
                                <div data-i18n="users">Զեղչեր</div>
                            </a>
                            <ul class="menu-sub sub_menu_sub">
                                <li class="menu-item">
                                    <a href="/discount" class="menu-link">
                                        <div data-i18n="discount">Ակտիվ զեղչեր</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="/discount/inactive" class="menu-link">
                                        <div data-i18n="discount">Ոչ ակտիվ զեղչեր</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item ">
                            <a href="/route" class="menu-link">
                                <i class='bx bxs-direction-left'></i>
                                <div data-i18n="Analytics">Երթուղի</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div>
                <div class="ps__rail-y" style="top: 0px; height: 362px; right: 4px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 91px;"></div></div>
            </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="bx bx-menu bx-sm"></i>
                    </a>
                </div>

                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <!-- Search -->
                    <div class="navbar-nav align-items-center">
                        <div class="nav-item d-flex align-items-center">
                            <?php
                            $form = ActiveForm::begin([
                                'action' => ['/search/index'],
                                'method' => 'get',
                                'options' => ['class' => 'form-inline'], // Add Bootstrap form-inline class
                            ]);
                            ?>

                            <?= Html::csrfMetaTags() ?>

                            <div class="input-group"> <!-- Use Bootstrap input-group class -->
                                <?= Html::submitButton('', ['name' => 'submit', 'class' => 'bx bx-search fs-4 lh-0 searchicon']) ?>
                                <?= Html::textInput('searchQuery', null, ['class' => 'inputstyle form-control border-0 shadow-none ps-1 ps-sm-2']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>


                        </div>
                    </div>


                    <ul class="navbar-nav flex-row align-items-center ms-auto">
                        <!-- Place this tag where you want the button to render. -->
                        <li class="nav-item lh-1 me-3">
                            <div class="notifications-container">
                                <div class="bell-icon"><i id="notificationBell" class="bx bx-bell notificationIcon"></i>
                                    <span class="badge badge-light index_not"></span>
                                </div>
                                <div id="notifications-dropdown">
                                    <div class="notification-ui_dd-header">
                                        <h3 class="text-center">Notification</h3>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- User -->
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <i class='bx bxs-user userIcons'></i>
<!--                                    <img src="/img/avatars/1.png" alt="" class="w-px-40 h-auto rounded-circle">-->
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar avatar-online">
                                                    <i class='bx bxs-user userIcons'></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="fw-medium d-block"><?=$session['name']?></span>
                                                <small class="text-muted"><?=$session['username']?></small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/users/profile">
                                        <i class="bx bx-user me-2"></i>
                                        <span class="align-middle">Իմ պրոֆիլը</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bx bx-cog me-2"></i>
                                        <span class="align-middle">Կարգավորումներ</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                          <span class="flex-grow-1 align-middle ms-1">Վաճառք</span>
                          <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= Url::to(['site/logout']) ?>">
                                        <i class="bx bx-power-off me-2"></i>
                                        <span class="align-middle">Դուրս գալ</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--/ User -->
                    </ul>
                </div>
            </nav>
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <?php
                        if (!empty($sub_page)){
                            ?>
                            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
                                <div class="container-fluid">
                                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                        <?php
                                        foreach ($sub_page as $item){
                                            ?>
                                            <li class="nav-item">
                                                <a class="nav-link" aria-current="page" href="<?=$item['address']?>"><?=$item['name']?></a>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </nav>
                        <?php
                            }
                        if (!empty($date_tab)){
                        ?>
                        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
                            <div class="container-fluid">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <i class='bx bxs-log-out iconPrev' onclick="window.location = document.referrer"></i>
                                    </li>
                                    <li class="nav-item">
                                        <div class="btn-group">
                                            <button type="button" class="btn dropdown-toggle hide-arrow customBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                                Ընտրել
                                            </button>
                                            <form method="get" action="/dashboard/index">
                                                <ul class="dropdown-menu customUl" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 41px);" data-popper-placement="bottom-start">
                                                    <li><input name="start_date" type="date" class="start_date form-control"></li>
                                                    <li><input name="end_date" type="date" class="end_date form-control"></li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li class="iconBtn"><button class="customBtnIcon" type="submit"><i class='bx bx-search-alt-2 customIcon'></i></button></li>
                                                </ul>
                                            </form>
                                        </div>
                                    </li>
                                    <?php
                                    foreach ($date_tab as $item){
                                        ?>
                                        <li class="nav-item">
                                            <a class="nav-link" aria-current="page" href="<?=$item['address']?>"><?=$item['name']?></a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </nav>
                        <?php
                                }
                            ?>

                            <?= $content ?>
                </div>
                <!-- / Content -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


