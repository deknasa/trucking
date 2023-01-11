let sidebarIsOpen = false;
let formats;
let offDays;
let addedRules;

$(document).ready(function () {
	setFormats();
	startTime();
	setSidebarBindKeys();
	openMenuParents();
	// initDatepicker();
	initSelect2();
	initAutoNumeric();
	initDisabled();

	/* Remove autocomplete */
	$("input").attr("autocomplete", "off");
	$("input, textarea").attr("spellcheck", "false");

	$(document).on("click", "#sidebar-overlay", () => {
		$(document).trigger("sidebar:toggle");

		sidebarIsOpen = false;
	});

	$(document).on("show.bs.modal", ".modal", function () {
		const zIndex = 1040 + 10 * $(".modal:visible").length;
		$(this).css("z-index", zIndex);
		setTimeout(() =>
			$(".modal-backdrop")
				.not(".modal-stack")
				.css("z-index", zIndex - 1)
				.addClass("modal-stack")
		);
	});

	$(document).on("hidden.bs.modal", ".modal", function () {
		$(".modal:visible").length && $(document.body).addClass("modal-open");
	});

	$('#loader').addClass('d-none')

	$('#splash img').addClass('animate-zoom-in')
	
	setTimeout(() => {
		$('#splash').addClass('d-none')
	}, 500);
});

window.onbeforeunload =() => {
	$('#loader').removeClass('d-none')
}

function setFormats() {
	$.ajax({
		url: `${appUrl}/formats/global.json`,
		method: "GET",
		dataType: "JSON",
		async: false,
		cache: false,
		success: (response) => {
			formats = response;
		},
		error: (error) => {
			showDialog(error.statusText);
		},
	});
}

function initDisabled() {
	$(".disabled").each(function () {
		$(this).disable();
	});
}

function initAutoNumeric(elements = null) {
	let option = {
		digitGroupSeparator: formats.THOUSANDSEPARATOR,
		decimalCharacter: formats.DECIMALSEPARATOR,
	};

	if (elements == null) {
		new AutoNumeric.multiple(".autonumeric", option);
	} else {
		$.each(elements, (index, element) => {
			new AutoNumeric(element, option);
		});
	}
}

function unformatAutoNumeric(data) {
	let autoNumericElements = $(".autonumeric");

	$.each(autoNumericElements, (index, autoNumericElement) => {
		let inputs = data.filter((row) => row.name == autoNumericElement.name);

		inputs.forEach((input, index) => {
			if (input.value !== "") {
				input.value = AutoNumeric.getNumber(autoNumericElement);
			}
		});
	});

	return data;
}

function setHighlight(grid) {
	let stringFilters;
	let filters;
	let gridId;

	stringFilters = grid.getGridParam("postData").filters;

	if (stringFilters) {
		filters = JSON.parse(stringFilters);
	}

	gridId = $(grid).getGridParam().id;

	if (filters) {
		filters.rules.forEach((rule) => {
			$(grid)
				.find(`tbody tr td[aria-describedby=${gridId}_${rule.field}]`)
				.highlight(rule.data);
		});
	}
}

function currencyFormat(value) {
	let result = parseFloat(value).toLocaleString("en-US", {
		minimumFractionDigits: 2,
		maximumFractionDigits: 2,
	});

	result = result.replace(/\./g, "*");
	result = result.replace(/,/g, formats.THOUSANDSEPARATOR);
	result = result.replace(/\*/g, formats.DECIMALSEPARATOR);

	return result;
}

function currencyUnformat(value) {
	let result = parseFloat(value.replaceAll(formats.THOUSANDSEPARATOR, ""));

	return result;
}

function dateFormat(value) {
	let date = new Date(value);

	let seconds = date.getSeconds("default");
	let minutes = date.getMinutes("default");
	let hours = date.getHours("default");
	let day = date.getDate("default");
	let month = date.getMonth("default") + 1;
	let year = date.getFullYear("default");

	return `${day.toString().padStart(2, "0")}-${month
		.toString()
		.padStart(2, "0")}-${year}`;
}

function setNumberSeparators() {
	$.ajax({
		url: `${apiUrl}parameter`,
		method: "GET",
		async: false,
		data: {
			filters: JSON.stringify({
				groupOp: "AND",
				rules: [
					{
						field: "grp",
						op: "cn",
						data: "FORMAT ANGKA",
					},
				],
			}),
		},
		beforeSend: (jqXHR) => {
			jqXHR.setRequestHeader("Authorization", `Bearer ${accessToken}`);
		},
		success: (response) => {
			response.data.forEach((data) => {
				if (data.subgrp == "DESIMAL") {
					decimalSeparator = data.text;
				} else if (data.subgrp == "RIBUAN") {
					thousandSeparator = data.text;
				}
			});
		},
	});
}

function openMenuParents() {
	let currentMenu = $("a.nav-link.active").first();
	let parents = currentMenu.parents("li.nav-item");

	parents.each((index, parent) => {
		$(parent).addClass("menu-open");
	});
}

$(document).on("sidebar:toggle", () => {
	if ($("body").hasClass("sidebar-collapse")) {
		sidebarIsOpen = false;

		$("#search").focusout();
		$("body").removeClass("no-scroll");
	} else if ($("body").hasClass("sidebar-open")) {
		sidebarIsOpen = true;

		$("body").addClass("no-scroll");

		if (detectDeviceType() == "desktop") {
			$("#search").focus();
		}
	}
});

$(document).ajaxError((event, jqXHR, ajaxSettings, thrownError) => {
	if (jqXHR.status === 401) {
		showDialog(thrownError, jqXHR.responseJSON.message);
	}
});

// $(window).on("resize", function (event) {
// 	if ($(window).width() > 990) {
// 		$("body").removeClass();
// 		setTimeout(() => {
// 			$("body").addClass("sidebar-closed sidebar-collapse");
// 		}, 0);
// 	}
// });

$(".sidebars").click(function (e) {
	$("body").addClass("sidebar-open");
	e.preventDefault();
});

$(document).mouseup(function (e) {
	var container = $(".main-sidebar");
	if (!container.is(e.target) && container.has(e.target).length === 0) {
		if ($("body").hasClass("sidebar-open")) {
			$("body").removeClass("sidebar-open");
		}
	}
});

/* Disable plugin */
$.fn.disable = function () {
	this.bind("cut copy paste change", function () {
		return false;
	});

	this.on("keydown", (e) => {
		if (!e.altKey && !e.ctrlKey && e.which !== 27) {
			e.preventDefault();
			return false;
		}
	});

	if (this.is("select")) {
		let selected = this.find("option:selected");

		this.change(() => {
			this.val(selected.val());
		});
	}
};

function setErrorMessages(form, errors) {
	$.each(errors, (index, error) => {
		let indexes = index.split(".");
		let element;

		if (indexes.length > 1) {
			element = form.find(`[name="${indexes[0]}[]"]`)[indexes[1]];
		} else {
			element = form.find(`[name="${indexes[0]}"]`)[0];
		}

		if ($(element).length > 0 && !$(element).is(":hidden")) {
			$(element).addClass("is-invalid");
			$(`
					<div class="invalid-feedback">
					${error}
					</div>
			`).appendTo($(element).parent());
		} else {
			return showDialog(error);
		}
	});

	$(".is-invalid").first().focus();
}

function removeTags(str) {
	if (str === null || str === "") return false;
	else str = str.toString();
	return str.replace(/(<([^>]+)>)/gi, "");
}

/**
 * Set Home, End, PgUp, PgDn
 * to move grid page
 */
function setCustomBindKeys(grid) {
	setSidebarBindKeys();

	$(document).on("keydown", function (e) {
		if (!sidebarIsOpen && activeGrid) {
			if (
				e.keyCode == 33 ||
				e.keyCode == 34 ||
				e.keyCode == 35 ||
				e.keyCode == 36 ||
				e.keyCode == 38 ||
				e.keyCode == 40 ||
				e.keyCode == 13
			) {
				e.preventDefault();

				var gridIds = $(activeGrid).getDataIDs();
				var selectedRow = $(activeGrid).getGridParam("selrow");
				var currentPage = $(activeGrid).getGridParam("page");
				var lastPage = $(activeGrid).getGridParam("lastpage");
				var currentIndex = 0;
				var row = $(activeGrid).jqGrid("getGridParam", "postData").rows;

				for (var i = 0; i < gridIds.length; i++) {
					if (gridIds[i] == selectedRow) currentIndex = i;
				}

				if (triggerClick == false) {
					if (33 === e.keyCode) {
						if (currentPage > 1) {
							$(activeGrid)
								.jqGrid("setGridParam", {
									page: parseInt(currentPage) - 1,
								})
								.trigger("reloadGrid");

							triggerClick = true;
						}
						$(activeGrid).triggerHandler("jqGridKeyUp"), e.preventDefault();
					}
					if (34 === e.keyCode) {
						if (currentPage !== lastPage) {
							$(activeGrid)
								.jqGrid("setGridParam", {
									page: parseInt(currentPage) + 1,
								})
								.trigger("reloadGrid");

							triggerClick = true;
						}
						$(activeGrid).triggerHandler("jqGridKeyUp"), e.preventDefault();
					}
					if (35 === e.keyCode) {
						if (currentPage !== lastPage) {
							$(activeGrid)
								.jqGrid("setGridParam", {
									page: lastPage,
								})
								.trigger("reloadGrid");
							if (e.ctrlKey) {
								if (
									$(activeGrid).jqGrid("getGridParam", "selrow") !==
									$("#customer")
										.find(">tbody>tr.jqgrow")
										.filter(":last")
										.attr("id")
								) {
									$(activeGrid)
										.jqGrid(
											"setSelection",
											$(activeGrid)
												.find(">tbody>tr.jqgrow")
												.filter(":last")
												.attr("id")
										)
										.trigger("reloadGrid");
								}
							}

							triggerClick = true;
						}
						if (e.ctrlKey) {
							if (
								$(activeGrid).jqGrid("getGridParam", "selrow") !==
								$("#customer")
									.find(">tbody>tr.jqgrow")
									.filter(":last")
									.attr("id")
							) {
								$(activeGrid)
									.jqGrid(
										"setSelection",
										$(activeGrid)
											.find(">tbody>tr.jqgrow")
											.filter(":last")
											.attr("id")
									)
									.trigger("reloadGrid");
							}
						}
						$(activeGrid).triggerHandler("jqGridKeyUp"), e.preventDefault();
					}
					if (36 === e.keyCode) {
						if (currentPage > 1) {
							if (e.ctrlKey) {
								if (
									$(activeGrid).jqGrid("getGridParam", "selrow") !==
									$("#customer")
										.find(">tbody>tr.jqgrow")
										.filter(":first")
										.attr("id")
								) {
									$(activeGrid).jqGrid(
										"setSelection",
										$(activeGrid)
											.find(">tbody>tr.jqgrow")
											.filter(":first")
											.attr("id")
									);
								}
							}
							$(activeGrid)
								.jqGrid("setGridParam", {
									page: 1,
								})
								.trigger("reloadGrid");

							triggerClick = true;
						}
						$(activeGrid).triggerHandler("jqGridKeyUp"), e.preventDefault();
					}
					if (38 === e.keyCode) {
						if (currentIndex - 1 >= 0) {
							$(activeGrid)
								.resetSelection()
								.setSelection(gridIds[currentIndex - 1]);
						}
					}
					if (40 === e.keyCode) {
						if (currentIndex + 1 < gridIds.length) {
							$(activeGrid)
								.resetSelection()
								.setSelection(gridIds[currentIndex + 1]);
						}
					}
					if (13 === e.keyCode) {
						let rowId = $(activeGrid).getGridParam("selrow");
						let ondblClickRowHandler = $(activeGrid).jqGrid(
							"getGridParam",
							"ondblClickRow"
						);

						if (ondblClickRowHandler) {
							ondblClickRowHandler.call($(activeGrid)[0], rowId);
						}
					}
				}

				$(".ui-jqgrid-bdiv").find("tbody").animate({
					scrollTop: 200,
				});
				$(".table-success").position().top > 300;
			}
		}
	});
}

function setSidebarBindKeys() {
	$(document).on("keydown", (event) => {
		if (event.keyCode === 77 && event.altKey) {
			event.preventDefault();

			$("#sidebarButton").click();
		}

		if (sidebarIsOpen) {
			let allowedKeyCodes = [37, 38, 39, 40];

			if (allowedKeyCodes.includes(event.keyCode)) {
				event.preventDefault();

				$("#search").val("");

				if ($(".nav-link.active, .nav-link.hover").length <= 0) {
					$(".main-sidebar nav .nav-link").first().addClass("hover");
				}

				switch (event.keyCode) {
					case 37:
						setUpOneLevelMenu();

						break;
					case 38:
						setPreviousMenuHover();

						break;
					case 39:
						setDownOneLevelMenu();

						break;
					case 40:
						setNextMenuHover();

						break;
					default:
						break;
				}
			} else if (event.keyCode === 13) {
				let hoveredElement = $(".nav-link.hover");

				if (hoveredElement.length > 0) {
					if (hoveredElement.siblings("ul").length > 0) {
						setDownOneLevelMenu();
					} else {
						hoveredElement[0].click();
					}
				}
			}
		}
	});
}

function setNextMenuHover() {
	let currentElement = $(".nav-link.hover").first();

	if (currentElement.length <= 0) {
		currentElement = $(".nav-link.selected-link");
	}

	if (currentElement.length <= 0) {
		currentElement = $(".nav-link.active");
	}

	let nextElement = currentElement
		.parent(".nav-item")
		.next()
		.find(".nav-link")
		.first();

	if (nextElement.length > 0) {
		currentElement.removeClass("selected-link hover");
		nextElement.addClass("hover");
	}
}

function setPreviousMenuHover() {
	let currentElement = $(".nav-link.hover").first();

	if (currentElement.length <= 0) {
		currentElement = $(".nav-link.selected-link");
	}

	if (currentElement.length <= 0) {
		currentElement = $(".nav-link.active");
	}

	let nextElement = currentElement
		.parent(".nav-item")
		.prev()
		.find(".nav-link")
		.first();

	if (nextElement.length > 0) {
		currentElement.removeClass("selected-link hover");
		nextElement.addClass("hover");
	}
}

function setUpOneLevelMenu() {
	let currentElement = $(".nav-link.hover").first();

	if (currentElement.length <= 0) {
		currentElement = $(".nav-link.selected-link");
	}

	if (currentElement.length <= 0) {
		currentElement = $(".nav-link.active");
	}

	let upOneLevelElement = currentElement.parents().eq(2);

	if (upOneLevelElement.length > 0) {
		currentElement.removeClass("selected-link hover");
		upOneLevelElement.removeClass("menu-is-opening menu-open");
		upOneLevelElement.find(".nav-link").first().addClass("hover");
	}
}

function setDownOneLevelMenu() {
	let currentElement = $(".nav-link.hover").first();

	if (currentElement.length <= 0) {
		currentElement = $(".nav-link.selected-link");
	}

	if (currentElement.length <= 0) {
		currentElement = $(".nav-link.active");
	}

	let downOneLevelElement = currentElement
		.siblings("ul")
		.css({
			display: "",
		})
		.find(".nav-link")
		.first();

	if (downOneLevelElement.length > 0) {
		currentElement.removeClass("selected-link hover");
		currentElement.parent(".nav-item").addClass("menu-open");
		downOneLevelElement.addClass("hover");
	}
}

function fillSearchMenuInput() {
	let currentElement = $(".nav-link.hover").first();

	if (currentElement.length <= 0) {
		currentElement = $(".nav-link.selected-link");
	}

	if (currentElement.length <= 0) {
		currentElement = $(".nav-link.active");
	}

	$("#search").val(currentElement.attr("id"));
}

/**
 * Move to closest input when using press enter
 */
function setFormBindKeys(form = null) {
	let element;
	let position;
	let inputs;

	if (form !== null) {
		inputs = form.find(
			"[name]:not(:hidden, [readonly], [disabled], .disabled), button:submit"
		);
	} else {
		inputs = $(document).find(
			"[name]:not(:hidden, [readonly], [disabled], .disabled), button:submit"
		);
	}

	$($(inputs.filter(":not(button)")[0])).focus();

	if (!$("#crudForm").attr("has-binded")) {
		inputs.each(function (i, el) {
			$(el).attr("data-input-index", i);
		});

		inputs.focus(function () {
			$(this).data("input-index");
		});

		inputs.keydown(function (e) {
			let operator;
			switch (e.keyCode) {
				case 38:
					// if ($(this).parents('table').length > 0) {
					// 	element = $(this).parents('tr').prev('tr').find('td').eq($(this).parent().index()).find('input')
					// } else {
					element = $(inputs[$(this).data("input-index") - 1]);
					// }

					break;
				case 13:
					if (e.shiftKey) {
						element = $(inputs[$(this).data("input-index") - 1]);
					} else if (e.ctrlKey) {
						$(this).closest("form").find("button:submit").click();
					} else {
						element = $(inputs[$(this).data("input-index") + 1]);

						if (e.keyCode == 13 && $(this).is("button")) {
							$(this).click();
						}
					}

					break;
				case 40:
					element = $(inputs[$(this).data("input-index") + 1]);

					break;
				default:
					return;
			}

			if (element !== undefined) {
				if (
					element.is(":not(select, button)") &&
					element.attr("type") !== "email" &&
					element.attr("type") !== "time"
				) {
					position = element.val().length;
					element[0].setSelectionRange(position, position);
				}

				element.hasClass("hasDatePicker")
					? $(".ui-datepicker").show()
					: $(".ui-datepicker").hide();
				element.focus();
			}

			e.preventDefault();
		});

		form.attr("has-binded", true);
	}
}

function initResize(grid) {
	/* Check if scrollbar appears */
	$(window).height() < $(document).height()
		? grid.setGridWidth($(window).width() - 15)
		: "";

	/* Resize grid while resizing window */
	$(window).resize(function () {
		grid.setGridWidth($(window).width() - 15);
	});
}

var delay = (function () {
	var timer = 0;
	return function (callback, ms) {
		clearTimeout(timer);
		timer = setTimeout(callback, ms);
	};
})();

function loadGlobalSearch(grid) {
	/* Append global search textfield */
	$("#t_" + $.jgrid.jqID(grid[0].id)).html(
		$(
			`<form class="form-inline"><div class="form-group w-100 px-2" id="titlesearch"><label for="searchText" style="font-weight: normal !important;">Search : </label><input type="text" class="form-control global-search" id="${$.jgrid.jqID(
				grid[0].id
			)}_searchText" placeholder="Search" autocomplete="off"></div></form>`
		)
	);

	/* Handle textfield on input */
	$(document).on(
		"input",
		`#${$.jgrid.jqID(grid[0].id)}_searchText`,
		function () {
			delay(function () {
				clearColumnSearch(grid);

				var postData = grid.jqGrid("getGridParam", "postData"),
					colModel = grid.jqGrid("getGridParam", "colModel"),
					rules = [],
					searchText = $(`#${$.jgrid.jqID(grid[0].id)}_searchText`).val(),
					l = colModel.length,
					i,
					cm;
				if (addedRules) {
					rules.push(addedRules);
				}
				for (i = 0; i < l; i++) {
					cm = colModel[i];
					if (
						cm.search !== false &&
						(cm.stype === undefined ||
							cm.stype === "text" ||
							cm.stype === "select")
					) {
						rules.push({
							field: cm.name,
							op: "cn",
							data: searchText.toUpperCase(),
						});
					}
				}
				postData.filters = JSON.stringify({
					groupOp: "OR",
					rules: rules,
				});

				grid.jqGrid("setGridParam", {
					search: true,
				});
				grid.trigger("reloadGrid", [
					{
						page: 1,
						current: true,
					},
				]);
				return false;
			}, 500);
		}
	);
}

function additionalRulesGlobalSearch(params) {
	if (JSON.parse(params).rules[0]) {
		addedRules = JSON.parse(params).rules[0];
	}
}

function clearColumnSearch(grid) {
	$(`#gview_${grid.getGridParam("id")}`)
		.find('input[id*="gs_"]')
		.val("");
	$(`#gview_${grid.getGridParam("id")}`)
		.find('select[id*="gs_"]')
		.val("")
		.trigger("change.select2");
	$(`#resetdatafilter_${grid.getGridParam("id")}`).removeClass("active");
}

function clearGlobalSearch(grid) {
	$(`#${grid.getGridParam("id")}_searchText`).val("");
}

function loadClearFilter(grid) {
	/* Append Button */
	$("#gsh_" + $.jgrid.jqID(grid[0].id) + "_rn").html(
		$(
			`<div id='resetfilter' class='reset'><span id="resetdatafilter_${grid.getGridParam(
				"id"
			)}" class='btn btn-default'> X </span></div>`
		)
	);

	/* Handle button on click */
	$(`#resetdatafilter_${grid.getGridParam("id")}`).click(function () {
		highlightSearch = "";

		clearColumnSearch(grid);
		clearGlobalSearch(grid);

		grid
			.jqGrid("setGridParam", {
				search: false,
				postData: {
					filters: "",
				},
			})
			.trigger("reloadGrid");
	});
}

function startTime() {
	setInterval(() => {
		$(".time-place").html(
			new Date()
				.toLocaleString("id", {
					dateStyle: "medium",
					timeStyle: "medium",
				})
				.replaceAll(".", ":")
		);
	}, 1000);
}

function initDatepicker() {
	let element = $(document).find(".datepicker");

	if (!offDays) {
		offDays = getOffDays();
	}

	if (!element.parent().hasClass("input-group")) {
		element.wrap(`
				<div class="input-group">
				</div>
			`);
	}

	element
		.datepicker({
			dateFormat: "dd-mm-yy",
			changeYear: true,
			changeMonth: true,
			assumeNearbyYear: true,
			showOn: "button",
			beforeShow: function (element) {
				$(element).css({
					position: "relative"
				});
			},
			beforeShowDay: function (date) {
				let y = date.getFullYear().toString(); // get full year
				let m = (date.getMonth() + 1).toString(); // get month.
				let d = date.getDate().toString(); // get Day

				if (m.length == 1) {
					m = "0" + m;
				} // append zero(0) if single digit
				if (d.length == 1) {
					d = "0" + d;
				} // append zero(0) if single digit
				let currDate = y + "-" + m + "-" + d;

				let offDay = offDays.find((offDay) => offDay.date == currDate);

				if (offDay) {
					return [
						true,
						"ui-state-disabled datepicker-offday",
						offDay.description,
					];
				} else {
					return [true];
				}
			},
		})
		.inputmask({
			inputFormat: "dd-mm-yyyy",
			alias: "datetime",
		})
		.focusout(function (e) {
			let val = $(this).val();
			if (val.match("[a-zA-Z]") == null) {
				if (val.length == 8) {
					$(this)
						.inputmask({
							inputFormat: "dd-mm-yyyy",
						})
						.val([val.slice(0, 6), "20", val.slice(6)].join(""));
				}
			} else {
				$(this).focus();
			}
		});

	element
		.siblings(".ui-datepicker-trigger")
		.wrap(
			`
			<div class="input-group-append">
			</div>
		`
		)
		.addClass("btn btn-primary").html(`
			<i class="fa fa-calendar-alt"></i>
		`);

	element.on("keydown", function (event) {
		if (event.keyCode === 115) {
			if (element.datepicker("widget").not(":visible")) {
				element.datepicker("show");
			}
		}
	});
}

function getOffDays() {
	let offDays = [];

	$.ajax({
		url: `${apiUrl}harilibur`,
		method: "GET",
		dataType: "JSON",
		headers: {
			Authorization: `Bearer ${accessToken}`
		},
		data: {
			limit: 0,
		},
		async: false,
		cache: true,
		success: (response) => {
			let convertedResponse = [];

			response.data.forEach((row) => {
				convertedResponse.push({
					date: row.tgl,
					description: row.keterangan,
				});
			});

			offDays = convertedResponse;
		},
	});

	return offDays;
}

function destroyDatepicker() {
	let datepickerElements = $(document).find(".datepicker");

	$.each(datepickerElements, (index, datepickerElement) => {
		$(datepickerElement).datepicker("destroy");
	});
}

$(document).on("input", ".numbernoseparate", function () {
	this.value = this.value.replace(/\D/g, "");
});

/* Select2: Autofocus search input on open */
function initSelect2(elements = null, isInsideModal = true) {
	let option = {
		width: "100%",
		theme: "bootstrap4",
		dropdownParent: isInsideModal ? $("#crudModal") : '',
	};

	if (elements === null) {
		$(document)
			.find("select")
			.select2(option)
			.on("select2:open", function (e) {
				document.querySelector(".select2-search__field").focus();
			});
	} else {
		$.each(elements, (index, element) => {
			$(element)
				.select2(option)
				.on("select2:open", function (e) {
					document.querySelector(".select2-search__field").focus();
				});
		});
	}
}

function destroySelect2() {
	let select2Elements = $(document).find("select");

	$.each(select2Elements, (index, select2Element) => {
		$(select2Element).select2("destroy");
	});
}

// select2 lama untuk testing lokal
// function initSelect2() {
// 	$(document)
// 		.find("select")
// 		.select2({
// 			theme: "bootstrap4",
// 		})
// 		.on("select2:open", function (e) {
// 			document.querySelector(".select2-search__field").focus();
// 		});
// }

// function destroySelect2() {
// 	let select2Elements = $(document).find("select");

// 	$.each(select2Elements, (index, select2Element) => {
// 		$(select2Element).select2("destroy");
// 	});
// }

function showDialog(statusText = "", message = "") {
	$("#dialog-message").find("p").remove();
	$("#dialog-message").append(`<p> ${statusText} </p><p> ${message} </p>`);
	$("#dialog-message").dialog({
		modal: true,
	});
}

$(document).ready(function () {
	$("#sidebarButton").click(function () {
		setTimeout(() => {
			$(document).trigger("sidebar:toggle");
		}, 0);

		$(".nav-treeview").each(function (i, el) {
			$(el).removeAttr("style");
		});
	});

	var url = window.location.href;

	/** add active class and stay opened when selected */
	var url = window.location;

	// for sidebar menu entirely but not cover treeview
	$("ul.sidebar-menu a")
		.filter(function () {
			return this.href == url;
		})
		.parent()
		.addClass("active");

	// for treeview
	$("ul.treeview-menu a")
		.filter(function () {
			return this.href == url;
		})
		.parentsUntil(".sidebar-menu > .treeview-menu")
		.addClass("active");
});

$("#search").keyup(function () {
	$(this).data("val", $(this).val());
});

$("#search").on("input", function (e) {
	var code = $(this).val();
	var test = $("#" + code).attr("id");
	var attr = $("#" + test).attr("href");

	$(".sidebar .hover").removeClass("hover");

	if (code === "") {
		$(".selected").click().removeClass("selected");
	} else {
		if (
			$("#" + test).hasClass("selected") ||
			$("#" + test).hasClass("selected-link")
		) {
			var prev = $(this).data("val");
			$("#" + prev)
				.removeClass("selected")
				.click();
			$("#" + prev).removeClass("active selected-link");
		} else {
			if (attr != "javascript:void(0)") {
				var link = $("#" + test).addClass("selected-link");
				$(document).on("keypress", function (e) {
					if (e.keyCode == 13) {
						if ($(link).hasClass("selected-link")) {
							$(link)[0].click();
						} else {
							return false;
						}
					}
				});
			} else {
				if (
					$("#" + test)
						.parent(".nav-item")
						.hasClass("menu-is-opening menu-open") ||
					$("#" + test)
						.parent(".nav-item")
						.hasClass("menu-open")
				) {
					$("#" + test).addClass("selected");
				} else {
					$("#" + test)[0].click();
					$("#" + test).addClass("selected");
				}
			}
		}
	}
});

/* Table bindkeys */
$(document).on("keydown", ".table-bindkeys [name]", function (event) {
	switch (event.keyCode) {
		case 13:
			event.preventDefault();
		case 38:
			incomingElement = $(this)
				.parents("tr")
				.prev("tr")
				.find("td")
				.eq($(this).parents("td").index())
				.find("[name]");

			if (incomingElement.length !== 0) {
				setPrevFocus(incomingElement);
			}
			break;
		case 40:
			incomingElement = $(this)
				.parents("tr")
				.next("tr")
				.find("td")
				.eq($(this).parents("td").index())
				.find("[name]");

			if (incomingElement.length == 0) {
				$("form button#btnSimpan").focus();
			} else {
				incomingElement.focus();
			}
			break;
		default:
			break;
	}
});

$(document)
	.on("mousedown", "#addrow", function (event) {
		activeElement = document.activeElement;
	})
	.on("mouseup", "#addrow", function (event) {
		if (
			($(activeElement).is("input") ||
				$(activeElement).is("select") ||
				$(activeElement).is("textarea")) &&
			$(activeElement).parents(".table-bindkeys").length > 0
		) {
			if (
				typeof $(activeElement).attr("name") !== "undefined" &&
				$(activeElement).attr("name") !== false
			) {
				activeElement.focus();
			}
		} else {
			$(".table-bindkeys").find("[name]")[0].focus();
		}
	});

function setPrevFocus(incomingElement) {
	position = incomingElement.val().length;

	setTimeout(() => {
		incomingElement[0].setSelectionRange(position, position);
	}, 0);

	incomingElement.focus();
}

function detectDeviceType() {
	const ua = navigator.userAgent;
	if (/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i.test(ua)) {
		return "tablet";
	} else if (
		/Mobile|Android|iP(hone|od)|IEMobile|BlackBerry|Kindle|Silk-Accelerated|(hpw|web)OS|Opera M(obi|ini)/.test(
			ua
		)
	) {
		return "mobile";
	}
	return "desktop";
}
