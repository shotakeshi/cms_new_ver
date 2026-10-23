<div class="table-responsive">
    <table class="table table-striped mb-0">
        <thead class="thead-light">
        <tr>
            <th class="text-center" style="width: 50px">#</th>
            <th style="width: 500px">{{ __('site.page.name') }}</th>
            <th class="text-center" style="width: 150px">{{ __('site.page.status') }}</th>
            <th class="text-center" style="width: 150px">{{ __('site.page.status_comment') }}</th>
            <th class="text-center" style="width: 150px">{{ __('site.button.author') }}</th>
            <th class="text-center" style="width: 100px">
                @foreach($globalLanguages as $language)
                    <img alt="{{ $language->name }}" style="max-width: 20px" src="{{ asset('flags/'.$language->slug.'.png') }}">
                @endforeach
            </th>
            <th class="text-center" style="width: 300px">{{ __('site.button.date') }}</th>
        </tr>
        </thead>
        <tbody>
        @forelse($pages as $page)
            @php
                $contents = $pageContents[$page->id] ?? [];
                $fallbackContent = collect($contents)->first();
                $currentContent = $contents[$appLocale] ?? $fallbackContent;
                $pageName = $currentContent['name'] ?? '';
                if (!isset($contents[$appLocale]) && $fallbackContent) {
                    $pageName = '[ ' . array_key_first($contents) . ' ] ' . $fallbackContent['name'];
                }
                $isTrash = $page->trashed();
                $isTrashPage = isset($pageTrash) || $isTrash;
            @endphp
            <tr
                    class="hover-target"
                    id="row-{{ $page->id }}"
            >
                {{-- No --}}
                <td class="text-center">
                    <strong>{{ $loop->iteration }}</strong>
                </td>

                {{-- Page --}}
                <td>
                    <div class="mb-1">
                        @if($isTrash)
                            <span class="font-14 text-gray font-italic">
                        {{ $pageName }}
                    </span>
                        @else
                            <a href="{{ route('pages.edit', $page) }}?ref_lang={{ $appLocale }}">
                        <span class="font-14 text-primary">
                            {{ $pageName }}
                        </span>
                            </a>
                        @endif
                    </div>

                    <div style="height: 22px">
                        <div class="row-action hidden-div">
                            @if($isTrashPage)
                                {{-- Restore --}}
                                <a
                                        class="border-right text-primary border-gray pr-2 mr-1"
                                        href="{{ route('pages.restore', $page) }}"
                                >
                                    {{ __('site.button.restore') }}
                                </a>

                                {{-- Permanent Delete --}}
                                <x-admin::buttons.delete-button
                                        :action="route('pages.force-delete', $page)"
                                        asText
                                        :title="__('site.button.delete_permanently')"
                                />
                            @else
                                {{-- Edit --}}
                                <a
                                        class="border-right text-primary border-gray pr-2 mr-1"
                                        href="{{ route('pages.edit', $page) }}"
                                >
                                    {{ __('site.button.edit') }}
                                </a>

                                {{-- Trash --}}
                                <a
                                        href="javascript:void(0)"
                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $page->id }}').submit();"
                                        class="border-right text-danger border-gray pr-2 mr-1"
                                >
                                    {{ __('site.button.trash') }}
                                </a>

                                {{-- Preview --}}
                                <a href="{{ route('pages.show', $page) }}">
                                    {{ __('site.button.preview') }}
                                </a>

                                <form
                                        id="delete-form-{{ $page->id }}"
                                        action="{{ route('pages.destroy', $page) }}"
                                        method="POST"
                                        class="d-none"
                                >
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif
                        </div>
                    </div>
                </td>

                {{-- Status --}}
                <td class="text-center">
                    @if($isTrash)
                        <span
                                class="badge badge-soft-danger p-2"
                                style="width: 100px"
                        >
                    {{ __('site.filter.trash') }}
                </span>
                    @else
                        <span
                                class="{{ $page->status_class }} p-1"
                                style="width: 100px"
                        >
                    {{ $page->status_name }}
                </span>
                    @endif
                </td>

                {{-- Comment Status --}}
                <td class="text-center">
            <span
                    class="{{ $page->status_comment_class }} p-1"
                    style="width: 100px"
            >
                {{ $page->status_comment_name }}
            </span>
                </td>

                {{-- Admin --}}
                <td class="text-center">
            <span style="width: 100px">
                {{ $page->admin->name ?? '' }}
            </span>
                </td>

                {{-- Languages --}}
                <td class="text-center">
                    @unless($isTrash)
                        @foreach($globalLanguages as $language)
                            @if(isset($contents[$language->slug]))
                                <a
                                        href="{{ route('pages.edit', $page) }}?ref_lang={{ $language->slug }}"
                                >
                                    <i class="font-20 mdi mdi-square-edit-outline text-success"></i>
                                </a>
                            @else
                                <a
                                        href="{{ route('pages.edit', $page) }}?ref_lang={{ $language->slug }}"
                                >
                                    <i class="font-20 mdi mdi-shape-square-plus text-primary"></i>
                                </a>
                            @endif
                        @endforeach
                    @endunless
                </td>

                {{-- Dates --}}
                <td class="text-right">
            <span class="text-gray font-italic">
                {{ __('site.page.created_at') }}:
            </span>

                    <span class="text-primary">
                {{ $page->created_at }}
            </span>

                    <br>

                    <span class="text-gray font-italic">
                {{ __('site.button.last_modified') }}:
            </span>

                    <span class="text-beanred">
                {{ $page->updated_at }}
            </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">
                    {{ __('site.no_data') }}
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>