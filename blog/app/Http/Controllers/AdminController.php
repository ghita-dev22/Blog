<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Categorie;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
            return view('admin.index', [
                'posts' => Post::without('categorie', 'tags')->latest()->get(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        
     return  $this->showPost();
        
    }
    
    public function edit(Post $post):View
    {
        return $this->showPost($post);
    }
    protected function showPost(Post $post = new Post):View
    {
        return view('admin.form', [
            'post'=>$post,
            'categories' => Categorie::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request):RedirectResponse
    {
       return $this->save($request->validated());
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        //
        return $this->save($request->validated(), $post);
    }

    
    protected function save(array $data, Post $post = null): RedirectResponse
    {
        //
        if (isset($data['thumbnail'])) {
            if (isset($post->thumbnail)) {
                Storage::delete($post->thumbnail);
            }
            $data['thumbnail'] = $data['thumbnail']->store('thumbnails');
        }

        $data['excerpt'] = Str::limit($data['content'], 150);

        $post = Post::updateOrCreate(['id' => $post?->id], $data);
        $post->tags()->sync($data['tag_id'] ?? null);

        return redirect()->route('posts.show', ['post' => $post])->withStatus(
            $post->wasRecentlyCreated ? 'Post publié !' : 'Post mis à jour !'
        );
    }
    public function destroy(Post $post)
    {
        Storage::delete($post->thumbnail);
        $post->delete();

        return redirect()->route('admin.index');
    }
}
