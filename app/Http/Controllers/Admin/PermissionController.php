<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Requests\Admins\PermissionRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PermissionController extends Controller
{
    const PREFIX = 'admin';
    const APPLY = 'apply';
    const SAVE = 'save';

    public function __construct(private Permission $permission)
    {
        $permissionExists = Arr::flatten($this->permission->pluck('slug')->all());
        view()->share('permissionExists', $permissionExists);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $permissions = $this->permission->all();
        return view('admin.permission.index', compact('permissions'));
    }

    public function create() : View
    {
        $routeNames = $this->getRoutes();
        return view('admin.permission.create', compact('routeNames'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request) : RedirectResponse
    {
        $permission = $this->permission->create($request->all());
        toastr()->success(__('site.notification.create_success'));
        if($request->submitter == self::SAVE) {
            return redirect()->route('permissions.index');
        }
        return redirect()->route('permissions.edit', $permission->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission): View
    {
        $routeNames = $this->getRoutes();
        return view('admin.permission.edit', compact('permission',  'routeNames'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, Permission $permission) : RedirectResponse
    {
        $permission->fill($request->only('name', 'slug'));
        DB::beginTransaction();
        try {
            if($permission->isDirty()){
                $permission->save();
                toastr()->success(__('site.notification.update_success'));
                DB::commit();
            }
            if($request->submitter == self::SAVE) {
                return redirect()->route('permissions.index');
            }
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->success(__('site.notification.update_fail'));
            return back();
        }
    }

    private function getRoutes() : array
    {
        $exceptionRoutes = config('exceptions.routes');
        $prefix = self::PREFIX;
        $routes = collect(Route::getRoutes())->filter(function ($route) use ($prefix) {
            return Str::startsWith($route->uri, $prefix);
        });
        $routeNames = [];
        foreach ($routes as $route){
            if($route->gatherMiddleware()[1] == 'auth:admin'){
                if(!in_array($route->getName(), $exceptionRoutes)){
                    $routeNames[] = $route->getName();
                }
            }
        }
        return $routeNames;
    }
}
