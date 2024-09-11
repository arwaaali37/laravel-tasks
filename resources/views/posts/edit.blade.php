@extends('layout')

@section('content')
    <div class="container mt-5">
        <h1>Edit Post</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control">{{ old('description', $post->description) }}</textarea>
            </div>
            <div class="form-group">
            <input type="hidden" name="creator_id" value="{{ auth()->id() }}">
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control">
                @if ($post->image)
                    <img src="{{ asset('images/' . $post->image) }}" alt="{{ $post->title }}" width="100">
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
