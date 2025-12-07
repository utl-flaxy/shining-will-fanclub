@extends('admin.layouts.app')

@section('title', '基本設定')

@section('content')
    @include('components.admin.breadcrumbs', [
        'links' => [
            'ホーム' => route('admin.home'),
            '設定'   => route('admin.settings.index'),
            'トーク設定' => null,
        ]
    ])

    <x-admin.page-header title="トーク設定" />
    <p>※ テスト公開ではここはまだ「準備中」です。</p>
@endsection
