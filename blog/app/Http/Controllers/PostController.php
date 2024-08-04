<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected function postsView(array $filters)
    {
        return view('index', [
   
            'posts' => Post::filters($filters)->latest()->paginate(10),
        ]);
    }
    public function index(Request $request)
    {

      
        return $this->postsView($request->search ? ['search' => $request->search] : []);
    }
    public function show(Post $post){
        
        return view ('posts.show',compact('post'));
    }
    public function comment(Post $post,Request $request){
        $validated=$request->validate(
            [
               'comment' => 'required', 'string', 'between:2,255'
            ]
        );
        Comment::create([
            'content' => $validated['comment'],
            'post_id' => $post->id,
            'user_id' => Auth::id(),
        ]);

        return back()->withStatus('Commentaire publié !');
    }
    public function postsByCategorie(Categorie $categorie)
    {
        
        //'posts' => $categorie->posts()->latest()->paginate(10),
        return $this->postsView(['categorie' => $categorie]);
      
     
    }
    public function postsByTag(Tag $tag)
    {
        
        //'posts' => $categorie->posts()->latest()->paginate(10),
      
        return $this->postsView(['tag' => $tag]);
     
    }
}
