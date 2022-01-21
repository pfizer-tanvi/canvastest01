<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @codeCoverageIgnore
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * {@inheritDoc}
     */
    public function validateLogin(Request $request): void
    {
        $this->validate($request, [
            $this->username() => 'required', 'password' => 'required',
        ]);

        $credentials = $this->credentials($request);

        $canLogin = $this->guard()->attempt($credentials, $request->has('remember'));

        if ($canLogin) {
            if ($user = User::where('email', $request->input('email'))->first()) {
                DB::table('sessions')->where('user_id', '=', $user->getKey())->delete();
            }
        }
    }
}
