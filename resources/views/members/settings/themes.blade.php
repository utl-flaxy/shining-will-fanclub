@extends('members.layouts.app')

@section('content')

<style>
.page-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 24px 16px 120px;
}

.page-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 24px;
}

.flash-success {
    background: #e6f4ea;
    color: #1e7f4d;
    padding: 14px;
    border-radius: 12px;
    font-size: 13px;
    margin-bottom: 20px;
}

.theme-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
}

.theme-item {
    text-align: center;
}

.theme-color {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

.theme-name {
    margin-top: 8px;
    font-size: 13px;
}

.current {
    margin-top: 4px;
    font-size: 12px;
    color: #0a7d44;
    font-weight: 700;
}
</style>

<div class="page-wrapper">

    <div class="page-title">着せ替えテーマ</div>

    @if(session('success'))
        <div class="flash-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="theme-grid">
        @foreach($themes as $theme)
            <form method="POST"
                  action="{{ route('members.settings.themes.apply') }}"
                  class="theme-item">
                @csrf

                <input type="hidden" name="theme_id" value="{{ $theme->id }}">

                <button type="submit"
                        class="theme-color"
                        style="background-color: {{ $theme->color_hex }}">
                </button>

                <div class="theme-name">{{ $theme->name }}</div>

                @if($user->theme_id === $theme->id)
                    <div class="current">選択中</div>
                @endif
            </form>
        @endforeach
    </div>

</div>

@endsection
