<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use Session;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/article';
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {


        // check if user is not activated
        if (is_null($user->active) && $user->block !== 1) {

            $this->logout();
            return redirect('login')->withInput()->withErrors(['status' => 'Your account is for verification. Please contact the administrator.']);

        // check if user is not activated
        } elseif ($user->active == 0 && $user->block !== 1) {

            $this->logout();
            return redirect('login')->withInput()->withErrors(['status' => 'Your account is not active. Please contact the administrator.']);

        // check if user is not activated
        } elseif ($user->block === 1) {

            $this->logout();
            return redirect('login')->withInput()->withErrors(['status' => 'Your account has been blocked. Please contact the administrator.']);

        } else { 
     
            //$profileId = Auth::user()->id;
            $request->session()->put('user.profile_name', strtolower(str_replace(' ', '-', Auth::user()->name)));

            // update user last login, and last login ip
            $user->update([
                // 'last_login_at' => date('Y-m-d H:i:s'),
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $request->getClientIp()
            ]);

        } 

    }


    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function findUsername()
    {
        $login = request()->input('login');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $login]);
        return $fieldType;
    }
 
    /**
     * Get username property.
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }

}
