@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" data-bs-autohide="true" data-bs-delay="5000">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" data-bs-autohide="true" data-bs-delay="5000">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@push('scripts')
<script>
    // Auto-dismiss alerts after delay
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('[data-bs-autohide="true"]');
        
        alerts.forEach(function(alert) {
            const delay = alert.dataset.bsDelay || 5000;
            const alertInstance = new bootstrap.Alert(alert);
            
            setTimeout(() => {
                alertInstance.close();
            }, delay);
        });
    });
</script>
@endpush