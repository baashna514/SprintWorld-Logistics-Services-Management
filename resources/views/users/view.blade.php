<form method="post" action="{{ route('updateUserDetails', ['id' => $user->id]) }}" class="needs-validation" novalidate="" enctype="multipart/form-data">
    @csrf
    <div class="col-12 col-sm-12 col-lg-12">
        <div class="form-group">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="form-control" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <div class="invalid-feedback">
                Name fields is required
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-lg-12">
        <div class="form-group">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="form-control" :value="old('email', $user->email)" required autocomplete="username" />
            <div class="invalid-feedback">
                Email fields is required
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-lg-6">
        <div class="form-group">
            <div class="flex items-center gap-4">
                <x-primary-button class="btn btn-primary">{{ __('Save') }}</x-primary-button>
            </div>
        </div>
    </div>
</form>
