$(document).ready(function($) {
	"use strict"
	/* common js */
	/* register bind function when loaded */
	/*if ( !/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|ARM|Touch|Opera Mini/i.test(navigator.userAgent)) {*/
	if(!isTouchDevice()){
        $(function ($) {$('[data-toggle="tooltip"]').tooltip({container: 'body'})});
        $(function ($) {$('[data-tooltip="tooltip"]').tooltip({container: 'body'})});
    }else{
        $('[data-toggle="tooltip"]').removeAttr('title');
        $('[data-tooltip="tooltip"]').removeAttr('title');
    }

    $.fn.datepicker.defaults.format = "dd M yyyy";
    $.fn.datepicker.defaults.autoclose = true;
    $.fn.datepicker.defaults.todayHighlight = true;
    $.fn.datepicker.defaults.clearBtn = true;

    $('.birthday').datepicker({
        format: "dd M yyyy",
        autoclose: true,
        defaultViewDate: { year: 1988, month: 4, day: 25 }
    });
    $('.datepicker').datepicker();
	$('[data-toggle="popover"]').popover();
    initGlobal();


    /**
     * Author: CuongPH
     * Auto run Link Go on slider
     * **/

    $('a[link_go]').each(function(){
        var $link = $(this).attr('link_go');
        $(this).attr('target', '_blank');
        $(this).on('click', function(){
            window.open($link, '_self');
        });
    });



    /**
     * CuongPH
     * Auto-resize Textarea
     * */
    jQuery.each(jQuery('textarea[data-autoresize]'), function() {
        var offset = this.offsetHeight - this.clientHeight;
        var resizeTextarea = function(el) {
            jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset + 2);
        };
        jQuery(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
    });
    initGetCode();

    $('body').on('click','a[data-send="send-mail"]',function(e){
        var $target = $(this).attr('data-send-target');
        e.preventDefault();
        e.stopPropagation();
        $($target).css('display', 'table').find('input').focus();
    });
    $('body').click(function(event) {
        if ($(event.target).closest('.coupon-send-mail').length == 0) {
            $('.coupon-send-mail').hide();
        }
    });
    truncateSomething();
    $('.modal').on('shown.bs.modal', function() {
        $(document).off('focusin.modal');
        hideAllPopover()
    }).on('hide.bs.modal', function() {
        hideAllPopover()
    });

});
$(window).on('resize orientationchange', function(){
    truncateSomething();
});

/**
 * Function Check Browser Support HTML5 validation
 * **/
function hasFormValidation() {
    return 'reportValidity' in document.createElement('form');
}
function validateEmailElement($form) {
    $emailField = $form.find("input[type='email']");
    $email = $($emailField).val();
    if ($email === "" ) {
        alert("Email is required.");
        $($emailField).focus();
        return false;
    } else if ( !$email.match(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/) ) {
        alert("You must provide a valid email address.");
        $($emailField).focus();
        return false;
    }
    return true;
}

function hideAllPopover(){
    $(".btn-like").webuiPopover('destroy');
}
function truncateSomething(){
    $('.show-more-desc').each(function () {
        var $el = $(this);
        $el.truncate({
            lines: 2,
            lineHeight: 21,
            showMore: '<a href="#" class="toggle-more"><i>More</i></a>',
            showLess: '<a href="#" class="toggle-less"><i>Less</i></a>'
        });
        $el.on('click', 'a.toggle-more', function () {
            $el.truncate('expand');
            return false;
        });
        $el.on('click', 'a.toggle-less', function () {
            $el.truncate('collapse');
            return false;
        });
        $el.truncate('update');
    });
    $('.desc-more').each(function () {
        var $el = $(this);
        $el.truncate({
            lines: 4,
            lineHeight: 21,
            showMore: '<a href="#" class="toggle-more"><i>More</i></a>',
            showLess: '<a href="#" class="toggle-less"><i>Less</i></a>'
        });
        $el.on('click', 'a.toggle-more', function () {
            $el.truncate('expand');
            return false;
        });
        $el.on('click', 'a.toggle-less', function () {
            $el.truncate('collapse');
            return false;
        });
        $el.truncate('update');
    });
    $('.ellipsis3').truncate({
        lines: 3,
        lineHeight: 25
    }).truncate('update');

    $('.ellipsis1').each(function () {
        var $el = $(this);
        $el.truncate({
            lines: 1,
            lineHeight: 21
        });
        $el.truncate('update');
    });

    $('.ellipsis1-header').each(function () {
        var $el = $(this);
        $el.truncate({
            lines: 1,
            lineHeight: 34
        });
        $el.truncate('update');
    });

    $('.ellipsis2').each(function () {
        var $el = $(this);
        $el.truncate({
            lines: 2,
            lineHeight: 21
        });
        $el.truncate('update');
    });
    $('.ellipsis1-more').each(function () {
        var $el = $(this);
        $el.truncate({
            lines: 1,
            lineHeight: 18,
            showMore: '<a href="#" class="toggle-more"><i> More</i></a>',
            showLess: '<a href="#" class="toggle-less"><i> Less</i></a>'
        });
        $el.on('click', 'a.toggle-more', function () {
            $el.truncate('expand');
            return false;
        });
        $el.on('click', 'a.toggle-less', function () {
            $el.truncate('collapse');
            return false;
        });
        $el.truncate('update');
    });
    $('#tbl-withdraw-history .ellipsis1-more-paypal').each(function () {
        var $el = $(this);
        $el.truncate({
            lines: 1,
            lineHeight: 21,
            showMore: '<a href="#" class="toggle-more"><i> More</i></a>',
            showLess: '<a href="#" class="toggle-less"><i> Less</i></a>'
        });
        $el.on('click', 'a.toggle-more', function () {
            $el.truncate('expand');
            return false;
        });
        $el.on('click', 'a.toggle-less', function () {
            $el.truncate('collapse');
            return false;
        });
        $el.truncate('update');
    });
}

function saveInLocal(){
    /*
     Author:HaiHT
     Favourite store without login
     */
    // Check if browser support Web storage
    if(typeof(Storage) !== "undefined") {
        // Click save store to fav list
        $('body').on('click', '.fav-without-login', function(){
            // Init
            var favStores = [];
            // If exist saveCoupons ids in LS then push to localObj saveCoupons
            if(localStorage.favouriteStores){
                favStores = (localStorage.favouriteStores).split(',');
            }
            var storeID = $(this).attr('id');
                // Only add unique store id to fav list
            if($.inArray(storeID, favStores) == -1 && !$(this).hasClass('liked')){
                favStores.push(storeID);
            }else{
                favStores.splice(favStores.indexOf(storeID),1);
            }
            localStorage['favouriteStores'] = favStores;
            console.log(storeID,'after fav store:',localStorage['favouriteStores']);
            checkLocal();
        })
    } else {
        console.log('No Web Storage support');
    }

    /*
     Author:HaiHT
     Save coupon without login
     */
    // Check if browser support Web storage
    if(typeof(Storage) !== "undefined") {
        // Click save store to fav list
        $('body').on('click', '.save-cp-without-login', function(){
            var saveCoupons = [];
            // If exist saveCoupons ids in LS then push to localObj saveCoupons
            if(localStorage.saveCoupons){
                saveCoupons = (localStorage.saveCoupons).split(',');
            }
            var couponId = $(this).attr('id');
            if($.inArray(couponId, saveCoupons) == -1 && !$(this).hasClass('saved')){
                saveCoupons.push(couponId);
            }else{
                saveCoupons.splice($.inArray(couponId, saveCoupons), 1);
            }
            localStorage.saveCoupons = saveCoupons;
            // console.log('Saved coupon after:',localStorage['saveCoupons']);
            checkLocal();
        })
    } else {
        console.log('No Web Storage support');
    }

    /*if(typeof(Storage) !== "undefined") {
        $('body').on('click', '.btn-like.liked', function(){
            var likeCoupons = [];
            // If exist saveCoupons ids in LS then push to localObj saveCoupons
            if(localStorage.likeCoupons){
                likeCoupons = (localStorage.likeCoupons).split(',');
            }
            var $coupon_id = $(this).attr('c_id');
            console.log('This is called ', $coupon_id);
            likeCoupons.splice($.inArray($coupon_id, likeCoupons), 1);
            $(this).removeClass('liked').addClass('like-btn');
            localStorage.likeCoupons = likeCoupons;
            checkLocal();
        });
    } else {
        console.log('No Web Storage support');
    }*/

    // Check if browser support Web storage
    if(typeof(Storage) !== "undefined") {
        $('body').on('click', '.btn-dislike', function(e){
            var dislikeCoupons = [];
            if(localStorage.dislikeCoupons){
                dislikeCoupons = (localStorage.dislikeCoupons).split(',');
            }

            var $coupon_id = $(this).attr('c_id');
            // Only add unique id
            if($.inArray($coupon_id, dislikeCoupons) == -1 && !$(this).hasClass('disliked')){
                dislikeCoupons.push($coupon_id);
                var likeCoupons = [];
                // If exist saveCoupons ids in LS then push to localObj saveCoupons
                if(localStorage.likeCoupons){
                    likeCoupons = (localStorage.likeCoupons).split(',');
                }
                likeCoupons.splice( $.inArray($coupon_id, likeCoupons), 1);
                localStorage.likeCoupons = likeCoupons;
                $(this).addClass('disliked');
                $(this).prev('.btn-like').removeClass('liked');
            }else{
                dislikeCoupons.splice( $.inArray($coupon_id, dislikeCoupons), 1);
                $(this).removeClass('disliked');
            }
            localStorage.dislikeCoupons = dislikeCoupons;
            checkLocal();
        })
    } else {
        console.log('No Web Storage support');
    }
}

function checkLocal(){
    setTimeout(function () {
        var favStores = [];
        // If exist saveCoupons ids in LS then push to localObj saveCoupons
        if(localStorage.favouriteStores){
            favStores = (localStorage.favouriteStores).split(',');
        }
        /*
         Highlight coupons saved
         */
        if(favStores.length > 0){
            $('.fav-without-login').each(function(i, e){
                var sID = $(e).attr('id');
                // If this store id existed in LS then add class "saved" to this element
                if($.inArray(sID, favStores) >= 0){
                    $(this).addClass('liked');
                }
            });
            $('.item-header-favorite').find('a').addClass('have');
        }

        var saveCoupons = [];
        // If exist saveCoupons ids in LS then push to localObj saveCoupons
        if(localStorage.saveCoupons){
            saveCoupons = (localStorage.saveCoupons).split(',');
        }
        /*
         Highlight coupons saved
         */
        if(saveCoupons.length > 0){
            var arrLCSavedCP = saveCoupons;
            $('.save-cp-without-login').each(function(i, e){
                var cpID = $(e).attr('id');
                // If this store id existed in LS then add class "saved" to this element
                if($.inArray(cpID, arrLCSavedCP) >= 0){
                    $(e).addClass('saved');
                }
            });
            $('.item-header-save').find('a').addClass('have');
        }

        var likeCoupons = [];
        // If exist saveCoupons ids in LS then push to localObj saveCoupons
        if(localStorage.likeCoupons){
            likeCoupons = (localStorage.likeCoupons).split(',');
        }
        if(likeCoupons){
            var arrLikeCP = likeCoupons;
            $('.btn-like').each(function(i, e){
                var cpID = $(e).attr('c_id');
                if($.inArray(cpID, arrLikeCP) >= 0){
                    $(e).addClass('liked');
                }else{
                    $(e).removeClass('liked').addClass('like-btn');
                }
            })
        }

        var dislikeCoupons = [];
        if(localStorage.dislikeCoupons){
            dislikeCoupons = (localStorage.dislikeCoupons).split(',');
        }
        if(dislikeCoupons){
            var arrDislikeCP = dislikeCoupons;
            $('.btn-dislike').each(function(i, e){
                var cpID = $(e).attr('c_id');
                if($.inArray(cpID, arrDislikeCP) >= 0){
                    $(e).addClass('disliked');
                }else{
                    $(e).removeClass('disliked');
                }
            })
        }
    },500);
}

function likeSaveLocal($coupon_id){
    var likeCoupons = [];
    // If exist saveCoupons ids in LS then push to localObj saveCoupons
    if(localStorage.likeCoupons){
        likeCoupons = (localStorage.likeCoupons).split(',');
    }
    // Check if browser support Web storage
    if(typeof(Storage) !== "undefined") {
        var $that = $(".btn-like[c_id='"+$coupon_id+"']");
        if(!$that.hasClass('liked')){
            // Only add unique id
            if($.inArray($coupon_id, likeCoupons) == -1){
                likeCoupons.push($coupon_id);
                $(".btn-like[c_id='"+$coupon_id+"']").addClass('liked');
                var dislikeCoupons = [];
                if(localStorage.dislikeCoupons){
                    dislikeCoupons = (localStorage.dislikeCoupons).split(',');
                }
                dislikeCoupons.splice( $.inArray($(this).attr('c_id'), dislikeCoupons), 1);
                $(".btn-like[c_id='"+$coupon_id+"']").next('.btn-dislike').removeClass('disliked');
                localStorage.dislikeCoupons = dislikeCoupons;
            }

        }else{
            likeCoupons.splice( $.inArray($coupon_id, likeCoupons), 1);
            $(".btn-like[c_id='"+$coupon_id+"']").removeClass('liked');
        }
        localStorage.likeCoupons = likeCoupons;
    } else {
        console.log('No Web Storage support');
    }
    $(".btn-like[c_id='"+$coupon_id+"']").webuiPopover('destroy');
}

function unlikeCouponLocal($that){
    if(typeof(Storage) !== "undefined") {
        var likeCoupons = [];
        // If exist saveCoupons ids in LS then push to localObj saveCoupons
        if(localStorage.likeCoupons){
            likeCoupons = (localStorage.likeCoupons).split(',');
        }
        var $coupon_id = $($that).attr('c_id');
        likeCoupons.splice($.inArray($coupon_id, likeCoupons), 1);
        $($that).removeClass('liked').addClass('like-btn');
        localStorage.likeCoupons = likeCoupons;
        checkLocal();
    } else {
        console.log('No Web Storage support');
    }
}

function initGlobal() {
    truncateSomething();
    $(".flip-3d").flipCards({selector:'li, div.flip-cover'});
    $('.autoscroll').makeScroll();
    $('span[role="lsi-close"]').click(function(){$(this).parent().hide();});
    $('span[role="lsi-back"]').click(function(){
        $(this).parents('.lsi-item').children('.foldtl').removeClass('corner-clicked');
        $(this).parents('.lsi-item').children('.item-save-icon').removeClass('corner-clicked');
    });
    $('h3.lsi-item-title, div.lsi-item-content').each(function() {
        var $el = $(this);

        $el.truncate({
            lines: 2,
            lineHeight: 25
        });
        $el.on('mouseenter touchstart', function () {
            $el.truncate('expand');
            $el.addClass('extra');
            return false;
        });
        $el.on('mouseleave touchend', function () {
            $el.truncate('collapse');
            $el.removeClass('extra');
            return false;
        });
    });

    $('a[role="itm-cm"]').click(function(){
        $(this).parents('.foldtl').find('.lsi-btn-get').click();
        $(this).parents('.lsi-item').find('.' + $(this).attr('data-rel')).show();
    });

    $('button[role="itm"]').click(function(){
        $(this).parents('.lsi-control').find('div.lsi-elements').hide();
        $(this).parents('.lsi-control').find('.' + $(this).attr('data-rel')).show();
    });

    $('input[role="selectAll"]').click(function(){this.select();});

    /* register bind function autoCopy to clipboard or autoSelectAll text when adobe flash is not installed */
    if(!FlashDetect.installed){
        $('.click[role="setCopybyClick"]').click(function(){
            $(this).addClass('clicked');
            $('.voucher-item').find('.get-code').removeClass('selected');
            $(this).parents('.code-copy').find('input[role="selectAll"]').select();
        });
        $('.click[role="setCopy"]').click(function(){
            $('.voucher-item').find('.get-code').removeClass('selected');
            $(this).parents('.get-code').addClass('selected').find('input[role="selectAll"]').select();
        })

    }else{
        ZeroClipboard.config({moviePath: _getDefaultSwfPath()});
        var clientCopy = new ZeroClipboard($('[role="btn-get-code"]'));
        clientCopy.on("mouseout",function(){
            $(this).animate({width:'55px',height:'55px'}, 200);
        }),
            clientCopy.on("mouseover",function(){
                $(this).animate({width:'60px', height:'60px'}, 200);
            }),
            clientCopy.on("dataRequested",function(client){
                var c = $(this).parents('.lsi-item').find('input[role="selectAll"]').val();
                client.setText(c);
                $('.voucher-item').find('.get-code').removeClass('copied');
                $('.list-store-items').find('.code-mask').removeClass('bg-copied');
                //$(this).parents('.lsi-item').find('.code-mask').addClass('bg-copied');
            }),
            clientCopy.on("complete",function(){
                $(this).click();
            });

        var clientCopy = new ZeroClipboard($('.click[role="setCopybyClick"]'));
        clientCopy.on("dataRequested",function(client){
            var c = $(this).parent().find('input[role="selectAll"]').val();
            clientCopy.setText(c);
            $('.voucher-item').find('.get-code').removeClass('copied');
            $('.list-store-items').find('.code-mask').removeClass('bg-copied');
            $(this).parents('.lsi-item').find('.code-mask').addClass('bg-copied');
        }),
            clientCopy.on("complete",function(){
                $(this).click();
            });

        var clientCopy = new ZeroClipboard($('.click[role="setCopy"]'));
        clientCopy.on("dataRequested",function(client){
            var c = $(this).parent().find('input[role="selectAll"]').val();
            clientCopy.setText(c);
        }),
            clientCopy.on("complete",function(){
                $(this).click();
            });
    }
    /* effect click and hover on corner get button in list Iteam */
    $(".lsi-btn-get").each(function(i, els) {
        var maw = 60, mah = 60, miw = 55, mih = 55;
        if(!FlashDetect.installed){
            $(els).hover(function() {
                $(this).animate({width: maw+'px', height: mah+'px'}, 200);
            }, function() {
                $(els).animate({width: miw+'px',height: mih+'px'}, 200);
            });
        }else{
            if($(els).has('[role!="btn-get-code"]')){
                $(els).hover(function() {
                    $(els).animate({width: maw+'px', height: mah+'px'}, 200);
                }, function() {
                    $(els).animate({width: miw+'px',height: mih+'px'}, 200);
                });
            }
        }
        $(els).click(function() {
            var el = this;
            $(el).children('span').hide();
            var h = $(el).parent('.foldtl').height()*1.8;
            var w = $(el).parent('.foldtl').width()*1.8;
            $(el).animate({width: w + 'px', height: h + 'px'}, {
                start: function(){
                    $(el).parent('.foldtl').animate({opacity: 0.4});
                    $(el).parents('.lsi-item').children('.item-save-icon').animate({opacity: 0.4});
                    $('.lsi-item').each(function(i, e) {
                        $(e).find('.item-save-icon').animate({opacity: 1});
                        $(e).find('.foldtl').animate({opacity: 1});
                        $(e).find('.corner-clicked').removeClass('corner-clicked');
                        $(e).find('div.lsi-elements').hide();
                        $(e).find('.lsi-btn-get').animate({width: miw+'px',height: mih+'px'});
                        $(e).find('.lsi-btn-get span').show();
                    });
                },
                complete: function(){
                    $(el).parent('.foldtl').addClass('corner-clicked');
                    $(el).parents('.lsi-item').children('.item-save-icon').addClass('corner-clicked');
                }
            });
        });
    });
}
function convertTimeAgo() {
    /*var d = new Date();
    var n = d.getTimezoneOffset() / 60;
    if (n >= 0) {
        n = '0' + n;
        n = '+' + n.substr(n.length - 2);
    } else {
        n = '0' + Math.abs(n);
        n = '-' + n.substr(n.length - 2);
    }
    n = '';*/
    $('.timeago').each(function () {
        var $that = $(this);
        if ($that.attr('title').indexOf('Z') > -1) {
        }else
            $that.attr('title',$that.attr('title') + 'Z');
        $that.timeago();
    });
}
function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function addQSParm(paramName, paramValue)
{
    var url = window.location.href;
    if (url.indexOf(paramName + "=") >= 0)
    {
        var prefix = url.substring(0, url.indexOf(paramName));
        var suffix = url.substring(url.indexOf(paramName));
        suffix = suffix.substring(suffix.indexOf("=") + 1);
        suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
        url = prefix + paramName + "=" + paramValue + suffix;
    }
    else
    {
        if (url.indexOf("?") < 0)
            url += "?" + paramName + "=" + paramValue;
        else
            url += "&" + paramName + "=" + paramValue;
    }
    window.location.href = url;
}

$.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

/****************** For function extension ********************/
var _window = window, _document = _window.document, _Error = _window.Error;
/**
 * Get the presumed location of the "ZeroClipboard.swf" file, based on the location
 * of the executing JavaScript file (e.g. "ZeroClipboard.js", etc.).
 *
 * @returns String
 * @private
 */
var _getDefaultSwfPath = function() {
	var jsDir = _getDirPathOfUrl(_getCurrentScriptUrl()) || _getUnanimousScriptParentDir() || "";
	return jsDir + "ZeroClipboard.swf";
};
/**
 * Get the URL path's parent directory.
 *
 * @returns String or `undefined`
 * @private
 * Copyright 2015 MC Corp Team
 * Contributing Author: Pham Hung Cuong
 */
var _getDirPathOfUrl = function(url) {
	var dir;
	if (typeof url === "string" && url) {
		dir = url.split("#")[0].split("?")[0];
		dir = url.slice(0, url.lastIndexOf("/") + 1);
	}
	return dir;
};
/**
 * Get the current script's URL by throwing an `Error` and analyzing it.
 *
 * @returns String or `undefined`
 * @private
 */
var _getCurrentScriptUrlFromErrorStack = function(stack) {
	var url, matches;
	if (typeof stack === "string" && stack) {
		matches = stack.match(/^(?:|[^:@]*@|.+\)@(?=http[s]?|file)|.+?\s+(?: at |@)(?:[^:\(]+ )*[\(]?)((?:http[s]?|file):\/\/[\/]?.+?\/[^:\)]*?)(?::\d+)(?::\d+)?/);
		if (matches && matches[1]) {
			url = matches[1];
		} else {
			matches = stack.match(/\)@((?:http[s]?|file):\/\/[\/]?.+?\/[^:\)]*?)(?::\d+)(?::\d+)?/);
			if (matches && matches[1]) {
				url = matches[1];
			}
		}
	}
	return url;
};
  /**
 * Get the current script's URL by throwing an `Error` and analyzing it.
 *
 * @returns String or `undefined`
 * @private
 */
var _getCurrentScriptUrlFromError = function() {
	var url, err;
	try {
		throw new _Error();
	} catch (e) {
		err = e;
	}
	if (err) {
		url = err.sourceURL || err.fileName || _getCurrentScriptUrlFromErrorStack(err.stack);
	}
	return url;
};

/**
* Get the current script's URL.
*
* @returns String or `undefined`
* @private
*/
var _getCurrentScriptUrl = function() {
	var jsPath, scripts, i;
	if (_document.currentScript && (jsPath = _document.currentScript.src)) {
		return jsPath;
	}
	scripts = _document.getElementsByTagName("script");
	if (scripts.length === 1) {
		return scripts[0].src || undefined;
	}
	if ("readyState" in scripts[0]) {
		for (i = scripts.length; i--; ) {
			if (scripts[i].readyState === "interactive" && (jsPath = scripts[i].src)) {
				return jsPath;
			}
		}
	}
	if (_document.readyState === "loading" && (jsPath = scripts[scripts.length - 1].src)) {
		return jsPath;
	}
	if (jsPath = _getCurrentScriptUrlFromError()) {
		return jsPath;
	}
	return undefined;
};
/**
* Get the unanimous parent directory of ALL script tags.
* If any script tags are either (a) inline or (b) from differing parent
* directories, this method must return `undefined`.
*
* @returns String or `undefined`
* @private
*/
var _getUnanimousScriptParentDir = function() {
	var i, jsDir, jsPath, scripts = _document.getElementsByTagName("script");
	for (i = scripts.length; i--; ) {
		if (!(jsPath = scripts[i].src)) {
			jsDir = null;
			break;
		}
		jsPath = _getDirPathOfUrl(jsPath);
		if (jsDir == null) {
			jsDir = jsPath;
		} else if (jsDir !== jsPath) {
			jsDir = null;
			break;
		}
	}
	return jsDir || undefined;
};

/**
* Function auto affix header toolbar
* Contributing Author: Pham Hung Cuong
**/
$(function(){
	var _top = $(window).scrollTop();
	$(window).scroll(function(){
		if ($('body').width() < 768) {
			var _cur_top = $(window).scrollTop();
			_top < _cur_top ? (_top > 55 ? $('#navbar-main').css('top', -100) : '') : $('#navbar-main').css('top', 0);
			_top = _cur_top;
		}else{
			$('#navbar-main').css('top', 0);
		}
	});
});

/*
 * jQuery flyingItem to Cart
 * Copyright 2015 MC Corp Team
 * Contributing Author: Pham Hung Cuong
 */
(function($){
	"use strict";
	var defaultSettings = {cartSelector:'.btn-header-extra', cartSelectorMobile:'.btn-header-extra-mobile', hasIgnore:'', titleChange:'', callBack:function(){}};
	$.fn.flyingItem = function(options){
		var settings = $.extend({}, defaultSettings, options);
		$(this).on('click', function(){
            settings.type = settings.hasIgnore == 'liked' ? '.item-header-favorite' : '.item-header-save';
            settings.isMobile = $(settings.cartSelector).is(':visible') ? settings.cartSelector : settings.cartSelectorMobile;
			var cart = $(settings.isMobile + '>' + settings.type + '>a');
			var imgtodrag = $(this);
			if (!$(this).hasClass(settings.hasIgnore)) {
				var imgclone = imgtodrag.clone().offset({top: imgtodrag.offset().top, left: imgtodrag.offset().left})
					.css({'opacity': '0.8','position': 'absolute','z-index': '99999', color:'#fa5064', 'font-size':'30px'})
					.appendTo($('body'))
					.animate({'top': cart.offset().top, 'left': cart.offset().left},1000, 'easeInOutExpo');
				setTimeout(function(){cart.addClass('have').find('i').effect("shake", {times: 3}, 500)}, 1500);
				imgclone.animate({'width': 0,'height': 0}, function () {$(this).detach()});
				settings.titleChange ? $(this).attr('data-original-title', settings.titleChange):'';
				settings.callBack();
			}
		});
	};
})(jQuery);

/*
 * jQuery flipCards 3D tranformer
 * Copyright 2015 MC Corp Team
 * Contributing Author: Pham Hung Cuong
 */
(function($){
	"use strict";
	/* Object Instance */
  	var defaultSettings = {delay: 5, selector: 'li', childCover:'figure', classControl: 'hovered', timeScroll: 200};
	/*function flipElementSwicher(elem, settings){elem.hasClass(settings.classControl)?elem.removeClass(settings.classControl):elem.addClass(settings.classControl);}*/
	function makeFlip(elem, settings){$(elem).find(settings.childCover).addClass(settings.classControl);}
	function makeUnFlip(elem, settings){$(elem).find(settings.childCover).removeClass(settings.classControl);}
	$.fn.flipCards = function(options){
		var subjectElements, settings;
		subjectElements = $(this);
		settings = $.extend({}, defaultSettings, options);
		subjectElements.children(settings.selector).each(function() {
			var elem = $(this);
			elem.on('mouseover touchstart', function(){
				makeFlip(elem, settings);
			});
			elem.on('mouseout touchend', function(){
				makeUnFlip(elem, settings);
			});
		});
		setTimeout(function(){
			subjectElements.children(settings.selector).each(function(i, el) {
				setTimeout(function(){makeUnFlip(el, settings);},settings.timeScroll+(i*settings.timeScroll));
			});
		}, settings.delay*1000);
	}
})(jQuery);

/* jQuery Scrollbar */
(function($){
	$.fn.makeScroll = function(){
		return this.each(function(){
			$(this).data('scrollbar', new Scrollbar({el : this}));
		});
	}
	var Scrollbar = function(opts){
		this.$el = $(this.el = opts.el);
		this.$el
			.addClass('scrollbar__container')
			.before(
				this.$wrapper = $('<div class="scrollbar" />')
			)
			.appendTo(this.$wrapper)

		if(isTouchDevice()){
			this.$wrapper.addClass('scrollbar_mode_mobile');

		}else{
			this.$el.after(
				this.$track = $('<div class="scrollbar__track" />').append(
					this.$handle = $('<div class="scrollbar__handle" />')
				)
			);

			this.refresh();
			this.bindHandle();
			this.bindWheel();
			this.bindScrollTap();
			//this.bindTouch();
			this.$el.on('scroll', this.refresh.bind(this));
		}
	};

	Scrollbar.prototype = {
		refresh : function(){
			var height = this.el.offsetHeight,
				scrollHeight = this.el.scrollHeight,
				trackHeight = this.$track.height();

			this.$handle
				.height(height*100/scrollHeight + '%')
				.css('top', (this.handleTop = (this.el.scrollTop / this.el.scrollHeight * trackHeight)) + 'px');
		},

		bindHandle : function(){
			this.$handle.on('mousedown', function(e){
				this.startHandleMove({position : e.pageY});
				return false;
			}.bind(this));

			$(this).on({
				startMove : function(){
					this.$wrapper.addClass('scrollbar_state_move');
				},
				stopMove : function(){
					this.$wrapper.removeClass('scrollbar_state_move');
				}
			});
		},
		startHandleMove : function(opts){
			$(this).trigger('startMove');
			$(window)
				.on('mousemove.scrollbarMove', function(e){
					var movement = e.originalEvent.webkitMovementY || (e.pageY - opts.position),
						trackHeight = this.$track.height(),
						percentMovement = movement / trackHeight,
						scrollHeight = this.el.scrollHeight,
						scrollMovement = scrollHeight * percentMovement;

					opts.position = e.pageY;
					this.$el.scrollTop (this.$el.scrollTop() + scrollMovement);
					//this.refresh();
				}.bind(this))

				.on('mouseup.scrollbarMove blur.scrollbarMove', function(){
					$(window).off('.scrollbarMove');
					$(this).trigger('stopMove');
				}.bind(this));
		},

		wheelStep : 30,
		bindWheel : function(){
			this.$wrapper.on('mousewheel', function(e){
				this.$el.scrollTop(this.$el.scrollTop() - e.deltaY * this.wheelStep);
			}.bind(this));
		},

		bindScrollTap : function(){
			this.$track.on('mousedown', function(e){
				if(e.target !== this.$track[0]) return;
				var value = (e.offsetY > this.handleTop) ? 1 : -1;
				this.tapTimer(value)
				e.preventDefault();
				$(document).on('blur.tap mouseup.tap mouseleave.tap', function(){
					$(document).off('.tap');
					clearTimeout(this._tapTimer);
				}.bind(this));
			}.bind(this));
		},
		tapTimeout : 200,
		tapTimer : function(value){
			this.tap(value);
			this._tapTimer = setTimeout(this.tapTimer.bind(this, value), this.tapTimeout);
		},
		tap : function(c){
			this.$el.scrollTop(this.el.scrollTop + this.el.offsetHeight * c);
		}/*,
		bindTouch : function(){
			if(!isTouchDevice()) return;

			$(this).trigger('startMove');
			this.$wrapper.on('touchstart', function(e){
				this.startTouchMove({position : e.originalEvent.touches[0].pageY});
				e.preventDefault();
			}.bind(this));
		},
		startTouchMove : function(opts){
			$(window).on('touchmove.touch', function(e){
				var movement = e.originalEvent.touches[0].pageY - opts.position;
				opts.position = e.originalEvent.touches[0].pageY;
				this.$el.scrollTop(this.$el.scrollTop() - movement);

				$(window).on('touchend.touch touchcancel.touch', function(){
					$(window).off('.touch');
					$(this).trigger('stopMove');
				}.bind(this));
			}.bind(this));
		}*/
	};
})(jQuery);

var isTouchDevice = function(){
	try{
		document.createEvent("TouchEvent");
		return true;
	}catch(e){
		return false;
	}
};

/*! Copyright (c) 2013 Brandon Aaron (http://brandon.aaron.sh)
 * Licensed under the MIT License (LICENSE.txt).
 * Mousewheel js is a Supporter for the Scrollbar when the Browser is not support it.
 * Version: 3.1.11
 * Requires: jQuery 1.2.2+
 */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?module.exports=a:a(jQuery)}(function(a){function b(b){var g=b||window.event,h=i.call(arguments,1),j=0,l=0,m=0,n=0,o=0,p=0;if(b=a.event.fix(g),b.type="mousewheel","detail"in g&&(m=-1*g.detail),"wheelDelta"in g&&(m=g.wheelDelta),"wheelDeltaY"in g&&(m=g.wheelDeltaY),"wheelDeltaX"in g&&(l=-1*g.wheelDeltaX),"axis"in g&&g.axis===g.HORIZONTAL_AXIS&&(l=-1*m,m=0),j=0===m?l:m,"deltaY"in g&&(m=-1*g.deltaY,j=m),"deltaX"in g&&(l=g.deltaX,0===m&&(j=-1*l)),0!==m||0!==l){if(1===g.deltaMode){var q=a.data(this,"mousewheel-line-height");j*=q,m*=q,l*=q}else if(2===g.deltaMode){var r=a.data(this,"mousewheel-page-height");j*=r,m*=r,l*=r}if(n=Math.max(Math.abs(m),Math.abs(l)),(!f||f>n)&&(f=n,d(g,n)&&(f/=40)),d(g,n)&&(j/=40,l/=40,m/=40),j=Math[j>=1?"floor":"ceil"](j/f),l=Math[l>=1?"floor":"ceil"](l/f),m=Math[m>=1?"floor":"ceil"](m/f),k.settings.normalizeOffset&&this.getBoundingClientRect){var s=this.getBoundingClientRect();o=b.clientX-s.left,p=b.clientY-s.top}return b.deltaX=l,b.deltaY=m,b.deltaFactor=f,b.offsetX=o,b.offsetY=p,b.deltaMode=0,h.unshift(b,j,l,m),e&&clearTimeout(e),e=setTimeout(c,200),(a.event.dispatch||a.event.handle).apply(this,h)}}function c(){f=null}function d(a,b){return k.settings.adjustOldDeltas&&"mousewheel"===a.type&&b%120===0}var e,f,g=["wheel","mousewheel","DOMMouseScroll","MozMousePixelScroll"],h="onwheel"in document||document.documentMode>=9?["wheel"]:["mousewheel","DomMouseScroll","MozMousePixelScroll"],i=Array.prototype.slice;if(a.event.fixHooks)for(var j=g.length;j;)a.event.fixHooks[g[--j]]=a.event.mouseHooks;var k=a.event.special.mousewheel={version:"3.1.11",setup:function(){if(this.addEventListener)for(var c=h.length;c;)this.addEventListener(h[--c],b,!1);else this.onmousewheel=b;a.data(this,"mousewheel-line-height",k.getLineHeight(this)),a.data(this,"mousewheel-page-height",k.getPageHeight(this))},teardown:function(){if(this.removeEventListener)for(var c=h.length;c;)this.removeEventListener(h[--c],b,!1);else this.onmousewheel=null;a.removeData(this,"mousewheel-line-height"),a.removeData(this,"mousewheel-page-height")},getLineHeight:function(b){var c=a(b)["offsetParent"in a.fn?"offsetParent":"parent"]();return c.length||(c=a("body")),parseInt(c.css("fontSize"),10)},getPageHeight:function(b){return a(b).height()},settings:{adjustOldDeltas:!0,normalizeOffset:!0}};a.fn.extend({mousewheel:function(a){return a?this.bind("mousewheel",a):this.trigger("mousewheel")},unmousewheel:function(a){return this.unbind("mousewheel",a)}})});

/*!
* ZeroClipboard
* The ZeroClipboard library provides an easy way to copy text to the clipboard using an invisible Adobe Flash movie and a JavaScript interface.
* Copyright (c) 2014 Jon Rohan, James M. Greene
* Licensed MIT
* http://zeroclipboard.org/
* v1.3.5
*/
!function(a){"use strict";function b(a){return a.replace(/,/g,".").replace(/[^0-9\.]/g,"")}function c(a){return parseFloat(b(a))>=10}var d,e={bridge:null,version:"0.0.0",disabled:null,outdated:null,ready:null},f={},g=0,h={},i=0,j={},k=null,l=null,m=function(){var a,b,c,d,e="ZeroClipboard.swf";if(document.currentScript&&(d=document.currentScript.src));else{var f=document.getElementsByTagName("script");if("readyState"in f[0])for(a=f.length;a--&&("interactive"!==f[a].readyState||!(d=f[a].src)););else if("loading"===document.readyState)d=f[f.length-1].src;else{for(a=f.length;a--;){if(c=f[a].src,!c){b=null;break}if(c=c.split("#")[0].split("?")[0],c=c.slice(0,c.lastIndexOf("/")+1),null==b)b=c;else if(b!==c){b=null;break}}null!==b&&(d=b)}}return d&&(d=d.split("#")[0].split("?")[0],e=d.slice(0,d.lastIndexOf("/")+1)+e),e}(),n=function(){var a=/\-([a-z])/g,b=function(a,b){return b.toUpperCase()};return function(c){return c.replace(a,b)}}(),o=function(b,c){var d,e,f;return a.getComputedStyle?d=a.getComputedStyle(b,null).getPropertyValue(c):(e=n(c),d=b.currentStyle?b.currentStyle[e]:b.style[e]),"cursor"!==c||d&&"auto"!==d||(f=b.tagName.toLowerCase(),"a"!==f)?d:"pointer"},p=function(b){b||(b=a.event);var c;this!==a?c=this:b.target?c=b.target:b.srcElement&&(c=b.srcElement),K.activate(c)},q=function(a,b,c){a&&1===a.nodeType&&(a.addEventListener?a.addEventListener(b,c,!1):a.attachEvent&&a.attachEvent("on"+b,c))},r=function(a,b,c){a&&1===a.nodeType&&(a.removeEventListener?a.removeEventListener(b,c,!1):a.detachEvent&&a.detachEvent("on"+b,c))},s=function(a,b){if(!a||1!==a.nodeType)return a;if(a.classList)return a.classList.contains(b)||a.classList.add(b),a;if(b&&"string"==typeof b){var c=(b||"").split(/\s+/);if(1===a.nodeType)if(a.className){for(var d=" "+a.className+" ",e=a.className,f=0,g=c.length;g>f;f++)d.indexOf(" "+c[f]+" ")<0&&(e+=" "+c[f]);a.className=e.replace(/^\s+|\s+$/g,"")}else a.className=b}return a},t=function(a,b){if(!a||1!==a.nodeType)return a;if(a.classList)return a.classList.contains(b)&&a.classList.remove(b),a;if(b&&"string"==typeof b||void 0===b){var c=(b||"").split(/\s+/);if(1===a.nodeType&&a.className)if(b){for(var d=(" "+a.className+" ").replace(/[\n\t]/g," "),e=0,f=c.length;f>e;e++)d=d.replace(" "+c[e]+" "," ");a.className=d.replace(/^\s+|\s+$/g,"")}else a.className=""}return a},u=function(){var a,b,c,d=1;return"function"==typeof document.body.getBoundingClientRect&&(a=document.body.getBoundingClientRect(),b=a.right-a.left,c=document.body.offsetWidth,d=Math.round(b/c*100)/100),d},v=function(b,c){var d={left:0,top:0,width:0,height:0,zIndex:B(c)-1};if(b.getBoundingClientRect){var e,f,g,h=b.getBoundingClientRect();"pageXOffset"in a&&"pageYOffset"in a?(e=a.pageXOffset,f=a.pageYOffset):(g=u(),e=Math.round(document.documentElement.scrollLeft/g),f=Math.round(document.documentElement.scrollTop/g));var i=document.documentElement.clientLeft||0,j=document.documentElement.clientTop||0;d.left=h.left+e-i,d.top=h.top+f-j,d.width="width"in h?h.width:h.right-h.left,d.height="height"in h?h.height:h.bottom-h.top}return d},w=function(a,b){var c=null==b||b&&b.cacheBust===!0&&b.useNoCache===!0;return c?(-1===a.indexOf("?")?"?":"&")+"noCache="+(new Date).getTime():""},x=function(b){var c,d,e,f=[],g=[],h=[];if(b.trustedOrigins&&("string"==typeof b.trustedOrigins?g.push(b.trustedOrigins):"object"==typeof b.trustedOrigins&&"length"in b.trustedOrigins&&(g=g.concat(b.trustedOrigins))),b.trustedDomains&&("string"==typeof b.trustedDomains?g.push(b.trustedDomains):"object"==typeof b.trustedDomains&&"length"in b.trustedDomains&&(g=g.concat(b.trustedDomains))),g.length)for(c=0,d=g.length;d>c;c++)if(g.hasOwnProperty(c)&&g[c]&&"string"==typeof g[c]){if(e=E(g[c]),!e)continue;if("*"===e){h=[e];break}h.push.apply(h,[e,"//"+e,a.location.protocol+"//"+e])}return h.length&&f.push("trustedOrigins="+encodeURIComponent(h.join(","))),"string"==typeof b.jsModuleId&&b.jsModuleId&&f.push("jsModuleId="+encodeURIComponent(b.jsModuleId)),f.join("&")},y=function(a,b,c){if("function"==typeof b.indexOf)return b.indexOf(a,c);var d,e=b.length;for("undefined"==typeof c?c=0:0>c&&(c=e+c),d=c;e>d;d++)if(b.hasOwnProperty(d)&&b[d]===a)return d;return-1},z=function(a){if("string"==typeof a)throw new TypeError("ZeroClipboard doesn't accept query strings.");return a.length?a:[a]},A=function(b,c,d,e){e?a.setTimeout(function(){b.apply(c,d)},0):b.apply(c,d)},B=function(a){var b,c;return a&&("number"==typeof a&&a>0?b=a:"string"==typeof a&&(c=parseInt(a,10))&&!isNaN(c)&&c>0&&(b=c)),b||("number"==typeof N.zIndex&&N.zIndex>0?b=N.zIndex:"string"==typeof N.zIndex&&(c=parseInt(N.zIndex,10))&&!isNaN(c)&&c>0&&(b=c)),b||0},C=function(a,b){if(a&&b!==!1&&"undefined"!=typeof console&&console&&(console.warn||console.log)){var c="`"+a+"` is deprecated. See docs for more info:\n    https://github.com/zeroclipboard/zeroclipboard/blob/master/docs/instructions.md#deprecations";console.warn?console.warn(c):console.log(c)}},D=function(){var a,b,c,d,e,f,g=arguments[0]||{};for(a=1,b=arguments.length;b>a;a++)if(null!=(c=arguments[a]))for(d in c)if(c.hasOwnProperty(d)){if(e=g[d],f=c[d],g===f)continue;void 0!==f&&(g[d]=f)}return g},E=function(a){if(null==a||""===a)return null;if(a=a.replace(/^\s+|\s+$/g,""),""===a)return null;var b=a.indexOf("//");a=-1===b?a:a.slice(b+2);var c=a.indexOf("/");return a=-1===c?a:-1===b||0===c?null:a.slice(0,c),a&&".swf"===a.slice(-4).toLowerCase()?null:a||null},F=function(){var a=function(a,b){var c,d,e;if(null!=a&&"*"!==b[0]&&("string"==typeof a&&(a=[a]),"object"==typeof a&&"length"in a))for(c=0,d=a.length;d>c;c++)if(a.hasOwnProperty(c)&&(e=E(a[c]))){if("*"===e){b.length=0,b.push("*");break}-1===y(e,b)&&b.push(e)}},b={always:"always",samedomain:"sameDomain",never:"never"};return function(c,d){var e,f=d.allowScriptAccess;if("string"==typeof f&&(e=f.toLowerCase())&&/^always|samedomain|never$/.test(e))return b[e];var g=E(d.moviePath);null===g&&(g=c);var h=[];a(d.trustedOrigins,h),a(d.trustedDomains,h);var i=h.length;if(i>0){if(1===i&&"*"===h[0])return"always";if(-1!==y(c,h))return 1===i&&c===g?"sameDomain":"always"}return"never"}}(),G=function(a){if(null==a)return[];if(Object.keys)return Object.keys(a);var b=[];for(var c in a)a.hasOwnProperty(c)&&b.push(c);return b},H=function(a){if(a)for(var b in a)a.hasOwnProperty(b)&&delete a[b];return a},I=function(){try{return document.activeElement}catch(a){}return null},J=function(){var a=!1;if("boolean"==typeof e.disabled)a=e.disabled===!1;else{if("function"==typeof ActiveXObject)try{new ActiveXObject("ShockwaveFlash.ShockwaveFlash")&&(a=!0)}catch(b){}!a&&navigator.mimeTypes["application/x-shockwave-flash"]&&(a=!0)}return a},K=function(a,b){return this instanceof K?(this.id=""+g++,h[this.id]={instance:this,elements:[],handlers:{}},a&&this.clip(a),"undefined"!=typeof b&&(C("new ZeroClipboard(elements, options)",N.debug),K.config(b)),this.options=K.config(),"boolean"!=typeof e.disabled&&(e.disabled=!J()),void(e.disabled===!1&&e.outdated!==!0&&null===e.bridge&&(e.outdated=!1,e.ready=!1,O()))):new K(a,b)};K.prototype.setText=function(a){return a&&""!==a&&(f["text/plain"]=a,e.ready===!0&&e.bridge&&"function"==typeof e.bridge.setText?e.bridge.setText(a):e.ready=!1),this},K.prototype.setSize=function(a,b){return e.ready===!0&&e.bridge&&"function"==typeof e.bridge.setSize?e.bridge.setSize(a,b):e.ready=!1,this};var L=function(a){e.ready===!0&&e.bridge&&"function"==typeof e.bridge.setHandCursor?e.bridge.setHandCursor(a):e.ready=!1};K.prototype.destroy=function(){this.unclip(),this.off(),delete h[this.id]};var M=function(){var a,b,c,d=[],e=G(h);for(a=0,b=e.length;b>a;a++)c=h[e[a]].instance,c&&c instanceof K&&d.push(c);return d};K.version="1.3.5";var N={swfPath:m,trustedDomains:a.location.host?[a.location.host]:[],cacheBust:!0,forceHandCursor:!1,zIndex:999999999,debug:!0,title:null,autoActivate:!0};K.config=function(a){if("object"==typeof a&&null!==a&&D(N,a),"string"!=typeof a||!a){var b={};for(var c in N)N.hasOwnProperty(c)&&(b[c]="object"==typeof N[c]&&null!==N[c]?"length"in N[c]?N[c].slice(0):D({},N[c]):N[c]);return b}return N.hasOwnProperty(a)?N[a]:void 0},K.destroy=function(){K.deactivate();for(var a in h)if(h.hasOwnProperty(a)&&h[a]){var b=h[a].instance;b&&"function"==typeof b.destroy&&b.destroy()}var c=P(e.bridge);c&&c.parentNode&&(c.parentNode.removeChild(c),e.ready=null,e.bridge=null)},K.activate=function(a){d&&(t(d,N.hoverClass),t(d,N.activeClass)),d=a,s(a,N.hoverClass),Q();var b=N.title||a.getAttribute("title");if(b){var c=P(e.bridge);c&&c.setAttribute("title",b)}var f=N.forceHandCursor===!0||"pointer"===o(a,"cursor");L(f)},K.deactivate=function(){var a=P(e.bridge);a&&(a.style.left="0px",a.style.top="-9999px",a.removeAttribute("title")),d&&(t(d,N.hoverClass),t(d,N.activeClass),d=null)};var O=function(){var b,c,d=document.getElementById("global-zeroclipboard-html-bridge");if(!d){var f=K.config();f.jsModuleId="string"==typeof k&&k||"string"==typeof l&&l||null;var g=F(a.location.host,N),h=x(f),i=N.moviePath+w(N.moviePath,N),j='<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" id="global-zeroclipboard-flash-bridge" width="100%" height="100%"><param name="movie" value="'+i+'"/><param name="allowScriptAccess" value="'+g+'"/><param name="scale" value="exactfit"/><param name="loop" value="false"/><param name="menu" value="false"/><param name="quality" value="best" /><param name="bgcolor" value="#ffffff"/><param name="wmode" value="transparent"/><param name="flashvars" value="'+h+'"/><embed src="'+i+'" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="100%" height="100%" name="global-zeroclipboard-flash-bridge" allowScriptAccess="'+g+'"           allowFullScreen="false" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer"           flashvars="'+h+'" scale="exactfit"></embed></object>';d=document.createElement("div"),d.id="global-zeroclipboard-html-bridge",d.setAttribute("class","global-zeroclipboard-container"),d.style.position="absolute",d.style.left="0px",d.style.top="-9999px",d.style.width="15px",d.style.height="15px",d.style.zIndex=""+B(N.zIndex),document.body.appendChild(d),d.innerHTML=j}b=document["global-zeroclipboard-flash-bridge"],b&&(c=b.length)&&(b=b[c-1]),e.bridge=b||d.children[0].lastElementChild},P=function(a){for(var b=/^OBJECT|EMBED$/,c=a&&a.parentNode;c&&b.test(c.nodeName)&&c.parentNode;)c=c.parentNode;return c||null},Q=function(){if(d){var a=v(d,N.zIndex),b=P(e.bridge);b&&(b.style.top=a.top+"px",b.style.left=a.left+"px",b.style.width=a.width+"px",b.style.height=a.height+"px",b.style.zIndex=a.zIndex+1),e.ready===!0&&e.bridge&&"function"==typeof e.bridge.setSize?e.bridge.setSize(a.width,a.height):e.ready=!1}return this};K.prototype.on=function(a,b){var c,d,f,g={},i=h[this.id]&&h[this.id].handlers;if("string"==typeof a&&a)f=a.toLowerCase().split(/\s+/);else if("object"==typeof a&&a&&"undefined"==typeof b)for(c in a)a.hasOwnProperty(c)&&"string"==typeof c&&c&&"function"==typeof a[c]&&this.on(c,a[c]);if(f&&f.length){for(c=0,d=f.length;d>c;c++)a=f[c].replace(/^on/,""),g[a]=!0,i[a]||(i[a]=[]),i[a].push(b);g.noflash&&e.disabled&&T.call(this,"noflash",{}),g.wrongflash&&e.outdated&&T.call(this,"wrongflash",{flashVersion:e.version}),g.load&&e.ready&&T.call(this,"load",{flashVersion:e.version})}return this},K.prototype.off=function(a,b){var c,d,e,f,g,i=h[this.id]&&h[this.id].handlers;if(0===arguments.length)f=G(i);else if("string"==typeof a&&a)f=a.split(/\s+/);else if("object"==typeof a&&a&&"undefined"==typeof b)for(c in a)a.hasOwnProperty(c)&&"string"==typeof c&&c&&"function"==typeof a[c]&&this.off(c,a[c]);if(f&&f.length)for(c=0,d=f.length;d>c;c++)if(a=f[c].toLowerCase().replace(/^on/,""),g=i[a],g&&g.length)if(b)for(e=y(b,g);-1!==e;)g.splice(e,1),e=y(b,g,e);else i[a].length=0;return this},K.prototype.handlers=function(a){var b,c=null,d=h[this.id]&&h[this.id].handlers;if(d){if("string"==typeof a&&a)return d[a]?d[a].slice(0):null;c={};for(b in d)d.hasOwnProperty(b)&&d[b]&&(c[b]=d[b].slice(0))}return c};var R=function(b,c,d,e){var f=h[this.id]&&h[this.id].handlers[b];if(f&&f.length){var g,i,j,k=c||this;for(g=0,i=f.length;i>g;g++)j=f[g],c=k,"string"==typeof j&&"function"==typeof a[j]&&(j=a[j]),"object"==typeof j&&j&&"function"==typeof j.handleEvent&&(c=j,j=j.handleEvent),"function"==typeof j&&A(j,c,d,e)}return this};K.prototype.clip=function(a){a=z(a);for(var b=0;b<a.length;b++)if(a.hasOwnProperty(b)&&a[b]&&1===a[b].nodeType){a[b].zcClippingId?-1===y(this.id,j[a[b].zcClippingId])&&j[a[b].zcClippingId].push(this.id):(a[b].zcClippingId="zcClippingId_"+i++,j[a[b].zcClippingId]=[this.id],N.autoActivate===!0&&q(a[b],"mouseover",p));var c=h[this.id].elements;-1===y(a[b],c)&&c.push(a[b])}return this},K.prototype.unclip=function(a){var b=h[this.id];if(b){var c,d=b.elements;a="undefined"==typeof a?d.slice(0):z(a);for(var e=a.length;e--;)if(a.hasOwnProperty(e)&&a[e]&&1===a[e].nodeType){for(c=0;-1!==(c=y(a[e],d,c));)d.splice(c,1);var f=j[a[e].zcClippingId];if(f){for(c=0;-1!==(c=y(this.id,f,c));)f.splice(c,1);0===f.length&&(N.autoActivate===!0&&r(a[e],"mouseover",p),delete a[e].zcClippingId)}}}return this},K.prototype.elements=function(){var a=h[this.id];return a&&a.elements?a.elements.slice(0):[]};var S=function(a){var b,c,d,e,f,g=[];if(a&&1===a.nodeType&&(b=a.zcClippingId)&&j.hasOwnProperty(b)&&(c=j[b],c&&c.length))for(d=0,e=c.length;e>d;d++)f=h[c[d]].instance,f&&f instanceof K&&g.push(f);return g};N.hoverClass="zeroclipboard-is-hover",N.activeClass="zeroclipboard-is-active",N.trustedOrigins=null,N.allowScriptAccess=null,N.useNoCache=!0,N.moviePath="ZeroClipboard.swf",K.detectFlashSupport=function(){return C("ZeroClipboard.detectFlashSupport",N.debug),J()},K.dispatch=function(a,b){if("string"==typeof a&&a){var c=a.toLowerCase().replace(/^on/,"");if(c)for(var e=d&&N.autoActivate===!0?S(d):M(),f=0,g=e.length;g>f;f++)T.call(e[f],c,b)}},K.prototype.setHandCursor=function(a){return C("ZeroClipboard.prototype.setHandCursor",N.debug),a="boolean"==typeof a?a:!!a,L(a),N.forceHandCursor=a,this},K.prototype.reposition=function(){return C("ZeroClipboard.prototype.reposition",N.debug),Q()},K.prototype.receiveEvent=function(a,b){if(C("ZeroClipboard.prototype.receiveEvent",N.debug),"string"==typeof a&&a){var c=a.toLowerCase().replace(/^on/,"");c&&T.call(this,c,b)}},K.prototype.setCurrent=function(a){return C("ZeroClipboard.prototype.setCurrent",N.debug),K.activate(a),this},K.prototype.resetBridge=function(){return C("ZeroClipboard.prototype.resetBridge",N.debug),K.deactivate(),this},K.prototype.setTitle=function(a){if(C("ZeroClipboard.prototype.setTitle",N.debug),a=a||N.title||d&&d.getAttribute("title")){var b=P(e.bridge);b&&b.setAttribute("title",a)}return this},K.setDefaults=function(a){C("ZeroClipboard.setDefaults",N.debug),K.config(a)},K.prototype.addEventListener=function(a,b){return C("ZeroClipboard.prototype.addEventListener",N.debug),this.on(a,b)},K.prototype.removeEventListener=function(a,b){return C("ZeroClipboard.prototype.removeEventListener",N.debug),this.off(a,b)},K.prototype.ready=function(){return C("ZeroClipboard.prototype.ready",N.debug),e.ready===!0};var T=function(a,g){a=a.toLowerCase().replace(/^on/,"");var h=g&&g.flashVersion&&b(g.flashVersion)||null,i=d,j=!0;switch(a){case"load":if(h){if(!c(h))return void T.call(this,"onWrongFlash",{flashVersion:h});e.outdated=!1,e.ready=!0,e.version=h}break;case"wrongflash":h&&!c(h)&&(e.outdated=!0,e.ready=!1,e.version=h);break;case"mouseover":s(i,N.hoverClass);break;case"mouseout":N.autoActivate===!0&&K.deactivate();break;case"mousedown":s(i,N.activeClass);break;case"mouseup":t(i,N.activeClass);break;case"datarequested":if(i){var k=i.getAttribute("data-clipboard-target"),l=k?document.getElementById(k):null;if(l){var m=l.value||l.textContent||l.innerText;m&&this.setText(m)}else{var n=i.getAttribute("data-clipboard-text");n&&this.setText(n)}}j=!1;break;case"complete":H(f),i&&i!==I()&&i.focus&&i.focus()}var o=i,p=[this,g];return R.call(this,a,o,p,j)};"function"==typeof define&&define.amd?define(["require","exports","module"],function(a,b,c){return k=c&&c.id||null,K}):"object"==typeof module&&module&&"object"==typeof module.exports&&module.exports&&"function"==typeof a.require?(l=module.id||null,module.exports=K):a.ZeroClipboard=K}(function(){return this}())
/*//http://www.featureblend.com/license.txt*/
var FlashDetect=new function(){var self=this;self.installed=false;self.raw="";self.major=-1;self.minor=-1;self.revision=-1;self.revisionStr="";var activeXDetectRules=[{"name":"ShockwaveFlash.ShockwaveFlash.7","version":function(obj){return getActiveXVersion(obj);}},{"name":"ShockwaveFlash.ShockwaveFlash.6","version":function(obj){var version="6,0,21";try{obj.AllowScriptAccess="always";version=getActiveXVersion(obj);}catch(err){}return version;}},{"name":"ShockwaveFlash.ShockwaveFlash","version":function(obj){return getActiveXVersion(obj);}}];var getActiveXVersion=function(activeXObj){var version=-1;try{version=activeXObj.GetVariable("$version");}catch(err){}return version;};var getActiveXObject=function(name){var obj=-1;try{obj=new ActiveXObject(name);}catch(err){obj={activeXError:true};}return obj;};var parseActiveXVersion=function(str){var versionArray=str.split(",");return{"raw":str,"major":parseInt(versionArray[0].split(" ")[1],10),"minor":parseInt(versionArray[1],10),"revision":parseInt(versionArray[2],10),"revisionStr":versionArray[2]};};var parseStandardVersion=function(str){var descParts=str.split(/ +/);var majorMinor=descParts[2].split(/\./);var revisionStr=descParts[3];return{"raw":str,"major":parseInt(majorMinor[0],10),"minor":parseInt(majorMinor[1],10),"revisionStr":revisionStr,"revision":parseRevisionStrToInt(revisionStr)};};var parseRevisionStrToInt=function(str){return parseInt(str.replace(/[a-zA-Z]/g,""),10)||self.revision;};self.majorAtLeast=function(version){return self.major>=version;};self.minorAtLeast=function(version){return self.minor>=version;};self.revisionAtLeast=function(version){return self.revision>=version;};self.versionAtLeast=function(major){var properties=[self.major,self.minor,self.revision];var len=Math.min(properties.length,arguments.length);for(i=0;i<len;i++){if(properties[i]>=arguments[i]){if(i+1<len&&properties[i]==arguments[i]){continue;}else{return true;}}else{return false;}}};self.FlashDetect=function(){if(navigator.plugins&&navigator.plugins.length>0){var type='application/x-shockwave-flash';var mimeTypes=navigator.mimeTypes;if(mimeTypes&&mimeTypes[type]&&mimeTypes[type].enabledPlugin&&mimeTypes[type].enabledPlugin.description){var version=mimeTypes[type].enabledPlugin.description;var versionObj=parseStandardVersion(version);self.raw=versionObj.raw;self.major=versionObj.major;self.minor=versionObj.minor;self.revisionStr=versionObj.revisionStr;self.revision=versionObj.revision;self.installed=true;}}else if(navigator.appVersion.indexOf("Mac")==-1&&window.execScript){var version=-1;for(var i=0;i<activeXDetectRules.length&&version==-1;i++){var obj=getActiveXObject(activeXDetectRules[i].name);if(!obj.activeXError){self.installed=true;version=activeXDetectRules[i].version(obj);if(version!=-1){var versionObj=parseActiveXVersion(version);self.raw=versionObj.raw;self.major=versionObj.major;self.minor=versionObj.minor;self.revision=versionObj.revision;self.revisionStr=versionObj.revisionStr;}}}}}();};
/*! jQuery Mobile v1.4.5 | Copyright 2010, 2014 jQuery Foundation, Inc. | jquery.org/license */
(function(e,t,n){typeof define=="function"&&define.amd?define(["jquery"],function(r){return n(r,e,t),r.mobile}):n(e.jQuery,e,t)})(this,document,function(e,t,n,r){(function(e,n){e.extend(e.support,{orientation:"orientation"in t&&"onorientationchange"in t})})(e),function(e){e.event.special.throttledresize={setup:function(){e(this).bind("resize",n)},teardown:function(){e(this).unbind("resize",n)}};var t=250,n=function(){s=(new Date).getTime(),o=s-r,o>=t?(r=s,e(this).trigger("throttledresize")):(i&&clearTimeout(i),i=setTimeout(n,t-o))},r=0,i,s,o}(e),function(e,t){function p(){var e=s();e!==o&&(o=e,r.trigger(i))}var r=e(t),i="orientationchange",s,o,u,a,f={0:!0,180:!0},l,c,h;if(e.support.orientation){l=t.innerWidth||r.width(),c=t.innerHeight||r.height(),h=50,u=l>c&&l-c>h,a=f[t.orientation];if(u&&a||!u&&!a)f={"-90":!0,90:!0}}e.event.special.orientationchange=e.extend({},e.event.special.orientationchange,{setup:function(){if(e.support.orientation&&!e.event.special.orientationchange.disabled)return!1;o=s(),r.bind("throttledresize",p)},teardown:function(){if(e.support.orientation&&!e.event.special.orientationchange.disabled)return!1;r.unbind("throttledresize",p)},add:function(e){var t=e.handler;e.handler=function(e){return e.orientation=s(),t.apply(this,arguments)}}}),e.event.special.orientationchange.orientation=s=function(){var r=!0,i=n.documentElement;return e.support.orientation?r=f[t.orientation]:r=i&&i.clientWidth/i.clientHeight<1.1,r?"portrait":"landscape"},e.fn[i]=function(e){return e?this.bind(i,e):this.trigger(i)},e.attrFn&&(e.attrFn[i]=!0)}(e,this)});