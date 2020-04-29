<nav class="navbar navbar-expand-lg navbar-absolute bg-white">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <a class="navbar-brand" href="#"><img src="{{ asset('/img/logo.png') }}" alt="{{ __('Profile Photo') }}" width="50%"></a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse bg-white" id="navigation">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"> <a href="{{ route('home') }}" class="nav-link"> <i class="fa fa-fw fa-user"></i>  {{ auth()->user()->name }}</a></li>
                <li class="nav-item"> <a href="{{ route('change_password') }}" class="nav-link"> <i class="fa fa-fw fa-cogs"></i>  {{ __('Change Password') }}</a></li>
                <li class="nav-item"> <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();  document.getElementById('logout-form').submit();"><i class="fa fa-fw fa-sign-out-alt"></i> {{ __('Log out') }}</a></li>
                
            </ul>
        </div>
    </div>
</nav>
<div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="{{ __('SEARCH') }}">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('Close') }}">
                    <i class="tim-icons icon-simple-remove"></i>
              </button>
            </div>
        </div>
    </div>
</div>
