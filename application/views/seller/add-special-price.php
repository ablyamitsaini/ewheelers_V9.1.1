<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
    <div class="content-wrapper content-space">
        <div class="content-header  row justify-content-between mb-3">
            <div class="col-md-auto">
                <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Add_Special_Price', $siteLangId); ?></h2>
            </div>
        </div>
        <div class="content-body">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="cards">
                        <div class="cards-content pt-4 pl-4 pr-4 pb-4">
                            <div class="replaced">
                                <?php
                                foreach ($data as $counter => $value) {
                                    $selProdId = !empty($value['splprice_selprod_id']) ? $value['splprice_selprod_id'] : 0;
                                    $splPriceId = !empty($value['splprice_id']) ? $value['splprice_id'] : 0;
                                    $frm->setFormTagAttribute('id', 'frmSellerProductSpecialPrice-'.$selProdId.'-'.$splPriceId);
                                    $frm->setFormTagAttribute('name', 'frmSellerProductSpecialPrice-'.$selProdId.'-'.$splPriceId);
                                    $tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table splPrice-'.$selProdId.'-'.$splPriceId.'-js'));
                                    if (1 > $counter) {
                                        $th = $tbl->appendElement('thead')->appendElement('tr', array('class' => 'hide--mobile'));
                                        foreach ($arrFlds as $val) {
                                            $e = $th->appendElement('th', array(), $val);
                                        }
                                    }
                                    $frm->fill($value);
                                    $tr = $tbl->appendElement('tr', array('class' => 'selProdId-'.$selProdId.'-'.$splPriceId));
                                    foreach ($arrFlds as $key => $val) {
                                        $td = $tr->appendElement('td');
                                        $fld = $frm->getField($key);
                                        if (!empty($fld)) {
                                            $fld->setFieldTagAttribute('class', 'selProdId-'.$selProdId.'-'.$splPriceId);
                                            $fld->setFieldTagAttribute('data-selprodid', $selProdId);
                                            $fld->setFieldTagAttribute('data-splpriceid', $splPriceId);
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
                                                $btnUpdate = $frm->getField('btn_update');
                                                $btnUpdate->setFieldTagAttribute('class', 'invisible');
                                                $td->appendElement('plaintext', array(), $frm->getFieldHtml('btn_update'), true);
                                                break;
                                        }
                                    }
                                    $frm->setFormTagAttribute('class', 'web_form last_td_nowrap');
                                    $frm->setFormTagAttribute('onsubmit', 'updateSpecialPrice(this, '.$selProdId.', '.$splPriceId.'); return(false);');
                                    $frm->addHiddenField('', 'edit', $edit);

                                    echo $frm->getFormTag();
                                    echo $frm->getFieldHtml('edit');

                                    $selProdIdFld = $frm->getField('splprice_selprod_id');
                                    $selProdIdFld->setFieldTagAttribute('class', 'selProdId-'.$selProdId.'-'.$splPriceId);
                                    echo $frm->getFieldHtml('splprice_selprod_id');

                                    $splPriceIdFld = $frm->getField('splprice_id');
                                    $splPriceIdFld->setFieldTagAttribute('class', 'selProdId-'.$selProdId.'-'.$splPriceId);


                                    echo $frm->getFieldHtml('splprice_id');
                                    echo $tbl->getHtml();
                                    echo $frm->getExternalJS();
                                    ?>
                                    </form> <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
