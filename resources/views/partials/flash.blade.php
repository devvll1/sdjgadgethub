@if (session('success') || session('message_success') || session('error'))
    <div class="container-fluid page-shell pt-3 pb-0">
        <div class="page-card py-3">
            @if (session('success') || session('message_success'))
                <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                    {{ session('success') ?? session('message_success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>
@endif
