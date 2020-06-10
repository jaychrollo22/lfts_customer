<!DOCTYPE html>
<html>
<head>
    @include('layouts.header')
    <style>
        .img-container {
          text-align: center;
          display: block;
        }
    </style>
</head>
<body style="background: url('/img/bg.png');height: 100%; background-position: center;background-repeat: no-repeat;background-size: cover;">
    <div class="wrapper wrapper-full-page">
        <div class="login-page">
            <div class="content" style="padding-bottom: 150px;padding-top: 150px;">
                <div class="container">
                        <div class="col-md-10 text-center ml-auto mr-auto">
                            
                        </div>
                        <div class="col-lg-4 col-md-6 ml-auto">
                        <form class="form" method="POST" action="{{ route('login') }}">
                            <input type="hidden" name="_token" value="mnpGjp3P6yX0ahC8L8L6ghXVgiCQ3dnU4cghBpMy">
                            @csrf
                            <div class="card card-login bg-transparent">
                                <div class="card-body">
                                    <span class="img-container">
                                        <img src="{{ url('/img/lfuggoc_icon.png')}}" style="width:100px" alt="">
                                    </span>
                                    <h1 class="text-white text-center mt-5">LAFIL EXPRESS TRACKING</h1>
                                    <p class="text-white mb-2">Email</p>
                                    <div class="input-group bg-white" style="border-radius: 0.4285rem;">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text text-default">
                                                <i class="tim-icons icon-email-85"></i>
                                            </div>
                                        </div>
                                        <input type="email" name="email" class="form-control text-default" placeholder="Email">
                                    </div>
                                    @error('email')
                                        <p class="text-warning">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror
                                    <p class="text-white mb-2">Password</p>
                                    <div class="input-group mb-2 bg-white" style="border-radius: 0.4285rem;">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text text-default">
                                                <i class="tim-icons icon-lock-circle"></i>
                                            </div>
                                        </div>
                                        <input type="password" placeholder="Password" name="password" class="form-control text-default">  
                                    </div>
                                    @error('password')
                                        <p class="text-warning">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror

                                    <button type="submit" href="" class="btn btn-default btn-lg btn-block mb-3 mt-5">Sign In</button>
                                </div>
                                <div class="card-footer">
                                    <span class="img-container">
                                        <img src="{{ url('/img/lfuggoc.png')}}" style="width:400px" alt="">
                                    </span>
                                </div>
                            </div>
                        </form>
                        </div>
                </div>
            </div>
            
        @include('layouts.script')   
</body>

