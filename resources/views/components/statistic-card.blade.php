@props([
    'title' => '',
    'value' => '',
    'description' => '',
])

<div class="stats shadow bg-white rounded-lg">
    <div class="stat">
        <div class="flex items-center">
            <div class="stat-figure text-secondary">
                {{ $slot }}
            </div>
            <div class="ml-4">
                <div class="stat-title">{{ $title }}</div>
                <div class="stat-value text-secondary">{{ $value }}</div>
                <div class="stat-desc">{!! $description !!}</div>
            </div>
        </div>
    </div>
</div>