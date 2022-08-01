@extends('dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <h1 class="text-4xl font-bold text-gray-600">{{ $product->name }}</h1>

        <div class="text-lg text-gray-500 mb-2">
            {{ $product->details }}
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- contenido principal --}}
            <div class="lg:col-span-2">

                <figure>
                    @if (empty($product->image))
                        N/A
                    @else
                        <img class="w-full h-80 object-cover object-center" src="{{ $product->image->getUrl() }}"
                            alt="">
                    @endif
                </figure>

                <div class="text-base text-gray-500 mt-4">

                    @php
                        $mostrarUser = $product->user;
                        $product_car = $product->id;
                        
                    @endphp
                   

                        <div class="row justify-content-around my-3" style="opacity: 0.5">
                            <div class="col-6 px-5">
                                <a>Precio: {{ $product->price }}</a>

                                <div style="display: contents">
                                    <a href="{{ route('products.add', $product_car) }}" style="margin-left: 300px"
                                        class="inline-block px-3 h-6 bg-gray-600 text-white rounded-full">+=</a>
                                    <a href="{{ route('products.buy', $product_car) }}"
                                        class="inline-block px-3 h-6 bg-gray-600 text-white rounded-full">Comprar</a>
                                </div>

                            </div>

                        </div>
                    


                    <a href="{{ route('profile.info', $mostrarUser) }}"
                        class="inline-block px-3 h-6 bg-gray-600 text-white rounded-full">Vendedor:
                        {{ $product->user->username }}</a>
                </div>

                <div class="text-base text-gray-500 mt-4">
                    {{ $product->description }}
                </div>


            </div>
            {{-- contenido relacionado --}}
            <aside>

                <h1 class="text-2xl font-bold text-gray-600 mb-4">Mas en {{ $product->category->name }}</h1>

                <ul>
                    @foreach ($similares as $similar)
                        <li class="mb-4">
                            <a class="flex" href="{{ route('products.show', $similar) }}">
                                <img class="w-36 h-20 object-cover object-center"src="{{ $similar->image->getUrl() }}"
                                    alt="">
                                <span class="ml-2 text-gray-600">{{ $similar->name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>

            </aside>
        </div>

    </div>
@endsection
