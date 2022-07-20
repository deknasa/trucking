let sidebarIsOpen = false;
let thousandSeparator = ','
let decimalSeparator = '.'

$(document).ready(function () {
	startTime();
	setFormBindKeys();
	setSidebarBindKeys();
	openMenuParents();
	setNumberSeparators()

	/* Remove autocomplete */
	$("input").attr("autocomplete", "off");
	$("input, textarea").attr("spellcheck", "false");

	/* Init disable plugin */
	$(".disabled").each(function () {
		$(this).disable();
	});

	$("input").attr("autocomplete", "off");
	$("input, textarea").attr("spellcheck", "false");

	new AutoNumeric.multiple(".autonumeric", {
		digitGroupSeparator: ",",
		decimalCharacter: ".",
	});

	$(document).on("click", "#sidebar-overlay", () => {
		$(document).trigger("sidebar:toggle");

		sidebarIsOpen = false;
	});
});

function currencyFormat(value) {
	let result = parseFloat(value).toLocaleString('en-US', {
		minimumFractionDigits: 2,
		maximumFractionDigits: 2
	})

	result = result.replace(/\./g, '*')
	result = result.replace(/,/g, thousandSeparator)
	result = result.replace(/\*/g, decimalSeparator)

	return result
}

function dateFormat(value) {
	let date = new Date(value)

	let seconds = date.getSeconds('default')
	let minutes = date.getMinutes('default')
	let hours = date.getHours('default')
	let day = date.getDate('default')
	let month = date.getMonth('default') + 1
	let year = date.getFullYear('default')

	return `${day.toString().padStart(2, "0")}-${month.toString().padStart(2, "0")}-${year}`
}

function setNumberSeparators() {
  $.ajax({
    url: `${apiUrl}parameter`,
    method: 'GET',
    async: false,
    data: {
      filters: JSON.stringify({
        "groupOp": "AND",
        "rules": [{
          "field": "grp",
          "op": "cn",
          "data": "FORMAT ANGKA"
        }]
      })
    },
    beforeSend: jqXHR => {
      jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
    },
    success: response => {
      response.data.forEach(data => {
        if (data.subgrp == 'DESIMAL') {
          decimalSeparator = data.text
        } else if (data.subgrp == 'RIBUAN') {
          thousandSeparator = data.text
        }
      });
    }
  })
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
	} else if ($("body").hasClass("sidebar-open")) {
		sidebarIsOpen = true;

		$("#search").focus();
	}
});

$(document).ajaxError((event, jqXHR, ajaxSettings, thrownError) => {
	if (jqXHR.status !== 422) {
		showDialog(thrownError, jqXHR.responseJSON.message);
	}
});

$(window).on("resize", function (event) {
	if ($(window).width() > 990) {
		$("body").removeClass();
		setTimeout(() => {
			$("body").addClass("sidebar-closed sidebar-collapse");
		}, 0);
	}
});

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
		if (!e.altKey && !e.ctrlKey) {
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

function setErrorMessages(errors) {
	$(`[name=${Object.keys(errors)[0]}]`).focus();

	$.each(errors, (index, error) => {
		if ($(`[name=${index}]`).length > 0) {
			$(`[name=${index}]`).addClass("is-invalid").after(`
                <div class="invalid-feedback">
                ${error}
                </div>
            `);
		} else {
			return showDialog(error);
		}
	});
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
		if (!sidebarIsOpen) {
			if (
				e.keyCode == 33 ||
				e.keyCode == 34 ||
				e.keyCode == 35 ||
				e.keyCode == 36 ||
				e.keyCode == 38 ||
				e.keyCode == 40
			) {
				e.preventDefault();

				var gridIds = $("#jqGrid").getDataIDs();
				var selectedRow = $("#jqGrid").getGridParam("selrow");
				var currentPage = $(grid).getGridParam("page");
				var lastPage = $(grid).getGridParam("lastpage");
				var currentIndex = 0;
				var row = $(grid).jqGrid("getGridParam", "postData").rows;

				for (var i = 0; i < gridIds.length; i++) {
					if (gridIds[i] == selectedRow) currentIndex = i;
				}

				if (triggerClick == false) {
					if (33 === e.keyCode) {
						if (currentPage > 1) {
							$(grid)
								.jqGrid("setGridParam", {
									page: parseInt(currentPage) - 1,
								})
								.trigger("reloadGrid");

							triggerClick = true;
						}
						$(grid).triggerHandler("jqGridKeyUp"), e.preventDefault();
					}
					if (34 === e.keyCode) {
						if (currentPage !== lastPage) {
							$(grid)
								.jqGrid("setGridParam", {
									page: parseInt(currentPage) + 1,
								})
								.trigger("reloadGrid");

							triggerClick = true;
						}
						$(grid).triggerHandler("jqGridKeyUp"), e.preventDefault();
					}
					if (35 === e.keyCode) {
						if (currentPage !== lastPage) {
							$(grid)
								.jqGrid("setGridParam", {
									page: lastPage,
								})
								.trigger("reloadGrid");
							if (e.ctrlKey) {
								if (
									$(grid).jqGrid("getGridParam", "selrow") !==
									$("#customer")
										.find(">tbody>tr.jqgrow")
										.filter(":last")
										.attr("id")
								) {
									$(grid)
										.jqGrid(
											"setSelection",
											$(grid)
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
								$(grid).jqGrid("getGridParam", "selrow") !==
								$("#customer")
									.find(">tbody>tr.jqgrow")
									.filter(":last")
									.attr("id")
							) {
								$(grid)
									.jqGrid(
										"setSelection",
										$(grid).find(">tbody>tr.jqgrow").filter(":last").attr("id")
									)
									.trigger("reloadGrid");
							}
						}
						$(grid).triggerHandler("jqGridKeyUp"), e.preventDefault();
					}
					if (36 === e.keyCode) {
						if (currentPage > 1) {
							if (e.ctrlKey) {
								if (
									$(grid).jqGrid("getGridParam", "selrow") !==
									$("#customer")
										.find(">tbody>tr.jqgrow")
										.filter(":first")
										.attr("id")
								) {
									$(grid).jqGrid(
										"setSelection",
										$(grid).find(">tbody>tr.jqgrow").filter(":first").attr("id")
									);
								}
							}
							$(grid)
								.jqGrid("setGridParam", {
									page: 1,
								})
								.trigger("reloadGrid");

							triggerClick = true;
						}
						$(grid).triggerHandler("jqGridKeyUp"), e.preventDefault();
					}
					if (38 === e.keyCode) {
						if (currentIndex - 1 >= 0) {
							$(grid)
								.resetSelection()
								.setSelection(gridIds[currentIndex - 1]);
						}
					}
					if (40 === e.keyCode) {
						if (currentIndex + 1 < gridIds.length) {
							$(grid)
								.resetSelection()
								.setSelection(gridIds[currentIndex + 1]);
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
function setFormBindKeys() {
	let inputs = $(
		"[name]:not(:hidden, [readonly], [disabled], .disabled), button:submit"
	);
	let element;
	let position;

	inputs.each(function (i, el) {
		$(el).attr("data-input-index", i);
	});

	$($(inputs.filter(":not(button)")[0])).focus();

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

function loadGlobalSearch() {
	/* Append global search textfield */
	$("#t_" + $.jgrid.jqID($("#jqGrid")[0].id)).html(
		$(
			'<form class="form-inline"><div class="form-group" id="titlesearch"><label for="searchText" style="font-weight: normal !important;">Search : </label><input type="text" class="form-control" id="searchText" placeholder="Search" autocomplete="off"></div></form>'
		)
	);

	/* Handle textfield on input */
	$(document).on("input", "#searchText", function () {
		delay(function () {
			clearColumnSearch();

			var postData = $("#jqGrid").jqGrid("getGridParam", "postData"),
				colModel = $("#jqGrid").jqGrid("getGridParam", "colModel"),
				rules = [],
				searchText = $("#searchText").val(),
				l = colModel.length,
				i,
				cm;
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

			$("#jqGrid").jqGrid("setGridParam", {
				search: true,
			});
			$("#jqGrid").trigger("reloadGrid", [
				{
					page: 1,
					current: true,
				},
			]);
			return false;
		}, 500);
	});
}

function clearColumnSearch() {
	$('input[id*="gs_"]').val("");
	$("#resetFilterOptions span#resetFilterOptions").removeClass("aktif");
	$('select[id*="gs_"]').val("").trigger("change.select2");
	$("#resetdatafilter").removeClass("active");
}

function clearGlobalSearch() {
	$("#searchText").val("");
}

function loadClearFilter() {
	/* Append Button */
	$("#gsh_" + $.jgrid.jqID($("#jqGrid")[0].id) + "_rn").html(
		$(
			"<div id='resetfilter' class='reset'><span id='resetdatafilter' class='btn btn-default'> X </span></div>"
		)
	);

	/* Handle button on click */
	$("#resetdatafilter").click(function () {
		highlightSearch = "";

		clearColumnSearch();
		clearGlobalSearch();

		$("#jqGrid")
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
					dateStyle: "long",
					timeStyle: "medium",
				})
				.replaceAll(".", ":")
		);
	}, 1000);
}

$(".datepicker")
	.datepicker({
		dateFormat: "dd-mm-yy",
		assumeNearbyYear: true,
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

$(document).on("input", ".numbernoseparate", function () {
	this.value = this.value.replace(/\D/g, "");
});

/* Select2: Autofocus search input on open */
$(document)
	.find("select")
	.select2({
		theme: "bootstrap4",
	})
	.on("select2:open", function (e) {
		document.querySelector(".select2-search__field").focus();
	});

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
