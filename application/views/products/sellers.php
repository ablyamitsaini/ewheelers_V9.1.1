<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
?> <div id="body" class="body">

    <div class="bg--second pt-3 pb-3">
      <div class="container container--fixed">
        <div class="row align-items-center">
          <div class="col-md-8">
                <div class="prod-info">
                        
                        <div class="prod-info__left">
                            <div class="product-avtar"><a title="<?php echo $product['selprod_title'];?>" href="<?php echo CommonHelper::generateUrl('products', 'view', array($product['selprod_id']));?>"><img alt=""
                            src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image', 'product', array($product['product_id'], "SMALL", $product['selprod_id'], 0, $siteLangId), CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg'); ?>"></a>
                            </div>
                        </div>
                        <div class="prod-info__right">
                            <div class="avtar__info">
                                <h6><a title="<?php echo $product['selprod_title'];?>" href="<?php echo CommonHelper::generateUrl('products', 'view', array($product['selprod_id']));?>"><?php echo $product['selprod_title'];?></a></h6>
                                <?php if (round($product['prod_rating'])>0  && FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) {
                                    ?> <div class="products-reviews"><span class="rate"><i class="icn"><svg class="svg">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow"></use>
                            </svg> </i><?php echo round($product['prod_rating'], 1); ?></span> </div> <?php
                            } ?>
                        </div>
                    </div>
                    
                </div>
               
          </div>
          
    </div>
  </div>
</div>

    
    
    
    <section class="section">
        <div class="container">
           <h1><?php echo Labels::getLabel('LBL_All_Sellers', $siteLangId);?></h1>
            <div class=""> <?php
            $arr_flds = array(
                'shop_name'    =>    Labels::getLabel('LBL_Seller', $siteLangId),
                'theprice'    =>    Labels::getLabel('LBL_Price', $siteLangId),
                'COD'    =>    Labels::getLabel('LBL_COD_AVAILABLE', $siteLangId),
                'viewDetails'    =>    '',
                'Action'    =>    '',

            );
            $tbl = new HtmlElement('table', array('class'=>'table table--orders'));
            $th = $tbl->appendElement('thead')->appendElement('tr', array('class' => ''));
            foreach ($arr_flds as $val) {
                $e = $th->appendElement('th', array(), $val);
            }

            $sr_no = 0;
            foreach ($product['moreSellersArr'] as $sn => $moresellers) {
                $sr_no++;

                $tr = $tbl->appendElement('tr', array('class' =>'' ));

                foreach ($arr_flds as $key => $val) {
                    $td = $tr->appendElement('td');
                    switch ($key) {
                        case 'shop_name':
                        $txt = '<div class="ftshops "><div class="ftshops_name"><a title="'.$moresellers[$key].'" href="'.CommonHelper::generateUrl('shops', 'view', array($moresellers['shop_id'])).'">';
                        $txt .= $moresellers[$key];
                        $txt .= '</a></div><a href="'.CommonHelper::generateUrl('shops', 'view', array($moresellers['shop_id'])).'"><div class="ftshops_location">'.$moresellers['shop_state_name'].",".$moresellers['shop_country_name'].'</div></a></div>';
                        if (isset($product['rating'][$moresellers['selprod_user_id']]) && $product['rating'][$moresellers['selprod_user_id']]>0) {
                            $txt.='<div class="products-reviews"><span class="rate"><i class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="14.854px" height="14.166px" viewBox="0 0 14.854 14.166" enable-background="new 0 0 14.854 14.166" xml:space="preserve">
                                  <path d="M14.854,5.49c0-0.268-0.286-0.375-0.5-0.41L9.873,4.428L7.864,0.367C7.784,0.197,7.632,0,7.427,0
                                    C7.222,0,7.07,0.197,6.989,0.367L4.981,4.428L0.5,5.08C0.277,5.115,0,5.223,0,5.49c0,0.16,0.116,0.313,0.223,0.429l3.249,3.159
                                    l-0.768,4.464c-0.009,0.063-0.018,0.116-0.018,0.179c0,0.232,0.116,0.445,0.375,0.445c0.125,0,0.241-0.043,0.357-0.106l4.008-2.106
                                    l4.008,2.106c0.107,0.063,0.232,0.106,0.357,0.106c0.259,0,0.366-0.213,0.366-0.445c0-0.063,0-0.116-0.009-0.179l-0.768-4.464
                                    l3.241-3.159C14.737,5.803,14.854,5.65,14.854,5.49z"></path>
                                  </svg> </i>'.round($product['rating'][$moresellers['selprod_user_id']], 1).'</span> </div>';
                            }
                        $td->appendElement('plaintext', array(), $txt, true);
                            break;

                        case 'theprice':
                         $txt = ' <div class="item-yk"><div class="product_price">'.CommonHelper::displayMoneyFormat($moresellers['theprice']);
                              if ($moresellers['special_price_found']) {
                                  $txt.='  <span class="product_price_old">'.CommonHelper::displayMoneyFormat($moresellers['selprod_price']).'</span>
                              <div class="product_off">'.CommonHelper::showProductDiscountedText($moresellers, $siteLangId).'</div>';
                              }
                              $txt .='</div></div>';
                              $td->appendElement('plaintext', array(), $txt, true);
                            break;
                        case 'COD':
                            $codAvailableTxt = Labels::getLabel('LBL_N/A', $siteLangId);;
                                if (!empty($product['cod'][$moresellers['selprod_user_id']]) && $product['cod'][$moresellers['selprod_user_id']]) {
                                    $codAvailableTxt = Labels::getLabel('LBL_Cash_on_delivery_available', $siteLangId);
                                }
                              $td->appendElement('plaintext', array(), $codAvailableTxt, true);
                            break;
                        case 'viewDetails':
                                $td->appendElement(
                                    'a',
                                    array('href'=>CommonHelper::generateUrl('products', 'view', array($moresellers['selprod_id'])), 'class'=>'link--arrow','title'=>Labels::getLabel('LBL_View_Details', $siteLangId),true),
                                    Labels::getLabel('LBL_View_Details', $siteLangId),
                                    true
                                );
                            break;

                        case 'Action':
                            if (date('Y-m-d', strtotime($moresellers['selprod_available_from'])) <=  FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d')) {
                                $txt ='<div class="align--right"> <a data-id="'.$moresellers['selprod_id'].'" data-min-qty="'.$moresellers['selprod_min_order_qty'].'"  href="javascript:void(0)" class="btn btn--primary btn--sm ripplelink block-on-mobile btnProductBuy--js">  '.Labels::getLabel('LBL_Buy_Now', $siteLangId).'</a> <a data-id="'.$moresellers['selprod_id'].'" data-min-qty="'.$moresellers['selprod_min_order_qty'].'"  href="javascript:void(0)" class="btn btn--primary-border btn--sm ripplelink block-on-mobile btnAddToCart--js">  '.Labels::getLabel('LBL_Add_To_Cart', $siteLangId).'</a> </div>';
                            } else {
                                $txt = str_replace('{available-date}', FatDate::Format($moresellers['selprod_available_from']), Labels::getLabel('LBL_This_item_will_be_available_from_{available-date}', $siteLangId));
                            }
                            $td->appendElement('plaintext', array(), $txt, true);

                            break;

                        default:
                            $td->appendElement('plaintext', array(), $moresellers[$key], true);
                            break;
                    }
                }
            }

    echo $tbl->getHtml();

?> </div>
        </div>
        <div class="gap"></div>
    </section>
</div>
