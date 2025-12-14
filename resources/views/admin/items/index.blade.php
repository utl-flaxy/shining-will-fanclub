@extends('admin.layouts.app')

@section('title', '商品一覧')

@section('content')

@include('components.admin.breadcrumbs', [
    'links' => ['ホーム' => route('admin.home'), '商品一覧' => null]
])

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="page-title mb-0">商品一覧</h2>
    <a href="{{ route('admin.items.create') }}" class="btn btn-primary">＋ 新規アイテム</a>
</div>

{{-- ✅ 検索・フィルター（完成形） --}}
<form method="GET" action="{{ route('admin.items.index') }}" class="admin-filter card mb-4">
    <div class="admin-filter__inner">
        <div class="admin-filter__field">
            <label class="form-label">商品名</label>
            <input type="text" name="keyword" class="form-control"
                   value="{{ request('keyword') }}" placeholder="例：スタンプ / 時間テスト">
        </div>

        <div class="admin-filter__field">
            <label class="form-label">タイプ</label>
            <select name="type" class="form-select">
                <option value="">すべて</option>
                <option value="normal" @selected(request('type')==='normal')>通常</option>
                <option value="stamp" @selected(request('type')==='stamp')>スタンプ</option>
                <option value="theme" @selected(request('type')==='theme')>着せ替え</option>
            </select>
        </div>

        <div class="admin-filter__field">
            <label class="form-label">公開状態</label>
            <select name="is_active" class="form-select">
                <option value="">すべて</option>
                <option value="1" @selected(request('is_active')==='1')>公開</option>
                <option value="0" @selected(request('is_active')==='0')>非公開</option>
            </select>
        </div>

        <div class="admin-filter__field">
            <label class="form-label">販売状態</label>
            <select name="sale_status" class="form-select">
                <option value="">すべて</option>
                <option value="on_sale" @selected(request('sale_status')==='on_sale')>販売中</option>
                <option value="before" @selected(request('sale_status')==='before')>販売前</option>
                <option value="ended" @selected(request('sale_status')==='ended')>販売終了</option>
            </select>
        </div>

        <div class="admin-filter__buttons">
            <button class="btn btn-dark w-100">検索</button>
            <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary w-100">リセット</a>
        </div>
    </div>

    {{-- 何件ヒットしたか --}}
    <div class="admin-filter__result text-muted small">
        表示件数：<strong>{{ $items->count() }}</strong> 件
    </div>
</form>

<div class="admin-item-list">

@forelse($items as $item)
    <div class="admin-item-card">

        {{-- 画像 --}}
        <div class="item-image">
            @if($item->image_path)
                <img src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->title }}">
            @else
                <div class="no-image">NO IMAGE</div>
            @endif
        </div>

        {{-- 情報 --}}
        <div class="item-info">
            <div class="item-title">{{ $item->title }}</div>

            <div class="item-meta">
                <span class="badge bg-secondary">{{ $item->type_label }}</span>
                <span class="price">¥{{ number_format($item->price) }}</span>
            </div>

            <div class="item-status">
                <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">
                    {{ $item->is_active ? '公開' : '非公開' }}
                </span>

                @if($item->isOnSale())
                    <span class="badge bg-success">販売中</span>
                @elseif($item->isSaleEnded())
                    <span class="badge bg-dark">販売終了</span>
                @else
                    <span class="badge bg-warning text-dark">販売前</span>
                @endif
            </div>

            <div class="item-period">
                販売期間：
                {{ $item->sale_start_at?->format('Y/m/d H:i') ?? '—' }}
                〜
                {{ $item->sale_end_at?->format('Y/m/d H:i') ?? '—' }}
            </div>
        </div>

        {{-- 操作 --}}
        <div class="item-actions">
            <a href="{{ route('admin.items.edit', $item) }}?{{ http_build_query(request()->query()) }}"
               class="btn btn-sm btn-outline-primary">
                編集
            </a>

            @if($item->type === 'stamp')
                <a href="{{ route('admin.stamps.index', $item) }}?{{ http_build_query(request()->query()) }}"
                   class="btn btn-sm btn-outline-secondary">
                    スタンプ管理
                </a>
            @endif

            <form method="POST"
                  action="{{ route('admin.items.destroy', $item) }}?{{ http_build_query(request()->query()) }}"
                  onsubmit="return confirm('削除しますか？')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger">削除</button>
            </form>
        </div>

    </div>
@empty
    <p class="text-muted text-center">商品がまだありません</p>
@endforelse

</div>

{{-- ===== UI ===== --}}
<style>
/* --- Filter --- */
.admin-filter {
    padding: 16px;
    border-radius: 14px;
    border: 1px solid rgba(0,0,0,.06);
    box-shadow: 0 4px 12px rgba(0,0,0,.04);
}
.admin-filter__inner {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr 200px;
    gap: 12px;
    align-items: end;
}
.admin-filter__field .form-label { font-size: 12px; color: #666; margin-bottom: 6px; }
.admin-filter__buttons { display:flex; gap:10px; }
.admin-filter__result { margin-top: 10px; }

/* --- List --- */
.admin-item-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.admin-item-card {
    background: #fff;
    border-radius: 14px;
    padding: 16px;
    display: flex;
    gap: 16px;
    align-items: center;
    border: 1px solid rgba(0,0,0,.06);
    box-shadow: 0 6px 18px rgba(0,0,0,.05);
}

/* image */
.item-image img,
.no-image {
    width: 72px;
    height: 72px;
    border-radius: 12px;
    background: #f3f4f6;
}
.item-image img {
    object-fit: cover;
    display: block;
}
.no-image {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    color: #999;
}

/* info */
.item-info { flex: 1; min-width: 0; }
.item-title {
    font-weight: 800;
    margin-bottom: 6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.item-meta { display: flex; gap: 10px; align-items: center; margin-bottom: 8px; }
.price { font-weight: 700; }
.item-status { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 6px; }
.item-period { font-size: 12px; color: #666; }

/* actions */
.item-actions { display: flex; flex-direction: column; gap: 8px; min-width: 120px; }
.item-actions .btn { white-space: nowrap; }

/* Responsive */
@media (max-width: 1200px) {
    .admin-filter__inner { grid-template-columns: 1fr 1fr; }
    .admin-filter__buttons { grid-column: span 2; }
}
</style>

@endsection
