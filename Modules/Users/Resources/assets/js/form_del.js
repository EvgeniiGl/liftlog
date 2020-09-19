var FormdelModule = (function() {
	let modal_del = $('#modal_del');
	let form = $('#form_del');
	return {
		init: function() {
			this.events();
		},
		events: function() {
			$(window).on('enable_delete', function(e, id) {
				form.find('[name="id"]').val(id);
			});
		},
	};
})();
FormdelModule.init();
