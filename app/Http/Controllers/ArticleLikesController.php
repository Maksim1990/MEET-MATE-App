<?php

namespace App\Http\Controllers;

use App\Article;
use App\ArticleLike;
use Illuminate\Http\Request;
use Auth;

class ArticleLikesController extends Controller
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
    public function like($id){
        $article=Article::findOrFail($id);
        $like= ArticleLike::create([
            'user_id'=>Auth::id(),
            'article_id'=>$article->id

        ]);
        return ArticleLike::find($like->id);
    }
    public function unlike($id){
        $article=Article::findOrFail($id);
        $like=ArticleLike::where('user_id',Auth::id())->where('article_id',$article->id)->first();
        $like->delete();
        return $like->id;
    }

}
