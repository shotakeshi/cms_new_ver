<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admins\DepartmentRequest;
use App\Http\Requests\Admins\PositionRequest;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DepartmentController extends BaseController
{
    const LIMIT = 1;
    const SUBMITTER_SAVE = 'save';

    public function __construct(private Department $department) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $departments = $this->department->select('id', 'name', 'description')->with('positions')->get();
        return view('admin.department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $department = $this->department->create($request->only('name', 'description'));
            DB::commit();

            toastr()->success(__('site.notification.create_success'));
            return $request->submitter === self::SUBMITTER_SAVE
                ? redirect()->route('departments.index')
                : redirect()->route('departments.edit', $department->id);
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error(__('site.notification.create_fail'));
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department): View
    {
        return view('admin.department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, Department $department): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $department->fill($request->only('name', 'description'));
            if ($department->isDirty()) {
                $department->save();
                DB::commit();

                toastr()->success(__('site.notification.update_success'));
            }
            return $request->submitter === self::SUBMITTER_SAVE
                ? redirect()->route('departments.index')
                : redirect()->route('departments.edit', $department->id);
        }catch (\Exception $e) {
            DB::rollBack();
            toastr()->error(__('site.notification.update_fail'));
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department): RedirectResponse
    {
        if (Department::count() <= self::LIMIT) {
            toastr()->error(__('site.notification.can_not_delete_with_limit'));
            return redirect()->back();
        }

        if (! $department->canDelete()) {
            toastr()->error(__('site.notification.delete_fail_with_admin_used'));
            return redirect()->back();
        }
        
        //Delete department and positon
        DB::transaction(function () use ($department) {
            $department->positions()->delete();
            $department->delete();
        });
        toastr()->success(__('site.notification.delete_success'));
        return redirect()->back();
    }

    /**
     * Store a position for the specified department.
     */
    public function storePosition(Request $request, $departmentId): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $department = $this->department->findOrFail($departmentId);
            $department->positions()->create($request->only('name'));
            DB::commit();
            toastr()->success(__('site.notification.create_success'));
        }catch (\Exception $e) {
            DB::rollBack();
            toastr()->error(__('site.notification.create_fail'));
        }
        return redirect()->back();
    }

    /**
     * Update the specified position.
     */
    public function updatePosition(PositionRequest $request, Position $position): JsonResponse
    {
        try{
            $position->fill(['name' => $request->get('value')]);
            if ($position->isDirty()) {
                $position->save();
            }
            return response()->json([
                'status' => 'success',
                'data' => [],
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'data' => [],
            ]);
        }
    }

    /**
     * Remove the specified position from storage.
     */
    public function destroyPosition(Position $position): RedirectResponse
    {
        if (! $position->canDelete()) {
            toastr()->error(__('site.notification.delete_fail_with_admin_used'));
            return redirect()->back();
        }

        DB::transaction(function () use ($position) {
            $position->delete();
        });

        toastr()->success(__('site.notification.delete_success'));
        return redirect()->back();
    }
}
