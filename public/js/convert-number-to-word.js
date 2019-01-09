$(document).ready(function () {
    var home = $('#home').val();

    $('#getAllResults').click(function () {
       var numberInput = $('#numberInput').val();
       var convertNumberUrl = home +'/'+ numberInput + '-numbers';
       window.location.href = convertNumberUrl;
    });

    $('#convert').click(function () {
        var data = $("#currency-form").serialize();
        $.ajax({
            url: home + '/convertCurrency',
            type: 'GET',
            data : data,
            success: function (response) {
                var responseReplace =response.replace(/"/g, "");
              $('#responseConvert').val(responseReplace);
            }
        })
    });

    $('.hrefadd1').click(function () {
       var numberAdd1 = $('.numberAdd1').text();
       var numberAdd1Url = home + '/'+ numberAdd1 + '-numbers';
       window.location.href = numberAdd1Url;
    });
    $('.hrefadd2').click(function () {
        var numberAdd2 = $('.numberAdd2').text();
        var numberAdd2Url = home + '/'+ numberAdd2 + '-numbers';
        window.location.href = numberAdd2Url;
    });
    $('.hrefadd3').click(function () {
        var numberAdd3 = $('.numberAdd3').text();
        var numberAdd3Url = home + '/'+ numberAdd3 + '-numbers';
        window.location.href = numberAdd3Url;
    });
    $('.hrefadd4').click(function () {
        var numberAdd4 = $('.numberAdd4').text();
        var numberAdd4Url = home + '/'+ numberAdd4 + '-numbers';
        window.location.href = numberAdd4Url;
    });
    $('.hrefadd5').click(function () {
        var numberAdd5 = $('.numberAdd5').text();
        var numberAdd5Url = home + '/'+ numberAdd5 + '-numbers';
        window.location.href = numberAdd5Url;
    });

    $('.hrefsub1').click(function () {
        var numberSub1 = $('.numberSub1').text();
        var numberSub1Url = home + '/' + numberSub1 + '-numbers';
        window.location.href = numberSub1Url;
    });
    $('.hrefsub2').click(function () {
        var numberSub2 = $('.numberSub2').text();
        var numberSub2Url = home + '/' + numberSub2 + '-numbers';
        window.location.href = numberSub2Url;
    });
    $('.hrefsub3').click(function () {
        var numberSub3 = $('.numberSub3').text();
        var numberSub3Url = home + '/' + numberSub3 + '-numbers';
        window.location.href = numberSub3Url;
    });
    $('.hrefsub4').click(function () {
        var numberSub4 = $('.numberSub4').text();
        var numberSub4Url = home + '/' + numberSub4 + '-numbers';
        window.location.href = numberSub4Url;
    });
    $('.hrefsub5').click(function () {
        var numberSub5 = $('.numberSub5').text();
        var numberSub5Url = home + '/' + numberSub5 + '-numbers';
        window.location.href = numberSub5Url;
    });
    $('.hrefrandom1').click(function () {
        var randomNumber1 = $('.randomNumber1').text();
        var randomNumber1Url = home + '/' + randomNumber1 + '-numbers';
        window.location.href = randomNumber1Url;
    });
    $('.hrefrandom2').click(function () {
        var randomNumber2 = $('.randomNumber2').text();
        var randomNumber2Url = home + '/' + randomNumber2 + '-numbers';
        window.location.href = randomNumber2Url;
    });
    $('.hrefrandom3').click(function () {
        var randomNumber3 = $('.randomNumber3').text();
        var randomNumber3Url = home + '/' + randomNumber3 + '-numbers';
        window.location.href = randomNumber3Url;
    });
    $('.hrefrandom4').click(function () {
        var randomNumber4 = $('.randomNumber4').text();
        var randomNumber4Url = home + '/' + randomNumber4 + '-numbers';
        window.location.href = randomNumber4Url;
    });
    $('.hrefrandom5').click(function () {
        var randomNumber5 = $('.randomNumber5').text();
        var randomNumber5Url = home + '/' + randomNumber5 + '-numbers';
        window.location.href = randomNumber5Url;
    });


});
jQuery(function ($) {

    // Resize Height
    function reh(e) {
        $(e).css({'height': $(e).attr('height')})
    }

    // Empty Height
    function emh(e) {
        $(e).css({'height': 'auto'});
    }

    // Resize .lead (default height)
    reh('.lead');

    // Actions
    // More: Lead
    $('body').on('click', '.more-lead', function () {
        emh($(this).siblings('.lead'));
        $(this).remove();
    });
});