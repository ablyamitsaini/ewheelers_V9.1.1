<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);


$data = array(
    'productFiltersArr' => empty($productFiltersArr) ? (object)array() : $productFiltersArr,
    'headerFormParamsAssocArr' => $headerFormParamsAssocArr,
    'categoriesArr' => $categoriesArr,
    'shopCatFilters' => $shopCatFilters,
    'prodcatArr' => $prodcatArr,
    'brandsArr' => $brandsArr,
    'brandsCheckedArr' => $brandsCheckedArr,
    'optionValueCheckedArr' => $optionValueCheckedArr,
    'conditionsArr' => $conditionsArr,
    'conditionsCheckedArr' => $conditionsCheckedArr,
    'options' => $options,
    'priceArr' => $priceArr,
    'priceInFilter' => $priceInFilter,
    'filterDefaultMinValue' => $filterDefaultMinValue,
    'filterDefaultMaxValue' => $filterDefaultMaxValue,
    'availability' => $availability,
    'availabilityArr' => $availabilityArr,
);


if (1 > count((array)$productFiltersArr)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
