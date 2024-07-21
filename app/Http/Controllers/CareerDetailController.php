<?php

namespace App\Http\Controllers;

use App\Models\CareerDetail;
use Illuminate\Http\Request;
class CareerDetailController extends Controller
{
    public function index(Request $request){
        
        $validation = $request->validate([
            'name'=>'required',
            'jobtitle'=>'required',
            'email'=>'required',
            'mobile'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/|digits_between:10,15',
            'resume'=>'required|mimes:pdf',
            ]);
            $names = $request->name;
         $file = $request->file('resume');
        $filename = time().'_'.strtok($names, " ").'.'.$file->getClientOriginalExtension();
        $destinationPath = 'resume';
        $file->move(public_path() . '/resume/',$filename);   
      $data = new CareerDetail();
      $data->name = $request->name;
      $data->jobtitle = $request->jobtitle;
      $data->email = $request->email;
      $data->mobile = $request->mobile;
      $data->resume = $filename;
      $data->save();
      return redirect()->back()->with('message','Data added Successfully');
    }
  
}
