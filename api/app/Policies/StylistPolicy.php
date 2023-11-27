<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Stylist;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class StylistPolicy
{
    public function viewAny(Admin $admin): bool
    {
        return Auth::guard('admin')->check();
    }

    public function view(Admin $admin, Stylist $stylist, Shop $shop): bool
    {
        return Auth::guard('admin')->check()
            && $admin->id === $shop->admin_id
            && $stylist->shop_id === $shop->id;
    }

    public function create(Admin $admin): bool
    {
        return Auth::guard('admin')->check();
    }

    public function update(Admin $admin, Stylist $stylist, Shop $shop): bool
    {
        return Auth::guard('admin')->check()
            && $admin->id === $shop->admin_id
            && $stylist->shop_id === $shop->id;
    }

    public function delete(Admin $admin, Stylist $stylist, Shop $shop): bool
    {
        return Auth::guard('admin')->check()
            && $admin->id === $shop->admin_id
            && $stylist->shop_id === $shop->id;
    }
}
