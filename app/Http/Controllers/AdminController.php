<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Visit;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Exceptions\InvalidFormatException;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Hitung total data
            $userCount = User::count();
            $categoryCount = Category::count();
            $productCount = Product::where('is_verified', true)->count();
            $latestUsers = User::orderBy('created_at', 'desc')->take(5)->get();
            $totalSellers = Seller::count();

            // Statistik kunjungan
            $totalVisits = Visit::count();
            $todayVisits = Visit::whereDate('created_at', Carbon::today())->count();
            $weeklyVisits = Visit::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
            $monthlyVisits = Visit::whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count();

            // Kunjungan bulan lalu
            $lastMonthVisits = Visit::whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

            // Hitung persentase perubahan kunjungan dari bulan sebelumnya
            $percentChangeVisits = $lastMonthVisits == 0 ? 0 : (($monthlyVisits - $lastMonthVisits) / $lastMonthVisits) * 100;

            // Filter data kunjungan
            $filter = $request->input('filter', 'monthly');
            $visitQuery = Visit::query();

            if ($filter === 'today') {
                $visitQuery->whereDate('created_at', Carbon::today());
            } elseif ($filter === 'this_week') {
                $visitQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($filter === 'this_month') {
                $visitQuery->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->month);
            } elseif ($filter === 'monthly') {
                $endDate = Carbon::today()->endOfDay(); // Akhir hari ini
                $startDate = Carbon::today()->subMonths(11)->startOfMonth();
                $visitQuery->whereBetween('created_at', [$startDate, $endDate]);
            } elseif ($filter === 'custom_range') {
                $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
                $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
                $visitQuery->whereBetween('created_at', [$startDate, $endDate]);
            }

            // Grouping data kunjungan
            $visitLabels = [];
            $visitData = [];

            $visits = $visitQuery->get()->groupBy(function ($date) use ($filter) {
                if ($filter === 'today' || $filter === 'this_week') {
                    Carbon::setLocale('id');
                    return Carbon::parse($date->created_at)->translatedFormat('l'); // Hari dalam seminggu dengan terjemahan bahasa Indonesia
                } elseif ($filter === 'this_month' || $filter === 'monthly' || $filter === 'custom_range') {
                    Carbon::setLocale('id');
                    if ($filter === 'this_month') {
                        return Carbon::parse($date->created_at)->translatedFormat('d F y'); // Tanggal dan bulan
                    } else {
                        return Carbon::parse($date->created_at)->translatedFormat('F'); // Bulan
                    }
                }
            });

            foreach ($visits as $key => $value) {
                if ($filter === 'custom_range') {
                    Carbon::setLocale('id');
                    $visitLabels[] = Carbon::parse($key)->translatedFormat('Y-m-d'); // Atur format tanggal sesuai kebutuhan
                } else {
                    $visitLabels[] = $key;
                }
                $visitData[] = $value->count();
            }

            $mostViewedProducts = Product::orderByDesc('views_count')
                ->take(5) // Ambil lima produk teratas
                ->get();

            // Hitung persentase perubahan dari bulan sebelumnya
            $lastMonthUserCount = User::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
            $percentChangeUsers = $lastMonthUserCount == 0 ? 0 : (($userCount - $lastMonthUserCount) / $lastMonthUserCount) * 100;

            $lastMonthProductCount = Product::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
            $percentChangeProducts = $lastMonthProductCount == 0 ? 0 : (($productCount - $lastMonthProductCount) / $lastMonthProductCount) * 100;

            return view('dashboard.admin.index', compact(
                'userCount',
                'totalSellers',
                'categoryCount',
                'productCount',
                'mostViewedProducts',
                'latestUsers',
                'totalVisits',
                'todayVisits',
                'weeklyVisits',
                'monthlyVisits',
                'visitLabels',
                'visitData',
                'filter',
                'percentChangeUsers',
                'percentChangeProducts',
                'percentChangeVisits'
            ));
        } catch (InvalidFormatException $e) {
            // Handle date parsing errors here
            flash()->error('Invalid date format. Please enter dates in valid format.');
            return back()->withErrors(['error' => 'Invalid date format. Please enter dates in valid format.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
