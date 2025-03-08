<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pengguna;
use App\Models\DataKesehatan;
use Carbon\Carbon;
use App\Models\RiwayatKesehatan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
{
    // Default to the current month if no month is selected
    $selectedMonth = $request->input('month', Carbon::now()->month);

    // Get total admin count
    $totalAdmins = Admin::count();
    $bidanCount = Admin::where('hak_akses', 'Bidan')->count();
    $kaderCount = Admin::where('hak_akses', 'Kader')->count();
    $totalPengguna = Pengguna::count();
    $totalPemeriksaan = DataKesehatan::whereDate('tanggal_pemeriksaan', Carbon::today())->count();

    // Prepare data for the diabetes risk graph (weekly data)
    $chartData = [];
    $weeks = [];
    $riskData = [
        'Rendah' => [],
        'Sedang' => [],
        'Tinggi' => []
    ];

    // Get all health records for the selected month
    $healthData = DataKesehatan::whereMonth('tanggal_pemeriksaan', $selectedMonth)->get();

    // Check if there's any data for the selected month
    if ($healthData->isEmpty()) {
        $chartData = null; // No data for this month
    } else {
        // Loop through the weeks (week 1, week 2, week 3, week 4) and get the risk data
        for ($week = 1; $week <= 4; $week++) {
            // Calculate the start and end date for each week
            $startOfWeek = Carbon::now()->month($selectedMonth)->startOfMonth()->addWeeks($week - 1)->startOfWeek();
            $endOfWeek = $startOfWeek->copy()->endOfWeek();

            // Filter health data within the current week
            $weeklyData = $healthData->filter(function($item) use ($startOfWeek, $endOfWeek) {
                return Carbon::parse($item->tanggal_pemeriksaan)->between($startOfWeek, $endOfWeek);
            });

            // Calculate the risk count for each category (low, medium, high)
            $lowRiskCount = RiwayatKesehatan::whereIn('id_data', $weeklyData->pluck('id_data'))
                ->where('kategori_risiko', 'Rendah')
                ->count();

            $mediumRiskCount = RiwayatKesehatan::whereIn('id_data', $weeklyData->pluck('id_data'))
                ->where('kategori_risiko', 'Sedang')
                ->count();

            $highRiskCount = RiwayatKesehatan::whereIn('id_data', $weeklyData->pluck('id_data'))
                ->where('kategori_risiko', 'Tinggi')
                ->count();

            // Store the risk data for the current week
            $weeks[] = 'Minggu ' . $week;
            $riskData['Rendah'][] = $lowRiskCount;
            $riskData['Sedang'][] = $mediumRiskCount;
            $riskData['Tinggi'][] = $highRiskCount;
        }

        // Prepare the chart data to pass to the view
        $chartData = [
            'weeks' => $weeks,
            'data' => $riskData,
            'categories' => ['Rendah', 'Sedang', 'Tinggi']
        ];
    }

    // Return the dashboard view with the data
    return view('layouts.Dashboard.dashboard', compact(
        'totalAdmins', 
        'bidanCount', 
        'kaderCount', 
        'totalPengguna', 
        'totalPemeriksaan',
        'chartData' // Pass chartData to the view
    ));
}

}
