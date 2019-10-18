<div class="demo-header no-print">
    <div class="restore-wrapper">
        <a href="javascript:void(0)" onclick="showRestorePopup()">
		<p class="restore__content">Database Will Restore in</p>
            <span class="restore__counter" id="restoreCounter">00:00:00</span>                        
        </a>
    </div>
    <ul class="switch-interface">
        <li><a href="<?php echo CommonHelper::generateUrl('admin');?>"><i class="icn icn--admin">
                    <svg class="svg">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#admin" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#admin"></use>
                    </svg>
                </i></a></li>
       <?php /* ?> <li class="is-active"><a href="javascript:void(0)" onClick="setDemoLayout(360)"><i class="icn icn--desktop">
                    <svg class="svg">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#desktop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#desktop"></use>
                    </svg>
                </i></a></li>
        <li><a href="javascript:void(0);" onClick="setDemoLayout(360)"><i class="icn icn--mobile">
                    <svg class="svg">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#mobile" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#mobile"></use>
                    </svg>
                </i></a></li> <?php  */?>
    </ul>    
    <div class="demo-cta">
        <a target="_blank" href="https://www.yo-kart.com/multivendor-ecommerce-marketplace-platform.html" class="btn btn--primary-border ripplelink btn--sm">Start Your Marketplace</a> &nbsp;		
		<a href="javascript:void(0);" class="request-demo btn btn--secondary ripplelink btn--sm" id="btn-demo" >Request a Demo</a>
        <!-- <a href="javascript:void(0)" class="close-layer"></a> -->
    </div>	
</div>