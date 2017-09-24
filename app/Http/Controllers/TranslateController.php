<?php

namespace App\Http\Controllers;

use App\Translate;
use Auth;
use Illuminate\Http\Request;

class TranslateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $path="/laravelvue/";
   // public $path="";
    public function index()
    {
        $path=$this->path;
        $arrTabs=['General','Settings'];
        $active="active";
        $translates=Translate::where('user_id',Auth::id())->orderBy('id','desc')->get();
        return view('translate.index', compact('arrTabs', 'active','path','translates'));
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
        return $request->all();
//        $translator = new \Dedicated\GoogleTranslate\Translator;
//
//
//        $result = $translator->setSourceLang('en')
//            ->setTargetLang('fr')
//            ->translate('Hello World');
//
//        $path=$this->path;
//        $arrTabs=['General','Settings'];
//        $active="active";
//        return redirect('categories');
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
    public function translate(Request $request)
    {
        $input_word=$request['input_word'];
        $output_lang=$request['output_lang'];
        $input_lang=$request['input_lang'];
        $translator = new \Dedicated\GoogleTranslate\Translator;

        $result = $translator->setSourceLang($input_lang)
            ->setTargetLang($output_lang)
            ->translate($input_word);
        $translates=Translate::where('user_id',Auth::id())->orderBy('id')->get();
        if(count($translates)>=5){
            Translate::where('user_id',Auth::id())->orderBy('id')->first()->delete();
        }
        Translate::create(['user_id'=>Auth::id(),'input_lang'=>$input_lang,'output_lang'=>$output_lang,'input_word'=>$input_word,'output_word'=>$result]);
        return ["result"=>$result];
    }
}
