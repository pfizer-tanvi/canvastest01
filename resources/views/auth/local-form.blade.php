<div class="row justify-content-center">
    <div class="col-4">
        <div class="card login-card">
            <div class="card-header">Local/Staging Login</div>
                <div class="card-body">
                    <form role="form" method="POST" action="/login" class="mb-5">
                        {{ csrf_field() }}

                        <!-- E-Mail Address -->
                        <div class="form-group">
                            <label>{{__('E-Mail')}}</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus />
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label>{{__('Password')}}</label>
                            <input type="password" class="form-control" name="password" />
                        </div>

                        <!-- Remember Me -->
                        <div class="form-group">
                            <div class="form-check">
                                <div class="form-check-label">
                                    <label>
                                        <input type="checkbox" name="remember" class="form-check-input" /> {{__('Remember Me')}}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Login Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-dark btn-block">
                                {{__('Login')}}
                            </button>
                        </div>
                        <hr />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
