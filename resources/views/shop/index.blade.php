<x-app-layout>
    <x-slot name="header">
        @auth
            @if($carts!=='[]')
                <script>
                    localStorage.setItem('carts',JSON.stringify(decodeHtml('{{$carts}}')))
                </script>
            @endif
        @endauth
        <div class="slider sliderHead">
            <div class="slider__container">
                <div class="slider__wrapper bg-gradient-to-r from-blue-100 to-pink-100 rounded-xl py-3">
                    <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
                        {{ __('Новинки') }}
                    </h2>
                    <div class="slider__items ">
                        @foreach($products as $key=>$product)
                            @if(count($products)==1)
                                <div class="slider__item pl-5 md:pl-0 flex flex-col md:flex-row w-full justify-center items-top my-5">
                                    <div class="mr-4">
                                        <a href="/{{$product->id}}">
                                            <img class="w-72 rounded-xl" src="{{asset('storage/'.$product->image)}}" title="" alt="">
                                        </a>
                                    </div>
                                    <div class="flex flex-col justify-start mt-10">
                                        <label><span class="font-semibold italic text-purple-400">ISBN: </span> {{$product->ISBN}}</label>
                                        <label><span class="font-semibold italic text-purple-400">Название: </span> <a href="/{{$product->id}}">{{$product->name}}</a></label>
                                        <label><span class="font-semibold italic text-purple-400">Стоимость: </span> {{$product->price.' руб.'}}</label>
                                        <label><span class="font-semibold italic text-purple-400">Количество страниц: </span> {{$product->pages}}</label>
                                        <label><span class="font-semibold italic text-purple-400">Год издания: </span> {{$product->year_release}}</label>
                                        <label><span class="font-semibold italic text-purple-400">Автор: </span><a href="/shop/author/{{$product->author->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">{{$product->author->last_name." ".$product->author->initials}}</a></label>
                                        <label><span class="font-semibold italic text-purple-400">Возрастные ограничения: </span> <a href="/shop/limit/{{$product->limit->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">{{$product->limit->name}}</a></label>
                                        <label><span class="font-semibold italic text-purple-400">Издательство: </span> <a href="/shop/publisher/{{$product->publisher->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">{{$product->publisher->name}}</a></label>
                                        <label class="flex flex-row"><span class="font-semibold italic text-purple-400 mr-2">Жанры: </span>
                                                @foreach($product->genres as $key=>$genre)
                                                <a href="/shop/genre/{{$genre->genre->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200"> {{$genre->genre->name}}</a>
                                                    @if(count($product->genres)!==++$key)
                                                        {{', '}}
                                                    @endif
                                                @endforeach
                                        </label>
                                        <label class="max-w-xl">
                                            <span class="font-semibold italic text-purple-400">Описание: </span>
                                            <span>{{$product->description}}</span>
                                        </label>
                                        <label>
                                            <x-btn body="success" class="cart mt-2 px-1 py-1 hidden"> В корзине</x-btn>
                                            <x-btn body="info" type="submit" class="cartBuy mt-2 px-1 py-1" data-id="{{$product->id}}"> Купить</x-btn>
                                        </label>
                                    </div>
                                </div>
                            @endif
                            <div class="slider__item pl-5 md:pl-0 flex flex-col md:flex-row w-full justify-center items-top my-5">
                                <div class="mr-4">
                                    <a href="/{{$product->id}}">
                                        <img class="w-72 rounded-xl" src="{{asset('storage/'.$product->image)}}" title="" alt="">
                                    </a>
                                </div>
                                <div class="flex flex-col justify-start mt-10">
                                    <label><span class="font-semibold italic text-purple-400">ISBN: </span> {{$product->ISBN}}</label>
                                    <label><span class="font-semibold italic text-purple-400">Название: </span> <a href="/{{$product->id}}">{{$product->name}}</a></label>
                                    <label><span class="font-semibold italic text-purple-400">Стоимость: </span> {{$product->price.' руб.'}}</label>
                                    <label><span class="font-semibold italic text-purple-400">Количество страниц: </span> {{$product->pages}}</label>
                                    <label><span class="font-semibold italic text-purple-400">Год издания: </span> {{$product->year_release}}</label>
                                    <label><span class="font-semibold italic text-purple-400">Автор: </span><a href="/shop/author/{{$product->author->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">{{$product->author->last_name." ".$product->author->initials}}</a></label>
                                    <label><span class="font-semibold italic text-purple-400">Возрастные ограничения: </span> <a href="/shop/limit/{{$product->limit->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">{{$product->limit->name}}</a></label>
                                    <label><span class="font-semibold italic text-purple-400">Издательство: </span> <a href="/shop/publisher/{{$product->publisher->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">{{$product->publisher->name}}</a></label>
                                    <label class="flex flex-row"><span class="font-semibold italic text-purple-400 mr-2">Жанры: </span>
                                        @foreach($product->genres as $key=>$genre)
                                            <a href="/shop/genre/{{$genre->genre->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200"> {{$genre->genre->name}}</a>
                                            @if(count($product->genres)!==++$key)
                                                {{', '}}
                                            @endif
                                        @endforeach
                                    </label>
                                    <span>
                                        <x-btn body="success" class="cart mt-2 px-1 py-1 hidden"> В корзине</x-btn>
                                        <x-btn body="info" type="submit" class="cartBuy mt-2 px-1 py-1" data-id="{{$product->id}}"> Купить</x-btn>
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
    @auth
        @if(count($recom)!==0)
        <div class="slider sliderRecom my-12 md:mx-12">
            <div class="slider__container">
                <div class="slider__wrapper bg-gradient-to-r from-blue-100 to-pink-100 rounded-xl py-3">
                    <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
                        {{ __('Рекомендуем:') }}
                    </h2>
                    <div class="slider__items">
                        @foreach($recom as $item)
                            @foreach($item['products'] as $key=>$product)
                                @if(count($item['products'])>0)
                                    <div class="slider__item flex md:flex-auto justify-center items-top my-5 md:px-4 xl:px-0">
                                        <div class="flex flex-col w-64">
                                            <a href="/{{$product['id']}}">
                                                <img class="h-96 w-full rounded-xl" src="{{asset('storage/'.$product['image'])}}" title="" alt="">
                                            </a>
                                            <label>
                                            <span><a href="/shop/author/{{$item['id']}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">
                                                    {{$item['last_name']." ".$item['initials']}}
                                            </a></span>
                                            </label>
                                            <label>
                                                <span class="inline">
                                                    <x-btn body="success" class="cart mt-2 px-1 py-1 hidden"> В корзине</x-btn>
                                                    <x-btn body="info" class="cartBuy mt-2 px-1 py-1" data-id="{{$product['id']}}"> Купить</x-btn>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                @endif
                                @if($key === 9)
                                    @break
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
            <a class="slider__control" data-slide="prev"></a>
            <a class="slider__control" data-slide="next"></a>
            <ol class="slider__indicators">
                @foreach($recom as $keyR=>$item)
                    @foreach($item['products'] as $key=>$product)
                        @if(count($item['products'])===1)
                            <li data-slide-to="{{++$keyR * ++$key}}"></li>
                        @endif
                        @if(count($item['products'])!==0)
                            <li data-slide-to="{{++$keyR * ++$key}}"></li>
                        @endif
                        @if((++$keyR * ++$key) === 9)
                            @break
                        @endif
                    @endforeach
                @endforeach
            </ol>
        </div>
        @endif
    @endauth
    <div class="py-5 md:px-12 mx-auto block md:flex flex-row justify-between items-center">
        <div class="slider sliderGenre mt-4 w-full md:mt-0 md:w-1/2 mr-2">
            <div class="slider__container">
                <div class="slider__wrapper bg-gradient-to-r from-blue-100 to-pink-100 rounded-xl py-3">
                    <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
                        {{ __('Популярные жанры:') }}
                    </h2>
                    <div class="slider__items">
                        @foreach($genres as $key=>$genre)
                            @if(count($genre->products)!==0)
                            <div class="slider__item flex md:flex-3 justify-center items-top my-5 sm:px-0 md:px-4 xl:px-0">
                                <div class="flex flex-col w-64">
                                    <a href="/{{$genre->products[count($genre->products)-1]->product->id}}">
                                        <img class="h-96 w-full rounded-xl" src="{{asset('storage/'.$genre->products[count($genre->products)-1]->product->image)}}" title="" alt="">
                                    </a>
                                    <label>
                                        <a href="/shop/author/{{$genre->products[count($genre->products)-1]->product->author->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">
                                            {{$genre->products[count($genre->products)-1]->product->author->last_name." ".$genre->products[count($genre->products)-1]->product->author->initials}}
                                        </a>
                                    </label>
                                    <label>
                                        <span class="inline">
                                            <a href="/shop/genre/{{$genre->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200"> {{$genre->name}}</a>
                                        </span>
                                        <span class="inline">
                                            <x-btn body="success" class="cart mt-2 px-1 py-1 hidden"> В корзине</x-btn>
                                            <x-btn body="info" type="submit" class="cartBuy mt-2 px-1 py-1" data-id="{{$genre->products[count($genre->products)-1]->product->id}}"> Купить</x-btn>
                                        </span>
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
        <div class="slider sliderAuthor mt-4 w-full md:mt-0 md:w-1/2 md:h-full">
            <div class="slider__container">
                <div class="slider__wrapper bg-gradient-to-r to-blue-100 from-pink-100 rounded-xl py-3">
                    <h2 class="flex flex-row w-full py-3 justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
                        {{ __('Популярные авторы:') }}
                    </h2>
                    <div class="slider__items">
                        @foreach($authors as $key=>$author)
                            @if(count($author->products)!==0)
                            <div class="slider__item flex md:flex-3 justify-center items-center my-5 sm:px-0 md:px-4 xl:px-0">
                                <div class="flex flex-col w-64">
                                    <a href="/{{$author->products[count($author->products)-1]->id}}">
                                        <img class="h-96 w-full rounded-xl" src="{{asset('storage/'.$author->products[count($author->products)-1]->image)}}" title="" alt="">
                                    </a>
                                    <label>
                                        <span class="inline">
                                             <a href="/shop/author/{{$author->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">
                                                {{$author->last_name." ".$author->initials}}
                                             </a>
                                        </span>
                                        <span class="inline">
                                            <x-btn body="success" class="cart mt-2 px-1 py-1 hidden"> В корзине</x-btn>
                                            <x-btn body="info" type="submit" class="cartBuy mt-2 px-1 py-1" data-id="{{$author->products[count($author->products)-1]->id}}"> Купить</x-btn>
                                        </span>
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
    <div class="slider sliderLimit mt-4 md:mt-0 md:mx-12">
        <div class="slider__container">
            <div class="slider__wrapper bg-gradient-to-r from-blue-100 to-pink-100 rounded-xl py-3">
                <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
                    {{ __('Книги для подростков:') }}
                </h2>
                <div class="slider__items">
                    @foreach($limits[0]->products as $key=>$product)
                        @if(count($limits[0]->products)!==0)
                        <div class="slider__item flex md:flex-auto justify-center items-top my-5 sm:px-0 md:px-4 xl:px-0">
                            <div class="flex flex-col w-64">
                                <a href="/{{$product->id}}">
                                    <img class="h-96 w-full rounded-xl" src="{{asset('storage/'.$product->image)}}" title="" alt="">
                                </a>
                                <label>
                                    <span class="inline">
                                        <a href="/shop/author/{{$product->author->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">
                                            {{$product->author->last_name." ".$product->author->initials}}
                                        </a>
                                    </span>
                                    <span class="inline">
                                        <x-btn body="success" class="cart mt-2 px-1 py-1 hidden"> В корзине</x-btn>
                                        <x-btn body="info" type="submit" class="cartBuy mt-2 px-1 py-1" data-id="{{$product->id}}"> Купить</x-btn>
                                    </span>
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
            new ChiefSlider('.sliderRecom', {
                loop: false,
            });
        });
    </script>
</x-app-layout>
