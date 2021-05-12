<x-app-layout>
    <x-slot name="header">
        <div class="slider md:mx-12">
            <div class="slider__container">
                <div class="slider__wrapper bg-gradient-to-r from-blue-100 to-pink-100 rounded-xl py-3">
                    <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
                        {{ __('Новинки:') }}
                    </h2>
                    <div class="slider__items">
                        @foreach($news as $key=>$product)
                            @if(count($news)!==0)
                                <div class="slider__item flex md:flex-auto justify-center items-top px-3 my-5">
                                    <div class="flex flex-col w-64">
                                        <a href="/{{$product->id}}">
                                            <img class="h-96 w-full rounded-xl" src="{{asset('storage/'.$product->image)}}" title="" alt="">
                                        </a>
                                        <label>
                                            <span class="block">
                                                <a href="/{{$product->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">
                                                    {{$product->name}}
                                                </a>
                                            </span>
                                            <span class="inline">
                                                <a href="/shop/author/{{$product->author->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">
                                                    {{$product->author->last_name." ".$product->author->initials}}
                                                </a>
                                            </span>
                                            <span class="inline"><x-btn body="info" class="cart mt-1 px-1 py-1"> Купить</x-btn></span>
                                        </label>
                                    </div>
                                </div>
                            @endif
                            @if($key === 9)
                                @break
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <a class="slider__control" data-slide="prev"></a>
            <a class="slider__control" data-slide="next"></a>
            <ol class="slider__indicators">
                @foreach($news as $key=>$product)
                    @if(count($news)==1)
                        <li data-slide-to="{{$key}}"></li>
                    @endif
                    @if(count($news)!==0)
                        <li data-slide-to="{{$key}}"></li>
                    @endif
                    @if($key === 9)
                        @break
                    @endif
                @endforeach
            </ol>
        </div>
    </x-slot>

    <div class="container mx-auto my-5">
        <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight my-5">
            <a href="{{route('shop.shop')}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">{{ __('Магазин') }}</a>
        </h2>
        <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
            {{ __('Книги автора: '.$products[0]->author->last_name." ".$products[0]->author->initials) }}
        </h2>
        <div class="flex flex-col my-5">
            <div class="navigation flex flex-row w-full justify-center items-center mb-2">
                <a href="?page=1" class="px-2 py-1 border border-black rounded-l-md cursor-pointer hover:bg-blue-100"><</a>
                @for ($i=1;$i<=$products->lastPage(); $i++)
                    @if (request()->page == $i)
                        <a href="?page={{$i}}" class="px-2 py-1 border border-black cursor-pointer hover:bg-blue-100 bg-blue-100 ">{{$i}}</a>
                    @else
                        <a href="?page={{$i}}" class="px-2 py-1 border border-black cursor-pointer hover:bg-blue-100 ">{{$i}}</a>
                    @endif
                @endfor
                <a href="?page={{$products->lastPage()}}" class="px-2 py-1 border border-black rounded-r-md cursor-pointer hover:bg-blue-100">></a>
            </div>
            @if (!count($products))
                <div class="content flex flex-col w-full border-2 border-gray-300 rounded-xl mt-3">
                    <div class="flex flex-row justify-center items-center">
                        <p>Нет такой страницы</p>
                    </div>
                </div>
            @endif
            @foreach($products as $product)
                <div class="content flex flex-col w-full border-2 border-gray-300 rounded-xl mt-3">
                    <div class="flex flex-row justify-center items-center">
                        <a href="/{{$product->id}}" class="m-5">
                            <img class="w-44 cursor-pointer" src="{{asset('storage/'.$product->image)}}" alt="">
                        </a>
                        <div class="content-text flex flex-col w-full">
                            <label><span class="font-semibold italic text-purple-400">Название: </span>{{$product->name}}</label>
                            <label>
                                <span class="font-semibold italic text-purple-400">Автор: </span>
                                {{$product->author->last_name." ".$product->author->initials}}
                            </label>
                            <label>
                                <span class="font-semibold italic text-purple-400">Жанры: </span>
                                @foreach($product->genres as $key=>$genre)
                                    {{$genre->genre->name}}@if(count($product->genres)!==++$key){{', '}}@endif
                                @endforeach
                            </label>
                            <label>
                                <span class="font-semibold italic text-purple-400">Издательство: </span>
                                {{$product->publisher->name}}
                            </label>
                            <label> <span class="font-semibold italic text-purple-400">Год издания: </span> {{$product->year_release}}</label>
                            <label>
                                <span class="font-semibold italic text-purple-400">Описание: </span>{{mb_substr($product->description,0,200)}}
                                <span class="descOpen text-sm text-gray-400 border-b border-gray-400">весь текст</span>
                            </label>
                            <label class="hidden"><span class="font-semibold italic text-purple-400">Описание: </span>{{$product->description}}
                                <span class="descClose text-sm text-gray-400 border-b border-gray-400">скрыть</span> </label>
                        </div>
                        <div class="content-price mx-5 p-3 flex flex-col items-center justify-center bg-blue-200 rounded-md w-32">
                            <span>{{$product->price}} руб.</span>
                            <x-btn body="success" class="cart" data-id="{{$product->id}}">
                                Купить
                            </x-btn>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="navigation flex flex-row w-full justify-center items-center mt-2">
                <a href="?page=1" class="px-2 py-1 border border-black rounded-l-md cursor-pointer hover:bg-blue-100"><</a>
                @for ($i=1;$i<=$products->lastPage(); $i++)
                    @if (request()->page == $i)
                        <a href="?page={{$i}}" class="px-2 py-1 border border-black cursor-pointer hover:bg-blue-100 bg-blue-100 ">{{$i}}</a>
                    @else
                        <a href="?page={{$i}}" class="px-2 py-1 border border-black cursor-pointer hover:bg-blue-100 ">{{$i}}</a>
                    @endif
                @endfor
                <a href="?page={{$products->lastPage()}}" class="px-2 py-1 border border-black rounded-r-md cursor-pointer hover:bg-blue-100">></a>
            </div>
        </div>
    </div>
    <script src="{{asset('js/cart.js')}}"></script>
    <script src="{{asset('js/shop.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new ChiefSlider('.slider', {
                loop: true,
                autoplay: true,
                interval: 5000,
                refresh: true,
            });
        });
    </script>
</x-app-layout>
