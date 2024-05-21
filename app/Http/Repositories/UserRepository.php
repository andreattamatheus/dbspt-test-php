<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserRepository
{
    protected string $user = User::class;

    public function getUserTasks($request): Collection
    {
        return $this->user::where('email', $request->email)->first()
            ->tasks()->orderBy('created_at', 'desc')->get();
    }
}
