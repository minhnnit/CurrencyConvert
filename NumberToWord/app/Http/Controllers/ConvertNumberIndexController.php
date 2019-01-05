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
            array_push($numberArr,$covertDigit);
        }
        return join(', ',$numberArr);
    }

    public function generateConvert(Re $request){
        $numberInput = $request->all()["numberInput"];
        $data = [];
        $data["convertNumber"] = $this->convertNumber($numberInput);
        $data["convertDigits"] = $this->convertDigits($numberInput);
        return json_encode($data);
    }



}