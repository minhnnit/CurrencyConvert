<?php

namespace App\Http\Controllers;

use App\CurrencyKeyword;
use Illuminate\Http\Request as Re;
use DB;

class SitemapController extends Controller
{
    public function index()
    {
        $data = [];
        $keywordsLength = DB::table('currency_keyword')->count();
        $page = $keywordsLength / 1000;
        if($page<1)
            $page = 1;
        $data['page'] = (Int)$page;
        return view('sitemap-index')->with($data);
    }

    public function keywords($page) {
        $keywords = DB::table('currency_keyword')->offset($page * 1000)->limit(1000)->get();
        return response()->view('sitemap',[
            'keywords' => $keywords
        ])->header('Content-Type', 'text/xml');
    }

    public function insertToDB(Re $request) {
        $keywordInset = $request->all()['numberInput'];
        $checkKeywords = DB::table('currency_keyword')->where('keyword_text',$keywordInset)->get();
        if(count($checkKeywords)>0)
        {
            return ;
        }else
        {
            DB::table('currency_keyword')->insert([
                'keyword_text' => $keywordInset
            ]);
        }
    }
}