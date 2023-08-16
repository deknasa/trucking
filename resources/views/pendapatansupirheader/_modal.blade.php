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
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    SUPIR <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="supir_id">
                                <input type="text" name="supir" class="form-control supir-lookup">
                            </div>
                        </div>




                        <!-- <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    PERIODE <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="periode" class="form-control datepicker">
                                </div>
                            </div>
                        </div> -->

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
                                <a id="btnTampil" class="btn btn-primary mr-2 mb-2">
                                    <i class="fas fa-sync"></i>
                                    Reload
                                </a>
                            </div>
                        </div>

                        <div class="border p-3 mt-3 mb-3">
                            <h6>Posting Pengeluaran</h6>

                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        POSTING </label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <input type="hidden" name="bank_id">
                                    <input type="text" name="bank" class="form-control bank-lookup">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        NO BUKTI KAS/BANK KELUAR </label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <input type="text" name="pengeluaran_nobukti" id="pengeluaran_nobukti" class="form-control" readonly>
                                </div>
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
    let selectedDari = [];
    let selectedSampai = [];
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


            let tgldari = $('#crudForm').find(`[name=tgldari]`).val()
            let tglsampai = $('#crudForm').find(`[name=tglsampai]`).val()
            let supir_id = $('#crudForm').find(`[name=supir_id]`).val()
            let id = $('#crudForm').find(`[name=id]`).val()
            if ((tgldari != '') && (tglsampai != '') && (supir_id != '')) {

                getTrip(tgldari, tglsampai, supir_id, id)
                    .then((response) => {


                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        $('#modalgrid').jqGrid('setGridParam', {
                            url: `${apiUrl}pendapatansupirheader/gettrip`,
                            postData: {
                                tglsampai: tglsampai,
                                tgldari: tgldari,
                                supir_id: supir_id,
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
                name: 'pengeluaran_nobukti',
                value: form.find(`[name="pengeluaran_nobukti"]`).val()
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
                name: 'supir',
                value: form.find(`[name="supir"]`).val()
            })
            data.push({
                name: 'supir_id',
                value: form.find(`[name="supir_id"]`).val()
            })
            data.push({
                name: 'tgldari',
                value: form.find(`[name="tgldari"]`).val()
            })
            data.push({
                name: 'tglsampai',
                value: form.find(`[name="tglsampai"]`).val()
            })


            let rowLength = 0
            $.each(selectedRowsTrip, function(index, item) {
                data.push({
                    name: 'id_detail[]',
                    value: item
                })
                rowLength++
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
            $.each(selectedDari, function(index, item) {
                data.push({
                    name: 'dari_id[]',
                    value: item
                })
            });
            $.each(selectedSampai, function(index, item) {
                data.push({
                    name: 'sampai_id[]',
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
                name: 'jumlahdetail',
                value: rowLength
            })
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
                    selectedRowsTrip = []
                    selectedTrip = [];
                    selectedRic = [];
                    selectedNominal = [];
                    selectedDari = [];
                    selectedSampai = [];
                    $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
                    $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');
                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page,
                        postData: {
                            tgldari: dateFormat(response.data.tgldariheader),
                            tglsampai: dateFormat(response.data.tglsampaiheader)
                        }
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
        clearSelectedRowsTrip()
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
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        Promise
            .all([
                showDefault(form)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
                $('#crudForm').find('[name=tgldari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
                $('#crudForm').find('[name=tglsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
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
                // form.find('[name=tglbukti]').attr('readonly', true)
                // form.find('[name=tglbukti]').siblings('.input-group-append').remove()
                supir = $('#crudForm').find(`[name="supir"]`).parents('.input-group')
                supir.find('.button-clear').attr('disabled', true)
                supir.children().find('.lookup-toggler').attr('disabled', true)

                bank = $('#crudForm').find(`[name="bank"]`).parents('.input-group')
                bank.find('.button-clear').attr('disabled', true)
                bank.children().find('.lookup-toggler').attr('disabled', true)
            })
            .catch((error) => {
                showDialog(error.responseJSON)
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

                $('#crudForm [name=tglbukti]').attr('readonly', true)
                $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })

    }


    function showDefault(form) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}pendapatansupirheader/default`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)
                        // let element = form.find(`[name="statusaktif"]`)

                        if (element.is('select')) {
                            element.val(value).trigger('change')
                        } else {
                            element.val(value)
                        }
                    })
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
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
                var error = response.error
                if (error) {
                    showDialog(response)
                } else {
                    cekValidasiAksi(Id, Aksi)
                }
            }
        })
    }

    function cekValidasiAksi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}pendapatansupirheader/${Id}/cekValidasiAksi`,
            method: 'POST',
            dataType: 'JSON',
            beforeSend: request => {
                request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
            },
            success: response => {
                var error = response.error
                if (error) {
                    showDialog(response)
                } else {
                    if (Aksi == 'EDIT') {
                        editPendapatanSupir(Id)
                    }
                    if (Aksi == 'DELETE') {
                        deletePendapatanSupir(Id)
                    }
                }

            }
        })
    }


    function showPendapatanSupir(form, pendapatanId) {
        return new Promise((resolve, reject) => {
            $('#detailList tbody').html('')


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

                        if (index == 'supir') {
                            form.find('[name=supir]').attr('readonly', true)
                            element.data('current-value', value)

                        }
                        if (index == 'bank') {
                            form.find('[name=pengeluaran_nobukti]').attr('readonly', true)
                            form.find('[name=bank]').attr('readonly', true)
                            element.data('current-value', value)
                        }
                    })
                    $.each(response.detail, (index, detail) => {

                        if (detail.pendapatansupir_id != 0) {

                            selectedRowsTrip.push(detail.id)
                            selectedTrip.push(detail.nobukti_trip)
                            selectedRic.push(detail.nobukti_ric)
                            selectedNominal.push(detail.nominal_detail)
                            selectedDari.push(detail.dari_id)
                            selectedSampai.push(detail.sampai_id)
                        }
                    })

                    setTimeout(() => {
                        $('#modalgrid').jqGrid('setGridParam', {
                            url: `${apiUrl}pendapatansupirheader/gettrip`,
                            postData: {
                                tglsampai: $('#crudForm').find(`[name=tglsampai]`).val(),
                                tgldari: $('#crudForm').find(`[name=tgldari]`).val(),
                                supir_id: $('#crudForm').find(`[name=supir_id]`).val(),
                                sortIndex: 'nobukti_trip',
                                aksi: $('#crudForm').data('action'),
                                idPendapatan: $('#crudForm').find(`[name=id]`).val()
                            },
                            datatype: "json"
                        }).trigger('reloadGrid');

                    }, 50);
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
                        label: 'TGL TRIP',
                        name: 'tgl_trip',
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'NO BUKTI RIC',
                        name: 'nobukti_ric',
                    },
                    {
                        label: 'DARI',
                        name: 'dari',
                    },
                    {
                        label: 'dari_id',
                        name: 'dari_id',
                        hidden: true,
                        search: false
                    },
                    {
                        label: 'SAMPAI',
                        name: 'sampai',
                    },
                    {
                        label: 'sampai_id',
                        name: 'sampai_id',
                        hidden: true,
                        search: false
                    },
                    {
                        label: 'NOMINAL',
                        name: 'nominal_detail',
                        align: 'right',
                        formatter: currencyFormat,
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


    function getTrip(tgldari, tglsampai, supir_id, id) {
        return new Promise((resolve, reject) => {


            $.ajax({
                url: `${apiUrl}pendapatansupirheader/gettrip`,
                method: 'GET',
                dataType: 'JSON',
                data: {
                    limit: 0,
                    tglsampai: tglsampai,
                    tgldari: tgldari,
                    supir_id: supir_id,
                    id: id,
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
                    selectedDari = [];
                    selectedSampai = [];

                    $.each(response.data, (index, detail) => {
                        if (detail.pendapatansupir_id != 0) {

                            selectedRowsTrip.push(detail.id)
                            selectedTrip.push(detail.nobukti_trip)
                            selectedRic.push(detail.nobukti_ric)
                            selectedNominal.push(detail.nominal_detail)
                            selectedDari.push(detail.dari_id)
                            selectedSampai.push(detail.sampai_id)
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
        selectedDari = [];
        selectedSampai = [];
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
                supir_id: $('#crudForm').find(`[name=supir_id]`).val(),
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
                selectedDari = [];
                selectedSampai = [];

                selectedRowsTrip = response.data.map((data) => data.id)
                selectedTrip = response.data.map((data) => data.nobukti_trip)
                selectedRic = response.data.map((data) => data.nobukti_ric)
                selectedNominal = response.data.map((data) => data.nominal_detail)
                selectedDari = response.data.map((data) => data.dari_id)
                selectedSampai = response.data.map((data) => data.sampai_id)

                $('#modalgrid').jqGrid('setGridParam', {
                    url: `${apiUrl}pendapatansupirheader/gettrip`,
                    postData: {
                        tglsampai: $('#crudForm').find(`[name=tglsampai]`).val(),
                        tgldari: $('#crudForm').find(`[name=tgldari]`).val(),
                        supir_id: $('#crudForm').find(`[name=supir_id]`).val(),
                        id: $('#crudForm').find(`[name=id]`).val(),
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
            selectedDari.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_dari_id"]`).text())
            selectedSampai.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_sampai_id"]`).text())
        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRowsTrip.length; i++) {
                if (selectedRowsTrip[i] == value) {
                    selectedRowsTrip.splice(i, 1);
                    selectedTrip.splice(i, 1);
                    selectedRic.splice(i, 1);
                    selectedNominal.splice(i, 1);
                    selectedDari.splice(i, 1);
                    selectedSampai.splice(i, 1);
                }
            }
        }
    }

    function addRow() {
        let detailRow = $(`
      <tr>

        <td></td>
        <td>
                        <input type="hidden" name="dari_id[]">
                        <input type="text" name="dari[]" data-current-value="${detail.dari}" >
                    </td>
                    <td>
                        <input type="hidden" name="sampai_id[]">
                        <input type="text" name="sampai[]" data-current-value="${detail.sampai}" >
                    </td>
                    <td>
                        <input type="text" name="nobukti_ric[]" class="form-control">   
                    </td>
                    <td>
                        <input type="text" name="nobukti_trip[]" class="form-control">   
                    </td>
                    <td>
                        <input type="text" name="nominal_detail[]"  style="text-align:right" class="form-control autonumeric nominal" > 
                    </td>
                    <td>
                        <input type="text" name="keterangan_detail[]" class="form-control">   
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                    </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
        </td>
      </tr>
    `)

        $('#detailList tbody').append(detailRow)


        $('.kota-lookup').last().lookup({
            title: 'Kota Lookup',
            fileName: 'dari',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },


        })

        $('.kota-lookup').last().lookup({
            title: 'Kota Lookup',
            fileName: 'sampai',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },


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
        $('.supir-lookup').lookup({
            title: 'Supir Lookup',
            fileName: 'supir',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (supir, element) => {
                $('#crudForm [name=supir_id]').first().val(supir.id)
                element.val(supir.namasupir)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=supir_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

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
                $('#crudForm [name=bank_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.kota-lookup').lookup({
            title: 'Kota Lookup',
            fileName: 'dari',
            beforeProcess: function(test) {
                this.postData = {

                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (kota, element) => {
                $('#crudForm [name=dari_id]').first().val(kota.id)
                element.val(kota.kodekota)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=dari_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })


        $('.kota-lookup').lookup({
            title: 'Kota Lookup',
            fileName: 'sampai',
            beforeProcess: function(test) {
                this.postData = {

                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (kota, element) => {
                $('#crudForm [name=sampai_id]').first().val(kota.id)
                element.val(kota.kodekota)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=sampai_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }

    function setTotal() {
        let nominalDetails = $(`#table_body [name="nominal_detail[]"]`)
        let total = 0

        $.each(nominalDetails, (index, nominalDetail) => {
            total += AutoNumeric.getNumber(nominalDetail)
        });

        new AutoNumeric('#total').set(total)
    }
</script>
@endpush()