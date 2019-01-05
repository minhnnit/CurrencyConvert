$(document).ready(function () {
    var home = $('#home').val();

    $('#getAllResults').click(function () {
        var numberInput = $('#numberInput').val();
        $.ajax({
            url: home + '/getAllResults',
            data: {numberInput: numberInput},
            type: "GET",
            success:function (response) {
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
        $.ajax({
            url: 'http://apilayer.net/api/live?access_key=e8ac956c6526dedb108cc8ed56e4a89e&currencies=USD,AUD,CAD,PLN,MXN&format=1',
            type: 'GET',
            success: function (response) {
                console.log(response);
            }
        })
    })

});