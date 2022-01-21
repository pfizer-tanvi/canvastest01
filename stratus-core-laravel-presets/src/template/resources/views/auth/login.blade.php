@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="alert alert-info">
                This Application is best experienced in <strong>Google Chrome</strong> or <strong>Microsoft Edge</strong>. <a href="http://btod.pfizer.com/solution/150223104804940">Click to install Chrome on your Pfizer Windows PC.</a>
            </div>
            <div class="col-6">
                @include('layouts._messages')
                <div class="card mb-4 login-card">
                    <div class="card-header">Disclaimer</div>
                    <div class="card-body">
                        <div class="clearfix text-center login-container">
                            <div class="login-right">
                                <p class="login-one-click-msg text-left">Disclaimer can go here</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="card mb-4 login-card">
                    <p class="card-header">Pfizer Network Login</p>
                    <div class="card-body">
                        <p>
                            <a class="btn btn-info btn-info-login pfizer-login"
                            href="{{config('cognito.endpoint')}}/authorize?client_id={{config('cognito.client_id')}}&grant_type={{config('cognito.grant_type')}}&redirect_uri={{config('cognito.redirect_uri')}}&response_type=code">
                                <i class="fa fa-user"></i>&nbsp;Pfizer Network Login</a>
                        </p>
                        <p class="login-one-click-msg">Sign in with one click if logged into the Pfizer Network.</p>
                    </div>
                </div>
            </div>
            <div class="footer">
                <div class="footer-div">
                    <strong>Copyright</strong> Pfizer &copy; {{ date('Y') }} |
                    @include('layouts._policy')  |
                    <strong>
                        <a href="http://www.pfizer.com/general/terms_transitioned.jsp" target="_blank">Terms of Service</a>
                    </strong>
                </div>
            </div>
        </div>
    </div>

@endsection
