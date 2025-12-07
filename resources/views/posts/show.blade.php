@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-6">

    <h1 class="text-xl font-bold mb-2">{{ $post->title }}</h1>

    <p class="text-sm text-gray-500">
        {{ $post->user->name }} / {{ $post->created_at->format('Y-m-d H:i') }}
    </p>

    @if ($post->images->count())
        @foreach ($post->images as $img)
            <img src="{{ asset('storage/'.$img->path) }}" class="mt-4 rounded">
        @endforeach
    @endif

    <p class="mt-4 text-gray-700">
        {!! nl2br(e($post->body)) !!}
    </p>

</div>
@endsection
