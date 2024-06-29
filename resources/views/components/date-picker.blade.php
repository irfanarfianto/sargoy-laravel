@props(['name', 'value', 'placeholder' => 'Select Date', 'class' => ''])

<input type="text" 
       name="{{ $name }}" 
       id="{{ $name }}" 
       value="{{ $value }}" 
       placeholder="{{ $placeholder }}" 
       {{ $attributes->merge(['class' => 'form-input ' . $class]) }}
>
@push('scripts')
    <script>
        flatpickr("#{{ $name }}", {
            dateFormat: "Y-m-d",
            allowInput: true,
            wrap: true,
        });
    </script>
@endpush