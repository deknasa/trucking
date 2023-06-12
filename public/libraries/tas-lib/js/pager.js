function loadPagerHandler(element, grid) {
	$(element).html(`
		<button type="button" id="${
			grid.getGridParam().id
		}_firstPageButton" class="btn btn-sm hover-primary mr-2 d-flex">
			<span class="fas fa-step-backward"></span>
		</button>

		<button type="button" id="${
			grid.getGridParam().id
		}_previousPageButton" class="btn btn-sm hover-primary d-flex">
			<span class="fas fa-backward"></span>
		</button>
		
		<div class="d-flex align-items-center my-1 mx-3 justify-content-between gap-10">
			<span>Page</span>
			<input id="${grid.getGridParam().id}_pagerInput" class="pager-input" value="${
		grid.getGridParam().page
	}">
			<span id="${grid.getGridParam().id}_totalPage">of ${
		grid.getGridParam().lastpage
	}</span>
		</div>

		<button type="button" id="${
			grid.getGridParam().id
		}_nextPageButton" class="btn btn-sm hover-primary d-flex">
			<span class="fas fa-forward"></span>
		</button>

		<button type="button" id="${
			grid.getGridParam().id
		}_lastPageButton" class="btn btn-sm hover-primary ml-2 d-flex">
			<span class="fas fa-step-forward"></span>
		</button>

		<select id="${grid.getGridParam().id}_rowList" class="ml-2">
			${grid
				.getGridParam()
				.rowList.map((row, index) => {
					return `<option value="${row}">${row}</option>`;
				})
				.join("")}
		</select>
	`);

	$(document).on(
		"click",
		`#${grid.getGridParam().id}_firstPageButton`,
		function () {
			toFirstPage(grid);
		}
	);

	$(document).on(
		"click",
		`#${grid.getGridParam().id}_previousPageButton`,
		function () {
			toPreviousPage(grid);
		}
	);

	$(document).on(
		"click",
		`#${grid.getGridParam().id}_nextPageButton`,
		function () {
			toNextPage(grid);
		}
	);

	$(document).on(
		"click",
		`#${grid.getGridParam().id}_lastPageButton`,
		function () {
			toLastPage(grid);
		}
	);

	$(`#${grid.getGridParam().id}_pagerInput`).keydown(function (event) {
		if (event.which === 13) {
			jumpToPage(grid, $(this).val());
		}
	});

	$(`#${grid.getGridParam().id}_rowList`).change(function (event) {
		setPerPage(grid, $(this).val());
	});
}

function toNextPage(grid) {
	let currentPage = grid.getGridParam().page;
	let lastPage = grid.getGridParam("lastpage");
	let nextPage = parseInt(currentPage) + 1;

	if (nextPage <= lastPage) {
		grid.trigger("reloadGrid", [
			{
				page: nextPage,
			},
		]);
	}
}

function toLastPage(grid) {
	let lastPage = grid.getGridParam("lastpage");
	let currentPage = grid.getGridParam("page");

	if (currentPage < lastPage) {
		grid.trigger("reloadGrid", [
			{
				page: lastPage,
			},
		]);
	}
}

function toPreviousPage(grid) {
	let currentPage = grid.getGridParam().page;

	if (currentPage > 1) {
		grid.trigger("reloadGrid", [
			{
				page: parseInt(currentPage) - 1,
			},
		]);
	}
}

function toFirstPage(grid) {
	let currentPage = grid.getGridParam("page");

	if (currentPage > 1) {
		grid.trigger("reloadGrid", [
			{
				page: 1,
			},
		]);
	}
}

function jumpToPage(grid, page) {
	grid.trigger("reloadGrid", [
		{
			page: page,
		},
	]);
}

function setPerPage(grid, perPage) {
	grid
		.setGridParam({
			rowNum: perPage,
			page: 1,
		})
		.trigger("reloadGrid");
}

function loadPagerHandlerInfo(element, grid) {
	let page = grid.getGridParam().page;
	let totalPage = grid.getGridParam().lastpage;

	$(element).find(`#${grid.getGridParam().id}_pagerInput`).val(page);
	$(element)
		.find(`#${grid.getGridParam().id}_totalPage`)
		.text(`of ${totalPage}`);
}

function loadPagerInfo(element, grid) {
	let params = grid.getGridParam();
	let recordCount = params.reccount;
	let page = params.page;
	let perPage = params.rowNum;
	let totalRecords = params.records;
	let firstRow = (page - 1) * perPage + 1;
	let lastRow = firstRow + recordCount - 1;

	$(element).html(`
		<div class="text-md-right">
			View  ${firstRow} - ${lastRow} of ${totalRecords}
		</div>
	`);
}

$.fn.customPager = function (option = {}) {
	if (!$(`#gbox_${$(this).getGridParam().id}`).siblings('.grid-pager').length) {
		let grid = $(this);
		let pagerHandlerId = `${grid.getGridParam().id}PagerHandler`;
		let pagerInfoId = `${grid.getGridParam().id}InfoHandler`;
		let extndBtn ="";
		if (option.extndBtn) {
			option.extndBtn.forEach(element => {
				extndBtn +=`<div class="btn-group dropup  scrollable-menu">`
				extndBtn +=`<button type="button" class="${element.class}" data-toggle="dropdown" id="${element.id}">
				${element.innerHTML}
				</button>`
				extndBtn +=`<ul class="dropdown-menu" id="menu-approve" aria-labelledby="${element.id}">`
				if (element.dropmenuHTML) {
					element.dropmenuHTML.forEach(dropmenuHTML => {
						extndBtn +=`<li><a class="dropdown-item" id='${dropmenuHTML.id}' href="#">${dropmenuHTML.text}</a></li>`
						$(document).on("click", `#${dropmenuHTML.id}`, function (event) {
							event.stopImmediatePropagation();

							dropmenuHTML.onClick();
						});
					});	
				}
				extndBtn +=`</ul>`
				extndBtn +="</div>"
			});
		}
	
		$(`#gbox_${$(this).getGridParam().id}`).after(`
			<div class="col-12 bg-white grid-pager overflow-x-hidden">
				<div class="row d-flex align-items-center text-center text-lg-left">
					<div class="col-12 col-lg-6">
						${
							typeof option.buttons !== "undefined"
							? option.buttons
								.map((button, index) => {
									let buttonElement = document.createElement("button");
		
									buttonElement.id =
										typeof button.id !== "undefined"
											? button.id
											: `customButton_${index}`;
									buttonElement.className = button.class;
									buttonElement.innerHTML = button.innerHTML;
		
									if (button.onClick) {
										$(document).on("click", `#${buttonElement.id}`, function (event) {
											event.stopImmediatePropagation();
		
											button.onClick();
										});
									}
		
									return buttonElement.outerHTML;
								})
								.join("")
							: ''
						}
							${extndBtn}
					</div>
					<div class="col-12 col-lg-6">
						<div class="row d-flex align-items-center justify-content-center justify-content-lg-end pr-2">
							<div id="${pagerHandlerId}" class="pager-handler d-flex align-items-center justify-content-center mx-2">
							</div>
							<div id="${pagerInfoId}" class="pager-info">
							</div>
						</div>
					</div>
				</div>
			</div>
			
		`);

		loadPagerHandler(`#${pagerHandlerId}`, grid);

		grid.bind("jqGridLoadComplete.jqGrid", function (event, data) {
			loadPagerHandlerInfo(`#${pagerHandlerId}`, grid);
			loadPagerInfo(`#${pagerInfoId}`, grid);
		});
	}

	return this;
};
