<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$slideFrm->setFormTagAttribute('class', 'web_form form_horizontal');
$slideFrm->setFormTagAttribute('onsubmit', 'setup(this); return(false);');
$slideFrm->developerTags['colClassPrefix'] = 'col-md-';
$slideFrm->developerTags['fld_default_col'] = 12;

$slide_identifier = $slideFrm->getField('slide_identifier');
$slide_identifier->setUnique('tbl_slides', 'slide_identifier', 'slide_id', 'slide_id', 'slide_id');

$extUrlField = $slideFrm->getField('slide_url');
$extUrlField->addFieldTagAttribute('placeholder', 'http://');
$extUrlField->setWrapperAttribute('class', 'slideUrlFields slideUrlField-'.Slides::URL_TYPE_EXTERNAL);

$shopUrlField = $slideFrm->getField('urlTypeShop');
$shopUrlField->setWrapperAttribute('class', 'slideUrlFields slideUrlField-'.Slides::URL_TYPE_SHOP);

$prodUrlField = $slideFrm->getField('urlTypeProduct');
$prodUrlField->setWrapperAttribute('class', 'slideUrlFields slideUrlField-'.Slides::URL_TYPE_PRODUCT);

$catUrlField = $slideFrm->getField('urlTypeCategory');
$catUrlField->setWrapperAttribute('class', 'slideUrlFields slideUrlField-'.Slides::URL_TYPE_CATEGORY);

$brandUrlField = $slideFrm->getField('urlTypeBrand');
$brandUrlField->setWrapperAttribute('class', 'slideUrlFields slideUrlField-'.Slides::URL_TYPE_BRAND);

$urlTargetField = $slideFrm->getField('slide_target');
$urlTargetField->setWrapperAttribute('class', 'urlTargetField');

?>
<section class="section">
    <div class="sectionhead">
        <h4><?php echo Labels::getLabel('LBL_Slide_Setup', $adminLangId); ?></h4>
    </div>
    <div class="sectionbody space">
        <div class="row">
            <div class="col-sm-12">
                <div class="tabs_nav_container responsive flat">
                    <ul class="tabs_nav">
                        <li><a class="active" href="javascript:void(0)" onclick="slideForm(<?php echo $slide_id ?>);"><?php echo Labels::getLabel('LBL_General', $adminLangId); ?></a></li>
                        <?php $inactive = ($slide_id == 0) ? 'fat-inactive' : '';
                        foreach ($languages as $langId => $langName) { ?>
                            <li class="<?php echo $inactive; ?>"><a href="javascript:void(0);"
                                <?php if ($slide_id > 0) {
                                    ?> onclick="slideLangForm(<?php echo $slide_id ?>, <?php echo $langId; ?>);" <?php
                                } ?>>
                                <?php echo Labels::getLabel('LBL_'.$langName, $adminLangId); ?></a></li>
                        <?php } ?>
                            <li class="<?php echo $inactive;?>">
                                <a href="javascript:void(0)"
                                    <?php if ($slide_id > 0) { ?>
                                        onclick="slideMediaForm(<?php echo $slide_id ?>);"
                                    <?php } ?> >
                                    <?php echo Labels::getLabel('LBL_Media', $adminLangId); ?>
                                </a>
                            </li>
                        </ul>
                        <div class="tabs_panel_wrap">
                            <div class="tabs_panel">
                                <?php echo $slideFrm->getFormHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        $("document").ready(function(){
            var URL_TYPE_EXTERNAL = <?php echo Slides::URL_TYPE_EXTERNAL; ?>;
            $("select[name='slide_url_type']").change(function(){
                var slideUrlType = $(this).val();
                $(".slideUrlFields").hide();
                $(".slideUrlField-"+slideUrlType).show();

                (URL_TYPE_EXTERNAL != slideUrlType) ? $('.urlTargetField').hide() : $('.urlTargetField').show();
            });

            $("select[name='slide_url_type']").trigger('change');

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
                    $("input[name='slide_url_value']").val(item['value']);
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
                    $("input[name='slide_url_value']").val( item['value'] );
                }
            });

            $("select[name='urlTypeCategory']").change(function(){
                $("input[name='slide_url_value']").val($(this).val());
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
                    $("input[name='slide_url_value']").val( item['value'] );
                }
            });
        });
    </script>
