   

    <script>
        let elementReferenceLookup = null;
        let dataParsed 
        let filterPostData
        let urlRequestGrid
        let elementInput

        const serializeLookupV4 = function(obj) {
            var str = [];
            for (var p in obj)
                if (obj.hasOwnProperty(p)) {
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                }
            return str.join("&");
        };

        const getLookupV4 = function(
            fileName,
            postData,
            element,
            title,
            searching,
            singleColumn,
            labelColumn,
            filter,
            lookupName
        ) {
            let classString = element.attr("class");
            let classArray = classString.split(" ");
            let lookupClasses = classArray.filter((className) =>
                className.includes("-lookup")
            );

            postData.searchText = lookupClasses[0];
            postData.title = title;
            postData.searching = searching;
            postData.singleColumn = singleColumn;
            postData.labelColumn = labelColumn;
            postData.filterToolbar = filter;
            postData.lookupName = lookupName;
            return new Promise((resolve, reject) => { 
               resolve()
            });
        };

        let activeLookupElementV4 = null;
        let aktifIdV4 = null;
        let selectedIdV4;
        // let bottomSelected;
        // let topSelected;
        let indexRowSelectV4;
        let keydownIndexV4 = true;

        let isKeyDownV4 = false;
        let isLookupOpenV4 = true;
        let isSelectedRow = false;

        let offsetWindowV4;

        const lookupSettings = {};

        let previousLookupElementV4 = null; // Variabel untuk menyimpan lookup lama
        
        $.fn.lookupV4 = function(options) {
            let defaults = {
                title: null,
                fileName: null,
                singlecolumn: false,
                labelColumn: true,
                detail: null,
                typeSearch: null,
                rowIndex: null,
                totalRow: null,
                alignRightMobile: null,
                alignRight: null,
                searching: [],
                multiColumnSize: null,
                searchingSpesific: null,
                extendSize: null,
                disabledIsUsed: null,
                selectedRequired: null,
                filterToolbar: false,
                postData: {},
                endpoint: null,
                getValue: null,
                lookupName: null,
                beforeProcess: function() {},
                onShowLookup: function(rowData, element) {},
                onSelectRow: function(rowData, element) {},
                onCancel: function(element) {},
                onClear: function(element) {},
            };

            let settings = $.extend({}, defaults, options);
            let sidebarIsOpen = false;

            if (settings.lookupName) {
                lookupSettings[settings.lookupName] = settings;
            }

            this.each(function() {
                let element = $(this);
                let lookupContainer;
                let lookupTest
                elementReferenceLookup = element;

                element.data("hasLookup", true);

                element.wrap('<div class="input-group"></div>').after(`
        ${
            settings.onClear
                ? `<button type="button" class="btn position-absolute button-clear text-secondary" style="right: 34px; z-index: 99;"><i class="fa fa-times-circle" style="font-size: 15px; margin-top:2px; color:red"></i></button>`
                : ``
        }
        <div class="input-group-append">
				<button class="btn btn-easyui lookup-toggler" type="button">
					<i class="far fa-window-maximize text-easyui-dark" style="font-size: 12.25px"></i>
				</button>
			</div>
        `);

                element.siblings(".button-clear").click(function() {
                    handleOnClear(element);
                });

                element
                    .siblings(".input-group-append")
                    .find(".lookup-toggler")
                    .click(async function() {
                        event.preventDefault();
                        element.data("input", false);

                        let elementInput = $(this).closest('.input-group').find('input');

                        
                        let lookupContainer = element.siblings(
                            `#lookup-${element.attr("id")}`
                        );
                        
                        if (activeLookupElementV4 != null) {
                            if (aktifIdV4 != `#lookup-${element.attr("id")}`) {
                                bottomSelected = 10;
                                topSelected = 0;

                                $(aktifIdV4).hide();

                                activate = false;
                            }
                        }
                        if (activeLookupElementV4) {
                            
                            oldElement = $(activeLookupElementV4.prevObject[0])

                            let lookupName = oldElement.data('lookup-name');

                          
                            // Ambil konfigurasi `settings`, `searching`, dan `endpoint` secara dinamis
                            let settings = lookupSettings[lookupName];
                            let searching = settings ? settings.searching : [];
                            let endpoint = settings ? settings.endpoint : null;
                          
                            activeLookupElementV4.hide();
                            
                            lookupContainer.remove();
                            element.data("hasLookup", false)

                            getFirst(searching, $(aktifIdV4), oldElement,settings);
                            
                            // detailElement.css("overflow", "auto");
                        }

                        activeLookupElementV4 = lookupContainer;

                        aktifIdV4 = `#lookup-${element.attr("id")}`;

                        if (activate) {
                            $(aktifIdV4).hide();
                            
                            activate = false;

                            lookupContainer.remove();
                            element.data("hasLookup", false);

                            let detailElement = $(".overflow");

                            // $(".modal-overflow").css("overflow-y", "auto");
                        } else {
                           
                            
                            activateLookup(element, element.val());
                            element.focus();
                            activate = true;
                            bindKey = false;

                            // $(".modal-overflow").css("overflow-y", "hidden");
                        }

                        isLookupOpenV4 = true;
                    });

                activate = false;
                // element.on("focus", function (event) {

                // });

                element.on("input", function(event) {
                    let lookupContainer = element.siblings(
                        `#lookup-${element.attr("id")}`
                    );

                    element.data("input", true);

                    const searchValue = element.val();

                    if (activeLookupElementV4 != null) {
                       
                        if (aktifIdV4 != `#lookup-${element.attr("id")}`) {
                            $(aktifIdV4).hide();

                            activate = false;
                        }
                    }

                    activeLookupElementV4 = lookupContainer;

                    aktifIdV4 = `#lookup-${element.attr("id")}`;

                    if (!activate) {
                       
                        delay(function() {
                            activateLookup(element, searchValue);
                            activate = true;
                        }, 50);
                    } else {
                       
                        delay(function() {
                            handleOnInput(element, searchValue);
                        }, 100);
                        bindKey = false;
                    }

                    isLookupOpenV4 = true;
                });

                element.focus(function() {
                    const lookupContainer = element.siblings(
                        `#lookup-${element.attr("id")}`
                    );
                    if (lookupContainer.is(":visible")) {
                        lookupContainer.show();
                    }
                });

                element.on("blur",function(event){
                    if  (detectDeviceType() != "desktop") {
                        const lookupContainer = element.siblings(
                            `#lookup-${element.attr("id")}`
                        );
                        if (element.val() != '' && activate == false) {
                           
                            getFirst(settings.searching, lookupContainer, element);
                        }                        
                    }
                   
                })
              
               

            });

            function getFirst(fields, lookupContainer, element,settings = {},lookupUrl = null) {

               
                if (isSelectedRow) {
                    return ;
                }
                // isSelectedRow = true
                let rulesFirst = []
                dataval = element.val();

                fields.forEach((field) => {
                    rulesFirst.push({
                        field: field,
                        op: "cn",
                        data: dataval.toUpperCase(),
                    });
                });

                let postData = {
                    filters: JSON.stringify({
                            groupOp: "OR",
                            rules: rulesFirst,
                        })
                }

                filterPostData = {
                    ...filterPostData,
                    ...postData,
                }
                defaultUrl = urlRequestGrid

                if (lookupUrl) {
                    defaultUrl = lookupUrl
                }
               
                $.ajax({
                    url: `${defaultUrl}`,
                    method: 'GET',
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: filterPostData,
                    success: response => {
                        firstdata = response.data[0]
                        // handleSelectedRow(firstdata.id, lookupContainer, element, true, firstdata)
                        if (Object.keys(settings).length > 0) {
                            handleSelectedRow(firstdata.id, lookupContainer, element, true, firstdata, settings);
                           
                        } else {
                            handleSelectedRow(firstdata.id, lookupContainer, element, true, firstdata);
                            
                        }
                        isSelectedRow = false
                    },
                    error: error => {
                        console.log('err',error);
                        
                        if (error.status === 422) {
                            $('.is-invalid').removeClass('is-invalid')
                            $('.invalid-feedback').remove()

                            setErrorMessages(form, error.responseJSON.errors);
                        } else {
                            showDialog(error.responseJSON)
                        }
                    },
                }).always(() => {
                    $('#processingLoader').addClass('d-none')
                    $(this).removeAttr('disabled')
                })
            }

            async function activateLookup(element, searchValue = null, singlecolumn) {
                let bottomSelected = 11;
                let topSelected = 0;
                elementInput = $(element)
                // let indexRowSelectV4 = 1;
                isSelectedRow = false;

                offsetWindowV4 = window.pageYOffset;

                settings.beforeProcess();
                settings.onShowLookup();

             
                
                element.attr('data-lookup-name', settings.lookupName);
               
                $('.input-group').removeClass('active');
                element.addClass('active');

                const detail = settings.detail;
                const miniSize = settings.miniSize;
                const alignRightMobile = settings.alignRightMobile;
                const alignRight = settings.alignRight;

                idElement = $(element).attr("id");

                const box = $(`#${idElement}`)[0];

                const boxRect = box.getBoundingClientRect();

                const width = element[0].offsetWidth;

                let getId = element.attr("id");

                let lookupContainer = element.siblings(`#lookup-${getId}`);

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

                            if (alignRight) {
                                $(`#lookup-${getId}`).css("right", "0");
                            }
                        } else if (detectDeviceType() == "mobile") {
                            let ukuranDevice = window.innerWidth;
                            let widthValue = ukuranDevice < 400 ? 250 : 250;

                            lookupContainer = $(
                                `<div id="lookup-${getId}" style="position: absolute; background-color: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 9999; top: 100%; width: ${widthValue}px; max-height: 280px;  overscroll-behavior: contain!important;"></div>`
                            ).insertAfter(element);

                            if (alignRightMobile) {
                                $(`#lookup-${getId}`).css("right", "0");
                            }
                        }
                    } else {
                        if (detail) {
                            let detailElement = $(".overflow");

                            let modalBody = $(".modal-overflow");

                            let prevOverflow = detailElement.css("overflow");

                            detailElement.css("overflow", "visible");

                            if (detectDeviceType() == "desktop") {
                                lookupContainer = $(
                                    '<div id="lookup-' +
                                    getId +
                                    '" style="position: absolute; box-shadow: 10px 10px 5px 12px lightblue; border:1px; background-color: #fff;  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 9999; top: 100%;  width: 1000px; max-height: 300px;  overscroll-behavior: contain!important;"></div>'
                                ).insertAfter(element);

                                if (alignRight) {
                                    $(`#lookup-${getId}`).css("right", "0");
                                }
                            } else if (detectDeviceType() == "mobile") {
                                lookupContainer = $(
                                    '<div id="lookup-' +
                                    getId +
                                    '" style="position: absolute; background-color: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 9999; top: 100%;  width: 330px; max-height: 280px;   overscroll-behavior: contain!important; "></div>'
                                ).insertAfter(element);

                                if (alignRightMobile) {
                                    $(`#lookup-${getId}`).css("right", "0");
                                }
                            }
                        } else {

                            if (detectDeviceType() == "desktop") {
                                let multiColumnSize = settings.multiColumnSize;
                                let extend = settings.extendSize;
                                let sizeExtend = width + extend;

                                const commonStyles =
                                    "position: absolute; box-shadow: 10px 10px 5px 12px lightblue; border:1px; background-color: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 9999; top: 100%; max-height: 300px; overscroll-behavior: contain!important;";

                                if (multiColumnSize) {
                                    lookupContainer = $(
                                        `<div id="lookup-${getId}" style="${commonStyles} width: ${sizeExtend}px;"></div>`
                                    ).insertAfter(element);
                                } else {
                                    lookupContainer = $(
                                        `<div id="lookup-${getId}" style="${commonStyles} width: ${width}px;"></div>`
                                    ).insertAfter(element);
                                }

                                if (alignRight) {
                                    $(`#lookup-${getId}`).css("right", "0");
                                }
                            } else if (detectDeviceType() == "mobile") {
                               
                                lookupContainer = $(
                                    '<div id="lookup-' +
                                    getId +
                                    '" style="position: absolute; background-color: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 9999; top: 100%; width: 350px; max-height: 280px;  overscroll-behavior: contain!important;"></div>'
                                ).insertAfter(element);

                                if (alignRightMobile) {
                                    $(`#lookup-${getId}`).css("right", "0");
                                }
                            }
                        }
                    }
                }

                lookupContainer.empty();

                const {
                    fileName: flnm,
                    postData: pst,
                    title: title = "Default Title", // Default value for 'title'
                    searching: src = [], // Default value for 'searching' as an empty array
                    singleColumn: singleclm = false, // Default value for 'singleColumn' as false
                    labelColumn: hidelbl = false, // Default value for 'labelColumn' as false
                    filterToolbar: filter = false,
                    getValue: getValue = '',
                    lookupName: lookupName = ''
                } = settings;
                
                dataParsed =settings.postData
                
                let lookupBody = $(
                    `<div class="lookup-body"> </div>`
                    ).appendTo(
                    lookupContainer
                );

                

                getLookupV4(flnm, pst, element, title, src, singleclm, hidelbl, filter,lookupName).then(
                    (response) => {
                         
                            var myvar =   `<?php
                            $idLookup = isset($id) ? $id : null;
                            $name = '`+ flnm + `';
                            $filename = $name;
                            $lookupName = '`+ lookupName + `';
                            echo $filename;
                            echo $lookupName;
                            ?>`

                            lookupBody.html(`<div> @include('partials.lookups.lookupjs')  </div>`);
                       
                        let grid = lookupBody.find(".lookup-grid");

                        let lookupLabel = flnm;

                       $(".ui-jqgrid-bdiv").addClass("bdiv-lookup");
                       $(".jqgrid-rownum").addClass("rowNum-lookup");

                       if (grid.length > 0) {
                           bindKey = false;

                           let el = $(this);
                          keydownIndexV4++

                           $(element).on("keydown", function (e) {
                              keydownIndexV4 = true

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

                                       for (
                                           let index = 0;
                                           index < keydownIndexV4;
                                           index++
                                       ) {
                                           if (index == 0) {
                                           }
                                       }

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
                                           if (38 === e.keyCode && isLookupOpenV4) {
                                               $(grid).setSelection(
                                                   gridIds[currentIndex - 1]
                                               );
                                               element.focus();

                                               var selectedRowId =
                                                   $(grid).getGridParam("selrow");

                                               indexRowSelectV4 = $(grid).jqGrid(
                                                   "getInd",
                                                   selectedRowId
                                               );

                                               var currentRowHeight =
                                                   $(grid).getGridParam("rowHeight") ||
                                                   26;
                                               var visibleRows =
                                                   $(grid).getGridParam(
                                                       "recordsView"
                                                   ) || 1;

                                               var currentScrollTop = $(grid)
                                                   .closest(".ui-jqgrid-bdiv")
                                                   .scrollTop();

                                               if (indexRowSelectV4 == topSelected) {
                                                   bottomSelected--;
                                                   topSelected--;
                                                   $(grid)
                                                       .closest(".bdiv-lookup")
                                                       .scrollTop(
                                                           currentScrollTop -
                                                               visibleRows *
                                                                   currentRowHeight
                                                       );
                                               }

                                               return false;
                                           }

                                           if (40 === e.keyCode && isLookupOpenV4) {
                                              
                                               $(grid).setSelection(
                                                   gridIds[currentIndex + 1]
                                               );

                                               var currentRowHeight =
                                                   $(grid).getGridParam("rowHeight") ||
                                                   26;
                                               var visibleRows =
                                                   $(grid).getGridParam(
                                                       "recordsView"
                                                   ) || 1;

                                               var selectedRowId =
                                                   $(grid).getGridParam("selrow");
                                              var selectedRowId = $(grid).jqGrid("getGridParam").selectedIndex++;

                                               indexRowSelectV4 = $(grid).jqGrid(
                                                   "getInd",
                                                   selectedRowId
                                               );

                                              if (keydownIndexV4) {
                                                  indexRowSelectV4 = 1
                                              }

                                               var visibleSelRow = 0;

                                               element.focus();

                                               var currentScrollTop = $(grid)
                                                   .closest(".bdiv-lookup")
                                                   .scrollTop();

                                               if (
                                                   indexRowSelectV4 == bottomSelected
                                               ) {
                                                   visibleSelRow = 1;
                                                   bottomSelected++;
                                                   topSelected++;
                                               }

                                               if (visibleSelRow === 1) {
                                                   $(grid)
                                                       .closest(".bdiv-lookup")
                                                       .scrollTop(
                                                           currentScrollTop +
                                                               visibleRows *
                                                                   currentRowHeight
                                                       );
                                               }

                                               isLookupOpenV4 = true;

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
                                  element.focus();
                                   activate = false;
                                   bindKey = false;
                                   isSelectedRow = true;
                               },
                               onSelectRow: function (id) {
                                   selectedIdV4 = id;
                               },
                           });
                       } else if (detectDeviceType() == "mobile") {
                           grid.jqGrid("setGridParam", {
                               onCellSelect: function (id) {
                                   handleSelectedRow(id, lookupContainer, element);
                                   element.focus();
                                   activate = false;
                                   bindKey = false;
                                   isSelectedRow = true;
                               },
                           });
                       }

                       window.scrollTo(0, windowOffset);
                    }
                );

                $(element).on("keydown", function(event) {
                    if (event.keyCode === 13) {

                        if (selectedIdV4) {
                            handleSelectedRow(selectedIdV4, lookupContainer, element);
                        }
                        
                        activate = false;
                        // bindKey = false;
                        getFirst(settings.searching, lookupContainer, element);
                        return false;
                    }
                });

                lookupContainer.show();
                let activeElement = null;
                let isSwitchingFocus = false;
                if (!settings.selectedRequired) {
                    $(document).off("click.lookup");

                    $(document).on("click.lookup", function(event) {
                        // Cek apakah elemen yang sedang aktif adalah elemen yang diklik
                        const isActive = $(element).hasClass('active');

                        if (isActive) {
                            if (!activeElement || activeElement[0] !== element[0]) {
                                activeElement = element;
                            }

                            let lookupContainer = activeElement.siblings(
                                `#lookup-${activeElement.attr("id")}`
                            );

                            if (!$(event.target).closest(lookupContainer).length && !$(event.target).closest(".input-group").length) {
                                lookupContainer.hide();
                                lookupContainer.remove();
                                activeElement.data("hasLookup", false);
                                activeElement.data("currentValue", activeElement.val());

                                activate = false;
                                $(activeElement).removeClass('active');

                                if (activeElement.data("currentValue") != '' || activeElement.val() != '') {
                                    console.log("sembarang", activeElement);
                                    getFirst(settings.searching, lookupContainer, activeElement);
                                }

                                activeElement = null;
                            }
                        }
                    });
                    element.off("focusin");
                    element.on("focusin", function() {
                        console.log('focusin');
                        
                        if (activeElement && activeElement[0] !== this) {
                            let previousLookupContainer = activeElement.siblings(`#lookup-${activeElement.attr("id")}`);
                            previousLookupContainer.hide();
                            previousLookupContainer.remove();
                            activeElement.data("hasLookup", false);
                            activeElement.removeClass('active');
                        }
                        
                        activeElement = $(this);
                        $(this).addClass('active');
                        isSwitchingFocus = false; 
                        isSelectedRow = false
                    });

                    element.off("focusout");
                    // Event `focusout` untuk menangani saat elemen kehilangan fokus
                    element.on("focusout", function() {
                      
                        let currentElement = $(this);
                        let elementValue = currentElement.val(); // Simpan nilai untuk pengecekan nanti
                        let lookupContainer = currentElement.siblings(`#lookup-${currentElement.attr("id")}`);
                        
                     
                        isSwitchingFocus = true;

                        setTimeout(() => {
                            if (activeElement && activeElement[0] === currentElement[0] && isSwitchingFocus) {
                                lookupContainer.hide();
                                lookupContainer.remove();
                                activeElement.data("hasLookup", false);
                                activeElement.data("currentValue", elementValue);
                                activate = false;
                                activeElement.removeClass('active');
                                activeElement = null;

                                
                                let lookupName = currentElement.data('lookup-name');
                                let lookupUrl = currentElement.data('lookup-url');

                             
                                // Ambil konfigurasi `settings`, `searching`, dan `endpoint` secara dinamis
                                let settings = lookupSettings[lookupName];
                                let searching = settings ? settings.searching : [];
                                let endpoint = settings ? settings.endpoint : null;

                              
                                if (elementValue !== '') {
                                    getFirst(searching, lookupContainer, currentElement,settings,lookupUrl);
                            
                                }
                            }
                        }, 600);
                    });
                }

            
                const modal = $(".modal-body");
                const modalheader = $(".modal-master");

                $(element).on("keydown", function(event) {
                    if (event.keyCode === 27) {
                        lookupContainer.hide();

                        let detailElement = $(".overflow");

                        lookupContainer.remove();
                        element.data("hasLookup", false);

                        if (element.val() == '') {
                                 handleOnCancel(element);
                        }

                        activate = false;
                        return false;
                    }
                });

                // Tambahkan kode berikut
                lookupContainer.on("hide", function() {
                    if (lookupContainer === activeLookupElementV4) {
                        activeLookupElementV4 = null;
                    }
                });
                windowOffset = window.pageYOffset;
            }

            function handleSelectedRow(id, lookupContainer, element, statusDataFirst = false, dataFirst = {},settingsOld= {}) {
                isSelectedRow = true;
                if (id !== null) {
                    bottomSelected = 10;
                    topSelected = 1;

                    let rowData = sanitize(
                        lookupContainer.find(".lookup-grid").getRowData(id)
                    );

                    if (statusDataFirst) {
                        rowData = dataFirst;

                    }

                    const obj = rowData;
                    const array = Object.values(obj);

                    // element.val(rowData.name);
                    element.val(rowData.name);

                    if (array.length == 0) {
                        element.val(element.data("currentValue"));
                        lookupContainer.hide();
                        return rowData;
                    }
 
                    if (Object.keys(settingsOld).length > 0) {
                        settingsOld.onSelectRow(rowData, element);
                    }else{
                        settings.onSelectRow(rowData, element);
                    }
                   

                    lookupContainer.hide();

                    lookupContainer.remove();
                    element.data("hasLookup", false);

                    let detailElement = $(".overflow");
                    isLookupOpenV4 = false;

                }
            }

            function handleOnCancel(element) {
              
                settings.onCancel(element);
                activate=false
            }

            function handleOnClear(element) {
                activate=false
                let lookupContainer = element.siblings(`#lookup-${element.attr("id")}`);
                let grid = lookupContainer.find(".lookup-grid");

                let colMdl = grid.jqGrid("getGridParam", "colModel");

                settings.onClear(element);

                rules = [];
                colMdl.forEach(function(cm) {
                    $("#gs_" + cm.name).val("");
                });

                grid.jqGrid("setGridParam", {
                    postData: {
                        filters: "",
                    },
                });

                grid.trigger("reloadGrid", [{
                    page: 1,
                    current: true
                }]);
            }

            async function handleOnInput(element, searchValue = null, data) {
                let lookupContainer = element.siblings(`#lookup-${element.attr("id")}`);
                let grid = lookupContainer.find(".lookup-grid");
                abortGridLastRequest($(grid));
                if (searchValue) {
                    /* Determine user selection listener */
                    if (detectDeviceType() == "desktop") {
                        timeout = 200;
                    } else if (detectDeviceType() == "mobile") {
                        timeout = 50;
                    }

                  
                    input = element.data("input");

                    let colMdl = grid.jqGrid("getGridParam", "colModel");


                    rules = [];
                    colMdl.forEach(function(cm) {
                        $("#gs_" + cm.name).val("");
                    });
                    if (settings.searching.length == 0) {
                        delay(function() {
                            var postData = grid.jqGrid("getGridParam", "postData"),
                                colModel = grid.jqGrid("getGridParam", "colModel"),
                                rules = [],
                                searchText = searchValue,
                                l = colModel.length,
                                i,
                                cm;

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

                            grid.trigger("reloadGrid", [{
                                page: 1,
                                current: true,
                            }, ]);

                            return false;
                        }, timeout);
                    } else if (settings.searching.length > 0) {
                        delay(function() {
                            var postData = grid.jqGrid("getGridParam", "postData"),
                                colModel = grid.jqGrid("getGridParam", "colModel"),
                                rules = [],
                                searchText = searchValue,
                                l = colModel.length,
                                i,
                                j,
                                cm;

                            searching = settings.searching;

                            for (i = 0; i < l; i++) {
                                cm = colModel[i];

                                // Check if the column name is in the 'searching' array
                                if (searching.includes(cm.name)) {
                                    // Check for valid search options
                                    if (
                                        cm.search !== false &&
                                        (cm.stype === undefined || cm.stype === "text")
                                    ) {
                                        rules.push({
                                            field: cm.name,
                                            op: "cn", // Contains operation
                                            data: searchText.toUpperCase(),
                                        });
                                    }
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

                            grid.trigger("reloadGrid", [{
                                page: 1,
                                current: true,
                            }, ]);

                            return false;
                        }, timeout);
                    } else {
                        delay(function() {
                            var postData = grid.jqGrid("getGridParam", "postData"),
                                colModel = grid.jqGrid("getGridParam", "colModel"),
                                rules = [],
                                searchText = searchValue,
                                l = colModel.length,
                                i,
                                cm;

                            searching = settings.searching;

                            cm = colModel[searching];

                            if (
                                cm.search !== false &&
                                (cm.stype === undefined || cm.stype === "text")
                            ) {
                                grid.jqGrid("setGridParam", {
                                    field: cm.name,
                                    op: "cn",
                                    data: searchValue.toUpperCase(),
                                });
                            }

                            postData.filter_group = "OR";

                            grid.jqGrid("setGridParam", {
                                search: true,
                            });

                            grid.trigger("reloadGrid", [{
                                page: 1,
                                current: true,
                            }, ]);

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
                                rules: [{
                                    field: cm.name,
                                    op: "cn",
                                    data: "",
                                }, ],
                            });
                        }
                    }

                    grid.trigger("reloadGrid", [{
                        page: 1,
                        current: true,
                    }, ]);
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

        function getLookupSetting(lookupName, settingKey) {
          
            return lookupSettings[lookupName] ? lookupSettings[lookupName][settingKey] : null;
        }

        // Contoh cara mengubah settings secara dinamis dari luar:
        function updateLookupSetting(lookupName, settingKey, newValue) {
            if (lookupSettings[lookupName]) {
                lookupSettings[lookupName][settingKey] = newValue;
            }
        }
    </script>
