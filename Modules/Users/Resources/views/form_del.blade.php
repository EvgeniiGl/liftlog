<!--форма добавления-->
<div class="modal fade" id="modal_del" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog  modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Удалить пользователя</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <fieldset class="form-group">
                    <form id="form_del" name="form_del" enctype="multipart/form-data" action="users/destroy" method="post">
                        @csrf
                        <input name="id" value="" required="required" type="hidden">
                        <button type="submit" name="submit" class="btn-danger">Да</button>
                        <button type="button" class="btn-success" data-dismiss="modal" aria-hidden="true">Нет</button>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
</div>