<div class="info-footer">
    <div class="main">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
               <!-- <p> About us</p> -->
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
               <p> Copyright 2018 {{ $domain_upper }}. All right reserved</p>
            </div>
             <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
                <p>{{ "support@$domain_lower" }}</p>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.popup-get-code', function(){
        var affiliate = $(this).attr('data-affiliate');
        var data_link = $(this).attr('data-link');
        window.open(data_link,'_blank');
        location.href = affiliate;
    });
    $('body').on('click','.location', function(e){
        e.preventDefault();
        location.href=$(this).attr('data-href');
        return false;
    });
    $('body').on('click','.loc-open', function(e){
        e.preventDefault();
        window.open($(this).attr('data-href'),'blank');
        return false;
    });
    var moretext = "More";
    var lesstext = "Less";
    var ellipsestext = "...";
    function reMoreText(showChar = 200, thisClass = '.more'){ // How many characters are shown by default
        $(thisClass).each(function() {
            var content = $(this).html();
            if($(this).find('.morelink').length<1) {
                if (content.length > showChar) {
                    var c = content.substr(0, showChar);
                    var h = content.substr(showChar, content.length - showChar);
                    var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
                    $(this).html(html);
                }
            }
        });
    }
    /* show more text neu tràn box */
    function moreTextBox(thisClass=".limit") {
        $(thisClass).each(function () {
            if (!$(this).hasClass('limited')&&this.clientWidth < this.scrollWidth) $('<a class="toggle-description active moreOver">More</a>').insertBefore(this);
            $(this).addClass('limited');
        });
        $(".cp-item").on('click', '.moreOver', function () {
            if (!$(this).hasClass('less')) {
                $(this).addClass('less').next('.limit').removeClass('limit').addClass('nolimit');
                $(this).children('p').text('Close');
            } else {
                $(this).removeClass('less').next('.nolimit').removeClass('nolimit').addClass('limit');
                $(this).children('p').text('Read More');
            }
            $(this).remove();
        });
    }
    $(document).ready(function(){
        moreTextBox();
    });
</script>

@yield('scripts-footer')
{!! $settings['footer'] !!}

</body></html>