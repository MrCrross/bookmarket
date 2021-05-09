<x-app-layout>

    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="text-xl">Просмотр роли</h2>
            </div>
            <div class="float-right">
                <x-a.primary href="{{ route('roles.index') }}"> Назад</x-a.primary>
            </div>
        </div>
    </x-slot>

<div class="my-5 mx-5">
    <div class="flex flex-col">
        <strong>Название:</strong>
        {{ $role->name }}
    </div>
    <div class="my-3">
        <strong>Права доступа:</strong>
        @if(!empty($rolePermissions))
            @foreach($rolePermissions as $v)
                <label class="rounded px-1 bg-green-500 mr-0.5 text-">{{ $v->name }}</label>
            @endforeach
        @endif
    </div>
</div>
</x-app-layout>>
