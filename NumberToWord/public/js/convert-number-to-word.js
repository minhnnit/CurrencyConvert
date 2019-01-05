$(document).ready(function () {
    var home = $('#home').val();

    $('#getAllResults').click(function () {
        var numberInput = $('#numberInput').val();
        $.ajax({
            url: home + '/getAllResults',
            data: {numberInput: numberInput},
            type: "GET",
            success: function (response) {
                response = JSON.parse(response);
                $('.eachNumberToWord').text(response['convertDigits']);
                $('.allNumberToWord').text(response['convertNumber']);
                $('.allNumberToWordUSD').text(response['convertNumber']);
                $('.allNumberToWordEUR').text(response['convertNumber']);
                $('.allNumberToWordVND').text(response['convertNumber']);
                $('.allNumberToWordFBP').text(response['convertNumber']);
            }
        })
    });

    $('#convert').click(function () {
        var data = $("#currency-form").serialize();
        $.ajax({
            url: home + '/convertCurrency',
            type: 'GET',
            data : data,
            success: function (response) {
                var results =$('#results').append($('.toCurrency').val());
                results.text(response);
            }
        })
    })

});