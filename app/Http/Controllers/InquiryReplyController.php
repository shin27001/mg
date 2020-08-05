<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\InquiryReply;

class InquiryReplyController extends Controller
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
        $validator = \Validator::make($request->all(), [
            'inquiry_id'    => 'required',
            'reply_comment' => 'required',
        ],[
            'inquiry_id.required'    => 'お問い合せIDが不明です。再度ログインして下さい。',
            'reply_comment.required' => 'お問い合せ内容を入力して下さい。',
        ]);
        //バリデーションルールにでエラーの場合 
        if ($validator->fails()) {
            return redirect('/mypage')->withInput()
                    ->withErrors($validator)
                    ->with([
                        'active_tab' => 'contact',
                        'active_collapse' => $request->input('inquiry_id')
                    ]);
        }
               
        $inquiry_reply = new InquiryReply; 
        $inquiry_reply->fill($request->all()); 
        $inquiry_reply->save();

        return redirect('/mypage')->with([
            'flash_inquiry_message' => 'お問い合せの登録が完了しました！',
            'active_tab' => 'contact',
            'active_collapse' => $request->input('inquiry_id')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }
}
