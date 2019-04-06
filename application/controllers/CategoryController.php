<?php
class CategoryController extends MyAppController
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function index()
    {
        /* $categoriesArr = ProductCategory::getProdCatParentChildWiseArr( $this->siteLangId,'',true,false,true ); */
        $categoriesArr = ProductCategory::getTreeArr($this->siteLangId, 0, true, false, true);
        $this->set('categoriesArr', $categoriesArr);
        $this->_template->render();
    }

    public function view( $category_id )
    {
        $category_id = FatUtility::int($category_id);
        ProductCategory::recordCategoryWeightage($category_id);

        $db = FatApp::getDb();
        $this->includeProductPageJsCss();
        $frm = $this->getProductSearchForm();

        $headerFormParamsArr = FatApp::getParameters();
        $headerFormParamsAssocArr = Product::convertArrToSrchFiltersAssocArr($headerFormParamsArr);
                
        $headerFormParamsAssocArr['category'] = $category_id;
        $headerFormParamsAssocArr['join_price'] = 1;
        $frm->fill($headerFormParamsAssocArr);
        
        $catSrch = new ProductCategorySearch($this->siteLangId);
        $catSrch->addCondition('prodcat_id', '=', $category_id);

        /* to show searched category data[ */
        $catSrch->addMultipleFields(array('prodcat_id','IFNULL(prodcat_name, prodcat_identifier) as prodcat_name','prodcat_description','prodcat_code'));
        $catSrchRs = $catSrch->getResultSet();
        $categoryData = $db->fetch($catSrchRs);


        if(!$categoryData ) {
            FatUtility::exitWithErrorCode(404);
        }
        $catBanner = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_BANNER, $categoryData['prodcat_id']);
        $categoryData['catBanner'] = $catBanner;
        /* ] */

        $prodSrchObj = new ProductSearch($this->siteLangId);
        $prodSrchObj->setDefinedCriteria();
        $prodSrchObj->joinProductToCategory();
        $prodSrchObj->joinSellerSubscription();
        $prodSrchObj->addSubscriptionValidCondition();        
        $prodSrchObj->addCategoryCondition($category_id);
        
        $objCat = clone $prodSrchObj;
        $objCat->addMultipleFields(array('prodcat_id'));
        $objCat->setPageSize(1);        
        $rs = $objCat->getResultSet();     
        $totalRecords = FatApp::getDb()->totalRecords($rs);

        $prodSrchObj->doNotCalculateRecords();
        $prodSrchObj->doNotLimitRecords();
        
        $brandsArr = array();
        $conditionsArr  = array();
        $priceArr  = array();

        /* Categories Data[ */         
        $catSrch = clone $prodSrchObj;
        $catSrch->addGroupBy('c.prodcat_id');
        $categoriesArr = ProductCategory::getTreeArr($this->siteLangId, $category_id, false, $catSrch, true);
        /* ] */

        /* Brand Filters Data[ */
        $brandSrch = clone $prodSrchObj;
        $brandSrch->addGroupBy('brand_id');
        $brandSrch->addOrder('brand_name');
        $brandSrch->addMultipleFields(array( 'brand_id', 'ifNull(brand_name,brand_identifier) as brand_name', 'brand_short_description'));
        /* if needs to show product counts under brands[ */
        //$brandSrch->addFld('count(selprod_id) as totalProducts');
        /* ] */

        $brandRs = $brandSrch->getResultSet();
        $brandsArr = $db->fetchAll($brandRs);
        /* ] */

        /* {Can modify the logic fetch data directly from query . will implement later}
        Option Filters Data[ */
        $options = array();
        if($category_id && ProductCategory::isLastChildCategory($category_id)) {
            $selProdCodeSrch = clone $prodSrchObj;
            $selProdCodeSrch->addGroupBy('selprod_code');
            $selProdCodeSrch->addMultipleFields(array('product_id','selprod_code'));
            $selProdCodeRs = $selProdCodeSrch->getResultSet();
            $selProdCodeArr = $db->fetchAll($selProdCodeRs);

            if(!empty($selProdCodeArr)) {
                foreach($selProdCodeArr as $val){
                    $optionsVal = SellerProduct::getSellerProductOptionsBySelProdCode($val['selprod_code'], $this->siteLangId, true);
                    $options = $options+$optionsVal;
                }
            }
        }
        
        usort(
            $options, function ($a, $b) {
                if ($a['optionvalue_id']==$b['optionvalue_id']) { return 0; 
                }
                return ($a['optionvalue_id']<$b['optionvalue_id'])?-1:1;
            }
        );
        
        /* $optionSrch->joinSellerProductOptionsWithSelProdCode();
        $optionSrch->addGroupBy('optionvalue_id'); */
        /*]*/


        /* Condition filters data[ */
        $conditionSrch = clone $prodSrchObj;
        $conditionSrch->addGroupBy('selprod_condition');
        $conditionSrch->addOrder('selprod_condition');
        $conditionSrch->addMultipleFields(array('selprod_condition'));

        /* if needs to show product counts under any condition[ */
        //$conditionSrch->addFld('count(selprod_condition) as totalProducts');
        /* ] */
        $conditionRs = $conditionSrch->getResultSet();
        $conditionsArr = $db->fetchAll($conditionRs);
        /* ] */


        /* Price Filters[ */                
        $priceSrch = clone $prodSrchObj;        
        $priceSrch->addMultipleFields(array('MIN(theprice) as minPrice', 'MAX(theprice) as maxPrice'));
        $qry = $priceSrch->getQuery();
        $qry .= ' having minPrice IS NOT NULL AND maxPrice IS NOT NULL';
        
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

        $brandsCheckedArr = array();
        if(array_key_exists('brand', $headerFormParamsAssocArr)) {
            $brandsCheckedArr = $headerFormParamsAssocArr['brand'];
        }
        
        $optionValueCheckedArr = array();
        if(array_key_exists('optionvalue', $headerFormParamsAssocArr)) {
            $optionValueCheckedArr = $headerFormParamsAssocArr['optionvalue'];
        }
        
        $conditionsCheckedArr = array();
        if(array_key_exists('condition', $headerFormParamsAssocArr)) {
            $conditionsCheckedArr = $headerFormParamsAssocArr['condition'];
        }
        
        $availability = 0;
        if(array_key_exists('availability', $headerFormParamsAssocArr)) {
            $availability = current($headerFormParamsAssocArr['availability']);
        }
        
        $productFiltersArr = array(
        'headerFormParamsAssocArr'=>    $headerFormParamsAssocArr,
        'categoriesArr'            =>    $categoriesArr,
        //	'categoryDataArr'		=>	$categoryFilterData,
        'brandsArr'                =>    $brandsArr,
        'brandsCheckedArr'          => $brandsCheckedArr,
        'optionValueCheckedArr'      =>    $optionValueCheckedArr,
        'availability'              =>     $availability,
        'conditionsArr'            =>    $conditionsArr,
        'conditionsCheckedArr'      =>    $conditionsCheckedArr,
        'priceArr'                =>    $priceArr,
        'options'                =>    $options,
        'siteLangId'            =>    $this->siteLangId,
        'priceInFilter'              =>    $priceInFilter,         
        'filterDefaultMinValue'              =>    $filterDefaultMinValue,        
        'filterDefaultMaxValue'              =>    $filterDefaultMaxValue,
        'count_for_view_more'   =>  FatApp::getConfig('CONF_COUNT_FOR_VIEW_MORE', FatUtility::VAR_INT, 5)
        );

        //$this->set('categoryData',$categoryData);
        $this->set('productFiltersArr', $productFiltersArr);
        $this->set('frmProductSearch', $frm);

        $this->set('categoryData', $categoryData);
        
        if(empty($totalRecords) ) {
            $this->set('noProductFound', 'noProductFound');
        }
        $this->set('priceArr', $priceArr);
        $this->set('priceInFilter', $priceInFilter);
        /* Get category Polls [ */
        $pollQuest = Polling::getCategoryPoll($category_id, $this->siteLangId);
        $this->set('pollQuest', $pollQuest);
        $this->set('category_id', $category_id);
        $this->set('canonicalUrl', CommonHelper::generateFullUrl('Category', 'view', array($category_id)));
        /* ] */
        $this->_template->addJs('js/slick.min.js'); 
        $this->_template->addCss(array('css/slick.css','css/product-detail.css')); 
        $this->_template->render();
    }

    public function image( $catId, $langId = 0, $sizeType = '')
    {
        $catId = FatUtility::int($catId);
        $langId = FatUtility::int($langId);
        $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_IMAGE, $catId, 0, $langId);
        $image_name = isset($file_row['afile_physical_path']) ?  $file_row['afile_physical_path'] : '';

        switch( strtoupper($sizeType) ){
        case 'THUMB':
            $w = 100;
            $h = 100;
            AttachedFile::displayImage($image_name, $w, $h);
            break;
        case 'COLLECTION_PAGE':
            $w = 45;
            $h = 41;
            AttachedFile::displayImage($image_name, $w, $h);
            break;
        default:
            AttachedFile::displayOriginalImage($image_name);
            break;
        }
    }

    public function icon( $catId, $langId = 0, $sizeType = '')
    {
        $catId = FatUtility::int($catId);
        $langId = FatUtility::int($langId);
        $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_ICON, $catId, 0, $langId);
        $image_name = isset($file_row['afile_physical_path']) ?  $file_row['afile_physical_path'] : '';

        switch( strtoupper($sizeType) ){
        case 'THUMB':
            $w = 100;
            $h = 100;
            AttachedFile::displayImage($image_name, $w, $h);
            break;
        case 'COLLECTION_PAGE':
            $w = 48;
            $h = 48;
            AttachedFile::displayImage($image_name, $w, $h);
            break;
        default:
            AttachedFile::displayOriginalImage($image_name);
            break;
        }
    }

    public function sellerBanner( $shopId, $prodCatId, $langId = 0, $sizeType = '' )
    {
        $shopId = FatUtility::int($shopId);
        $prodCatId = FatUtility::int($prodCatId);
        $langId = FatUtility::int($langId);

        $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_BANNER_SELLER, $shopId, $prodCatId, $langId);
        $image_name = isset($file_row['afile_physical_path']) ?  $file_row['afile_physical_path'] : '';

        switch( strtoupper($sizeType) ){
        case 'THUMB':
            $w = 250;
            $h = 100;
            AttachedFile::displayImage($image_name, $w, $h);
            break;
        case 'WIDE':
            $w = 1320;
            $h = 320;
            AttachedFile::displayImage($image_name, $w, $h);
            break;
        default:
            AttachedFile::displayOriginalImage($image_name);
            break;
        }
    }

    public function banner( $prodCatId, $langId = 0, $sizeType = '', $subRcordId = 0)
    {
        $prodCatId = FatUtility::int($prodCatId);
        $subRcordId = FatUtility::int($subRcordId);
        $langId = FatUtility::int($langId);

        $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_BANNER, $prodCatId, $subRcordId, $langId);
        $image_name = isset($file_row['afile_physical_path']) ?  $file_row['afile_physical_path'] : '';

        switch( strtoupper($sizeType) ){
        case 'THUMB':
            $w = 250;
            $h = 100;
            AttachedFile::displayImage($image_name, $w, $h);
            break;
        case 'MEDIUM':
            $w = 380;
            $h = 213;
            AttachedFile::displayImage($image_name, $w, $h);
            break;
        case 'WIDE':
            $w = 1000;
            $h = 563;
            AttachedFile::displayImage($image_name, $w, $h);
            break;
        default:
            AttachedFile::displayOriginalImage($image_name);
            break;
        }
    }

    /* public function banner( $shopId, $sizeType = '', $prodCatId = 0){
    $shopId = FatUtility::int($shopId);
    $prodCatId = FatUtility::int($prodCatId);

    $file_row = false;
    if($prodCatId > 0){
    $file_row = AttachedFile::getAttachment( AttachedFile::FILETYPE_CATEGORY_BANNER_SELLER, $shopId,$prodCatId );
    if(false == $file_row){
				$file_row = AttachedFile::getAttachment( AttachedFile::FILETYPE_SHOP_BANNER, $shopId );
    }
    }

    if(false == $file_row){
    // $file_row = AttachedFile::getAttachment( AttachedFile::FILETYPE_CATEGORY_BANNER, $shopId );
    $file_row = AttachedFile::getAttachment( AttachedFile::FILETYPE_SHOP_BANNER, $shopId );
    }

    $image_name = isset($file_row['afile_physical_path']) ?  $file_row['afile_physical_path'] : '';

    switch( strtoupper($sizeType) ){
    case 'THUMB':
				$w = 250;
				$h = 100;
				AttachedFile::displayImage( $image_name, $w, $h );
    break;
    case 'WIDE':
				$w = 1320;
				$h = 320;
				AttachedFile::displayImage( $image_name, $w, $h );
    break;
    default:
				AttachedFile::displayOriginalImage( $image_name );
    break;
    }
    } */

    public function getBreadcrumbNodes($action) 
    {
        $nodes = array();
        $parameters = FatApp::getParameters();
        switch($action)
        {
        case 'view':
            //$nodes[] = array('title'=>'Root Categories', 'href'=>CommonHelper::generateUrl('ProductCategories'));
            if (isset($parameters[0]) && $parameters[0] > 0) {
                $parent = FatUtility::int($parameters[0]);
                if ($parent>0) {
                    $cntInc=1;
                    $prodCateObj =new ProductCategory();
                    $category_structure=$prodCateObj->getCategoryStructure($parent, '', $this->siteLangId);
                    $category_structure = array_reverse($category_structure);
                    foreach($category_structure as $catKey=>$catVal){
                        if ($cntInc<count($category_structure)) {
                            $nodes[] = array('title'=>$catVal["prodcat_name"], 'href'=>Commonhelper::generateUrl('category', 'view', array($catVal['prodcat_id'])));
                        }else{
                            $nodes[] = array('title'=>$catVal["prodcat_name"]);
                        }
                        $cntInc++;
                    }
                }

            }
            break;

        case 'form':
            break;
        }
        return $nodes;
    }

}
