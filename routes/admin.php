<?php

use App\Http\Controllers\Admin\TranslationController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PermissionGroupController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Auth\Admin\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\WidgetController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogPostController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('/', function () {
        return redirect(route('admin.dashboard'));
    });
    Route::get('login', [LoginController::class, 'create']);
    Route::post('login', [LoginController::class, 'store'])->name('admin.login');
});

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::post('logout', [LoginController::class, 'destroy'])->name('admin.logout');
    // Resources
    Route::resources([
        'admins' => AdminController::class,
        'languages' => LanguageController::class,
        'departments' => DepartmentController::class,
        'permissions' => PermissionController::class,
        'permission-groups' => PermissionGroupController::class,
        'roles' => RoleController::class,
        'pages' => PageController::class,
        'widgets' => WidgetController::class,
        'settings' => SettingController::class,
        'blog-categories' => BlogCategoryController::class,
        'blog-posts' => BlogPostController::class
    ]);
    Route::controller(AdminController::class)->group(function () {
        Route::get('profile', 'profile')->name('admin.profile');
        Route::get('change-password', 'changePassword')->name('admin.change-password');
        Route::post('update-password', 'updateAdminPassword')->name('admin.update-password');
        Route::post('reset-password/{adminId}', 'resetPassword')->name('admin.reset-password');
        Route::get('remove-root-admin/{adminId}', 'removeRootAdmin')->name('admin.remove-root-admin');
    });
    Route::controller(DepartmentController::class)->prefix('departments')->group(function () {
        Route::post('store-position/{departmentId}', 'storePosition')->name('department.store-position');
        Route::post('update-position/{position}', 'updatePosition')->name('department.update-position');
        Route::delete('destroy-position/{position}', 'destroyPosition')->name('department.destroy-position');
    });
    Route::controller(LanguageController::class)->prefix('languages')->group(function () {
        Route::get('settings/{fileName}', 'settings')->name('languages.settings');
    });
    Route::controller(PageController::class)->prefix('pages')->group(function () {
        Route::get('trash/list', 'trash')->name('pages.trash');
        Route::get('trash/restore/{page_id}', 'restore')->name('pages.restore');
        Route::delete('trash/force-delete/{page_id}', 'forceDelete')->name('pages.force-delete');
    });
    Route::controller(TranslationController::class)->prefix('translations')->group(function () {
        Route::get('list', 'index')->name('translation.index');
        Route::get('create', 'create')->name('translation.create');
        Route::post('store', 'store')->name('translation.store');
        Route::post('update/{locale}', 'update')->name('translation.update');
    });
});
Route::get('/change-language/{locale}', [LanguageController::class, 'changeLanguage'])->name('change-language');