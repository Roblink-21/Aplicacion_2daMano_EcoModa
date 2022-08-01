@extends('dashboard')

@section('content')

<div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">  

    <div class="grid grid-col-1 gap-6">
    
        <div class="grid grid-cols-12 gap-3 px-4 sm:px-0">
            <div class="col-span-12 md:col-span-8">
                <h3 class="text-lg font-medium text-gray-900">
                    {{ __("List of products") }}
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                    {{ __("List of users with the role of products and who have been registered in the system.") }}
                </p>
            </div>
    
            <div class="col-span-12 md:col-span-4 flex items-center mx-auto max-w-max md:w-full">
                <form method="GET" action="{{ route('products.index') }}" >
                    <x-search/>
                </form>
            </div>
    
        </div>

        @foreach($products as $post)

        <x-card-product :post="$post"/>
            
        @endforeach

    </div>

    <div class="mt-4">
            {{$products->links()}}
    </div>

</div>


{{-- <div class="bg-white p-6 md:p-8 shadow-md">
    <div class="grid grid-cols-12 gap-3 px-4 sm:px-0">
        <div class="col-span-12 md:col-span-8">
            <h3 class="text-lg font-medium text-gray-900">
                {{ __("List of products") }}
            </h3>
            <p class="mt-1 text-sm text-gray-600">
                {{ __("List of users with the role of products and who have been registered in the system.") }}
            </p>
        </div>

        <div class="col-span-12 md:col-span-4 flex items-center mx-auto max-w-max md:w-full">
            <form method="GET" action="{{ route('products.index') }}" >
                <x-search/>
            </form>
        </div>

    </div>

    <x-table.list>
        <x-slot name="thead">
            <tr>
                <x-table.th>{{ __("Name") }}</x-table.th>
                <x-table.th>{{ __("Details") }}</x-table.th>
                <x-table.th>{{ __("Price") }}</x-table.th>
            </tr>
        </x-slot>

        <x-slot name="tbody">

            @foreach($products as $product)
                <tr>
                    <x-table.td class=" space-x-3 whitespace-nowrap">
                        <x-user-avatar class="hidden md:inline-flex" src="{{  $product->image->getUrl() }}"/>
                        <p class="inline-flex">{{ $product->name }}</p>
                    </x-table.td>

                    <x-table.td>
                        {{ $product->details }}
                    </x-table.td>
                    <x-table.td>
                        {{ $product->price }}
                    </x-table.td>
                </tr>
            @endforeach

        </x-slot>
    </x-table.list>
</div> --}}
@endsection