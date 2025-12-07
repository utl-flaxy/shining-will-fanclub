<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Talent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TalentController extends Controller
{
    /**
     * タレント一覧
     */
    public function index()
    {
        $talents = Talent::with('user')
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.talents.index', compact('talents'));
    }

    /**
     * 新規作成フォーム
     */
    public function create()
    {
        return view('admin.talents.create');
    }

    /**
     * タレント + ログインユーザー作成
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'color'    => 'nullable|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        DB::transaction(function () use ($validated) {
            // ログイン用ユーザー作成
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // タレント権限を付与
            $user->assignRole('talent');

            // タレント情報作成
            Talent::create([
                'name'    => $validated['name'],
                'color'   => $validated['color'] ?? null,
                'user_id' => $user->id,
            ]);
        });

        return redirect()
            ->route('admin.talents.index')
            ->with('success', 'タレントを追加しました');
    }

    /**
     * 編集フォーム
     */
    public function edit(Talent $talent)
    {
        // 既に talent ロールを持っているユーザーを候補として表示
        $talentUsers = User::role('talent')->orderBy('id', 'asc')->get();

        return view('admin.talents.edit', compact('talent', 'talentUsers'));
    }

    /**
     * 更新処理
     */
    public function update(Request $request, Talent $talent)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'color'   => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        DB::transaction(function () use ($validated, $talent) {
            // タレント本体更新
            $talent->update([
                'name'    => $validated['name'],
                'color'   => $validated['color'] ?? null,
                'user_id' => $validated['user_id'],
            ]);

            // 紐付けたユーザーに talent ロールを保証
            $user = User::find($validated['user_id']);
            if ($user && ! $user->hasRole('talent')) {
                $user->assignRole('talent');
            }
        });

        return redirect()
            ->route('admin.talents.index')
            ->with('success', '更新しました');
    }

    /**
     * 削除
     *
     * ※ ここではユーザーアカウント自体は削除しない（安全側）
     */
    public function destroy(Talent $talent)
    {
        $talent->delete();

        return redirect()
            ->route('admin.talents.index')
            ->with('success', '削除しました');
    }
}
