<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Stylist;
use App\Models\Reservation;
use App\Http\Services\AnalyzeService;
use Illuminate\Support\Carbon;

class AnalyzeController extends Controller
{
    private $analyzeService;

    public function __construct(AnalyzeService $analyzeService) {
        $this->analyzeService = $analyzeService;
    }

    public function index(Request $request)
    {
        $stylists = Stylist::where('shop_id', $request->shop)->get();
        $users = Reservation::with(['user'])
            ->where('shop_id', $request->shop)
            ->get()
            ->pluck('user')
            ->unique();

        return Inertia::render('Admin/Shop/Analyze/Index', compact('stylists', 'users'));
    }

    public function analyze(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        if (Carbon::parse($start)->gt(Carbon::parse($end))) {
            return redirect()->route('admin.analyze.index', ['shop' => $request->shop]);
        }
        $stylists = Stylist::where('shop_id', $request->shop)->get();
        $users = Reservation::with(['user'])
            ->where('shop_id', $request->shop)
            ->get()
            ->pluck('user')
            ->unique();
        if ($start && $end) {
            [$labels, $amounts, $amountAll] = $this->analyzeService->analyzeByStylistId($request->shop, $request->stylist_id, $start, $end);
            [$userLabels, $userAmounts, $counts] = $this->analyzeService->analyzeByUser($request->shop, $start, $end);

            return Inertia::render('Admin/Shop/Analyze/Index', compact(
                'labels',
                'amounts',
                'userLabels',
                'amountAll',
                'userAmounts',
                'start',
                'end',
                'stylists',
                'users'
            ));
        }
        return redirect()->route('admin.analyze.index', ['shop' => $request->shop]);
    }
}