<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive">
            @forelse($activities as $log)
                <li class="list-group-item">
                    <div>
                        {{ ucfirst($log->action) }}
                        <b>{{ $log->module }}</b>

                        @if($log->subject_id)
                            #{{ $log->subject_id }}
                        @endif
                    </div>
                    <small class="text-muted">
                        {{ $log->created_at->diffForHumans() }}
                        · IP: {{ $log->ip }}
                    </small>
                    <small class="text-muted d-block">
                        {{ $log->log_time }}
                    </small>
                    @if(!empty($log->agent_info))
                        <small class="text-muted">
                            @if($log->agent_info['device'] === 'Mobile') 📱 @else 💻 @endif
                            {{ $log->agent_info['browser'] }}
                            · {{ $log->agent_info['platform'] }}
                            · {{ $log->agent_info['device'] }}
                            · IP {{ $log->ip }}
                        </small>
                    @endif
                    @if($log->action === 'update' && !empty($log->properties))
                        <ul class="mb-1">
                            @foreach($log->properties['after'] as $field => $value)
                                <li>
                                    {{ $field }}:
                                    {{ $log->properties['before'][$field] ?? '-' }}
                                    → <b>{{ $value }}</b>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @empty
                <li class="list-group-item text-muted">
                    Chưa có hoạt động
                </li>
            @endforelse
        </div>
    </div> <!-- end col -->
</div>
