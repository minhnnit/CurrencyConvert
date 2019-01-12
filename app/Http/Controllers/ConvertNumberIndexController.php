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
        $data=[];
        $data["randomNumber"] = $this->randomNumber();
        return view('convert-number-index')->with('listCurrency', $listCurrency)->with('data',$data);
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
        return ($numberAddArr);
    }

    public function numberSub($numberInput)
    {
        $numberSubArr = [];
        for ($i = 0; $i < 5; $i++) {
            $numberSub = $numberInput -= 1;
            array_push($numberSubArr, $numberSub);
        }
        return ($numberSubArr);
    }


    public function randomNumber(){
        $randomArr = [];
        for($i = 1; $i < 20; $i ++ )
        {
            $randomNumber = rand();
            array_push($randomArr,$randomNumber);
        }
        return $randomArr;
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
        $data["numberAdd"] = $this->numberAdd($numberInput);
        $data["numberSub"] = $this->numberSub($numberInput);
        $data["randomNumber"] = $this->randomNumber();
        $data["convertNumber"] = $this->convertNumber($numberInput);
        $data["convertDigits"] = $this->convertDigits($numberInput);
        $data["numberInput"] = $numberInput;
        return view('convert-number-index')->with('data', $data)->with('listCurrency', $listCurrency);
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