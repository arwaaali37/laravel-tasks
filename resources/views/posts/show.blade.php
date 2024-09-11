@extends('layout')

@section('content')
@php
    use Carbon\Carbon;
@endphp
    <div class="container mt-5">
        <h1>{{ $post->title }}</h1>
        <p>{{ $post->description }}</p>
        <p><strong>Posted By:</strong> {{ $post->creator->name }}</p>
        <p><strong>Created At:</strong> {{ $post->created_at->format('M d, Y') }}</p>
        @if ($post->image)
            <img src="{{ asset('images/' . $post->image) }}" alt="{{ $post->title }}" width="300">
        @endif
        <a href="{{ route('posts.index') }}" class="btn btn-primary mt-3">Back to Posts</a>
    </div>
@endsection
