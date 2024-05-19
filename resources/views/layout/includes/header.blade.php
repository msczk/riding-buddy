<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li class="nav-item "><a href="{{ route('home') }}" class="nav-link px-2 link-secondary">Home</a></li>
      </ul>

      <div class="col-md-3 text-end">
        @guest
          <a href="{{ route('auth.login') }}" class="btn btn-outline-primary me-2">Login</a>
          <a href="{{ route('auth.register') }}" class="btn btn-primary">Sign-up</a>
        @endguest
        @auth
          <form class="nav-item" action="{{ route('auth.logout') }}" method="POST">
            @method('delete')
            @csrf
            <button class="btn btn-danger">Se déconnecter</button>
          </form>
        @endauth
      </div>
    </header>
  </div>