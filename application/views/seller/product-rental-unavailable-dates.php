<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<div class="tabs tabs--small tabs--scroll clearfix">
    <?php require_once('sellerCatalogProductTop.php');?>
</div>
<div class="cards">
<?php if (count($arrListing) > 0) { ?>
    <div class="cards-header p-4">
        <h5 class="cards-title"><?php echo Labels::getLabel('LBL_Rental_Unavailable_Dates', $siteLangId);?></h5>
        <div class="action">
            <a class="btn btn--primary btn--sm" href="javascript:void(0); " onClick="productRentalUnavailableDatesForm(<?php echo $selprod_id; ?>, 0);"><?php echo Labels::getLabel('LBL_Add_Date', $siteLangId)?></a>
        </div>
    </div>
<?php } ?>
<div class="cards-content pl-4 pr-4 ">
    <div class="row">
        <div class="<?php echo (count($arrListing) > 0) ? 'col-md-8' : 'col-md-12' ;?>">
            <div class="form__subcontent">
                <?php
                    $arr_flds = array(
						'listserial' => Labels::getLabel('LBL_Sr.', $siteLangId),
						'pu_start_date' => Labels::getLabel('LBL_Start_date', $siteLangId),
						'pu_end_date' => Labels::getLabel('LBL_End_Date', $siteLangId),
						'pu_quantity' => Labels::getLabel('LBL_Unavailable_Quantity', $siteLangId),
						'action' => Labels::getLabel('LBL_Action', $siteLangId),
                    );
                    $tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table table--orders'));
                    $th = $tbl->appendElement('thead')->appendElement('tr', array('class' => ''));
                    foreach ($arr_flds as $val) {
                        $e = $th->appendElement('th', array(), $val);
                    }

                    $sr_no = 0;
                    foreach ($arrListing as $sn => $row) {
                        $sr_no++;
                        $tr = $tbl->appendElement('tr', array());
                        foreach ($arr_flds as $key => $val) {
                            $td = $tr->appendElement('td');
                            switch ($key) {
                                case 'listserial':
                                    $td->appendElement('plaintext', array(), $sr_no, true);
                                    break;
                                case 'action':
                                    $ul = $td->appendElement("ul", array("class"=>"actions"), '', true);
                                    $li = $ul->appendElement("li");
                                    $li->appendElement('a', array('href' => 'javascript:void(0)', 'class'=>'', 'title'=>Labels::getLabel('LBL_Edit', $siteLangId), "onclick"=>"productRentalUnavailableDatesForm(".$selprod_id.", ".$row['pu_id'].")"), '<i class="fa fa-edit"></i>', true);
                                    $li = $ul->appendElement("li");
                                    $li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'', 'title'=>Labels::getLabel('LBL_Delete', $siteLangId), "onclick"=>"deleteRentalUnavailableDates(".$row['pu_id'].")"), '<i class="fa fa-trash"></i>', true);
                                    break;
                                default:
                                    $td->appendElement('plaintext', array(), $row[$key], true);
                                    break;
                            }
                        }
                    }

                    if (count($arrListing) == 0) {
                        $message = Labels::getLabel('LBL_No_Unavailable_dates_added_yet', $siteLangId);
                        $linkArr = array(
                        0 => array(
							'href' => 'javascript:void(0);',
							'label' => Labels::getLabel('LBL_Add_Unavailable_Dates', $siteLangId),
							'onClick' => 'productRentalUnavailableDatesForm('.$selprod_id.', 0);',
                        )
                        );
                        $this->includeTemplate('_partial/no-record-found.php', array('siteLangId'=>$siteLangId,'linkArr'=>$linkArr,'message'=>$message));
                    }else{
                        echo $tbl->getHtml();
                    } ?>
            </div>
        </div>
    </div>
</div>
</div>
