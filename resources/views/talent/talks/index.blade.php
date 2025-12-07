@extends('talent.layouts.app')

@section('content')

<style>
/* ===== wrapper ===== */
.wrapper {
    max-width: 640px;
    margin: 0 auto;
    padding-bottom: 80px;
}

/* ===== header ===== */
.page-header {
    padding: 14px 16px;
    background: #fff;
    font-size: 18px;
    font-weight: 700;
    border-bottom: 1px solid #eee;
}

/* ===== room card ===== */
.room-card {
    background: #fff;
    padding: 14px 16px;
    display: flex;
    gap: 12px;
    align-items: center;
    border-bottom: 1px solid #eee;
    text-decoration: none;
    color: #111;
}

.room-card:active {
    background: #f3f4f8;
}

.avatar {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background: #dcdcec;
    flex-shrink: 0;
}

.room-main {
    flex: 1;
    min-width: 0;
}

.room-top {
    display: flex;
    justify-content: space-between;
    gap: 8px;
    align-items: center;
}

.room-name {
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.room-time {
    font-size: 11px;
    color: #888;
    flex-shrink: 0;
}

.room-message {
    font-size: 13px;
    color: #555;
    margin-top: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>

{{-- ヘッダー --}}
<div class="page-header">トーク</div>

<div class="wrapper">

    @forelse($rooms as $room)
        <a href="{{ route('talent.talks.show', $room->id) }}" class="room-card">

            {{-- アバター（仮） --}}
            <div class="avatar"></div>

            <div class="room-main">
                <div class="room-top">
                    <div class="room-name">
                        {{ $room->display_name_for_talent }}
                    </div>
                    <div class="room-time">
                        {{ optional($room->latestMessage)->created_at?->diffForHumans() }}
                    </div>
                </div>

                <div class="room-message">
                    {{ Str::limit($room->latestMessage->message ?? 'メッセージはありません', 30) }}
                </div>
            </div>

        </a>
    @empty
        <div style="padding:16px;color:#777;">
            トークはまだありません
        </div>
    @endforelse

</div>

@include('components.talent.nav')

@endsection
