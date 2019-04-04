<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

$frmSrch->setFormTagAttribute('onSubmit','searchBuyerDownloadLinks(this); return false;');
$frmSrch->setFormTagAttribute('class', 'form');
$frmSrch->developerTags['colClassPrefix'] = 'col-md-';
$frmSrch->developerTags['fld_default_col'] = 12;

$submitBtnFld = $frmSrch->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class','btn--block');
$submitBtnFld->setWrapperAttribute('class','col-sm-6');
$submitBtnFld->developerTags['col'] = 2;

$clearFld = $frmSrch->getField('btn_clear');
$clearFld->setFieldTagAttribute('onclick','clearSearch(1)');

$cancelBtnFld = $frmSrch->getField('btn_clear');
$cancelBtnFld->setFieldTagAttribute('class','btn--block');
$cancelBtnFld->setWrapperAttribute('class','col-sm-6');
$cancelBtnFld->developerTags['col'] = 2;
?>
<div class="bg-gray-light p-3 pb-0">
	<?php echo $frmSrch->getFormHtml(); ?>
</div>
<span class="gap"></span>
<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
	'op_invoice_number'	=>	Labels::getLabel('LBL_Invoice', $siteLangId),
	'opddl_downloadable_link'	=>	Labels::getLabel('LBL_Link', $siteLangId),
	'downloadable_count'		=>	Labels::getLabel('LBL_Download_times', $siteLangId),
	'opddl_downloaded_times'		=>	Labels::getLabel('LBL_Downloaded_Count', $siteLangId),
	'expiry_date'	=>	Labels::getLabel('LBL_Expired_on', $siteLangId),
);

$tbl = new HtmlElement('table', array('class'=>'table'));
$th = $tbl->appendElement('thead')->appendElement('tr',array('class' => ''));
foreach ($arr_flds as $val) {
	$e = $th->appendElement('th', array(), $val);
}

$sr_no = 0;
$canCancelOrder = true;
$canReturnRefund = true;
foreach ($digitalDownloadLinks as $sn => $row){
	$sr_no++;
	$tr = $tbl->appendElement('tr',array( 'class' => '' ));

	foreach ($arr_flds as $key=>$val){
		$td = $tr->appendElement('td');
		switch ($key){
			case 'opddl_downloadable_link':
				/* $link = ($row['downloadable']!=1) ? Labels::getLabel('LBL_N/A',$siteLangId) : $row['opddl_downloadable_link'];
				$linkUrl = ($row['downloadable']!=1) ? 'javascript:void(0)' : $row['opddl_downloadable_link'];
				$linkOnClick = ($row['downloadable']!=1) ? '' : 'increaseDownloadedCount('.$row['opddl_link_id'].')';
				$linkTitle = ($row['downloadable']!=1) ? '' : Labels::getLabel('LBL_Click_to_download',$siteLangId);

				$td->appendElement('a', array('href'=> $linkUrl, 'class'=>'', 'title'=>$linkTitle, 'onClick'=>$linkOnClick),
				$link, true); */
				if($row['downloadable']!=1){
					$td->appendElement('plaintext', array(), Labels::getLabel('LBL_N/A',$siteLangId), true);
				}else{
					$ul = $td->appendElement("ul",array("class"=>"actions"),'',true);
					
					$li = $ul->appendElement("li");
					$li->appendElement('a', array('href'=> $row['opddl_downloadable_link'], 'class'=>'',
					'title'=>Labels::getLabel('LBL_Click_to_open',$siteLangId)),
					'<i class="fa fa-download"></i>', true);

					/* $li = $ul->appendElement("li");
					$li->appendElement('a', array('href'=> 'javascript:void(0)', 'id'=>'dataLink', 'data-link'=>$row['opddl_downloadable_link'], 'onclick'=>'copyToClipboard(this)',
					'title'=>Labels::getLabel('LBL_copy_to_clipboard',$siteLangId)),
					'<i class="fa fa-copy"></i>', true); */
				}
			break;
			case 'downloadable_count':
				$downloadableCount = Labels::getLabel('LBL_N/A',$siteLangId) ;
				if($row['downloadable_count'] != -1){
					$downloadableCount = $row['downloadable_count'];
				}
				$td->appendElement('plaintext', array(), $downloadableCount,true);
			break;
			case 'expiry_date':
				$expiry = Labels::getLabel('LBL_N/A',$siteLangId) ;
				if($row['expiry_date']!=''){
					$expiry = FatDate::Format($row['expiry_date']);
				}
				$td->appendElement('plaintext', array(), $expiry,true);
			break;
			default:
				$td->appendElement('plaintext', array(), $row[$key],true);
			break;
		}
	}
}
if (count($digitalDownloadLinks) == 0){
	$this->includeTemplate('_partial/no-record-found.php' , array('siteLangId'=>$siteLangId),false);
} else {
	echo $tbl->getHtml();
}

$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmSrchPaging') );
$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount, 'callBackJsFunc' => 'goToLinksSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr,false);

?>
<script>
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($('#dataLink').attr("data-link")).select();
  document.execCommand("copy");
  $temp.remove();
  alert('<?php echo Labels::getLabel('LBL_Your_link_is_copied_to_clipboard',$siteLangId); ?>');
}
</script>
