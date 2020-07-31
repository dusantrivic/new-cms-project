<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    //
    public function index(){
        // $posts=auth()->user()->posts;
        $posts=auth()->user()->posts()->paginate(5);
        // $posts=Post::all();

        return view('admin.posts.index',['posts'=>$posts]);
    }
    public function show(Post $post){

        return view ('blog-post',['post'=>$post]);
    }
    public function create(){
        $this->authorize('create',Post::class);

        return view ('admin.posts.create');
    }
    public function store(Request $request){
        $this->authorize('create',Post::class);
        $inputs= request()->validate([
            'title'=>'required|min:8|max:255',
            'post_image'=>'file',
            'body'=>'required'
         ]);
         if (request('post_image')){
             $inputs['post_image']=request('post_image')->store('images');
         }
        //  dd($request->post_image);
         auth()->user()->posts()->create($inputs);
         Session::flash('post-created-message','Post '.$inputs['title'].' was created');
         return redirect()->route('post.index');
    }
    public function destroy(Post $post )
    {
        $this->authorize('delete',$post);
        $post->delete();
        Session::flash('message','Post was deleted');
        return back();
    }

    public function edit(Post $post){
        // $this->authorize('view',$post);
        // if(auth()->user()->can('view',$post)){}

        return view('admin.posts.edit',['post'=>$post]);
    }
    public function update(Post $post){
        $inputs= request()->validate([
            'title'=>'required|min:8|max:255',
            'post_image'=>'file',
            'body'=>'required'
         ]);
         if (request('post_image')){
            $inputs['post_image']=request('post_image')->store('images');
            $post->post_image=$inputs['post_image'];
        }
        $post->title=$inputs['title'];
        $post->body=$inputs['body'];
        $this->authorize('update',$post);
        $post->update();
        Session::flash('post-updated-message','Post was updated');

        return redirect()->route('post.index');
    }

    public function getImage($post_id)
    {
        $post = Post::findOrFail($post_id);
        $image = Storage::disk('')->get($post->post_image);

        return $image;

    }

}
