<?php

namespace Blume\Modules\Admin\Controllers;

use Blume\Http\Controllers\Controller;
use Blume\Models\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin|editor', [
            'only' => ['index', 'show'],
        ]);

        $this->middleware('role:admin', [
            'only' => ['create', 'store', 'edit', 'update', 'destroy'],
        ]);
    }

    public function index()
    {
        $posts = Posts::all();

        return view('admin::posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin::posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Posts::create($validated);

        return redirect()->route('admin::posts.index');
    }

    public function show(Posts $post)
    {
        return view('admin::posts.show', compact('post'));
    }

    public function edit(Posts $post)
    {
        return view('admin::posts.edit', compact('post'));
    }

    public function update(Request $request, Posts $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $post->update($validated);

        return redirect()->route('admin::posts.index');
    }

    public function destroy(Posts $post)
    {
        $post->delete();

        return redirect()->route('admin::posts.index');
    }
}
