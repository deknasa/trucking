const serializeMaster = function (obj) {
    var str = [];
    for (var p in obj)
        if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
};

const getLookupMaster = function (fileName, postData, singlecolumn) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `${appUrl}/lookup/${fileName}?${serializeMaster(postData)}`,
            method: "GET",
            dataType: "html",
            success: function (response) {
                resolve(response);
            },
        });
    });
};

let activeLookupElement = null;
let aktifId = null;

$.fn.lookupMaster = function (options) {
    let defaults = {
        title: null,
        fileName: null,
        singlecolumn: null,
        detail: null,
        typeSearch: null,
        rowIndex: null,
        totalRow: null,
        postData: {},
        beforeProcess: function () {},
        onShowLookup: function (rowData, element) {},
        onSelectRow: function (rowData, element) {},
        onCancel: function (element) {},
        onClear: function (element) {},
    };

    let settings = $.extend({}, defaults, options);
    let sidebarIsOpen = false;

    this.each(function () {
        let element = $(this);
        let lookupContainer;

        element.data("hasLookup", true);

        element.wrap('<div class="input-group"></div>');

        let inputGroupAppend = $(
            '<div class="input-group-append"></div>'
        ).insertAfter(element);

        if (settings.onClear) {
            $(
                '<button type="button" class="btn position-absolute button-clear text-secondary" style="right: 34px; z-index: 99;"><i class="fa fa-times"></i></button>'
            )
                .appendTo(inputGroupAppend)
                .click(function () {
                    handleOnClear(element);
                });
        }

        $(
            `<button class="btn btn-easyui lookup-toggler" type="button"><i class="far fa-window-maximize text-easyui-dark" style="font-size: 12.25px"></i></button>`
        )
            .appendTo(inputGroupAppend)
            .click(async function () {
                event.preventDefault();

                let lookupContainer = element.siblings(
                    `#lookup-${element.attr("id")}`
                );

                if (activeLookupElement != null) {
                    if (aktifId != `#lookup-${element.attr("id")}`) {
                        $(aktifId).hide();

                        activate = false;
                    }
                }

                if (activeLookupElement) {
                    activeLookupElement.hide();

                    lookupContainer.remove();
                    element.data("hasLookup", false);

                    let detailElement = $(".overflow");

                    // detailElement.css("overflow", "auto");
                }

                activeLookupElement = lookupContainer;

                aktifId = `#lookup-${element.attr("id")}`;

                if (activate) {
                    $(aktifId).hide();
                    activate = false;

                    lookupContainer.remove();
                    element.data("hasLookup", false);

                    let detailElement = $(".overflow");

                    // detailElement.css("overflow", "auto");
                } else {
                    activateLookupMaster(element, element.val());
                    element.focus();
                    activate = true;
                    bindKey = false;
                }
            });

        activate = false;
        element.on("focus", function (event) {
            if (window.innerWidth < 768) {
                adjustScrollForMobile();
            }
        });

        element.on("input", function (event) {
            const searchValue = element.val();
            if (!activate) {
                delay(function () {
                    activateLookupMaster(element, searchValue);
                    activate = true;
                }, 50);
            } else {
                delay(function () {
                    handleOnInput(element, searchValue);
                }, 100);
                bindKey = false;
            }
        });

        element.focus(function () {
            const lookupContainer = element.siblings(
                `#lookup-${element.attr("id")}`
            );
            if (lookupContainer.is(":visible")) {
                lookupContainer.show();
            }
        });
    });

    async function activateLookupMaster(element, searchValue = null, singlecolumn) {
        settings.beforeProcess();
        settings.onShowLookup();

        const detail = settings.detail;
        const miniSize = settings.miniSize;

        idElement = $(element).attr("id");

        const box = $(`#${idElement}`)[0];

        const boxRect = box.getBoundingClientRect();

        const width = element[0].offsetWidth;


        let getId = element.attr("id");

        let detailElement = $(".overflow");

        let lookupContainer = element.siblings(`#lookup-${getId}`);

        let singleColumn = settings.singlecolumn;

        if (lookupContainer.length === 0) {
            if (miniSize) {
                let detailElement = $(".overflow");
                let modalBody = $(".modal-overflow");

                let prevOverflow = detailElement.css("overflow");

                // detailElement.css("overflow", "visible");

                if (detectDeviceType() == "desktop") {
                    lookupContainer = $(
                        '<div id="lookup-' +
                            getId +
                            '" style="position: absolute; box-shadow: 10px 10px 5px 12px lightblue; border:1px; background-color: #fff;  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 9999; top: 100%;  width: 400px; max-height: 150px;  overscroll-behavior: contain!important;"></div>'
                    ).insertAfter(element);
                } else if (detectDeviceType() == "mobile") {
                    lookupContainer = $(
                        '<div id="lookup-' +
                            getId +
                            '" style="position: absolute; background-color: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 9999; top: 100%;  width: 350px; max-height: 280px;   overflow: hidden;  overscroll-behavior: contain!important; "></div>'
                    ).insertAfter(element);
                }
            } else {
                if (detail) {
                    let detailElement = $(".overflow");

                    let modalBody = $(".modal-overflow");

                    let prevOverflow = detailElement.css("overflow");

                    detailElement.css("overflow", "visible");

                    console.log($(".lookup-bdiv"));

                    if (detectDeviceType() == "desktop") {
                        lookupContainer = $(
                            '<div id="lookup-' +
                                getId +
                                '" style="position: absolute; box-shadow: 10px 10px 5px 12px lightblue; border:1px; background-color: #fff;  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 9999; top: 100%;  width: 1000px; max-height: 300px;  overscroll-behavior: contain!important;"></div>'
                        ).insertAfter(element);
                    } else if (detectDeviceType() == "mobile") {
                        lookupContainer = $(
                            '<div id="lookup-' +
                                getId +
                                '" style="position: absolute; background-color: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 9999; top: 100%;  width: 350px; max-height: 280px;   overflow: hidden;  overscroll-behavior: contain!important; "></div>'
                        ).insertAfter(element);
                    }
                } else {
                    if (detectDeviceType() == "desktop") {
                        lookupContainer = $(
                            '<div id="lookup-' +
                                getId +
                                '" style="position: absolute; box-shadow: 10px 10px 5px 12px lightblue; border:1px; background-color: #fff;  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 9999; top: 100%;  width: ' +
                                width +
                                'px; max-height: 300px;  overscroll-behavior: contain!important;"></div>'
                        ).insertAfter(element);
                    } else if (detectDeviceType() == "mobile") {
                        lookupContainer = $(
                            '<div id="lookup-' +
                                getId +
                                '" style="position: absolute; background-color: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 9999; top: 100%; width: 350px; max-height: 280px;   overflow: hidden;  overscroll-behavior: contain!important;"></div>'
                        ).insertAfter(element);
                    }
                }
            }
        }

        lookupContainer.empty();

        let lookupBody = $('<div class="lookup-body"></div>').appendTo(
            lookupContainer
        );

        getLookupMaster(settings.fileName, settings.postData ?? null).then(
            (response) => {
                lookupBody.html(response);
                let grid = lookupBody.find(".lookup-grid");

                function preventScroll(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    return false;
                }

                // disable();
                let lookupLabel = settings.fileName;

                $(".ui-jqgrid-bdiv").addClass("bdiv-lookup");
                $(".jqgrid-rownum").addClass("rowNum-lookup");

                if (grid.length > 0) {
                    bindKey = false;
                    let el = $(this);
                    $(el).on("keydown", function (e) {
                        if (!bindKey) {
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

                                var gridIds = $(grid).getDataIDs();
                                var selectedRow =
                                    $(grid).getGridParam("selrow");

                                var currentPage = $(grid).getGridParam("page");
                                var lastPage = $(grid).getGridParam("lastpage");
                                var currentIndex = -1;

                                var triggerClick = false;

                                for (var i = 0; i < gridIds.length; i++) {
                                    if (gridIds[i] == selectedRow)
                                        currentIndex = i;
                                }

                                if (triggerClick == false) {
                                    if (33 === e.keyCode) {
                                        if (currentPage > 1) {
                                            $(grid)
                                                .jqGrid("setGridParam", {
                                                    page:
                                                        parseInt(currentPage) -
                                                        2,
                                                })
                                                .trigger("reloadGrid");

                                            triggerClick = true;
                                        }
                                        $(grid).triggerHandler("jqGridKeyUp"),
                                            e.preventDefault();

                                        return false;
                                    }
                                    if (34 === e.keyCode) {
                                        if (currentPage !== lastPage) {
                                            $(grid)
                                                .jqGrid("setGridParam", {
                                                    page:
                                                        parseInt(currentPage) -
                                                        1,
                                                })
                                                .trigger("reloadGrid");

                                            triggerClick = true;
                                        }
                                        $(grid).triggerHandler("jqGridKeyUp"),
                                            e.preventDefault();

                                        return false;
                                    }
                                    if (
                                        35 === e.keyCode &&
                                        !e.shiftKey &&
                                        !e.ctrlKey
                                    ) {
                                        var inputElement =
                                            document.activeElement;
                                        if (
                                            inputElement &&
                                            inputElement.tagName === "INPUT"
                                        ) {
                                            inputElement.setSelectionRange(
                                                inputElement.value.length,
                                                inputElement.value.length
                                            );
                                        }
                                        return false;
                                    }
                                    if (
                                        36 === e.keyCode &&
                                        !e.shiftKey &&
                                        !e.ctrlKey
                                    ) {
                                        var inputElement =
                                            document.activeElement;
                                        if (
                                            inputElement &&
                                            inputElement.tagName === "INPUT"
                                        ) {
                                            inputElement.setSelectionRange(
                                                0,
                                                0
                                            );
                                        }
                                        return false;
                                    }
                                    if (38 === e.keyCode) {
                                        if (currentIndex - 1 >= 0) {
                                            $(grid).setSelection(
                                                gridIds[currentIndex - 1]
                                            );
                                        }
                                        element.focus();
                                        return false;
                                    }
                                    if (40 === e.keyCode) {
                                        if (currentIndex + 1 < gridIds.length) {
                                            // $(grid).setSelection(gridIds[currentIndex]);
                                            $(grid).setSelection(
                                                gridIds[currentIndex + 1]
                                            );

                                            element.focus();
                                        }

                                        return false;
                                    }
                                    if (13 === e.keyCode) {
                                        let rowId =
                                            $(grid).getGridParam("selrow");
                                        let ondblClickRowHandler = $(
                                            grid
                                        ).jqGrid(
                                            "getGridParam",
                                            "ondblClickRow"
                                        );

                                        if (ondblClickRowHandler) {
                                            ondblClickRowHandler.call(
                                                $(grid)[0],
                                                rowId
                                            );
                                        }

                                        return false;
                                    }
                                }

                                $(".ui-jqgrid-bdiv").find("tbody").animate({
                                    scrollTop: 200,
                                });
                                $(".table-success").position().top > 300;
                            }
                            bindKey = true;
                        }
                    });
                }

                /* Determine user selection listener */
                if (detectDeviceType() == "desktop") {
                    grid.jqGrid("setGridParam", {
                        onCellSelect: function (id) {
                            handleSelectedRow(id, lookupContainer, element);
                            // element.focus();
                            activate = false;
                            bindKey = false;
                        },
                        onSelectRow: function (id) {
                            $(element).on("keydown", function (event) {
                                if (event.keyCode === 13) {
                                    handleSelectedRow(
                                        id,
                                        lookupContainer,
                                        element
                                    );
                                    activate = false;
                                    bindKey = false;

                                    return false;
                                }
                            });
                        },
                    });
                } else if (detectDeviceType() == "mobile") {
                    grid.jqGrid("setGridParam", {
                        onCellSelect: function (id) {
                            handleSelectedRow(id, lookupContainer, element);
                            element.focus();
                            activate = false;
                            bindKey = false;
                        },
                    });
                }
            }
        );

        lookupContainer.show();

        $(document).on("click.lookup", function (event) {
            if (!$(event.target).closest(".input-group").length) {
                lookupContainer.hide();

                lookupContainer.remove();
                element.data("hasLookup", false);

                // detailElement.css("overflow", "auto");

                activate = false;
            }
        });

        const modal = $(".modal-body");

        // document.addEventListener('DOMContentLoaded', function() {

        //     lastTdElements.forEach(td => {
        //       // Menambahkan event listener untuk setiap elemen <td>
        //       td.addEventListener('click', function() {
        //         // Memeriksa apakah elemen ini adalah elemen terakhir dalam tabel
        //         if (this === this.parentElement.lastElementChild) {
        //           // Jika ya, jalankan scrollIntoView()
        //           this.scrollIntoView();
        //         }
        //       });
        //     });
        //   });

        // document.addEventListener("focusin", function (event) {
           
        //     const focusedElement = event.target;
        //     if (focusedElement && focusedElement.closest('tr')) {
        //     const focusElement = focusedElement.closest('tr').parentElement.querySelectorAll('.table-lookup tbody tr:last-child')

        
            
        //     const rowIndexElement =  $(focusedElement.closest('tr')).attr("data-trindex")
         
        //     const lastElement = document.querySelectorAll('.table-lookup tbody tr:last-child');
        //     totalRowsElement = $(focusElement[0]).attr("data-trindex")
            
         
        //     const tableContaint = $(".scroll-container");
        //     if (tableContaint.length) {
        //         const lookupTop = lookupContainer.offset().top;
        //         const lookupBottom = lookupContainer.offset().top + lookupContainer.outerHeight();
        //         const tableContaintBottom = tableContaint.offset().top + tableContaint.height();
        //         const tableContaintTop = tableContaint.offset().top;
        //         if (totalRowsElement <= rowIndexElement) {
                   
        //             tableContaint.animate(
        //                 {
        //                     scrollTop: 3000,
        //                 },
        //                 300
        //             );
        //         }
        
        //     }
        // }
               

            
        // });

        const modalheader =  $(".modal-master");
        if (modalheader.length) {
            console.log('masuk')
            const lookupTop = lookupContainer.offset().top;

            const lookupBottom =
                lookupContainer.offset().top + lookupContainer.outerHeight();
            const modalBottom = modalheader.offset().top + modalheader.height();
            const modalTop = modalheader.offset().top;
           
            if (lookupTop >= 573.5) {
                
                const scrollDistance =
                    lookupTop + lookupContainer.height() - modalBottom + 50; // Jarak scroll yang diinginkan

                modalheader.animate(
                    {
                        scrollTop: modalBottom + scrollDistance + 50,
                    },
                    500
                );
            }
        }
        // const tableContaint = $(".scroll-container");
        //     if (tableContaint.length) {
        //         const lookupTop = lookupContainer.offset().top;

        //         const lookupBottom = lookupContainer.offset().top + lookupContainer.outerHeight();
        //         const tableContaintBottom = tableContaint.offset().top + tableContaint.height();
        //         const tableContaintTop = tableContaint.offset().top;

                
        //         if (settings.totalRow <= settings.rowIndex) {

        //             tableContaint.animate(
        //                 {
        //                     scrollTop: 5000,
        //                 },
        //                 300
        //             );
        //         }
        
        //     }


        const aktifElement = document.activeElement;
        const containtModal = document.querySelector(".scroll-container"); // Ganti dengan selektor sesuai struktur Anda

        if (aktifElement && "scrollIntoView" in aktifElement && containtModal) {
            aktifElement.scrollIntoView({
                behavior: "instant",
                block: "start",
                inline: "end",
            });
        }

        window.addEventListener("resize", () => {
            if (window.innerWidth < 768) {
                adjustScrollForMobile();
            }
        });

        $(element).on("keydown", function (event) {
            if (event.keyCode === 27) {
                lookupContainer.hide();

                let detailElement = $(".overflow");

                // detailElement.css("overflow", "auto");

                lookupContainer.remove();
                element.data("hasLookup", false);

                return false;
                activate = false;
            }
        });

        // Tambahkan kode berikut
        lookupContainer.on("hide", function () {
            if (lookupContainer === activeLookupElement) {
                activeLookupElement = null;
                // aktifId = null;
            }
        });
    }

    // Fungsi untuk mengatur scroll saat keyboard muncul
    function adjustScrollForMobile() {
        const activeElement = document.activeElement;
        const modalContent = document.querySelector(".overflow"); // Ganti dengan selektor sesuai struktur Anda

        if (
            activeElement &&
            "scrollIntoView" in activeElement &&
            modalContent
        ) {
            activeElement.scrollIntoView({
                behavior: "instant",
                block: "start",
                inline: "start",
            });
        }
    }

    function handleSelectedRow(id, lookupContainer, element) {
        if (id !== null) {
            let rowData = sanitize(
                lookupContainer.find(".lookup-grid").getRowData(id)
            );

            element.val(rowData.name);
            settings.onSelectRow(rowData, element);

            lookupContainer.hide();

            lookupContainer.remove();
            element.data("hasLookup", false);

            let detailElement = $(".overflow");

            // detailElement.css("overflow", "auto");
        }
    }

    function handleOnCancel(element) {
        settings.onCancel(element);
    }

    function handleOnClear(element) {
        settings.onClear(element);

        let lookupContainer = element.siblings(`#lookup-${element.attr("id")}`);
        let grid = lookupContainer.find(".lookup-grid");

        grid.jqGrid("setGridParam", {
            postData: {
                filters: [],
            },
        });

        grid.trigger("reloadGrid", [{ page: 1, current: true }]);
    }

    async function handleOnInput(element, searchValue = null, data) {
        let lookupContainer = element.siblings(`#lookup-${element.attr("id")}`);
        let grid = lookupContainer.find(".lookup-grid");

        if (searchValue) {
            /* Determine user selection listener */
            if (detectDeviceType() == "desktop") {
                timeout = 150;
            } else if (detectDeviceType() == "mobile") {
                timeout = 50;
            }

            if (settings.typeSearch === "ALL") {
                delay(function () {
                    var postData = grid.jqGrid("getGridParam", "postData"),
                        colModel = grid.jqGrid("getGridParam", "colModel"),
                        rules = [],
                        searchText = searchValue,
                        l = colModel.length,
                        i,
                        cm;

                    searching = postData.searching;

                    cm = colModel[searching];

                    if (
                        cm.search !== false &&
                        (cm.stype === undefined || cm.stype === "text")
                    ) {
                        // grid.jqGrid("setGridParam", {
                        //     field: cm.name,
                        //     op: "cn",
                        //     data: element.val().toUpperCase(),
                        // });
                        rules.push({
                            field: cm.name,
                            op: "cn",
                            data: searchValue.toUpperCase(),
                        });
                    }

                    for (i = 0; i < l; i++) {
                        cm = colModel[i];
                        if (
                            cm.search !== false &&
                            (cm.stype === undefined || cm.stype === "text")
                        ) {
                            grid.jqGrid("setGridParam", {
                                field: cm.name,
                                op: "cn",
                                data: searchValue.toUpperCase(),
                            });

                            // rules.push({
                            //     field: cm.name,
                            //     op: "cn",
                            //     data: searchValue.toUpperCase(),
                            // });
                        }
                    }
                    postData.filter_group = "OR";

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
                        // element.focus(),
                    ]);

                    // grid.setGridParam({page: 1}).trigger('reloadGrid');

                    return false;
                }, timeout);
            } else {
                delay(function () {
                    var postData = grid.jqGrid("getGridParam", "postData"),
                        colModel = grid.jqGrid("getGridParam", "colModel"),
                        rules = [],
                        searchText = searchValue,
                        l = colModel.length,
                        i,
                        cm;

                    searching = postData.searching;

                    cm = colModel[searching];

                    if (
                        cm.search !== false &&
                        (cm.stype === undefined || cm.stype === "text")
                    ) {
                        console.log("masuk sinii");
                        grid.jqGrid("setGridParam", {
                            field: cm.name,
                            op: "cn",
                            data: searchValue.toUpperCase(),
                        });

                        // rules.push({
                        //     field: cm.name,
                        //     op: "cn",
                        //     data: searchValue.toUpperCase(),
                        // });
                    }

                    postData.filter_group = "OR";

                    grid.jqGrid("setGridParam", {
                        search: true,
                    });

                    grid.trigger("reloadGrid", [
                        {
                            page: 1,
                            current: true,
                        },
                        // element.focus(),
                    ]);

                    // grid.setGridParam({page: 1}).trigger('reloadGrid');

                    return false;
                }, timeout);
            }
        } else {
            var postData = grid.jqGrid("getGridParam", "postData"),
                colModel = grid.jqGrid("getGridParam", "colModel"),
                l = colModel.length,
                i,
                cm;

            for (i = 0; i < l; i++) {
                cm = colModel[i];
                if (
                    cm.search !== false &&
                    (cm.stype === undefined || cm.stype === "text")
                ) {
                    postData.filters = JSON.stringify({
                        groupOp: "AND",
                        rules: [
                            {
                                field: cm.name,
                                op: "cn",
                                data: "",
                            },
                        ],
                    });
                }
            }

            grid.trigger("reloadGrid", [
                {
                    page: 1,
                    current: true,
                },
            ]);
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
