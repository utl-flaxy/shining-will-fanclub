@extends('admin.layouts.app')

@section('title', 'トーク管理')

@section('content')

@include('components.admin.breadcrumbs', [
    'links' => [
        'ホーム' => route('admin.home'),
        'トーク管理' => null,
    ]
])

<x-admin.page-header title="トーク管理" />

@if (session('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
@endif

<style>
    .talk-row {
        border-bottom: 1px solid #e5e7eb;
    }

    .talk-main {
        padding: 14px 0;
    }

    .talk-name {
        font-weight: 700;
        color: #111827;
        font-size: 14px;
    }

    .talk-sub {
        font-size: 12px;
        color: #6b7280;
        margin-top: 2px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
    }

    .status-open {
        background: #dcfce7;
        color: #166534;
    }

    .status-closed {
        background: #fee2e2;
        color: #991b1b;
    }

    .type-badge {
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 8px;
        background: #eff6ff;
        color: #1e40af;
        font-weight: 700;
    }

    .count-text {
        font-weight: 600;
        color: #374151;
    }

    .empty-text {
        padding: 48px;
        text-align: center;
        color: #6b7280;
    }
</style>

<div class="card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th style="width:70px;">ID</th>
                <th>トーク</th>
                <th style="width:90px;">種別</th>
                <th style="width:120px;">状態</th>
                <th style="width:120px;">メッセージ</th>
                <th style="width:110px;">操作</th>
            </tr>
            </thead>

            <tbody>
            @forelse($talks as $talk)
                <tr class="talk-row">
                    {{-- ID --}}
                    <td class="text-muted">#{{ $talk->id }}</td>

                    {{-- トーク名 --}}
                    <td>
                        <div class="talk-main">
                            <div class="talk-name">
                                {{ $talk->display_name_admin }}
                            </div>
                            <div class="talk-sub">
                                更新：{{ $talk->updated_at?->format('Y/m/d H:i') }}
                            </div>
                        </div>
                    </td>

                    {{-- 種別 --}}
                    <td>
                        <span class="type-badge">
                            {{ strtoupper($talk->type) }}
                        </span>
                    </td>

                    {{-- ステータス --}}
                    <td>
                        @if($talk->status === 'open')
                            <span class="status-badge status-open">OPEN</span>
                        @else
                            <span class="status-badge status-closed">CLOSED</span>
                        @endif
                    </td>

                    {{-- メッセージ数 --}}
                    <td>{{ $talk->messages->count() }}件</td>

                    {{-- 操作 --}}
                    <td>
                        <a href="{{ route('admin.talks.show', $talk->id) }}"
                           class="btn btn-sm btn-outline-secondary">
                            詳細
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty-text">
                        トークが存在しません
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
