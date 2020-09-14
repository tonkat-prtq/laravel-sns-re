<nav class="navbar navbar-expand navbar-dark blue-gradient">

  <a class="navbar-brand" href="/"><i class="far fa-sticky-note mr-1"></i>memo</a>

  <ul class="navbar-nav ml-auto">

    {{-- bladeの認証ディレクティブという機能で、@guestから@endguestで囲まれている部分は未ログイン時のみ表示される --}}
    {{-- また、@authから@endauthで囲まれている部分はログイン時のみ表示される --}}
    @guest
      <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}">ユーザー登録</a>
      </li>
    @endguest

    @guest
      <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">ログイン</a>
      </li>
    @endguest

    @auth
      <li class="nav-item">
        <a class="nav-link" href="{{ route('articles.create') }}"><i class="fas fa-pen mr-1"></i>投稿する</a>
      </li>
    @endauth

    @auth
      <!-- Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
          <button class="dropdown-item" type="button"
                  onclick="location.href=''">
            マイページ
          </button>
          <div class="dropdown-divider"></div>
          <button form="logout-button" class="dropdown-item" type="submit">
            ログアウト
          </button>
        </div>
      </li>
      <form id="logout-button" method="POST" action="{{ route('logout') }}">
        @csrf
      </form>
      <!-- Dropdown -->
    @endauth

  </ul>

</nav>
