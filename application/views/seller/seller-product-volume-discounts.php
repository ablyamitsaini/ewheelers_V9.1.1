<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<div class="cards-header p-4">
    <h5 class="cards-title"><?php echo $productCatalogName; ?></h5>
    <div class="action">
        <a class="btn btn--primary btn--sm" href="javascript:void(0); " onClick="sellerProductVolumeDiscountForm(<?php echo $selprod_id; ?>, 0);"><?php echo Labels::getLabel('LBL_Add_New_Volume_Discount', $siteLangId)?></a>
    </div>
</div>
<div class="cards-content pl-4 pr-4 ">
    <div class="tabs tabs--small   tabs--scroll clearfix">
        <?php require_once('sellerCatalogProductTop.php');?>
    </div>
    <div class="tabs__content form">
        <div class="form__content">
            <div class="<?php echo (count($arrListing) > 0) ? 'col-md-6' : 'col-md-12' ;?>">
                <div class="form__subcontent">
                    <?php
                        $arr_flds = array(
                        'listserial'=> Labels::getLabel('LBL_Sr.', $siteLangId),
                        'voldiscount_min_qty' => Labels::getLabel('LBL_Minimum_Quantity', $siteLangId),
                        'voldiscount_percentage' => Labels::getLabel('LBL_Discount', $siteLangId).' (%)',
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
                                        $li->appendElement('a', array('href' => 'javascript:void(0)', 'class'=>'', 'title'=>Labels::getLabel('LBL_Edit', $siteLangId), "onclick"=>"sellerProductVolumeDiscountForm(".$selprod_id.", ".$row['voldiscount_id'].")"), '<i class="fa fa-edit"></i>', true);
                                        $li = $ul->appendElement("li");
                                        $li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'', 'title'=>Labels::getLabel('LBL_Delete', $siteLangId), "onclick"=>"deleteSellerProductVolumeDiscount(".$row['voldiscount_id'].")"), '<i class="fa fa-trash"></i>', true);
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
                                        $td->appendElement('plaintext', array(), $row[$key], true);
                                        break;
                                }
                            }
                        }
                        if (count($arrListing) == 0) {
                            $message = Labels::getLabel('LBL_No_any_volume_discount_on_this_product', $siteLangId);
                            $linkArr = array(
                            0=>array(
                            'href'=>'javascript:void(0);',
                            'label'=>Labels::getLabel('LBL_Add_New_Volume_Discount', $siteLangId),
                            'onClick'=>'sellerProductVolumeDiscountForm('.$selprod_id.', 0);',
                            )
                            );
                            $tbl->appendElement('tr')->appendElement('td', array('colspan'=>count($arr_flds), 'class'=>'text-center'), Labels::getLabel('LBL_No_record_found', $siteLangId));
                        }
                        echo $tbl->getHtml(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
