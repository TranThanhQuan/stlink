<?php

namespace App\Http\Controllers\Admin;

use App\Models\Link;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
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
                    'status' => $link->status,
                    'created_at' => Carbon::parse($link->created_at)->format('d/m/Y H:i:s'),
                ];
            });

        // Đếm số lượng từng trạng thái
        $statusCounts = Link::selectRaw("status, COUNT(*) as count")
        ->groupBy('status')
        ->pluck('count', 'status')
        ->toArray(); // Chuyển sang mảng

        // Đảm bảo luôn có đủ các trạng thái (nếu không có thì mặc định là 0)
        $statusCounts = array_merge([
        'active' => 0,
        'disabled' => 0,
        'expired' => 0,
        ], $statusCounts);

        return Inertia::render('Admin/Link/Index', [
        'links' => $links,
        'statusCounts' => $statusCounts, // Trả về trực tiếp mà không cần check từng key
        ]);
    }




    public function store(Request $request) {
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'short_code' => 'required|string|max:50|unique:links,short_code',
            'original_link' => 'required',
            'endDate' => 'nullable|date|after:today',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'short_code.required' => 'Vui lòng nhập Halfback.',
            'short_code.unique' => 'link rút gọn đã tồn tại!',
            'original_link.required' => 'Vui lòng nhập link gốc.',
            'original_link.url' => 'link không hợp lệ.',
            'endDate.date' => 'Ngày hết hạn không hợp lệ.',
            'endDate.after' => 'Ngày hết hạn phải lớn hơn hôm nay.',
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
        $link->status = 'active';
        $link->expires_at = $request->endDate;

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
            'short_code' => "required|string|max:50|unique:links,short_code,$id",
            'original_link' => 'required',
            'endDate' => 'nullable|date|after:today',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'short_code.required' => 'Vui lòng nhập Halfback.',
            'short_code.unique' => 'Link rút gọn đã tồn tại!',
            'original_link.required' => 'Vui lòng nhập link gốc.',
            'original_link.url' => 'Link không hợp lệ.',
            'endDate.date' => 'Ngày hết hạn không hợp lệ.',
            'endDate.after' => 'Ngày hết hạn phải lớn hơn hôm nay.',
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
        $link->expires_at = $request->endDate;

        $link->save();

        return redirect()->route('admin.links.index')->with('success', 'Cập nhật link thành công!');
    }

    public function destroy($id){
        $link = Link::findOrFail($id);
        $link->delete();
        return redirect()->route('admin.links.index')->with('success', 'Xóa link thành công!');
    }



    public function view($id){
        return 'chi tiết link id = '. $id;
    }

}
