<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\customer;
use App\Models\otp;
use DB;
use Carbon\Carbon;
use Session;
use Hash;
use Auth;

class OtpLoginController extends Controller
{
    //
    public function otp_login()
    {
        return view('auth.otplogin');
    }

    public function otp_generate(Request $request)
    {
        
        $request->validate([
            'mobile' => 'required|exists:customers,mobile'
        ]);  // Request Validation

        
        $otp_code = $this->generate_otp($request->mobile);

        $message = "Your OTP To Login is - ".$otp_code->otp;
        
        return redirect()->route('verify_otp', ['customer_id' => $otp_code->customer_id])->with('success',  $message); 
    }

    public function generate_otp($mobile)
    {
        $user = customer::where('mobile', $mobile)->first();

        
        $otp_code = otp::where('customer_id', $user->id)->latest()->first();

        $now = Carbon::now();

        if($otp_code && $now->isBefore($otp_code->expire_at)){
            return $otp_code;
        }

        // New OTP
        return otp::create([
            'customer_id' => $user->id,
            'otp' => rand(123456, 999999),
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);
    }
    public function verify_otp($user_id)
    {
        return view('auth.verify_otp')->with([
            'customer_id' => $user_id
        ]);
    }

    public function final_otp_login(Request $request)
    {
        // dd($request);
        #Validation
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'otp' => 'required'
        ]);

        #Validation Logic
        $otp_code   = otp::where('customer_id', $request->customer_id)->where('otp', $request->otp)->first();

        $now = Carbon::now();
        if (!$otp_code) {
            dd(321);
            return redirect()->back()->with('error', 'Your OTP is not correct');
        }elseif($otp_code && $now->isAfter($otp_code->expire_at)){
            // dd(11);
            return redirect()->route('otp_login')->with('error', 'Your OTP has been expired');
        }
        // dd(123);
        $user = customer::whereId($request->customer_id)->first();

        if($user){
            // Expire The OTP
            $otp_code->update([
                'expire_at' => Carbon::now()
            ]);

            Auth::guard('customers')->login($user);
            
            return redirect('/new_dash');
        }

        return redirect()->route('otp_login')->with('error', 'Your Otp is not correct');
    }
}
