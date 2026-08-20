@extends('admin.layouts.app')
@section('title')
    {{ __('site.permission.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('admin.layouts.partials.page-title-box', ['name' => __('site.setting.title')])
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header bg-light font-16">
                        {{ __('site.setting.common') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="media">
                                    <div class="float-left mr-1 pt-2 text-gray">
                                        <i class="fa fa-cogs font-24"></i>
                                    </div>
                                    <div class="media-body">
                                        <div class="col-auto">
                                            <a href="{{ route('settings.create') }}?type={{ \App\Enums\SettingType::GENERAL->value }}" class="text-primary font-weight-bold font-16">{{ __('site.setting.general') }}</a><br/>
                                            <span>{{ __('site.setting.general_note') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="media">
                                    <div class="col- float-left mr-1 pt-2 text-gray">
                                        <i class="dripicons-web font-24"></i>
                                    </div>
                                    <div class="media-body">
                                        <div class="col-auto">
                                            <a href="{{ route('settings.create') }}?type={{ \App\Enums\SettingType::WEBSITE_TRACKING->value }}" class="text-primary font-weight-bold font-16">{{ __('site.setting.website_tracking') }}</a><br/>
                                            <span>{{ __('site.setting.config_website_tracking') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="media">
                                    <div class="col- float-left mr-1 pt-2 text-gray">
                                        <i class="dripicons-web font-24"></i>
                                    </div>
                                    <div class="media-body">
                                        <div class="col-auto">
                                            <a href="{{ route('settings.create') }}?type={{ \App\Enums\SettingType::SEO_CONFIG->value }}" class="text-primary font-weight-bold font-16">SEO</a><br/>
                                            <span>SEO</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="media">
                                    <div class="col- float-left mr-1 pt-2 text-gray">
                                        <i class="mdi mdi-api font-24"></i>
                                    </div>
                                    <div class="media-body">
                                        <div class="col-auto">
                                            <a href="{{ route('settings.create') }}?type={{ \App\Enums\SettingType::SEO_API->value }}" class="text-primary font-weight-bold font-16">API</a><br/>
                                            <span>{{ __('site.setting.api_settings') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card m-b-30">
                    <div class="card-header bg-light font-16">
                        {{ __('site.setting.localization') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="media">
                                    <div class="col- float-left mr-1 pt-2 text-gray">
                                        <i class="ti-flag-alt font-24"></i>
                                    </div>
                                    <div class="media-body">
                                        <div class="col-auto">
                                            <a href="{{ route('languages.index') }}" class="text-primary font-weight-bold font-16">{{ __('site.language.title') }}</a><br/>
                                            <span>{{ __('site.setting.language_note') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="media">
                                    <div class="col- float-left mr-1 pt-2 text-gray">
                                        <i class="fas fa-language font-24"></i>
                                    </div>
                                    <div class="media-body">
                                        <div class="col-auto">
                                            <a href="{{ route('translation.index') }}" class="text-primary font-weight-bold font-16">{{ __('site.translation.title') }}</a><br/>
                                            <span>{{ __('site.setting.translation_note') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card m-b-30">
                    <div class="card-header bg-light font-16">
                        Roles
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="media">
                                    <div class="col- float-left mr-1 pt-2 text-gray">
                                        <i class="fa fa-user-lock font-24"></i>
                                    </div>
                                    <div class="media-body">
                                        <div class="col-auto">
                                            <a href="{{ route('permissions.index') }}" class="text-primary font-weight-bold font-16">{{ __('site.setting.permission') }}</a><br/>
                                            <span>{{ __('site.setting.permission_note') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="media">
                                    <div class="col- float-left mr-1 pt-2 text-gray">
                                        <i class="fa fa-users-cog font-24"></i>
                                    </div>
                                    <div class="media-body">
                                        <div class="col-auto">
                                            <a href="{{ route('permission-groups.index') }}" class="text-primary font-weight-bold font-16">{{ __('site.setting.permission_group') }}</a><br/>
                                            <span>{{ __('site.setting.permission_group_note') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="media">
                                    <div class="col- float-left mr-1 pt-2 text-gray">
                                        <i class="fa fa-user-shield font-24"></i>
                                    </div>
                                    <div class="media-body">
                                        <div class="col-auto">
                                            <a href="{{ route('roles.index') }}" class="text-primary font-weight-bold font-16">{{ __('site.setting.role') }}</a><br/>
                                            <span>{{ __('site.setting.role_note') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
@endsection
