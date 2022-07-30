@props(['post'])

<article class="mb-8 bg-cover bg-center border-4">
    <div class="my-2">
        @foreach($post->tags as $tag)
                <a href="{{route('products.tag', $tag)}}" class="inline-block px-3 h-6 bg-gray-600 text-white rounded-full">{{$tag->name}}</a>
        @endforeach
    </div>
    @if (empty($post->image))
         N/A
    @else
        <x-user-avatar class="hidden md:inline-flex" src="{{  $post->image->getUrl() }}"/>
    @endif
    <a href="{{route('products.show', $post)}}" class="inline-flex">
        {{ $post->name }}
    </a>
    <div class="mx-auto" style="width: 575px;">
        <p class="bg-right inline-flex">Precio: {{ $post->price }}</p>
    </div>
</article>