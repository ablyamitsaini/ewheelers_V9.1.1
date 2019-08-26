<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$conditions = array();
$conditionTitles = Product::getConditionArr($siteLangId);
foreach ($conditionsArr as $condition) {
    if ($condition['selprod_condition'] == 0) {
        continue;
    }
    $conditions[] = array(
        'title' => $conditionTitles[$condition['selprod_condition']],
        'value' => $condition['selprod_condition'],
    );
}

$data = array(
    'productFiltersArr' => empty($productFiltersArr) ? (object)array() : $productFiltersArr,
    'headerFormParamsAssocArr' => $headerFormParamsAssocArr,
    'categoriesArr' => $categoriesArr,
    'shopCatFilters' => $shopCatFilters,
    'prodcatArr' => $prodcatArr,
    'brandsArr' => $brandsArr,
    'brandsCheckedArr' => $brandsCheckedArr,
    'optionValueCheckedArr' => $optionValueCheckedArr,
    'conditionsArr' => $conditions,
    'conditionsCheckedArr' => $conditionsCheckedArr,
    'options' => $options,
    'priceArr' => $priceArr,
    'priceInFilter' => $priceInFilter,
    'filterDefaultMinValue' => $filterDefaultMinValue,
    'filterDefaultMaxValue' => $filterDefaultMaxValue,
    'availability' => $availability,
    'availabilityArr' => $availabilityArr,
);
