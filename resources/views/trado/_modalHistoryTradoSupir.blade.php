<div class="modal modal-fullscreen" id="crudModalHistorySupir" tabindex="-1" aria-labelledby="crudModalHistorySupirLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="crudFormHistorySupir">
            <div class="modal-content">

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
                                    Supir Lama
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="supir_id">
                                <input type="text" name="supir" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    Supir Baru<span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="supirbaru_id">
                                <input type="text" name="supirbaru" class="form-control supirbaru-lookup">
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
                            <table id="tableHistorySupir"></table>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmitHistorySupir" class="btn btn-primary">
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
    let modalBodyHistorySupir = $('#crudModalHistorySupir').find('.modal-body').html()

    let sortnameHistorySupir = 'tanggalberlakugrid';
    let sortorderHistorySupir = 'asc';
    let pageHistorySupir = 0;
    let totalRecordHistorySupir
    let limitHistorySupir
    let postDataHistorySupir
    let triggerClickHistorySupir
    let indexRowHistorySupir

    $(document).ready(function() {
        $('#btnSubmitHistorySupir').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudFormHistorySupir')
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
                url: `${apiUrl}trado/historysupir`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {
                    $('#crudFormHistorySupir').trigger('reset')
                    $('#crudModalHistorySupir').modal('hide')

                    id = response.data.id

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

    $('#crudModalHistorySupir').on('shown.bs.modal', () => {
        let form = $('#crudFormHistorySupir')

        setFormBindKeys(form)

        activeGrid = null

        form.find('#btnSubmitHistorySupir').prop('disabled', false)
        initLookupHistorySupir()
        initDatepicker()
    })

    $('#crudModalHistorySupir').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        $('#crudModalHistorySupir').find('.modal-body').html(modalBodyHistorySupir)
    })

    function editTradoMilikSupir(Id) {
        let form = $('#crudFormHistorySupir')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmitHistorySupir').html(`
            <i class="fa fa-save"></i>
            Save
        `)
        form.find(`.sometimes`).hide()
        $('#crudModalHistorySupirTitle').text('HistorySupirMilikSupir')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        loadTradoSupir()
        Promise
            .all([
                showTradoMilikSupir(form, Id)
            ])
            .then(() => {
                $('#crudModalHistorySupir').modal('show')
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function showTradoMilikSupir(form, id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}trado/${id}/gethistorysupir`,
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

                        $('#tableHistorySupir').jqGrid('setGridParam', {
                            url: `${apiUrl}trado/${id}/getlisthistorysupir`,
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

    function initLookupHistorySupir() {
        $('.supirbaru-lookup').lookup({
            title: 'Supir Lookup',
            fileName: 'supir',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (supir, element) => {
                $('#crudFormHistorySupir [name=supirbaru_id]').first().val(supir.id)
                element.val(supir.namasupir)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {

                $('#crudFormHistorySupir [name=supirbaru_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }

    function loadTradoSupir() {
        let disabled = '';
        if ($('#crudForm').data('action') == 'delete') {
            disabled = 'disabled'
        }
        $("#tableHistorySupir").jqGrid({
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
                        label: 'SUPIR LAMA',
                        name: 'supirlamagrid',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'SUPIR BARU',
                        name: 'supirbarugrid',
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
                sortname: sortnameHistorySupir,
                sortorder: sortorderHistorySupir,
                page: pageHistorySupir,
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
                    sortnameHistorySupir = $(this).jqGrid("getGridParam", "sortname")
                    sortorderHistorySupir = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordHistorySupir = $(this).getGridParam("records")
                    limitHistorySupir = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataHistorySupir = $(this).jqGrid('getGridParam', 'postData')
                    triggerClickHistorySupir = true

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowHistorySupir > $(this).getDataIDs().length - 1) {
                        indexRowHistorySupir = $(this).getDataIDs().length - 1;
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
                    clearGlobalSearch($('#tableHistorySupir'))
                },
                afterSearch: function() {
                    console.log($(this).getGridParam())
                }
            })
            .customPager({})
        /* Append clear filter button */
        loadClearFilter($('#tableHistorySupir'))

        /* Append global search */
        loadGlobalSearch($('#tableHistorySupir'))
    }
</script>
@endpush()