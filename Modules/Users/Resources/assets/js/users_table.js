var TableModule = (function() {
	const table = $('#table_users');
	let selectedTr = null;
	let data_tr = {
		id: '',
		login: '',
		name: '',
		role: '',
		access: '',
	};
	return {
		init: function() {
			this.selectTr();
			this.events();
		},
		selectTr: function() {
			$('#table_users').on('click', 'tbody>tr', function(e) {
				$('.table-primary').removeClass('table-primary');
				selectedTr = $(e.currentTarget).addClass('table-primary');
				$(window).trigger('enable_delete', selectedTr.data('id')); //buttons_action, form_del
			});
		},
		events: function() {
			$(window).on('edit_user', function() {
				TableModule.getDataTr();
			});
			table.on('dblclick', 'tbody>tr', function() {
				$(window).trigger('edit_user');
				$(window).trigger('show_form_add'); //form_add
			});
			$(window).on('repaginate_table', function(e, data) {
				table
					.find('tbody tr')
					.hide()
					.slice(data.currentPage * data.numPerPage, (data.currentPage + 1) * data.numPerPage)
					.show();
				$(window).trigger('build_pager', {
					numRows: table.find('tbody tr').length,
				});
			});
			$(window).on('get_role_users', function() {
				TableModule.getRoleUsers();
			});
			table.on('click', '.btn-access', function() {
				if ($(this).is(':disabled')) {
					return false;
				}
				TableModule.replaceAccess(this);
			});
		},
		getDataTr: function() {
			if (!selectedTr) {
				return false;
			}
			data_tr.id = selectedTr.data('id');
			data_tr.login = $.trim(selectedTr.find('.td-login').text());
			data_tr.name = $.trim(selectedTr.find('.td-name').text());
			data_tr.role = $.trim(selectedTr.find('.td-role').text());
			data_tr.access = $.trim(selectedTr.find('.td-access').text()) == 'отключен' ? false : true;
			$(window).trigger('fill_form_add', data_tr); //form_add
		},
		getRoleUsers: function() {
			let roles = [
				...new Set(
					table.find('.td-role').map(function() {
						return $.trim($(this).text());
					})
				),
			];
			$(window).trigger('get_arr_role_users', { roles });
		},
		replaceAccess: function(btn_access) {
			let btn = $(btn_access);
			$.ajax({
				type: 'POST',
				url: 'access',
				data: { id: btn.data('id'), access: btn.data('access') },
				success: function(data) {
					btn.data('access', data.access);
					btn.removeClass('btn-success btn-danger');
					btn.addClass(!data.access ? 'btn-danger' : 'btn-success');
					btn.text(!data.access ? 'отключен' : 'включен');
				},
				error: function(data) {
					$(window).trigger('error_ajax', data);
				},
				beforeSend: TableModule.buttonLoading('start', btn),
				complete: function() {
					TableModule.buttonLoading('stop', btn);
				},
			});
		},
		buttonLoading: function(action, btn) {
			var self = $(btn);
			if (action == 'start') {
				if ($(self).attr('disabled') == 'disabled') {
					e.preventDefault();
				}
				$('.btn-access').attr('disabled', 'disabled');
				$(self).html('<span class="spinner"><i class="fa fa-spinner fa-spin"></i></span>' + $(btn).text());
				$(self).addClass('active');
			}
			if (action == 'stop') {
				$(self).removeClass('active');
				$('.btn-access').removeAttr('disabled');
			}
		},
	};
})();
TableModule.init();
