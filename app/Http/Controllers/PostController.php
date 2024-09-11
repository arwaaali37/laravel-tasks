<?php

namespace App\Http\Controllers;
use App\Rules\NoPostKeyword;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Gate;
//use Carbon\Carbon;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $posts = Post::paginate(3);
    //     return view('posts.index', ["posts" => $posts]);
    // }

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
     {
        $posts = Post::withTrashed()->paginate(3); 
        return view('posts.index', ["posts" => $posts]);
     } 

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $users = Auth::user(); 
        
        return view('posts.create', compact('users'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        
        $validatedData = $request->validated();
    
       
        $post = new Post();
        $post->title = $validatedData['title'];
        $post->description = $validatedData['description'];
    
        
        $post->creator_id = auth()->id();  

        // $im_path = '';
        // if ($request->hasFile('image')) {
        //     $imageName = $request->file('image');
        //     $im_path = $imageName->store('posts','uploaded_files');

        // }
        // $post->image = $im_path;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $post->image = $imageName;
        }
    
        $post->save();
    
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {    
        $post = Post::findOrFail($id);
        return view('posts.show', ["post" => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if (Gate::denies('update-post', $post)) {
            return redirect()->route('posts.index')->with('error', 'Unauthorized action.');
        }

        return view('posts.edit', compact('post'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        if (Gate::denies('update-post', $post)) {
            return redirect()->route('posts.index')->with('error', 'Unauthorized action.');
        }

        $validatedData = $request->validated();
        $post->title = $validatedData['title'];
        $post->description = $validatedData['description'];

        if ($request->hasFile('image')) {
            if ($post->image && file_exists(public_path('images') . '/' . $post->image)) {
                unlink(public_path('images') . '/' . $post->image); 
            }

            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $post->image = $imageName;
        }

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        if ($post->image && file_exists(public_path('images') . '/' . $post->image)) {
            unlink(public_path('images') . '/' . $post->image); 
        }
        
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }


    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        return redirect()->route('posts.index')->with('success', 'Post restored successfully.');
    }

   

}




