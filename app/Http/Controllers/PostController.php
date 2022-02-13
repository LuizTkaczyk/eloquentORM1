<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function forceDelete($post){
        Post::onlyTrashed()->where(['id' => $post])->forceDelete();
        return redirect()->route('posts.trashed');
    }

    public function restore($post){
        $post = Post::onlyTrashed()->where(['id' =>$post])->first();
        if($post->trashed()){
            $post->restore();
        }

        return redirect()->route('posts.trashed');
    }

    public function trashed(){
        $posts = Post::onlyTrashed()->get();
        return view('posts.trashed',['posts' => $posts]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //echo "Listagem de artigos";

        //$posts = Post::where('created_at', '<=', date('Y-m-d H:i:s'))->orderBy('title','asc')->get();
        // foreach ($posts as $post) {
        //     echo "<h1>{$post->title}</h1>";
        //     echo "<span>{$post->created_at}</span>";
        //     echo "<h2>{$post->subtitle}</h2>";
        //     echo "<p>{$post->description}</p>";
        //     echo "<hr>";
        // }

        //$posts = Post::where('created_at', '>=', date('Y-m-d H:i:s'))->first();
        //$posts = Post::where('created_at', '>=', date('3000-m-d H:i:s'))->firstOrFail();

        // echo "<h1>{$posts->title}</h1>";
        // echo "<span>{$posts->created_at}</span>";
        // echo "<h2>{$posts->subtitle}</h2>";
        // echo "<p>{$posts->description}</p>";
        // echo "<hr>";

        //dd($posts);

        // $posts = Post::find(1);
        // echo "<h1>{$posts->title}</h1>";
        // echo "<span>{$posts->created_at}</span>";
        // echo "<h2>{$posts->subtitle}</h2>";
        // echo "<p>{$posts->description}</p>";
        // echo "<hr>";

        //  $posts = Post::findOrFail(188);
        // echo "<h1>{$posts->title}</h1>";
        // echo "<span>{$posts->created_at}</span>";
        // echo "<h2>{$posts->subtitle}</h2>";
        // echo "<p>{$posts->description}</p>";
        // echo "<hr>";

        //$posts = Post::where('created_at', '>=', date('Y-m-d H:i:s'))->count();
        // foreach ($posts as $post) {
        //     echo "<h1>{$post->title}</h1>";
        //     echo "<span>{$post->created_at}</span>";
        //     echo "<h2>{$post->subtitle}</h2>";
        //     echo "<p>{$post->description}</p>";
        //     echo "<hr>";
        // }
        $posts = Post::where('created_at', '<=', date('Y-m-d H:i:s'))->orderBy('updated_at','desc')->get();
        return view('posts.index', ['posts' => $posts]);
        //dd($posts);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // //primeiro modo de salvar no banco de dados
        $post = new Post;
        $post->title = $request->title;
        $post->subtitle = $request->subtitle;
        $post->description = $request->description;
        $post->save();


        // //Segundo modo de salvar no banco de dados
        // Post::create([
        //     'title'=>$request->title,
        //     'subtitle'=>$request->subtitle,
        //     'description'=>$request->description
        // ]);
        

        //terceiro modo de salvar no banco de dados
        // $post = Post::firstOrNew([
        //     'title' => $request->title
        // ]);
        // dd($post);

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit',['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //primeira forma de salvar uma alteração
        $post = Post::find($post->id);
        $post->title = $request->title;
        $post->subtitle = $request->subtitle;
        $post->description = $request->description;
        $post->save();

        //segunda forma de salvar uma alteração( não achei viável :(  )
        // $post = Post::updateOrCreate([

        // ]);

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //primeira opção
        //Post::find($post->id)->delete();

        //segunda opção
        Post::destroy($post->id);

        return redirect()->route('posts.index');
    }
}
