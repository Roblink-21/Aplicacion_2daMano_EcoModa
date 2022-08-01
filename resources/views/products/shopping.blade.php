@extends('dashboard')

@section('content')
    @foreach ($products as $post)
        <x-card-product :post="$post" />
        @php
            $id_product = $post->id;
            
        @endphp
        <a href="{{ route('products.destroy', $id_product) }}" style="margin-left: 300px"
            class="inline-block px-3 h-6 bg-gray-600 text-white rounded-full">Discard</a>
        @if (!($post->status == 2))
            <a href="{{ route('products.addBuy', $id_product) }}" style="margin-left: 300px"
                class="inline-block px-3 h-6 bg-gray-600 text-white rounded-full">Reservar</a>
        @else
            <p>El producto ya ha fue reservado por otro usuario.</p>
        @endif
    @endforeach
@endsection
