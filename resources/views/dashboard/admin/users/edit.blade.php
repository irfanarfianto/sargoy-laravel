<x-dashboard-layout>
    <div class="pt-14 flex flex-wrap w-full justify-between items-start">
        <div class="flex flex-col">
            <h4 class="text-xl font-bold text-gray-900">
                {{ __('Daftar Produk') }}
            </h4>
            <x-breadcrumb :items="$breadcrumbItems" />
        </div>
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" class="form-input mt-1 block w-full"
                    value="{{ old('name', $user->name) }}">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="form-input mt-1 block w-full"
                    value="{{ old('email', $user->email) }}">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="form-input mt-1 block w-full">
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                    Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="form-input mt-1 block w-full">
            </div>
            <div class="mb-4">
                <label for="roles" class="block text-sm font-medium text-gray-700">Roles</label>
                @foreach ($roles as $role)
                    <div class="flex items-center">
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="form-checkbox"
                            {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                        <span class="ml-2">{{ $role->name }}</span>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-end">
                @if (Auth::user()->hasRole('demo_admin'))
                    <button type="submit" class="btn btn-primary" disabled>Update</button>
                @else
                    <button type="submit" class="btn btn-primary">Update</button>
                @endif
            </div>
        </form>
    </div>
</x-dashboard-layout>
