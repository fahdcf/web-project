@props(['module'])

<div class="list-group-item module-item py-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="h6 mb-1">{{ $module->name }}</h4>
            <div class="d-flex gap-2">
                <span class="badge bg-light text-dark">
                    <i class="fas fa-clock me-1"></i> {{ $module->volume_horaire }}h
                </span>
                <span class="badge bg-light text-dark">
                    <i class="fas fa-user me-1"></i> {{ $module->professor->firstname }}
                </span>
            </div>
        </div>
        <span class="badge bg-{{ $module->status === 'validé' ? 'success' : 'warning' }}">
            {{ $module->status }}
        </span>
    </div>
</div>