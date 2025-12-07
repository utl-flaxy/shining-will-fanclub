<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Models\Talk;
use App\Models\TalkMember;

class CreateDmForNewUser
{
    /**
     * ユーザー登録時にタレントとのDMトークを自動生成
     */
    public function handle(Registered $event): void
    {
        $user = $event->user;

        // 念のため型チェック
        if (! $user instanceof User) {
            return;
        }

        // 管理者やタレント自身登録の場合はスキップ
        if ($user->hasRole('admin') || $user->hasRole('talent')) {
            return;
        }

        // role=talent のユーザーを取得（talent リレーション付き）
        $talentUsers = User::role('talent')->with('talent')->get();

        foreach ($talentUsers as $talentUser) {
            $talent = $talentUser->talent; // App\Models\Talent|null

            // --- 既に同じ組み合わせのDMがあればスキップ ---
            $exists = Talk::whereHas('members', function ($q) use ($user) {
                    // 一般ユーザー側
                    $q->where('user_id', $user->id)
                      ->whereNull('talent_id');
                })
                ->whereHas('members', function ($q) use ($talentUser) {
                    // タレント側
                    $q->where('user_id', $talentUser->id)
                      ->whereNotNull('talent_id');
                })
                ->exists();

            if ($exists) {
                continue;
            }

            // --- Talk 作成 ---
            $talk = Talk::create([
                'name'   => ($talent->name ?? 'タレント') . ' × ' . $user->name,
                'type'   => 'dm',
                'status' => 'open',
                'color'  => $talent->color ?? '#cfe1ff',
            ]);

            // タレント側メンバー
            TalkMember::create([
                'talk_id'   => $talk->id,
                'user_id'   => $talentUser->id,
                'talent_id' => $talent?->id,
            ]);

            // 一般ユーザー側メンバー
            TalkMember::create([
                'talk_id'   => $talk->id,
                'user_id'   => $user->id,
                'talent_id' => null,
            ]);
        }
    }
}
