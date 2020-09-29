<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, string $provider)
    {
        $providerUser = Socialite::driver($provider)->stateless()->user();
        // Laravel\Socialite\Two\Userというクラスのインスタンスを取得できる

        $user = User::where('email', $providerUser->getEmail())->first();
        // Googleから取得したユーザー情報から、メールアドレスを取り出し、usersテーブルに存在するかを調べている
        // $providerUser->getEmail()で、Googleから取得したユーザー情報からメールアドレスを取得

        if($user) {
        // $userがnullでなければ(Googleから取得したメールアドレスを同じメールアドレスを持つユーザーモデルが存在すれば)以下の処理を行う

            $this->guard()->login($user, true);
            // userをログイン状態にする

            return $this->sendLoginResponse($request);
            // ログイン後の画面（記事一覧画面）に遷移
        }
    }
}
