@extends('admin.layouts.app')

@section('title', 'NGワード管理')

@section('content')
    @include('components.admin.breadcrumbs', [
        'links' => [
            'ホーム' => route('admin.home'),
            '設定'   => route('admin.settings.index'),
            'NGワード管理' => null,
        ]
    ])

    <x-admin.page-header title="NGワード管理" />

    <p>※ テスト公開ではここはまだ「準備中」です。</p>
@endsection
