@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="h2">Редактирование списка типов записей</div>
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Наименование</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($types as $type)
                <tr>
                    <td>{{$type->id}}</td>
                    <td>{{$type->title}}</td>
                    <td>
                        <a class="btn btn-primary btn-sm"
                           href='{{url("service/records/edit_type/{$type->id}")}}'
                        >Изменить</a>
                        <a onclick="return confirm('Удалить запись?')"
                           href='{{url("service/records/destroy_type/{$type->id}")}}'
                           class="btn btn-danger btn-sm">Удалить</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop

