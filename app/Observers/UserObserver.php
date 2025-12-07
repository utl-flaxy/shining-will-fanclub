<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user)
    {
        // ここではDMは作らない (Listenerに集約)
        // role:user 付与済であれば特に不要な処理なし
        //return;
    }
}
