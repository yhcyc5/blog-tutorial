<?php

namespace App\Http\Controllers;


use Request;
use Validator;
use Auth;
use App\Http\Requests\StoreBlogPostRequest;
use App\Post;
use Zoe\Repositories\PostRepository;
use Zoe\Repositories\UserRepository;
use Illuminate\Support\Facades\View;


class HomeController extends Controller
{

    protected $postRepository = null;
    protected $userRepository = null;

    public function __construct(
        PostRepository $postRepository,
        UserRepository $userRepository
    ) {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

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
        $user = $this->userRepository->getById($request['id']);
        $posts = $user->post()->get();

        return View::make('frontend/blog', ['id', $user->id])
            ->with('blogger_name', $user->name)
            ->with('posts', $posts);
    }

    public function show($post_id)
    {
        $post = $this->postRepository->getById($post_id);

        return View::make('frontend/show')
            ->with('author', $post->user->name)
            ->with('post', $post);
    }

    public function create()
    {
        return View::make('frontend/create')
            ->with('title', '新增文章');
    }

    public function store(StoreBlogPostRequest $request)
    {
        // dd($request);
        // $params = \Request::all();
        $params = $request->only(['title','content']);
        $this->postRepository->postCreate(Auth::user()->id, $params);

        return redirect(route('blog', ['id' => Auth::user()->id]));
    }

    public function edit($id)
    {
        $post = $this->postRepository->getById($id);

        return View::make('frontend/edit')
            ->with('user_name', Auth::user()->name)
            ->with('title', '編輯文章')
            ->with('post', $post);
    }

    public function update(Request $request, $id)
    {
        $params = $request::only(['title','content']);
        $this->postRepository->postUpdate($id, $params);

        return redirect(route('blog', ['id' => Auth::user()->id]));
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect(route('blog', ['id' => Auth::user()->id]));
    }
}
