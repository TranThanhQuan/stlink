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


    public function permission_old(Groups $group){
        $this->authorize('permission', $group);
        $modules = Module::all();
        $roleListArr = [
            'view' => 'Xem',
            'add' => 'Thêm',
            'edit' => 'Sửa',
            'delete' => 'Xóa',
        ];

        $roleJson = $group->permissions;
        if(!empty($roleJson)){
            $roleArr = json_decode($roleJson, true);
        }else{
            $roleArr = [];
        }

        return view('admin.groups.permission', compact('group', 'modules', 'roleListArr', 'roleArr'));
    }

}
