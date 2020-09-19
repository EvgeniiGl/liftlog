@extends('layouts.app')

@section('content')
    <section class="users w-100">
        <table id="table_users" class="table table-bordred table-hover paginated">
            <thead>
            <tr class="bg-info text-light">
                <th>Логин</th>
                <th>ФИО</th>
                <th>Должность</th>
                <th>Телефон</th>
                <th>Права доступа</th>
                <th>Оповещение</th>
                <th>Закрепленные объекты</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr data-id='{{$user->id}}'>
                    <td class='td-login'>
                        {{$user->login }}
                    </td>
                    <td class='td-name'>
                        {{$user->name }}
                    </td>
                    <td class='td-role'>
                        {{ $user->role }}
                    </td>
                    <td class='td-phone'>
                        {{ $user->phone }}
                    </td>
                    <td class='td-access'>
                        {{--                        @if ($user->access)--}}
                        {{--                            <button data-id='{{$user->id}}' data-access='0'--}}
                        {{--                                    class='btn-xs btn-access btn-success glyphicon glyphicon-plus-sign has-spinner'>--}}
                        {{--                                включен--}}
                        {{--                            </button>--}}
                        {{--                        @else--}}
                        {{--                            <button data-id='{{$user->id}}' data-access='1'--}}
                        {{--                                    class='btn-xs btn-access btn-danger glyphicon glyphicon-minus-sign has-spinner'>--}}
                        {{--                                отключен--}}
                        {{--                            </button>--}}
                        {{--                        @endif--}}
                        Персонал:
                        @switch($user->access_users)
                            @case(1)
                            <span class="badge-info small">чтение</span>
                            @break
                            @case(2)
                            <span class="badge-success small">чтение и запись</span>
                            @break
                            @default
                            <span class="badge-danger small">запрещен</span>
                        @endswitch.
                        <button class='btn-xs btn-primary btn-access small'
                                title="Изменить доступ"
                                data-toggle="modal"
                                data-target="#modal_access"
                                data-id="{{$user->id}}"><i class="fas fa-edit"></i>
                        </button>
                        <br/>
                        Журнал: @switch($user->access_records)
                            @case(1)
                            <span class="badge-info small">чтение</span>
                            @break
                            @case(2)
                            <span class="badge-success small">чтение и запись</span>
                            @break
                            @default
                            <span class="badge-danger small">запрещен</span>
                        @endswitch.
                    </td>
                    <td class="notifications">
                        <select data-user-id='{{$user->id}}'
                                name="notificate">
                            @foreach ($notifications as $key=>$notificate)
                                <option {{$notificate===$user->notificate?"selected":""}} value="{{$notificate}}">
                                    {{$notificate}}
                                </option>
                            @endforeach
                        </select>
                        <div class="d-none spinner-border spinner-border-sm">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </td>
                    <td>
                        <button class='btn-xs btn-success btn-pin-address' title="Добавить адрес"
                                data-id="{{$user->id}}"><i class="fa fa-plus-square" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
        @include('users::paginator')
    </section>
    @include('users::btn_bar')
    @include('users::form_add')
    @include('users::form_del')
    @include('users::form_search')
    @include('users::form_access')
    <div id="users_react"></div>
@stop
