{{-- layoutsフォルダのapplication.blade.phpを継承 --}}
@extends('layouts.app')

{{-- @yield('title')にテンプレートごとの値を代入 --}}
@section('title', 'マイページ')

{{-- application.blade.phpの@yield('content')に以下のレイアウトを代入 --}}

@section('css')
<style>
.main_img {
  width: 150px;
  height: 100px;
  object-fit: cover; /* この一行を追加するだけ！ */
}
</style>
@endsection

@section('js')
<script> 
function check(shop_name){
	if(window.confirm('「'+shop_name+'」を削除します。\n\nよろしいですか？')){ // 確認ダイアログを表示
		return true; // 「OK」時は送信を実行
	}
	else{ // 「キャンセル」時の処理
		return false; // 送信を中止
	}
}
function account_delete_check(){
	if(window.confirm('アカウントを削除します。\n\nよろしいですか？')){ // 確認ダイアログを表示
		return true; // 「OK」時は送信を実行
	}
	else{ // 「キャンセル」時の処理
		return false; // 送信を中止
	}
}
</script>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-9">
        <!-- 4個分のタブ -->
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a href="#profile" class="nav-link active" data-toggle="tab">プロフィール</a>
          </li>
          <li class="nav-item">
            <a href="#favorite" class="nav-link" data-toggle="tab">お気に入り</a>
          </li>
          <li class="nav-item">
            <a href="#contact" class="nav-link" data-toggle="tab">お問い合わせ</a>
          </li>
        </ul>

        <div class="tab-content">
          <div id="profile" class="tab-pane active">
            @if (session('flash_message'))
              <div class="alert alert-success border mt-3 mb-3 p-3">
                <p><i class="fas fa-info-circle"></i>お知らせ</p>
                <p>{{ session('flash_message') }}</p>
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

            <form action="{{ url('mypage/'.$user->profile->id) }}" method="post">
              @csrf
              @method('PUT')
              <!-- <input type="hidden" name="user_id" value="{{$user->id}}"> -->
              <div class="form-group">
                <label for="nickname">ニックネーム</label>
                <input type="text" name="nickname" class="form-control" id="nickname" value="{{$user->profile->nickname}}" aria-describedby="nicknameHelp" placeholder="ニックネームを入力して下さい">
                <small id="nicknameHelp" class="form-text text-muted">本サービスでは、名前の代わりにニックネームが表示されます。</small>
              </div>
              <div class="form-group">
                <label for="zip_code">郵便番号</label>
                <input type="text" name="zip_code" class="form-control" id="zip_code" value="{{$user->profile->zip_code}}" style="width:200px;" placeholder="103-0001">
              </div>
              <div class="form-group">
                <label for="address">ご住所</label>
                <input type="text" name="address" class="form-control" id="address" value="{{$user->profile->address}}" placeholder="東京都港区新橋1-2-3">
              </div>
              <div class="form-group">
                <label for="tel_no">電話番号</label>
                <input type="text" name="tel_no" class="form-control" id="tel_no" value="{{$user->profile->tel_no}}" placeholder="03-1234-5678">
              </div>

              <div class="form-group">
                <label for="">生年月日</label>
                <input type="text" name="birthday" class="form-control" id="birthday" value="{{$user->profile->birthday}}" placeholder="1990/08/01">
              </div>

              <div class="form-group">
                <label for="gender">性別</label>
                <select id="gender" name="gender" class="custom-select" style="width:150px;">
                  <option>選択して下さい</option>
                  <option value="1" {{ ($user->profile->gender == 1) ? 'selected' : '' }}>男性</option>
                  <option value="2" {{ ($user->profile->gender == 2) ? 'selected' : '' }}>女性</option>
                </select>
              </div>

              <div class="form-group">
                <label for="self_introduce">自己紹介</label>
                <textarea name="self_introduce" class="form-control" id="self_introduce" rows="8">{{$user->profile->self_introduce}}</textarea>
              </div>
              <div class="text-right">
                <button type="submit" class="btn btn-primary">更　新</button>
              </div>
            </form>
            <!-- <form id="" action="{{ route('logout') }}" class="mt-5" method="POST"> -->
            <div class="mt-5">
            <form style="display:inline" action="{{ url('mypage/'.$user->id) }}" method="POST" onSubmit="return account_delete_check();">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger">アカウント削除</button>
            </form>
            </div>
          </div>
          <div id="favorite" class="tab-pane fade">
            @if (!empty( $posts ))
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">画像</th>
                  <th scope="col">店舗名</th>
                  <th scope="col">住所</th>
                  <th scope="col">TEL</th>
                  <th scope="col">操作</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($posts as $post)
                  <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td><a href="{{env('WP_URL').'/'.$post->favorite->pref.'/shops/?p='.$post->favorite->shop_id}}" target="_blank"><img src="{{$post->shop_main_image->guid}}" class="main_img"></a></td>
                    <td><a href="{{env('WP_URL').'/'.$post->favorite->pref.'/shops/?p='.$post->favorite->shop_id}}" target="_blank">{{$post->post_title}}</a></td>
                    <td>{{$post->address->meta_value}}</td>
                    <td>{{$post->tel_no->meta_value}}</td>
                    <td>
                      <form style="display:inline" action="{{ url('favorite/'.$post->favorite->id) }}" method="post" onSubmit="return check('{{$post->post_title}}');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">
                              {{ __('Delete') }}
                          </button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            @else
              <div class="col-md-8 mt-5 mx-auto">
                お気に入りが登録されていません
              </div>
            @endif
          </div>
          <div id="contact" class="tab-pane fade">
            <div class="alert alert-warning border text-secondary mt-3 mb-3 p-3" style="">
              <p><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>お知らせ</p>
              <p>お問い合わせ内容によりましては、ご返信までお時間をいただく場合がございますので、予めご了承ください。</p>
            </div>
            <form action="{{ url('inquiry/'.$user->profile->id) }}" method="post">
              <div class="form-group">
                <label for="title">タイトル</label>
                <input type="email" class="form-control" id="title" placeholder="">
              </div>
              <div class="form-group">
                <label for="comment">お問い合わせ内容</label>
                <textarea class="form-control" id="comment" rows="8"></textarea>
              </div>
              <div class="text-right">
                <button type="submit" class="btn btn-primary">送　信</button>
              </div>
            </form>
            <!-- <div class="divider"></div> -->
            <hr>
            <div class="accordion mt-5" id="inquiries">
              @foreach ($user->inquiries as $inquiry)
                <div class="card">
                  <div class="card-header" id="title-{{$inquiry->id}}">
                    <h5 class="mb-0">
                      <span class="badge badge-primary">New</span>
                      <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#comment-{{$inquiry->id}}" aria-expanded="false" aria-controls="comment-{{$inquiry->id}}">
                        {{$inquiry->title}}
                      </button>
                    </h5>
                  </div>

                  <div id="comment-{{$inquiry->id}}" class="collapse show" aria-labelledby="title-{{$inquiry->id}}" data-parent="#inquiries">
                    <div class="card-body">
                      {{$inquiry->comment}}
                      <div class="mt-3">
                      @foreach ($inquiry->replies as $reply)
                        <div class="alert alert-info border mb-2">
                          {{$reply->comment}}
                        </div>
                      @endforeach
                      </div>
                    </div>
                  </div>
                  <!-- <hr> -->
                  <!-- <div id="comment-{{$inquiry->id}}" class="collapse show" aria-labelledby="title-{{$inquiry->id}}" data-parent="#inquiries">
                    <div class="card-body">
                      {{$inquiry->comment}}
                    </div>
                  </div> -->
                </div>
              @endforeach
              <!-- <div class="card">
                <div class="card-header" id="headingTwo">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      Collapsible Group Item #2
                    </button>
                  </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                  <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header" id="headingThree">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      Collapsible Group Item #3
                    </button>
                  </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                  <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                  </div>
                </div>
              </div> -->
            </div><!-- //#inquiries -->

          </div>
        </div>
      </div>
    </div>
</div>
@endsection