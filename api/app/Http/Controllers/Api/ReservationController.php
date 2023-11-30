<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Shop;
use App\Models\Reservation;
use App\Http\Requests\Admin\Shop\StoreShopRequest;
use App\Http\Requests\Admin\Shop\UpdateShopRequest;
use App\Http\Requests\Admin\Shop\DestroyShopRequest;
use App\Models\Stylist;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index(Request $request, Shop $shop)
    {
        $stylistId = $request->query('stylist');
        $reservations = Reservation::with(['paymentHistories.menu', 'user', 'shop'])
            ->where('shop_id', $shop->id)
            ->where('stylist_id', $stylistId)
            ->get();
        return response()->json([
            'reservations' => $reservations,
        ]);
    }
}
