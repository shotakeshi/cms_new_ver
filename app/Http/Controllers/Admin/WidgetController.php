<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Widget;
use App\Models\WidgetContent;
use App\Enums\WidgetType;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use App\Http\Requests\Admins\WidgetRequest;
use Illuminate\Support\Facades\DB;
class WidgetController extends Controller
{
    use UploadImage;
    const SAVE_AND_EXIT = 'save';
    const IMAGE_PATH = 'widgets';
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.widget.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $type = WidgetType::tryFrom($request->type);
        if($type){
            return view('admin.widget.create-widget', compact('type'));
        }
        return view('admin.widget.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WidgetRequest $request)
    {
        DB::transaction(function () use ($request) {
            $widget = Widget::create($request->all());
            Language::active()
                ->pluck('slug')
                ->each(function ($language) use ($request, $widget) {
                    $content = $request->input($language, []);
                    foreach ($request->file($language, []) as $key => $file) {
                        if ($file instanceof \Illuminate\Http\UploadedFile) {
                            $content[$key] = $this->uploadImage(
                                $file,
                                self::IMAGE_PATH
                            );
                        }
                    }
                    $widget->contents()->create([
                        'language_code' => $language,
                        'data' => $content,
                    ]);
                });
        });
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        //
    }
}
