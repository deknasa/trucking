<div class="modal modal-fullscreen" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="transferForm">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="transferModalTitle"></p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body" style="min-height: 627px;">
                    <div class="card">
                        <div class="card-body h-100">
                            <div class="row form-group">
                                <div class="col-12 col-sm-3 col-md-2">
                                    <label class="col-form-label">
                                        Cabang <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-sm-9 col-md-10">
                                    <select name="cabang[]" id="multiple" class="select2bs4 form-control" multiple="multiple"></select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12">
                                    <table id="coaGrid"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="mr-auto">
                        <button type="button" id="btnSubmitTransfer" class="btn btn-primary"><i class="fa fa-upload"></i> Transfer</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
    let sortnameCoa = 'coa';
    let sortorderCoa = 'asc';
    let pageCoa = 0;
    let totalRecordCoa
    let limitCoa
    let postDataCoa
    let triggerClickCoa
    let indexRowCoa
    let selectedRowsTransfer = [];

    $(document).ready(function() {
        $('#btnSubmitTransfer').click(function(event) {

            let method
            let url
            let form = $('#transferForm')


            event.preventDefault()

            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            let data = []

            $.each(form.find(`[name="cabang[]"]`).val(), function(index, value) {
                data.push({
                    name: 'cabang[]',
                    value: value
                })
            })
            data.push({
                name: 'jumlahdetail',
                value: selectedRowsTransfer.length
            })
            $.each(selectedRowsTransfer, function(index, item) {
                data.push({
                    name: 'coaId[]',
                    value: item
                })
            });

            data.push({
                name: 'sortIndex',
                value: $('#jqGrid').getGridParam().sortname
            })
            data.push({
                name: 'sortOrder',
                value: $('#jqGrid').getGridParam().sortorder
            })
            data.push({
                name: 'filters',
                value: $('#jqGrid').getGridParam('postData').filters
            })
            data.push({
                name: 'indexRow',
                value: indexRow
            })
            data.push({
                name: 'page',
                value: page
            })
            data.push({
                name: 'limit',
                value: limit
            })

            method = 'POST'
            url = `${apiUrl}akunpusat/transfer`

            $(this).attr('disabled', '')
            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: url,
                method: method,
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {

                    $('#transferModal').find('#crudForm').trigger('reset')
                    $('#transferModal').modal('hide')
                    $('#jqGrid').jqGrid().trigger('reloadGrid');
                    selectedRowsTransfer = []

                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        console.log(error)
                        setErrorMessages(form, error.responseJSON.errors);
                    } else {
                        console.log(error)
                        showDialog(error.responseJSON)
                    }
                },
            }).always(() => {
                $('#processingLoader').addClass('d-none')
                $(this).removeAttr('disabled')
            })
        })
    })

    function transferCoa() {
        let form = $('#transferForm')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
        `)

        form.data('action', 'add')
        $('#transferModalTitle').text('Transfer Akun Pusat')
        $('#transferModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        Promise
            .all([
                setCabang(form),
                getTransferCoa()
            ])
            .then(() => {
                $('#userRoleModal').modal('show')
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function getTransferCoa() {
        $("#coaGrid").jqGrid({
                url: `${apiUrl}akunpusat`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "json",
                colModel: [{
                        label: '',
                        name: '',
                        width: 30,
                        align: 'center',
                        sortable: false,
                        clear: false,
                        stype: 'input',
                        searchable: false,
                        searchoptions: {
                            type: 'checkbox',
                            clearSearch: false,
                            dataInit: function(element) {

                                let aksi = $('#crudForm').data('action')
                                $(element).removeClass('form-control')
                                $(element).parent().addClass('text-center')

                                $(element).on('click', function() {
                                    $(element).attr('disabled', true)

                                    if ($(this).is(':checked')) {
                                        selectAllRows()
                                    } else {
                                        clearselectedRowsTransfer(element)
                                    }
                                })

                            }
                        },
                        formatter: (value, rowOptions, rowData) => {
                            return `<input type="checkbox" name="coaId[]" value="${rowData.id}" onchange="checkboxHandler(this)">`
                        },
                    },
                    {
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '50px',
                        search: false,
                        hidden: true
                    },
                    {
                        label: 'KODE PERKIRAAN',
                        name: 'coa',
                    },
                    {
                        label: 'keterangan kode perkiraan',
                        width: 220,
                        name: 'keterangancoa',
                    },
                    {
                        label: 'TYPE',
                        name: 'type',
                    },
                    {
                        label: 'AKUNTANSI',
                        name: 'akuntansi',
                    },
                    {
                        label: 'LEVEL',
                        name: 'level',
                    }, {
                        label: 'STATUS',
                        name: 'statusaktif',
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

                                    ?>
              `,
                            dataInit: function(element) {
                                $(element).select2({
                                    width: 'resolve',
                                    theme: "bootstrap4"
                                });
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
                            let statusAktif = JSON.parse(rowObject.statusaktif)

                            return ` title="${statusAktif.MEMO}"`
                        }
                    },
                    {
                        label: 'PARENT',
                        name: 'parent',
                    },
                    {
                        label: 'STATUS PARENT',
                        width: 210,
                        name: 'statusparent',
                        align: 'left',
                        stype: 'select',
                        searchoptions: {

                            value: `<?php
                                    $i = 1;

                                    foreach ($data['comboparent'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['comboparent'])) {
                                            echo ';';
                                        }
                                        $i++;
                                    endforeach;

                                    ?>
              `,
                            dataInit: function(element) {
                                $(element).select2({
                                    width: 'resolve',
                                    theme: "bootstrap4"
                                });
                            }
                        },
                        formatter: (value, options, rowData) => {
                            if (!value) {
                                return ''
                            }
                            let statusParent = JSON.parse(value)

                            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusParent.WARNA}; color: #fff;">
                  <span>${statusParent.SINGKATAN}</span>
                </div>
              `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            if (!rowObject.statusparent) {
                                return ` title=""`
                            }
                            let statusParent = JSON.parse(rowObject.statusparent)

                            return ` title="${statusParent.MEMO}"`
                        }
                    },
                    {
                        label: 'STATUS NERACA',
                        name: 'statusneraca',
                        align: 'left',
                        stype: 'select',
                        searchoptions: {

                            value: `<?php
                                    $i = 1;

                                    foreach ($data['comboneraca'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['comboneraca'])) {
                                            echo ';';
                                        }
                                        $i++;
                                    endforeach;

                                    ?>
              `,
                            dataInit: function(element) {
                                $(element).select2({
                                    width: 'resolve',
                                    theme: "bootstrap4"
                                });
                            }
                        },
                        formatter: (value, options, rowData) => {
                            let statusNeraca = JSON.parse(value)

                            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusNeraca.WARNA}; color: #fff;">
                  <span>${statusNeraca.SINGKATAN}</span>
                </div>
              `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusNeraca = JSON.parse(rowObject.statusneraca)

                            return ` title="${statusNeraca.MEMO}"`
                        }
                    },
                    {
                        label: 'STATUS LABA RUGI',
                        name: 'statuslabarugi',
                        align: 'left',
                        stype: 'select',
                        searchoptions: {

                            value: `<?php
                                    $i = 1;

                                    foreach ($data['combolabarugi'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['combolabarugi'])) {
                                            echo ';';
                                        }
                                        $i++;
                                    endforeach;

                                    ?>
              `,
                            dataInit: function(element) {
                                $(element).select2({
                                    width: 'resolve',
                                    theme: "bootstrap4"
                                });
                            }
                        },
                        formatter: (value, options, rowData) => {
                            let statusLabaRugi = JSON.parse(value)

                            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusLabaRugi.WARNA}; color: #fff;">
                  <span>${statusLabaRugi.SINGKATAN}</span>
                </div>
              `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusLabaRugi = JSON.parse(rowObject.statuslabarugi)

                            return ` title="${statusLabaRugi.MEMO}"`
                        }
                    },
                    {
                        label: 'kode perkiraan main',
                        width: 200,
                        name: 'coamain',
                    },
                    {
                        label: 'CREATED AT',
                        name: 'created_at',
                        align: 'right',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y H:i:s"
                        }
                    },
                    {
                        label: 'UPDATED AT',
                        name: 'updated_at',
                        align: 'right',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y H:i:s"
                        }
                    },
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 400,
                rowNum: 10,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                footerrow: true,
                userDataOnFooter: true,
                toolbar: [true, "top"],
                sortable: true,
                sortname: sortnameCoa,
                sortorder: sortorderCoa,
                page: pageCoa,
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
                    jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

                    setGridLastRequest($(this), jqXHR)
                },

                onSelectRow: function(id) {
                    activeGrid = $(this)
                },
                loadComplete: function(data) {
                    let grid = $(this)
                    changeJqGridRowListText()

                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    /* Set global variables */
                    sortnameCoa = $(this).jqGrid("getGridParam", "sortname")
                    sortorderCoa = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordCoa = $(this).getGridParam("records")
                    limitCoa = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataCoa = $(this).jqGrid('getGridParam', 'postData')
                    triggerClickCoa = true

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowCoa > $(this).getDataIDs().length - 1) {
                        indexRowCoa = $(this).getDataIDs().length - 1;
                    }

                    setHighlight($(this))

                    $.each(selectedRowsTransfer, function(key, value) {
                        $(grid).find('tbody tr').each(function(row, tr) {
                            if ($(this).find(`td input:checkbox`).val() == value) {
                                $(this).addClass('bg-light-blue')
                                $(this).find(`td input:checkbox`).prop('checked', true)
                            }
                        })
                    });
                    $('#gs_').attr('disabled', false)
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
                    clearGlobalSearch($('#coaGrid'))
                },
            })

            .customPager({})



        /* Append clear filter button */
        loadClearFilter($('#coaGrid'))

        /* Append global search */
        loadGlobalSearch($('#coaGrid'))
    }

    function setCabang(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name="cabang[]"]').empty()

            $.ajax({
                url: `${apiUrl}cabang`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    limit: 0,
                    transferCoa: 'pusat'
                },
                success: response => {
                    response.data.forEach(cabang => {
                        let option = new Option(cabang.kodecabang, cabang.id)

                        relatedForm.find(`[name="cabang[]"]`).append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function checkboxHandler(element) {
        let value = $(element).val();

        if (element.checked) {
            selectedRowsTransfer.push($(element).val())
            $(element).parents('tr').addClass('bg-light-blue')
        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRowsTransfer.length; i++) {
                if (selectedRowsTransfer[i] == value) {
                    selectedRowsTransfer.splice(i, 1);
                }
            }
        }
    }

    function clearselectedRowsTransfer() {
        selectedRowsTransfer = []

        $('#coaGrid').trigger('reloadGrid')
    }

    function selectAllRows() {
        $.ajax({
            url: `${apiUrl}akunpusat`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                limit: 0
            },
            success: (response) => {
                selectedRowsTransfer = response.data.map((coa) => coa.id)

                $('#coaGrid').trigger('reloadGrid')
            }
        })
    }
</script>
@endpush()