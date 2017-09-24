<?php

namespace App\Http\Controllers;

use App\Category;
use App\CommunityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrTabs=['General'];
        $active="active";
        $categories=Category::all();
        $types=CommunityType::pluck('name','id')->all();
        return view('admin.categories.index', compact('categories','arrTabs', 'active','types'));
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

        $input=$request->all();
        Category::create($input);
        Session::flash('category_change','The category has been successfully created!');
        return redirect('categories');
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
        $category=Category::findOrFail($id);
        $arrTabs=['General'];
        $active="active";
        return view('admin.categories.edit',compact('arrTabs', 'active','category'));
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
        $category=Category::findOrFail($id);
        $input=$request->all();
        $category->update($input);
        Session::flash('category_change','The category has been successfully edited!');
        return redirect('categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        Session::flash('category_change','The category has been successfully deleted!');
        return redirect('/categories');
    }

    public function categoryList(Request $request)
    {
        $typeId=$request['type'];
        $categories=Category::where('type_id',$typeId)->get();
        return ["categories"=>$categories];
    }
    
    
}
