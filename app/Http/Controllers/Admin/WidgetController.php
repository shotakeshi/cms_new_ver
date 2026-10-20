<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Widget;
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
    public function index(Request $request)
    {
        $query = Widget::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $widgets = $query->latest()
            ->paginate(100)
            ->withQueryString();

        $types = Widget::query()
            ->whereNotNull('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');

        return view('admin.widget.index', compact(
            'widgets',
            'types'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $widget = null;
        $type = WidgetType::tryFrom($request->type);
        if($type){
            return view('admin.widget.create-widget', compact('type', 'widget'));
        }
        return view('admin.widget.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WidgetRequest $request)
    {
        DB::beginTransaction();
        try {
            $languages = Language::active()->pluck('slug')->toArray();

            $widgetData = $request->except(
                array_merge(['_token', 'submitter'], $languages)
            );

            $widget = Widget::create($widgetData);

            foreach ($languages as $language) {
                $content = $request->input($language, []);
                $files = $request->file($language, []);
                foreach ($files as $key => $value) {
                    if (
                        $value instanceof \Illuminate\Http\UploadedFile
                        && $value->isValid()
                    ) {
                        $content[$key] = $this->uploadImage(
                            $value,
                            self::IMAGE_PATH
                        );

                        continue;
                    }

                    if (is_array($value)) {
                        foreach ($value as $fieldName => $file) {
                            if (
                                $file instanceof \Illuminate\Http\UploadedFile
                                && $file->isValid()
                            ) {
                                $content[$key][$fieldName] =
                                    $this->uploadImage(
                                        $file,
                                        self::IMAGE_PATH
                                    );
                            }
                        }
                    }
                }
                if (in_array($widget->type, [WidgetType::SLIDER, WidgetType::BLOCKS, WidgetType::GALLERY, WidgetType::CONTACT], true)) {
                    $data = array_values($content);
                } else {
                    $data = $content;
                }
                $widget->contents()->create([
                    'language_code' => $language,
                    'data' => $data,
                ]);
            }
            DB::commit();
            toastr()->success(__('site.notification.create_success'));
            if($request['submitter'] == self::SAVE_AND_EXIT) {
                return redirect()->route('widgets.index');
            }
            return redirect()->route('widgets.edit',$widget);
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error(__('site.notification.create_fail'));
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Widget $widget)
    {
        return redirect()->route('widgets.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Widget $widget, Request $request)
    {
        $type = WidgetType::tryFrom($request->type);
        if($type){
            return view('admin.widget.create-widget', compact('widget', 'type'));
        }
        return redirect()->route('widgets.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WidgetRequest $request, Widget $widget)
    {
        DB::beginTransaction();
        try {
            $languages = Language::active()->pluck('slug')->toArray();

            $widgetData = $request->except(
                array_merge(['_token', '_method', 'submitter', 'type'], $languages)
            );
            // Update widget, giữ nguyên model
            $widget->update($widgetData);

            foreach ($languages as $language) {
                $content = $request->input($language, []);
                $files = $request->file($language, []);
                foreach ($files as $key => $value) {
                    if (
                        $value instanceof \Illuminate\Http\UploadedFile
                        && $value->isValid()
                    ) {
                        $content[$key] = $this->uploadImage(
                            $value,
                            self::IMAGE_PATH
                        );
                        continue;
                    }

                    if (is_array($value)) {
                        foreach ($value as $fieldName => $file) {
                            if (
                                $file instanceof \Illuminate\Http\UploadedFile
                                && $file->isValid()
                            ) {
                                $content[$key][$fieldName] =
                                    $this->uploadImage(
                                        $file,
                                        self::IMAGE_PATH
                                    );
                            }
                        }
                    }
                }
                $widget->contents()
                    ->where('language_code', $language)
                    ->delete();

                if (in_array($widget->type, [WidgetType::SLIDER, WidgetType::BLOCKS, WidgetType::GALLERY, WidgetType::CONTACT], true)) {
                    $data = array_values($content);
                } else {
                    $data = $content;
                }

                $widget->contents()->create([
                    'language_code' => $language,
                    'data' => $data,
                ]);
            }
            DB::commit();
            toastr()->success(__('site.notification.update_success'));
            if ($request->input('submitter') === self::SAVE_AND_EXIT) {
                return redirect()->route('widgets.index');
            }
            return redirect()->route('widgets.edit', [
                'widget' => $widget,
                'type' => $widget->type,
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            toastr()->error(__('site.notification.update_fail'));
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Widget $widget)
    {
        abort_unless(auth()->user()?->rootAdmin, 403);
        $widget->delete();
        toastr()->success(__('site.notification.delete_success'));
        return redirect()->back();
    }

    public function updateStatusLock($widget_id)
    {
        abort_unless(auth()->user()?->rootAdmin, 403);
        $widget = Widget::findOrFail($widget_id);
        $widget->update([
            'status_lock' => (int) !$widget->status_lock,
        ]);
        toastr()->success(__('site.notification.update_success'));
        return redirect()->back();
    }
}
