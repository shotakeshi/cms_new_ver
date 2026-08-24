<h4 class="header-title mt-0 mb-3">
    {{ __('site.activity.timeline') }}
</h4>

<div class="slimscroll activity-scroll">
    <div class="activity">
        @forelse($activities as $log)
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