@props(['route', 'text', 'icon', 'badge' => null])

<li>
    <a href="{{ route($route) }}"
       class="{{ request()->routeIs($route) ? 'text-indigo-500' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
             stroke="currentColor" class="size-6">
            {!! $icon !!} <!-- Icon is passed as SVG code -->
        </svg>
        {{ $text }}
        @if ($badge && auth()->user()->hasRole('admin'))
            <span class="badge badge-secondary">{{ $badge }}</span>
        @endif
    </a>
</li>
