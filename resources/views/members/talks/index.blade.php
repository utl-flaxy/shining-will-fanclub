@extends('members.layouts.app')

@section('title', 'トーク')

@section('content')

<style>
.talk-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 16px 0;
}

.page-title {
    font-size: 20px;
    font-weight: 700;
    padding: 0 16px 12px;
}

.talk-card {
    display: flex;
    gap: 12px;
    padding: 14px 16px;
    background: #fff;
    border-bottom: 1px solid #eee;
    text-decoration: none;
    color: #111;
}

.talk-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #ddd;
}

.talk-main {
    flex: 1;
    min-width: 0;
}

.talk-name {
    font-size: 14px;
    font-weight: 600;
}

.talk-message {
    font-size: 13px;
    color: #666;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.talk-meta {
    text-align: right;
    font-size: 11px;
    color: #999;
}
</style>

<div class="talk-wrapper">

    <div class="page-title">トーク</div>

    @forelse($talks as $talk)
        <a href="{{ route('members.talks.show', $talk->id) }}" class="talk-card">
            <div class="talk-avatar"></div>

            <div class="talk-main">
                <div class="talk-name">{{ $talk->display_name_for_user }}</div>
                <div class="talk-message">
                    {{ $talk->latestMessage?->body ?? 'メッセージはまだありません' }}
                </div>
            </div>

            <div class="talk-meta">
                {{ $talk->latestMessage?->created_at?->format('H:i') }}
            </div>
        </a>
    @empty
        <p style="text-align:center;color:#777;">まだトークがありません</p>
    @endforelse

</div>

@endsection
