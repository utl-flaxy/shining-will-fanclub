<div style="
    background:#FFD5D5;
    padding:12px 16px;
    font-size:18px;
    font-weight:700;
    text-align:center;
    position:relative;
    border-bottom:1px solid #f1f1f1;
">
    {{-- 戻るボタン --}}
    <a href="{{ $back ?? url()->previous() }}"
       style="position:absolute;left:16px;top:12px;color:#333;text-decoration:none;font-size:20px;">
        ←
    </a>

    {{ $title ?? '' }}
</div>
