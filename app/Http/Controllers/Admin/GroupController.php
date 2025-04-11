<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Group;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{

    public function index(){
        $groups = Group::with('user')->get();

        return Inertia::render('Admin/Group/Index', [ 'groups' => $groups, ]);

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

        if(!empty($request->role)){
            $roleArr = $request->role;
        }else {
            $roleArr = [];
        }

        $group->permissions = $roleArr;
        $group->save();
        return redirect()->back()->with('success', 'Phân quyền thành công!');
    }



}
