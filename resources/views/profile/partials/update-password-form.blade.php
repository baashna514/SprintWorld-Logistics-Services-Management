<section>
    <header>
        <h5 class="ml-3 text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h5>

        <p class="ml-3 mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="needs-validation" novalidate="">
        @csrf
        @method('put')

        <div class="col-12 col-sm-12 col-lg-12">
            <div class="form-group">
                <x-input-label for="update_password_current_password" :value="__('Current Password')" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="form-control mt-1 block w-full" autocomplete="current-password" required="" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="text-danger mt-2" />
                <div class="invalid-feedback">
                    Old password fields is required
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-lg-12">
            <div class="form-group">
                <x-input-label for="update_password_password" :value="__('New Password')" />
                <x-text-input id="update_password_password" name="password" type="password" class="form-control mt-1 block w-full" autocomplete="new-password" required="" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="text-danger mt-2" />
                <div class="invalid-feedback">
                    New password fields is required
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-lg-12">
            <div class="form-group">
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control mt-1 block w-full" autocomplete="new-password" required="" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="text-danger mt-2" />
                <div class="invalid-feedback">
                    Old password confirmation fields is required
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-lg-6">
            <div class="form-group">
                <div class="flex items-center gap-4">
                    <x-primary-button class="btn btn-primary">{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'password-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </div>
    </form>
</section>
