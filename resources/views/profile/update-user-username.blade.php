<div class="row shadow">

    <div class="col-5 py-2">


        <div class="container-fluid">
            <h4 class="mt-5">{{ __("Update username") }}</h4>
        </div>

        <div class="col mb-4 my-4 mx-4">
            <h6>
                {{ __("Update your username.") }}
            </h6>
        </div>
    </div>

    <div class="col">
        <div class="container">
            <form method="POST" action="{{ route('user-username.update') }}" class="grid grid-cols-6 gap-6 mt-5">
                @method('PUT')
                @csrf

                <!--Username-->
                <div class="mb-3 row">
                    <x-label for="username" class="col col-form-label" :value="__('Username')" />
                    <div class="col-sm-9">
                        <x-input id="username" class="form-control" type="text" name="username"
                            :value="old('username') ?? $user->username" placeholder="Enter your username" maxlength="20"
                            required />

                        <x-input-error for="username" class="mt-2" />
                    </div>
                </div>

                <!--Actions-->
                <div class="col-span-6 flex justify-end">    
                    <x-button class="min-w-max">{{ __('Update') }}</x-button>
                </div>
            </form>
        </div>

    </div>
</div>