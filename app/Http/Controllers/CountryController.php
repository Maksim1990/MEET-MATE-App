<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CountryController extends Controller
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
        $title='Country module';
        return view('country.index', compact('arrTabs', 'active','path','title'));
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
    public function getByName(Request $request)
    {
        $country_name=$request['item_name'];
        $country_name=strtolower($country_name);
        $response = \Unirest\Request::get("https://restcountries-v1.p.mashape.com/name/".$country_name,
            array(
                "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C",
                "Accept" => "application/json"
            )
        );
        return ["result"=>$response->body];
    }

    public function getByCapital(Request $request)
    {
        $country_capital=$request['item_name'];
        $country_capital=strtolower($country_capital);
        $response = \Unirest\Request::get("https://restcountries-v1.p.mashape.com/capital/".$country_capital,
            array(
                "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C",
                "Accept" => "application/json"
            )
        );
        return ["result"=>$response->body];
    }

    public function getByCurrency(Request $request)
    {
        $country_currency=$request['item_name'];
        $country_currency=strtoupper($country_currency);
        $response = \Unirest\Request::get("https://restcountries-v1.p.mashape.com/currency/".$country_currency,
            array(
                "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C",
                "Accept" => "application/json"
            )
        );
        return ["result"=>$response->body];
    }

    public function getByCode(Request $request)
    {
        $country_code=$request['item_name'];
        $country_code=strtoupper($country_code);
        $response = \Unirest\Request::get("https://restcountries-v1.p.mashape.com/alpha/?codes=".$country_code,
            array(
                "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C",
                "Accept" => "application/json"
            )
        );
        return ["result"=>$response->body];
    }

}
