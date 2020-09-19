let MessagesModule = (function () {
    const msg_error = $('#msg_error');
    return {
        init: function () {
            this.messagePHP();
            $(window).on('error_ajax', function (data) {
                MessagesModule.messageAjax(data);
            });
        },
        messagePHP: function () {
            if (msg_error.text().length > 0) {
                this.showMessage();
            }
        },
        messageAjax: function (data) {
            //доделать
        },
        showMessage: function (data) {
            msg_error.slideDown('slow');
            setTimeout(() => {
                msg_error.slideUp('slow');
            }, 5000);
        },
    };
})();
MessagesModule.init();
//todo добавить успешные и др. соообщения
