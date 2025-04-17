<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Link;
use App\Models\User;
use App\Models\ClickStatistic;
use Inertia\Inertia;
use App\Rules\ValidString;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class LinkController extends Controller
{

    public function index(Request $request)
    {
        $page = $request->input('page', 1);

        $links = Link::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page', $page) // Truyền tham số page vào paginate
            ->through(function ($link) {
                return [
                    'id' => $link->id,
                    'title' => $link->title,
                    'user_id' => $link->user_id,
                    'user' => [
                        'name' => $link->user->name ?? null,
                    ],
                    'short_code' => $link->short_code,
                    'original_url' => $link->original_url,
                    'expires_at' => $link->expires_at,

                    'status' => $link->expires_at < now() ? 'expired' : $link->status,
                    // 'created_at' => Carbon::parse($link->created_at)->format('d/m/Y H:i:s'),
                    'expires_at_format' => Carbon::parse($link->expires_at)->format('d/m/Y H:i:s'),

                ];
            });

            $statusCountsRaw = Link::selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

            // Gán mặc định
            $statusCounts = [
                'Công khai' => $statusCountsRaw[1] ?? 0,
                'Riêng tư' => $statusCountsRaw[0] ?? 0,
            ];

            // Đếm số lượng bản ghi đã hết hạn
            $expiredCount = Link::whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->count();

            // Thêm trạng thái "Hết hạn"
            $statusCounts['Hết hạn'] = $expiredCount;


        $userPrefix = auth()->user()->prefix;
        return Inertia::render('Admin/Link/Index', [
            'links' => $links,
            'statusCounts' => $statusCounts,
            'userPrefix' => $userPrefix,
        ]);
    }




    public function store(Request $request) {
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'short_code'    => ['required', 'string', 'max:50', 'unique:links,short_code' , new ValidString('Half-back')],
            'original_link' => 'required',
            'endDate' => 'nullable|date',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'short_code.required' => 'Vui lòng nhập Halfback.',
            'short_code.unique' => 'link rút gọn đã tồn tại!',
            'original_link.required' => 'Vui lòng nhập link gốc.',
            'original_link.url' => 'link không hợp lệ.',
            'endDate.date' => 'Ngày hết hạn không hợp lệ.',
            // 'endDate.after' => 'Ngày hết hạn phải lớn hơn hôm nay.',
        ]);

        // Nếu có lỗi, quay lại trang trước với lỗi
        if ($validator->fails()) {
            return redirect()->route('admin.links.index')
                ->withErrors($validator);
        }


        $url = $request->original_link;
        if (strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
            $url = "https://$url";
        }

        // Lưu link vào database
        $link = new Link();
        $link->title = $request->title;
        $link->user_id = auth()->user()->id;
        $link->short_code = $request->short_code;
        $link->original_url = $url;
        $status = filter_var($request->status, FILTER_VALIDATE_BOOLEAN); // ép về boolean trước khi kiểm tra
        $link->status = $status;
        $link->expires_at = Carbon::now()->addDays(30)->format('Y-m-d H:i');

        $link->save();

        return redirect()->route('admin.links.index')->with('success', 'Thêm link thành công!');
    }



    public function update(Request $request, $id)
    {
        // Tìm link cần cập nhật
        $link = Link::findOrFail($id);

        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'short_code' => ['required','string','max:50',"unique:links,short_code,$id",new ValidString('Half-back')],
            'original_link' => 'required',
            'status' => 'required',
            'endDate' => 'required|date',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'short_code.required' => 'Vui lòng nhập Halfback.',
            'short_code.unique' => 'Link rút gọn đã tồn tại!',
            'original_link.required' => 'Vui lòng nhập link gốc.',
            'original_link.url' => 'Link không hợp lệ.',
            'status.required' => 'Trạng thái không hợp lệ.',
            'endDate.required' => 'Vui lòng nhập ngày hết hạn.',
            'endDate.date' => 'Ngày hết hạn không hợp lệ.',

        ]);

        // Nếu có lỗi, quay lại trang trước với lỗi
        if ($validator->fails()) {
            return redirect()->route('admin.links.index')
                ->withErrors($validator);
        }

        $url = $request->original_link;
        if (strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
            $url = "https://$url";
        }

        // Cập nhật thông tin link
        $link->title = $request->title;
        $link->short_code = $request->short_code;
        $link->original_url = $url;
        $link->status = $request->status;
        $link->expires_at = $request->endDate;

        $link->save();

        return redirect()->route('admin.links.index')->with('success', 'Cập nhật link thành công!');
    }

    public function destroy($id){
        $link = Link::findOrFail($id);
        $link->delete();
        return redirect()->route('admin.links.index')->with('success', 'Xóa link thành công!');
        // return redirect()->back()->with('success', 'Xóa link thành công!');

    }



    public function view($id){
        $link = Link::findOrFail($id);
        $link->created_at_format = Carbon::parse($link->created_at)->format('d/m/Y H:i:s');
        $link->expired = Carbon::parse($link->expires_at)->gt(now()) ? 0 : 1;
        $link->expires_at = Carbon::parse($link->expires_at)->format('d/m/Y H:i:s');
        $link->username =  $link->user->name ?? null;

        return Inertia::render('Admin/Link/LinkDetail', [
                'link' => $link
            ]);
    }


    public function show(Request $request, $short_code)
    {
        $link = Link::where('short_code', $short_code)->first();

        if (!$link) {
            return Inertia::render('Errors/NotFound')->toResponse($request)->setStatusCode(404);
        }

        // Kiểm tra xem link đã hết hạn hay chưa
        if ($link->expires_at && Carbon::parse($link->expires_at)->isPast()) {
            return response()->json(['error' => 'Link đã hết hạn.'], 410);
        }
        // Kiểm tra xem link có bị khóa hay không
        if ($link->status == 0) {
            return Inertia::render('Errors/NotFound')->toResponse($request)->setStatusCode(404);
        }

        // Lấy User Agent
        $agent = $request->header('User-Agent');

        // Phân tích hệ điều hành, trình duyệt và nền tảng
        $os = $this->detectOS($agent);
        $browser = $this->detectBrowser($agent);
        $platform = $this->detectPlatform($agent);

        // Lấy IP và quốc gia
        $ip = $request->ip();
        $country = $this->getCountryFromIP($ip);

        // Lưu thông tin vào cơ sở dữ liệu
        $link->clickStatistics()->create([
            'ip_address' => $ip,
            'referrer' => $request->header('referer'),
            'os' => $os,
            'browser' => $browser,
            'platform' => $platform,
            'country' => $country,
        ]);

        // Chuyển hướng đến link gốc
        return redirect()->away($link->original_url);
    }





    private function detectOS($agent)
    {
        $oses = [
            'Windows' => 'Windows',
            'Macintosh' => 'Mac OS',
            'iPhone' => 'ios',
            'Android' => 'Android',
            'Linux' => 'Linux',
        ];

        foreach ($oses as $key => $os) {
            if (stripos($agent, $key) !== false) {
                return $os;
            }
        }

        return 'Unknown';
    }

    private function detectBrowser($agent)
    {
        $browsers = [
            'Chrome' => 'Chrome',
            'Firefox' => 'Firefox',
            'Safari' => 'Safari',
            'Edge' => 'Edge',
            'Opera' => 'Opera',
            'MSIE' => 'Internet Explorer',
        ];

        foreach ($browsers as $key => $browser) {
            if (stripos($agent, $key) !== false) {
                return $browser;
            }
        }

        return 'Unknown';
    }

    private function detectPlatform($agent)
    {
        if (preg_match('/mobile/i', $agent)) {
            return 'Mobile';
        } elseif (preg_match('/tablet/i', $agent)) {
            return 'Tablet';
        } else {
            return 'Desktop';
        }
    }

    private function getCountryFromIP($ip)
        {
            try {
                $response = Http::get("http://ip-api.com/json/{$ip}?fields=country");
                if ($response->ok()) {
                    return $response->json('country') ?? 'Unknown';
                }
            } catch (\Exception $e) {
                return 'Unknown';
            }

            return 'Unknown';
        }

}
