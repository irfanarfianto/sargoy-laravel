<section>
    <header>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Name and Email Fields -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            <!-- Email Verification Status -->
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Profile Details Based on Role -->
        @if (auth()->user()->hasRole('admin'))
            <div>
                <x-input-label for="position" :value="__('Position')" />
                <x-text-input id="position" name="admin[position]" type="text" class="mt-1 block w-full"
                    :value="old('admin.position', $adminProfile->position ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('admin.position')" />
            </div>
        @elseif (auth()->user()->hasRole('seller'))
            <div>
                <x-input-label for="no_wa" :value="__('WhatsApp Number')" />
                <x-text-input id="no_wa" name="seller[no_wa]" type="text" class="mt-1 block w-full"
                    :value="old('seller.no_wa', $sellerProfile->no_wa ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('seller.no_wa')" />

                <x-input-label for="alamat" :value="__('Address')" />
                <x-text-input id="alamat" name="seller[alamat]" type="text" class="mt-1 block w-full"
                    :value="old('seller.alamat', $sellerProfile->alamat ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('seller.alamat')" />
            </div>
        @elseif (auth()->user()->hasRole('visitor'))
            <div>
                <x-input-label for="no_wa" :value="__('WhatsApp Number')" />
                <x-text-input id="no_wa" name="visitor[no_wa]" type="text" class="mt-1 block w-full"
                    :value="old('visitor.no_wa', $visitorProfile->no_wa ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('visitor.no_wa')" />

                <x-input-label for="alamat" :value="__('Address')" />
                <x-text-input id="alamat" name="visitor[alamat]" type="text" class="mt-1 block w-full"
                    :value="old('visitor.alamat', $visitorProfile->alamat ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('visitor.alamat')" />

                <x-input-label for="birthdate" :value="__('Birthdate')" />
                <x-date-picker id="birthdate" name="visitor[birthdate]" class="mt-1 block w-full" :value="old('visitor.birthdate', $visitorProfile->birthdate ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('visitor.birthdate')" />

                <x-input-label for="gender" :value="__('Gender')" />
                <x-select id="gender" name="visitor[gender]" class="mt-1 block w-full">
                    <option value="male" @if (old('visitor.gender', $visitorProfile->gender ?? '') === 'male') selected @endif>{{ __('Male') }}
                    </option>
                    <option value="female" @if (old('visitor.gender', $visitorProfile->gender ?? '') === 'female') selected @endif>{{ __('Female') }}
                    </option>
                    <option value="other" @if (old('visitor.gender', $visitorProfile->gender ?? '') === 'other') selected @endif>{{ __('Other') }}
                    </option>
                </x-select>
                <x-input-error class="mt-2" :messages="$errors->get('visitor.gender')" />

                <x-input-label for="bio" :value="__('Bio')" />
                <x-textarea id="bio" name="visitor[bio]" class="mt-1 block w-full" :value="old('visitor.bio', $visitorProfile->bio ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('visitor.bio')" />
            </div>
        @endif

        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
