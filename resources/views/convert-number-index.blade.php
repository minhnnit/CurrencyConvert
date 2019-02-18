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
    <script src="https://code.responsivevoice.org/responsivevoice.js"></script>
    <script type="text/javascript" charset="utf8" src="{{ asset('/js/convert-number-to-word.js') }}"></script>
    <link href='https://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>
<body>
<header>
    <div class="header-content">
        <div class="logo-header">
            <a href="{{ url('/') }}">
                <img src="{{ asset ('img/Back-To-Homepage-button.png') }}" alt="">
            </a>
        </div>
    </div>
</header>
<div class="container-fluid bg-convert text-left darkgrey">
    <div class="row default">
        <div class="col-sm-5 col-sm-offset-1">
            <h1>Currency Converter</h1>
            <p class="fs-16px">Fill in the currency to convert</p>
        </div>
        <div class="col-sm-4 col-sm-offset-1">
            <p>Select the currency and enter the amount you have. Then select the currency you would like and click
                'Convert'. You'll see how much the recipient account would get based on <b>Currency Converter Api.</b>
            </p>
            <div class="converter-container">
                <div class="converter-box bg-lightgrey" id="currency-converter">
                    <h3 class="text-center">Currency Converter</h3>
                    <div id="calculator" class="row">
                        <form id="currency-form" class="form-horizontal"
                              method="post">
                            <div class=" form-group ">
                                <div class="col-xs-12">
                                    <select name="from_currency" placeholder="Sell currency"
                                            class="form-control col-lg-3" required="">
                                        <optgroup id="sell_currency-optgroup-Common currencies"
                                                  label="Common currencies">
                                            <option value="AUD">AUD Australian Dollar</option>
                                            <option value="CAD">CAD Canadian Dollar</option>
                                            <option value="EUR">EUR Euro</option>
                                            <option value="GBP">GBP British Pound</option>
                                            <option value="USD" selected="selected">USD United States Dollar</option>
                                            <option value="ZAR">ZAR South African Rand</option>
                                        </optgroup>
                                        <optgroup id="sell_currency-optgroup-Other currencies" label="Other currencies">
                                            <option value="AED">AED United Arab Emirates Dirham</option>
                                            <option value="ALL">ALL Albanian Lek</option>
                                            <option value="AMD">AMD Armenian Dram</option>
                                            <option value="ANG">ANG Netherlands Antillean Guilder</option>
                                            <option value="AOA">AOA Angolan Kwanza</option>
                                            <option value="ARS">ARS Argentine Peso</option>
                                            <option value="AUD">AUD Australian Dollar</option>
                                            <option value="AZN">AZN Azerbaijan New Manat</option>
                                            <option value="BAM">BAM Bosnia Herzegovina Marka</option>
                                            <option value="BBD">BBD Barbados Dollars</option>
                                            <option value="BDT">BDT Bangladesh Taka</option>
                                            <option value="BGN">BGN Bulgarian lev</option>
                                            <option value="BHD">BHD Bahrain dinars</option>
                                            <option value="BIF">BIF Burundian Franc</option>
                                            <option value="BMD">BMD Bermudian Dollar</option>
                                            <option value="BND">BND Brunei Dollar</option>
                                            <option value="BOB">BOB Bolivian Boliviano</option>
                                            <option value="BRL">BRL Brazilian Real</option>
                                            <option value="BSD">BSD Bahamian Dollar</option>
                                            <option value="BWP">BWP Botswana Pula</option>
                                            <option value="BYN">BYN New Belarusian ruble</option>
                                            <option value="BZD">BZD Belize Dollar</option>
                                            <option value="CAD">CAD Canadian Dollar</option>
                                            <option value="CDF">CDF Congolese Franc</option>
                                            <option value="CHF">CHF Swiss Franc</option>
                                            <option value="CLP">CLP Chilean Peso</option>
                                            <option value="CNH">CNH Chinese Offshore Yuan</option>
                                            <option value="CNY">CNY Chinese Yuan</option>
                                            <option value="COP">COP Colombian Peso</option>
                                            <option value="CRC">CRC Costa Rican Colon</option>
                                            <option value="CVE">CVE Cape Verde Escudo</option>
                                            <option value="CZK">CZK Czech Koruna</option>
                                            <option value="DJF">DJF Djibouti Franc</option>
                                            <option value="DKK">DKK Danish Kroner</option>
                                            <option value="DOP">DOP Dominican Peso</option>
                                            <option value="DZD">DZD Algerian Dinar</option>
                                            <option value="EGP">EGP Egyptian Pound</option>
                                            <option value="ERN">ERN Eritrean Nakfa</option>
                                            <option value="ETB">ETB Ethiopian Birr</option>
                                            <option value="EUR">EUR Euro</option>
                                            <option value="FJD">FJD Fijian Dollars</option>
                                            <option value="GBP">GBP British Pound</option>
                                            <option value="GEL">GEL Georgian Lari</option>
                                            <option value="GHS">GHS Ghanaian Cedi</option>
                                            <option value="GMD">GMD Gambian Dalasi</option>
                                            <option value="GNF">GNF Guinean Franc</option>
                                            <option value="GTQ">GTQ Guatemalan Quetzal</option>
                                            <option value="GYD">GYD Guyanese Dollar</option>
                                            <option value="HKD">HKD Hong Kong Dollar</option>
                                            <option value="HNL">HNL Honduran Lempira</option>
                                            <option value="HRK">HRK Croatian Kuna</option>
                                            <option value="HTG">HTG Haitian Gourde</option>
                                            <option value="HUF">HUF Hungarian Forint</option>
                                            <option value="IDR">IDR Indonesian Rupiah</option>
                                            <option value="ILS">ILS Israeli New Shekel</option>
                                            <option value="INR">INR Indian Rupees</option>
                                            <option value="IQD">IQD Iraqi Dinar</option>
                                            <option value="ISK">ISK Icelandic Kronur</option>
                                            <option value="JMD">JMD Jamaican Dollar</option>
                                            <option value="JOD">JOD Jordan Dinar</option>
                                            <option value="JPY">JPY Japanese Yen</option>
                                            <option value="KES">KES Kenyan Shilling</option>
                                            <option value="KHR">KHR Cambodian Riel</option>
                                            <option value="KRW">KRW South Korean Won</option>
                                            <option value="KWD">KWD Kuwaiti Dinar</option>
                                            <option value="KYD">KYD Cayman Island Dollar</option>
                                            <option value="KZT">KZT Kazakhstani Tenge</option>
                                            <option value="LAK">LAK Laos Kip</option>
                                            <option value="LBP">LBP Lebanese Pound</option>
                                            <option value="LKR">LKR Sri Lankan Rupee</option>
                                            <option value="LRD">LRD Liberian Dollar</option>
                                            <option value="LSL">LSL Lesotho Loti</option>
                                            <option value="MAD">MAD Moroccan Dirham</option>
                                            <option value="MGA">MGA Malagsy Ariary</option>
                                            <option value="MKD">MKD Macedonian Denar</option>
                                            <option value="MNT">MNT Mongolian Tugrik</option>
                                            <option value="MRO">MRO Mauritanian Ouguiya</option>
                                            <option value="MUR">MUR Mauritian Rupees</option>
                                            <option value="MWK">MWK Malawian Kwacha</option>
                                            <option value="MXN">MXN Mexican Peso</option>
                                            <option value="MYR">MYR Malaysian Ringgit</option>
                                            <option value="MZN">MZN Mozambican Metical</option>
                                            <option value="NAD">NAD Namibian Dollar</option>
                                            <option value="NGN">NGN Nigerian Naira</option>
                                            <option value="NIO">NIO Nicaraguan Cordoba</option>
                                            <option value="NOK">NOK Norwegian Krone</option>
                                            <option value="NPR">NPR Nepalese Rupee</option>
                                            <option value="NZD">NZD New Zealand Dollar</option>
                                            <option value="OMR">OMR Omani Riyal</option>
                                            <option value="PEN">PEN Peruvian Nuevo Sol</option>
                                            <option value="PGK">PGK Papua New Guinean Kina</option>
                                            <option value="PHP">PHP Philippine Peso</option>
                                            <option value="PKR">PKR Pakistan Rupees</option>
                                            <option value="PLN">PLN Polish Zlotych</option>
                                            <option value="PYG">PYG Paraguayan Guarani</option>
                                            <option value="QAR">QAR Qatari Rial</option>
                                            <option value="RON">RON Romanian Lei</option>
                                            <option value="RSD">RSD Serbian Dinar</option>
                                            <option value="RUB">RUB Russian ruble</option>
                                            <option value="RWF">RWF Rwandan Franc</option>
                                            <option value="SAR">SAR Saudi Arabian Riyal</option>
                                            <option value="SBD">SBD Solomon Islands Dollar</option>
                                            <option value="SCR">SCR Seychelles Rupee</option>
                                            <option value="SEK">SEK Swedish Kronor</option>
                                            <option value="SGD">SGD Singapore Dollar</option>
                                            <option value="SLL">SLL Sierra Leonean Leone</option>
                                            <option value="SRD">SRD Surinamese Dollar</option>
                                            <option value="STD">STD Sao Tome &amp; Principe Dobra</option>
                                            <option value="SZL">SZL Swaziland Lilangeni</option>
                                            <option value="THB">THB Thai Baht</option>
                                            <option value="TND">TND Tunisian dinar</option>
                                            <option value="TOP">TOP Tongan Pa'anga</option>
                                            <option value="TRY">TRY Turkish Lira</option>
                                            <option value="TTD">TTD Trinidad and Tobago Dollars</option>
                                            <option value="TWD">TWD Taiwan New Dollar</option>
                                            <option value="TZS">TZS Tanzanian Shilling</option>
                                            <option value="UGX">UGX Ugandan Shilling</option>
                                            <option value="USD" selected="selected">USD United States Dollar</option>
                                            <option value="UYU">UYU Uruguayan Peso</option>
                                            <option value="VEF">VEF Venezuelan Bolivar Fuerte</option>
                                            <option value="VND">VND Vietnamese Dong</option>
                                            <option value="VUV">VUV Vanuatu Vatu</option>
                                            <option value="WST">WST Samoan Tala</option>
                                            <option value="XAF">XAF Cameroon Central African Franc</option>
                                            <option value="XCD">XCD East Carribean Dollar</option>
                                            <option value="XOF">XOF Central African States CFA Fra</option>
                                            <option value="XPF">XPF French Pacific Franc</option>
                                            <option value="ZAR">ZAR South African Rand</option>
                                            <option value="ZMW">ZMW Zambian Kwacha</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="sell-amount form-group ">
                                <div class="col-xs-12">
                                    <div class="input-group">
                                        <input type="number" placeholder="Currency" name="amount" id="amount"
                                               class="form-control inputCurrency" value="1"/><span
                                                class="input-group-addon"><span
                                                    class="icon-refresh no-margin"><b>Amount</b></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class=" form-group ">
                                <div class="col-xs-12">
                                    <select name="to_currency" placeholder="Buy currency"
                                            class="form-control col-lg-3" required="">
                                        <optgroup id="buy_currency-optgroup-Common currencies"
                                                  label="Common currencies">
                                            <option value="AUD">AUD Australian Dollar</option>
                                            <option value="CAD">CAD Canadian Dollar</option>
                                            <option value="EUR">EUR Euro</option>
                                            <option value="GBP" selected="selected">GBP British Pound</option>
                                            <option value="USD">USD United States Dollar</option>
                                            <option value="ZAR">ZAR South African Rand</option>
                                        </optgroup>
                                        <optgroup id="buy_currency-optgroup-Other currencies" label="Other currencies">
                                            <option value="AED">AED United Arab Emirates Dirham</option>
                                            <option value="ALL">ALL Albanian Lek</option>
                                            <option value="AMD">AMD Armenian Dram</option>
                                            <option value="ANG">ANG Netherlands Antillean Guilder</option>
                                            <option value="AOA">AOA Angolan Kwanza</option>
                                            <option value="ARS">ARS Argentine Peso</option>
                                            <option value="AUD">AUD Australian Dollar</option>
                                            <option value="AZN">AZN Azerbaijan New Manat</option>
                                            <option value="BAM">BAM Bosnia Herzegovina Marka</option>
                                            <option value="BBD">BBD Barbados Dollars</option>
                                            <option value="BDT">BDT Bangladesh Taka</option>
                                            <option value="BGN">BGN Bulgarian lev</option>
                                            <option value="BHD">BHD Bahrain dinars</option>
                                            <option value="BIF">BIF Burundian Franc</option>
                                            <option value="BMD">BMD Bermudian Dollar</option>
                                            <option value="BND">BND Brunei Dollar</option>
                                            <option value="BOB">BOB Bolivian Boliviano</option>
                                            <option value="BRL">BRL Brazilian Real</option>
                                            <option value="BSD">BSD Bahamian Dollar</option>
                                            <option value="BWP">BWP Botswana Pula</option>
                                            <option value="BYN">BYN New Belarusian ruble</option>
                                            <option value="BZD">BZD Belize Dollar</option>
                                            <option value="CAD">CAD Canadian Dollar</option>
                                            <option value="CDF">CDF Congolese Franc</option>
                                            <option value="CHF">CHF Swiss Franc</option>
                                            <option value="CLP">CLP Chilean Peso</option>
                                            <option value="CNH">CNH Chinese Offshore Yuan</option>
                                            <option value="CNY">CNY Chinese Yuan</option>
                                            <option value="COP">COP Colombian Peso</option>
                                            <option value="CRC">CRC Costa Rican Colon</option>
                                            <option value="CVE">CVE Cape Verde Escudo</option>
                                            <option value="CZK">CZK Czech Koruna</option>
                                            <option value="DJF">DJF Djibouti Franc</option>
                                            <option value="DKK">DKK Danish Kroner</option>
                                            <option value="DOP">DOP Dominican Peso</option>
                                            <option value="DZD">DZD Algerian Dinar</option>
                                            <option value="EGP">EGP Egyptian Pound</option>
                                            <option value="ERN">ERN Eritrean Nakfa</option>
                                            <option value="ETB">ETB Ethiopian Birr</option>
                                            <option value="EUR">EUR Euro</option>
                                            <option value="FJD">FJD Fijian Dollars</option>
                                            <option value="GBP" selected="selected">GBP British Pound</option>
                                            <option value="GEL">GEL Georgian Lari</option>
                                            <option value="GHS">GHS Ghanaian Cedi</option>
                                            <option value="GMD">GMD Gambian Dalasi</option>
                                            <option value="GNF">GNF Guinean Franc</option>
                                            <option value="GTQ">GTQ Guatemalan Quetzal</option>
                                            <option value="GYD">GYD Guyanese Dollar</option>
                                            <option value="HKD">HKD Hong Kong Dollar</option>
                                            <option value="HNL">HNL Honduran Lempira</option>
                                            <option value="HRK">HRK Croatian Kuna</option>
                                            <option value="HTG">HTG Haitian Gourde</option>
                                            <option value="HUF">HUF Hungarian Forint</option>
                                            <option value="IDR">IDR Indonesian Rupiah</option>
                                            <option value="ILS">ILS Israeli New Shekel</option>
                                            <option value="INR">INR Indian Rupees</option>
                                            <option value="IQD">IQD Iraqi Dinar</option>
                                            <option value="ISK">ISK Icelandic Kronur</option>
                                            <option value="JMD">JMD Jamaican Dollar</option>
                                            <option value="JOD">JOD Jordan Dinar</option>
                                            <option value="JPY">JPY Japanese Yen</option>
                                            <option value="KES">KES Kenyan Shilling</option>
                                            <option value="KHR">KHR Cambodian Riel</option>
                                            <option value="KRW">KRW South Korean Won</option>
                                            <option value="KWD">KWD Kuwaiti Dinar</option>
                                            <option value="KYD">KYD Cayman Island Dollar</option>
                                            <option value="KZT">KZT Kazakhstani Tenge</option>
                                            <option value="LAK">LAK Laos Kip</option>
                                            <option value="LBP">LBP Lebanese Pound</option>
                                            <option value="LKR">LKR Sri Lankan Rupee</option>
                                            <option value="LRD">LRD Liberian Dollar</option>
                                            <option value="LSL">LSL Lesotho Loti</option>
                                            <option value="MAD">MAD Moroccan Dirham</option>
                                            <option value="MGA">MGA Malagsy Ariary</option>
                                            <option value="MKD">MKD Macedonian Denar</option>
                                            <option value="MNT">MNT Mongolian Tugrik</option>
                                            <option value="MRO">MRO Mauritanian Ouguiya</option>
                                            <option value="MUR">MUR Mauritian Rupees</option>
                                            <option value="MWK">MWK Malawian Kwacha</option>
                                            <option value="MXN">MXN Mexican Peso</option>
                                            <option value="MYR">MYR Malaysian Ringgit</option>
                                            <option value="MZN">MZN Mozambican Metical</option>
                                            <option value="NAD">NAD Namibian Dollar</option>
                                            <option value="NGN">NGN Nigerian Naira</option>
                                            <option value="NIO">NIO Nicaraguan Cordoba</option>
                                            <option value="NOK">NOK Norwegian Krone</option>
                                            <option value="NPR">NPR Nepalese Rupee</option>
                                            <option value="NZD">NZD New Zealand Dollar</option>
                                            <option value="OMR">OMR Omani Riyal</option>
                                            <option value="PEN">PEN Peruvian Nuevo Sol</option>
                                            <option value="PGK">PGK Papua New Guinean Kina</option>
                                            <option value="PHP">PHP Philippine Peso</option>
                                            <option value="PKR">PKR Pakistan Rupees</option>
                                            <option value="PLN">PLN Polish Zlotych</option>
                                            <option value="PYG">PYG Paraguayan Guarani</option>
                                            <option value="QAR">QAR Qatari Rial</option>
                                            <option value="RON">RON Romanian Lei</option>
                                            <option value="RSD">RSD Serbian Dinar</option>
                                            <option value="RUB">RUB Russian ruble</option>
                                            <option value="RWF">RWF Rwandan Franc</option>
                                            <option value="SAR">SAR Saudi Arabian Riyal</option>
                                            <option value="SBD">SBD Solomon Islands Dollar</option>
                                            <option value="SCR">SCR Seychelles Rupee</option>
                                            <option value="SEK">SEK Swedish Kronor</option>
                                            <option value="SGD">SGD Singapore Dollar</option>
                                            <option value="SLL">SLL Sierra Leonean Leone</option>
                                            <option value="SRD">SRD Surinamese Dollar</option>
                                            <option value="STD">STD Sao Tome &amp; Principe Dobra</option>
                                            <option value="SZL">SZL Swaziland Lilangeni</option>
                                            <option value="THB">THB Thai Baht</option>
                                            <option value="TND">TND Tunisian dinar</option>
                                            <option value="TOP">TOP Tongan Pa'anga</option>
                                            <option value="TRY">TRY Turkish Lira</option>
                                            <option value="TTD">TTD Trinidad and Tobago Dollars</option>
                                            <option value="TWD">TWD Taiwan New Dollar</option>
                                            <option value="TZS">TZS Tanzanian Shilling</option>
                                            <option value="UGX">UGX Ugandan Shilling</option>
                                            <option value="USD">USD United States Dollar</option>
                                            <option value="UYU">UYU Uruguayan Peso</option>
                                            <option value="VEF">VEF Venezuelan Bolivar Fuerte</option>
                                            <option value="VND">VND Vietnamese Dong</option>
                                            <option value="VUV">VUV Vanuatu Vatu</option>
                                            <option value="WST">WST Samoan Tala</option>
                                            <option value="XAF">XAF Cameroon Central African Franc</option>
                                            <option value="XCD">XCD East Carribean Dollar</option>
                                            <option value="XOF">XOF Central African States CFA Fra</option>
                                            <option value="XPF">XPF French Pacific Franc</option>
                                            <option value="ZAR">ZAR South African Rand</option>
                                            <option value="ZMW">ZMW Zambian Kwacha</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input type="text" id="responseConvert"
                                           class="color-blue form-control inputCurrency" readonly>
                                </div>
                            </div>
                            <div class=" form-group ">
                                <div class="col-xs-12">
                                    <span name="convert" id="convert" value="
Convert" buttons="danger info primary success warning inverse link" class="btn btn-wf-blue s125 btn btn-default">
                                        <b>Convert</b><i
                                                class="fas fa-arrow-right"></i>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div id="main">
        <div class="col-lg-9 col-xs-12">
            <div class="convert-number-left">
                <h3 class="h3-title">SPELLOUT NUMBER</h3>
                <div class="image">
                    <div class="spellout-number">
                        <p class="text-center"><b>Input Number</b></p>
                        <input type="number" class="form-control inputCurrency-nb text-center" required=""
                               id="numberInput"
                               value="{{!empty($data["numberInput"]) ? $data["numberInput"] : '1'}}">
                        <div class="button-convert-first">
                            <button class="btn btn-default btn-padding" type="submit" id="getAllResults"><b>Convert
                                    Number To Word</b>
                            </button>
                        </div>
                    </div>
                    <div class="number-type">
                        <div>
                            <table class="table text-white">
                                <thead>
                                <tr>
                                    <th>Spellout</th>
                                    <th>Value</th>
                                    <th>Audio</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><span><b>Spellout Each Digits Of Number Input</b></span></td>
                                    <td>
                                        <span class="eachNumberToWordAudio"><b>{{!empty($data["convertDigits"]) ? $data["convertDigits"] : 'one'}}</b></span>
                                    </td>
                                    <td><input class="speak-audio"
                                               onclick="responsiveVoice.speak($('.eachNumberToWordAudio').text());"
                                               type='button' value='🔊'/></td>
                                </tr>
                                <tr>
                                    <td><span><b>Spellout rule-based format</b></span></td>
                                    <td><span
                                                class="allNumberToWordAudio"><b>{{!empty($data["convertNumber"]) ? $data["convertNumber"] : 'one'}}</b></span>
                                    </td>
                                    <td><input class="speak-audio"
                                               onclick="responsiveVoice.speak($('.allNumberToWordAudio').text());"
                                               type='button'
                                               value='🔊'/></td>
                                </tr>
                                <tr>
                                    <td><b>Even numbers in input string</b></td>
                                    <td><span><b>{{!empty($data["evenNumber"]) ? $data["evenNumber"] : ''}}</b></span>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><b>Odd numbers in input string</b></td>
                                    <td><span><b>{{!empty($data["oddNumber"]) ? $data["oddNumber"] : '1'}}</b></span></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><b>Min number in input string</b></td>
                                    <td><span><b>{{!empty($data["minNumber"]) ? $data["minNumber"] : '1'}}</b></span></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><b>Sum all digits in input string</b></td>
                                    <td><span><b>{{!empty($data["arraySum"]) ? $data["arraySum"] : '1'}}</b></span></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-12 ">
            <h3 class="relate-number text-center">RELATE AND RANDOM NUMBER</h3>
            <div class="sidebar-bg">
                <div class="text-center sidebar-fs">
                    <span>
                        @if(!empty($data["numberAdd"]))
                            @foreach(($data["numberAdd"]) as $el)
                                <a href="{{url('/')}}/{{$el}}-numbers">
                                <span class="relateNumber">{{$el}}</span>
                            </a>
                            @endforeach
                        @endif
                    </span>
                    <span>
                         @if(!empty($data["numberSub"]))
                            @foreach(($data["numberSub"]) as $el)
                                <a href="{{url('/')}}/{{$el}}-numbers">
                                <span class="relateNumber">{{$el}}</span>
                            </a>
                            @endforeach
                        @endif
                    </span>
                </div>
                <div class="span-currency random-number text-center">
                    <span class="sidebar-fs"><b>Random Numbers:</b></span>
                    <div class="sidebar-fs">
                        @if(!empty($data["randomNumber"]))
                            @foreach(($data["randomNumber"]) as $vl)
                                <a href="{{url('/')}}/{{$vl}}-numbers">
                                    <span class="randomNumber">{{$vl}}</span>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <section class="currency-res" tabindex="-1">
        <h3 class="h3-title text-center">CURRENCIES TO AUDIO</h3>
        <div class="lead">
            <table class="table">
                <thead class="thead-color">
                <tr>
                    <th>Currencies</th>
                    <th>Currencies to text</th>
                    <th>Audio</th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($listCurrency))
                    @foreach($listCurrency as $v => $v_value)
                        <tr>
                            <td><span class="span-currency"><b>{{$v}}</b></span></td>
                            <td>
                                <span class="span-currency {{$v}}">{{!empty($data["convertNumber"]) ? $data["convertNumber"] : 'one'}} {{$v_value}}</span>
                            </td>
                            <td><input class="speak-audio" onclick="responsiveVoice.speak($('.{{$v}}').text());"
                                       type='button' value='🔊'/></td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div class="more more-lead text-center"><span class="btn btn-wf-blue"><b>More</b></span></div>
    </section>
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