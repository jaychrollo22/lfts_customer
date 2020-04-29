
<!DOCTYPE html>
<html>
<head>
    @include('layouts.header')
</head>
<body style="background: linear-gradient(rgba(255,255,255, 0.1), rgba(255,255,255, 0.1)), url('/img/bg.jpg');background-repeat: no-repeat;background-size: auto;">
    <div class="wrapper wrapper-full-page">
        <div class="login-page">
            <div class="content" style="padding-bottom: 150px;padding-top: 150px;">
                <div class="container">
                        <div class="col-md-10 text-center ml-auto mr-auto">
                            
                        </div>
                        <div class="col-lg-4 col-md-6 ml-auto mr-auto">
                        <form class="form" method="POST" action="{{ route('login') }}">
                            <input type="hidden" name="_token" value="mnpGjp3P6yX0ahC8L8L6ghXVgiCQ3dnU4cghBpMy">
                            @csrf
                            <div class="card card-login card-white">
                                <div class="card-header">
                                    <img src="https://white-dashboard-laravel.creative-tim.com/white/img/card-primary.png" alt="">
                                    <h1 class="card-title">Sign in</h1>
                                </div>
                                <div class="card-body">
                                    <h4 class="text-default text-center">Welcome to LAFIL Tracking System</h4>
                                    <p class="text-dark mb-2">Username</p>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tim-icons icon-email-85"></i>
                                            </div>
                                        </div>
                                        <input type="email" name="email" class="form-control" placeholder="Email">
                                    </div>
                                    @error('email')
                                        <p class="text-warning">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror
                                    <p class="text-dark mb-2">Password</p>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tim-icons icon-lock-circle"></i>
                                            </div>
                                        </div>
                                        <input type="password" placeholder="Password" name="password" class="form-control">  
                                    </div>
                                    @error('password')
                                        <p class="text-warning">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror
                                </div>
                                <div class="card-footer">
                                    <button type="submit" href="" class="btn btn-primary btn-lg btn-block mb-3">Get Started</button>
                                </div>
                            </div>
                        </form>
                        </div>
                </div>
            </div>
            
        @include('layouts.script')   
</body>

