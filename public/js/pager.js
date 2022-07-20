function loadPagerHandler(element, grid) {
	$(element).html("");

	let params = grid.getGridParam();

	let previousPageHandler = document.createElement("button");
	previousPageHandler.className = "mr-2";
	previousPageHandler.onclick = function () {
		toPreviousPage(grid, params.page);
	};

	let previousPageIcon = document.createElement("i");
	previousPageIcon.className = "fas fa-angle-left";

	let firstPageHandler = document.createElement("button");
	firstPageHandler.className = "mr-2";
	firstPageHandler.onclick = function () {
		toFirstPage(grid);
	};

	let firstPageIcon = document.createElement("i");
	firstPageIcon.className = "fas fa-angle-double-left";

	let pagerInput = document.createElement("input");
	pagerInput.className = "form-control";
	pagerInput.value = parseInt(params.page);
	pagerInput.onkeydown = function (event) {
		if (event.which === 13) {
			jumpToPage(grid, event.target.value);
		}
	};

	let nextPageHandler = document.createElement("button");
	nextPageHandler.className = "ml-2";
	nextPageHandler.onclick = function () {
		toNextPage(grid, params.page);
	};

	let nextPageIcon = document.createElement("i");
	nextPageIcon.className = "fas fa-angle-right";

	let lastPageHandler = document.createElement("button");
	lastPageHandler.className = "ml-2";
	lastPageHandler.onclick = function () {
		toLastPage(grid);
	};

	let lastPageIcon = document.createElement("i");
	lastPageIcon.className = "fas fa-angle-double-right";

	let perPageSelect = document.createElement("select");
	perPageSelect.className = "ml-2";
	params.rowList.forEach((rowList) => {
		let option = document.createElement("option");
		option.value = rowList;
		option.innerHTML = rowList;

		if (params.rowNum == rowList) {
			option.setAttribute("selected", "selected");
		}

		perPageSelect.append(option);
	});
	perPageSelect.onchange = function (event) {
		setPerPage(grid, event.target.value);
	};

	firstPageHandler.append(firstPageIcon);
	$(element).append(firstPageHandler);

	previousPageHandler.append(previousPageIcon);
	$(element).append(previousPageHandler);

	$(element).append(pagerInput);

	nextPageHandler.append(nextPageIcon);
	$(element).append(nextPageHandler);

	lastPageHandler.append(lastPageIcon);
	$(element).append(lastPageHandler);

	$(element).append(perPageSelect);
	$(element).find("input").before("page ");
	$(element).find("input").after(`of ${params.lastpage}`);
}

function toNextPage(grid, currentPage) {
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

function toPreviousPage(grid, currentPage) {
	if (currentPage > 1) {
		grid.trigger("reloadGrid", [
			{
				page: parseInt(currentPage) - 1,
			},
		]);
	}
}

function toFirstPage(grid) {
	let currentPage = grid.getGridParam('page')
	
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

function loadPagerInfo(element, grid) {
	let params = grid.getGridParam();
	let recordCount = params.reccount;
	let page = params.page;
	let perPage = params.rowNum;
	let totalRecords = params.records;
	let firstRow = (page - 1) * perPage + 1;
	let lastRow = firstRow + recordCount - 1;

	$(element).html(`View ${firstRow} - ${lastRow} of ${totalRecords}`);
}
