<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function showArticle($id)
    {
        $redis = Redis::connection();

        $redis->set('first_name','Alex');
      //  $response = $redis->get('first_name');


        if($redis->zScore('articleViews','article:'.$id)){

            $redis->pipeline(function($pipe)use($id){
                $pipe->zIncrBy('articleViews',1,'article:'.$id);
                $pipe->incr('article:'.$id.':views');
            });

        }else{
            $view=$redis->incr('article:'.$id.':views');
            $redis->zIncrBy('articleViews',$view,'article:'.$id);
        }
        $view=$redis->get('article:'.$id.':views');

        return "This is an article with id ".$id." it has views ".$view." views";
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
