
    <div class="menu-footer">
        <div class="main row">
            <div class="col-md-3 col-xl-4 col-ms-4">
                <p><a href="#">About Us</a>
                <p><a href="{{url('/Privacy-Policy')}}">Privacy Policy</a></p>
                <p><a href="{{url('/Terms')}}">Terms & conditions</a>
            </div>
            <div class="col-md-5 col-xl-4 col-ms-4 share">
                <p><a href="{{url('/contact-us')}}">Contact us</a></p>
                <p><a href="mainto:{{env('MAIL_CONTACT')}}">{{env('MAIL_CONTACT')}}</a></p>
                <a href="#pinterest"><i class="fa fa-pinterest-square"></i></a>
                <a href="#fb"><i class="fa fa-facebook-square"></i></a>
                <a href="#gplus"><i class="fa fa-google-plus"></i></a>
                <a href="#twitter"><i class="fa fa-twitter-square"></i></a>
            </div>
            <div class="col-md-4 col-xl-4 col-ms-4">
                <p>Subscribe to get new offers directly</p>
                <div class="wrap-sub">
                <form class="input-group">
                    <input type="text" class="form-control" placeholder="Enter Email For New Discount Codes" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button type="submit" class="btn sub-btn" id="basic-addon2"><span>Submit</span></button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="main">
        Copyright © 2018  All rights reserved.
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
            $(".coupon-item").on('click', '.moreOver', function () {
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
</body></html>