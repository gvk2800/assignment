<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use DB;
use Auth;
use Session;
use App\Models\customer;

// class LoginController extends Controller
// {
//     /*
//     |--------------------------------------------------------------------------
//     | Login Controller
//     |--------------------------------------------------------------------------
//     |
//     | This controller handles authenticating users for the application and
//     | redirecting them to your home screen. The controller uses a trait
//     | to conveniently provide its functionality to your applications.
//     |
//     */

//     use AuthenticatesUsers;

//     /**
//      * Where to redirect users after login.
//      *
//      * @var string
//      */
//     protected $redirectTo = RouteServiceProvider::HOME;

//     /**
//      * Create a new controller instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         $this->middleware('guest')->except('logout');
//     }
// }
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
    protected $redirectTo = 'new_dash';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('guest:customers')->except('logout');
      $this->middleware('guest:web')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        //dd("hello");
      return view('auth.login');
    }

    /**
     * Redirect the user to the facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from facebook.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    // public function login(Request $request)
    // {
        // dd($request);
        // if($request->login_type=='EnterOTP')        //   <---------OTP REQUEST----------
        // {
        //     //dd($request);
        //     $phone=$request->phone;
        //     $otp = rand(1000,9999);
        //     // $otp = 2021;
        //     $data = array(
        //             'otp'=>$otp,
        //             'phone'=>$phone,
        //             'status'=>1,
        //         );
            
        //     //dd($request,$data);
        //     $user_exist=DB::table('customers')->where('phone',$phone)->first();
            
        //         //return $otp;
        //     if(!empty($user_exist))
        //     {
                // $check_otp_exist = DB::table('otps')->where('phone',$phone)->first();
                
                // //dd($check_otp_exist,$request,$data);

                // if($check_otp_exist != '')
                //      DB::table('otps')->where('phone',$phone)->delete();
                //  $sent_otp = DB::table('otps')->insert($data);
                
                
                // //$this->sendMsg($phone,$message);
                // Customer::where('phone',$phone)->update(['password'=>bcrypt($otp)]);
                // return array('data'=>'enter otp','phone'=>$phone,'otp'=>$otp);
        //     }

        //     else
        //     {
        //         return array('data'=>'please register','phone'=>$phone);
        //     }
            
        // }
        // elseif($request->login_type=='VerifyOTP')       //   <--------------------OTP Verification--------------
        // {
        //     //dd($request);
        //     if ($this->hasTooManyLoginAttempts($request)) {
        //         $this->fireLockoutEvent($request);

        //         return $this->sendLockoutResponse($request);
        //     }
        //     $customer =Auth::guard('customer')->attempt(
        //         $request->only('phone','password'), $request->filled('remember')
        //     );
        //     //if($request->password=='2021')
        //     if($customer)
        //     {
        //         //dd($request,$customer);
        //         //return redirect()->intended(url()->previous())->with('success', trans('theme.notify.logged_in_successfully'));
        //         return redirect()->route('Account','details')->with('success', trans('theme.notify.logged_in_successfully'));
        //     }
        //      // If the login attempt was unsuccessful we will increment the number of attempts
        //     // to login and redirect the user back to the login form. Of course, when this
        //     // user surpasses their maximum number of attempts they will get locked out.
        //     $this->incrementLoginAttempts($request);
        //     return redirect()->intended(url()->previous())->with('warning', trans('OTP not matched | <a href="#" class="dropdn-link js-dropdn-link" data-panel="#dropdnAccount"> ( Retry )</a>'));

        //     //return $this->sendFailedLoginResponse($request);
            
        // }
        // else    // ----------email login---------------
        
            // $this->validate($request, [
            //     $this->username() => 'required|string',
            //     'password' => 'required|string',
            // ]);

            // If the class is using the ThrottlesLogins trait, we can automatically throttle
            // the login attempts for this application. We'll key this by the username and
            // the IP address of the client making these requests into this application.

            // if ($this->attemptLogin($request)) {
            //     // if successful, then redirect to their intended location

            //     return redirect()->intended(url()->previous())->with('success', trans('theme.notify.logged_in_successfully'));
            // }
            // $credentials = $request->only('email', 'password');

            // if (Auth::guard('customers')->attempt($credentials)) {
  
            //     return redirect()->route('home');
            // }
            // else
            // {
            //     return "incorrect";
            // }

            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            // $this->incrementLoginAttempts($request);

            // return $this->sendFailedLoginResponse($request);
        
    // }
    public function login(Request $request)
    {
        $this->validate($request, [
                $this->username() => 'required|string',
                'password' => 'required|string',
            ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard('customers')->user())) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());
    }
    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    // protected function attemptLogin(Request $request)
    // {
    //     return Auth::guard('customers')->attempt(
    //         $request->only($this->username(), 'password'), $request->filled('remember')
    //     );
    // }
    protected function attemptLogin(Request $request)
    {
        return $this->guard('customers')->attempt(
            $this->credentials($request), $request->boolean('remember')
        );
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::guard('customers')->logout();

        //$request->session()->invalidate();

        return redirect()->to('/')->with('success', trans('theme.notify.logged_out_successfully'));
        //return redirect()->intended(url()->previous())->with('success', trans('theme.notify.logged_out_successfully'));
        
        
    }
    

}

