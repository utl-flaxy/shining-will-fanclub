@extends('admin.layouts.app')

@section('title', 'ファン一覧')

@section('content')

@include('components.admin.breadcrumbs', [
    'links' => [
        'ホーム' => route('admin.home'),
        'ファン一覧' => null
    ]
])

<x-admin.page-header title="ファン一覧" />

<style>
    .fan-avatar {
        width: 36px;
        height: 36px;
        border-radius: 999px;
        object-fit: cover;
        background: #e5e7eb;
    }

    .fan-name {
        font-weight: 600;
        font-size: 14px;
    }

    .fan-email {
        font-size: 12px;
        color: #6b7280;
    }

    .badge-status {
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 999px;
        font-weight: 600;
    }

    .badge-status.active {
        background: #dcfce7;
        color: #166534;
    }

    .badge-status.inactive {
        background: #fee2e2;
        color: #991b1b;
    }
</style>

<table class="table table-striped align-middle mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>ユーザー</th>
            <th>会員状態</th>
            <th>登録日</th>
            <th style="width:120px;">操作</th>
        </tr>
    </thead>
    <tbody>
    @forelse($fans as $fan)
        <tr>
            <td>{{ $fan->id }}</td>

            <td>
                <div class="d-flex align-items-center gap-3">
                    <img
                        src="{{ $fan->avatar ? asset('storage/' . $fan->avatar) : asset('images/user_dummy.png') }}"
                        class="fan-avatar"
                    >
                    <div>
                        <div class="fan-name">{{ $fan->name }}</div>
                        <div class="fan-email">{{ $fan->email }}</div>
                    </div>
                </div>
            </td>

            <td>
                @if($fan->is_active_member)
                    <span class="badge-status active">有効</span>
                @else
                    <span class="badge-status inactive">無効</span>
                @endif
            </td>

            <td>{{ optional($fan->created_at)->format('Y/m/d') }}</td>

            <td>
                ✅
                <a href="{{ route('admin.fans.show', $fan->id) }}"
                   class="btn btn-sm btn-outline-primary">
                    詳細
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center text-muted">
                ファンがいません
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

@endsection
