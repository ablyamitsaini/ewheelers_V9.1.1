<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$this->includeTemplate('restore-system/top-header.php');
?>

<main role="main" id="main">
    <div class="device-preview">
        <div class="device-preview__container <?php echo $deviceClass; ?>">
            <div class="device-preview__content">
                <iframe class="device-preview__iframe"
                    src="<?php echo CommonHelper::generateFullUrl(); ?>"
                    scrolling="yes" frameborder="0"
                    width="<?php echo $width; ?>"
                    height="<?php echo $height; ?>">
                </iframe>
            </div>
        </div>
    </div>
</main>