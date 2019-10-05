<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'web_form form_horizontal');
$frm->setFormTagAttribute('onsubmit', 'setupBanners(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;

$extUrlField = $frm->getField('banner_url');
$extUrlField->addFieldTagAttribute('placeholder', 'http://');
$extUrlField->setWrapperAttribute('class', 'bannerUrlFields bannerUrlField-'.Banner::URL_TYPE_EXTERNAL);

$shopUrlField = $frm->getField('urlTypeShop');
$shopUrlField->setWrapperAttribute('class', 'bannerUrlFields bannerUrlField-'.Banner::URL_TYPE_SHOP);

$prodUrlField = $frm->getField('urlTypeProduct');
$prodUrlField->setWrapperAttribute('class', 'bannerUrlFields bannerUrlField-'.Banner::URL_TYPE_PRODUCT);

$catUrlField = $frm->getField('urlTypeCategory');
$catUrlField->setWrapperAttribute('class', 'bannerUrlFields bannerUrlField-'.Banner::URL_TYPE_CATEGORY);

$brandUrlField = $frm->getField('urlTypeBrand');
$brandUrlField->setWrapperAttribute('class', 'bannerUrlFields bannerUrlField-'.Banner::URL_TYPE_BRAND);

$urlTargetField = $frm->getField('banner_target');
$urlTargetField->setWrapperAttribute('class', 'urlTargetField');
?>
<section class="section">
    <div class="sectionhead">
        <h4><?php echo Labels::getLabel('LBL_Banner_Setups', $adminLangId); ?></h4>
    </div>
    <div class="sectionbody space">
        <div class="row">
            <div class="col-sm-12">
                <div class="tabs_nav_container responsive flat">
                    <ul class="tabs_nav">
                        <li><a class="active" href="javascript:void(0)" onclick="bannerForm(<?php echo $blocation_id ?>,<?php echo $banner_id ?>);"><?php echo Labels::getLabel('LBL_General', $adminLangId); ?></a></li>
                        <?php $inactive = ($banner_id == 0)?'fat-inactive':'';
                        foreach ($languages as $langId => $langName) { ?>
                            <li class="<?php echo $inactive;?>"><a href="javascript:void(0);"
                                <?php if ($banner_id > 0) { ?>
                                    onclick="bannerLangForm(<?php echo $blocation_id ?>,<?php echo $banner_id ?>, <?php echo $langId;?>);"
                                <?php } ?>>
                                <?php echo Labels::getLabel('LBL_'.$langName, $adminLangId); ?></a></li>
                        <?php } ?>
                        <li class="<?php echo $inactive;?>"><a href="javascript:void(0)"
                            <?php if ($banner_id > 0) { ?>
                                onclick="mediaForm(<?php echo $blocation_id ?>,<?php echo $banner_id ?>);"
                            <?php }?>>
                            <?php echo Labels::getLabel('LBL_Media', $adminLangId); ?></a></li>
                    </ul>
                    <div class="tabs_panel_wrap">
                        <div class="tabs_panel"> <?php echo $frm->getFormHtml(); ?> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $("document").ready(function(){
        var URL_TYPE_EXTERNAL = <?php echo Banner::URL_TYPE_EXTERNAL; ?>;
        $("select[name='banner_url_type']").change(function(){
            var bannerUrlType = $(this).val();
            $(".bannerUrlFields").hide();
            $(".bannerUrlField-"+bannerUrlType).show();

            (URL_TYPE_EXTERNAL != bannerUrlType) ? $('.urlTargetField').hide() : $('.urlTargetField').show();
        });

        $("select[name='banner_url_type']").trigger('change');

        $("input[name='urlTypeProduct']").autocomplete({
            'source': function(request, response) {
                $.ajax({
                    url: fcom.makeUrl('SellerProducts', 'autoCompleteProducts'),
                    data: {keyword: request,fIsAjax:1},
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        response($.map(json, function(item) {
                            return { label: item['name'] ,    value: item['id']    };
                        }));
                    },
                });
            },
            'select': function(item) {
                $("input[name='urlTypeProduct']").val(item['label']);
                $("input[name='banner_url_value']").val(item['value']);
            }
        });

        $("input[name='urlTypeShop']").autocomplete({
            'source': function(request, response) {
                $.ajax({
                    url: fcom.makeUrl('Shops', 'autoComplete'),
                    data: { keyword: request, fIsAjax:1},
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        response($.map(json, function(item) {
                            return { label: item['name'] ,    value: item['id']    };
                        }));
                    },
                });
            },
            'select': function(item) {
                $("input[name='urlTypeShop']").val( item['label'] );
                $("input[name='banner_url_value']").val( item['value'] );
            }
        });

        $("select[name='urlTypeCategory']").change(function(){
            $("input[name='banner_url_value']").val($(this).val());
        });

        $("input[name='urlTypeBrand']").autocomplete({
            'source': function(request, response) {
                $.ajax({
                    url: fcom.makeUrl('Brands', 'autocomplete'),
                    data: {keyword: request,fIsAjax:1},
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        response($.map(json, function(item) {
                            return {label: item['name'] , value: item['id']};
                        }));
                    },
                });
            },
            'select': function( item ) {
                $("input[name='urlTypeBrand']").val( item['label'] );
                $("input[name='banner_url_value']").val( item['value'] );
            }
        });
    });
</script>
