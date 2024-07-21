<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogAuthenticate;
use App\Models\Agent\Admin;
use Illuminate\Support\Facades\Hash;
use App\Models\Agent\Agent;
use App\Models\Agent\GdsUser;
use App\Models\Agent\User;
use App\Models\Agent\AgentBooking;
use App\Models\Booking;
use Session;
class Useradmin extends Controller
{
    public function Blog_page()
    {
        if(session()->get('useradmin')){
            return view('useradmin.blog_page');
      }else{
          return redirect('/adminlogin');
      }
    }

    public function dashboard(){
        if(session()->get('useradmin')){
          return view('useradmin.dashborad');  
    }else{
        return redirect('/adminlogin');
    }
    } 

    public function admin_login(){
        if(session()->get('useradmin')){
            return redirect('/useradmin');
        }else{
            return view('useradmin.admin-login');
        }
    }

    public function useradmin_profile(){
        if(session()->get('useradmin')){
             $blogs = new Admin();
             $data = $blogs->find(session()->get('id'));
            return view('useradmin.useradmin-profile', ['admindata'=>$data]);
        }else{
          return redirect('/adminlogin');
        }
    }

    public function getdata()
    {
        if(session()->get('useradmin')){
            // $blogs = new Blog();
        $data = Blog::paginate(3);
        // foreach ($data as  $value) {
        //     $id = $value->id;
        //     $dd[] = collect(\DB::select('select * from blogImages where blogs_id = '.$id))->first();
        // }
        // die();
        return view('useradmin.admin-blog-page', ['data' => $data]);
        }else{
          return redirect('/adminlogin');
        }
       
    }

    public function show_blog_pages($id)
    {  if(session()->get('useradmin')){
        $blogs = new Blog();
        $data = $blogs->find($id);
        // $dd = DB::select('select * from blogImages where blogs_id = '.$id);
        return view('useradmin.blogs_pages_details', ['data' => $data]);
    }else{
      return redirect('/adminlogin');
    }
       
    }

    public function edit_blog_pages($id)
    {
        if(session()->get('useradmin')){
            $blogs = new Blog();
            $data = $blogs->find($id);
            return view('useradmin.useradmin_edit_blog_post', ['data' => $data]);
        }else{
        return redirect('/adminlogin');
        }
       
    }

    public function delete_blog($id)
    {
        if(session()->get('useradmin')){
            $blogs = new Blog();
        $data = $blogs->find($id);
        $data->delete();
        return redirect('/useradmin/blogpages');
        }else{
        return redirect('/adminlogin');
        }
       
    }

    public function blogPost(Request $request)
    {
        if(session()->get('useradmin')){
            $blogs = new Blog();
        $blog_desc =  $request->blog_desc;
        $blogs->blog_desc = $blog_desc;
        $blogs->status = '1';
        $blogs->save();
        return redirect('/useradmin/blogpages');
        }else{
        return redirect('/adminlogin');
        }
       
    }

    public function status(Request $request, $blog_id, $status_id)
    {
        if(session()->get('useradmin')){
            $blogs = new Blog();
            $data = $blogs->find($blog_id);
            $data->status = $status_id;
            $data->save();
            return redirect('/useradmin/blogpages');
        }else{
        return redirect('/adminlogin');
        }
      
    }
    
    public function forwagnistrip(Request $request, $blog_id, $status_id)
    {
        if(session()->get('useradmin')){
            $blogs = new Blog();
            $data = $blogs->find($blog_id);
            $data->forwagnistrip = $status_id;
            $data->save();
            return redirect('/useradmin/blogpages');
        }else{
        return redirect('/adminlogin');
        }
      
    }

    public function edit_blog_data(Request $request, $id)
    {
        if(session()->get('useradmin')){
            $blogs = new Blog();
            $data = $blogs->find($id);
            $data->blog_desc = $request->blog_desc;
            $data->save();
            return redirect('/useradmin/blogpages');
        }else{
        return redirect('/adminlogin');
        }
       
       
    }

    public function adminauth(Request $request){
    if(session()->get('useradmin')){
         return redirect('/useradmin');
    }else{
           $blogAuth = new Admin();
        //   $blogAuth = $blogAuth->find(1);
        //   $blogAuth->email = $request->username;
        //   $blogAuth->password = Hash::make($request->password);
        //   $blogAuth->save();
        //   dd($blogAuth->email, $request->username, $request->password, $blogAuth->password);
           $data = $blogAuth->where('email', '=' , $request->username)->first();
           if($data != null)
           {
               if(Hash::check($request->password,$data->password)&& ($data->email== $request->username)){
                $request->session()->put('id', $data->id);
                $request->session()->put('useradmin', $request->username);
                // dd('d');
                 return redirect('/useradmin');
               }else{
                    $mess = "Email And Password Don't Match...";
                    return redirect('/adminlogin')->withErrors(['msg' =>$mess]);
               }
           }else{
                $mess = "Email And Password Don't Match.";
                return redirect('/adminlogin')->withErrors(['msg' =>$mess]);
           }
        }
    }


    public function logout(Request $request){
        $request->session()->forget('useradmin');
        return redirect('/adminlogin');
    }

    public function useradmin_gds(){
        if(session()->get('useradmin')){
            $data = Booking::orderBy('id', 'desc')->paginate(10);
            return view('useradmin.GDS_page', ['data'=>$data]);
        }else{
        return redirect('/adminlogin');
        }
    }
    
    public function Agent_booking_details(){
        if(session()->get('useradmin')){
            $Agentdata = AgentBooking::orderBy('id', 'desc')->paginate(10);
            return view('useradmin.agent_booking_details', ['Agentdata'=>$Agentdata]);
        }else{
        return redirect('/adminlogin');
        }
    }
    
    public function Agent_confirm_ticket(Request $request){
       $agent_booking_id = $request->agent_booking_id;
       $status = $request->confirmation;
       $agent = new AgentBooking();
       $data = $agent->find($agent_booking_id);
       $data->IsConfirm = $status;
       $data->save();
       $mess = 'Ticket Update Successfull';
       return redirect()->back()->withErrors(['msg' =>$mess]);
    }

    public function agent_pages(){
        // dd('dd');
        if(session()->get('useradmin')){
            // $agent = new Agent();
            $data = Agent::orderBy('id','DESC')->paginate(10);
            $total = new Agent();
            $total = count($total->All());
            return view('useradmin.agent_page', ['data'=>$data, 'total'=>$total]);
        }else{
        return redirect('/adminlogin');
        }

    }

    public function gds_form(Request $request){
       $gds_id = $request->gds_id;
       $status = $request->confirmation;
       $agent = new Booking();
       $data = $agent->find($gds_id);
       $data->IsConfirm = $status;
       $data->save();
       $mess = 'Ticket Update Successfull';
       return redirect()->back()->withErrors(['msg' =>$mess]);
       
    }
    
    public function changepassword(Request $request){
       $username = session()->get('useradmin');
       $id = $request->id;
       $blogAuth = new Admin();
       $data = $blogAuth->find($id);
       $current = $request->current_password;
       $newpass= $request->new_password;
       $cpass = $request->confirm_password;
       if($newpass === $cpass){
           if(Hash::check($current,$data->password)&& ($data->email== $username)){
              $data->password = Hash::make($newpass);
              $data->plen_pass = $newpass;
              $data->save();
              $mess = 'Password Change Successfull';
              return redirect()->back()->withErrors(['msg' =>$mess]);
           }else{
               $mess = 'Password Not Change';
              return redirect()->back()->withErrors(['msg' =>$mess]);
           }
       }else{
         $mess = 'Password Not Change';
         return redirect()->back()->withErrors(['msg' =>$mess]);
       }
    }
    
    public function Agent_status(Request $request, $id, $status_id){
          $agent = new Agent();
          $data = $agent->find($id);
          $data->status = $status_id;
          $data->save();
          return redirect()->back();
    }
    
    public function Delete_agent($id){
         $agent = new Agent();
          $data = $agent->find($id);
          $data->delete();
          return redirect()->back();
    }
    
    public function Agent_Amount_Update(Request $request){
       $agent_amount = $request->agent_amount;
       $agent_id = $request->agent_id;
       $agent = new Agent();
       $data = $agent->find($agent_id);
       $data->state = $agent_amount;
       $data->save();
       $mess = 'Amount Update Successfull';
       return redirect()->back()->withErrors(['msg' =>$mess]);
    }
    
    public function Agent_view($id){
        $agent = new Agent();
        $data = $agent->find($id);
        $email = $data->email;
        $agent_booking = AgentBooking::where('B', '=', $email)->paginate(10);
        return view('useradmin.view_agent_detail', ['data'=> $data, 'booking'=>$agent_booking]);
    }
    
    public function Agent_view_update(Request $request){
       $agent = new Agent();
       $data = $agent->find($request->agent_id);
       $data->name = $request->name;
       $data->email = $request->email;
       $data->phone = $request->phone;
       $data->address = $request->address;
       $data->state = $request->state;
       $data->city = $request->city;
       $data->zip = $request->zip;
       $data->country = $request->country;
       $data->type = $request->type;
       $data->save();
       $mess = 'Agent Profile Update Successfull';
       return redirect('/agent_pages')->withErrors(['msg' =>$mess]);
    }
    
    public function CreatedUserShow(Request $request){
         $gdsuser = GdsUser::paginate(10);
         $blog = BlogAuthenticate::paginate(10);
        return view('useradmin.userPage', ['blog'=>$blog, 'gdsuser'=>$gdsuser]);
    }
    
    public function CreateUser(){
     
        return view('useradmin.create_user');
    }
    
    public function Create_new_user(Request $request){
        if($request->password !== $request->cpassword){
             $mess = 'Don\'t Match And Confirm Password Check Again';
            return redirect('/create_user')->withErrors(['msg' =>$mess]);
         }
        if(!empty($request->bloguser) && !empty($request->gdsuser) && !empty($request->agentuser)){
            $gdsuser = new GdsUser();
            $user = $gdsuser->where('email', '=', $request->email)->first();
            if ($user === null) {
               $gdsuser->name = $request->name;
                $gdsuser->email = $request->email;
                $gdsuser->password = Hash::make($request->password);
                $gdsuser->phone = $request->phone;
                $gdsuser->plen_pass = $request->password;
                $gdsuser->status = '0';
                $gdsuser->save();
            }else{
                 $mess = 'GDS User Already Exist';
                 return redirect('/create_user')->withErrors(['msg' =>$mess]);
            }
            
           
            
            $blog = new BlogAuthenticate();
            $user = $blog->where('email', '=', $request->email)->first();
            if ($user === null) {
               $blog->username = $request->name;
                $blog->email = $request->email;
                $blog->password = Hash::make($request->password);
                $blog->phone = $request->phone;
                $blog->pass_plentext = $request->password;
                $blog->status = '0';
                $blog->save(); 
            }else{
                $mess = 'Blog User Already Exist';
                 return redirect('/create_user')->withErrors(['msg' =>$mess]);
            }
            
            $Agent = new Agent();
            $user = $Agent->where('email', '=', $request->email)->first();
            if ($user === null) {
                $Agent->name = $request->name;
                $Agent->email = $request->email;
                $Agent->password = Hash::make($request->password);
                $Agent->phone = $request->phone;
                $Agent->plen_pass = $request->password;
                $Agent->status = '0';
                $Agent->save(); 
            }else{
                $mess = 'Blog User Already Exist';
                 return redirect('/create_user')->withErrors(['msg' =>$mess]);
            }
            
            $mess = 'Create Blog User And GDS User Successfull';
            return redirect('/create_user_view')->withErrors(['msg' =>$mess]);
            // dd($request->bloguser, $request->gdsuser);
        }elseif(!empty($request->bloguser) && !empty($request->gdsuser)){
            $gdsuser = new GdsUser();
            $user = $gdsuser->where('email', '=', $request->email)->first();
            if ($user === null) {
               $gdsuser->name = $request->name;
                $gdsuser->email = $request->email;
                $gdsuser->password = Hash::make($request->password);
                $gdsuser->phone = $request->phone;
                $gdsuser->plen_pass = $request->password;
                $gdsuser->status = '0';
                $gdsuser->save();
            }else{
                 $mess = 'GDS User Already Exist';
                 return redirect('/create_user')->withErrors(['msg' =>$mess]);
            }
            
           
            
            $blog = new BlogAuthenticate();
            $user = $blog->where('email', '=', $request->email)->first();
            if ($user === null) {
               $blog->username = $request->name;
                $blog->email = $request->email;
                $blog->password = Hash::make($request->password);
                $blog->phone = $request->phone;
                $blog->pass_plentext = $request->password;
                $blog->status = '0';
                $blog->save(); 
            }else{
                $mess = 'Blog User Already Exist';
                 return redirect('/create_user')->withErrors(['msg' =>$mess]);
            }
            
            $mess = 'Create Blog User And GDS User Successfull';
            return redirect('/create_user_view')->withErrors(['msg' =>$mess]);
            // dd($request->bloguser, $request->gdsuser);
        }elseif(!empty($request->bloguser) && !empty($request->agentuser)){
             $Agent = new Agent();
            $user = $Agent->where('email', '=', $request->email)->first();
            if ($user === null) {
                $Agent->name = $request->name;
                $Agent->email = $request->email;
                $Agent->password = Hash::make($request->password);
                $Agent->phone = $request->phone;
                $Agent->plen_pass = $request->password;
                $Agent->status = '0';
                $Agent->save(); 
            }else{
                $mess = 'Blog User Already Exist';
                 return redirect('/create_user')->withErrors(['msg' =>$mess]);
            }
            
            $blog = new BlogAuthenticate();
            $user = $blog->where('email', '=', $request->email)->first();
            if ($user === null) {
               $blog->username = $request->name;
                $blog->email = $request->email;
                $blog->password = Hash::make($request->password);
                $blog->phone = $request->phone;
                $blog->pass_plentext = $request->password;
                $blog->status = '0';
                $blog->save(); 
            }else{
                $mess = 'Blog User Already Exist';
                 return redirect('/create_user')->withErrors(['msg' =>$mess]);
            }
            
            $mess = 'Create Blog User And GDS User Successfull';
            return redirect('/create_user_view')->withErrors(['msg' =>$mess]);
            // dd($request->bloguser, $request->gdsuser);
        }elseif(!empty($request->gdsuser) && !empty($request->agentuser)){
             $Agent = new Agent();
            $user = $Agent->where('email', '=', $request->email)->first();
            if ($user === null) {
                $Agent->name = $request->name;
                $Agent->email = $request->email;
                $Agent->password = Hash::make($request->password);
                $Agent->phone = $request->phone;
                $Agent->plen_pass = $request->password;
                $Agent->status = '0';
                $Agent->save(); 
            }else{
                $mess = 'Blog User Already Exist';
                 return redirect('/create_user')->withErrors(['msg' =>$mess]);
            }
            
           
            
           $gdsuser = new GdsUser();
            $user = $gdsuser->where('email', '=', $request->email)->first();
            if ($user === null) {
               $gdsuser->name = $request->name;
                $gdsuser->email = $request->email;
                $gdsuser->password = Hash::make($request->password);
                $gdsuser->phone = $request->phone;
                $gdsuser->plen_pass = $request->password;
                $gdsuser->status = '0';
                $gdsuser->save();
            }else{
                 $mess = 'GDS User Already Exist';
                 return redirect('/create_user')->withErrors(['msg' =>$mess]);
            }
            
            
            $mess = 'Create Blog User And GDS User Successfull';
            return redirect('/create_user_view')->withErrors(['msg' =>$mess]);
            // dd($request->bloguser, $request->gdsuser);
        }elseif(!empty($request->bloguser)){
             $blog = new BlogAuthenticate();
           $user = $blog->where('email', '=', $request->email)->first();
            if ($user === null) {
               $blog->username = $request->name;
                $blog->email = $request->email;
                $blog->password = Hash::make($request->password);
                $blog->phone = $request->phone;
                $blog->pass_plentext = $request->password;
                $blog->status = '0';
                $blog->save(); 
            }else{
                $mess = 'Blog User Already Exist';
                 return redirect('/create_user')->withErrors(['msg' =>$mess]);
            }
            $mess = 'Create Blog User Successfull';
            return redirect('/create_user_view')->withErrors(['msg' =>$mess]);
            // dd($request->bloguser);
        }elseif(!empty($request->gdsuser)){
             $gdsuser = new GdsUser();
           $user = $gdsuser->where('email', '=', $request->email)->first();
            if ($user === null) {
               $gdsuser->name = $request->name;
                $gdsuser->email = $request->email;
                $gdsuser->password = Hash::make($request->password);
                $gdsuser->phone = $request->phone;
                $gdsuser->plen_pass = $request->password;
                $gdsuser->status = '0';
                $gdsuser->save();
            }else{
                 $mess = 'GDS User Already Exist';
                 return redirect('/create_user')->withErrors(['msg' =>$mess]);
            }
             $mess = 'Create GDS User Successfull';
            return redirect('/create_user_view')->withErrors(['msg' =>$mess]);
        }elseif(!empty($request->agentuser)){
             $Agent = new Agent();
            $user = $Agent->where('email', '=', $request->email)->first();
            if ($user === null) {
                $Agent->name = $request->name;
                $Agent->email = $request->email;
                $Agent->password = Hash::make($request->password);
                $Agent->phone = $request->phone;
                $Agent->plen_pass = $request->password;
                $Agent->status = '0';
                $Agent->save(); 
            }else{
                $mess = 'Blog User Already Exist';
                 return redirect('/create_user')->withErrors(['msg' =>$mess]);
            }
             $mess = 'Create GDS User Successfull';
            return redirect('/create_user_view')->withErrors(['msg' =>$mess]);
        }else{
            $mess = 'Select Any One Blog User / GDS User / Agent User';
            return redirect('/create_user')->withErrors(['msg' =>$mess]);
        }
        dd($request->all());
    }
    
    public function deleteBlogUser($id){
        $blog = new BlogAuthenticate();
        $data = $blog->find($id);
        $data->delete();
        $mess = 'Delete Blog User Successfull';
        return redirect('/create_user_view')->withErrors(['msg' =>$mess]);
    }
    
    public function deleteGdsUser($id){
        $gdsuser = new GdsUser();
        $data = $gdsuser->find($id);
        $data->delete();
        $mess = 'Delete GDS User Successfull';
        return redirect('/create_user_view')->withErrors(['msg' =>$mess]);
    }
    
    public function BlogUser_status(Request $request, $blog_id, $status_id){
         $blog = new BlogAuthenticate();
         $blog = $blog->find($blog_id);
         $blog->status = $status_id;
         $blog->save();
         if($status_id == 1){
         $mess = 'User Activate Successfull';
         }else{
         $mess = 'User Deactivate Successfull';
         }
        return redirect('/create_user_view')->withErrors(['msg' =>$mess]);
    }
    
    public function GdsUser_status(Request $request, $gds_id, $status_id){
       $blog = new GdsUser();
         $blog = $blog->find($gds_id);
         $blog->status = $status_id;
         $blog->save();
         if($status_id == 1){
         $mess = 'User Activate Successfull';
         }else{
         $mess = 'User Deactivate Successfull';
         }
        return redirect('/create_user_view')->withErrors(['msg' =>$mess]);
    }
    
    public function Update_blog_user(Request $request, $id){
        $blog = new BlogAuthenticate();
        $blog = $blog->find($id);
        return view('useradmin.blog_user_edit', ['data'=>$blog]);
    }
    
    public function Update_Gds_user(Request $request, $id){
        $blog = new GdsUser();
        $blog = $blog->find($id);
        return view('useradmin.gds_user_edit', ['data'=>$blog]);
    }
    
    public function UpdateBlogUser(Request $request){
         if($request->password !== $request->cpassword){
             $mess = 'Don\'t Match And Confirm Password Check Again';
            return redirect('/blog_user_edit/'.$request->id)->withErrors(['msg' =>$mess]);
         }else{
            $blog = new BlogAuthenticate();
            $blog = $blog->find($request->id);
            $blog->username = $request->name;
            $blog->email = $request->email;
            $blog->password = Hash::make($request->password);
            $blog->phone = $request->phone;
            $blog->pass_plentext = $request->password;
            $blog->save();
             $mess = 'Update Blog User Successfull';
            return redirect('/create_user_view')->withErrors(['msg' =>$mess]);
         }
       
    }
    
    public function UpdateGdsUser(Request $request){
       if($request->password !== $request->cpassword){
             $mess = 'Don\'t Match And Confirm Password Check Again';
            return redirect('/gds_user_edit/'.$request->id)->withErrors(['msg' =>$mess]);
         }else{
             
            $gdsuser = new GdsUser();
            $gdsuser = $gdsuser->find($request->id);
            $gdsuser->name = $request->name;
            $gdsuser->email = $request->email;
            $gdsuser->password = Hash::make($request->password);
            $gdsuser->phone = $request->phone;
            $gdsuser->plen_pass = $request->password;
            $gdsuser->save();
             $mess = 'Update GDS User Successfull';
            return redirect('/create_user_view')->withErrors(['msg' =>$mess]);
         }
    }
    
    public function GdsUser_allow_for_edit(Request $request, $gds_id, $allow_for_edit_id){
        $gdsuser = new GdsUser();
        $data = $gdsuser->find($gds_id);
        $data->allow_for_edit = $allow_for_edit_id;
        $data->save();
        $mess = 'Update GDS User Successfull';
        return redirect('/create_user_view')->withErrors(['msg' =>$mess]);
    }
    
    public function User_pagess(){
        $data = User::paginate(10);
        return view('useradmin.users_pages', ['data'=>$data]);
        
    }
    
    public function UserUpdate(Request $request){
        $agent_amount = $request->agent_amount;
       $agent_id = $request->agent_id;
       $agent = new User();
       $data = $agent->find($agent_id);
       $data->amount = $agent_amount;
       $data->save();
       $mess = 'Amount Update Successfull';
       return redirect()->back()->withErrors(['msg' =>$mess]);
    }
    
    
    public function UserStatue(Request $request, $user_id, $status_id){
         $blog = new User();
         $blog = $blog->find($user_id);
         $blog->status = $status_id;
         $blog->save();
         if($status_id == 1){
         $mess = 'User Activate Successfull';
         }else{
         $mess = 'User Deactivate Successfull';
         }
        return redirect('/User_pagess')->withErrors(['msg' =>$mess]);
    }
  
    public function UserDelete($id)
    {
        $user= new User();
        $data = $user->find($id);
        $data->delete();
        return redirect('/User_pagess')->withErrors(['msg' =>'Customer Details Delete Successfull']);
    }
    
    
    public function viewUserPage(Request $request, $id){
        $agent = new User();
        $data = $agent->find($id);
        return view('useradmin.view_user_detail', ['data'=> $data]);
    }
    
    public function User_view_update(Request $request){
       $agent = new User();
      
       $data = $agent->find($request->user_id);
       $data->name = $request->name;
       $data->email = $request->email;
       $data->phone = $request->phone;
       $data->amount = $request->amount;
       $data->gender = $request->gender;
       $data->save();
       $mess = 'Customer Profile Update Successfull';
       return redirect('/User_pagess')->withErrors(['msg' =>$mess]);
    }
    
    public function Profile_update(Request $request){
        $data = new Admin();
        $data = $data->find($request->id);
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->gender = $request->gender;
        $data->save();
        $mess = 'Profile Update Successfull';
       return redirect()->back()->withErrors(['msg' =>$mess]);
    }
    
    public function Reset_password(Request $request, $id){
        return view('useradmin.reset_pass', ['id'=>$id]);
    }
    
    public function Reset_Agent_password(Request $request){
        if($request->new_password == $request->confirm_password){
            $data = new Agent();
            $data = $data->find($request->id);
            $data->password = Hash::make($request->new_password);
            $data->plen_pass = $request->new_password;
            $data->save();
             $mess = 'Reset Password Successfull';
            return redirect('/agent_pages')->withErrors(['msg' =>$mess]); 
        }else{
            $mess = 'Don\'t match New Password and Confirm Password';
            return redirect()->back()->withErrors(['msg' =>$mess]); 
        }
        dd($request->all());
        return view('useradmin.reset_pass', ['id'=>$id]);
    }
    
    public function userOnlineStatus(){
         $users = Admin::all();
        foreach ($users as $user) {
            if (Cache::has('user-online' . $user->id))
                echo $user->name . " is online. <br>";
            else
                echo $user->name . " is offline <br>";
        }
    }
    
    public function Agent_document(Request $request, $id){
        $data = new Agent();
        $data = $data->find($id);
        $image = $data->image;
        if($image == null){
            $mess = 'Document Not Available';
            return redirect()->back()->withErrors(['msg' =>$mess]);
        }else{
            $document = json_decode( $image  , true);
            // $document = $image;
            return view('useradmin.agentUser_doc', ['document'=>$document]);
        }
        dd('');
    }
    public function AgentD(){
        return view('useradmin.agentUser_doc');
    }
}
