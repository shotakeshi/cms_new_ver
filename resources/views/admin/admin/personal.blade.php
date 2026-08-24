@extends('admin.layouts.app')
@section('title')
    {{ $admin->name }}
@endsection
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
            name="{{ $admin->name }}"
        />
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body  met-pro-bg">
                        <div class="met-profile">
                            <div class="row">
                                <div class="col-lg-7 align-self-center mb-3 mb-lg-0">
                                    <div class="met-profile-main">
                                        <div class="met-profile-main-pic">
                                            <img src="{{ showImage($admin?->avatar) }}" width="100" alt="{{ $admin->name }}">
                                        </div>
                                        <div class="met-profile_user-detail">
                                            <h5 class="met-user-name">{{ $admin->name }}</h5>
                                            <p class="mb-0 met-user-name-post">{{ $admin->position?->name }}</p>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-4 ml-auto">
                                    <ul class="list-unstyled personal-detail">
                                        <li class=""><i class="dripicons-store mr-2 text-info font-18"></i> <b> {{ __('site.department.title') }} </b> : {{ $admin->department?->name ?? '-' }}</li>
                                        <li class="mt-2"><i class="dripicons-phone mr-2 text-info font-18"></i> <b> {{ __('site.admin.phone') }} </b> : {{ $admin->phone ?? '-' }}</li>
                                        <li class="mt-2"><i class="dripicons-mail text-info font-18 mt-2 mr-2"></i> <b> {{ __('site.admin.email') }} </b> : {{ $admin->email }}</li>
                                    </ul>
                                </div><!--end col-->
                                <div class="col-lg-1 text-right">
                                    <a href="{{ route('admins.show', $admin) }}" class="btn btn-outline-gray"><i class="fas fa-edit"></i></a>
                                </div>
                            </div><!--end row-->
                        </div><!--end f_profile-->
                    </div><!--end card-body-->
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mt-0 mb-3">
                            {{ __('site.activity.activity') }}
                        </h4>
                        <div class="slimscroll activity-scroll">
                            <div class="activity">
                                @forelse($admin->activities()->get() as $log)
                                    @php
                                        $icon = match ($log->action) {
                                            'create' => [
                                                'icon' => 'mdi-plus-circle-outline',
                                                'class' => 'bg-soft-success',
                                            ],
                                            'update' => [
                                                'icon' => 'mdi-pencil-outline',
                                                'class' => 'bg-soft-primary',
                                            ],
                                            'delete' => [
                                                'icon' => 'mdi-trash-can-outline',
                                                'class' => 'bg-soft-danger',
                                            ],
                                            'restore' => [
                                                'icon' => 'mdi-restore',
                                                'class' => 'bg-soft-warning',
                                            ],
                                            'login' => [
                                                'icon' => 'mdi-login',
                                                'class' => 'bg-soft-info',
                                            ],
                                            'logout' => [
                                                'icon' => 'mdi-logout',
                                                'class' => 'bg-soft-secondary',
                                            ],
                                            default => [
                                                'icon' => 'mdi-information-outline',
                                                'class' => 'bg-soft-secondary',
                                            ],
                                        };
                                    @endphp

                                    <div class="activity-info">
                                        {{-- Icon --}}
                                        <div class="icon-info-activity">
                                            <i class="mdi {{ $icon['icon'] }} {{ $icon['class'] }}"></i>
                                        </div>
                                        {{-- Content --}}
                                        <div class="activity-info-text">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="m-0 w-75">
                                                    {{ ucfirst($log->action) }}

                                                    @if ($log->module)
                                                        <strong>{{ $log->module }}</strong>
                                                    @endif

                                                    @if ($log->subject_id)
                                                        #{{ $log->subject_id }}
                                                    @endif
                                                </h6>
                                                <span class="text-muted">
                            {{ $log->created_at->diffForHumans() }}
                        </span>
                                            </div>

                                            {{-- Date --}}
                                            <small class="text-muted d-block mt-1">
                                                {{ $log->log_time }}
                                            </small>

                                            {{-- Device --}}
                                            @if (!empty($log->agent_info))
                                                <small class="text-muted d-block mt-1">
                                                    @if (($log->agent_info['device'] ?? null) === 'Mobile')
                                                        <i class="mdi mdi-cellphone"></i>
                                                    @else
                                                        <i class="mdi mdi-laptop"></i>
                                                    @endif
                                                    {{ $log->agent_info['browser'] ?? '-' }}
                                                    · {{ $log->agent_info['platform'] ?? '-' }}
                                                    · {{ $log->agent_info['device'] ?? '-' }}
                                                    · IP {{ $log->ip }}
                                                </small>
                                            @else
                                                <small class="text-muted d-block mt-1">
                                                    IP {{ $log->ip }}
                                                </small>
                                            @endif

                                            {{-- Updated fields --}}
                                            @if (
                                                $log->action === 'update' &&
                                                !empty($log->properties['after'])
                                            )
                                                <div class="mt-3">
                                                    @foreach ($log->properties['after'] as $field => $value)
                                                        @php
                                                            $before = $log->properties['before'][$field] ?? '-';

                                                            if (is_array($before)) {
                                                                $before = json_encode($before, JSON_UNESCAPED_UNICODE);
                                                            }

                                                            if (is_array($value)) {
                                                                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
                                                            }
                                                        @endphp
                                                        <div class="mb-1">
                                    <span class="text-muted">
                                        {{ $field }}:
                                    </span>
                                                            <span class="text-danger">
                                        {{ $before }}
                                    </span>
                                                            <i class="mdi mdi-arrow-right mx-1"></i>
                                                            <strong class="text-success">
                                                                {{ $value }}
                                                            </strong>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-muted py-4">
                                        <i class="mdi mdi-history mdi-24px d-block mb-2"></i>
                                        {{ __('site.activity.no_activity') }}
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div>
            </div><!--end col-->
        </div>
    </div>
@endsection