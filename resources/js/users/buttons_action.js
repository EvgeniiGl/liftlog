var ButtonsActionsModule = (function() {
	return {
		init: function() {
			this.event();
		},
		event: function() {
			$('#edit').on('click', function(e) {
				e.preventDefault();
				$(window).trigger('edit_user'); //users_table
			});
			$('#add').on('click', function(e) {
				e.preventDefault();
				$(window).trigger('add_user'); //form_add
			});
			$(window).on('enable_delete', function() {
				$('#del').removeClass('disabled');
			});
			$('#del').on('click', function() {
				if ($(this).hasClass('disabled')) {
					return false;
				}
			});
		},
	};
})();

ButtonsActionsModule.init();
