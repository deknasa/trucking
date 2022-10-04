const getLookup = function (fileName) {
	return new Promise((resolve, reject) => {
		$.ajax({
			url: `${appUrl}/lookup/${fileName}`,
			method: "GET",
			dataType: "html",
			success: function (response) {
				resolve(response);
			},
		});
	});
};

$.fn.lookup = function (options = null) {
	this.each(function () {
		let element = $(this);

		element.wrap('<div class="input-group"></div>').after(`
        <div class="input-group-append">
          <button class="btn btn-primary lookup-toggler" type="button">...</button>
        </div>
      `);

		element
			.siblings(".input-group-append")
			.find(".lookup-toggler")
			.click(function () {
				activateLookup(element);
			});

		element.on("input", function (event) {
      $(this).val('')
      
			activateLookup(element, $(this).val());
		});
	});

	function activateLookup(element, searchValue = null) {
		let lookupModal = $(`
      <div class="modal modal-fullscreen" id="lookupModal" tabindex="-1" aria-labelledby="lookupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <form action="#" id="crudForm">
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <h5 class="modal-title" id="lookupModalLabel">${options.title}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
              </div>
              <div class="modal-footer">
                <div class="mr-auto">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                  BATAL
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    `);

		$("body").append(lookupModal);

		lookupModal.modal("show");

		getLookup(options.fileName).then((response) => {
			lookupModal.find(".modal-body").html(response);

			grid = lookupModal.find(".lookup-grid");

			if (detectDeviceType() == "desktop") {
				grid.jqGrid("setGridParam", {
					ondblClickRow: function (id) {
						handleSelectedRow(id, lookupModal, element);
					},
				});
			} else if (detectDeviceType() == "mobile") {
				grid.jqGrid("setGridParam", {
					onSelectRow: function (id) {
						handleSelectedRow(id, lookupModal, element);
					},
				});
			}
		});

		lookupModal.on("hidden.bs.modal", function () {
			lookupModal.remove();
			element.focus();
		});
	}

	function handleSelectedRow(id, lookupModal, element) {
		if (id !== null) {
			lookupModal.modal("hide");

			options.onSelectRow(sanitize(grid.getRowData(id)), element);
		} else {
			alert("Please select a row");
		}
	}

	function sanitize(rowData) {
		Object.keys(rowData).forEach((key) => {
			rowData[key] = rowData[key]
				.replaceAll('<span class="highlight">', "")
				.replaceAll("</span>", "");
		});

		return rowData;
	}

	return this;
};