<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.header')
    </head>
    <body class="white-content">

        <div id="app">
            @auth
                <div class="wrapper">
                    @include('layouts.navbars.sidebar')
                   <div class="main-panel" data="primary">
                        @include('layouts.navbars.navbar')

                        <div class="content">
                            <div id="app">
                                @yield('content')
                            </div>
                        </div>
                     
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
