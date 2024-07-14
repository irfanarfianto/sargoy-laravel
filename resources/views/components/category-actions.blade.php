<div class="flex space-x-2">
    <button onclick="document.getElementById('editModal{{ $category->slug }}').showModal()"
        class="text-indigo-600 hover:text-indigo-900 btn btn-ghost btn-xs">Edit</button>

    <button onclick="document.getElementById('deleteModal{{ $category->slug }}').showModal()"
        class="btn btn-ghost btn-xs text-error">Delete</button>
</div>
