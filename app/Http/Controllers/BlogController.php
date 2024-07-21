<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogAuthenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BlogController extends Controller
{
    public function index(){
        if(session()->get('bloguser')){
            return view('blogs.blog-post');
        }else{
            return redirect('/blogauth');
        }
    }

    public function blogPost(Request $request){
        if(session()->get('bloguser')){
             $blogs = new Blog();
        $blog_desc =  $request->blog_desc;
        $blogs->blog_desc = $blog_desc;
        $blogs->status = '1';
        $blogs->forwagnistrip = '1';
        $blogs->save();
      
      
        // dd($blog);
       return redirect('/blog-posts');
        }else{
            return redirect('/blogauth');
        }
       
    }

    public function getdata(){
        if(session()->get('bloguser')){
            $blogs = new Blog();
            $data = $blogs->all();
            // foreach ($data as  $value) {
            //     $id = $value->id;
            //     $dd[] = collect(\DB::select('select * from blogImages where blogs_id = '.$id))->first();
            // }
            // die();
            return view('blogs.blogs-pages', ['data' =>$data]);
        }else{
            return redirect('/blogauth');
        }
       
    }

    public function show_blog_pages($id){
        if(session()->get('bloguser')){
        $blogs = new Blog();
        $data = $blogs->find($id);
        // $dd = DB::select('select * from blogImages where blogs_id = '.$id);
        return view('blogs.blogs_pages_details', ['data'=>$data]);
        }else{
            return redirect('/blogauth');
        }
    }

    public function edit_blog_pages($id){
        if(session()->get('bloguser')){
        $blogs = new Blog();
        $data = $blogs->find($id);
        return view('blogs.edit_blog_post', ['data'=>$data]);
        }else{
            return redirect('/blogauth');
        }
    }

    public function edit_blog_data(Request $request ,$id){
        if(session()->get('bloguser')){
        $blogs = new Blog();
        $data = $blogs->find($id);
        $data->blog_desc = $request->blog_desc;
        $data->save();
        return redirect('/blog-posts');
        }else{
            return redirect('/blogauth');
        }
    }

    public function blog_auth(){
        if(session()->get('bloguser')){
            return redirect('/blog-post');
        }else{
            return view('blogs.blogauth');
        }
    }

    public function blog_post_auth(Request $request){
          $blogAuth = new BlogAuthenticate();
           $data = $blogAuth->where('username', '=' , $request->username)->first();;
           if(Hash::check($request->password,$data->password)&& ($data->username== $request->username)){
            $request->session()->put('bloguser', $request->username);
            // dd('d');
             return redirect('/blog-post');
           }else{
            return redirect('/blogauth');
           }
        //   $blogAuth->username = $request->username;
        //   $blogAuth->password = Hash::make($request->password);
        //   $blogAuth->save();
    }

    public function bloglogout(Request $request){
        $request->session()->forget('bloguser');
        return redirect('/blogauth');
    }

    public function status(Request $request, $blog_id, $status_id){
        if(session()->get('bloguser')){
            $blogs = new Blog();
            $data = $blogs->find($blog_id);
            $data->status = $status_id;
            $data->save();
            return redirect('/blog-posts');
            }else{
                return redirect('/blogauth');
            }
    }

    public function blog_publish(){
        $blogs = new Blog();
            $data = $blogs->where('status', '=', '1')->orderBy('id','asc')->get();
            return view('pages.blogs-pages_blogs', ['data' =>$data]);
    }

    public function blog_show_publish(Request $request, $id){
        $blogs = new Blog();
        $data = $blogs->where('status','=','1')->find($id);
        return view('pages.blogs-pages_blogs_details', ['data' =>$data]);
    }

    public function forwagnistrip(Request $request, $blog_id, $status_id){
        if(session()->get('bloguser')){
            $blogs = new Blog();
            $data = $blogs->find($blog_id);
            $data->forwagnistrip = $status_id;
            $data->save();
            return redirect('/blog-posts');
            }else{
                return redirect('/blogauth');
            }
    }
    
     public function delete_blog_pages($id){
        $blogs = new Blog();
        $data = $blogs->find($id);
        $data->delete();
        return redirect('/blog-posts');
    } 
}
