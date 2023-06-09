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
                        <div class="master">
                            <input type="hidden" name="id">

                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        NO BUKTI <span class="text-danger"></span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <input type="text" name="nobukti" class="form-control" readonly>
                                </div>

                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        TGL BUKTI <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="input-group">
                                        <input type="text" name="tglbukti" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        ABSENSI SUPIR <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="text" name="absensisupir" class="form-control absensisupir-lookup">
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

                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        NO. POL <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="hidden" name="trado_id">
                                    <input type="text" name="trado" class="form-control trado-lookup">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div id="tabs" class="dejavu" style="font-size:12px">
                                    <ul>
                                        <li><a href="#tabs-1">List Transfer</a></li>
                                        <li><a href="#tabs-2">List Adjust Transfer</a></li>
                                        <li><a href="#tabs-3">List Deposit</a></li>
                                        <li><a href="#tabs-4">List Pengembalian Pinjaman</a></li>
                                    </ul>

                                    <div id="tabs-1">
                                        <div class="table-scroll table-responsive">
                                            <table class="table table-bordered table-bindkeys" id="detailTransfer" style="width:1450px;">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th width="10%">Tanggal</th>
                                                        <th width="20%">Keterangan Transfer</th>
                                                        <th width="15%">Nilai Transfer</th>
                                                        <th width="20%">Posting ke Kas/Bank</th>
                                                        <th width="15%">No Bukti Kas/Bank</th>
                                                        <th width="5%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodyTransfer" class="form-group">
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p class="text-right font-weight-bold">TOTAL :</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-right font-weight-bold autonumeric" id="totalTransfer"></p>
                                                        </td>
                                                        <td colspan="2"></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm my-2" id="addRowTransfer">TAMBAH</button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>


                                    <div id="tabs-2">
                                        <div class="row form-group mt-3">
                                            <div class="col-md-2">
                                                <label class="col-form-label">
                                                    TGL ADJUST TRANSFER
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" name="tgladjust" class="form-control datepicker">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label class="col-form-label">
                                                    NILAI ADJUST TRANSFER
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" name="nilaiadjust" readonly class="form-control text-right">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label class="col-form-label">
                                                    KETERANGAN ADJUST TRANSFER
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" name="keteranganadjust" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border p-3 mt-3">
                                            <h6>Posting ke Kas/Bank Masuk</h6>

                                            <div class="row form-group">
                                                <div class="col-12 col-md-2">
                                                    <label class="col-form-label">
                                                        POSTING
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <input type="hidden" name="bank_idadjust">
                                                    <input type="text" name="bankadjust" class="form-control bankadjust-lookup">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-12 col-md-2">
                                                    <label class="col-form-label">
                                                        NO BUKTI BARU
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <input type="text" name="penerimaan_nobukti" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div id="tabs-3">

                                        <div class="row form-group mt-3">
                                            <div class="col-md-2">
                                                <label class="col-form-label">
                                                    NO BUKTI
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" name="nobuktideposit" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label class="col-form-label">
                                                    TANGGAL
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" name="tgldeposit" class="form-control datepicker">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label class="col-form-label">
                                                    NILAI DEPOSIT
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" name="nilaideposit" class="form-control text-right">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label class="col-form-label">
                                                    KETERANGAN
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" name="keterangandeposit" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border p-3 mt-3">
                                            <h6>Posting ke Kas/Bank Masuk</h6>

                                            <div class="row form-group">
                                                <div class="col-12 col-md-2">
                                                    <label class="col-form-label">
                                                        POSTING
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <input type="hidden" name="bank_iddeposit">
                                                    <input type="text" name="bankdeposit" class="form-control bankdeposit-lookup">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-12 col-md-2">
                                                    <label class="col-form-label">
                                                        NO BUKTI BARU
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <input type="text" name="penerimaandeposit_nobukti" id="pengeluaran_nobukti" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="tabs-4">
                                        <div class="row form-group mt-3">
                                            <div class="col-12 col-md-2">
                                                <label class="col-form-label">
                                                    POSTING
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <input type="hidden" name="bank_idpengembalian">
                                                <input type="text" name="bankpengembalian" class="form-control bankpengembalian-lookup">
                                            </div>
                                        </div>
                                        <table id="tablePengembalian"></table>
                                        <!-- <div class="table-scroll table-responsive">
                                            <table class="table table-bordered table-bindkeys" id="detailPengembalian" style="width:1450px;">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">Pilih</th>
                                                        <th width="15%">No Bukti</th>
                                                        <th width="10%">Tanggal</th>
                                                        <th width="10%">Supir</th>
                                                        <th width="10%">Jlh Pinjaman</th>
                                                        <th width="10%">Total Bayar</th>
                                                        <th width="10%">Sisa</th>
                                                        <th width="10%">Nom Bayar</th>
                                                        <th width="10%">Sisa Pinjaman</th>
                                                        <th width="10%">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodyPengembalian" class="form-group">
                                                </tbody>
                                                <tfoot id="tfootPengembalian">
                                                    <tr>
                                                        <td colspan="4"></td>
                                                        <td>
                                                            <p class="text-right font-weight-bold" id="jlhPinjaman"></p>
                                                        </td>
                                                        <td>
                                                            <p class="text-right font-weight-bold" id="ttlBayar"></p>
                                                        </td>
                                                        <td>
                                                            <p class="text-right font-weight-bold" id="sisa"></p>
                                                        </td>
                                                        <td>
                                                            <p class="text-right font-weight-bold" id="nomBayar"></p>
                                                        </td>
                                                        <td>
                                                            <p class="text-right font-weight-bold autonumeric" id="sisaPinjaman"></p>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div> -->
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

    $(document).ready(function() {

        $('#addRowTransfer').hide()
        $('#crudForm').autocomplete({
            disabled: true
        });

        $(document).on('click', "#addRowTransfer", function() {
            addRowTransfer()
        });

        $(document).on('click', '.delete-row', function(event) {
            deleteRow($(this).parents('tr'))
        })

        $(document).on('input', `#detailTransfer #tbodyTransfer [name="nilaitransfer[]"]`, function(event) {
            setTotalTransfer()
        })
        $(document).on('input', `#detailPengembalian #tbodyPengembalian [name="nombayar[]"]`, function(event) {

            let sisa = AutoNumeric.getNumber($(this).closest("tr").find(`[name="sisa[]"]`)[0])

            let bayar = $(this).val()
            bayar = parseFloat(bayar.replaceAll(',', ''));
            bayar = Number.isNaN(bayar) ? 0 : bayar
            console.log(sisa)
            if (sisa == 0) {
                let jlhPinjaman = $(this).closest("tr").find(`[name="jlhpinjaman[]"]`).val()
                jlhPinjaman = parseFloat(jlhPinjaman.replaceAll(',', ''));
                let totalSisa = jlhPinjaman - bayar

                $(this).closest("tr").find(`[name="sisapinjaman[]"]`).val(totalSisa)
            } else {
                let totalSisa = sisa - bayar
                initAutoNumeric($(this).closest("tr").find(`[name="sisapinjaman[]"]`).val(totalSisa))
            }


            // initAutoNumeric($(this).closest("tr").find(".sisa"))

            // let Sisa = $(`#table_body .sisa`)
            // let total = 0

            // $.each(Sisa, (index, SISA) => {
            //     total += AutoNumeric.getNumber(SISA)
            // });

            // new AutoNumeric('#sisaPiutang').set(total)
            setNomBayar()
            setSisaPinjaman()
        })

        $('#btnSubmit').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm').serializeArray()

            nilaiTransfer = 0
            $('#crudForm').find(`[name="nilaitransfer[]"]`).each((index, element) => {
                data.filter((row) => row.name === 'nilaitransfer[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nilaitransfer[]"]`)[index])
                nilaiTransfer = nilaiTransfer + AutoNumeric.getNumber($(`#crudForm [name="nilaitransfer[]"]`)[index])
            })
            data.filter((row) => row.name === 'nilaiadjust')[0].value = AutoNumeric.getNumber($(`#crudForm [name="nilaiadjust"]`)[0])
            data.filter((row) => row.name === 'nilaideposit')[0].value = AutoNumeric.getNumber($(`#crudForm [name="nilaideposit"]`)[0])
            nilaiDeposit = AutoNumeric.getNumber($(`#crudForm [name="nilaideposit"]`)[0])

            let selectedRowsPengembalian = $("#tablePengembalian").getGridParam("selectedRowIds");
            nilaiPinjaman = 0;
            $.each(selectedRowsPengembalian, function(index, value) {
                dataPengembalian = $("#tablePengembalian").jqGrid("getLocalRow", value);
                let selectedSisa = dataPengembalian.sisa
                let selectedNominal = (dataPengembalian.nombayar == undefined) ? 0 : dataPengembalian.nombayar;
                nilaiPinj = (isNaN(selectedNominal)) ? parseFloat(selectedNominal.replaceAll(',', '')) : selectedNominal;
                nilaiPinjaman = nilaiPinjaman + nilaiPinj
                data.push({
                    name: 'nombayar[]',
                    value: (isNaN(selectedNominal)) ? parseFloat(selectedNominal.replaceAll(',', '')) : selectedNominal
                })
                data.push({
                    name: 'sisa[]',
                    value: selectedSisa
                })
                data.push({
                    name: 'keteranganpinjaman[]',
                    value: dataPengembalian.keteranganpinjaman
                })
                data.push({
                    name: 'pengeluarantruckingheader_nobukti[]',
                    value: dataPengembalian.nobuktipengeluaran
                })
                data.push({
                    name: 'pjt_id[]',
                    value: dataPengembalian.id
                })
            });

            totalAll = nilaiTransfer + nilaiPinjaman + nilaiDeposit
            data.push({
                name: 'totalAll',
                value: totalAll
            })

            data.push({
                name: 'tglbukti',
                value: $('#crudForm').find(`[name="tglbukti"]`).val()
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
                    url = `${apiUrl}prosesuangjalansupirheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}prosesuangjalansupirheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}prosesuangjalansupirheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}prosesuangjalansupirheader`
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

                    $('#crudModal').find('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')

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

                        errors = error.responseJSON.errors
                        $(".ui-state-error").removeClass("ui-state-error");
                        $.each(errors, (index, error) => {
                            let indexes = index.split(".");
                            let angka = indexes[1]
                            selectedRowsPengembalian = $("#tablePengembalian").getGridParam("selectedRowIds");
                            let element;
                            if (indexes[0] == 'nombayar' || indexes[0] == 'keteranganpinjaman') {

                                element = $(`#tablePengembalian tr#${parseInt(selectedRowsPengembalian[angka])}`).find(`td[aria-describedby="tablePengembalian_${indexes[0]}"]`)
                                $(element).addClass("ui-state-error");
                                $(element).attr("title", error[0].toLowerCase())
                            } else if (indexes[0] == 'totalAll') {
                                return showDialog(error);
                            } else {
                                if (indexes.length > 1) {
                                    element = form.find(`[name="${indexes[0]}[]"]`)[indexes[1]];
                                } else {
                                    element = form.find(`[name="${indexes[0]}"]`)[0];
                                }
                                if ($(element).length > 0 && !$(element).is(":hidden")) {
                                    $(element).addClass("is-invalid");
                                    $(`
                                        <div class="invalid-feedback">
                                        ${error[0].toLowerCase()}
                                        </div>
                                        `).appendTo($(element).parent());
                                } else {
                                    return showDialog(error);
                                }
                            }
                        });
                    } else {
                        showDialog(error.responseJSON.message)
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

        $("#tabs").tabs();
        getMaxLength(form)
        initLookup()
        initDatepicker()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'

        $('#crudModal').find('.modal-body').html(modalBody)
    })

    // function setTotal() {
    //     let nominalDetails = $(`#table_body [name="nominal_detail[]"]`)
    //     let total = 0

    //     $.each(nominalDetails, (index, nominalDetail) => {
    //         total += AutoNumeric.getNumber(nominalDetail)
    //     });

    //     new AutoNumeric('#total').set(total)
    // }

    function setTotalTransfer() {
        let nominalDetails = $(`#detailTransfer #tbodyTransfer [name="nilaitransfer[]"]`)
        let total = 0

        $.each(nominalDetails, (index, nominalDetail) => {
            total += AutoNumeric.getNumber(nominalDetail)
        });

        new AutoNumeric('#totalTransfer').set(total)
    }

    function setNomBayar() {
        let nominalDetails = $(`#detailPengembalian #tbodyPengembalian [name="nombayar[]"]:not([disabled])`)
        let total = 0

        $.each(nominalDetails, (index, nominalDetail) => {
            total += AutoNumeric.getNumber(nominalDetail)
        });

        new AutoNumeric('#nomBayar').set(total)
    }

    function setNomBayars() {
        let nominalDetails = $(`#detailPengembalian #tbodyPengembalian [name="nombayar[]"]`)
        let total = 0

        $.each(nominalDetails, (index, nominalDetail) => {
            total += AutoNumeric.getNumber(nominalDetail)
        });

        new AutoNumeric('#nomBayar').set(total)
    }

    function setSisaPinjaman() {
        let nominalDetails = $(`#detailPengembalian #tbodyPengembalian [name="sisapinjaman[]"]`)
        let total = 0

        $.each(nominalDetails, (index, nominalDetail) => {
            total += AutoNumeric.getNumber(nominalDetail)
        });

        new AutoNumeric('#sisaPinjaman').set(total)
    }

    function createProsesUangJalanSupir() {
        let form = $('#crudForm')

        $('#crudModal').find('#crudForm').trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
        form.data('action', 'add')
        $('#crudModalTitle').text('Create Proses Uang Jalan')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        $('#table_body').html('')
        $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tgladjust]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tgldeposit]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        addRowTransfer()
        $('#addRowTransfer').show()
        initAutoNumeric(form.find(`[name="nilaideposit"]`))
        initAutoNumeric(form.find(`[name="nilaiadjust"]`))

        loadPengembalianGrid()
    }

    function editProsesUangJalanSupir(userId) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Edit Proses Uang Jalan')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        $('#detailTransfer').find("th").last().hide()
        $('#detailTransfer tfoot').find("td").last().hide()

        Promise
            .all([
                showProsesUangJalanSupir(form, userId)
            ])
            .then(() => {
                $('#crudModal').modal('show')

                form.find(`[name="tglbukti"]`).prop('readonly', true)
                form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
                form.find(`[name="tgladjust"]`).parent('.input-group').find('.input-group-append').remove()
                form.find(`[name="tgldeposit"]`).parent('.input-group').find('.input-group-append').remove()
                form.find(`[name="supir"]`).parent('.input-group').find('.button-clear').remove()
                form.find(`[name="supir"]`).parent('.input-group').find('.input-group-append').remove()
                form.find(`[name="absensisupir"]`).parent('.input-group').find('.button-clear').remove()
                form.find(`[name="absensisupir"]`).parent('.input-group').find('.input-group-append').remove()
                form.find(`[name="trado"]`).parent('.input-group').find('.button-clear').remove()
                form.find(`[name="trado"]`).parent('.input-group').find('.input-group-append').remove()
                form.find(`[name="bankadjust"]`).parent('.input-group').find('.button-clear').remove()
                form.find(`[name="bankadjust"]`).parent('.input-group').find('.input-group-append').remove()
                form.find(`[name="bankdeposit"]`).parent('.input-group').find('.button-clear').remove()
                form.find(`[name="bankdeposit"]`).parent('.input-group').find('.input-group-append').remove()
                form.find(`[name="bankpengembalian"]`).parent('.input-group').find('.button-clear').remove()
                form.find(`[name="bankpengembalian"]`).parent('.input-group').find('.input-group-append').remove()
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function deleteProsesUangJalanSupir(userId) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Delete Proses Uang Jalan')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showProsesUangJalanSupir(form, userId)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                form.find(`[name="tglbukti"]`).prop('readonly', true)
                form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
                form.find(`[name="tgladjust"]`).parent('.input-group').find('.input-group-append').remove()
                form.find(`[name="tgldeposit"]`).parent('.input-group').find('.input-group-append').remove()
                form.find(`[name="supir"]`).parent('.input-group').find('.button-clear').remove()
                form.find(`[name="supir"]`).parent('.input-group').find('.input-group-append').remove()
                form.find(`[name="absensisupir"]`).parent('.input-group').find('.button-clear').remove()
                form.find(`[name="absensisupir"]`).parent('.input-group').find('.input-group-append').remove()
                form.find(`[name="trado"]`).parent('.input-group').find('.button-clear').remove()
                form.find(`[name="trado"]`).parent('.input-group').find('.input-group-append').remove()
                form.find(`[name="bankadjust"]`).parent('.input-group').find('.button-clear').remove()
                form.find(`[name="bankadjust"]`).parent('.input-group').find('.input-group-append').remove()
                form.find(`[name="bankdeposit"]`).parent('.input-group').find('.button-clear').remove()
                form.find(`[name="bankdeposit"]`).parent('.input-group').find('.input-group-append').remove()
                form.find(`[name="bankpengembalian"]`).parent('.input-group').find('.button-clear').remove()
                form.find(`[name="bankpengembalian"]`).parent('.input-group').find('.input-group-append').remove()
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function loadPengembalianGrid() {
        $("#tablePengembalian")
            .jqGrid({
                datatype: 'local',
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                colModel: [{
                        label: "",
                        name: "",
                        width: 30,
                        formatter: 'checkbox',
                        search: false,
                        editable: false,
                        formatter: function(value, rowOptions, rowData) {
                            let disabled = '';
                            if ($('#crudForm').data('action') == 'delete' || $('#crudForm').data('action') == 'edit') {
                                disabled = 'disabled'
                            }
                            return `<input type="checkbox" value="${rowData.id}" ${disabled} onChange="checkboxPengembalianHandler(this, ${rowData.id})">`;
                        },
                    },
                    {
                        label: "id",
                        name: "id",
                        hidden: true,
                        search: false,
                    },
                    {
                        label: "no bukti pengeluaran TRUCKING",
                        width: 250,
                        name: "nobuktipengeluaran",
                        sortable: true,
                    },
                    {
                        label: "SISA",
                        name: "sisa",
                        sortable: true,
                        align: "right",
                        formatter: currencyFormat,
                    },
                    {
                        label: "NOMINAL",
                        name: "nombayar",
                        align: "right",
                        editable: true,
                        editoptions: {
                            dataInit: function(element, id) {
                                initAutoNumeric($('#crudForm').find(`[id="${id.id}"]`))
                            },
                            dataEvents: [{
                                type: "keyup",
                                fn: function(event, rowObject) {
                                    let originalGridData = $("#tablePengembalian")
                                        .jqGrid("getGridParam", "originalData")
                                        .find((row) => row.id == rowObject.rowId);

                                    let localRow = $("#tablePengembalian").jqGrid(
                                        "getLocalRow",
                                        rowObject.rowId
                                    );
                                    let totalSisa
                                    localRow.nombayar = event.target.value;
                                    let nombayar = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                                    if ($('#crudForm').data('action') == 'edit') {
                                        totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nombayar)) - nombayar
                                    } else {
                                        totalSisa = originalGridData.sisa - nombayar
                                    }

                                    $("#tablePengembalian").jqGrid(
                                        "setCell",
                                        rowObject.rowId,
                                        "sisa",
                                        totalSisa
                                    );
                                    if (totalSisa < 0) {
                                        showDialog('sisa tidak boleh minus')
                                        $("#tablePengembalian").jqGrid(
                                            "setCell",
                                            rowObject.rowId,
                                            "nombayar",
                                            0
                                        );
                                        if (originalGridData.sisa == 0) {
                                            $("#tablePengembalian").jqGrid("setCell", rowObject.rowId, "sisa", (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nombayar)));
                                        } else {
                                            $("#tablePengembalian").jqGrid("setCell", rowObject.rowId, "sisa", originalGridData.sisa);
                                        }
                                    }

                                    nombayarDetails = $(`#tablePengembalian tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tablePengembalian_nombayar"]`)
                                    ttlBayar = 0
                                    $.each(nombayarDetails, (index, nombayarDetail) => {
                                        ttlBayarDetail = parseFloat($(nombayarDetail).attr('title').replaceAll(',', ''))
                                        ttlBayars = (isNaN(ttlBayarDetail)) ? 0 : ttlBayarDetail;
                                        ttlBayar += ttlBayars
                                    });
                                    ttlBayar += nombayar
                                    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePengembalian_nombayar"]`).text(ttlBayar))

                                    // setAllTotal()
                                    setTotalSisa()
                                },
                            }, ],
                        },
                        sortable: false,
                        sorttype: "int",
                    },
                    {
                        label: "KETERANGAN",
                        name: "keteranganpinjaman",
                        sortable: false,
                        editable: false,
                        width: 500
                    },
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 400,
                rownumbers: true,
                rownumWidth: 45,
                footerrow: true,
                userDataOnFooter: true,
                toolbar: [true, "top"],
                pgbuttons: false,
                pginput: false,
                cellEdit: true,
                cellsubmit: "clientArray",
                editableColumns: ["nombayar"],
                selectedRowIds: [],
                afterRestoreCell: function(rowId, value, indexRow, indexColumn) {
                    let originalGridData = $("#tablePengembalian")
                        .jqGrid("getGridParam", "originalData")
                        .find((row) => row.id == rowId);

                    let localRow = $("#tablePengembalian").jqGrid("getLocalRow", rowId);

                    let getBayar = $("#tablePengembalian").jqGrid("getCell", rowId, "nombayar")
                    let nombayar = (getBayar != '') ? parseFloat(getBayar.replaceAll(',', '')) : 0

                    sisa = 0
                    if ($('#crudForm').data('action') == 'edit') {
                        sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nombayar)) - nombayar
                    } else {
                        sisa = originalGridData.sisa
                    }
                    console.log(indexColumn)
                    if (indexColumn == 5) {

                        $("#tablePengembalian").jqGrid(
                            "setCell",
                            rowId,
                            "sisa",
                            sisa
                            // sisa - nombayar - potongan
                        );
                    }
                    setTotalNominal()
                    setTotalSisa()
                },
                isCellEditable: function(cellname, iRow, iCol) {
                    let rowData = $(this).jqGrid("getRowData")[iRow - 1];
                    if ($('#crudForm').data('action') == 'add') {
                        return $(this)
                            .find(`tr input[value=${rowData.id}]`)
                            .is(":checked");
                    }
                },
                validationCell: function(cellobject, errormsg, iRow, iCol) {
                    console.log(cellobject);
                    console.log(errormsg);
                    console.log(iRow);
                    console.log(iCol);
                },
                loadComplete: function() {
                    setTimeout(() => {
                        $(this)
                            .getGridParam("selectedRowIds")
                            .forEach((selectedRowId) => {
                                console.log(selectedRowId)
                                $(this)
                                    .find(`tr input[value=${selectedRowId}]`)
                                    .prop("checked", true);
                                initAutoNumeric($(this).find(`td[aria-describedby="tablePengembalian_nombayar"]`))
                            });
                    }, 100);
                    setTotalNominal()
                    setTotalSisa()
                    setHighlight($(this))
                },
            })
            .jqGrid("setLabel", "rn", "No.")
            .jqGrid("navGrid", "#tablePager", {
                add: false,
                edit: false,
                del: false,
                refresh: false,
                search: false,
            })
            .jqGrid("filterToolbar", {
                searchOnEnter: false,
            })
            .jqGrid("excelLikeGrid", {
                beforeDeleteCell: function(rowId, iRow, iCol, event) {
                    let localRow = $("#tablePengembalian").jqGrid("getLocalRow", rowId);

                    $("#tablePengembalian").jqGrid(
                        "setCell",
                        rowId,
                        "sisa",
                        parseInt(localRow.sisa) + parseInt(localRow.nominal)
                    );

                    return true;
                },
            });
        /* Append clear filter button */
        loadClearFilter($('#tablePengembalian'))

        /* Append global search */
        // loadGlobalSearch($('#tablePengembalian'))
    }


    function getDataPengembalian(supirId, id) {
        aksi = $('#crudForm').data('action')

        if (aksi == 'edit') {
            url = `${apiUrl}prosesuangjalansupirheader/${id}/getPengembalian`
        } else if (aksi == 'delete') {
            url = `${apiUrl}prosesuangjalansupirheader/${id}/getPengembalian`
            attribut = 'disabled'
            forCheckbox = 'disabled'
        } else if (aksi == 'add') {
            url = `${apiUrl}prosesuangjalansupirheader/${supirId}/getPinjaman`
        }

        return new Promise((resolve, reject) => {
            $.ajax({
                url: url,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: (response) => {
                    resolve(response);
                },
            });
        });
    }

    function checkboxPengembalianHandler(element, rowId) {

        let isChecked = $(element).is(":checked");
        let editableColumns = $("#tablePengembalian").getGridParam("editableColumns");
        let selectedRowIds = $("#tablePengembalian").getGridParam("selectedRowIds");
        let originalGridData = $("#tablePengembalian")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

        editableColumns.forEach((editableColumn) => {

            if (!isChecked) {
                for (var i = 0; i < selectedRowIds.length; i++) {
                    if (selectedRowIds[i] == rowId) {
                        selectedRowIds.splice(i, 1);
                    }
                }
                sisa = 0
                if ($('#crudForm').data('action') == 'edit') {
                    sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nombayar))
                } else {
                    sisa = originalGridData.sisa
                }

                $("#tablePengembalian").jqGrid(
                    "setCell",
                    rowId,
                    "sisa",
                    sisa
                );

                $("#tablePengembalian").jqGrid("setCell", rowId, "nombayar", 0);
                setTotalNominal()
                setTotalSisa()
            } else {
                selectedRowIds.push(rowId);

                let localRow = $("#tablePengembalian").jqGrid("getLocalRow", rowId);

                if ($('#crudForm').data('action') == 'edit') {
                    localRow.nominal = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nombayar))
                }

                initAutoNumeric($(`#tablePengembalian tr#${rowId}`).find(`td[aria-describedby="tablePengembalian_nombayar"]`))
                setTotalNominal()
                setTotalSisa()
            }
        });

        $("#tablePengembalian").jqGrid("setGridParam", {
            selectedRowIds: selectedRowIds,
        });

    }

    function setTotalNominal() {
        let nominalDetails = $(`#tablePengembalian`).find(`td[aria-describedby="tablePengembalian_nombayar"]`)
        let nominal = 0
        $.each(nominalDetails, (index, nominalDetail) => {
            nominaldetail = parseFloat($(nominalDetail).text().replaceAll(',', ''))
            nominals = (isNaN(nominaldetail)) ? 0 : nominaldetail;
            nominal += nominals
        });
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePengembalian_nombayar"]`).text(nominal))
    }

    function setTotalSisa() {
        let sisaDetails = $(`#tablePengembalian`).find(`td[aria-describedby="tablePengembalian_sisa"]`)
        let sisa = 0
        $.each(sisaDetails, (index, sisaDetail) => {
            sisadetail = parseFloat($(sisaDetail).text().replaceAll(',', ''))
            sisas = (isNaN(sisadetail)) ? 0 : sisadetail;
            sisa += sisas
        });
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePengembalian_sisa"]`).text(sisa))
    }

    function cekValidasi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}prosesuangjalansupirheader/${Id}/cekvalidasi`,
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
                            editProsesUangJalanSupir(Id)
                        }
                        if (Aksi == 'DELETE') {
                            deleteProsesUangJalanSupir(Id)
                        }
                    }

                } else {
                    showDialog(response.message['keterangan'])
                }
            }
        })
    }

    function showProsesUangJalanSupir(form, userId) {
        return new Promise((resolve, reject) => {
            $('#detailList tbody').html('')

            $.ajax({
                url: `${apiUrl}prosesuangjalansupirheader/${userId}`,
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
                        } else {
                            element.val(value)
                        }

                        if (index != 'id') {
                            element.prop('readonly', true)
                        }
                    })

                    form.find(`[name="tglbukti"]`).val(dateFormat(response.data.tglbukti))
                    form.find(`[name="supir"]`).val(response.data.supir)
                    form.find(`[name="supir"]`).data('currentValue', response.data.supir)
                    form.find(`[name="trado"]`).val(response.data.trado)
                    form.find(`[name="trado"]`).data('currentValue', response.data.trado)

                    $.each(response.detail.transfer, (index, detail) => {
                        let detailRow = $(`
                        <tr>
                            <td></td>
                            <td>
                                <div class="row form-group">
                                    <div class="col-12 col-md-12">
                                        <input type="text" name="tgltransfer[]" readonly class="form-control"
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="row form-group">
                                    <div class="col-12 col-md-12">
                                        <input type="text" name="keterangantransfer[]" class="form-control">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="row form-group">
                                    <div class="col-12 col-md-12">
                                        <input type="text" name="nilaitransfer[]" readonly class="form-control autonumeric">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="row form-group">
                                    <div class="col-12 col-md-12">
                                        <input type="hidden" name="bank_idtransfer[]">
                                        <input type="text" name="banktransfer[]" readonly class="form-control">
                                    </div>
                                </div>
                            </td>
                            
                            <td>
                                <div class="row form-group">
                                    <div class="col-12 col-md-12">
                                        <input type="text" name="nobukti_kasbank[]" readonly class="form-control">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        `)

                        detailRow.find(`[name="tgltransfer[]"]`).val(dateFormat(detail.pengeluarantrucking_tglbukti))
                        detailRow.find(`[name="keterangantransfer[]"]`).val(detail.keterangan)
                        detailRow.find(`[name="nilaitransfer[]"]`).val(detail.nominal)
                        detailRow.find(`[name="banktransfer[]"]`).val(detail.bank)
                        detailRow.find(`[name="bank_idtransfer[]"]`).val(detail.pengeluarantrucking_bank_id)
                        detailRow.find(`[name="nobukti_kasbank[]"]`).val(detail.pengeluarantrucking_nobukti)

                        initAutoNumeric(detailRow.find(`[name="nilaitransfer[]"]`))
                        $('#detailTransfer #tbodyTransfer').append(detailRow)
                        initDatepicker()
                        setTotalTransfer()

                    })

                    setRowNumbers('#detailTransfer #tbodyTransfer')

                    $.each(response.detail.adjust, (index, value) => {
                        let element = form.find(`[name="${index}"]`)
                        if (element.is('select')) {
                            element.val(value).trigger('change')
                        } else {
                            element.val(value)
                        }
                        if (index == 'keteranganadjust') {
                            element.prop('readonly', false)
                        } else {
                            element.prop('readonly', true)
                        }
                    })

                    if (response.detail.deposito == null) {
                        form.find('#tabs-3 [name]').prop('readonly', true)
                    } else {
                        $.each(response.detail.deposito, (index, value) => {
                            let element = form.find(`[name="${index}"]`)
                            if (element.is('select')) {
                                element.val(value).trigger('change')
                            } else {
                                element.val(value)
                            }

                            if (index == 'keterangandeposit') {
                                element.prop('readonly', false)
                            } else {
                                element.prop('readonly', true)
                            }
                        })

                        initAutoNumeric(form.find(`[name="nilaideposit"]`))
                        form.find(`[name="tgldeposit"]`).val(dateFormat(response.detail.deposito.tgldeposit))
                        form.find(`[name="bankdeposit"]`).data('currentValue', response.detail.deposito.bankdeposit)
                    }

                    let totaljlhPinjaman = 0
                    let totalttlBayar = 0
                    let totalSisa = 0

                    initAutoNumeric(form.find(`[name="nilaiadjust"]`))
                    form.find(`[name="tgladjust"]`).val(dateFormat(response.detail.adjust.tgladjust))
                    form.find(`[name="bankadjust"]`).data('currentValue', response.detail.adjust.bankadjust)

                    loadPengembalianGrid()
                    if (response.detail.pengembalian != null) {
                        form.find(`[name="bank_idpengembalian"]`).val(response.detail.pengembalian.bank_idpengembalian)
                        form.find(`[name="bankpengembalian"]`).val(response.detail.pengembalian.bankpengembalian).prop('readonly', true)
                        form.find(`[name="bankpengembalian"]`).data('currentValue', response.detail.pengembalian.bankpengembalian)
                        getDataPengembalian(response.data.supir_id, userId).then((response) => {

                            let selectedId = []
                            let totalBayar = 0

                            $.each(response.data, (index, value) => {
                                selectedId.push(value.id)
                                totalBayar += parseFloat(value.nominal)
                            })
                            $('#tablePengembalian').jqGrid("clearGridData");
                            setTimeout(() => {

                                $("#tablePengembalian")
                                    .jqGrid("setGridParam", {
                                        datatype: "local",
                                        data: response.data,
                                        originalData: response.data,
                                        rowNum: response.data.length,
                                        selectedRowIds: selectedId
                                    })
                                    .trigger("reloadGrid");
                            }, 100);

                            initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePengembalian_nombayar"]`).text(totalBayar))

                        });
                    } else {
                        form.find('#tabs-4 [name]').prop('readonly', true)
                    }

                    form.find(`[name="bankdeposit"]`).siblings('.button-clear').remove()
                    form.find(`[name="bankdeposit"]`).siblings('.input-group-append').remove()

                    form.find(`[name="bankadjust"]`).siblings('.button-clear').remove()
                    form.find(`[name="bankadjust"]`).siblings('.input-group-append').remove()
                    form.find(`[name="bankpengembalian"]`).siblings('.button-clear').remove()
                    form.find(`[name="bankpengembalian"]`).siblings('.input-group-append').remove()



                    if (form.data('action') === 'delete') {
                        form.find('[name]').addClass('disabled')
                        initDisabled()
                    }

                    resolve()
                }
            })
        })
    }

    function addRowTransfer() {
        let detailRow = $(`
        <tr>
            <td></td>
            <td>
                <div class="row form-group">
                    <div class="col-12 col-md-12">
                        <div class="input-group">
                            <input type="text" name="tgltransfer[]" class="form-control datepicker">
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div class="row form-group">
                    <div class="col-12 col-md-12">
                        <input type="text" name="keterangantransfer[]" class="form-control">
                    </div>
                </div>
            </td>
            <td>
                <div class="row form-group">
                    <div class="col-12 col-md-12">
                        <input type="text" name="nilaitransfer[]" class="form-control autonumeric">
                    </div>
                </div>
            </td>
            <td>
                <div class="row form-group">
                    <div class="col-12 col-md-12">
                        <input type="hidden" name="bank_idtransfer[]">
                        <input type="text" name="banktransfer[]" class="form-control bank-lookup">
                    </div>
                </div>
            </td>
            
            <td>
                <div class="row form-group">
                    <div class="col-12 col-md-12">
                        <input type="text" name="nobukti_kasbank[]" readonly class="form-control">
                    </div>
                </div>
            </td>
            <td>
                <div class="btn btn-danger btn-sm delete-row">HAPUS</div>
            </td>
        </tr>
        `)


        $('#detailTransfer #tbodyTransfer').append(detailRow)
        $('.bank-lookup').last().lookup({
            title: 'Bank Lookup',
            fileName: 'bank',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (bank, element) => {
                $(`#crudForm [name="bank_idtransfer[]"]`).last().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $(`#crudForm [name="bank_idtransfer[]"]`).last().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('#crudForm').find(`[name="tgltransfer[]"]`).val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        initDatepicker();
        initAutoNumeric(detailRow.find('.autonumeric'))
        setTotalTransfer()
        setRowNumbers('#detailTransfer #tbodyTransfer')
    }


    function deleteRow(row) {
        row.remove()

        setRowNumbers()
        // setTotal()
        setTotalTransfer()
    }

    function setRowNumbers(attr) {
        let elements = $(`${attr} tr td:nth-child(1)`)

        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }

    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
            $.ajax({
                url: `${apiUrl}piutangheader/field_length`,
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
        $('.absensisupir-lookup').lookup({
            title: 'Abensi Supir Lookup',
            fileName: 'absensisupir',

            onSelectRow: (absensisupir, element) => {
                element.val(absensisupir.nobukti)

                $('#crudForm [name=nilaiadjust]').first().val(absensisupir.nominal)
                initAutoNumeric($('#crudForm [name=nilaiadjust]'))
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.trado-lookup').lookup({
            title: 'Trado Lookup',
            fileName: 'trado',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (trado, element) => {
                $('#crudForm [name=trado_id]').first().val(trado.id)
                element.val(trado.kodetrado)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=trado_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.supir-lookup').lookup({
            title: 'Supir Lookup',
            fileName: 'supir',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (supir, element) => {
                $('#crudForm [name=supir_id]').first().val(supir.id)
                element.val(supir.namasupir)
                element.data('currentValue', element.val())
                $('#tablePengembalian').jqGrid("clearGridData");
                $("#tablePengembalian")
                    .jqGrid("setGridParam", {
                        selectedRowIds: []
                    })
                    .trigger("reloadGrid");
                getDataPengembalian(supir.id).then((response) => {

                    console.log('before', $("#tablePengembalian").jqGrid('getGridParam', 'selectedRowIds'))
                    setTimeout(() => {

                        $("#tablePengembalian")
                            .jqGrid("setGridParam", {
                                datatype: "local",
                                data: response.data,
                                originalData: response.data,
                                rowNum: response.data.length,
                                selectedRowIds: []
                            })
                            .trigger("reloadGrid");
                    }, 100);

                });
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

        $('.bankadjust-lookup').lookup({
            title: 'Bank Lookup',
            fileName: 'bank',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (bank, element) => {
                $('#crudForm [name=bank_idadjust]').first().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="bank_idadjust"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })

        $('.bankdeposit-lookup').lookup({
            title: 'Bank Lookup',
            fileName: 'bank',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (bank, element) => {
                $('#crudForm [name=bank_iddeposit]').first().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="bank_iddeposit"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
        $('.bankpengembalian-lookup').lookup({
            title: 'Bank Lookup',
            fileName: 'bank',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (bank, element) => {
                $('#crudForm [name=bank_idpengembalian]').first().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="bank_idpengembalian"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()