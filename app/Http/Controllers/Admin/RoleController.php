<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Http\Requests\Admins\RoleRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
class RoleController extends BaseController
{
    const SUBMITTER_SAVE = 'save';
    public function __construct(
        private Role $role,
        private Permission $permission,
        private PermissionGroup $permissionGroup
    ) {
        $permissions = $this->permission->pluck('name', 'id')->all();
        $permissionGroups = $this->permissionGroup->all();
        view()->share(compact('permissions','permissionGroups'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $roles = $this->role->select('id', 'name')->get();
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $role = $this->role->create($request->validated());
            $role->permissions()->sync($request->input('permission_ids', []));

            DB::commit();

            toastr()->success(__('site.notification.create_success'));
            return $request->submitter === self::SUBMITTER_SAVE
                ? redirect()->route('roles.index')
                : redirect()->route('roles.edit', $role->id);
        }catch (\Exception $e) {
            DB::rollBack();

            toastr()->error(__('site.notification.create_fail'));
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        $permissionIds = $role->permissions()->pluck('permissions.id')->toArray();
        return view('admin.role.edit', compact('role', 'permissionIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $role->update($request->validated());
            $role->permissions()->sync($request->input('permission_ids', []));

            DB::commit();

            toastr()->success(__('site.notification.update_success'));
            return $request->submitter === self::SUBMITTER_SAVE
                ? redirect()->route('roles.index')
                : redirect()->back();
        }catch (\Exception $e) {
            DB::rollBack();

            toastr()->error(__('site.notification.update_fail'));
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}
