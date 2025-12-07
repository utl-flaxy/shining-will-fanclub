@extends('talent.layouts.app')

@section('content')

<div style="max-width:480px;margin:0 auto;padding:16px;">

    <h2 style="font-size:18px;margin-bottom:12px;">🔔 通知</h2>

    @forelse($notifications as $notification)

        <a href="{{ route('talent.posts.show', $notification->data['post_id']) }}"
           style="
               display:block;
               background:#fff;
               border-radius:12px;
               padding:12px;
               margin-bottom:10px;
               text-decoration:none;
               color:#111;
               box-shadow:0 2px 6px rgba(0,0,0,.05);
           ">

            <div style="font-size:13px;font-weight:bold;">
                {{ $notification->data['from_user_name'] }} さんからコメント
            </div>

            <div style="font-size:13px;color:#555;margin-top:4px;">
                {{ $notification->data['comment_body'] }}
            </div>

            <div style="font-size:11px;color:#999;margin-top:6px;">
                {{ $notification->created_at->diffForHumans() }}
            </div>
        </a>

    @empty
        <div style="color:#888;">通知はありません</div>
    @endforelse

</div>

@endsection
