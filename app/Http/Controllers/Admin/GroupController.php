<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Group;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{

    public function index(){
        $groups = Group::with('user')->get();

        return Inertia::render('Admin/Group/Index', [ 'groups' => $groups, ]);

    }

    public function store(Request $request) {
        // Validate dữ liệu đầu vào

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:groups,name',
            'isAdmin' => 'boolean',
        ], [
            'name.required' => 'Vui lòng nhập tiêu đề.',
            'name.string' => 'Tiêu đề phải là một chuỗi.',
            'name.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'name.unique' => 'Tiêu đề đã tồn tại.',
            'isAdmin.boolean' => 'Giá trị quyền quản trị không hợp lệ',
        ]);

        // Nếu có lỗi, quay lại trang trước với lỗi
        if ($validator->fails()) {
            return redirect()->route('admin.groups.index')
                ->withErrors($validator);
        }

        // lấy danh sách tên module
        $modules = Module::all();

        foreach ($modules as $module) {
            $moduleList[] = $module->name;
        }

        // lặp qua danh sách module và thêm mảng rỗng vào mảng phân quyền
        foreach ($moduleList as $module) {
            $permissionsArray[$module] = [];
        }

        // Lưu group vào database
        $group = new Group();
        $group->name = $request->name;
        $group->isAdmin = $request->isAdmin;
        $group->permissions = $permissionsArray;
        $group->save();

        return redirect()->route('admin.groups.index')->with('success', 'Thêm nhóm thành công!');
    }

    public function update($groupId, Request $request) {
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:groups,name,' . $groupId,
            'isAdmin' => 'boolean',
        ], [
            'name.required' => 'Vui lòng nhập tiêu đề.',
            'name.string' => 'Tiêu đề phải là một chuỗi.',
            'name.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'name.unique' => 'Tiêu đề đã tồn tại.',
            'isAdmin.boolean' => 'Giá trị quyền quản trị không hợp lệ',
        ]);

        // Nếu có lỗi, quay lại trang trước với lỗi
        if ($validator->fails()) {
            return redirect()->route('admin.groups.index')
                ->withErrors($validator);
        }

        // Cập nhật thông tin nhóm
        $group = Group::findOrFail($groupId);
        $group->name = $request->name;
        $group->isAdmin = $request->isAdmin;
        $group->save();

        return redirect()->route('admin.groups.index')->with('success', 'Cập nhật nhóm thành công!');
    }

    public function permission($id){
        $group = Group::findOrFail($id);

        $modules = Module::all();

        $roleListArr = [
            'view' => 'Xem',
            'add' => 'Thêm',
            'edit' => 'Sửa',
            'delete' => 'Xóa',
        ];

        $roleArr = $group->permissions;

        return Inertia::render('Admin/Group/GroupDetail', [ 'group' => $group, 'modules' => $modules, 'roleListArr' => $roleListArr, 'roleArr' => $roleArr]);
    }

    public function updatePermission($id, Request $request)
    {
        $group = Group::findOrFail($id);
        $modules = Module::all();
        foreach ($modules as $module) {
            $moduleList[] = $module->name;
        }
        $roleArr = [];

        if(!empty($request->role)){
            $roleArr = $request->role;
        }

        // lặp qua danh sách module và thêm vào mảng phân quyền
        foreach ($moduleList as $module) {
            if (!array_key_exists($module, $roleArr)) {
                $roleArr[$module] = [];
            }
        }

        $group->permissions = $roleArr;
        $group->save();
        return redirect()->back()->with('success', 'Phân quyền thành công!');
    }

    public function destroy($id){
        $group = Group::findOrFail($id);
        $group->delete();
        return redirect()->route('admin.groups.index')->with('success', 'Xóa nhóm thành công!');

    }

}
