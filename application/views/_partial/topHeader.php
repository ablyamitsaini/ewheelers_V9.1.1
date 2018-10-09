<div id="wrapper">
<!--header start here-->
<header id="header" class="no-print">
<div class="common_overlay"></div>
  <div class="top_bar">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-xs-6 hide--mobile ">
          <div class="slogan"><?php echo Labels::getLabel('L_Instant_Multi_Vendor_eCommerce_System_Builder',$siteLangId); ?></div>
        </div>
        <div class="col-lg-6 col-xs-12">
          <div class="short-links">
            <ul>
              <?php $this->includeTemplate('_partial/headerTopNavigation.php'); ?>
              <?php $this->includeTemplate('_partial/headerLanguageArea.php'); ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="main-bar">
    <div class="container">
      <?php $this->includeTemplate('_partial/headerNavigation.php'); ?>
      <?php $this->includeTemplate('_partial/headerUserArea.php'); ?>
      <div class="cart dropdown" id="cartSummary">
        <?php $this->includeTemplate('_partial/headerWishListAndCartSummary.php'); ?>
      </div>
    </div>
  </div>
</header>
<div class="after-header no-print"></div>

<!--header end here-->
<!--body start here-->
