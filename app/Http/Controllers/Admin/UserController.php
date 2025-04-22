<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Group;
use App\Rules\ValidString;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page', 1);

        $users = User::with('group')->get();
        $groups = Group::all();

        return Inertia::render('Admin/User/Index', [ 'users' => $users, 'groups' => $groups]);
    }

    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'prefix'    => ['required', 'string', 'max:3', new ValidString('Tiền tố')],
            'isAdmin'   => 'required|boolean',
            'group_id'  => 'required|exists:groups,id',
            'status'    => 'required|boolean',
            'password'  => 'required|string|min:8',
        ],
        [
            'name.required'       => 'Vui lòng nhập tên.',
            'name.string'         => 'Tên phải là một chuỗi ký tự.',
            'name.max'            => 'Tên không được vượt quá 255 ký tự.',

            'email.required'      => 'Vui lòng nhập email.',
            'email.email'         => 'Email không đúng định dạng.',
            'email.unique'        => 'Email đã được sử dụng.',

            'prefix.required'     => 'Vui lòng nhập tiền tố.',
            'prefix.string'       => 'Tiền tố phải là một chuỗi.',
            'prefix.max'          => 'Tiền tố không được vượt quá 3 ký tự.',
            'prefix.unique'       => 'Tiền tố đã tồn tại.',

            'isAdmin.required'    => 'Vui lòng chọn vai trò.',
            'isAdmin.boolean'     => 'Giá trị vai trò không hợp lệ.',

            'group_id.required'   => 'Vui lòng chọn nhóm.',
            'group_id.exists'     => 'Nhóm đã chọn không tồn tại.',

            'status.required'     => 'Vui lòng chọn trạng thái.',
            'status.boolean'      => 'Giá trị trạng thái không hợp lệ.',

            'password.required'   => 'Vui lòng nhập mật khẩu.',
            'password.string'     => 'Mật khẩu phải là một chuỗi.',
            'password.min'        => 'Mật khẩu phải có ít nhất 8 ký tự.',
        ]);



        // Nếu có lỗi, trả về lỗi
        if ($validator->fails()) {
                return redirect()->route('admin.users.index')
                ->withErrors($validator);
        }
        // Tạo mới người dùng
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->prefix = $request->prefix;
        $user->group_id = $request->group_id;
        $user->status = 1;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Thêm người dùng thành công!');

    }



    public function update(Request $request, $id){
        // Tìm user cần cập nhật
        $user = User::findOrFail($id);

        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => "required|string|email|max:50|unique:users,email,$id",
            // 'prefix' => "required|string|max:3|unique:users,prefix,$id",
            'prefix' => ['required','string','max:3',"unique:users,prefix,$id",new ValidString('Tiền tố')],

            // 'isAdmin' => 'required|integer',
            'group_id' => 'required|integer',
            'password' => 'nullable|string|min:6'
        ], [
            'name.required' => 'Tên người dùng không được để trống!',
            'name.max' => 'Tên người dùng không được quá 255 kí tự!',
            'name.string' => 'Tên người dùng phải là 1 chuỗi!',

            'email.required' => 'Email không được để trống!',
            'email.string' => 'Email phải là 1 chuỗi!',
            'email.email' => 'Email không đúng định dạng!',
            'email.max' => 'Email không được quá 50 kí tự!',
            'email.unique' => 'Email này đã tồn tại!',

            // 'isAdmin.required' => 'Trường isAdmin không được để trống!',
            // 'isAdmin.integer' => 'Trường isAdmin phải là số nguyên!',
            'prefix.required'     => 'Vui lòng nhập tiền tố.',
            'prefix.string'       => 'Tiền tố phải là một chuỗi.',
            'prefix.max'          => 'Tiền tố không được vượt quá 3 ký tự.',
            'prefix.unique'       => 'Tiền tố đã tồn tại.',

            'group_id.required' => 'Trường nhóm không được để trống!',
            'group_id.integer' => 'Trường nhóm phải là số nguyên!',

            'password.string' => 'Mật khẩu phải là kiểu chuỗi!',
            'password.min' => 'Mật khẩu phải có ít nhất 6 kí tự!'
        ]);


        // Nếu có lỗi, quay lại trang trước với lỗi
        if ($validator->fails()) {
            return redirect()->route('admin.users.index')
                ->withErrors($validator);
        }

        // Cập nhật thông tin user

        $user->name =  $request->name;
        $user->email =  $request->email;
        if(!empty($request->password)){
            // nếu tồn tại thì tạo password còn không thì không thay đổi
            $user->password =  Hash::make($request->password);
        }
        $user->group_id =  $request->group_id;
        $user->prefix =  $request->prefix;
        $user->status =  $request->status;

        $user->save();
        return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công!');
    }

    function destroy($id){
        $user = User::findOrFail($id);
        // dd($user);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Xóa người dùng thành công!');
    }



}
