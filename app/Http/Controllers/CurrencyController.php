<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   //public $path="/laravelvue/";
    public $path="";
    public function index()
    {
        $path=$this->path;
        $arrTabs=['General'];
        $active="active";

        return view('currency.index', compact('arrTabs', 'active','path'));
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

    public function convert(Request $request)
    {
        $input_currency=$request['input_currency'];
        $input_value=$request['input_value'];
    if(!empty($input_value)){
        $output_currency=$request['output_currency'];
        $response = \Unirest\Request::get("https://currencyconverter.p.mashape.com/?from=".$input_currency."&from_amount=".$input_value."&to=".$output_currency,
            array(
                "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C",
                "Accept" => "application/json"
            )
        );
        $result=$response->body->to_amount;
    }else{
       $result='false';
    }
     return ["result"=>$result];
    }



}
