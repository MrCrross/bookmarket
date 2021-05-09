<x-app-layout>

    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="text-xl">Управление пользователями</h2>
            </div>
            <div class="float-right">
                @can('role-create')
                    <x-a.success href="{{ route('users.create') }}">Зарегистрировать пользователя</x-a.success>
                @endcan
            </div>
        </div>
    </x-slot>


@if ($message = Session::get('success'))
    <div class="w-full px-10 py-5 bg-green-500">
      <p>{{ $message }}</p>
    </div>
@endif

    <div class="container mx-auto px-4 my-5">
        <table class="table-auto w-full">
         <tr>
           <th class="w-1/12 border-2 border-gray-400 px-4 py-2">#</th>
           <th class="w-1/6 border-2 border-gray-400 px-4 py-2">Имя пользователя</th>
           <th class="w-1/6 border-2 border-gray-400 px-4 py-2">Почта</th>
           <th class="w-1/6 border-2 border-gray-400 px-4 py-2">Роли</th>
           <th class="w-1/3 border-2 border-gray-400 px-4 py-2">Действия</th>
         </tr>
         @foreach ($data as $key => $user)
          <tr>
            <td class="border-2 border-gray-400 px-4 py-2">{{ ++$i }}</td>
            <td class="border-2 border-gray-400 px-4 py-2">{{ $user->name }}</td>
            <td class="border-2 border-gray-400 px-4 py-2">{{ $user->email }}</td>
            <td class="border-2 border-gray-400 px-4 py-2">
              @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $v)
                   <label class="rounded px-1 bg-green-500 mr-0.5">{{ $v }}</label>
                @endforeach
              @endif
            </td>
            <td class="border-2 border-gray-400 px-4 py-2">
                <x-a.info href="{{ route('users.show',$user->id) }}">Посмотреть</x-a.info>
                <x-a.primary href="{{ route('users.edit',$user->id) }}">&#128393;</x-a.primary>
                {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                    <x-btn.danger type="submit">&times;</x-btn.danger>
                {!! Form::close() !!}
            </td>
          </tr>
         @endforeach
        </table>
    </div>
{!! $data->render() !!}
</x-app-layout>
