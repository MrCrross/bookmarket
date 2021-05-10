<x-app-layout>

    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">Редактировать пользователя</h2>
            </div>
            <div class="float-right">
                <x-a  href="{{ route('users.index') }}"> Назад</x-a>
            </div>
        </div>
    </x-slot>


@if (count($errors) > 0)
  <div class="w-full px-10 py-5 bg-red-700">
    <strong>Whoops!</strong> Возникли проблемы с вашими данными.
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif


{!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Name -->
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
            <div class="mt-4">
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
</x-app-layout>>
