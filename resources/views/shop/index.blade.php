<x-app-layout>
    <x-slot name="header">
        <div class="slider sliderHead">
            <div class="slider__container">
                <div class="slider__wrapper bg-gradient-to-r from-blue-100 to-pink-100 rounded-xl py-3">
                    <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
                        {{ __('Новинки') }}
                    </h2>
                    <div class="slider__items ">
                        @foreach($products as $key=>$product)
                            @if(count($products)==1)
                                <div class="slider__item flex flex-row w-full justify-center items-top my-5">
                                    <div class="mr-4">
                                        <a href="/shop/{{$product->id}}">
                                            <img class="w-96 rounded-xl" src="{{asset('storage/'.$product->image)}}" title="" alt="">
                                        </a>
                                    </div>
                                    <div class="flex flex-col justify-start mt-10 font">
                                        <label><span class="font-semibold italic text-purple-400">ISBN: </span> {{$product->ISBN}}</label>
                                        <label><span class="font-semibold italic text-purple-400">Название: </span> <a href="/shop/{{$product->id}}">{{$product->name}}</a></label>
                                        <label><span class="font-semibold italic text-purple-400">Стоимость: </span> {{$product->price.' руб.'}}</label>
                                        <label><span class="font-semibold italic text-purple-400">Количество страниц: </span> {{$product->pages}}</label>
                                        <label><span class="font-semibold italic text-purple-400">Год издания: </span> {{$product->year_release}}</label>
                                        <label><span class="font-semibold italic text-purple-400">Автор: </span><a href="/shop/author/{{$product->author->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-100">{{$product->author->last_name." ".$product->author->initials}}</a></label>
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
                                        <label>
                                            <x-btn body="info" class="px-1 py-1"> Купить</x-btn>
                                        </label>
                                    </div>
                                </div>
                            @endif
                            <div class="slider__item flex flex-row w-full justify-center items-top my-5">
                                <div class="mr-4">
                                    <a href="/shop/{{$product->id}}">
                                        <img class="w-96 rounded-xl" src="{{asset('storage/'.$product->image)}}" title="" alt="">
                                    </a>
                                </div>
                                <div class="flex flex-col justify-start mt-10 font">
                                    <label><span class="font-semibold italic text-purple-400">ISBN: </span> {{$product->ISBN}}</label>
                                    <label><span class="font-semibold italic text-purple-400">Название: </span> <a href="/shop/{{$product->id}}">{{$product->name}}</a></label>
                                    <label><span class="font-semibold italic text-purple-400">Стоимость: </span> {{$product->price.' руб.'}}</label>
                                    <label><span class="font-semibold italic text-purple-400">Количество страниц: </span> {{$product->pages}}</label>
                                    <label><span class="font-semibold italic text-purple-400">Год издания: </span> {{$product->year_release}}</label>
                                    <label><span class="font-semibold italic text-purple-400">Автор: </span><a href="/shop/author/{{$product->author->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-100">{{$product->author->last_name." ".$product->author->initials}}</a></label>
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
                                    <span>
                                        <x-btn body="info" class="cart px-1 py-1"> Купить</x-btn>
                                    </span>
                                </div>
                            </div>
                            @if($key === 9)
                                @break
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Кнопки для перехода к предыдущему и следующему слайду -->
            <a class="slider__control" data-slide="prev"></a>
            <a class="slider__control" data-slide="next"></a>
            <ol class="slider__indicators">
                @foreach($products as $key=>$product)
                    @if(count($products)==1)
                        <li data-slide-to="{{$key}}"></li>
                    @endif
                        <li data-slide-to="{{$key}}"></li>
                        @if($key === 9)
                            @break
                        @endif
                @endforeach
            </ol>
        </div>
    </x-slot>

    <div class="py-5 px-12 mx-auto flex flex-row justify-between items-center">
        <div class="slider sliderGenre w-1/2 mr-2">
            <div class="slider__container">
                <div class="slider__wrapper bg-gradient-to-r from-blue-100 to-pink-100 rounded-xl py-3">
                    <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
                        {{ __('Популярные жанры:') }}
                    </h2>
                    <div class="slider__items">
                        @foreach($genres as $key=>$genre)
                            @if(count($genre->products)!==0)
                            <div class="slider__item flex flex-3 justify-center items-top my-5">
                                <div class="mr-4">
                                    <div class="flex flex-col w-36">
                                        <a href="/shop/{{$genre->products[count($genre->products)-1]->product->id}}">
                                            <img class="w-full rounded-xl" src="{{asset('storage/'.$genre->products[count($genre->products)-1]->product->image)}}" title="" alt="">
                                        </a>
                                        <label>
                                            <a href="/shop/author/{{$genre->products[count($genre->products)-1]->product->author->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-100">
                                                {{$genre->products[count($genre->products)-1]->product->author->last_name." ".$genre->products[count($genre->products)-1]->product->author->initials}}
                                            </a>
                                        </label>
                                        <label>
                                            <span class="inline">
                                                <a href="/shop/genre/{{$genre->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-100"> {{$genre->name}}</a>
                                            </span>
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
                @foreach($genres as $key=>$genre)
                    @if(count($genres)==1)
                        <li data-slide-to="{{$key}}"></li>
                    @endif
                    @if(count($genre->products)!==0)
                        <li data-slide-to="{{$key}}"></li>
                    @endif
                        @if($key === 9)
                            @break
                        @endif
                @endforeach
            </ol>
        </div>
        <div class="slider sliderAuthor w-1/2 h-full">
            <div class="slider__container">
                <div class="slider__wrapper bg-gradient-to-r to-blue-100 from-pink-100 rounded-xl py-3">
                    <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
                        {{ __('Популярные авторы:') }}
                    </h2>
                    <div class="slider__items">
                        @foreach($authors as $key=>$author)
                            @if(count($author->products)!==0)
                            <div class="slider__item flex flex-3 justify-center items-center my-5">
                                <div class="mr-4">
                                    <div class="flex flex-col w-32 ">
                                        <a href="/shop/{{$author->products[count($author->products)-1]->id}}">
                                            <img class=" w-full rounded-xl" src="{{asset('storage/'.$author->products[count($author->products)-1]->image)}}" title="" alt="">
                                        </a>
                                        <label>
                                            <span class="inline">
                                                 <a href="/shop/author/{{$author->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-100">
                                                    {{$author->last_name." ".$author->initials}}
                                                 </a>
                                            </span>
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
                @foreach($authors as $key=>$author)
                    @if(count($authors)==1)
                        <li data-slide-to="{{$key}}"></li>
                    @endif
                    @if(count($author->products)!==0)
                        <li data-slide-to="{{$key}}"></li>
                    @endif
                    @if($key === 9)
                        @break
                    @endif
                @endforeach
            </ol>
        </div>
    </div>
    <div class="slider sliderLimit mx-12">
        <div class="slider__container">
            <div class="slider__wrapper bg-gradient-to-r from-blue-100 to-pink-100 rounded-xl py-3">
                <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
                    {{ __('Книги для подростков:') }}
                </h2>
                <div class="slider__items">
                    @foreach($limits[0]->products as $key=>$product)
                        @if(count($limits[0]->products)!==0)
                        <div class="slider__item flex flex-auto justify-center items-top my-5">
                            <div class="mr-4">
                                <div class="flex flex-col w-32 ">
                                    <a href="/shop/{{$product->id}}">
                                        <img class="w-full rounded-xl" src="{{asset('storage/'.$product->image)}}" title="" alt="">
                                    </a>
                                    <label class="w-32">
                                        <span>
                                            <a href="/shop/author/{{$product->author->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-100">
                                                {{$product->author->last_name." ".$product->author->initials}}
                                            </a>
                                        </span>
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
                @if(count($limits[0]->products)==1)
                    <li data-slide-to="{{$key}}"></li>
                @endif
                @if(count($limits[0]->products)!==0)
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
            new ChiefSlider('.sliderHead', {
                loop: true,
                autoplay: true,
                interval: 5000,
                refresh: true,
            });
            new ChiefSlider('.sliderGenre', {
                loop: true,
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
