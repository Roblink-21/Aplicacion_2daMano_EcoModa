@extends('dashboard')

@section('content')

<div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">  

    <div class="grid grid-col-1 gap-6">
    
        <div class="grid grid-cols-12 gap-3 px-4 sm:px-0">
            <div class="col-span-12 md:col-span-8">
                <h3 class="text-lg font-medium text-gray-900">
                    {{ __("Detail of my product") }}
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                    {{ __("List of users with the role of products and who have been registered in the system.") }}
                </p>
            </div>
    
            
    
        </div>

    </div>

</div>


@endsection