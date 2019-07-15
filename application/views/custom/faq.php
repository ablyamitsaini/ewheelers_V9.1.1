<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body">
    <div class="bg--second pt-5 pb-5">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6">
                    <div class="section-head section--white--head section--head--center mb-0">
                        <div class="section__heading">
                            <h2>Frequently Asked Questions</h2>
                        </div>

                    </div>
                    <div class="faqsearch">
                        <input class="faq-input no-focus" type="text" placeholder="Search" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="section bg--white">
        <div class="container">




            <div class="row">
                <?php if ($recordCount > 0) { ?>
                <div class="col-lg-6 col-md-6">
                    <div id="listing"></div>
                </div>
                <div class="col-lg-6 col-md-6 ">
                    <h3><?php echo Labels::getLabel('LBL_Browse_By_Category', $siteLangId)?></h3>
                    <div id="categoryPanel"></div>
                </div>
                <?php } else { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <div id="listing"></div>
                    <div class="gap"> </div>
                </div>
                <?php }?>
            </div>

            <div class="gap"></div>
            <div class="divider"></div>
            <div class="align--center pt-5">
                <h3><?php echo Labels::getLabel('LBL_Still_need_help', $siteLangId)?> ?</h3>
                <a href="<?php echo CommonHelper::generateUrl('custom', 'contact-us'); ?>" class="btn btn--secondary"><?php echo Labels::getLabel('LBL_Contact_Customer_Care', $siteLangId)?> </a>
            </div>


        </div>
    </section>

    <div class="container container--fixed">
       <div class="row">
           <div class="container container--fluid">

               <div class="panel panel--grids panel--grids-even">
                   <div class="grid__left fixed__panel">
                      <div id="fixed__panel">
                           <div class="box box--white" id="categoryPanel">
                           </div>
                       </div>
                   </div>
                    <div class="grid__right">
                       <h2><?php echo Labels::getLabel('Lbl_Frequently_Asked_Questions', $siteLangId); ?></h2>
                       <ul class="breadcrumbs clearfix">
                           <li><a href="<?php echo CONF_WEBROOT_URL; ?>"><?php echo Labels::getLabel('Lbl_Home', $siteLangId); ?></a></li>
                           <li><?php echo Labels::getLabel('Lbl_Frequently_Asked_Questions', $siteLangId); ?></li>
                       </ul>
                       <?php if (!empty($cpages)) { ?>
                       <div class="grid grid--onefourth">
                           <h4>For Immediate Self-help</h4>
                           <?php if (!empty($cpages)) { ?>
                            <ul>
                            <?php foreach ($cpages as $cpage) { ?>
                               <li><a href="<?php echo CommonHelper::generateUrl('Cms', 'view', array($cpage['cpage_id'])); ?>" class="btn btn--secondary btn--block"><?php echo $cpage['cpage_identifier']; ?></a></li>
                               <?php } ?>
                           </ul>
                           <?php } ?>

                       </div>
                       <?php } ?>
                        <div class="container--faqs">
                           <?php
                            $frm->setFormTagAttribute('id', 'frmSearchFaqs');
                            $frm->setFormTagAttribute('onSubmit', 'searchFaqs(this);return false;');
                            $frm->getField('question')->setFieldTagAttribute('placeholder', Labels::getLabel('Lbl_Search_within', $siteLangId));
                            echo $frm->getFormTag(); ?>
                               <label class="field_label"><?php echo Labels::getLabel('Lbl_Enter_Your_Question', $siteLangId); ?></label>
                                <div class="search search--sort">
                                    <div class="search__field">
                                    <?php echo $frm->getFieldHtml('question') , $frm->getFieldHtml('btn_submit'); ?>

                                        <i class="fa fa-search"></i>
                                    </div>
                                </div>
                            </form>
                            <?php echo $frm->getExternalJs(); ?>
                            <div id="listing"></div>
                            <span class="gap"></span>
                        </div>
                    </div>
               </div>

            </div>
        </div>
    </div>

</div>
<script>
    var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?>';
    var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS', $siteLangId); ?>';
</script>


<script>
    var clics = 0;

    $(document).ready(function() {

        $('.faqanswer').hide();
        $('#faqcloseall').hide();

        $('h3').click(function() {

            $(this).next('.faqanswer').toggle(function() {

                $(this).next('.faqanswer');

            }, function() {

                $(this).next('.faqanswer').fadeIn('fast');

            });

            if ($(this).hasClass('faqclose')) {
                $(this).removeClass('faqclose');
            } else {
                $(this).addClass('faqclose');
            };

            if ($('.faqclose').length >= 3) {

                $('#faqcloseall').fadeIn('fast');

            } else {
                $('#faqcloseall').hide();
                var yolo = $('.faqclose').length
                console.log(yolo);
            }
        }); //Close Function Click

    }); //Close Function Ready

    $('#faqcloseall').click(function() {
        $('.faqanswer').fadeOut(200);
        $('h3').removeClass('faqclose');
        $('#faqcloseall').fadeOut('fast');
    });

    //search box

    $(function() {
        $('.faq-input').keyup(function() {
            // Get user input from search box
            var filter_text = $(this).val();
            // If user input is not null
            if (filter_text) {
                $('.faqlist h3').each(function() {
                    // If user input matches this item in the list, show this item
                    if ($(this).text().toLowerCase().indexOf(filter_text) >= 0) {
                        $(this).parent().slideDown();
                    }
                    // If user input doesn't match this item in the list, hide this item
                    else {
                        $(this).parent().slideUp();
                    }
                })
                // If user input is null
            } else {
                $('.faqlist li').slideDown();
            }
        });
    });
</script>
