
var FormAddModule = (function() {
	let modal_add = $('#modal_add');
	let form = $('#form_add');
	let form_title = modal_add.find('.modal-title');
	var roles = [];
	return {
		init: function() {
			this.events();
			this.confirmPassword();
			this.fillForm();
			this.addUser();
		},
		events: function() {
			$(window).on('show_form_add', function() {
				modal_add.modal('show');
			});
			$(window).on('get_arr_role_users', function(e, data) {
				roles = data.roles;
				FormAddModule.rolesAutocomplete();
			});
			modal_add.on('show.bs.modal', function() {
				$(window).trigger('get_role_users');
			});
		},
		confirmPassword: function() {
			var password = document.getElementById('password'),
				confirm_password = document.getElementById('confirm_password');
			if (!password) {
				return false;
			}
			function validatePassword() {
				if (password.value != confirm_password.value) {
					confirm_password.setCustomValidity('Пароли не совпадают!');
				} else {
					confirm_password.setCustomValidity('');
				}
			}
			password.onchange = validatePassword;
			confirm_password.onkeyup = validatePassword;
		},
		fillForm: function() {
			$(window).on('fill_form_add', function(e, data) {
				form.find('[name="id"]').val(data.id);
				form.find('[name="login"]').val(data.login);
				form.find('[name="name"]').val(data.name);
				form.find('[name="role"]').val(data.role);
				form.find('[name="access"]').prop('checked', data.access);
				form_title.text('Редактировать пользователя');
			});
		},
		addUser: function() {
			$(window).on('add_user', function() {
				form.find('input:not([name="access"])').each((i, el) => {
					$(el).val('');
				});
				form_title.text('Добавить пользователя');
			});
		},
		rolesAutocomplete: function() {
			form.find("[name='role']").autocomplete({
				source: roles,
				minLength: 0,
			});
			form.find("[name='role']")
				.autocomplete('option', 'appendTo', '#form_add')
				.on('click', function() {
					$(this).autocomplete('search');
				});
		},
	};
})();
FormAddModule.init();
