@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-6">

    <h1 class="text-xl font-bold mb-4">投稿一覧</h1>

    @foreach ($posts as $post)
        <div class="bg-white p-4 rounded shadow mb-4">
            <h2 class="text-lg font-semibold">
                <a href="{{ route('posts.show', $post) }}">
                    {{ $post->title }}
                </a>
            </h2>

            <p class="text-sm text-gray-500">
                {{ $post->user->name }} / {{ $post->created_at->format('Y-m-d H:i') }}
            </p>

            @if ($post->image_path)
                <img src="{{ asset('storage/'.$post->image_path) }}" class="mt-2 rounded">
            @endif
        </div>
    @endforeach

    {{ $posts->links() }}
</div>
@endsection
