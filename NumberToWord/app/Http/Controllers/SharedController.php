<?php namespace App\Http\Controllers;

use Illuminate\Http\Request as RQ;
use Session;

class SharedController extends Controller
{
    public function store(RQ $request){
        if($request->ajax()){
            $data = $request->all();

            $userId = Session::has('user.id') ? Session::get('user.id') : '';
            $socialUserId = isset($data['uid']) ? $data['uid'] : '';
            $via = isset($data['via']) ? $data['via'] : '';
            $fkl = isset($data['fkl']) ? $data['fkl'] : '';
            $fkr = isset($data['fkr']) ? $data['fkr'] : '';
            $url = isset($data['url']) ? $data['url'] : '';
            $clickedBack = isset($data['clickedBack']) ? $data['clickedBack'] : 0;

            $sendData = [
                'userId' => $userId,
                'socialUserId' => $socialUserId,
                'via' => $via,
                'fkl' => $fkl,
                'fkr' => $fkr,
                'url' => $url,
                'clickedBack' => $clickedBack
            ];

            $query = config('config.api_url').'social_shared/?findType=findOne&where[fkr]='.$fkr.'&where[via]='.$via;
            if($userId)
                $query .= '&where[userId]='.$userId;
            if($socialUserId)
                $query .= '&where[socialUserId]='.$socialUserId;
            $find = $this->_submitHTTPGet($query, []);
            if(!$find){
                $result = $this->_submitHTTPPost(config('config.api_url') . 'social_shared/new', $sendData);
                return $result;
            }else{
                return 'existed';
            }
        }
    }
    public function update(RQ $request){
		echo '';exit;
        if($request->ajax()){
            $data = $request->all();
            $via = isset($data['via']) ? $data['via'] : '';
            $fkr = isset($data['fkr']) ? $data['fkr'] : '';
            $url = isset($data['url']) ? $data['url'] : '';

            $query = config('config.api_url').'social_shared/?findType=findOne&where[fkr]='.$fkr.'&where[via]='.$via;
            if(isset($data['uid'])){
                $query .= '&where[socialUserId]='.$data['uid'];
            }
            $find = $this->_submitHTTPGet($query, []);
            if($find){
                $find['clickedBack'] += 1;
                return $this->_submitHTTPPost(config('config.api_url').'social_shared/edit',
                ['id'=>$find['id'], 'clickedBack' => $find['clickedBack']]);
            }else{
                return 'link not exist';
            }
        }
    }
}
