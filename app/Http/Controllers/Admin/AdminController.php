<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AdminType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\AdminChangePasswordRequest;
use App\Http\Requests\Admins\AdminRequest;
use App\Http\Requests\Admins\AdminProfileRequest;
use App\Models\Admin;
use App\Models\Department;
use App\Models\Language;
use App\Models\Position;
use App\Services\Image\ImageStorageManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admins\AdminResetPasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Traits\UploadImage;

class AdminController extends Controller
{
    const LIMIT = 1;
    const SAVE = 'save';

    use UploadImage;
    public function __construct(private Admin $admin){

    }
    public function index(): View
    {
        $admins = $this->admin->with('department', 'language', 'position')->get();
        return view('admin.admin.index', compact('admins'));
    }

    public function create(): View
    {
        return view('admin.admin.create');
    }

    public function show(Admin $admin): View
    {
        return view('admin.admin.show', [
            'admin' => $admin,
            'departments' => Department::pluck('name', 'id'),
            'activities' => $admin->activities()->latest()->limit(10)->get(),
            'languages' => Language::pluck('name', 'id'),
            'positions' => Position::select('id', 'name', 'department_id')->get()->groupBy('department_id')
        ]);
    }

    public function profile(): View
    {
        return view('admin.admin.personal', [
            'admin' => auth()->guard('admin')->user(),
            'departments' => Department::pluck('name', 'id'),
            'languages' => Language::pluck('name', 'id'),
            'positions' => Position::select('id', 'name', 'department_id')->get()->groupBy('department_id')
        ]);
    }

    public function store(AdminRequest $request) {
        $request['avatar'] = $this->uploadImage(
            $request->file('file'),
            'avatar',
        );
        $admin = $this->admin->create($request->all());
        toastr()->success(__('site.notification.create_success'));
        return redirect()->route($request->submitter == self::SAVE ? 'admins.index' : 'admins.show', $admin->id);
    }

    public function update(AdminProfileRequest $request, Admin $admin): RedirectResponse
    {
        $request['avatar'] = $this->uploadImage(
            $request->file('file'),
            'avatar',
            $admin->avatar
        );
        $admin->fill($request->all());

        DB::transaction(function () use ($admin) {
            if ($admin->isDirty()) {
                $admin->save();
                toastr()->success(__('site.notification.update_success'));
            } else {
                toastr()->info(__('site.notification.no_changes_detected'));
            }
        });

        return redirect()->back();
    }

    public function destroy(Admin $admin): JsonResponse
    {
        if (Admin::count() <= self::LIMIT) {
            return response()->json(['success' => false, 'message' => __('site.notification.can_not_delete_with_limit')]);
        }

        DB::transaction(function () use ($admin) {
            $admin->delete();
        });

        return response()->json(['success' => true, 'message' => __('site.notification.delete_success')]);
    }

    public function resetPassword(AdminResetPasswordRequest $request, $adminId): JsonResponse
    {
        $admin = $this->admin->findOrFail($adminId);
        $admin->update($request->only('password'));
        return response()->json([
            'status' => 'success',
            'data' => [],
            'message' => __('site.notification.update_success')
        ]);
    }

    public function changePassword(): View
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.admin.change-password', compact('admin'));
    }

    public function updateAdminPassword(AdminChangePasswordRequest $request): RedirectResponse
    {
        auth()->guard('admin')->user()->update($request->only('password'));
        toastr()->success(__('site.notification.change_password_success'));
        return redirect()->back();
    }

    public function removeRootAdmin($adminId): RedirectResponse
    {
        $admin = $this->admin->findOrFail($adminId);
        $admin->type = AdminType::NORMAL->value;
        $admin->save();
        toastr()->success(__('site.notification.update_success'));
        return redirect()->back();
    }
}
