<x-app-layout>
    <x-slot name="header">
        @foreach($products as $product)
        <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
            {{ __($product->name) }}
        </h2>
        <div class="flex flex-row w-full justify-center items-top my-5">
            <div class="mr-4">
                <img class="w-96 rounded-xl" src="{{asset('storage/'.$product->image)}}" title="" alt="">
            </div>
            <div class="flex flex-col justify-start">
                <label><span class="font-semibold italic text-purple-400">ISBN: </span> {{$product->ISBN}}</label>
                <label><span class="font-semibold italic text-purple-400">Название: </span> {{$product->name}}</label>
                <label><span class="font-semibold italic text-purple-400">Стоимость: </span> {{$product->price.' руб.'}}</label>
                <label><span class="font-semibold italic text-purple-400">Количество страниц: </span> {{$product->pages}}</label>
                <label><span class="font-semibold italic text-purple-400">Год издания: </span> {{$product->year_release}}</label>
                <label><span class="font-semibold italic text-purple-400">Автор: </span> <a href="/shop/author/{{$product->author->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-100">{{$product->author->last_name." ".$product->author->initials}}</a></label>
                <label><span class="font-semibold italic text-purple-400">Возрастные ограничения: </span> <a href="/shop/limit/{{$product->limit->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-100">{{$product->limit->name}}</a></label>
                <label><span class="font-semibold italic text-purple-400">Издательство: </span> <a href="/shop/publisher/{{$product->publisher->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-100">{{$product->publisher->name}}</a></label>
                <label class="flex flex-row"><span class="font-semibold italic text-purple-400 mr-2">Жанры: </span>
                    @foreach($product->genres as $key=>$genre)
                        <a href="/shop/genre/{{$genre->genre->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-100"> {{$genre->genre->name}}</a>
                        @if(count($product->genres)!==++$key)
                            {{','}}
                        @endif
                    @endforeach
                </label>
                <label class="max-w-xl">
                    <span class="font-semibold italic text-purple-400">Описание: </span>
                    <span>{{$product->description}}</span>
                </label>
                <span>
                    <x-btn body="info" class="cart px-1 py-1"> Купить</x-btn>
                </span>
            </div>
        </div>
        @endforeach
    </x-slot>
    <div class="slider sliderGenre my-12 mx-12">
        <div class="slider__container">
            <div class="slider__wrapper bg-gradient-to-r from-blue-100 to-pink-100 rounded-xl py-3">
                <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
                    {{ __('Книги этого жанра:') }}
                </h2>
                <div class="slider__items">
                    @foreach($genres[0]->products as $key=>$product)
                        @if($genres[0]->products !==0)
                            <div class="slider__item flex flex-auto justify-center items-top my-5">
                                <div class="mr-4">
                                    <div class="flex flex-col w-36">
                                        <a href="/shop/{{$product->product->id}}">
                                            <img class="w-full rounded-xl" src="{{asset('storage/'.$product->product->image)}}" title="" alt="">
                                        </a>
                                        <label><span>
                                                {{$product->product->author->last_name." ".$product->product->author->initials}}
                                            </span></label>
                                        <label>
                                            <span class="inline">{{$genres[0]->name}}</span>
                                            <span class="inline"><x-btn body="info" class="cart px-1 py-1"> Купить</x-btn></span>
                                        </label>
                                    </div>

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
            @foreach($genres[0]->products as $key=>$product)
                @if(count($genres[0]->products)==1)
                    <li data-slide-to="{{$key}}"></li>
                @endif
                @if(count($genres[0]->products)!==0)
                    <li data-slide-to="{{$key}}"></li>
                @endif
                @if($key === 9)
                    @break
                @endif
            @endforeach
        </ol>
    </div>
    <div class="slider sliderAuthor my-12 mx-12">
        <div class="slider__container">
            <div class="slider__wrapper bg-gradient-to-r to-blue-100 from-pink-100 rounded-xl py-3">
                <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
                    {{ __('Книги '.$products[0]->author->last_name." ".$products[0]->author->initials.":") }}
                </h2>
                <div class="slider__items">
                    @foreach($authors[0]->products as $key=>$product)
                        @if(isset($product))
                            <div class="slider__item flex flex-auto justify-center items-center my-5">
                                <div class="mr-4">
                                    <div class="flex flex-col w-32 ">
                                        <a href="/shop/{{$product->id}}">
                                            <img class=" w-full rounded-xl" src="{{asset('storage/'.$product->image)}}" title="" alt="">
                                        </a>
                                        <label>
                                            <span class="inline">{{$authors[0]->last_name." ".$authors[0]->initials}}</span>
                                            <span class="inline"><x-btn body="info" class="cart px-1 py-1"> Купить</x-btn></span>
                                        </label>
                                    </div>
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
            @foreach($authors[0]->products as $key=>$product)
                @if(count($authors[0]->products)==1)
                    <li data-slide-to="{{$key}}"></li>
                @endif
                @if(isset($product))
                    <li data-slide-to="{{$key}}"></li>
                @endif
                @if($key === 9)
                    @break
                @endif
            @endforeach
        </ol>
    </div>
    <div class="slider sliderLimit my-12 mx-12">
        <div class="slider__container">
            <div class="slider__wrapper bg-gradient-to-r from-blue-100 to-pink-100 rounded-xl py-3">
                <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
                    {{ __('Книги этой возрастной категории:') }}
                </h2>
                <div class="slider__items">
                    @foreach($limits[0]->products as $key=>$product)
                        @if(isset($product))
                            <div class="slider__item flex flex-auto justify-center items-top my-5">
                                <div class="mr-4">
                                    <div class="flex flex-col w-32 ">
                                        <a href="/shop/{{$product->id}}">
                                            <img class="w-full rounded-xl" src="{{asset('storage/'.$product->image)}}" title="" alt="">
                                        </a>
                                        <label class="w-32">
                                            <span>{{$product->author->last_name." ".$product->author->initials}}</span>
                                            <span class="inline"><x-btn body="info" class="cart px-1 py-1"> Купить</x-btn></span>
                                        </label>
                                    </div>
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
            @foreach($limits[0]->products as $key=>$product)
                @if(count($limits[0]->products)===1)
                    <li data-slide-to="{{$key}}"></li>
                @endif
                @if(isset($product))
                    <li data-slide-to="{{$key}}"></li>
                @endif
                @if($key === 9)
                    @break
                @endif
            @endforeach
        </ol>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new ChiefSlider('.sliderGenre', {
                loop: false,
            });
            new ChiefSlider('.sliderAuthor', {
                loop: false,
            });
            new ChiefSlider('.sliderLimit', {
                loop: false,
            });
        });
    </script>
</x-app-layout>
