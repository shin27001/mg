<?php

namespace App\Http\Controllers;

use App\Favorite;
use Illuminate\Http\Request;
// use Auth;

use Illuminate\Support\Facades\Config;

class FavoriteController extends Controller
{

    public function auth()
    {
        \Debugbar::disable();
        // return "aaaaaaaaaaaaaa";
        // return json_encode(['auth' => \Auth::check()]);
        return response()->json(['auth' => \Auth::check()]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pref, $shop_id, $shop_slug)
    {   
        \Debugbar::disable();

        $favorite = Favorite::where('pref', $pref)->where('pref', $pref)->where('shop_id', $shop_id)->get();
        if($favorite->isEmpty()) {
            $user = \Auth::user();

            $favorite = new Favorite;
            $favorite->user_id = $user->id;
            $favorite->pref = htmlspecialchars($pref, ENT_QUOTES);
            $favorite->shop_id = htmlspecialchars($shop_id, ENT_QUOTES);
            $favorite->shop_slug = htmlspecialchars($shop_slug, ENT_QUOTES);
            $favorite->save();
        }
        return redirect(url()->previous());
        // return response()->json();
        // exit;
        // return true;
        // print_r($request->all());
        
        // $favorite = new Favorite;
        // $favorite->fill( $request->all() ); 
        // $favorite->save(); 
        // print_r($favorite);
        // $user = \Auth::user();
        // if(!$user) {
        //   return redirect('/mypage/'.$profile->user_id.'/edit');
        // }
        // echo "id -- ".$id;
        // exit;
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
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite $favorite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function edit(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {   
        $favorite->delete();
        return redirect(url()->previous());
    }
}
