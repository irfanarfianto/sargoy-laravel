@props(['items'])
<div class="breadcrumbs text-sm">
    <ul>
        @foreach ($items as $index => $item)
            <li>
                @if (isset($item['url']))
                    <a href="{{ $item['url'] }}">{{ $item['name'] }}</a>
                @else
                    <span>{{ $item['name'] }}</span>
                @endif
            </li>
        @endforeach
    </ul>
</div>
