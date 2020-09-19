var PaginationModule = (function() {
	var paginator = $('#paginator');
	var pager = $('<ul class="pagination  pagination-sm float-right"></ul>');
	var currentPage = 0;
	var numPerPage = 10;
	return {
		init: function() {
			this.events();
			this.insertPager();
		},
		events: function() {
			$(window).one('build_pager', function(e, data) {
				PaginationModule.buildPager(e, data);
			});
			$(window).trigger('repaginate_table', {
				currentPage: currentPage,
				numPerPage: numPerPage,
			});
		},
		buildPager: function(e, data) {
			var numPages = Math.ceil(data.numRows / numPerPage);
			var numPage;
			var butPages;
			for (var page = 0; page < numPages && numPages > 1; page++) {
				if (page == 0) {
					numPage = $(
						'<li class="page-item active"><span  class="page-link">≪Первая</span></li><li class="page-item active"><span  class="page-link">' +
							(page + 1) +
							'</span></li>'
					);
				} else if (page + 1 == numPages) {
					numPage = $(
						'<li class="page-item"><span  class="page-link">' +
							(page + 1) +
							'</span></li><li class="page-item"><span  class="page-link">Последняя≫</span></li>'
					);
				} else {
					numPage = $('<li class="page-item"><span  class="page-link">' + (page + 1) + '</span></li>');
				}
				numPage
					.on(
						'click',
						{
							newPage: page,
						},
						function(event) {
							currentPage = event.data['newPage'];
							$(window).trigger('repaginate_table', {
								currentPage: currentPage,
								numPerPage: numPerPage,
							});
							$(this)
								.addClass('active')
								.removeClass('noactive')
								.siblings()
								.addClass('noactive')
								.removeClass('active');
							butPages = $(this).closest('ul');
							if ($(this).prevAll().length <= 1) {
								butPages
									.find('li:first, li:eq(1)')
									.addClass('active')
									.removeClass('noactive');
							}
							if ($(this).nextAll().length <= 1) {
								butPages
									.find('li:last, li:eq(' + numPages + ')')
									.addClass('active')
									.removeClass('noactive');
							}
							butPages.find('li').show();
							$(this)
								.prevAll('li:not(:last)')
								.slice(3)
								.hide();
							$(this)
								.nextAll('li:not(:last)')
								.slice(3)
								.hide();
						}
					)
					.appendTo(pager);
			}
			PaginationModule.insertPager();
		},
		insertPager: function() {
			paginator.append(pager);
		},
	};
})();

PaginationModule.init();
