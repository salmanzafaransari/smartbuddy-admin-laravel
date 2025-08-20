<header class="header header-1">
   <div class="main-navigation">
    <nav id="navbar_top" class="navbar navbar-expand-lg">
     <div class="container g-0">
      <a class="navbar-brand" href="https://themekar.com/templatebucket/lenda/index.html">
       <img src="{{ asset('home/assets/img/logo/logo-white.png') }}" class="logo-display" alt="thumb">
       <img src="{{ asset('home/assets/img/logo/logo.png') }}" class="logo-scrolled" alt="thumb">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
       <span class="navbar-toggler-icon"><i class="ti-menu-alt"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="main_nav">
       <ul id="top-menu" class="navbar-nav ms-auto">
        <li class="nav-item">
         <a class="nav-link smooth-menu" href="/"> Home </a>
        </li>
        <li class="nav-item">
         <a class="nav-link smooth-menu" href="{{route('blogs')}}"> Blog </a>
        </li>
        <li class="nav-item">
         <a class="nav-link smooth-menu" href="/#contact"> Contact </a>
        </li>
        @guest
            <li class="nav-item">
                <a class="nav-link smooth-menu" href="{{ route('login') }}"> Login </a>
            </li>
            <li class="nav-item">
                <a class="nav-link smooth-menu" href="{{ route('signup') }}"> Sign Up </a>
            </li>
        @endguest

        {{-- If user is logged in --}}
        @auth
            <li class="nav-item">
                <a class="nav-link smooth-menu" href="{{ route('dashboard') }}"> <span class="btn btn-primary px-3" style="font-size:12px;"> <b>Go to Dashboard</b></span> </a>
            </li>
        @endauth
       </ul>
      </div> <!-- navbar-collapse.// -->
     </div> <!-- container -->
    </nav>
   </div>
  </header>