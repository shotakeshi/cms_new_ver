<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SettingType;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\UploadImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use DateTimeZone;

class SettingController extends Controller
{
    use UploadImage;

    const IMAGE_PATH = 'settings';
    const FIELDS_IMAGE = ['logo', 'favicon'];

    public function __construct(private Setting $setting)
    {
        $timeZones = DateTimeZone::listIdentifiers();
        view()->share('timeZones', $timeZones);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.setting.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $settings = Setting::where('setting', $request['type'])->pluck('value', 'key');
        return view('admin.setting.store.'.$request['type'], compact('settings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $type = SettingType::from($request->input('type'));
        $inputs = Arr::except($request->all(), ['_token', 'type']);
        foreach ($inputs as $key => $value) {
            if (in_array($key, self::FIELDS_IMAGE)
                && $request->input("remove_$key") == 1) {
                $value = null;
            }
            if ($request->hasFile($key)) {
                $value = $this->uploadImage(
                    $request->file($key),
                    self::IMAGE_PATH,
                    $value
                );
            }
            $this->setting->updateOrCreate(
                ['key' => $key],
                [
                    'name' => $type->getName(),
                    'setting' => $type->getSetting(),
                    'value' => $value,
                ]
            );
        }
        toastr()->success(__('site.notification.update_success'));
        return redirect()->back();
    }
}
