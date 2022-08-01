@extends('dashboard')

@section('content')

    @if (empty($products_history) && empty($products_reserve))
        <p>no hay productos pendientes</p>

        <p>no hay productos recientemente comprados</p>
    @elseif(!empty($products_reserve) && empty($products_history))

        <div class="my-2">

            <p class="ml-2 text-xl font-medium text-slate-700 mt-3">Productos reservados</p> </span>

            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            IMAGEN
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            NAME
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Cost
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Vendor Information
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Buy
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products_reserve as $post)
                        <tr>
                            <td>
                                @if (empty($post->image))
                                    N/A
                                @else
                                    <x-user-avatar class="hidden md:inline-flex" src="{{ $post->image->getUrl() }}" />
                                @endif
                            </td>
                            <td>{{ $post->name }}</td>
                            <td width="10px">{{ $post->price }}</td>
                            @php
                                $mostrarVendor = $post->user;
                                $id_product = $post -> id;
                            @endphp
                            <td>
                                <p>{{ $mostrarVendor->username }}</p>
                                <p>{{ $mostrarVendor->personal_phone }}</p>
                                <p>{{ $mostrarVendor->email }}</p>

                            </td>
                            <td width="10px">
                                <a href="{{ route('products.bought', $id_product) }}"
                                class="inline-block px-3 h-6 bg-gray-600 text-white rounded-full">Comprar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>



        <p>
            No hay registro de productos comprados.
        </p>
    @else

    <div class="my-2">

        <p class="ml-2 text-xl font-medium text-slate-700 mt-3">Productos reservados</p> </span>

        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        IMAGEN
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        NAME
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Cost
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Vendor Information
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Buy
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products_reserve as $post)
                    <tr>
                        <td>
                            @if (empty($post->image))
                                N/A
                            @else
                                <x-user-avatar class="hidden md:inline-flex" src="{{ $post->image->getUrl() }}" />
                            @endif
                        </td>
                        <td>{{ $post->name }}</td>
                        <td width="10px">{{ $post->price }}</td>
                        @php
                            $mostrarVendor = $post->user;
                            $id_product = $post -> id;
                        @endphp
                        <td>
                            <p>{{ $mostrarVendor->username }}</p>
                            <p>{{ $mostrarVendor->personal_phone }}</p>
                            <p>{{ $mostrarVendor->email }}</p>

                        </td>
                        <td width="10px">
                            <a href="{{ route('products.bought', $id_product) }}"
                            class="inline-block px-3 h-6 bg-gray-600 text-white rounded-full">Comprar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>

    <div class="my-2">

        <p class="ml-2 text-xl font-medium text-slate-700 mt-3">Productos comprados</p> </span>

        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        IMAGEN
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        NAME
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Cost
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Vendor Information
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products_history as $post)
                    <tr>
                        <td>
                            @if (empty($post->image))
                                N/A
                            @else
                                <x-user-avatar class="hidden md:inline-flex" src="{{ $post->image->getUrl() }}" />
                            @endif
                        </td>
                        <td>{{ $post->name }}</td>
                        <td width="10px">{{ $post->price }}</td>
                        @php
                            $mostrarVendor = $post->user;
                            $id_product = $post -> id;
                        @endphp
                        <td>
                            <p>{{ $mostrarVendor->username }}</p>
                            <p>{{ $mostrarVendor->personal_phone }}</p>
                            <p>{{ $mostrarVendor->email }}</p>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>

    @endif

@endsection
