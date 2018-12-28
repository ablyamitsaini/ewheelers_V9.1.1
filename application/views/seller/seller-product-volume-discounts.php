<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<div class="box__head box__head--large">
   <h4><?php echo $productCatalogName; ?></h4>
	<div class="group--btns">
		<a class="btn btn--primary btn--sm" href="javascript:void(0); " onClick="sellerProductVolumeDiscountForm(<?php echo $selprod_id; ?>, 0);"><?php echo Labels::getLabel( 'LBL_Add_New_Volume_Discount', $siteLangId)?></a>
	</div>
</div>
<div class="box__body">
	<div class="tabs tabs--small tabs--offset tabs--scroll clearfix">
		<?php require_once('sellerCatalogProductTop.php');?>
	</div>
	<div class="tabs__content form">
		<div class="form__content">
			<div class="form__subcontent">
			<?php
			$arr_flds = array(
				'listserial'=> Labels::getLabel( 'LBL_Sr.', $siteLangId ),
				'voldiscount_min_qty' => Labels::getLabel( 'LBL_Minimum_Quantity', $siteLangId ),
				'voldiscount_percentage' => Labels::getLabel( 'LBL_Discount', $siteLangId ).' (%)',
				'action'	=>	Labels::getLabel('LBL_Action', $siteLangId),
			);
			$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table'));
			$th = $tbl->appendElement('thead')->appendElement('tr',array('class' => ''));
			foreach ($arr_flds as $val) {
				$e = $th->appendElement('th', array(), $val);
			}

			$sr_no = 0;
			foreach ($arrListing as $sn => $row){
				$sr_no++;
				$tr = $tbl->appendElement('tr',array());

				foreach ($arr_flds as $key=>$val){
					$td = $tr->appendElement('td');
					switch ($key){
						case 'listserial':
							$td->appendElement('plaintext', array(), $sr_no,true);
						break;
						case 'action':
							$ul = $td->appendElement("ul",array("class"=>"actions"),'',true);
							$li = $ul->appendElement("li");
							$li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'',
							'title'=>Labels::getLabel('LBL_Edit',$siteLangId),"onclick"=>"sellerProductVolumeDiscountForm(".$selprod_id.", ".$row['voldiscount_id'].")"),
							'<i class="fa fa-edit"></i>', true);

							$li = $ul->appendElement("li");
							$li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'',
							'title'=>Labels::getLabel( 'LBL_Delete', $siteLangId ),"onclick"=>"deleteSellerProductVolumeDiscount(".$row['voldiscount_id'].")"),
							'<i class="fa fa-trash"></i>', true);
						break;
						/* case 'splprice_price':
							$td->appendElement( 'plaintext', array(), CommonHelper::displayMoneyFormat($row[$key]),true );
						break;
						case 'splprice_start_date';
							$td->appendElement( 'plaintext', array(), FatDate::format($row[$key]),true );
						break;
						case 'splprice_end_date';
							$td->appendElement( 'plaintext', array(), FatDate::format($row[$key]),true );
						break;
						 */
						default:
							$td->appendElement('plaintext', array(), $row[$key],true);
						break;
					}
				}
			}
			if (count($arrListing) == 0){
				$message = Labels::getLabel('LBL_No_any_volume_discount_on_this_product', $siteLangId);
				$linkArr = array(
					0=>array(
					'href'=>'javascript:void(0);',
					'label'=>Labels::getLabel('LBL_Add_New_Volume_Discount', $siteLangId),
					'onClick'=>'sellerProductVolumeDiscountForm('.$selprod_id.', 0);',
					)
				);
				$this->includeTemplate('_partial/no-record-found.php' , array('siteLangId'=>$siteLangId,'linkArr'=>$linkArr,'message'=>$message));
				/* $this->includeTemplate('_partial/no-record-found.php',array('siteLangId' => $siteLangId),false); */
			}
			else{
				echo $tbl->getHtml();
			}
			?>
			</div>
		</div>
	</div>
</div>
