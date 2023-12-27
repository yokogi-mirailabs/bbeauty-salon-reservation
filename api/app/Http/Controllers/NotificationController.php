<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Shop;
use App\Http\Requests\Admin\Shop\StoreShopRequest;
use App\Http\Requests\Admin\Shop\UpdateShopRequest;
use App\Http\Requests\Admin\Shop\DestroyShopRequest;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        // dbに誰宛かのカラムを持たせる、今回は仮実装
        $notifications = Shop::find($request->shop)->admin->load('notifications')->notifications;
        return Inertia::render('Notification/Index', compact('notifications'));
    }
}
