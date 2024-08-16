<div class="modal modal-fullscreen" id="crudModalHistoryMandor" tabindex="-1" aria-labelledby="crudModalHistoryMandorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="crudFormHistoryMandor">
            <div class="modal-content">

                <div class="modal-header">
                    <p class="modal-title" id="crudModalHistoryMandorTitle"></p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">

                        <input type="text" name="id" class="form-control" hidden>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    TRADO
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="text" name="trado" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    Mandor Lama
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="mandor_id">
                                <input type="text" name="mandor" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    Mandor Baru<span class="text-danger"></span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="mandorbaru_id">
                                <input type="text" name="mandorbaru" class="form-control mandorhistorytrado-lookup">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    Tanggal Berlaku <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tglberlaku" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <table id="tableHistoryMandor"></table>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmitHistoryMandor" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Save
                        </button>
                        <button class="btn btn-secondary" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    hasFormBindKeys = false
    let modalBodyHistoryMandor = $('#crudModalHistoryMandor').find('.modal-body').html()

    let sortnameHistoryMandor = 'tanggalberlakugrid';
    let sortorderHistoryMandor = 'asc';
    let pageHistoryMandor = 0;
    let totalRecordHistoryMandor
    let limitHistoryMandor
    let postDataHistoryMandor
    let triggerClickHistoryMandor
    let indexRowHistoryMandor

    $(document).ready(function() {
        $('#btnSubmitHistoryMandor').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudFormHistoryMandor')
            $(this).attr('disabled', '')
            $('#processingLoader').removeClass('d-none')

            let data = form.serializeArray()
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
                name: 'info',
                value: info
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
            console.log(data)
            $.ajax({
                url: `${apiUrl}trado/historymandor`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {
                    $('#crudFormHistoryMandor').trigger('reset')
                    $('#crudModalHistoryMandor').modal('hide')

                    id = response.data.id
                    selectedRows = []
                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page
                    }).trigger('reloadGrid');

                    if (response.data.grp == 'FORMAT') {
                        updateFormat(response.data)
                    }
                },
                error: error => {
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
        })
    })

    $('#crudModalHistoryMandor').on('shown.bs.modal', () => {
        let form = $('#crudFormHistoryMandor')

        setFormBindKeys(form)

        activeGrid = null

        form.find('#btnSubmitHistoryMandor').prop('disabled', false)
        initLookupHistoryMandor()
        initDatepicker()
    })

    $('#crudModalHistoryMandor').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        $('#crudModalHistoryMandor').find('.modal-body').html(modalBodyHistoryMandor)
    })

    function editTradoMilikMandor(Id) {
        let form = $('#crudFormHistoryMandor')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmitHistoryMandor').html(`
            <i class="fa fa-save"></i>
            Save
        `)
        form.find(`.sometimes`).hide()
        $('#crudModalHistoryMandorTitle').text('History Trado Milik Mandor')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        loadTradoMandor()
        Promise
            .all([
                showTradoMilikMandor(form, Id)
            ])
            .then(() => {
                $('#crudModalHistoryMandor').modal('show')
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function showTradoMilikMandor(form, id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}trado/${id}/gethistorymandor`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)

                        if (element.is('select')) {
                            element.val(value).trigger('change')
                        } else if (element.hasClass('datepicker')) {
                            element.val(dateFormat(value))
                        } else {
                            element.val(value)
                        }
                    })
                    setTimeout(() => {

                        $('#tableHistoryMandor').jqGrid('setGridParam', {
                            url: `${apiUrl}trado/${id}/getlisthistorymandor`,
                            datatype: "json"
                        }).trigger('reloadGrid');
                    }, 100);

                    if (form.data('action') === 'delete') {
                        form.find('[name]').addClass('disabled')
                        initDisabled()
                    }

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function initLookupHistoryMandor() {
        $('.mandorhistorytrado-lookup').lookup({
            title: 'Mandor Lookup',
            fileName: 'mandor',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (mandor, element) => {
                $('#crudFormHistoryMandor [name=mandorbaru_id]').first().val(mandor.id)
                element.val(mandor.namamandor)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {

                $('#crudFormHistoryMandor [name=mandorbaru_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }

    function loadTradoMandor() {
        let disabled = '';
        if ($('#crudForm').data('action') == 'delete') {
            disabled = 'disabled'
        }
        $("#tableHistoryMandor").jqGrid({
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "local",
                colModel: [{
                        label: 'ID Grid',
                        name: 'idgrid',
                        width: '50px',
                        search: false,
                        hidden: true
                    }, {
                        label: 'TRADO',
                        name: 'tradogrid',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
                    },
                    {
                        label: 'MANDOR LAMA',
                        name: 'mandorlamagrid',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'MANDOR BARU',
                        name: 'mandorbarugrid',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'TGL BERLAKU',
                        name: 'tanggalberlakugrid',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 400,
                rowNum: 0,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                footerrow: true,
                userDataOnFooter: true,
                toolbar: [true, "top"],
                sortable: true,
                sortname: sortnameHistoryMandor,
                sortorder: sortorderHistoryMandor,
                page: pageHistoryMandor,
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
                    sortnameHistoryMandor = $(this).jqGrid("getGridParam", "sortname")
                    sortorderHistoryMandor = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordHistoryMandor = $(this).getGridParam("records")
                    limitHistoryMandor = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataHistoryMandor = $(this).jqGrid('getGridParam', 'postData')
                    triggerClickHistoryMandor = true

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowHistoryMandor > $(this).getDataIDs().length - 1) {
                        indexRowHistoryMandor = $(this).getDataIDs().length - 1;
                    }

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
                    clearGlobalSearch($('#tableHistoryMandor'))
                },
                afterSearch: function() {
                    console.log($(this).getGridParam())
                }
            })
            .customPager({})
        /* Append clear filter button */
        loadClearFilter($('#tableHistoryMandor'))

        /* Append global search */
        loadGlobalSearch($('#tableHistoryMandor'))
    }
</script>
@endpush()