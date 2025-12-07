@extends('layouts.app')

@section('title', 'アイテム一覧')

@section('content')
<div class="container py-4">

    <h1 class="mb-4 fw-bold" style="font-size:24px;">アイテム一覧</h1>

    @if ($items->isEmpty())
        <div class="text-center text-muted py-5">商品がまだありません</div>
    @endif

    <div class="row g-4">
        @foreach ($items as $item)
            <div class="col-6 col-md-3">
                <a href="#" class="text-decoration-none">
                    <div class="card shadow-sm border-0" style="border-radius:14px; overflow:hidden">
                        <div style="width:100%;height:170px;background:#f1f1f5;">
                            @if ($item->image_path)
                                <img src="{{ asset('storage/'.$item->image_path) }}"
                                     style="width:100%;height:100%;object-fit:cover;">
                            @endif
                        </div>

                        <div class="p-2">
                            <div class="fw-bold text-dark" style="font-size:14px;">
                                {{ $item->title }}
                            </div>

                            <div class="text-muted" style="font-size:12px;">
                                {{ $item->talent?->name ?? '全体向け' }}
                            </div>

                            <div class="fw-bold mt-1 text-primary">
                                ¥{{ number_format($item->price) }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
