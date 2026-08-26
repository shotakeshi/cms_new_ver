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
        @foreach($pages as $page)
            <tr class="hover-target" id="row-{{ $page->id}}" >
                <td class="text-center">
                    <strong>{{ $loop->iteration }}</strong>
                </td>
                <td>
                    <div class="mb-1">
                        @if(!$page->trashed())
                            <a href="{{ route('pages.edit', $page) }}?ref_lang={{ app()->getLocale() }}">
                                <span class="font-14 text-primary">{{ $pageContents[$page->id][$appLocale]['name'] ?? '[ ' . array_key_first($pageContents[$page->id]) . ' ] ' . collect($pageContents[$page->id])->first()['name'] }}</span>
                            </a>
                        @else
                            <span class="font-14 text-gray font-italic">{{ $pageContents[$page->id][$appLocale]['name'] ?? '[ ' . array_key_first($pageContents[$page->id]) . ' ] ' . collect($pageContents[$page->id])->first()['name'] }}</span>
                        @endif
                    </div>
                    <div style="height: 22px">
                        <div class="row-action hidden-div">
                            @if(isset($pageTrash) || $page->trashed())
                                <a class="border-right text-primary border-gray pr-2 mr-1" href="{{ route('pages.restore', $page) }}">{{ __('site.button.restore') }}</a>
                                <x-admin::buttons.delete-button
                                        :action="route('pages.force-delete',$page)"
                                        asText
                                        :title="__('site.button.delete_permanently')"
                                />
                            @else
                                <a class="border-right text-primary border-gray pr-2 mr-1" href="{{ route('pages.edit', $page) }}">{{ __('site.button.edit') }}</a>
                                <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $page->id }}').submit();" class="border-right text-danger border-gray pr-2 mr-1" >{{ __('site.button.trash') }}</a>
                                <a href="{{ route('pages.show', $page) }}">{{ __('site.button.preview') }}</a>
                                <form id="delete-form-{{ $page->id }}" action="{{ route('pages.destroy', $page) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    @if($page->trashed())
                        <span class="badge badge-soft-danger p-2" style="width: 100px">{{ __('site.filter.trash') }}</span>
                    @else
                        <span class="{{ $page->status_class }} p-1" style="width: 100px">{{ $page->status_name  }}</span>
                    @endif
                </td>
                <td class="text-center">
                    <span class="{{ $page->status_comment_class }} p-1" style="width: 100px">{{ $page->status_comment_name  }}</span>
                </td>
                <td class="text-center">
                    <span style="width: 100px">{{ $page->admin->name ?? '' }}</span>
                </td>
                <td class="text-center">
                    @if(!$page->trashed())
                        @foreach($globalLanguages as $language)
                            @if(!empty($pageContents[$page->id][$language->slug]))
                                <a href="{{ route('pages.edit', $page) }}?ref_lang={{ $language->slug }}">
                                    <i class="font-20 mdi mdi-square-edit-outline text-success"></i>
                                </a>
                            @else
                                <a href="{{ route('pages.edit', $page) }}?ref_lang={{ $language->slug }}">
                                    <i class="font-20 mdi mdi-shape-square-plus text-primary"></i>
                                </a>
                            @endif
                        @endforeach
                    @endif
                </td>
                <td class="text-right">
                    <span class="text-gray font-italic">{{ __('site.page.created_at') }}: </span>
                    <span class="text-primary">{{ $page->created_at }}</span><br/>
                    <span class="text-gray font-italic">{{ __('site.button.last_modified') }}: </span>
                    <span class="text-beanred">{{ $page->updated_at }}</span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>