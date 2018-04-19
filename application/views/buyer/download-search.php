<?php 
defined('SYSTEM_INIT') or die('Invalid Usage.');

$frmSrch->setFormTagAttribute('onSubmit','searchBuyerDownloads(this); return false;');
$frmSrch->setFormTagAttribute('class', 'form'); 
$frmSrch->developerTags['colClassPrefix'] = 'col-md-';
$frmSrch->developerTags['fld_default_col'] = 12;

$submitBtnFld = $frmSrch->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class','btn--block');
$submitBtnFld->setWrapperAttribute('class','col-sm-6');
$submitBtnFld->developerTags['col'] = 2;

$cancelBtnFld = $frmSrch->getField('btn_clear');
$cancelBtnFld->setFieldTagAttribute('class','btn--block');
$cancelBtnFld->setWrapperAttribute('class','col-sm-6');
$cancelBtnFld->developerTags['col'] = 2;
?>
<div class="form__cover nopadding--bottom">
	<?php echo $frmSrch->getFormHtml(); ?>
</div>
<span class="gap"></span>
<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
	'op_invoice_number'	=>	Labels::getLabel('LBL_Invoice', $siteLangId),
	'afile_name'	=>	Labels::getLabel('LBL_File', $siteLangId),
	'downloadable_count'		=>	Labels::getLabel('LBL_Download_times', $siteLangId),
	'afile_downloaded_times'		=>	Labels::getLabel('LBL_Downloaded_Count', $siteLangId),
	'expiry_date'	=>	Labels::getLabel('LBL_Expired_on', $siteLangId),
	'action'	=>	Labels::getLabel('LBL_Action', $siteLangId),
);

$tbl = new HtmlElement('table', array('class'=>'table'));
$th = $tbl->appendElement('thead')->appendElement('tr',array('class' => ''));
foreach ($arr_flds as $val) {
	$e = $th->appendElement('th', array(), $val);
}

$sr_no = 0;
$canCancelOrder = true;
$canReturnRefund = true;
foreach ($digitalDownloads as $sn => $row){
	$sr_no++;
	$tr = $tbl->appendElement('tr',array( 'class' => '' ));
	
	foreach ($arr_flds as $key=>$val){
		$td = $tr->appendElement('td');
		switch ($key){
			case 'afile_name':
				if($row['downloadable']){
					$fileName = '<a href="'.CommonHelper::generateUrl('Buyer','downloadDigitalFile',array($row['afile_id'],$row['afile_record_id'])).'">'.$row['afile_name'].'</a>';
				}else{
					$fileName = $row['afile_name'];
				}
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$fileName,true);
			break;
			case 'downloadable_count':
				$downloadableCount = Labels::getLabel('LBL_N/A',$siteLangId) ;
				if($row['downloadable_count'] != -1){
					$downloadableCount = $row['downloadable_count'];
				}
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$downloadableCount,true);
			break;
			case 'expiry_date':
				$expiry = Labels::getLabel('LBL_N/A',$siteLangId) ;
				if($row['expiry_date']!=''){
					$expiry = FatDate::Format($row['expiry_date']);
				}
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$expiry,true);
			break;
			case 'action':
				$ul = $td->appendElement("ul",array("class"=>"actions"),'<span class="caption--td">'.$val.'</span>',true);				
				if($row['downloadable']){				
					$li = $ul->appendElement("li");
					$li->appendElement('a', array('href'=> CommonHelper::generateUrl('Buyer','downloadDigitalFile',array($row['afile_id'],$row['afile_record_id'])), 'class'=>'',
				'title'=>Labels::getLabel('LBL_View_Order',$siteLangId)),
				'<i class="fa fa-download"></i>', true);
				}
			break;
			default:
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$row[$key],true);
			break;
		}
	}
}
if (count($digitalDownloads) == 0){	
	$this->includeTemplate('_partial/no-record-found.php' , array('siteLangId'=>$siteLangId),false);
} else {
	echo $tbl->getHtml();
}

$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmSrchPaging') );
$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount, 'callBackJsFunc' => 'goToSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr,false);