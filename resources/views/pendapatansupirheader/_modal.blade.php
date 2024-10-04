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

                        <div class="row form-group supir">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    SUPIR
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="supir_id">
                                <input type="text" name="supir" id="supir" class="form-control supir-lookup">
                            </div>
                        </div>




                        <!-- 
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
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    BANK <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="bank_id">
                                <input type="text" name="bank" id="bank" class="form-control bank-lookup">
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
                        <div class="row">
                            <div class="col-12">
                                <div id="tabsModal" class="dejavu" style="font-size:12px">
                                    <ul>
                                        <li><a href="#tabsModal-1">Komisi Supir</a></li>
                                        <li class="deposito"><a href="#tabsModal-2">Deposito</a></li>
                                        <li class="pinjaman"><a href="#tabsModal-3">Pot. pinjaman</a></li>
                                    </ul>
                                    <div id="tabsModal-1">
                                        <div class="row form-group mb-3">
                                            <div class="col-12 col-md-2">
                                                <label class="col-form-label">
                                                    NO BUKTI KAS/BANK KELUAR </label>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <input type="text" name="pengeluaran_nobukti" id="pengeluaran_nobukti" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <table id="modalgrid"></table>
                                    </div>

                                    <div id="tabsModal-2">
                                        <div class="row form-group mb-3">
                                            <div class="col-12 col-md-2">
                                                <label class="col-form-label">
                                                    NO BUKTI KAS/BANK MASUK </label>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <input type="text" name="penerimaan_deposito" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <table id="tableDeposito"></table>
                                    </div>

                                    <div id="tabsModal-3">
                                        <div class="row form-group mb-3">
                                            <div class="col-12 col-md-2">
                                                <label class="col-form-label">
                                                    NO BUKTI KAS/BANK MASUK </label>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <input type="text" name="penerimaan_pinjaman" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <table id="tablePinjaman"></table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Save
                        </button>
                        <button id="btnSaveAdd" class="btn btn-success">
                            <i class="fas fa-file-upload"></i>
                            Save & Add
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
    let hasFormBindKeys = false
    let modalBody = $('#crudModal').find('.modal-body').html()

    let selectedRowsTrip = []
    let selectedTrip = [];
    let selectedRic = [];
    let selectedNominal = [];
    let selectedGajiKenek = [];
    let selectedDari = [];
    let selectedSampai = [];
    let selectedSupirId = [];
    let selectedKeterangan = [];

    let sortnameTrip = 'nobukti_trip';
    let sortorderTrip = 'asc';
    let pageTrip = 0;
    let totalRecordTrip
    let limitTrip
    let postDataTrip
    let triggerClickTrip
    let indexRowTrip
    let isEditTgl

    $(document).ready(function() {

        $('#crudForm').autocomplete({
            disabled: true
        });





        $(document).on('click', '#btnTampil', function(event) {


            let tgldari = $('#crudForm').find(`[name=tgldari]`).val()
            let tglsampai = $('#crudForm').find(`[name=tglsampai]`).val()
            let supir_id = $('#crudForm').find(`[name=supir_id]`).val()
            let id = $('#crudForm').find(`[name=id]`).val()
            if (supir_id == '') {
                supir_id = 0;
            }
            if ((tgldari != '') && (tglsampai != '')) {
                $('#gsTrip').prop("checked", false)

                $('#loaderGrid').removeClass('d-none')
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
                        $('#loaderGrid').addClass('d-none')
                        if (error.status === 422) {
                            $('.is-invalid').removeClass('is-invalid')
                            $('.invalid-feedback').remove()

                            setErrorMessages(form, error.responseJSON.errors);
                        } else {
                            showDialog(error.responseJSON)
                        }
                    })
                // if (isDeposito == 'YA') {

                //     getDataPinjaman().then((response) => {
                //         $("#tablePinjaman")[0].p.selectedRowIds = [];
                //         if ($('#crudForm').data('action') == 'add') {
                //             selectedRowId = [];
                //         } else {
                //             selectedRowId = response.selectedId;
                //         }
                //         setTimeout(() => {

                //             $("#tablePinjaman")
                //                 .jqGrid("setGridParam", {
                //                     datatype: "local",
                //                     data: response.data,
                //                     originalData: response.data,
                //                     rowNum: response.data.length,
                //                     selectedRowIds: selectedRowId
                //                 })
                //                 .trigger("reloadGrid");
                //         }, 100);
                //     });
                // }
            }

        })

        $('#btnSubmit').click(function(event) {
            event.preventDefault()
            submit($(this).attr('id'))
        })
        $('#btnSaveAdd').click(function(event) {
            event.preventDefault()
            submit($(this).attr('id'))
        })

        function submit(button) {
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
            data.push({
                name: 'jumlahdetail',
                value: selectedRowsTrip.length
            })
            data.push({
                name: 'aksi',
                value: action.toUpperCase()
            })

            // data.push({
            //     name: 'periode',
            //     value: form.find(`[name="periode"]`).val()
            // })

            let nominalTrip = [];
            let kenekTrip = [];
            $.each(selectedNominal, function(index, item) {
                if (item != undefined) {
                    nominalTrip.push(parseFloat(item.replaceAll(',', '')))
                }
            });
            $.each(selectedGajiKenek, function(index, item) {
                kenekTrip.push(parseFloat(item.replaceAll(',', '')))
            });

            let requestDataTrip = {
                'id_detail': selectedRowsTrip,
                'nobukti_trip': selectedTrip,
                'nobukti_ric': selectedRic,
                'dari_id': selectedDari,
                'sampai_id': selectedSampai,
                'nominal_detail': nominalTrip,
                'gajikenek': kenekTrip,
                'supirtrip': selectedSupirId
            };

            data.push({
                name: 'detail',
                value: JSON.stringify(requestDataTrip)
            })
            // DEPOSITO

            let selectedRowsDepo = $(`#tableDeposito`).getGridParam("selectedRowIds");
            $.each(selectedRowsDepo, function(index, value) {
                dataDepo = $(`#tableDeposito`).jqGrid("getLocalRow", value);
                let selectedNominal = (dataDepo.nominal == undefined) ? 0 : dataDepo.nominal;
                if (selectedNominal != 0) {

                    data.push({
                        name: 'nominal_depo[]',
                        value: (isNaN(selectedNominal)) ? parseFloat(selectedNominal.replaceAll(',', '')) : selectedNominal
                    })
                    data.push({
                        name: 'supir_depo[]',
                        value: dataDepo.supir_id
                    })
                    data.push({
                        name: 'keterangan_depo[]',
                        value: 'DEPOSITO ' + dataDepo.supirdeposito
                    })
                }
            })

            // potongan pinjaman
            let selectedRowsPinjaman = $("#tablePinjaman").getGridParam("selectedRowIds");
            $.each(selectedRowsPinjaman, function(index, value) {
                dataPinjaman = $("#tablePinjaman").jqGrid("getLocalRow", value);
                let selectedSisaPP = dataPinjaman.pinj_sisa
                let selectedNominalPP = (dataPinjaman.pinj_nominal == undefined) ? 0 : dataPinjaman.pinj_nominal;
                if (selectedNominalPP != 0) {
                    data.push({
                        name: 'pinj_nominal[]',
                        value: (isNaN(selectedNominalPP)) ? parseFloat(selectedNominalPP.replaceAll(',', '')) : selectedNominalPP
                    })
                    data.push({
                        name: 'pinj_sisa[]',
                        value: selectedSisaPP
                    })
                    data.push({
                        name: 'pinj_keterangan[]',
                        value: dataPinjaman.pinj_keterangan
                    })
                    data.push({
                        name: 'pinj_supir[]',
                        value: dataPinjaman.pinj_supirid
                    })
                    data.push({
                        name: 'pinj_nobukti[]',
                        value: dataPinjaman.pinj_nobukti
                    })
                    data.push({
                        name: 'pinj_id[]',
                        value: dataPinjaman.pinj_id
                    })
                }
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
            data.push({
                name: 'aksi',
                value: action.toUpperCase()
            })

            data.push({
                name: 'tgldariheader',
                value: $('#tgldariheader').val()
            })
            data.push({
                name: 'tglsampaiheader',
                value: $('#tglsampaiheader').val()
            })
            data.push({
                name: 'button',
                value: button
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

                    $('#crudModal').find('#crudForm').trigger('reset')
                    id = response.data.id
                    if (button == 'btnSubmit') {
                        $('#crudModal').modal('hide')
                        selectedRowsTrip = []
                        selectedTrip = [];
                        selectedRic = [];
                        selectedNominal = [];
                        selectedDari = [];
                        selectedSampai = [];
                        selectedGajiKenek = [];
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
                    } else {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        $('#crudForm').find('input[type="text"]').data('current-value', '')
                        // showSuccessDialog(response.message, response.data.nobukti)

                        $("#tableDeposito")[0].p.selectedRowIds = [];
                        $('#tableDeposito').jqGrid("clearGridData");
                        $("#tableDeposito")
                            .jqGrid("setGridParam", {
                                selectedRowIds: []
                            })
                            .trigger("reloadGrid");

                        $("#tablePinjaman")[0].p.selectedRowIds = [];
                        $('#tablePinjaman').jqGrid("clearGridData");
                        $("#tablePinjaman")
                            .jqGrid("setGridParam", {
                                selectedRowIds: []
                            })
                            .trigger("reloadGrid");
                        createPendapatanSupir()
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
        }
    })

    $(document).on("change", `[name=tglbukti]`, function(event) {
        if (isDeposito == 'YA') {

            $('#btnSubmit').prop('disabled', true)
            $('#btnSaveAdd').prop('disabled', true)
            $("#tablePinjaman")[0].p.selectedRowIds = [];
            $('#tablePinjaman').jqGrid("clearGridData");
            $("#tablePinjaman")
                .jqGrid("setGridParam", {
                    selectedRowIds: []
                })
                .trigger("reloadGrid");
            getDataPinjaman().then((response) => {
                $("#tablePinjaman")[0].p.selectedRowIds = [];
                if ($('#crudForm').data('action') == 'add') {
                    selectedRowId = [];
                } else {
                    selectedRowId = response.selectedId;
                }
                setTimeout(() => {

                    $("#tablePinjaman")
                        .jqGrid("setGridParam", {
                            datatype: "local",
                            data: response.data,
                            originalData: response.data,
                            rowNum: response.data.length,
                            selectedRowIds: selectedRowId
                        })
                        .trigger("reloadGrid");

                    $('#btnSubmit').prop('disabled', false)
                    $('#btnSaveAdd').prop('disabled', false)
                }, 100);
            });

        }
    })

    $('#crudModal').on('shown.bs.modal', () => {
        let form = $('#crudForm')
        $("#tabsModal").tabs()
        setFormBindKeys(form)
        if (form.data('action') == 'add') {
            form.find('#btnSaveAdd').show()
        } else {
            form.find('#btnSaveAdd').hide()
        }
        activeGrid = null

        getMaxLength(form)
        initDatepicker()
        initLookup()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        removeEditingBy($('#crudForm').find('[name=id]').val())
        $('#crudModal').find('.modal-body').html(modalBody)
        clearSelectedRowsTrip()
        initDatepicker('datepickerIndex')
    })

    function removeEditingBy(id) {
        let formData = new FormData();


        formData.append('id', id);
        formData.append('aksi', 'BATAL');
        formData.append('table', 'pendapatansupirheader');

        fetch(`{{ config('app.api_url') }}removeedit`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                },
                body: formData,
                keepalive: true

            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                $("#crudModal").modal("hide");
            })
            .catch(error => {
                // Handle error
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                    setErrorMessages(form, error.responseJSON.errors);
                } else {
                    showDialog(error.responseJSON);
                }
            })
    }

    function createPendapatanSupir() {
        let form = $('#crudForm')

        $('#crudModal').find('#crudForm').trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
        form.data('action', 'add')

        $('#crudModalTitle').text('Add Komisi Supir')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        loadModalGrid()
        if (isDeposito == 'YA') {

            loadDepositoGrid()
            loadPinjamanGrid()

            getDataDeposito().then((response) => {
                let selectedIdDepo = []

                $.each(response.data, (index, value) => {
                    selectedIdDepo.push(value.id)
                })
                $('#tableDeposito').jqGrid("clearGridData");
                setTimeout(() => {

                    $("#tableDeposito")
                        .jqGrid("setGridParam", {
                            datatype: "local",
                            data: response.data,
                            originalData: response.data,
                            rowNum: response.data.length,
                            selectedRowIds: selectedIdDepo
                        })
                        .trigger("reloadGrid");
                }, 100);
                initAutoNumeric($('.footrow').find(`td[aria-describedby="tableDeposito_nominal"]`).text(0))

            });
        }
        let today = new Date();
        let firstDay = new Date(today.getFullYear(), today.getMonth(), 1);

        Promise
            .all([
                showDefault(form),
                setTampilan()
            ])
            .then(() => {
                if (selectedRows.length > 0) {
                    clearSelectedRows()
                }
                $('#crudModal').modal('show')
                $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
                // $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
                $('#crudForm').find('[name=tgldari]').val($.datepicker.formatDate('dd-mm-yy', firstDay)).trigger('change');
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
      Save
    `)
        $('#crudModalTitle').text('Edit komisi Supir')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        loadModalGrid()
        Promise
            .all([
                setTampilan(),
                setTglBukti(form),
                showPendapatanSupir(form, pendapatanId)
            ])
            .then(() => {
                if (selectedRows.length > 0) {
                    clearSelectedRows()
                }
                $('#crudModal').modal('show')
                if (isEditTgl == 'TIDAK') {
                    form.find(`[name="tglbukti"]`).prop('readonly', true)
                    form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
                }

                if (isBank == 'YA') {

                    supir = $('#crudForm').find(`[name="supir"]`).parents('.input-group')
                    supir.find('.button-clear').attr('disabled', true)
                    supir.children().find('.lookup-toggler').attr('disabled', true)

                    bank = $('#crudForm').find(`[name="bank"]`).parents('.input-group')
                    bank.find('.button-clear').attr('disabled', true)
                    bank.children().find('.lookup-toggler').attr('disabled', true)

                }
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
      <i class="fa fa-trash"></i>
              Delete
    `)
        $('#crudModalTitle').text('Delete komisi Supir')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        loadModalGrid()
        Promise
            .all([
                setTampilan(),
                showPendapatanSupir(form, pendapatanId)
            ])
            .then(() => {
                if (selectedRows.length > 0) {
                    clearSelectedRows()
                }
                $('#crudModal').modal('show')
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })

    }

    function viewPendapatanSupir(pendapatanId) {

        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'view')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
          <i class="fa fa-save"></i>
          Save
        `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('View komisi Supir')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        loadModalGrid()
        Promise
            .all([
                setTampilan(),
                showPendapatanSupir(form, pendapatanId)
            ])
            .then(() => {
                if (selectedRows.length > 0) {
                    clearSelectedRows()
                }
                $('#crudModal').modal('show')
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
            data: {
                aksi: Aksi
            },
            success: response => {
                var error = response.error
                if (error) {
                    showDialog(response)
                } else {
                    if (Aksi == 'PRINTER BESAR') {
                        window.open(`{{ route('pendapatansupirheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
                    } else if (Aksi == 'PRINTER KECIL') {
                        window.open(`{{ route('pendapatansupirheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
                    } else {
                        cekValidasiAksi(Id, Aksi)
                    }
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
                            if (isBank == 'YA') {
                                form.find('[name=bank]').attr('readonly', true)
                            }
                            element.data('current-value', value)
                        }
                    })
                    let totalNominal = 0;
                    let totalKenek = 0;
                    $.each(response.detail, (index, detail) => {

                        if (detail.pendapatansupir_id != 0) {

                            totalNominal += parseFloat(detail.nominal_detail)
                            totalKenek += parseFloat(detail.gajikenek)
                            selectedRowsTrip.push(detail.id)
                            selectedTrip.push(detail.nobukti_trip)
                            selectedRic.push(detail.nobukti_ric)
                            selectedNominal.push(detail.nominal_detail)
                            selectedGajiKenek.push(detail.gajikenek)
                            selectedDari.push(detail.dari_id)
                            selectedSampai.push(detail.sampai_id)
                            selectedSupirId.push(detail.supir_id)
                        }
                    })

                    supir_id = $('#crudForm').find(`[name=supir_id]`).val()
                    if (supir_id == '') {
                        supir_id = 0;
                    }
                    setTimeout(() => {
                        $('#modalgrid').jqGrid('setGridParam', {
                            url: `${apiUrl}pendapatansupirheader/gettrip`,
                            postData: {
                                tglsampai: $('#crudForm').find(`[name=tglsampai]`).val(),
                                tgldari: $('#crudForm').find(`[name=tgldari]`).val(),
                                supir_id: supir_id,
                                sortIndex: 'nobukti_trip',
                                aksi: $('#crudForm').data('action'),
                                idPendapatan: $('#crudForm').find(`[name=id]`).val()
                            },
                            datatype: "json"
                        }).trigger('reloadGrid');
                        initAutoNumeric($('.footrow').find(`td[aria-describedby="modalgrid_nominal_detail"]`).text(totalNominal))
                        initAutoNumeric($('.footrow').find(`td[aria-describedby="modalgrid_gajikenek"]`).text(totalKenek))

                    }, 50);

                    if (isDeposito == 'YA') {

                        if (response.pjp != null) {
                            form.find('[name=penerimaan_pinjaman]').val(response.pjp.penerimaan_nobukti)
                        }
                        if (response.dpo != null) {
                            form.find('[name=penerimaan_deposito]').val(response.dpo.penerimaan_nobukti)
                        }


                        // DEPOSITO
                        loadDepositoGrid()
                        getDataDeposito().then((response) => {

                            let selectedIdDepo = []
                            let totalBiaya = 0

                            $.each(response.data, (index, value) => {
                                selectedIdDepo.push(value.id)
                                totalBiaya += parseFloat(value.nominal)
                            })
                            $('#tableDeposito').jqGrid("clearGridData");
                            setTimeout(() => {

                                $("#tableDeposito")
                                    .jqGrid("setGridParam", {
                                        datatype: "local",
                                        data: response.data,
                                        originalData: response.data,
                                        rowNum: response.data.length,
                                        selectedRowIds: selectedIdDepo
                                    })
                                    .trigger("reloadGrid");
                                initAutoNumeric($('#tableDeposito tbody tr').find(`td[aria-describedby="tableDeposito_nominal"]`))
                            }, 100);
                            initAutoNumeric($('.footrow').find(`td[aria-describedby="tableDeposito_nominal"]`).text(totalBiaya))

                        });

                        //PJP
                        loadPinjamanGrid()
                        getDataPinjaman().then((response) => {
                            console.log(response)
                            setTimeout(() => {

                                $("#tablePinjaman")
                                    .jqGrid("setGridParam", {
                                        datatype: "local",
                                        data: response.data,
                                        originalData: response.data,
                                        rowNum: response.data.length,
                                        selectedRowIds: response.selectedId
                                    })
                                    .trigger("reloadGrid");
                                initAutoNumeric($('#tablePinjaman tbody tr').find(`td[aria-describedby="tablePinjaman_pinj_nominal"]`))
                            }, 100);
                            initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePinjaman_pinj_nominal"]`).text(response.totalPinj))
                        });

                    }
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
                        width: 40,
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
                                $(element).addClass('checkbox-selectall')

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
                            return `<input type="checkbox" class="checkbox-jqgrid" name="idgrid[]" value="${rowData.id}" ${disabled} onchange="checkboxHandlerTrip(this)">`
                        },
                    },
                    {
                        label: 'ID',
                        name: 'id',
                        width: '50px',
                        hidden: true,
                        search: false
                    },
                    {
                        label: 'SUPIR',
                        name: 'namasupir',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                    },
                    {
                        label: 'SUPIRID',
                        name: 'supir_id',
                        hidden: true,
                        search: false
                    },
                    {
                        label: 'NO BUKTI TRIP',
                        name: 'nobukti_trip',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'TGL TRIP',
                        name: 'tgl_trip',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
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
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'TGL RIC',
                        name: 'tgl_ric',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'DARI',
                        name: 'dari',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'right',
                        formatter: currencyFormat,
                    },
                    {
                        label: 'GAJI KENEK',
                        name: 'gajikenek',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
                    $('#loaderGrid').addClass('d-none')
                    $('#modalgrid').setSelection($('#modalgrid').getDataIDs()[0])
                    setHighlight($(this))

                    if (data.attributes) {

                        $(this).jqGrid('footerData', 'set', {
                            nobukti_trip: 'Total:',
                            // nominal_detail: data.attributes.totalNominal,
                            // gajikenek: data.attributes.totalGajiKenek,
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
                    let supir_id = $('#crudForm').find(`[name=supir_id]`).val()
                    if (supir_id == '') {
                        supir_id = 0;
                    }
                    $('#modalgrid').jqGrid('setGridParam', {
                        postData: {
                            supir_id: supir_id
                        }
                    })
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
                    selectedGajiKenek = [];
                    selectedDari = [];
                    selectedSampai = [];
                    selectedSupirId = [];

                    $.each(response.data, (index, detail) => {
                        if (detail.pendapatansupir_id != 0) {

                            selectedRowsTrip.push(detail.id)
                            selectedTrip.push(detail.nobukti_trip)
                            selectedRic.push(detail.nobukti_ric)
                            selectedNominal.push(detail.nominal_detail)
                            selectedGajiKenek.push(detail.gajikenek)
                            selectedDari.push(detail.dari_id)
                            selectedSampai.push(detail.sampai_id)
                            selectedSupirId.push(detail.supir_id)
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
        selectedGajiKenek = [];
        selectedSupirId = [];
        $('#modalgrid').trigger('reloadGrid')
        setTotalNominalTrip()
    }

    function selectAllRowsTrip() {
        supirId = $('#crudForm').find(`[name=supir_id]`).val()
        if (supirId == '') {
            supirId = 0;
        }
        $.ajax({
            url: `${apiUrl}pendapatansupirheader/gettrip`,
            method: 'GET',
            dataType: 'JSON',
            data: {
                limit: 0,
                tglsampai: $('#crudForm').find(`[name=tglsampai]`).val(),
                tgldari: $('#crudForm').find(`[name=tgldari]`).val(),
                supir_id: supirId,
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
                selectedGajiKenek = [];
                selectedSupirId = [];

                selectedRowsTrip = response.data.map((data) => data.id)
                selectedTrip = response.data.map((data) => data.nobukti_trip)
                selectedRic = response.data.map((data) => data.nobukti_ric)
                selectedNominal = response.data.map((data) => data.nominal_detail)
                selectedGajiKenek = response.data.map((data) => data.gajikenek)
                selectedDari = response.data.map((data) => data.dari_id)
                selectedSampai = response.data.map((data) => data.sampai_id)
                selectedSupirId = response.data.map((data) => data.supir_id)

                $('#modalgrid').jqGrid('setGridParam', {
                    url: `${apiUrl}pendapatansupirheader/gettrip`,
                    postData: {
                        tglsampai: $('#crudForm').find(`[name=tglsampai]`).val(),
                        tgldari: $('#crudForm').find(`[name=tgldari]`).val(),
                        supir_id: supirId,
                        id: $('#crudForm').find(`[name=id]`).val(),
                        sortIndex: 'nobukti_trip',
                        aksi: $('#crudForm').data('action'),
                        idPendapatan: $('#crudForm').find(`[name=id]`).val()
                    },
                    datatype: "json"
                }).trigger('reloadGrid');

                setTotalNominalTrip()
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
            selectedGajiKenek.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_gajikenek"]`).text())
            selectedDari.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_dari_id"]`).text())
            selectedSampai.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_sampai_id"]`).text())
            selectedSupirId.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_supir_id"]`).text())

            $(element).parents('tr').addClass('bg-light-blue')
        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRowsTrip.length; i++) {
                if (selectedRowsTrip[i] == value) {
                    selectedRowsTrip.splice(i, 1);
                    selectedTrip.splice(i, 1);
                    selectedRic.splice(i, 1);
                    selectedNominal.splice(i, 1);
                    selectedGajiKenek.splice(i, 1);
                    selectedDari.splice(i, 1);
                    selectedSampai.splice(i, 1);
                    selectedSupirId.splice(i, 1);
                }
            }
        }

        setTotalNominalTrip()
    }


    function setTotalNominalTrip() {
        let nominal = 0
        let kenek = 0
        $.each(selectedRowsTrip, (index, val) => {
            getNominal = selectedNominal[index];
            nominals = (getNominal == 'undefined' || getNominal == NaN || getNominal == '' || getNominal == undefined) ? 0 : parseFloat(getNominal.replaceAll(',', ''))
            nominal += nominals

            getKenek = selectedGajiKenek[index];
            keneks = parseFloat(getKenek.replaceAll(',', ''))
            kenek += keneks
        })
        initAutoNumeric($('.footrow').find(`td[aria-describedby="modalgrid_nominal_detail"]`).text(nominal))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="modalgrid_gajikenek"]`).text(kenek))
    }

    function loadDepositoGrid() {
        $("#tableDeposito")
            .jqGrid({
                datatype: 'local',
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                colModel: [{
                        label: "id",
                        name: "id",
                        hidden: true,
                        search: false,
                    }, {
                        label: "supir_id",
                        name: "supir_id",
                        hidden: true,
                        search: false,
                    },
                    {
                        label: "SUPIR",
                        name: "supirdeposito",
                        sortable: true,
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_dekstop_4,
                    },
                    {
                        label: "NOMINAL",
                        name: "nominal",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: "right",
                        editable: true,
                        editoptions: {
                            dataInit: function(element, id) {
                                initAutoNumeric($('#crudForm').find(`[id="${id.id}"]`))
                            },
                            dataEvents: [{
                                type: "keyup",
                                fn: function(event, rowObject) {
                                    let originalGridData = $("#tableDeposito")
                                        .jqGrid("getGridParam", "originalData")
                                        .find((row) => row.id == rowObject.rowId);

                                    let localRow = $("#tableDeposito").jqGrid(
                                        "getLocalRow",
                                        rowObject.rowId
                                    );
                                    let totalSisa
                                    localRow.nominal = event.target.value;

                                    let nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])

                                    if (nominal < 0) {
                                        showDialog('NOMINAL tidak boleh minus')
                                        $("#tableDeposito").jqGrid(
                                            "setCell",
                                            rowObject.rowId,
                                            "nominal",
                                            0
                                        );
                                    }
                                    setTotalNominalDeposito()
                                    // nominalDetails = $(`#tableDeposito tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tableDeposito_nominal"]`)
                                    // ttlBayar = 0
                                    // $.each(nominalDetails, (index, nominalDetail) => {
                                    //     ttlBayarDetail = parseFloat($(nominalDetail).attr('title').replaceAll(',', ''))
                                    //     ttlBayars = (isNaN(ttlBayarDetail)) ? 0 : ttlBayarDetail;
                                    //     ttlBayar += ttlBayars
                                    // });
                                    // ttlBayar += nominal
                                    // initAutoNumeric($('.footrow').find(`td[aria-describedby="tableDeposito_nominal"]`).text(ttlBayar))
                                },
                            }, ],
                        },
                        sortable: false,
                        sorttype: "int",
                    },
                    {
                        label: "empty",
                        name: "empty",
                        hidden: true,
                        search: false,
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
                editableColumns: ["nominal"],
                selectedRowIds: [],
                afterRestoreCell: function(rowId, value, indexRow, indexColumn) {
                    let originalGridData = $("#tableDeposito")
                        .jqGrid("getGridParam", "originalData")
                        .find((row) => row.id == rowId);

                    let localRow = $("#tableDeposito").jqGrid("getLocalRow", rowId);
                },
                validationCell: function(cellobject, errormsg, iRow, iCol) {
                    console.log(cellobject);
                    console.log(errormsg);
                    console.log(iRow);
                    console.log(iCol);
                },
                loadComplete: function() {
                    setTotalNominalDeposito()
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
                    let localRow = $("#tableDeposito").jqGrid("getLocalRow", rowId);

                    $("#tableDeposito").jqGrid(
                        "setCell",
                        rowId,
                        "sisa",
                        parseInt(localRow.sisa) + parseInt(localRow.nominal)
                    );

                    return true;
                },
            });
        /* Append clear filter button */
        loadClearFilter($('#tableDeposito'))

    }

    $(document).on('click', '#resetdatafilter_tableDeposito', function(event) {
        selectedRowsPengembalian = $("#tableDeposito").getGridParam("selectedRowIds");
        $.each(selectedRowsPengembalian, function(index, value) {
            $('#tableDeposito').jqGrid('saveCell', value, 5); //emptycell
            $('#tableDeposito').jqGrid('saveCell', value, 4); //nominal
        })

    });
    $(document).on('click', '#gbox_tableDeposito .ui-jqgrid-hbox .ui-jqgrid-htable thead .ui-search-toolbar th td a.clearsearchclass', function(event) {
        selectedRowsPengembalian = $("#tableDeposito").getGridParam("selectedRowIds");
        $.each(selectedRowsPengembalian, function(index, value) {
            $('#tableDeposito').jqGrid('saveCell', value, 5); //emptycell
            $('#tableDeposito').jqGrid('saveCell', value, 4); //nominal
        })
    })

    function setTotalNominalDeposito() {
        let nominalDetails = $(`#tableDeposito`).find(`td[aria-describedby="tableDeposito_nominal"]`)
        let nominal = 0
        selectedRowsPinjaman = $("#tableDeposito").getGridParam("selectedRowIds");
        $.each(selectedRowsPinjaman, function(index, value) {
            dataPinjaman = $("#tableDeposito").jqGrid("getLocalRow", value);
            nominals = (dataPinjaman.nominal == undefined || dataPinjaman.nominal == '') ? 0 : dataPinjaman.nominal;
            getNominal = (isNaN(nominals)) ? parseFloat(nominals.replaceAll(',', '')) : parseFloat(nominals)
            nominal = nominal + getNominal
        })
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tableDeposito_nominal"]`).text(nominal))
    }

    function getDataDeposito() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}pendapatansupirheader/getDataDeposito`,
                dataType: "JSON",
                data: {
                    nobukti: $('#crudForm').find("[name=nobukti]").val(),
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: (response) => {
                    resolve(response);
                },
                error: error => {
                    reject(error)
                }
            });
        });
    }

    function loadPinjamanGrid() {
        $("#tablePinjaman")
            .jqGrid({
                datatype: 'local',
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                colModel: [{
                        label: "",
                        name: "",
                        width: 40,
                        formatter: 'checkbox',
                        search: false,
                        editable: false,
                        formatter: function(value, rowOptions, rowData) {
                            let disabled = '';
                            if ($('#crudForm').data('action') == 'delete') {
                                disabled = 'disabled'
                            }
                            return `<input type="checkbox" class="checkbox-jqgrid" value="${rowData.id}" ${disabled} onChange="checkboxPotPribadiHandler(this, ${rowData.id})">`;
                        },
                    },
                    {
                        label: "id",
                        name: "id",
                        hidden: true,
                        search: false,
                    },
                    {
                        label: "SUPIR",
                        name: "pinj_supir",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                        sortable: true,
                    },
                    {
                        label: "SUPIR_ID",
                        name: "pinj_supirid",
                        hidden: true,
                        search: false
                    },
                    {
                        label: "no bukti pinjaman",
                        name: "pinj_nobukti",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        sortable: true,
                    },
                    {
                        label: "tgl bukti pinjaman",
                        name: "pinj_tglbukti",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        sortable: true,
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: "Jlh Pinjaman",
                        name: "jlhpinjaman",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        sortable: true,
                        align: "right",
                        formatter: currencyFormat,
                    },
                    {
                        label: "Total Bayar",
                        name: "totalbayar",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        sortable: true,
                        align: "right",
                        formatter: currencyFormat,
                    },
                    {
                        label: "SISA",
                        name: "pinj_sisa",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        sortable: true,
                        align: "right",
                        formatter: currencyFormat,
                    },
                    {
                        label: "NOMINAL",
                        name: "pinj_nominal",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: "right",
                        editable: true,
                        editoptions: {
                            dataInit: function(element, id) {
                                initAutoNumeric($('#crudForm').find(`[id="${id.id}"]`))
                            },
                            dataEvents: [{
                                type: "keyup",
                                fn: function(event, rowObject) {
                                    let originalGridDataPotPribadi = $("#tablePinjaman")
                                        .jqGrid("getGridParam", "originalData")
                                        .find((row) => row.id == rowObject.rowId);

                                    let localRow = $("#tablePinjaman").jqGrid(
                                        "getLocalRow",
                                        rowObject.rowId
                                    );
                                    let totalSisaPinjPribadi
                                    localRow.pinj_nominal = event.target.value;
                                    let pinj_nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                                    if ($('#crudForm').data('action') == 'edit') {
                                        totalSisaPinjPribadi = (parseFloat(originalGridDataPotPribadi.pinj_sisa) + parseFloat(originalGridDataPotPribadi.pinj_nominal)) - pinj_nominal
                                    } else {
                                        totalSisaPinjPribadi = originalGridDataPotPribadi.pinj_sisa - pinj_nominal
                                    }

                                    $("#tablePinjaman").jqGrid(
                                        "setCell",
                                        rowObject.rowId,
                                        "pinj_sisa",
                                        totalSisaPinjPribadi
                                    );

                                    if (totalSisaPinjPribadi < 0) {
                                        showDialog('sisa tidak boleh minus')
                                        $("#tablePinjaman").jqGrid(
                                            "setCell",
                                            rowObject.rowId,
                                            "pinj_nominal",
                                            0
                                        );
                                        if (originalGridDataPotPribadi.pinj_sisa == 0) {
                                            $("#tablePinjaman").jqGrid("setCell", rowObject.rowId, "pinj_sisa", (parseFloat(originalGridDataPotPribadi.pinj_sisa) + parseFloat(originalGridDataPotPribadi.pinj_nominal)));
                                        } else {
                                            $("#tablePinjaman").jqGrid("setCell", rowObject.rowId, "pinj_sisa", originalGridDataPotPribadi.pinj_sisa);
                                        }
                                    }

                                    // ttlpinj_nominals = 0
                                    // let selectedRowsPinjaman = $("#tablePinjaman").getGridParam("selectedRowIds");
                                    // $.each(selectedRowsPinjaman, function(index, value) {
                                    //     if (value != rowObject.rowId) {
                                    //         dataPinjaman = $("#tablePinjaman").jqGrid("getLocalRow", value);
                                    //         getNominal = (dataPinjaman.pinj_nominal == undefined) ? 0 : dataPinjaman.pinj_nominal;
                                    //         ttlpinj_nominals = ttlpinj_nominals + parseFloat(getNominal.replaceAll(',', ''))
                                    //     }
                                    // })
                                    // ttlpinj_nominal = pinj_nominal + parseFloat(ttlpinj_nominals)
                                    // initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePinjaman_pinj_nominal"]`).text(ttlpinj_nominal))

                                    // initAutoNumeric($('#detailLainnya').find(`[name="potonganpinjaman"]`).val(ttlpinj_nominal))
                                    setTotalNominalPP()
                                    setTotalSisaPotPribadi()
                                },
                            }, ],
                        },
                        sortable: false,
                        sorttype: "int",
                    },
                    {
                        label: "KETERANGAN",
                        name: "pinj_keterangan",
                        sortable: false,
                        editable: false,
                        width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
                    },
                    {
                        label: "empty",
                        name: "empty",
                        hidden: true,
                        search: false,
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
                editableColumns: ["pinj_nominal"],
                selectedRowIds: [],
                afterRestoreCell: function(rowId, value, indexRow, indexColumn) {
                    let originalGridDataPotPribadi = $("#tablePinjaman")
                        .jqGrid("getGridParam", "originalData")
                        .find((row) => row.id == rowId);

                    let getBayarPP = $("#tablePinjaman").jqGrid("getCell", rowId, "pinj_nominal")
                    let pinj_nominal = (getBayarPP != '') ? parseFloat(getBayarPP.replaceAll(',', '')) : 0

                    potPribadiSisa = 0
                    if ($('#crudForm').data('action') == 'edit') {
                        potPribadiSisa = (parseFloat(originalGridDataPotPribadi.pinj_sisa) + parseFloat(originalGridDataPotPribadi.pinj_nominal)) - pinj_nominal
                    } else {
                        potPribadiSisa = parseFloat(originalGridDataPotPribadi.pinj_sisa) - pinj_nominal
                    }
                    console.log(indexColumn)
                    if (indexColumn == 8) {

                        $("#tablePinjaman").jqGrid(
                            "setCell",
                            rowId,
                            "pinj_sisa",
                            potPribadiSisa
                            // sisa - nominal - potongan
                        );
                    }
                    // setTotalNominal()
                    setTotalSisaPotPribadi()
                },
                isCellEditable: function(cellname, iRow, iCol) {
                    let rowData = $(this).jqGrid("getRowData")[iRow - 1];

                    return $(this)
                        .find(`tr input[value=${rowData.id}]`)
                        .is(":checked");
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
                                $(this)
                                    .find(`tr input[value=${selectedRowId}]`)
                                    .prop("checked", true);
                                initAutoNumeric($(this).find(`td[aria-describedby="tablePinjaman_pinj_nominal"]`))
                            });
                    }, 100);
                    // setTotalNominal()
                    setTotalSisaPotPribadi()
                    setTotalPinjaman()
                    setTotalBayarPinjaman()
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
                    let localRow = $("#tablePinjaman").jqGrid("getLocalRow", rowId);

                    $("#tablePinjaman").jqGrid(
                        "setCell",
                        rowId,
                        "pinj_sisa",
                        parseInt(localRow.pinj_sisa) + parseInt(localRow.pinj_nominal)
                    );

                    return true;
                },
            });
        /* Append clear filter button */
        loadClearFilter($('#tablePinjaman'))

        /* Append global search */
        // loadGlobalSearch($('#tablePinjaman'))
    }


    $(document).on('click', '#resetdatafilter_tablePinjaman', function(event) {
        selectedRowsPengembalian = $("#tablePinjaman").getGridParam("selectedRowIds");
        $.each(selectedRowsPengembalian, function(index, value) {
            $('#tablePinjaman').jqGrid('saveCell', value, 12); //emptycell
            $('#tablePinjaman').jqGrid('saveCell', value, 10); //nominal
        })

    });
    $(document).on('click', '#gbox_tablePinjaman .ui-jqgrid-hbox .ui-jqgrid-htable thead .ui-search-toolbar th td a.clearsearchclass', function(event) {
        selectedRowsPengembalian = $("#tablePinjaman").getGridParam("selectedRowIds");
        $.each(selectedRowsPengembalian, function(index, value) {
            $('#tablePinjaman').jqGrid('saveCell', value, 12); //emptycell
            $('#tablePinjaman').jqGrid('saveCell', value, 10); //nominal
        })
    })

    function setTotalPinjaman() {
        let jlhpinj = 0
        $("#tablePinjaman").find("tbody tr").each(function() {
            $(this).find(`td[aria-describedby="tablePinjaman_jlhpinjaman"]`).map(function() {
                jlhpinj = jlhpinj + parseFloat($(this).text().replaceAll(',', ''));
            });
        });
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePinjaman_jlhpinjaman"]`).text(jlhpinj))
    }

    function setTotalBayarPinjaman() {
        let bayarpinj = 0
        let originalData = $("#tablePinjaman").getGridParam("data");
        var filteredData = [];

        // Iterate through the rows and add filtered data to the array
        $("#tablePinjaman").find("tbody tr").each(function() {
            $(this).find(`td[aria-describedby="tablePinjaman_totalbayar"]`).map(function() {
                bayarpinj = bayarpinj + parseFloat($(this).text().replaceAll(',', ''));
            });
        });
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePinjaman_totalbayar"]`).text(bayarpinj))
    }

    function getDataPinjaman() {
        aksi = $('#crudForm').data('action')
        let supirId = $('#crudForm').find('[name=supir_id]').val();
        if (supirId == '') {
            supirId = 0;
        }
        urlPotPribadi = `${apiUrl}pendapatansupirheader/${supirId}/getPinjaman`
        return new Promise((resolve, reject) => {
            $.ajax({
                url: urlPotPribadi,
                dataType: "JSON",
                data: {
                    nobukti: $('#crudForm').find('[name=nobukti]').val(),
                    tglbukti: $('#crudForm').find('[name=tglbukti]').val(),
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: (response) => {
                    if (aksi != 'add') {
                        let selectedIdPinj = []
                        let totalPinj = 0

                        $.each(response.data, (index, value) => {
                            if (value.penerimaantruckingheader_id != null) {
                                selectedIdPinj.push(parseInt(value.id))
                                totalPinj += parseFloat(value.pinj_nominal)

                            }
                        })
                        response.selectedId = selectedIdPinj;
                        response.totalPinj = totalPinj;
                    }
                    resolve(response);
                },
                error: error => {
                    reject(error)
                }
            });
        });
    }

    function checkboxPotPribadiHandler(element, rowId) {

        let isChecked = $(element).is(":checked");
        let editableColumnsPotPribadi = $("#tablePinjaman").getGridParam("editableColumns");
        let selectedRowIdsPotPribadi = $("#tablePinjaman").getGridParam("selectedRowIds");
        let originalGridDataPotPribadi = $("#tablePinjaman")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

        editableColumnsPotPribadi.forEach((editableColumn) => {

            if (!isChecked) {
                for (var i = 0; i < selectedRowIdsPotPribadi.length; i++) {
                    if (selectedRowIdsPotPribadi[i] == rowId) {
                        selectedRowIdsPotPribadi.splice(i, 1);
                    }
                }
                sisaPribadi = 0
                if ($('#crudForm').data('action') == 'edit') {
                    sisaPribadi = (parseFloat(originalGridDataPotPribadi.pinj_sisa) + parseFloat(originalGridDataPotPribadi.pinj_nominal))
                } else {
                    sisaPribadi = originalGridDataPotPribadi.pinj_sisa
                }

                $("#tablePinjaman").jqGrid(
                    "setCell",
                    rowId,
                    "pinj_sisa",
                    sisaPribadi
                );

                $("#tablePinjaman").jqGrid("setCell", rowId, "pinj_nominal", 0);
                setTotalNominalPP()
                setTotalSisaPotPribadi()
            } else {
                selectedRowIdsPotPribadi.push(rowId);

                let localRow = $("#tablePinjaman").jqGrid("getLocalRow", rowId);

                // if ($('#crudForm').data('action') == 'edit') {
                //     localRow.pinj_nominal = (parseFloat(originalGridDataPotPribadi.pinj_sisa) + parseFloat(originalGridDataPotPribadi.pinj_nominal))
                // }
                $("#tablePinjaman").jqGrid("setCell", rowId, "pinj_nominal", 0);

                initAutoNumeric($(`#tablePinjaman tr#${rowId}`).find(`td[aria-describedby="tablePinjaman_pinj_nominal"]`))
                setTotalNominalPP()
                setTotalSisaPotPribadi()
            }
        });

        $("#tablePinjaman").jqGrid("setGridParam", {
            selectedRowIds: selectedRowIdsPotPribadi,
        });

    }

    function setTotalSisaPotPribadi() {
        let pinj_sisaDetails = $(`#tablePinjaman`).find(`td[aria-describedby="tablePinjaman_pinj_sisa"]`)
        let pinj_sisa = 0
        // let originalData = $("#tablePinjaman").getGridParam("data");
        // $.each(originalData, function(index, value) {
        //     sisa = value.pinj_sisa;
        //     sisa = (isNaN(sisa)) ? parseFloat(sisa.replaceAll(',', '')) : parseFloat(sisa)
        //     pinj_sisa += sisa

        // })
        $("#tablePinjaman").find("tbody tr").each(function() {
            $(this).find(`td[aria-describedby="tablePinjaman_pinj_sisa"]`).map(function() {
                pinj_sisa = pinj_sisa + parseFloat($(this).text().replaceAll(',', ''));
            });
        });
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePinjaman_pinj_sisa"]`).text(pinj_sisa))
    }

    function setTotalNominalPP() {
        let pinj_nominal = 0
        selectedRowsPinjaman = $("#tablePinjaman").getGridParam("selectedRowIds");
        $.each(selectedRowsPinjaman, function(index, value) {
            console.log('selectedRowsPinjaman ', value)
            dataPinjaman = $("#tablePinjaman").jqGrid("getLocalRow", value);
            pinj_nominals = (dataPinjaman.pinj_nominal == undefined) ? 0 : dataPinjaman.pinj_nominal;
            getNominal = (isNaN(pinj_nominals)) ? parseFloat(pinj_nominals.replaceAll(',', '')) : parseFloat(pinj_nominals)
            pinj_nominal = pinj_nominal + getNominal
        })
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePinjaman_pinj_nominal"]`).text(pinj_nominal))
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
        // $('.supir-lookup').lookup({
        //     title: 'Supir Lookup',
        //     fileName: 'supir',
        //     beforeProcess: function(test) {
        //         // var levelcoa = $(`#levelcoa`).val();
        //         this.postData = {

        //             Aktif: 'AKTIF',
        //         }
        //     },
        //     onSelectRow: (supir, element) => {
        //         $('#crudForm [name=supir_id]').first().val(supir.id)
        //         element.val(supir.namasupir)
        //         element.data('currentValue', element.val())
        //     },
        //     onCancel: (element) => {
        //         element.val(element.data('currentValue'))
        //     },
        //     onClear: (element) => {
        //         $('#crudForm [name=supir_id]').first().val('')
        //         element.val('')
        //         element.data('currentValue', element.val())
        //     }
        // })
        $('.supir-lookup').lookupV3({
            title: 'Supir Lookup',
            fileName: 'supirV3',
            searching: ['namasupir'],
            labelColumn: false,
            beforeProcess: function(test) {
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
                $(`#crudForm [name="supir_id"]`).first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })


        // $('.bank-lookup').lookup({
        //     title: 'Bank Lookup',
        //     fileName: 'bank',
        //     beforeProcess: function(test) {
        //         this.postData = {

        //             Aktif: 'AKTIF',
        //             withPusat: 0
        //         }
        //     },
        //     onSelectRow: (bank, element) => {
        //         $('#crudForm [name=bank_id]').first().val(bank.id)
        //         element.val(bank.namabank)
        //         element.data('currentValue', element.val())
        //     },
        //     onCancel: (element) => {
        //         element.val(element.data('currentValue'))
        //     },
        //     onClear: (element) => {
        //         $('#crudForm [name=bank_id]').first().val('')
        //         element.val('')
        //         element.data('currentValue', element.val())
        //     }
        // })
        $('.bank-lookup').lookupV3({
            title: 'Bank Lookup',
            fileName: 'bankV3',
            searching: ['namabank'],
            labelColumn: false,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    withPusat: 0
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
                $(`#crudForm [name="bank_id"]`).first().val('')
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

    const setTampilan = function() {
        return new Promise((resolve, reject) => {
            let data = [];
            data.push({
                name: 'grp',
                value: 'UBAH TAMPILAN'
            })
            data.push({
                name: 'text',
                value: 'PENDAPATANSUPIR'
            })
            $.ajax({
                url: `${apiUrl}parameter/getparambytext`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {
                    memo = JSON.parse(response.memo)
                    memo = memo.INPUT
                    if (memo != '') {
                        input = memo.split(',');
                        input.forEach(field => {
                            field = $.trim(field.toLowerCase());
                            $(`.${field}`).hide()
                            $("#modalgrid").jqGrid("hideCol", `${field}`);
                            console.log(field)
                            if (field == 'nobukti_trip') {

                                sortnameTrip = 'nobukti_ric';
                                $("#modalgrid").jqGrid('setGridParam', {
                                    postData: {
                                        sortIndex: sortnameTrip
                                    }
                                }).trigger('reloadGrid')
                            }
                        });
                    }
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    const setTglBukti = function(form) {
        return new Promise((resolve, reject) => {
            let data = [];
            data.push({
                name: 'grp',
                value: 'EDIT TANGGAL BUKTI'
            })
            data.push({
                name: 'subgrp',
                value: 'PENDAPATAN SUPIR'
            })
            $.ajax({
                url: `${apiUrl}parameter/getparamfirst`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {
                    isEditTgl = $.trim(response.text);
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }
</script>
@endpush()