<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Collection;

class SidebarService
{
    public function getUsers(): Collection
    {
        return User::query()
            ->whereNot('id', auth()->id())
            ->inRandomOrder()
            ->limit(3)
            ->get(['id', 'name', 'username']);
    }
}
