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

$optionRows = array();
foreach ($options as $opt) {
    $optionRows[] = [
        'option_id' => $opt['option_id'],
        'option_is_color' => $opt['option_is_color'],
        'option_name' => $opt['option_name'],
        'values' => [
            'optionvalue_name' => $opt['optionvalue_name'],
            'optionvalue_id' => $opt['optionvalue_id'],
            'optionvalue_color_code' => $opt['optionvalue_color_code'],
        ],
    ];
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
    'options' => $optionRows,
    'priceArr' => $priceArr,
    'priceInFilter' => $priceInFilter,
    'filterDefaultMinValue' => $filterDefaultMinValue,
    'filterDefaultMaxValue' => $filterDefaultMaxValue,
    'availability' => $availability,
    'availabilityArr' => $availabilityArr,
);
