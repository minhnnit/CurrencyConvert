/**
*
* jQuery Crop Image Plugin version 1.0
* This plugin builded on using jQuery, Bootstrap, Font Awesome
* @Author Phạm Hùng Cường
* @Email phc.itt@gmail.com
* @Create date: 08:59:12 - 18/05/2015
* @Copyright MC-CORP* @URL http://mccorp.co.com
*
**/
(function($){
	"use strict";
    var isTouchDevice = function(){
        try{
            document.createEvent("TouchEvent");
            return true;
        }catch(e){
            return false;
        }
    };
    if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
        alert('The File APIs are not fully supported in this browser. Please update your browser to new version or try again with other browser.');
        return false;
    }
    var currentCuter = '';
	$.fn.cropImage = function(options){

        var defaultSettings = {inputId: 'cuteAvatar',modalId:'changeAvatar', width:200, height:200, imageSelector:'.resize-image', handleCompletedFile:function(){}}, image_target, orig_src, min_width, min_height, $container;
        /*With image object named is orig_src, When resizing, we will always use this copy of the original as the base*/
        var event_state = {}, max_width = 1000, max_height = 1000, constrain = false, resize_canvas = document.createElement('canvas');

        var settings 	= $.extend({}, defaultSettings, options);
        settings.inputId = 'cuter_' + settings.inputId;
        var inputField 	= document.createElement('input');
        inputField.type         = 'file';
        inputField.className    = 'hidden';
        inputField.accept       = 'image/*';
        inputField.id           = settings.inputId;
        $('body').append(inputField);
        min_width 	= settings.width;
        min_height 	= settings.height;
        image_target = $(settings.imageSelector).get(0);
        if(currentCuter = settings.inputId){
            if($(image_target).closest(".resize-container").length <= 0){
                $(image_target).wrap('<div class="resize-container"></div>')
                    .before('<span class="resize-handle resize-handle-nw"></span>')
                    .before('<span class="resize-handle resize-handle-ne"></span>')
                    .after('<span class="resize-handle resize-handle-se"></span>')
                    .after('<span class="resize-handle resize-handle-sw"></span>');
            }
        }
        // Wrap the image with the container and add resize handles
        var strMessage = '<strong>Hint:</strong> hold SHIFT while resizing to keep the original aspect ratio.';
        if(isTouchDevice()){
            strMessage = 'Hint: <strong>Hold</strong> and <strong>Drag</strong> while resizing to keep the original aspect ratio.';
        }
        $('.crop-tip-hint').html(strMessage);

        var doogleTipHint = function(err){
            var objHinter = $('.crop-tip-hint');
            var oldStr = objHinter.html();
            objHinter.html(err).removeClass('alert-info').addClass('alert-danger');
            setTimeout(function(){
                objHinter.html(oldStr).removeClass('alert-danger').addClass('alert-info');
            }, 5000);
        };

        var clickToInputField = function(){
            currentCuter = settings.inputId;
            $('#' + settings.inputId).click();
        };
        var openTheModal = function(){
            if(currentCuter == settings.inputId){
                $('.component').addClass('loading');
                $('.overlay').attr('style','width:'+min_width+'px; height:'+min_height+ 'px;margin-left:-'+min_width/2+'px;margin-top:-'+min_height/2+'px;');
                $container =  $(image_target).parent('.resize-container');
                handleFiles(currentCuter);
                $('#'+settings.modalId).modal('show');
                $container.on('mousedown touchstart', '.resize-handle', startResize);
                $container.on('mousedown touchstart', 'img', startMoving);
                $("#clockwise").on('click', clockWise);
                $("#counterclockwise").on('click', counterClockWise);
                $('.js-crop').on('click', crop);
            }
        };
        var handleFiles = function (input){
            var file = $('#' + input)[0].files[0];
            if(!file.type.match(/image.*/)){
                window.alert('File type is not supported!');
                return false;
            }
            var MAX_WIDTH 	= 600;
            var MAX_HEIGHT 	= 600;
            var width, height;
            var canvas 		= document.createElement('canvas');
            var	tmpImg		= new Image();
            var	reader 		= new FileReader();
            reader.onload	= function(e){
                tmpImg.onload = function () {
                    width 	= this.width;
                    height 	= this.height;
                    if (width > height) {
                        if (width > MAX_WIDTH) {
                            height *= MAX_WIDTH / width;
                            width = MAX_WIDTH;
                        }
                    } else {
                        if (height > MAX_HEIGHT) {
                            width *= MAX_HEIGHT / height;
                            height = MAX_HEIGHT;
                        }
                    }
                    canvas.width 	= width;
                    canvas.height 	= height;
                    canvas.getContext("2d").drawImage(tmpImg, 0, 0, width, height);
                    orig_src 		= new Image();
                    orig_src.onload = function(){
                        resizeImage(width, height);
                        $('.component').removeClass('loading').addClass('remaining');
                    };
                    orig_src.src = canvas.toDataURL("image/png");
                };
                tmpImg.src = e.target.result;
            };
            reader.readAsDataURL(file);
        };
        var startResize = function(e){
            e.preventDefault();
            e.stopPropagation();
            saveEventState(e);
            $(document).on('mousemove touchmove', resizing);
            $(document).on('mouseup touchend', endResize);
        };
        var endResize = function(e){
            e.preventDefault();
            $(document).off('mouseup touchend', endResize);
            $(document).off('mousemove touchmove', resizing);
        };
        var saveEventState = function(e){
            // Save the initial event details and container state
            event_state.container_width = $container.width();
            event_state.container_height = $container.height();
            event_state.container_left = $container.offset().left;
            event_state.container_top = $container.offset().top;
            event_state.mouse_x = (e.clientX || e.pageX || e.originalEvent.touches[0].clientX) + $(window).scrollLeft();
            event_state.mouse_y = (e.clientY || e.pageY || e.originalEvent.touches[0].clientY) + $(window).scrollTop();
            // This is a fix for mobile safari
            // For some reason it does not allow a direct copy of the touches property
            if(typeof e.originalEvent.touches !== 'undefined'){
                event_state.touches = [];
                $.each(e.originalEvent.touches, function(i, ob){
                    event_state.touches[i] = {};
                    event_state.touches[i].clientX = 0+ob.clientX;
                    event_state.touches[i].clientY = 0+ob.clientY;
                });
            }
            event_state.evnt = e;
        };
        var resizing = function(e){
            var mouse	= {},width,height,left,top,offset=$container.offset();
            mouse.x = (e.clientX || e.pageX || e.originalEvent.touches[0].clientX) + $(window).scrollLeft();
            mouse.y = (e.clientY || e.pageY || e.originalEvent.touches[0].clientY) + $(window).scrollTop();
            // Position image differently depending on the corner dragged and constraints
            if( $(event_state.evnt.target).hasClass('resize-handle-se') ){
                width = mouse.x - event_state.container_left;
                height = mouse.y  - event_state.container_top;
                left = event_state.container_left;
                top = event_state.container_top;
            } else if($(event_state.evnt.target).hasClass('resize-handle-sw') ){
                width = event_state.container_width - (mouse.x - event_state.container_left);
                height = mouse.y  - event_state.container_top;
                left = mouse.x;
                top = event_state.container_top;
            } else if($(event_state.evnt.target).hasClass('resize-handle-nw') ){
                width = event_state.container_width - (mouse.x - event_state.container_left);
                height = event_state.container_height - (mouse.y - event_state.container_top);
                left = mouse.x;
                top = mouse.y;
                if(constrain || e.shiftKey){
                    top = mouse.y - ((width / orig_src.width * orig_src.height) - height);
                }
            } else if($(event_state.evnt.target).hasClass('resize-handle-ne') ){
                width = mouse.x - event_state.container_left;
                height = event_state.container_height - (mouse.y - event_state.container_top);
                left = event_state.container_left;
                top = mouse.y;
                if(constrain || e.shiftKey){
                    top = mouse.y - ((width / orig_src.width * orig_src.height) - height);
                }
            }
            // Optionally maintain aspect ratio
            if(constrain || e.shiftKey){
                height = width / orig_src.width * orig_src.height;
            }
            if(width > min_width && height > min_height && width < max_width && height < max_height){
                // To improve performance you might limit how often resizeImage() is called
                resizeImage(width, height);
                // Without this Firefox will not re-calculate the the image dimensions until drag end
                $container.offset({'left': left, 'top': top});
            }
        };
        var resizeImage = function(width, height){
            resize_canvas.width = width;
            resize_canvas.height = height;
            resize_canvas.getContext('2d').drawImage(orig_src, 0, 0, width, height);
            $(settings.imageSelector).attr('src', resize_canvas.toDataURL("image/png"));
        };

        var clockWise = function(){
            drawRotated(90);
        };
        var counterClockWise = function(){
            drawRotated(-90);
        };
        var drawRotated = function (degrees){
            degrees = parseInt(degrees);
            var canvasRotate = document.createElement('canvas');
            var ctx = canvasRotate.getContext("2d");
            var cW = orig_src.width,
                cH = orig_src.height;
            canvasRotate.height = cW;
            canvasRotate.width = cH;
            ctx.translate(canvasRotate.width/2,canvasRotate.height/2);
            ctx.rotate(degrees*Math.PI/180);
            ctx.drawImage(orig_src,-orig_src.width/2,-orig_src.height/2);
            orig_src.onload = function(){
                cW = $(image_target).width();
                cH = $(image_target).height();
                resizeImage(cH, cW);
            };
            orig_src.src = canvasRotate.toDataURL("image/png");

        };
        var startMoving = function(e){
            e.preventDefault();
            e.stopPropagation();
            saveEventState(e);
            $(document).on('mousemove touchmove', moving);
            $(document).on('mouseup touchend', endMoving);
        };
        var endMoving = function(e){
            e.preventDefault();
            $(document).off('mouseup touchend', endMoving);
            $(document).off('mousemove touchmove', moving);
        };
        var moving = function(e){
            var	mouse	= {}, touches;
            e.preventDefault();
            e.stopPropagation();
            touches = e.originalEvent.touches;
            mouse.x = (e.clientX || e.pageX || touches[0].clientX) + $(window).scrollLeft();
            mouse.y = (e.clientY || e.pageY || touches[0].clientY) + $(window).scrollTop();
            $container.offset({
                'left': mouse.x - ( event_state.mouse_x - event_state.container_left ),
                'top': mouse.y - ( event_state.mouse_y - event_state.container_top )
            });
            // Watch for pinch zoom gesture while moving
            if(event_state.touches && event_state.touches.length > 1 && touches.length > 1){
                var width = event_state.container_width, height = event_state.container_height;
                var a = event_state.touches[0].clientX - event_state.touches[1].clientX;
                a = a * a;
                var b = event_state.touches[0].clientY - event_state.touches[1].clientY;
                b = b * b;
                var dist1 = Math.sqrt( a + b );
                a = e.originalEvent.touches[0].clientX - touches[1].clientX;
                a = a * a;
                b = e.originalEvent.touches[0].clientY - touches[1].clientY;
                b = b * b;
                var dist2 = Math.sqrt( a + b );
                var ratio = dist2 /dist1;
                width = width * ratio;
                height = height * ratio;
                // To improve performance you might limit how often resizeImage() is called
                resizeImage(width, height);
            }
        };
        var crop = function(){
            if(currentCuter == settings.inputId) {
                //Find the part of the image that is inside the crop box
                var crop_canvas,
                    left = $('.overlay').offset().left - $container.offset().left,
                    top = $('.overlay').offset().top - $container.offset().top,
                    width = $('.overlay').width(),
                    height = $('.overlay').height();
                crop_canvas = document.createElement('canvas');
                crop_canvas.width = width;
                crop_canvas.height = height;
                try {
                    crop_canvas.getContext('2d').drawImage(image_target, left, top, width, height, 0, 0, width, height);
                    settings.handleCompletedFile(crop_canvas.toDataURL("image/png"));
                    $('#' + settings.modalId).modal('hide');
                } catch (e) {
                    doogleTipHint('Please move your image into the red box and crop try again.');
                }
            }
        };
		// Add events
		$('#'+settings.modalId).on('hidden.bs.modal', function(){
			$('.component').addClass('loading').removeClass('remaining');
            $('#' + settings.inputId).val(null);
		});
		$(this).on('click', clickToInputField);
        $('input#' + settings.inputId).on('change', openTheModal);
	};
})(jQuery);

$(document).ready(function($){
	$('[data-provide=cropSelector]').cropImage({
		handleCompletedFile: handAvatar,
		modalId: 'changeAvatarModal',
		width:150,
		height:150
	});
});

