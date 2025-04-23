<?php

namespace App\Http\Controllers\Admin;

use DB;
use stdClass;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\ClickStatistic;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request){
        //khai báo biến data
        $data = new stdClass();

        // lấy tổng lượt clicks của tất cả link
        $data->totalClicks = ClickStatistic::count();

        // lấy top os click nhiều nhất
        $data->topOs = ClickStatistic::select('os', \DB::raw('count(*) as total'))
            ->groupBy('os')
            ->orderBy('total', 'desc')
            ->limit(1)
            ->pluck('os')->first();

        // lấy top quốc gia (country) click nhiều nhất
        $data->topCountry = ClickStatistic::select('country', \DB::raw('count(*) as total'))
            ->groupBy('country')
            ->orderBy('total', 'desc')
            ->limit(1)
            ->pluck('country')->first();

        // lấy tổng số link
        $data->totalLinks = ClickStatistic::distinct('link_id')->count('link_id');

        // lấy tổng số user
        // $totalUsers = ClickStatistic::distinct('user_id')->count('user_id');



        $startDate = $request->startDate
            ? Carbon::parse($request->startDate)
            : Carbon::now()->subDays(7); // Lấy 7 ngày, tính cả hôm nay

        $endDate = $request->endDate
            ? Carbon::parse($request->endDate)
            : Carbon::now(); // Hôm nay

        $type = $request->type ?? 'clicks';


        // kiểm tra loại (clicks, os, country) và lấy dữ liệu tương ứng của tất cả link

        if ($type == 'clicks') {
            $clicks = ClickStatistic::select(\DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
                ->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->pluck('total', 'date');
            $dates = [];
            for ($i = $startDate->diffInDays($endDate); $i >= 0; $i--) {
                $date = $startDate->copy()->addDays($i)->format('Y-m-d');
                $dates[$date] = $clicks->get($date, 0);
            }

            $data->clicks = $dates;
        } elseif ($type == 'os') {

            // Fetch OS statistics grouped by date and OS
            $stats = ClickStatistic::select(
                \DB::raw('DATE(created_at) as date'),
                'os',
                \DB::raw('count(*) as total')
            )
            ->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->groupBy('date', 'os')
            ->orderBy('date', 'asc')
            ->get();

            // Initialize the data structure
            $osData = [];
            $allOS = ClickStatistic::select('os')
                ->distinct()
                ->pluck('os')
                ->map(function ($os) {
                    return ucfirst(strtolower($os ?? 'Unknown')); // Normalize OS names
                })
                ->toArray();

            // Define all OS names (including default "Unknown")
            $defaultOS = ['Android', 'Ios', 'Unknown', 'Windows'];

            // Initialize dates with 0 values for all OS types
            for ($i = 0; $i <= $startDate->diffInDays($endDate); $i++) {
                $date = $startDate->copy()->addDays($i)->format('Y-m-d');
                $osData[$date] = array_fill_keys($defaultOS, 0); // Set default values for all OS types
            }

            // Populate the data with actual statistics
            foreach ($stats as $stat) {
                $date = $stat->date;
                $os = ucfirst(strtolower($stat->os ?? 'Unknown')); // Normalize OS names
                $total = $stat->total;

                // If the date exists in the osData array, update the corresponding OS data
                if (isset($osData[$date])) {
                    $osData[$date][$os] = $total;
                }
            }


            $data->os = $osData;


        } elseif ($type == 'country') {
            $countries = ClickStatistic::select('country', \DB::raw('count(*) as total'))
                ->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
                ->groupBy('country')
                ->orderBy('total', 'desc')
                ->pluck('total', 'country');
            $data->country = $countries;
        }else {
            return redirect()->route('admin.links.index')->with('errors', 'Không có dữ liệu phù hợp!');
        }
        return Inertia::render('Admin/Dashboard', [
                'data' => $data
            ]);


    }
}
