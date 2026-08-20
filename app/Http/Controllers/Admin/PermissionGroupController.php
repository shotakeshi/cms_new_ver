<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\PermissionGroupRequest;
use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class PermissionGroupController extends Controller
{
    const APPLY = 'apply';
    const SAVE = 'save';

    public function __construct(private PermissionGroup $permissionGroup, private Permission $permission) {
        $permissionGroupExists = Arr::flatten($this->permissionGroup->pluck('permission_id')->all());
        $permissions = $this->permission->pluck('name', 'id')->all();
        view()->share(compact('permissions','permissionGroupExists'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $permissionGroups = $this->permissionGroup->all();
        return view('admin.permission.group.index', compact('permissionGroups'));
    }

    public function create() : View
    {
        return view('admin.permission.group.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionGroupRequest $request) : RedirectResponse
    {
        $permissionGroup = $this->permissionGroup->create($request->all());
        toastr()->success(__('site.notification.create_success'));
        if($request['submitter'] == self::SAVE) {
            return redirect()->route('permission-groups.index');
        }
        return redirect()->route('permission-groups.edit', $permissionGroup->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PermissionGroup $permissionGroup) : View
    {
        return view('admin.permission.group.edit', compact('permissionGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionGroupRequest $request, PermissionGroup $permissionGroup) : RedirectResponse
    {
        $permissionGroup->fill($request->only('name', 'permission_id'));
        DB::beginTransaction();
        try {
            if($permissionGroup->isDirty()){
                $permissionGroup->save();
                toastr()->success(__('site.notification.update_success'));
                DB::commit();
            }
            if($request->submitter == self::SAVE) {
                return redirect()->route('permission-groups.index');
            }
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating permission group: ' . $e->getMessage(), ['exception' => $e]);
            toastr()->success(__('site.notification.update_fail'));
            return back();
        }
    }
}
