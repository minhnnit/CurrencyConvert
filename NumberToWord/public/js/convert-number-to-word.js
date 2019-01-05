$(document).ready(function () {
    var home = $('#home').val();
    var numberInput = $('#numberInput').val();
    $("#getResultFromNumber").click(function () {
        $.ajax({
            url: home + '/convertNumber',
            data: {numberInput: numberInput},
            type: "GET",
            success: function (response) {
                $('.allNumberToWord').text(response.toUpperCase());
            }
        });
    });

    $('#getEachDigits').click(function () {
        $.ajax({
            url: home + '/convertDigits',
            data: {numberInput: numberInput},
            type: "GET",
            success: function (response) {
                $('.eachNumberToWord').text(response.toUpperCase());
            }
        })
    });

    $('.fa-volume-up').click(function () {
        $.ajax({
            url: home + '/googleSpeech',
            type: 'GET',
            success: function (response) {
                console.log(response);
            }
        })
    })

});