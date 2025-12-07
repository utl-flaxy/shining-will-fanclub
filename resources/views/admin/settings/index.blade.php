@extends('admin.layouts.app')

@section('title', '設定')

@section('content')

    @include('components.admin.breadcrumbs', [
        'links' => [
            'ホーム' => route('admin.home'),
            '設定'   => null,
        ]
    ])

    <x-admin.page-header title="設定" />

    <style>
        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 16px;
            margin-top: 8px;
        }

        .settings-card {
            display: flex;
            align-items: center;
            padding: 14px 16px;
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            text-decoration: none;
        }

        /* ✅ 準備中カード */
        .settings-card.disabled {
            opacity: 0.55;
            cursor: not-allowed;
        }

        .settings-icon {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 20px;
            background: #f3f4ff;
        }

        .settings-text-main {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }

        .settings-text-sub {
            font-size: 12px;
            color: #6b7280;
            margin-top: 2px;
        }

        .settings-arrow {
            margin-left: auto;
            font-size: 16px;
            color: #9ca3af;
        }
    </style>

    <div class="settings-grid">

        {{-- 基本設定 --}}
        <div class="settings-card disabled">
            <div class="settings-icon">⚙️</div>
            <div>
                <div class="settings-text-main">基本設定</div>
                <div class="settings-text-sub">
                    サイト名・ロゴ・ブランドカラーなど（準備中）
                </div>
            </div>
            <div class="settings-arrow">›</div>
        </div>

        {{-- NGワード管理 --}}
        <div class="settings-card disabled">
            <div class="settings-icon">🚫</div>
            <div>
                <div class="settings-text-main">NGワード管理</div>
                <div class="settings-text-sub">
                    NGワードの追加・削除・インポート（準備中）
                </div>
            </div>
            <div class="settings-arrow">›</div>
        </div>

        {{-- BAN / 権限管理 --}}
        <div class="settings-card disabled">
            <div class="settings-icon">👮</div>
            <div>
                <div class="settings-text-main">BAN / 権限管理</div>
                <div class="settings-text-sub">
                    BANユーザー一覧・解除、権限の調整（準備中）
                </div>
            </div>
            <div class="settings-arrow">›</div>
        </div>

        {{-- 通知設定 --}}
        <div class="settings-card disabled">
            <div class="settings-icon">🔔</div>
            <div>
                <div class="settings-text-main">通知設定</div>
                <div class="settings-text-sub">
                    メール通知・テンプレート編集（準備中）
                </div>
            </div>
            <div class="settings-arrow">›</div>
        </div>

        {{-- メンテナンスモード --}}
        <div class="settings-card disabled">
            <div class="settings-icon">🩹</div>
            <div>
                <div class="settings-text-main">メンテナンスモード</div>
                <div class="settings-text-sub">
                    一時停止ページの表示設定（準備中）
                </div>
            </div>
            <div class="settings-arrow">›</div>
        </div>

        {{-- トーク設定 --}}
        <div class="settings-card disabled">
            <div class="settings-icon">💬</div>
            <div>
                <div class="settings-text-main">トーク設定</div>
                <div class="settings-text-sub">
                    画像送信・既読ON/OFF・1:1許可（準備中）
                </div>
            </div>
            <div class="settings-arrow">›</div>
        </div>

        {{-- 支払い設定 --}}
        <div class="settings-card disabled">
            <div class="settings-icon">💳</div>
            <div>
                <div class="settings-text-main">支払い設定</div>
                <div class="settings-text-sub">
                    Squareのキー・プラン金額など（準備中）
                </div>
            </div>
            <div class="settings-arrow">›</div>
        </div>

    </div>

@endsection
