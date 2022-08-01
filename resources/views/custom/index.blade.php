@extends('dashboard')

@section('content')

<div class="bg-white p-8 rounded-md w-full">
	<div class=" flex items-center justify-between pb-6">
		<div>
			<h2 class="text-gray-600 font-semibold">Products Oder</h2>
			<span class="text-xs">All products item</span>
		</div>
		<div class="flex items-center justify-between">
			<div class="flex bg-gray-50 items-center p-2 rounded-md">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
					fill="currentColor">
					<path fill-rule="evenodd"
						d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
						clip-rule="evenodd" />
				</svg>
				<input class="bg-gray-50 outline-none ml-1 block " type="text" name="" id="" placeholder="search...">
          </div>
				<div class="lg:ml-40 ml-10 space-x-8">
                    <a class="border border-indigo-500 bg-indigo-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline" href="{{route('custom.create')}}">Agregar un nuevo Producto</a>
				</div>
			</div>
		</div>
		<div>
			<div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
				<div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
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
									Editar
								</th>
								<th
									class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
									Eliminar
								</th>
							</tr>
						</thead>
						<tbody>
                            @foreach ($posts as $post)
                            <tr>
                                <td>
                                    @if (empty($post->image))
                                        N/A
                                    @else
                                        <x-user-avatar class="hidden md:inline-flex" src="{{  $post->image->getUrl() }}"/>
                                    @endif
                                </td>
                                <td>{{$post -> name}}</td>
                                <td>{{$post -> price}}</td>
                                <td width="10px">
                                    <x-link color="indigo" class="inline-flex"
									href="{{ route('custom.edit', ['post' => $post->id]) }}">
                                    <x-icons.edit/>
                                    Editar
                                </x-link>
                                </td>
                                <td width="10px">
									<x-link class="inline-flex"
										href="{{ route('custom.destroy', $post) }}">
									@if($post->status == 0)
										<x-icons.delete/>
									@elseif ($post->status == 3)
										<x-icons.check/>
									@endif
								    </x-link>
                                </td>
                            </tr>
                        @endforeach
						</tbody>
					</table>
					
				</div>
				<div class="mt-4">
					{{$posts->links()}}
				</div>
			</div>
		</div>
	</div>

@endsection