@extends('talent.layouts.app')

@section('content')

<div style="padding:20px; max-width:480px; margin:0 auto; padding-bottom:90px;">

    {{-- タイトル --}}
    <h2 style="font-size:20px; font-weight:bold; margin-bottom:16px;">
        タレントホーム
    </h2>

    {{-- サブタイトル --}}
    <div style="font-size:13px; color:#666; margin-bottom:18px;">
        今日のアクション
    </div>

    {{-- ================================ --}}
    {{-- ファントーク --}}
    {{-- ================================ --}}
    <a href="{{ route('talent.talks.index') }}"
       style="
        display:flex;
        gap:12px;
        padding:16px;
        background:white;
        border-radius:16px;
        margin-bottom:12px;
        box-shadow:0 2px 8px rgba(0,0,0,0.05);
        text-decoration:none;
        color:black;
       ">
        <div style="width:48px;height:48px;background:#dce6ff;border-radius:14px;"></div>
        <div>
            <div style="font-weight:bold;">ファントーク</div>
            <div style="font-size:12px;color:#777;">
                ファンとのメッセージを見る
            </div>
        </div>
    </a>

    {{-- ================================ --}}
    {{-- 投稿管理 --}}
    {{-- ================================ --}}
    <a href="{{ route('talent.posts.index') }}"
       style="
        display:flex;
        gap:12px;
        padding:16px;
        background:white;
        border-radius:16px;
        margin-bottom:20px;
        box-shadow:0 2px 8px rgba(0,0,0,0.05);
        text-decoration:none;
        color:black;
       ">
        <div style="width:48px;height:48px;background:#ffe3dc;border-radius:14px;"></div>
        <div>
            <div style="font-weight:bold;">投稿管理</div>
            <div style="font-size:12px;color:#777;">
                投稿の作成・確認・削除
            </div>
        </div>
    </a>

    {{-- その他 --}}
    <div style="font-size:13px;color:#666;margin-bottom:10px;">
        その他
    </div>

    {{-- 設定（未実装） --}}
    <div style="
        display:flex;
        gap:12px;
        padding:16px;
        background:#f5f5f5;
        border-radius:16px;
        margin-bottom:12px;
        color:#999;
       ">
        <div style="width:48px;height:48px;background:#e0e0e0;border-radius:14px;"></div>
        <div>
            <div style="font-weight:bold;">設定（準備中）</div>
            <div style="font-size:12px;">
                今後実装予定
            </div>
        </div>
    </div>

</div>

{{-- ✅ 共通下部ナビ --}}
@include('components.talent.nav')

@endsection
