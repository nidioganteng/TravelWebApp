<div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-900 mb-1">Update Password</h3>
    <p class="text-xs text-gray-500 mb-6">Ensure your account is using a long, random password to stay secure</p>
    
    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="space-y-6">
            {{-- Current Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-2">Current Password</label>
                <input type="password" name="current_password" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-gray-900 px-4 py-3" autocomplete="current-password">
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            {{-- New Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-2">New Password</label>
                <input type="password" name="password" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-gray-900 px-4 py-3" autocomplete="new-password">
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            {{-- Confirm Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-gray-900 px-4 py-3" autocomplete="new-password">
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            {{-- Save Button --}}
            <div class="flex justify-end pt-4 items-center gap-4">
                @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600">
                        {{ __('Saved.') }}
                    </p>
                @endif
                <button type="submit" class="bg-[#0099FF] hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-lg transition duration-300">
                    Save
                </button>
            </div>
        </div>
    </form>
</div>