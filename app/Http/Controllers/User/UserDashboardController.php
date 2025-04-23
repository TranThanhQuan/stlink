<?php

namespace App\Http\Controllers\User;

use DB;
use stdClass;
use Carbon\Carbon;
use App\Models\Link;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\ClickStatistic;
use App\Http\Controllers\Controller;

class UserDashboardController extends Controller
{
    public function index(Request $request){
        //khai báo biến data
        $user = auth()->user();
        $user_id = $user->id;

        $data = new stdClass();

        // đếm tổng lượt click của tất cả link theo user
        $totalClicks = ClickStatistic::where('user_id', $user_id)
            ->count();
        $data->totalClicks = $totalClicks;

        // lấy top os click nhiều nhất theo user
        $topOs = ClickStatistic::where('user_id', $user_id)
            ->select('os', \DB::raw('count(*) as total'))
            ->groupBy('os')
            ->orderBy('total', 'desc')
            ->limit(1)
            ->pluck('os')->first();
        $data->topOs = $topOs;

        // lấy top quốc gia (country) click nhiều nhất theo user
        $topCountry = ClickStatistic::where('user_id', $user_id)
            ->select('country', \DB::raw('count(*) as total'))
            ->groupBy('country')
            ->orderBy('total', 'desc')
            ->limit(1)
            ->pluck('country')->first();
        $data->topCountry = $topCountry;

        // lấy tổng số link của user
        $totalLinksByUser = Link::where('user_id', $user_id)
            ->count();
        $data->totalLinksByUser = $totalLinksByUser;

        $startDate = $request->startDate
            ? Carbon::parse($request->startDate)
            : Carbon::now()->subDays(7); // Lấy 7 ngày, tính cả hôm nay

        $endDate = $request->endDate
            ? Carbon::parse($request->endDate)
            : Carbon::now(); // Hôm nay

        $type = $request->type ?? 'clicks';

        // thống kê theo từng loại với link của user
        if ($type == 'clicks') {
            $clicks = ClickStatistic::select(\DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
                ->where('user_id', $user_id)
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
            ->where('user_id', $user_id)
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
                ->where('user_id', $user_id)
                ->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
                ->groupBy('country')
                ->orderBy('total', 'desc')
                ->pluck('total', 'country');
            $data->country = $countries;

        } else {
            return redirect()->route('user.links.index')->with('errors', 'Không có dữ liệu phù hợp!');
        }


        return Inertia::render('User/Dashboard', [
                'data' => $data
            ]);


    }
}
