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
    <h1>SPELLOUT NUMBER</h1>
</div>
<div class="col-xs-12">
    <p>Input Number</p>
    <input type="number" id="numberInput" value="321456">
    <button class="btn btn-green" type="submit" id="getEachDigits">Convert Each Digits To Word</button>
    <button class="btn btn-default" type="submit" id="getResultFromNumber">Convert to Word</button>
</div>
<div class="col-xs-12">
    <p>Spellout each digits of number input:<span class="eachNumberToWord"></span></p><i class="fas fa-volume-up"></i>
    <p>Spellout rule-based format: <span class="allNumberToWord"></span></p><i class="fas fa-volume-up"></i>
</div>
<div class="convert-title">
    <h1>CONVERT CURRENCY</h1>
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
        <select name="to_currency" class="inputCurrency">
            <option value="INR" selected="1">Indian Rupee</option>
            <option value="USD">US Dollar</option>
            <option value="AUD">Australian Dollar</option>
            <option value="EUR">Euro</option>
            <option value="EGP">Egyptian Pound</option>
            <option value="CNY">Chinese Yuan</option>
        </select>
        <button type="submit" name="convert" id="convert" class="btn btn-default">Convert</button>
    </div>
</form>
<span id="results"></span>

<div class="convert-title">
    <h1>CURRENCY</h1>
</div>
<div class="col-xs-12">
    <div class="usd">
        <span class="span-currency">USD:</span><span class="allNumberToWord span-currency"></span><span
                class="span-currency">United States Dollars</span><i class="fas fa-volume-up"></i>
    </div>
    <div class="eur">
        <span class="span-currency">EUR:</span><span class="allNumberToWord span-currency"></span><span
                class="span-currency">EURO</span><i class="fas fa-volume-up"></i>
    </div>
    <div class="vnd">
        <span class="span-currency">VND:</span><span class="allNumberToWord span-currency"></span><span
                class="span-currency">Vietnam Dong</span><i class="fas fa-volume-up"></i>
    </div>
    <div class="gbp">
        <span class="span-currency">GBP:</span><span class="allNumberToWord span-currency"></span><span
                class="span-currency">United Kingdom Pounds</span><i class="fas fa-volume-up"></i>
    </div>
</div>

<input onclick='responsiveVoice.speak("THREE HUNDRED TWENTY-ONE THOUSAND FOUR HUNDRED FIFTY-SIX Viet Nam Dong");' type='button' value='🔊 Play' />
<input type="hidden" value="{{ url('/') }}" id="home">
</body>
</html>