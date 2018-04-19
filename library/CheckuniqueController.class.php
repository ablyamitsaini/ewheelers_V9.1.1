<?php
class CheckuniqueController {
	function check() {
		$db = FatApp::getDb();
		$post=FatApp::getPostedData();
		$expr='/^[a-zA-Z0-9_]+$/';
		if(!preg_match($expr, $post['tbl']) || !preg_match($expr, $post['tbl_fld']) || !preg_match($expr, $post['tbl_key'])) {
			FatUtility::dieJsonError('Invalid Request');
		}
		$srch=new SearchBase(FatApp::getPostedData('tbl', FatUtility::VAR_STRING));
		$srch->addCondition(FatApp::getPostedData('tbl_fld', FatUtility::VAR_STRING), '=', FatApp::getPostedData('val', FatUtility::VAR_STRING));
		$srch->addCondition(FatApp::getPostedData('tbl_key', FatUtility::VAR_STRING), '!=', FatApp::getPostedData('key_val', FatUtility::VAR_STRING));
		
		$operators=array(
				'eq'=>'=',
				'ne'=>'!=',
				'gt'=>'>',
				'ge'=>'>=',
				'lt'=>'<',
				'le'=>'<='
		);
		
		if(is_array( FatApp::getPostedData('constraints') )){
			foreach ( FatApp::getPostedData('constraints') as $contraint ){
				if (!array_key_exists($contraint['op'], $operators)) continue;
				$contraint['op'] = $operators[$contraint['op']];
				$srch->addCondition($contraint['fld'], $contraint['op'], $contraint['v']);
			}
		}
		
		$rs=$srch->getResultSet();
		
		if( $db->totalRecords($rs) > 0 ){
			$arr = array (
					'status' => 0,
					'existing_value' => '' 
			);
			if( FatApp::getPostedData('key_val') != '' && FatApp::getPostedData('key_val', FatUtility::VAR_STRING) != '0'){
				$srch=new SearchBase(FatApp::getPostedData('tbl'));
				$srch->addCondition(FatApp::getPostedData('tbl_key'), '=', FatApp::getPostedData('key_val'));
				$srch->addFld(FatApp::getPostedData('tbl_fld'));
				$rs=$srch->getResultSet();
				if($row=$db->fetch($rs)) $arr['existing_value']=$row[$post['tbl_fld']];
			}
			die(json_encode($arr));
		}
		FatUtility::dieJsonSuccess('Available');
	}
}