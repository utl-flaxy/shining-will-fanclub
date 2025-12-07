<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    public function create(array $input)
    {
        Validator::make($input, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();

        // ⭐ ユーザー作成
        $user = User::create([
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        // ⭐ デフォルトロール付与
        $user->assignRole('user');

        return $user;
    }
}
