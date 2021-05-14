<x-app-layout>
    <x-slot name="header">
        @auth
            @if($carts!=='[]')
                <script>
                    localStorage.setItem('carts',JSON.stringify(decodeHtml('{{$carts}}')))
                </script>
            @endif
        @endauth
            <h2 class="w-full font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Корзина') }}
            </h2>
    </x-slot>
{{Form::open(['action'=>'App\Http\Controllers\OrderController@create','method'=>'post','id'=>'cartForm'])}}
    <div class="container mx-auto my-5">
        <div class="flex flex-col my-5">
            @foreach($products as $product)
                <div class="content flex flex-col w-full border-2 border-gray-300 rounded-xl mt-3">
                    <div class="ml-5 md:ml-0 md:flex flex-row justify-center items-center">
                        <a href="/{{$product->id}}" class="m-5">
                            <img class="w-44 cursor-pointer" src="{{asset('storage/'.$product->image)}}" alt="">
                        </a>
                        <div class="content-text flex flex-col w-full">
                            <input type="text" name="products[]" value="{{$product->id}}" class="hidden" readonly required>
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
                        </div>
                        <div class="content-text flex flex-col w-full">
                            <label>
                                <span class="font-semibold italic text-purple-400">Количество: </span>
                                <x-input type="number" name="count[]" value="1" min="1" data-id="{{$product->id}}" data-price="{{$product->price}}" />
                            </label>
                        </div>
                        <div class="content-price mx-3 p-2 my-3 md:my-0 flex flex-col items-center justify-center bg-gray-200 rounded-md w-96">
                            <span>Итого:</span>
                            <span class="price">{{$product->price}} руб.</span>
                        </div>
                    </div>
                </div>
            @endforeach
            @if(count($products)===0)
                <h2 class="flex flex-row w-full w-full justify-center items-center font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Корзина пуста') }}
                </h2>
            @endif
            <div class="navigation flex flex-row w-full justify-end items-center mt-2">
                <div class="content-price mx-3 p-2 my-3 md:my-0 flex flex-row items-center justify-center bg-gray-200 rounded-md w-96">
                    <span>Итого к оплате: </span>
                    <span class="to_pay"></span>
                </div>
                <x-btn body="success" type="submit"> Купить </x-btn>
            </div>
        </div>
    </div>
{{Form::close()}}
    <script src="{{asset('js/shop.js')}}"></script>
</x-app-layout>
