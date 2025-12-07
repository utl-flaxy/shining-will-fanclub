@extends('admin.layouts.app')

@section('title', 'Watchdog監視')

@section('content')

    @include('components.admin.breadcrumbs', [
        'links' => [
            'ホーム' => route('admin.home'),
            'Watchdog監視' => null,
        ]
    ])

    <x-admin.page-header title="Watchdog監視" />

    {{-- フィルター & 件数 --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="fs-6 text-muted">
            NG件数: <strong>{{ $ngCount }}</strong> 件
        </div>

        <a href="{{ route('admin.watchdog.index', ['filter_ng' => $filterNg === 'on' ? 'off' : 'on']) }}"
           class="btn btn-sm filter-btn {{ $filterNg === 'on' ? 'btn-dark' : 'btn-outline-dark' }}">
            NGワード検出: {{ strtoupper($filterNg) }}
        </a>
    </div>

    <table class="admin-table table-list">
        <thead>
            <tr>
                <th>ID</th>
                <th>トーク名</th>
                <th>送信者</th>
                <th>メッセージ</th>
                <th>送信日時</th>
                <th class="text-center">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($messages as $msg)
                @php
                    $hasNg = false;
                    $highlighted = e($msg->message);

                    foreach ($ngWords as $word) {
                        if (stripos($msg->message, $word) !== false) {
                            $hasNg = true;
                        }
                        $highlighted = preg_replace(
                            '/' . preg_quote($word, '/') . '/iu',
                            '<span class="ng-word">' . $word . '</span>',
                            $highlighted
                        );
                    }
                @endphp

                <tr>
                    <td>{{ $msg->id }}</td>
                    <td>{{ $msg->talk?->name ?? '（削除済み）' }}</td>
                    <td>{{ $msg->user?->name ?? '不明ユーザー' }}</td>
                    <td>{!! $highlighted !!}</td>
                    <td>{{ $msg->created_at->format('Y/m/d H:i') }}</td>

                    {{-- 操作 --}}
                    <td class="text-center">
                        @if($hasNg)
                            <div class="action-buttons">
                                {{-- 削除 --}}
                                <form action="{{ route('admin.watchdog.delete', $msg->id) }}" method="POST"
                                      onsubmit="return confirm('このメッセージを削除しますか？')">
                                    @csrf @method('DELETE')
                                    <button class="btn delete-btn">削除</button>
                                </form>

                                {{-- BAN --}}
                                <form action="{{ route('admin.watchdog.ban', $msg->user_id) }}" method="POST"
                                      onsubmit="return confirm('このユーザーをBANしますか？')">
                                    @csrf
                                    <button class="btn ban-btn">BAN</button>
                                </form>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4 text-center">
        {{ $messages->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>

    {{-- CSS --}}
    <style>
        .ng-word {
            color: #ff2d55;
            font-weight: bold;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 6px;
        }

        .action-buttons .btn {
            min-width: 64px;
            text-align: center;
            padding: 4px 10px;
            font-size: 13px;
            border-radius: 6px;
        }

        .delete-btn {
            background-color: #ff6b6b;
            color: white !important;
            border: none;
        }

        .ban-btn {
            background-color: #111;
            color: white !important;
            border: none;
        }

        .filter-btn {
            padding: 5px 14px;
            border-radius: 8px;
            font-weight: 600;
        }
    </style>

@endsection
