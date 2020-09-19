<!--форма добавления-->
<div class="modal fade" id="modal_search" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog  modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Найти пользователя</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <fieldset class="form-group">
                    <form id="form_search" name="form_search" enctype="multipart/form-data" action="search"
                          method="post">
                        @csrf
                        <div class='form-section'>
                            <input class="form-control" name="search" value="" required="required" type="text"
                                   placeholder="ФИО">
                        </div>
                        <button type="submit" name="submit" class="btn-primary">Найти</button>
                        <a href="{{route('users')}}" class="btn-link float-right">Сбросить поиск</a>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
</div>