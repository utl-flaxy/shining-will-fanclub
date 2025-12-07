{{-- resources/views/admin/watchdog/show.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Watchdog詳細')

@section('content')

    @include('components.admin.breadcrumbs', [
        'links' => [
            'ホーム'        => route('admin.home'),
            'Watchdog監視' => route('admin.watchdog.index'),
            '詳細'         => null,
        ]
    ])

    <x-admin.page-header title="Watchdog詳細" />

    <div class="card-box" style="background:#fff; padding:24px; border-radius:10px;">

        <table class="table-view">
            <tr>
                <th>ID</th>
                <td>{{ $message->id }}</td>
            </tr>
            <tr>
                <th>トーク名</th>
                <td>{{ $message->talk->name ?? '（削除済み）' }}</td>
            </tr>
            <tr>
                <th>送信者</th>
                <td>{{ $message->user->name ?? '不明ユーザー' }}</td>
            </tr>
            <tr>
                <th>メッセージ</th>
                <td>
                    @php
                        $highlight = preg_replace(
                            '/(' . implode('|', array_map('preg_quote', $ngWords)) . ')/iu',
                            '<span class="ng-word">$1</span>',
                            e($message->message)
                        );
                    @endphp

                    {!! $highlight !!}
                </td>
            </tr>
            <tr>
                <th>送信日時</th>
                <td>{{ $message->created_at->format('Y/m/d H:i') }}</td>
            </tr>
        </table>

        <div style="margin-top:20px; display:flex; gap:12px;">
            {{-- 戻る --}}
            <a href="{{ route('admin.watchdog.index') }}" class="btn btn-secondary">
                ← 戻る
            </a>

            {{-- メッセージ削除 --}}
            <form action="{{ route('admin.watchdog.delete', $message->id) }}" method="POST"
                  onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    メッセージ削除
                </button>
            </form>

            {{-- BANボタン --}}
            @if(!$message->user?->status || $message->user->status !== 'banned')
                <form action="{{ route('admin.watchdog.ban', $message->user->id) }}" method="POST"
                      onsubmit="return confirm('ユーザーをBANしますか？');">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        🚫 BANする
                    </button>
                </form>
            @else
                <span class="badge bg-danger" style="padding:8px 14px;">BAN済みユーザー</span>
            @endif
        </div>

    </div>


@endsection

<style>
    .ng-word {
        color: #ff2d55;
        font-weight: bold;
        background: #ffe6ea;
        padding: 2px 4px;
        border-radius: 4px;
    }
    .table-view th {
        background: #fafafa;
        width: 180px;
        font-weight: 600;
        padding: 10px;
        border-bottom: 1px solid #eee;
    }
    .table-view td {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }
</style>
