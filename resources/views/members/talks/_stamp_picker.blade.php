{{-- resources/views/members/talks/_stamp_picker.blade.php --}}

<style>
.stamp-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
}

.stamp-btn {
    background: none;
    border: none;
    padding: 0;
}

.stamp-btn img {
    width: 64px;
    height: 64px;
    object-fit: contain;
    border-radius: 12px;
}

/* 空状態 */
.stamp-empty {
    text-align: center;
    color: #888;
    font-size: 13px;
    padding: 20px 0;
}
</style>

{{-- スタンプなし --}}
@if($stamps->isEmpty())
    <div class="stamp-empty">
        スタンプがありません<br>
        ショップでスタンプを購入できます
    </div>
@else
    <div class="stamp-grid">
        @foreach($stamps as $stamp)
            <form method="POST"
                  action="{{ route('members.talks.send', $talk->id) }}">
                @csrf
                <input type="hidden" name="stamp_id" value="{{ $stamp->id }}">

                <button type="submit" class="stamp-btn">
                    <img
                        src="{{ asset('storage/'.$stamp->image_path) }}"
                        alt="{{ $stamp->name }}">
                </button>
            </form>
        @endforeach
    </div>
@endif
