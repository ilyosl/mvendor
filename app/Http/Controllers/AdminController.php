<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class AdminController extends Controller
{
    public function AdminDashBoard(){
        return view('admin.index');
    }
    public function AdminLogin(){
        return view('admin.admin_login');
    }
    public function AdminDestroy(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
    public function AdminProfile(){
        $id = Auth::user()->id;
        $adminData = User::query()->find($id);
        return view('admin.admin_profile',compact('adminData'));
    }
    public function AdminProfileStore(Request $request){
        $id = Auth::user()->id;
        $data = User::query()->find($id);
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename = date('YmdHi'). $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);

            $data->photo = $filename;
        }
        $data->save();

        $notification = [
            'message'=> 'Admin profile updated successfully',
            'alert-type'=>'success'
        ];

        return redirect()->back()->with($notification);
    }
    public function AdminChangePassword(){
        return view('admin.admin_change_password');
    }
    public function AdminUpdatePassword(Request $request){
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
    public function InactiveVendor(){
        $inActiveVendor = User::query()->where('status','=','inactive')->where('role','=','vendor')->get();

        return view('backend.vendor.inactive_vendor', compact('inActiveVendor'));
    }
    public function ActiveVendor(){
        $activeVendor = User::query()->where('status','=','active')->where('role','=','vendor')->get();

        return view('backend.vendor.active_vendor', compact('activeVendor'));
    }

    public function VendorDetails($id){
        $vendorDetails = User::query()->findOrFail($id);
        return view('backend.vendor.detail', compact('vendorDetails'));
    }
    public function VendorApprove(Request $request){
        $vendorDetails = User::query()->findOrFail($request->id);
        $route = '';
        if($request->status == 'active'){
            $vendorDetails->status = 'inactive';
            $route = 'inactive.vendor';
        }elseif($request->status == 'inactive'){
            $vendorDetails->status = 'active';
            $route = 'active.vendor';
        }
        $vendorDetails->save();
        $notification = [
            'message'=> 'Vendor status changed successfully',
            'alert-type'=>'success'
        ];

        return redirect()->route($route)->with($notification);
    }
}
