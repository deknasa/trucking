@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <table id="jqGrid"></table>
        </div>
    </div>
</div>

</div>
</div>

@include('penjual._modal')

@push('scripts')
<script>
    let indexRow = 0
    let page = 1
    let pager = '#pager'
    let id = ''
    let triggerClick = true;
    let highlightSearch
    let totalRecord;
    let limit;
    let postData;
    let sortname = 'namapenjual'
    let sortorder = 'asc'
    let autoNumericElements = []
    let rowNum = 10

    
    $(document).ready(function() {
        $("#jqGrid").jqGrid({
            url: `${apiUrl}penjual`,
            mtype: 'GET',
            styleUI: 'Bootstrap4',
            iconSet: 'fontAwesome',
            datatype: 'json',
            colModel: [
                { 
                    label: 'Id', 
                    name: 'id', 
                    align: 'right',
                    width: '50px',
                    search: false, 
                    hidden: true
                },
                { 
                    label: 'Nama Penjual', 
                    name: 'namapenjual',  
                    width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1 
                },
                { 
                    label: 'Alamat', 
                    name: 'alamat', 
                    width: (detectDeviceType() == "desktop") ? md_dekstop_3 : md_mobile_3
                },
                { 
                    label: 'No. Hp', 
                    name: 'nohp', 
                    width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
                },
                { 
                    label: 'Keterangan Coa', 
                    name: 'coa', 
                    width: (detectDeviceType() == "desktop") ? md_dekstop_4 : md_mobile_3
                },
                { 
                    label: 'Status Aktif', 
                    name: 'statusaktif', 
                    width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    stype: 'select',
                    searchoptions: {
                        value: `<?php
                            $i = 1;
                            foreach ($data['comboaktif'] as $status) :
                                echo "$status[param]:$status[parameter]";
                                if ($i !== count($data['comboaktif'])) {
                                    echo ';';
                                }
                                $i++;
                            endforeach;
                            ?>`,
                        dataInit: function(element) {
                            $(element).select2({
                                width: 'resolve',
                                theme: "bootstrap4"
                            })
                        }
                    },
                    formatter: (value, options, rowData) => {
                        let statusAktif = JSON.parse(value)
                        
                        let formattedValue = $(`
                            <div class="badge" style="background-color: ${statusAktif.WARNA}; color: ${statusAktif.WARNATULISAN};">
                            <span>${statusAktif.SINGKATAN}</span>
                            </div>
                        `)
                        return formattedValue[0].outerHTML
                    },
                    cellattr: (rowId, value, rowObject) => {
                        // console.log(rowId, value, rowObject);
                        
                        let statusAktif = JSON.parse(rowObject.statusaktif)
                        // console.log(statusAktif.MEMO);
                        
                        return ` title="${statusAktif.MEMO}"`
                    }
                },
                { 
                    label: 'Modified By', 
                    name: 'modifiedby', 
                    width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3
                },
                { 
                    label: 'Created At', 
                    name: 'created_at', 
                    width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                    align: 'right',
                    formatter: "date",
                    formatoptions: {
                        srcformat: "ISO8601Long",
                        newformat: "d-m-Y H:i:s"
                    }
                }, 
                {
                    label: 'Updated At',
                    name: 'updated_at',
                    width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                    align: 'right',
                    formatter: "date",
                    formatoptions: {
                        srcformat: "ISO8601Long",
                        newformat: "d-m-Y H:i:s"
                    }
                }
            ],
            autoWidth: true,
            shrinkToFit: false,
            height: 350,
            rowNum: rowNum,
            rownumbers: true,
            rownumWidth: 45,
            rowList: [10, 20, 50, 0],
            toolbar: [true, 'top'],
            sortable: true,
            sortname: sortname,
            sortorder: sortorder,
            page: page,
            viewrecords: true,
            prmNames: {
                sort: 'sortIndex',
                order: 'sortOrder',
                rows: 'limit'
            },
            jsonReader: {
                root: 'data',
                total: 'attributes.totalPages',
                records: 'attributes.totalRows',
            },
            loadBeforeSend: function(jqXHR){
                jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

                setGridLastRequest($(this), jqXHR)
            },
            onSelectRow: function(id){
                activeGrid = $(this)

                indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
                page = $(this).jqGrid('getGridParam', 'page')
                let limit = $(this).jqGrid('getGridParam', 'postData').limit
                if (indexRow >= limit) {
                    indexRow = (indexRow - limit * (page - 1))
                }
            },
            loadComplete: function(data){
                
                // changeJqGridRowListText()

                if (data.data.length === 0) {
                    $('#jqGrid').each((index, element) => {
                        abortGridLastRequest($(element))
                        clearGridHeader($(element))
                    })
                }
                
                $(document).unbind('keydown')
                setCustomBindKeys($(this))
                initResize($(this))

                sortname = $(this).jqGrid("getGridParam", "sortname")
                sortorder = $(this).jqGrid("getGridParam", "sortorder")
                totalRecord = $(this).getGridParam("records")
                limit = $(this).jqGrid('getGridParam', 'postData').limit
                postData = $(this).jqGrid('getGridParam', 'postData')
                triggerClick = true

                $('.clearsearchclass').click(function() {
                    clearColumnSearch($(this)) 
                })

                if (indexRow > $(this).getDataIDs().length - 1) {
                    indexRow = $(this).getDataIDs().length - 1;
                }

                if (triggerClick) {
                    if (id != '') {
                        indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
                        $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
                        id = ''
                    } else if (indexRow != undefined) {
                        $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
                    }

                    if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
                        $(`#jqGrid [id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
                    }

                    triggerClick = false
                } else {
                    $('#jqGrid').setSelection($('#jqGrid').getDataIDs()[indexRow])
                }

                $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
                setHighlight($(this))
            }
        })
        .jqGrid('setLabel', 'rn', 'No.')
        .jqGrid('filterToolbar', {
            stringResult: true,
            searchOnEnter: false,
            defaultSearch: 'cn',
            groupOp: 'AND',
            disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
            beforeSearch: function() {
                abortGridLastRequest($(this))

                $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
                clearGlobalSearch($('#jqGrid'))
            },
        })

        .customPager({
            buttons: [
                {
                    id: 'add',
                    innerHTML: '<i class="fa fa-plus"></i> ADD',
                    class: 'btn add btn-primary btn-sm mr-1',
                    onClick: () => {
                        createPenjual()
                    }
                },
                {
                    id: 'edit',
                    innerHTML: '<i class="fa fa-pen"></i> EDIT',
                    class: 'btn btn-success btn-sm mr-1',
                    onClick: () => {
                        selectedId = $('#jqGrid').jqGrid('getGridParam', 'selrow')
                        console.log(selectedId);
                        
                        if (selectedId == null || selectedId == "" || selectedId == undefined) {
                            showDialog('Harap pilih baris yang ingin di edit!')
                        } else {
                            editPenjual(selectedId)
                        }
                    } 
                },
                {
                    id: 'delete',
                    innerHTML: '<i class="fa fa-trash"></i> DELETE',
                    class: 'btn delete btn-danger btn-sm mr-1',
                    onClick: () => {
                        selectedId = $('#jqGrid').jqGrid('getGridParam', 'selrow')
                        if (selectedId == null || selectedId == "" || selectedId == undefined) {
                            showDialog('Harap pilih baris yang ingin di edit!')
                        } else {
                            deletePenjual(selectedId)
                        }
                    }
                },
                {
                    id: 'report',
                    innerHTML: '<i class="fa fa-print"></i> REPORT',
                    class: 'btn btn-info btn-sm mr-1',
                    onClick: () => {
                        $('#rangeModal').data('action', 'report')
                        $('#rangeModal').find('button:submit').html(`Report`)
                        $('#rangeModal').modal('show')
                    }
                },
                {
                    id: 'export',
                    innerHTML: '<i class="fa fa-file-export"></i> EXPORT',
                    class: 'btn btn-warning btn-sm mr-1',
                    onClick: () => {
                        $('#rangeModal').data('action', 'export')
                        $('#rangeModal').find('button:submit').html(`Export`)
                        $('#rangeModal').modal('show')
                    }
                },
            ]
        })

        loadClearFilter($('#jqGrid'))

        loadGlobalSearch($('#jqGrid'))

        // $('#add .ui-pg-div')
        // .addClass(`btn-sm btn-primary`)
        // .parent().addClass('px-1')

        // $('#edit .ui-pg-div')
        // .addClass('btn-sm btn-success')
        // .parent().addClass('px-1')

        // $('#delete .ui-pg-div')
        // .addClass('btn-sm btn-danger')
        // .parent().addClass('px-1')

        $('#rangeModal').on('shown.bs.modal', function() {
            if (autoNumericElements.length > 0) {
                $.each(autoNumericElements, (index, autoNumericElement) => {
                autoNumericElement.remove()
                })
            }

            $('#formRange [name]:not(:hidden)').first().focus()

            $('#formRange [name=sidx]').val($('#jqGrid').jqGrid('getGridParam').postData.sidx)
            $('#formRange [name=sord]').val($('#jqGrid').jqGrid('getGridParam').postData.sord)
            if (page == 0) {
                $('#formRange [name=dari]').val(page)
                $('#formRange [name=sampai]').val(totalRecord)
            } else {
                $('#formRange [name=dari]').val((indexRow + 1) + (limit * (page - 1)))
                $('#formRange [name=sampai]').val(totalRecord)
            }

            autoNumericElements = new AutoNumeric.multiple('#formRange .autonumeric-report', {
                digitGroupSeparator: ',',
                decimalCharacter: '.',
                decimalPlaces: 0,
                allowDecimalPadding: false,
                minimumValue: 1,
                maximumValue: totalRecord,
            })
        })

        $('#rangeModal').on('hidden.bs.modal', function() {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
        })

        $('#formRange').submit(function(event) {
            event.preventDefault()

            let params
            let submitButton = $(this).find('button:submit')

            submitButton.attr('disabled', 'disabled')
            $('#processingLoader').removeClass('d-none')

            /* Set params value */
            for (var key in postData) {
                // console.log(key);
                // console.log(postData[key]);
                
                if (params != "") {
                    params += "&";
                }
                params += key + "=" + encodeURIComponent(postData[key]);
            }
            // console.log(params);
            

            let formRange = $('#formRange')
            let offset = parseInt(formRange.find('[name=dari]').val()) - 1
            let limit = parseInt(formRange.find('[name=sampai]').val().replace('.', '')) - offset
            params += `&offset=${offset}&limit=${limit}`


            getCekExport(params).then((response) => {
                console.log(response);
                
                if ($('#rangeModal').data('action') == 'export') {
                    $.ajax({
                        url: `${apiUrl}penjual/export?${params}`,
                        type: 'GET',
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization', `Bearer ${accessToken}`);
                        },
                        xhrFields: {
                            responseType: 'arraybuffer'
                        },
                        success: function(response, status, xhr) {
                            if (xhr.status === 200) {
                                if (response !== undefined) {
                                    var blob = new Blob([response], {
                                        type: 'supplier/vnd.ms-excel'
                                    });
                                    var link = document.createElement('a');
                                    link.href = window.URL.createObjectURL(blob);
                                    link.download = 'penjual' + new Date().getTime() + '.xlsx';
                                    link.click();
                                }
                                $('#rangeModal').modal('hide')
                            }
                        },
                        error: function(xhr, status, error) {
                            $('#processingLoader').addClass('d-none')
                            submitButton.prop('disabled', false)
                        }
                    }).always(() => {
                        $('#processingLoader').addClass('d-none')
                        submitButton.prop('disabled', false)
                    })
                } else if ($('#rangeModal').data('action') == 'report') {
                    // console.log($('#rangeModal').data('action'))
                    
                    window.open(`{{ route('penjual.report') }}?${params}`)
                    submitButton.prop('disabled', false)
                    $('#processingLoader').addClass('d-none')
                    $('#rangeModal').modal('hide')
                }

            })
            .catch((error) => {
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()
                    errors = error.responseJSON.errors

                    $.each(errors, (index, error) => {
                        let indexes = index.split(".");
                        indexes[0] = 'sampai'
                        let element;
                        element = $('#rangeModal').find(`[name="${indexes[0]}"]`)[0];

                        $(element).addClass("is-invalid");
                        $(`<div class="invalid-feedback">
                            ${error[0].toLowerCase()}
                        </div>`).appendTo($(element).parent());
                    });

                    $(".is-invalid").first().focus();
                    $('#processingLoader').addClass('d-none')
                } else {
                    showDialog(error.statusText)
                }
            })
            .finally(() => {
                $('.ui-button').click()

                submitButton.removeAttr('disabled')
            })
        })

        function getCekExport(params) {
            params += `&cekExport=true`

            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `${apiUrl}penjual/export?${params}`,
                    dataType: "JSON",
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    success: (response) => {
                        resolve(response)
                    },
                    error: error => {
                        reject(error)
                    },
                });
            });
        }



    })
</script>

@endpush()
@endsection