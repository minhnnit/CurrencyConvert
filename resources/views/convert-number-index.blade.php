<!DOCTYPE html>
<html>
<head>
    <title>Currency Conversion</title>
    <meta name="viewport"
          content="width=device-width, minimum-scale=1, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" media="all">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="http://code.responsivevoice.org/responsivevoice.js"></script>
    <script type="text/javascript" charset="utf8" src="{{ asset('/js/convert-number-to-word.js') }}"></script>
    <link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>
<body>
<header>
    <div class="header-content">
        <div class="logo-header">
            <a href="{{ url('/') }}">
                <img src="../public/img/Back-To-Homepage-button.png" alt="">
            </a>
        </div>
    </div>
</header>
<div class="container">
    <div id="main">
        <div class="col-lg-9 col-xs-12">
            <div class="convert-number-left">
                <div class="spellout-number">
                    <h3>SPELLOUT NUMBER</h3>
                    <p><b>Input Number</b></p>
                    <input type="number" class="form-control inputCurrency-nb" required="" id="numberInput" value="{{!empty($data["numberInput"]) ? $data["numberInput"] : '1'}}">
                    <div class="button-convert-first">
                        <button class="btn btn-default btn-padding" type="submit" id="getAllResults">Convert Number To Word</button>
                    </div>
                </div>
                <div class="display-text-audio" >
                    <div class="speakout-digit">
                        <input onclick="responsiveVoice.speak($('.eachNumberToWordAudio').text());" type='button'
                               value='🔊 Play'/><span
                                class="span-currency">Spellout each digits of number input:</span><span
                                class="color-blue eachNumberToWordAudio span-currency">{{!empty($data["convertDigits"]) ? $data["convertDigits"] : 'one'}}</span>
                    </div>
                    <div>
                        <input onclick="responsiveVoice.speak($('.allNumberToWordAudio').text());" type='button'
                               value='🔊 Play'/><span
                                class="span-currency">Spellout rule-based format:</span><span
                                class="color-blue allNumberToWordAudio span-currency">{{!empty($data["convertNumber"]) ? $data["convertNumber"] : 'one'}}</span>
                    </div>
                </div>
                <div class="number-type">
                    <div class="even-number">
                        Even numbers in input string : <span
                                class="color-blue">{{!empty($data["evenNumber"]) ? $data["evenNumber"] : ''}}</span>
                    </div>
                    <div class="odd-number">
                        Odd numbers in input string : <span
                                class="color-blue">{{!empty($data["oddNumber"]) ? $data["oddNumber"] : '1'}}</span>
                    </div>
                    <div class="max-number">
                        Max number in input string : <span
                                class="color-blue">{{!empty($data["maxNumber"]) ? $data["maxNumber"] : '1'}}</span>
                    </div>
                    <div class="min-number">
                        Min number in input string : <span
                                class="color-blue">{{!empty($data["minNumber"]) ? $data["minNumber"] : '1'}}</span>
                    </div>
                    <div class="array-sum">
                        Sum all digits in input string : <span
                                class="color-blue">{{!empty($data["arraySum"]) ? $data["arraySum"] : '1'}}</span>
                    </div>
                </div>
                <div class="convert-currency">
                    <h3>CONVERT CURRENCY</h3>
                    <form method="post" id="currency-form">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" placeholder="Currency" name="amount" id="amount" class="form-control inputCurrency" value="1"/>
                            <label>From</label>
                            <select name="from_currency" class="inputCurrency form-control">
                                <option value="INR">Indian Rupee</option>
                                <option value="USD" selected="1">US Dollar</option>
                                <option value="AUD">Australian Dollar</option>
                                <option value="EUR">Euro</option>
                                <option value="EGP">Egyptian Pound</option>
                                <option value="CNY">Chinese Yuan</option>
                                <option value="GBP">British Pound</option>
                                <option value="CAD">Canadian Dollar</option>
                                <option value="AFN">Afghanistan Afghani</option>
                                <option value="ARS">Argentine Peso</option>
                                <option value="BSD">Bahamian Dollar</option>
                                <option value="BRL">Brazilian Real</option>
                                <option value="BND">Brunei Dollar</option>
                                <option value="KHR">Cambodian Riel</option>
                                <option value="CFP">Central Pacific Franc</option>
                                <option value="COP">Colombian Peso</option>
                                <option value="FRF">French Franc</option>
                                <option value="DEM">German Mark</option>
                                <option value="HKD">Hong Kong Dollar</option>
                                <option value="ISK">Iceland Krona</option>
                                <option value="IDR">Indonesian Rupiah</option>
                                <option value="JPY">Japanese Yen</option>
                                <option value="LAK">Lao Kip</option>
                                <option value="MOP">Macau Pataca</option>
                                <option value="MXN">Mexican Peso</option>
                                <option value="PHP">Philippine Peso</option>
                                <option value="VND">Vietnamese Dong</option>
                                <option value="THB">Thai Baht</option>
                                <option value="TWD">Taiwan Dollar</option>
                                <option value="SEK">Swedish Krona</option>

                            </select>
                            <label>To</label>
                            <select name="to_currency" class="inputCurrency toCurrency form-control">
                                <option value="INR" selected="1">Indian Rupee</option>
                                <option value="USD">US Dollar</option>
                                <option value="AUD">Australian Dollar</option>
                                <option value="EUR">Euro</option>
                                <option value="EGP">Egyptian Pound</option>
                                <option value="CNY">Chinese Yuan</option>
                                <option value="GBP">British Pound</option>
                                <option value="CAD">Canadian Dollar</option>
                                <option value="AFN">Afghanistan Afghani</option>
                                <option value="ARS">Argentine Peso</option>
                                <option value="ARS">Argentine Peso</option>
                                <option value="BSD">Bahamian Dollar</option>
                                <option value="BRL">Brazilian Real</option>
                                <option value="BND">Brunei Dollar</option>
                                <option value="KHR">Cambodian Riel</option>
                                <option value="CFP">Central Pacific Franc</option>
                                <option value="COP">Colombian Peso</option>
                                <option value="FRF">French Franc</option>
                                <option value="DEM">German Mark</option>
                                <option value="HKD">Hong Kong Dollar</option>
                                <option value="ISK">Iceland Krona</option>
                                <option value="IDR">Indonesian Rupiah</option>
                                <option value="JPY">Japanese Yen</option>
                                <option value="LAK">Lao Kip</option>
                                <option value="MOP">Macau Pataca</option>
                                <option value="MXN">Mexican Peso</option>
                                <option value="PHP">Philippine Peso</option>
                                <option value="VND">Vietnamese Dong</option>
                                <option value="THB">Thai Baht</option>
                                <option value="TWD">Taiwan Dollar</option>
                                <option value="SEK">Swedish Krona</option>
                            </select>
                            =
                            <input type="text" id="responseConvert" class="color-blue form-control inputCurrency" readonly>
                           <div class="convert-button">
                                <span name="convert" id="convert" class="btn btn-default"><b>Convert</b><i
                                            class="fas fa-arrow-right"></i></span>
                           </div>
                        </div>
                    </form>
                </div>
                <div class="currency-to-text">
                    <h3>CURRENCY TO TEXT</h3>
                    <div class="lead">
                        @if(!empty($listCurrency))
                            @foreach($listCurrency as $v => $v_value)
                                <div class="mg-bottom-5">
                                    <input onclick="responsiveVoice.speak($('.{{$v}}').text());"
                                           type='button'
                                           value='🔊 Play'/><span
                                            class="span-currency">{{$v}}:</span><span
                                            class="color-blue span-currency {{$v}}">{{!empty($data["convertNumber"]) ? $data["convertNumber"] : 'one'}} {{$v_value}}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="more more-lead">More...</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-12">
            <h3 class="relate-number">RELATE AND RANDOM NUMBER</h3>
            <span>
                <span class="relate-number"></span> <a class="hrefadd1 cursor-pointer"><span class="numberAdd1 span-currency">{{!empty($data["numberAdd1"]) ? $data["numberAdd1"] : ''}}</span></a>
                <a class="hrefadd2 cursor-pointer"><span class="numberAdd2 span-currency">{{!empty($data["numberAdd2"]) ? $data["numberAdd2"] : ''}}</span></a>
                <a class="hrefadd3 cursor-pointer"><span class="numberAdd3 span-currency">{{!empty($data["numberAdd3"]) ? $data["numberAdd3"] : ''}}</span></a>
                <a class="hrefadd4 cursor-pointer"><span class="numberAdd4 span-currency">{{!empty($data["numberAdd4"]) ? $data["numberAdd4"] : ''}}</span></a>
                <a class="hrefadd5 cursor-pointer"><span class="numberAdd5 span-currency">{{!empty($data["numberAdd5"]) ? $data["numberAdd5"] : ''}}</span></a>
            </span>
            <span>
                <a class="hrefsub1 cursor-pointer"><span class="numberSub1 span-currency">{{!empty($data["numberSub1"]) ? $data["numberSub1"] : ''}}</span></a>
                <a class="hrefsub2 cursor-pointer"><span class="numberSub2 span-currency">{{!empty($data["numberSub2"]) ? $data["numberSub2"] : ''}}</span></a>
                <a class="hrefsub3 cursor-pointer"><span class="numberSub3 span-currency">{{!empty($data["numberSub3"]) ? $data["numberSub3"] : ''}}</span></a>
                <a class="hrefsub4 cursor-pointer"><span class="numberSub4 span-currency">{{!empty($data["numberSub4"]) ? $data["numberSub4"] : ''}}</span></a>
                <a class="hrefsub5 cursor-pointer"><span class="numberSub5 span-currency">{{!empty($data["numberSub5"]) ? $data["numberSub5"] : ''}}</span></a>
            </span>
            <div class="span-currency random-number">
                Random Numbers: <a class="hrefrandom1 cursor-pointer"><span class="span-currency randomNumber1">{{!empty($data["randomNumber1"]) ? $data["randomNumber1"] : ''}}</span></a>
                <a class="hrefrandom2 cursor-pointer"><span class="span-currency randomNumber2">{{!empty($data["randomNumber2"]) ? $data["randomNumber2"] : ''}}</span></a>
                <a class="hrefrandom3 cursor-pointer"><span class="span-currency randomNumber3">{{!empty($data["randomNumber3"]) ? $data["randomNumber3"] : ''}}</span></a>
                <a class="hrefrandom4 cursor-pointer"><span class="span-currency randomNumber4">{{!empty($data["randomNumber4"]) ? $data["randomNumber4"] : ''}}</span></a>
                <a class="hrefrandom5 cursor-pointer"><span class="span-currency randomNumber5">{{!empty($data["randomNumber5"]) ? $data["randomNumber5"] : ''}}</span></a>
            </div>
        </div>
    </div>
</div>
<footer id="footer">
    <div class="footer-left clear-fix">
        <ul class="clearfix list-unstyled">
            <li class="pull-left"><a href="#">About Us</a></li>
            <li class="pull-left"><a href="#">Privacy Policy</a></li>
            <li class="pull-left"><a href="#">Terms of Service</a></li>
            <li class="pull-left"><a href="#">Contact</a></li>
        </ul>
    </div>
    <div class="footer-right">
        © Copyright 2018. All Rights Reserved.
    </div>
</footer>

<input type="hidden" value="{{ url('/') }}" id="home">

</body>
</html>