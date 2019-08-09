<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class='page'>
    <div class='container container-fluid'>
        <div class="row">
            <div class="col-lg-12 col-md-12 space">
                <div class="page__title">
                    <div class="row">
                        <div class="col--first col-lg-6">
                            <span class="page__icon"><i class="ion-android-star"></i></span>
                            <h5><?php echo Labels::getLabel('LBL_Manage_Special_Price', $adminLangId); ?> </h5>
                            <?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
                        </div>
                    </div>
                </div>
                <!--<div class="col-sm-12">-->
                <section class="section">
                    <div class="sectionhead">
                        <h4><?php echo $product_name .' '. Labels::getLabel('LBL_Special_Price_List', $adminLangId); ?> </h4>
                        <?php
                        if ($canEdit) {
                            $ul = new HtmlElement("ul", array("class"=>"actions actions--centered"));
                            $li = $ul->appendElement("li", array('class'=>'droplink'));
                            $innerDiv=$li->appendElement('div', array('class'=>'dropwrap'));
                            $li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green','title'=>Labels::getLabel('LBL_Edit', $adminLangId)), '<i class="ion-android-more-horizontal icon"></i>', true);
                            $innerUl=$innerDiv->appendElement('ul', array('class'=>'linksvertical'));
                            $innerLi = $innerUl->appendElement('li');
                            $innerLi->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('LBL_Add_Special_Price', $adminLangId),"onclick"=>"sellerProductSpecialPriceForm(".$selprod_id.", 0);"), Labels::getLabel('LBL_Add_Special_Price', $adminLangId), true);

                            $innerLi = $innerUl->appendElement('li');
                            $innerLi->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('LBL_Update_Special_Price', $adminLangId),"onclick"=>"updateSpecialPrice();"), Labels::getLabel('LBL_Update_Special_Price', $adminLangId), true);
                        }
                            echo $ul->getHtml();
                        ?>
                    </div>
                    <div class="sectionbody">
                        <div class="tablewrap" >
                        <?php
                            $arr_flds = array(
                                'select_all'=>Labels::getLabel('LBL_Select_all', $adminLangId),
                                'listserial'=> Labels::getLabel('LBL_Sr.', $adminLangId),
                                'splprice_price' => Labels::getLabel('LBL_Special_Price', $adminLangId),
                                'splprice_start_date' => Labels::getLabel('LBL_Start_Date', $adminLangId),
                                'splprice_end_date' => Labels::getLabel('LBL_End_Date', $adminLangId),
                                'action' => Labels::getLabel('LBL_Action', $adminLangId),
                            );
                            $tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table'));
                            $th = $tbl->appendElement('thead')->appendElement('tr', array('class' => 'hide--mobile'));
                            foreach ($arr_flds as $key => $val) {
                                if ('select_all' == $key) {
                                    $th->appendElement('th')->appendElement('plaintext', array(), '<label class="checkbox"><input title="'.$val.'" type="checkbox" onclick="selectAll($(this))" class="selectAll-js"><i class="input-helper"></i></label>', true);
                                } else {
                                    $e = $th->appendElement('th', array(), $val);
                                }
                            }

                            $sr_no = 0;
                            foreach ($arrListing as $sn => $row) {
                                $sr_no++;
                                $tr = $tbl->appendElement('tr', array());

                                foreach ($arr_flds as $key => $val) {
                                    $td = $tr->appendElement('td');
                                    switch ($key) {
                                        case 'select_all':
                                            $td->appendElement('plaintext', array(), '<label class="checkbox"><input class="selectItem--js" type="checkbox" name="selprod_ids['.$row['splprice_id'].']" value='.$selprod_id.'><i class="input-helper"></i></label>', true);
                                            break;
                                        case 'listserial':
                                            $td->appendElement('plaintext', array(), ''.$sr_no, true);
                                            break;
                                        case 'splprice_price':
                                            $td->appendElement('plaintext', array(), ''.CommonHelper::displayMoneyFormat($row[$key]), true);
                                            break;
                                        case 'splprice_start_date':
                                            $td->appendElement('plaintext', array(), ''.FatDate::format($row[$key]), true);
                                            break;
                                        case 'splprice_end_date':
                                            $td->appendElement('plaintext', array(), ''.FatDate::format($row[$key]), true);
                                            break;
                                        case 'action':
                                            $ul = $td->appendElement("ul", array("class"=>"actions actions--centered"), '', true);
                                            $li = $ul->appendElement("li", array('class'=>'droplink'));
                                            $li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green','title'=>Labels::getLabel('LBL_Edit', $adminLangId)), '<i class="ion-android-more-horizontal icon"></i>', true);
                                            $innerDiv=$li->appendElement('div', array('class'=>'dropwrap'));
                                            $innerUl=$innerDiv->appendElement('ul', array('class'=>'linksvertical'));

                                            $innerLiEdit=$innerUl->appendElement('li');

                                            $innerLiEdit->appendElement(
                                                'a',
                                                array('href'=>'javascript:void(0)', 'class'=>'',
                                                'title'=>Labels::getLabel('LBL_Edit', $adminLangId),"onclick"=>"sellerProductSpecialPriceForm(".$selprod_id.", ".$row['splprice_id'].")"),
                                                Labels::getLabel('LBL_Edit', $adminLangId),
                                                true
                                            );

                                            $innerLiDelete=$innerUl->appendElement('li');
                                            $innerLiDelete->appendElement(
                                                'a',
                                                array('href'=>'javascript:void(0)', 'class'=>'',
                                                'title'=>Labels::getLabel('LBL_Delete', $adminLangId),"onclick"=>"deleteSellerProductSpecialPrice(".$row['splprice_id'].")"),
                                                Labels::getLabel('LBL_Delete', $adminLangId),
                                                true
                                            );
                                            break;
                                        default:
                                            $td->appendElement('plaintext', array(), ''.$row[$key], true);
                                            break;
                                    }
                                }
                            }
                            if (count($arrListing) == 0) {
                                // $tbl->appendElement('tr')->appendElement('td', array('colspan'=>count($arr_flds)), Labels::getLabel('LBL_No_Special_Price_added_to_this_product', $adminLangId));
                                $this->includeTemplate('_partial/no-record-found.php', array('adminLangId' => $adminLangId), false);
                            } else {
                                $frm = new Form('frmSplPriceListing', array('id'=>'frmSplPriceListing', 'target' => '_blank'));
                                $frm->setFormTagAttribute('class', 'web_form last_td_nowrap');
                                $frm->addHiddenField('', 'edit', 1);
                                echo $frm->getFormTag();
                                echo $frm->getFieldHtml('edit');
                                echo $tbl->getHtml();
                            } ?>
                                </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
