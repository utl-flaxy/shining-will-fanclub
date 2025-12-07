<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Talent;
use App\Models\Talk;
use App\Models\TalkMember;

class CreateDmForExistingUsers extends Command
{
    protected $signature = 'dm:create-for-existing-users';
    protected $description = '既存ユーザーにタレントDMを作成する';

    public function handle()
    {
        $users = User::whereDoesntHave('roles', fn($q) =>
            $q->where('name', 'talent')
        )->get();

        $talents = Talent::whereNotNull('user_id')->with('user')->get();

        foreach ($users as $user) {

            foreach ($talents as $talent) {

                if (!$talent->user) continue;

                // すでに DM があるかチェック
                $exists = Talk::whereHas('members', function ($q) use ($user, $talent) {
                    $q->where('user_id', $user->id);
                })->whereHas('members', function ($q) use ($talent) {
                    $q->where('talent_id', $talent->id);
                })->exists();

                if ($exists) continue;

                $talk = Talk::create([
                    'name'   => $talent->name . ' × ' . $user->name,
                    'type'   => 'dm',
                    'status' => 'open', // ← NEW USER と合わせる
                    'color'  => $talent->color ?? '#cfe1ff', // ← ここも統一しておく
                ]);

                TalkMember::create([
                    'talk_id'   => $talk->id,
                    'user_id'   => $talent->user->id,
                    'talent_id' => $talent->id,
                ]);

                TalkMember::create([
                    'talk_id'   => $talk->id,
                    'user_id'   => $user->id,
                    'talent_id' => null,
                ]);
            }
        }

        $this->info('✅ 既存ユーザーのDM作成が完了しました');
    }
}
