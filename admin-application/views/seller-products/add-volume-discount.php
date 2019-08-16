<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
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
                <section class="section">
                    <div class="sectionhead">
                        <h4><?php echo Labels::getLabel('LBL_Add_Volume_Discount', $adminLangId); ?> </h4>
                    </div>
                    <div class="sectionbody">
                        <div class="tablewrap" >
                            <div id="formListingSP-js">
                                <?php
                                foreach ($data as $counter => $value) {
                                    $selProdId = !empty($value['voldiscount_selprod_id']) ? $value['voldiscount_selprod_id'] : 0;
                                    $volDiscountId = !empty($value['voldiscount_id']) ? $value['voldiscount_id'] : 0;
                                    $frm->setFormTagAttribute('id', 'frmSellerProductVolumeDiscount-'.$selProdId.'-'.$volDiscountId);
                                    $frm->setFormTagAttribute('name', 'frmSellerProductVolumeDiscount-'.$selProdId.'-'.$volDiscountId);
                                    $tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table volDiscount-'.$selProdId.'-'.$volDiscountId.'-js'));
                                    if (1 > $counter) {
                                        $th = $tbl->appendElement('thead')->appendElement('tr', array('class' => 'hide--mobile'));
                                        foreach ($arrFlds as $val) {
                                            $e = $th->appendElement('th', array(), $val);
                                        }
                                    }
                                    $frm->fill($value);
                                    $tr = $tbl->appendElement('tr', array('class' => 'selProdId-'.$selProdId.'-'.$volDiscountId));
                                    foreach ($arrFlds as $key => $val) {
                                        $td = $tr->appendElement('td');
                                        $fld = $frm->getField($key);
                                        if (!empty($fld)) {
                                            $fld->setFieldTagAttribute('class', 'selProdId-'.$selProdId.'-'.$volDiscountId);
                                            $fld->setFieldTagAttribute('data-selprodid', $selProdId);
                                            $fld->setFieldTagAttribute('data-voldiscountid', $volDiscountId);
                                        }
                                        switch ($key) {
                                            case 'product_name':
                                                if (!empty($value[$key])) {
                                                    $productName = $frm->getField('product_name');
                                                    $productName->setFieldTagAttribute('readonly', 'readonly');
                                                }
                                                $td->appendElement('plaintext', array(), $frm->getFieldHtml($key), true);
                                                break;
                                            case 'voldiscount_min_qty':
                                                $td->appendElement('plaintext', array(), $frm->getFieldHtml($key), true);
                                                break;
                                            case 'voldiscount_percentage':
                                                $volDiscountPerc = $frm->getField('voldiscount_percentage');
                                                $volDiscountPerc->setFieldTagAttribute('data-selprodid', $selProdId);
                                                $volDiscountPerc->setFieldTagAttribute('data-voldiscountid', $volDiscountId);
                                                $td->appendElement('plaintext', array(), $frm->getFieldHtml($key), true);
                                                break;
                                            case 'action':
                                                if ($canEdit) {
                                                    $btnUpdate = $frm->getField('btn_update');
                                                    $btnUpdate->setFieldTagAttribute('class', 'invisible');
                                                    $td->appendElement('plaintext', array(), $frm->getFieldHtml('btn_update'), true);
                                                }
                                                break;
                                        }
                                    }
                                    $frm->setFormTagAttribute('class', 'web_form last_td_nowrap');
                                    $frm->setFormTagAttribute('onsubmit', 'updateVolumeDiscount(this, '.$selProdId.', '.$volDiscountId.'); return(false);');
                                    $frm->addHiddenField('', 'edit', $edit);

                                    echo $frm->getFormTag();
                                    echo $frm->getFieldHtml('edit');

                                    $selProdIdFld = $frm->getField('voldiscount_selprod_id');
                                    $selProdIdFld->setFieldTagAttribute('class', 'selProdId-'.$selProdId.'-'.$volDiscountId);
                                    echo $frm->getFieldHtml('voldiscount_selprod_id');

                                    $volDiscountIdFld = $frm->getField('voldiscount_id');
                                    $volDiscountIdFld->setFieldTagAttribute('class', 'selProdId-'.$selProdId.'-'.$volDiscountId);


                                    echo $frm->getFieldHtml('voldiscount_id');
                                    echo $tbl->getHtml();
                                    echo $frm->getExternalJS();
                                    ?>
                                    </form> <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
