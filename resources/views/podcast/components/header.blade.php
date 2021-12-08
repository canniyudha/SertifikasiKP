<div class="site-mobile-menu">
  <div class="site-mobile-menu-header">
    <div class="site-mobile-menu-close mt-3">
      <span class="icon-close2 js-menu-toggle"></span>
    </div>
  </div>
  <div class="site-mobile-menu-body"></div>
</div>

<header class="site-navbar py-4" role="banner">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-3">
        <h1 class="site-logo"><a href="/" class="h2">Facenote<span class="text-primary">.</span> </a></h1>
      </div>
      <div class="col-9">
        <nav class="site-navigation position-relative text-right text-md-right" role="navigation">
          <div class="d-block d-lg-none ml-md-0 mr-auto"><a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>
          <ul class="site-menu js-clone-nav d-none d-lg-block">
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
              <li>
                <a href="/post">Home</a>
              </li>
              <li><a href="/profile/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a></li>
              <li>
                <a class="text-danger" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </li>
            @endguest
          </ul>
        </nav>
      </div>
    </div>
  </div>
</header>
<hr class="m-0">