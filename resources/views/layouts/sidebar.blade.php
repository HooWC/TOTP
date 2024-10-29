<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <link rel="stylesheet" href="{{asset('css/content/sidebar.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/content/home.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/content/account.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/content/admin.css')}}"/>
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<nav class="sidebar locked">
    <div class="logo_items flex">
          <span class="nav_image">
            <img src="{{asset('images/web/logo.png')}}" alt="logo_img"/>
          </span>
        <span class="logo_name">CodingTOTP</span>
        <i class="bx bx-lock-alt" id="lock-icon" title="Unlock Sidebar"></i>
        <i class="bx bx-x" id="sidebar-close"></i>
    </div>
    <div class="menu_container">
        <div class="menu_items">
            <ul class="menu_item">
                <div class="menu_title flex">
                    <span class="title">Dashboard</span>
                    <span class="line"></span>
                </div>
                <li class="item">
                    <a href="{{route('account.home')}}" class="link flex">
                        <i class="bx bx-home-alt"></i>
                        <span>Home</span>
                    </a>
                </li>


                @if(auth()->user()->roles->contains('name', 'admin'))
                    <li class="item">
                        <a href="{{route('admin.users')}}" class="link flex">
                            <i class="bx bx-grid-alt"></i>
                            <span>Users</span>
                        </a>
                    </li>
                @else
                    <li class="item">
                        <a href="{{route('account.totp')}}" class="link flex">
                            <i class="bx bx-grid-alt"></i>
                            <span>Account</span>
                        </a>
                    </li>
                @endif

            </ul>

            <ul class="menu_item">
                <div class="menu_title flex">
                    <span class="title">Logout</span>
                    <span class="line"></span>
                </div>
                <li class="item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault();
                                        this.closest('form').submit();"
                                               style="text-decoration: none;">
                            <div class="link flex">
                                <i class="bx bx-cog"></i>
                                <span>Logout</span>
                            </div>
                        </x-responsive-nav-link>
                    </form>
                </li>
            </ul>
        </div>
        <div class="sidebar_profile">
            <div class="data_text">
                <p class="id" style="display:none" id="user_id_disabled">{{auth()->user()->id}}</p>
                <p class="name">{{auth()->user()->name}}</p>
                <p class="email">{{auth()->user()->email}}</p>
            </div>
        </div>
    </div>
</nav>

<nav class="navbar">
    @yield('content')
</nav>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{asset('js/content/sidebar.js')}}"></script>
@yield('scripts')
</body>
</html>
