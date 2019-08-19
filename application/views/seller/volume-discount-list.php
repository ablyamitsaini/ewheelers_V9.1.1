<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
    <div class="content-wrapper content-space">
        <div class="content-header  row justify-content-between mb-3">
            <div class="col-md-auto">
                <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Manage_Volume_Discount_Of_', $siteLangId); ?><b><?php echo $product_name; ?></b></h2>
            </div>
            <div class="col-auto">
                <div class="action">
                    <a class="btn btn--primary btn--sm" title="<?php echo Labels::getLabel('LBL_Add_Volume_Discount', $siteLangId); ?>" onclick="sellerProductVolumeDiscountForm(<?php echo $selprod_id; ?>, 0);" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Add_Volume_Discount', $siteLangId); ?></a>
                    <a class="btn btn--primary-border btn--sm formActionBtn-js formActions-css" title="<?php echo Labels::getLabel('LBL_Update_Volume_Discount', $siteLangId); ?>" onclick="updateVolumeDiscount()" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Update_Volume_Discount', $siteLangId); ?></a>
                    <a class="btn btn--primary btn--sm formActionBtn-js formActions-css" title="<?php echo Labels::getLabel('LBL_Remove_Volume_Discount', $siteLangId); ?>" onclick="deleteVolumeDiscount()" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Remove_Volume_Discount', $siteLangId); ?></a>
                    <div class="gap"></div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="cards">
                        <div class="cards-content pl-4 pr-4 pt-4">
                            <div id="listing">
                                <?php
                                $arr_flds = array(
                                    'select_all'=>Labels::getLabel('LBL_Select_all', $siteLangId),
                                    'listserial'=> Labels::getLabel('LBL_Sr.', $siteLangId),
                                    'voldiscount_min_qty' => Labels::getLabel('LBL_Minimum_Quantity', $siteLangId),
                                    'voldiscount_percentage' => Labels::getLabel('LBL_Percentage', $siteLangId),
                                    'action' => Labels::getLabel('LBL_Action', $siteLangId),
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
                                                $li = $ul->appendElement('li');
                                                $li->appendElement(
                                                    'a',
                                                    array('href' => 'javascript:void(0)', 'class'=>'', 'title'=>Labels::getLabel('LBL_Edit', $siteLangId), "onclick"=>"sellerProductVolumeDiscountForm(".$selprod_id.", ".$row['voldiscount_id'].")"),
                                                    '<i class="fa fa-edit"></i>',
                                                    true
                                                );

                                                $li = $ul->appendElement('li');
                                                $li->appendElement(
                                                    'a',
                                                    array('href'=>'javascript:void(0)', 'class'=>'',
                                                    'title'=>Labels::getLabel('LBL_Delete', $siteLangId),"onclick"=>"deleteSellerProductVolumeDiscount(".$row['voldiscount_id'].")"),
                                                    '<i class="fa fa-trash"></i>',
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
                                    $this->includeTemplate('_partial/no-record-found.php', array('adminLangId' => $siteLangId), false);
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
                          <span class="gap"></span>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
