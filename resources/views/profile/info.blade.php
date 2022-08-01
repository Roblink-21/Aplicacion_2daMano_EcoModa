@extends('dashboard')


@section('content')

<!-- component -->
<div class="px-3 md:lg:xl:px-40   border-t border-b py-20 bg-opacity-10" style="background-image: url('https://www.toptal.com/designers/subtlepatterns/uploads/dot-grid.png') ;">
    <div class="grid grid-cols-1 md:lg:xl:grid-cols-3 group bg-white shadow-xl shadow-neutral-100 border ">


        <div
            class="p-10 flex flex-col items-center text-center group md:lg:xl:border-r md:lg:xl:border-b hover:bg-slate-50 cursor-pointer">
            <img class="w-36 h-20 object-cover object-center"src="{{$similar->image->getUrl()}}" alt="">
            <p class="text-xl font-medium text-slate-700 mt-3">Nombre: {{$similar -> first_name}}</p>
            <p class="text-xl font-medium text-slate-700 mt-3">Apellido: {{$similar -> last_name}}</p>
            <p class="mt-2 text-sm text-slate-500">Nick: {{$similar -> username}}</p>
        </div>

        <div class="p-10 flex flex-col items-center text-center group   md:lg:xl:border-b hover:bg-slate-50 cursor-pointer">
            <span class="p-5 rounded-full bg-yellow-500 text-white shadow-lg shadow-yellow-200"><svg
                    xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                </svg></span>
            <p class="text-xl font-medium text-slate-700 mt-3">Contacto</p>
            <p class="mt-2 text-sm text-slate-500">Professional Advice for higher education abroad and select the
                top institutions worldwide.</p>
                <p class="mt-2 text-sm text-slate-500">{{$similar -> email}}</p>
                <p class="mt-2 text-sm text-slate-500">{{$similar -> personal_phone}}</p>
        </div>


    </div>

    <div class="w-full   bg-indigo-600 shadow-xl shadow-indigo-200 py-10 px-20 flex justify-between items-center">
        <p class=" text-white"> <span class="text-4xl font-medium">Still Confused ?</span> <br> <span class="text-lg">Book For Free Career Consultation Today ! </span></p>
        <button class="px-5 py-3  font-medium text-slate-700 shadow-xl  hover:bg-white duration-150  bg-yellow-400">Reputacion: {{$similar -> score}}</button>
    </div>

    <div class="p-10 flex flex-col group md:lg:xl:border-r md:lg:xl:border-b hover:bg-slate-50 cursor-pointer">

        <span class="flex p-5 rounded-full bg-red-500 text-white shadow-lg shadow-red-200"><svg
            xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg> <p class="ml-2 text-xl font-medium text-slate-700 mt-3">Productos a la venta</p> </span>
        

        @foreach($yours_products as $post)

        <x-card-product :post="$post"/>
            
        @endforeach
    </div>

    <div class="mt-4">
        {{$yours_products->links()}}
    </div>

</div>

@endsection()