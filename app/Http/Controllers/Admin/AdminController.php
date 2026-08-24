<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AdminType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\AdminChangePasswordRequest;
use App\Http\Requests\Admins\AdminProfileRequest;
use App\Http\Requests\Admins\AdminRequest;
use App\Http\Requests\Admins\AdminResetPasswordRequest;
use App\Models\Admin;
use App\Models\Department;
use App\Models\Language;
use App\Models\Position;
use App\Traits\UploadImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private const MIN_ADMIN_COUNT = 1;
    use UploadImage;

    /**
     * @return View
     */
    public function index(): View
    {
        $admins = Admin::query()
            ->with([
                'department:id,name',
                'language:id,name',
                'position:id,name',
            ])
            ->latest()
            ->get();
        return view('admin.admin.index', compact('admins'));
    }

    public function create(): View
    {
        return view('admin.admin.create', [
            'languages' => Language::query()->pluck('name', 'id'),
            'departments' => Department::query()->select('id', 'name')
                ->with(['positions:id,name,department_id'])
                ->get(),
        ]);
    }

    /**
     * @param AdminRequest $request
     * @return RedirectResponse
     */
    public function store(AdminRequest $request): RedirectResponse
    {
        $data = $request->all();
        $data['avatar'] = $this->uploadImage(
            $request->file('file'),
            'avatar',
        );
        $admin = Admin::query()->create($data);
        toastr()->success(
            __('site.notification.create_success')
        );
        return redirect()->route(
            $request->submitter === 'save'
                ? 'admins.index'
                : 'admins.show',
            $admin->id
        );
    }

    /**
     * @param Admin $admin
     * @return View
     */
    public function show(Admin $admin): View
    {
        $admin->load([
            'department:id,name',
            'language:id,name',
            'position:id,name,department_id',
        ]);

        return view('admin.admin.show', [
            'admin' => $admin,

            'departments' => Department::query()
                ->select('id', 'name')
                ->with([
                    'positions:id,name,department_id',
                ])
                ->orderBy('name')
                ->get(),

            'languages' => $this->getLanguageOptions(),

            'activities' => $admin->activities()
                ->latest()
                ->limit(10)
                ->get(),
        ]);
    }

    /**
     * @return View
     */
    public function profile(): View
    {
        return view('admin.admin.personal', [
            'admin' => auth()->guard('admin')->user(),
            'departments' => $this->getDepartmentOptions(),
            'languages' => $this->getLanguageOptions(),
            'positions' => $this->getPositionOptions(),
        ]);
    }



    /**
     * @param AdminProfileRequest $request
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function update(AdminProfileRequest $request, Admin $admin): RedirectResponse
    {
        $data = $request->all();
        if ($request->hasFile('file')) {
            $data['avatar'] = $this->uploadImage(
                $request->file('file'),
                'avatar',
                $admin->avatar
            );
        }
        $admin->fill($data);
        if (! $admin->isDirty()) {
            toastr()->info(__('site.notification.no_changes_detected')
            );
            return redirect()->back();
        }
        $admin->save();
        toastr()->success(__('site.notification.update_success'));
        return redirect()->back();
    }

    /**
     * @param Admin $admin
     * @return JsonResponse
     */
    public function destroy(Admin $admin): RedirectResponse
    {
        $this->authorize('destroy', $admin);
        if ($admin->id === auth()->id()) {
            toastr()->error(__('site.notification.can_not_delete_self'));
            return redirect()->back();
        }
        if ($admin->root_admin) {
            toastr()->error(__('site.notification.can_not_delete_root_admin'));
            return redirect()->back();
        }
        if (Admin::query()->count() <= self::MIN_ADMIN_COUNT) {
            toastr()->error(__('site.notification.can_not_delete_with_limit'));
            return redirect()->back();
        }

        DB::transaction(function () use ($admin) {
            $admin->delete();
        });

        toastr()->success(__('site.notification.delete_success'));
        return redirect()->back();
    }

    /**
     * @param AdminResetPasswordRequest $request
     * @param $admin
     * @return JsonResponse
     */
    public function resetPassword(AdminResetPasswordRequest $request, Admin $admin): JsonResponse {
        $admin->update(
            $request->validated()
        );

        return response()->json([
            'status' => 'success',
            'data' => [],
            'message' => __('site.notification.update_success'),
        ]);
    }

    /**
     * @return View
     */
    public function changePassword(): View
    {
        return view('admin.admin.change-password', [
            'admin' => auth()->guard('admin')->user(),
        ]);
    }

    /**
     * @param AdminChangePasswordRequest $request
     * @return RedirectResponse
     */
    public function updateAdminPassword(
        AdminChangePasswordRequest $request
    ): RedirectResponse {
        auth()->guard('admin')
            ->user()
            ->update($request->validated());

        toastr()->success(
            __('site.notification.change_password_success')
        );

        return redirect()->back();
    }

    public function removeRootAdmin(Admin $admin): RedirectResponse
    {
        $this->authorize('removeRootAdmin', $admin);
        if (!$admin->root_admin) {
            toastr()->error(__('site.notification.admin_is_not_root'));
            return back();
        }

        if ($admin->id === auth()->id()) {
            toastr()->error(__('site.notification.can_not_remove_yourself'));
            return back();
        }

        $rootAdminCount = Admin::query()
            ->where('type', AdminType::ROOT)
            ->count();

        if ($rootAdminCount <= 1) {
            toastr()->error(__('site.notification.can_not_remove_last_root_admin'));
            return back();
        }

        $admin->update([
            'type' => AdminType::NORMAL,
        ]);

        toastr()->success(__('site.notification.update_success'));
        return back();
    }

    private function getDepartmentOptions()
    {
        return Department::query()
            ->select('id', 'name')->get();
    }

    private function getLanguageOptions()
    {
        return Language::query()
            ->pluck('name', 'id');
    }

    private function getPositionOptions()
    {
        return Position::query()
            ->select([
                'id',
                'name',
                'department_id',
            ])
            ->get()
            ->groupBy('department_id');
    }
}
