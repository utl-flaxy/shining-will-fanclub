@extends('admin.layouts.app')

@section('title', '基本設定')

@section('content')
    @include('components.admin.breadcrumbs', [
        'links' => [
            'ホーム' => route('admin.home'),
            '設定'   => route('admin.settings.index'),
            'BAN / 権限管理' => null,
        ]
    ])

    <x-admin.page-header title="BAN / 権限管理" />
    <p>※ テスト公開ではここはまだ「準備中」です。</p>
@endsection
