<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Admin;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class ShopPolicy
{
    public function viewAny(Admin $admin): bool
    {
        return Auth::guard('admin')->check();
    }

    public function view(Admin $admin): bool
    {
        return Auth::guard('admin')->check();
    }

    public function create(Admin $admin): bool
    {
        return Auth::guard('admin')->check();
    }

    public function update(Admin $admin, Shop $shop): bool
    {
        return Auth::guard('admin')->check()
            && $shop->admin_id === $admin->id;
    }

    public function delete(Admin $admin, Shop $shop): bool
    {
        return Auth::guard('admin')->check()
            && $shop->admin_id === $admin->id;
    }
}
