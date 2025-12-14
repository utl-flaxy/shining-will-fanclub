<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\Talk;
use App\Models\TalkMessage;
use App\Models\Stamp;
use App\Models\PurchasedItem;

class TalkController extends Controller
{
    /**
     * トーク一覧
     */
    public function index()
    {
        $user = Auth::user();

        $talks = Talk::whereHas('members', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->whereNull('talent_id');
            })
            ->with(['latestMessage', 'talentMembers'])
            ->orderByDesc(
                TalkMessage::select('created_at')
                    ->whereColumn('talk_messages.talk_id', 'talks.id')
                    ->latest()
                    ->limit(1)
            )
            ->get()
            ->map(function ($talk) use ($user) {
                $talk->unread_count = TalkMessage::where('talk_id', $talk->id)
                    ->where('user_id', '!=', $user->id)
                    ->whereNull('read_at')
                    ->count();

                return $talk;
            });

        return view('members.talks.index', compact('talks'));
    }

    /**
     * トーク詳細
     */
    public function show($id)
    {
        $user = Auth::user();

        $talk = Talk::whereHas('members', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->whereNull('talent_id');
            })
            ->with(['messages.user', 'messages.stamp'])
            ->findOrFail($id);

        /** =========================
         * 未読 → 既読
         ========================= */
        TalkMessage::where('talk_id', $talk->id)
            ->where('user_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        /** =========================
         * 購入済みスタンプ取得
         ========================= */

        // ① 購入済みスタンプ商品の item_id
        $stampItemIds = PurchasedItem::where('user_id', $user->id)
            ->whereHas('item', function ($q) {
                $q->where('type', 'stamp');
            })
            ->pluck('item_id');

        // ② スタンプ取得
        $stamps = Stamp::whereIn('item_id', $stampItemIds)
            ->orderBy('sort_order')
            ->get();

        return view('members.talks.show', [
            'talk'     => $talk,
            'messages' => $talk->messages()->orderBy('created_at')->get(),
            'stamps'   => $stamps,
        ]);
    }

    /**
     * メッセージ送信（テキスト / 画像 / スタンプ）
     */
    public function send(Request $request, $id)
    {
        Log::info('Talk send request', [
            'payload' => $request->all(),
        ]);

        $request->validate([
            'message'  => 'nullable|string|max:1000',
            'stamp_id' => 'nullable|exists:stamps,id',
            'images'   => 'nullable|array|max:10',
            'images.*' => 'nullable|image|max:10240',
        ]);

        $userId   = Auth::id();
        $hasText  = $request->filled('message');
        $hasStamp = $request->filled('stamp_id');
        $hasImage = $request->hasFile('images');

        if (!$hasText && !$hasStamp && !$hasImage) {
            return redirect()->route('members.talks.show', $id);
        }

        /** ===== テキスト ===== */
        if ($hasText) {
            TalkMessage::create([
                'talk_id' => $id,
                'user_id' => $userId,
                'type'    => 'text',
                'message' => $request->message,
            ]);
        }

        /** ===== スタンプ ===== */
        if ($hasStamp) {
            TalkMessage::create([
                'talk_id'  => $id,
                'user_id'  => $userId,
                'type'     => 'stamp',
                'stamp_id' => $request->stamp_id,
            ]);
        }

        /** ===== 画像 ===== */
        if ($hasImage) {
            foreach ($request->file('images') as $image) {
                if (!$image) continue;

                $path = $image->store('talk_images', 'public');

                TalkMessage::create([
                    'talk_id'    => $id,
                    'user_id'    => $userId,
                    'type'       => 'image',
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('members.talks.show', $id);
    }
}
