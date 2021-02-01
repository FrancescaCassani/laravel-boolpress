<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Ottenere i nostri post
        $posts = Post::where('user_id', Auth::id())
               ->orderBy('created_at', 'desc')
               ->get();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate($this->ruleValidation());

        $data['user_id'] = Auth::id(); //attraverso FK creiamo slug
        $data['slug'] = Str::slug($data['title'], '-');

        $newPost = new Post();
        $newPost->fill($data);  //Fillable nel model
        $saved = $newPost->save();

        if ($saved) {
            return redirect()->route('admin.posts.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)  // ---> = $post = Post::find($id);
    {
        $data = $request->all();
        $request->validate($this->ruleValidation());

        $data['slug'] = Str::slug($data['title'], '-');
        $updated = $post->update($data); //fillable

        if($updated) {
            return redirect()->route('posts.show', $post->slug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $title = $post->title;
        $deleted = $post->delete();

        if ($deleted) {
            return redirect()->route('admin.posts.index')->with('post-deleted', $title);
        } else {
            return redirect()->route('admin.home');
        }
    }

    //Regole per la validazione
    private function ruleValidation() {
        return [
            'title' => 'required',
            'where' => 'required',
            'body' => 'required'
        ];
    }
}
