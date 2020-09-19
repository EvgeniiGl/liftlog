var FormaccessModule = (function() {
	let modal_access = $('#modal_access');
	let form = $('#form_access');
	return {
		init: function() {
			this.events();
		},
		events: function() {
			$(window).on('open_form_access', function(e, id) {
				form.find('[name="id"]').val(id);
			});
		},
	};
})();
FormaccessModule.init();
