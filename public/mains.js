$(document).ready(function () {
	startTime();
	setFormBindKeys();

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
		digitGroupSeparator: ".",
		decimalCharacter: ",",
	});
});

$(window).on("resize", function (event) {
	if ($(window).width() > 990) {
		$("body").addClass("sidebar-close sidebar-collapse");
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
		$(`[name=${index}]`).addClass("is-invalid").after(`
<div class="invalid-feedback">
${error}
</div>
`);
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
	$(document).on("keydown", function (e) {
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
										$(grid).find(">tbody>tr.jqgrow").filter(":last").attr("id")
									)
									.trigger("reloadGrid");
							}
						}

						triggerClick = true;
					}
					if (e.ctrlKey) {
						if (
							$(grid).jqGrid("getGridParam", "selrow") !==
							$("#customer").find(">tbody>tr.jqgrow").filter(":last").attr("id")
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
		}
	});
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

	$($(inputs[0])).focus();

	inputs.focus(function () {
		$(this).data("input-index");
	});

	inputs.keydown(function (e) {
		let operator;
		switch (e.keyCode) {
			case 38:
				element = $(inputs[$(this).data("input-index") - 1]);

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
				element.attr("type") !== "email"
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
	$('select[id*="gs_"]').val("");
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

		clearGlobalSearch();
		clearColumnSearch();

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

function tampilkanjam() {
	var waktu = new Date();
	var jam = waktu.getHours();
	var menit = waktu.getMinutes();
	var detik = waktu.getSeconds();
	var teksjam = new String();
	if (menit <= 9) menit = "0" + menit;
	if (detik <= 9) detik = "0" + detik;
	teksjam = jam + ":" + menit + ":" + detik;
	tempatjam.innerHTML = teksjam;
	setTimeout(tampilkanjam, 1000);
}

function tampilkantanggal() {
	var d = new Date();

	var month = d.getMonth() + 1;
	var day = d.getDate();

	var output =
		d.getFullYear() +
		"/" +
		(("" + month).length < 2 ? "0" : "") +
		month +
		"/" +
		(("" + day).length < 2 ? "0" : "") +
		day;

	tempattanggal.innerHTML = output;
}

function startTime() {
	tampilkanjam();
	tampilkantanggal();
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

function showDialog(message = "") {
	$("#dialog-message p").html(message);
	$("#dialog-message").dialog({
		modal: true,
	});
}
