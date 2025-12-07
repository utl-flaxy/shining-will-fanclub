<div style="background:#ffd8dd; padding:14px 0; text-align:center; position:relative;">

    {{-- 戻るボタン（←） --}}
    <a href="{{ route($back) }}"
       style="position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:20px; text-decoration:none; color:#333;">
        ←
    </a>

    {{-- タイトル --}}
    <span style="font-weight:bold; font-size:16px;">
        {{ $title }}
    </span>

</div>
