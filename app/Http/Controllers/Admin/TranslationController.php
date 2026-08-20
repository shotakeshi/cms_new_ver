<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TranslationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\UpdateTranslationRequest;
use App\Http\Requests\Admins\CreateTranslationRequest;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class TranslationController extends Controller
{
    const SUBMITTER_SAVE = 'save';
    public function __construct (
        private Language $language,
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $locales = $this->language->active()->pluck('slug')->toArray();
        $locale = in_array(request('ref_lang'), $locales) ? request('ref_lang') : config('app.locale');
        $keySearch = request('keyword', '');

        $translations = TranslationHelper::getTranslation($locale, $keySearch);
        $translations = $this->getPaginatedTranslation($translations);

        return view('admin.translation.index', compact('translations', 'locale'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.translation.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTranslationRequest $request)
    {
         TranslationHelper::create(
            $request['group'],
            $request['dotKey'],
            $request['values'],
        );

        toastr()->success(__('site.notification.create_success'));
        return redirect()->route('translation.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTranslationRequest $request): JsonResponse
    {
        $data = $request->all();
        TranslationHelper::update(
            $data['locale'],
            $data['group'],
            $data['dotKey'],
            $data['value']
        );

        toastr()->success(__('site.notification.update_success'));
        return response()->json(['success' => true]);
    }

    /**
     * Get paginated translation
     *
     * @param array $translations
     * @return LengthAwarePaginator
     */
     private function getPaginatedTranslation(array $translations): LengthAwarePaginator
     {
         $page = request()->integer('page', 1);
         $perPage = config('commons.per_page');
         $collection = collect($translations);
         return new LengthAwarePaginator(
             $collection->forPage($page, $perPage),
             $collection->count(),
             $perPage,
             $page,
             [
                 'path' => request()->url(),
                 'query' => request()->query()
             ]
         );
     }
}
