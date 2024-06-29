<!-- resources/views/components/select.blade.php -->
<select
    {{ $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) }}>
    {{ $slot }}
</select>
