function pop_message(text,type){
	$("body .messages").append("<div class='message-tip "+type+"'>"+text+"</div>");
	$(".message-tip").slideDown();
	setTimeout(function(){$(".message-tip").slideUp(function(){$(this).remove()})},3000);
}
function get_url_params(){
    var sPageURL = window.location.search.substring(1);
    var sURLVariables =sPageURL.length?sPageURL.split('&'):[];
    var params = {};
    for (var i = 0; i < sURLVariables.length; i++){
        var sParameterName = sURLVariables[i].split('=');
        params[sParameterName[0]] = sParameterName[1];
    }
    return params;
}
function open_dialog(dialog){
    var visible_dia=$(".dialog.active")
    if(visible_dia.length){
        setTimeout(function(){
            visible_dia.removeClass("active");
        },100)
    }
    if(dialog.parent().is("body"))
        $("body").addClass("dialog-enable");
    else {
        $("body").append(dialog).addClass("dialog-enable");
    }
    setTimeout(function(){
        dialog.addClass("active");
    },10)
}
function build_url_search(arr){
    var c_o=get_url_params(),n_arr=[],as=arguments;
    for(var i=0;i<as.length;i++){
        var name=as[i][0],val=as[i][1];
        if(val)
            c_o[name]=val;
        else
            delete c_o[name];
    }
    for(var i in c_o){
        n_arr.push(i+'='+c_o[i])
    }
    if(n_arr.length)
        return "?"+n_arr.join("&");
    else
        return '?';
}
function init_pagination(c,len,size,container,num,max){
    var page_size=num?parseInt(num):Math.ceil(len/size),c=parseInt(c||get_url_params().page||1),h='';
    if(!page_size||page_size<2) return false;
    if(c==1)
        h+='<span class="page prev-page disabled">&lt; Prev</span>';
    else
        h+='<a class="page prev-page" href="'+build_url_search(['page',(c-1)],['c',''])+'" data-page="'+(c-1)+'">&lt; Prev</a>';
    if(max&&page_size>max){
        var half =Math.floor((max-1)/2);
        if(c<=half+1){
            for(var i=1;i<=max;i++){
                h+='<a class="page'+(i==c?" current":"")+'" href="'+build_url_search(['page',i],['c',''])+'" data-page="'+i+'">'+i+'</a>';
            }
            h+='<span class="dotstyle" style="font-size:1.8rem;line-height:1;letter-spacing:2px;">...</span>';
        }else if(c>half+1&&c<page_size-half){
            h+='<a class="page" href="?page=1" data-page="1">1</a><span class="dotstyle" style="font-size:1.8rem;line-height:1;letter-spacing:2px;">...</span>'
            for(var i=c-half+1;i<=c+half;i++){
                h+='<a class="page'+(i==c?" current":"")+'" href="'+build_url_search(['page',i],['c',''])+'" data-page="'+i+'">'+i+'</a>';
            }
            h+='<span class="dotstyle" style="font-size:1.8rem;line-height:1;letter-spacing:2px;">...</span>';
        }else{
            h+='<a class="page" href="'+build_url_search(['page',i],['c',''])+'" data-page="1">1</a><span class="dotstyle">...</span>'
            for(var i=page_size-max+2;i<=page_size;i++){
                h+='<a class="page'+(i==c?" current":"")+'" href="'+build_url_search(['page',i],['c',''])+'" data-page="'+i+'">'+i+'</a>';
            }
        }
    }else{
        for(var i=1;i<=page_size;i++){
            h+='<a class="page'+(i==c?" current":"")+'" href="'+build_url_search(['page',i])+'" data-page="'+i+'">'+i+'</a>';
        }
    }
    if(c==page_size)
        h+='<span class="page next-page disabled">Next &gt;</span>';
    else
        h+='<a class="page next-page" data-page="'+(c-0+1)+'" href="'+build_url_search(['page',(c-0+1)])+'">Next &gt;</a>'
    container.html(h);
}
function init_tip_panel(){
    var t_p=$(".time .tip-panel-wrap");
    if(t_p.length){
        var tt=t_p.attr("data-date"),nt=new Date(tt*1000),
            Y=nt.getFullYear(),mm=nt.getMonth()+1,d=nt.getDate(),h=nt.getHours(),m=nt.getMinutes();
        t_p.html("as of "+(d>9?d:("0"+d))+"/"+(mm>9?mm:("0"+mm))+"/"+Y+" "+h+":"+m+" PST");
    }
}
function time_format(time){
    var t=new Date(time),
        n=new Date(),
        t_m= parseInt(t.getMonth()),
        t_d= t.getDate(),
        t_y= t.getFullYear();
    if(n.getFullYear=t_y&&n.getMonth()==t_m&&n.getDate()==t_d){
        return "Today";
    }else{
        return t_y+"-"+((t_m+1)>10?(t_m+1):("0"+(t_m+1)))+"-"+t_d;
    }
}
function time_since(date) {
    var seconds = Math.floor((new Date() - date) / 1000);

    var interval = Math.floor(seconds / 31536000);

    if (interval > 1) {
        return interval + " years";
    }
    interval = Math.floor(seconds / 2592000);
    if (interval > 1) {
        return interval + " months";
    }
    interval = Math.floor(seconds / 604800);
    if (interval > 1) {
        return interval + " weeks";
    }
    interval = Math.floor(seconds / 86400);
    if (interval > 1) {
        return interval + " days";
    }
    interval = Math.floor(seconds / 3600);
    if (interval > 1) {
        return interval + " hours";
    }
    interval = Math.floor(seconds / 60);
    if (interval > 1) {
        return interval + " minutes";
    }
    return Math.floor(seconds) + " seconds";
}

$(function(){
    function PopupCenter(url, title, w, h,resizable) {
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left,'resizable='+resizable);
        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }
    }
    function init_gotop_action(){
        var gotop_btn=$(".gotop-btn");
        window.addEventListener("scroll",function(){
            if(window.scrollY> window.innerHeight){
                gotop_btn.addClass("active");
            }else{
                gotop_btn.removeClass("active");
            }
        })
        gotop_btn.click(function(){
            $("html,body").animate({scrollTop:0},"slow");
        })
    }
    //slide up system returned message tips
    if($(".message-tip").length > 0){
        setTimeout(function(){$(".message-tip").slideUp(function(){$(this).remove()})},4000);
    }
    $("body").on("click",".sbb-i-s",function(){
        var that=$(this),ipt=that.siblings("input");
        if(!that.is(".active")&&ipt.val().match(/^[a-zA-Z0-9.!#$%&??*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)){
            that.addClass("active");
            setTimeout(function(){
                that.removeClass("active");
                ipt.val();
                pop_message("Subscribe successful","success");
            },500+Math.random()*2000)
        }else{
            pop_message("Invalid Email","false");
        }
    })
    $("body").on("click",".pin-share-btn",function(){
        PopupCenter(this.href,'',780,300,1);
        return false;
    })
    init_gotop_action();
})
