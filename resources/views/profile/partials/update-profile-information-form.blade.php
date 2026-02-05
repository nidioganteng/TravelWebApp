@php
$months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
@endphp

@if ($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
    <strong class="font-bold">{{ __('user.update.profile_error') }}</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-900 mb-6">{{ __('user.update.profile_section') }}</h3>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <input type="hidden" name="email" value="{{ $user->email }}">

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-2">{{ __('user.update.profile_fullname') }}</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-gray-900 px-4 py-3" required autocomplete="name">
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                <p class="mt-2 text-xs text-gray-500">{{ __('user.update.profile_fullname2') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">{{ __('user.update.profile_gender') }}</label>
                    <div class="relative">
                        <select name="gender" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-gray-900 appearance-none px-4 py-3 bg-white">
                            <option value="" disabled {{ is_null($user->gender) ? 'selected' : '' }}>{{ __('user.update.profile_gender_select') }}</option>
                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>{{ __('user.update.profile_genderMale') }}</option>
                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>{{ __('user.update.profile_genderFemale') }}</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">{{ __('user.update.profile_birthdate') }}</label>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="relative">
                            <select name="birth_day" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-gray-900 px-2 py-3 appearance-none bg-white">
                                <option value="" disabled selected>{{ __('user.update.profile_birthdateDay') }}</option>
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}" {{ old('birth_day', $user->birth_day) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>

                        <div class="relative">
                            <select name="birth_month" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-gray-900 px-2 py-3 appearance-none bg-white">
                                <option value="" disabled selected>{{ __('user.update.profile_birthdateMonth') }}</option>
                                @foreach ($months as $month)
                                <option value="{{ $month }}" {{ old('birth_month', $user->birth_month) == $month ? 'selected' : '' }}>{{ $month }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="relative">
                            <select name="birth_year" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-gray-900 px-2 py-3 appearance-none bg-white">
                                <option value="" disabled selected>{{ __('user.update.profile_birthdateYear') }}</option>
                                @for ($i = date('Y'); $i >= 1950; $i--)
                                <option value="{{ $i }}" {{ old('birth_year', $user->birth_year) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-2">{{ __('user.update.profile_residance') }}</label>
                <input type="text" name="city" value="{{ old('city', $user->city) }}" placeholder="{{ __('user.update.profile_residance2') }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-gray-900 px-4 py-3">
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>

            <div class="flex justify-end pt-4 items-center gap-4">
                @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600">
                    {{ __('user.update.profile_saved') }}
                </p>
                @endif
                <button type="submit" class="bg-[#0099FF] hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-lg transition duration-300">
                    {{ __('user.update.profile_save') }}
                </button>
            </div>
        </div>
    </form>
</div>


<div class="bg-white border border-gray-200 rounded-xl p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('user.update.profile_section2') }}</h3>
    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-100">
        <span class="font-bold text-gray-900">{{ __('user.update.profile_section2_list') }}</span>
        <span class="text-gray-900 font-semibold">{{ $user->email }}</span>
    </div>

    <!-- @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="mt-2 text-sm text-red-500">
            {{ __('Your email address is unverified.') }}
        </div>
    @endif -->
</div>