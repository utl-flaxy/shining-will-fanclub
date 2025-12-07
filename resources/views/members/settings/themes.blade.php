@extends('members.layouts.app')

@section('content')

<x-members.header title="着せ替えテーマ" back="members.settings.index" />

<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h4 class="fw-bold mb-3">テーマを選択</h4>

    <div class="theme-grid">
        @foreach($themes as $theme)
            <form action="{{ route('members.settings.themes.apply') }}" method="POST" class="theme-item">
                @csrf

                <input type="hidden" name="theme_id" value="{{ $theme->id }}">

                {{-- 丸いカラー --}}
                <button class="theme-color-circle"
                        style="background-color: {{ $theme->color_hex }}">
                </button>

                <div class="theme-name">{{ $theme->name }}</div>

                @if($user->theme_id == $theme->id)
                    <div class="current">選択中</div>
                @endif
            </form>
        @endforeach
    </div>

</div>

<style>
.theme-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
    padding-top: 10px;
}

.theme-item {
    text-align: center;
}

.theme-color-circle {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
}

.theme-name {
    margin-top: 8px;
    font-size: 14px;
}

.current {
    margin-top: 5px;
    color: green;
    font-weight: bold;
}
</style>

@endsection
