// Russell Hobbs I Heart Home
// BUILD VERSION: 0.2

// Config Vars
var _fbAppID = 549385165194725;
//var _fbAppID = 745990165439756;
//var _appURL = "https://rh-i-heart-home.proofing5.brayleino.co.uk/";

//var _appURL = "https://en.russellhobbs.com/";
//var _webserviceURL = "https://en.russellhobbs.com/image_upload.html?mechanicID=1&action=ajax_submit";
//var _unsupportedURL = "/unsupported.html";
//var _submitFormThankyouURL = "http://en.russellhobbs.com/image_upload.html?mechanicID=1&action=success";
//var _facebookImageHandlerFile = "https://en.russellhobbs.com/imageproxy.php";
//var _fbRedirectPath = "https://en.russellhobbs.com/image_upload.html?mechanicID=1";

//var _termsConditionsTitle = 'Terms and conditions';
//var _compFormTitle = 'Enter the competition';
//var _tellUsAboutItTitle = 'Tell us about it';
//var _pickPhotoTitle = 'Pick a photo';
//var _cropItTitle = 'Crop it';
//var _chooseFilterTitle = 'Choose a filter';
//var _compFormBtnText = 'Enter competition';
//var _chooseFilterBtnText = 'Continue';
//var _compMechanicURL = "/image_upload.html?mechanicID=1";
//var _fbProfilePicAlt = 'Facebook photo';

//var _errorSendEntry = "Sorry there was an issue\nwith your entry.\n\nPlease try again later.";
//var _errorPostAjax = "Sorry there was an issue\nconnecting to the server.\n\nPlease try again later.";
//var _errorUploadFormat = "\n\nIncompatible image file.\nPlease select again.";
//var _errorImageTooLarge = "Sorry!\nThat image is too large.\nPlease select a\nsmaller image.";
//var _errorReadingFile = "Sorry there was an issue\nreading this file.\n\nPlease try another.";
//var _errorConnectingFacebook = "Sorry there was an issue\nconnecting to Facebook.\n\nPlease try again later.";
//var _errorfbNoPhotos = "We are unable to find any Facebook images at this time. Please go back and choose from another option.";

var _preloadHeartEmbedImg = "../../../images/custom/ihearthome/mechanic/heartEmbed.png";
var _preloadCropFrameImg = "../../../images/custom/ihearthome/mechanic/crop-frame.png";

var _flashFileSelectorPath = "flash/fileselector.swf";
var _fbChannelFile = "channel.php";
// Config Vars

// Fall back Base 64 encoding
if (!window.btoa) window.btoa = base64.encode
if (!window.atob) window.atob = base64.decode

// App vars
var _lastMouseDown = 0;
var _tickerFPS = 14;
var _canvas, _stage, _container, _preloader, _loadManifest, _text1, _text2;
var _wrapperDiv;
var _cropItOverlay;
var _stageWidth = 300;
var _stageHeight = 300;

// Image
var _fileInput, _fileReader, _fileFilter;
var _fileInputField, _cameraInputField;
var _editImg;
var _maxImgData = 10000000;
var _imgGuideRect = { x: 0, y: 0, width: 315, height: 315 };
var _maxImgSize = _imgGuideRect.width * 2;
var _scaleInc;
var _imgMask;
var _zoomIntv;
var _heartImg;
var _startDragPt = { x: 0, y: 0 };
var _editImgPt = { x: 0, y: 0 };
var _timeout;
var _saving = false;
var _jpgData = "";
var _encodeQuality = 100;
var _timeout;
var _cropFrameImg;
var _cropImgX = 0;
var _cropImgY = 0;
var _textYOffset = 0;

//filter images
var _filterImg;
var _imagefilters;
var _filterImgData;

// Facebook
var _fbLoggedIn = false;
var _fbUID = "";
var _fbAccessToken = "";
var _fbName = "";
var _fbEmail = "";
var _fbButtonActivated = false;
var _fbButtonClicked = false;
var _fbLoadingAlbumPhotos = false;

// Form
var _currentForm;
var _filterDirection = { back: "back", cont: "cont" };

// Browser Specific
var _navUserAgent = navigator.userAgent.toLowerCase();
var _isiPhone = _navUserAgent.indexOf("iphone") > -1;
var _isiPad = _navUserAgent.indexOf("ipad") > -1;
var _isAndroid = _navUserAgent.indexOf("android") > -1;
var _ieMobile = _navUserAgent.indexOf("iemobile") > -1;
var _iOSVer = 1000;
var _androidVer = 1000;
var _verIndex = 0;
var _supportedBrowser = true;
var _isMobile = false

var _imgCanvas = document.createElement("canvas");
var _imgCanvasCtx;

window.fbAsyncInit = function () {
    $(document).ready(function () {
        browserSupport();

        if (_supportedBrowser) {
            initApp();
        }
        else {
            gotoURL(_unsupportedURL);
        }
    });
};

function browserSupport() {
    if (_isiPhone || _isiPad || _isAndroid || _ieMobile) {
        _isMobile = true;
    }
    if (_isiPhone || _isiPad) {
        _verIndex = _navUserAgent.indexOf("os ");
        _iOSVer = Number(_navUserAgent.substring(_verIndex + 3, _verIndex + 4));
    }
    else if (_isAndroid) {
        _verIndex = _navUserAgent.indexOf("android ");
        _androidVer = Number(_navUserAgent.substring(_verIndex + 8, _verIndex + 9));
    }

	if (!_imgCanvas.getContext || _ieMobile || (_iOSVer < 6) || (_androidVer < 3)) {
        _supportedBrowser = false;
    }
}

function initApp() {
    if (_isiPhone) {
        $('head meta[name=viewport]').remove();
        $('head').prepend('<meta name="viewport" content="width=device-width, initial-scale=0.5, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">');
    }

    _imgCanvasCtx = _imgCanvas.getContext("2d");
    _wrapperDiv = document.getElementById("wrapper");
    _canvas = document.getElementById("canvas");

    _fileInputField = document.getElementById("fileInput");
    if (_isiPad) _fileInputField.style.visibility = "visible";

    _cameraInputField = document.getElementById("cameraInput");
    if (_isiPad) _cameraInputField.style.visibility = "visible";

    _stage = new createjs.Stage(_canvas);
    _container = new createjs.Container();

    _cropItOverlay = new createjs.Container();

    if (!createjs.Touch.isSupported()) {
        _stage.enableMouseOver(10);
    }

    //createjs.Touch.enable(_stage);
    createjs.Ticker.setFPS(_tickerFPS);
    _stage.addChild(_container);
	
    _loadManifest = [{ src: _preloadHeartEmbedImg, id: "heartEmbed" },
						{ src: _preloadCropFrameImg, id: "cropFrame" }
    ];

    _preloader = new createjs.LoadQueue(false);
    _preloader.on("complete", onInitAssetsLoaded);
    _preloader.loadManifest(_loadManifest);

    setBreadcrumb();
    loadImageFilters();
}

function onInitAssetsLoaded() {
    viewsInit();
    _stage.on("stagemousedown", onStageMouseDown);
    createjs.Ticker.on("tick", onTickEvent);
    initFbAPI();
}

function setBreadcrumb(step) {
    var breadcrumbEl = $("ul.breadcrumb");
    var bcNum = 1;

    if (typeof step === 'undefined') { step = 'none'; }
    var items = breadcrumbEl.children().length;

    switch (step) {
        case '1':
            bcNum = 1;
            break;
        case '2':
        case 'tell-us-about':
            bcNum = 2;
            break;
        case '3':
        case 'crop-it':
            bcNum = 3;
            break;
        case '4':
        case 'filter-it':
            bcNum = 4;
            break;
        case '5':
        case 'entry-form':
            bcNum = 5;
            break;
    }

    if (bcNum <= items) {
        $("ul.breadcrumb li").removeClass("selected"); //remove all
        for (var i = 0; i <= bcNum; i++) {
            $("ul.breadcrumb li:nth-child(" + i + ")").addClass("selected");
        }
    }

}

function viewsInit() {

	if (!window.FileReader)
	{
		$('#btn-choose-file').hide();
		
		var swfVersionStr = "0";
		var xiSwfUrlStr = "";
		var flashvars = {};
		var params = {};
		params.quality = "high";
		params.bgcolor = "#ffffff";
		params.allowscriptaccess = "sameDomain";
		var attributes = {};
		attributes.id = "fallbackInput";
		attributes.name = "fallbackInput";
		attributes.align = "middle";
		swfobject.embedSWF(
			_flashFileSelectorPath, "flashUploadImage", "488", "92", swfVersionStr, xiSwfUrlStr, flashvars, params, attributes);
		
		$('#flashUploadImage').show();
	}
	
    $(_fileInputField).on("change", function (e) {
        _fileInput = _fileInputField;
        onFileInputEvent();
    });

    $('#btn-choose-file').bind('click', function (e) {
        _fileInputField.click();
    });

    $(_cameraInputField).on("change", function (e) {
        _fileInput = _cameraInputField;
        onFileInputEvent();
    });

    $('#btn-take-photo').bind('click', function (e) {
        if (!_isMobile) {
            changeSlide("take-photo");
        } else {
            _cameraInputField.click();
        }
    });

    $('#btn-form-back').bind('click', function (e) {
        formBack();
    });
	
	$('#btn-fb-back').bind('click', function (e) {
        window.location.replace(_compMechanicURL);
    });
	
    $('#btn-webcam-back').bind('click', function (e) {
        formLoadPick();
    });

    $('#btn-find-fb-photo').bind('click', function (e) {
        if (_fbButtonActivated) {
            _fbButtonClicked = true;
            if (_fbLoggedIn) {
                changeSlide("fb-photo");
                loadFBGallery();
            }
            else {
                onFbConnBtnClick();
            }
        }
    });

    $('#btn-lets-go').bind('click', function (e) {
        formLoadPick();
    });

    $('#btn-form-continue').bind('click', function (e) {
        if ($('#rhForm').valid()) {
            formContinue();
        }
    });

    $('#link-terms-conditions').bind('click', function (e) {
        changeSlide('terms-conditions');
        changeText(_termsConditionsTitle);
    });

    $('#btn-close-tsandcs').bind('click', function (e) {
        changeSlide('canvas');
        changeText(_compFormTitle);
    });

    adustImageControls();
	
	formLoadPick();
}

function changeText(titletxt, btntxt) {
    if (typeof titletxt != "undefined" || titletxt != null || titletxt != '') $('h1').text(titletxt);
    if (typeof btntxt != "undefined" || btntxt != null || btntxt != '') $('#btn-form-continue').text(btntxt);
}

function adustImageControls() {
    $('#btn-rotate').on("mousedown", rotateImg);
    $('#btn-rotate').on("mouseup", rotateImg);

    $('#btn-zoom-in').on("mousedown", zoomInImg);
    $('#btn-zoom-in').on("mouseup", zoomInImg);

    $('#btn-zoom-out').on("mousedown", zoomOutImg);
    $('#btn-zoom-out').on("mouseup", zoomOutImg);

    $('#btn-textpos').on("mousedown", textPosUpImg);
}

function rotateImg(evt) {
    clearInterval(_zoomIntv);
    if (evt.type == "mousedown") {
        rotate();
        _zoomIntv = setInterval(rotate, 400);
    }
    function rotate() {
        _editImg.rotation += 90;
    }
}

function zoomInImg(evt) {
    clearInterval(_zoomIntv);
    if (evt.type == "mousedown") {
        zoomIn();
        _zoomIntv = setInterval(zoomIn, 200);
    }
    function zoomIn() {
        _editImg.scaleX = _editImg.scaleY = (Number(_editImg.scaleX) + Number(_scaleInc)).toFixed(2);
    }
}

function zoomOutImg(evt) {
    clearInterval(_zoomIntv);
    if (evt.type == "mousedown") {
        zoomOut();
        _zoomIntv = setInterval(zoomOut, 200);
    }
    function zoomOut() {
        _editImg.scaleX = _editImg.scaleY = (Number(_editImg.scaleX) - Number(_scaleInc)).toFixed(2);
    }
}

function textPosUpImg(evt) {

    $(this).toggleClass('is-bottom');

    if (evt.type == "mousedown") {
        textPos();
    }
    function textPos() {
        var newYpos = (222 - _textYOffset);
        if (_text1.y - newYpos < 0) {
            newYpos = -(222 - _textYOffset);
        }
        _text1.y = _text1.y - newYpos;
        _text2.y = _text2.y - newYpos;
        _heartImg.y = _heartImg.y - newYpos;
    }
}

// Nav Slide and Forms
function scrollTop() {
    window.scrollTo(0, 0);
}

function formContinue() {
    scrollTop();
    if (_currentForm == "tell-us-about") {
        formLoadCropIt();
    } else if (_currentForm == "crop-it") {
        formLoadFilterIt(_filterDirection.cont);
    } else if (_currentForm == "filter-it") {
        formLoadEntryForm();
    } else if (_currentForm == "entry-form") {
		saveComposedImg();
    }
}

function formBack() {
    if (_currentForm == "tell-us-about") {
		window.location.replace(_compMechanicURL);
    } else if (_currentForm == "crop-it") {
        initTellUsAbout();
    } else if (_currentForm == "filter-it") {
        formLoadCropIt();
    } else if (_currentForm == "entry-form") {
        formLoadFilterIt(_filterDirection.back);
    }
}

function initTellUsAbout() {
	
	disableStageTouch();

    changeText(_tellUsAboutItTitle);
    setBreadcrumb("2");
    changeForm("tell-us-about");
    ctrlContainerClasses('col from-med');
}

function changeForm(stepName) {
    _currentForm = stepName;
    setBreadcrumb(stepName);

    $('.form-step').hide();
    $('.form-step.form-' + stepName).show();
}

function changeSlide(slideName) {
    $('section.comp-slide').hide();
    $('section.comp-slide.slide-' + slideName).show();
}

function formLoadPick() {
    clearSelectedImg();
    setBreadcrumb('1');
    changeText(_pickPhotoTitle);
    changeSlide("pick");
}

function formLoadCropIt() {
    if (typeof _cropItOverlay != "undefined" || _cropItOverlay != null) {
        _container.removeChild(_cropItOverlay);
        _cropItOverlay.removeAllChildren();
    }

	createjs.Touch.enable(_stage);
	
    removeImageFilter();
	
	$('#btn-textpos').removeClass('is-bottom');

    _stage.canvas.width = _imgGuideRect.width;
    _stage.canvas.height = _imgGuideRect.height;

    if (_cropImgX != 0 || _cropImgY != 0) {
        _editImg.y += _cropImgY;
        _editImg.x += _cropImgX;
        _cropItOverlay.x += 7;
        _cropImgY = 0;
        _cropImgX = 0;
    }

    _editImg.on("mousedown", onEditImgMouseEvent);
    _editImg.on("pressup", onEditImgMouseEvent);
    _editImg.on("pressmove", onEditImgMouseEvent);
	
	var txtWhatYouLove = $("#txtWhatYouLove").val().replace(/(\w{18})(?=\w)/g, '$1 ');
	
    _text1 = new createjs.Text($("#txtName").val(), "24px Gotham, Arial, Bold", "#FFFFFF");
    _text2 = new createjs.Text(txtWhatYouLove, "24px Gotham, Arial, Bold", "#FFFFFF");

    _text1.shadow = new createjs.Shadow("#000000", 0, 1, 10);
    _text2.shadow = new createjs.Shadow("#000000", 0, 1, 10);
	_text2.lineWidth = 270;

    _text1.x = _text2.x = 20;
    _text1.y = 239;
    _text2.y = 269;
	
	var textLineHeight = 25;
	_text2.lineHeight = textLineHeight;
	var linecount = _text2.getMeasuredHeight() / textLineHeight;
	
	if (linecount >= 2){
		_textYOffset = (textLineHeight * (linecount - 1));
		_text1.y = _text1.y - _textYOffset;
		_text2.y = _text2.y - _textYOffset;
	}
	 else
		 _textYOffset=0;
	
    var xPos = _text1.getMeasuredWidth() + _text1.x + -6;
	if (_text1.getMeasuredWidth()==0)
		xPos = 0;
	
    _heartImg = new createjs.Bitmap(_preloader.getResult("heartEmbed"));
    _heartImg.setTransform(xPos, _text1.y - 15);

    _cropFrameImg = new createjs.Bitmap(_preloader.getResult("cropFrame"));
    _cropFrameImg.setTransform(0, 0);

    _cropItOverlay.addChild(_text1, _text2, _heartImg, _cropFrameImg);
    _container.addChild(_cropItOverlay);

    changeText(_cropItTitle);
    changeForm("crop-it");
    ctrlContainerClasses('tools');
}

function formLoadEntryForm() {
    changeText(_compFormTitle, _compFormBtnText);
    changeForm("entry-form");
    ctrlContainerClasses('form');
}

// Filters
function formLoadFilterIt(direction) {
	
	disableStageTouch();
	
    if (direction == _filterDirection.cont) {
        _stage.canvas.width = _stageWidth;
        _stage.canvas.height = _stageHeight;

        _cropImgY = parseInt((_imgGuideRect.width - _stageWidth) / 2);
        _cropImgX = parseInt((_imgGuideRect.height - _stageHeight) / 2);

        _editImg.y -= _cropImgY;
        _editImg.x -= _cropImgX;
        _cropItOverlay.x -= 7;
    }

    bindFilterControls();
    ctrlContainerClasses('filters');
    _cropItOverlay.removeChild(_cropFrameImg);

    _stage.update();

    changeText(_chooseFilterTitle, _chooseFilterBtnText);
    changeForm("filter-it");
    ctrlContainerClasses('filters');
}

function bindFilterControls() {
    $("#btn-filter1").on("click", { name: "none" }, addImgFilter);
    $('#btn-filter2').on("click", { name: "Hefe" }, addImgFilter);
    $('#btn-filter3').on("click", { name: "Hudson" }, addImgFilter);
    $('#btn-filter4').on("click", { name: "Amaro" }, addImgFilter);
}

function loadImageFilters() {
    _imagefilters = {
        'Hefe': {
            curves: { 'a': [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 140, 141, 142, 143, 144, 145, 146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 156, 157, 158, 159, 160, 161, 162, 163, 164, 165, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186, 187, 188, 189, 190, 191, 192, 193, 194, 195, 196, 197, 198, 199, 200, 201, 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220, 221, 222, 223, 224, 225, 226, 227, 228, 229, 230, 231, 232, 233, 234, 235, 236, 237, 238, 239, 240, 241, 242, 243, 244, 245, 246, 247, 248, 249, 250, 251, 252, 253, 254, 255, 255], 'r': [32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 33, 33, 33, 33, 33, 34, 35, 36, 38, 39, 41, 43, 45, 48, 50, 52, 54, 56, 58, 60, 62, 64, 65, 67, 69, 71, 73, 75, 77, 79, 81, 83, 85, 87, 89, 91, 93, 95, 96, 98, 100, 102, 104, 106, 108, 110, 112, 114, 116, 117, 119, 121, 123, 125, 126, 128, 130, 132, 133, 135, 137, 139, 140, 142, 144, 146, 147, 149, 151, 152, 154, 155, 157, 158, 160, 161, 163, 164, 166, 167, 168, 170, 171, 172, 173, 175, 176, 177, 178, 179, 180, 181, 182, 184, 185, 186, 187, 188, 189, 190, 190, 191, 192, 193, 194, 195, 196, 197, 197, 198, 199, 200, 201, 201, 202, 203, 204, 204, 205, 205, 206, 206, 207, 207, 208, 208, 209, 209, 210, 210, 211, 211, 212, 212, 213, 213, 214, 214, 215, 215, 216, 216, 217, 217, 218, 218, 219, 219, 220, 220, 221, 221, 221, 222, 222, 223, 223, 224, 224, 225, 225, 225, 226, 226, 227, 227, 228, 228, 228, 229, 229, 230, 230, 231, 231, 231, 232, 232, 233, 233, 233, 234, 234, 235, 235, 235, 236, 236, 236, 237, 237, 238, 238, 238, 239, 239, 239, 240, 240, 240, 241, 241, 242, 242, 242, 243, 243, 243, 244, 244, 245, 245, 245, 246, 246, 247, 248, 248, 249, 249, 250, 250, 251, 251, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252], 'g': [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 13, 14, 15, 16, 17, 19, 20, 21, 23, 24, 25, 27, 28, 30, 31, 33, 34, 36, 37, 39, 40, 42, 44, 45, 47, 49, 50, 52, 54, 56, 57, 59, 61, 63, 65, 67, 69, 71, 73, 75, 78, 80, 82, 85, 87, 89, 92, 94, 97, 99, 102, 104, 106, 109, 111, 114, 116, 118, 121, 123, 125, 127, 129, 131, 133, 135, 137, 139, 141, 143, 145, 146, 148, 150, 152, 154, 156, 157, 159, 161, 163, 164, 166, 168, 169, 171, 173, 174, 176, 178, 179, 181, 182, 184, 185, 187, 188, 190, 191, 192, 194, 195, 196, 197, 198, 199, 200, 201, 202, 203, 204, 205, 205, 206, 207, 207, 208, 209, 209, 210, 210, 211, 211, 211, 212, 212, 213, 213, 213, 214, 214, 215, 215, 216, 216, 216, 217, 217, 218, 218, 219, 219, 220, 220, 220, 221, 221, 222, 222, 222, 223, 223, 224, 224, 225, 225, 225, 226, 226, 227, 227, 228, 228, 228, 229, 229, 230, 230, 231, 231, 232, 232, 232, 233, 233, 234, 234, 235, 235, 236, 236, 237, 237, 238, 238, 239, 239, 239, 240, 240, 241, 241, 242, 242, 243, 244, 244, 245, 246, 246, 247, 248, 249, 249, 250, 250, 251, 251, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252], 'b': [2, 2, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 5, 5, 5, 5, 5, 6, 6, 6, 6, 6, 7, 7, 7, 8, 8, 9, 9, 9, 10, 10, 11, 12, 12, 13, 13, 14, 15, 15, 16, 17, 17, 18, 19, 19, 20, 21, 22, 23, 24, 24, 25, 26, 27, 28, 29, 30, 32, 33, 34, 35, 36, 38, 39, 40, 42, 43, 45, 47, 48, 50, 52, 54, 56, 58, 60, 62, 64, 66, 68, 70, 72, 74, 76, 78, 80, 82, 84, 86, 87, 89, 91, 93, 95, 96, 98, 100, 101, 103, 105, 107, 108, 110, 112, 113, 115, 117, 118, 120, 122, 123, 125, 127, 128, 130, 131, 133, 135, 136, 138, 140, 141, 143, 145, 146, 148, 149, 151, 153, 154, 156, 158, 159, 161, 163, 164, 166, 167, 169, 170, 171, 173, 174, 175, 177, 178, 179, 180, 182, 183, 184, 185, 186, 187, 189, 190, 191, 192, 193, 194, 195, 195, 196, 197, 198, 198, 199, 200, 200, 201, 201, 202, 202, 203, 203, 204, 204, 204, 205, 205, 205, 206, 206, 206, 207, 207, 207, 207, 208, 208, 209, 209, 209, 210, 210, 211, 211, 211, 212, 212, 213, 213, 214, 214, 214, 215, 215, 216, 216, 216, 217, 217, 218, 218, 218, 219, 219, 220, 220, 220, 221, 221, 222, 222, 222, 223, 223, 224, 224, 225, 225, 226, 226, 227, 227, 227, 228, 228, 228, 228, 228, 228, 228, 228, 228, 228, 228, 228, 228, 228, 228, 228, 228, 228, 228, 228] },
            vignette: true
        },
        'Amaro': {
            curves: { 'a': [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 140, 141, 142, 143, 144, 145, 146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 156, 157, 158, 159, 160, 161, 162, 163, 164, 165, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186, 187, 188, 189, 190, 191, 192, 193, 194, 195, 196, 197, 198, 199, 200, 201, 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220, 221, 222, 223, 224, 225, 226, 227, 228, 229, 230, 231, 232, 233, 234, 235, 236, 237, 238, 239, 240, 241, 242, 243, 244, 245, 246, 247, 248, 249, 250, 251, 252, 253, 254, 255, 256], 'r': [26, 27, 28, 29, 30, 32, 33, 34, 35, 36, 37, 38, 40, 41, 42, 43, 44, 45, 47, 48, 49, 50, 51, 52, 54, 55, 56, 57, 59, 60, 61, 63, 64, 65, 67, 68, 70, 71, 72, 74, 75, 77, 78, 80, 81, 82, 84, 85, 87, 88, 90, 91, 93, 95, 96, 98, 99, 101, 102, 104, 106, 107, 109, 111, 112, 114, 116, 118, 119, 121, 123, 125, 127, 129, 131, 133, 135, 137, 139, 141, 143, 145, 146, 148, 149, 151, 152, 154, 155, 156, 157, 159, 160, 161, 162, 163, 164, 165, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186, 187, 188, 188, 189, 190, 191, 192, 192, 193, 194, 194, 195, 195, 196, 196, 197, 197, 198, 198, 199, 199, 199, 200, 200, 201, 201, 201, 202, 202, 202, 203, 203, 203, 204, 204, 204, 204, 205, 205, 205, 205, 205, 206, 206, 206, 206, 207, 207, 207, 207, 208, 208, 208, 209, 209, 209, 210, 210, 210, 211, 211, 212, 212, 212, 213, 213, 214, 214, 214, 215, 215, 216, 216, 217, 217, 218, 218, 218, 219, 219, 220, 221, 221, 222, 222, 223, 223, 224, 224, 225, 225, 226, 227, 227, 228, 228, 229, 230, 230, 231, 231, 232, 233, 233, 234, 235, 235, 236, 237, 237, 238, 239, 239, 240, 240, 241, 242, 242, 243, 243, 244, 244, 245, 245, 246, 246, 246, 247, 247, 248, 248, 249, 249, 250, 250, 251, 251, 251], 'g': [0, 1, 2, 4, 5, 6, 7, 8, 9, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21, 22, 24, 25, 26, 28, 29, 31, 32, 33, 35, 37, 38, 40, 41, 43, 45, 46, 48, 50, 51, 53, 55, 57, 59, 60, 62, 64, 66, 68, 70, 72, 74, 76, 78, 80, 83, 85, 87, 90, 92, 94, 97, 99, 102, 104, 106, 108, 111, 113, 115, 117, 119, 121, 123, 125, 126, 128, 130, 131, 132, 134, 135, 136, 138, 139, 140, 141, 143, 144, 146, 147, 149, 150, 152, 153, 155, 157, 158, 160, 162, 164, 165, 167, 169, 171, 172, 174, 176, 177, 179, 180, 182, 183, 184, 186, 187, 188, 189, 190, 191, 192, 193, 193, 194, 195, 195, 196, 197, 197, 198, 198, 198, 199, 199, 200, 200, 200, 201, 201, 202, 202, 202, 203, 203, 203, 204, 204, 205, 205, 205, 206, 206, 207, 207, 207, 208, 208, 208, 209, 209, 209, 210, 211, 211, 212, 213, 213, 214, 215, 216, 217, 217, 218, 219, 220, 220, 221, 222, 222, 222, 223, 223, 223, 223, 223, 223, 223, 223, 224, 224, 224, 224, 225, 225, 225, 226, 226, 226, 227, 227, 228, 228, 228, 229, 229, 230, 230, 231, 231, 232, 232, 233, 233, 234, 234, 234, 235, 236, 236, 237, 237, 238, 238, 239, 240, 240, 241, 241, 242, 243, 243, 244, 244, 245, 245, 246, 246, 247, 247, 248, 248, 249, 249, 250, 250, 250, 251, 251, 252, 252, 253, 253, 253, 254, 254, 255, 255, 255], 'b': [28, 29, 30, 32, 33, 35, 36, 38, 39, 41, 42, 43, 45, 46, 48, 49, 50, 52, 53, 55, 56, 58, 59, 61, 62, 64, 65, 67, 69, 70, 72, 74, 76, 77, 79, 81, 83, 85, 87, 89, 91, 93, 95, 97, 99, 101, 103, 105, 107, 109, 111, 113, 115, 117, 119, 121, 122, 124, 126, 127, 129, 130, 132, 133, 134, 136, 137, 138, 140, 141, 142, 143, 145, 146, 147, 148, 150, 151, 152, 153, 154, 156, 157, 158, 159, 160, 161, 162, 163, 164, 164, 165, 166, 167, 167, 168, 169, 169, 170, 170, 171, 171, 172, 172, 173, 173, 174, 174, 175, 176, 176, 176, 177, 177, 178, 178, 179, 179, 180, 180, 180, 181, 181, 182, 182, 182, 183, 183, 183, 184, 184, 184, 185, 185, 185, 185, 186, 186, 186, 186, 186, 187, 187, 187, 187, 187, 188, 188, 188, 188, 189, 189, 189, 189, 190, 190, 190, 190, 191, 191, 191, 191, 192, 192, 192, 192, 193, 193, 193, 194, 194, 195, 195, 195, 196, 196, 197, 197, 198, 199, 199, 200, 200, 201, 201, 202, 202, 203, 203, 204, 204, 205, 205, 206, 206, 207, 207, 207, 208, 208, 209, 209, 209, 210, 210, 211, 211, 212, 212, 212, 213, 214, 214, 215, 215, 216, 217, 217, 218, 219, 220, 221, 222, 222, 223, 224, 225, 226, 227, 228, 229, 230, 231, 232, 233, 234, 235, 235, 236, 237, 238, 238, 239, 240, 240, 241, 242, 242, 243, 243, 244, 245, 245, 246, 246, 247, 248] },
            vignette: true
        },
        'Hudson': {
            curves: { 'a': [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 140, 141, 142, 143, 144, 145, 146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 156, 157, 158, 159, 160, 161, 162, 163, 164, 165, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186, 187, 188, 189, 190, 191, 192, 193, 194, 195, 196, 197, 198, 199, 200, 201, 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220, 221, 222, 223, 224, 225, 226, 227, 228, 229, 230, 231, 232, 233, 234, 235, 236, 237, 238, 239, 240, 241, 242, 243, 244, 245, 246, 247, 248, 249, 250, 251, 252, 253, 254, 255, 256], 'r': [36, 37, 37, 38, 39, 39, 40, 40, 41, 42, 42, 43, 44, 44, 45, 46, 46, 47, 47, 48, 49, 50, 50, 51, 52, 52, 53, 54, 55, 55, 56, 57, 58, 59, 59, 60, 61, 62, 63, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 91, 92, 93, 95, 96, 97, 98, 99, 100, 101, 103, 104, 105, 106, 107, 109, 110, 111, 112, 113, 115, 116, 117, 119, 120, 121, 123, 124, 125, 127, 128, 129, 131, 132, 134, 135, 136, 138, 139, 140, 142, 143, 144, 146, 147, 148, 149, 151, 152, 153, 154, 156, 157, 158, 159, 160, 162, 163, 164, 165, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176, 176, 177, 178, 179, 180, 181, 181, 182, 183, 184, 185, 185, 186, 187, 188, 189, 189, 190, 191, 191, 192, 193, 194, 194, 195, 196, 196, 197, 197, 198, 199, 199, 200, 201, 201, 202, 203, 203, 204, 205, 205, 206, 207, 207, 208, 208, 209, 210, 210, 211, 212, 212, 213, 213, 214, 214, 215, 216, 216, 217, 217, 217, 218, 218, 219, 219, 219, 220, 220, 221, 221, 222, 222, 223, 224, 224, 225, 226, 226, 227, 228, 229, 229, 230, 231, 232, 232, 233, 234, 235, 236, 236, 237, 238, 239, 240, 240, 241, 242, 243, 243, 244, 245, 245, 246, 247, 247, 248, 248, 249, 250, 250, 251, 251, 252, 253, 253, 254, 254, 255, 256], 'g': [0, 1, 2, 4, 5, 6, 7, 8, 9, 11, 12, 13, 14, 15, 17, 18, 19, 20, 21, 23, 24, 25, 26, 28, 29, 30, 32, 33, 34, 36, 37, 39, 40, 42, 43, 45, 46, 47, 49, 50, 52, 53, 55, 56, 58, 59, 60, 62, 63, 64, 66, 67, 69, 70, 71, 73, 74, 75, 77, 78, 79, 81, 82, 83, 85, 86, 87, 89, 90, 91, 93, 94, 96, 97, 98, 100, 101, 103, 104, 106, 107, 109, 110, 111, 113, 114, 116, 117, 118, 120, 121, 122, 124, 125, 126, 128, 129, 130, 131, 133, 134, 135, 137, 138, 139, 141, 142, 144, 145, 146, 148, 149, 150, 152, 153, 154, 155, 157, 158, 159, 160, 162, 163, 164, 165, 166, 167, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186, 186, 187, 188, 189, 190, 190, 191, 192, 192, 193, 194, 194, 195, 196, 196, 197, 197, 198, 199, 199, 200, 201, 201, 202, 202, 203, 204, 204, 205, 205, 206, 206, 207, 207, 208, 208, 209, 209, 210, 210, 211, 211, 212, 213, 213, 214, 214, 215, 216, 216, 217, 218, 219, 219, 220, 221, 222, 222, 223, 224, 224, 225, 226, 226, 227, 227, 228, 228, 229, 230, 230, 231, 231, 232, 232, 233, 233, 234, 234, 235, 235, 236, 236, 237, 237, 238, 238, 239, 240, 240, 241, 242, 242, 243, 244, 244, 245, 246, 246, 247, 248, 249, 249, 250, 251, 251, 252, 253, 254, 254, 255, 256], 'b': [1, 2, 3, 5, 7, 9, 10, 12, 14, 16, 18, 19, 21, 23, 25, 26, 28, 30, 31, 33, 35, 36, 38, 40, 41, 43, 45, 46, 47, 49, 50, 52, 53, 54, 56, 57, 59, 61, 62, 64, 66, 67, 69, 71, 73, 74, 76, 78, 80, 82, 83, 85, 87, 89, 91, 92, 94, 96, 98, 99, 101, 103, 104, 106, 108, 109, 111, 113, 114, 116, 118, 119, 121, 123, 124, 126, 128, 129, 131, 133, 134, 136, 137, 139, 140, 142, 143, 145, 146, 148, 149, 150, 152, 153, 154, 155, 156, 158, 159, 160, 161, 162, 163, 164, 166, 167, 168, 169, 171, 172, 173, 175, 176, 178, 179, 181, 182, 184, 185, 186, 188, 189, 190, 192, 193, 194, 195, 196, 197, 198, 199, 199, 200, 201, 202, 202, 203, 204, 204, 205, 205, 206, 206, 207, 207, 208, 209, 209, 210, 210, 211, 211, 211, 212, 212, 213, 213, 214, 214, 214, 215, 215, 216, 216, 216, 217, 217, 217, 218, 218, 219, 219, 219, 220, 220, 220, 221, 221, 221, 222, 222, 222, 223, 223, 223, 224, 224, 224, 225, 225, 226, 226, 226, 227, 227, 228, 229, 229, 230, 230, 231, 231, 232, 233, 233, 234, 234, 235, 235, 236, 237, 237, 237, 238, 238, 239, 239, 240, 241, 241, 242, 242, 243, 243, 244, 244, 244, 245, 245, 246, 246, 246, 246, 247, 247, 247, 247, 247, 247, 247, 247, 247, 247, 247, 247, 247, 247, 247, 247, 247, 247, 247, 247, 247, 247, 247, 247] },
            vignette: false
        },
    }
}

function removeImageFilter() {
    if (_container.contains(_filterImg)) {
        _container.removeChild(_filterImg);
        _stage.update();
    }
}

function addImgFilter(e) {

    removeImageFilter();

    if (e.data.name != "none") {
        var curves = _imagefilters[e.data.name].curves;
        var vignette = _imagefilters[e.data.name].vignette;

        _container.removeChild(_cropItOverlay);
        _filterImgData = _stage.canvas.getContext("2d").getImageData(0, 0, _imgGuideRect.width, _imgGuideRect.height);

        var imgData = _filterImgData;
        var data = imgData.data;
        var length = data.length;

        for (i = 0; i < length; i += 4) {
            data[i] = curves["r"][data[i]];
            data[i + 1] = curves["g"][data[i + 1]];
            data[i + 2] = curves["b"][data[i + 2]];
        }

        for (i = 0; i < length; i += 4) {
            data[i] = curves.a[data[i]];
            data[i + 1] = curves.a[data[i + 1]];
            data[i + 2] = curves.a[data[i + 2]];
        }
        imgData.data = data;

        _imgCanvas.width = _imgGuideRect.width;
        _imgCanvas.height = _imgGuideRect.height;
        _imgCanvasCtx.putImageData(imgData, 0, 0);

        addImgVignette(vignette);

        _filterImg = new createjs.Bitmap(_imgCanvas.toDataURL("image/jpeg", 0.85));
        _container.addChild(_filterImg);
        _container.addChild(_cropItOverlay);
    }
}

function addImgVignette(vignette) {
    if (vignette) {
        var gradient,
            outerRadius = Math.sqrt(Math.pow(_imgGuideRect.width / 2, 2) + Math.pow(_imgGuideRect.height / 2, 2));

        _imgCanvasCtx.globalCompositeOperation = 'source-over';
        gradient = _imgCanvasCtx.createRadialGradient(_imgGuideRect.width / 2, _imgGuideRect.height / 2, 0, _imgGuideRect.width / 2, _imgGuideRect.height / 2, outerRadius);
        gradient.addColorStop(0, 'rgba(0, 0, 0, 0)');
        gradient.addColorStop(0.75, 'rgba(0, 0, 0, 0)');
        gradient.addColorStop(1, 'rgba(0, 0, 0, 0.3)');
        _imgCanvasCtx.fillStyle = gradient;
        _imgCanvasCtx.fillRect(0, 0, _imgGuideRect.width, _imgGuideRect.height);

        _imgCanvasCtx.globalCompositeOperation = 'lighter';
        gradient = _imgCanvasCtx.createRadialGradient(_imgGuideRect.width / 2, _imgGuideRect.height / 2, 0, _imgGuideRect.width / 2, _imgGuideRect.height / 2, outerRadius);
        gradient.addColorStop(0, 'rgba(255, 255, 255, 0.2)');
        gradient.addColorStop(0.75, 'rgba(255, 255, 255, 0)');
        gradient.addColorStop(1, 'rgba(0, 0, 0, 0)');
        _imgCanvasCtx.fillStyle = gradient;
        _imgCanvasCtx.fillRect(0, 0, _imgGuideRect.width, _imgGuideRect.height);
    }
}
// End Filters

// Nav Slide and Forms

//Image 
function saveComposedImg() {
    if (!_saving) {
        _saving = true;
        _stage.canvas.width = _stageWidth;
        _stage.canvas.height = _stageHeight;
        _container.scaleX = _container.scaleY = 1;
        _stage.update();

        var jpgEncoder = new JPEGEncoder(_encodeQuality);
        var imgData = _stage.canvas.getContext("2d").getImageData(_imgGuideRect.x, _imgGuideRect.y, _stageWidth, _stageHeight);
        _jpgData = jpgEncoder.encode(imgData, _encodeQuality);
        imgData = jpgEncoder = null;

        _timout = setTimeout(sendEntryImg, 1000);
    }
}

// POST COMPETITION ENTRY
function sendEntryImg() {
    clearTimeout(_timout);

	var txtName = $('#txtName').val();
	var txtWhatYouLove = $('#txtWhatYouLove').val();

    var imgCategory = $('#ddFileUnder').val();
	var txtFirstname = $('#txtFirstName').val();
	var txtLastname = $('#txtLastName').val();
	
	var txtDobDay = $('#txtDobDay').val();
	var txtDobMonth = $('#txtDobMonth').val();
	var txtDobYear = $('#txtDobYear').val();
	
	var dobFull = txtDobDay + '/' + txtDobMonth + '/' + txtDobYear;
	
	var ddCountry = $('#ddCountry').val();
	var txtEmail = $('#txtEmail').val();
	var cbOffers = $('#cb1').val();
	var cbTermsAgree = $('#cb2').val();
	var cbConfirm = $('#cb3').val();
	
	// data: "{imageCategory: '" + imgCategory + "', jpgData: '" + _jpgData + "'}",
	
    $.ajax({type: "POST",
		url: _webserviceURL,
		data: '{"FirstName":"' + txtFirstname + '", "LastName":"' + txtLastname + '", "DOB":"' + dobFull + '", "Country":"' + ddCountry + '", "Email":"' + txtEmail + '", "FutureOffers":"' + cbOffers + '","Terms":"' + cbTermsAgree + '","TextHeart":"' + txtName + '","Whatyoulove":"' + txtWhatYouLove + '","PhotoRights":"' + cbConfirm + '", "imageCategory": "' + imgCategory + '", "jpgData": "' + _jpgData + '"}',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: onSendEntryImgComplete,
		error: function(xhr, status){
			_saving = false;
			_jpgData = null;
			showAlertPopup(_errorPostAjax);
		}
    });
}

function onSendEntryImgComplete(data) {
                
    _jpgData = null;
    //var json = JSON.parse(data);
    var response = data.response;

    if (response) {
        gotoURL(_submitFormThankyouURL);
    }
    else {
        _saving = false;
        showAlertPopup(_errorSendEntry);
    }
}

//--- webcam and flash: start
function getFlexApp(appName) {
    if (navigator.appName.indexOf("Microsoft") != -1) {
        return window[appName];
    } else {
        return document[appName];
    }
}

//triggered by onclick
function callFlex() {
    var webcam = getFlexApp('webcam');
    webcam.takeSnapshot(); //Flex function
}

function onSnapshotData(data) {
    //webcam image
    if (data != null) {

        data = data.substring(data.indexOf(","), data.length);
        data = "data:image/jpeg;base64," + data;

        _editImg = new createjs.Bitmap(data);
        data = null;

        $(_editImg.image).on("load", onEditImgLoaded);

        changeSlide('canvas');
        changeText(_tellUsAboutItTitle);
        changeForm("tell-us-about");
    }
}
//--- webcam and flash: end

function onFileInputEvent() {
    if (_fileInput.files.length > 0) {
        var isImgFile = true;
        var isAllowed = false;
		var permittedFiles = "jpeg|jpg|gif|bmp|png";
		
        if (_fileInput.files[0].type) {
            isImgFile = _fileInput.files[0].type.substring(0, 5) == "image";
            var imgType = _fileInput.files[0].type;
            var imgExt = imgType.substr(imgType.indexOf("/") + 1)
            if (permittedFiles.indexOf(imgExt.toLowerCase()) != -1) {
                isAllowed = true;
            }
        }else{
			var imgExt = _fileInput.files[0].fileName.split('.').pop();
			if (permittedFiles.indexOf(imgExt.toLowerCase()) != -1) {
                isAllowed = true;
            }
		}

        if (isImgFile && isAllowed) {
            clearSelectedImg();
            loadSelectedImg();
            changeSlide('canvas');
        }
        else {
            showAlertPopup(_errorUploadFormat);
        }
    }
}

function onFlashUploadImage(data) {
	data = data.substring(data.indexOf(","), data.length);
	data = "data:image/jpeg;base64," + data;

	_editImg = new createjs.Bitmap(data);
	data = null;

	$(_editImg.image).on("load", onEditImgLoaded);

	changeSlide('canvas');
	changeText(_tellUsAboutItTitle);
	changeForm("tell-us-about");
}

function loadSelectedImg() {
	_fileReader = new FileReader(), _fileFilter = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;

    _fileReader.onload = onFileReaderEvent;
    _fileReader.onerror = onFileReaderEvent;

    _fileReader.readAsDataURL(_fileInput.files[0]);
}

function onFileReaderEvent(evt) {
    if (evt.type == "load") {
        if (_fileReader.result.length < _maxImgData) {
            var data = _fileReader.result;

            data = data.substring(data.indexOf(","), data.length);
            data = "data:image/jpeg;base64" + data;
            _editImg = new createjs.Bitmap(data);
            data = null;
            $(_editImg.image).on("load", onEditImgLoaded);
        }
        else {
            showAlertPopup(_errorImageTooLarge);
        }
    }
    else {
        showAlertPopup(_errorReadingFile);
    }

    _fileReader = _fileFilter = null;
}

function onEditImgLoaded(evt) {
    $(_editImg.image).off();
    if (_editImg.image.width > _maxImgSize || _editImg.image.height > _maxImgSize) {
        createResizedImg();
    }
    else {
        onEditImgComplete();
    }
}

function createResizedImg() {
    var vertRatio = 1;
    var scaleFactor = 0;
    if (_isiPhone || _isiPad) {
        vertRatio = detectImgVertRatio(_editImg.image, _editImg.image.width, _editImg.image.height);
    }

    if (_editImg.image.width <= _editImg.image.height) {
        scaleFactor = _maxImgSize / _editImg.image.width;
    }
    else {
        scaleFactor = _maxImgSize / _editImg.image.height;
    }
	
    _imgCanvas.width = Math.round(_editImg.image.width * scaleFactor);
    _imgCanvas.height = Math.round(_editImg.image.height * scaleFactor);

    if (_isiPhone || _isiPad) {
        _imgCanvasCtx.drawImage(_editImg.image, 0, 0, _editImg.image.width, _editImg.image.height, 0, 0, _imgCanvas.width, _imgCanvas.height / vertRatio);
    }
    else {
        _imgCanvasCtx.drawImage(_editImg.image, 0, 0, _imgCanvas.width, _imgCanvas.height);
    }

    _editImg.image = null;
    _editImg = null;
    _editImg = new createjs.Bitmap(_imgCanvas.toDataURL("image/jpeg", 0.85));

    _imgCanvasCtx.clearRect(0, 0, _imgCanvas.width, _imgCanvas.height);
    $(_imgCanvas).remove();

    $(_editImg.image).on("load", onEditImgComplete);
}

function detectImgVertRatio(img, iw, ih) {
    _imgCanvas.width = 1;
    _imgCanvas.height = ih;
    _imgCanvasCtx.drawImage(img, 0, 0);
    var data = _imgCanvasCtx.getImageData(0, 0, 1, ih).data;
    var sy = 0;
    var ey = ih;
    var py = ih;
    var alpha;
    while (py > sy) {
        alpha = data[(py - 1) * 4 + 3];
        if (alpha === 0) {
            ey = py;
        } else {
            sy = py;
        }
        py = (ey + sy) >> 1;
    }
    var ratio = (py / ih);
    data = null;
    _imgCanvasCtx.clearRect(0, 0, _imgCanvas.width, _imgCanvas.height);
    return (ratio === 0) ? 1 : ratio;
}

function onEditImgComplete() {
    $(_editImg.image).off();

     _editImg.regX = _editImg.image.width * 0.5;
     _editImg.regY = _editImg.image.height * 0.5;
	 
	if (_editImg.image.width <= _editImg.image.height)
	{
		_editImg.scaleX = (_imgGuideRect.width / _editImg.image.width).toFixed(2);
		_editImg.scaleY = _editImg.scaleX;
	}
	else
	{
		_editImg.scaleY = (_imgGuideRect.height / _editImg.image.height).toFixed(2);
		_editImg.scaleX = _editImg.scaleY;
	}
	
    _editImg.x = _imgGuideRect.x + (_imgGuideRect.width * 0.5);
    _editImg.y = _imgGuideRect.y + (_imgGuideRect.height * 0.5);

    _scaleInc = (0.10 * _editImg.scaleX).toFixed(2);

    _editImg.on("mousedown", onEditImgMouseEvent);
    _editImg.on("pressup", onEditImgMouseEvent);
    _editImg.on("pressmove", onEditImgMouseEvent);
    applyRolloverCursor([_editImg]);
	
    _container.addChild(_editImg);

    initTellUsAbout();
}

function onEditImgMouseEvent(evt) {
	
	
	if (_currentForm == "crop-it")
	{
		switch (evt.type) {
			case "mousedown":
				_startDragPt.x = evt.rawX;
				_startDragPt.y = evt.rawY;
				_editImgPt.x = _editImg.x;
				_editImgPt.y = _editImg.y;
				break;
			case "pressmove":
				_editImg.x = _editImgPt.x + (evt.rawX - _startDragPt.x);
				_editImg.y = _editImgPt.y + (evt.rawY - _startDragPt.y);
				break;
		}
	}
}

function clearSelectedImg() {
    if (_editImg) {
        _editImg.removeAllEventListeners();
        _container.removeChild(_editImg);
        _editImg.image = null;
        _editImg = null;
    }
}
// Image

// Facebook
function addFBProfilePic() {
    if (!$('#fb-profile-pic').length > 0) {
        FB.api("/me/picture", function (response) {
            var profilepic = document.createElement('img');
            profilepic.src = response.data.url;
            profilepic.width = 45;
            profilepic.height = 45;
            profilepic.id = "fb-profile-pic";
            profilepic.alt = _fbProfilePicAlt;
            var fbBreadcrumbEl = $('.gallery-breadcrumb');
            $(fbBreadcrumbEl).prepend(profilepic);
        });
    }
}

function getFBAlbums(callback) {
    FB.api(
		'/me/albums?limit=100',
		function (albumResponse) {
		    if (callback) {
		        callback(albumResponse);
		    }
		}
	);
}

function getFBAlbumPicture(album, imgId, callback) {
    FB.api(
		'/' + album.id + '/picture',
		function (picture) {
		    if (callback) {
		        callback(picture, album, imgId);
		    }
		}
	);
}

function clearFBList() {
    $('#fb-photo-list-ul li').each(function () {
        $(this).remove();
    });
}

function loadFBGallery() {

	_fbLoadingAlbumPhotos = false;

    addFBProfilePic();

    var ul = document.getElementById('fb-photo-list-ul');
    clearFBList();
	
	document.getElementById("fb-album-title").innerHTML='';

    getFBAlbums(function (resp) {

        for (var i = 0, l = resp.data.length; i < l; i++) {
            var album = resp.data[i];
			
			var li = document.createElement('li');
			var a = document.createElement('a');
			var imgId = generateFBImageGuid();
			
			a.href = "JavaScript:loadFBAlbumPhotos('" + album.id + "', '" + album.name.replace("'","&apos;") + "');";
			
			$('<img />').attr({
				id: imgId,
				width: 280,
				height: 200
			}).appendTo(a);

			li.appendChild(a);
			ul.appendChild(li);
			
            getFBAlbumPicture(album, imgId, function (picResp, retAlbum, setImgId) {
				if (!_fbLoadingAlbumPhotos) {
					 $('#' + setImgId).attr("src", picResp.data.url);
				}
            });
        }

        if (resp.data == 0) {
			var li = document.createElement('li');
			var p = document.createElement('p');
			$(p).html(_errorfbNoPhotos);
			li.appendChild(p);
			ul.appendChild(li);
			
        }
    });
}

function generateFBImageGuid() {
    return Math.random().toString(36).substring(2, 15) +
        Math.random().toString(36).substring(2, 15);
}

function loadFBAlbumPhotos(albumId,albumTitle) {
    var ul = document.getElementById('fb-photo-list-ul');
    clearFBList();
	
	_fbLoadingAlbumPhotos = true;
	
	document.getElementById("fb-album-title").innerHTML = ' > ' + albumTitle;

    FB.api('/' + albumId + '/photos?limit=100', function (photos) {
        if (photos && photos.data && photos.data.length) {
            for (var j = 0; j < photos.data.length; j++) {
                var photo = photos.data[j];
				
                var li = document.createElement('li');
                var a = document.createElement('a');

                a.href = 'JavaScript:loadFbImageToCanvas("' + photo.source + '");';

                $('<img />').attr({
                    src: photo.source,
                    width: 280,
                    height: 200
                }).appendTo(a);

                li.appendChild(a);
                ul.appendChild(li);
            }
        }
    });
}

function loadFbImageToCanvas(fbImg) {
	clearSelectedImg();
    _editImg = new createjs.Bitmap(_facebookImageHandlerFile + "?fbID=" + encodeURIComponent(fbImg));
    $(_editImg.image).on("load", onEditImgLoaded);
    changeSlide('canvas');
}

function initFbAPI() {
    FB.init({
        appId: _fbAppID,
        channelUrl: _appURL + _fbChannelFile,
        status: true,
        xfbml: true
    });

    FB.getLoginStatus(onFbLoginEvent);
}

function onFbConnBtnClick() {
    var fbPerms = { scope: "email,user_photos", redirect_uri: _appURL + '/index.html' };
    var fbConnURL = "https://m.facebook.com/dialog/oauth?client_id=" + _fbAppID + "&response_type=code&redirect_uri=" + fbPerms.redirect_uri + "&scope=" + fbPerms.scope;
	
    if (_isiPhone || _isAndroid) {
        gotoURL(fbConnURL);
    }
    else {
        fbPerms.redirect_uri = "";
        FB.login(onFbLoginEvent, fbPerms);
    }
}

function onFbLoginEvent(response) {
	
    if (response.status == "connected") {
        if (!_fbLoggedIn) {
            _fbLoggedIn = true;
            _fbUID = response.authResponse.userID;
            _fbAccessToken = response.authResponse.accessToken;
            loadFbUserInfo();

            if (_fbButtonClicked) {
                _fbButtonClicked = false;
				changeSlide("fb-photo");
                loadFBGallery();
            }
        }
    }
    _fbButtonActivated = true;
}

function loadFbUserInfo() {
    FB.api("/me?fields=name,email", function (response) {
        if (response) {
            _fbName = response.name;
            _fbEmail = response.email;
        }
        else {
            showAlertPopup(_errorConnectingFacebook);
        }
    });
}
// Facebook

// Helper Functions
function gotoURL(value) {
    window.location.href = value;
}

function ctrlContainerClasses(add) {
    if (typeof add === 'undefined') { add = ''; }

    $('#photo-container').removeClass().addClass(add);
}

function showAlertPopup(msg) {
    alert(msg);
}

function onTickEvent(evt) {
    _stage.update();
}

function onStageMouseDown(evt) {
    _lastMouseDown = new Date().getTime();
}

function onPressUpManager(evt, data) {
    var delayTime = new Date().getTime() - _lastMouseDown;
    if (delayTime > 20) data.call(evt, data);
}

function applyRolloverCursor(targets) {
    for (var i = 0; i < targets.length; i++) {
        var target = targets[i];
        target.on("rollover", onBtnRollEvent);
        target.on("rollout", onBtnRollEvent);
    }
}

function onBtnRollEvent(evt) {
    
	if (_currentForm == "crop-it")
	{
		switch (evt.type) {
			case "rollover":
				document.body.style.cursor = "pointer";
				break;
			case "rollout":
				document.body.style.cursor = "default";
				break;
		}
	}
}

function disableStageTouch()
{
	if (createjs.Touch.isSupported())
	{
		try {
			createjs.Touch.disable(_stage);
		}
		catch(err) {
		}
	}
}
// Helper Functions

// Load Facebook SDK asynchronously
(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) { return; }
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));