<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //      = select * from blogs
        $blogs = Blog::all();
        //dd($blogs);

        //          /blogs/index.blade.php
        return view('blogs.index')->with(compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blogs.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);

        //Method 1
        // $blog = new Blog();
        // $blog->title = $request->get('title');
        // $blog->body = $request->get('body');
        // $blog->save();

        //Method 2 - Mass Assignment

        $user = auth()->user();

        $blog = $user->blogs()->create($request->only('title','body'));

        // return view('blogs.index');
        return redirect()->route('blog:index')->with(['alert-type' => 'alert-success','alert'=> 'Your blog saved']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return view('blogs.show')-> with(compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
        return view('blogs.edit')-> with(compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        //
        $blog->update($request->only('title','body'));
        return redirect()->route('blog:index')->with(['alert-type' => 'alert-success','alert'=> 'Your blog updated']);
        dd($blog);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function padam(Blog $blog)
    {
        //
        $blog->delete();
        return redirect()->route('blog:index')->with(['alert-type' => 'alert-danger','alert'=> 'Your blog deleted']);

    }
}
