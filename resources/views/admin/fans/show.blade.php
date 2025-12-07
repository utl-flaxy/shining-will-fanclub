{{-- resources/views/admin/fans/show.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'ファン詳細')

@section('content')

    {{-- パンくず --}}
    @include('components.admin.breadcrumbs', [
        'links' => [
            'ホーム'   => route('admin.home'),
            'ファン一覧' => route('admin.fans.index'),
            $fan->name => null,
        ]
    ])

    <x-admin.page-header :title="$fan->name . ' さんの詳細'" />

    <style>
        .fan-show-wrapper {
            max-width: 960px;
            margin: 0 auto;
        }

        .fan-main-card {
            display: flex;
            gap: 24px;
            padding: 20px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
            margin-bottom: 20px;
        }

        .fan-avatar-lg {
            width: 80px;
            height: 80px;
            border-radius: 999px;
            object-fit: cover;
            background: #e5e7eb;
        }

        .fan-basic {
            flex: 1;
        }

        .fan-name-lg {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .fan-email {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .fan-meta {
            font-size: 12px;
            color: #9ca3af;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            margin-right: 6px;
        }

        .badge-status.active {
            background: #dcfce7;
            color: #166534;
        }

        .badge-status.inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-role {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 11px;
            background: #e0f2fe;
            color: #0c4a6e;
            margin-right: 4px;
        }

        .fan-stat-card {
            padding: 16px 18px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
            margin-bottom: 16px;
        }

        .fan-stat-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .fan-stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 10px 18px;
            font-size: 13px;
        }

        .fan-stat-label {
            color: #6b7280;
            margin-right: 4px;
        }

        .fan-stat-value {
            font-weight: 600;
        }

        .section-title-small {
            font-size: 13px;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 6px;
        }
    </style>

    <div class="fan-show-wrapper">

        {{-- 基本情報 --}}
        <div class="fan-main-card">
            <div>
                <img
                    src="{{ $fan->avatar ? asset('storage/' . $fan->avatar) : asset('images/user_dummy.png') }}"
                    class="fan-avatar-lg"
                    alt="{{ $fan->name }}"
                >
            </div>

            <div class="fan-basic">
                <div class="fan-name-lg">{{ $fan->name }}</div>
                <div class="fan-email">{{ $fan->email }}</div>

                <div class="mb-2">
                    @if($fan->is_active_member)
                        <span class="badge-status active">有効会員</span>
                    @else
                        <span class="badge-status inactive">無効</span>
                    @endif

                    @foreach($fan->getRoleNames() as $role)
                        <span class="badge-role">{{ $role }}</span>
                    @endforeach
                </div>

                <div class="fan-meta">
                    会員登録日：
                    {{ optional($fan->created_at)->format('Y/m/d') ?? '-' }}
                </div>
            </div>
        </div>

        {{-- 会員ステータス・数値情報 --}}
        <div class="fan-stat-card">
            <div class="fan-stat-title">会員ステータス</div>

            <div class="fan-stat-grid">
                <div>
                    <span class="fan-stat-label">会員ランク：</span>
                    <span class="fan-stat-value">
                        {{ $fan->membership_level ?? '未設定' }}
                    </span>
                </div>

                <div>
                    <span class="fan-stat-label">ポイント：</span>
                    <span class="fan-stat-value">
                        {{ number_format($fan->points ?? 0) }} pt
                    </span>
                </div>

                <div>
                    <span class="fan-stat-label">購入アイテム数：</span>
                    <span class="fan-stat-value text-muted">
                        ―（未実装）
                    </span>
                </div>

                <div>
                    <span class="fan-stat-label">注文数：</span>
                    <span class="fan-stat-value text-muted">
                        ―（未実装）
                    </span>
                </div>
            </div>
        </div>

        {{-- メモ欄など追加したくなったらここにセクションを増やす --}}
        {{--
        <div class="fan-stat-card">
            <div class="section-title-small">管理メモ</div>
            <p class="text-muted mb-0">今後、運営メモなどをここに表示できます。</p>
        </div>
        --}}

    </div>

@endsection
