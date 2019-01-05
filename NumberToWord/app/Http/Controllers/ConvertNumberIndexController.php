<?php namespace App\Http\Controllers;

use Illuminate\Http\Request as Re;
use NumberFormatter;




class ConvertNumberIndexController extends Controller
{
    public function index()
    {
        return view('convert-number');
    }

    public function convertNumber(Re $request)
    {
        $numberInput = $request->all()["numberInput"];
        $numberConvert = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return $numberConvert->format($numberInput);
    }

    public function convertDigits(Re $request)
    {
        $numberInput = $request->all()["numberInput"];
        $splitNum = str_split($numberInput);
        //        var_dump($splitNum);
        $inputNumCount = (count($splitNum));
        for ($i = 0; $i < $inputNumCount; $i++) {
            $countDigits = new NumberFormatter("en", NumberFormatter::SPELLOUT);
            echo $countDigits->format($numberInput[$i]) . " ";
        }
    }

    public function generateConvert(){

    }



}