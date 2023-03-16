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
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    NO BUKTI <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="text" name="nobukti" class="form-control" readonly>
                            </div>

                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    TANGGAL BUKTI <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="input-group">
                                    <input type="text" name="tglbukti" autocomplete="off" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    PERIODE <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-10">

                                <div class="input-group">
                                    <input type="text" name="periode" autocomplete="off" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    TGL DARI <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="input-group">
                                    <input type="text" name="tgldari" class="form-control datepicker" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    TANGGAL SAMPAI <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="input-group">
                                    <input type="text" name="tglsampai" class="form-control datepicker" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 col-md-2 ">
                                <button class="btn btn-secondary" id="btnTampil">RELOAD</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div id="tabs" class="dejavu">
                                    <ul>
                                        <li><a href="#tabs-1">Rekap Rincian</a></li>
                                        <li><a href="#tabs-2">Pot. pinjaman (semua)</a></li>
                                        <li><a href="#tabs-3">Pot. pinjaman (pribadi)</a></li>
                                        <li><a href="#tabs-4">deposito</a></li>
                                        <li><a href="#tabs-5">bbm</a></li>
                                        <li><a href="#tabs-6">pinjaman pribadi</a></li>
                                    </ul>
                                    <div id="tabs-1">
                                        <table id="rekapRincian"></table>
                                    </div>
                                    <div id="tabs-2">
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    NO BUKTI</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nobuktiPS" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Tanggal Bukti</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="tglbuktiPS" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Nominal</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nomPS" class="form-control text-right" readonly>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Keterangan</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="ketPS" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    KAS/BANK</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="hidden" name="bank_idPS">
                                                <input type="text" name="bankPS" class="form-control bankPS-lookup">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tabs-3">
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    NO BUKTI</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nobuktiPP" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Tanggal Bukti</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="tglbuktiPP" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Nominal</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nomPP" class="form-control text-right" readonly>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Keterangan</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="ketPP" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    KAS/BANK</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="hidden" name="bank_idPP">
                                                <input type="text" name="bankPP" class="form-control bankPP-lookup">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tabs-4">
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    NO BUKTI</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nobuktiDeposito" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Tanggal Bukti</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="tglbuktiDeposito" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Nominal</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nomDeposito" class="form-control text-right" readonly>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Keterangan</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="ketDeposito" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    KAS/BANK</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="hidden" name="bank_idDeposito">
                                                <input type="text" name="bankDeposito" class="form-control bankDeposito-lookup">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tabs-5">
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    NO BUKTI</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nobuktiBBM" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Tanggal Bukti</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="tglbuktiBBM" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Nominal</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nomBBM" class="form-control text-right" readonly>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Keterangan</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="ketBBM" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    KAS/BANK</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="hidden" name="bank_idBBM">
                                                <input type="text" name="bankBBM" class="form-control bankBBM-lookup">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tabs-6">
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    NO BUKTI</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nobuktiPinjaman" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Tanggal Bukti</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="tglbuktiPinjaman" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Nominal</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nomPinjaman" class="form-control text-right" readonly>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Keterangan</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="ketPinjaman" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    KAS/BANK</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="hidden" name="bank_idPinjaman">
                                                <input type="text" name="bankPinjaman" class="form-control bankPinjaman-lookup">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Simpan
                        </button>
                        <button id="btnBatal" class="btn btn-secondary" data-dismiss="modal">
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
    let selectedRows = [];

    function checkboxHandler(element) {
        let value = $(element).val();
        if (element.checked) {
            selectedRows.push($(element).val())
        } else {
            for (var i = 0; i < selectedRows.length; i++) {
                if (selectedRows[i] == value) {
                    selectedRows.splice(i, 1);
                }
            }
        }
    }
    $(document).ready(function() {

        $('#btnSubmit').click(function(event) {

            let method
            let url
            let form = $('#crudForm')


            event.preventDefault()

            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            let data = [];

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
                name: 'tgldari',
                value: form.find(`[name="tgldari"]`).val()
            })
            data.push({
                name: 'tglsampai',
                value: form.find(`[name="tglsampai"]`).val()
            })

            $.each(selectedRows, function(index, item) {
                data.push({
                    name: 'rincianId[]',
                    value: item
                })
            });
            
            data.push({
                name: 'bank_idPS',
                value: form.find(`[name="bank_idPS"]`).val()
            })
            
            data.push({
                name: 'bank_idPP',
                value: form.find(`[name="bank_idPP"]`).val()
            })
            data.push({
                name: 'bank_idDeposito',
                value: form.find(`[name="bank_idDeposito"]`).val()
            })
            data.push({
                name: 'bank_idBBM',
                value: form.find(`[name="bank_idBBM"]`).val()
            })
            data.push({
                name: 'bank_idPinjaman',
                value: form.find(`[name="bank_idPinjaman"]`).val()
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

            console.log(data);

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}prosesgajisupirheader`
                    break;
                    // case 'edit':
                    //     method = 'PATCH'
                    //     url = `${apiUrl}prosesgajisupirheader/${Id}`
                    //     break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}prosesgajisupirheader/${Id}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}prosesgajisupirheader`
                    break;
            }

            $(this).attr('disabled', '')
            $('#loader').removeClass('d-none')

            if (action == 'edit') {
                $.ajax({
                    url: `${apiUrl}prosesgajisupirheader/noEdit`,
                    method: 'POST',
                    dataType: 'JSON',
                    beforeSend: request => {
                        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
                    },
                    success: response => {

                        showDialog(response.message)
                    }
                }).always(() => {
                    $('#loader').addClass('d-none')
                    $(this).removeAttr('disabled')
                })

            } else {
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
                        $('#crudModal').find('#crudForm').trigger('reset')
                        $('#crudModal').modal('hide')
                        $('#jqGrid').jqGrid('setGridParam', {
                            page: response.data.page
                        }).trigger('reloadGrid');
                        selectedRows = []
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
                            showDialog(error.statusText)
                        }
                    },
                }).always(() => {
                    $('#loader').addClass('d-none')
                    $(this).removeAttr('disabled')
                })

            }

        })
    })

    $('#crudModal').on('shown.bs.modal', () => {
        let form = $('#crudForm')

        $("#tabs").tabs()
        setFormBindKeys(form)

        activeGrid = null
        initLookup()
        initDatepicker()
        getMaxLength(form)
        initAutoNumeric()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'

        $('#crudModal').find('.modal-body').html(modalBody)
    })


    function rekapRincian(url) {
        $("#rekapRincian").jqGrid({
                url: `${apiUrl}prosesgajisupirheader/${url}`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "json",
                colModel: [{
                        label: 'Pilih',
                        name: 'idric',
                        index: 'Pilih',
                        formatter: (value) => {
                            return `<input type="checkbox" value="${value}" onchange="checkboxHandler(this)">`
                        },
                        editable: true,
                        edittype: 'checkbox',
                        search: false,
                        width: 60,
                        align: 'center',
                        formatoptions: {
                            disabled: false
                        },
                    },
                    {
                        label: 'ID',
                        name: 'idric',
                        align: 'right',
                        width: '50px',
                        hidden: true
                    },
                    {
                        label: 'NO. BUKTI',
                        name: 'nobuktiric',
                        align: 'left'
                    },
                    {
                        label: 'TANGGAL BUKTI',
                        name: 'tglbuktiric',
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'SUPIR',
                        name: 'supir_id',
                        align: 'left'
                    },
                    {
                        label: 'DARI',
                        name: 'tgldariric',
                        align: 'left'
                    },
                    {
                        label: 'SAMPAI',
                        name: 'tglsampairic',
                        align: 'left'
                    },
                    {
                        label: 'NOMINAL',
                        name: 'nominal',
                        formatter: currencyFormat,
                        align: "right",
                    },
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 350,
                rowNum: 10,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                footerrow: true,
                userDataOnFooter: true,
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
                loadBeforeSend: (jqXHR) => {
                    jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
                },

                onSelectRow: function(id) {

                    activeGrid = $(this)
                    indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
                    page = $(this).jqGrid('getGridParam', 'page')
                    let limit = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))


                },
                loadComplete: function(data) {
                    changeJqGridRowListText()

                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    $.each(selectedRows, function(key, value) {

                        $('#rekapRincian tbody tr').each(function(row, tr) {
                            if ($(this).find(`td input:checkbox`).val() == value) {
                                $(this).find(`td input:checkbox`).prop('checked', true)
                            }
                        })

                    });

                    /* Set global variables */
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

                    setTimeout(function() {

                        if (triggerClick) {
                            if (id != '') {
                                indexRow = parseInt($('#rekapRincian').jqGrid('getInd', id)) - 1
                                $(`#rekapRincian [id="${$('#rekapRincian').getDataIDs()[indexRow]}"]`).click()
                                id = ''
                            } else if (indexRow != undefined) {
                                $(`#rekapRincian [id="${$('#rekapRincian').getDataIDs()[indexRow]}"]`).click()
                            }

                            if ($('#rekapRincian').getDataIDs()[indexRow] == undefined) {
                                $(`#rekapRincian [id="` + $('#rekapRincian').getDataIDs()[0] + `"]`).click()
                            }

                            triggerClick = false
                        } else {
                            $('#rekapRincian').setSelection($('#rekapRincian').getDataIDs()[indexRow])
                        }
                    }, 100)


                    setHighlight($(this))

                    if (data.attributes) {

                        $('#rekapRincian tbody tr').find(`td input:checkbox`).prop('checked', false);
                        selectedRows = [];
                        $('#rekapRincian tbody tr').each(function(row, tr) {
                            $(this).find(`td input:checkbox`).click()
                        })
                        $(this).jqGrid('footerData', 'set', {
                            nominal: data.attributes.totalNominal,
                        }, true)
                    }
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
                    clearGlobalSearch($('#rekapRincian'))
                },
            })

            .customPager({})



        /* Append clear filter button */
        loadClearFilter($('#rekapRincian'))

        /* Append global search */
        loadGlobalSearch($('#rekapRincian'))
    }



    function createProsesGajiSupirHeader() {
        let form = $('#crudForm')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Simpan
        `)

        form.data('action', 'add')
        $('#crudModalTitle').text('Add Proses Gaji Supir')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tgldari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglbuktiPS]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglbuktiPP]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglbuktiDeposito]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglbuktiBBM]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglbuktiPinjaman]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        rekapRincian('getRic')
        initDatepicker()
        // form.find(`[name="subnominal"]`).addClass('disabled')
    }

    function editProsesGajiSupirHeader(Id) {
        let form = $('#crudForm')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Simpan
        `)
        $('#crudModalTitle').text('Edit Proses Gaji Supir')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        showProsesGajiSupir(form, Id, 'edit')
        form.find('#btnTampil').prop('disabled', true)
    }

    function deleteProsesGajiSupirHeader(Id) {
        let form = $('#crudForm')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Hapus
        `)
        $('#crudModalTitle').text('Delete Proses Gaji Supir')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        showProsesGajiSupir(form, Id, 'delete')
        form.find('#btnTampil').prop('disabled', true)

    }

    function cekValidasi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}prosesgajisupirheader/${Id}/cekvalidasi`,
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
                            editProsesGajiSupirHeader(Id)
                        }
                        if (Aksi == 'DELETE') {
                            deleteProsesGajiSupirHeader(Id)
                        }
                    }

                } else {
                    showDialog(response.message['keterangan'])
                }
            }
        })
    }

    function showProsesGajiSupir(form, gajiId, aksi) {
        console.log(apiUrl)
        $.ajax({
            url: `${apiUrl}prosesgajisupirheader/${gajiId}`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: response => {
                $.each(response.data, (index, value) => {
                    let element = form.find(`[name="${index}"]`)

                    form.find(`[name="${index}"]`).val(value)

                    if (element.hasClass('datepicker')) {
                        element.val(dateFormat(value))
                    }

                })


                form.find('[name]').addClass('disabled')
                initDisabled()
                getEdit(gajiId, aksi)
            }
        })
    }

    $(document).on('click', '#btnTampil', function(event) {
        event.preventDefault()
        let form = $('#crudForm')
        let data = []
        let tglDari = form.find(`[name="tgldari"]`).val()
        let tglSampai = form.find(`[name="tglsampai"]`).val()
        let action = form.data('action')
        $('#rekapRincian').jqGrid('setGridParam', {
            postData: {
                dari: $('#crudForm').find('[name=tgldari]').val(),
                sampai: $('#crudForm').find('[name=tglsampai]').val(),
                aksi: action
            },
        }).trigger('reloadGrid');
        getAllData(tglDari,tglSampai);
    })

    function getAllData(dari,sampai)
    {
        $.ajax({
            url: `${apiUrl}prosesgajisupirheader/${dari}/${sampai}/getAllData`,
            method: 'GET',
            dataType: 'JSON',
            data: {
                limit: 0
            },
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: response => {
                initAutoNumeric($('#crudForm').find(`[name="nomPS"]`).val(response.potsemua))
                initAutoNumeric($('#crudForm').find(`[name="nomPP"]`).val(response.potpribadi))
                initAutoNumeric($('#crudForm').find(`[name="nomDeposito"]`).val(response.deposito))
                initAutoNumeric($('#crudForm').find(`[name="nomBBM"]`).val(response.bbm))
                initAutoNumeric($('#crudForm').find(`[name="nomPinjaman"]`).val(response.pinjaman))
            }
        })
    }

    function getPotPinjaman(dari,sampai)
    {
        $.ajax({
            url: `${apiUrl}prosesgajisupirheader/${dari}/${sampai}/getPotPinjaman`,
            method: 'GET',
            dataType: 'JSON',
            data: {
                limit: 0
            },
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: response => {

            }
        })
    }

    function getDepo(dari,sampai)
    {
        $.ajax({
            url: `${apiUrl}prosesgajisupirheader/${dari}/${sampai}/getDepo`,
            method: 'GET',
            dataType: 'JSON',
            data: {
                limit: 0
            },
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: response => {

            }
        })
    }


    function getEdit(gajiId, aksi) {
        $('#gajiSupir').html('')
        $('#gajiKenek').html('')
        $.ajax({
            url: `${apiUrl}prosesgajisupirheader/${gajiId}/getEdit`,
            method: 'GET',
            dataType: 'JSON',
            data: {
                limit: 0
            },
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: response => {

                let nominal = 0
                $.each(response.data, (index, detail) => {
                    nominal = parseFloat(nominal) + parseFloat(detail.nominal)

                    let detailRow = $(`
                        <tr >
                                <td><input name='ric_id[]' type="checkbox" class="checkItem" value="${detail.id}" disabled checked></td>
                                <td>${detail.nobukti}</td>
                                <td>${detail.tglbukti}</td>
                                <td>${detail.namasupir}</td>
                                <td>${detail.tgldari}</td>
                                <td>${detail.tglsampai}</td>
                                <td class="nominal text-right">${detail.nominal}</td>
                            </tr>
                        `)

                    $('#ricList tbody').append(detailRow)
                    initAutoNumeric(detailRow.find('.nominal'))
                })

                $('#nominal').append(`${nominal}`)

                initAutoNumeric($('#ricList tfoot').find('#nominal'))

            }
        })
    }

    $(document).on('click', `#ricList tbody [name="ric_id[]"]`, function() {
            let tdNominal = $(this).closest('tr').find('td.nominal').text()
            tdNominal = parseFloat(tdNominal.replaceAll(',', ''));

            console.log(tdNominal)
            let allNominal = $('#nominal').text()
            allNominal = parseFloat(allNominal.replaceAll(',', ''));
            let nominal = 0

            if ($(this).prop("checked") == true) {
                allNominal = allNominal + tdNominal
            } else {
                allNominal = allNominal - tdNominal
            }
            $('#nominal').html('')
            $('#nominal').append(`${allNominal}`)
            initAutoNumeric($('#ricList tfoot').find('#nominal'))
        }

    )

    function setRowNumbers() {
        let elements = $('#detailList tbody tr td:nth-child(2)')

        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }

    $("#checkAll").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
        console.log($('#crudForm input:checkbox').find(`[name="sp_id[]"]`).val())
    });

    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
            $.ajax({
                url: `${apiUrl}prosesgajisupirheader/field_length`,
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

        $('.bankPS-lookup').lookup({
            title: 'Bank Lookup',
            fileName: 'bank',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',

                }
            },
            onSelectRow: (bank, element) => {
                $('#crudForm [name=bank_idPS]').first().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=bank_idPS]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        $('.bankPP-lookup').lookup({
            title: 'Bank Lookup',
            fileName: 'bank',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',

                }
            },
            onSelectRow: (bank, element) => {
                $('#crudForm [name=bank_idPP]').first().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=bank_idPP]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        $('.bankDeposito-lookup').lookup({
            title: 'Bank Lookup',
            fileName: 'bank',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',

                }
            },
            onSelectRow: (bank, element) => {
                $('#crudForm [name=bank_idDeposito]').first().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=bank_idDeposito]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        $('.bankBBM-lookup').lookup({
            title: 'Bank Lookup',
            fileName: 'bank',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',

                }
            },
            onSelectRow: (bank, element) => {
                $('#crudForm [name=bank_idBBM]').first().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=bank_idBBM]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        $('.bankPinjaman-lookup').lookup({
            title: 'Bank Lookup',
            fileName: 'bank',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',

                }
            },
            onSelectRow: (bank, element) => {
                $('#crudForm [name=bank_idPinjaman]').first().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=bank_idPinjaman]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()