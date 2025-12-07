@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-6">

    <h1 class="text-xl font-bold mb-4">新規投稿</h1>

    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="font-semibold">タイトル</label>
            <input type="text" name="title" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="font-semibold">本文</label>
            <textarea name="body" class="w-full p-2 border rounded"></textarea>
        </div>

        <div class="mb-4">
            <label class="font-semibold">画像（任意）</label>
            <input type="file" name="image" class="w-full">
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            投稿する
        </button>
    </form>

</div>
@endsection
