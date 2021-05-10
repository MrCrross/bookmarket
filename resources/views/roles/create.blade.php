<x-app-layout>

    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">Создать роль</h2>
            </div>
            <div class="float-right">
                <x-a href="{{ route('roles.index') }}"> Назад</x-a>
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


{!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
<div class="my-5 mx-5">
    <div class="flex flex-col">
        <strong>Название:</strong>
        {!! Form::text('name', null, array('placeholder' => 'Имя','class' => 'form-input rounded border-gray-300')) !!}
    </div>
    <div class="my-2">
        <strong>Права доступа:</strong>
        <br/>
        @foreach($permission as $value)
            <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'rounded text-blue-500 mr-2')) }}
            {{ $value->name }}</label>
        <br/>
        @endforeach
    </div>
    <div class="mt-2 text-center">
        <x-btn type="submit" class="w-full"> Отправить</x-btn>
    </div>
</div>
{!! Form::close() !!}
</x-app-layout>
