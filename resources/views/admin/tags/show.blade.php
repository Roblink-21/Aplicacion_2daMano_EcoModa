@extends('dashboard')

@section('content')

<div class="mt-2">
    <x-form-section>

        <x-slot name="title">{{ __("Tag information") }}</x-slot>

        <x-slot name="description">
            {{ __("You can view the director's information.") }}
        </x-slot>


    </x-form-section>
</div>

@endsection