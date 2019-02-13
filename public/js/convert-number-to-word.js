$(document).ready(function () {
    var home = $('#home').val();

    $('#getAllResults').click(function () {
       var numberInput = $('#numberInput').val();
       var convertNumberUrl = home +'/'+ numberInput + '-numbers';
       if(numberInput.length == 0)
       {
           alert('Please fill in number to convert !')
       }
       else
       {
           $.ajax({
               url: home + '/insertToDB',
               type:'GET',
               data: {numberInput: numberInput},
               success: function (response) {
                   console.log('success');
               }
           });
           window.location.href = convertNumberUrl;
       }
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