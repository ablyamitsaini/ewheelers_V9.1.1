<?php
class BrandsController extends MyAppController
{
    public function __construct($action)
    {
        parent::__construct($action);
    }
    
    public function index() 
    {
        $brandSrch = Brand::getListingObj($this->siteLangId, array( 'brand_id', 'IFNULL(brand_name, brand_identifier) as brand_name'), true);
        $brandSrch->doNotCalculateRecords();
        $brandSrch->doNotLimitRecords();
        $brandSrch->addOrder('brand_name', 'asc');        
        $brandRs = $brandSrch->getResultSet();
        $brandsArr = FatApp::getDb()->fetchAll($brandRs);
        /* CommonHelper::printArray($brandsArr);die; */
        $this->set('layoutDirection', Language::getLayoutDirection($this->siteLangId));        
        $this->set('allBrands', $brandsArr);
        $this->_template->render();
    }
    
    public function all()
    {
        FatApp::redirectUser(CommonHelper::generateUrl('Brands'));
    }
    
    public function view( $brandId )
    { 
        $brandId = FatUtility::int($brandId);
        Brand::recordBrandWeightage($brandId);
        $db = FatApp::getDb();

        $this->includeProductPageJsCss();
        $frm = $this->getProductSearchForm();    
        
        $headerFormParamsArr = FatApp::getParameters();
        $headerFormParamsAssocArr = Product::convertArrToSrchFiltersAssocArr($headerFormParamsArr);
        
        /* if(array_key_exists('currency',$headerFormParamsAssocArr)){
        $headerFormParamsAssocArr['currency_id'] = $headerFormParamsAssocArr['currency'];
        }
        if(array_key_exists('sort',$headerFormParamsAssocArr)){
        $headerFormParamsAssocArr['sortOrder'] = $headerFormParamsAssocArr['sort'];
        }
        if(array_key_exists('shop',$headerFormParamsAssocArr)){
        $headerFormParamsAssocArr['shop_id'] = $headerFormParamsAssocArr['shop'];
        }	
        if(array_key_exists('collection',$headerFormParamsAssocArr)){
        $headerFormParamsAssocArr['collection_id'] = $headerFormParamsAssocArr['collection'];
        } */
        $headerFormParamsAssocArr['join_price'] = 1;    
        $frm->fill($headerFormParamsAssocArr);
                
        $prodSrchObj = new ProductSearch($this->siteLangId);
        $prodSrchObj->setDefinedCriteria(0);
        $prodSrchObj->joinProductToCategory();
        $prodSrchObj->joinSellerSubscription();
        $prodSrchObj->addSubscriptionValidCondition();
        $prodSrchObj->doNotCalculateRecords();
        $prodSrchObj->setPageSize(FatApp::getConfig('CONF_PAGE_SIZE', FatUtility::VAR_INT, 10));
        
        if($brandId > 0) {
            $prodSrchObj->addBrandCondition($brandId);
        }
        $rs = $prodSrchObj->getResultSet();
        $record = FatApp::getDb()->fetch($rs);
        /* Brand Filters Data[ */
        $brandSrch = Brand::getListingObj($this->siteLangId, array( 'brand_id', 'IFNULL(brand_name, brand_identifier) as brand_name', 'brand_short_description'));
        $brandSrch->doNotCalculateRecords();
        $brandSrch->doNotLimitRecords();
        $brandSrch->addCondition('brand_id', '=', $brandId);
        $brandRs = $brandSrch->getResultSet();
        $brandsArr = $db->fetchAll($brandRs);
        
        
        /* Condition filters data[ */
        $conditionSrch = clone $prodSrchObj;
        $conditionSrch->addGroupBy('selprod_condition');
        $conditionSrch->addOrder('selprod_condition');
        $conditionSrch->addMultipleFields(array('selprod_condition'));
        //echo $conditionSrch->getQuery(); die();
        /* if needs to show product counts under any condition[ */
        //$conditionSrch->addFld('count(selprod_condition) as totalProducts');
        /* ] */
        $conditionRs = $conditionSrch->getResultSet();
        $conditionsArr = $db->fetchAll($conditionRs);
        /* ] */


        /* Price Filters[ */
        $priceSrch = new ProductSearch($this->siteLangId);
        $priceSrch->setDefinedCriteria(1);
        $priceSrch->joinProductToCategory();
        $priceSrch->joinSellerSubscription();
        $priceSrch->addSubscriptionValidCondition();
        $priceSrch->doNotCalculateRecords();
        $priceSrch->doNotLimitRecords();

        if($brandId > 0) {
            $priceSrch->addBrandCondition($brandId);
        }
        $priceSrch->addMultipleFields(array('MIN(theprice) as minPrice', 'MAX(theprice) as maxPrice'));
        $qry = $priceSrch->getQuery();
        $qry .= ' having minPrice IS NOT NULL AND maxPrice IS NOT NULL';
        //echo $qry; die();
        //$priceRs = $priceSrch->getResultSet();
        $priceRs = $db->query($qry);
        $priceArr = $db->fetch($priceRs);
        
        $priceInFilter = false;    
        $filterDefaultMinValue = $priceArr['minPrice'];
        $filterDefaultMaxValue = $priceArr['maxPrice'];
        
        if($this->siteCurrencyId != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1) || (array_key_exists('currency_id', $headerFormParamsAssocArr) && $headerFormParamsAssocArr['currency_id'] != $this->siteCurrencyId )) {
            $filterDefaultMinValue = CommonHelper::displayMoneyFormat($priceArr['minPrice'], false, false, false);
            $filterDefaultMaxValue = CommonHelper::displayMoneyFormat($priceArr['maxPrice'], false, false, false);
            $priceArr['minPrice'] = $filterDefaultMinValue;
            $priceArr['maxPrice'] = $filterDefaultMaxValue;
        }    
        
        if(array_key_exists('price-min-range', $headerFormParamsAssocArr) && array_key_exists('price-max-range', $headerFormParamsAssocArr)) {
            $priceArr['minPrice'] = $headerFormParamsAssocArr['price-min-range'];
            $priceArr['maxPrice'] = $headerFormParamsAssocArr['price-max-range'];
            $priceInFilter = true;
        }
        
        if(array_key_exists('currency_id', $headerFormParamsAssocArr) && $headerFormParamsAssocArr['currency_id'] != $this->siteCurrencyId) {
            $priceArr['minPrice'] = CommonHelper::convertExistingToOtherCurrency($headerFormParamsAssocArr['currency_id'], $headerFormParamsAssocArr['price-min-range'], $this->siteCurrencyId, false);
            $priceArr['maxPrice'] = CommonHelper::convertExistingToOtherCurrency($headerFormParamsAssocArr['currency_id'], $headerFormParamsAssocArr['price-max-range'], $this->siteCurrencyId, false);
        }
        /* ] */
                
        /* Categories Data[ */
        //echo $prodSrchObj->getQuery();die();
        $catSrch = clone $prodSrchObj;
        $catSrch->addGroupBy('prodcat_code');
        //$categoriesArr = productCategory::getProdCatParentChildWiseArr( $this->siteLangId, 0, true, false, false, $catSrch );
        
        $productCatObj = new ProductCategory;
        $productCategories =  $productCatObj->getCategoriesForSelectBox($this->siteLangId);            
        
        $categoriesArr = ProductCategory::getProdCatParentChildWiseArr($this->siteLangId, 0, false, false, false, $catSrch, true);
        

        usort(
            $categoriesArr, function ($a, $b) {
                return $a['prodcat_code'] - $b['prodcat_code'];
            }
        );
        
        /* ] */
        
        $optionValueCheckedArr = array();
        if(array_key_exists('optionvalue', $headerFormParamsAssocArr)) {
            $optionValueCheckedArr = $headerFormParamsAssocArr['optionvalue'];
        }
        
        $conditionsCheckedArr = array();
        if(array_key_exists('condition', $headerFormParamsAssocArr)) {
            $conditionsCheckedArr = $headerFormParamsAssocArr['condition'];
        }
        
        $prodcatArr = array();
        if(array_key_exists('prodcat', $headerFormParamsAssocArr)) {
            $prodcatArr = $headerFormParamsAssocArr['prodcat'];
        }
        
        $availability = 0;
        if(array_key_exists('availability', $headerFormParamsAssocArr)) {
            $availability = current($headerFormParamsAssocArr['availability']);
        }
        
        $productFiltersArr = array(
        'headerFormParamsAssocArr'=>    $headerFormParamsAssocArr,
        'categoriesArr'        =>    $categoriesArr, 
        'productCategories'        =>    $productCategories,
        'shopCatFilters'        =>    true,
        'brandsArr'            =>    $brandsArr,            
        'optionValueCheckedArr'      =>    $optionValueCheckedArr,
        'conditionsCheckedArr'      =>    $conditionsCheckedArr,
        'availability'              =>     $availability,
        'brandsCheckedArr'    =>    array($brandId),
        'conditionsArr'        =>    $conditionsArr,            
        'priceArr'            =>    $priceArr,
        'prodcatArr'            =>    $prodcatArr,
        'priceInFilter'              =>    $priceInFilter,         
        'filterDefaultMinValue'              =>    $filterDefaultMinValue,        
        'filterDefaultMaxValue'              =>    $filterDefaultMaxValue,            
        'siteLangId'        =>    $this->siteLangId
        );
        
        $brandData = array();
        $brandData = array_shift($brandsArr);
        
        $this->set('frmProductSearch', $frm);    
        $this->set('brandData', $brandData);
        $this->set('brandId', $brandId);
        $this->set('priceArr', $priceArr);
        $this->set('priceInFilter', $priceInFilter);
        $this->set('productFiltersArr', $productFiltersArr);
        $this->set('canonicalUrl', CommonHelper::generateFullUrl('Brands', 'view', array($brandId)));
        if(empty($record)) {
            $this->set('noProductFound', 'noProductFound');
        }
        $this->_template->addJs('js/slick.min.js'); 
        $this->_template->addCss(array('css/slick.css','css/product-detail.css'));
        $this->_template->render();
    }
    
    function autoComplete()
    {
        $pagesize = FatApp::getConfig('CONF_PAGE_SIZE');
        $post = FatApp::getPostedData();
        
        $brandObj = new Brand();
        $srch = $brandObj->getSearchObject($this->siteLangId, true, true);
        
        $srch->addMultipleFields(array('brand_id, IFNULL(brand_name, brand_identifier) as brand_name'));
        
        if (!empty($post['keyword'])) {
            $srch->addCondition('brand_name', 'LIKE', '%' . $post['keyword'] . '%');
        }
        $srch->addCondition('brand_status', '=', Brand::BRAND_REQUEST_APPROVED);
    
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $db = FatApp::getDb();
        $brands = $db->fetchAll($rs, 'brand_id');
        $json = array();
        foreach( $brands as $key => $brand ){
            $json[] = array(
            'id' => $key,
            'name'      => strip_tags(html_entity_decode($brand['brand_name'], ENT_QUOTES, 'UTF-8'))
            );
        }
        die(json_encode($json));
        /* $this->set('brands', $db->fetchAll($rs,'brand_id') );
        $this->_template->render(false,false); */
    }
    
    public function checkUniqueBrandName()
    {
        $post = FatApp::getPostedData();
        
        $langId = FatUtility::int($post['langId']);
        
        $brandName = $post['brandName'];
        $brandId =  FatUtility::int($post['brandId']);
        if(1>$langId) {
            trigger_error(Labels::getLabel('LBL_Lang_Id_not_Specified', CommonHelper::getLangId()));
        }
        if(1>$brandId) {
            trigger_error(Labels::getLabel('LBL_Brand_Id_not_Specified', CommonHelper::getLangId()));
        }
        $srch = Brand::getSearchObject($langId);
        $srch->addCondition('brand_name', '=', $brandName);
        if($brandId) {
            $srch->addCondition('brand_id', '!=', $brandId); 
        }
        $rs = $srch->getResultSet();
        $records = $srch->recordCount();
        if($records>0) {
            
            FatUtility::dieJsonError(sprintf(Labels::getLabel('LBL_%s_not_available', $this->siteLangId), $brandName));
        }
        FatUtility::dieJsonSuccess(array());
    }
    
    public function getBreadcrumbNodes($action) 
    {
        $nodes = array();
        $parameters = FatApp::getParameters();
        switch($action)
        {
        case 'view':
            $nodes[] = array('title'=>Labels::getLabel('LBL_Brands', $this->siteLangId), 'href'=>CommonHelper::generateUrl('brands'));
            if (isset($parameters[0]) && $parameters[0] > 0) {
                $brandId = FatUtility::int($parameters[0]);
                if ($brandId>0) {
                        
                    $brandSrch = Brand::getListingObj($this->siteLangId, array( 'IFNULL(brand_name, brand_identifier) as brand_name', ));
                    $brandSrch->doNotCalculateRecords();
                    $brandSrch->doNotLimitRecords();
                    $brandSrch->addCondition('brand_id', '=', $brandId);
                    $brandRs = $brandSrch->getResultSet();
                    $brandsArr = FatApp::getDb()->fetch($brandRs);
                    $nodes[] = array('title'=>$brandsArr['brand_name']);
                            
                            
                }
            } 
                
            break;
            
        case 'index':
            $nodes[] = array('title'=>Labels::getLabel('LBL_Brands', $this->siteLangId));
                
            break;

            
        }
        return $nodes;
    }    
}