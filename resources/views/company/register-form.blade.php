@extends('layouts.blank')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Регистрация организации') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ url('/company/register') }}">
                            @csrf
                            <fieldset class="form-group border p-2">
                                <legend class="w-auto pt-0 font-weight-bold">Организация</legend>
                                <div class="form-group row">
                                    <label for="company_name" class="col-md-4 col-form-label text-md-right">
                                        {{ __('Наименование') }}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text"
                                               class="form-control
                                               @error('company_name')
                                                   is-invalid @enderror"
                                               name="company_name"
                                               value="{{ old('company_name') }}"
                                               required
                                               autocomplete="company_name"
                                               autofocus
                                        >
                                        @error('company_name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="company_inn" class="col-md-4 col-form-label text-md-right">
                                        {{ __('ИНН') }}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text"
                                               class="form-control
                                               @error('company_inn')
                                                   is-invalid @enderror"
                                               name="company_inn"
                                               value="{{ old('company_inn') }}"
                                               pattern="[0-9]{10,12}"
                                               title="Введите корректный ИНН"
                                               required
                                        >
                                        @error('company_inn')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="company_phone"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Телефон') }}</label>
                                    <div class="col-md-6">
                                        <input type="text"
                                               class="form-control @error('company_phone') is-invalid @enderror"
                                               name="company_phone"
                                               value="{{ old('company_phone') }}"
                                               required
                                               autocomplete="tel"
                                               pattern="[78][0-9]{10}"
                                               title="Телефон должен начинаться с 7 или 8 и состоять из 11 цифр"
                                        >
                                        @error('company_phone')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="company_email"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Электронная почта') }}</label>
                                    <div class="col-md-6">
                                        <input type="text"
                                               class="form-control @error('company_email') is-invalid @enderror"
                                               name="company_email"
                                               value="{{ old('company_email') }}"
                                               required
                                               autocomplete="email"
                                               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                               title="Введите корректный адрес электронной почты"
                                        >
                                        @error('company_email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="form-group border p-2">
                                <legend class="w-auto pt-0 font-weight-bold">Администратор</legend>

                                <div class="form-group row">
                                    <label for="name"
                                           class="col-md-4 col-form-label text-md-right">{{ __('ФИО') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                               class="form-control @error('name') is-invalid @enderror" name="name"
                                               value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="phone"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Телефон') }}</label>
                                    <div class="col-md-6">
                                        <input id="phone" type="text"
                                               class="form-control @error('phone') is-invalid @enderror"
                                               name="phone"
                                               value="{{ old('phone') }}"
                                               autocomplete="phone"
                                               pattern="[78][0-9]{10}"
                                               title="Телефон должен начинаться с 7 или 8 и состоять из 11 цифр"
                                        >
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="login"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Логин') }}</label>
                                    <div class="col-md-6">
                                        <input id="login" type="text"
                                               class="form-control @error('login') is-invalid @enderror" name="login"
                                               value="{{ old('login') }}" required autocomplete="login" autofocus>

                                        @error('login')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                {{--                            <div class="form-group row">--}}
                                {{--                                <label for=" role"--}}
                                {{--                                       class="col-md-4 col-form-label text-md-right">{{ __('Должность') }}</label>--}}
                                {{--                                <div class="col-md-6">--}}
                                {{--                                    <select id="role" type="role"--}}
                                {{--                                            class="form-control @error('role') is-invalid @enderror" name="role"--}}
                                {{--                                            value="{{ old(' role') }}" required autocomplete="role">--}}
                                {{--                                        <option value="" disabled="" selected="">Должность</option>--}}
                                {{--                                        @foreach($roles as $role)--}}
                                {{--                                            <option value="{{$role}}">{{$role}}</option>--}}
                                {{--                                        @endforeach--}}
                                {{--                                    </select>--}}
                                {{--                                    @error('role')--}}
                                {{--                                    <span class="invalid-feedback" role="alert">--}}
                                {{--                                        <strong>{{ $message }}</strong>--}}
                                {{--                                    </span>--}}
                                {{--                                    @enderror--}}
                                {{--                                </div>--}}
                                {{--                            </div>--}}

                                <div class="form-group row">
                                    <label for="password"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Пароль') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password"
                                               required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Подтвердите пароль') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Зарегистрировать') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
