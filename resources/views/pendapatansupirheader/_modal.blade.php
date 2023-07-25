<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="crudForm">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="crudModalTitle"></p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <form action="" method="post">

                    <div class="modal-body">
                        <input type="hidden" name="id">

                        <div class="row form-group">
                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">
                                    NO BUKTI <span class="text-danger"></span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4">
                                <input type="text" name="nobukti" class="form-control" readonly>
                            </div>

                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">
                                    TGL BUKTI <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4">
                                <div class="input-group">
                                    <input type="text" name="tglbukti" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    BANK <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="bank_id">
                                <input type="text" name="bank" class="form-control bank-lookup">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    PERIODE <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="periode" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    TGL DARI <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tgldari" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    TGL SAMPAI <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tglsampai" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-4">
                                <a id="btnTampil" class="btn btn-secondary mr-2 mb-2">
                                    <i class="fas fa-sync"></i>
                                    Reload
                                </a>
                            </div>
                        </div>

                        <table id="modalgrid"></table>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Simpan
                        </button>
                        <button class="btn btn-secondary" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let hasFormBindKeys = false
    let modalBody = $('#crudModal').find('.modal-body').html()

    let selectedRowsTrip = []
    let selectedTrip = [];
    let selectedRic = [];
    let selectedNominal = [];
    let selectedSupir = [];
    let selectedKeterangan = [];

    let sortnameTrip = 'nobukti_trip';
    let sortorderTrip = 'asc';
    let pageTrip = 0;
    let totalRecordTrip
    let limitTrip
    let postDataTrip
    let triggerClickTrip
    let indexRowTrip

    $(document).ready(function() {

        $('#crudForm').autocomplete({
            disabled: true
        });

        $(document).on('click', '#btnTampil', function(event) {
            console.log('reloaad');
            let tgldari = $('#crudForm').find(`[name=tgldari]`).val()
            let tglsampai = $('#crudForm').find(`[name=tglsampai]`).val()
            if ((tgldari != '') && (tglsampai != '')) {
                getTrip(tgldari, tglsampai)
                    .then((response) => {


                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        $('#modalgrid').jqGrid('setGridParam', {
                            url: `${apiUrl}pendapatansupirheader/gettrip`,
                            postData: {
                                tglsampai: tglsampai,
                                tgldari: tgldari,
                                sortIndex: 'nobukti_trip',
                                aksi: $('#crudForm').data('action'),
                                idPendapatan: $('#crudForm').find(`[name=id]`).val()
                            },
                            datatype: "json"
                        }).trigger('reloadGrid');
                    }).catch((error) => {
                        if (error.status === 422) {
                            $('.is-invalid').removeClass('is-invalid')
                            $('.invalid-feedback').remove()

                            setErrorMessages(form, error.responseJSON.errors);
                        } else {
                            showDialog(error.responseJSON)
                        }
                    })
            }

        })

        $('#btnSubmit').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            let data = []
            data.push({
                name: 'id',
                value: form.find(`[name="id"]`).val()
            })
            data.push({
                name: 'nobukti',
                value: form.find(`[name="nobukti"]`).val()
            })
            data.push({
                name: 'tglbukti',
                value: form.find(`[name="tglbukti"]`).val()
            })
            data.push({
                name: 'periode',
                value: form.find(`[name="periode"]`).val()
            })
            data.push({
                name: 'bank',
                value: form.find(`[name="bank"]`).val()
            })
            data.push({
                name: 'bank_id',
                value: form.find(`[name="bank_id"]`).val()
            })
            data.push({
                name: 'tgldari',
                value: form.find(`[name="tgldari"]`).val()
            })
            data.push({
                name: 'tglsampai',
                value: form.find(`[name="tglsampai"]`).val()
            })

            
            $.each(selectedRowsTrip, function(index, item) {
                data.push({
                    name: 'id_detail[]',
                    value: item
                })
            });
            $.each(selectedTrip, function(index, item) {
                data.push({
                    name: 'nobukti_trip[]',
                    value: item
                })
            });
            $.each(selectedRic, function(index, item) {
                data.push({
                    name: 'nobukti_ric[]',
                    value: item
                })
            });
            $.each(selectedSupir, function(index, item) {
                data.push({
                    name: 'supir_id[]',
                    value: item
                })
            });
            $.each(selectedKeterangan, function(index, item) {
                data.push({
                    name: 'keterangan[]',
                    value: item
                })
            });
            $.each(selectedNominal, function(index, item) {
                data.push({
                    name: 'nominal_detail[]',
                    value: parseFloat(item.replaceAll(',', ''))
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

            data.push({
                name: 'tgldariheader',
                value: $('#tgldariheader').val()
            })
            data.push({
                name: 'tglsampaiheader',
                value: $('#tglsampaiheader').val()
            })

            let tgldariheader = $('#tgldariheader').val();
            let tglsampaiheader = $('#tglsampaiheader').val()

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}pendapatansupirheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}pendapatansupirheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}pendapatansupirheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}pendapatansupirheader`
                    break;
            }

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

                    id = response.data.id
                    $('#crudModal').modal('hide')
                    $('#crudModal').find('#crudForm').trigger('reset')

                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page
                    }).trigger('reloadGrid');

                    if (id == 0) {
                        $('#detail').jqGrid().trigger('reloadGrid')
                    }
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

    $('#crudModal').on('shown.bs.modal', () => {
        let form = $('#crudForm')

        setFormBindKeys(form)

        activeGrid = null

        getMaxLength(form)
        initDatepicker()
        initLookup()
        loadModalGrid()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'

        $('#crudModal').find('.modal-body').html(modalBody)
    })

    function createPendapatanSupir() {
        let form = $('#crudForm')

        $('#crudModal').find('#crudForm').trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
        form.data('action', 'add')

        $('#crudModalTitle').text('Add Pendapatan Supir')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()


        $('#table_body').html('')
        $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tgldari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    }

    function editPendapatanSupir(pendapatanId) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
        $('#crudModalTitle').text('Edit Pendapatan Supir')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showPendapatanSupir(form, pendapatanId)
            ])
            .then(() => {
                clearSelectedRows()
                $('#gs_').prop('checked', false)
                $('#crudModal').modal('show')
                form.find('[name=tglbukti]').attr('readonly', true)
                form.find('[name=tglbukti]').siblings('.input-group-append').remove()
                form.find('[name=tgldari]').attr('readonly', true)
                form.find('[name=tgldari]').siblings('.input-group-append').remove()
                form.find('[name=tglsampai]').attr('readonly', true)
                form.find('[name=tglsampai]').siblings('.input-group-append').remove()
                form.find('[name=periode]').attr('readonly', true)
                form.find('[name=periode]').siblings('.input-group-append').remove()
                form.find('[name=bank]').attr('readonly', true)
                form.find('[name=bank]').siblings('.input-group-append').remove()
                form.find('[name=bank]').siblings('.button-clear').remove()
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function deletePendapatanSupir(pendapatanId) {

        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
        $('#crudModalTitle').text('Delete Pendapatan Supir')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showPendapatanSupir(form, pendapatanId)
            ])
            .then(() => {
                clearSelectedRows()
                $('#gs_').prop('checked', false)
                $('#crudModal').modal('show')
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })

    }


    function cekValidasi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}pendapatansupirheader/${Id}/cekvalidasi`,
            method: 'POST',
            dataType: 'JSON',
            beforeSend: request => {
                request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
            },
            success: response => {
                var kodenobukti = response.kodenobukti
                if (kodenobukti == '1') {
                    var kodestatus = response.kodestatus
                    if (kodestatus == '1') {
                        showDialog(response.message['keterangan'])
                    } else {
                        if (Aksi == 'EDIT') {
                            editPendapatanSupir(Id)
                        }
                        if (Aksi == 'DELETE') {
                            deletePendapatanSupir(Id)
                        }
                    }

                } else {
                    showDialog(response.message['keterangan'])
                }
            }
        })
    }

    function showPendapatanSupir(form, pendapatanId) {
        return new Promise((resolve, reject) => {
            $('#detailList tbody').html('')

            $('#crudForm [name=tglbukti]').attr('readonly', true)
            $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()

            $.ajax({
                url: `${apiUrl}pendapatansupirheader/${pendapatanId}`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)

                        if (element.hasClass('datepicker')) {
                            element.val(dateFormat(value))
                        } else {
                            element.val(value)
                        }
                    })
                    $('#detailList tbody').html('')
                    $.each(response.detail, (index, detail) => {
                        let detailRow = $(`
                    <tr>
                    <td></td>
                    <td>
                        <input type="hidden" name="supir_id[]">
                        <input type="text" name="supir[]" data-current-value="${detail.supir}" class="form-control supir-lookup">
                    </td>
                    <td>
                        <input type="text" name="keterangan_detail[]" class="form-control">   
                    </td>
                    <td>
                        <input type="text" name="nominal[]"  style="text-align:right" class="form-control autonumeric nominal" > 
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                    </td>
                    </tr>
                `)

                        detailRow.find(`[name="supir_id[]"]`).val(detail.supir_id)
                        detailRow.find(`[name="supir[]"]`).val(detail.supir)
                        detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
                        detailRow.find(`[name="nominal[]"]`).val(detail.nominal)

                        initAutoNumeric(detailRow.find(`[name="nominal[]"]`))
                        $('#detailList tbody').append(detailRow)
                        setTotal();

                        $('.supir-lookup').last().lookup({
                            title: 'Supir Lookup',
                            fileName: 'supir',
                            beforeProcess: function(test) {
                                this.postData = {
                                    Aktif: 'AKTIF',
                                }
                            },
                            onSelectRow: (supir, element) => {
                                element.parents('td').find(`[name="supir_id[]"]`).val(supir.id)
                                element.val(supir.namasupir)
                                element.data('currentValue', element.val())
                            },
                            onCancel: (element) => {
                                element.val(element.data('currentValue'))
                            },
                            onClear: (element) => {
                                element.parents('td').find(`[name="supir_id[]"]`).val('')
                                element.val('')
                                element.data('currentValue', element.val())
                            }
                        })

                    })

                    setRowNumbers()
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

    function loadModalGrid() {
        let disabled = '';
        if ($('#crudForm').data('action') == 'delete') {
            disabled = 'disabled'
        }

        $("#modalgrid").jqGrid({
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "local",
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
                                $(element).attr('id', 'gsTrip')
                                let agen_id = $('#crudForm').find(`[name=agen_id]`).val()
                                let tglproses = $('#crudForm').find(`[name=tglproses]`).val()

                                $(element).removeClass('form-control')
                                $(element).parent().addClass('text-center')
                                if (disabled == '') {
                                    $(element).on('click', function() {
                                        $(element).attr('disabled', true)

                                        if ($(this).is(':checked')) {
                                            selectAllRowsTrip()
                                        } else {
                                            clearSelectedRowsTrip(element)
                                        }
                                    })
                                } else {
                                    $(element).attr('disabled', true)
                                }
                            }
                        },
                        formatter: (value, rowOptions, rowData) => {
                            return `<input type="checkbox" name="idgrid[]" value="${rowData.id}" ${disabled} onchange="checkboxHandlerTrip(this)">`
                        },
                    },
                    {
                        label: 'ID',
                        name: 'id',
                        width: '50px',
                        hidden: true
                    },
                    {
                        label: 'NO BUKTI TRIP',
                        name: 'nobukti_trip',
                    },
                    {
                        label: 'NO BUKTI RIC',
                        name: 'nobukti_ric',
                    },
                    {
                        label: 'SUPIR',
                        name: 'supir',
                    },
                    {
                        label: 'supir_id',
                        name: 'supir_id',
                        hidden: true,
                        search: false
                    },
                    {
                        label: 'NOMINAL',
                        name: 'nominal_detail',
                        align: 'right',
                        formatter: currencyFormat,
                    },

                    {
                        label: 'KETERANGAN',
                        name: 'keterangan',
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
                sortname: sortnameTrip,
                sortorder: sortorderTrip,
                page: pageTrip,
                viewrecords: true,
                footerrow: true,
                userDataOnFooter: true,
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

                loadComplete: function(data) {
                    let grid = $(this)
                    changeJqGridRowListText()
                    initResize($(this))

                    sortnameTrip = $(this).jqGrid("getGridParam", "sortname")
                    sortorderTrip = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordTrip = $(this).getGridParam("records")
                    limitTrip = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataTrip = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = false

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })
                    if (indexRow > $(this).getDataIDs().length - 1) {
                        indexRow = $(this).getDataIDs().length - 1;
                    }
                    $('#modalgrid').setSelection($('#modalgrid').getDataIDs()[0])
                    setHighlight($(this))

                    if (data.attributes) {

                        $(this).jqGrid('footerData', 'set', {
                            nobukti_trip: 'Total:',
                            nominal_detail: data.attributes.totalNominal,
                        }, true)
                    }

                    $.each(selectedRowsTrip, function(key, value) {
                        $(grid).find('tbody tr').each(function(row, tr) {
                            if ($(this).find(`td input:checkbox`).val() == value) {
                                $(this).addClass('bg-light-blue')
                                $(this).find(`td input:checkbox`).prop('checked', true)
                            }
                        })
                    });
                    if (disabled == '') {
                        $('#gsTrip').attr('disabled', false)
                    } else {
                        $('#gsTrip').attr('disabled', true)
                    }
                }
            })
            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false,
                defaultSearch: 'cn',
                groupOp: 'AND',
                disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
                beforeSearch: function() {
                    abortGridLastRequest($(this))

                    clearGlobalSearch($('#modalgrid'))
                },
            })
            .customPager()
        /* Append clear filter button */
        loadClearFilter($('#modalgrid'))

        /* Append global search */
        loadGlobalSearch($('#modalgrid'))
    }


    function getTrip(tgldari, tglsampai) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}pendapatansupirheader/gettrip`,
                method: 'GET',
                dataType: 'JSON',
                data: {
                    limit: 0,
                    tglsampai: tglsampai,
                    tgldari: tgldari,
                    sortIndex: 'nobukti_trip',
                    aksi: $('#crudForm').data('action'),
                    idPendapatan: $('#crudForm').find(`[name=id]`).val()
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: (response) => {
                    response.url = `${apiUrl}pendapatansupirheader/gettrip`
                    selectedRowsTrip = []
                    selectedTrip = [];
                    selectedRic = [];
                    selectedNominal = [];
                    selectedSupir = [];
                    selectedKeterangan = [];

                    $.each(response.data, (index, detail) => {
                        if (detail.noinvoice != '') {

                            selectedRowsTrip.push(detail.id)
                            selectedTrip.push(detail.nobukti_trip)
                            selectedRic.push(detail.nobukti_ric)
                            selectedNominal.push(detail.nominal_detail)
                            selectedSupir.push(detail.supir_id)
                            selectedKeterangan.push(detail.keterangan)
                        }
                    })
                    resolve(response)
                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        errors = error.responseJSON.errors
                        reject(errors)

                    } else {
                        showDialog(error.statusText)
                    }
                },
                error: error => {
                    reject(error)
                }
            })
        });

    }

    function clearSelectedRowsTrip(element = null) {
        selectedRowsTrip = []
        selectedTrip = [];
        selectedRic = [];
        selectedNominal = [];
        selectedSupir = [];
        selectedKeterangan = [];

        $('#modalgrid').trigger('reloadGrid')
    }

    function selectAllRowsTrip() {
        $.ajax({
            url: `${apiUrl}pendapatansupirheader/gettrip`,
            method: 'GET',
            dataType: 'JSON',
            data: {
                limit: 0,
                tglsampai: $('#crudForm').find(`[name=tglsampai]`).val(),
                tgldari: $('#crudForm').find(`[name=tgldari]`).val(),
                sortIndex: 'nobukti_trip',
                aksi: $('#crudForm').data('action'),
                idPendapatan: $('#crudForm').find(`[name=id]`).val()
            },
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: (response) => {
                selectedRowsTrip = []
                selectedTrip = [];
                selectedRic = [];
                selectedNominal = [];
                selectedSupir = [];
                selectedKeterangan = [];

                selectedRowsTrip = response.data.map((data) => data.id)
                selectedTrip = response.data.map((data) => data.nobukti_trip)
                selectedRic = response.data.map((data) => data.nobukti_ric)
                selectedNominal = response.data.map((data) => data.nominal_detail)
                selectedSupir = response.data.map((data) => data.supir_id)
                selectedKeterangan = response.data.map((data) => data.keterangan)

                $('#modalgrid').jqGrid('setGridParam', {
                    url: `${apiUrl}pendapatansupirheader/gettrip`,
                    postData: {
                        tglsampai: $('#crudForm').find(`[name=tglsampai]`).val(),
                        tgldari: $('#crudForm').find(`[name=tgldari]`).val(),
                        sortIndex: 'nobukti_trip',
                        aksi: $('#crudForm').data('action'),
                        idPendapatan: $('#crudForm').find(`[name=id]`).val()
                    },
                    datatype: "json"
                }).trigger('reloadGrid');
            }
        })

    }

    function checkboxHandlerTrip(element) {
        let value = $(element).val();
        if (element.checked) {
            selectedRowsTrip.push($(element).val())
            selectedTrip.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_nobukti_trip"]`).text())
            selectedRic.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_nobukti_ric"]`).text())
            selectedNominal.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_nominal_detail"]`).text())
            selectedSupir.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_supir_id"]`).text())
            selectedKeterangan.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_keterangan"]`).text())
        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRowsTrip.length; i++) {
                if (selectedRowsTrip[i] == value) {
                    selectedRowsTrip.splice(i, 1);
                    selectedTrip.splice(i, 1);
                    selectedRic.splice(i, 1);
                    selectedNominal.splice(i, 1);
                    selectedSupir.splice(i, 1);
                    selectedKeterangan.splice(i, 1);
                }
            }
        }
    }

    function addRow() {
        let detailRow = $(`
      <tr>

        <td></td>
        <td>
            <input type="hidden" name="supir_id[]">
            <input type="text" name="supir[]" class="form-control supir-lookup">
        </td>
        <td>
          <input type="text" name="keterangan_detail[]" class="form-control">   
        </td><td>
          <input type="text" name="nominal[]" class="form-control autonumeric nominal"> 
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
        </td>
      </tr>
    `)

        $('#detailList tbody').append(detailRow)


        $('.supir-lookup').last().lookup({
            title: 'Supir Lookup',
            fileName: 'supir',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },

            onSelectRow: (supir, element) => {
                element.parents('td').find(`[name="supir_id[]"]`).val(supir.id)
                element.val(supir.namasupir)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.parents('td').find(`[name="supir_id[]"]`).val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        initAutoNumeric(detailRow.find('.autonumeric'))

        initDatepicker()
        setRowNumbers()
    }

    function deleteRow(row) {
        row.remove()

        setRowNumbers()
        setTotal()
    }

    function setRowNumbers() {
        let elements = $('#detailList tbody tr td:nth-child(1)')

        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }

    function approve() {

        event.preventDefault()

        let form = $('#crudForm')
        $(this).attr('disabled', '')
        $('#processingLoader').removeClass('d-none')

        $.ajax({
            url: `${apiUrl}pendapatansupirheader/approval`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                pendapatanId: selectedRows
            },
            success: response => {
                $('#crudForm').trigger('reset')
                $('#crudModal').modal('hide')

                $('#jqGrid').jqGrid().trigger('reloadGrid');
                selectedRows = []
                $('#gs_').prop('checked', false)
            },
            error: error => {
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()

                    setErrorMessages(form, error.responseJSON.errors);
                } else {
                    showDialog(error.statusText)
                }
            },
        }).always(() => {
            $('#processingLoader').addClass('d-none')
            $(this).removeAttr('disabled')
        })

    }

    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
            $.ajax({
                url: `${apiUrl}jurnalumumheader/field_length`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        if (value !== null && value !== 0 && value !== undefined) {
                            form.find(`[name=${index}]`).attr('maxlength', value)
                        }
                    })

                    form.attr('has-maxlength', true)
                },
                error: error => {
                    showDialog(error.statusText)
                }
            })
        }
    }

    function initLookup() {
        $('.bank-lookup').lookup({
            title: 'Bank Lookup',
            fileName: 'bank',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },

            onSelectRow: (bank, element) => {
                $('#crudForm [name=bank_id]').first().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="bank_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()