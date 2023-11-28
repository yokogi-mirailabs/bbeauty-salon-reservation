<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Menu;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class MenuPolicy
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

    public function update(Admin $admin, Menu $menu, Shop $shop): bool
    {
        return Auth::guard('admin')->check()
            && $admin->id === $shop->admin_id
            && $menu->shop_id === $shop->id;
    }

    public function delete(Admin $admin, Menu $menu, Shop $shop): bool
    {
        return Auth::guard('admin')->check()
            && $admin->id === $shop->admin_id
            && $menu->shop_id === $shop->id;
    }
}
