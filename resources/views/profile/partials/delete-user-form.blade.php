<div class="bg-white border border-gray-200 rounded-xl p-6 flex items-center justify-between">
    <div>
        <h3 class="text-lg font-bold text-gray-900">{{ __('user.delete_account') }}</h3>
        <p class="text-xs text-gray-500 mt-1">{{ __('user.delete_account_desc') }}</p>
    </div>
    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="bg-[#FF0000] hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
        {{ __('user.delete_account_button') }}
    </button>
</div>

<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('user.delete_account_confirm') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('user.delete_account_confirm_desc') }}
        </p>

        <div class="mt-6">
            <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

            <x-text-input
                id="password"
                name="password"
                type="password"
                class="mt-1 block w-3/4"
                placeholder="{{ __('user.delete_account_password_placeholder') }}" />

            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('user.delete_account_cancel_button') }}
            </x-secondary-button>

            <x-danger-button class="ms-3">
                {{ __('user.delete_account_confirm_button') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>