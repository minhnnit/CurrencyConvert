<?php namespace App\Http\Controllers;

use Illuminate\Http\Request as Re;
use NumberFormatter;


class ConvertNumberIndexController extends Controller
{
    public function index()
    {
        return view('convert-number');
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
        //        var_dump($splitNum);
        $inputNumCount = (count($splitNum));
        for ($i = 0; $i < $inputNumCount; $i++) {
            $countDigits = new NumberFormatter("en", NumberFormatter::SPELLOUT);
            $covertDigit = $countDigits->format($numberInput[$i]);
            array_push($numberArr, $covertDigit);
        }
        return join(', ', $numberArr);
    }

    public function generateConvert(Re $request)
    {
        $numberInput = $request->all()["numberInput"];
        $data = [];
        $data["convertNumber"] = $this->convertNumber($numberInput);
        $data["convertDigits"] = $this->convertDigits($numberInput);
        return json_encode($data);
    }

    public function inputNumberUrl($inputNumberUrl){
        $numberInput = $inputNumberUrl;
        $data = [];
        $data["convertNumber"] = $this->convertNumber($numberInput);
        $data["convertDigits"] = $this->convertDigits($numberInput);
        $data["numberInput"] = $numberInput;
        return view('convert-number')->with('data',$data);
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