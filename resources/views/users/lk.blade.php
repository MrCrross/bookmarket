<x-app-layout>
    <x-slot name="header">
        <h2 class="w-full font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Личный кабинет') }}
        </h2>
    </x-slot>

    <div class="container my-5 mx-auto bg-gray-50 rounded-2xl">
        <div class="md:flex flex-row items-center justify-start pt-10 mx-10 px-10">
            <div class="bg-gray-200 border-2 border-gray-400 rounded-full p-3">
                <div class="flex flex-col items-center justify-center my-5 mx-5 border-b-2 border-gray-400">
                    <div class="flex-shrink-0 mb-2">
                        <svg class="h-10 w-10 fill-current text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="flex-shrink-0">
                        <span> {{Auth::user()->name}}</span>
                    </div>
                    <div class="flex-shrink-0 mb-1">
                        <span> {{Auth::user()->email}}</span>
                    </div>
                </div>
            </div>
            <div class="bg-gray-200 p-3 mx-2">
                <div class="flex flex-col items-start justify-center my-5 mx-5">
                    <div class="flex-shrink-0">
                        <span>Фамилия:</span>
                        <span>@if(isset($user->last_name)){{$user->last_name}}@else Нет данных @endif</span>
                    </div>
                    <div class="flex-shrink-0">
                        <span>Имя:</span>
                        <span>@if(isset($user->first_name)){{$user->first_name}}@else Нет данных @endif</span>
                    </div>
                    <div class="flex-shrink-0">
                        <span>Отчество:</span>
                        <span>@if(isset($user->father_name)){{$user->father_name}}@else Нет данных @endif</span>
                    </div>
                    <div class="flex-shrink-0">
                        <span>Номер телефона:</span>
                        <span>@if(isset($user->phone)){{$user->phone}}@else Нет данных @endif</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="md:flex flex-row items-center justify-start mx-10 mt-5 px-10">
            <div class="flex flex-col items-start justify-center my-5 mx-5">
                <a class="flex-shrink-0 border-b-2 p-2 border-gray-200 hover:border-gray-400 cursor-pointer">
                    <span class="personal">Изменить личные данные</span>
                </a>
                <a class="flex-shrink-0 border-b-2 p-2 border-gray-200 hover:border-gray-400 cursor-pointer">
                    <span class="password">Изменить пароль</span>
                </a>
                <a class="flex-shrink-0 border-b-2 p-2 border-gray-200 hover:border-gray-400 cursor-pointer">
                    <span class="orders">Мои заказы</span>
                </a>
                @can('logs-list')
                    <a class="flex-shrink-0 border-b-2 p-2 border-gray-200 hover:border-gray-400 cursor-pointer">
                        <span class="logs">Просмотр логов</span>
                    </a>
                @endcan
            </div>
            <div class="flex flex-col items-start justify-center my-5 mx-5">
                {{Form::open(['action'=>'App\Http\Controllers\UserController@updatePersonal','method'=>'patch','class'=>'personalForm hidden'])}}
                    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
                        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                            <input type="text" name="id" value="{{$user->id}}" class="hidden">
                            <div>
                                <x-label for="last_name" :value="__('Фамилия:')" />
                                {!! Form::text('last_name', null, array('placeholder' => 'Фамилия','class' => 'rounded-md shadow-sm border-gray-300
                                                 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full')) !!}
                            </div>
                            <div>
                                <x-label for="first_name" :value="__('Имя:')" />
                                {!! Form::text('first_name', null, array('placeholder' => 'Имя','class' => 'rounded-md shadow-sm border-gray-300
                                                 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full')) !!}
                            </div>
                            <div>
                                <x-label for="father_name" :value="__('Отчество:')" />
                                {!! Form::text('father_name', null, array('placeholder' => 'Отчество','class' => 'rounded-md shadow-sm border-gray-300
                                                 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full')) !!}
                            </div>
                            <div>
                                <x-label for="phone" :value="__('Телефон:')" />
                                {!! Form::text('phone', null, array('pattern'=>'[0-9]{11}','maxLength'=>'11','minLength'=>'11','placeholder' => 'Телефон','class' => 'rounded-md shadow-sm border-gray-300
                                                 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full')) !!}
                            </div>
                            <div class="flex items-center justify-center mt-4">
                                <x-btn type="submit">
                                    {{ __('Отправить') }}
                                </x-btn>
                            </div>
                        </div>
                    </div>
                {{Form::close()}}
                {!! Form::model($user, ['class'=>'passwordForm hidden','method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
                    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
                        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                            <input type="text" name="lk" value="1" class="hidden">
                            <div>
                                <x-label for="name" :value="__('Логин:')" />
                                {!! Form::text('name', null, array('placeholder' => 'Название','class' => 'rounded-md shadow-sm border-gray-300
                                                 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full')) !!}
                            </div>
                            <!-- Email Address -->
                            <div class="mt-4">
                                <x-label for="email" :value="__('Почта:')" />
                                {!! Form::text('email', null, array('placeholder' => 'Почта','class' => 'rounded-md shadow-sm border-gray-300
                                                 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full')) !!}
                            </div>
                            <!-- Password -->
                            <div class="mt-4">
                                <x-label for="password" :value="__('Пароль:')" />
                                {!! Form::password('password', array('placeholder' => 'Пароль','class' => 'rounded-md shadow-sm border-gray-300
                                                 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full')) !!}
                            </div>
                            <!-- Confirm Password -->
                            <div class="mt-4">
                                <x-label for="password_confirmation" :value="__('Подтвеждение пароля:')" />
                                {!! Form::password('confirm-password', array('placeholder' => 'Проверка пароля','class' => 'rounded-md shadow-sm border-gray-300
                                                 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full')) !!}
                            </div>
                            <!-- Roles -->
                            <div class="mt-4 hidden">
                                <x-label for="roles" :value="__('Роли:')" />
                                {!! Form::select('roles[]', $roles,$userRole, array('class' => 'rounded-md shadow-sm border-gray-300
                                                 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full','multiple')) !!}
                            </div>
                            <div class="flex items-center justify-center mt-4">
                                <x-btn type="submit">
                                    {{ __('Отправить') }}
                                </x-btn>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="w-full flex flex-col ordersForm hidden">
            <h2 class="w-full font-semibold ml-5 text-xl text-gray-800 leading-tight">
                {{ __('Мои заказы') }}
            </h2>
            @if(count($orders)===0)
                <h2 class="flex flex-row text-center justify-center font-semibold my-5 text-xl text-gray-800 leading-tight">
                    {{ __('У вас пока не было заказов') }}
                </h2>
            @endif
            @foreach($orders as $order)
            <div class="flex flex-col w-full border-2 border-gray-300 rounded-xl mt-3">
                <div class="ml-5 md:ml-0 md:flex flex-row justify-between items-start">
                    <div class="text-left">
                        <span class="font-semibold italic text-purple-400">№: </span>
                        <span>{{$order->id}}</span>
                    </div>
                    <div class="flex flex-col mx-5 border-gray-400">
                        @foreach($order->orders as $product)
                            <div class="flex flex-row">
                                <label class="mr-3">
                                    <span class="font-semibold italic text-purple-400">Название: </span>
                                    <span>
                                    <a href="/{{$product->product->id}}" class="border-2 border-t-0 border-l-0 border-r-0 border-blue-200">
                                        {{$product->product->name}}
                                    </a>
                                </span>
                                </label>
                                <label>
                                    <span class="font-semibold italic text-purple-400">Количество: </span>
                                    <span>{{$product->count}} шт.</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-right">
                        <span class="font-semibold italic text-purple-400">Статус: </span>
                        <span>{{$order->status->name}}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @can('logs-list')
            <?php $logs=json_decode($logs)?>
        <div class="w-full flex flex-col logsForm hidden">
            <h2 class="w-full font-semibold ml-5 text-xl text-gray-800 leading-tight">
                {{ __('Действия пользователей') }}
            </h2>
            <div class="navigation flex flex-row w-full justify-center items-center mt-2">
                <a href="{{$logs->first_page_url}}" class="firstPage px-2 py-1 border border-black rounded-l-md cursor-pointer hover:bg-blue-100"><<</a>
                @foreach($logs->links as $page)
                    <a href="{{$page->url}}" class="lastPage px-2 py-1 border border-black cursor-pointer hover:bg-blue-100 @if($page->active) bg-blue-100 @endif">{{$page->label}}</a>
                @endforeach
                <a href="{{$logs->last_page_url}}" class="lastPage px-2 py-1 border border-black rounded-r-md cursor-pointer hover:bg-blue-100">>></a>
            </div>
            @foreach($logs->data as $log)
            <div class="flex flex-col w-full border-2 border-gray-300 rounded-xl mt-3">
                <div class="px-2 py-2 md:ml-0 md:flex flex-row justify-between items-center">
                    <label>
                        <span class="font-semibold italic text-purple-400">Действие: </span>
                        <span class="actionLog">{{$log->actions}}</span>
                    </label>
                    <label>
                        <span class="font-semibold italic text-purple-400">Дата: </span>
                        <span class="dateLog">{{$log->created_at}}</span>
                    </label>
                    @can('logs-delete')
                        <label>
                            {{Form::open(['action'=>'App\Http\Controllers\LogController@destroy','method'=>'delete'])}}
                            <input type="text" name="id[]" value="{{$log->id}}" class="hidden">
                            <x-btn body="danger" type="submit" >Удалить</x-btn>
                            {{Form::close()}}
                        </label>
                    @endcan
                </div>
            </div>
            @endforeach
        </div>
        @endcan
    </div>
    <script src="{{asset('js/lk.js')}}"></script>
</x-app-layout>
