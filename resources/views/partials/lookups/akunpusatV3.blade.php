<?php
    if (isset($id)) { ?>
<table id="akunpusatLookup<?= $id ?>" class="lookup-grid"></table>
<?php
    } else { ?>
<table id="akunpusatLookup" class="lookup-grid"></table>
<?php } ?>
<div class="loadingMessage">
    <img class="loading-image" src="{{ asset('libraries/tas-lib/img/loading-lookup.gif') }}" alt="Loading">
    <p class="loading-text">Loading data...</p>

</div>

<?php
$idLookup = isset($id) ? $id : null;

?>
<script>
    var idLookup = '{{ $idLookup }}';
    var idTop

    selector = $(`#akunpusatLookup{{ isset($id) ? $id : null }} `)
    var isToolbarSearch = false;

    var singleColumn = `{{ $singleColumn ?? '' }}`
    var filterToolbar = `{{ $filterToolbar ?? '' }}`

    label = `{{ $labelColumn ?? '' }}`

    width = ''
    //  use this witdh if single column lookup
    if (detectDeviceType() == "desktop" && label === 'false') {
        width = '1500px'
    } else if (detectDeviceType() == "mobile") {
        width = '350px'

    }


    column = [
        {
            label: "ID",
            name: "id",
            width: "50px",
            hidden: true,
            sortable: false,
            search: false,
          },
          {
            label: 'AKUNTANSI',
            name: 'keterangancoa',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            align: 'left'
          },
          {
            label: 'KODE TIPE',
            name: 'coa',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            width: 255
          },
            
    ];




    selector.jqGrid({
        url: `{{ config('app.api_url') . 'akunpusat' }}`,        
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        postData: {
            levelCoa: `{!! $levelCoa ?? '' !!}`,
            potongan: `{!! $potongan ?? '' !!}`,
            aktif: `{!! $Aktif ?? '' !!}`,
            keterangancoa: `{!! $KeteranganCoa ?? '' !!}`,
            supplier: `{!! $Supplier ?? '' !!}`,
            isParent: `{!! $isParent ?? '' !!}`,
            // filters: `{!! $filters ?? '' !!}`
        },
        idPrefix: '',
        colModel: column,
        height: 350,
        fixed: true,
        rownumbers: false,
        rownumWidth: 0,
        rowNum: `{!! $limit ?? 20 !!}`,
        rowList: [10, 20, 50, 0],
        sortable: true,
        sortname: 'id',
        sortorder: 'asc',
        page: 1,
        toolbar: [true, "top"],
        viewrecords: true,
        prmNames: {
            sort: 'sortIndex',
            order: 'sortOrder',
            rows: 'limit'
        },
        jsonReader: {
            root: 'data',
            total: 'attributes.totalPages',
            records: 20,
        },
        autowidth: true,
        scrollOffset: 1,
        scrollrows: false,
        shrinkToFit: false,
        scrollLeftOffset: "25%",
        scroll: true,
        height: 350,
        page: 1,
        selectedIndex: 0,
        triggerClick: false,
        search: true,
        serializeGridData: function(postData) {
            searching = `{{ $searching }}`
            searchText = `.{{ $searchText }} `

            console.log(searchText);
            


            var colModel = $(this).jqGrid("getGridParam", "colModel"),
                rules = [],
                searchValue = $(searchText).val(),
                i,
                cm;
            l = colModel.length


           

            if (searching != '') {
                searching = searching.split(',');
            }


            aksi = `{!! $aksi ?? '' !!}`


            postData.sort_indexes = [postData.sort_index];
            postData.sort_orders = [postData.sort_order];


            input = $(searchText).data('input')

            if (isToolbarSearch) {
                colModel.forEach(function(cm) {
                    var searchField = $("#gs_" + cm.name).val();

                    if (searchField && cm.search !== false && (cm.stype === undefined || cm
                            .stype === "text")) {
                        isToolbarSearch = true;
                        rules.push({
                            field: cm.name,
                            op: "cn", // Contains operation
                            data: searchField.toUpperCase()
                        });
                    }
                });

                // Logic for toolbar search with AND
                postData.filters = JSON.stringify({
                    "groupOp": "AND",
                    "rules": rules
                });
                postData.filter_group = "AND";

            } else {
                if (input) {
                    if (searching.length == 0) {
                        for (i = 0; i < l; i++) {
                            cm = colModel[i];

                            if (cm.search !== false && (cm.stype === undefined || cm.stype === "text")) {
                                rules.push({
                                    field: cm.name,
                                    op: "cn",
                                    data: searchValue.toUpperCase(),
                                });
                            }
                        }

                        postData.filters = JSON.stringify({
                            groupOp: "OR",
                            rules: rules,
                        });

                        postData.searching = searching;
                        postData.searchText = searchText;
                    } else if (searching.length > 1) {
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
                                        data: searchValue.toUpperCase(),
                                    });
                                }
                            }
                        }
                        postData.filter_group = "OR";

                        postData.filters = JSON.stringify({
                            groupOp: "OR",
                            rules: rules,
                        });

                        postData.searching = searching;
                        postData.searchText = searchText;
                    }
                }
            }

            return postData;
        },
        loadBeforeSend: function(jqXHR) {
            $('.loadingMessage').show();
            idTop = selector.attr('id')


            $(`#load_${idTop}`).remove()

            if (detectDeviceType() == 'mobile') {

                $('.lookup-grid tr:not(.jqgfirstrow) td').css('padding', '12px')
                $('.lookup-grid tr:not(.jqgfirstrow) td').css('font-size', '1rem')

                $(`#gview_${idTop} .ui-th-column `).css('font-size', '1rem')

                var title = `{{ $title ?? '' }}`
                var label = $("<label>").attr("for", "searchText")
                    .css({
                        "font-weight": "normal",
                        "padding-left": "10px",
                        "padding-top": "5px"
                    })
                    .text(title);

                $(`#gbox_${idTop}`).find('.ui-userdata-top').css({
                    "height": "1px",

                })

            } else {
                var title = `{{ $title ?? '' }}`
                var label = $("<label>").attr("for", "searchText")
                    .css({
                        "font-weight": "normal",
                        "padding-left": "10px",
                        "padding-top": "1px"
                    })
                    .text(title);

                $(`#gbox_${idTop}`).find('.ui-jqgrid').css({
                    "min-height": "24px!important"
                })

                $(`#gbox_${idTop}`).find('.ui-userdata-top').css({
                    "height": "1px",
                    "min-height": "25px"
                })

            }

            // Mengecek apakah label belum ada sebelumnya
            if ($(`#t_${idTop} label[for='searchText']`).length === 0) {
                $(`#t_${idTop}`).append(label);
            }


            var labelColumn = `{{ $labelColumn ?? '' }}`

            if (labelColumn == 'false') {
                $(`#gbox_${idTop}`).find('.ui-jqgrid-hdiv').hide()
            }


            $('.ui-scroll-popup').addClass('d-none')
            $('.modal-loader-content').addClass('d-none')



            jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
            setGridLastRequest($(this), jqXHR)

        },
        onSelectRow: function(id) {
            activeGrid = this;

            let limit = $(this).jqGrid("getGridParam", "postData").limit;
            let page = $(this).jqGrid("getGridParam", "page");
            let selectedIndex = $(this).jqGrid("getCell", id, "rn") - 1;

            if (selectedIndex >= limit)
                selectedIndex = selectedIndex - limit * (page - 1);

            $(this).jqGrid("setGridParam", {
                selectedIndex,
            });
        },
        loadComplete: function(data) {

            $('.loadingMessage').hide();
            idTop = selector.attr('id')

            var colModel = selector.jqGrid('getGridParam', 'colModel');
            var firstColumnName = colModel[1].name;


            if (detectDeviceType() == 'mobile') {
                $('.lookup-grid tr:not(.jqgfirstrow) td').css('padding', '12px')
                $('.lookup-grid tr:not(.jqgfirstrow) td').css('font-size', '1rem')
                $(`#gview_${idTop} .ui-th-column `).css('font-size', '1rem')

            }

            let modal = $('#crudModal')
            let form = modal.find('form')

            changeJqGridRowListText();

            if (data.data.length === 0) {

                $('#parameterGrid').each((index, element) => {
                    abortGridLastRequest($(element))
                    clearGridHeader($(element))
                })
            } else {
                $(form).find('.is-invalid').removeClass('is-invalid');
                $(form).find('.invalid-feedback').remove();
            }

            if (detectDeviceType() == 'desktop') {
                console.log('desktop');

                // $(document).unbind('keydown')
               
                initResize($(this))


                let selectedIndex = $(this).jqGrid("getGridParam").selectedIndex;
             
                if (selectedIndex > $(this).getDataIDs().length - 1) {
                    selectedIndex = $(this).getDataIDs().length - 1;
                }

                if ($(this).jqGrid("getGridParam").triggerClick) {

                    $(this)
                        .find(`tr[id="${$(this).getDataIDs()[selectedIndex]}"]`)
                        .click();

                    $(this).jqGrid("setGridParam", {
                        triggerClick: false,
                    });
                    
                } 
            }

            $('.clearsearchclass').click(function() {
                clearColumnSearch($(this))
            })

            $(this).setGridWidth($('#lookupCabang').prev().width())
            setHighlight($(this))
            // $(this).jqGrid('setSelection', 1);

        

        },

    })

    if (filterToolbar == 'true') {
        if (detectDeviceType() == 'mobile') {
            $('.loadingMessage').css('top', '125%')
            $('.loading-text').css('margin-top', '13px')
        }
        selector.jqGrid('filterToolbar', {
            stringResult: true,
            searchOnEnter: false,
            defaultSearch: 'cn',
            groupOp: 'AND',
            beforeSearch: function() {
                isToolbarSearch = true;

                var postData = $(this).jqGrid("getGridParam", "postData");
                postData.filters = "";
                $(this).jqGrid("setGridParam", {
                    search: false
                });

                $(searchText).val('');
            },
            afterSearch: function() {
                isToolbarSearch = false;

            }
        });
    }
</script>

</html>