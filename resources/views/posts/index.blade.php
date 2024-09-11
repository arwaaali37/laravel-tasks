@extends('layout')

@section('content')
@php
    use Carbon\Carbon;
@endphp
    <div class="container mt-5">
        <h1>All Posts</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @auth
            <a href="{{ route('posts.create') }}" class="btn btn-success mb-3">Create Post</a>
        @endauth
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Slug</th> 
                    <th>Posted By</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->slug }}</td> 
                        <td>{{ $post->creator->name }}</td>
                        <td>
                            @if ($post->image)
                                <img src="{{ asset('images/' . $post->image) }}" alt="{{ $post->title }}" width="100">
                            @endif
                        </td>
                        <td>{{ $post->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info">View</a>
                            @auth
                            
                            @if(Gate::allows('update-post', $post))
                                  <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>
                            @endif

                            @can('delete', $post)
                              <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                @csrf
                                @method('DELETE')
                                 <button type="submit" class="btn btn-danger">Delete</button>
                               </form>
                            @endcan

                                @if($post->trashed())
                                    <form action="{{ route('posts.restore', $post->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">Restore</button>
                                    </form>
                                @endif
                            @endauth
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $posts->links() }}
    </div>
@endsection
