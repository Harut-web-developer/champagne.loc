<?php
use \app\models\OrderItems;
//var_dump($items);
//echo "<pre>";

//var_dump($order_items);
//exit();
?>
<div class="row">
    <div class="col mb-3">
        <span><?=$order_items['name']?></span>
        <input type="hidden" id="costModal" value="<?=$order_items['cost'] / $order_items['count']?>" class="form-control">
<!--        <input type="hidden" name="costBy" id="costByModal" value="--><?//=number_format($order_items['cost_by'],2,'.','')?><!--" class="form-control">-->
        <input type="hidden" class="itemsId" value="<?=$order_items['id']?>">
    </div>
</div>
<div class="row">
    <div class="col mb-3">
        <label for="countModal" class="form-label">Քանակ</label>
        <input type="number" id="countByModal" value="<?=$order_items['count_by']?>" max="<?=$order_items['count']?>" min="1" class="form-control">
        <input type="hidden" id="countModal" value="<?=$order_items['count']?>" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col mb-3">
        <label for="discountByModal" class="form-label">Զեղչի չափը</label>
<!--        <input type="hidden" readonly id="discountModal" value="--><?//=number_format($order_items['discount'] / $order_items['count'],2,'.','')?><!--" class="form-control">-->
        <input type="number" readonly id="discountByModal" value="<?=number_format($order_items['discount'] / $order_items['count'],2,'.','')?>" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col mb-3">
        <label for="beforePriceModal" class="form-label">Գինը մինչև զեղչելը</label>
        <input type="number" readonly id="beforePriceModal" value="<?=number_format($order_items['price_before_discount_by'] / $order_items['count_by'],2,'.','')?>" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col mb-3">
        <label for="priceModal" class="form-label">Զեղչված գինը</label>
        <input type="number" readonly id="priceModal" value="<?=number_format($order_items['price_by'] /  $order_items['count_by'],2,'.','')?>" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col mb-3">
        <label for="totalBeforePriceModal" class="form-label">Ընդհանուր գումար</label>
        <input type="number" readonly id="totalBeforePriceModal" value="<?=number_format($order_items['price_before_discount_by'],2,'.','')?>" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col mb-3">
        <label for="totalPriceModal" class="form-label">Ընդհանուր զեղչված գումար</label>
        <input type="number" readonly id="totalPriceModal" value="<?=number_format($order_items['price_by'],2,'.','') ?>" class="form-control">
    </div>
</div>

