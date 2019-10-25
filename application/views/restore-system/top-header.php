<div class="demo-header no-print">
    <div class="restore-wrapper">
        <a href="javascript:void(0)" onclick="showRestorePopup()">

            <p class="restore__content">Database Restore's in</p>
            <div class="restore__progress">
                <div class="restore__progress-bar" role="progressbar" style="width:25%" aria-valuenow="25"
                    aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
            <span class="restore__counter" id="restoreCounter">00:00:00</span>
        </a>
    </div>
    <ul class="switch-interface">
        <?php
        $admin = '';
        $mobileSite = '';
        $tabSite = '';
        $desktopSite = '';
        $adminUrl = 'admin';
        if ('SiteDemoController' == FatApp::getController()) {
            switch (FatApp::getAction()) {
                case 'mobile':
                    $mobileSite = 'is-active';
                    break;
                case 'tab':
                    $tabSite = 'is-active';
                    break;
            }
        } elseif (strpos($_SERVER ['REQUEST_URI'], rtrim(CONF_WEBROOT_BACKEND, '/')) !== false) {
            $admin = 'is-active';
            $adminUrl = '';
        } else {
            $desktopSite = 'is-active';
        }
        ?>

        <li class="<?php echo $admin; ?>">
            <a title="Admin"
                href="<?php echo CommonHelper::generateUrl($adminUrl); ?>">
                <i class="icn icn--admin">
                    <svg class="svg">
                        <use xlink:href="<?php echo CONF_WEBROOT_FRONTEND; ?>images/retina/sprite.svg#admin"
                            href="<?php echo CONF_WEBROOT_FRONTEND; ?>images/retina/sprite.svg#admin">
                        </use>
                    </svg>
                </i>
            </a>
        </li>
        <li class="<?php echo $desktopSite; ?>">
            <a title="Marketplace" 
                href="<?php echo CommonHelper::generateUrl('', '', array(), CONF_WEBROOT_FRONTEND); ?>">
                <i class="icn icn--desktop">
                    <svg class="svg">
                        <use xlink:href="<?php echo CONF_WEBROOT_FRONTEND; ?>images/retina/sprite.svg#desktop"
                            href="<?php echo CONF_WEBROOT_FRONTEND; ?>images/retina/sprite.svg#desktop">
                        </use>
                    </svg>
                </i>
            </a>
        </li>
        <!-- <li class="<?php echo $tabSite; ?>">
            <a title="Marketplace Tab View"
                href="<?php echo CommonHelper::generateUrl('SiteDemo', 'tab', array(), CONF_WEBROOT_FRONTEND); ?>">
                <i class="icn icn--tab">
                    <svg class="svg">
                        <use xlink:href="<?php echo CONF_WEBROOT_FRONTEND; ?>images/retina/sprite.svg#tab"
                            href="<?php echo CONF_WEBROOT_FRONTEND; ?>images/retina/sprite.svg#tab">
                        </use>
                    </svg>
                </i>
            </a>
        </li> -->
        <li class="<?php echo $mobileSite; ?>">
            <a title="Marketplace Mobile View"
                href="<?php echo CommonHelper::generateUrl('SiteDemo', 'mobile', array(), CONF_WEBROOT_FRONTEND); ?>">
                <i class="icn icn--mobile">
                    <svg class="svg">
                        <use xlink:href="<?php echo CONF_WEBROOT_FRONTEND; ?>images/retina/sprite.svg#mobile"
                            href="<?php echo CONF_WEBROOT_FRONTEND; ?>images/retina/sprite.svg#mobile">
                        </use>
                    </svg>
                </i>
            </a>
        </li>
    </ul>
    <div class="demo-cta">
        <a target="_blank" href="https://www.yo-kart.com/multivendor-ecommerce-marketplace-platform.html"
            class=" btn btn-primary ripplelink">Start Your Marketplace</a> &nbsp;
        <a href="javascript:void(0);" class="request-demo btn btn--primary-border  ripplelink" id="btn-demo">
            Request a Demo
        </a>
        <a href="javascript:void(0)" class="close-layer" id="demoBoxClose"></a>
    </div>
</div>