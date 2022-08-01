@extends('dashboard')

@section('content')

   <div class="mt-2">
        <x-form-section>

            <x-slot name="title">{{ __("Create a new category") }}</x-slot>

            <x-slot name="description">
                {{ __("You can register a new category.") }}
            </x-slot>

            <x-slot name="form">
                <form method="POST" action="{{ route('admin.categories.store') }}" class="grid grid-cols-6 gap-6">
                    @csrf

                    <!--name-->
                    <div class="col-span-6 sm:col-span-3">
                        <x-label for="name" :value="__('Nombre')"/>

                        <x-input id="name"
                                 class="block mt-2 w-full"
                                 type="text"
                                 name="name"
                                 :value="old('name')"
                                 placeholder="Enter the name of the category"
                                 maxlength="35"
                                 required/>

                        <x-input-error for="name" class="mt-2"/>
                       
                    </div>

                    <!--Slug-->
                    <div class="col-span-6 sm:col-span-3">
                        <x-label for="slug" :value="__('Slug')"/>

                        <x-input id="slug"
                                 class="block mt-2 w-full"
                                 type="text"
                                 name="slug"
                                 :value="old('slug')"
                                 placeholder="Enter the slug of the Category"
                                 maxlength="35"
                                 required/>

                        <x-input-error for="slug" class="mt-2"/>
                    </div>

                    <!--Actions-->
                    <div class="col-span-6 flex justify-end">
                        <x-button class="min-w-max">{{ __('Create') }}</x-button>
                    </div>
                </form>
            </x-slot>

        </x-form-section>
    </div>
@endsection
