<style type="text/css">
.mfp-bg {
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: 100000;
	overflow: hidden;
	position: fixed;
	background: #0b0b0b;
	opacity: 0.8;
}

.mfp-wrap {
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: 100001;
	position: fixed;
	outline: none !important;
	-webkit-backface-visibility: hidden;
}

.mfp-container {
	text-align: center;
	position: absolute;
	width: 100%;
	height: 100%;
	left: 0;
	top: 0;
	padding: 0 8px;
	-webkit-box-sizing: border-box;
	box-sizing: border-box;
}

.mfp-container:before {
	content: '';
	display: inline-block;
	height: 100%;
	vertical-align: middle;
}

.mfp-align-top .mfp-container:before {
	display: none;
}

.mfp-content {
	position: relative;
	display: inline-block;
	vertical-align: middle;
	text-align: left;
	z-index: 10000;
	/*min-height: 300px !important;display:block;*/
	background: #FFF;
	padding: 20px;
	width: auto;
	max-width: 700px;
	min-width: 350px;
	margin: 20px auto;
}

.mfp-inline-holder .mfp-content,
.mfp-ajax-holder .mfp-content {
	width: 100%;
	cursor: auto;
}

.mfp-ajax-cur {
	cursor: progress;
}

.mfp-zoom-out-cur,
.mfp-zoom-out-cur .mfp-image-holder .mfp-close {
	cursor: -webkit-zoom-out;
	cursor: zoom-out;
}

.mfp-zoom {
	cursor: pointer;
	cursor: -webkit-zoom-in;
	cursor: zoom-in;
}

.mfp-auto-cursor .mfp-content {
	cursor: auto;
}

.mfp-close,
.mfp-arrow,
.mfp-preloader,
.mfp-counter {
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
}

.mfp-loading.mfp-figure {
	display: none;
}

.mfp-hide {
	display: none !important;
}

.mfp-preloader {
	color: #CCC;
	position: absolute;
	top: 50%;
	width: auto;
	text-align: center;
	margin-top: -0.8em;
	left: 8px;
	right: 8px;
	z-index: 1044;
}

.mfp-preloader a {
	color: #CCC;
}

.mfp-preloader a:hover {
	color: #FFF;
}

.mfp-s-ready .mfp-preloader {
	display: none;
}

.mfp-s-error .mfp-content {
	display: none;
}

button.mfp-close,
button.mfp-arrow {
	overflow: visible;
	cursor: pointer;
	background: transparent;
	border: 0;
	-webkit-appearance: none;
	display: block;
	outline: none;
	padding: 0;
	z-index: 1046;
	-webkit-box-shadow: none;
	box-shadow: none;
	-ms-touch-action: manipulation;
	touch-action: manipulation;
}

button::-moz-focus-inner {
	padding: 0;
	border: 0;
}

.mfp-close {
	width: 44px;
	height: 44px;
	line-height: 44px;
	position: absolute;
	right: 0;
	top: 0;
	text-decoration: none;
	text-align: center;
	opacity: 0.65;
	padding: 0 0 18px 10px;
	color: #FFF;
	font-style: normal;
	font-size: 28px;
	font-family: Arial, Baskerville, monospace;
}

.mfp-close:hover,
.mfp-close:focus {
	opacity: 1;
}

.mfp-close:active {
	top: 1px;
}

.mfp-close-btn-in .mfp-close {
	color: #333;
}

.mfp-image-holder .mfp-close,
.mfp-iframe-holder .mfp-close {
	color: #333;
	right: -6px;
	text-align: right;
	padding-right: 6px;
	width: 100%;
}

.mfp-counter {
	position: absolute;
	top: 0;
	right: 0;
	color: #CCC;
	font-size: 12px;
	line-height: 18px;
	white-space: nowrap;
}

.mfp-arrow {
	position: absolute;
	opacity: 0.65;
	margin: 0;
	top: 50%;
	margin-top: -55px;
	padding: 0;
	width: 90px;
	height: 110px;
	-webkit-tap-highlight-color: transparent;
}

.mfp-arrow:active {
	margin-top: -54px;
}

.mfp-arrow:hover,
.mfp-arrow:focus {
	opacity: 1;
}

.mfp-arrow:before,
.mfp-arrow:after {
	content: '';
	display: block;
	width: 0;
	height: 0;
	position: absolute;
	left: 0;
	top: 0;
	margin-top: 35px;
	margin-left: 35px;
	border: medium inset transparent;
}

.mfp-arrow:after {
	border-top-width: 13px;
	border-bottom-width: 13px;
	top: 8px;
}

.mfp-arrow:before {
	border-top-width: 21px;
	border-bottom-width: 21px;
	opacity: 0.7;
}

.mfp-arrow-left {
	left: 0;
}

.mfp-arrow-left:after {
	border-right: 17px solid #FFF;
	margin-left: 31px;
}

.mfp-arrow-left:before {
	margin-left: 25px;
	border-right: 27px solid #3F3F3F;
}

.mfp-arrow-right {
	right: 0;
}

.mfp-arrow-right:after {
	border-left: 17px solid #FFF;
	margin-left: 39px;
}

.mfp-arrow-right:before {
	border-left: 27px solid #3F3F3F;
}

.mfp-iframe-holder {
	padding-top: 40px;
	padding-bottom: 40px;
}

.mfp-iframe-holder .mfp-content {
	line-height: 0;
	width: 100%;
	max-width: 900px;
}

.mfp-iframe-holder .mfp-close {
	top: -40px;
}

.mfp-iframe-scaler {
	width: 100%;
	height: 0;
	overflow: hidden;
	padding-top: 56.25%;
}

.mfp-iframe-scaler iframe {
	position: absolute;
	display: block;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	-webkit-box-shadow: 0 0 8px rgba(0, 0, 0, 0.6);
	box-shadow: 0 0 8px rgba(0, 0, 0, 0.6);
	background: #000;
}

/* Main image in popup */
img.mfp-img {
	width: auto;
	max-width: 100%;
	height: auto;
	display: block;
	line-height: 0;
	-webkit-box-sizing: border-box;
	box-sizing: border-box;
	padding: 40px 0 40px;
	margin: 0 auto;
}

/* The shadow behind the image */
.mfp-figure {
	line-height: 0;
}

.mfp-figure:after {
	content: '';
	position: absolute;
	left: 0;
	top: 40px;
	bottom: 40px;
	display: block;
	right: 0;
	width: auto;
	height: auto;
	z-index: -1;
	-webkit-box-shadow: 0 0 8px rgba(0, 0, 0, 0.6);
	box-shadow: 0 0 8px rgba(0, 0, 0, 0.6);
	background: #444;
}

.mfp-figure small {
	color: #BDBDBD;
	display: block;
	font-size: 12px;
	line-height: 14px;
}

.mfp-figure figure {
	margin: 0;
}

.mfp-bottom-bar {
	margin-top: -36px;
	position: absolute;
	top: 100%;
	left: 0;
	width: 100%;
	cursor: auto;
}

.mfp-title {
	text-align: left;
	line-height: 18px;
	color: #F3F3F3;
	word-wrap: break-word;
	padding-right: 36px;
}

.mfp-image-holder .mfp-content {
	max-width: 100%;
}

.mfp-gallery .mfp-image-holder .mfp-figure {
	cursor: pointer;
}

@media screen and (max-width: 800px) and (orientation: landscape),
screen and (max-height: 300px) {

	/** * Remove all paddings around the image on small screen */
	.mfp-img-mobile .mfp-image-holder {
		padding-left: 0;
		padding-right: 0;
	}

	.mfp-img-mobile img.mfp-img {
		padding: 0;
	}

	.mfp-img-mobile .mfp-figure:after {
		top: 0;
		bottom: 0;
	}

	.mfp-img-mobile .mfp-figure small {
		display: inline;
		margin-left: 5px;
	}

	.mfp-img-mobile .mfp-bottom-bar {
		background: rgba(0, 0, 0, 0.6);
		bottom: 0;
		margin: 0;
		top: auto;
		padding: 3px 5px;
		position: fixed;
		-webkit-box-sizing: border-box;
		box-sizing: border-box;
	}

	.mfp-img-mobile .mfp-bottom-bar:empty {
		padding: 0;
	}

	.mfp-img-mobile .mfp-counter {
		right: 5px;
		top: 3px;
	}

	.mfp-img-mobile .mfp-close {
		top: 0;
		right: 0;
		width: 35px;
		height: 35px;
		line-height: 35px;
		background: rgba(0, 0, 0, 0.6);
		position: fixed;
		text-align: center;
		padding: 0;
	}
}

@media all and (max-width: 900px) {
	.mfp-arrow {
		-webkit-transform: scale(0.75);
		transform: scale(0.75);
	}

	.mfp-arrow-left {
		-webkit-transform-origin: 0;
		transform-origin: 0;
	}

	.mfp-arrow-right {
		-webkit-transform-origin: 100%;
		transform-origin: 100%;
	}

	.mfp-container {
		padding-left: 6px;
		padding-right: 6px;
	}
}


/* Demo button */
.fixed-demo-btn {
	line-height: 1.8;
	position: fixed;
	right: -100px;
	top: 300px;
	z-index: 10;
	background: var(--first-color);
	border-radius: 2px 2px 0px 0px;
	-webkit-transform: rotate(-90deg);
	transform: rotate(-90deg);
	display: block;
	height: 50px;
	width: 228px;
	color: #fff;
	font-size: 1.5em;
	/* font-weight: 600; */
	text-align: center;
}

.fixed-demo-btn #btn-demo {
	color: #fff;
	display: block;
}

.modal {
	background-color: white;
	border-radius: 0;
	display: none;
	max-height: calc(100% - 100px);
	position: fixed;
	top: 50%;
	left: 50%;
	right: auto;
	bottom: auto;
	-webkit-transform: translate(-50%, -50%);
	transform: translate(-50%, -50%);
	z-index: 990;
}

.modal.modal-is-visible {
	display: block;
	z-index: 1010;
}

.modal .modal-body {
	height: 100%;
}

/* .modal-overlay {
	background-color: rgba(0, 0, 0, 0.85);
	display: none;
	position: fixed;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	z-index: 980;
} */
.modal-overlay.modal-is-visible {
	display: block;
	z-index: 1009;
}

.crossed {
	z-index: 1;
	position: absolute;
	text-align: center;
	line-height: 18px;
	-webkit-transform: rotate(45deg);
	transform: rotate(45deg);
	position: absolute;
	top: 5px;
	right: 5px;
	padding: 0px;
	width: 30px;
	height: 30px;
}

.crossed:before {
	width: 1px;
	height: 30px;
	left: 50%;
	margin: 0 0 0 -1px;
	position: absolute;
	top: 0;
	content: "";
	background: #000;
}

.crossed:after {
	width: 30px;
	height: 1px;
	left: 0px;
	top: 50%;
	margin: -0px 0 0 0;
	position: absolute;
	content: "";
	background: #000;
}

.bg-modal {
	background: #fff url(./images/bg-dot.png) repeat 0 0;
	position: relative;
	padding-bottom: 50px;
}

.bg-modal:after {
	background: url(./images/floating-layer.png) no-repeat center bottom;
	position: absolute;
	bottom: 0;
	left: 0;
	right: 0;
	height: 131px;
	width: 100%;
	content: "";
}

.bg-modal:before {
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	height: 131px;
	width: 100%;
	content: "";
	background: rgb(255, 255, 255);
	background: -webkit-gradient(linear, left bottom, left top, from(rgba(255, 255, 255, 0)), to(rgba(255, 255, 255, 1)));
	background: linear-gradient(0deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#ffffff", endColorstr="#ffffff", GradientType=1);
}

.pop-logo {
	margin: 20px auto;
	text-align: center;
}

.pop-logo img {
	display: inline-block;
}

.get-started-wrapper {
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-align: center;
	-ms-flex-align: center;
	align-items: center;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
	position: relative;
	z-index: 1;
	margin-bottom: 50px;
}

.started-box {
	text-align: center;
	max-width: 350px;
	padding: 10px 50px;
	position: relative;
}

.started-box:first-child:after {
	background: #d9dade;
	width: 1px;
	height: 190px;
	content: "";
	position: absolute;
	top: 50%;
	right: 0;
	margin-top: -95px;
}

.illus {
	margin: 15px auto;
}

.illus img {
	display: inline-block;
}

.modal-content {
	position: relative;
	z-index: 1;
}

.modal-content .btn {
	min-width: 200px;
}

.modal-content .btn--primary {
	background: #ff4461;
	border: none;
	color: #fff;
}

.modal-content .btn--secondary {
	background: #1c8adb;
	border: none;
}

.view-packages {
	color: #000;
	font-size: 16px;
	font-weight: 400;
	background: url(./images/arrow-black.png) no-repeat right center;
	padding: 10px;
	padding-right: 35px;
}

@media only screen and (max-width:767px) {
	.modal {
		overflow-y: scroll;
	}

	.get-started-wrapper {
		-webkit-box-orient: vertical;
		-webkit-box-direction: normal;
		-ms-flex-direction: column;
		flex-direction: column;
	}
}

#facebox .content.faceboxWidth.requestdemo {
	padding: 0;
	width: 700px;
	min-width: 350px;
	min-height: 150px;
}

</style>

	<div class="modal-body bg-modal">
		<div class="">
			<div class="pop-logo"> <img src="https://demo.yo-kart.com/image/site_logo/2015-12-05.png" alt=""></div>
			<div class="get-started-wrapper">
				<div class="started-box">
					<div class="illus"><img src="<?php echo CONF_WEBROOT_URL; ?>images/get-started.png" alt=""></div>
					<p>I Really Liked The Features Of Yo!Kart And Want To Discuss My Project</p>
					<a href="https://www.yo-kart.com/contact-us.html" target="_blank" class="btn btn--primary">Get Started</a>
				</div>
				<div class="started-box">
					<div class="illus"><img src="<?php echo CONF_WEBROOT_URL; ?>images/free-demo.png" alt=""></div>
					<p>I Want To Learn More About The Product And Need A Personalized Live Demo</p>
					<a href="https://www.yo-kart.com/request-demo.html" target="_blank" class="btn btn--secondary">Book A Free Demo</a>
				</div>
			</div>
			<div class="align--center"> <a href="https://www.yo-kart.com/multivendor-marketplace-packages.html" target="_blank" class="view-packages">View Packages</a></div>
		</div>
	</div>
