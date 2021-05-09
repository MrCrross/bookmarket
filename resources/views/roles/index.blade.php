<x-app-layout>

    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="text-xl">Управление ролями</h2>
            </div>
            <div class="float-right">
            @can('role-create')
                <x-a.success href="{{ route('roles.create') }}"> Создать роль</x-a.success>
            @endcan
            </div>
        </div>
    </x-slot>


@if ($message = Session::get('success'))
    <div class="w-full px-10 py-5 bg-green-500" >
        <p>{{ $message }}</p>
    </div>
@endif

<div class="container mx-auto px-4 my-5">
    <table class="table-auto w-full">
        <thead>
        <tr>
            <th class="w-1/12 border-2 border-gray-400 px-4 py-2">№</th>
            <th class="w-1/2 border-2 border-gray-400 px-4 py-2">Название</th>
            <th class="w-1/2 border-2 border-gray-400 px-4 py-2">Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($roles as $key => $role)
            <tr>
                <td class="border-2 border-gray-400 px-4 py-2">{{ ++$i }}</td>
                <td class="border-2 border-gray-400 px-4 py-2">{{ $role->name }}</td>
                <td class="border-2 border-gray-400 px-4 py-2">
                    <x-a.info href="{{ route('roles.show',$role->id) }}">Посмотреть</x-a.info>
                    @can('role-edit')
                        <x-a.primary href="{{ route('roles.edit',$role->id) }}">&#128393;</x-a.primary>
                    @endcan
                    @can('role-delete')
                        {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                        <x-btn.danger type="submit">&times;</x-btn.danger>
                        {!! Form::close() !!}
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

{!! $roles->render() !!}
</x-app-layout>
