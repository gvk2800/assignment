<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use DB;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::guard('customers')->check())
        {
            $id=Auth::guard('customers')->id();
            $data=DB::table('customers')->where('id',$id)->first();
            if($data->role_id==1)
            {
                return $next($request);
            }
            else
            {
                return redirect('/new_dash')->with('message','Acess Denied');
            }
        }
        else
        {
            return redirect('/login')->with('message','Plz Login');
        }
        return $next($request);
    }
}
