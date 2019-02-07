<?php
class ImportexportCommon extends FatModel{
	protected $db;

	const IMPORT_ERROR_LOG_PATH = CONF_UPLOADS_PATH.'import-error-log/';

	function __construct($id = 0 ) {
		//$this->defaultLangId = FatApp::getConfig('CONF_DEFAULT_SITE_LANG',FatUtility::VAR_INT,CommonHelper::getLangId());
		$this->defaultLangId = CommonHelper::getLangId();
		$this->db = FatApp::getDb();
		$this->settings = $this->getSettingsArr();
	}

	public function logFileName( $name = '', $langId = 0 ){
		$langId =  FatUtility::int($langId);
		if(!$langId){
			$langId = CommonHelper::getLangId();
		}
		$fileName = empty($name) ? 'Error_Log' : str_replace(' ', '_', $name);
		$fileName = Labels::getLabel('LBL_'.$fileName,$langId);
		return $fileName.'_'.time().'_'.mt_rand().'.csv';
	}
	public function openErrorLogFile( $fileName ,$langId = 0 )
	{
		if( empty($fileName)){
			return false;
		}

		$langId =  FatUtility::int($langId);
		if(!$langId){
			$langId = CommonHelper::getLangId();
		}

		$fileName = self::IMPORT_ERROR_LOG_PATH.$fileName;

		$file = fopen ($fileName, "w");

		$arr = array(
			Labels::getLabel('LBL_Row',$langId),
			Labels::getLabel('LBL_Column',$langId),
			Labels::getLabel('LBL_Description',$langId)
		);

		CommonHelper::writeLogFile( $file, $arr );
		return $file;
	}

	public function isUploadedFileValidMimes($files){
		$csvValidMimes = array(
			'text/x-comma-separated-values',
			'text/comma-separated-values',
			'application/octet-stream',
			'application/vnd.ms-excel',
			'application/x-csv',
			'text/x-csv',
			'text/csv',
			'application/csv',
			'application/excel',
			'application/vnd.msexcel',
			'text/plain'
		);
		return (isset($files['name'])
            && $files['error'] == 0
            && in_array(trim($files['type']), $csvValidMimes)
            && $files['size']>0);
	}

	public function isDefaultSheetData($langId){
		if($langId == $this->defaultLangId){
			return true;
		}
		return false;
	}

	public function displayDate($date){
		return $this->displayDateTime($date,false);
	}

	public function displayDateTime($dt,$time = true){
		if(trim($dt)=='' || $dt=='0000-00-00' || $dt=='0000-00-00 00:00:00'){return;}
		if($time == false){
			return date("m/d/Y",strtotime($dt));
		}
		return date('m/d/Y H:i:s',strtotime($dt));
	}

	public function getDateTime($dt,$time = true){
		if($time && strpos($dt, ":")){
			$dt = substr($dt,0,19);
		}else{
			$dt = substr($dt,0,10);
		}
		$emptyDateArr=array('0000-00-00','0000-00-00 00:00:00','0000/00/00','0000/00/00 00:00:00','00/00/0000','00/00/0000 00:00:00','00/00/00','00/00/00 00:00:00');
		if(trim($dt)=='' || in_array($dt,$emptyDateArr)){return '0000-00-00';}
		//$dt = str_replace('/', '-', $dt);
		$date = new DateTime($dt);
		$timeStamp=$date->getTimestamp();
		if($time==false){
			return date("Y-m-d",$timeStamp);
		}
		return date("Y-m-d H:i:s",$timeStamp);
	}

	public function getCategoryColoumArr($langId, $userId = 0){
		$arr = array();

		if($this->settings['CONF_USE_CATEGORY_ID']){
			$arr[] = Labels::getLabel('LBL_Category_Id', $langId);
			if($this->isDefaultSheetData($langId)){
				$arr[] = Labels::getLabel('LBL_Category_Identifier', $langId);
			}
		}else{
			$arr[] = Labels::getLabel('LBL_Category_Identifier', $langId);
		}

		if($this->isDefaultSheetData($langId)){
			if($this->settings['CONF_USE_CATEGORY_ID']){
				$arr[] = Labels::getLabel('LBL_Parent_Id', $langId);
			}else{
				$arr[] = Labels::getLabel('LBL_Parent_Identifier', $langId);
			}
		}

		$arr[] = Labels::getLabel('LBL_Name', $langId);
		if(!$userId){
			$arr[] = Labels::getLabel('LBL_Description', $langId);
			/* $arr[] = Labels::getLabel('LBL_Content_block', $langId); */

			if($this->isDefaultSheetData($langId)){
				$arr[] = Labels::getLabel('LBL_Seo_friendly_url', $langId);
				$arr[] = Labels::getLabel('LBL_Featured', $langId);
				$arr[] = Labels::getLabel('LBL_Active', $langId);
				$arr[] = Labels::getLabel('LBL_Display_Order', $langId);
				$arr[] = Labels::getLabel('LBL_Deleted', $langId);
			}
		}
		return $arr;
	}

	public function getCategoryMediaColoumArr($langId){
		$arr = array();
		if($this->settings['CONF_USE_CATEGORY_ID']){
			$arr[] = Labels::getLabel('LBL_Category_Id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_Category_Identifier', $langId);
		}

		if($this->settings['CONF_USE_LANG_ID']){
			$arr[] = Labels::getLabel('LBL_lang_id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_lang_code', $langId);
		}

		$arr[] = Labels::getLabel('LBL_Image_Type', $langId);
		$arr[] = Labels::getLabel('LBL_File_Path', $langId);
		$arr[] = Labels::getLabel('LBL_File_Name', $langId);
		$arr[] = Labels::getLabel('LBL_Display_Order', $langId);
		return $arr;
	}

	public function getBrandColoumArr($langId, $userId = 0){
		$arr = array();

		if($this->settings['CONF_USE_BRAND_ID']){
			$arr[] = Labels::getLabel('LBL_Brand_Id', $langId);
			if($this->isDefaultSheetData($langId)){
				$arr[] = Labels::getLabel('LBL_Brand_Identifier', $langId);
			}
		}else{
			$arr[] = Labels::getLabel('LBL_Brand_Identifier', $langId);
		}
		$arr[] = Labels::getLabel('LBL_Name', $langId);

		if(!$userId){
			$arr[] = Labels::getLabel('LBL_Description', $langId);

			if($this->isDefaultSheetData($langId)){
				$arr[] = Labels::getLabel('LBL_Seo_friendly_url', $langId);
				$arr[] = Labels::getLabel('LBL_Featured', $langId);
				$arr[] = Labels::getLabel('LBL_Active', $langId);
			}
		}
		return $arr;
	}

	public function getBrandMediaColoumArr($langId){
		$arr = array();
		if($this->settings['CONF_USE_BRAND_ID']){
			$arr[] = Labels::getLabel('LBL_Brand_Id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_Brand_Identifier', $langId);
		}

		if($this->settings['CONF_USE_LANG_ID']){
			$arr[] = Labels::getLabel('LBL_lang_id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_lang_code', $langId);
		}

		$arr[] = Labels::getLabel('LBL_File_Path', $langId);
		$arr[] = Labels::getLabel('LBL_File_Name', $langId);
		$arr[] = Labels::getLabel('LBL_Display_Order', $langId);
		return $arr;
	}

	public function getProductsCatalogColoumArr($langId, $userId = 0){
		$arr = array();

		if($this->settings['CONF_USE_PRODUCT_ID']){
			$arr[] = Labels::getLabel('LBL_PRODUCT_ID', $langId);
			if($this->isDefaultSheetData($langId)){
				$arr[] = Labels::getLabel('LBL_Product_identifier', $langId);
			}
		}else{
			$arr[] = Labels::getLabel('LBL_Product_identifier', $langId);
		}

		if($this->isDefaultSheetData($langId)){
			if($this->settings['CONF_USE_USER_ID']){
				$arr[] = Labels::getLabel('LBL_User_ID', $langId);
			}else{
				$arr[] = Labels::getLabel('LBL_Username', $langId);
			}
		}

		$arr[] = Labels::getLabel('LBL_Name', $langId);
		/* $arr[] = Labels::getLabel('LBL_Short_Description', $langId); */
		$arr[] = Labels::getLabel('LBL_Description', $langId);
		$arr[] = Labels::getLabel('LBL_Youtube_Video', $langId);

		if($this->isDefaultSheetData($langId)){
			if($this->settings['CONF_USE_CATEGORY_ID']){
				$arr[] = Labels::getLabel('LBL_Category_Id', $langId);
			}else{
				$arr[] = Labels::getLabel('LBL_Category_Identifier', $langId);
			}

			if($this->settings['CONF_USE_BRAND_ID']){
				$arr[] = Labels::getLabel('LBL_Brand_Id', $langId);
			}else{
				$arr[] = Labels::getLabel('LBL_Brand_Identifier', $langId);
			}

			if($this->settings['CONF_USE_PRODUCT_TYPE_ID']){
				$arr[] = Labels::getLabel('LBL_Product_Type_Id', $langId);
			}else{
				$arr[] = Labels::getLabel('LBL_Product_Type_Identifier', $langId);
			}

			$arr[] = Labels::getLabel('LBL_Model', $langId);
			$arr[] = Labels::getLabel('LBL_Min_Selling_price', $langId);

			if($this->settings['CONF_USE_TAX_CATEOGRY_ID']){
				$arr[] = Labels::getLabel('LBL_Tax_Category_Id', $langId);
			}else{
				$arr[] = Labels::getLabel('LBL_Tax_Category_Identifier', $langId);
			}

			$arr[] = Labels::getLabel('LBL_Length', $langId);
			$arr[] = Labels::getLabel('LBL_Width', $langId);
			$arr[] = Labels::getLabel('LBL_Height', $langId);

			if($this->settings['CONF_USE_DIMENSION_UNIT_ID']){
				$arr[] = Labels::getLabel('LBL_Dimension_Unit_Id', $langId);
			}else{
				$arr[] = Labels::getLabel('LBL_Dimension_Unit_Identifier', $langId);
			}

			$arr[] = Labels::getLabel('LBL_Weight', $langId);

			if($this->settings['CONF_USE_WEIGHT_UNIT_ID']){
				$arr[] = Labels::getLabel('LBL_Weight_unit_id', $langId);
			}else{
				$arr[] = Labels::getLabel('LBL_Weight_unit_identifier', $langId);
			}
			$arr[] = Labels::getLabel('LBL_EAN/UPC_code', $langId);
			if($this->settings['CONF_USE_COUNTRY_ID']){
				$arr[] = Labels::getLabel('LBL_Shipping_Country_Id', $langId);
			}else{
				$arr[] = Labels::getLabel('LBL_Shipping_Country_Code', $langId);
			}

			if(!$userId){
				$arr[] = Labels::getLabel('LBL_Added_On', $langId);
			}
			$arr[] = Labels::getLabel('LBL_Free_Shipping', $langId);
			$arr[] = Labels::getLabel('LBL_COD_available', $langId);
			if(!$userId){
				$arr[] = Labels::getLabel('LBL_Featured', $langId);
			}
			$arr[] = Labels::getLabel('LBL_Approved', $langId);
			$arr[] = Labels::getLabel('LBL_Active', $langId);
			$arr[] = Labels::getLabel('LBL_Deleted', $langId);
		}

		return $arr;
	}

	public function getProductOptionColoumArr($langId){

		$arr = array();
		if($this->settings['CONF_USE_PRODUCT_ID']){
			$arr[] = Labels::getLabel('LBL_PRODUCT_ID', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_PRODUCT_IDENTIFIER', $langId);
		}

		if($this->settings['CONF_USE_OPTION_ID']){
			$arr[] = Labels::getLabel('LBL_Option_ID', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_Option_Identifier', $langId);
		}

		return $arr;
	}

	public function getProductTagColoumArr($langId){
		$arr = array();
		if($this->settings['CONF_USE_PRODUCT_ID']){
			$arr[] = Labels::getLabel('LBL_PRODUCT_ID', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_PRODUCT_IDENTIFIER', $langId);
		}

		if($this->settings['CONF_USE_TAG_ID']){
			$arr[] = Labels::getLabel('LBL_TAG_ID', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_TAG_Identifier', $langId);
		}

		return $arr;
	}

	public function getProductSpecificationColoumArr($langId){
		$arr = array();
		if($this->settings['CONF_USE_PRODUCT_ID']){
			$arr[] = Labels::getLabel('LBL_product_id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_product_identifier', $langId);
		}

		if($this->settings['CONF_USE_LANG_ID']){
			$arr[] = Labels::getLabel('LBL_Lang_id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_Lang_code', $langId);
		}

		$arr[] = Labels::getLabel('LBL_specification_name', $langId);
		$arr[] = Labels::getLabel('LBL_specification_value', $langId);

		return $arr;
	}

	public function getProductShippingColoumArr($langId){
		$arr = array();
		if($this->settings['CONF_USE_PRODUCT_ID']){
			$arr[] = Labels::getLabel('LBL_product_id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_product_identifier', $langId);
		}

		if($this->settings['CONF_USE_USER_ID']){
			$arr[] = Labels::getLabel('LBL_user_id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_user_username', $langId);
		}

		if($this->settings['CONF_USE_COUNTRY_ID']){
			$arr[] = Labels::getLabel('LBL_Shipping_country_id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_Shipping_country_code', $langId);
		}

		if($this->settings['CONF_USE_SHIPPING_COMPANY_ID']){
			$arr[] = Labels::getLabel('LBL_Shipping_company_id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_Shipping_company_identifier', $langId);
		}

		if($this->settings['CONF_USE_SHIPPING_DURATION_ID']){
			$arr[] = Labels::getLabel('LBL_Shipping_duration_id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_Shipping_duration_identifier', $langId);
		}

		$arr[] = Labels::getLabel('LBL_Cost', $langId);
		$arr[] = Labels::getLabel('LBL_Additional_item_cost', $langId);
		return $arr;
	}

	public function getProductMediaColoumArr($langId){
		$arr = array();
		if($this->settings['CONF_USE_PRODUCT_ID']){
			$arr[] = Labels::getLabel('LBL_Product_Id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_Product_Identifier', $langId);
		}

		if($this->settings['CONF_USE_LANG_ID']){
			$arr[] = Labels::getLabel('LBL_lang_id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_lang_code', $langId);
		}

		if($this->settings['CONF_USE_OPTION_ID']){
			$arr[] = Labels::getLabel('LBL_Option_id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_Option_identifer', $langId);
		}

		if($this->settings['CONF_OPTION_VALUE_ID']){
			$arr[] = Labels::getLabel('LBL_Option_value_id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_Option_value_identifer', $langId);
		}

		$arr[] = Labels::getLabel('LBL_File_Path', $langId);
		$arr[] = Labels::getLabel('LBL_File_Name', $langId);
		$arr[] = Labels::getLabel('LBL_Display_Order', $langId);
		return $arr;
	}

	public function getSelProdGeneralColoumArr($langId,$userId = 0){
		$arr = array();
		$arr[] = Labels::getLabel('LBL_seller_product_id', $langId);

		if($this->settings['CONF_USE_PRODUCT_ID']){
			$arr[] = Labels::getLabel('LBL_Product_Id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_Product_Identifier', $langId);
		}

		if(!$userId){
			if($this->settings['CONF_USE_USER_ID']){
				$arr[] = Labels::getLabel('LBL_User_ID', $langId);
			}else{
				$arr[] = Labels::getLabel('LBL_Username', $langId);
			}
		}

		if($this->isDefaultSheetData($langId)){
			$arr[] = Labels::getLabel('LBL_Selling_Price', $langId);
			/* $arr[] = Labels::getLabel('LBL_Cost', $langId);	 */
			$arr[] = Labels::getLabel('LBL_Stock', $langId);
			$arr[] = Labels::getLabel('LBL_SKU', $langId);
			$arr[] = Labels::getLabel('LBL_Min_Order_Quantity', $langId);
			$arr[] = Labels::getLabel('LBL_Sustack_stock', $langId);
			$arr[] = Labels::getLabel('LBL_Track_Inventory', $langId);
			$arr[] = Labels::getLabel('LBL_Threshold_stock_level', $langId);

			if($this->settings['CONF_USE_PROD_CONDITION_ID']){
				$arr[] = Labels::getLabel('LBL_Condition_id', $langId);
			}else{
				$arr[] = Labels::getLabel('LBL_Condition_Identifier', $langId);
			}
			$arr[] = Labels::getLabel('LBL_digital_product_max_download_time', $langId);
			$arr[] = Labels::getLabel('LBL_download_validity_in_days', $langId);
		}

		$arr[] = Labels::getLabel('LBL_Title', $langId);
		$arr[] = Labels::getLabel('LBL_Comments', $langId);

		if($this->isDefaultSheetData($langId)){
			$arr[] = Labels::getLabel('LBL_Url_keyword', $langId);
			if(!$userId){
				$arr[] = Labels::getLabel('LBL_Added_on', $langId);
			}
			$arr[] = Labels::getLabel('LBL_Available_from', $langId);
			$arr[] = Labels::getLabel('LBL_Active', $langId);
			$arr[] = Labels::getLabel('LBL_COD_Available', $langId);
			if(!$userId){
				$arr[] = Labels::getLabel('LBL_Deleted', $langId);
				$arr[] = Labels::getLabel('LBL_Sold_Count', $langId);
			}
		}
		return $arr;
	}

	public function getSelProdMediaColoumArr($langId){
		$arr = array();
		$arr[] = Labels::getLabel('LBL_seller_product_id', $langId);
		if($this->settings['CONF_USE_LANG_ID']){
			$arr[] = Labels::getLabel('LBL_lang_id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_lang_code', $langId);
		}
		$arr[] = Labels::getLabel('LBL_File_Path', $langId);
		$arr[] = Labels::getLabel('LBL_File_Name', $langId);
		$arr[] = Labels::getLabel('LBL_Display_Order', $langId);
		return $arr;
	}

	public function getSelProdOptionsColoumArr($langId){
		$arr = array();
		$arr[] = Labels::getLabel('LBL_seller_product_id', $langId);

		if($this->settings['CONF_USE_OPTION_ID']){
			$arr[] = Labels::getLabel('LBL_Option_id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_Option_identifier', $langId);
		}

		if($this->settings['CONF_OPTION_VALUE_ID']){
			$arr[] = Labels::getLabel('LBL_Option_Value_ID', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_Option_Value_Identifier', $langId);
		}
		return $arr;
	}

	public function getSelProdSeoColoumArr($langId){
		$arr = array();
		$arr[] = Labels::getLabel('LBL_seller_product_id', $langId);

		if($this->isDefaultSheetData($langId)){
			$arr[] = Labels::getLabel('LBL_meta_identifier', $langId);
		}
		$arr[] = Labels::getLabel('LBL_meta_title', $langId);
		$arr[] = Labels::getLabel('LBL_meta_keywords', $langId);
		$arr[] = Labels::getLabel('LBL_meta_description', $langId);
		$arr[] = Labels::getLabel('LBL_other_meta_tags', $langId);
		return $arr;
	}

	public function getSelProdSpecialPriceColoumArr($langId){
		$arr = array();
		$arr[] = Labels::getLabel('LBL_seller_product_id', $langId);
		$arr[] = Labels::getLabel('LBL_Start_date', $langId);
		$arr[] = Labels::getLabel('LBL_End_date', $langId);
		$arr[] = Labels::getLabel('LBL_Price', $langId);

		/* if($this->settings['CONF_USE_PERSENT_OR_FLAT_CONDITION_ID']){
			$arr[] = Labels::getLabel('LBL_display_price_type_id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_display_price_type', $langId);
		}

		$arr[] = Labels::getLabel('LBL_display_discount_value', $langId);
		$arr[] = Labels::getLabel('LBL_display_list_price', $langId); */
		return $arr;
	}

	public function getSelProdVolumeDiscountColoumArr($langId){
		$arr = array();
		$arr[] = Labels::getLabel('LBL_seller_product_id', $langId);
		$arr[] = Labels::getLabel('LBL_Min_quantity', $langId);
		$arr[] = Labels::getLabel('LBL_discount_percentage', $langId);
		return $arr;
	}

	public function getSelProdBuyTogetherColoumArr($langId){
		$arr = array();
		$arr[] = Labels::getLabel('LBL_seller_product_id', $langId);
		$arr[] = Labels::getLabel('LBL_Buy_together_selprod_id', $langId);
		return $arr;
	}

	public function getSelProdRelatedProductColoumArr($langId){
		$arr = array();
		$arr[] = Labels::getLabel('LBL_seller_product_id', $langId);
		$arr[] = Labels::getLabel('LBL_Related_selprod_id', $langId);
		return $arr;
	}

	public function getSelProdPolicyColoumArr($langId){
		$arr = array();
		$arr[] = Labels::getLabel('LBL_seller_product_id', $langId);
		if($this->settings['CONF_USE_POLICY_POINT_ID']){
			$arr[] = Labels::getLabel('LBL_Policy_point_id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_Policy_point_identifier', $langId);
		}
		return $arr;
	}

	public function getOptionsColoumArr($langId, $userId = 0){
		$arr = array();

		if($this->settings['CONF_USE_OPTION_ID']){
			$arr[] = Labels::getLabel('LBL_Option_id', $langId);
			if($this->isDefaultSheetData($langId)){
				$arr[] = Labels::getLabel('LBL_Option_identifier', $langId);
			}
		}else{
			$arr[] = Labels::getLabel('LBL_Option_identifier', $langId);
		}

		$arr[] = Labels::getLabel('LBL_Option_name', $langId);

		if(!$userId){
			if($this->isDefaultSheetData($langId)){

				if($this->settings['CONF_USE_USER_ID']){
					$arr[] = Labels::getLabel('LBL_User_ID', $langId);
				}else{
					$arr[] = Labels::getLabel('LBL_Username', $langId);
				}

				/* if($this->settings['CONF_USE_OPTION_TYPE_ID']){
					$arr[] = Labels::getLabel('LBL_Option_Type_ID', $langId);
				}else{
					$arr[] = Labels::getLabel('LBL_Option_Type', $langId);
				} */

				$arr[] = Labels::getLabel('LBL_Is_Separate_Image', $langId);
				$arr[] = Labels::getLabel('LBL_Is_Color_Type', $langId);
				$arr[] = Labels::getLabel('LBL_Display_in_filters', $langId);
				if(!$userId){
					$arr[] = Labels::getLabel('LBL_Deleted', $langId);
				}
			}
		}
		return $arr;
	}

	public function getOptionsValueColoumArr($langId, $userId = 0){
		$arr = array();

		if($this->settings['CONF_OPTION_VALUE_ID']){
			$arr[] = Labels::getLabel('LBL_Option_Value_ID', $langId);
			if($this->isDefaultSheetData($langId)){
				$arr[] = Labels::getLabel('LBL_Option_Value_Identifier', $langId);
			}
		}else{
			$arr[] = Labels::getLabel('LBL_Option_Value_Identifier', $langId);
		}

		if($this->settings['CONF_USE_OPTION_ID']){
			$arr[] = Labels::getLabel('LBL_Option_id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_Option_identifier', $langId);
		}

		$arr[] = Labels::getLabel('LBL_Option_value', $langId);

		if($this->isDefaultSheetData($langId)){
			$arr[] = Labels::getLabel('LBL_Color_Code', $langId);
			if(!$userId){
				$arr[] = Labels::getLabel('LBL_Display_Order', $langId);
			}
		}

		return $arr;
	}

	public function getTagColoumArr($langId, $userId = 0){
		$arr = array();
		if($this->settings['CONF_USE_TAG_ID']){
			$arr[] = Labels::getLabel('LBL_Tag_Id', $langId);
			if($this->isDefaultSheetData($langId)){
				$arr[] = Labels::getLabel('LBL_Tag_Identifier', $langId);
			}
		}else{
			$arr[] = Labels::getLabel('LBL_Tag_Identifier', $langId);
		}

		if(!$userId){
			if($this->isDefaultSheetData($langId)){
				if($this->settings['CONF_USE_USER_ID']){
					$arr[] = Labels::getLabel('LBL_User_ID', $langId);
				}else{
					$arr[] = Labels::getLabel('LBL_Username', $langId);
				}
			}
		}

		$arr[] = Labels::getLabel('LBL_Tag_Name', $langId);
		return $arr;
	}

	public function getCountryColoumArr($langId, $userId = 0){
		$arr = array();
		if($this->settings['CONF_USE_COUNTRY_ID']){
			$arr[] = Labels::getLabel('LBL_Country_Id', $langId);
			if($this->isDefaultSheetData($langId)){
				$arr[] = Labels::getLabel('LBL_Country_code', $langId);
			}
		}else{
			$arr[] = Labels::getLabel('LBL_Country_code', $langId);
		}

		$arr[] = Labels::getLabel('LBL_Country_Name', $langId);

		if(!$userId){
			if($this->isDefaultSheetData($langId)){
				if($this->settings['CONF_USE_CURRENCY_ID']){
					$arr[] = Labels::getLabel('LBL_Currency_ID', $langId);
				}else{
					$arr[] = Labels::getLabel('LBL_Currency_code', $langId);
				}

				if($this->settings['CONF_USE_LANG_ID']){
					$arr[] = Labels::getLabel('LBL_Lang_ID', $langId);
				}else{
					$arr[] = Labels::getLabel('LBL_Lang_code', $langId);
				}

				$arr[] = Labels::getLabel('LBL_Active', $langId);
			}
		}

		return $arr;
	}

	public function getStatesColoumArr($langId, $userId = 0){
		$arr = array();
		if($this->settings['CONF_USE_STATE_ID']){
			$arr[] = Labels::getLabel('LBL_State_Id', $langId);
			if($this->isDefaultSheetData($langId)){
				$arr[] = Labels::getLabel('LBL_State_Identifier', $langId);
			}
		}else{
			$arr[] = Labels::getLabel('LBL_State_Identifier', $langId);
		}

		if($this->settings['CONF_USE_COUNTRY_ID']){
			$arr[] = Labels::getLabel('LBL_Country_Id', $langId);
		}else{
			$arr[] = Labels::getLabel('LBL_Country_code', $langId);
		}

		$arr[] = Labels::getLabel('LBL_State_Name', $langId);

		if($this->isDefaultSheetData($langId)){
			$arr[] = Labels::getLabel('LBL_State_Code', $langId);
			if(!$userId){
				$arr[] = Labels::getLabel('LBL_Active', $langId);
			}
		}
		return $arr;
	}

	public function getPolicyPointsColoumArr($langId, $userId = 0){
		$arr = array();
		if($this->settings['CONF_USE_POLICY_POINT_ID']){
			$arr[] = Labels::getLabel('LBL_Policy_Point_Id', $langId);
			if($this->isDefaultSheetData($langId)){
				$arr[] = Labels::getLabel('LBL_Policy_Point_Identifier', $langId);
			}
		}else{
			$arr[] = Labels::getLabel('LBL_Policy_Point_Identifier', $langId);
		}
		$arr[] = Labels::getLabel('LBL_Policy_Point_Title', $langId);

		if($this->isDefaultSheetData($langId)){
			if($this->settings['CONF_USE_POLICY_POINT_TYPE_ID']){
				$arr[] = Labels::getLabel('LBL_Policy_Point_Type_Id', $langId);
			}else{
				$arr[] = Labels::getLabel('LBL_Policy_Point_Type_Identifier', $langId);
			}

			if(!$userId){
				$arr[] = Labels::getLabel('LBL_Display_order', $langId);
				$arr[] = Labels::getLabel('LBL_Active', $langId);
				$arr[] = Labels::getLabel('LBL_Deleted', $langId);
			}
		}
		return $arr;
	}

	public function getUsersColoumArr($langId){
		$arr = array();
		$arr[] = Labels::getLabel('LBL_User_id', $langId);
		$arr[] = Labels::getLabel('LBL_Name', $langId);
		$arr[] = Labels::getLabel('LBL_Username', $langId);
		$arr[] = Labels::getLabel('LBL_phone', $langId);
		$arr[] = Labels::getLabel('LBL_Is_buyer', $langId);
		$arr[] = Labels::getLabel('LBL_Is_supplier', $langId);
		$arr[] = Labels::getLabel('LBL_Is_Advertiser', $langId);
		$arr[] = Labels::getLabel('LBL_Is_Affiliate', $langId);
		return $arr;
	}

	public function getSalesTaxColumArr($langId, $userId = 0){
		$arr = array();
		$arr[] = Labels::getLabel('LBL_Tax_Category_Id', $langId);
		$arr[] = Labels::getLabel('LBL_Tax_Category_Identifier', $langId);
		$arr[] = Labels::getLabel('LBL_Tax_Category_Name', $langId);
		if(!$userId){
			if($this->isDefaultSheetData($langId)){
				$arr[] = Labels::getLabel('LBL_Last_Updated', $langId);
				$arr[] = Labels::getLabel('LBL_Active', $langId);
				$arr[] = Labels::getLabel('LBL_Deleted', $langId);
			}
		}
		return $arr;
	}

	public function getAllRewriteUrls($startingWith){
		$keywordSrch = UrlRewrite::getSearchObject();
		$keywordSrch->doNotCalculateRecords();
		$keywordSrch->doNotLimitRecords();
		$keywordSrch->addMultipleFields(array('urlrewrite_original','urlrewrite_custom'));
		$keywordSrch->addCondition(UrlRewrite::DB_TBL_PREFIX . 'original', 'like', $startingWith.'%');
		$keywordRs = $keywordSrch->getResultSet();
		$urlKeywords = $this->db->fetchAllAssoc($keywordRs,'brand_identifier');
		return $urlKeywords;
	}

	public function getSettingsArr($siteConfiguration = false){
		return array(
			'CONF_USE_BRAND_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_BRAND_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_CATEGORY_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_CATEGORY_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_PRODUCT_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_PRODUCT_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_USER_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_USER_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_OPTION_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_OPTION_ID',FatUtility::VAR_INT,0):false,
			'CONF_OPTION_VALUE_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_OPTION_VALUE_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_TAG_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_TAG_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_TAX_CATEOGRY_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_TAX_CATEOGRY_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_PRODUCT_TYPE_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_PRODUCT_TYPE_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_DIMENSION_UNIT_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_DIMENSION_UNIT_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_WEIGHT_UNIT_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_WEIGHT_UNIT_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_LANG_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_LANG_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_CURRENCY_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_CURRENCY_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_PROD_CONDITION_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_PROD_CONDITION_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_PERSENT_OR_FLAT_CONDITION_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_PERSENT_OR_FLAT_CONDITION_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_STATE_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_STATE_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_COUNTRY_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_COUNTRY_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_POLICY_POINT_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_POLICY_POINT_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_POLICY_POINT_TYPE_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_POLICY_POINT_TYPE_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_SHIPPING_COMPANY_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_SHIPPING_COMPANY_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_SHIPPING_DURATION_ID'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_SHIPPING_DURATION_ID',FatUtility::VAR_INT,0):false,
			'CONF_USE_O_OR_1'=>($siteConfiguration)?FatApp::getConfig('CONF_USE_O_OR_1',FatUtility::VAR_INT,0):false,
		);
	}

	public function getSettings($userId = 0){
		$userId = FatUtility::int($userId);
		$res = $this->getSettingsArr(true);
		if(!$userId){
			return $res;
		}

		$srch = new SearchBase(Importexport::DB_TBL_SETTINGS, 's');
		$srch->addCondition('impexp_setting_user_id','=',$userId);
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$srch->addMultipleFields(array('impexp_setting_key','impexp_setting_value'));
		$rs = $srch->getResultSet();
		$row = $this->db->fetchAllAssoc($rs);
		if(!$row){
			return $res;
		}
		return $row;
	}

	public function getAllCategoryIdentifiers($byId = true,$catIdOrIdentifier = false){
		$srch = ProductCategory::getSearchObject(false,false,false);
		$srch->doNotCalculateRecords();
		if($catIdOrIdentifier){
			$srch->setPageSize(1);
		}else{
			$srch->doNotLimitRecords();
		}

		if($byId){
			$srch->addMultipleFields(array('prodcat_id','prodcat_identifier'));
			if($catIdOrIdentifier){
				$srch->addCondition('prodcat_id','=',$catIdOrIdentifier);
			}
		}else{
			$srch->addMultipleFields(array('prodcat_identifier','prodcat_id'));
			if($catIdOrIdentifier){
				$srch->addCondition('prodcat_identifier','=',$catIdOrIdentifier);
			}
		}
		$rs = $srch->getResultSet();
		return $row = $this->db->fetchAllAssoc($rs);
	}

	public function getAllProductsIdentifiers($byId = true,$productIdOrIdentifier = false){
		$srch = Product::getSearchObject();
		$srch->doNotCalculateRecords();

		if($productIdOrIdentifier){
			$srch->setPageSize(1);
		}else{
			$srch->doNotLimitRecords();
		}

		if($byId){
			$srch->addMultipleFields(array('product_id','product_identifier'));
			if($productIdOrIdentifier){
				$srch->addCondition('product_id','=',$productIdOrIdentifier);
			}
		}else{
			$srch->addMultipleFields(array('product_identifier','product_id'));
			if($productIdOrIdentifier){
				$srch->addCondition('product_identifier','=',$productIdOrIdentifier);
			}
		}
		$rs = $srch->getResultSet();
		return $row = $this->db->fetchAllAssoc($rs);
	}

	public function getAllUserArr($byId = true,$userIdOrUsername = false){
		$srch = User::getSearchObject(true);
		$srch->doNotCalculateRecords();

		if($userIdOrUsername){
			$srch->setPageSize(1);
		}else{
			$srch->doNotLimitRecords();
		}

		if($byId){
			$srch->addMultipleFields(array('user_id','credential_username'));
			if($userIdOrUsername){
				$srch->addCondition('user_id','=',$userIdOrUsername);
			}
		}else{
			$srch->addMultipleFields(array('credential_username','user_id'));
			if($userIdOrUsername){
				$srch->addCondition('credential_username','=',$userIdOrUsername);
			}
		}

		$rs = $srch->getResultSet();
		return $row = $this->db->fetchAllAssoc($rs);
	}

	public function getTaxCategoryArr($byId = true,$taxCatIdOrIdentifier = false){
		$srch = Tax::getSearchObject(false,false);
		$srch->doNotCalculateRecords();

		if($taxCatIdOrIdentifier){
			$srch->setPageSize(1);
		}else{
			$srch->doNotLimitRecords();
		}

		if($byId){
			$srch->addMultipleFields(array('taxcat_id','taxcat_identifier'));
			if($taxCatIdOrIdentifier){
				$srch->addCondition('taxcat_id','=',$taxCatIdOrIdentifier);
			}
		}else{
			$srch->addMultipleFields(array('taxcat_identifier','taxcat_id'));
			if($taxCatIdOrIdentifier){
				$srch->addCondition('taxcat_identifier','=',$taxCatIdOrIdentifier);
			}
		}
		$rs = $srch->getResultSet();
		return $row = $this->db->fetchAllAssoc($rs);
	}

	public function getTaxCategoryByProductId($productId){
		$taxData = array();
		$taxObj = Tax::getTaxCatObjByProductId($productId);
		$taxObj->addMultipleFields(array('ptt_taxcat_id'));
		$taxObj->doNotCalculateRecords();
		$taxObj->setPageSize(1);
		$taxObj->addOrder('ptt_seller_user_id','ASC');
		$rs = $taxObj->getResultSet();
		return $taxData = FatApp::getDb()->fetch($rs);
	}

	public function getAllBrandsArr($byId = true,$brandIdOrIdentifier = false){
		$srch = Brand::getSearchObject(false,false,false);
		$srch->doNotCalculateRecords();

		if($brandIdOrIdentifier){
			$srch->setPageSize(1);
		}else{
			$srch->doNotLimitRecords();
		}

		if($byId){
			$srch->addMultipleFields(array('brand_id','brand_identifier'));
			if($brandIdOrIdentifier){
				$srch->addCondition('brand_id','=',$brandIdOrIdentifier);
			}
		}else{
			$srch->addMultipleFields(array('brand_identifier','brand_id'));
			if($brandIdOrIdentifier){
				$srch->addCondition('brand_identifier','=',$brandIdOrIdentifier);
			}
		}
		$rs = $srch->getResultSet();
		return $row = $this->db->fetchAllAssoc($rs);
	}

	public function getTaxCategoriesArr($byId = true){
		$srch = Tax::getSearchObject(false,false);
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		if($byId){
			$srch->addMultipleFields(array('taxcat_id','taxcat_identifier'));
		}else{
			$srch->addMultipleFields(array('taxcat_identifier','taxcat_id'));
		}
		$rs = $srch->getResultSet();
		return $row = $this->db->fetchAllAssoc($rs);
	}

	public function getCountriesArr($byId = true,$countryIdOrCode = false){
		$srch = Countries::getSearchObject(false,false);
		$srch->doNotCalculateRecords();

		if($countryIdOrCode){
			$srch->setPageSize(1);
		}else{
			$srch->doNotLimitRecords();
		}

		if($byId){
			$srch->addMultipleFields(array('country_id','country_code'));
			if($countryIdOrCode){
				$srch->addCondition('country_id','=',$countryIdOrCode);
			}
		}else{
			$srch->addMultipleFields(array('country_code','country_id'));
			if($countryIdOrCode){
				$srch->addCondition('country_code','=',$countryIdOrCode);
			}
		}
		$rs = $srch->getResultSet();
		return $row = $this->db->fetchAllAssoc($rs);
	}

	public function getProductCategoriesByProductId($productId,$byId = true){
		$srch = new SearchBase( Product::DB_TBL_PRODUCT_TO_CATEGORY, 'ptc' );
		$srch->addCondition( Product::DB_TBL_PRODUCT_TO_CATEGORY_PREFIX . 'product_id', '=', $productId );

		$srch->joinTable( ProductCategory::DB_TBL, 'INNER JOIN', ProductCategory::DB_TBL_PREFIX.'id = ptc.'.Product::DB_TBL_PRODUCT_TO_CATEGORY_PREFIX.'prodcat_id','cat');
		if($byId){
			$srch->addMultipleFields(array(ProductCategory::DB_TBL_PREFIX.'id',ProductCategory::DB_TBL_PREFIX.'identifier'));
		}else{
			$srch->addMultipleFields(array(ProductCategory::DB_TBL_PREFIX.'identifier',ProductCategory::DB_TBL_PREFIX.'id'));
		}
		$rs = $srch->getResultSet();
		$records = $this->db->fetchAllAssoc($rs);
		if( !$records ){ return false; }
		return $records;
	}

	public function getAllOptions($byId = true,$optionIdOrIdentifier = false){
		$srch = Option::getSearchObject(false,false);
		$srch->doNotCalculateRecords();
		if($byId){
			$srch->addMultipleFields(array('option_id','option_identifier'));
			if($optionIdOrIdentifier){
				$srch->setPageSize(1);
				$srch->addCondition('option_id','=',$optionIdOrIdentifier);
			}else{
				$srch->doNotLimitRecords();
			}
		}else{
			$srch->addMultipleFields(array('option_identifier','option_id'));
			if($optionIdOrIdentifier){
				$srch->setPageSize(1);
				$srch->addCondition('option_identifier','=',$optionIdOrIdentifier);
			}else{
				$srch->doNotLimitRecords();
			}
		}
		$rs = $srch->getResultSet();
		return $row = $this->db->fetchAllAssoc($rs);
	}

	public function getAllOptionValues($optionId,$byId = true,$optionValueIdOrIdentifier = false){
		$optionId = FatUtility::convertToType($optionId, FatUtility::VAR_INT);
		$srch = OptionValue::getSearchObject();
		$srch->addCondition('ov.optionvalue_option_id' , '=', $optionId);
		$srch->doNotCalculateRecords();
		if($byId){
			$srch->addMultipleFields(array('optionvalue_id','optionvalue_identifier'));
			if($optionValueIdOrIdentifier){
				$srch->setPageSize(1);
				$srch->addCondition('optionvalue_id','=',$optionValueIdOrIdentifier);
			}else{
				$srch->doNotLimitRecords();
			}
		}else{
			$srch->addMultipleFields(array('optionvalue_identifier','optionvalue_id'));
			if($optionValueIdOrIdentifier){
				$srch->setPageSize(1);
				$srch->addCondition('optionvalue_identifier','=',$optionValueIdOrIdentifier);
			}else{
				$srch->doNotLimitRecords();
			}
		}
		$rs = $srch->getResultSet();
		return $row = $this->db->fetchAllAssoc($rs);
	}

	public function getAllTags($byId = true,$tagIdOrIdentifier = false){
		$srch = Tag::getSearchObject();
		$srch->doNotCalculateRecords();
		if($byId){
			$srch->addMultipleFields(array('tag_id','tag_identifier'));
			if($tagIdOrIdentifier){
				$srch->setPageSize(1);
				$srch->addCondition('tag_id','=',$tagIdOrIdentifier);
			}else{
				$srch->doNotLimitRecords();
			}
		}else{
			$srch->addMultipleFields(array('tag_identifier','tag_id'));
			if($tagIdOrIdentifier){
				$srch->setPageSize(1);
				$srch->addCondition('tag_identifier','=',$tagIdOrIdentifier);
			}else{
				$srch->doNotLimitRecords();
			}
		}
		$rs = $srch->getResultSet();
		return $row = $this->db->fetchAllAssoc($rs);
	}

	public function getAllShippingCompany($byId = true,$scompanyIdOrIdentifier = false){
		$srch = ShippingCompanies::getSearchObject(false);
		$srch->doNotCalculateRecords();
		if($byId){
			$srch->addMultipleFields(array('scompany_id','scompany_identifier'));
			if($scompanyIdOrIdentifier){
				$srch->setPageSize(1);
				$srch->addCondition('scompany_id','=',$scompanyIdOrIdentifier);
			}else{
				$srch->doNotLimitRecords();
			}
		}else{
			$srch->addMultipleFields(array('scompany_identifier','scompany_id'));
			if($scompanyIdOrIdentifier){
				$srch->setPageSize(1);
				$srch->addCondition('scompany_identifier','=',$scompanyIdOrIdentifier);
			}else{
				$srch->doNotLimitRecords();
			}
		}
		$rs = $srch->getResultSet();
		return $row = $this->db->fetchAllAssoc($rs);
	}

	public function getAllShippingDurations($byId = true,$durationIdOrIdentifier = false){
		$srch = ShippingDurations::getSearchObject(false,false);
		$srch->doNotCalculateRecords();
		if($byId){
			$srch->addMultipleFields(array('sduration_id','sduration_identifier'));
			if($durationIdOrIdentifier){
				$srch->setPageSize(1);
				$srch->addCondition('sduration_id','=',$durationIdOrIdentifier);
			}else{
				$srch->doNotLimitRecords();
			}
		}else{
			$srch->addMultipleFields(array('sduration_identifier','sduration_id'));
			if($durationIdOrIdentifier){
				$srch->setPageSize(1);
				$srch->addCondition('sduration_identifier','=',$durationIdOrIdentifier);
			}else{
				$srch->doNotLimitRecords();
			}
		}
		$rs = $srch->getResultSet();
		return $row = $this->db->fetchAllAssoc($rs);
	}

	public function getAllPrivacyPoints($byId = true,$policyPointIdOrIdentifier = false){
		$srch = PolicyPoint::getSearchObject(false,false);
		$srch->doNotCalculateRecords();
		if($byId){
			$srch->addMultipleFields(array('ppoint_id','ppoint_identifier'));
			if($policyPointIdOrIdentifier){
				$srch->setPageSize(1);
				$srch->addCondition('ppoint_id','=',$policyPointIdOrIdentifier);
			}else{
				$srch->doNotLimitRecords();
			}
		}else{
			$srch->addMultipleFields(array('ppoint_identifier','ppoint_id'));
			if($policyPointIdOrIdentifier){
				$srch->setPageSize(1);
				$srch->addCondition('ppoint_identifier','=',$policyPointIdOrIdentifier);
			}else{
				$srch->doNotLimitRecords();
			}
		}
		$rs = $srch->getResultSet();
		return $row = $this->db->fetchAllAssoc($rs);
	}

	public function getProductIdByTempId($tempId , $userId = 0){
		$srch = new SearchBase(Importexport::DB_TBL_TEMP_PRODUCT_IDS, 't');
		$srch->doNotCalculateRecords();
		$srch->setPageSize(1);
		$srch->addCondition( 'pti_product_temp_id' , '=', $tempId);
		$srch->addCondition( 'pti_user_id', '=', $userId);
		$rs = $srch->getResultSet();
		$row = $this->db->fetch($rs);
		if (!is_array($row)) {
			return false;
		}
		return $row;
	}

	public function getCheckAndSetProductIdByTempId($sellerTempId,$userId){
		$productId = 0;
		$userTempIdData = $this->getProductIdByTempId($sellerTempId,$userId);
		if(!empty($userTempIdData) && $userTempIdData['pti_product_temp_id'] == $sellerTempId){
			$productId = $userTempIdData['pti_product_id'];
		}else{
			$row = Product::getAttributesById($sellerTempId,array('product_id','product_seller_id'));
			if(!empty($row) && $row['product_seller_id'] == $userId){
				$productId = $row['product_id'];
				$tempData = array(
					'pti_product_id' =>$productId,
					'pti_product_temp_id' =>$sellerTempId,
					'pti_user_id' =>$userId,
				);
				$this->db->deleteRecords( Importexport::DB_TBL_TEMP_PRODUCT_IDS, array('smt'=> 'pti_product_id = ? and pti_user_id = ?','vals' => array($productId,$userId) ) );
				$this->db->insertFromArray( Importexport::DB_TBL_TEMP_PRODUCT_IDS, $tempData,false,array(),$tempData );
			}
		}
		return 	$productId;
	}

	public function getTempSelProdIdByTempId($tempId , $userId = 0){
		$srch = new SearchBase(Importexport::DB_TBL_TEMP_SELPROD_IDS, 't');
		$srch->doNotCalculateRecords();
		$srch->setPageSize(1);
		$srch->addCondition( 'spti_selprod_temp_id' , '=', $tempId);
		$srch->addCondition( 'spti_user_id', '=', $userId);
		$rs = $srch->getResultSet();
		$row = $this->db->fetch($rs);
		if (!is_array($row)) {
			return false;
		}
		return $row;
	}

	public function getCheckAndSetSelProdIdByTempId($sellerTempId,$userId){
		$selprodId = 0;
		$userTempIdData = $this->getTempSelProdIdByTempId($sellerTempId,$userId);
		if(!empty($userTempIdData) && $userTempIdData['spti_selprod_temp_id'] == $sellerTempId){
			$selprodId = $userTempIdData['spti_selprod_id'];
		}else{
			$row = SellerProduct::getAttributesById($sellerTempId,array('selprod_id','selprod_user_id'));
			if(!empty($row) && $row['selprod_user_id'] == $userId){
				$selprodId = $row['selprod_id'];
				$tempData = array(
					'spti_selprod_id' =>$selprodId,
					'spti_selprod_temp_id' =>$sellerTempId,
					'spti_user_id' =>$userId,
				);
				$this->db->deleteRecords( Importexport::DB_TBL_TEMP_SELPROD_IDS, array('smt'=> 'spti_selprod_id = ? and spti_user_id = ?','vals' => array($selprodId,$userId) ) );
				$this->db->insertFromArray( Importexport::DB_TBL_TEMP_SELPROD_IDS, $tempData,false,array(),$tempData );
			}
		}
		return 	$selprodId;
	}
}
