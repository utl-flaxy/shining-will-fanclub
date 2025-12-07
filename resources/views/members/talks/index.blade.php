{{-- resources/views/members/talks/index.blade.php --}}
@extends('members.layouts.app')

@section('content')

<style>
    .page-header {
        padding: 16px;
        background: #fff;
        font-size: 18px;
        font-weight: 700;
        border-bottom: 1px solid #e0e0ea;
    }

    .talk-wrapper {
        max-width: 480px;
        margin: 0 auto;
        padding-bottom: 90px;
        background: #f7f7fb;
        min-height: calc(100vh - 60px);
    }

    .talk-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        background: #fff;
        border-bottom: 1px solid #eee;
        text-decoration: none;
        color: #111;
    }

    .talk-card:hover {
        background: #fafafa;
    }

    .talk-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #ddd;
        flex-shrink: 0;
    }

    .talk-main {
        flex: 1;
        min-width: 0;
    }

    .talk-name {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
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
        min-width: 52px;
    }

    .unread-badge {
        display: inline-block;
        background: #ff4d4f;
        color: #fff;
        font-size: 10px;
        padding: 2px 8px;
        border-radius: 999px;
        margin-top: 4px;
    }
</style>

<div class="page-header">トーク</div>

<div class="talk-wrapper">

    @forelse($talks as $talk)
        <a href="{{ route('members.talks.show', $talk->id) }}" class="talk-card">

            {{-- アイコン（将来タレント画像） --}}
            <div class="talk-avatar"></div>

            {{-- メイン --}}
            <div class="talk-main">
                <div class="talk-name">
                    {{ $talk->display_name_for_user }}
                </div>

                <div class="talk-message">
                    {{ $talk->latestMessage?->body ?? 'メッセージはまだありません' }}
                </div>
            </div>

            {{-- 時刻・未読 --}}
            <div class="talk-meta">
                <div>
                    {{ $talk->latestMessage?->created_at?->format('H:i') ?? '' }}
                </div>

                @if(($talk->unread_count ?? 0) > 0)
                    <div class="unread-badge">
                        {{ $talk->unread_count }}
                    </div>
                @endif
            </div>

        </a>
    @empty
        <div style="padding:24px; text-align:center; color:#777;">
            まだトークがありません
        </div>
    @endforelse

</div>

{{-- 下部ナビ --}}
@include('components.members.nav')

@endsection
