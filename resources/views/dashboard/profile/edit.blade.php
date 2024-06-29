<x-dashboard-layout>
    <div class="pt-14 w-full items-start">
        <div class="flex flex-col">
            <h4 class="text-xl font-bold text-gray-900">
                {{ __('Profile') }}
            </h4>
            {{-- <x-breadcrumb :items="$breadcrumbItems" /> --}}
        </div>
        <div class="flex flex-col">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('dashboard.profile.partials.update-profile-information-form')
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('dashboard.profile.partials.update-password-form')
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('dashboard.profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
