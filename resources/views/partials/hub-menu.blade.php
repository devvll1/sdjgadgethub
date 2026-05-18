@props(['title' => 'Menu', 'buttons' => []])

<div class="hub-hero mt-4">
    <h1>{{ $title }}</h1>
    <p class="text-white-50 mb-4">Choose an action below</p>
    <div class="d-flex flex-wrap justify-content-center">
        @foreach ($buttons as $button)
            <a href="{{ $button['url'] }}" class="btn hub-btn">{{ $button['label'] }}</a>
        @endforeach
    </div>
</div>
