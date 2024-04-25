<section>
    <header>
        <h5 class="ml-3 text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h5>

        <p class="ml-3 mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success my-3 ml-3">
                Your account's profile updated successfully.
            </div>
        @elseif(session('status') === 'image-removed')
            <div class="alert alert-success my-3 ml-3">
                Your account's profile image deleted successfully.
            </div>
        @endif
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="needs-validation" novalidate="" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="col-12 col-sm-12 col-lg-12">
            <div class="form-group">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="form-control" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2 text-danger" :messages="$errors->get('name')" />
                <div class="invalid-feedback">
                    Name fields is required
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-lg-12">
            <div class="form-group">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="form-control" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2 text-danger" :messages="$errors->get('email')" />
                <div class="invalid-feedback">
                    Email fields is required
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-lg-12">
            <div class="form-group">
                <x-input-label for="image" :value="__('Image')" />
                <input type="file" name="image" class="form-control" value="{{ isset($user->image)?$user->image : old('image') }}" />
                <x-input-error class="mt-2 text-danger" :messages="$errors->get('image')" />
            </div>
        </div>
        @if($user->image)
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="form-group">
                    <img src="{{ asset('storage/profile_images/' . auth()->user()->image) }}" title="Profile Image" class="img-fluid" width="120" alt="Profile Image">
                </div>
                <a href="{{ route('profile.remove-image', ['user' => $user]) }}" title="Remove Profile Image" class="btn btn-danger btn-sm mb-2"><i class="fa fa-trash"></i></a>
            </div>
        @endif
        <div class="col-12 col-sm-12 col-lg-6">
            <div class="form-group">
                <div class="flex items-center gap-4">
                    <x-primary-button class="btn btn-primary">{{ __('Save') }}</x-primary-button>
                </div>
            </div>
        </div>
    </form>
</section>
