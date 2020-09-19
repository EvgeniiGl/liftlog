<!--форма добавления-->
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="modal_add" aria-hidden="true">
    <div class="modal-dialog  modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавить пользователя</h5>

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <fieldset class="form-group">
                    <form id="form_add" method="POST" action="{{ route('users.create') }}">
                        @csrf
                        {{--                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"--}}
                        {{--                               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>--}}
                        {{--                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">--}}
                        <input name="id" value="" value="{{ old('id') }}" type="hidden">
                        <div class='form-section'>
                            <input class="form-control"
                                   name="login"
                                   required="required"
                                   type="text"
                                   placeholder="Логин"
                                   pattern="[a-zA-Zа-яА-Я0-9\s]{3,50}"
                                   title="Буквы или цифры от 3 до 50 символов>"
                                   value="{{ old('login') }}">
                        </div>
                        <div class='form-section'>
                            <input class="form-control @error('name') is-invalid @enderror"
                                   name="name"
                                   required="required"
                                   type="text"

                                   placeholder="ФИО"
                                   pattern="[a-zA-Zа-яА-Я0-9\s]{3,200}"
                                   title="Буквы или цифры от 3 до 200 символов"
                                   value="{{ old('name') }}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class='form-section'>
                            <select class="form-control"
                                    name="role"
                                    required="required">
                                <option value="" disabled selected>Должность</option>
                                @foreach ($usersRoles as $role)
                                    <option value="{{$role }}"
                                            {{ old('role') === $role ?'selected':null }}>
                                        {{$role }}
                                    </option>
                                @endforeach
                            </select>
                            <!-- <input class="form-control" name="role" required="required" type="text" placeholder="Должность    &#10507;" pattern="[a-zA-Zа-яА-Я0-9\s]{3,200}"  title="Буквы или цифры от 3 до 200 символов" value="">-->
                        </div>
                        <div class='form-section'>
                            <input class="form-control"
                                   name="phone"
                                   required="required"
                                   type="text"
                                   placeholder="Телефон"
                                   pattern="[78][0-9]{10}"
                                   title="Телефон должен начинаться с 7 или 8 и состоять из 11 цифр>"
                                   value="{{ old('phone') }}">
                        </div>
                        <div class='form-section'>
                            <input id="password"
                                   class="form-control"
                                   name="password"
                                   required="required"
                                   type="password"
                                   placeholder="Пароль"
                                   minlength="8"
                                   autocomplete="new-password">
                        </div>
                        <div class='form-section'>
                            <input id="confirm_password"
                                   class="form-control"
                                   name="password_confirmation"
                                   required="required"
                                   type="password"
                                   placeholder="Подтвердите пароль"
                                   minlength="8"
                                   autocomplete="new-password">
                        </div>


                        {{--                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">--}}

                        <div class='form-section'>
                            <label>Доступ к персоналу:</label>
                            <select class="form-control"
                                    name="access_users"
                                    required="required">
                                <option value="0"
                                        {{ old('access_users') === 0 ?'selected':null }}>
                                    запрещен
                                </option>
                                <option value="1"
                                        {{ old('access_users') === 1 ?'selected':null }}>
                                    чтение
                                </option>
                                <option value="2"
                                        {{ old('access_users') === 2 ?'selected':null }}>
                                    чтение и запись
                                </option>
                            </select>
                            <label>Доступ к журналу:</label>
                            <select class="form-control"
                                    name="access_records"
                                    required="required">
                                <option value="0"
                                        {{ old('access_records') === 0 ?'selected':null }}>
                                    запрещен
                                </option>
                                <option value="1"
                                        {{ old('access_records') === 1 ?'selected':null }}>
                                    чтение
                                </option>
                                <option value="2"
                                        {{ old('access_records') === 2 ?'selected':null }}>
                                    чтение и запись
                                </option>
                            </select>
                        </div>
                        <button type="submit" name="submit" class="btn-primary">Сохранить</button>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
</div>
