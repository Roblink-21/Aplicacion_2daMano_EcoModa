@extends('dashboard')

@section('content')

    <div class="mt-2">
        <x-form-section>

            <x-slot name="title">{{ __("Create a new Post") }}</x-slot>

            <x-slot name="description">
                {{ __("You can register a new post in the store.") }}
            </x-slot>

            <x-slot name="form">
                <form method="POST" action="{{ route('custom.store') }}" enctype="multipart/form-data"
                      class="grid grid-cols-6 gap-6">
                    @csrf
                    <!--Title-->
                    <div class="col-span-6">
                        <x-label for="name" :value="__('Name')"/>

                        <x-input id="name"
                                 class="block mt-2 w-full"
                                 type="text"
                                 name="name"
                                 :value="old('name')"
                                 placeholder="Enter the name of Product"
                                 maxlength="45"
                                 required/>

                        <x-input-error for="name" class="mt-2"/>
                    </div>

                    <!--Slug-->
                    <div class="col-span-6">
                        <x-label for="slug" :value="__('Slug')"/>

                        <x-input id="slug"
                                 class="block mt-2 w-full"
                                 type="text"
                                 name="slug"
                                 :value="old('slug')"
                                 placeholder="Enter the slug of Product"
                                 maxlength="45"
                                 required/>

                        <x-input-error for="slug" class="mt-2"/>
                    </div>

                    <!--Details-->
                    <div class="col-span-6">
                        <x-label for="details" :value="__('Detail')"/>

                        <x-input id="details"
                                 class="block mt-2 w-full"
                                 type="text"
                                 name="details"
                                 :value="old('details')"
                                 placeholder="Enter the detail of Product"
                                 maxlength="45"
                                 required/>

                        <x-input-error for="details" class="mt-2"/>
                    </div>

                    <!--Price-->
                    <div class="col-span-6">
                        <x-label for="price" :value="__('Price')"/>

                        <x-input id="price"
                                 class="block mt-2 w-full"
                                 type="number"
                                 name="price"
                                 :value="old('price')"
                                 placeholder="Enter the price of Product"
                                 required/>

                        <x-input-error for="price" class="mt-2"/>
                    </div>

                    <!--Description-->
                    <div class="col-span-6">
                        <x-label for="description" :value="__('Description')"/>

                        <x-text-area id="description"
                                  name="description"
                                  class="block mt-2 w-full"
                                  rows="6"
                                  placeholder="Enter the description"
                                  maxlength="255"
                                  required>{{old('description')}}</x-text-area>

                        <x-input-error for="description" class="mt-2"/>
                    </div>

                    <!--Category-->

                    <div class="col-span-6">
                        <x-label for="category_id" :value="__('Category')"/>

                        <select name="category_id" id="inputCategoria_id" class="form-control">
                            
                            <option value="">-- Choose the category --</option>

                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category -> name}}</option>
                            @endforeach

                        </select>
                        <x-input-error for="category_id" class="mt-2"/>
                    </div>

                    <!--Tag-->

                    <div class="col-span-6 form-group">
                        <p class="font-weight-bold">Tags</p>

                        @foreach($tags as $tag)
                                <label class="mr-2">
                                    <input type="checkbox" name="tags[]" value="{{$tag->id}}">
                                    {{$tag->name}}
                                </label>
                        @endforeach
                        <x-input-error for="tags[]" class="mt-2"/>
                    </div>

                    <!--Image-->
                    <div class="col-span-6">
                        <x-label for="image">
                            {{ __('Image') }}
                            <span class="text-sm ml-2 text-gray-400"> ({{ __('Optional') }})</span>
                        </x-label>

                        <x-input id="image"
                                 class="block mt-2 w-full"
                                 type="file"
                                 name="image"/>

                        <x-input-error for="image" class="mt-2"/>
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

