
{{-- layoutsフォルダのapplication.blade.phpを継承 --}}
@extends('layouts.app')

{{-- @yield('title')にテンプレートごとの値を代入 --}}
@section('title', '新規作成')

{{-- application.blade.phpの@yield('content')に以下のレイアウトを代入 --}}
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(count($errors) > 0)
              <div class="alert alert-warning border text-secondary mt-3 mb-3 p-3" style="">
                <p><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>お知らせ</p>
                <p>未入力の項目があります！</p>
              </div>
            @endif

            <div class="form-group">
              <label for="name">お名前</label>
              <input type="text" class="form-control" id="name" value="{{$user->name}}" disabled="disabled">
            </div>
            <div class="form-group">
              <label for="mail">メールアドレス</label>
              <input type="text" class="form-control" id="mail" value="{{$user->email}}" disabled="disabled">
            </div>

            <form action="/mypage" method="post">
              {{ csrf_field() }}
              <input type="hidden" name="user_id" value="{{$user->id}}">
              <div class="form-group">
                <label for="nickname">ニックネーム</label>&nbsp;<span class="badge badge-danger">必須</span>
                <input type="text" name="nickname" class="form-control" id="nickname" value="{{old('nickname')}}" aria-describedby="nicknameHelp" placeholder="ニックネームを入力して下さい">
                <small id="nicknameHelp" class="form-text text-muted">本サービスでは、名前の代わりにニックネームが表示されます。</small>
                @if($errors->has('nickname')) <div class="p-1 m-1 bg-info text-white">{{$errors->first('nickname')}}</div> @endif
              </div>
              <div class="form-group">
                <label for="zip_code">郵便番号</label>&nbsp;<span class="badge badge-danger">必須</span>
                <input type="text" name="zip_code" class="form-control" id="zip_code" value="{{old('zip_code')}}" style="width:200px;" placeholder="(例)103-0001">
                @if($errors->has('zip_code')) <div class="p-1 m-1 bg-info text-white">{{$errors->first('zip_code')}}</div> @endif
              </div>
              <div class="form-group">
                <label for="address">ご住所</label>&nbsp;<span class="badge badge-danger">必須</span>
                <input type="text" name="address" class="form-control" id="address" value="{{old('address')}}" placeholder="(例)東京都港区新橋1-2-3">
                @if($errors->has('address')) <div class="p-1 m-1 bg-info text-white">{{$errors->first('address')}}</div> @endif
              </div>
              <div class="form-group">
                <label for="tel_no">電話番号</label>&nbsp;<span class="badge badge-danger">必須</span>
                <input type="text" name="tel_no" class="form-control" id="tel_no" value="{{old('tel_no')}}" placeholder="(例)03-1234-5678">
                @if($errors->has('tel_no')) <div class="p-1 m-1 bg-info text-white">{{$errors->first('tel_no')}}</div> @endif
              </div>

              <div class="form-group">
                <label for="">生年月日</label>
                <input type="date" name="birthday" class="form-control" id="birthday" value="{{old('birthday')}}" max="{{date('Y-m-d')}}" style="width:200px;">
              </div>

              <div class="form-group">
                <label for="gender">性別</label>
                <select id="gender" name="gender" class="custom-select" style="width:150px;">
                  <option selected>選択して下さい</option>
                  <option value="1" @if(old('gender')=="1") selected @endif>男性</option>
                  <option value="2" @if(old('gender')=="2") selected @endif>女性</option>
                </select>
              </div>

              <div class="form-group">
                <label for="self_introduce">自己紹介</label>
                <textarea name="self_introduce" class="form-control" id="self_introduce" rows="8">{{old('self_introduce')}}</textarea>
              </div>

              <button type="submit" class="btn btn-primary">登　録</button>
            </form>
        </div>
    </div>
</div>
@endsection