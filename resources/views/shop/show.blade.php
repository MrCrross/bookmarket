<x-app-layout>
    <x-slot name="header">
        @auth
            @if($carts!=='[]')
                <script>
                    localStorage.setItem('carts',JSON.stringify(decodeHtml('{{$carts}}')))
                </script>
            @endif
        @endauth
        @foreach($products as $product)
        <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
            {{ __($product->name) }}
        </h2>
        <div class="product flex flex-col">
            <div class="md:flex flex-row w-full justify-center items-top my-5">
                <div class="mr-4">
                    <a href="/{{$product->id}}">
                        <img class="w-96 rounded-xl" src="{{asset('storage/'.$product->image)}}" title="" alt="">
                    </a>
                </div>
                <div class="flex mt-4 md:mt-0 flex-col justify-start">
                    <label><span class="font-semibold italic text-purple-400">ISBN: </span> {{$product->ISBN}}</label>
                    <label><span class="font-semibold italic text-purple-400">Название: </span> <a href="/{{$product->id}}">{{$product->name}}</a></label>
                    <label><span class="font-semibold italic text-purple-400">Стоимость: </span> {{$product->price.' руб.'}}</label>
                    <label><span class="font-semibold italic text-purple-400">Количество страниц: </span> {{$product->pages}}</label>
                    <label><span class="font-semibold italic text-purple-400">Год издания: </span> {{$product->year_release}}</label>
                    <label><span class="font-semibold italic text-purple-400">Автор: </span> <a href="/shop/author/{{$product->author->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">{{$product->author->last_name." ".$product->author->initials}}</a></label>
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
                    <span>
                        <x-btn body="success" class="cart mt-2 px-1 py-1 hidden"> В корзине</x-btn>
                        <x-btn body="info" type="submit" class="cartBuy mt-2 px-1 py-1" data-id="{{$product->id}}"> Купить</x-btn>
                    </span>
                </div>
            </div>
            <div class="inline-flex flex-row justify-start mt-2 ">
                @foreach($product->images as $key=> $image)
                    <span>
                        <img data-toggle="#imgModal" src="{{asset('storage/'.$image->image)}}" title="Доп. изображение книги {{$product->name}} № {{++$key}}" class="w-36 mx-4 cursor-pointer border border-blue-200">
                    </span>
                @endforeach
            </div>
        </div>
        @endforeach
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
    <div class="slider sliderGenre my-12 md:mx-12">
        <div class="slider__container">
            <div class="slider__wrapper bg-gradient-to-r from-blue-100 to-pink-100 rounded-xl py-3">
                <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
                    {{ __('Книги этого жанра:') }}
                </h2>
                <div class="slider__items">
                    @foreach($genres[0]->products as $key=>$product)
                        @if($genres[0]->products !==0)
                            <div class="slider__item flex md:flex-auto justify-center items-top my-5">
                                <div class="flex flex-col w-64">
                                    <a href="/{{$product->product->id}}">
                                        <img class="h-96 w-full rounded-xl" src="{{asset('storage/'.$product->product->image)}}" title="" alt="">
                                    </a>
                                    <label><span>
                                            <a href="/shop/author/{{$product->product->author->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">
                                                {{$product->product->author->last_name." ".$product->product->author->initials}}
                                            </a>
                                        </span></label>
                                    <label>
                                        <span class="inline">
                                            <a href="/shop/genre/{{$genres[0]->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">
                                            {{$genres[0]->name}}
                                            </a>
                                        </span>
                                        <span class="inline">
                                            <x-btn body="success" class="cart mt-2 px-1 py-1 hidden"> В корзине</x-btn>
                                            <x-btn body="info" type="submit" class="cartBuy mt-2 px-1 py-1" data-id="{{$product->product->id}}"> Купить</x-btn>
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
    <div class="slider sliderAuthor my-12 md:mx-12">
        <div class="slider__container">
            <div class="slider__wrapper bg-gradient-to-r to-blue-100 from-pink-100 rounded-xl py-3">
                <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
                    {{ __('Книги ')}}
                    <a href="/shop/author/{{$authors[0]->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">
                        {{$products[0]->author->last_name." ".$products[0]->author->initials}}
                    </a>
                    {{__(' :')}}
                </h2>
                <div class="slider__items">
                    @foreach($authors[0]->products as $key=>$product)
                        @if(isset($product))
                            <div class="slider__item flex md:flex-auto justify-center items-center my-5">
                                <div class="md:flex flex-col w-64">
                                    <a href="/{{$product->id}}">
                                        <img class="h-96 w-full rounded-xl" src="{{asset('storage/'.$product->image)}}" title="" alt="">
                                    </a>
                                    <label>
                                        <span class="inline">
                                            <a href="/shop/author/{{$authors[0]->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">
                                            {{$authors[0]->last_name." ".$authors[0]->initials}}
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
    <div class="slider sliderLimit my-12 md:mx-12">
        <div class="slider__container">
            <div class="slider__wrapper bg-gradient-to-r from-blue-100 to-pink-100 rounded-xl py-3">
                <h2 class="flex flex-row w-full justify-center font-semibold text-xl items-center text-gray-800 leading-tight">
                    {{ __('Книги этой возрастной категории:') }}
                </h2>
                <div class="slider__items">
                    @foreach($limits[0]->products as $key=>$product)
                        @if(isset($product))
                            <div class="slider__item flex md:flex-auto justify-center items-top my-5">
                                <div class="flex flex-col w-64">
                                    <a href="/{{$product->id}}">
                                        <img class="h-96 w-full rounded-xl" src="{{asset('storage/'.$product->image)}}" title="" alt="">
                                    </a>
                                    <label>
                                        <span>
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
    @include('modal')
    <script src="{{asset('js/img.js')}}"></script>
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
            new ChiefSlider('.sliderRecom', {
                loop: false,
            });
        });
        document.querySelector('.product').addEventListener('click',function (e ){
            if(e.target && e.target.matches('img[data-toggle="#imgModal"]')){
                imgModalHandler(e)
            }
        })
    </script>
</x-app-layout>
