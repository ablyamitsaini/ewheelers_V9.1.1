<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
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
                <section class="section">
                    <div class="sectionhead">
                        <h4><?php echo Labels::getLabel('LBL_Add_Special_Price', $adminLangId); ?> </h4>
                    </div>
                    <div class="sectionbody">
                        <div class="tablewrap" >
                            <div id="formListingSP-js">
                                <?php
                                foreach ($data as $counter => $value) {
                                    $selProdId = !empty($value['splprice_selprod_id']) ? $value['splprice_selprod_id'] : 0;
                                    $splPriceId = !empty($value['splprice_id']) ? $value['splprice_id'] : 0;
                                    $frm->setFormTagAttribute('id', 'frmSellerProductSpecialPrice-'.$selProdId);
                                    $frm->setFormTagAttribute('name', 'frmSellerProductSpecialPrice-'.$selProdId);
                                    $frm->setFormTagAttribute('data-splPriceId', $splPriceId);
                                    $tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table splPrice-'.$selProdId.'-js'));
                                    if (1 > $counter) {
                                        $th = $tbl->appendElement('thead')->appendElement('tr', array('class' => 'hide--mobile'));
                                        foreach ($arrFlds as $val) {
                                            $e = $th->appendElement('th', array(), $val);
                                        }
                                    }
                                    $frm->fill($value);
                                    $tr = $tbl->appendElement('tr', array('class' => 'selProdId-'.$selProdId));
                                    foreach ($arrFlds as $key => $val) {
                                        $td = $tr->appendElement('td');
                                        $fld = $frm->getField($key);
                                        if (!empty($fld)) {
                                            $fld->setFieldTagAttribute('class', 'selProdId-'.$selProdId);
                                        }
                                        switch ($key) {
                                            case 'product_name':
                                                if (!empty($value[$key])) {
                                                    $productName = $frm->getField('product_name');
                                                    $productName->setFieldTagAttribute('readonly', 'readonly');
                                                }
                                                $td->appendElement('plaintext', array(), $frm->getFieldHtml($key), true);
                                                break;
                                            case 'splprice_price':
                                                $splprice_price = $frm->getField('splprice_price');
                                                $splprice_price->setFieldTagAttribute('data-selprodid', $selProdId);
                                                $splprice_price->setFieldTagAttribute('data-splpriceid', $splPriceId);
                                                $td->appendElement('plaintext', array(), $frm->getFieldHtml($key), true);
                                                break;
                                            case 'splprice_start_date':
                                            case 'splprice_end_date':
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
                                    $frm->setFormTagAttribute('onsubmit', 'updateSpecialPrice(this, '.$selProdId.'); return(false);');

                                    echo $frm->getFormTag();

                                    $selProdIdFld = $frm->getField('splprice_selprod_id');
                                    $selProdIdFld->setFieldTagAttribute('class', 'selProdId-'.$selProdId);
                                    echo $frm->getFieldHtml('splprice_selprod_id');

                                    $splPriceIdFld = $frm->getField('splprice_id');
                                    $splPriceIdFld->setFieldTagAttribute('class', 'selProdId-'.$selProdId);
                                    echo $frm->getFieldHtml('splprice_id');
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
