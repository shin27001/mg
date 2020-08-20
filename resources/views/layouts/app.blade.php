<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
  <title>@yield('title')</title>
  <link href="{{ asset('css/style.css') }}" media="all" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" href="<?php echo env('WP_URL'); ?>/<?php echo session('pref'); ?>/wp-content/themes/ryukyu-leaf/images/favicon.ico" />
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <script src="https://kit.fontawesome.com/cd70ed3316.js" crossorigin="anonymous"></script>
  <script src="{{ asset('js/app.js') }}" defer></script>
  @yield('css')
</head>

<body>
  <div class="l-wrap">
    <header id="top-header" class="l-header">
      <div class="l-header__inner">
        <div class="mobile__menu">
          <p class="l-header__logo"> <a href="<?php echo env('WP_URL'); ?>/<?php echo session('pref'); ?>" class="header__logoLink">
              アフターコロナ応援グルメサイト<br><img src="<?php echo env('WP_URL'); ?>/<?php echo session('pref'); ?>/wp-content/themes/ryukyu-leaf/images/logo.svg?<?php echo date('Ymd-His'); ?>" alt="ごはん旅">
            </a></p>
          <div class="mobile__toggle">
            <div>
              <span></span>
              <span></span>
              <span></span>
            </div>
          </div>
        </div>
        <nav class="l-header__nav">
          <ul class="l-header__nav-list">
            <li class="l-header__nav-item"><a href="<?php echo env('WP_URL'); ?>/<?php echo session('pref'); ?>/feature"><i class="fas fa-star"></i> GO!HAN旅の特徴</a></a></li>
            <li class="l-header__nav-item"><a href="<?php echo env('WP_URL'); ?>/<?php echo session('pref'); ?>/shops"><i class="fas fa-list-ul"></i> 飲食店一覧</a></li>
            <li class="l-header__nav-item"><a href="<?php echo env('WP_URL'); ?>/<?php echo session('pref'); ?>/entry"><i class="fas fa-edit"></i> 飲食店の皆様へ</a></li>
            <li class="l-header__nav-item"><a href="<?php echo env('WP_URL'); ?>/<?php echo session('pref'); ?>/contact"><i class="far fa-envelope"></i> お問い合わせ</a></li>
            <li class="l-header__nav-item"><?php echo (session('pref') == 'okinawa') ? '<a href="'.env('WP_URL').'/kyoto"><i class="fas fa-external-link-alt"></i> 京都版</a></li>' : '<a href="'.env('WP_URL').'/okinawa"><i class="fas fa-external-link-alt"></i> 沖縄版</a></li>'; ?></li>

            <!-- <li class="l-header__nav-item">
              <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  ログアウト
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </li> -->

          </ul>
        </nav>
        <nav class="navbar navbar-expand-md navbar-light bg-white">
            <div class="container">
                <!-- <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button> -->

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @if (!empty(Auth::user()->profile->nickname)) {{ Auth::user()->profile->nickname }} @else {{ Auth::user()->name }} @endif <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <!-- <a class="dropdown-item" href="{{ route('logout') }}">
                                    <i class="fas fa-star"></i> GO!HAN旅の特徴
                                    </a> -->

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        ログアウト
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

      </div>
    </header>

    <main class="main-container main-mt mb-3">
      @yield('content')
    </main>
      <footer class="l-footer">
        <p class="pagetop"><a href="#top-header">▲</a></p>
        <nav class="l-footer__nav">
          <ul class="l-footer__nav-list">
            <li class="l-footer__nav-item"><a href="<?php echo env('WP_URL'); ?>/<?php echo session('pref'); ?>/admin">運営者情報</a></a></li>
            <li class="l-footer__nav-item"><a href="<?php echo env('WP_URL'); ?>/<?php echo session('pref'); ?>/privacy-policy">プライバシーポリシー</a></a></li>
            <li class="l-footer__nav-item"><a href="<?php echo env('WP_URL'); ?>/<?php echo session('pref'); ?>/contact">お問い合わせ</a></a></li>
          </ul>
        </nav>
        <div class="l-footer__bottom">
          <p class="copyright">&copy;2020 Leaf Publications</p>
        </div>
      </footer>
      </div>

      <!-- Java script-->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="<?php echo env('WP_URL'); ?>/<?php echo session('pref'); ?>/wp-content/themes/ryukyu-leaf/scripts/vendors/slick.js"></script>
      <script src="<?php echo env('WP_URL'); ?>/<?php echo session('pref'); ?>/wp-content/themes/ryukyu-leaf/scripts/main.js?<?php echo date('Ymd-Hi'); ?>"></script>
      <!-- <script src="<?php echo env('WP_URL'); ?>/<?php echo session('pref'); ?>/wp-content/themes/ryukyu-leaf/scripts/libs/main-slider.js"></script> -->
  </div>
  @yield('js')
</body>

</html>