@extends('dashboard')

@section('content')

<div class="py-8">
    <h1 class="uppercase text-center text-3xl font-bold">
        Etiqueta: {{$tag -> name}}
    </h1>

    @foreach ($posts as $post)
        <x-card-product :post="$post"/>
    @endforeach


    <div class="mt-4">
        {{$posts->links()}}
    </div>

</div>



@endsection