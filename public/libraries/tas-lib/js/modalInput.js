// const serialize = function (obj) {
// 	var str = [];
// 	for (var p in obj)
// 		if (obj.hasOwnProperty(p)) {
// 			str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
// 		}
// 	return str.join("&");
// };

const getModalInput = function (fileName, postData) {
	return new Promise((resolve, reject) => {
		$.ajax({
			url: `${appUrl}/lookup/${fileName}?data=${postData}`,
			method: "GET",
			dataType: "html",
			success: function (response) {
				resolve(response);
			},
		});
	});
};

$.fn.modalInput = function (options) {
	let defaults = {
		title: null,
		fileName: null,
		beforeProcess: function () {},
		onShowLookup: function (rowData, element) {},
		onSelectRow: function (rowData, element) {},
		onCancel: function (element) {},
		onClear: function (element) {},
	};

	let settings = $.extend({}, defaults, options);

	this.each(function () {
		let element = $(this);

		element.data("hasLookup", true);
		element.hide()
		element.wrap('<div class="input-group"></div>').after(`
			
			<div class="input-app-data">
				<button class="btn btn-success lookup-toggler" type="button">
					<i class="far fa-window-maximize text-white text-easyui-dark" style="font-size: 12.25px"> ${settings.title}</i>
				</button>
			</div>
		`);

		element
			.siblings(".input-app-data")
			.find(".lookup-toggler")
			.click(async function () {
				activateLookup(element, element.val());
			});

		element.siblings(".button-clear").click(function () {
			handleOnClear(element);
		});

		element.on("input", function (event) {
			delay(function () {
				activateLookup(element, element.val());
			}, 500);
		});

		element.on("keydown", function (event) {
			if (event.keyCode === 115) {
				activateLookup(element, element.val());
			}
		});
	});

	async function activateLookup(element, searchValue = null) {
		settings.beforeProcess();
		settings.onShowLookup();

		

		let lookupModal = $(`
      <div class="modal modal-lookup" id="lookupModal" tabindex="-1" aria-labelledby="lookupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <form action="#" id="crudForm">
            <div class="modal-content">
              <div class="modal-header">
                <p class="modal-title" id="lookupModalLabel">${settings.title}</p>
                <button type="button" class="close close-button" data-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body" style="min-height: 680px;">
              </div>
              <div class="modal-footer">
                <div class="mr-auto">
                  <button type="button" class="btn btn-success savemodal-input"  aria-label="save">
                  Save
                  </button>
                  <button type="button" class="btn btn-secondary close-button" data-dismiss="modal" aria-label="Close">
                  Close
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
		console.log(searchValue);
		getModalInput(settings.fileName, searchValue ?? null).then((response) => {
			lookupModal.find(".modal-body").html('')
			lookupModal.find(".modal-body").html(response);
		
		});

		lookupModal.on("hidden.bs.modal", function () {
			lookupModal.html('');
			lookupModal.remove();
			element.focus();
			let isInModal = $(element).closest('.modal').length > 0; 
			if (isInModal) { 
				initDatepicker()
			}
		});

		$(document)
			.find(lookupModal)
			.find(".close-button")
			.on("click", function () {
				handleOnCancel(element);
			});

		$(document)
			.find(lookupModal)
			.on("keydown", function (event) {
				if (event.which === 27) {
					handleOnCancel(element);
				}
			});
		$(document)
			.find(lookupModal)
			.on("click", ".savemodal-input",function () {
				let data = $('#input-modal-form').serializeArray()
				console.log(data);
				handleSelectedRow(serializeToJson(data), lookupModal, element)
			});

	}

	function serializeToJson(data) {
		let jobEmklArray = [];
		let nominalArray = [];
		
		// Pisahkan berdasarkan nama "job_emkl[]" dan "nominal[]"
		data.forEach(item => {
			if (item.name === "job_emkl[]") {
				jobEmklArray.push(item.value);
			} else if (item.name === "nominal_job[]") {
				nominalArray.push(item.value);
			}
		});
		
		// Gabungkan kembali berdasarkan indeks yang sama
		let result = jobEmklArray.map((job, index) => {
			return {
				"job_emkl": job,
				"nominal": nominalArray[index]
			};
		});

		return result;
	}

	function handleSelectedRow(data, lookupModal, element) {
		if (id !== null) {
			lookupModal.modal("hide");
			//ambil nilai,submit
			settings.onSelectRow(data, element);
		} else {
			alert("Please select a row");
		}
	}

	function handleOnCancel(element) {
		settings.onCancel(element);
	}

	function handleOnClear(element) {
		settings.onClear(element);
	}

	

	return this;
};
