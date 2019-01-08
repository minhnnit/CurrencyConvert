<?php namespace App\Http\Controllers;

use Illuminate\Http\Request as Re;
use NumberFormatter;


class ConvertNumberIndexController extends Controller
{
    public function index()
    {
        $listCurrency = [
            "USD" => "UnitedStatesDollars",
            "EUR" => "EURO",
            "VND" => "VietnamDong",
            "GBP" => "UnitedKingdomPounds"

        ];
        return view('convert-number')->with('listCurrency',$listCurrency);
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

    public function evenNumber($numberInput){
        $splitNum = str_split($numberInput);
        $evenNumberArr = [];
        $inputNumCount = count($splitNum);
        for ($i = 0; $i < $inputNumCount; $i++){
            if($numberInput[$i]%2 ==0) {
                array_push($evenNumberArr,$numberInput[$i]);
//                $evenNumberArrUnique = array_unique($evenNumberArr);
            }
        }
        return join(', ',$evenNumberArr);
    }

    public function oddNumber($numberInput)
    {
        $splitNum = str_split($numberInput);
        $oddNumberArr = [];
        $inputNumCount = count($splitNum);
        for($i = 0; $i < $inputNumCount; $i++){
            if($numberInput[$i]%2 != 0) {
                array_push($oddNumberArr,$numberInput[$i]);
//                $oddNumberArrUnique =  array_unique($oddNumberArr);
            }
        }
        return join(', ',$oddNumberArr);
    }

    public function squareRoot($numberInput){

    }

    public function inputNumberUrl($numberInput){
        $listCurrency = [
            "USD" => "UnitedStatesDollars",
            "EUR" => "EURO",
            "VND" => "VietnamDong",
            "GBP" => "UnitedKingdomPounds"
        ];
        $splitNum = str_split($numberInput);

        $maxValue = max($splitNum);
        $minValue = min($splitNum);
        $arraySum = array_sum($splitNum);
        $data = [];
        $data["evenNumber"] = $this->evenNumber($numberInput);
        $data["oddNumber"] = $this->oddNumber($numberInput);
        $data["squareRoot"] = $this->squareRoot($numberInput);
        $data["maxNumber"] = $maxValue;
        $data["minNumber"] = $minValue;
        $data["arraySum"] = $arraySum;
        $data["convertNumber"] = $this->convertNumber($numberInput);
        $data["convertDigits"] = $this->convertDigits($numberInput);
        $data["numberInput"] = $numberInput;
        return view('convert-number')->with('data',$data)->with('listCurrency',$listCurrency);
    }

    function convertCurrency($amount,$from_currency,$to_currency){

        $from_Currency = urlencode($from_currency);
        $to_Currency = urlencode($to_currency);
        $query =  "{$from_Currency}_{$to_Currency}";

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
        $paramConvert = $this->convertCurrency($amount,$from_currency,$to_currency);
        return json_encode($paramConvert);
    }
}