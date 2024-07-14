<!-- resources/views/components/select.blade.php -->
<select {{ $attributes->merge(['class' => 'select select-bordered w-full']) }}>
    {{ $slot }}
</select>
