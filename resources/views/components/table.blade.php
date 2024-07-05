<div class="overflow-x-auto">
    <table class="table table-zebra min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <!-- head -->
        <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <tr>
                <th class="py-3 px-6 text-left">#</th>
                @foreach ($headers as $header)
                    <th class="py-3 px-6 text-left">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach ($rows as $index => $row)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    {{-- <td class="py-3 px-6 text-left align-top">{{ $index + 1 }}</td> --}}
                    @foreach ($row as $key => $cell)
                        <td class="py-3 px-6 text-left align-top">
                            {{ $cell }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
