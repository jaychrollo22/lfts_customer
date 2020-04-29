<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.header')
    </head>
    <body class="white-content">
        
        <div id="app">
            @auth
                <div class="wrapper">
                    <div class="main-panel" data="green">
                        @include('layouts.navbars.navbar')

                        <div class="content">
                            <div id="app">
                                @yield('content')
                            </div>
                        </div>
                        {{-- @include('layouts.footer') --}}
                    </div>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>  
            @endauth
        </div>        
        

        @include('layouts.script')

    </body>
</html>
