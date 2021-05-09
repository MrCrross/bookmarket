<x-app-layout>

    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="text-xl">Зарегистрировать пользователя</h2>
            </div>
            <div class="float-right">
                <x-a.primary href="{{ route('users.index') }}"> Назад</x-a.primary>
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

{!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Логин:')" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="Логин"/>
            </div>
            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Почта:')" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required placeholder="Почта"/>
            </div>
            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Пароль:')" />
                <x-input id="password" class="block mt-1 w-full"
                         type="password"
                         name="password"
                         required autocomplete="new-password" placeholder="Пароль"/>
            </div>
            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Подтвеждение пароля:')" />
                <x-input id="password_confirmation" class="block mt-1 w-full"
                         type="password"
                         name="password_confirmation" required placeholder="Подтвеждение пароля"/>
            </div>
            <!-- Roles -->
            <div class="mt-4">
                <x-label for="roles" :value="__('Роли:')" />
                {!! Form::select('roles[]', $roles,[], array('class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full','multiple')) !!}
            </div>
            <div class="flex items-center justify-center mt-4">
                <x-btn.primary>
                    {{ __('Отправить') }}
                </x-btn.primary>
            </div>
        </div>
    </div>
{!! Form::close() !!}
</x-app-layout>
