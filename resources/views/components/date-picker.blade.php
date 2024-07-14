@props(['name', 'value', 'placeholder' => 'Select Date', 'class' => ''])

<input type="datetime" type="text" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}"
    placeholder="{{ $placeholder }}" {{ $attributes->merge(['class' => 'form-input ' . $class]) }}>

<script>
    flatpickr("#{{ $name }}", {
        dateFormat: "Y-m-d",
        allowInput: true,
        wrap: true,
    });
</script>
