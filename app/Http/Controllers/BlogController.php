<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    function __contructor(){
        $this->middleware('permission: ver-blog | crear-blog | editar-blog | borrar-blog', ['only' => 'index']);
        $this->middleware('permission: crear-blog', ['only' => 'create','store']);
        $this->middleware('permission: editar-blog', ['only' => 'edit','update']);
        $this->middleware('permission: borrar-blog', ['only' => 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::paginate(5);
        return view('blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blogs.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'titulo' => 'required',
            'contenido' => 'required'
        ]);
        Blog::create($request->all());
        return redirect()->route('blogs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        return view('blogs.editar', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        request()->validate([
            'titulo' => 'required',
            'contenido' => 'required'
        ]);
        $blog->update($request->all());
        return redirect()->route('blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blogs.index');
    }
}
