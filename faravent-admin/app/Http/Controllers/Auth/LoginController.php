<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Repos\UserRepo;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;
    protected $redirectPath;
    protected $redirectAfterLogout;

    protected $userRepo;

    /**
     * Create a new controller instance.
     *
     * @param SocialAuthService $socialAuthService
     * @param UserRepo $userRepo
     */
    public function __construct(UserRepo $userRepo)
    {
        $this->middleware('guest', ['only' => ['getLogin', 'postLogin']]);
        $this->userRepo = $userRepo;
        $this->redirectPath = route('index');
        $this->redirectTo = route('login');

        $this->redirectAfterLogout = route('login');

        parent::__construct();
    }

    public function username()
    {
        return 'user';
    }

    /**
     * Overrides the action when a user is authenticated.
     * If the user authenticated but does not exist in the user table we create them.
     * @param Request $request
     * @param Authenticatable $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthException
     */
    protected function authenticated(Request $request, Authenticatable $user)
    {
        return redirect($this->redirectPath);
    }

    /**
     * Show the application login form.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getLogin(Request $request)
    {
        return view('auth.login', ['loginFailed' => false]);
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();
        $request->session()->invalidate();
        return redirect($this->redirectAfterLogout);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended($this->redirectPath);
        } else {
            return view('auth.login', ['loginFailed' => true]);
        }
    }
}
