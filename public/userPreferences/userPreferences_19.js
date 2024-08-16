function createColModelUser() {
    return [
        {
            label: "",
            name: "",
            width: 30,
            align: "center",
            sortable: false,
            clear: false,
            stype: "input",
            searchable: false,
            searchoptions: {
                type: "checkbox",
                clearSearch: false,
                dataInit: function (element) {
                    $(element).removeClass("form-control");
                    $(element).parent().addClass("text-center");

                    $(element).on("click", function () {
                        $(element).attr("disabled", true);
                        if ($(this).is(":checked")) {
                            selectAllRows();
                        } else {
                            clearSelectedRows();
                        }
                    });
                },
            },
            formatter: (value, rowOptions, rowData) => {
                return `<input type="checkbox" name="Id[]" value="${rowData.id}" onchange="checkboxHandler(this)">`;
            },
        },
        {
            label: "ID",
            name: "id",
            align: "right",
            width: "70px",
            search: false,
            hidden: true,
        },
        {
            label: "GANDENGAN",
            name: "kodegandengan",
            align: "left",
            width: detectDeviceType() == "desktop" ? sm_dekstop_4 : sm_mobile_4,
        },
        {
            label: "KETERANGAN",
            name: "keterangan",
            align: "left",
            width: detectDeviceType() == "desktop" ? md_dekstop_2 : md_mobile_2,
        },
        {
            label: "NO POLISI",
            name: "trado",
            align: "left",
            width: detectDeviceType() == "desktop" ? sm_dekstop_2 : sm_mobile_1,
        },
        {
            label: "Container",
            name: "container",
            align: "left",
            width: detectDeviceType() == "desktop" ? sm_dekstop_2 : sm_mobile_1,
        },
        {
            label: "JLH BAN",
            name: "jumlahroda",
            width: detectDeviceType() == "desktop" ? sm_dekstop_2 : sm_mobile_1,
        },
        {
            label: "JLH BAN SERAP",
            name: "jumlahbanserap",
            width: detectDeviceType() == "desktop" ? sm_dekstop_2 : sm_mobile_1,
        },
        {
            label: "Status",
            name: "statusaktif",
            width: detectDeviceType() == "desktop" ? sm_dekstop_1 : sm_mobile_1,
            width: 100,
            stype: "select",
            searchoptions: {
                value: OptionSeacrhStatusAktif,
                dataInit: function (element) {
                    $(element).select2({
                        width: "resolve",
                        theme: "bootstrap4",
                    });
                },
            },
            formatter: (value, options, rowData) => {
                let statusAktif = JSON.parse(value);

                let formattedValue = $(`
<div class="badge" style="background-color: ${statusAktif.WARNA}; color: ${statusAktif.WARNATULISAN};">
  <span>${statusAktif.SINGKATAN}</span>
</div>
`);

                return formattedValue[0].outerHTML;
            },
            cellattr: (rowId, value, rowObject) => {
                let statusAktif = JSON.parse(rowObject.statusaktif);

                return ` title="${statusAktif.MEMO}"`;
            },
        },
        {
            label: "MODIFIED BY",
            name: "modifiedby",
            align: "left",
            width: detectDeviceType() == "desktop" ? sm_dekstop_3 : sm_mobile_3,
        },
        {
            label: "UPDATED AT",
            name: "updated_at",
            formatter: "date",
            formatoptions: {
                srcformat: "ISO8601Long",
                newformat: "d-m-Y H:i:s",
            },
            align: "right",
            width: detectDeviceType() == "desktop" ? sm_dekstop_4 : sm_mobile_4,
        },
        {
            label: "CREATED AT",
            name: "created_at",
            formatter: "date",
            formatoptions: {
                srcformat: "ISO8601Long",
                newformat: "d-m-Y H:i:s",
            },
            align: "right",
            width: detectDeviceType() == "desktop" ? sm_dekstop_4 : sm_mobile_4,
        },
    ];
}
