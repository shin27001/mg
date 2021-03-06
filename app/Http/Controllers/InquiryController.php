<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Inquiry;

class InquiryController extends Controller
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
        // dd($request);
        $validator = \Validator::make($request->all(), [
            'user_id' => 'required',
            'title'   => 'required',
            'comment' => 'required',
        ],[
            'user_id.required' => 'ユーザIDが不明です。新規登録を行って下さい。',
            'title.required'   => 'タイトルを入力して下さい。',
            'comment.required' => 'お問い合せ内容を入力して下さい。',
        ]);
        //バリデーションルールにでエラーの場合 
        if ($validator->fails()) {
            return redirect('/mypage')->withInput()->withErrors($validator)->with(['active_tab' => 'contact']);
        }
               
        $inquiry = new Inquiry; 
        $inquiry->fill($request->all()); 
        $inquiry->save();

        return redirect('/mypage')->with([
            'flash_inquiry_message' => 'お問い合せの登録が完了しました！',
            'active_tab' => 'contact'
        ]);
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
