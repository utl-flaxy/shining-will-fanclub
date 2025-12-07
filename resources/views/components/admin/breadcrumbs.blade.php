{{-- resources/views/components/admin/breadcrumbs.blade.php --}}
<div class="admin-breadcrumbs">
    <nav aria-label="breadcrumb">
        <ol class="admin-breadcrumb-list">
            @foreach ($links as $label => $url)
                <li class="admin-breadcrumb-item">
                    @if ($url)
                        <a href="{{ $url }}">{{ $label }}</a>
                        <span class="separator">›</span>
                    @else
                        <span class="current">{{ $label }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
</div>
