<?php
class Importexport extends ImportexportCommon{

	const DB_TBL_SETTINGS = 'tbl_import_export_settings';
	const DB_TBL_TEMP_SELPROD_IDS = 'tbl_seller_products_temp_ids';
	const DB_TBL_TEMP_PRODUCT_IDS = 'tbl_products_temp_ids';

	const TYPE_CATEGORIES = 1;
	const TYPE_BRANDS = 2;
	const TYPE_PRODUCTS = 3;
	const TYPE_SELLER_PRODUCTS = 4;
	const TYPE_OPTIONS = 5;
	const TYPE_OPTION_VALUES = 6;
	const TYPE_TAG = 7;
	const TYPE_COUNTRY = 8;
	const TYPE_STATE = 9;
	const TYPE_POLICY_POINTS = 10;
	const TYPE_USERS = 11;
	const TYPE_TAX_CATEGORY = 12;

	const MAX_LIMIT = 1000;

	const PRODUCT_CATALOG = 1;
	const PRODUCT_OPTION = 2;
	const PRODUCT_TAG = 3;
	const PRODUCT_SPECIFICATION = 4;
	const PRODUCT_SHIPPING = 5;

	const LABEL_OPTIONS = 1;
	const LABEL_OPTIONS_VALUES = 2;

	const SELLER_PROD_GENERAL_DATA = 6;
	const SELLER_PROD_OPTION = 7;
	const SELLER_PROD_SEO = 8;
	const SELLER_PROD_SPECIAL_PRICE = 9;
	const SELLER_PROD_VOLUME_DISCOUNT = 10;
	const SELLER_PROD_BUY_TOGTHER = 11;
	const SELLER_PROD_RELATED_PRODUCT = 12;
	const SELLER_PROD_POLICY = 13;

	const BY_ID_RANGE = 1;
	const BY_BATCHES = 2;

	public static function getImportExportTypeArr($type,$langId, $sellerDashboard = false){
		switch(strtoupper($type)){
			case 'EXPORT':
				$arr[static::TYPE_CATEGORIES] = Labels::getLabel('LBL_Export_Categories',$langId);
				$arr[static::TYPE_PRODUCTS] = Labels::getLabel('LBL_Export_Catalogs',$langId);
				$arr[static::TYPE_SELLER_PRODUCTS] = Labels::getLabel('LBL_Export_Seller_Products',$langId);
				$arr[static::TYPE_BRANDS] = Labels::getLabel('LBL_Export_Brands',$langId);
				$arr[static::TYPE_OPTIONS] = Labels::getLabel('LBL_Export_Options',$langId);
				$arr[static::TYPE_OPTION_VALUES] = Labels::getLabel('LBL_Export_Option_Values',$langId);
				$arr[static::TYPE_TAG] = Labels::getLabel('LBL_Export_Tags',$langId);
				$arr[static::TYPE_COUNTRY] = Labels::getLabel('LBL_Export_Countries',$langId);
				$arr[static::TYPE_STATE] = Labels::getLabel('LBL_Export_States',$langId);
				$arr[static::TYPE_POLICY_POINTS] = Labels::getLabel('LBL_Export_Policy_Points',$langId);
				if(!$sellerDashboard){
					$arr[static::TYPE_USERS] = Labels::getLabel('LBL_Export_users',$langId);
				}
				$arr[static::TYPE_TAX_CATEGORY] = Labels::getLabel('LBL_Export_Tax_Category',$langId);
			break;
			case 'IMPORT':
				if(!$sellerDashboard){
					$arr[static::TYPE_CATEGORIES] = Labels::getLabel('LBL_Import_Categories',$langId);
					$arr[static::TYPE_BRANDS] = Labels::getLabel('LBL_Import_Brands',$langId);
				}

				$arr[static::TYPE_PRODUCTS] = Labels::getLabel('LBL_Import_Catalogs',$langId);

				if(!$sellerDashboard){
					$arr[static::TYPE_OPTIONS] = Labels::getLabel('LBL_Import_Options',$langId);
					$arr[static::TYPE_OPTION_VALUES] = Labels::getLabel('LBL_Import_Option_Values',$langId);
					$arr[static::TYPE_TAG] = Labels::getLabel('LBL_Import_Tags',$langId);
					$arr[static::TYPE_COUNTRY] = Labels::getLabel('LBL_Import_Countries',$langId);
					$arr[static::TYPE_STATE] = Labels::getLabel('LBL_Import_States',$langId);
					$arr[static::TYPE_POLICY_POINTS] = Labels::getLabel('LBL_Import_Policy_Points',$langId);
				}
				$arr[static::TYPE_SELLER_PRODUCTS] = Labels::getLabel('LBL_Import_Seller_Products',$langId);
				if(!$sellerDashboard){
					$arr[static::TYPE_USERS] = Labels::getLabel('LBL_Import_users',$langId);
					$arr[static::TYPE_TAX_CATEGORY] = Labels::getLabel('LBL_Import_Tax_Category',$langId);
				}
			break;
		}

		return $arr;
	}

	public static function getOptionContentTypeArr($langId){
		$arr = array(
			static::LABEL_OPTIONS=>Labels::getLabel('LBL_Options',$langId),
			static::LABEL_OPTIONS_VALUES=>Labels::getLabel('LBL_Option_Values',$langId),
		);
		return $arr;
	}

	public static function getProductCatalogContentTypeArr($langId){
		$arr = array(
			static::PRODUCT_CATALOG=>Labels::getLabel('LBL_Product_Catalog',$langId),
			static::PRODUCT_OPTION=>Labels::getLabel('LBL_Product_Options',$langId),
			static::PRODUCT_TAG=>Labels::getLabel('LBL_Product_Tags',$langId),
			static::PRODUCT_SPECIFICATION=>Labels::getLabel('LBL_Product_Specifications',$langId),
			static::PRODUCT_SHIPPING=>Labels::getLabel('LBL_Product_Shipping',$langId),
		);
		return $arr;
	}

	public static function getSellerProductContentTypeArr($langId){
		$arr = array(
			static::SELLER_PROD_GENERAL_DATA=>Labels::getLabel('LBL_General_Data',$langId),
			static::SELLER_PROD_OPTION=>Labels::getLabel('LBL_Product_Options',$langId),
			static::SELLER_PROD_SEO=>Labels::getLabel('LBL_SEO_Data',$langId),
			static::SELLER_PROD_SPECIAL_PRICE=>Labels::getLabel('LBL_Special_Price',$langId),
			static::SELLER_PROD_VOLUME_DISCOUNT=>Labels::getLabel('LBL_Volume_Discount',$langId),
			static::SELLER_PROD_BUY_TOGTHER=>Labels::getLabel('LBL_Buy_togther',$langId),
			static::SELLER_PROD_RELATED_PRODUCT=>Labels::getLabel('LBL_Related_products',$langId),
			static::SELLER_PROD_POLICY=>Labels::getLabel('LBL_Seller_Product_Policy',$langId),
		);
		return $arr;
	}

	public static function getDataRangeArr($langId){
		$arr = array(
			static::BY_ID_RANGE=>Labels::getLabel('LBL_By_id_range',$langId),
			static::BY_BATCHES=>Labels::getLabel('LBL_By_batches',$langId),
		);
		return $arr;
	}

	public function getCsvFilePointer($fileTempName){
		return fopen($fileTempName, 'r');
	}

	public function getFileContent($csvFilePointer){
		return fgetcsv($csvFilePointer);
	}

	public function getCell($arr = array(),$index, $defaultValue = ''){
		if(isset($arr[$index]) && trim($arr[$index])!=''){
			$str = str_replace( "\xc2\xa0", '', trim($arr[$index]) );
			return str_replace( "\xa0", '', $str );
			//return trim($arr[$index]);
		}
		return $defaultValue;
	}

	public function export($type,$langId,$sheetType,$offset = null,$noOfRows = null,$minId = null,$maxId = null,$userId = 0){
		$all = !isset($offset) && !isset($noOfRows) && !isset($minId) && !isset($maxId);
		$userId = FatUtility::int($userId);
		$this->settings = $this->getSettings($userId);

		$sheetData = array();
		$sheetName = '';

		switch($type){
			case Importexport::TYPE_BRANDS:
				$sheetData = $this->exportBrands($langId, $userId);
				$sheetName = Labels::getLabel('LBL_Brands',$langId);
			break;
			case Importexport::TYPE_CATEGORIES:
				$sheetData = $this->exportCategories($langId, $userId);
				$sheetName = Labels::getLabel('LBL_Category',$langId);
			break;
			case Importexport::TYPE_PRODUCTS:
				switch($sheetType){
					case Importexport::PRODUCT_CATALOG:
						$sheetData = $this->exportProductsCatalog($langId,$offset,$noOfRows,$minId,$maxId,$userId);
						$sheetName = Labels::getLabel('LBL_Product_Catalogs',$langId);
					break;
					case Importexport::PRODUCT_OPTION:
						$sheetData = $this->exportProductOptions($langId,$offset,$noOfRows,$minId,$maxId,$userId);
						$sheetName = Labels::getLabel('LBL_Catalog_Options',$langId);
					break;
					case Importexport::PRODUCT_TAG:
						$sheetData = $this->exportProductTags($langId,$offset,$noOfRows,$minId,$maxId,$userId);
						$sheetName = Labels::getLabel('LBL_Catalog_Tags',$langId);
					break;
					case Importexport::PRODUCT_SPECIFICATION:
						$sheetData = $this->exportProductSpecification($langId,$offset,$noOfRows,$minId,$maxId,$userId);
						$sheetName = Labels::getLabel('LBL_Catalog_Specification',$langId);
					break;
					case Importexport::PRODUCT_SHIPPING:
						$sheetData = $this->exportProductShipping($langId,$offset,$noOfRows,$minId,$maxId,$userId);
						$sheetName = Labels::getLabel('LBL_Catalog_Shipping',$langId);
					break;
				}
			break;
			case Importexport::TYPE_SELLER_PRODUCTS:
				switch($sheetType){
					case Importexport::SELLER_PROD_GENERAL_DATA:
						$sheetData = $this->exportSellerProdGeneralData($langId,$offset,$noOfRows,$minId,$maxId,$userId);
						$sheetName = Labels::getLabel('LBL_Seller_Product_General',$langId);
					break;
					case Importexport::SELLER_PROD_OPTION:
						$sheetData = $this->exportSellerProdOptionData($langId,$offset,$noOfRows,$minId,$maxId,$userId);
						$sheetName = Labels::getLabel('LBL_Seller_Product_Option',$langId);
					break;
					case Importexport::SELLER_PROD_SEO:
						$sheetData = $this->exportSellerProdSeoData($langId,$offset,$noOfRows,$minId,$maxId,$userId);
						$sheetName = Labels::getLabel('LBL_Seller_Product_Seo',$langId);
					break;
					case Importexport::SELLER_PROD_SPECIAL_PRICE:
						$sheetData = $this->exportSellerProdSpecialPrice($langId,$offset,$noOfRows,$minId,$maxId,$userId);
						$sheetName = Labels::getLabel('LBL_Seller_Prod_Special_price',$langId);
					break;
					case Importexport::SELLER_PROD_VOLUME_DISCOUNT:
						$sheetData = $this->exportSellerProdVolumeDiscount($langId,$offset,$noOfRows,$minId,$maxId,$userId);
						$sheetName = Labels::getLabel('LBL_Seller_Prod_Volume_Discount',$langId);
					break;
					case Importexport::SELLER_PROD_BUY_TOGTHER:
						$sheetData = $this->exportSellerProdBuyTogther($langId,$offset,$noOfRows,$minId,$maxId,$userId);
						$sheetName = Labels::getLabel('LBL_Seller_Prod_Buy_Together',$langId);
					break;
					case Importexport::SELLER_PROD_RELATED_PRODUCT:
						$sheetData = $this->exportSellerProdRelatedProd($langId,$offset,$noOfRows,$minId,$maxId,$userId);
						$sheetName = Labels::getLabel('LBL_Seller_Prod_Related_Prod',$langId);
					break;
					case Importexport::SELLER_PROD_POLICY:
						$sheetData = $this->exportSellerProdPolicy($langId,$offset,$noOfRows,$minId,$maxId,$userId);
						$sheetName = Labels::getLabel('LBL_Seller_Prod_Policy',$langId);
					break;
				}
			break;
			case Importexport::TYPE_OPTIONS:
				switch($sheetType){
					case Importexport::LABEL_OPTIONS:
						$sheetData = $this->exportOptions($langId, $userId);
						$sheetName = Labels::getLabel('LBL_Options',$langId);
					break;
					case Importexport::LABEL_OPTIONS_VALUES:
						$sheetData = $this->exportOptionValues($langId, $userId);
						$sheetName = Labels::getLabel('LBL_Option_Values',$langId);
					break;
					default:
						$sheetData = $this->exportOptions($langId, $userId);
						$sheetName = Labels::getLabel('LBL_Options',$langId);
					break;
				}
			break;
			case Importexport::TYPE_OPTION_VALUES:
				$sheetData = $this->exportOptionValues($langId, $userId);
				$sheetName = Labels::getLabel('LBL_Option_Values',$langId);
			break;
			case Importexport::TYPE_TAG:
				$sheetData = $this->exportTags($langId, $userId);
				$sheetName = Labels::getLabel('LBL_Tags',$langId);
			break;
			case Importexport::TYPE_COUNTRY:
				$sheetData = $this->exportCountries($langId, $userId);
				$sheetName = Labels::getLabel('LBL_Country',$langId);
			break;
			case Importexport::TYPE_STATE:
				$sheetData = $this->exportStates($langId, $userId);
				$sheetName = Labels::getLabel('LBL_State',$langId);
			break;
			case Importexport::TYPE_POLICY_POINTS:
				$sheetData = $this->exportPolicyPoints($langId, $userId);
				$sheetName = Labels::getLabel('LBL_Policy_points',$langId);
			break;
			case Importexport::TYPE_USERS:
				$sheetData = $this->exportUsers($langId);
				$sheetName = Labels::getLabel('LBL_Users',$langId);
			break;
			case Importexport::TYPE_TAX_CATEGORY:
				$sheetData = $this->exportTaxCategory($langId, $userId);
				$sheetName = Labels::getLabel('LBL_Tax_Category',$langId);
			break;
		}

		if(isset($offset) && isset($noOfRows)){
			$sheetName.='_'.$offset;
		}

		if(isset($minId) && isset($maxId)){
			$sheetName.='_'.$minId.'-'.$maxId;
		}

		$langData = Language::getAttributesById($langId,array('language_code'));
		CommonHelper::convertToCsv( $sheetData, $sheetName.'_'.$langData['language_code'].'_'.date("d-M-Y").'.csv', ',');
		exit;
	}

	public function exportMedia($type,$langId,$offset = null,$noOfRows = null,$minId = null,$maxId = null,$userId = 0){
		$all = !isset($offset) && !isset($noOfRows) && !isset($minId) && !isset($maxId);
		$userId = FatUtility::int($userId);
		$this->settings = $this->getSettings($userId);

		$sheetData = array();
		$sheetName = '';
		switch($type){
			case Importexport::TYPE_BRANDS:
				$sheetData = $this->exportBrandMedia($langId);
				$sheetName = Labels::getLabel('LBL_Brands_Media',$langId);
			break;
			case Importexport::TYPE_CATEGORIES:
				$sheetData = $this->exportCategoryMedia($langId);
				$sheetName = Labels::getLabel('LBL_Category_Media',$langId);
			break;
			case Importexport::TYPE_PRODUCTS:
				$sheetData = $this->exportProductMedia($langId,$offset,$noOfRows,$minId,$maxId,$userId);
				$sheetName = Labels::getLabel('LBL_Product_Media',$langId);
			break;
			case Importexport::TYPE_SELLER_PRODUCTS:
				$sheetData = $this->exportSellerProductMedia($langId,$offset,$noOfRows,$minId,$maxId,$userId);
				$sheetName = Labels::getLabel('LBL_Seller_Product_Digital_File',$langId);
			break;
		}

		if(isset($offset) && isset($noOfRows)){
			$sheetName.='_'.$offset;
		}

		if(isset($minId) && isset($maxId)){
			$sheetName.='_'.$minId.'-'.$maxId;
		}

		$langData = Language::getAttributesById($langId,array('language_code'));
		CommonHelper::convertToCsv( $sheetData, $sheetName.'_'.$langData['language_code'].'_'.date("d-M-Y").'.csv', ','); exit;
	}

	public function import($type,$langId,$sheetType = '',$userId = 0){
		$post = FatApp::getPostedData();
		$userId = FatUtility::int($userId);
		$this->settings = $this->getSettings($userId);

		$csvFilePointer = $this->getCsvFilePointer($_FILES['import_file']['tmp_name']);
		$default = false;
		switch($type){
			case Importexport::TYPE_BRANDS:
				$this->importBrands($csvFilePointer,$post,$langId,$userId);
			break;
			case Importexport::TYPE_CATEGORIES:
				$this->importCategories($csvFilePointer,$post,$langId,$userId);
			break;
			case Importexport::TYPE_PRODUCTS:
				switch($sheetType){
					case Importexport::PRODUCT_CATALOG:
						$this->importProductsCatalog($csvFilePointer,$post,$langId,$userId);
					break;
					case Importexport::PRODUCT_OPTION:
						$this->importProductOptions($csvFilePointer,$post,$langId,$userId);
					break;
					case Importexport::PRODUCT_TAG:
						$this->importProductTags($csvFilePointer,$post,$langId,$userId);
					break;
					case Importexport::PRODUCT_SPECIFICATION:
						$this->importProductSpecifications($csvFilePointer,$post,$langId,$userId);
					break;
					case Importexport::PRODUCT_SHIPPING:
						$this->importProductShipping($csvFilePointer,$post,$langId,$userId);
					break;
					default:
						$default = true;
					break;
				}
			break;
			case Importexport::TYPE_SELLER_PRODUCTS:
				switch($sheetType){
					case Importexport::SELLER_PROD_GENERAL_DATA:
						$this->importSellerProdGeneralData($csvFilePointer, $post, $langId, $userId);
					break;
					case Importexport::SELLER_PROD_OPTION:
						$sheetData = $this->importSellerProdOptionData($csvFilePointer, $post, $langId, $userId);
					break;
					case Importexport::SELLER_PROD_SEO:
						$this->importSellerProdSeoData($csvFilePointer, $post, $langId, $userId);
					break;
					case Importexport::SELLER_PROD_SPECIAL_PRICE:
						$this->importSellerProdSpecialPrice($csvFilePointer, $post, $langId, $userId);
					break;
					case Importexport::SELLER_PROD_VOLUME_DISCOUNT:
						$this->importSellerProdVolumeDiscount($csvFilePointer, $post, $langId, $userId);
					break;
					case Importexport::SELLER_PROD_BUY_TOGTHER:
						$this->importSellerProdBuyTogther($csvFilePointer, $post, $langId, $userId);
					break;
					case Importexport::SELLER_PROD_RELATED_PRODUCT:
						$this->importSellerProdRelatedProd($csvFilePointer, $post, $langId, $userId);
					break;
					case Importexport::SELLER_PROD_POLICY:
						$this->importSellerProdPolicy($csvFilePointer, $post, $langId, $userId);
					break;
					default:
						$default = true;
					break;
				}
			break;
			case Importexport::TYPE_OPTIONS:
				switch($sheetType){
					case Importexport::PRODUCT_CATALOG:
						$this->importOptions($csvFilePointer,$post,$langId);
					break;
					case Importexport::PRODUCT_OPTION:
						$this->importOptionValues($csvFilePointer,$post,$langId);
					break;
				}
			break;
			case Importexport::TYPE_OPTION_VALUES:
				$this->importOptionValues($csvFilePointer,$post,$langId);
			break;
			case Importexport::TYPE_TAG:
				$this->importTags($csvFilePointer,$post,$langId);
			break;
			case Importexport::TYPE_COUNTRY:
				$this->importCountries($csvFilePointer,$post,$langId);
			break;
			case Importexport::TYPE_STATE:
				$this->importStates($csvFilePointer,$post,$langId);
			break;
			case Importexport::TYPE_POLICY_POINTS:
				$this->importPolicyPoints($csvFilePointer,$post,$langId);
			break;
			default:
				$default = true;
			break;
		}

		if($default){
			Message::addMessage(Labels::getLabel('MSG_Invalid_Access',$langId));
			FatUtility::dieJsonError(Message::getHtml());
		}
	}

	public function importMedia($type,$post,$langId,$userId = 0){
		$csvFilePointer = $this->getCsvFilePointer($_FILES['import_file']['tmp_name']);
		$userId = FatUtility::int($userId);
		$this->settings = $this->getSettings($userId);

		switch($type){
			case Importexport::TYPE_BRANDS:
				$this->importBrandsMedia($csvFilePointer,$post,$langId);
			break;
			case Importexport::TYPE_CATEGORIES:
				$this->importCategoryMedia($csvFilePointer,$post,$langId);
			break;
			case Importexport::TYPE_PRODUCTS:
				$this->importProductCatalogMedia($csvFilePointer,$post,$langId,$userId);
			break;
		}
	}

	public function exportCategories($langId, $userId = 0){
		$userId = FatUtility::int($userId);

		if(!$userId){
			$urlKeywords = $this->getAllRewriteUrls(ProductCategory::REWRITE_URL_PREFIX);
		}

		$useCategoryId = false;
		if($this->settings['CONF_USE_CATEGORY_ID']){
			$useCategoryId = true;
		}else{
			$categoriesIdentifiers = $this->getAllCategoryIdentifiers();
		}

		$srch = ProductCategory::getSearchObject(false,$langId,false);
		$srch->addMultipleFields(array('prodcat_id','prodcat_identifier','prodcat_parent','IFNULL(prodcat_name,prodcat_identifier) as prodcat_name','prodcat_description','prodcat_featured','prodcat_active','prodcat_deleted','prodcat_display_order'));
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$srch->addOrder('prodcat_id','asc');
		if($userId){
			$srch->addCondition('prodcat_active','=',applicationConstants::ACTIVE);
			$srch->addCondition('prodcat_deleted','=',applicationConstants::NO);
		}

		$rs = $srch->getResultSet();

		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getCategoryColoumArr($langId, $userId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){

			foreach ($headingsArr as $columnKey => $heading) {

				$colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';

				if( in_array( $columnKey, array( 'prodcat_featured', 'prodcat_active', 'prodcat_deleted' ) ) && !$this->settings['CONF_USE_O_OR_1'] ){
					$colValue = (FatUtility::int($colValue) == 1) ? 'YES' : 'NO';
				}

				if(  'urlrewrite_custom' == $columnKey ){
					$colValue = isset($urlKeywords[ProductCategory::REWRITE_URL_PREFIX.$row['prodcat_id']]) ? $urlKeywords[ProductCategory::REWRITE_URL_PREFIX.$row['prodcat_id']] : '';
				}

				if(  'prodcat_parent_identifier' == $columnKey ){
					$colValue = array_key_exists($row['prodcat_parent'], $categoriesIdentifiers) ? $categoriesIdentifiers[$row['prodcat_parent']] : '';
				}

				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}

		return $sheetData;
	}

	public function exportCategoryMedia($langId){
		$srch = ProductCategory::getSearchObject(false,false,false);
		$srch->joinTable(AttachedFile::DB_TBL,'INNER JOIN','prodcat_id = afile_record_id and ( afile_type = '.AttachedFile::FILETYPE_CATEGORY_ICON.' or afile_type = '.AttachedFile::FILETYPE_CATEGORY_BANNER.')');
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$srch->addMultipleFields(array('prodcat_id','prodcat_identifier','afile_record_id','afile_record_subid','afile_type','afile_lang_id','afile_screen','afile_physical_path','afile_name','afile_display_order'));
		$rs = $srch->getResultSet();

		$sheetData = array();
		/* Sheet Heading Row [ */
		$arr = $this->getCategoryMediaColoumArr($langId);
		array_push( $sheetData, $arr );
		/* ] */

		$languageCodes = Language::getAllCodesAssoc(true);
		$fileTypeArr = AttachedFile::getFileTypeArray($langId);

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();
			if($this->settings['CONF_USE_CATEGORY_ID']){
				$sheetArr[] = $row['prodcat_id'];
			}else{
				$sheetArr[] = $row['prodcat_identifier'];
			}

			if($this->settings['CONF_USE_LANG_ID']){
				$sheetArr[] = $row['afile_lang_id'];
			}else{
				$sheetArr[] = $languageCodes[$row['afile_lang_id']];
			}
			$sheetArr[] = isset($fileTypeArr[$row['afile_type']])?$fileTypeArr[$row['afile_type']]:'';

			$sheetArr[] = $row['afile_physical_path'];
			$sheetArr[] = $row['afile_name'];
			$sheetArr[] = $row['afile_display_order'];
			array_push( $sheetData, $sheetArr );
		}

		return $sheetData;
	}

	public function importCategories($csvFilePointer,$post,$langId,$userId = null){

		$rowIndex = 0;
		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){

			$rowIndex++;
			if($rowIndex == 1){
				$coloumArr = $this->getCategoryColoumArr($langId, $userId);

				if( !$this->isValidColumns($row, $coloumArr) ){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndexArr = array_flip($row);

				$errfileName = $this->logFileName('Categories');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$prodCatDataArr = $prodCatlangDataArr = array();
			$error = $seoUrl = false;

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndexArr[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( 'prodcat_id' == $columnKey && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_should_be_gerater_than_0.", $langId ) );
				}else if( in_array( $columnKey,array('prodcat_identifier','prodcat_name') ) && $colValue == '' ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_is_mandatory.", $langId ) );
				}else if( 'prodcat_display_order' == $columnKey && 0 > FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_should_be_gerater_than_equal_to_0.", $langId ) );
				}

				if( $errMsg ){
					$err = array($rowIndex,( $colIndex + 1),$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{
					if( in_array( $columnKey, array( 'prodcat_featured', 'prodcat_active', 'prodcat_deleted', 'prodcat_display_order' ) ) ){
						if($this->settings['CONF_USE_O_OR_1']){
							$colValue = (FatUtility::int($colValue) == 1) ? applicationConstants::YES : applicationConstants::NO;
						}else{
							$colValue = (strtoupper($colValue) == 'YES') ? applicationConstants::YES : applicationConstants::NO;
						}
					}

					if( in_array( $columnKey, array( 'prodcat_name', 'prodcat_description' ) ) ){
						$prodCatlangDataArr[$columnKey] = $colValue;
					}else if( 'urlrewrite_custom' == $columnKey ){
						$seoUrl = $colValue;
					}else{
						$prodCatDataArr[$columnKey] = $colValue;
					}
				}
			}

			if( !$error && count($prodCatDataArr) ){

				if( $this->isDefaultSheetData($langId) ){
					if( $this->settings['CONF_USE_CATEGORY_ID'] ){
						$parentId = $prodCatDataArr['prodcat_parent'];
					}else{
						$identifier = $prodCatDataArr['prodcat_parent_identifier'];

						$categoriesIdentifiers = $this->getAllCategoryIdentifiers(false);
						$parentId = isset($categoriesIdentifiers[$identifier]) ? $categoriesIdentifiers[$identifier] : 0;
					}
					if($parentId){
						$parentCategoryData = ProductCategory::getAttributesById($parentId,'prodcat_id');
						if(empty($parentCategoryData) || $parentCategoryData == false){
							$parentId = 0;
						}
						$prodCatDataArr['prodcat_parent'] = $parentId;
					}
				}

				if( $this->settings['CONF_USE_CATEGORY_ID'] ){
					$categoryId = $prodCatDataArr['prodcat_id'];
					$categoryData = ProductCategory::getAttributesById($categoryId,array('prodcat_id'));
				}else{
					$identifier = $prodCatDataArr['prodcat_identifier'];
					$categoryData = ProductCategory::getAttributesByIdentifier($identifier,array('prodcat_id'));
					$categoryId = $categoryData['prodcat_id'];
				}

				if( !$this->isDefaultSheetData( $langId ) ){
					unset( $prodCatDataArr['prodcat_parent'] );
					unset( $prodCatDataArr['prodcat_identifier'] );
					unset( $prodCatDataArr['prodcat_display_order'] );
				}

				if( !empty($categoryData) && $categoryData['prodcat_id'] ){
					$where = array('smt' => 'prodcat_id = ?', 'vals' => array( $categoryId ) );
					$this->db->updateFromArray( ProductCategory::DB_TBL, $prodCatDataArr,$where);
				}else{
					if( $this->isDefaultSheetData($langId) ){
						$this->db->insertFromArray( ProductCategory::DB_TBL, $prodCatDataArr);
						$categoryId = $this->db->getInsertId();
					}
				}

				if( $categoryId ){
					/* Lang Data [*/
					$langData = array(
						'prodcatlang_prodcat_id'=> $categoryId,
						'prodcatlang_lang_id'=> $langId,
					);
					$langData = array_merge( $langData, $prodCatlangDataArr );

					$this->db->insertFromArray( ProductCategory::DB_LANG_TBL, $langData , false, array(), $langData );

					/* ]*/

					/* Update cat code[*/
					$category = new ProductCategory( $categoryId );
					$category->updateCatCode();
					/*]*/

					/* Url rewriting [*/
					if($this->isDefaultSheetData($langId)){
						if(!$seoUrl){
							$seoUrl = $identifier;
						}
						$prodcatData = ProductCategory::getAttributesById($categoryId,array('prodcat_parent'));
						$category->rewriteUrl($seoUrl,true,$prodcatData['prodcat_parent']);
					}
					/* ]*/
				}
			}
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function importCategoryMedia($csvFilePointer,$post,$langId){

		$rowIndex = $rowCount = 0;

		$fileTypeArr = AttachedFile::getFileTypeArray($langId);
		$fileTypeIdArr = array_flip($fileTypeArr);

		$languageCodes = Language::getAllCodesAssoc(true);
		$languageIds = array_flip($languageCodes);

		$useCategoryId = false;
		if($this->settings['CONF_USE_CATEGORY_ID']){
			$useCategoryId = true;
		}else{
			$categoriesIdentifiers = $this->getAllCategoryIdentifiers();
			$categoriesIds = array_flip($categoriesIdentifiers);
		}

		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			if(empty($line[0])){
				continue;
			}

			if($rowCount == 0){
				$coloumArr = $this->getCategoryMediaColoumArr($langId);
				if($line !== $coloumArr){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Category_Media');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$numcols = count($line);
			$colCount = 0;


			if($useCategoryId){
				$categoryId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $categoryId ){
					$err = Labels::getLabel('MSG_Category_id_is_required.');
					CommonHelper::writeLogFile( $errFile, array( $rowIndex, $colCount, $err ) );
					continue;
				}
			}else{
				$identifier = $this->getCell($line,$colCount++,'');
				if( empty($identifier) ){
					$err = Labels::getLabel('MSG_Identifier_is_required_and_unique.');
					CommonHelper::writeLogFile( $errFile, array( $rowIndex, $colCount, $err ) );
					continue;
				}
			}

			if($this->settings['CONF_USE_LANG_ID']){
				$landId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $landId ){
					$err = Labels::getLabel('MSG_Lang_id_is_required.');
					CommonHelper::writeLogFile( $errFile, array( $rowIndex, $colCount, $err ) );
					continue;
				}
			}else{
				$langCode = $this->getCell($line,$colCount++,'');
				if( empty($identifier) ){
					$err = Labels::getLabel('MSG_Lang_code_is_required_and_unique.');
					CommonHelper::writeLogFile( $errFile, array( $rowIndex, $colCount, $err ) );
					continue;
				}
			}

			$imageType = $this->getCell($line,$colCount++,'');
			if( empty($imageType) ){
				$err = Labels::getLabel('MSG_Image_type_is_required.');
				CommonHelper::writeLogFile( $errFile, array( $rowIndex, $colCount, $err ) );
				continue;
			}
			$filePath = $this->getCell($line,$colCount++,'');
			if( empty($filePath) ){
				$err = Labels::getLabel('MSG_File_path_is_required.');
				CommonHelper::writeLogFile( $errFile, array( $rowIndex, $colCount, $err ) );
				continue;
			}
			$fileName = $this->getCell($line,$colCount++,'');
			if( empty($fileName) ){
				$err = Labels::getLabel('MSG_File_name_is_required.');
				CommonHelper::writeLogFile( $errFile, array( $rowIndex, $colCount, $err ) );
				continue;
			}
			$displayOrder = $this->getCell($line,$colCount++,0);
			if( $displayOrder == '' || $displayOrder < 0 ){
				$err = Labels::getLabel('MSG_Display_order_is_required.');
				CommonHelper::writeLogFile( $errFile, array( $rowIndex, $colCount, $err ) );
				continue;
			}

			if(!$numcols || $numcols != $colCount){
				Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
				FatUtility::dieJsonError( Message::getHtml() );
			}

			if($rowCount > 0){
				$fileType = isset($fileTypeIdArr[$imageType])?$fileTypeIdArr[$imageType]:0;

				if($useCategoryId){
					$recordId = $categoryId;
				}else{
					$recordId = isset($categoriesIds[$identifier])?$categoriesIds[$identifier]:0;
				}

				if(!$recordId || !$fileType){
					$err = Labels::getLabel('MSG_Category_id_and_file_type_is_required.');
					CommonHelper::writeLogFile( $errFile, array( $rowIndex, $colCount, $err ) );
					continue;
				}

				if($this->settings['CONF_USE_LANG_ID']){
					$fileLangId = $landId;
				}else{
					$fileLangId = $languageIds[$langCode];
				}

				$recordSubid = 0;

				$dataToSaveArr = array(
					'afile_type'=>$fileType,
					'afile_record_id'=>$recordId,
					'afile_record_subid'=>$recordSubid,
					'afile_lang_id'=>$fileLangId,
					'afile_physical_path'=>$filePath,
					'afile_name'=>$fileName,
					'afile_display_order'=>$displayOrder,
				);

				$saveToTempTable = false;
				$isUrlArr = parse_url($filePath);

				if(is_array($isUrlArr) && isset($isUrlArr['host'])){
					$saveToTempTable = true;
				}

				if($saveToTempTable){
					$dataToSaveArr['afile_downloaded'] = applicationConstants::NO;
					$dataToSaveArr['afile_unique'] = applicationConstants::YES;
					$this->db->deleteRecords ( AttachedFile::DB_TBL_TEMP, array (
						'smt' => 'afile_type = ? AND afile_record_id = ? AND afile_record_subid = ? AND afile_lang_id = ?',
						'vals' => array ($fileType, $recordId, $recordSubid, $fileLangId)
					) );
					$this->db->insertFromArray( AttachedFile::DB_TBL_TEMP, $dataToSaveArr,false,array(),$dataToSaveArr);
				}else{
					$this->db->deleteRecords ( AttachedFile::DB_TBL, array (
							'smt' => 'afile_type = ? AND afile_record_id = ? AND afile_record_subid = ? AND afile_lang_id = ?',
							'vals' => array ($fileType, $recordId, $recordSubid, $fileLangId)
					) );
					$this->db->insertFromArray( AttachedFile::DB_TBL, $dataToSaveArr,false,array(),$dataToSaveArr);
				}
			}
			$rowCount++;
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );


		$success['status'] = 1;
		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportBrands($langId,$userId = 0){
		$userId = FatUtility::int($userId);
		if(!$userId){
			/*Fetch all seo keyword [*/
			$urlKeywords = $this->getAllRewriteUrls(Brand::REWRITE_URL_PREFIX);
			/*]*/
		}

		$srch = Brand::getSearchObject($langId);
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$srch->addMultipleFields(array('brand_id','brand_identifier','iFNULL(brand_name,brand_identifier) as brand_name','brand_short_description','brand_featured','brand_active'));
		$srch->addCondition('brand_status','=',applicationConstants::ACTIVE);
		if($userId){
			$srch->addCondition('brand_active','=',applicationConstants::ACTIVE);
			$srch->addOrder('brand_id');
		}
		$rs = $srch->getResultSet();

		$sheetData = array();

		/* Sheet Heading Row [ */
		$headingsArr = $this->getBrandColoumArr($langId, $userId);
		array_push( $sheetData, $headingsArr );
		/* ] */
		// $data = $this->db->fetchAll($rs);

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){
			foreach ($headingsArr as $columnKey => $heading) {

				$colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';

				if( in_array( $columnKey, array( 'brand_featured', 'brand_active' ) ) && !$this->settings['CONF_USE_O_OR_1'] ){
					$colValue = (FatUtility::int($colValue) == 1) ? 'YES' : 'NO';
				}

				if(  'urlrewrite_custom' == $columnKey ){
					$colValue = isset($urlKeywords[Brand::REWRITE_URL_PREFIX.$row['brand_id']]) ? $urlKeywords[Brand::REWRITE_URL_PREFIX.$row['brand_id']] : '';
				}

				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return $sheetData;
	}



	public function importBrands($csvFilePointer,$post,$langId,$userId = null){

		$rowIndex = 0;
		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){

			$rowIndex++;
			if($rowIndex == 1){
				$coloumArr = $this->getBrandColoumArr($langId, $userId);

				if(!$this->isValidColumns( $row, $coloumArr )){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndexArr = array_flip($row);

				$errfileName = $this->logFileName('Brands');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$brandDataArr = $brandlangDataArr = array();
			$error = $seoUrl = false;

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndexArr[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( 'brand_id' == $columnKey && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0", $langId ) );
				}else if( in_array( $columnKey,array('brand_identifier','brand_name') ) && $colValue == '' ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_is_mandatory.", $langId ) );
				}

				if($errMsg){
					$err = array($rowIndex,( $colIndex + 1),$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{
					if( in_array( $columnKey,array('brand_featured', 'brand_active') ) ){
						if($this->settings['CONF_USE_O_OR_1']){
							$colValue = (FatUtility::int($colValue) == 1)?applicationConstants::YES:applicationConstants::NO;
						}else{
							$colValue = (strtoupper($colValue) == 'YES')?applicationConstants::YES:applicationConstants::NO;
						}
					}


					if( in_array( $columnKey, array( 'brand_name', 'brand_short_description' ) ) ){
						$brandlangDataArr[$columnKey] = $colValue;
					}else if( 'urlrewrite_custom' == $columnKey ){
						$seoUrl = $colValue;
					}else{
						$brandDataArr['brand_status'] = applicationConstants::ACTIVE;
						$brandDataArr[$columnKey] = $colValue;
					}
				}
			}

			if( !$error && count($brandDataArr) ){

				if( $this->settings['CONF_USE_BRAND_ID'] ){
					$brandId = $brandDataArr['brand_id'];
					$brandData = Brand::getAttributesById($brandId,array('brand_id'));
				}else{
					$identifier = $brandDataArr['brand_identifier'];
					$brandData = Brand::getAttributesByIdentifier($identifier,array('brand_id'));
					$brandId = $brandData['brand_id'];
				}

				if(!empty( $brandData ) && $brandData['brand_id'] ){
					$where = array('smt' => 'brand_id = ?', 'vals' => array( $brandId ) );
					$this->db->updateFromArray( Brand::DB_TBL, $brandDataArr, $where);
				}else{
					if( $this->isDefaultSheetData($langId) ){
						$this->db->insertFromArray( Brand::DB_TBL, $brandDataArr);
						$brandId = $this->db->getInsertId();
					}
				}

				if($brandId){
					/* Lang Data [*/
					$langData = array(
						'brandlang_brand_id'=> $brandId,
						'brandlang_lang_id'=> $langId,
					);
					$langData = array_merge( $langData, $brandlangDataArr );

					$this->db->insertFromArray( Brand::DB_LANG_TBL, $langData , false, array(),$langData );
					/* ]*/

					/* Url rewriting [*/
					if($this->isDefaultSheetData($langId)){
						if(!$seoUrl){
							$seoUrl = $brandDataArr['brand_identifier'];
						}
						$brand = new Brand($brandId);
						$brand->rewriteUrl($seoUrl);
					}
					/* ]*/
				}
			}
		}

		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportBrandMedia($langId){
		$srch = Brand::getSearchObject();
		$srch->joinTable(AttachedFile::DB_TBL,'INNER JOIN','brand_id = afile_record_id and afile_type = '.AttachedFile::FILETYPE_BRAND_LOGO);
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$srch->addMultipleFields(array('brand_id','brand_identifier','afile_record_id','afile_record_subid','afile_lang_id','afile_screen','afile_physical_path','afile_name','afile_display_order'));
		$srch->addCondition('brand_status','=',applicationConstants::ACTIVE);
		$rs = $srch->getResultSet();

		$sheetData = array();
		/* Sheet Heading Row [ */
		$arr = $this->getBrandMediaColoumArr($langId);
		array_push( $sheetData, $arr );
		/* ] */

		$languageCodes = Language::getAllCodesAssoc(true);

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();

			if($this->settings['CONF_USE_BRAND_ID']){
				$sheetArr[] = $row['brand_id'];
			}else{
				$sheetArr[] = $row['brand_identifier'];
			}

			if($this->settings['CONF_USE_LANG_ID']){
				$sheetArr[] = $row['afile_lang_id'];
			}else{
				$sheetArr[] = $languageCodes[$row['afile_lang_id']];
			}

			$sheetArr[] = $row['afile_physical_path'];
			$sheetArr[] = $row['afile_name'];
			$sheetArr[] = $row['afile_display_order'];
			array_push( $sheetData, $sheetArr );
		}

		return $sheetData;
	}

	public function importBrandsMedia($csvFilePointer,$post,$langId){
		$rowCount = 0;
		$languageCodes = Language::getAllCodesAssoc(true);
		$languageIds = array_flip($languageCodes);

		$brandIdentifiers =  Brand::getAllIdentifierAssoc();
		$brandIds = array_flip($brandIdentifiers);

		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			if(empty($line[0])){
				continue;
			}

			$numcols = count($line);
			$colCount = 0;

			if($rowCount == 0){
				$coloumArr = $this->getBrandMediaColoumArr($langId);
				if($line !== $coloumArr){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				continue;
			}

			if($this->settings['CONF_USE_BRAND_ID']){
				$brandId = FatUtility::int($line[$colCount++]);
			}else{
				$identifier = $line[$colCount++];
			}

			if($this->settings['CONF_USE_LANG_ID']){
				$landId = FatUtility::int($line[$colCount++]);
			}else{
				$langCode = $line[$colCount++];
			}

			$filePath = $line[$colCount++];
			$fileName = $line[$colCount++];
			$displayOrder = $line[$colCount++];

			if(!$numcols || $numcols != $colCount){
				Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
				FatUtility::dieJsonError( Message::getHtml() );
			}

			if($rowCount > 0){
				$fileType  = AttachedFile::FILETYPE_BRAND_LOGO;

				if($this->settings['CONF_USE_BRAND_ID']){
					$recordId = $brandId;
				}else{
					$recordId = $brandIds[$identifier];
				}

				if($this->settings['CONF_USE_LANG_ID']){
					$fileLangId = $landId;
				}else{
					$fileLangId = $languageIds[$langCode];
				}

				$recordSubid = 0;

				$dataToSaveArr = array(
					'afile_type'=>$fileType,
					'afile_record_id'=>$recordId,
					'afile_record_subid'=>$recordSubid,
					'afile_lang_id'=>$fileLangId,
					'afile_physical_path'=>$filePath,
					'afile_name'=>$fileName,
					'afile_display_order'=>$displayOrder,
				);

				$saveToTempTable = false;
				$isUrlArr = parse_url($filePath);

				if(is_array($isUrlArr) && isset($isUrlArr['host'])){
					$saveToTempTable = true;
				}

				if($saveToTempTable){
					$dataToSaveArr['afile_downloaded'] = applicationConstants::NO;
					$dataToSaveArr['afile_unique'] = applicationConstants::YES;
					$this->db->deleteRecords ( AttachedFile::DB_TBL_TEMP, array (
							'smt' => 'afile_type = ? AND afile_record_id = ? AND afile_record_subid = ? AND afile_lang_id = ?',
							'vals' => array ($fileType, $recordId, $recordSubid, $fileLangId)
					) );
					$this->db->insertFromArray( AttachedFile::DB_TBL_TEMP, $dataToSaveArr,false,array(),$dataToSaveArr);
				}else{
					$this->db->deleteRecords ( AttachedFile::DB_TBL, array (
							'smt' => 'afile_type = ? AND afile_record_id = ? AND afile_record_subid = ? AND afile_lang_id = ?',
							'vals' => array ($fileType, $recordId, $recordSubid, $fileLangId)
					) );
					$this->db->insertFromArray( AttachedFile::DB_TBL, $dataToSaveArr,false,array(),$dataToSaveArr);
				}
			}
			$rowCount++;
		}
		Message::addMessage(Labels::getLabel('LBL_data_imported/updated_Successfully',$langId));
		FatUtility::dieJsonSuccess(Message::getHtml());
	}

	public function exportProductsCatalog($langId,$offset = null,$noOfRows = null,$minId = null,$maxId = null, $userId = null){
		$userId = FatUtility::int($userId);
		$useProductId = false;
		if($this->settings['CONF_USE_PRODUCT_ID']){
			$useProductId = true;
		}

		if(!$this->settings['CONF_USE_PRODUCT_TYPE_ID']){
			$ProdTypeIdentifierById = Product::getProductTypes($langId);
		}

		if(!$this->settings['CONF_USE_TAX_CATEOGRY_ID']){
			$taxCategoryIdentifierById = $this->getTaxCategoriesArr();
		}

		if(!$this->settings['CONF_USE_DIMENSION_UNIT_ID']){
			$lengthUnitsArr = applicationConstants::getLengthUnitsArr($langId);
		}

		if(!$this->settings['CONF_USE_WEIGHT_UNIT_ID']){
			$weightUnitsArr = applicationConstants::getWeightUnitsArr($langId);
		}

		$srch = Product::getSearchObject($langId, false);
		$srch->joinTable(User::DB_TBL,'LEFT OUTER JOIN','u.user_id = tp.product_seller_id','u');
		$srch->joinTable(User::DB_TBL_CRED,'LEFT OUTER JOIN','uc.credential_user_id = tp.product_seller_id','uc');
		$srch->joinTable(Brand::DB_TBL,'LEFT OUTER JOIN','b.brand_id = tp.product_brand_id','b');
		if($userId){
			$srch->joinTable(Product::DB_TBL_PRODUCT_SHIPPING,'LEFT OUTER JOIN','ps.ps_product_id = tp.product_id and ps.ps_user_id = '.$userId,'ps');
		}else{
			$srch->joinTable(Product::DB_TBL_PRODUCT_SHIPPING,'LEFT OUTER JOIN','ps.ps_product_id = tp.product_id and ps.ps_user_id = tp.product_seller_id','ps');
		}
		$srch->joinTable(Countries::DB_TBL,'LEFT OUTER JOIN','c.country_id = ps.ps_from_country_id','c');
		//$srch->joinTable(Countries::DB_TBL,'LEFT OUTER JOIN','c.country_id = tp.product_ship_country','c');
		$srch->doNotCalculateRecords();
		$srch->addMultipleFields(array('tp.*','tp_l.*','ps.ps_from_country_id','ps.ps_free','user_id','credential_username','brand_id','brand_identifier','country_id','country_code'));
		if($userId){
			$cnd = $srch->addCondition('tp.product_seller_id','=',$userId,'OR');
			$cnd->attachCondition('tp.product_seller_id','=',0);
		}

		if (isset($offset) && isset($noOfRows)) {
			$srch->setPageNumber($offset);
			$srch->setPageSize($noOfRows);
		}else{
			$srch->setPageSize(static::MAX_LIMIT);
		}

		if (isset($minId) && isset($maxId)) {
			$srch->addCondition('product_id','>=',$minId);
			$srch->addCondition('product_id','<=',$maxId);
		}
		$rs = $srch->getResultSet();

		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getProductsCatalogColoumArr($langId, $userId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){

			$taxData = $this->getTaxCategoryByProductId($row['product_id']);
			if(!empty($taxData)){
				$row = array_merge( $row, $taxData );
			}

			foreach ($headingsArr as $columnKey => $heading) {

                $colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';

				if( in_array( $columnKey, array( 'brand_featured', 'brand_active' ) ) && !$this->settings['CONF_USE_O_OR_1'] ){
					$colValue = (FatUtility::int($colValue) == 1) ? 'YES' : 'NO';
				}

				if(  in_array( $columnKey, array( 'category_Id', 'category_indentifier' ) ) ){
					if( 'category_Id' == $columnKey ){
						$productCategories = $this->getProductCategoriesByProductId( $row['product_id'], false );
					}else{
						$productCategories = $this->getProductCategoriesByProductId( $row['product_id'] );
					}

					$colValue =  ( $productCategories ) ? implode(',',$productCategories) : '';
				}

				if(  'credential_username' == $columnKey ){
					$colValue = ( !empty( $row[$columnKey] ) && 0 < $userId ? $row['credential_username'] :  Labels::getLabel('LBL_Admin',$langId) );
				}

				if(  'product_type_identifier' == $columnKey ){
					$colValue = array_key_exists($row['product_type'], $ProdTypeIdentifierById) ? $ProdTypeIdentifierById[$row['product_type']] : 0;
				}

				if(  'tax_category_identifier' == $columnKey ){
					$colValue = array_key_exists($row['ptt_taxcat_id'], $taxCategoryIdentifierById) ? $taxCategoryIdentifierById[$row['ptt_taxcat_id']] : 0;
				}

				if(  'product_dimension_unit_identifier' == $columnKey ){
					$colValue = array_key_exists($row['product_dimension_unit'], $lengthUnitsArr) ? $lengthUnitsArr[$row['product_dimension_unit']] : '';
				}

				if(  'product_weight_unit_identifier' == $columnKey ){
					$colValue = array_key_exists($row['product_weight_unit'], $weightUnitsArr) ? $weightUnitsArr[$row['product_weight_unit']] : '';
				}

				// Not necessary
				// if(  'product_added_on' == $columnKey ){
				// 	$colValue = $this->displayDateTime($row[$columnKey]);
				// }

				if( in_array( $columnKey, array( 'ps_free', 'product_cod_enabled', 'product_featured', 'product_approved', 'product_active', 'product_deleted' ) ) && !$this->settings['CONF_USE_O_OR_1'] ){
					$colValue = (FatUtility::int($colValue) == 1) ? 'YES' : 'NO';
				}
				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}

		return $sheetData;
	}

	public function importProductsCatalog($csvFilePointer,$post,$langId, $sellerId = null){
		$sellerId = FatUtility::int($sellerId);

		$rowIndex = 0;
		$usernameArr = array();
		$categoryIdentifierArr = array();
		$brandIdentifierArr = array();
		$taxCategoryArr = array();
		$countryArr = array();

		if(!$this->settings['CONF_USE_PRODUCT_TYPE_ID']){
			$prodTypeIdentifierArr = Product::getProductTypes($langId);
			$prodTypeIdentifierArr = array_flip($prodTypeIdentifierArr);
		}

		if(!$this->settings['CONF_USE_DIMENSION_UNIT_ID']){
			$lengthUnitsArr = applicationConstants::getLengthUnitsArr($langId);
			$lengthUnitsArr = array_flip($lengthUnitsArr);
		}

		if(!$this->settings['CONF_USE_WEIGHT_UNIT_ID']){
			$weightUnitsArr = applicationConstants::getWeightUnitsArr($langId);
			$weightUnitsArr = array_flip($weightUnitsArr);
		}

		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){

			$rowIndex++;
			if($rowIndex == 1){
				$coloumArr = $this->getProductsCatalogColoumArr($langId, $sellerId);

				if( !$this->isValidColumns($row, $coloumArr) ){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndex = array_flip($row);

				$errfileName = $this->logFileName('Products_catalog');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$prodDataArr = $prodlangDataArr = array();
			$error = false;

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndex[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( in_array( $columnKey, array('product_id', 'product_brand_id', 'category_Id', 'tax_category_id', 'product_min_selling_price') ) && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0.", $langId ) );
				}else if( in_array( $columnKey, array( 'product_seller_id', 'product_type', 'product_ship_free') ) && 0 > FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_{column-name}_should_be_greater_than_equal_to_0.", $langId ) );
				}else if( in_array( $columnKey, array( 'product_model', 'product_name', 'product_identifier', 'credential_username', 'category_indentifier', 'brand_identifier', 'product_type_identifier', 'tax_category_identifier', 'product_dimension_unit_identifier', 'product_weight_unit_identifier', 'product_length', 'product_width', 'product_height', 'product_weight' ) ) && empty($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}', $heading ,Labels::getLabel( "MSG_{column-name}_is_mandatory.", $langId ) );
				}else if($sellerId && 'product_seller_id' == $columnKey ( $sellerId != $colValue || 1 > $colValue)){
					$error = true;
					$errMsg = Labels::getLabel( "MSG_Sorry_you_are_not_authorised_to_update_this_product.", $langId );
				}

				if( 'product_seller_id' == $columnKey && $this->settings['CONF_USE_USER_ID'] ){
					$userId = $colValue;
				}
				if( 'credential_username' == $columnKey && !$this->settings['CONF_USE_USER_ID'] ){
					$colValue = ( $colValue == Labels::getLabel('LBL_Admin',$langId) ? '' : $colValue );
					if(!empty($colValue) && !array_key_exists($colValue,$usernameArr)){
						$res = $this->getAllUserArr(false,$colValue);
						if(!$res){
							$errMsg = Labels::getLabel( "MSG_Invalid_User.", $langId );
							CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg  ) );
						}
						$usernameArr = array_merge($usernameArr,$res);
					}
					$userId = $colValue = isset($usernameArr[$colValue]) ? FatUtility::int( $usernameArr[$colValue] ) : 0;
				}

				if($this->settings['CONF_USE_PRODUCT_ID'] && 'product_id' == $columnKey){
					if($sellerId){
						$userTempIdData = $this->getProductIdByTempId($colValue,$userId);
						if(!empty($userTempIdData) && $userTempIdData['pti_product_temp_id'] == $colValue){
							$colValue = $userTempIdData['pti_product_id'];
						}
					}

					$prodDataArr['product_id'] = $colValue;

					$prodData = Product::getAttributesById($colValue,array('product_id','product_seller_id','product_featured','product_approved'));
				}else if($this->settings['CONF_USE_PRODUCT_ID'] && 'product_identifier' == $columnKey){
					$prodData = Product::getAttributesByIdentifier($colValue,array('product_id','product_seller_id','product_featured','product_approved'));
					if( $sellerId && !empty($prodData) && $prodData['product_seller_id'] != $sellerId ){
						$errMsg = str_replace( '{column-name}', 'Seller', Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
						CommonHelper::writeLogFile( $errFile, array($rowIndex, ( $colIndex + 1), $errMsg ) );
					}
				}

				if($errMsg){
					$err = array($rowIndex,( $colIndex + 1),$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{

					if( in_array( $columnKey,array( 'product_cod_enabled', 'product_featured', 'product_approved', 'product_active', 'product_deleted' ) ) ){
						if( $this->settings['CONF_USE_O_OR_1'] ){
							$colValue = ( FatUtility::int($colValue) == 1 ) ? applicationConstants::YES : applicationConstants::NO;
						}else{
							$colValue = ( strtoupper($colValue) == 'YES' ) ? applicationConstants::YES : applicationConstants::NO;
						}
					}

					if( $sellerId && 'product_added_on' == $columnKey ){
						$colValue = date('Y-m-d H:i:s');
					}

					if( 'tax_category_identifier' == $columnKey ){
						$catArr = array();

						$catIdentifiers = explode( ',', $colValue );
						if( !empty( $catIdentifiers ) ){
							foreach( $catIdentifiers as $val ){
								if( !array_key_exists($val, $categoryIdentifierArr) ){
									$res = $this->getAllCategoryIdentifiers(false,$val);
									if(!$res){
										$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_{column-name}_is_mandatory.", $langId ) );
										CommonHelper::writeLogFile( $errFile, array($rowIndex, ( $colIndex + 1), $errMsg ) );
										continue;
									}
									$categoryIdentifierArr = array_merge($categoryIdentifierArr,$res);
								}
								if(isset($categoryIdentifierArr[$val])){
									$catArr[] = $categoryIdentifierArr[$val];
								}
							}
						}
						$colValue = implode(',',$catArr);
					}

					if( 'brand_identifier' == $columnKey ){
						if(!array_key_exists($colValue,$brandIdentifierArr)){
							$res = $this->getAllBrandsArr(false,$colValue);
							if(!$res){
								$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
								CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
							}
							$brandIdentifierArr = array_merge($brandIdentifierArr,$res);
						}
						$colValue = isset($brandIdentifierArr[$colValue]) ? $brandIdentifierArr[$colValue] : 0;
					}

					if( 'product_type_identifier' == $columnKey ){
						if(!array_key_exists($colValue,$prodTypeIdentifierArr)){
							$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
							CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
						}
						$colValue = $prodTypeIdentifierArr[$colValue];
					}

					if( 'tax_category_identifier' == $columnKey ){
						if(!array_key_exists($colValue,$taxCategoryArr)){
							$res = $this->getTaxCategoriesArr(false,$colValue);
							if(!$res){
								$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
								CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
							}
							$taxCategoryArr = array_merge($taxCategoryArr,$res);
						}
						$colValue = isset($taxCategoryArr[$colValue]) ? $taxCategoryArr[$colValue] : 0;
					}

					if( 'product_dimension_unit_identifier' == $columnKey ){
						if( !array_key_exists($colValue,$lengthUnitsArr) ){
							$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
							CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
						}
						$colValue = $lengthUnitsArr[$colValue];
					}

					if( 'product_weight_unit_identifier' == $columnKey ){
						if(!array_key_exists($colValue,$weightUnitsArr)){
							$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
							CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
						}
						$colValue = $weightUnitsArr[$colValue];
					}

					if( 'product_ship_country_code' == $columnKey ){
						if(!array_key_exists($colValue,$countryArr)){
							$res = $this->getCountriesArr(false,$colValue);
							if(!$res){
								$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
								CommonHelper::writeLogFile( $errFile, array($rowIndex, ( $colIndex + 1), $errMsg ) );
							}
							$countryArr = array_merge($countryArr,$res);
						}
						$colValue = isset($countryArr[$colValue]) ? $countryArr[$colValue] : 0;
					}

					if( in_array( $columnKey, array( 'product_name', 'product_description', 'product_youtube_video' ) ) ){
						$prodlangDataArr[$columnKey] = $colValue;
					}else{
						$prodDataArr[$columnKey] = $colValue;
					}
				}
			}

			if( !$error && count($prodDataArr) ){

				$prodDataArr['product_added_by_admin_id'] = ( array_key_exists( 'user_id', $prodDataArr ) ) ? applicationConstants::YES : applicationConstants::NO;

				if( !empty($prodData) && $prodData['product_id'] && ( !$sellerId || ($sellerId && $prodData['product_seller_id'] == $sellerId) ) ){
					unset($prodData['product_seller_id']);
					$productId = $prodData['product_id'];

					if($sellerId){
						$prodDataArr['product_featured'] = $prodData['product_featured'] ;
						$prodDataArr['product_approved'] = $prodData['product_approved'] ;
						unset($prodDataArr['product_added_on']);
					}

					$where = array('smt' => 'product_id = ?', 'vals' => array( $productId ) );
					$this->db->updateFromArray( Product::DB_TBL, $prodDataArr,$where);

					if($sellerId && $this->isDefaultSheetData($langId)){
						$tempData = array(
							'pti_product_id' =>$productId,
							'pti_product_temp_id' =>($sellerTempId) ? $sellerTempId : $productId,
							'pti_user_id' =>$userId,
						);
						$this->db->deleteRecords( Importexport::DB_TBL_TEMP_PRODUCT_IDS, array('smt'=> 'pti_product_id = ? and pti_user_id = ?','vals' => array($productId,$userId) ) );
						$this->db->insertFromArray( Importexport::DB_TBL_TEMP_PRODUCT_IDS, $tempData,false,array(),$tempData );
					}

				}else{
					if($this->isDefaultSheetData($langId)){
						if($sellerId){
							unset($prodDataArr['product_id']);
							unset($prodDataArr['product_featured']);
							if(FatApp::getConfig("CONF_CUSTOM_PRODUCT_REQUIRE_ADMIN_APPROVAL", FatUtility::VAR_INT, 1)){
								$prodDataArr['product_approved'] = applicationConstants::NO;
							}
						}
						$this->db->insertFromArray( Product::DB_TBL, $prodDataArr);
						$productId = $this->db->getInsertId();

						if($sellerId){
							$tempData = array(
								'pti_product_id' =>$productId,
								'pti_product_temp_id' =>($sellerTempId)?$sellerTempId:$productId,
								'pti_user_id' =>$userId,
							);
							$this->db->deleteRecords( Importexport::DB_TBL_TEMP_PRODUCT_IDS, array('smt'=> 'pti_product_id = ? and pti_user_id = ?','vals' => array($productId,$userId) ) );
							$this->db->insertFromArray( Importexport::DB_TBL_TEMP_PRODUCT_IDS, $tempData,false,array(),$tempData );
						}
					}
				}

				if($productId){

					if($this->isDefaultSheetData($langId)){
						$productSellerShiping = array(
							'ps_product_id'=>$productId,
							'ps_user_id'=>$userId,
							'ps_from_country_id'=>$countryId,
							'ps_free'=>$product_ship_free,
						);
						FatApp::getDb()->insertFromArray(PRODUCT::DB_TBL_PRODUCT_SHIPPING,$productSellerShiping,false,array(),$productSellerShiping);
					}

					/* Lang Data [*/
					$langData = array(
						'productlang_product_id'=> $productId,
						'productlang_lang_id'=> $langId,
					);

					$langData = array_merge( $langData, $prodlangDataArr );

					$this->db->insertFromArray( Product::DB_LANG_TBL, $langData , false, array(),$langData );
					/* ]*/

					if($this->isDefaultSheetData($langId)){
						/* Product Categories [*/
						$this->db->deleteRecords( Product::DB_TBL_PRODUCT_TO_CATEGORY, array('smt'=> Product::DB_TBL_PRODUCT_TO_CATEGORY_PREFIX.'product_id = ?','vals' => array($productId) ) );

						$categoryIdsArr = explode(',',$categoryIds);
						if(!empty($categoryIdsArr)){
							foreach($categoryIdsArr as $catId){
								$catData = array(
									'ptc_product_id'=>$productId,
									'ptc_prodcat_id'=>$catId
								);
								$this->db->insertFromArray( Product::DB_TBL_PRODUCT_TO_CATEGORY, $catData );
							}
						}
						/*]*/

						/* Tax Category [*/
						$this->db->deleteRecords( Tax::DB_TBL_PRODUCT_TO_TAX, array('smt'=> 'ptt_product_id = ? and ptt_seller_user_id = ?','vals' => array($productId,$userId) ) );
						if($taxCatId){
							$this->db->insertFromArray( Tax::DB_TBL_PRODUCT_TO_TAX, array('ptt_product_id'=>$productId,'ptt_taxcat_id'=>$taxCatId,'ptt_seller_user_id'=>$userId) );
						}
						/*]*/
					}
				}
			}
		}

		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportProductOptions($langId,$offset = null,$noOfRows = null,$minId = null,$maxId = null, $userId = null){
		$userId = FatUtility::int($userId);
		$srch = Product::getSearchObject();
		$srch->joinTable( Product::DB_PRODUCT_TO_OPTION, 'INNER JOIN', Product::DB_TBL_PREFIX.'id = '.Product::DB_PRODUCT_TO_OPTION_PREFIX.'product_id');
		$srch->joinTable( Option::DB_TBL, 'INNER JOIN', Option::DB_TBL_PREFIX.'id = '.Product::DB_PRODUCT_TO_OPTION_PREFIX.'option_id');
		$srch->addMultipleFields(array('option_id','option_identifier','product_id','product_identifier'));
		$srch->doNotCalculateRecords();
		if($userId){
			$cnd = $srch->addCondition('tp.product_seller_id','=',$userId,'OR');
			$cnd->attachCondition('tp.product_seller_id','=',0);
		}

		if (isset($offset) && isset($noOfRows)) {
			$srch->setPageNumber($offset);
			$srch->setPageSize($noOfRows);
		}else{
			$srch->setPageSize(static::MAX_LIMIT);
		}

		if (isset($minId) && isset($maxId)) {
			$srch->addCondition('product_id','>=',$minId);
			$srch->addCondition('product_id','<=',$maxId);
		}
		$srch->addOrder('product_id');
		$rs = $srch->getResultSet();

		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getProductOptionColoumArr($langId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){

			foreach ($headingsArr as $columnKey => $heading) {

                $colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';
				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;

		}
		return $sheetData;
	}

	public function importProductOptions($csvFilePointer,$post,$langId, $userId = null){

		$userId = FatUtility::int( $userId );
		$rowIndex = 0;
		$prodIndetifierArr = array();
		$optionIdentifierArr = array();
		$prodArr = array();
		while( ( $row = $this->getFileContent( $csvFilePointer ) ) !== FALSE ){
			$rowIndex++;

			if($rowIndex == 1){
				$coloumArr = $this->getProductOptionColoumArr($langId);

				if(!$this->isValidColumns( $row, $coloumArr )){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndexArr = array_flip($row);

				$errfileName = $this->logFileName('Product_Options');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$optionsArr = array();
			$error = false;

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndexArr[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( in_array( $columnKey, array( 'product_id','option_id' ) ) && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0", $langId ) );
				}

				if( in_array( $columnKey, array( 'product_identifier','option_identifier' ) ) && empty( $colValue ) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_is_mandatory.", $langId ) );
				}

				if($errMsg){
					$err = array($rowIndex,( $colIndex + 1),$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{
					if( in_array( $columnKey,array( 'product_identifier', 'option_identifier' ) ) ){

						$invalidIdentifier = false;

						if( 'product_identifier' == $columnKey ){
							if( !array_key_exists( $colValue, $prodIndetifierArr ) ){
								$res = $this->getAllProductsIdentifiers( false, $colValue );
								if( !$res ){
									$invalidIdentifier = true;
								}else{
									$prodIndetifierArr = array_merge( $prodIndetifierArr, $res );
								}
							}
							$colValue =   array_key_exists( $colValue, $prodIndetifierArr ) ? $prodIndetifierArr[$colValue] : 0;
						}else{
							if(!array_key_exists($colValue,$optionIdentifierArr)){
								$res = $this->getAllOptions(false,$colValue);
								if( !$res ){
									$invalidIdentifier = true;
								}else{
									$optionIdentifierArr = array_merge($optionIdentifierArr,$res);
								}
							}
							$colValue = array_key_exists( $colValue, $optionIdentifierArr ) ? $optionIdentifierArr[$colValue] : 0;
						}

						if( $invalidIdentifier ){
							$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_{column-name}_is_invalid", $langId ) );
							CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
						}
					}

					if( in_array( $columnKey, array( 'product_id', 'product_identifier' ) ) ){
						$columnKey = 'prodoption_product_id';

						if( $userId ){
							$colValue = $this->getCheckAndSetProductIdByTempId( $colValue, $userId );
						}

						$productId = $colValue;
					}

					if( in_array( $columnKey, array( 'option_id', 'option_identifier' ) ) ){
						$columnKey = 'prodoption_option_id';
					}
					$optionsArr[$columnKey] = $colValue;
				}
			}

			if( !$error && count( $optionsArr ) ){
				if( !in_array( $productId, $prodArr ) ){
					$prodArr[] = $productId;
					$this->db->deleteRecords( Product::DB_PRODUCT_TO_OPTION, array('smt'=> 'prodoption_product_id = ? ','vals' => array( $productId ) ) );
				}

				$this->db->insertFromArray( Product::DB_PRODUCT_TO_OPTION, $optionsArr );
			}
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportProductTags($langId,$offset = null,$noOfRows = null,$minId = null,$maxId = null, $userId = null){
		$userId = FatUtility::int($userId);
		$srch = Product::getSearchObject();
		$srch->joinTable( Product::DB_PRODUCT_TO_TAG, 'INNER JOIN', Product::DB_TBL_PREFIX.'id = '.Product::DB_PRODUCT_TO_TAG_PREFIX.'product_id');
		$srch->joinTable( Tag::DB_TBL, 'INNER JOIN', Tag::DB_TBL_PREFIX.'id = '.Product::DB_PRODUCT_TO_TAG_PREFIX.'tag_id');
		$srch->addMultipleFields(array('tag_id','tag_identifier','product_id','product_identifier'));
		$srch->doNotCalculateRecords();
		if($userId){
			$cnd = $srch->addCondition('tp.product_seller_id','=',$userId,'OR');
			$cnd->attachCondition('tp.product_seller_id','=',0);
		}

		if (isset($offset) && isset($noOfRows)) {
			$srch->setPageNumber($offset);
			$srch->setPageSize($noOfRows);
		}else{
			$srch->setPageSize(static::MAX_LIMIT);
		}

		if (isset($minId) && isset($maxId)) {
			$srch->addCondition('product_id','>=',$minId);
			$srch->addCondition('product_id','<=',$maxId);
		}
		$srch->addOrder('product_id');
		$rs = $srch->getResultSet();
		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getProductTagColoumArr($langId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){

			foreach ($headingsArr as $columnKey => $heading) {
                $colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';
				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return $sheetData;
	}

	public function importProductTags($csvFilePointer,$post,$langId, $userId = null){

		$userId = FatUtility::int($userId);

		$rowIndex = 0;
		$prodIndetifierArr = array();
		$tagIndetifierArr = array();
		$prodArr = array();

		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;

			if($rowIndex == 1){
				$coloumArr = $this->getProductTagColoumArr($langId);

				if(!$this->isValidColumns( $row, $coloumArr )){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndexArr = array_flip($row);

				$errfileName = $this->logFileName('Product_Tags');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$tagsArr = array();
			$error = false;

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndexArr[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( in_array( $columnKey, array( 'product_id','tag_id' ) ) && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0", $langId ) );
				}

				if( in_array( $columnKey, array( 'product_identifier','tag_identifier' ) ) && empty( $colValue ) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_is_mandatory.", $langId ) );
				}

				if($errMsg){
					$err = array($rowIndex,( $colIndex + 1),$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{
					if( in_array( $columnKey,array( 'product_identifier', 'tag_identifier' ) ) ){

						$invalidIdentifier = false;

						if( 'product_identifier' == $columnKey ){
							if( !array_key_exists( $colValue, $prodIndetifierArr ) ){
								$res = $this->getAllProductsIdentifiers( false, $colValue );
								if( !$res ){
									$invalidIdentifier = true;
								}else{
									$prodIndetifierArr = array_merge( $prodIndetifierArr, $res );
								}
							}
							$colValue =   array_key_exists( $colValue, $prodIndetifierArr ) ? $prodIndetifierArr[$colValue] : 0;
						}else{
							if( !array_key_exists( $colValue, $tagIndetifierArr) ){
								$res = $this->getAllTags(false,$colValue);
								if( !$res ){
									$invalidIdentifier = true;
								}else{
									$tagIndetifierArr = array_merge($tagIndetifierArr,$res);
								}
							}
							$colValue = array_key_exists( $colValue, $tagIndetifierArr ) ? $tagIndetifierArr[$colValue] : 0;
						}

						if( $invalidIdentifier ){
							$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_{column-name}_is_invalid", $langId ) );
							CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
						}
					}

					if( in_array( $columnKey, array( 'product_id', 'product_identifier' ) ) ){
						$columnKey = 'ptt_product_id';

						if( $userId ){
							$colValue = $this->getCheckAndSetProductIdByTempId( $colValue, $userId );
						}

						$productId = $colValue;
					}

					if( in_array( $columnKey, array( 'tag_id', 'tag_identifier' ) ) ){
						$columnKey = 'ptt_tag_id';
					}
					$tagsArr[$columnKey] = $colValue;
				}
			}

			if( !$error && count( $tagsArr ) ){
				if( !in_array( $productId, $prodArr ) ){
					$prodArr[] = $productId;
					$this->db->deleteRecords( Product::DB_PRODUCT_TO_TAG, array('smt'=> 'ptt_product_id = ? ','vals' => array($productId) ) );
				}

				$this->db->insertFromArray( Product::DB_PRODUCT_TO_TAG, $tagsArr );
			}
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportProductSpecification($langId,$offset = null,$noOfRows = null,$minId = null,$maxId = null, $userId = null){
		$userId = FatUtility::int($userId);
		$srch = Product::getSearchObject();
		$srch->joinTable( Product::DB_PRODUCT_SPECIFICATION, 'INNER JOIN', Product::DB_TBL_PREFIX.'id = '.Product::DB_PRODUCT_SPECIFICATION_PREFIX.'product_id');
		$srch->joinTable( Product::DB_PRODUCT_LANG_SPECIFICATION, 'LEFT OUTER JOIN', Product::DB_PRODUCT_SPECIFICATION_PREFIX.'id = '.Product::DB_PRODUCT_LANG_SPECIFICATION_PREFIX.'prodspec_id');
		$srch->addMultipleFields(array('prodspec_id','prodspeclang_lang_id','prodspec_name','prodspec_value','product_id','product_identifier'));
		$srch->joinTable( Language::DB_TBL, 'INNER JOIN', 'language_id = prodspeclang_lang_id');
		$srch->doNotCalculateRecords();
		if($userId){
			$cnd = $srch->addCondition('tp.product_seller_id','=',$userId,'OR');
			$cnd->attachCondition('tp.product_seller_id','=',0);
		}

		if (isset($offset) && isset($noOfRows)) {
			$srch->setPageNumber($offset);
			$srch->setPageSize($noOfRows);
		}else{
			$srch->setPageSize(static::MAX_LIMIT);
		}

		if (isset($minId) && isset($maxId)) {
			$srch->addCondition('product_id','>=',$minId);
			$srch->addCondition('product_id','<=',$maxId);
		}
		$srch->addCondition('language_active','=',applicationConstants::ACTIVE);

		$srch->addOrder('product_id');
		$srch->addOrder('prodspec_id');

		$rs = $srch->getResultSet();

		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getProductSpecificationColoumArr($langId);

		array_push( $sheetData, $headingsArr );
		/* ] */
		$languageCodes = Language::getAllCodesAssoc();

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){

			foreach ($headingsArr as $columnKey => $heading) {

                $colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';
				if( 'prodspeclang_lang_code' == $columnKey ){
					$colValue = $languageCodes[ $row['prodspeclang_lang_id'] ];
				}
				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return $sheetData;
	}

	public function importProductSpecifications($csvFilePointer,$post,$langId, $userId = null){

		$userId = FatUtility::int($userId);
		$rowIndex = 0;
		$prodIndetifierArr = array();
		$prodArr = array();
		$langArr = array();
		$languageCodes = Language::getAllCodesAssoc();
		$languageCodes = array_flip($languageCodes);

		$prodspec_id = 0;
		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;

			if($rowIndex == 1){
				$coloumArr = $this->getProductSpecificationColoumArr($langId);

				if(!$this->isValidColumns( $row, $coloumArr )){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndexArr = array_flip($row);

				$errfileName = $this->logFileName('Product_Specifications');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$prodSpecArr = $prodSpecLangArr = array();
			$error = false;

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndexArr[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( in_array( $columnKey,array('product_id','prodspeclang_lang_id') ) && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0", $langId ) );
				}

				if( in_array( $columnKey,array('product_identifier', 'prodspeclang_lang_code', 'prodspec_name', 'prodspec_value') ) && $colValue == '' ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_is_mandatory.", $langId ) );
				}

				if($errMsg){
					$err = array($rowIndex,( $colIndex + 1),$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{
					if( 'product_identifier' == $columnKey ){
						if( !array_key_exists( $colValue, $prodIndetifierArr ) ){
							$res = $this->getAllProductsIdentifiers( false, $colValue );

							if( !$res ){
								$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_{column-name}_is_invalid", $langId ) );
								CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
							}else{
								$prodIndetifierArr = array_merge( $prodIndetifierArr, $res );
							}

						}
						$colValue =   array_key_exists( $colValue, $prodIndetifierArr ) ? $prodIndetifierArr[$colValue] : 0;
					}

					if( in_array( $columnKey, array( 'product_id', 'product_identifier' ) ) ){

						if( $userId ){
							$colValue = $this->getCheckAndSetProductIdByTempId( $colValue, $userId );
						}

						$productId = $colValue;
					}

					if( 'prodspeclang_lang_id' == $columnKey ){
						$languageId = $colValue;
					}
					if( 'prodspeclang_lang_code' == $columnKey ){
						$colValue =  array_key_exists($colValue, $languageCodes) ? $languageCodes[$colValue] : 0;
						if( 0 >= $colValue ){
							$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_is_invalid.", $langId ) );
							CommonHelper::writeLogFile( $errFile, array($rowIndex, ( $colIndex + 1), $errMsg) );
						}
						$languageId = $colValue;
					}

					if( in_array( $columnKey, array( 'prodspeclang_lang_id', 'prodspec_name', 'prodspec_value' ) ) ){
						$prodSpecLangArr[$columnKey] = $colValue;
					}else{
						$prodSpecArr[$columnKey] = $colValue;
					}
				}
			}

			if( !$error && count( $prodSpecArr ) ){
				if( !array_key_exists( $productId, $prodArr ) ){
					$prodArr[] = $productId;

					$srch = new SearchBase( Product::DB_PRODUCT_SPECIFICATION );
					$srch->addCondition( Product::DB_PRODUCT_SPECIFICATION_PREFIX . 'product_id', '=', $productId );
					$rs = $srch->getResultSet();
					$res = FatApp::getDb()->fetchAll($rs);
					foreach($res as $val){
						$this->db->deleteRecords( Product::DB_PRODUCT_LANG_SPECIFICATION, array('smt'=> 'prodspeclang_prodspec_id = ? ','vals' => array($val['prodspec_id']) ) );
					}
					$this->db->deleteRecords( Product::DB_PRODUCT_SPECIFICATION, array('smt'=> 'prodspec_product_id = ? ','vals' => array( $productId ) ) );
				}

				if( !array_key_exists( $languageId, $langArr ) ){
					$langArr[] = $languageId;
					if( !$prodspec_id ){
						$this->db->insertFromArray( Product::DB_PRODUCT_SPECIFICATION, array('prodspec_product_id' => $productId) );
						$prodspec_id = $this->db->getInsertId();
					}
				}else{
					// continue lang loop
					$langArr = array();
					$langArr[] = $languageId;
					$this->db->insertFromArray( Product::DB_PRODUCT_SPECIFICATION, array('prodspec_product_id' => $productId) );
					$prodspec_id = $this->db->getInsertId();
				}

				$langData = array(
					'prodspeclang_prodspec_id'=>$prodspec_id
				);
				$langData = array_merge( $langData, $prodSpecLangArr );

				$this->db->insertFromArray( Product::DB_PRODUCT_LANG_SPECIFICATION, $langData );
			}
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportProductShipping($langId,$offset = null,$noOfRows = null,$minId = null,$maxId = null, $userId = null){
		$userId = FatUtility::int($userId);
		$srch = Product::getSearchObject();
		$srch->joinTable( Product::DB_PRODUCT_TO_SHIP, 'INNER JOIN', Product::DB_TBL_PREFIX.'id = '.Product::DB_PRODUCT_TO_SHIP_PREFIX.'prod_id','tpsr');
		$srch->joinTable(ShippingCompanies::DB_TBL, 'LEFT OUTER JOIN', ShippingCompanies::DB_TBL_PREFIX.'id = tpsr.pship_company' , 'tsc');
		$srch->joinTable(ShippingDurations::DB_TBL, 'LEFT OUTER JOIN', 'tpsr.pship_duration=tsd.sduration_id', 'tsd');
		$srch->joinTable(ShippingMethods::DB_TBL, 'LEFT OUTER JOIN', 'tpsr.pship_method = tsm.shippingapi_id', 'tsm');
		$srch->joinTable(Countries::DB_TBL, 'LEFT OUTER JOIN', 'tpsr.pship_country = c.country_id', 'c');
		$srch->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'tpsr.pship_user_id = u.user_id', 'u');
		$srch->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'tpsr.pship_user_id = uc.credential_user_id', 'uc');
		$srch->addMultipleFields(array('product_id','product_identifier','scompany_id','scompany_identifier','shippingapi_id','shippingapi_identifier','sduration_id','sduration_identifier','user_id','credential_username','country_id','country_code','pship_charges','pship_additional_charges'));
		$srch->doNotCalculateRecords();
		if($userId){
			$srch->addDirectCondition("( ( tp.product_seller_id = '".$userId."' and (tpsr.pship_user_id = '".$userId."' or tpsr.pship_user_id = 0)) or (tp.product_seller_id = 0 and (tpsr.pship_user_id = '".$userId."' or tpsr.pship_user_id = 0)))");
		}

		if (isset($offset) && isset($noOfRows)) {
			$srch->setPageNumber($offset);
			$srch->setPageSize($noOfRows);
		}else{
			$srch->setPageSize(static::MAX_LIMIT);
		}

		if (isset($minId) && isset($maxId)) {
			$srch->addCondition('product_id','>=',$minId);
			$srch->addCondition('product_id','<=',$maxId);
		}
		$srch->addOrder('product_id');
		$rs = $srch->getResultSet();

		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getProductShippingColoumArr($langId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){

			foreach ($headingsArr as $columnKey => $heading) {

				$colValue = array_key_exists( $columnKey, $row ) ? $row[$columnKey] : '';

				if(  'user_id' == $columnKey ){
					$colValue = $colValue == '' ? 0 : $colValue;
				}
				if(  'credential_username' == $columnKey ){
					$colValue = !empty( $row['credential_username'] ) ? $row['credential_username'] : Labels::getLabel('LBL_Admin',$langId) ;
				}

				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}

		return $sheetData;
	}

	public function importProductShipping($csvFilePointer,$post,$langId, $userId = null){

		$sellerId = FatUtility::int($userId);
		$rowIndex = 0;
		$prodIndetifierArr = array();
		$prodArr = array();
		$usernameArr = array();
		$scompanyIdentifierArr = array();
		$durationIdentifierArr = array();
		$countryCodeArr = array();

		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;

			if($rowIndex == 1){
				$coloumArr = $this->getProductShippingColoumArr($langId);

				if(!$this->isValidColumns( $row, $coloumArr )){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndexArr = array_flip($row);

				$errfileName = $this->logFileName('Product_Shipping');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$prodShipArr = array();
			$error = false;

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndexArr[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( in_array( $columnKey, array('product_id', 'country_id', 'scompany_id', 'sduration_id', 'pship_charges') ) && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0", $langId ) );
				}

				if( in_array( $columnKey,array('product_identifier', 'credential_username', 'country_code', 'scompany_identifier', 'sduration_identifier', 'pship_charges', 'user_id', 'credential_username' ) ) && $colValue == '' ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_is_mandatory.", $langId ) );
				}

				if( in_array( $columnKey, array( 'user_id', 'credential_username' ) ) ){
					if( !empty( $sellerId ) && $sellerId != $colValue){
						$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_You_are_not_allowed_to_update_this_record", $langId ) );
					}
				}

				if($errMsg){
					$err = array($rowIndex, ( $colIndex + 1), $errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{
					$errMsg = '';

					if( in_array( $columnKey, array( 'product_id', 'product_identifier' ) ) ){

						if( 'product_identifier' == $columnKey && !array_key_exists( $colValue, $prodIndetifierArr ) ){
							$res = $this->getAllProductsIdentifiers( false, $colValue );

							if( !$res ){
								$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_{column-name}_is_invalid", $langId ) );
								CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
							}else{
								$prodIndetifierArr = array_merge( $prodIndetifierArr, $res );
							}

						}
						$colValue =   array_key_exists( $colValue, $prodIndetifierArr ) ? $prodIndetifierArr[$colValue] : 0;

						if( $userId ){
							$colValue = $this->getCheckAndSetProductIdByTempId( $colValue, $userId );
						}

						$productId = $colValue;

						/* Product Ship By Seller [ */
						$srch = new ProductSearch($langId);
						$srch->joinProductShippedBySeller($sellerId);
						$srch->addCondition( 'psbs_user_id', '=',$sellerId);
						$srch->addCondition( 'product_id', '=',$productId);
						$srch->addFld('psbs_user_id');
						$rs = $srch->getResultSet();
						$shipBySeller = FatApp::getDb()->fetch($rs);
						/* ] */

						if( empty($shipBySeller) && $sellerId > 0 ) {
							$colValue = $productId = $this->getCheckAndSetProductIdByTempId($productId,$sellerId);
						}

						if( !$productId ){
							$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_{column-name}_is_invalid", $langId ) );
							$err = array($rowIndex, ( $colIndex + 1), $errMsg);
							CommonHelper::writeLogFile( $errFile,  $err);
						}
						$columnKey = 'pship_prod_id';
					}

					if( 'user_id' == $columnKey ){ $columnKey = 'pship_user_id'; }
					if( 'credential_username' == $columnKey ){
						$columnKey = 'pship_user_id';
						$colValue = ( $colValue == Labels::getLabel('LBL_Admin',$langId) ? '' : $colValue );
						if(!empty($colValue) && !array_key_exists($colValue,$usernameArr)){
							$res = $this->getAllUserArr( false, $colValue );
							if(!$res){
								$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_{column-name}_is_invalid", $langId ) );
								$err = array($rowIndex,$colCount,$errMsg);
								CommonHelper::writeLogFile( $errFile,  $err);
							}else{
								$usernameArr = array_merge( $usernameArr, $res );
							}
						}
						$colValue = array_key_exists( $colValue, $usernameArr ) ? $usernameArr[$colValue] : 0;
						if( $sellerId && $sellerId != $colValue ){
							$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_{column-name}_is_invalid", $langId ) );
							$err = array($rowIndex, ( $colIndex + 1), $errMsg);
							CommonHelper::writeLogFile( $errFile,  $err);
						}
					}

					if( 'country_code' == $columnKey ){
						if( 'country_code' == $columnKey && !array_key_exists($colValue, $countryCodeArr) ){
							$res = $this->getCountriesArr(false,$colValue);
							if( !$res ){
								$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_{column-name}_is_invalid", $langId ) );
								$err = array($rowIndex, ( $colIndex + 1), $errMsg);
								CommonHelper::writeLogFile( $errFile,  $err);
							}else{
								$countryCodeArr = array_merge($countryCodeArr,$res);
							}
						}
						$colValue = array_key_exists($colValue, $countryCodeArr) ? $countryCodeArr[$colValue] : 0;
					}

					if( in_array( $columnKey, array( 'country_id', 'country_code' ) ) ){
						$columnKey = 'pship_country';
						$colValue = ($colValue) ? $colValue : -1;
					}

					if( 'scompany_id' == $columnKey ){ $columnKey = 'pship_company'; }
					if( 'scompany_identifier' == $columnKey ){
						$columnKey = 'pship_company';
						if( !array_key_exists( $colValue, $scompanyIdentifierArr ) ){
							$res = $this->getAllShippingCompany(false,$colValue);
							if(!$res){
								$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_{column-name}_is_invalid", $langId ) );
								$err = array( $rowIndex, ( $colIndex + 1), $errMsg );
								CommonHelper::writeLogFile( $errFile,  $err );
							}else{
								$scompanyIdentifierArr = array_merge($scompanyIdentifierArr,$res);
							}
						}
						$colValue = array_key_exists($colValue, $scompanyIdentifierArr) ? $scompanyIdentifierArr[$colValue] : 0;
					}

					if( 'sduration_id' == $columnKey ){ $columnKey = 'pship_duration'; }
					if( 'sduration_identifier' == $columnKey ){
						$columnKey = 'pship_duration';
						if( !array_key_exists($colValue, $durationIdentifierArr) ){
							$res = $this->getAllShippingDurations(false,$colValue);
							if(!$res){
								$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_{column-name}_is_invalid", $langId ) );
								$err = array( $rowIndex, ( $colIndex + 1), $errMsg );
								CommonHelper::writeLogFile( $errFile,  $err );
							}else{
								$durationIdentifierArr = array_merge($durationIdentifierArr,$res);
							}
						}
						$colValue = array_key_exists($colValue, $durationIdentifierArr) ? $durationIdentifierArr[$colValue] : 0;
						if( 0 >= $colValue ){
							$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_{column-name}_is_invalid", $langId ) );
							CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errorMsgForShpDurId ) );
							continue;
						}
					}
					$prodShipArr[$columnKey] = $colValue;
				}
			}

			if( !$error && count( $prodShipArr ) ){
				$data = array(
					'pship_method'=>ShippingCompanies::MANUAL_SHIPPING,
				);
				$data = array_merge( $prodShipArr, $data );
				if( !array_key_exists($productId, $prodArr) ){
					$prodArr[] = $productId;
					$where =  array('smt'=> 'pship_prod_id = ? ','vals' => array( $productId ) );
					if( $sellerId ){
						$where =  array('smt'=> 'pship_prod_id = ? and pship_user_id = ?','vals' => array( $productId, $sellerId ) );
					}
					$this->db->deleteRecords( Product::DB_PRODUCT_TO_SHIP, array('smt'=> 'pship_prod_id = ? ','vals' => array( $productId ) ) );
				}
				$this->db->insertFromArray( Product::DB_PRODUCT_TO_SHIP,$data);
			}
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportProductMedia($langId,$offset = null,$noOfRows = null,$minId = null,$maxId = null, $userId = null){
		$userId = FatUtility::int($userId);
		$srch = Product::getSearchObject();
		$srch->joinTable(AttachedFile::DB_TBL,'INNER JOIN','product_id = afile_record_id and ( afile_type = '.AttachedFile::FILETYPE_PRODUCT_IMAGE.')');
		$srch->joinTable(OptionValue::DB_TBL,'LEFT OUTER JOIN','ov.optionvalue_id = afile_record_subid','ov');
		$srch->joinTable(Option::DB_TBL,'LEFT OUTER JOIN','o.option_id = ov.optionvalue_option_id','o');
		$srch->doNotCalculateRecords();
		if($userId){
			$cnd = $srch->addCondition('tp.product_seller_id','=',$userId,'AND');
			$cnd->attachCondition('tp.product_seller_id','=',0);
		}

		if (isset($offset) && isset($noOfRows)) {
			$srch->setPageNumber($offset);
			$srch->setPageSize($noOfRows);
		}else{
			$srch->setPageSize(static::MAX_LIMIT);
		}

		if (isset($minId) && isset($maxId)) {
			$srch->addCondition('product_id','>=',$minId);
			$srch->addCondition('product_id','<=',$maxId);
		}

		$srch->addMultipleFields(array('product_id','product_identifier','afile_record_id','afile_record_subid','afile_type','afile_lang_id','afile_screen','afile_physical_path','afile_name','afile_display_order','optionvalue_identifier','option_identifier','optionvalue_id','option_id'));
		$rs = $srch->getResultSet();

		$sheetData = array();
		/* Sheet Heading Row [ */
		$arr = $this->getProductMediaColoumArr($langId);
		array_push( $sheetData, $arr );
		/* ] */

		$languageCodes = Language::getAllCodesAssoc(true);

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();
			if($this->settings['CONF_USE_PRODUCT_ID']){
				$sheetArr[] = $row['product_id'];
			}else{
				$sheetArr[] = $row['product_identifier'];
			}

			if($this->settings['CONF_USE_LANG_ID']){
				$sheetArr[] = $row['afile_lang_id'];
			}else{
				$sheetArr[] = $languageCodes[$row['afile_lang_id']];
			}

			if($this->settings['CONF_USE_OPTION_ID']){
				$sheetArr[] = $row['option_id'];
			}else{
				$sheetArr[] = $row['option_identifier'];
			}

			if($this->settings['CONF_OPTION_VALUE_ID']){
				$sheetArr[] = $row['optionvalue_id'];
			}else{
				$sheetArr[] = $row['optionvalue_identifier'];
			}

			$sheetArr[] = $row['afile_physical_path'];
			$sheetArr[] = $row['afile_name'];
			$sheetArr[] = $row['afile_display_order'];
			array_push( $sheetData, $sheetArr );
		}
		return $sheetData;
	}

	public function importProductCatalogMedia($csvFilePointer,$post,$langId, $userId = null){

		$userId = FatUtility::int($userId);
		$rowIndex = $rowCount = 0;
		$prodIndetifierArr = array();
		$optionValueIndetifierArr = array();
		$optionIdentifierArr = array();
		$prodTempArr = array();
		$prodArr = array();
		$selProdValidOptionArr = array();

		$languageCodes = Language::getAllCodesAssoc(true);
		$languageIds = array_flip($languageCodes);

		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			// if(empty($line[0])){
			// 	continue;
			// }

			$numcols = count($line);
			$colCount = 0;

			if($rowCount == 0){
				$coloumArr = $this->getProductMediaColoumArr($langId);
				if($line !== $coloumArr || $numcols != count($coloumArr)){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Product_Catalog_Media');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			if($this->settings['CONF_USE_PRODUCT_ID']){
				$productId = FatUtility::int($this->getCell($line,$colCount++,0));
			}else{
				$colValue = $this->getCell($line,$colCount++);
				if(!array_key_exists($colValue,$prodIndetifierArr)){
					$res = $this->getAllProductsIdentifiers(false,$colValue);
					if(!$res){
						$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
					$prodIndetifierArr = array_merge($prodIndetifierArr,$res);
				}
				$productId = $prodIndetifierArr[$colValue];
			}

			if($userId){
				$productId = $this->getCheckAndSetProductIdByTempId($productId,$userId);
			}
			if(!$productId){
				$errMsg = Labels::getLabel( "MSG_Product_Id_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			if($this->settings['CONF_USE_LANG_ID']){
				$fileLangId = FatUtility::int($this->getCell($line,$colCount++,0));
			}else{
				$colValue = $this->getCell($line,$colCount++);
				$fileLangId = isset($languageIds[$colValue])?$languageIds[$colValue]:0;
			}

			if($this->settings['CONF_USE_OPTION_ID']){
				$optionId = FatUtility::int($this->getCell($line,$colCount++,0));
			}else{
				$colValue = trim( $this->getCell($line,$colCount++,'') );
				if( empty( $colValue ) ){
				    $errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				$optionId = 0;
				if($colValue){
					if(!array_key_exists($colValue,$optionIdentifierArr)){
						$res = $this->getAllOptions(false,$colValue);
						if(!$res){
							$errMsg = Labels::getLabel( "MSG_Invalid_Option_Identifier", $langId );
							$err = array($rowIndex,$colCount,$errMsg);
							CommonHelper::writeLogFile( $errFile,  $err);
							continue;
						}
						$optionIdentifierArr = array_merge($optionIdentifierArr,$res);
					}
					$optionId = isset($optionIdentifierArr[$colValue])?$optionIdentifierArr[$colValue]:0;
				}
			}

			if(!array_key_exists($productId,$selProdValidOptionArr)){
				$selProdValidOptionArr[$productId] = array();
				$optionSrch = Product::getSearchObject();
				$optionSrch->joinTable( Product::DB_PRODUCT_TO_OPTION, 'INNER JOIN', 'tp.product_id = po.prodoption_product_id','po');
				$optionSrch->addCondition( 'product_id', '=',$productId );
				$optionSrch->addMultipleFields(array('prodoption_option_id'));
				$optionSrch->doNotCalculateRecords();
				$optionSrch->doNotLimitRecords();
				$rs = $optionSrch->getResultSet();
				$db = FatApp::getDb();
				while( $row = $db->fetch($rs) ){
					$selProdValidOptionArr[$productId][] = $row['prodoption_option_id'];
				}
			}

			if($optionId && !in_array($optionId,$selProdValidOptionArr[$productId])){
				$errMsg = Labels::getLabel( "MSG_Option_Identifier_cannot_be_blank", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			$optionValueId = 0;
			if($optionId){
				if($this->settings['CONF_OPTION_VALUE_ID']){
					$optionValueId = FatUtility::int($this->getCell($line,$colCount++,0));
				}else{
					$colValue = $this->getCell($line,$colCount++);
					$optionValueId = 0;
					$optionValueIndetifierArr[$optionId] = isset($optionValueIndetifierArr[$optionId])?$optionValueIndetifierArr[$optionId]:array();
					if($colValue){
						if(!array_key_exists($colValue,$optionValueIndetifierArr[$optionId])){
							$res = $this->getAllOptionValues($optionId,false,$colValue);
							if(!$res){
								$errMsg = Labels::getLabel( "MSG_Option_value_Identifier_cannot_be_blank", $langId );

								$err = array($rowIndex,$colCount,$errMsg);
								CommonHelper::writeLogFile( $errFile,  $err);
								continue;
							}
							$optionValueIndetifierArr[$optionId] = array_merge($optionValueIndetifierArr[$optionId],$res);
						}
						$optionValueId = $optionValueIndetifierArr[$optionId][$colValue];
					}
				}
			}else{
				$colCount++;
			}

			$filePath = $this->getCell($line,$colCount++,'');
			$fileName = $this->getCell($line,$colCount++,'');
			$displayOrder = $this->getCell($line,$colCount++,'');

			if($rowCount > 0){
				$fileType = AttachedFile::FILETYPE_PRODUCT_IMAGE;
				$data = array(
					'afile_type'=>$fileType,
					'afile_record_id'=>$productId,
					'afile_record_subid'=>$optionValueId,
					'afile_lang_id'=>$fileLangId,
					'afile_physical_path'=>$filePath,
					'afile_name'=>$fileName,
					'afile_display_order'=>$displayOrder,
				);

				$saveToTempTable = false;
				$isUrlArr = parse_url($filePath);
				if(is_array($isUrlArr) && isset($isUrlArr['host'])){
					$saveToTempTable = true;
				}

				if($saveToTempTable){
					$data['afile_downloaded'] = applicationConstants::NO;
					$data['afile_unique'] = applicationConstants::NO;
					if(!in_array($productId,$prodTempArr)){
						$prodTempArr[] = $productId;
						$this->db->deleteRecords ( AttachedFile::DB_TBL_TEMP, array (
							'smt' => 'afile_type = ? AND afile_record_id = ?',
							'vals' => array ($fileType, $productId)
						) );
					}
					$this->db->insertFromArray( AttachedFile::DB_TBL_TEMP, $data,false,array(),$data);
				}else{
					if(!in_array($productId,$prodArr)){
						$prodArr[] = $productId;
						$this->db->deleteRecords ( AttachedFile::DB_TBL, array (
							'smt' => 'afile_type = ? AND afile_record_id = ?',
							'vals' => array ($fileType, $productId)
						) );
					}
					$this->db->insertFromArray( AttachedFile::DB_TBL, $data,false,array(),$data);
				}
			}
			$rowCount++;
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportSellerProductMedia($langId,$offset = null,$noOfRows = null,$minId = null,$maxId = null, $userId = null){
		$userId = FatUtility::int($userId);
		$srch = SellerProduct::getSearchObject( $langId );
		$srch->joinTable( Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p' );
		$srch->joinTable(User::DB_TBL,'LEFT OUTER JOIN','u.user_id = sp.selprod_user_id','u');
		$srch->joinTable(User::DB_TBL_CRED,'LEFT OUTER JOIN','uc.credential_user_id = u.user_id','uc');
		$srch->joinTable( AttachedFile::DB_TBL, 'INNER JOIN', 'pa.afile_record_id = sp.selprod_id and afile_type = '.AttachedFile::FILETYPE_SELLER_PRODUCT_DIGITAL_DOWNLOAD, 'pa' );
		if($userId){
			$srch->addCondition('u.user_id','=',$userId);
			$srch->addCondition('selprod_deleted','=',applicationConstants::NO);
		}
		$srch->doNotCalculateRecords();
		$srch->doNotCalculateRecords();
		$srch->addMultipleFields(array('sp.*','sp_l.*','pa.*','user_id','credential_username','product_id','product_identifier'));

		if (isset($offset) && isset($noOfRows)) {
			$srch->setPageNumber($offset);
			$srch->setPageSize($noOfRows);
		}else{
			$srch->setPageSize(static::MAX_LIMIT);
		}

		if (isset($minId) && isset($maxId)) {
			$srch->addCondition('selprod_id','>=',$minId);
			$srch->addCondition('selprod_id','<=',$maxId);
		}

		$srch->addOrder('selprod_id','ASC');
		$rs = $srch->getResultSet();

		$sheetData = array();

		/* Sheet Heading Row [ */
		$arr = $this->getSelProdMediaColoumArr($langId);
		array_push( $sheetData, $arr );
		/* ] */

		$languageCodes = Language::getAllCodesAssoc(true);

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();
			$sheetArr[] = $row['selprod_id'];

			if($this->settings['CONF_USE_LANG_ID']){
				$sheetArr[] = $row['afile_lang_id'];
			}else{
				$sheetArr[] = $languageCodes[$row['afile_lang_id']];
			}

			$sheetArr[] = $row['afile_physical_path'];
			$sheetArr[] = $row['afile_name'];
			$sheetArr[] = $row['afile_display_order'];
			array_push( $sheetData, $sheetArr );
		}
		return $sheetData;
	}

	public function exportSellerProdGeneralData($langId,$offset = null,$noOfRows = null,$minId = null,$maxId = null, $userId = null){
		$userId = FatUtility::int($userId);

		$srch = SellerProduct::getSearchObject( $langId );
		$srch->joinTable( Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p' );
		$srch->joinTable(User::DB_TBL,'LEFT OUTER JOIN','u.user_id = sp.selprod_user_id','u');
		$srch->joinTable(User::DB_TBL_CRED,'LEFT OUTER JOIN','uc.credential_user_id = u.user_id','uc');
		if($userId){
			$srch->addCondition('u.user_id','=',$userId);
			$srch->addCondition('selprod_deleted','=',applicationConstants::NO);
		}
		$srch->doNotCalculateRecords();
		$srch->addMultipleFields(array('sp.*','sp_l.*','user_id','credential_username','product_id','product_identifier'));
		if (isset($offset) && isset($noOfRows)) {
			$srch->setPageNumber($offset);
			$srch->setPageSize($noOfRows);
		}else{
			$srch->setPageSize(static::MAX_LIMIT);
		}

		if (isset($minId) && isset($maxId)) {
			$srch->addCondition('selprod_id','>=',$minId);
			$srch->addCondition('selprod_id','<=',$maxId);
		}

		$srch->addOrder('selprod_id','ASC');
		$rs = $srch->getResultSet();

		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getSelProdGeneralColoumArr($langId , $userId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$conditionArr = Product::getConditionArr($langId);

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){

			foreach ($headingsArr as $columnKey => $heading) {

                $colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';
				if( 'credential_username' == $columnKey ){
					$colValue = ( !empty($colValue) ? $colValue : Labels::getLabel('LBL_Admin',$langId) );
				}

				if( 'selprod_condition_identifier' == $columnKey ){
					$colValue = array_key_exists($row['selprod_condition'], $conditionArr) ? $conditionArr[$row['selprod_condition']] : '';
				}

				if( in_array( $columnKey, array( 'selprod_added_on', 'selprod_available_from' ) ) ){
					$colValue = $this->displayDateTime($colValue);
				}

				if( in_array( $columnKey, array( 'selprod_subtract_stock', 'selprod_track_inventory', 'selprod_active', 'selprod_cod_enabled', 'selprod_deleted' ) ) && !$this->settings['CONF_USE_O_OR_1'] ){
					$colValue = (FatUtility::int($colValue) == 1) ? 'YES' : 'NO';
				}

				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return 	$sheetData;
	}

	public function importSellerProdGeneralData($csvFilePointer,$post,$langId, $sellerId = null){

		$sellerId = FatUtility::int($sellerId);

		$rowIndex = 0;
		$usernameArr = array();
		$prodIndetifierArr = array();
		$prodConditionArr = Product::getConditionArr($langId);
		$prodConditionArr = array_flip($prodConditionArr);

		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;

			if($rowIndex == 1){
				$coloumArr = $this->getSelProdGeneralColoumArr($langId, $sellerId);

				if(!$this->isValidColumns( $row, $coloumArr )){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndexArr = array_flip($row);

				$errfileName = $this->logFileName('Seller_Product_General_Data');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$selProdGenArr = $selProdGenLangArr = array();
			$error = false;

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndexArr[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( in_array( $columnKey, array('selprod_id', 'selprod_product_id', 'selprod_price', 'selprod_stock', 'selprod_min_order_qty', 'selprod_condition', 'selprod_max_download_times', 'selprod_download_validity_in_days') ) && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0", $langId ) );
				}else if( in_array( $columnKey, array('product_identifier', 'credential_username', 'selprod_subtract_stock', 'selprod_track_inventory', 'selprod_threshold_stock_level', 'selprod_condition_identifier', 'selprod_title', 'selprod_url_keyword', 'selprod_available_from') ) && $colValue == '' ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_is_mandatory.", $langId ) );
				}

				if( $errMsg ){
					$err = array($rowIndex, ( $colIndex + 1), $errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{

					if( 'selprod_id' == $columnKey ){
						$selprodId = $sellerTempId = $colValue;
						if( $sellerId ){
							$userTempIdData = $this->getTempSelProdIdByTempId( $sellerTempId, $sellerId );
							if( !empty($userTempIdData) && $userTempIdData['spti_selprod_temp_id'] == $sellerTempId ){
								$selprodId = $colValue = $userTempIdData['spti_selprod_id'];
							}
						}
					}

					if( 'selprod_product_id' == $columnKey ){ $productId = $colValue; }
					if( 'product_identifier' == $columnKey ){
						if( !array_key_exists($colValue, $prodIndetifierArr) ){
							$res = $this->getAllProductsIdentifiers(false,$colValue);
							if(!$res){
								$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
								$err = array($rowIndex, ( $colIndex + 1), $errMsg);
								CommonHelper::writeLogFile( $errFile,  $err);
							}
							$prodIndetifierArr = array_merge($prodIndetifierArr,$res);
						}
						$productId = $colValue = array_key_exists($colValue, $prodIndetifierArr) ? $prodIndetifierArr[$colValue] : 0;
					}

					if( 'selprod_user_id' == $columnKey ){ $userId = $colValue;}
					if( 'credential_username' == $columnKey ){

						$colValue = ( $colValue == Labels::getLabel('LBL_Admin',$langId) ? '' : $colValue );
						if( !empty($colValue) && !array_key_exists($colValue, $usernameArr) ){
							$res = $this->getAllUserArr(false, $colValue);
							if(!$res){
								$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
								$err = array($rowIndex, ( $colIndex + 1), $errMsg);
								CommonHelper::writeLogFile( $errFile,  $err);
							}
							$usernameArr = array_merge($usernameArr, $res);
						}
						$userId = $colValue = array_key_exists( $colValue, $usernameArr ) ? $usernameArr[$colValue] : 0;
					}

					if( 'selprod_condition_identifier' == $columnKey ){
						$colValue = array_key_exists($colValue, $prodConditionArr) ? $prodConditionArr[$colValue] : 0;
						$columnKey = 'selprod_condition';
					}

					if( 'selprod_available_from' == $columnKey ){
						$colValue = $this->getDateTime($colValue);
					}

					if( 'selprod_url_keyword' == $columnKey ){ $urlKeyword = $colValue; }

					if( in_array( $columnKey, array( 'selprod_active', 'selprod_cod_enabled', 'selprod_deleted' ) ) && !$this->settings['CONF_USE_O_OR_1'] ){
						$colValue = ( FatUtility::int($colValue) == 1 ) ? 'YES' : 'NO';
					}

					if( in_array($columnKey, array( 'selprod_title', 'selprod_comments' ) ) ){
						$selProdGenLangArr[$columnKey] = $colValue;
					}else{
						$selProdGenArr[$columnKey] = $colValue;
					}
				}
			}

			if( !$error && count( $prodSpecArr ) ){

				$userId = ( !$sellerId ) ? $userId : $sellerId;

				$prodData = Product::getAttributesById( $productId, array('product_min_selling_price') );

				if($selProdGenArr['selprod_price'] < $prodData['product_min_selling_price']){
					$selProdGenArr['selprod_price'] = $prodData['product_min_selling_price'];
				}
				$selProdGenArr['selprod_added_on'] = date('Y-m-d H:i:s');

				$selProdData = SellerProduct::getAttributesById( $selprodId, array('selprod_id', 'selprod_sold_count', 'selprod_user_id') );

				if( !empty( $selProdData ) && $selProdData['selprod_id'] && ( !$sellerId || ( $sellerId && $selProdData['selprod_user_id'] == $sellerId ) ) ){
					$where = array('smt' => 'selprod_id = ?', 'vals' => array( $selprodId ) );
					$selProdGenArr['selprod_sold_count'] = $selProdData['selprod_sold_count'];

					if($sellerId){
						unset($selProdGenArr['selprod_added_on']);
					}

					$this->db->updateFromArray( SellerProduct::DB_TBL, $selProdGenArr,$where);

					if( $sellerId && $this->isDefaultSheetData($langId) ){
						$tempData = array(
							'spti_selprod_id' => $selprodId,
							'spti_selprod_temp_id' => $sellerTempId,
							'spti_user_id' => $userId,
						);
						$this->db->deleteRecords( Importexport::DB_TBL_TEMP_SELPROD_IDS, array('smt'=> 'spti_selprod_id = ? and spti_user_id = ?','vals' => array( $selprodId, $userId ) ) );
						$this->db->insertFromArray( Importexport::DB_TBL_TEMP_SELPROD_IDS, $tempData,false,array(),$tempData );
					}
				}else{
					$selProdGenArr['selprod_code'] = $productId.'_';
					if($sellerId){
						unset($selProdGenArr['selprod_id']);
						unset($selProdGenArr['selprod_sold_count']);
					}

					if($this->isDefaultSheetData($langId)){
						$this->db->insertFromArray( SellerProduct::DB_TBL, $selProdGenArr );
						$selprodId = $this->db->getInsertId();

						$tempData = array(
							'spti_selprod_id' =>$selprodId,
							'spti_selprod_temp_id' =>$sellerTempId,
							'spti_user_id' =>$userId,
						);
						$this->db->deleteRecords( Importexport::DB_TBL_TEMP_SELPROD_IDS, array('smt'=> 'spti_selprod_id = ? and spti_user_id = ?','vals' => array( $selprodId, $userId ) ) );
						$this->db->insertFromArray( Importexport::DB_TBL_TEMP_SELPROD_IDS, $tempData,false,array(),$tempData );
					}
				}

				if($selprodId){
					/* Lang Data [ */
					$langData = array(
						'selprodlang_selprod_id'=> $selprodId,
						'selprodlang_lang_id'=> $langId,
					);
					$langData = array_merge( $langData, $selProdGenLangArr );
					$this->db->insertFromArray( SellerProduct::DB_LANG_TBL, $langData , false, array(), $langData );
					/*]*/

					/* Url rewriting [*/
					if( $this->isDefaultSheetData( $langId ) ){
						if( trim( $urlKeyword ) != '' ){
							$sellerProdObj = new SellerProduct( $selprodId );
							$sellerProdObj->rewriteUrlProduct( $urlKeyword );
							$sellerProdObj->rewriteUrlReviews( $urlKeyword );
							$sellerProdObj->rewriteUrlMoreSellers( $urlKeyword );
						}
					}
					/* ]*/
				}
			}
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportSellerProdOptionData($langId,$offset = null,$noOfRows = null,$minId = null,$maxId = null, $userId = null){
		$userId = FatUtility::int($userId);
		$srch = new SearchBase(SellerProduct::DB_TBL_SELLER_PROD_OPTIONS, 'spo');
		$srch->joinTable( SellerProduct::DB_TBL, 'INNER JOIN', 'sp.selprod_id = spo.selprodoption_selprod_id', 'sp');
		$srch->joinTable( OptionValue::DB_TBL, 'INNER JOIN', 'spo.selprodoption_optionvalue_id = ov.optionvalue_id', 'ov');
		$srch->joinTable( OptionValue::DB_TBL . '_lang', 'LEFT OUTER JOIN', 'ov_lang.optionvaluelang_optionvalue_id = ov.optionvalue_id AND ov_lang.optionvaluelang_lang_id = '.$langId, 'ov_lang' );
		$srch->joinTable( Option::DB_TBL, 'INNER JOIN', 'o.option_id = ov.optionvalue_option_id', 'o' );
		$srch->joinTable( Option::DB_TBL . '_lang', 'LEFT OUTER JOIN', 'o.option_id = o_lang.optionlang_option_id AND o_lang.optionlang_lang_id = '.$langId, 'o_lang' );
		$srch->addMultipleFields( array('selprodoption_selprod_id','o.option_id', 'ov.optionvalue_id', 'option_identifier', 'optionvalue_identifier') );
		if($userId){
			$srch->addCondition('sp.selprod_user_id','=',$userId);
		}

		if (isset($offset) && isset($noOfRows)) {
			$srch->setPageNumber($offset);
			$srch->setPageSize($noOfRows);
		}else{
			$srch->setPageSize(static::MAX_LIMIT);
		}

		if (isset($minId) && isset($maxId)) {
			$srch->addCondition('selprodoption_selprod_id','>=',$minId);
			$srch->addCondition('selprodoption_selprod_id','<=',$maxId);
		}

		$srch->addOrder('selprodoption_selprod_id','ASC');
		$rs = $srch->getResultSet();

		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getSelProdOptionsColoumArr($langId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){

			foreach ($headingsArr as $columnKey => $heading) {
                $colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';
				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return $sheetData;
	}

	public function importSellerProdOptionData($csvFilePointer,$post,$langId, $userId = null){

		$rowIndex = 0;
		$optionIdentifierArr = array();
		$optionValueIndetifierArr = array();
		$selProdArr = array();
		$selProdOptionsArr = array();
		$selProdValidOptionArr = array();

		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;

			if($rowIndex == 1){
				$coloumArr = $this->getSelProdOptionsColoumArr($langId);

				if(!$this->isValidColumns( $row, $coloumArr )){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndexArr = array_flip($row);

				$errfileName = $this->logFileName('Seller_Product_Option_Data');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$error = false;
			$selprodId = $optionId = 0;

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndexArr[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( in_array( $columnKey, array('selprodoption_selprod_id', 'option_id', 'optionvalue_id') ) && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0", $langId ) );
				}else if( in_array( $columnKey, array('option_identifier', 'optionvalue_identifier') ) && $colValue == '' ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_is_mandatory.", $langId ) );
				}

				if( $errMsg ){
					$err = array($rowIndex, ( $colIndex + 1), $errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{
					if( 'selprodoption_selprod_id' == $columnKey ){
						$selprodId = $colValue;
						if( $userId ){
							$selprodId = $colValue = $this->getCheckAndSetSelProdIdByTempId( $colValue, $userId );
						}
					}

					if( in_array( $columnKey, array('option_id', 'option_identifier') ) ){
						$optionId = $colValue;
						if( 'option_identifier' == $columnKey ){
							if( !array_key_exists($colValue, $optionIdentifierArr) ){
								$res = $this->getAllOptions(false,$colValue);
								if(!$res){
									$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
									$err = array($rowIndex,$colCount,$errMsg);
									CommonHelper::writeLogFile( $errFile,  $err);
								}
								$optionIdentifierArr = array_merge($optionIdentifierArr,$res);
							}
							$colValue = $optionId = array_key_exists($colValue, $optionIdentifierArr) ? $optionIdentifierArr[$colValue] : 0;
							if( !$optionId ){
								$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
								$err = array($rowIndex, ( $colIndex + 1), $errMsg);
								CommonHelper::writeLogFile( $errFile,  $err);
							}
						}

						if( !array_key_exists( $selprodId, $selProdValidOptionArr ) ){
							$selProdValidOptionArr[$selprodId] = array();
							$optionSrch = SellerProduct::getSearchObject();
							$optionSrch->joinTable( Product::DB_PRODUCT_TO_OPTION, 'INNER JOIN', 'sp.selprod_product_id = po.prodoption_product_id','po');
							$optionSrch->addCondition( 'selprod_id', '=',$selprodId );
							$optionSrch->addMultipleFields(array('prodoption_option_id'));
							$optionSrch->doNotCalculateRecords();
							$optionSrch->doNotLimitRecords();
							$rs = $optionSrch->getResultSet();
							$db = FatApp::getDb();
							while( $spRow = $db->fetch($rs) ){
								$selProdValidOptionArr[$selprodId][] = $spRow['prodoption_option_id'];
							}
						}
						if( !in_array( $optionId, $selProdValidOptionArr[$selprodId] ) ){
							$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
							$err = array($rowIndex, ( $colIndex + 1), $errMsg);
							CommonHelper::writeLogFile( $errFile,  $err);
						}
					}

					if( in_array( $columnKey, array('optionvalue_id', 'optionvalue_identifier') ) ){
						$optionValueId = 0;
						if($optionId){
							$optionValueId = $colValue;
							if( 'optionvalue_identifier' == $columnKey ){
								$optionValueId = 0;

								$optionValueIndetifierArr[$optionId] = array_key_exists($optionId, $optionValueIndetifierArr) ? $optionValueIndetifierArr[$optionId] : array();

								if( !array_key_exists( $colValue, $optionValueIndetifierArr[$optionId] ) ){
									$res = $this->getAllOptionValues( $optionId, false, $colValue );
									if(!$res){
										$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
										$err = array($rowIndex,$colCount,$errMsg);
										CommonHelper::writeLogFile( $errFile,  $err);
									}
									$optionValueIndetifierArr[$optionId] = array_merge($optionValueIndetifierArr[$optionId],$res);
								}
								$optionValueId = array_key_exists( $colValue, $optionValueIndetifierArr[$optionId] ) ? $optionValueIndetifierArr[$optionId][$colValue] : 0;
							}
						}
						$colValue = $optionValueId;
						if( !$colValue ){
							$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
							$err = array($rowIndex, ( $colIndex + 1), $errMsg);
							CommonHelper::writeLogFile( $errFile,  $err);
						}
					}
				}
			}

			if( !$error ){
				if( !array_key_exists($selprodId, $selProdArr) ){
					$selProdArr[] = $selprodId;
					$where = array ('smt' => 'selprodoption_selprod_id = ?','vals' => array ($selprodId));
					$this->db->deleteRecords ( SellerProduct::DB_TBL_SELLER_PROD_OPTIONS, $where );
				}
				$selProdOptionsArr[$selprodId][] = $optionValueId;

				$data = array(
					'selprodoption_selprod_id' => $selprodId,
					'selprodoption_option_id' => $optionId,
					'selprodoption_optionvalue_id' => $optionValueId,
				);
				$this->db->insertFromArray( SellerProduct::DB_TBL_SELLER_PROD_OPTIONS, $data , false, array(),$data );
			}
		}

		if( $selProdOptionsArr ){
			$options = array();
			foreach( $selProdOptionsArr as $k => $v ){
				$productRow = Product::getAttributesById( $k, array('product_id') );
				if( !$productRow ){
					$errMsg = Labels::getLabel( "MSG_Product_not_found.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$options['selprod_code'] = $productRow['product_id'].'_'.implode('_',$v);
				$sellerProdObj = new SellerProduct($k);
				$sellerProdObj->assignValues( $options );
				if ( !$sellerProdObj->save() ) {
					$errMsg = Labels::getLabel( "MSG_Product_not_saved.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
			}
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportSellerProdSeoData($langId,$offset = null,$noOfRows = null,$minId = null,$maxId = null, $userId = null){
		$userId = FatUtility::int($userId);
		$metaTabArr = MetaTag::getTabsArr($langId);

		$srch = SellerProduct::getSearchObject( $langId );
		$srch->joinTable( MetaTag::DB_TBL, 'LEFT OUTER JOIN', 'sp.selprod_id = m.meta_record_id', 'm' );
		$srch->joinTable( MetaTag::DB_LANG_TBL, 'LEFT OUTER JOIN', 'm_l.metalang_meta_id = m.meta_id and m_l.metalang_lang_id = '.$langId, 'm_l' );
		$srch->addCondition('meta_identifier','!=','');
		$srch->addCondition('meta_controller','=',$metaTabArr[MetaTag::META_GROUP_PRODUCT_DETAIL]['controller']);
		$srch->addCondition('meta_action','=',$metaTabArr[MetaTag::META_GROUP_PRODUCT_DETAIL]['action']);
		$srch->doNotCalculateRecords();
		$srch->addMultipleFields(array('sp.selprod_id','m.*','m_l.*'));

		if($userId){
			$srch->addCondition('sp.selprod_user_id','=',$userId);
		}

		if (isset($offset) && isset($noOfRows)) {
			$srch->setPageNumber($offset);
			$srch->setPageSize($noOfRows);
		}else{
			$srch->setPageSize(static::MAX_LIMIT);
		}

		if (isset($minId) && isset($maxId)) {
			$srch->addCondition('selprod_id','>=',$minId);
			$srch->addCondition('selprod_id','<=',$maxId);
		}

		$srch->addOrder('selprod_id','ASC');
		$rs = $srch->getResultSet();

		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getSelProdSeoColoumArr($langId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){

			foreach ($headingsArr as $columnKey => $heading) {
                $colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';
				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return  $sheetData;
	}

	public function importSellerProdSeoData($csvFilePointer,$post,$langId, $userId = null){

		$rowIndex = 0;
		$metaTabArr = MetaTag::getTabsArr($langId);
		$metaSrch = MetaTag::getSearchObject();
		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;

			if($rowIndex == 1){
				$coloumArr = $this->getSelProdSeoColoumArr($langId);

				if(!$this->isValidColumns( $row, $coloumArr )){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndexArr = array_flip($row);

				$errfileName = $this->logFileName('Seller_Product_Seo_Data');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$selProdSeoArr = $selProdSeoLangArr = array();
			$error = false;

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndexArr[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( 'selprod_id' == $columnKey && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0", $langId ) );
				}else if( 'meta_identifier' == $columnKey && empty($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_is_mandatory.", $langId ) );
				}

				if( $errMsg ){
					$err = array($rowIndex, ( $colIndex + 1), $errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{
					if( 'selprod_id' == $columnKey ){
						$selProdId = $colValue;
						if( $userId ){
							$selProdId = $colValue = $this->getCheckAndSetSelProdIdByTempId( $colValue, $userId );
						}
					}

					if( in_array($columnKey, array( 'meta_title', 'meta_keywords', 'meta_description', 'meta_other_meta_tags' ) ) ){
						$selProdSeoLangArr[$columnKey] = $colValue;
					}else{
						$selProdSeoArr[$columnKey] = $colValue;
					}
				}
			}

			if( !$error && count($selProdSeoArr) ){
				$data = array(
					'meta_controller' => $metaTabArr[MetaTag::META_GROUP_PRODUCT_DETAIL]['controller'],
					'meta_action' => $metaTabArr[MetaTag::META_GROUP_PRODUCT_DETAIL]['action'],
					'meta_record_id' => $selProdId,
				);
				$data = array_merge($data, $selProdSeoArr);

				$srch = clone $metaSrch;
				$srch->addCondition('meta_controller','=',$metaTabArr[MetaTag::META_GROUP_PRODUCT_DETAIL]['controller']);
				$srch->addCondition('meta_action','=',$metaTabArr[MetaTag::META_GROUP_PRODUCT_DETAIL]['action']);
				$srch->addCondition('meta_record_id','=',$selProdId);
				$srch->addMultipleFields(array('meta_id','meta_record_id'));
				$srch->doNotCalculateRecords();
				$srch->setPageSize(1);
				$rs = $srch->getResultSet();
				$row = $this->db->fetch($rs);
				if($row && $row['meta_record_id'] === $selProdId){
					$metaId = $row['meta_id'];
					$where = array('smt' => 'meta_controller = ? AND meta_action = ? AND meta_record_id = ?', 'vals' => array( $metaTabArr[MetaTag::META_GROUP_PRODUCT_DETAIL]['controller'], $metaTabArr[MetaTag::META_GROUP_PRODUCT_DETAIL]['action'],$selProdId ) );
					$this->db->updateFromArray( MetaTag::DB_TBL, $data, $where);
				}else{
					if($this->isDefaultSheetData($langId)){
						$this->db->insertFromArray( MetaTag::DB_TBL, $data );
						$metaId = $this->db->getInsertId();
					}
				}

				if($metaId){
					/* Lang Data [*/
					$langData = array(
						'metalang_meta_id'=> $metaId,
						'metalang_lang_id'=> $langId,
					);
					$langData = array_merge($langData, $selProdSeoLangArr);
					$this->db->insertFromArray( MetaTag::DB_LANG_TBL, $langData , false, array(),$langData );
					/* ]*/
				}
			}
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportSellerProdSpecialPrice($langId,$offset = null,$noOfRows = null,$minId = null,$maxId = null, $userId = null){
		$userId = FatUtility::int($userId);
		$srch = SellerProduct::getSearchObject( $langId );
		$srch->joinTable(SellerProduct::DB_TBL_SELLER_PROD_SPCL_PRICE, 'INNER JOIN', 'sp.selprod_id = spsp.splprice_selprod_id', 'spsp' );
		$srch->doNotCalculateRecords();
		$srch->addMultipleFields(array('spsp.*','sp.selprod_id'));
		if($userId){
			$srch->addCondition('sp.selprod_user_id','=',$userId);
		}

		if (isset($offset) && isset($noOfRows)) {
			$srch->setPageNumber($offset);
			$srch->setPageSize($noOfRows);
		}else{
			$srch->setPageSize(static::MAX_LIMIT);
		}

		if (isset($minId) && isset($maxId)) {
			$srch->addCondition('selprod_id','>=',$minId);
			$srch->addCondition('selprod_id','<=',$maxId);
		}

		$srch->addOrder('selprod_id','ASC');
		$rs = $srch->getResultSet();

		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getSelProdSpecialPriceColoumArr($langId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$persentOrFlatTypeArr = applicationConstants::getPercentageFlatArr($langId);
		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){

			foreach ($headingsArr as $columnKey => $heading) {
                $colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';
				if( in_array( $columnKey, array( 'splprice_start_date', 'splprice_end_date' ) ) ){
					$colValue = $this->displayDate($colValue);
				}
				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return  $sheetData;
	}

	public function importSellerProdSpecialPrice($csvFilePointer,$post,$langId, $userId = null){

		$rowIndex = 0;
		$persentOrFlatTypeArr = applicationConstants::getPercentageFlatArr($langId);
		$persentOrFlatTypeArr = array_flip($persentOrFlatTypeArr);
		$selProdArr = array();

		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;

			if($rowIndex == 1){
				$coloumArr = $this->getSelProdSpecialPriceColoumArr($langId);

				if( !$this->isValidColumns($row, $coloumArr) ){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndexArr = array_flip($row);

				$errfileName = $this->logFileName('Seller_Product_Special_Price');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$sellerProdSplPriceArr = array();
			$error = false;

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndexArr[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( 'selprod_id' == $columnKey && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0", $langId ) );
				}else if( in_array( $columnKey, array( 'splprice_start_date', 'splprice_end_date', 'splprice_price' ) ) && empty($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_is_mandatory.", $langId ) );
				}

				if( $errMsg ){
					$err = array($rowIndex, ( $colIndex + 1), $errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{
					if( 'selprod_id' == $columnKey ){
						$selProdId = $colValue;
						if( $userId ){
							$selProdId = $colValue = $this->getCheckAndSetSelProdIdByTempId( $colValue, $userId );
						}
						if( !$selProdId ){
							$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
							CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
						}
					}
					if(  in_array( $columnKey, array( 'splprice_start_date', 'splprice_end_date') ){
						$colValue = $this->getDateTime( $colValue, false );
					}

					$sellerProdSplPriceArr[$columnKey] = $colValue;
				}

			}

			if( !$error && count( $sellerProdSplPriceArr ) ){
				$data = array(
					'splprice_selprod_id'=>$selProdId,
				);
				$data = array_merge( $data, $sellerProdSplPriceArr );

				$res = SellerProduct::getSellerProductSpecialPrices($selProdId);
				if(!empty($res)){
					if(!in_array($selProdId,$selProdArr)){
						$selProdArr[] = $selProdId;
						$where = array ('smt' => 'splprice_selprod_id = ?','vals' => array ($selProdId));
						$this->db->deleteRecords ( SellerProduct::DB_TBL_SELLER_PROD_SPCL_PRICE, $where );
					}
				}
				$this->db->insertFromArray( SellerProduct::DB_TBL_SELLER_PROD_SPCL_PRICE, $data );
			}

		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportSellerProdVolumeDiscount($langId,$offset = null,$noOfRows = null,$minId = null,$maxId = null, $userId = null){
		$userId = FatUtility::int($userId);
		$srch = SellerProduct::getSearchObject( $langId );
		$srch->joinTable(SellerProductVolumeDiscount::DB_TBL, 'INNER JOIN', 'sp.selprod_id = spvd.voldiscount_selprod_id', 'spvd' );
		$srch->doNotCalculateRecords();
		$srch->addMultipleFields(array('spvd.voldiscount_min_qty','spvd.voldiscount_percentage','sp.selprod_id'));
		if($userId){
			$srch->addCondition('sp.selprod_user_id','=',$userId);
		}

		if (isset($offset) && isset($noOfRows)) {
			$srch->setPageNumber($offset);
			$srch->setPageSize($noOfRows);
		}else{
			$srch->setPageSize(static::MAX_LIMIT);
		}

		if (isset($minId) && isset($maxId)) {
			$srch->addCondition('selprod_id','>=',$minId);
			$srch->addCondition('selprod_id','<=',$maxId);
		}

		$srch->addOrder('selprod_id','ASC');
		$rs = $srch->getResultSet();
		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getSelProdVolumeDiscountColoumArr($langId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){
			foreach ($headingsArr as $columnKey => $heading) {
                $colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';
				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return  $sheetData;
	}

	public function importSellerProdVolumeDiscount($csvFilePointer,$post,$langId, $userId = null){

		$rowIndex = 0;
		$selProdArr = array();
		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;

			if($rowIndex == 1){
				$coloumArr = $this->getSelProdVolumeDiscountColoumArr($langId);

				if(!$this->isValidColumns( $row, $coloumArr )){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndexArr = array_flip($row);

				$errfileName = $this->logFileName('Seller_Product_Volume_Discount');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$selProdVolDisArr = array();
			$error = false;

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndexArr[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if(  in_array( $columnKey, array( 'selprod_id', 'voldiscount_min_qty' ) ) && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0", $langId ) );
				}

				if( 'voldiscount_percentage' == $columnKey && 0 > FatUtility::float($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_is_mandatory", $langId ) );
				}

				if( $errMsg ){
					$err = array( $rowIndex, ( $colIndex + 1), $errMsg );
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{
					if( 'selprod_id' == $columnKey ){
						$selProdId = $colValue;
						if( $userId ){
							$selProdId = $colValue = $this->getCheckAndSetSelProdIdByTempId( $colValue, $userId );
						}
						if( !$selProdId ){
							$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
							CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
						}
					}

					$selProdVolDisArr[$columnKey] = $colValue;
				}
			}

			if( !$error && count($selProdVolDisArr) ){
				$data = array(
					'voldiscount_selprod_id'=>$selProdId,
				);
				$data = array_merge( $data, $selProdVolDisArr );

				if( !in_array( $selProdId, $selProdArr ) ){
					$selProdArr[] = $selProdId;
					$where = array( 'smt' => 'voldiscount_selprod_id = ?','vals' => array( $selProdId ) );
					$this->db->deleteRecords( SellerProductVolumeDiscount::DB_TBL, $where );
				}
				$this->db->insertFromArray( SellerProductVolumeDiscount::DB_TBL, $data );
			}
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportSellerProdBuyTogther($langId,$offset = null,$noOfRows = null,$minId = null,$maxId = null, $userId = null){
		$userId = FatUtility::int($userId);
		$srch = SellerProduct::getSearchObject( $langId );
		$srch->joinTable(SellerProduct::DB_TBL_UPSELL_PRODUCTS, 'INNER JOIN', 'sp.selprod_id = spu.upsell_sellerproduct_id', 'spu' );
		$srch->doNotCalculateRecords();
		$srch->addMultipleFields(array('spu.upsell_sellerproduct_id','spu.upsell_recommend_sellerproduct_id','sp.selprod_id'));
		if($userId){
			$srch->addCondition('sp.selprod_user_id','=',$userId);
		}

		if (isset($offset) && isset($noOfRows)) {
			$srch->setPageNumber($offset);
			$srch->setPageSize($noOfRows);
		}else{
			$srch->setPageSize(static::MAX_LIMIT);
		}

		if (isset($minId) && isset($maxId)) {
			$srch->addCondition('selprod_id','>=',$minId);
			$srch->addCondition('selprod_id','<=',$maxId);
		}

		$srch->addOrder('selprod_id','ASC');
		$rs = $srch->getResultSet();
		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getSelProdBuyTogetherColoumArr($langId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){
			foreach ($headingsArr as $columnKey => $heading) {
                $colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';
				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return  $sheetData;
	}

	public function importSellerProdBuyTogther($csvFilePointer,$post,$langId, $userId = null){

		$rowIndex = 0;
		$selProdArr = array();
		$selProdUserArr = array();
		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;

			if($rowIndex == 1){
				$coloumArr = $this->getSelProdBuyTogetherColoumArr($langId);

				if( !$this->isValidColumns($row, $coloumArr) ){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndex = array_flip($row);

				$errfileName = $this->logFileName('Seller_Product_Buy_Togther');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$error = false;
			$selProdId = 0;
			$selProdBuyTogetherArr = array();

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndex[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( in_array( $columnKey, array('selprod_id', 'upsell_recommend_sellerproduct_id') ) && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0.", $langId ) );
				}

				if($errMsg){
					$err = array($rowIndex,( $colIndex + 1),$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{
					if( 'selprod_id' == $columnKey ){
						$columnKey = 'upsell_sellerproduct_id';
						$selProdId = $colValue;
						if( $userId ){
							$selProdId = $colValue = $this->getCheckAndSetSelProdIdByTempId( $colValue, $userId );
						}

						if( !array_key_exists( $selProdId, $selProdUserArr ) ){
							$res = SellerProduct::getAttributesById( $selProdId, array( 'selprod_id', 'selprod_user_id' ) );
							if( empty($res) ){
								$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
								CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
								$error = true;
							}else{
								$selProdUserArr[ $res['selprod_id'] ] = $res['selprod_user_id'];
							}
						}

					}

					if( 'upsell_recommend_sellerproduct_id' == $columnKey ){
						$upselProdId = $colValue;
						if($userId){
							$upselProdId = $colValue = $this->getCheckAndSetSelProdIdByTempId($upselProdId,$userId);
						}

						if( !$upselProdId ){
							$errMsg = str_replace( '{column-name}', 'Seller', Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
							CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
							$error = true;
						}

						if( !array_key_exists( $upselProdId, $selProdUserArr ) ){
							$res = SellerProduct::getAttributesById( $upselProdId, array( 'selprod_id', 'selprod_user_id' ) );
							if( empty($res) ){
								$errMsg = str_replace( '{column-name}', 'Seller', Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
								CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
								$error = true;
							}else{
								$selProdUserArr[ $res['selprod_id'] ] = $res['selprod_user_id'];
							}
						}

						if( $selProdUserArr[$selProdId] != $selProdUserArr[$upselProdId] ){
							$errMsg = Labels::getLabel( "MSG_Seller_product_not_valid.", $langId );
							CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
							$error = true;
						}
					}

					$selProdBuyTogetherArr[$columnKey] = $colValue;
				}
			}

			if( !$error && count($selProdBuyTogetherArr) ){

				if( !in_array( $selProdId, $selProdArr ) ){
					$selProdArr[] = $selProdId;
					$where = array ('smt' => 'upsell_sellerproduct_id = ?','vals' => array ($selProdId));
					$this->db->deleteRecords ( SellerProduct::DB_TBL_UPSELL_PRODUCTS, $where );
				}

				$this->db->insertFromArray( SellerProduct::DB_TBL_UPSELL_PRODUCTS, $selProdBuyTogetherArr );
			}
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportSellerProdRelatedProd($langId,$offset = null,$noOfRows = null,$minId = null,$maxId = null, $userId = null){
		$userId = FatUtility::int($userId);
		$srch = SellerProduct::getSearchObject( $langId );
		$srch->joinTable(SellerProduct::DB_TBL_RELATED_PRODUCTS, 'INNER JOIN', 'sp.selprod_id = spr.related_sellerproduct_id', 'spr' );
		$srch->doNotCalculateRecords();
		$srch->addMultipleFields(array('spr.related_sellerproduct_id','spr.related_recommend_sellerproduct_id','sp.selprod_id'));
		if($userId){
			$srch->addCondition('sp.selprod_user_id','=',$userId);
		}

		if (isset($offset) && isset($noOfRows)) {
			$srch->setPageNumber($offset);
			$srch->setPageSize($noOfRows);
		}else{
			$srch->setPageSize(static::MAX_LIMIT);
		}

		if (isset($minId) && isset($maxId)) {
			$srch->addCondition('selprod_id','>=',$minId);
			$srch->addCondition('selprod_id','<=',$maxId);
		}

		$srch->addOrder('selprod_id','ASC');
		$rs = $srch->getResultSet();
		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getSelProdRelatedProductColoumArr($langId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){
			foreach ($headingsArr as $columnKey => $heading) {
                $colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';
				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return  $sheetData;
	}

	public function importSellerProdRelatedProd($csvFilePointer,$post,$langId, $userId = null){

		$rowIndex = 0;
		$selProdArr = array();
		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;

			if($rowIndex == 1){
				$coloumArr = $this->getSelProdRelatedProductColoumArr($langId);

				if( !$this->isValidColumns($row, $coloumArr) ){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndexArr = array_flip($row);

				$errfileName = $this->logFileName('Seller_Product_Related_Product');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$sellerProdSplPriceArr = array();
			$error = false;

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndexArr[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( in_array( $columnKey, array( 'selprod_id', 'related_recommend_sellerproduct_id' ) ) && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0.", $langId ) );
				}

				if( $errMsg ){
					$err = array($rowIndex, ( $colIndex + 1), $errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{
					if( 'selprod_id' == $columnKey ){
						$columnKey = 'related_sellerproduct_id';
						$selProdId = $colValue;
						if( $userId ){
							$selProdId = $colValue = $this->getCheckAndSetSelProdIdByTempId( $colValue, $userId );
						}
						if( !$selProdId ){
							$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
							CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
						}
					}

					$sellerProdSplPriceArr[$columnKey] = $colValue;
				}
			}

			if( !$error && count($sellerProdSplPriceArr) ){

				if( !in_array( $selProdId, $selProdArr ) ){
					$selProdArr[] = $selProdId;
					$where = array ('smt' => 'related_sellerproduct_id = ?','vals' => array ($selProdId));
					$this->db->deleteRecords ( SellerProduct::DB_TBL_RELATED_PRODUCTS, $where );
				}
				$this->db->insertFromArray( SellerProduct::DB_TBL_RELATED_PRODUCTS, $sellerProdSplPriceArr );
			}
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportSellerProdPolicy($langId,$offset = null,$noOfRows = null,$minId = null,$maxId = null, $userId = null){
		$userId = FatUtility::int($userId);
		$srch = SellerProduct::getSearchObject( $langId );
		$srch->joinTable(SellerProduct::DB_TBL_SELLER_PROD_POLICY, 'INNER JOIN', 'sp.selprod_id = spp.sppolicy_selprod_id', 'spp' );
		$srch->joinTable(PolicyPoint::DB_TBL, 'INNER JOIN', 'spp.sppolicy_ppoint_id = pp.ppoint_id', 'pp' );
		$srch->doNotCalculateRecords();
		$srch->addMultipleFields(array('pp.ppoint_identifier','sp.selprod_id','spp.sppolicy_ppoint_id'));
		if($userId){
			$srch->addCondition('sp.selprod_user_id','=',$userId);
		}

		if (isset($offset) && isset($noOfRows)) {
			$srch->setPageNumber($offset);
			$srch->setPageSize($noOfRows);
		}else{
			$srch->setPageSize(static::MAX_LIMIT);
		}

		if (isset($minId) && isset($maxId)) {
			$srch->addCondition('selprod_id','>=',$minId);
			$srch->addCondition('selprod_id','<=',$maxId);
		}

		$srch->addOrder('selprod_id','ASC');
		$rs = $srch->getResultSet();
		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getSelProdPolicyColoumArr($langId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){

			foreach ($headingsArr as $columnKey => $heading) {
                $colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';
				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return  $sheetData;
	}

	public function importSellerProdPolicy($csvFilePointer,$post,$langId, $userId = null){

		$rowIndex = 0;
		$policyPonitIdentifierArr = array();
		$policyPonitIdArr = array();
		$selProdArr = array();
		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;

			if($rowIndex == 1){
				$coloumArr = $this->getSelProdPolicyColoumArr($langId);

				if( !$this->isValidColumns($row, $coloumArr) ){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndexArr = array_flip($row);

				$errfileName = $this->logFileName('Seller_Product_Policy');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$sellerProdPolicyArr = array();
			$error = false;

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndexArr[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( in_array( $columnKey, array( 'selprod_id', 'sppolicy_ppoint_id' ) ) && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0.", $langId ) );
				}else if( 'ppoint_identifier' == $columnKey && empty($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading,Labels::getLabel( "MSG_{column-name}_is_mandatory.", $langId ) );
				}

				if( $errMsg ){
					$err = array($rowIndex, ( $colIndex + 1), $errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{
					if( 'selprod_id' == $columnKey ){
						$columnKey = 'sppolicy_selprod_id';
						$selProdId = $colValue;
						if( $userId ){
							$selProdId = $colValue = $this->getCheckAndSetSelProdIdByTempId( $colValue, $userId );
						}
						if( !$selProdId ){
							$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
							CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
						}
					}

					if( in_array( $columnKey, array( 'sppolicy_ppoint_id', 'ppoint_identifier' ) ) ){
						if( 'sppolicy_ppoint_id' == $columnKey ){
							$colValue = $policyPointId = FatUtility::int( $this->getCell($line, $colCount++, 0) );

							if( !array_key_exists( $policyPointId, $policyPonitIdArr ) ){
								$res = $this->getAllPrivacyPoints( true, $policyPointId );
								if( !$res ){
									$error = true;
									$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
									CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
								}
								$policyPonitIdArr = array_merge($policyPonitIdArr,$res);
							}
						}

						if( 'ppoint_identifier' == $columnKey ){
							$columnKey = 'sppolicy_ppoint_id';

							if( !array_key_exists( $colValue, $policyPonitIdentifierArr ) ){
								$res = $this->getAllPrivacyPoints( false, $colValue );
								if(!$res){
									$error = true;
									$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
									CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
								}
								$policyPonitIdentifierArr = array_merge( $policyPonitIdentifierArr, $res );
							}
							$colValue = $policyPointId = $policyPonitIdentifierArr[$colValue];
						}

						if( !$policyPointId ){
							$error = true;
							$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
							CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
						}
					}

					$sellerProdPolicyArr[$columnKey] = $colValue;
				}
			}

			if( !$error && count($sellerProdPolicyArr) ){

				if( !in_array( $selProdId, $selProdArr ) ){
					$selProdArr[] = $selProdId;
					$where = array ('smt' => 'sppolicy_selprod_id = ?','vals' => array ($selProdId));
					$this->db->deleteRecords ( SellerProduct::DB_TBL_SELLER_PROD_POLICY, $where );
				}
				$this->db->insertFromArray( SellerProduct::DB_TBL_SELLER_PROD_POLICY, $sellerProdPolicyArr );
			}
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportOptions($langId ,$userId = 0){
		$userId = FatUtility::int($userId);
		$srch = Option::getSearchObject( $langId , false );
		$srch->joinTable(User::DB_TBL,'LEFT OUTER JOIN','u.user_id = o.option_seller_id','u');
		$srch->joinTable(User::DB_TBL_CRED,'LEFT OUTER JOIN','uc.credential_user_id = o.option_seller_id','uc');
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$srch->addMultipleFields(array('option_id','option_identifier','option_seller_id','option_type','option_deleted','option_is_separate_images','option_is_color','option_display_in_filter','IFNULL(option_name,option_identifier)option_name','credential_username'));
		$srch->addOrder('option_id','ASC');
		if($userId){
			$srch->addCondition('option_deleted','=',applicationConstants::NO);
		}
		$rs = $srch->getResultSet();

		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getOptionsColoumArr($langId, $userId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		/* $optionTypeArr = Option::getOptionTypes($langId); */

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){

			foreach ($headingsArr as $columnKey => $heading) {
                $colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';

				if( 'credential_username' == $columnKey ){
					$colValue = ( !empty( $colValue ) ? $colValue : Labels::getLabel('LBL_Admin',$langId) );
				}

				if(  in_array( $columnKey, array( 'option_is_separate_images', 'option_is_color', 'option_display_in_filter', 'option_deleted' ) ) && !$this->settings['CONF_USE_O_OR_1'] ){
					$colValue = (FatUtility::int($colValue) == 1) ? 'YES' : 'NO';
				}

				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return $sheetData;
	}

	public function importOptions($csvFilePointer,$post,$langId){

		$rowIndex = 0;
		$optionIdentifierArr = array();
		$optionIdArr = array();
		$userArr = array();

		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;

			if($rowIndex == 1){
				$coloumArr = $this->getOptionsColoumArr($langId);

				if( !$this->isValidColumns($row, $coloumArr) ){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndexArr = array_flip($row);

				$errfileName = $this->logFileName('Options');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$optionsArr = $optionsLangArr = array();
			$error = false;

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndexArr[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( in_array( $columnKey, array( 'option_id', 'option_seller_id' ) ) && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading, Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0.", $langId ) );
				}else if( in_array( $columnKey, array( 'option_identifier', 'option_name', 'credential_username' ) ) && empty($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading, Labels::getLabel( "MSG_{column-name}_is_mandatory.", $langId ) );
				}

				if( $errMsg ){
					$err = array($rowIndex, ( $colIndex + 1), $errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{
					if( 'credential_username' ==  $columnKey ){
						$columnKey = 'option_seller_id';
						$colValue = ( $colValue == Labels::getLabel('LBL_Admin',$langId) ? '' : $colValue );

						if( !empty( $colValue ) ){
							if( !array_key_exists( $colValue, $userArr ) ){
								$res = $this->getAllOptions(false,$colValue);
								if( !$res ){
									$error = true;
									$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
									CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
								}
								$userArr = array_merge($userArr,$res);
							}
							$colValue = $userId = array_key_exists( $colValue, $userArr ) ? $userArr[$colValue] : 0;
						}
					}

					if( in_array($columnKey, array( 'option_is_separate_images', 'option_is_color', 'option_display_in_filter', 'option_deleted' ) ) ){
						if( $this->settings['CONF_USE_O_OR_1'] ){
							$colValue = FatUtility::int($colValue);
						}else{
							$colValue = ( strtoupper($colValue) == 'YES' ) ? applicationConstants::YES : applicationConstants::NO;
						}
					}

					if( 'option_name' == $columnKey ){
						$optionsLangArr[$columnKey] = $colValue;
					}
					else{
						$optionsArr[$columnKey] = $colValue;
					}
				}
			}
			if( !$error && count($optionsArr) ){
				$data = array( 'option_type' => Option::OPTION_TYPE_SELECT );

				$data = array_merge( $data, $optionsArr );

				if( $this->settings['CONF_USE_OPTION_ID'] ){
					$optionData =  Option::getAttributesById( $data['option_id'], array('option_id') );
				}else{
					$brandId = 0;
					$optionData = Option::getAttributesByIdentifier( $data['option_identifier'], array('option_id') );
				}


				if( !empty($optionData) && $optionData['option_id'] ){
					$optionId = $optionData['option_id'];
					$where = array('smt' => 'option_id = ?', 'vals' => array( $optionId ) );
					$this->db->updateFromArray( Option::DB_TBL, $data, $where );
				}else{
					if( $this->isDefaultSheetData($langId) ){
						$this->db->insertFromArray( Option::DB_TBL, $data );
						$optionId = $this->db->getInsertId();
					}
				}

				if($optionId){
					/* Lang Data [*/
					$langData = array(
						'optionlang_option_id'=> $optionId,
						'optionlang_lang_id'=> $langId,
					);
					$langData = array_merge( $langData, $optionsLangArr );
					$this->db->insertFromArray( Option::DB_LANG_TBL, $langData , false, array(),$langData );
					/* ]*/
				}
			}
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportOptionValues($langId,$userId = 0){
		$userId = FatUtility::int($userId);
		$srch = OptionValue::getSearchObject();
		$srch->joinTable(OptionValue::DB_TBL . '_lang',
		'LEFT OUTER JOIN','ovl.optionvaluelang_optionvalue_id = ov.optionvalue_id
		AND ovl.optionvaluelang_lang_id = ' . $langId,'ovl');
		$srch->joinTable(Option::DB_TBL,'LEFT OUTER JOIN','ov.optionvalue_option_id = o.option_id','o');
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$srch->addMultipleFields(array('optionvalue_id','optionvalue_option_id','optionvalue_identifier','optionvalue_color_code','optionvalue_display_order','IFNULL(optionvalue_name,optionvalue_identifier) as optionvalue_name','option_identifier'));
		$srch->addOrder('optionvalue_id','ASC');
		$rs = $srch->getResultSet();

		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getOptionsValueColoumArr($langId,$userId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){

			foreach ($headingsArr as $columnKey => $heading) {
                $colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';
				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return $sheetData;
	}

	public function importOptionValues($csvFilePointer,$post,$langId){

		$rowIndex = 0;
		$optionIdentifierArr = array();
		$optionIdArr = array();

		$optionValueObj= new OptionValue();
		$srchObj = OptionValue::getSearchObject();

		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;

			if($rowIndex == 1){
				$coloumArr = $this->getOptionsValueColoumArr($langId);

				if( !$this->isValidColumns($row, $coloumArr) ){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndexArr = array_flip($row);

				$errfileName = $this->logFileName('Option_Values');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$sellerProdPolicyArr = $sellerProdPolicyLangArr = array();
			$error = false;
			$optionvalue_identifier = '';

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndexArr[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( in_array( $columnKey, array( 'optionvalue_id', 'optionvalue_option_id' ) ) && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading, Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0.", $langId ) );
				}else if( in_array( $columnKey, array( 'optionvalue_identifier', 'option_identifier', 'optionvalue_name', 'optionvalue_display_order' ) ) && empty($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading, Labels::getLabel( "MSG_{column-name}_is_mandatory.", $langId ) );
				}

				if( $errMsg ){
					$err = array($rowIndex, ( $colIndex + 1), $errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{
					if( in_array( $columnKey, array( 'optionvalue_id', 'optionvalue_identifier' ) ) ){
						if( 'optionvalue_id' == $columnKey ){
							$optionValueData = OptionValue::getAttributesById( $colValue, array( 'optionvalue_id' ) );
						}else{
							$optionvalue_identifier = $colValue;
						}
					}

					if( in_array($columnKey, array( 'optionvalue_option_id', 'option_identifier' ) ) ){
						$optionId = 0;
						if( 'optionvalue_option_id' == $columnKey && !array_key_exists( $colValue, $optionIdArr ) ){
							$optionId = $colValue
							$res = $this->getAllOptions( true, $optionId );
							if(!$res){
								$error = true;
								$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
								CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
							}
							$optionIdArr = array_merge( $optionIdArr, $res );
						}

						if( 'option_identifier' == $columnKey ){
							if( !array_key_exists($colValue, $optionIdentifierArr) ){
								$res = $this->getAllOptions(false,$colValue);
								if(!$res){
									$error = true;
									$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
									CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
								}
								$optionIdentifierArr = array_merge( $optionIdentifierArr, $res );
							}

							$optionId = $colValue = array_key_exists($colValue, $optionIdentifierArr) ? $optionIdentifierArr[$colValue] : 0;
						}

						if( !$optionId ){
							$error = true;
							$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
							CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
						}else{
							$optionValueData = $optionValueObj->getAtttibutesByIdentifierAndOptionId( $optionId, $optionvalue_identifier, array( 'optionvalue_id' ) );
						}
					}

					if( 'optionvalue_name' == $columnKey ){
						$sellerProdPolicyLangArr[$columnKey] = $colValue;
					}else{
						$sellerProdPolicyArr[$columnKey] = $colValue;
					}
				}
			}

			if( !$error && count($sellerProdPolicyArr) ){

				if( !empty($optionValueData) && $optionValueData['optionvalue_id'] ){
					$optionValueId = $optionValueData['optionvalue_id'];
					$where = array('smt' => 'optionvalue_id = ?', 'vals' => array( $optionValueId ) );
					$this->db->updateFromArray( OptionValue::DB_TBL, $sellerProdPolicyArr, $where);
				}else{
					if( $this->isDefaultSheetData($langId) ){
						$this->db->insertFromArray( OptionValue::DB_TBL, $sellerProdPolicyArr);
						$optionValueId = $this->db->getInsertId();
					}
				}

				if($optionValueId){
					/* Lang Data [*/
					$langData = array(
						'optionvaluelang_optionvalue_id'=> $optionValueId,
						'optionvaluelang_lang_id'=> $langId,
					);
					$langData = array_merge( $langData, $sellerProdPolicyLangArr );

					$this->db->insertFromArray( OptionValue::DB_TBL_LANG, $langData , false, array(),$langData );
					/* ]*/
				}

			}
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportTags($langId, $userId = 0){
		$userId = FatUtility::int($userId);
		$srch = Tag::getSearchObject($langId);
		$srch->addMultipleFields(array('tag_id','tag_identifier','tag_user_id','tag_admin_id','tag_name','credential_username'));
		$srch->joinTable(User::DB_TBL,'LEFT OUTER JOIN','u.user_id = t.tag_user_id','u');
		$srch->joinTable(User::DB_TBL_CRED,'LEFT OUTER JOIN','uc.credential_user_id = u.user_id','uc');
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$rs = $srch->getResultSet();

		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getTagColoumArr($langId,$userId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){

			foreach ($headingsArr as $columnKey => $heading) {

				$colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';

				if( 'credential_username' == $columnKey ){
					$colValue = ( !empty( $colValue ) ? $colValue : Labels::getLabel('LBL_Admin',$langId) );
				}

				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return $sheetData;
	}

	public function importTags($csvFilePointer,$post,$langId){

		$rowIndex = 0;
		$usernameArr = array();
		$useTagId  = false;
		if($this->settings['CONF_USE_TAG_ID']){
			$useTagId = true;
		}

		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;

			if( $rowIndex == 1 ){
				$coloumArr = $this->getTagColoumArr($langId);

				if( !$this->isValidColumns( $row, $coloumArr ) ){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndexArr = array_flip($row);

				$errfileName = $this->logFileName('Tags');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$tagsArr = $tagsLangArr = array();
			$error = false;

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndexArr[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( 'tag_id' == $columnKey  && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading, Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0.", $langId ) );
				}else if( in_array( $columnKey, array( 'tag_identifier', 'tag_name' ) ) && empty($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading, Labels::getLabel( "MSG_{column-name}_is_mandatory.", $langId ) );
				}

				if( $errMsg ){
					$err = array($rowIndex, ( $colIndex + 1), $errMsg);
					CommonHelper::writeLogFile( $errFile,  $err );
				}else{
					if( 'credential_username' == $columnKey ){
						$columnKey = 'tag_user_id';
						$colValue = ( $colValue == Labels::getLabel('LBL_Admin',$langId) ? '' : $colValue );

						if( !empty($colValue) && !array_key_exists( $colValue, $usernameArr ) ){
							$res = $this->getAllUserArr( false, $colValue );
							if(!$res){
								$error = true;
								$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
								CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
							}
							$usernameArr = array_merge( $usernameArr, $res );
						}
						$userId = $colValue = array_key_exists( $colValue, $usernameArr ) ? $usernameArr[$colValue] : 0;
					}

					if( in_array( $columnKey, array( 'tag_identifier', 'tag_name' ) ) && empty($colValue) ){
						if( 'tag_id' == $columnKey ){
							$tagData = Tag::getAttributesById( $colValue, array('tag_id') );
						}

						if( 'tag_identifier' == $columnKey ){
							$tagData = Tag::getAttributesByIdentifier( $colValue, array('tag_id') );
						}
					}

					if( 'tag_name' == $columnKey ){
						$tagsLangArr[$columnKey] = $colValue;
					}else{
						if( $userId ){
							$tagsArr['tag_admin_id']	= 0;
						}

						$tagsArr[$columnKey] = $colValue;
					}
				}
			}

			if( !$error && count($tagsArr) ){
				if( !empty($tagData) && $tagData['tag_id'] ){
					$tagId = $tagData['tag_id'];
					$where = array('smt' => 'tag_id = ?', 'vals' => array( $tagId ) );
					$this->db->updateFromArray( Tag::DB_TBL, $tagsArr, $where);
				}else{
					if( $this->isDefaultSheetData( $langId ) ){
						$this->db->insertFromArray( Tag::DB_TBL, $tagsArr );
						$tagId = $this->db->getInsertId();
					}
				}

				if($tagId){
					/* Lang Data [*/
					$langData = array(
						'taglang_tag_id'=> $tagId,
						'taglang_lang_id'=> $langId,
					);
					$langData = array_merge( $langData, $tagsLangArr );

					$this->db->insertFromArray( Tag::DB_LANG_TBL, $langData , false, array(),$langData );
					/* ]*/

					/* update product tags association and tag string in products lang table[ */
					Tag::updateTagStrings( $tagId );
					/* ] */
				}

			}
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportCountries($langId, $userId = 0){
		$userId = FatUtility::int($userId);

		$srch = Countries::getSearchObject(false ,$langId);
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		if($userId){
			$srch->addCondition('country_active','=',applicationConstants::ACTIVE);
		}
		$rs = $srch->getResultSet();

		$languageCodes = Language::getAllCodesAssoc(true);
		$currencyCodes = Currency::getCurrencyAssoc(true);

		$useCountryId = false;
		if($this->settings['CONF_USE_COUNTRY_ID']){
			$useCountryId = true;
		}

		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getCountryColoumArr($langId,$userId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){
			foreach ($headingsArr as $columnKey => $heading) {
                $colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : 'a';

				if( 'country_currency_code' == $columnKey ){
					$colValue =  array_key_exists($row['country_currency_id'], $currencyCodes) ? $currencyCodes[$row['country_currency_id']] : 0;
				}

				if( 'country_language_code' == $columnKey ){
					$colValue =  array_key_exists($row['country_language_id'], $languageCodes) ? $languageCodes[$row['country_language_id']] : 0;
				}

				if( 'country_active' == $columnKey ){
					if( !$this->settings['CONF_USE_O_OR_1'] ){
						$colValue = (FatUtility::int($colValue) == 1) ? 'YES' : 'NO';
					}
				}

				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return $sheetData;
	}

	public function importCountries($csvFilePointer,$post,$langId){

		$rowIndex = 0;

		$useCountryId  = false;
		if($this->settings['CONF_USE_COUNTRY_ID']){
			$useCountryId = true;
		}

		$languageCodes = Language::getAllCodesAssoc(true);
		$languageIds = array_flip($languageCodes);

		$currencyCodes = Currency::getCurrencyAssoc(true);
		$currencyIds = array_flip($currencyCodes);

		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;

			if($rowIndex == 1){
				$coloumArr = $this->getCountryColoumArr($langId);

				if( !$this->isValidColumns($row, $coloumArr) ){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndexArr = array_flip($row);

				$errfileName = $this->logFileName('Countries');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$countryArr = $countryLangArr = array();
			$error = false;

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndexArr[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( in_array( $columnKey, array( 'country_id' ) ) && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading, Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0.", $langId ) );
				}else if( in_array( $columnKey, array( 'country_code', 'country_name' ) ) && empty($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading, Labels::getLabel( "MSG_{column-name}_is_mandatory.", $langId ) );
				}

				if( $errMsg ){
					$err = array($rowIndex, ( $colIndex + 1), $errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{

					if( 'country_currency_id' == $columnKey ){
						$currencyId = FatUtility::int($colValue);
						$colValue =  array_key_exists($currencyId, $languageCodes) ? $currencyId : 0;
					}elseif ( 'country_currency_code' == $columnKey ) {
						$columnKey = 'country_currency_id';
						$colValue = array_key_exists($colValue, $currencyIds) ? $currencyIds[$colValue] : 0;
					}

					if( 'country_language_id' == $columnKey ){
						$currencyLangId = FatUtility::int($colValue);
						$colValue = array_key_exists($currencyLangId, $languageCodes) ? $currencyLangId : 0;
					}elseif ( 'country_currency_code' == $columnKey ) {
						$columnKey = 'country_language_id';
						$colValue = array_key_exists($colValue, $languageIds) ? $languageIds[$colValue] : 0;
					}

					if( 'country_active' == $columnKey ){
						if( $this->settings['CONF_USE_O_OR_1'] ){
							$colValue = FatUtility::int($colValue);
						}else{
							$colValue = ( strtoupper($colValue) == 'YES' ) ? applicationConstants::YES : applicationConstants::NO;
						}
					}

					if( 'country_id' == $columnKey ){
						$countryData = Countries::getAttributesById( $colValue, array('country_id') );
					}elseif ( 'country_code' == $columnKey ) {
						$countryData = Countries::getCountryByCode( $colValue, array('country_id') );
					}

					if( 'country_name' == $columnKey ){
						$countryLangArr[$columnKey] = $colValue;
					}else{
						$countryArr[$columnKey] = $colValue;
					}
				}
			}

			if( !$error && count($countryArr) ){

				if( !empty($countryData) && $countryData['country_id'] ){
					$countryId = $countryData['country_id'];
					$where = array('smt' => 'country_id = ?', 'vals' => array( $countryId ) );
					$this->db->updateFromArray( Countries::DB_TBL, $countryArr, $where );

				}else{
					if( $this->isDefaultSheetData($langId) ){
						$this->db->insertFromArray( Countries::DB_TBL, $countryArr );
						$countryId = $this->db->getInsertId();
					}
				}

				if($countryId){
					/* Lang Data [*/
					$langData = array(
						'countrylang_country_id'=> $countryId,
						'countrylang_lang_id'=> $langId,
					);
					$langData = array_merge( $langData, $countryLangArr );
					$this->db->insertFromArray( Countries::DB_TBL_LANG, $langData , false, array(),$langData );
					/* ]*/
				}
			}

		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );

		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportStates($langId, $userId = 0){
		$userId = FatUtility::int($userId);
		$useStateId = false;
		if($this->settings['CONF_USE_STATE_ID']){
			$useStateId = true;
		}

		$srch = States::getSearchObject(false ,$langId);
		$srch->joinTable(Countries::DB_TBL,'LEFT OUTER JOIN','st.state_country_id = c.country_id','c');
		$srch->addMultipleFields(array('state_id','state_code','state_country_id','state_identifier','state_active','country_id','country_code','state_name'));
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		if($userId){
			$srch->addCondition('state_active','=',applicationConstants::ACTIVE);
		}

		if($useStateId){
			$srch->addOrder('state_country_id','ASC');
			$srch->addOrder('state_id','ASC');
		}else{
			$srch->addOrder('country_code','ASC');
			$srch->addOrder('state_identifier','ASC');
		}

		$rs = $srch->getResultSet();

		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getStatesColoumArr($langId, $userId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){

			foreach ($headingsArr as $columnKey => $heading) {
                $colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';

				if( 'state_active' == $columnKey && !$this->settings['CONF_USE_O_OR_1'] ){
					$colValue = (FatUtility::int($colValue) == 1) ? 'YES' : 'NO';
				}
				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return $sheetData;
	}

	public function importStates($csvFilePointer,$post,$langId){

		$rowIndex = 0;

		if($this->settings['CONF_USE_COUNTRY_ID']){
			$countryCodes = $this->getCountriesArr(true);
		}else{
			$countryIds = $this->getCountriesArr(false);
		}

		while( ($row = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;

			if($rowIndex == 1){
				$coloumArr = $this->getStatesColoumArr($langId);

				if( !$this->isValidColumns($row, $coloumArr) ){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}

				$headingIndexArr = array_flip($row);

				$errfileName = $this->logFileName('States');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$statesArr = $statesLangArr = array();
			$error = false;

			foreach ($coloumArr as $columnKey => $heading) {
				$colIndex = $headingIndexArr[$heading];
				$colValue = trim( $row[$colIndex] );
				$errMsg = '';

				if( in_array( $columnKey, array( 'state_id', 'state_country_id' ) ) && 0 >= FatUtility::int($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading, Labels::getLabel( "MSG_{column-name}_should_be_greater_than_0.", $langId ) );
				}else if( in_array( $columnKey, array( 'state_identifier', 'country_code', 'state_name', 'state_code' ) ) && empty($colValue) ){
					$error = true;
					$errMsg = str_replace( '{column-name}',$heading, Labels::getLabel( "MSG_{column-name}_is_mandatory.", $langId ) );
				}


				if( $errMsg ){
					$err = array($rowIndex, ( $colIndex + 1), $errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
				}else{

					if( in_array( $columnKey, array( 'state_country_id', 'country_code' ) ) ){
						if( 'state_country_id' == $columnKey ){
							$currencyId = FatUtility::int($colValue);
							$colValue = array_key_exists($countryId, $countryCodes) ? $countryId : 0;
						}elseif ( 'country_code' == $columnKey ) {
							$columnKey = 'state_country_id';
							$colValue = array_key_exists($colValue, $countryIds) ? $countryIds[$colValue] : 0;
						}
						if( !$colValue ){
							$error = true;
							$errMsg = str_replace( '{column-name}', $heading, Labels::getLabel( "MSG_Invalid_{column-name}.", $langId ) );
							CommonHelper::writeLogFile( $errFile, array( $rowIndex, ( $colIndex + 1), $errMsg ) );
						}
					}

					if( 'state_active' == $columnKey ){
						if($this->settings['CONF_USE_O_OR_1']){
							$colValue = (FatUtility::int($colValue) == 1) ? applicationConstants::YES : applicationConstants::NO;
						}else{
							$colValue = strtoupper($colValue) == 'YES') ? applicationConstants::YES : applicationConstants::NO;
						}
					}

					if( 'state_name' == $columnKey ){
						$countryLangArr[$columnKey] = $colValue;
					}else{
						$countryArr[$columnKey] = $colValue;
					}
				}
			}

			if( !$error && count($countryArr) ){
				if( $this->settings['CONF_USE_STATE_ID'] ){
					$stateData = States::getAttributesById( $countryArr['state_id'], array('state_id') );
				}else{
					$stateData = States::getAttributesByIdentifierAndCountry( $countryArr['state_identifier'], $countryArr['state_country_id'], array('state_id') );
				}

				if( !empty($stateData) && $stateData['state_id'] ){
					$stateId = $stateData['state_id'];
					$where = array('smt' => 'state_id = ?', 'vals' => array( $stateId ) );
					$this->db->updateFromArray( States::DB_TBL, $data,$where);
				}else{
					if($this->isDefaultSheetData($langId)){
						$this->db->insertFromArray( States::DB_TBL, $data);
						$stateId = $this->db->getInsertId();
					}
				}
				if($stateId){
					/* Lang Data [*/
					$langData = array(
						'statelang_state_id'=> $stateId,
						'statelang_lang_id'=> $langId,
					);

					$langData = array_merge( $langData, $countryLangArr );

					$this->db->insertFromArray( States::DB_TBL_LANG, $langData , false, array(),$langData );
					/* ]*/
				}
			}
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );



		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportPolicyPoints($langId, $userId = 0){
		$userId = FatUtility::int($userId);
		$srch = PolicyPoint::getSearchObject($langId, false);
		$srch->addMultipleFields(array('ppoint_id','ppoint_identifier','ppoint_type','ppoint_display_order','ppoint_active','ppoint_deleted','ppoint_title'));
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		if($userId){
			$srch->addCondition('ppoint_active','=',applicationConstants::ACTIVE);
		}
		$rs = $srch->getResultSet();

		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getPolicyPointsColoumArr($langId, $userId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$usePolicyPointId = false;
		if($this->settings['CONF_USE_POLICY_POINT_ID']){
			$usePolicyPointId = true;
		}

		$policyPointTypeArr = PolicyPoint::getPolicyPointTypesArr($langId);

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){

			foreach ($headingsArr as $columnKey => $heading) {

				$colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';

				if( in_array( $columnKey, array( 'ppoint_active', 'ppoint_deleted' ) ) && !$this->settings['CONF_USE_O_OR_1'] ){
					$colValue = (FatUtility::int($colValue) == 1) ? 'YES' : 'NO';
				}

				if(  'ppoint_type_identifier' == $columnKey ){
					$colValue = isset( $policyPointTypeArr[$row['ppoint_type']] ) ? $policyPointTypeArr[$row['ppoint_type']] : '';
				}

				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return $sheetData;
	}

	public function importPolicyPoints($csvFilePointer,$post,$langId){

		$rowIndex = $rowCount = 0;

		$usePolicyPointId  = false;
		if($this->settings['CONF_USE_POLICY_POINT_ID']){
			$usePolicyPointId = true;
		}

		$policyPointTypeArr = PolicyPoint::getPolicyPointTypesArr($langId);
		$policyPointTypeKeys = array_flip($policyPointTypeArr);

		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			if(empty($line[0])){
				continue;
			}

			if($rowCount == 0){
				$coloumArr = $this->getPolicyPointsColoumArr($langId);
				if($line !== $coloumArr){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Policy_Points');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$numcols = count($line);
			$colCount = 0;

			if($usePolicyPointId){
				$policyPointId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $policyPointId ){
					$errMsg = Labels::getLabel( "MSG_Policy_point_id_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				if($this->isDefaultSheetData($langId)){
					$identifier = $this->getCell($line,$colCount++,'');
					if(trim($identifier) == ''){
						$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
				}
			}else{
				$identifier = $this->getCell($line,$colCount++,'');
				if(trim($identifier) == ''){
					$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
			}

			$title = $this->getCell($line,$colCount++,'');

			if($this->isDefaultSheetData($langId)){
				if($this->settings['CONF_USE_POLICY_POINT_TYPE_ID']){
					$policyPointTypeId = FatUtility::int($this->getCell($line,$colCount++,0));
					$policyPointTypeId = isset($policyPointTypeArr[$policyPointTypeId])?$policyPointTypeId:0;
				}else{
					$policyPointType = $this->getCell($line,$colCount++,'');
					$policyPointTypeId = isset($policyPointTypeKeys[$policyPointType])?$policyPointTypeKeys[$policyPointType]:0;
				}
				if(!$policyPointTypeId){
					$errMsg = Labels::getLabel( "MSG_Policy_point_type_Id_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}

				$displayOrder = $this->getCell($line,$colCount++,0);
				if($this->settings['CONF_USE_O_OR_1']){
					$active = (FatUtility::int($this->getCell($line,$colCount++,0)) == 1)?applicationConstants::YES:applicationConstants::NO;
					$deleted = (FatUtility::int($this->getCell($line,$colCount++,0)) == 1)?applicationConstants::YES:applicationConstants::NO;
				}else{
					$active = ($this->getCell($line,$colCount++,0) == 'YES')?applicationConstants::YES:applicationConstants::NO;
					$deleted = ($this->getCell($line,$colCount++,0) == 'YES')?applicationConstants::YES:applicationConstants::NO;
				}
			}

			if($rowCount > 0){
				$data = array();

				if($usePolicyPointId){
					$data['ppoint_id']	= $policyPointId;
					if($this->isDefaultSheetData($langId)){
						$data['ppoint_identifier'] = $identifier;
					}
				}else{
					$data['ppoint_identifier'] = $identifier;
				}

				if($this->isDefaultSheetData($langId)){
					$data['ppoint_type'] = $policyPointTypeId;
					$data['ppoint_display_order'] = $displayOrder;
					$data['ppoint_active'] = $active;
					$data['ppoint_deleted'] = $deleted;
				}

				if($usePolicyPointId){
					$policyData = PolicyPoint::getAttributesById($policyPointId,array('ppoint_id'));
				}else{
					$policyData = PolicyPoint::getAttributesByIdentifier($identifier,array('ppoint_id'));
				}

				if(!empty($policyData) && $policyData['ppoint_id']){
					$policyPointId = $policyData['ppoint_id'];
					$where = array('smt' => 'ppoint_id = ?', 'vals' => array( $policyPointId ) );
					$this->db->updateFromArray( PolicyPoint::DB_TBL, $data,$where);
				}else{
					if($this->isDefaultSheetData($langId)){
						$this->db->insertFromArray( PolicyPoint::DB_TBL, $data);
						$policyPointId = $this->db->getInsertId();
					}
				}

				if($policyPointId){
					/* Lang Data [*/
					$langData = array(
						'ppointlang_ppoint_id'=> $policyPointId,
						'ppointlang_lang_id'=> $langId,
						'ppoint_title'=> $title,
					);
					$this->db->insertFromArray( PolicyPoint::DB_TBL_LANG, $langData , false, array(),$langData );
					/* ]*/
				}
			}
			$rowCount++;
		}
		// Close File
		CommonHelper::writeLogFile( $errFile, array(), true );



		$success['msg'] = Labels::getLabel( 'LBL_data_imported/updated_Successfully.', $langId );
		if(CommonHelper::checkLogFile( $errfileName )){
			$success['redirectUrl'] = FatUtility::generateFullUrl( 'custom','downloadLogFile',array($errfileName),CONF_WEBROOT_FRONTEND );
		}
		FatUtility::dieJsonSuccess($success);
	}

	public function exportUsers($langId,$offset = null,$noOfRows = null,$minId = null,$maxId = null){
		$userObj = new User();
		$srch = $userObj->getUserSearchObj();
		$srch->addOrder('u.user_id','DESC');
		$srch->addCondition('u.user_is_shipping_company', '=', applicationConstants::NO);
		$srch->doNotCalculateRecords();
		$srch->addFld( array('user_is_buyer', 'user_is_supplier','user_is_advertiser','user_is_affiliate', 'user_registered_initially_for') );
		if (isset($offset) && isset($noOfRows)) {
			$srch->setPageNumber($offset);
			$srch->setPageSize($noOfRows);
		}else{
			$srch->setPageSize(static::MAX_LIMIT);
		}

		if (isset($minId) && isset($maxId)) {
			$srch->addCondition('user_id','>=',$minId);
			$srch->addCondition('user_id','<=',$maxId);
		}

		$srch->addOrder('user_id','ASC');
		$rs = $srch->getResultSet();
		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getUsersColoumArr($langId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$userTypeArr = User::getUserTypesArr($langId);

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){

			foreach ($headingsArr as $columnKey => $heading) {

				$colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';

				if( in_array( $columnKey, array( 'user_is_buyer', 'user_is_supplier', 'user_is_advertiser', 'user_is_affiliate' ) ) && !$this->settings['CONF_USE_O_OR_1'] ){
					$colValue = (FatUtility::int($colValue) == 1) ? 'YES' : 'NO';
				}

				if(  'urlrewrite_custom' == $columnKey ){
					$colValue = isset($urlKeywords[ProductCategory::REWRITE_URL_PREFIX.$row['prodcat_id']]) ? $urlKeywords[ProductCategory::REWRITE_URL_PREFIX.$row['prodcat_id']] : '';
				}

				if(  'prodcat_parent_identifier' == $columnKey ){
					$colValue = array_key_exists($row['prodcat_parent'], $categoriesIdentifiers) ? $categoriesIdentifiers[$row['prodcat_parent']] : '';
				}

				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return  $sheetData;
	}

	public function exportTaxCategory($langId, $userId = 0){
		$userId = FatUtility::int($userId);
		$taxObj = new Tax();
		$srch = $taxObj->getSearchObject($langId,false);

		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		if($userId){
			$srch->addCondition('taxcat_active','=',applicationConstants::ACTIVE);
			$srch->addCondition('taxcat_deleted','=',applicationConstants::NO);
		}
		$rs = $srch->getResultSet();

		$sheetData = array();
		/* Sheet Heading Row [ */
		$headingsArr = $this->getSalesTaxColumArr($langId, $userId);
		array_push( $sheetData, $headingsArr );
		/* ] */

		$rowIndex = 1;
		while( $row = $this->db->fetch($rs) ){

			foreach ($headingsArr as $columnKey => $heading) {

				$colValue = array_key_exists($columnKey, $row) ? $row[$columnKey] : '';

				if( in_array( $columnKey, array( 'taxcat_active', 'taxcat_deleted' ) ) && !$this->settings['CONF_USE_O_OR_1'] ){
					$colValue = (FatUtility::int($colValue) == 1) ? 'YES' : 'NO';
				}

				if(  'taxcat_last_updated' == $columnKey ){
					$colValue = $this->displayDateTime($colValue);
				}

				$sheetData[$rowIndex][] = $colValue;
			}
			$rowIndex++;
		}
		return $sheetData;
	}
}
