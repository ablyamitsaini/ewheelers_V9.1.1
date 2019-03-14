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
				$this->importBrands($csvFilePointer,$post,$langId);
			break;
			case Importexport::TYPE_CATEGORIES:
				$this->importCategories($csvFilePointer,$post,$langId);
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
		$arr = $this->getCategoryColoumArr($langId, $userId);
		array_push( $sheetData, $arr );
		/* ] */

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();

			if($useCategoryId){
				$sheetArr[] = $row['prodcat_id'];
				if($this->isDefaultSheetData($langId)){
					$sheetArr[] = $row['prodcat_identifier'];
				}
			}else{
				$sheetArr[] = $row['prodcat_identifier'];
			}

			if($this->isDefaultSheetData($langId)){
				if($useCategoryId){
					$sheetArr[] = $row['prodcat_parent'];
				}else{
					$sheetArr[] = isset($categoriesIdentifiers[$row['prodcat_parent']])?$categoriesIdentifiers[$row['prodcat_parent']]:'';
				}
			}

			$sheetArr[] = $row['prodcat_name'];
			if(!$userId){
				$sheetArr[] = $row['prodcat_description'];
				/* $sheetArr[] = $row['prodcat_content_block']; */

				if($this->isDefaultSheetData($langId)){
					if($this->settings['CONF_USE_O_OR_1']){
						$featured = $row['prodcat_featured'];
						$active = $row['prodcat_active'];
						$deleted = $row['prodcat_deleted'];
					}else{
						$featured = ($row['prodcat_featured'])?'YES':'NO';
						$active = ($row['prodcat_active'])?'YES':'NO';
						$deleted = ($row['prodcat_deleted'])?'YES':'NO';
					}

					$keyword = isset($urlKeywords[ProductCategory::REWRITE_URL_PREFIX.$row['prodcat_id']])?$urlKeywords[ProductCategory::REWRITE_URL_PREFIX.$row['prodcat_id']]:'';
					$sheetArr[] = $keyword;
					$sheetArr[] = $featured;
					$sheetArr[] = $active;
					$sheetArr[] = $row['prodcat_display_order'];
					$sheetArr[] = $deleted;
				}
			}
			array_push( $sheetData, $sheetArr );
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

	public function importCategories($csvFilePointer,$post,$langId){

		$rowIndex = $rowCount = 0;

		$useCategoryId = false;
		if($this->settings['CONF_USE_CATEGORY_ID']){
			$useCategoryId = true;
		}else{
			$categoriesIdentifiers = $this->getAllCategoryIdentifiers(false);
		}

		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){

			$rowIndex++;

			// if(empty($line[0])){
			// 	continue;
			// }

			if($rowCount == 0){
				$coloumArr = $this->getCategoryColoumArr($langId);
				if($line !== $coloumArr){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Categories');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$numcols = count($line);
			$colCount = 0;

			// if($useCategoryId){
			// 	$categoryId = FatUtility::int($this->getCell($line,$colCount++,0));
			// 	if(!$categoryId){
			// 		$errMsg = Labels::getLabel( "MSG_Category_Id_is_required.", $langId );
			// 		$err = array($rowIndex,$colCount,$errMsg);
			// 		CommonHelper::writeLogFile( $errFile,  $err);
			// 		continue;
			// 	}
			// 	if($this->isDefaultSheetData($langId)){
			// 		$identifier = trim($this->getCell($line,$colCount++,''));
			// 		if($identifier == '') {
			// 			$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
			// 			$err = array($rowIndex,$colCount,$errMsg);
			// 			CommonHelper::writeLogFile( $errFile, $err );
			// 			continue;
			// 		}
			// 	}
			// }else{
			// 	$identifier = trim($this->getCell($line,$colCount++,''));
			// 	if($identifier == '') {
			// 		$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
			// 		$err = array($rowIndex,$colCount,$errMsg);
			// 		CommonHelper::writeLogFile( $errFile,  $err);
			// 		continue;
			// 	}
			// }

			$useIdentifier = true;
			if($useCategoryId){
				$categoryId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $categoryId ){
					$errMsg = Labels::getLabel( "MSG_Valid_category_id_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$useIdentifier = $this->isDefaultSheetData($langId);
			}

			if( $useIdentifier ){
				$identifier = trim($this->getCell($line,$colCount++,''));
				if(empty( $identifier ) ){
					$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
			}

			if($this->isDefaultSheetData($langId)){
				if($useCategoryId){
					$parent = FatUtility::int($this->getCell($line,$colCount++,0));
				}else{
					$col = $this->getCell($line,$colCount++,'');
					$parent = 0;
					if(trim($col) !=''){
						$parent = isset($categoriesIdentifiers[$col])?$categoriesIdentifiers[$col]:0;
					}
				}

				if($parent){
					$categoryData = ProductCategory::getAttributesById($parent,'prodcat_id');
					if(empty($categoryData) || $categoryData == false){
						$parent = 0;
					}
				}
			}

			$name = $this->getCell($line,$colCount++,'');
			if(empty($name)){
				$errMsg = Labels::getLabel( "MSG_Category_name_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}
			$description = $this->getCell($line,$colCount++,'');
			/* $contentBlock = $this->getCell($line,$colCount++,''); */

			if($this->isDefaultSheetData($langId)){
				$seoUrl = $this->getCell($line,$colCount++,'');
				if(empty($seoUrl)){
					$errMsg = Labels::getLabel( "MSG_Category_SEO_Friendly_URL_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$featured = $this->getCell($line,$colCount++,0);
				if( $featured == '' || $featured < 0 ){
					$errMsg = Labels::getLabel( "MSG_Featured_column_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$active = $this->getCell($line,$colCount++,0);
				if( $active == '' || $active < 0){
					$errMsg = Labels::getLabel( "MSG_Active_column_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$displayOrder = $this->getCell($line,$colCount++,0);
				if( $displayOrder == '' || $displayOrder < 0){
					$errMsg = Labels::getLabel( "MSG_Display_order_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$deleted = $this->getCell($line,$colCount++,0);
				if( $deleted == '' || $deleted < 0){
					$errMsg = Labels::getLabel( "MSG_Deleted_column_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
			}

			if(!$numcols || $numcols != $colCount){
				Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
				FatUtility::dieJsonError( Message::getHtml() );
			}

			if($rowCount > 0){
				$data = array();
				if($this->isDefaultSheetData($langId)){
					$data['prodcat_identifier']	= $identifier;
					$data['prodcat_display_order']	= $displayOrder;
					$data['prodcat_parent']	= $parent;
					if($this->settings['CONF_USE_O_OR_1']){
						$data['prodcat_featured'] = (FatUtility::int($featured) == 1)?applicationConstants::YES:applicationConstants::NO;
						$data['prodcat_active'] = (FatUtility::int($active) == 1)?applicationConstants::YES:applicationConstants::NO;
						$data['prodcat_deleted'] = (FatUtility::int($deleted) == 1)?applicationConstants::YES:applicationConstants::NO;
					}else{
						$data['prodcat_featured'] = (strtoupper($featured) == 'YES')?applicationConstants::YES:applicationConstants::NO;
						$data['prodcat_active'] = (strtoupper($active) == 'YES')?applicationConstants::YES:applicationConstants::NO;
						$data['prodcat_deleted'] = (strtoupper($deleted) == 'YES')?applicationConstants::YES:applicationConstants::NO;
					}
				}

				if($useCategoryId){
					$data['prodcat_id']	= $categoryId;
					if($this->isDefaultSheetData($langId)){
						$data['prodcat_identifier']	= $identifier;
					}
					$categoryData = ProductCategory::getAttributesById($categoryId,array('prodcat_id'));
				}else{
					$data['prodcat_identifier']	= $identifier;
					$categoryId = 0;
					$categoryData = ProductCategory::getAttributesByIdentifier($identifier,array('prodcat_id'));
				}

				if(!empty($categoryData) && $categoryData['prodcat_id']){
					$categoryId = $categoryData['prodcat_id'];
					$where = array('smt' => 'prodcat_id = ?', 'vals' => array( $categoryId ) );
					$this->db->updateFromArray( ProductCategory::DB_TBL, $data,$where);
				}else{
					if($this->isDefaultSheetData($langId)){
						$this->db->insertFromArray( ProductCategory::DB_TBL, $data);
						$categoryId = $this->db->getInsertId();
					}
				}

				if($categoryId){

					if(!$useCategoryId && !isset($categoriesIdentifiers[$data['prodcat_identifier']])){
						$categoriesIdentifiers[$identifier] = $categoryId;
					}

					/* Lang Data [*/
					$langData = array(
						'prodcatlang_prodcat_id'=> $categoryId,
						'prodcatlang_lang_id'=> $langId,
						'prodcat_name'=> $name,
						'prodcat_description'=> $description,
						/* 'prodcat_content_block'=> $contentBlock, */
					);
					$this->db->insertFromArray( ProductCategory::DB_LANG_TBL, $langData , false, array(),$langData );

					/* ]*/

					/* Update cat code[*/
					$category = new ProductCategory($categoryId);
					$category->updateCatCode();
					/*]*/

					/* Url rewriting [*/
					if($this->isDefaultSheetData($langId)){
						if(trim($seoUrl) == ''){
							$seoUrl = $identifier;
						}
						$prodcatData = ProductCategory::getAttributesById($categoryId,array('prodcat_parent'));
						$category->rewriteUrl($seoUrl,true,$prodcatData['prodcat_parent']);
					}
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
		$arr = $this->getBrandColoumArr($langId, $userId);
		array_push( $sheetData, $arr );
		/* ] */

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();

			if($this->settings['CONF_USE_BRAND_ID']){
				$sheetArr[] = $row['brand_id'];
				if($this->isDefaultSheetData($langId)){
					$sheetArr[] = $row['brand_identifier'];
				}
			}else{
				$sheetArr[] = $row['brand_identifier'];
			}
			$sheetArr[] = $row['brand_name'];

			if(!$userId){
				$sheetArr[] = $row['brand_short_description'];

				if($this->isDefaultSheetData($langId)){
					if($this->settings['CONF_USE_O_OR_1']){
						$featured = $row['brand_featured'];
						$active = $row['brand_active'];
					}else{
						$featured = ($row['brand_featured'])?'YES':'NO';
						$active = ($row['brand_active'])?'YES':'NO';
					}

					$keyword = isset($urlKeywords[Brand::REWRITE_URL_PREFIX.$row['brand_id']])?$urlKeywords[Brand::REWRITE_URL_PREFIX.$row['brand_id']]:'';

					$sheetArr[] = $keyword;
					$sheetArr[] = $featured;
					$sheetArr[] = $active;
				}
			}
			array_push( $sheetData, $sheetArr );
		}

		return $sheetData;
	}

	public function importBrands($csvFilePointer,$post,$langId){

		$rowIndex = $rowCount = 0;
		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){

			$rowIndex++;

			// if(empty($line[0])){
			// 	continue;
			// }

			if($rowCount == 0){
				$coloumArr = $this->getBrandColoumArr($langId);
				if($line !== $coloumArr){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Brands');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$numcols = count($line);
			$colCount = 0;

			// if($this->settings['CONF_USE_BRAND_ID']){
			// 	$brandId = FatUtility::int($this->getCell($line,$colCount++,0));
			// 	if($this->isDefaultSheetData($langId)){
			// 		$identifier = trim($this->getCell($line,$colCount++,''));
			// 		if($identifier == ''){
			// 			$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
			// 			$err = array($rowIndex,$colCount,$errMsg);
			// 			CommonHelper::writeLogFile( $errFile,  $err);
			// 			continue;
			// 		}
			// 	}
			// }else{
			// 	$identifier = trim($this->getCell($line,$colCount++,''));
			// 	if($identifier == ''){
			// 		$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
			// 		$err = array($rowIndex,$colCount,$errMsg);
			// 		CommonHelper::writeLogFile( $errFile,  $err);
			// 		continue;
			// 	}
			// }

			$useIdentifier = true;
			if($this->settings['CONF_USE_BRAND_ID']){
				$brandId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $brandId ){
					$errMsg = Labels::getLabel( "MSG_Valid_brand_id_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$useIdentifier = $this->isDefaultSheetData($langId);
			}

			if( $useIdentifier ){
				$identifier = trim($this->getCell($line,$colCount++,''));
				if(empty( $identifier ) ){
					$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
			}

			$name = $this->getCell($line,$colCount++,'');
			if( empty( $name ) ){
				$errMsg = Labels::getLabel( "MSG_Brand_name_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}
			$description = $this->getCell($line,$colCount++,'');

			if($this->isDefaultSheetData($langId)){
				$seoUrl = $this->getCell($line,$colCount++,'');
				if( empty( $seoUrl ) ){
					$errMsg = Labels::getLabel( "MSG_SEO_Friendly_URL_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$featured = $this->getCell($line,$colCount++,0);
				if( $featured == '' || $featured < 0 ){
					$errMsg = Labels::getLabel( "MSG_Featured_column_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$active = $this->getCell($line,$colCount++,0);
				if( $active == '' || $active < 0 ){
					$errMsg = Labels::getLabel( "MSG_Active_column_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
			}

			if(!$numcols || $numcols != $colCount){
				Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
				FatUtility::dieJsonError( Message::getHtml() );
			}

			if($rowCount > 0){
				$dataToSaveArr = array(
					'brand_status'=>applicationConstants::ACTIVE,
					'brand_identifier'=>$identifier,
				);

				if($this->isDefaultSheetData($langId)){
					if($this->settings['CONF_USE_O_OR_1']){
						$dataToSaveArr['brand_featured'] = (FatUtility::int($featured) == 1)?applicationConstants::YES:applicationConstants::NO;
						$dataToSaveArr['brand_active'] = (FatUtility::int($active) == 1)?applicationConstants::YES:applicationConstants::NO;
					}else{
						$dataToSaveArr['brand_featured'] = (strtoupper($featured) == 'YES')?applicationConstants::YES:applicationConstants::NO;
						$dataToSaveArr['brand_active'] = (strtoupper($active) == 'YES')?applicationConstants::YES:applicationConstants::NO;
					}
				}

				if($this->settings['CONF_USE_BRAND_ID']){
					$dataToSaveArr['brand_id'] = $brandId;
					if($this->isDefaultSheetData($langId)){
						$dataToSaveArr['brand_identifier'] = $identifier;
					}
					$brandData = Brand::getAttributesById($brandId,array('brand_id'));
				}else{
					$brandId = 0;
					$dataToSaveArr['brand_identifier'] = $identifier;
					$brandData = Brand::getAttributesByIdentifier($identifier,array('brand_id'));
				}

				if(!empty($brandData) && $brandData['brand_id']){
					$brandId = $brandData['brand_id'];
					$where = array('smt' => 'brand_id = ?', 'vals' => array( $brandId ) );
					$this->db->updateFromArray( Brand::DB_TBL, $dataToSaveArr,$where);
				}else{
					if($this->isDefaultSheetData($langId)){
						$this->db->insertFromArray( Brand::DB_TBL, $dataToSaveArr);
						$brandId = $this->db->getInsertId();
					}
				}

				if($brandId){
					/* Lang Data [*/
					$langData = array(
						'brandlang_brand_id'=> $brandId,
						'brandlang_lang_id'=> $langId,
						'brand_name'=> $name,
						'brand_short_description'=> $description,
					);
					$this->db->insertFromArray( Brand::DB_LANG_TBL, $langData , false, array(),$langData );
					/* ]*/

					/* Url rewriting [*/
					if($this->isDefaultSheetData($langId)){
						if(trim($seoUrl) == ''){
							$seoUrl = $identifier;
						}
						$brand = new Brand($brandId);
						$brand->rewriteUrl($seoUrl);
					}
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
		$arr = $this->getProductsCatalogColoumArr($langId, $userId);
		array_push( $sheetData, $arr );
		/* ] */

		while( $row = $this->db->fetch($rs) ){

			$taxData = $this->getTaxCategoryByProductId($row['product_id']);
			if(!empty($taxData)){
				$row = array_merge( $row, $taxData );
			}

			$sheetArr = array();

			if($useProductId){
				$sheetArr[] = $row['product_id'];
				if($this->isDefaultSheetData($langId)){
					$sheetArr[] = $row['product_identifier'];
				}
			}else{
				$sheetArr[] = $row['product_identifier'];
			}

			if($this->isDefaultSheetData($langId)){
				if($this->settings['CONF_USE_USER_ID']){
					$sheetArr[] = $row['product_seller_id'];
				}else{
					$sheetArr[] = ( !empty($row['credential_username']) && 0 < $userId ? $row['credential_username'] : Labels::getLabel('LBL_Admin',$langId) );
				}
			}

			$sheetArr[] = $row['product_name'];
			/* $sheetArr[] = $row['product_short_description'];	 */
			$sheetArr[] = $row['product_description'];
			$sheetArr[] = $row['product_youtube_video'];

			if($this->isDefaultSheetData($langId)){
				if($this->settings['CONF_USE_CATEGORY_ID']){
					$productCategories = $this->getProductCategoriesByProductId($row['product_id'],false);
					$sheetArr[] =  ($productCategories)?implode(',',$productCategories):'';
				}else{
					$productCategories = $this->getProductCategoriesByProductId($row['product_id']);
					$sheetArr[] = ($productCategories)?implode(',',$productCategories):'';
				}

				if($this->settings['CONF_USE_BRAND_ID']){
					$sheetArr[] = $row['product_brand_id'];
				}else{
					$sheetArr[] = ($row['brand_identifier'])?$row['brand_identifier']:'';
				}

				if($this->settings['CONF_USE_PRODUCT_TYPE_ID']){
					$sheetArr[] = $row['product_type'];
				}else{
					$sheetArr[] = isset($ProdTypeIdentifierById[$row['product_type']])?$ProdTypeIdentifierById[$row['product_type']]:0;
				}

				$sheetArr[] = $row['product_model'];
				$sheetArr[] = $row['product_min_selling_price'];

				if($this->settings['CONF_USE_TAX_CATEOGRY_ID']){
					$sheetArr[] = isset($row['ptt_taxcat_id']) ? $row['ptt_taxcat_id'] : 0;
				}else{
					if(isset($row['ptt_taxcat_id'])){
					$sheetArr[] = isset($taxCategoryIdentifierById[$row['ptt_taxcat_id']])?$taxCategoryIdentifierById[$row['ptt_taxcat_id']]:0;
					}else{
						$sheetArr[] = 0;
					}
				}

				$sheetArr[] = $row['product_length'];
				$sheetArr[] = $row['product_width'];
				$sheetArr[] = $row['product_height'];

				if($this->settings['CONF_USE_DIMENSION_UNIT_ID']){
					$sheetArr[] = $row['product_dimension_unit'];
				}else{
					$sheetArr[] = isset($lengthUnitsArr[$row['product_dimension_unit']])?$lengthUnitsArr[$row['product_dimension_unit']]:'';
				}

				$sheetArr[] = $row['product_weight'];
				if($this->settings['CONF_USE_WEIGHT_UNIT_ID']){
					$sheetArr[] = $row['product_weight_unit'];
				}else{
					$sheetArr[] = isset($weightUnitsArr[$row['product_weight_unit']])?$weightUnitsArr[$row['product_weight_unit']]:'';
				}
				$sheetArr[] = $row['product_upc'];
				if($userId){
					$shippingDetails = Product::getProductShippingDetails($row['product_id'],$langId,$row['product_seller_id']);
				}

				if($this->settings['CONF_USE_COUNTRY_ID']){
					$sheetArr[] = $row['ps_from_country_id'];
					//$sheetArr[] = (isset($shippingDetails['ps_from_country_id']))?$shippingDetails['ps_from_country_id']:0;
				}else{
					$sheetArr[] = ($row['country_code'])?$row['country_code']:'';
				}

				if(!$userId){
					$sheetArr[] = $this->displayDateTime($row['product_added_on']);
				}

				if($this->settings['CONF_USE_O_OR_1']){
					$sheetArr[] = $row['ps_free'];
					$sheetArr[] = $row['product_cod_enabled'];
					if(!$userId){
						$sheetArr[] = $row['product_featured'];
					}
					$sheetArr[] = $row['product_approved'];
					$sheetArr[] = $row['product_active'];
					$sheetArr[] = $row['product_deleted'];
				}else{
					$sheetArr[] = ($row['ps_free'])?'YES':'NO';
					$sheetArr[] = ($row['product_cod_enabled'])?'YES':'NO';
					if(!$userId){
						$sheetArr[] = ($row['product_featured'])?'YES':'NO';
					}
					$sheetArr[] = ($row['product_approved'])?'YES':'NO';
					$sheetArr[] = ($row['product_active'])?'YES':'NO';
					$sheetArr[] = ($row['product_deleted'])?'YES':'NO';
				}
			}
			array_push( $sheetData, $sheetArr );
		}

		return $sheetData;
	}

	public function importProductsCatalog($csvFilePointer,$post,$langId, $sellerId = null){
		$sellerId = FatUtility::int($sellerId);

		$rowIndex = $rowCount = 0;
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

		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			// if(empty($line[0])){
			// 	continue;
			// }

			if($rowCount == 0){
				$coloumArr = $this->getProductsCatalogColoumArr($langId,$sellerId);

				if($line !== $coloumArr){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Products_catalog');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$numcols = count($line);
			$colCount = 0;

			// $useProductId = false;
			// if($this->settings['CONF_USE_PRODUCT_ID']){
			// 	$useProductId = true;
			// 	$productId = FatUtility::int($this->getCell($line,$colCount++,0));
			// 	if($this->isDefaultSheetData($langId)){
			// 		$identifier = trim($this->getCell($line,$colCount++,''));
			// 		if($identifier == '') {
			// 			$err = array(
			// 					$rowIndex,
			// 					$colCount,
			// 					Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId )
			// 				);
			// 			CommonHelper::writeLogFile( $errFile, $err );
			// 			continue;
			// 		}
			// 	}
			// }else{
			// 	$identifier = trim($this->getCell($line,$colCount++,''));
			// 	if($identifier == '') {
			// 		CommonHelper::writeLogFile( $errFile, array( $rowIndex, $colCount, Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId ) ) );
			// 		continue;
			// 	}
			// }

			$useProductId = false;
			$useIdentifier = true;
			if($this->settings['CONF_USE_PRODUCT_ID']){
				$useProductId = true;
				$productId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $productId ){
					$errMsg = Labels::getLabel( "MSG_Product_id_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$useIdentifier = $this->isDefaultSheetData($langId);
			}

			if( $useIdentifier ){
				$identifier = trim($this->getCell($line,$colCount++,''));
				if(empty( $identifier ) ){
					$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
			}

			$userId = 0;
			if($this->isDefaultSheetData($langId)){
				if($this->settings['CONF_USE_USER_ID']){
					$userId = FatUtility::int($this->getCell($line,$colCount++,0));
					if( 0 > $userId ){
					    $errMsg = Labels::getLabel( "MSG_Invalid_User.", $langId );
					    $err = array($rowIndex,$colCount,$errMsg);
					    CommonHelper::writeLogFile( $errFile,  $err);
					    continue;
					}
				}else{
					$colValue = trim( $this->getCell($line,$colCount++,'') );
					if( $colValue == '' ){
					    $errMsg = Labels::getLabel( "MSG_Invalid_User.", $langId );
					    $err = array($rowIndex,$colCount,$errMsg);
					    CommonHelper::writeLogFile( $errFile,  $err);
					    continue;
					}
					$colValue = ( $colValue == Labels::getLabel('LBL_Admin',$langId) ? '' : $colValue );
					if(!empty($colValue) && !array_key_exists($colValue,$usernameArr)){
						$res = $this->getAllUserArr(false,$colValue);
						if(!$res){
							$errMsg = Labels::getLabel( "MSG_Invalid_User.", $langId );
							CommonHelper::writeLogFile( $errFile, array( $rowIndex, $colCount, $errMsg  ) );
							continue;
						}
						$usernameArr = array_merge($usernameArr,$res);
					}
					$userId = isset($usernameArr[$colValue])?$usernameArr[$colValue]:0;
				}

				$userId = FatUtility::int($userId);
				if($sellerId && ( $sellerId != $userId || 1 > $userId)){
					CommonHelper::writeLogFile( $errFile, array( $rowIndex, $colCount, Labels::getLabel( "MSG_Sorry_you_are_not_authorised_to_update_this_product.", $langId ) ) );
					continue;
				}
			}

			$name = $this->getCell($line,$colCount++,'');
			if( empty( $name ) ){
				$errMsg = Labels::getLabel( "MSG_Name_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}
			/* $shortDescription = $this->getCell($line,$colCount++,'');	 */
			$description = $this->getCell($line,$colCount++,'');
			$youtubeVideo = $this->getCell($line,$colCount++,'');

			if($this->isDefaultSheetData($langId)){
				if($this->settings['CONF_USE_CATEGORY_ID']){
					$categoryIds = trim($this->getCell($line,$colCount++,0));
				}else{
					$catArr = array();
					$colValue = trim( $this->getCell($line,$colCount++,'') );
					if( empty( $colValue ) ){
					    $errMsg = Labels::getLabel( "MSG_Category_identifier_is_required.", $langId );
					    $err = array($rowIndex,$colCount,$errMsg);
					    CommonHelper::writeLogFile( $errFile,  $err);
					    continue;
					}
					$catIdentifiers = explode(',',$colValue);
					if(!empty($catIdentifiers)){
						foreach($catIdentifiers as $val){
							if(!array_key_exists($val,$categoryIdentifierArr)){
								$res = $this->getAllCategoryIdentifiers(false,$val);
								if(!$res){
									CommonHelper::writeLogFile( $errFile, array($rowIndex,$colCount,Labels::getLabel( "MSG_Category_is_required.", $langId ) ) );
									continue;
								}
								$categoryIdentifierArr = array_merge($categoryIdentifierArr,$res);
							}
							if(isset($categoryIdentifierArr[$val])){
								$catArr[] = $categoryIdentifierArr[$val];
							}
						}
					}
					$categoryIds = implode(',',$catArr);
				}

				if( empty( $categoryIds ) ){
				    $errMsg = Labels::getLabel( "MSG_Category_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}

				if($this->settings['CONF_USE_BRAND_ID']){
					$brandId = trim( $this->getCell($line,$colCount++,0) );
				}else{
					$colValue = trim( $this->getCell($line,$colCount++,'') );
					if( empty( $colValue ) ){
					    $errMsg = Labels::getLabel( "MSG_Brand_identifier_is_required.", $langId );
					    $err = array($rowIndex,$colCount,$errMsg);
					    CommonHelper::writeLogFile( $errFile,  $err);
					    continue;
					}
					if(!array_key_exists($colValue,$brandIdentifierArr)){
						$res = $this->getAllBrandsArr(false,$colValue);
						if(!$res){
							CommonHelper::writeLogFile( $errFile, array($rowIndex,$colCount,Labels::getLabel( "MSG_Brand_is_required.", $langId ) ) );
							continue;
						}
						$brandIdentifierArr = array_merge($brandIdentifierArr,$res);
					}
					$brandId = isset($brandIdentifierArr[$colValue])?$brandIdentifierArr[$colValue]:0;
				}
				if( 0 >= $brandId ){
				    $errMsg = Labels::getLabel( "MSG_Invalid_brand.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				if($this->settings['CONF_USE_PRODUCT_TYPE_ID']){
					$prodTypeId = $this->getCell($line,$colCount++,'');
					if( 0 >= $prodTypeId ){
					    $errMsg = Labels::getLabel( "MSG_Product_type_identifier_is_required.", $langId );
					    $err = array($rowIndex,$colCount,$errMsg);
					    CommonHelper::writeLogFile( $errFile,  $err);
					    continue;
					}
				}else{
					$colValue = $this->getCell($line,$colCount++,'');
					if( empty( $colValue ) ){
					    $errMsg = Labels::getLabel( "MSG_Product_type_identifier_is_required.", $langId );
					    $err = array($rowIndex,$colCount,$errMsg);
					    CommonHelper::writeLogFile( $errFile,  $err);
					    continue;
					}
					if(!array_key_exists($colValue,$prodTypeIdentifierArr)){
						CommonHelper::writeLogFile( $errFile, array($rowIndex,$colCount,Labels::getLabel( "MSG_Product_Type_is_a_required.", $langId ) ) );
						continue;
					}
					$prodTypeId = $prodTypeIdentifierArr[$colValue];
				}

				$model = $this->getCell($line,$colCount++,'');
				if( empty( $model ) ){
				    $errMsg = Labels::getLabel( "MSG_Model_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				$minSellingPrice = $this->getCell($line,$colCount++,'');
				if( empty( $minSellingPrice ) ){
				    $errMsg = Labels::getLabel( "MSG_Minimum_selling_price_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}

				if($this->settings['CONF_USE_TAX_CATEOGRY_ID']){
					$taxCatId = $this->getCell($line,$colCount++,0);
					if( 0 >= $taxCatId || $taxCatId == ''  ){
					    $errMsg = Labels::getLabel( "MSG_Tax_category_is_required.", $langId );
					    $err = array($rowIndex,$colCount,$errMsg);
					    CommonHelper::writeLogFile( $errFile,  $err);
					    continue;
					}

				}else{
					$colValue = trim( $this->getCell($line,$colCount++,'') );
					if( $colValue == '' || $colValue <= 0 ){
					    $errMsg = Labels::getLabel( "MSG_Tax_category_is_required.", $langId );
					    $err = array($rowIndex,$colCount,$errMsg);
					    CommonHelper::writeLogFile( $errFile,  $err);
					    continue;
					}
					if(!array_key_exists($colValue,$taxCategoryArr)){
						$res = $this->getTaxCategoriesArr(false,$colValue);
						if(!$res){
							CommonHelper::writeLogFile( $errFile, array( $rowIndex,$colCount,Labels::getLabel( "MSG_Optional_field_either_Valid_tax_category.", $langId ) ) );
							continue;
						}
						$taxCategoryArr = array_merge($taxCategoryArr,$res);
					}
					$taxCatId = isset($taxCategoryArr[$colValue])?$taxCategoryArr[$colValue]:0;
				}
				/* echo $taxCatId; die; */
				$length = $this->getCell($line,$colCount++,'');
				if( $length == '' || $length <= 0 ){
				    $errMsg = Labels::getLabel( "MSG_Length_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				$width = $this->getCell($line,$colCount++,'');
				if( $width == '' || $width <= 0 ){
				    $errMsg = Labels::getLabel( "MSG_Width_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				$height = $this->getCell($line,$colCount++,'');
				if( $height == '' || $height <= 0 ){
				    $errMsg = Labels::getLabel( "MSG_Height_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}

				if($this->settings['CONF_USE_DIMENSION_UNIT_ID']){
					$dimensionUnit = $this->getCell($line,$colCount++,'');
				}else{
					$colValue = $this->getCell($line,$colCount++,'');
					if(!array_key_exists($colValue,$lengthUnitsArr)){
						CommonHelper::writeLogFile( $errFile, array($rowIndex,$colCount,Labels::getLabel( "MSG_Product_dimensions_are_required.",$langId) ) );
						continue;
					}
					$dimensionUnit = $lengthUnitsArr[$colValue];
				}
				if( $dimensionUnit == '' || $dimensionUnit <= 0 ){
				    $errMsg = Labels::getLabel( "MSG_Dimension_unit_identifier_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}

				$weight = $this->getCell($line,$colCount++,'');
				if( $weight == '' || $weight <= 0 ){
				    $errMsg = Labels::getLabel( "MSG_Weight_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				if($this->settings['CONF_USE_WEIGHT_UNIT_ID']){
					$weightUnitId = $this->getCell($line,$colCount++,0);
				}else{
					$colValue = $this->getCell($line,$colCount++,'');
					if(!array_key_exists($colValue,$weightUnitsArr)){
						CommonHelper::writeLogFile( $errFile, array($rowIndex,$colCount,Labels::getLabel( "MSG_Product_dimensions_are_required.",$langId)) );
						continue;
					}
					$weightUnitId = $weightUnitsArr[$colValue];
				}
				if( $weightUnitId == '' ){
				    $errMsg = Labels::getLabel( "MSG_Weight_unit_identifier_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				$productUpc = $this->getCell($line,$colCount++,'');
				if($this->settings['CONF_USE_COUNTRY_ID']){
					$countryId = $this->getCell($line,$colCount++,'');
				}else{
					$colValue = $this->getCell($line,$colCount++,'');
					if(!array_key_exists($colValue,$countryArr)){
						$res = $this->getCountriesArr(false,$colValue);
						if(!$res){
							CommonHelper::writeLogFile( $errFile, array($rowIndex,$colCount,Labels::getLabel('LBL_Please_check_Country',$langId) ) );
							continue;
						}
						$countryArr = array_merge($countryArr,$res);
					}
					$countryId = isset($countryArr[$colValue])?$countryArr[$colValue]:0;
				}

				if(!$sellerId){
					$addedOn = 	$this->getCell($line,$colCount++,'');
					if( $addedOn == '' ){
					    $errMsg = Labels::getLabel( "MSG_Added_on_date_is_required.", $langId );
					    $err = array($rowIndex,$colCount,$errMsg);
					    CommonHelper::writeLogFile( $errFile,  $err);
					    continue;
					}
				}else{
					$addedOn = date('Y-m-d H:i:s');
				}

				$freeShipping = 	$this->getCell($line,$colCount++,'');
				if( $freeShipping  == '' || $freeShipping < 0){
					$errMsg = Labels::getLabel( "MSG_Free_shipping_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$CODavailable = 	$this->getCell($line,$colCount++,'');
				if( $CODavailable == '' || $CODavailable < 0 ){
					$errMsg = Labels::getLabel( "MSG_COD_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				if($sellerId){
					$featured = 0;
				}else{
					$featured = $this->getCell($line,$colCount++,'');
					if( $featured == '' || $featured < 0 ){
						$errMsg = Labels::getLabel( "MSG_Featured_value_is_required.", $langId );
						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
				}

				$approved = 	$this->getCell($line,$colCount++,'');
				if( $approved == '' || $approved < 0 ){
					$errMsg = Labels::getLabel( "MSG_Approved_column_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$active = 	$this->getCell($line,$colCount++,'');
				if( $active == '' || $active < 0 ){
					$errMsg = Labels::getLabel( "MSG_Active_column_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$deleted = 	$this->getCell($line,$colCount++,'');
				if( $deleted == '' || $deleted < 0 ){
					$errMsg = Labels::getLabel( "MSG_Deleted_column_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}

				if(!$numcols || $numcols != $colCount){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
			}

			if($rowCount > 0){
				$data = array(	);
				if($this->isDefaultSheetData($langId)){
					$data['product_seller_id'] = $userId;
					$data['product_model'] = $model;
					$data['product_min_selling_price'] = $minSellingPrice;
					$data['product_type'] = $prodTypeId;
					$data['product_brand_id'] = $brandId;
					$data['product_length'] = $length;
					$data['product_width'] = $width;
					$data['product_height'] = $height;
					$data['product_dimension_unit'] = $dimensionUnit;
					$data['product_weight'] = $weight;
					$data['product_weight_unit'] = $weightUnitId;
					$data['product_upc'] = $productUpc;
					//$data['product_ship_country'] = $countryId;
					$data['product_added_on'] = $this->getDateTime($addedOn);
					$data['product_added_by_admin_id'] = (!$userId)?applicationConstants::YES:applicationConstants::NO;
					$product_ship_free = 0;
					if($this->settings['CONF_USE_O_OR_1']){
						$product_ship_free = (FatUtility::int($freeShipping) == 1)?applicationConstants::YES:applicationConstants::NO;
						$data['product_featured'] = (FatUtility::int($featured) == 1)?applicationConstants::YES:applicationConstants::NO;
						$data['product_active'] = (FatUtility::int($active) == 1)?applicationConstants::YES:applicationConstants::NO;
						$data['product_deleted'] = (FatUtility::int($deleted) == 1)?applicationConstants::YES:applicationConstants::NO;
						$data['product_approved'] = (FatUtility::int($approved) == 1)?applicationConstants::YES:applicationConstants::NO;
						$data['product_cod_enabled'] = (FatUtility::int($CODavailable) == 1)?applicationConstants::YES:applicationConstants::NO;
					}else{
						$product_ship_free = (strtoupper($freeShipping) == 'YES')?applicationConstants::YES:applicationConstants::NO;
						$data['product_featured'] = (strtoupper($featured) == 'YES')?applicationConstants::YES:applicationConstants::NO;
						$data['product_active'] = (strtoupper($active) == 'YES')?applicationConstants::YES:applicationConstants::NO;
						$data['product_deleted'] = (strtoupper($deleted) == 'YES')?applicationConstants::YES:applicationConstants::NO;
						$data['product_approved'] = (strtoupper($approved) == 'YES')?applicationConstants::YES:applicationConstants::NO;
						$data['product_cod_enabled'] = (strtoupper($CODavailable) == 'YES')?applicationConstants::YES:applicationConstants::NO;
					}
				}
				$sellerTempId = 0;
				if($useProductId){
					$sellerTempId = $productId;
					if($sellerId){
						$userTempIdData = $this->getProductIdByTempId($sellerTempId,$userId);
						if(!empty($userTempIdData) && $userTempIdData['pti_product_temp_id'] == $sellerTempId){
							$productId = $userTempIdData['pti_product_id'];
						}
					}

					$data['product_id'] = $productId;
					if($this->isDefaultSheetData($langId)){
						$data['product_identifier'] = $identifier;
					}
					$prodData = Product::getAttributesById($productId,array('product_id','product_seller_id','product_featured','product_approved'));
				}else{
					$data['product_identifier'] = $identifier;
					$prodData = Product::getAttributesByIdentifier($identifier,array('product_id','product_seller_id','product_featured','product_approved'));
					if($sellerId && !empty($prodData) && $prodData['product_seller_id'] != $sellerId){
						CommonHelper::writeLogFile( $errFile, array($rowIndex,$colCount,Labels::getLabel('LBL_Please_check_sellerId',$langId) ) );
						continue;
					}
				}

				if(!empty($prodData) && $prodData['product_id'] && (!$sellerId || ($sellerId && $prodData['product_seller_id'] == $sellerId))){
					unset($prodData['product_seller_id']);
					$productId = $prodData['product_id'];

					if($sellerId){
						$data['product_featured'] = $prodData['product_featured'] ;
						$data['product_approved'] = $prodData['product_approved'] ;
						unset($data['product_added_on']);
					}

					$where = array('smt' => 'product_id = ?', 'vals' => array( $productId ) );
					$this->db->updateFromArray( Product::DB_TBL, $data,$where);

					if($sellerId && $this->isDefaultSheetData($langId)){
						$tempData = array(
							'pti_product_id' =>$productId,
							'pti_product_temp_id' =>($sellerTempId)?$sellerTempId:$productId,
							'pti_user_id' =>$userId,
						);
						$this->db->deleteRecords( Importexport::DB_TBL_TEMP_PRODUCT_IDS, array('smt'=> 'pti_product_id = ? and pti_user_id = ?','vals' => array($productId,$userId) ) );
						$this->db->insertFromArray( Importexport::DB_TBL_TEMP_PRODUCT_IDS, $tempData,false,array(),$tempData );
					}

				}else{
					if($this->isDefaultSheetData($langId)){
						if($sellerId){
							unset($data['product_id']);
							unset($data['product_featured']);
							if(FatApp::getConfig("CONF_CUSTOM_PRODUCT_REQUIRE_ADMIN_APPROVAL", FatUtility::VAR_INT, 1)){
								$data['product_approved'] = applicationConstants::NO;
							}
						}
						$this->db->insertFromArray( Product::DB_TBL, $data);
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
						'product_name'=> $name,
						/* 'product_short_description'=> $shortDescription, */
						'product_description'=> $description,
						'product_youtube_video'=> $youtubeVideo,
					);
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
						//
						/*]*/
					}
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
		$arr = $this->getProductOptionColoumArr($langId);
		array_push( $sheetData, $arr );
		/* ] */

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();

			if($this->settings['CONF_USE_PRODUCT_ID']){
				$sheetArr[] = $row['product_id'];
			}else{
				$sheetArr[] = $row['product_identifier'];
			}

			if($this->settings['CONF_USE_OPTION_ID']){
				$sheetArr[] = $row['option_id'];
			}else{
				$sheetArr[] = $row['option_identifier'];
			}
			array_push( $sheetData, $sheetArr );
		}
		return $sheetData;
	}

	public function importProductOptions($csvFilePointer,$post,$langId, $userId = null){

		$userId = FatUtility::int($userId);
		$rowIndex = $rowCount = 0;
		$prodIndetifierArr = array();
		$optionIdentifierArr = array();
		$prodArr = array();
		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			// if(empty($line[0])){
			// 	continue;
			// }

			$numcols = count($line);
			$colCount = 0;

			if($rowCount == 0){
				$coloumArr = $this->getProductOptionColoumArr($langId);
				if($line !== $coloumArr || $numcols != count($coloumArr)){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Product_Options');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$useProductId = false;
			if($this->settings['CONF_USE_PRODUCT_ID']){
				$useProductId = true;
				$productId = FatUtility::int($this->getCell($line,$colCount++,0));
			}else{
				$colValue = trim( $this->getCell($line,$colCount++,'') );
				if( empty( $colValue ) ){
				    $errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				if(!array_key_exists($colValue,$prodIndetifierArr)){
					$res = $this->getAllProductsIdentifiers(false,$colValue);
					if(!$res){
						CommonHelper::writeLogFile( $errFile, array($rowIndex,$colCount,Labels::getLabel( "MSG_Valid_Identifier_is_required.", $langId ) ) );
						continue;
					}
					$prodIndetifierArr = array_merge($prodIndetifierArr,$res);
				}
				$productId = $prodIndetifierArr[$colValue];
			}

			if($userId){
				$productId = $this->getCheckAndSetProductIdByTempId($productId,$userId);
			}

			if( 0 >= $productId ){
				CommonHelper::writeLogFile( $errFile, array($rowIndex,$colCount,Labels::getLabel( "MSG_Invalid_product_id.", $langId ) ) );
				continue;
			}

			if($this->settings['CONF_USE_OPTION_ID']){
				$optionId = $this->getCell($line,$colCount++,0);

				if( 0 >= $optionId ){
					$errMsg = Labels::getLabel( "MSG_Option_ID_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}

			}else{
				$colValue = trim( $this->getCell($line,$colCount++,'') );
				if( empty($colValue) ){
					$errMsg = Labels::getLabel( "MSG_Option_identifier_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				if(!array_key_exists($colValue,$optionIdentifierArr)){
					$res = $this->getAllOptions(false,$colValue);
					if(!$res){
						$errMsg = Labels::getLabel( "MSG_Option_Identifier_cannot_be_blank", $langId );
						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
					$optionIdentifierArr = array_merge($optionIdentifierArr,$res);
				}
				$optionId = isset($optionIdentifierArr[$colValue])?$optionIdentifierArr[$colValue]:0;
			}

			if($rowCount > 0){
				if(!in_array($productId,$prodArr)){
					$prodArr[] = $productId;
					$this->db->deleteRecords( Product::DB_PRODUCT_TO_OPTION, array('smt'=> 'prodoption_product_id = ? ','vals' => array($productId) ) );
				}

				$this->db->insertFromArray( Product::DB_PRODUCT_TO_OPTION, array('prodoption_product_id'=>$productId,'prodoption_option_id'=>$optionId) );
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
		$arr = $this->getProductTagColoumArr($langId);
		array_push( $sheetData, $arr );
		/* ] */

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();

			if($this->settings['CONF_USE_PRODUCT_ID']){
				$sheetArr[] = $row['product_id'];
			}else{
				$sheetArr[] = $row['product_identifier'];
			}

			if($this->settings['CONF_USE_TAG_ID']){
				$sheetArr[] = $row['tag_id'];
			}else{
				$sheetArr[] = $row['tag_identifier'];
			}
			array_push( $sheetData, $sheetArr );
		}
		return $sheetData;
	}

	public function importProductTags($csvFilePointer,$post,$langId, $userId = null){

		$userId = FatUtility::int($userId);

		$rowIndex = $rowCount = 0;
		$prodIndetifierArr = array();
		$tagIndetifierArr = array();
		$prodArr = array();

		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			// if(empty($line[0])){
			// 	continue;
			// }

			$numcols = count($line);
			$colCount = 0;

			if($rowCount == 0){
				$coloumArr = $this->getProductTagColoumArr($langId);
				if($line !== $coloumArr || $numcols != count($coloumArr)){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Product_Tags');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			if($this->settings['CONF_USE_PRODUCT_ID']){
				$productId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 > $productId ){
				    $errMsg = Labels::getLabel( "MSG_Product_id_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
			}else{
				$colValue = trim( $this->getCell($line,$colCount++,'') );
				if( empty( $colValue ) ){
				    $errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				if(!array_key_exists($colValue,$prodIndetifierArr)){
					$res = $this->getAllProductsIdentifiers(false,$colValue);
					if(!$res){
						$errMsg = Labels::getLabel( "MSG_Invalid_identifier.", $langId );
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

			if($this->settings['CONF_USE_TAG_ID']){
				$tagId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $tagId ){
				    $errMsg = Labels::getLabel( "MSG_Tag_Id_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
			}else{
				$colValue = trim($this->getCell($line,$colCount++,''));
				if( empty( $colValue ) ){
				    $errMsg = Labels::getLabel( "MSG_Tag_Identifier_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				if(!array_key_exists($colValue,$tagIndetifierArr)){
					$res = $this->getAllTags(false,$colValue);
					if(!$res){
						$errMsg = Labels::getLabel( "MSG_Please_check_product_tag_identifier", $langId );
						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
					$tagIndetifierArr = array_merge($tagIndetifierArr,$res);
				}
				$tagId = $tagIndetifierArr[$colValue];
			}

			if(!$tagId){
				$errMsg = Labels::getLabel( "MSG_Tag_Id_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}
			if($rowCount > 0){
				if(!in_array($productId,$prodArr)){
					$prodArr[] = $productId;
					$this->db->deleteRecords( Product::DB_PRODUCT_TO_TAG, array('smt'=> 'ptt_product_id = ? ','vals' => array($productId) ) );
				}

				$this->db->insertFromArray( Product::DB_PRODUCT_TO_TAG, array('ptt_product_id'=>$productId,'ptt_tag_id'=>$tagId) );
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
		$arr = $this->getProductSpecificationColoumArr($langId);

		array_push( $sheetData, $arr );
		/* ] */
		$languageCodes = Language::getAllCodesAssoc();

		while( $row = $this->db->fetch($rs) ){

			$sheetArr = array();

			if($this->settings['CONF_USE_PRODUCT_ID']){
				$sheetArr[] = $row['product_id'];
			}else{
				$sheetArr[] = $row['product_identifier'];
			}

			if($this->settings['CONF_USE_LANG_ID']){
				$sheetArr[] = $row['prodspeclang_lang_id'];
			}else{
				$sheetArr[] = $languageCodes[$row['prodspeclang_lang_id']];
			}

			$sheetArr[] = $row['prodspec_name'];
			$sheetArr[] = $row['prodspec_value'];

			array_push( $sheetData, $sheetArr );
		}
		return $sheetData;
	}

	public function importProductSpecifications($csvFilePointer,$post,$langId, $userId = null){

		$userId = FatUtility::int($userId);
		$rowIndex = $rowCount = 0;
		$prodIndetifierArr = array();
		$prodArr = array();
		$langArr = array();
		$languageCodes = Language::getAllCodesAssoc();
		$languageCodes = array_flip($languageCodes);

		$prodspec_id = 0;
		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			// if(empty($line[0])){
			// 	continue;
			// }

			$numcols = count($line);
			$colCount = 0;

			if($rowCount == 0){
				$coloumArr = $this->getProductSpecificationColoumArr($langId);
				if($line !== $coloumArr || $numcols != count($coloumArr)){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Product_Specifications');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$useProductId = false;
			if($this->settings['CONF_USE_PRODUCT_ID']){
				$useProductId = true;
				$productId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $productId ){
				    $errMsg = Labels::getLabel( "MSG_Product_id_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
			}else{
				$colValue = trim( $this->getCell($line,$colCount++,'') );
				if( empty( $colValue ) ){
				    $errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				if(!array_key_exists($colValue,$prodIndetifierArr)){
					$res = $this->getAllProductsIdentifiers(false,$colValue);
					if(!$res){
						$errMsg = Labels::getLabel( "MSG_Invalid_identifier.", $langId );
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
				$languageId = FatUtility::int($this->getCell($line,$colCount++,0));
				$errorMsgForLangId = Labels::getLabel( "MSG_Language_Id_cannot_be_blank", $langId );
			}else{
				$colValue = $this->getCell($line,$colCount++);
				$languageId = isset($languageCodes[$colValue])?$languageCodes[$colValue]:0;
				$errorMsgForLangId = Labels::getLabel( "MSG_Please_check_language_code.", $langId );
			}
			if( 0 >= $languageId ){
				CommonHelper::writeLogFile( $errFile, array($rowIndex,$colCount,$errorMsgForLangId) );
				continue;
			}

			$specName = $this->getCell($line,$colCount++);
			if(empty($specName)){
				$errMsg = Labels::getLabel( "MSG_Specification_name_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}
			$specValue = $this->getCell($line,$colCount++);
			if(empty($specValue)){
				$errMsg = Labels::getLabel( "MSG_Specification_value_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			if($rowCount > 0){
				if(!in_array($productId,$prodArr)){
					$prodArr[] = $productId;

					$srch = new SearchBase( Product::DB_PRODUCT_SPECIFICATION );
					$srch->addCondition( Product::DB_PRODUCT_SPECIFICATION_PREFIX . 'product_id', '=', $productId );
					$rs = $srch->getResultSet();
					$res = FatApp::getDb()->fetchAll($rs);
					foreach($res as $val){
						$this->db->deleteRecords( Product::DB_PRODUCT_LANG_SPECIFICATION, array('smt'=> 'prodspeclang_prodspec_id = ? ','vals' => array($val['prodspec_id']) ) );
					}
					$this->db->deleteRecords( Product::DB_PRODUCT_SPECIFICATION, array('smt'=> 'prodspec_product_id = ? ','vals' => array($productId) ) );
				}

				if(!in_array($languageId,$langArr)){
					$langArr[] = $languageId;
					if(!$prodspec_id){
						$this->db->insertFromArray( Product::DB_PRODUCT_SPECIFICATION, array('prodspec_product_id'=>$productId) );
						$prodspec_id = $this->db->getInsertId();
					}
				}else{
					// continue lang loop
					$langArr = array();
					$langArr[] = $languageId;
					$this->db->insertFromArray( Product::DB_PRODUCT_SPECIFICATION, array('prodspec_product_id'=>$productId) );
					$prodspec_id = $this->db->getInsertId();
				}

				$data = array(
					'prodspeclang_prodspec_id'=>$prodspec_id,
					'prodspeclang_lang_id'=>$languageId,
					'prodspec_name'=>$specName,
					'prodspec_value'=>$specValue
				);
				$this->db->insertFromArray( Product::DB_PRODUCT_LANG_SPECIFICATION, $data );
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
		$arr = $this->getProductShippingColoumArr($langId);
		array_push( $sheetData, $arr );
		/* ] */

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();

			if($this->settings['CONF_USE_PRODUCT_ID']){
				$sheetArr[] = $row['product_id'];
			}else{
				$sheetArr[] = $row['product_identifier'];
			}

			if($this->settings['CONF_USE_USER_ID']){
				$sheetArr[] = $row['user_id'] == '' ? 0 : $row['user_id'];
			}else{
				$sheetArr[] = ( !empty($row['credential_username']) && 0 < $userId ? $row['credential_username'] : Labels::getLabel('LBL_Admin',$langId) );
			}

			if($this->settings['CONF_USE_COUNTRY_ID']){
				$sheetArr[] = $row['country_id'];
			}else{
				$sheetArr[] = $row['country_code'];
			}

			if($this->settings['CONF_USE_SHIPPING_COMPANY_ID']){
				$sheetArr[] = $row['scompany_id'];
			}else{
				$sheetArr[] = $row['scompany_identifier'];
			}

			if($this->settings['CONF_USE_SHIPPING_DURATION_ID']){
				$sheetArr[] = $row['sduration_id'];
			}else{
				$sheetArr[] = $row['sduration_identifier'];
			}

			$sheetArr[] = $row['pship_charges'];
			$sheetArr[] = $row['pship_additional_charges'];

			array_push( $sheetData, $sheetArr );
		}

		return $sheetData;
	}

	public function importProductShipping($csvFilePointer,$post,$langId, $userId = null){

		$sellerId = FatUtility::int($userId);
		$rowIndex = $rowCount = 0;
		$prodIndetifierArr = array();
		$prodArr = array();
		$usernameArr = array();
		$scompanyIdentifierArr = array();
		$durationIdentifierArr = array();
		$countryCodeArr = array();

		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			// if(empty($line[0])){
			// 	continue;
			// }

			$numcols = count($line);
			$colCount = 0;

			if($rowCount == 0){
				$coloumArr = $this->getProductShippingColoumArr($langId);
				if($line !== $coloumArr || $numcols != count($coloumArr)){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Product_Shipping');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$useProductId = false;
			if($this->settings['CONF_USE_PRODUCT_ID']){
				$useProductId = true;
				$productId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $productId ){
				    $errMsg = Labels::getLabel( "MSG_Product_id_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
			}else{
				$colValue = trim( $this->getCell($line,$colCount++,'') );
				if( empty( $colValue ) ){
				    $errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				if(!array_key_exists($colValue,$prodIndetifierArr)){
					$res = $this->getAllProductsIdentifiers(false,$colValue);
					if(!$res){
						$errMsg = Labels::getLabel( "MSG_Invalid_identifier.", $langId );
						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
					$prodIndetifierArr = array_merge($prodIndetifierArr,$res);
				}
				$productId = $prodIndetifierArr[$colValue];
			}

			/* Product Ship By Seller [ */
			$srch = new ProductSearch($langId);
			$srch->joinProductShippedBySeller($sellerId);
			$srch->addCondition( 'psbs_user_id', '=',$sellerId);
			$srch->addCondition( 'product_id', '=',$productId);
			$srch->addFld('psbs_user_id');
			$rs = $srch->getResultSet();
			$shipBySeller = FatApp::getDb()->fetch($rs);
			/* ] */

			if(empty($shipBySeller) && $sellerId > 0) {
				$productId = $this->getCheckAndSetProductIdByTempId($productId,$sellerId);
			}

			if(!$productId){
				$errMsg = Labels::getLabel( "MSG_Product_Id_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			if($this->settings['CONF_USE_USER_ID']){
				$userId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 > $userId ){
				    $errMsg = Labels::getLabel( "MSG_Invalid_User.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
			}else{
				$colValue = trim( $this->getCell($line,$colCount++,'') );
				if( empty( $colValue ) ){
				    $errMsg = Labels::getLabel( "MSG_Invalid_User.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				$colValue = ( $colValue == Labels::getLabel('LBL_Admin',$langId) ? '' : $colValue );
				if(!empty($colValue) && !array_key_exists($colValue,$usernameArr)){
					$res = $this->getAllUserArr(false,$colValue);
					if(!$res){
						$errMsg = Labels::getLabel( "MSG_Invalid_User.", $langId );
						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
					$usernameArr = array_merge($usernameArr,$res);
				}
				$userId = isset($usernameArr[$colValue])?$usernameArr[$colValue]:0;
			}

			if($sellerId && $sellerId != $userId){
				$errMsg = Labels::getLabel( "MSG_Seller_Id_not_matched.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}


			if($this->settings['CONF_USE_COUNTRY_ID']){
				$countryId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $countryId ){
					$errMsg = Labels::getLabel( "MSG_Shipping_country_id_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
			}else{
				$colValue = $this->getCell($line,$colCount++);
				if( empty($colValue) ){
				    $errMsg = Labels::getLabel( "MSG_Shipping_country_code_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				if(!array_key_exists($colValue,$countryCodeArr)){
					$res = $this->getCountriesArr(false,$colValue);
					if(!$res){
						$errMsg = Labels::getLabel( "MSG_Please_check_country_code", $langId );
						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
					$countryCodeArr = array_merge($countryCodeArr,$res);
				}
				$countryId = isset($countryCodeArr[$colValue])?$countryCodeArr[$colValue]:0;
			}

			if($this->settings['CONF_USE_SHIPPING_COMPANY_ID']){
				$scompanyId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $scompanyId ){
				    $errMsg = Labels::getLabel( "MSG_Shipping_company_id_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
			}else{
				$colValue = $this->getCell($line,$colCount++);
				if( empty($colValue) ){
				    $errMsg = Labels::getLabel( "MSG_Shipping_company_Identifier_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				if(!array_key_exists($colValue,$scompanyIdentifierArr)){
					$res = $this->getAllShippingCompany(false,$colValue);
					if(!$res){
						$errMsg = Labels::getLabel( "MSG_Shipping_company_Identifier_cannot_be_blank", $langId );
						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
					$scompanyIdentifierArr = array_merge($scompanyIdentifierArr,$res);
				}
				$scompanyId = $scompanyIdentifierArr[$colValue];
			}

			if($this->settings['CONF_USE_SHIPPING_DURATION_ID']){
				$durationId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $durationId ){
				    $errMsg = Labels::getLabel( "MSG_Shipping_duration_id_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
			}else{
				$colValue = trim($this->getCell($line,$colCount++,''));
				if( empty($colValue) ){
				    $errMsg = Labels::getLabel( "MSG_Shipping_duration_identifier_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				if(!array_key_exists($colValue,$durationIdentifierArr)){
					$res = $this->getAllShippingDurations(false,$colValue);
					if(!$res){
						$errMsg = Labels::getLabel( "MSG_Please_check_shipping_duration", $langId );

						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
					$durationIdentifierArr = array_merge($durationIdentifierArr,$res);
				}
				$durationId = $durationIdentifierArr[$colValue];
			}
			if(!$durationId){
				$errorMsgForShpDurId = Labels::getLabel( "MSG_Please_check_Shipping_duration_id", $langId );
				CommonHelper::writeLogFile( $errFile, array($rowIndex,$colCount,$errorMsgForShpDurId) );
				continue;
			}

			$cost = $this->getCell($line,$colCount++,0);
			if( !isset($cost) ){
				$errMsg = Labels::getLabel( "MSG_Shipping_cost_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}
			$additionalCost = $this->getCell($line,$colCount++,0);

			if($rowCount > 0){
				$data = array(
					'pship_prod_id'=>$productId,
					'pship_user_id'=>$userId,
					'pship_country'=>($countryId)?$countryId:-1,
					'pship_method'=>ShippingCompanies::MANUAL_SHIPPING,
					'pship_company'=>$scompanyId,
					'pship_duration'=>$durationId,
					'pship_charges'=>$cost,
					'pship_additional_charges'=>$additionalCost,
				);
				if(!in_array($productId,$prodArr)){
					$prodArr[] = $productId;
					$where =  array('smt'=> 'pship_prod_id = ? ','vals' => array($productId) );
					if($sellerId){
						$where =  array('smt'=> 'pship_prod_id = ? and pship_user_id = ?','vals' => array($productId,$sellerId) );
					}
					$this->db->deleteRecords( Product::DB_PRODUCT_TO_SHIP, array('smt'=> 'pship_prod_id = ? ','vals' => array($productId) ) );
				}
				$this->db->insertFromArray( Product::DB_PRODUCT_TO_SHIP,$data);
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
		$arr = $this->getSelProdGeneralColoumArr($langId , $userId);
		array_push( $sheetData, $arr );
		/* ] */

		$conditionArr = Product::getConditionArr($langId);

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();
			$sheetArr[] = $row['selprod_id'];

			if($this->settings['CONF_USE_PRODUCT_ID']){
				$sheetArr[] = $row['selprod_product_id'];
			}else{
				$sheetArr[] = $row['product_identifier'];
			}

			if(!$userId){
				if($this->settings['CONF_USE_USER_ID']){
					$sheetArr[] = $row['selprod_user_id'];
				}else{
					$sheetArr[] = ( !empty($row['credential_username']) && 0 < $userId ? $row['credential_username'] : Labels::getLabel('LBL_Admin',$langId) );
				}
			}

			if($this->isDefaultSheetData($langId)){
				$sheetArr[] = $row['selprod_price'];
				/* $sheetArr[] = $row['selprod_cost']; */
				$sheetArr[] = $row['selprod_stock'];
				$sheetArr[] = $row['selprod_sku'];
				$sheetArr[] = $row['selprod_min_order_qty'];
				if($this->settings['CONF_USE_O_OR_1']){
					$sheetArr[] = $row['selprod_subtract_stock'];
					$sheetArr[] = $row['selprod_track_inventory'];
				}else{
					$sheetArr[] = ($row['selprod_subtract_stock'])?'YES':'NO';
					$sheetArr[] = ($row['selprod_track_inventory'])?'YES':'NO';
				}
				$sheetArr[] = $row['selprod_threshold_stock_level'];

				if($this->settings['CONF_USE_PROD_CONDITION_ID']){
					$sheetArr[] = $row['selprod_condition'];
				}else{
					$sheetArr[] = isset($conditionArr[$row['selprod_condition']])?$conditionArr[$row['selprod_condition']]:'';
				}
				$sheetArr[] = $row['selprod_max_download_times'];
				$sheetArr[] = $row['selprod_download_validity_in_days'];
			}

			$sheetArr[] = $row['selprod_title'];
			$sheetArr[] = $row['selprod_comments'];

			if($this->isDefaultSheetData($langId)){
				$sheetArr[] = $row['selprod_url_keyword'];
				if(!$userId){
					$sheetArr[] = $this->displayDateTime($row['selprod_added_on']);
				}
				$sheetArr[] = $this->displayDateTime($row['selprod_available_from']);

				if($this->settings['CONF_USE_O_OR_1']){
					$sheetArr[] = $row['selprod_active'];
					$sheetArr[] = $row['selprod_cod_enabled'];
					if(!$userId){
						$sheetArr[] = $row['selprod_deleted'];
					}
				}else{
					$sheetArr[] = ($row['selprod_active'])?'YES':'NO';
					$sheetArr[] = ($row['selprod_cod_enabled'])?'YES':'NO';
					if(!$userId){
						$sheetArr[] = ($row['selprod_deleted'])?'YES':'NO';
					}
				}
			}
			if(!$userId){
				$sheetArr[] = $row['selprod_sold_count'];
			}

			array_push( $sheetData, $sheetArr );
		}
		return 	$sheetData;
	}

	public function importSellerProdGeneralData($csvFilePointer,$post,$langId, $sellerId = null){

		$sellerId = FatUtility::int($sellerId);

		$rowIndex = $rowCount = 0;
		$usernameArr = array();
		$prodIndetifierArr = array();
		$prodConditionArr = Product::getConditionArr($langId);
		$prodConditionArr = array_flip($prodConditionArr);

		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			// if(empty($line[0])){
			// 	continue;
			// }

			$numcols = count($line);
			$colCount = 0;

			if($rowCount == 0){
				$coloumArr = $this->getSelProdGeneralColoumArr($langId , $sellerId);
				if($line !== $coloumArr || $numcols != count($coloumArr)){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Seller_Product_General_Data');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$selprodId = FatUtility::int($this->getCell($line,$colCount++,0));
			if( 0 >= $selprodId ){
				$errMsg = Labels::getLabel( "MSG_Seller_Product_Id_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}
			$sellerTempId = $selprodId;
			if($sellerId){
				$userTempIdData = $this->getTempSelProdIdByTempId($sellerTempId,$sellerId);
				if(!empty($userTempIdData) && $userTempIdData['spti_selprod_temp_id'] == $sellerTempId){
					$selprodId = $userTempIdData['spti_selprod_id'];
				}
			}

			if($this->settings['CONF_USE_PRODUCT_ID']){
				$productId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $productId ){
					$errMsg = Labels::getLabel( "MSG_Product_Id_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
			}else{
				$colValue = trim( $this->getCell($line,$colCount++,'') );
				if( empty( $colValue ) ){
				    $errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				if(!array_key_exists($colValue,$prodIndetifierArr)){
					$res = $this->getAllProductsIdentifiers(false,$colValue);
					if(!$res){
						$errMsg = Labels::getLabel( "MSG_Invalid_Identifier.", $langId );
						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
					$prodIndetifierArr = array_merge($prodIndetifierArr,$res);
				}
				$productId = $prodIndetifierArr[$colValue];
			}

			if(!$sellerId){
				if($this->settings['CONF_USE_USER_ID']){
					$userId = FatUtility::int($this->getCell($line,$colCount++,0));
					if( 0 > $userId ){
					    $errMsg = Labels::getLabel( "MSG_Invalid_User.", $langId );
					    $err = array($rowIndex,$colCount,$errMsg);
					    CommonHelper::writeLogFile( $errFile,  $err);
					    continue;
					}
				}else{
					$colValue = trim( $this->getCell($line,$colCount++,'') );
					if( empty( $colValue ) ){
					    $errMsg = Labels::getLabel( "MSG_Invalid_User.", $langId );
					    $err = array($rowIndex,$colCount,$errMsg);
					    CommonHelper::writeLogFile( $errFile,  $err);
					    continue;
					}
					$colValue = ( $colValue == Labels::getLabel('LBL_Admin',$langId) ? '' : $colValue );
					if(!empty($colValue) && !array_key_exists($colValue,$usernameArr)){
						$res = $this->getAllUserArr(false,$colValue);
						if(!$res){
							$errMsg = Labels::getLabel( "MSG_Invalid_User.", $langId );
							$err = array($rowIndex,$colCount,$errMsg);
							CommonHelper::writeLogFile( $errFile,  $err);
							continue;
						}
						$usernameArr = array_merge($usernameArr,$res);
					}
					$userId = isset($usernameArr[$colValue])?$usernameArr[$colValue]:0;
				}

				if(!$userId) {
					$errMsg = Labels::getLabel( "MSG_Please_check_User_ID.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
			}

			if($this->isDefaultSheetData($langId)){
				$price  = $this->getCell($line,$colCount++,0);
				if( 0 >= $price ){
					$errMsg = Labels::getLabel( "MSG_Selling_price_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				/* $cost  = $this->getCell($line,$colCount++,0); */
				$stock  = $this->getCell($line,$colCount++,0);
				if( 0 >= $stock || $stock == '' ){
					$errMsg = Labels::getLabel( "MSG_Stock_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$sku  = $this->getCell($line,$colCount++,0);
				$minOrderQty  = $this->getCell($line,$colCount++,0);
				if( 0 >= $minOrderQty || $minOrderQty == ''  ){
					$errMsg = Labels::getLabel( "MSG_Order_minimum_quantity_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				if($this->settings['CONF_USE_O_OR_1']){
					$subtractStock = (FatUtility::int($this->getCell($line,$colCount++,0)) == 1)?applicationConstants::YES:applicationConstants::NO;
					$trackInventory = (FatUtility::int($this->getCell($line,$colCount++,0)) == 1)?applicationConstants::YES:applicationConstants::NO;
				}else{
					$subtractStock = (strtoupper($this->getCell($line,$colCount++,'')) == 'YES')?applicationConstants::YES:applicationConstants::NO;
					$trackInventory = (strtoupper($this->getCell($line,$colCount++,'')) == 'YES')?applicationConstants::YES:applicationConstants::NO;
				}

				if( $subtractStock < 0 || $subtractStock == '' ){
					$errMsg = Labels::getLabel( "MSG_Substract_stock_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				if( $trackInventory < 0 || $trackInventory == '' ){
					$errMsg = Labels::getLabel( "MSG_Track_inventory_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}

				$thresholdStockLevel  = $this->getCell($line,$colCount++,0);
				if( $thresholdStockLevel == '' ){
					$errMsg = Labels::getLabel( "MSG_Threshold_stock_level_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				if($this->settings['CONF_USE_PROD_CONDITION_ID']){
					$conditionId = $this->getCell($line,$colCount++,0);
				}else{
					$colName = $this->getCell($line,$colCount++,'');
					$conditionId = isset($prodConditionArr[$colName])?$prodConditionArr[$colName]:0;
				}
				if( 0 >= $conditionId || $conditionId == '' ){
					$errMsg = Labels::getLabel( "MSG_Condition_identifier_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$selprod_max_download_times = $this->getCell($line,$colCount++,0);
				if( 0 >= $selprod_max_download_times || $selprod_max_download_times == '' ){
					$errMsg = Labels::getLabel( "MSG_Digital_product_max_download_time_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$selprod_download_validity_in_days = $this->getCell($line,$colCount++,0);
				if( 0 >= $selprod_download_validity_in_days || $selprod_download_validity_in_days == '' ){
					$errMsg = Labels::getLabel( "MSG_Download_validity_in_days_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
			}

			$title = $this->getCell($line,$colCount++,'');
			if( empty($title) ){
				$errMsg = Labels::getLabel( "MSG_title_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}
			$comments = $this->getCell($line,$colCount++,'');

			if($this->isDefaultSheetData($langId)){
				$urlKeyword = $this->getCell($line,$colCount++,'');
				if( empty($urlKeyword) ){
					$errMsg = Labels::getLabel( "MSG_URL_Keyword_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				if(!$sellerId){
					$addedOn = $this->getDateTime($this->getCell($line,$colCount++,date('Y-m-d')));
					if( empty($addedOn) ){
						$errMsg = Labels::getLabel( "MSG_Added_on_date_is_required.", $langId );
						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
				}else{
					$addedOn = date('Y-m-d H:i:s');
				}

				$availableFrom = $this->getDateTime($this->getCell($line,$colCount++,date('Y-m-d')));
				if( empty($availableFrom) ){
					$errMsg = Labels::getLabel( "MSG_Avaliable_from_date_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				if($this->settings['CONF_USE_O_OR_1']){
					$active = (FatUtility::int($this->getCell($line,$colCount++,0)) == 1)?applicationConstants::YES:applicationConstants::NO;
					$codEnable = (FatUtility::int($this->getCell($line,$colCount++,0)) == 1)?applicationConstants::YES:applicationConstants::NO;
					if(!$sellerId){
						$deleted = (FatUtility::int($this->getCell($line,$colCount++,0)) == 1)?applicationConstants::YES:applicationConstants::NO;
					}
				}else{
					$active = (strtoupper($this->getCell($line,$colCount++,'')) == 'YES')?applicationConstants::YES:applicationConstants::NO;
					$codEnable = (strtoupper($this->getCell($line,$colCount++,'')) == 'YES')?applicationConstants::YES:applicationConstants::NO;
					if(!$sellerId){
						$deleted = (strtoupper($this->getCell($line,$colCount++,'')) == 'YES')?applicationConstants::YES:applicationConstants::NO;
					}
				}
				if( $active < 0 || $active == '' ){
					$errMsg = Labels::getLabel( "MSG_Active_column_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				if( $codEnable < 0 || $codEnable == '' ){
					$errMsg = Labels::getLabel( "MSG_COD_column_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				if( $deleted < 0 || $deleted == '' ){
					$errMsg = Labels::getLabel( "MSG_Deleted_column_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
			}

			if(!$sellerId){
				$soldCount = $this->getCell($line,$colCount++,0);
			}

			if($rowCount > 0){
				$userId = (!$sellerId)?$userId:$sellerId;

				$data = array(
					'selprod_id'=>$selprodId,
					'selprod_user_id'=>$userId,
					'selprod_product_id'=>$productId,
				);
				$prodData = Product::getAttributesById($productId,array('product_min_selling_price'));
				if($price < $prodData['product_min_selling_price']){
					$price = $prodData['product_min_selling_price'];
				}
				if($this->isDefaultSheetData($langId)){
					$data['selprod_price'] = $price;
					/* $data['selprod_cost'] = $cost; */
					$data['selprod_stock'] = $stock;
					$data['selprod_sku'] = $sku;
					$data['selprod_min_order_qty'] = $minOrderQty;
					$data['selprod_subtract_stock'] = $subtractStock;
					$data['selprod_track_inventory'] = $trackInventory;
					$data['selprod_threshold_stock_level'] = $thresholdStockLevel;
					$data['selprod_condition'] = $conditionId;
					$data['selprod_max_download_times'] = $selprod_max_download_times;
					$data['selprod_download_validity_in_days'] = $selprod_download_validity_in_days;
					$data['selprod_added_on'] = $addedOn;
					$data['selprod_available_from'] = $availableFrom;
					$data['selprod_active'] = $active;
					$data['selprod_cod_enabled'] = $codEnable;
					if(!$sellerId){
						$data['selprod_deleted'] = $deleted;
					}
				}

				/* $sellerTempId = $data['selprod_id'];
				if($sellerId){
					$userTempIdData = $this->getTempSelProdIdByTempId($sellerTempId,$userId);
					if(!empty($userTempIdData) && $userTempIdData['spti_selprod_temp_id'] == $sellerTempId){
						$selprodId = $userTempIdData['spti_selprod_id'];
					}
				} */

				$selProdData = SellerProduct::getAttributesById($selprodId,array('selprod_id','selprod_sold_count','selprod_user_id'));
				if(!empty($selProdData) && $selProdData['selprod_id'] && (!$sellerId || ($sellerId && $selProdData['selprod_user_id'] == $sellerId))){
					$where = array('smt' => 'selprod_id = ?', 'vals' => array( $selprodId ) );
					$data['selprod_sold_count'] = $selProdData['selprod_sold_count'];

					if($sellerId){
						unset($data['selprod_added_on']);
					}

					$this->db->updateFromArray( SellerProduct::DB_TBL, $data,$where);

					if($sellerId && $this->isDefaultSheetData($langId)){
						$tempData = array(
							'spti_selprod_id' =>$selprodId,
							'spti_selprod_temp_id' =>$sellerTempId,
							'spti_user_id' =>$userId,
						);
						$this->db->deleteRecords( Importexport::DB_TBL_TEMP_SELPROD_IDS, array('smt'=> 'spti_selprod_id = ? and spti_user_id = ?','vals' => array($selprodId,$userId) ) );
						$this->db->insertFromArray( Importexport::DB_TBL_TEMP_SELPROD_IDS, $tempData,false,array(),$tempData );
					}
				}else{
					$data['selprod_code'] = $productId.'_';
					if($sellerId){
						unset($data['selprod_id']);
						unset($data['selprod_sold_count']);
					}

					if($this->isDefaultSheetData($langId)){
						$this->db->insertFromArray( SellerProduct::DB_TBL, $data );
						$selprodId = $this->db->getInsertId();

						$tempData = array(
							'spti_selprod_id' =>$selprodId,
							'spti_selprod_temp_id' =>$sellerTempId,
							'spti_user_id' =>$userId,
						);
						$this->db->deleteRecords( Importexport::DB_TBL_TEMP_SELPROD_IDS, array('smt'=> 'spti_selprod_id = ? and spti_user_id = ?','vals' => array($selprodId,$userId)) );
						$this->db->insertFromArray( Importexport::DB_TBL_TEMP_SELPROD_IDS, $tempData,false,array(),$tempData );
					}
				}

				if($selprodId){
					/* Lang Data [ */
					$langData = array(
						'selprodlang_selprod_id'=> $selprodId,
						'selprodlang_lang_id'=> $langId,
						'selprod_title'=> $title,
						'selprod_comments'=> $comments,
					);
					$this->db->insertFromArray( SellerProduct::DB_LANG_TBL, $langData , false, array(),$langData );
					/*]*/

					/* Url rewriting [*/
					if($this->isDefaultSheetData($langId)){
						if(trim($urlKeyword) != ''){
							$sellerProdObj = new SellerProduct($selprodId);
							$sellerProdObj->rewriteUrlProduct($urlKeyword);
							$sellerProdObj->rewriteUrlReviews($urlKeyword);
							$sellerProdObj->rewriteUrlMoreSellers($urlKeyword);
						}
					}
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
		$arr = $this->getSelProdOptionsColoumArr($langId);
		array_push( $sheetData, $arr );
		/* ] */

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();
			$sheetArr[] = $row['selprodoption_selprod_id'];

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
			array_push( $sheetData, $sheetArr );
		}
		return $sheetData;
	}

	public function importSellerProdOptionData($csvFilePointer,$post,$langId, $userId = null){

		$rowIndex = $rowCount = 0;
		$optionIdentifierArr = array();
		$optionValueIndetifierArr = array();
		$selProdArr = array();
		$selProdOptionsArr = array();
		$selProdValidOptionArr = array();

		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			// if(empty($line[0])){
			// 	continue;
			// }

			if($rowCount == 0){
				$coloumArr = $this->getSelProdOptionsColoumArr($langId);
				if($line !== $coloumArr){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Seller_Product_Option_Data');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$numcols = count($line);
			$colCount = 0;

			$selprodId = FatUtility::int($this->getCell($line,$colCount++,0));
			if( 0 >= $selprodId ){
				$errMsg = Labels::getLabel( "MSG_Seller_product_Id_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}
			if($userId){
				$selprodId = $this->getCheckAndSetSelProdIdByTempId($selprodId,$userId);
			}

			if($this->settings['CONF_USE_OPTION_ID']){
				$optionId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $optionId ){
					$errMsg = Labels::getLabel( "MSG_Option_Id_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
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
							$errMsg = Labels::getLabel( "MSG_Invalid_option_identifier", $langId );
							$err = array($rowIndex,$colCount,$errMsg);
							CommonHelper::writeLogFile( $errFile,  $err);
							continue;
						}
						$optionIdentifierArr = array_merge($optionIdentifierArr,$res);
					}
					$optionId = isset($optionIdentifierArr[$colValue])?$optionIdentifierArr[$colValue]:0;
				}
			}

			if(!$optionId){
				$errMsg = Labels::getLabel( "MSG_Option_Id_is_required", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			if(!array_key_exists($selprodId,$selProdValidOptionArr)){
				$selProdValidOptionArr[$selprodId] = array();
				$optionSrch = SellerProduct::getSearchObject();
				$optionSrch->joinTable( Product::DB_PRODUCT_TO_OPTION, 'INNER JOIN', 'sp.selprod_product_id = po.prodoption_product_id','po');
				$optionSrch->addCondition( 'selprod_id', '=',$selprodId );
				$optionSrch->addMultipleFields(array('prodoption_option_id'));
				$optionSrch->doNotCalculateRecords();
				$optionSrch->doNotLimitRecords();
				$rs = $optionSrch->getResultSet();
				$db = FatApp::getDb();
				while( $row = $db->fetch($rs) ){
					$selProdValidOptionArr[$selprodId][] = $row['prodoption_option_id'];
				}
			}

			if(!in_array($optionId,$selProdValidOptionArr[$selprodId])){
				$errMsg = Labels::getLabel( "MSG_Option_Id_is_required", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			$optionValueId = 0;
			if($optionId){
				if($this->settings['CONF_OPTION_VALUE_ID']){
					$optionValueId = FatUtility::int($this->getCell($line,$colCount++,0));
					if( 0 >= $optionValueId ){
					    $errMsg = Labels::getLabel( "MSG_Option_value_I	d_is_required.", $langId );
					    $err = array($rowIndex,$colCount,$errMsg);
					    CommonHelper::writeLogFile( $errFile,  $err);
					    continue;
					}
				}else{
					$colValue = trim($this->getCell($line,$colCount++,''));
					if( empty($colValue) ){
					    $errMsg = Labels::getLabel( "MSG_Option_value_indentifier_is_required.", $langId );
					    $err = array($rowIndex,$colCount,$errMsg);
					    CommonHelper::writeLogFile( $errFile,  $err);
					    continue;
					}
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
						$optionValueId = isset($optionValueIndetifierArr[$optionId][$colValue])?$optionValueIndetifierArr[$optionId][$colValue]:0;
					}
				}
			}else{
				$colCount++;
			}

			if(!$optionValueId){
				$errMsg = Labels::getLabel( "MSG_Option_value_Id_is_required", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			if($rowCount > 0){
				if(!in_array($selprodId,$selProdArr)){
					$selProdArr[] = $selprodId;
					$where = array ('smt' => 'selprodoption_selprod_id = ?','vals' => array ($selprodId));
					$this->db->deleteRecords ( SellerProduct::DB_TBL_SELLER_PROD_OPTIONS, $where );
				}
				$selProdOptionsArr[$selprodId][] = $optionValueId;

				$data = array(
					'selprodoption_selprod_id'=>$selprodId,
					'selprodoption_option_id'=>$optionId,
					'selprodoption_optionvalue_id'=>$optionValueId,
				);
				$this->db->insertFromArray( SellerProduct::DB_TBL_SELLER_PROD_OPTIONS, $data , false, array(),$data );
			}
			$rowCount++;
		}

		if($selProdOptionsArr){
			$options = array();
			foreach($selProdOptionsArr as $k=>$v){
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
		$arr = $this->getSelProdSeoColoumArr($langId);
		array_push( $sheetData, $arr );
		/* ] */

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();
			$sheetArr[] = $row['selprod_id'];

			if($this->isDefaultSheetData($langId)){
				$sheetArr[] = $row['meta_identifier'];
			}

			$sheetArr[] = $row['meta_title'];
			$sheetArr[] = $row['meta_keywords'];
			$sheetArr[] = $row['meta_description'];
			$sheetArr[] = $row['meta_other_meta_tags'];
			array_push( $sheetData, $sheetArr );
		}
		return  $sheetData;
	}

	public function importSellerProdSeoData($csvFilePointer,$post,$langId, $userId = null){

		$rowIndex = $rowCount = 0;
		$metaTabArr = MetaTag::getTabsArr($langId);
		$metaSrch = MetaTag::getSearchObject();
		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			// if(empty($line[0])){
			// 	continue;
			// }

			if($rowCount == 0){
				$coloumArr = $this->getSelProdSeoColoumArr($langId);
				if($line !== $coloumArr){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Seller_Product_Seo_Data');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$numcols = count($line);
			$colCount = 0;

			$selProdId = FatUtility::int($this->getCell($line,$colCount++,0));
			if( 0 >= $selProdId ){
				$errMsg = Labels::getLabel( "MSG_Seller_product_Id_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}
			if($userId){
				$selProdId = $this->getCheckAndSetSelProdIdByTempId($selProdId,$userId);
			}


			if($this->isDefaultSheetData($langId)){
				$metaIdentifier = trim( $this->getCell($line,$colCount++,'') );
				if( empty( $metaIdentifier ) ){
				    $errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
			}

			$metaTitle = $this->getCell($line,$colCount++,'');
			$metaKeyword = $this->getCell($line,$colCount++,'');
			$metaDescription = $this->getCell($line,$colCount++,'');
			$otherMetaTag = $this->getCell($line,$colCount++,'');

			if($rowCount > 0){
				$data = array(
					'meta_controller'=>$metaTabArr[MetaTag::META_GROUP_PRODUCT_DETAIL]['controller'],
					'meta_action'=>$metaTabArr[MetaTag::META_GROUP_PRODUCT_DETAIL]['action'],
					'meta_record_id'=>$selProdId,
				);

				if($this->isDefaultSheetData($langId)){
					$data['meta_identifier'] = $metaIdentifier;
				}

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
					$this->db->updateFromArray( MetaTag::DB_TBL, $data,$where);
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
						'meta_title'=> $metaTitle,
						'meta_keywords'=> $metaKeyword,
						'meta_description'=> $metaDescription,
						'meta_other_meta_tags'=> $otherMetaTag,
					);
					$this->db->insertFromArray( MetaTag::DB_LANG_TBL, $langData , false, array(),$langData );
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
		$arr = $this->getSelProdSpecialPriceColoumArr($langId);
		array_push( $sheetData, $arr );
		/* ] */

		$persentOrFlatTypeArr = applicationConstants::getPercentageFlatArr($langId);

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();
			$sheetArr[] = $row['selprod_id'];
			$sheetArr[] = $this->displayDate($row['splprice_start_date']);
			$sheetArr[] = $this->displayDate($row['splprice_end_date']);
			$sheetArr[] = $row['splprice_price'];

			/* if($this->settings['CONF_USE_PERSENT_OR_FLAT_CONDITION_ID']){
				$sheetArr[] = $row['splprice_display_dis_type'];
			}else{
				$sheetArr[] = isset($persentOrFlatTypeArr[$row['splprice_display_dis_type']])?$persentOrFlatTypeArr[$row['splprice_display_dis_type']]:'';
			}

			$sheetArr[] = $row['splprice_display_dis_val'];
			$sheetArr[] = $row['splprice_display_list_price']; */
			array_push( $sheetData, $sheetArr );
		}
		return  $sheetData;
	}

	public function importSellerProdSpecialPrice($csvFilePointer,$post,$langId, $userId = null){

		$rowIndex = $rowCount = 0;
		$persentOrFlatTypeArr = applicationConstants::getPercentageFlatArr($langId);
		$persentOrFlatTypeArr = array_flip($persentOrFlatTypeArr);
		$selProdArr = array();

		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			if(empty($line[0])){
				continue;
			}

			if($rowCount == 0){
				$coloumArr = $this->getSelProdSpecialPriceColoumArr($langId);
				if($line !== $coloumArr){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Seller_Product_Special_Price');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$numcols = count($line);
			$colCount = 0;

			$selProdId = FatUtility::int($this->getCell($line,$colCount++,0));
			if( 0 >= $selProdId){
				$errMsg = Labels::getLabel( "MSG_Seller_product_Id_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}
			if($userId){
				$selProdId = $this->getCheckAndSetSelProdIdByTempId($selProdId,$userId);
			}

			$startDate = $this->getDateTime($this->getCell($line,$colCount++,''),false);
			if( !$startDate ){
				$errMsg = Labels::getLabel( "MSG_Start_date_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}
			$endDate = $this->getDateTime($this->getCell($line,$colCount++,''),false);
			if( !$endDate ){
				$errMsg = Labels::getLabel( "MSG_End_date_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}
			$price = $this->getCell($line,$colCount++,0);
			if( 0 >= $price || $price == '' ){
				$errMsg = Labels::getLabel( "MSG_Price_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}
			/* if($this->settings['CONF_USE_PERSENT_OR_FLAT_CONDITION_ID']){
				$displayDisType = $this->getDateTime($this->getCell($line,$colCount++,0));
			}else{
				$colValue = $this->getCell($line,$colCount++,'');
				$displayDisType = isset($persentOrFlatTypeArr[$colValue])?$persentOrFlatTypeArr[$colValue]:0;
			}
			$discountValue = $this->getCell($line,$colCount++,'');
			$listPrice = $this->getCell($line,$colCount++,''); */

			if($rowCount > 0){
				$data = array(
					'splprice_selprod_id'=>$selProdId,
					'splprice_start_date'=>$startDate,
					'splprice_end_date'=>$endDate,
					'splprice_price'=>$price,
					/* 'splprice_display_dis_type'=>$displayDisType,
					'splprice_display_dis_val'=>$discountValue,
					'splprice_display_list_price'=>$listPrice, */
				);

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
		$arr = $this->getSelProdVolumeDiscountColoumArr($langId);
		array_push( $sheetData, $arr );
		/* ] */

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();
			$sheetArr[] = $row['selprod_id'];
			$sheetArr[] = $row['voldiscount_min_qty'];
			$sheetArr[] = $row['voldiscount_percentage'];
			array_push( $sheetData, $sheetArr );
		}
		return  $sheetData;
	}

	public function importSellerProdVolumeDiscount($csvFilePointer,$post,$langId, $userId = null){

		$rowIndex = $rowCount = 0;
		$selProdArr = array();
		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			if(empty($line[0])){
				continue;
			}

			if($rowCount == 0){
				$coloumArr = $this->getSelProdVolumeDiscountColoumArr($langId);
				if($line !== $coloumArr){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Seller_Product_Volume_Discount');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$numcols = count($line);
			$colCount = 0;

			$selProdId = FatUtility::int($this->getCell($line,$colCount++,0));
			if( 0 >= $selProdId ){
				$errMsg = Labels::getLabel( "MSG_Seller_product_Id_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			$minQty = FatUtility::int($this->getCell($line,$colCount++,0));
			if( 0 >= $minQty ){
				$errMsg = Labels::getLabel( "MSG_Minimum_quantity_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}
			$discountPercent = FatUtility::float($this->getCell($line,$colCount++,0));
			if( 0 > $discountPercent ){
				$errMsg = Labels::getLabel( "MSG_Discount_percent_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			if($rowCount > 0){
				if($userId){
					$selProdId = $this->getCheckAndSetSelProdIdByTempId($selProdId,$userId);
					if(!$selProdId){
						$errMsg = Labels::getLabel( "MSG_Seller_product_Id_is_required.", $langId );
						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
				}

				$data = array(
					'voldiscount_selprod_id'=>$selProdId,
					'voldiscount_min_qty'=>$minQty,
					'voldiscount_percentage'=>$discountPercent
				);
				if(!in_array($selProdId,$selProdArr)){
					$selProdArr[] = $selProdId;
					$where = array ('smt' => 'voldiscount_selprod_id = ?','vals' => array ($selProdId));
					$this->db->deleteRecords ( SellerProductVolumeDiscount::DB_TBL, $where );
				}
				$this->db->insertFromArray( SellerProductVolumeDiscount::DB_TBL, $data );
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
		$arr = $this->getSelProdBuyTogetherColoumArr($langId);
		array_push( $sheetData, $arr );
		/* ] */

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();
			$sheetArr[] = $row['selprod_id'];
			$sheetArr[] = $row['upsell_recommend_sellerproduct_id'];
			array_push( $sheetData, $sheetArr );
		}
		return  $sheetData;
	}

	public function importSellerProdBuyTogther($csvFilePointer,$post,$langId, $userId = null){

		$rowIndex = $rowCount = 0;
		$selProdArr = array();
		$selProdUserArr = array();
		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			if(empty($line[0])){
				continue;
			}

			if($rowCount == 0){
				$coloumArr = $this->getSelProdBuyTogetherColoumArr($langId);
				if($line !== $coloumArr){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Seller_Product_Buy_Togther');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$numcols = count($line);
			$colCount = 0;

			$selProdId = FatUtility::int($this->getCell($line,$colCount++,0));
			if( 0 >= $selProdId ) {
				$errMsg = Labels::getLabel( "MSG_Seller_product_Id_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			if($userId){
				$selProdId = $this->getCheckAndSetSelProdIdByTempId($selProdId,$userId);
			}


			if(!array_key_exists($selProdId,$selProdUserArr)){
				$res = SellerProduct::getAttributesById($selProdId,array('selprod_id','selprod_user_id'));
				if(empty($res)){
					$errMsg = Labels::getLabel( "MSG_Product_not_found.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$selProdUserArr[$res['selprod_id']] = $res['selprod_user_id'];
			}

			$upselProdId = FatUtility::int($this->getCell($line,$colCount++,0));
			if( 0 >= $upselProdId ) {
				$errMsg = Labels::getLabel( "MSG__Buy_together_seller_product_Id_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			if($userId){
				$upselProdId = $this->getCheckAndSetSelProdIdByTempId($upselProdId,$userId);
			}
			if(!$upselProdId){
				$errMsg = Labels::getLabel( "MSG_Seller_product_Id_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			if(!array_key_exists($upselProdId,$selProdUserArr)){
				$res = SellerProduct::getAttributesById($upselProdId,array('selprod_id','selprod_user_id'));
				if(empty($res)){
					$errMsg = Labels::getLabel( "MSG_Seller_product_not_found.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$selProdUserArr[$res['selprod_id']] = $res['selprod_user_id'];
			}

			if($selProdUserArr[$selProdId] != $selProdUserArr[$upselProdId]){
				$errMsg = Labels::getLabel( "MSG_Seller_product_not_valid.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			if($rowCount > 0){
				$data = array(
					'upsell_sellerproduct_id'=>$selProdId,
					'upsell_recommend_sellerproduct_id'=>$upselProdId,
				);
				if(!in_array($selProdId,$selProdArr)){
					$selProdArr[] = $selProdId;
					$where = array ('smt' => 'upsell_sellerproduct_id = ?','vals' => array ($selProdId));
					$this->db->deleteRecords ( SellerProduct::DB_TBL_UPSELL_PRODUCTS, $where );
				}
				$this->db->insertFromArray( SellerProduct::DB_TBL_UPSELL_PRODUCTS, $data );
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
		$arr = $this->getSelProdRelatedProductColoumArr($langId);
		array_push( $sheetData, $arr );
		/* ] */

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();
			$sheetArr[] = $row['selprod_id'];
			$sheetArr[] = $row['related_recommend_sellerproduct_id'];
			array_push( $sheetData, $sheetArr );
		}
		return  $sheetData;
	}

	public function importSellerProdRelatedProd($csvFilePointer,$post,$langId, $userId = null){

		$rowIndex = $rowCount = 0;
		$selProdArr = array();
		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			if(empty($line[0])){
				continue;
			}

			if($rowCount == 0){
				$coloumArr = $this->getSelProdRelatedProductColoumArr($langId);
				if($line !== $coloumArr){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Seller_Product_Related_Product');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$numcols = count($line);
			$colCount = 0;

			$selProdId = FatUtility::int($this->getCell($line,$colCount++,0));
			if( 0 >= $selProdId ){
				$errMsg = Labels::getLabel( "MSG_Seller_product_Id_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			if($userId){
				$selProdId = $this->getCheckAndSetSelProdIdByTempId($selProdId,$userId);
			}

			$relatedSelProdId = FatUtility::int($this->getCell($line,$colCount++,0));
			if( 0 >= $relatedSelProdId ){
				$errMsg = Labels::getLabel( "MSG_Related_seller_product_Id_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			if($rowCount > 0){
				$data = array(
					'related_sellerproduct_id'=>$selProdId,
					'related_recommend_sellerproduct_id'=>$relatedSelProdId,
				);
				if(!in_array($selProdId,$selProdArr)){
					$selProdArr[] = $selProdId;
					$where = array ('smt' => 'related_sellerproduct_id = ?','vals' => array ($selProdId));
					$this->db->deleteRecords ( SellerProduct::DB_TBL_RELATED_PRODUCTS, $where );
				}
				$this->db->insertFromArray( SellerProduct::DB_TBL_RELATED_PRODUCTS, $data );
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
		$arr = $this->getSelProdPolicyColoumArr($langId);
		array_push( $sheetData, $arr );
		/* ] */

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();
			$sheetArr[] = $row['selprod_id'];
			if($this->settings['CONF_USE_POLICY_POINT_ID']){
				$sheetArr[] = $row['sppolicy_ppoint_id'];
			}else{
				$sheetArr[] = $row['ppoint_identifier'];
			}
			array_push( $sheetData, $sheetArr );
		}
		return  $sheetData;
	}

	public function importSellerProdPolicy($csvFilePointer,$post,$langId, $userId = null){

		$rowIndex = $rowCount = 0;
		$policyPonitIdentifierArr = array();
		$policyPonitIdArr = array();
		$selProdArr = array();
		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			if(empty($line[0])){
				continue;
			}

			if($rowCount == 0){
				$coloumArr = $this->getSelProdPolicyColoumArr($langId);
				if($line !== $coloumArr){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Seller_Product_Policy');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$numcols = count($line);
			$colCount = 0;

			$selProdId = FatUtility::int($this->getCell($line,$colCount++,0));
			if( 0 >= $selProdId ){
				$errMsg = Labels::getLabel( "MSG_Seller_product_Id_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			if($userId){
				$selProdId = $this->getCheckAndSetSelProdIdByTempId($selProdId,$userId);
			}


			if($this->settings['CONF_USE_POLICY_POINT_ID']){
				$policyPointId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $policyPointId ){
					$errMsg = Labels::getLabel( "MSG_Policy_point_id_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				if(!array_key_exists($policyPointId,$policyPonitIdArr)){
					$res = $this->getAllPrivacyPoints(true,$policyPointId);
					if(!$res){
						$errMsg = Labels::getLabel( "MSG_Please_check_policy_point_Id.", $langId );
						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
					$policyPonitIdArr = array_merge($policyPonitIdArr,$res);
				}
			}else{
				$colValue = trim($this->getCell($line,$colCount++,''));
				if( empty($colValue) ){
					$errMsg = Labels::getLabel( "MSG_Policy_point_identifier_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				if(!array_key_exists($colValue,$policyPonitIdentifierArr)){
					$res = $this->getAllPrivacyPoints(false,$colValue);
					if(!$res){
						$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
					$policyPonitIdentifierArr = array_merge($policyPonitIdentifierArr,$res);
				}
				$policyPointId = $policyPonitIdentifierArr[$colValue];
			}
			if(!$policyPointId){
				$errMsg = Labels::getLabel( "MSG_Policy_point_Id_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			if($rowCount > 0){
				$data = array(
					'sppolicy_selprod_id'=>$selProdId,
					'sppolicy_ppoint_id'=>$policyPointId,
				);
				if(!in_array($selProdId,$selProdArr)){
					$selProdArr[] = $selProdId;
					$where = array ('smt' => 'sppolicy_selprod_id = ?','vals' => array ($selProdId));
					$this->db->deleteRecords ( SellerProduct::DB_TBL_SELLER_PROD_POLICY, $where );
				}
				$this->db->insertFromArray( SellerProduct::DB_TBL_SELLER_PROD_POLICY, $data );
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
		$arr = $this->getOptionsColoumArr($langId, $userId);
		array_push( $sheetData, $arr );
		/* ] */

		/* $optionTypeArr = Option::getOptionTypes($langId); */

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();
			if($this->settings['CONF_USE_OPTION_ID']){
				$sheetArr[] = $row['option_id'];
				if($this->isDefaultSheetData($langId)){
					$sheetArr[] = $row['option_identifier'];
				}
			}else{
				$sheetArr[] = $row['option_identifier'];
			}

			$sheetArr[] = $row['option_name'];

			if(!$userId){
				if($this->isDefaultSheetData($langId)){

					if($this->settings['CONF_USE_USER_ID']){
						$sheetArr[] = $row['option_seller_id'];
					}else{
						$sheetArr[] = ( !empty($row['credential_username']) && 0 < $userId ? $row['credential_username'] : Labels::getLabel('LBL_Admin',$langId) );
					}

					/* if($this->settings['CONF_USE_OPTION_TYPE_ID']){
						$sheetArr[] = $row['option_type'];
					}else{
						$sheetArr[] = isset($optionTypeArr[$row['option_type']])?$optionTypeArr[$row['option_type']]:'';
					} */

					if($this->settings['CONF_USE_O_OR_1']){
						$sheetArr[] = $row['option_is_separate_images'];
						$sheetArr[] = $row['option_is_color'];
						$sheetArr[] = $row['option_display_in_filter'];
						if(!$userId){
							$sheetArr[] = $row['option_deleted'];
						}
					}else{
						$sheetArr[] = ($row['option_is_separate_images'])?'YES':'NO';
						$sheetArr[] = ($row['option_is_color'])?'YES':'NO';
						$sheetArr[] = ($row['option_display_in_filter'])?'YES':'NO';
						if(!$userId){
							$sheetArr[] = ($row['option_deleted'])?'YES':'NO';
						}
					}
				}
			}
			array_push( $sheetData, $sheetArr );
		}
		return $sheetData;
	}

	public function importOptions($csvFilePointer,$post,$langId){

		$rowIndex = $rowCount = 0;
		$optionIdentifierArr = array();
		$optionIdArr = array();
		$userArr = array();

		$useOptionId = false;
		if($this->settings['CONF_USE_OPTION_ID']){
			$useOptionId = true;
		}

		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			// if(empty($line[0])){
			// 	continue;
			// }

			if($rowCount == 0){
				$coloumArr = $this->getOptionsColoumArr($langId);
				if($line !== $coloumArr){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Options');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$numcols = count($line);
			$colCount = 0;

			// if($useOptionId){
			// 	$optionId = FatUtility::int($this->getCell($line,$colCount++,0));
			// 	if($this->isDefaultSheetData($langId)){
			// 		$identifier = $this->getCell($line,$colCount++,'');
			// 		if(!$identifier){
			// 			$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
			// 			$err = array($rowIndex,$colCount,$errMsg);
			// 			CommonHelper::writeLogFile( $errFile,  $err);
			// 			continue;
			// 		}
			// 	}
			// }else{
			// 	$identifier = $this->getCell($line,$colCount++,'');
			// 	if(!$identifier){
			// 		$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
			// 		$err = array($rowIndex,$colCount,$errMsg);
			// 		CommonHelper::writeLogFile( $errFile,  $err);
			// 		continue;
			// 	}
			// }

			$useIdentifier = true;
			if($useOptionId){
				$optionId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $optionId ){
				    $errMsg = Labels::getLabel( "MSG_Valid_option_id_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				$useIdentifier = $this->isDefaultSheetData($langId);
			}

			if( $useIdentifier ){
				$identifier = trim($this->getCell($line,$colCount++,''));
				if(empty( $identifier ) ){
					$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
			}

			$optionName = $this->getCell($line,$colCount++,'');
			if( empty( $optionName ) ){
			    $errMsg = Labels::getLabel( "MSG_Option_name_is_required.", $langId );
			    $err = array($rowIndex,$colCount,$errMsg);
			    CommonHelper::writeLogFile( $errFile,  $err);
			    continue;
			}

			if($this->isDefaultSheetData($langId)){
				if($this->settings['CONF_USE_USER_ID']){
					$userId = FatUtility::int($this->getCell($line,$colCount++,0));
					if( 0 > $userId ){
					    $errMsg = Labels::getLabel( "MSG_Invalid_user.", $langId );
					    $err = array($rowIndex,$colCount,$errMsg);
					    CommonHelper::writeLogFile( $errFile,  $err);
					    continue;
					}
				}else{
					$userId = 0;
					$colValue = trim( $this->getCell($line,$colCount++,'') );
					if( empty( $colValue ) ){
					    $errMsg = Labels::getLabel( "MSG_Invalid_user.", $langId );
					    $err = array($rowIndex,$colCount,$errMsg);
					    CommonHelper::writeLogFile( $errFile,  $err);
					    continue;
					}
					$colValue = ( $colValue == Labels::getLabel('LBL_Admin',$langId) ? '' : $colValue );
					if(!empty($colValue)){
						if(!array_key_exists($colValue,$userArr)){
							$res = $this->getAllOptions(false,$colValue);
							if(!$res){
								$errMsg = Labels::getLabel( "MSG_Invalid_User.", $langId );
								$err = array($rowIndex,$colCount,$errMsg);
								CommonHelper::writeLogFile( $errFile,  $err);
								continue;
							}
							$userArr = array_merge($userArr,$res);
						}
						$userId = isset($userArr[$colValue])?$userArr[$colValue]:0;
					}
				}

				if($this->settings['CONF_USE_O_OR_1']){
					$isSeparateImage = (FatUtility::int($this->getCell($line,$colCount++,0)) == 1)?applicationConstants::YES:applicationConstants::NO;
					$isColor = (FatUtility::int($this->getCell($line,$colCount++,0)) == 1)?applicationConstants::YES:applicationConstants::NO;
					$displayInFilter = (FatUtility::int($this->getCell($line,$colCount++,0)) == 1)?applicationConstants::YES:applicationConstants::NO;
					$deleted = (FatUtility::int($this->getCell($line,$colCount++,0)) == 1)?applicationConstants::YES:applicationConstants::NO;
				}else{
					$isSeparateImage = (strtoupper($this->getCell($line,$colCount++,'')) == 'YES')?applicationConstants::YES:applicationConstants::NO;
					$isColor = (strtoupper($this->getCell($line,$colCount++,'')) == 'YES')?applicationConstants::YES:applicationConstants::NO;
					$displayInFilter = (strtoupper($this->getCell($line,$colCount++,'')) == 'YES')?applicationConstants::YES:applicationConstants::NO;
					$deleted = (strtoupper($this->getCell($line,$colCount++,'')) == 'YES')?applicationConstants::YES:applicationConstants::NO;
				}
				if( $isSeparateImage < 0 || $isSeparateImage == '' ){
					$errMsg = Labels::getLabel( "MSG_Separate_image_column_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				if( $isColor < 0 || $isColor == '' ){
					$errMsg = Labels::getLabel( "MSG_Color_Type_column_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				if( $displayInFilter < 0 || $displayInFilter == '' ){
					$errMsg = Labels::getLabel( "MSG_Display_in_filter_column_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				if( $deleted < 0 || $deleted == '' ){
					$errMsg = Labels::getLabel( "MSG_Deleted_column_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}

			}

			if($rowCount > 0){
				$data = array('option_type'=>Option::OPTION_TYPE_SELECT);

				if($this->isDefaultSheetData($langId)){
					$data['option_seller_id'] = $userId;
					$data['option_display_in_filter'] = $displayInFilter;
					$data['option_is_color'] = $isColor;
					$data['option_is_separate_images'] = $isSeparateImage;
					$data['option_deleted'] = $deleted;
					$data['option_identifier'] = $identifier;
				}

				if($useOptionId){
					$data['option_id'] = $optionId;
					$optionData =  Option::getAttributesById($optionId,array('option_id'));
				}else{
					$data['option_identifier'] = $identifier;
					$brandId = 0;
					$optionData = Option::getAttributesByIdentifier($identifier,array('option_id'));
				}

				if(!empty($optionData) && $optionData['option_id']){
					$optionId = $optionData['option_id'];
					$where = array('smt' => 'option_id = ?', 'vals' => array( $optionId ) );
					$this->db->updateFromArray( Option::DB_TBL, $data,$where);
				}else{
					if($this->isDefaultSheetData($langId)){
						$this->db->insertFromArray( Option::DB_TBL, $data);
						$optionId = $this->db->getInsertId();
					}
				}

				if($optionId){
					/* Lang Data [*/
					$langData = array(
						'optionlang_option_id'=> $optionId,
						'optionlang_lang_id'=> $langId,
						'option_name'=> $optionName,
					);
					$this->db->insertFromArray( Option::DB_LANG_TBL, $langData , false, array(),$langData );
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
		$arr = $this->getOptionsValueColoumArr($langId,$userId);
		array_push( $sheetData, $arr );
		/* ] */

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();
			if($this->settings['CONF_OPTION_VALUE_ID']){
				$sheetArr[] = $row['optionvalue_id'];
				if($this->isDefaultSheetData($langId)){
					$sheetArr[] = $row['optionvalue_identifier'];
				}
			}else{
				$sheetArr[] = $row['optionvalue_identifier'];
			}

			if($this->settings['CONF_USE_OPTION_ID']){
				$sheetArr[] = $row['optionvalue_option_id'];
			}else{
				$sheetArr[] = $row['option_identifier'];
			}
			$sheetArr[] = $row['optionvalue_name'];

			if($this->isDefaultSheetData($langId)){
				$sheetArr[] = $row['optionvalue_color_code'];
				if(!$userId){
					$sheetArr[] = $row['optionvalue_display_order'];
				}
			}

			array_push( $sheetData, $sheetArr );
		}
		return $sheetData;
	}

	public function importOptionValues($csvFilePointer,$post,$langId){

		$rowIndex = $rowCount = 0;
		$optionIdentifierArr = array();
		$optionIdArr = array();

		$useOptionValueId = false;
		if($this->settings['CONF_OPTION_VALUE_ID']){
			$useOptionValueId = true;
		}

		$optionValueObj= new OptionValue();
		$srchObj = OptionValue::getSearchObject();

		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			// if(empty($line[0])){
			// 	continue;
			// }

			if($rowCount == 0){
				$coloumArr = $this->getOptionsValueColoumArr($langId);
				if($line !== $coloumArr){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Option_Values');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$numcols = count($line);
			$colCount = 0;

			// if($useOptionValueId){
			// 	$optionValueId = FatUtility::int($this->getCell($line,$colCount++,0));
			// 	if($this->isDefaultSheetData($langId)){
			// 		$identifier = $this->getCell($line,$colCount++,'');
			// 		if(trim($identifier) == ''){
			// 			$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
			// 			$err = array($rowIndex,$colCount,$errMsg);
			// 			CommonHelper::writeLogFile( $errFile,  $err);
			// 			continue;
			// 		}
			// 	}
			// }else{
			// 	$identifier = $this->getCell($line,$colCount++,'');
			// 	if(trim($identifier) == ''){
			// 		$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
			// 		$err = array($rowIndex,$colCount,$errMsg);
			// 		CommonHelper::writeLogFile( $errFile,  $err);
			// 		continue;
			// 	}
			// }

			$useIdentifier = true;
			if($useOptionValueId){
				$optionValueId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $optionValueId ){
				    $errMsg = Labels::getLabel( "MSG_Valid_option_value_id_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				$useIdentifier = $this->isDefaultSheetData($langId);
			}

			if( $useIdentifier ){
				$identifier = trim($this->getCell($line,$colCount++,''));
				if(empty( $identifier ) ){
					$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
			}

			$optionId = 0;
			if($this->settings['CONF_USE_OPTION_ID']){
				$optionId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $optionId){
					$errMsg = Labels::getLabel( "MSG_Option_Id_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				if(!array_key_exists($optionId,$optionIdArr)){
					$res = $this->getAllOptions(true,$optionId);
					if(!$res){
						$errMsg = Labels::getLabel( "MSG_Please_check_option_Id.", $langId );
						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
					$optionIdArr = array_merge($optionIdArr,$res);
				}
			}else{
				$colValue = trim( $this->getCell($line,$colCount++,'') );
				if( empty( $colValue ) ){
				    $errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				if(!array_key_exists($colValue,$optionIdentifierArr)){
					$res = $this->getAllOptions(false,$colValue);
					if(!$res){
						$errMsg = Labels::getLabel( "MSG_Option_not_found.", $langId );
						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
					$optionIdentifierArr = array_merge($optionIdentifierArr,$res);
				}
				$optionId = isset($optionIdentifierArr[$colValue])?$optionIdentifierArr[$colValue]:0;
			}

			if(!$optionId){
				$errMsg = Labels::getLabel( "MSG_Option_Id_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			$optionValue = $this->getCell($line,$colCount++,'');
			if( empty( $optionValue ) ){
				$errMsg = Labels::getLabel( "MSG_Option_value_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}
			if($this->isDefaultSheetData($langId)){
				$colorCode = $this->getCell($line,$colCount++,'');
				$displayOrder = $this->getCell($line,$colCount++,'');
				if( empty( $displayOrder ) ){
					$errMsg = Labels::getLabel( "MSG_Display_order_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
			}

			if($rowCount > 0){
				$data = array();
				if($this->isDefaultSheetData($langId)){
					$data['optionvalue_color_code']	= $colorCode;
					$data['optionvalue_option_id']	= $optionId;
					$data['optionvalue_display_order']= $displayOrder;
				}

				if($useOptionValueId){
					$data['optionvalue_id']	= $optionValueId;
					if($this->isDefaultSheetData($langId)){
						$data['optionvalue_identifier']	= $identifier;
					}
					$optionValueData = OptionValue::getAttributesById($optionValueId,array('optionvalue_id'));
				}else{
					$data['optionvalue_identifier'] = $identifier;
					$optionValueData = $optionValueObj->getAtttibutesByIdentifierAndOptionId($optionId,$identifier,array('optionvalue_id'));
				}

				if(!empty($optionValueData) && $optionValueData['optionvalue_id']){
					$optionValueId = $optionValueData['optionvalue_id'];
					$where = array('smt' => 'optionvalue_id = ?', 'vals' => array( $optionValueId ) );
					$this->db->updateFromArray( OptionValue::DB_TBL, $data,$where);
				}else{
					if($this->isDefaultSheetData($langId)){
						$this->db->insertFromArray( OptionValue::DB_TBL, $data);
						$optionValueId = $this->db->getInsertId();
					}
				}

				if($optionValueId){
					/* Lang Data [*/
					$langData = array(
						'optionvaluelang_optionvalue_id'=> $optionValueId,
						'optionvaluelang_lang_id'=> $langId,
						'optionvalue_name'=> $optionValue,
					);
					$this->db->insertFromArray( OptionValue::DB_TBL_LANG, $langData , false, array(),$langData );
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
		$arr = $this->getTagColoumArr($langId,$userId);
		array_push( $sheetData, $arr );
		/* ] */

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();
			if($this->settings['CONF_USE_TAG_ID']){
				$sheetArr[] = $row['tag_id'];
				if($this->isDefaultSheetData($langId)){
					$sheetArr[] = $row['tag_identifier'];
				}
			}else{
				$sheetArr[] = $row['tag_identifier'];
			}

			if(!$userId){
				if($this->isDefaultSheetData($langId)){
					if($this->settings['CONF_USE_USER_ID']){
						$sheetArr[] = $row['tag_user_id'];
					}else{
						$sheetArr[] = ( !empty($row['credential_username']) && 0 < $userId ? $row['credential_username'] : Labels::getLabel('LBL_Admin',$langId) );
					}
				}
			}

			$sheetArr[] = $row['tag_name'];

			array_push( $sheetData, $sheetArr );
		}
		return $sheetData;
	}

	public function importTags($csvFilePointer,$post,$langId){

		$rowIndex = $rowCount = 0;
		$usernameArr = array();
		$useTagId  = false;
		if($this->settings['CONF_USE_TAG_ID']){
			$useTagId = true;
		}

		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			// if(empty($line[0])){
			// 	continue;
			// }

			if($rowCount == 0){
				$coloumArr = $this->getTagColoumArr($langId);
				if($line !== $coloumArr){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Tags');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$numcols = count($line);
			$colCount = 0;

			// if($useTagId){
			// 	$tagId = FatUtility::int($this->getCell($line,$colCount++,0));
			// 	if($this->isDefaultSheetData($langId)){
			// 		$identifier = $this->getCell($line,$colCount++,'');
			// 		if(trim($identifier) == ''){
			// 			$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
			// 			$err = array($rowIndex,$colCount,$errMsg);
			// 			CommonHelper::writeLogFile( $errFile,  $err);
			// 			continue;
			// 		}
			// 	}
			// }else{
			// 	$identifier = $this->getCell($line,$colCount++,'');
			// 	if(trim($identifier) == ''){
			// 		$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
			// 		$err = array($rowIndex,$colCount,$errMsg);
			// 		CommonHelper::writeLogFile( $errFile,  $err);
			// 		continue;
			// 	}
			// }
			$useIdentifier = true;
			if($useTagId){
				$tagId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $tagId ){
				    $errMsg = Labels::getLabel( "MSG_Valid_tag_id_is_required.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				$useIdentifier = $this->isDefaultSheetData($langId);
			}

			if( $useIdentifier ){
				$identifier = trim($this->getCell($line,$colCount++,''));
				if(empty( $identifier ) ){
					$errMsg = Labels::getLabel( "MSG_Identifier_is_required_and_unique.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
			}

			if($this->settings['CONF_USE_USER_ID']){
				$userId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 > $userId ){
				    $errMsg = Labels::getLabel( "MSG_Invalid_User.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
			}else{
				$colValue = trim( $this->getCell($line,$colCount++,'') );
				if( empty( $colValue ) ){
				    $errMsg = Labels::getLabel( "MSG_Invalid_User.", $langId );
				    $err = array($rowIndex,$colCount,$errMsg);
				    CommonHelper::writeLogFile( $errFile,  $err);
				    continue;
				}
				$colValue = ( $colValue == Labels::getLabel('LBL_Admin',$langId) ? '' : $colValue );
				if(!empty($colValue) && !array_key_exists($colValue,$usernameArr)){
					$res = $this->getAllUserArr(false,$colValue);
					if(!$res){
						$errMsg = Labels::getLabel( "MSG_Invalid_User.", $langId );
						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
					$usernameArr = array_merge($usernameArr,$res);
				}
				$userId = isset($usernameArr[$colValue])?$usernameArr[$colValue]:0;
			}

			if( 0 > $userId ){
			    $errMsg = Labels::getLabel( "MSG_Invalid_user_id.", $langId );
			    $err = array($rowIndex,$colCount,$errMsg);
			    CommonHelper::writeLogFile( $errFile,  $err);
			    continue;
			}

			$name = $this->getCell($line,$colCount++,'');
			if( empty($name) ){
				$errMsg = Labels::getLabel( "MSG_Tag_name_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}
			if($rowCount > 0){
				$data = array();

				if($useTagId){
					$data['tag_id']	= $tagId;
					if($this->isDefaultSheetData($langId)){
						$data['tag_identifier']	= $identifier;
					}
				}else{
					$data['tag_identifier']= $identifier;
				}

				if($this->isDefaultSheetData($langId)){
					$data['tag_user_id']	= $userId;
				}

				if($userId){
					$data['tag_admin_id']	= 0;
				}

				if($useTagId){
					$tagData = Tag::getAttributesById($tagId,array('tag_id'));
				}else{
					$tagData = Tag::getAttributesByIdentifier($identifier,array('tag_id'));
				}

				if(!empty($tagData) && $tagData['tag_id']){
					$tagId = $tagData['tag_id'];
					$where = array('smt' => 'tag_id = ?', 'vals' => array( $tagId ) );
					$this->db->updateFromArray( Tag::DB_TBL, $data,$where);
				}else{
					if($this->isDefaultSheetData($langId)){
						$this->db->insertFromArray( Tag::DB_TBL, $data);
						$tagId = $this->db->getInsertId();
					}
				}

				if($tagId){
					/* Lang Data [*/
					$langData = array(
						'taglang_tag_id'=> $tagId,
						'taglang_lang_id'=> $langId,
						'tag_name'=> $name,
					);
					$this->db->insertFromArray( Tag::DB_LANG_TBL, $langData , false, array(),$langData );
					/* ]*/

					/* update product tags association and tag string in products lang table[ */
					Tag::updateTagStrings( $tagId );
					/* ] */
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
		$arr = $this->getCountryColoumArr($langId,$userId);
		array_push( $sheetData, $arr );
		/* ] */

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();
			if($useCountryId){
				$sheetArr[] = $row['country_id'];
				if($this->isDefaultSheetData($langId)){
					$sheetArr[] = $row['country_code'];
				}
			}else{
				$sheetArr[] = $row['country_code'];
			}
			$sheetArr[] = $row['country_name'];
			if(!$userId){
				if($this->isDefaultSheetData($langId)){
					if($this->settings['CONF_USE_CURRENCY_ID']){
						$sheetArr[] = $row['country_currency_id'];
					}else{
						$sheetArr[] = isset($currencyCodes[$row['country_currency_id']])?$currencyCodes[$row['country_currency_id']]:0;
					}

					if($this->settings['CONF_USE_LANG_ID']){
						$sheetArr[] = $row['country_language_id'];
					}else{
						$sheetArr[] = isset($languageCodes[$row['country_language_id']])?$languageCodes[$row['country_language_id']]:0;
					}

					if($this->settings['CONF_USE_O_OR_1']){
						$sheetArr[] = $row['country_active'];
					}else{
						$sheetArr[] = ($row['country_active'])?'YES':'NO';
					}
				}
			}
			array_push( $sheetData, $sheetArr );
		}
		return $sheetData;
	}

	public function importCountries($csvFilePointer,$post,$langId){

		$rowIndex = $rowCount = 0;

		$useCountryId  = false;
		if($this->settings['CONF_USE_COUNTRY_ID']){
			$useCountryId = true;
		}

		$languageCodes = Language::getAllCodesAssoc(true);
		$languageIds = array_flip($languageCodes);

		$currencyCodes = Currency::getCurrencyAssoc(true);
		$currencyIds = array_flip($currencyCodes);

		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			if(empty($line[0])){
				continue;
			}

			if($rowCount == 0){
				$coloumArr = $this->getCountryColoumArr($langId);
				if($line !== $coloumArr){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('Countries');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$numcols = count($line);
			$colCount = 0;

			if($useCountryId){
				$countryId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $countryId ){
					$errMsg = Labels::getLabel( "MSG_Country_id_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				if($this->isDefaultSheetData($langId)){
					$countryCode = $this->getCell($line,$colCount++,'');
					if(trim($countryCode) == ''){
						$errMsg = Labels::getLabel( "MSG_Country_code_is_required.", $langId );
						$err = array($rowIndex,$colCount,$errMsg);
						CommonHelper::writeLogFile( $errFile,  $err);
						continue;
					}
				}
			}else{
				$countryCode = $this->getCell($line,$colCount++,'');
				if(trim($countryCode) == ''){
					$errMsg = Labels::getLabel( "MSG_Country_code_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
			}

			$countryName = $this->getCell($line,$colCount++,'');
			if(trim($countryName) == ''){
				$errMsg = Labels::getLabel( "MSG_Country_name_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}

			if($this->isDefaultSheetData($langId)){
				if($this->settings['CONF_USE_CURRENCY_ID']){
					$currencyId = FatUtility::int($this->getCell($line,$colCount++,0));
					$currencyId = isset($currencyCodes[$currencyId])?$currencyId:0;
				}else{
					$currencyCode = $this->getCell($line,$colCount++,'');
					$currencyId = isset($currencyIds[$currencyCode])?$currencyIds[$currencyCode]:0;
				}

				if($this->settings['CONF_USE_LANG_ID']){
					$currencyLangId = FatUtility::int($this->getCell($line,$colCount++,0));
					$currencyLangId = isset($languageCodes[$currencyLangId])?$currencyLangId:0;
				}else{
					$langCode = $this->getCell($line,$colCount++,'');
					$currencyLangId = isset($languageIds[$langCode])?$languageIds[$langCode]:0;
				}

				if($this->settings['CONF_USE_O_OR_1']){
					$active = (FatUtility::int($this->getCell($line,$colCount++,0)) == 1)?applicationConstants::YES:applicationConstants::NO;
				}else{
					$active = ($this->getCell($line,$colCount++,0) == 'YES')?applicationConstants::YES:applicationConstants::NO;
				}
			}

			if($rowCount > 0){
				$data = array();

				if($useCountryId){
					$data['country_id']	= $countryId;
					if($this->isDefaultSheetData($langId)){
						$data['country_code']	= $countryCode;
					}
				}else{
					$data['country_code']= $countryCode;
				}

				if($this->isDefaultSheetData($langId)){
					$data['country_active']= $active;
					$data['country_currency_id']= $currencyId;
					$data['country_language_id']= $currencyLangId;
				}

				if($useCountryId){
					$countryData = Countries::getAttributesById($countryId,array('country_id'));
				}else{
					$countryData = Countries::getCountryByCode($countryCode,array('country_id'));
				}

				if(!empty($countryData) && $countryData['country_id']){
					$countryId = $countryData['country_id'];
					$where = array('smt' => 'country_id = ?', 'vals' => array( $countryId ) );
					$this->db->updateFromArray( Countries::DB_TBL, $data,$where);

				}else{
					if($this->isDefaultSheetData($langId)){
						$this->db->insertFromArray( Countries::DB_TBL, $data);
						$countryId = $this->db->getInsertId();
					}
				}

				if($countryId){
					/* Lang Data [*/
					$langData = array(
						'countrylang_country_id'=> $countryId,
						'countrylang_lang_id'=> $langId,
						'country_name'=> $countryName,
					);
					$this->db->insertFromArray( Countries::DB_TBL_LANG, $langData , false, array(),$langData );
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
		$arr = $this->getStatesColoumArr($langId, $userId);
		array_push( $sheetData, $arr );
		/* ] */

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();

			if($useStateId){
				$sheetArr[] = $row['state_id'];
				if($this->isDefaultSheetData($langId)){
					$sheetArr[] = $row['state_identifier'];
				}
			}else{
				$sheetArr[] = $row['state_identifier'];
			}

			if($this->settings['CONF_USE_COUNTRY_ID']){
				$sheetArr[] = $row['state_country_id'];
			}else{
				$sheetArr[] = $row['country_code'];
			}

			$sheetArr[] = $row['state_name'];

			if($this->isDefaultSheetData($langId)){
				$sheetArr[] = $row['state_code'];
				if(!$userId){
					if($this->settings['CONF_USE_O_OR_1']){
						$sheetArr[] = $row['state_active'];
					}else{
						$sheetArr[] = ($row['state_active'])?'YES':'NO';
					}
				}
			}
			array_push( $sheetData, $sheetArr );
		}
		return $sheetData;
	}

	public function importStates($csvFilePointer,$post,$langId){

		$rowIndex = $rowCount = 0;

		$useStateId  = false;
		if($this->settings['CONF_USE_STATE_ID']){
			$useStateId = true;
		}

		if($this->settings['CONF_USE_COUNTRY_ID']){
			$countryCodes = $this->getCountriesArr(true);
		}else{
			$countryIds = $this->getCountriesArr(false);
		}

		while( ($line = $this->getFileContent($csvFilePointer) ) !== FALSE ){
			$rowIndex++;
			if(empty($line[0])){
				continue;
			}

			if($rowCount == 0){
				$coloumArr = $this->getStatesColoumArr($langId);
				if($line !== $coloumArr){
					Message::addErrorMessage( Labels::getLabel( "MSG_Invalid_Coloum_CSV_File", $langId ) );
					FatUtility::dieJsonError( Message::getHtml() );
				}
				$rowCount++;
				$errfileName = $this->logFileName('States');
				$errFile = $this->openErrorLogFile( $errfileName, $langId );
				continue;
			}

			$numcols = count($line);
			$colCount = 0;

			if($useStateId){
				$stateId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $stateId ){
					$errMsg = Labels::getLabel( "MSG_State_id_is_required.", $langId );
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

			if($this->settings['CONF_USE_COUNTRY_ID']){
				$countryId = FatUtility::int($this->getCell($line,$colCount++,0));
				if( 0 >= $countryId ){
					$errMsg = Labels::getLabel( "MSG_Country_id_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$countryId = isset($countryCodes[$countryId])?$countryId:0;
			}else{
				$countryCode = $this->getCell($line,$colCount++,'');
				if( empty($countryCode) ){
					$errMsg = Labels::getLabel( "MSG_Country_code_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				$countryId = isset($countryIds[$countryCode])?$countryIds[$countryCode]:0;
			}

			if(!$countryId){continue;}

			$stateName = $this->getCell($line,$colCount++,'');
			if( empty($stateName) ){
				$errMsg = Labels::getLabel( "MSG_State_name_is_required.", $langId );
				$err = array($rowIndex,$colCount,$errMsg);
				CommonHelper::writeLogFile( $errFile,  $err);
				continue;
			}
			if($this->isDefaultSheetData($langId)){
				$stateCode = $this->getCell($line,$colCount++,'');
				if( empty($stateCode) ){
					$errMsg = Labels::getLabel( "MSG_State_code_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
				if($this->settings['CONF_USE_O_OR_1']){
					$active = (FatUtility::int($this->getCell($line,$colCount++,0)) == 1)?applicationConstants::YES:applicationConstants::NO;
				}else{
					$active = ($this->getCell($line,$colCount++,0) == 'YES')?applicationConstants::YES:applicationConstants::NO;
				}
				if( !isset($active) ){
					$errMsg = Labels::getLabel( "MSG_Active_column_value_is_required.", $langId );
					$err = array($rowIndex,$colCount,$errMsg);
					CommonHelper::writeLogFile( $errFile,  $err);
					continue;
				}
			}

			if($rowCount > 0){
				$data = array();

				if($useStateId){
					$data['state_id']	= $stateId;
					if($this->isDefaultSheetData($langId)){
						$data['state_identifier']	= $identifier;
					}
				}else{
					$data['state_identifier']= $identifier;
				}

				$data['state_country_id']= $countryId;

				if($this->isDefaultSheetData($langId)){
					$data['state_active']= $active;
					$data['state_code']= $stateCode;
				}

				if($useStateId){
					$stateData = States::getAttributesById($stateId,array('state_id'));
				}else{
					$stateData = States::getAttributesByIdentifierAndCountry($identifier,$countryId,array('state_id'));
				}

				if(!empty($stateData) && $stateData['state_id']){
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
						'state_name'=> $stateName,
					);
					$this->db->insertFromArray( States::DB_TBL_LANG, $langData , false, array(),$langData );
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
		$arr = $this->getPolicyPointsColoumArr($langId, $userId);
		array_push( $sheetData, $arr );
		/* ] */

		$usePolicyPointId = false;
		if($this->settings['CONF_USE_POLICY_POINT_ID']){
			$usePolicyPointId = true;
		}

		$policyPointTypeArr = PolicyPoint::getPolicyPointTypesArr($langId);

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();

			if($usePolicyPointId){
				$sheetArr[] = $row['ppoint_id'];
				if($this->isDefaultSheetData($langId)){
					$sheetArr[] = $row['ppoint_identifier'];
				}
			}else{
				$sheetArr[] = $row['ppoint_identifier'];
			}
			$sheetArr[] = $row['ppoint_title'];

			if($this->isDefaultSheetData($langId)){
				if($this->settings['CONF_USE_POLICY_POINT_TYPE_ID']){
					$sheetArr[] = $row['ppoint_type'];
				}else{
					$sheetArr[] = isset($policyPointTypeArr[$row['ppoint_type']])?$policyPointTypeArr[$row['ppoint_type']]:'';
				}

				if(!$userId){
					$sheetArr[] = $row['ppoint_display_order'];
					if($this->settings['CONF_USE_O_OR_1']){
						$sheetArr[] = $row['ppoint_active'];
						$sheetArr[] = $row['ppoint_deleted'];
					}else{
						$sheetArr[] = ($row['ppoint_active'])?'YES':'NO';
						$sheetArr[] = ($row['ppoint_deleted'])?'YES':'NO';
					}
				}
			}
			array_push( $sheetData, $sheetArr );
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
		$arr = $this->getUsersColoumArr($langId);
		array_push( $sheetData, $arr );
		/* ] */

		$userTypeArr = User::getUserTypesArr($langId);

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();
			$sheetArr[] = $row['user_id'];
			$sheetArr[] = $row['user_name'];
			$sheetArr[] = $row['credential_username'];
			$sheetArr[] = $row['user_phone'];

			if($this->settings['CONF_USE_O_OR_1']){
				$sheetArr[] = $row['user_is_buyer'];
				$sheetArr[] = $row['user_is_supplier'];
				$sheetArr[] = $row['user_is_advertiser'];
				$sheetArr[] = $row['user_is_affiliate'];
			}else{
				$sheetArr[] = ($row['user_is_buyer'])?'YES':'NO';
				$sheetArr[] = ($row['user_is_supplier'])?'YES':'NO';
				$sheetArr[] = ($row['user_is_advertiser'])?'YES':'NO';
				$sheetArr[] = ($row['user_is_affiliate'])?'YES':'NO';
			}
			array_push( $sheetData, $sheetArr );
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
		$arr = $this->getSalesTaxColumArr($langId, $userId);
		array_push( $sheetData, $arr );
		/* ] */

		while( $row = $this->db->fetch($rs) ){
			$sheetArr = array();
			$sheetArr[] = $row['taxcat_id'];
			$sheetArr[] = $row['taxcat_identifier'];
			$sheetArr[] = $row['taxcat_name'];

			if(!$userId){
				if($this->isDefaultSheetData($langId)){
					$sheetArr[] = $this->displayDateTime($row['taxcat_last_updated']);
					if($this->settings['CONF_USE_O_OR_1']){
						$sheetArr[] = $row['taxcat_active'];
						$sheetArr[] = $row['taxcat_deleted'];
					}else{
						$sheetArr[] = ($row['taxcat_active'])?'YES':'NO';
						$sheetArr[] = ($row['taxcat_deleted'])?'YES':'NO';
					}
				}
			}

			array_push( $sheetData, $sheetArr );
		}
		return $sheetData;
	}
}
