<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
    <div class="content-wrapper content-space">
        <div class="content-header  row justify-content-between mb-3">
            <div class="col-md-auto">
                <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Add_Volume_Discount', $siteLangId); ?></h2>
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
                                                $btnUpdate = $frm->getField('btn_update');
                                                $btnUpdate->setFieldTagAttribute('class', 'invisible');
                                                $td->appendElement('plaintext', array(), $frm->getFieldHtml('btn_update'), true);
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
                </div>
            </div>
        </div>
    </div>
</main>
