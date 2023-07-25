@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <table id="jqGrid"></table>
        </div>
    </div>
</div>



@push('scripts')
<script>
    let page = 0;
    let pager = '#jqGridPager'
    let popup = "";
    let id = "";
    let triggerClick = true;
    let highlightSearch;
    let totalRecord
    let limit
    let postData
    let sortname = 'jobtrucking'
    let sortorder = 'asc'
    let autoNumericElements = []
    let indexRow = 0;

    $(document).ready(function() {
        $("#jqGrid").jqGrid({
                url: `${apiUrl}chargegandengan`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                postData: {
                    proses:'reload',
                },
                datatype: "json",
                colModel: [
                    {
                        label:'jobtrucking',
                        name:'jobtrucking',
                        align:'left',
                    },
                    {
                        label:'gandengan',
                        name:'gandengan',
                        align:'left',
                    },
                    {
                        label:'tglawal',
                        name:'tglawal',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label:'tglkembali',
                        name:'tglkembali',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label:'jumlahhari',
                        name:'jumlahhari',
                        align:'left',
                    },
                    {
                        label:'jenisorder',
                        name:'jenisorder',
                        align:'left',
                    },
                    {
                        label:'namaemkl',
                        name:'namaemkl',
                        align:'left',
                    },
                    {
                        label:'ukurancontainer',
                        name:'ukurancontainer',
                        align:'left',
                    },
                    {
                        label:'nojob',
                        name:'nojob',
                        align:'left',
                    },
                    {
                        label:'nojob2',
                        name:'nojob2',
                        align:'left',
                    },
                    {
                        label:'nocont',
                        name:'nocont',
                        align:'left',
                    },
                    {
                        label:'nocont2',
                        name:'nocont2',
                        align:'left',
                    },
                    {
                        label:'trado',
                        name:'trado',
                        align:'left',
                    },
                    {
                        label:'supir',
                        name:'supir',
                        align:'left',
                    },
                    {
                        label:'namagudang',
                        name:'namagudang',
                        align:'left',
                    },
                    {
                        label:'noinvoice',
                        name:'noinvoice',
                        align:'left',
                    },
                   
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 350,
                rowNum: 10,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                toolbar: [true, "top"],
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
                loadBeforeSend: function(jqXHR) {
                    $(this).setGridParam({
                        postData: {
                            proses: "page"
                        }
                    })
                        jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
                    
                    setGridLastRequest($(this), jqXHR)
                },
                onSelectRow: function(id) {
                    activeGrid = $(this)
                    id = $(this).jqGrid('getCell', id, 'rn') - 1
                    indexRow = id
                    page = $(this).jqGrid('getGridParam', 'page')
                    let limit = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
                },
                loadComplete: function(data) {
                    changeJqGridRowListText()

                    if (data.data.length === 0) {
                        $('#jqGrid').each((index, element) => {
                            abortGridLastRequest($(element))
                            clearGridHeader($(element))
                        })
                    }
                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    /* Set global variables */
                    sortname = $(this).jqGrid("getGridParam", "sortname")
                    sortorder = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecord = $(this).getGridParam("records")
                    limit = $(this).jqGrid('getGridParam', 'postData').limit
                    postData = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = true

                    $('.clearsearchclass').click(function() {
                        highlightSearch = ''
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

                    $('#left-nav').find('button').attr('disabled', false)
                    permission()
                    setHighlight($(this))
                }
            })

            .jqGrid("setLabel", "rn", "No.")
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
                    // {
                    //     id: 'reload',
                    //     innerHTML: '<i class="fas fa-sync-alt"></i> RELOAD',
                    //     class: 'btn btn-dark btn-sm mr-1',
                    //     onClick: () => {
                    //         jQuery('#jqGrid').jqGrid('clearGridData');
                    //         jQuery('#jqGrid').trigger('reloadGrid');
                    //     }
                    // },
                    {
                        id: 'export',
                        innerHTML: '<i class="fa fa-file-export"></i> EXPORT',
                        class: 'btn btn-warning btn-sm mr-1',
                        onClick: () => {
                            getExport()
                        }
                    },
                ]
            })

        /* Append clear filter button */
        loadClearFilter($('#jqGrid'))

        /* Append global search */
        loadGlobalSearch($('#jqGrid'))


        $('#add .ui-pg-div')
            .addClass(`btn-sm btn-primary`)
            .parent().addClass('px-1')

        $('#edit .ui-pg-div')
            .addClass('btn-sm btn-success')
            .parent().addClass('px-1')

        $('#delete .ui-pg-div')
            .addClass('btn-sm btn-danger')
            .parent().addClass('px-1')


        $('#export .ui-pg-div')
            .addClass('btn-sm btn-warning')
            .parent().addClass('px-1')

        $('#rangeTglModal').on('shown.bs.modal', function() {
            initDatepicker()
            $('#formRangeTgl').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
            $('#formRangeTgl').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        })

        $('#formRangeTgl').submit(event => {
            event.preventDefault()
            let params
            let actionUrl = ``
            let submitButton = $(this).find('button:submit')
            
            /* Clear validation messages */
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
      
            /* Set params value */
            for (var key in postData) {
              if (params != "") {
                params += "&";
              }
              params += key + "=" + encodeURIComponent(postData[key]);
            }
            
            // window.open(`${actionUrl}?${$('#formRange').serialize()}&${params}`)
            
            let formRange = $('#formRangeTgl')
            let dari = formRange.find('[name=dari]').val()
            let sampai = formRange.find('[name=sampai]').val()
            params += `&dari=${dari}&sampai=${sampai}`
      
            getCekExport(params)
            .then((response) => {
              if ($('#formRangeTgl').data('action') == 'export') {
                $.ajax({
                    url: `{{ config('app.api_url') }}chargegandengan/export?` + params,
                    type: 'GET',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`);
                    },
                    xhrFields: {
                        responseType: 'arraybuffer'
                    },
                    success: function(response, status, xhr) {
                        if (xhr.status === 200) {
                            if (response !== undefined) {
                                var blob = new Blob([response], {
                                    type: 'chargegandengan/vnd.ms-excel'
                                });
                                var link = document.createElement('a');
                                link.href = window.URL.createObjectURL(blob);
                                link.download = 'chargegandengan' + new Date().getTime() + '.xlsx';
                                link.click();
                            }
                            $('#rangeTglModal').modal('hide')
                            console.log('hide');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#processingLoader').addClass('d-none')
                        submitButton.removeAttr('disabled')
                    }
                }).always(() => {
                    $('#processingLoader').addClass('d-none')
                    submitButton.removeAttr('disabled')
                })  
              }
            }).catch((error) => {
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()
                    let status
                    if (error.responseJSON.hasOwnProperty('status') == false) {
                        status = false
                    } else {
                        status = true
                    }
                    statusText = error.statusText
                    errors = error.responseJSON.errors
                    $.each(errors, (index, error) => {
                        let indexes = index.split(".");
                        if (status === false) {
                            indexes[0] = 'sampai'
                        }
                        let element;
                        element = $('#formRangeTgl').find(`[name="${indexes[0]}"]`)[
                            0];
                        if ($(element).length > 0 && !$(element).is(":hidden")) {
                            $(element).addClass("is-invalid");
                            $(`
                                            <div class="invalid-feedback">
                                            ${error[0].toLowerCase()}
                                            </div>
                                    `).appendTo($(element).parent());
                        } else {
                            setTimeout(() => {
                                return showDialog(error);
                            }, 100)
                        }
                    });
                    $(".is-invalid").first().focus();
                    $('#processingLoader').addClass('d-none')

                } else {
                    showDialog(error.statusText)
                }
            }).finally(() => {
                $('.ui-button').click()
                submitButton.removeAttr('disabled')
            })
        })
        

        function getExport() {
            let params

            for (var key in postData) {
              if (params != "") {
                params += "&";
              }
              params += key + "=" + encodeURIComponent(postData[key]);
            }
            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: `{{ config('app.api_url') }}chargegandengan/export?` + params,
                type: 'GET',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`);
                },
                xhrFields: {
                    responseType: 'arraybuffer'
                },
                success: function(response, status, xhr) {
                    if (xhr.status === 200) {
                        if (response !== undefined) {
                            var blob = new Blob([response], {
                                type: 'chargegandengan/vnd.ms-excel'
                            });
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = 'chargegandengan' + new Date().getTime() + '.xlsx';
                            link.click();
                        }
                        $('#rangeTglModal').modal('hide')
                        console.log('hide');
                    }
                },
                error: function(xhr, status, error) {
                    $('#processingLoader').addClass('d-none')
                }
            }).always(() => {
                $('#processingLoader').addClass('d-none')
            }) 
        }
                        

        function getCekExport(params) {
            params += `&cekExport=true`
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `${apiUrl}chargegandengan/export?${params}`,
                    dataType: "JSON",
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        dari: $('#formRangeTgl').find('[name=dari]').val(),
                        sampai: $('#formRangeTgl').find('[name=sampai]').val()
                    },
                    success: (response) => {
                        resolve(response);
                    },
                    error: error => {
                        reject(error)               
                    },
                });
            });
        }
        
                
            

        function permission() {
            if (!`{{ $myAuth->hasPermission('chargegandengan', 'store') }}`) {
                $('#add').attr('disabled', 'disabled')
            }
            if (!`{{ $myAuth->hasPermission('chargegandengan', 'update') }}`) {
                $('#edit').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('chargegandengan', 'destroy') }}`) {
                $('#delete').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('chargegandengan', 'export') }}`) {
                $('#export').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('chargegandengan', 'report') }}`) {
                $('#report').attr('disabled', 'disabled')
            }
        }

       



    })
</script>
@endpush()
@endsection