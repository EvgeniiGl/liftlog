<!--форма добавления-->
<div class="modal fade" id="modal_access" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog  modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Права доступа</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <fieldset class="form-group">
                    <form id="form_access" name="form_access" enctype="multipart/form-data" action="users/access" method="post">
                        @csrf
                        <input name="id" value="" required="required" type="hidden">
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