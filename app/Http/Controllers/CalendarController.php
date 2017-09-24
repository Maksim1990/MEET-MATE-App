<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Calendar;

use App\EventModel;
class CalendarController extends Controller
{   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = [];

        $data = EventModel::all();

        if($data->count()){

            foreach ($data as $key => $value) {

                $events[] = Calendar::event(

                    $value->title,

                    true,

                    new \DateTime($value->start_date),

                    new \DateTime($value->end_date.' +1 day')

                );

            }

        }

        $calendar = Calendar::addEvents($events);
        $arrTabs=['General','Settings'];
        $active="active";
        return view('calendar.index',compact('arrTabs', 'active','calendar'));

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



}
