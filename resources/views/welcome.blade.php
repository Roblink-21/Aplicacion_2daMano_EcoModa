@extends('dashboard')

@section('content')

@foreach ($categories as $category)
<a href="{{route('products.category', $category)}}" class="inline-block px-3 h-6 bg-gray-600 text-white rounded-full">{{$category->name}}</a>
@endforeach

@endsection