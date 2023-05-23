<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function VendorDashBoard(){
        return view('vendor.index');
    }
    public function VendorLogin(){
        return view('vendor.vendor_login');
    }
    public function VendorDestroy(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/vendor/login');
    }

    public function VendorProfile(){
        $id = Auth::user()->id;
        $vendorData = User::query()->find($id);
        return view('vendor.vendor_profile',compact('vendorData'));
    }
    public function VendorProfileStore(Request $request){
        $id = Auth::user()->id;
        $data = User::query()->find($id);
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->vendor_join = $request->vendor_join;
        $data->vendor_short_info = $request->vendor_short_info;

        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/vendor_images/'.$data->photo));
            $filename = date('YmdHi'). $file->getClientOriginalName();
            $file->move(public_path('upload/vendor_images'), $filename);

            $data->photo = $filename;
        }
        $data->save();

        $notification = [
            'message'=> 'Vendor profile updated successfully',
            'alert-type'=>'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function VendorChangePassword(){
        return view('vendor.vendor_change_password');
    }
    public function VendorUpdatePassword(Request $request){
        $request->validate([
            'old_password'=> 'required',
            'new_password'=> 'required|confirmed'
        ]);

        if(!Hash::check($request->old_password, Auth::user()->password)){
            return back()->with('error',"Old Password doesn't Match !!!");
        }
        $id = Auth::user()->id;
        User::query()->find($id)->update([
            'password'=>Hash::make($request->new_password)
        ]);
        return back()->with('status',"Password Changed Successfully");
    }

    public function BecomeVendor(){
        return view('auth.become_vendor');
    }
    public function VendorRegister(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed'],
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'email' => $request->email,
            'role'=>'vendor',
            'status'=>'inactive',
            'password' => Hash::make($request->password),
        ]);

        $notification = [
            'message'=> 'Vendor Registered successfully',
            'alert-type'=>'success'
        ];

        return redirect()->route('vendor.login')->with($notification);
    }
}
