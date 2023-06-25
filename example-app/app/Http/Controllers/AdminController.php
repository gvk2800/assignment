<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\customer;
use DB;
use Session;
use Hash;
use Auth;
class AdminController extends Controller
{
    //
    public function create()
    {
        return view('register_customer');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fname'=> 'required',
            'email'=> 'required|email',
            'mobile'=> 'required',
            'pass'=> 'required'
        ]);
        if($validator->passes())
        {
            // dd(1);
            $data=([
                'first_name'=>$request->fname,
                'last_name'=>$request->lname ? $request->lname : null,
                'mobile'=>$request->mobile,
                'email'=>$request->email,
                'password'=>Hash::make($request->pass),
                'role_id'=>0,
            ]);
            // dd($data);
            DB::table('customers')->insert($data);
            Session::flash('sucess','Category Saved Sucessfully');
            return response()->json(['success'=>"User regsi"]);
        }
        return response()->json(['error'=>$validator->errors()]);
    }
    public function dash ()
    {
        $id=Auth::guard('customers')->id();
        $data=DB::table('customers')->where('id',$id)->first();
        $role=$data->role_id ? "Admin" : "Customer";
        // dd($id);
        return view('new_dash',compact('id','data','role'));
    }
    public function all_customer()
    {
        $d=DB::table('customers')->where('role_id',0)->get();
        return view('cindex',compact('d'));
    }
    public function cedit(Request $request)
    {
        $data=DB::table('customers')->where('id',$request->idd)->first();
        return view('cedit',compact('data'));
    }
    public function cupdate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fname'=> 'required',
            'email'=> 'required|email',
            'mobile'=> 'required',
        ]);
        if($validator->passes())
        {
            // dd(1);
            $data=([
                'first_name'=>$request->fname,
                'last_name'=>$request->lname ? $request->lname : null,
                'mobile'=>$request->mobile,
                'email'=>$request->email,
                'role_id'=>0,
            ]);
            // dd($data);
            $d=customer::where('id',$request->idd)->first();
            $d->first_name=$request->fname;
            $d->last_name=$request->lname;
            $d->mobile=$request->mobile;
            $d->email=$request->email;
            $d->role_id=0;
            $d->save();
            Session::flash('sucess','Category Saved Sucessfully');
            return response()->json(['success'=>"User regsi"]);
        }
        return response()->json(['error'=>$validator->errors()]);
    }
}
