@extends('layouts.app')

@section('content')

    <div class="container">
        <form method="POST" action='{{ url("service/records/update_type/{$type->id}") }}'>
            @csrf
            <div class="form-group">
                <label for="title">Название</label>
                <input id="title"
                       type="text"
                       class="form-control @error('title') is-invalid @enderror"
                       name="title"
                       value="{{old('title', $type->title) }}"
                       required
                       autocomplete="title"
                       autofocus>
                @error('title')
                <span class="invalid-feedback" role="alert">
            <strong>{{$message}}</strong>
        </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>

@endsection
