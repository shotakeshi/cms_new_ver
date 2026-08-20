<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\NativeCountry\CountryNames;
use App\Http\Requests\Admins\LanguageRequest;
use App\Models\Language;

class LanguageController extends BaseController
{
    const LIMIT = 1;
    protected $title = 'Language';
    public function __construct(private Language $language, private CountryNames $countryNames){
        view()->share('title', $this->title);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $languages = $this->language->all();
        return view('admin.language.index', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LanguageRequest $request): RedirectResponse
    {
        $this->language->create($request->all());
        toastr()->success(__('site.notification.create_success'));
        return redirect()->route('languages.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Language $language): View
    {
        $languages = $this->language->all();
        return view('admin.language.edit', compact('languages','language'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LanguageRequest $request, Language $language): RedirectResponse
    {
        $language->fill($request->all());
        if($language->isDirty()){
            $language->save();
        };
        toastr()->success(__('site.notification.update_success'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language): JsonResponse
    {
        if (Language::count() <= self::LIMIT) {
            return response()->json(['success' => false, 'message' => __('site.notification.can_not_delete_with_limit')]);
        }

        DB::transaction(function () use ($language) {
            $language->delete();
        });

        return response()->json(['success' => true, 'message' => __('site.notification.delete_success')]);
    }

    /**
     * Change lang
     * @param $locale
     */
    public function changeLanguage($locale): RedirectResponse
    {
        if ($this->language->where('slug', $locale)->active()->exists()) {
            // Store the language in the session
            Session::put('locale', $locale);
            // Set the application's locale
            App::setLocale($locale);
        }
        return redirect()->back();
    }

    public function settings($fileName)
    {
        // read file in folder Land
    }
}
