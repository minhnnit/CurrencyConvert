<!DOCTYPE html>
<html>
<head>
    <title>Currency Conversion</title>
    <meta name="viewport"
          content="width=device-width, minimum-scale=1, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" media="all">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="http://code.responsivevoice.org/responsivevoice.js"></script>
    <script type="text/javascript" charset="utf8" src="{{ asset('/js/convert-number-to-word.js') }}"></script>
    <link href="{{ asset('css/convert-css.css') }}" rel="stylesheet">

</head>
<body>
<div class="convert-title">
    <h3>SPELLOUT NUMBER</h3>
</div>
<div class="col-xs-12">
    <p>Input Number</p>
    <input type="number" id="numberInput" >
    <button class="btn btn-default" type="submit" id="getAllResults">Convert Number To Word</button>
</div>
<div class="col-xs-12">
    <input onclick="responsiveVoice.speak($('.eachNumberToWord').text());" type='button' value='🔊 Play' /><span>Spellout each digits of number input:</span><span class="eachNumberToWord"></span><br>
    <input onclick="responsiveVoice.speak($('.allNumberToWord').text());" type='button' value='🔊 Play' /><span>Spellout rule-based format:</span> <span class="allNumberToWord"></span>
</div>
<div class="convert-title">
    <h3>CONVERT CURRENCY</h3>
</div>

<form method="post" id="currency-form">
    <div class="form-group">
        <label>From</label>
        <select name="from_currency" class="inputCurrency">
            <option value="INR">Indian Rupee</option>
            <option value="USD" selected="1">US Dollar</option>
            <option value="AUD">Australian Dollar</option>
            <option value="EUR">Euro</option>
            <option value="EGP">Egyptian Pound</option>
            <option value="CNY">Chinese Yuan</option>
        </select>
        <label>Amount</label>
        <input type="number" placeholder="Currency" name="amount" id="amount"/>
        <label>To</label>
        <select name="to_currency" class="inputCurrency toCurrency">
            <option value="INR" selected="1">Indian Rupee</option>
            <option value="USD">US Dollar</option>
            <option value="AUD">Australian Dollar</option>
            <option value="EUR">Euro</option>
            <option value="EGP">Egyptian Pound</option>
            <option value="CNY">Chinese Yuan</option>
        </select>
        <span name="convert" id="convert" class="btn btn-default">Convert</span>
    </div>
</form>
<span class="convert-amount">Converted Amount</span>:<span id="results"></span>

<div class="convert-title">
    <h3>CURRENCY</h3>
</div>
<div class="col-xs-12">
    <div class="usd">
        <input onclick="responsiveVoice.speak($('.allNumberToWordUSD').text());" type='button' value='🔊 Play' /><span class="span-currency">USD:</span><span class="allNumberToWordUSD span-currency color-blue "></span><span
                class="span-currency">United States Dollars</span>
    </div>
    <div class="eur">
        <input onclick="responsiveVoice.speak($('.allNumberToWordEUR').text());" type='button' value='🔊 Play' /><span class="span-currency">EUR:</span><span class="allNumberToWordEUR span-currency color-blue"></span><span
                class="span-currency">EURO</span>
    </div>
    <div class="vnd">
        <input onclick="responsiveVoice.speak($('.allNumberToWordVND').text());" type='button' value='🔊 Play' /><span class="span-currency">VND:</span><span class="allNumberToWordVND span-currency color-blue"></span><span
                class="span-currency">Vietnam Dong</span>
    </div>
    <div class="gbp">
        <input onclick="responsiveVoice.speak($('.allNumberToWordFBP').text());" type='button' value='🔊 Play' /><span class="span-currency">GBP:</span><span class="allNumberToWordFBP span-currency color-blue"></span><span
                class="span-currency">United Kingdom Pounds</span>
    </div>
</div>


<input type="hidden" value="{{ url('/') }}" id="home">
</body>
</html>