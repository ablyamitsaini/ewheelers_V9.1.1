<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class='page'>
    <div class='container container-fluid'>
        <div class="row">
            <div class="col-lg-12 col-md-12 space">
                <div class="page__title">
                    <div class="row">
                        <div class="col--first col-lg-6">
                            <span class="page__icon"><i class="ion-android-star"></i></span>
                            <h5><?php echo Labels::getLabel('LBL_Manage_Volume_Discount', $adminLangId); ?> </h5>
                            <?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
                        </div>
                    </div>
                </div>
                <!--<div class="col-sm-12">-->
                <section class="section">
                    <div class="sectionhead">
                        <h4><?php echo $product_name .' '. Labels::getLabel('LBL_Volume_Discount_List', $adminLangId); ?> </h4>
                        <?php
                        if ($canEdit) {
                            $ul = new HtmlElement("ul", array("class"=>"actions actions--centered"));
                            $li = $ul->appendElement("li", array('class'=>'droplink'));
                            $innerDiv=$li->appendElement('div', array('class'=>'dropwrap'));
                            $li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green','title'=>Labels::getLabel('LBL_Edit', $adminLangId)), '<i class="ion-android-more-horizontal icon"></i>', true);
                            $innerUl=$innerDiv->appendElement('ul', array('class'=>'linksvertical'));
                            $innerLi = $innerUl->appendElement('li');
                            $innerLi->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('LBL_Add_Volume_Discount', $adminLangId),"onclick"=>"sellerProductVolumeDiscountForm(".$selprod_id.", 0);"), Labels::getLabel('LBL_Add_Volume_Discount', $adminLangId), true);

                            $innerLi = $innerUl->appendElement('li');
                            $innerLi->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('LBL_Update_Volume_Discount', $adminLangId),"onclick"=>"updateVolumeDiscount();"), Labels::getLabel('LBL_Update_Volume_Discount', $adminLangId), true);

                            $innerLi = $innerUl->appendElement('li');
                            $innerLi->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('LBL_Delete_Volume_Discount', $adminLangId),"onclick"=>"deleteVolumeDiscount();"), Labels::getLabel('LBL_Delete_Volume_Discount', $adminLangId), true);
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
                                'voldiscount_min_qty' => Labels::getLabel('LBL_Minimum_Quantity', $adminLangId),
                                'voldiscount_percentage' => Labels::getLabel('LBL_Percentage', $adminLangId),
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
                                            $td->appendElement('plaintext', array(), '<label class="checkbox"><input class="selectItem--js" type="checkbox" name="selprod_ids['.$row['voldiscount_id'].']" value='.$selprod_id.'><i class="input-helper"></i></label>', true);
                                            break;
                                        case 'listserial':
                                            $td->appendElement('plaintext', array(), ''.$sr_no, true);
                                            break;
                                        case 'voldiscount_min_qty':
                                            $td->appendElement('plaintext', array(), ''.$row[$key], true);
                                            break;
                                        case 'voldiscount_percentage':
                                            $td->appendElement('plaintext', array(), ''.$row[$key].'%', true);
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
                                                'title'=>Labels::getLabel('LBL_Edit', $adminLangId),"onclick"=>"sellerProductVolumeDiscountForm(".$selprod_id.", ".$row['voldiscount_id'].")"),
                                                Labels::getLabel('LBL_Edit', $adminLangId),
                                                true
                                            );

                                            $innerLiDelete=$innerUl->appendElement('li');
                                            $innerLiDelete->appendElement(
                                                'a',
                                                array('href'=>'javascript:void(0)', 'class'=>'',
                                                'title'=>Labels::getLabel('LBL_Delete', $adminLangId),"onclick"=>"deleteSellerProductVolumeDiscount(".$row['voldiscount_id'].")"),
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
                                $this->includeTemplate('_partial/no-record-found.php', array('adminLangId' => $adminLangId), false);
                            } else {
                                $frm = new Form('frmVolDiscountListing', array('id'=>'frmVolDiscountListing', 'target' => '_blank'));
                                $frm->setFormTagAttribute('class', 'web_form last_td_nowrap');
                                $frm->addHiddenField('', 'edit', 1);
                                echo $frm->getFormTag();
                                echo $frm->getFieldHtml('edit');
                                echo $tbl->getHtml(); ?>
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
