@extends('admin.layouts.app')

@section('title', 'スタンプ管理')

@section('content')

@include('components.admin.breadcrumbs', [
    'links' => [
        'ホーム' => route('admin.home'),
        '商品一覧' => route('admin.items.index'),
        $item->title . '（スタンプ）' => null,
    ]
])

<style>
.stamp-page { max-width:1100px; margin:0 auto; }
.stamp-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; }
.stamp-item-info { display:flex; gap:16px; align-items:center; }
.stamp-item-thumb { width:72px; height:72px; border-radius:14px; object-fit:cover; background:#f1f2f6; }

.add-stamp-box { background:#fff; border-radius:16px; padding:24px; margin-bottom:30px; }
.add-stamp-form { display:flex; gap:16px; align-items:center; }
.add-stamp-form input[type="file"] { display:none; }
.add-stamp-preview {
    width:64px; height:64px;
    background:#f3f4f6;
    border-radius:12px;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
}

.stamp-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(140px,1fr)); gap:20px; }
.stamp-card {
    background:#fff;
    border-radius:16px;
    padding:14px;
    text-align:center;
    box-shadow:0 4px 12px rgba(0,0,0,.06);
}
.stamp-img { width:96px; height:96px; object-fit:contain; margin-bottom:8px; }

.stamp-actions {
    display:flex;
    justify-content:center;
    gap:6px;
    margin-top:8px;
}
.stamp-actions button {
    border:none;
    background:#f3f4f6;
    border-radius:8px;
    padding:6px 10px;
    cursor:pointer;
}
</style>

<div class="stamp-page">

{{-- ===== ヘッダー ===== --}}
<div class="stamp-header">
    <div class="stamp-item-info">
        <img
            src="{{ $item->image_path ? asset('storage/'.$item->image_path) : asset('images/no_image.png') }}"
            class="stamp-item-thumb"
        >
        <div>
            <h2 class="page-title mb-1">{{ $item->title }}</h2>
            <div class="text-muted small">
                スタンプ商品 / ¥{{ number_format($item->price) }}
            </div>
        </div>
    </div>
</div>

{{-- ===== スタンプ追加 ===== --}}
<div class="add-stamp-box">
    <form method="POST"
          action="{{ route('admin.stamps.store', $item) }}"
          enctype="multipart/form-data"
          class="add-stamp-form">
        @csrf

        <label class="add-stamp-preview" for="stamp-image-input">＋</label>
        <input type="file"
               name="image"
               id="stamp-image-input"
               accept="image/*"
               required>

        <input type="text"
               name="name"
               placeholder="スタンプ名"
               required>

        <button class="btn btn-primary">
            追加
        </button>
    </form>
</div>

{{-- ===== スタンプ一覧 ===== --}}
@if($stamps->isEmpty())
    <div class="text-muted text-center py-5">
        まだスタンプがありません
    </div>
@else

<form method="POST" action="{{ route('admin.stamps.reorder', $item) }}">
@csrf

<div class="stamp-grid">
@foreach($stamps as $stamp)
    <div class="stamp-card">

        <img
            src="{{ asset('storage/'.$stamp->image_path) }}"
            class="stamp-img"
        >

        <div class="fw-bold small">
            {{ $stamp->name }}
        </div>

        {{-- 並び順 --}}
        <input type="hidden"
               name="orders[{{ $stamp->id }}]"
               value="{{ $stamp->sort_order }}">

        <div class="stamp-actions">
            <button type="button" onclick="moveUp(this)">↑</button>
            <button type="button" onclick="moveDown(this)">↓</button>
        </div>

        {{-- 削除は独立 form（超重要） --}}
        <form method="POST"
              action="{{ route('admin.stamps.destroy', [$item, $stamp]) }}"
              onsubmit="return confirm('削除しますか？')"
              style="margin-top:6px;">
            @csrf
            @method('DELETE')
            <button type="submit">🗑</button>
        </form>

    </div>
@endforeach
</div>

<div class="text-end mt-4">
    <button class="btn btn-primary">
        並び順を保存
    </button>
</div>

</form>
@endif

</div>

<script>
function moveUp(btn){
    const card = btn.closest('.stamp-card');
    const prev = card.previousElementSibling;
    if(prev) card.parentNode.insertBefore(card, prev);
}
function moveDown(btn){
    const card = btn.closest('.stamp-card');
    const next = card.nextElementSibling;
    if(next) card.parentNode.insertBefore(next, card);
}
</script>

@endsection
