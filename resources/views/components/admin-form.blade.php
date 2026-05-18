@props([
    'title',
    'subtitle' => null,
    'action',
    'method' => 'POST',
    'backUrl',
    'backLabel' => 'Cancel',
    'submitLabel' => 'Save',
    'enctype' => false,
])

<div class="page-card form-shell">
    <div class="form-shell-header d-flex flex-column flex-md-row justify-content-between align-items-md-start gap-3 mb-4 pb-3 border-bottom">
        <div>
            <h1 class="h4 mb-1 fw-bold">{{ $title }}</h1>
            @if ($subtitle)
                <p class="text-muted mb-0 small">{{ $subtitle }}</p>
            @endif
        </div>
        <a href="{{ $backUrl }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>{{ $backLabel }}
        </a>
    </div>

    <form action="{{ $action }}" method="post" @if($enctype) enctype="multipart/form-data" @endif>
        @csrf
        @if (! in_array(strtoupper($method), ['POST', 'GET']))
            @method($method)
        @endif

        {{ $slot }}

        <div class="form-actions d-flex gap-2 pt-4 mt-2 border-top">
            <button type="submit" class="btn btn-dark px-4">{{ $submitLabel }}</button>
            <a href="{{ $backUrl }}" class="btn btn-light">{{ $backLabel }}</a>
        </div>
    </form>
</div>
