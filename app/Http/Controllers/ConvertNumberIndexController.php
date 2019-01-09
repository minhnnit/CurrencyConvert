<?php namespace App\Http\Controllers;

use Illuminate\Http\Request as Re;
use NumberFormatter;


class ConvertNumberIndexController extends Controller
{
    public function index()
    {
        $listCurrency = [
            "USD" => "United States Dollars",
            "EUR" => "EURO",
            "VND" => "Vietnam Dong",
            "GBP" => "British Pound",
            "EGP" => "Egyptian Pound",
            "CNY" => "Chinese Yuan",
            "CAD" => "Canadian Dollar",
            "FRF" => "French Franc",
            "DEM" => "German Mark",
            "HKD" => "HongKong Dollar",
            "ISK" => "Iceland Krona",
            "IDR" => "Indonesian Rupiah",
            "JPY" => "Japanese Yen",
            "LAK" => "Lao Kip",
            "MOP" => "Macau Pataca",
            "MXN" => "Mexican Peso",
            "BRL" => "Brazilian Real",
            "PHP" => "Philippine Peso",
            "THB" => "Thai Baht",
            "TWD" => "Taiwan Dollar",
            "SEK" => "Swedish Krona",
            "ZWD" => "Zimbabwe Dollar",
            "ZMK" => "Zambian Kwacha",
            "VES" => "Venezuelan Bolivar Soberano",
            "UZS" => "Uzbekistan Som",
            "UAH" => "Ukraine Hryvnia",
            "UYU" => "Uruguayan Peso",
            "UGX" => "Uganda Shilling",
            "TMM" => "Turkmenistan Manat",
            "TRY" => "Turkish Lira",
            "TOP" => "Tonga Pa'anga",
            "TJS" => "Tajikistani Somoni",
            "CHF" => "Swiss Franc",
            "LKR" => "Sri Lanka Rupee",
            "ESP" => "Spanish Peseta",
            "RON" => "Romanian New Lei",
            "PTE" => "Portuguese Escudo",
            "PLN" => "Polish Zloty",
            "PKR" => "Pakistan Rupee",
            "KPW" => "North Korean Won",
            "NGN" => "Nigerian Naira",
            "NZD" => "New Zealand Dollar",
            "MMK" => "Myanmar Kyat",
            "MAD" => "Moroccan Dirham",
            "MYR" => "Malaysian Ringgit",
            "LYD" => "Libyan Dinar",
            "KZT" => "Kazakhstan Tenge",
            "JMD" => "Jamaican Dollar",
            "ITL" => "Italian Lira",
            "IQD" => "Iraqi Dinar",
            "HUF" => "Hungarian Forint",
            "GNF" => "Guinea Franc",
            "ECS" => "Ecuador Sucre",
            "CZK" => "Czech Koruna",
            "CUP" => "Cuban Peso",
            "CLP" => "Chilean Peso",
            "KYD" => "Cayman Islands Dollar",
            "BIF" => "Burundi Franc",
            "BGN" => "Bulgarian Lev",
            "BND" => "Brunei Dollar",
            "BWP" => "Botswana Pula",
            "BAM" => "Bosnian Mark",
            "BEF" => "Belgian Franc",
            "BTN" => "Bhutan Ngultrum",
            "BHD" => "Bahraini Dinar",
            "ARS" => "Argentine Peso",
            "ALL" => "Albanian Lek"
        ];
        return view('convert-number')->with('listCurrency', $listCurrency);
    }

    public function convertNumber($numberInput)
    {
        $numberConvert = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return $numberConvert->format($numberInput);
    }

    public function convertDigits($numberInput)
    {
        $splitNum = str_split($numberInput);
        $numberArr = [];
        $inputNumCount = (count($splitNum));
        for ($i = 0; $i < $inputNumCount; $i++) {
            $countDigits = new NumberFormatter("en", NumberFormatter::SPELLOUT);
            $convertDigit = $countDigits->format($numberInput[$i]);
            array_push($numberArr, $convertDigit);
        }
        return join(', ', $numberArr);
    }

    public function evenNumber($numberInput)
    {
        $splitNum = str_split($numberInput);
        $evenNumberArr = [];
        $inputNumCount = count($splitNum);
        for ($i = 0; $i < $inputNumCount; $i++) {
            if ($numberInput[$i] % 2 == 0) {
                array_push($evenNumberArr, $numberInput[$i]);
//                $evenNumberArrUnique = array_unique($evenNumberArr);
            }
        }
        return join(', ', $evenNumberArr);
    }

    public function oddNumber($numberInput)
    {
        $splitNum = str_split($numberInput);
        $oddNumberArr = [];
        $inputNumCount = count($splitNum);
        for ($i = 0; $i < $inputNumCount; $i++) {
            if ($numberInput[$i] % 2 != 0) {
                array_push($oddNumberArr, $numberInput[$i]);
//                $oddNumberArrUnique =  array_unique($oddNumberArr);
            }
        }
        return join(', ', $oddNumberArr);
    }

    public function numberAdd($numberInput)
    {
        $numberAddArr = [];
        for ($i = 0; $i < 5; $i++) {
            $numberAdd = $numberInput += 1;
            array_push($numberAddArr, $numberAdd);
        }
        return join(', ',$numberAddArr);
    }

    public function numberAdd1($numberInput){
        $numberAdd1 = $numberInput += 1;
        return $numberAdd1;
    }
    public function numberAdd2($numberInput){
        $numberAdd2 = $numberInput += 2;
        return $numberAdd2;
    }
    public function numberAdd3($numberInput){
        $numberAdd3 = $numberInput += 3;
        return $numberAdd3;
    }
    public function numberAdd4($numberInput){
        $numberAdd4 = $numberInput += 4;
        return $numberAdd4;
    }
    public function numberAdd5($numberInput){
        $numberAdd5 = $numberInput += 5;
        return $numberAdd5;
    }

    public function numberSub1($numberInput){
        $numberSub1 = $numberInput -= 1;
        return $numberSub1;
    }
    public function numberSub2($numberInput){
        $numberSub2 = $numberInput -= 2;
        return $numberSub2;
    }
    public function numberSub3($numberInput) {
        $numberSub3 = $numberInput -= 3;
        return $numberSub3;
    }
    public function numberSub4($numberInput) {
        $numberSub4 = $numberInput -= 4;
        return $numberSub4;
    }
    public function numberSub5($numberInput) {
        $numberSub5 = $numberInput -= 5;
        return $numberSub5;
    }

    public function numberSub($numberInput)
    {
        $numberSubArr = [];
        for ($i = 0; $i < 5; $i++) {
            $numberSub = $numberInput -= 1;
            array_push($numberSubArr, $numberSub);
        }
        return join(', ',$numberSubArr);
    }

    public function randomNumber1($numberInput)
    {
        $randomNumber = rand(1,$numberInput);
        return $randomNumber;
    }
    public function randomNumber2($numberInput)
    {
        $randomNumber = rand(1,$numberInput);
        return $randomNumber;
    }
    public function randomNumber3($numberInput)
    {
        $randomNumber = rand(1,$numberInput);
        return $randomNumber;
    }
    public function randomNumber4($numberInput)
    {
        $randomNumber = rand(1,$numberInput);
        return $randomNumber;
    }
    public function randomNumber5($numberInput)
    {
        $randomNumber = rand(1,$numberInput);
        return $randomNumber;
    }

    public function inputNumberUrl($numberInput)
    {
        $listCurrency = [
            "USD" => "United States Dollars",
            "EUR" => "EURO",
            "VND" => "Vietnam Dong",
            "GBP" => "British Pound",
            "EGP" => "Egyptian Pound",
            "CNY" => "Chinese Yuan",
            "CAD" => "Canadian Dollar",
            "FRF" => "French Franc",
            "DEM" => "German Mark",
            "HKD" => "HongKong Dollar",
            "ISK" => "Iceland Krona",
            "IDR" => "Indonesian Rupiah",
            "JPY" => "Japanese Yen",
            "LAK" => "Lao Kip",
            "MOP" => "Macau Pataca",
            "MXN" => "Mexican Peso",
            "BRL" => "Brazilian Real",
            "PHP" => "Philippine Peso",
            "THB" => "Thai Baht",
            "TWD" => "Taiwan Dollar",
            "SEK" => "Swedish Krona",
            "ZWD" => "Zimbabwe Dollar",
            "ZMK" => "Zambian Kwacha",
            "VES" => "Venezuelan Bolivar Soberano",
            "UZS" => "Uzbekistan Som",
            "UAH" => "Ukraine Hryvnia",
            "UYU" => "Uruguayan Peso",
            "UGX" => "Uganda Shilling",
            "TMM" => "Turkmenistan Manat",
            "TRY" => "Turkish Lira",
            "TOP" => "Tonga Pa'anga",
            "TJS" => "Tajikistani Somoni",
            "CHF" => "Swiss Franc",
            "LKR" => "Sri Lanka Rupee",
            "ESP" => "Spanish Peseta",
            "RON" => "Romanian New Lei",
            "PTE" => "Portuguese Escudo",
            "PLN" => "Polish Zloty",
            "PKR" => "Pakistan Rupee",
            "KPW" => "North Korean Won",
            "NGN" => "Nigerian Naira",
            "NZD" => "New Zealand Dollar",
            "MMK" => "Myanmar Kyat",
            "MAD" => "Moroccan Dirham",
            "MYR" => "Malaysian Ringgit",
            "LYD" => "Libyan Dinar",
            "KZT" => "Kazakhstan Tenge",
            "JMD" => "Jamaican Dollar",
            "ITL" => "Italian Lira",
            "IQD" => "Iraqi Dinar",
            "HUF" => "Hungarian Forint",
            "GNF" => "Guinea Franc",
            "ECS" => "Ecuador Sucre",
            "CZK" => "Czech Koruna",
            "CUP" => "Cuban Peso",
            "CLP" => "Chilean Peso",
            "KYD" => "Cayman Islands Dollar",
            "BIF" => "Burundi Franc",
            "BGN" => "Bulgarian Lev",
            "BND" => "Brunei Dollar",
            "BWP" => "Botswana Pula",
            "BAM" => "Bosnian Mark",
            "BEF" => "Belgian Franc",
            "BTN" => "Bhutan Ngultrum",
            "BHD" => "Bahraini Dinar",
            "ARS" => "Argentine Peso",
            "ALL" => "Albanian Lek"
        ];
        $splitNum = str_split($numberInput);

        $maxValue = max($splitNum);
        $minValue = min($splitNum);
        $arraySum = array_sum($splitNum);
        $data = [];
        $data["evenNumber"] = $this->evenNumber($numberInput);
        $data["oddNumber"] = $this->oddNumber($numberInput);
        $data["maxNumber"] = $maxValue;
        $data["minNumber"] = $minValue;
        $data["arraySum"] = $arraySum;
      /*  $data["numberAdd"] = $this->numberAdd($numberInput);
        $data["numberSub"] = $this->numberSub($numberInput);*/
        $data["numberAdd1"] = $this->numberAdd1($numberInput);
        $data["numberAdd2"] = $this->numberAdd2($numberInput);
        $data["numberAdd3"] = $this->numberAdd3($numberInput);
        $data["numberAdd4"] = $this->numberAdd4($numberInput);
        $data["numberAdd5"] = $this->numberAdd5($numberInput);
        $data["numberSub1"] = $this->numberSub1($numberInput);
        $data["numberSub2"] = $this->numberSub2($numberInput);
        $data["numberSub3"] = $this->numberSub3($numberInput);
        $data["numberSub4"] = $this->numberSub4($numberInput);
        $data["numberSub5"] = $this->numberSub5($numberInput);
        $data["randomNumber1"] = $this->randomNumber1($numberInput);
        $data["randomNumber2"] = $this->randomNumber2($numberInput);
        $data["randomNumber3"] = $this->randomNumber3($numberInput);
        $data["randomNumber4"] = $this->randomNumber4($numberInput);
        $data["randomNumber5"] = $this->randomNumber5($numberInput);
        $data["convertNumber"] = $this->convertNumber($numberInput);
        $data["convertDigits"] = $this->convertDigits($numberInput);
        $data["numberInput"] = $numberInput;
        return view('convert-number')->with('data', $data)->with('listCurrency', $listCurrency);
    }

    function convertCurrency($amount, $from_currency, $to_currency)
    {

        $from_Currency = urlencode($from_currency);
        $to_Currency = urlencode($to_currency);
        $query = "{$from_Currency}_{$to_Currency}";

        $json = file_get_contents("https://free.currencyconverterapi.com/api/v6/convert?q={$query}&compact=ultra");
        $obj = json_decode($json, true);

        $val = floatval($obj["$query"]);

        $total = $val * $amount;
        return number_format($total, 2, '.', '');

    }

    public function generateConvertCurrency(Re $request)
    {
        $from_currency = $request->all()['from_currency'];
        $amount = $request->all()['amount'];
        $to_currency = $request->all()['to_currency'];
        $paramConvert = $this->convertCurrency($amount, $from_currency, $to_currency);
        return json_encode($paramConvert);
    }
}