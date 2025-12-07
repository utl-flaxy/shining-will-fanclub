@extends('admin.layouts.app')

@section('title', '商品一覧')

@section('content')

{{-- パンくず --}}
@include('components.admin.breadcrumbs', [
    'links' => [
        'ホーム' => route('admin.home'),
        '商品一覧' => null
    ]
])

{{-- ヘッダー --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title mb-0">商品一覧</h2>

    <a href="{{ route('admin.items.create') }}" class="btn btn-primary">
        ＋ 新規アイテム
    </a>
</div>

<style>
.item-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
}

.item-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.06);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    position: relative;
}

.item-thumb {
    width: 100%;
    height: 180px;
    object-fit: cover;
    background: #f3f4f6;
}

.item-body {
    padding: 14px;
    flex: 1;
}

.item-title {
    font-size: 15px;
    font-weight: 700;
    margin-bottom: 4px;
}

.item-price {
    font-size: 14px;
    color: #2563eb;
    font-weight: 600;
}

.item-meta {
    font-size: 12px;
    color: #6b7280;
    margin-top: 4px;
}

.item-status {
    position: absolute;
    top: 10px;
    right: 10px;
}

.item-actions {
    display: flex;
    gap: 6px;
    padding: 12px;
    border-top: 1px solid #eee;
    background: #fafafa;
}
</style>

{{-- 一覧 --}}
<div class="item-grid">

    @forelse($items as $item)

        <div class="item-card">

            {{-- 公開ステータス --}}
            <div class="item-status">
                @if($item->is_published)
                    <span class="badge bg-success">公開</span>
                @else
                    <span class="badge bg-secondary">非公開</span>
                @endif
            </div>

            {{-- 画像 --}}
            <div class="item-image">
                @if ($item->image_path)
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                @else
                    <div class="no-image">NO IMAGE</div>
                @endif
            </div>

            {{-- 本文 --}}
            <div class="item-body">
                <div class="item-title">{{ $item->name }}</div>

                <div class="item-price">
                    ¥{{ number_format($item->price) }}
                </div>

                <div class="item-meta">
                    作成日：{{ $item->created_at->format('Y/m/d') }}
                </div>
            </div>

            {{-- 操作 --}}
            <div class="item-actions">
                <a href="{{ route('admin.items.edit', $item) }}"
                   class="btn btn-sm btn-dark">
                    編集
                </a>

                <form action="{{ route('admin.items.destroy', $item) }}"
                      method="POST"
                      onsubmit="return confirm('本当に削除しますか？')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-sm btn-danger">
                        削除
                    </button>
                </form>
            </div>

        </div>

    @empty
        <div class="text-muted p-4">
            商品がまだ登録されていません
        </div>
    @endforelse

</div>

@endsection
