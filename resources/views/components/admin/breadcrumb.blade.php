{{-- resources/views/components/admin/breadcrumb.blade.php --}}
@props(['paths' => []])

<div class="admin-breadcrumbs">
    <nav aria-label="breadcrumb">
        <ol class="admin-breadcrumb-list">
            @foreach ($paths as $label => $url)
                <li class="admin-breadcrumb-item">
                    @if ($loop->last)
                        <span class="current">{{ $label }}</span>
                    @else
                        <a href="{{ $url }}">{{ $label }}</a>
                        <span class="separator">›</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
</div>
