<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use App\Post;
use App\User;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return View::make('frontend/home')
            ->with('title', 'Hello Blog')
            ->with('posts', $posts);
    }

    public function index_single()
    {
        $request = Request::only(['id']);

        // 個人首頁
        $blog = User::where('id', $request['id'])->first();

        //$posts = Post::all();
        $posts = Post::where('creator_id', $blog->id)->get();
        return View::make('frontend/blog', ['id', $blog->id])
            ->with('blog', $blog)
            ->with('posts', $posts);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $blog = User::where('id', $post->creator_id)->first();
        return View::make('frontend/show')
            ->with('creator', $blog->name)
            ->with('post', $post);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('frontend/create')
            ->with('user', Auth::user())
            ->with('title', '新增文章');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $user = User::where('id', Auth::user()->id)->first();
        $input = Input::only(['title','content']);

        $post = new Post;
        $post->creator_id = $user->id;
        $post->title = $input['title'];
        $post->content = $input['content'];
        $post->save();
        return redirect(route('blog', ['id' => $user->id]));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return View::make('frontend/edit')
            ->with('user_name', Auth::user()->name)
            ->with('title', '編輯文章')
            ->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = Input::all();
        $post = Post::find($id);
        $post->title = $input['title'];
        $post->content = $input['content'];
        $post->save();
        return redirect(route('blog', ['id' => Auth::user()->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect(route('blog', ['id' => Auth::user()->id]));
    }
}
