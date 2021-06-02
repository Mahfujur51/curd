<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;



class CustomerController extends Controller
{
    public function  index(){
        $customers=Customer::orderBy('id')->paginate(10);
        return view('welcome',compact('customers'));
    }
    public  function  store(Request  $request){
        $request->validate([
           'name'=>'required|max:50',
           'phone'=>'required|max:50',
           'email'=>'required|max:50|unique:customers',
           'gender'=>'required|max:50',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $customer=new Customer();
        $customer->name=$request->name;
        $customer->phone=$request->phone;
        $customer->email=$request->email;
        $customer->gender=$request->gender;
        if ($request->has('status')){
            $customer->status=$request->status;
        }else{
            $customer->status='inactive';
        }
        if($request->has('image')){
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(270,270)->save('customer/'.$name_gen);
            $image_url = $name_gen;
        }
        $customer->image = $image_url;
        $customer->save();
        return redirect()->back()->with('message', 'Customer Insert Successfully!!');


    }
    public  function  update(Request  $request,$id){
        $request->validate([
            'name'=>'required|max:50',
            'phone'=>'required|max:50',
            'email'=>'required|max:50',
            'gender'=>'required|max:50',
            'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $customer=Customer::findOrFail($id);
        $image='customer/'.$customer->image;
        $customer->name=$request->name;
        $customer->phone=$request->phone;
        $customer->email=$request->email;
        $customer->gender=$request->gender;
        if ($request->has('status')){
            $customer->status=$request->status;
        }else{
            $customer->status='inactive';
        }
        if($request->has('image')){
            unlink($image);
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(270,270)->save('customer/'.$name_gen);
            $image_url = $name_gen;
            $customer->image = $image_url;
        }

        $customer->update();
        return redirect()->back()->with('message', 'Customer Updated Successfully!!');
    }
    public  function  delete($id){
        $customer=Customer::findOrFail($id);
        $image='customer/'.$customer->image;
        unlink($image);
        $customer->delete();
        return redirect()->back()->with('message', 'Customer Deleted Successfully!!');
    }
    public  function inactive($id){
        $customer=Customer::findOrFail($id);
        $customer->status='inactive';
        $customer->save();
        return redirect()->back()->with('message', 'Customer Inactive Successfully!!');
    }
    public  function active($id){
        $customer=Customer::findOrFail($id);
        $customer->status='active';
        $customer->save();
        return redirect()->back()->with('message', 'Customer Active  Successfully!!');
    }
}
