$(document).ready(function () {
    var home = $('#home').val();

    $('#getAllResults').click(function () {
       var numberInput = $('#numberInput').val();
       var convertNumberUrl = home +'/'+ numberInput;
       window.location.href = convertNumberUrl;
    });

    $('#convert').click(function () {
        var data = $("#currency-form").serialize();
        $.ajax({
            url: home + '/convertCurrency',
            type: 'GET',
            data : data,
            success: function (response) {
              $('#responseConvert').val(response);
            }
        })
    })

});