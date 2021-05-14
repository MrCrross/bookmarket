<x-app-layout>
    <x-slot name="header">
        <h2 class="flex flex-row w-full justify-start font-semibold text-xl items-center text-gray-800 leading-tight ml-20 mb-10">
            {{ __('Заказы:') }}
        </h2>
        <div class="container mx-auto">
            <div class="flex flex-col w-full">
                <div class="navigation flex flex-row w-full justify-center items-center mb-2">
                    <a href="?page=1" class="px-2 py-1 border border-black rounded-l-md cursor-pointer hover:bg-blue-100"><</a>
                    @for ($i=1;$i<=$orders->lastPage(); $i++)
                        @if (request()->page == $i)
                            <a href="?page={{$i}}" class="px-2 py-1 border border-black cursor-pointer hover:bg-blue-100 bg-blue-100 ">{{$i}}</a>
                        @else
                            <a href="?page={{$i}}" class="px-2 py-1 border border-black cursor-pointer hover:bg-blue-100 ">{{$i}}</a>
                        @endif
                    @endfor
                    <a href="?page={{$orders->lastPage()}}" class="px-2 py-1 border border-black rounded-r-md cursor-pointer hover:bg-blue-100">></a>
                </div>
                @if (!count($orders))
                    <div class="content flex flex-col w-full border-2 border-gray-300 rounded-xl mt-3">
                        <div class="flex flex-row justify-center items-center">
                            <p>В базе ещё нет новых заказов</p>
                        </div>
                    </div>
                @endif
                @foreach($orders as $order)
                    <div class="content flex flex-col w-full border-2 border-gray-300 rounded-xl mt-3">
                        <div class="md:flex flex-row items-center">
                            <div class="ml-5">
                                # {{$order->id}}
                            </div>
                            <div class="ml-5 md:flex flex-col">
                                <span>{{$order->user->name}}</span>
                                <span>{{$order->user->last_name}}</span>
                                <span>{{$order->user->first_name}}</span>
                                <span>{{$order->user->phone}}</span>
                            </div>
                            <div class="flex flex-col">
                                @foreach($order->orders as $products)
                                    <div class="ml-5 md:ml-0 md:flex flex-row justify-center items-center">
                                        <a href="/{{$products->product->id}}" class="m-5">
                                            <img class="w-28 cursor-pointer" src="{{asset('storage/'.$products->product->image)}}" alt="">
                                        </a>
                                        <div class="content-text flex flex-col w-full">
                                            <label><span class="font-semibold italic text-purple-400">ISBN: </span>{{$products->product->ISBN}}</label>
                                            <label><span class="font-semibold italic text-purple-400">Название: </span>{{$products->product->name}}</label>
                                            <label>
                                                <span class="font-semibold italic text-purple-400">Автор: </span>
                                                {{$products->product->author->last_name." ".$products->product->author->initials}}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mx-3 p-2 my-3 md:my-0 md:flex flex-row items-center justify-center bg-gray-200 rounded-md">
                                {{Form::open(['action'=>'App\Http\Controllers\OrderController@update','method'=>'PATCH'])}}
                                    <input type="text" name="user_id" value="{{Auth::user()->id}}" class="hidden">
                                    <select name="status" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        @foreach($statuses as $status)
                                            <option value="{{$status->id}}" @if($order->status->id === $status->id) selected @endif>{{$status->name}}</option>
                                        @endforeach
                                    </select>
                                    <x-btn type="submit"> Изменить</x-btn>
                                {{Form::close()}}
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="navigation flex flex-row w-full justify-center items-center mt-2">
                    <a href="?page=1" class="px-2 py-1 border border-black rounded-l-md cursor-pointer hover:bg-blue-100"><</a>
                    @for ($i=1;$i<=$orders->lastPage(); $i++)
                        @if (request()->page == $i)
                            <a href="?page={{$i}}" class="px-2 py-1 border border-black cursor-pointer hover:bg-blue-100 bg-blue-100 ">{{$i}}</a>
                        @else
                            <a href="?page={{$i}}" class="px-2 py-1 border border-black cursor-pointer hover:bg-blue-100 ">{{$i}}</a>
                        @endif
                    @endfor
                    <a href="?page={{$orders->lastPage()}}" class="px-2 py-1 border border-black rounded-r-md cursor-pointer hover:bg-blue-100">></a>
                </div>
            </div>
        </div>
    </x-slot>
    <script src="{{asset('js/shop.js')}}"></script>
</x-app-layout>
