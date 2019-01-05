<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller{

    public function index(Request $request, $alias){
        if($alias !== strtolower($alias)){
            $alias = $this->_redirect($alias, '/event/', $request->all());
            return redirect($alias);
        }
        $data = $this->_submitHTTPGet(config('config.api_url') . 'events/eventDetail/' . $alias, [
            // 'c_limit' => 16,
            'c_limit' => 36,
            // 'c_offset' => 1,
            'c_location' => config('config.location')
        ]);
        // $data['categories'] = [['id'=>123]];
        // echo json_encode($data);die;
        if($data){
            $data['seoConfig']['title'] = $data['event']['seoTitle'];
            $data['seoConfig']['desc']  = $data['event']['seoDes'];
            return view('eventDetail')->with($data);
        }else{
            return response(view('errors.404'), 404);
        }
    }

    public function showMore(Request $request){
        if ($request->ajax()) {
            $params = $request->all();
            $limit = $params['limit'];
            $alias = $params['alias'];
            $category_id = '';
            if(isset($params['categoryId'])){
                $category_id = $params['categoryId'];
            }
            $countItem = -1;
            if(isset($params['countItem'])){
                $countItem = $params['countItem'];
            }

            $data = [];
            $cond = [
                'c_offset' => 0,
                'c_limit' => $limit,
                'c_location' => config('config.location')
            ];
            if($category_id){
                $cond['categoryId'] = $category_id;
            }

            $data['deals'] = $this->_submitHTTPGet(config('config.api_url')."events/eventDetail/$alias/showMore/", $cond);

            if (empty($data['deals']) || count($data['deals']) <= $countItem){
                return response()->json(['status' => 'error', 'deals' => []]);
            }else{
                return view('elements.deals-list', $data);
            }

        }else{
            return response()->json(['status' => 'error', 'deals' => []]);
        }
    }

}