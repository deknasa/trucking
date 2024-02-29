<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="crudForm">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="crudModalTitle"></p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="text" name="id" class="form-control" hidden>


                        <div class="form-group">
                            <label class="col-sm-12 col-form-label">NO BUKTI</label>
                            <div class="col-sm-12">
                                <input type="text" name="nobukti" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-4 col-form-label">TGL TRIP <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <input type="text" name="tglbukti" class="form-control datepicker" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group statusupahzona">
                            <label class="col-sm-12 col-form-label">UPAH ZONA <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <select name="statusupahzona" class="form-control select2bs4" id="statusupahzona">
                                    <option value="">-- PILIH STATUS UPAH ZONA--</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="col-sm-12 col-form-label">JENIS SURAT PENGANTAR <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <select name="statuslongtrip" class="form-control select2bs4" id="statuslongtrip">
                                    <option value="">-- PILIH STATUS LONGTRIP --</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group joblangsir">
                            <label class="col-sm-12 col-form-label">STATUS LANGSIR <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <select name="statuslangsir" class="form-control select2bs4" id="statuslangsir">
                                    <option value="">-- PILIH STATUS LANGSIR --</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-12 col-form-label">GUDANG SAMA <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <select name="statusgudangsama" class="form-control select2bs4" id="statusgudangsama">
                                    <option value="">-- PILIH STATUS GUDANG SAMA --</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group nobukti_tripasal">
                            <label class="col-sm-12 col-form-label">TRIP ASAL</label>
                            <div class="col-sm-12">
                                <input type="text" name="nobukti_tripasal" class="form-control suratpengantar-lookup">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-12 col-form-label">CUSTOMER <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="hidden" name="agen_id">
                                <input type="text" name="agen" class="form-control agen-lookup">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-12 col-form-label">JENIS ORDERAN <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="hidden" name="jenisorder_id">
                                <input type="text" name="jenisorder" class="form-control jenisorder-lookup">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-12 col-form-label">FULL / EMPTY <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="hidden" name="statuscontainer_id">
                                <input type="text" name="statuscontainer" class="form-control statuscontainer-lookup">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-4 col-form-label">CONTAINER <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="hidden" name="container_id">
                                <input type="text" name="container" class="form-control container-lookup">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-4 col-form-label">UPAH SUPIR <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="hidden" name="upah_id">
                                <input type="text" name="upah" class="form-control upahsupirrincian-lookup">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-12 col-form-label">PENYESUAIAN</label>
                            <div class="col-sm-12">
                                <input type="text" name="penyesuaian" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-4 col-form-label">DARI <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="hidden" name="dari_id">
                                <input type="text" name="dari" class="form-control kotadari-lookup" readonly>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-12 col-form-label">Sampai <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="hidden" name="sampai_id">
                                <input type="text" name="sampai" class="form-control kotasampai-lookup" readonly>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-12 col-form-label">TUJUAN TARIF <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="hidden" name="tarifrincian_id">
                                <input type="text" name="tarifrincian" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group " style="display:none">
                            <label class="col-sm-12 col-form-label">Lokasi BONGKAR/MUAT <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" name="lokasibongkarmuat" class="form-control">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-4 col-form-label">NO POLISI <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="hidden" name="trado_id">
                                <input type="hidden" name="supir_id">
                                <input type="hidden" name="absensidetail_id">
                                <input type="text" name="trado" class="form-control absensisupirdetail-lookup">
                                <table class="table table-striped table-bordered table-responsive tableInfo" style="display:none">
                                    <thead>
                                        <tr>
                                            <th>Keterangan</th>
                                            <th>KM trado</th>
                                            <th>KM total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="infoTrado">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-12 col-form-label">SHIPPER <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="hidden" name="pelanggan_id">
                                <input type="text" name="pelanggan" class="form-control pelanggan-lookup">
                            </div>
                        </div>

                        <div class="form-group statusgandengan">
                            <label class="col-sm-12 col-form-label">STATUS GANDENGAN <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <select name="statusgandengan" class="form-control select2bs4" id="statusgandengan">
                                    <option value="">-- PILIH STATUS GANDENGAN --</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group gandengan">
                            <label class="col-sm-12 col-form-label">NO GANDENGAN / CHASIS <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="hidden" name="gandengan_id">
                                <input type="text" name="gandengan" class="form-control gandengan-lookup">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-12 col-form-label">NO GANDENGAN / CHASIS (ASAL)</label>
                            <div class="col-sm-12">
                                <input type="hidden" name="gandenganasal_id">
                                <input type="text" name="gandenganasal" class="form-control gandenganasal-lookup">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label name="labeljobtrucking" class="col-sm-12 col-form-label">NO JOB TRUCKING
                                {{-- <span class="text-danger">*</span> --}}
                            </label>
                            <div class="col-sm-12">
                                <input type="text" name="jobtrucking" class="form-control jobtrucking-lookup">
                            </div>
                        </div>


                        <div class="form-group ">
                            <label class="col-sm-12 col-form-label">GUDANG <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" name="gudang" class="form-control">
                            </div>
                        </div>

                        <div class="table-scroll table-responsive ritasi">
                            <table class="table table-bordered table-bindkeys" id="ritasiList" style="width: 1000px;">
                                <thead>
                                    <tr>
                                        <th width="2%">No</th>
                                        <th width="25%">JENIS RITASI</th>
                                        <th width="35%">RITASI DARI</th>
                                        <th width="35%">RITASI KE</th>
                                        <th width="2%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body" class="form-group">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">TAMBAH</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                </div>
                <div class="modal-footer justify-content-start">
                    <button id="btnSubmit" class="btn btn-primary">
                        <i class="fa fa-save"></i>
                        Save
                    </button>
                    <button class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                        Cancel
                    </button>
        </form>
    </div>
</div>
</div>
</form>
</div>
</div>

@push('scripts')
<script>
    let hasFormBindKeys = false
    let modalBody = $('#crudModal').find('.modal-body').html()

    let jenisorderId
    let statuscontainerId
    let kotadariId
    let kotasampaiId
    let pilihKotaDariId = 0;
    let pilihKotaSampaiId = 0;
    let containerId
    let tradoId
    let pelangganId
    let gandenganId
    let tarifrincianId
    let statusLongtrip
    var statuspelabuhan
    let dataRitasiId = []
    let statusUpahZona
    let selectedUpahZona
    let zonadariId
    let zonasampaiId
    let upahZona
    let tinggalGandengan
    let longTripId
    let kodeStatusContainer
    let isTripAsal = true;

    $(document).ready(function() {
        $('.nobukti_tripasal').hide()
        $(document).on('click', "#addRow", function() {
            addRow()
        });

        $(document).on('click', '.delete-row', function(event) {
            deleteRow($(this).parents('tr'))
        })
        $('#btnSubmit').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let tripId = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm').serializeArray()

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
                    url = `${apiUrl}listtrip`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}listtrip/${tripId}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}listtrip/${tripId}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}listtrip`
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
                    $('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')

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

    $('#crudModal').on('shown.bs.modal', () => {
        let form = $('#crudForm')

        setFormBindKeys(form)

        activeGrid = null

        form.find('#btnSubmit').prop('disabled', false)
        if (form.data('action') == "view") {
            form.find('#btnSubmit').prop('disabled', true)
        }
        initLookup()
        initSelect2(form.find('.select2bs4'), true)
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        $('#crudModal').find('.modal-body').html(modalBody)
    })


    $(`#crudForm [name="statusupahzona"]`).on('change', function(event) {
        selectedUpahZona = $(`#crudForm [name="statusupahzona"] option:selected`).text()
        enabledLogTrip($(this).val())
        if (selectedUpahZona == 'NON UPAH ZONA' || selectedUpahZona == 'UPAH ZONA') {
            statusUpahZona = $(`#crudForm [name="statusupahzona"]`).val()

            $('#crudForm [name=upah_id]').val('')
            $('#crudForm [name=upah]').val('').data('currentValue', '')
            enabledUpahSupir()
            clearUpahSupir()
            if (selectedUpahZona == 'UPAH ZONA') {
                let jobtrucking = $('#crudForm [name=jobtrucking]')
                let labeljobtrucking = $('#crudForm [name=labeljobtrucking]')

                jobtrucking.attr('hidden', true)
                labeljobtrucking.attr('hidden', true)
                jobtrucking.parents('.input-group').find('.input-group-append').hide()
                jobtrucking.parents('.input-group').find('.button-clear').hide()
            }
        }
    })

    $(`#crudForm [name="statusgandengan"]`).on('change', function(event) {
        if ($(this).val() == tinggalGandengan) {
            $(`#crudForm [name="gandenganasal"]`).parents('.form-group').hide()
        } else {
            $(`#crudForm [name="gandenganasal"]`).parents('.form-group').show()
        }
    })


    $(`#crudForm [name="statusgudangsama"]`).on('change', function(event) {
        if ($(this).val() == 204) {
            if (isTripAsal) {
                $('.nobukti_tripasal').show()
            }
        } else {
            $('.nobukti_tripasal').hide()
        }
    })


    function enabledLogTrip(selected) {
        if (selected == upahZona) {

            $(`#crudForm [name="statuslongtrip"]`).val(longTripId).trigger('change');
            $(`#crudForm [name="statuslongtrip"]`).attr('readonly', true);
        } else {
            $(`#crudForm [name="statuslongtrip"]`).attr('readonly', false);
        }
    }

    function enabledUpahSupir() {

        let statuscontainer_id = $('#crudForm [name=statuscontainer_id]')
        let container_id = $('#crudForm [name=container_id]')
        let jenisorder_id = $('#crudForm [name=jenisorder_id]')
        let upahsupir = $('#crudForm [name=upah]')

        if (container_id.val() == '' && statuscontainer_id.val() == '' && jenisorder_id.val() == '') {
            upahSupirReadOnly()
            kotaUpahZona()
        } else {
            if (container_id.val() == '') {
                upahSupirReadOnly()
            } else if (statuscontainer_id.val() == '') {
                upahSupirReadOnly()
            } else if (jenisorder_id.val() == '') {
                upahSupirReadOnly()
            } else {
                if (upahsupir.val() != '') {
                    upahsupir.val('')
                    $('#crudForm [name=upah]').val('')
                    clearUpahSupir()
                } else {
                    console.log('here')
                    upahsupir.attr('readonly', false)
                    upahsupir.parents('.input-group').find('.input-group-append').show()
                    upahsupir.parents('.input-group').find('.button-clear').show()
                }
            }
        }
    }

    function upahSupirReadOnly() {
        let upahsupir = $('#crudForm [name=upah]')
        upahsupir.attr('readonly', true)
        upahsupir.parents('.input-group').find('.input-group-append').hide()
        upahsupir.parents('.input-group').find('.button-clear').hide()
    }

    function kotaUpahZona() {
        let kotadari_id = $('#crudForm [name=dari]')
        let kotasampai_id = $('#crudForm [name=sampai]')
        let upahsupir = $('#crudForm [name=upah]')
        if (upahsupir.val() != '') {
            if (selectedUpahZona == 'UPAH ZONA') {
                kotadari_id.attr('readonly', false)
                kotasampai_id.attr('readonly', false)
                kotadari_id.parents('.input-group').find('.input-group-append').show()
                kotadari_id.parents('.input-group').find('.button-clear').show()
                kotasampai_id.parents('.input-group').find('.input-group-append').show()
                kotasampai_id.parents('.input-group').find('.button-clear').show()
            } else {
                kotadari_id.attr('readonly', true)
                kotasampai_id.attr('readonly', true)
                kotadari_id.parents('.input-group').find('.input-group-append').hide()
                kotadari_id.parents('.input-group').find('.button-clear').hide()
                kotasampai_id.parents('.input-group').find('.input-group-append').hide()
                kotasampai_id.parents('.input-group').find('.button-clear').hide()
            }
        } else {

            kotadari_id.parents('.input-group').find('.input-group-append').hide()
            kotadari_id.parents('.input-group').find('.button-clear').hide()
            kotasampai_id.parents('.input-group').find('.input-group-append').hide()
            kotasampai_id.parents('.input-group').find('.button-clear').hide()
        }
    }


    function clearUpahSupir() {

        $('#crudForm [name=dari_id]').val('')
        $('#crudForm [name=sampai_id]').val('')
        $('#crudForm [name=dari]').val('')
        $('#crudForm [name=sampai]').val('')
        $('#crudForm [name=tarifrincian_id]').val('')
        $('#crudForm [name=tarifrincian]').val('')
        $('#crudForm [name=penyesuaian]').val('')
    }

    function editTrip(Id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
        `)
        $('#crudModalTitle').text('Edit Data Trip (mandor)')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusLongTripOptions(form),
                setStatusGudangSamaOptions(form),
                setStatusUpahZonaOptions(form),
                setStatusLangsirOptions(form),
                setStatusGandenganOptions(form),
                setTampilan(form)
            ])
            .then(() => {
                showTrip(form, Id)
                    .then(() => {
                        $('#crudModal').modal('show')
                        $('#crudForm [name=upah]').attr('readonly', false)
                        kotaUpahZona()
                        setJobReadOnly()
                    })
                    .catch((error) => {
                        showDialog(error.statusText)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })
    }

    function deleteTrip(Id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-trash"></i>
            Delete
        `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Delete Data Trip (mandor)')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusLongTripOptions(form),
                setStatusGudangSamaOptions(form),
                setStatusUpahZonaOptions(form),
                setStatusLangsirOptions(form),
                setStatusGandenganOptions(form),
                setTampilan(form)
            ])
            .then(() => {
                showTrip(form, Id)
                    .then(() => {
                        $('#crudModal').modal('show')
                        $('#crudForm [name=upah]').attr('readonly', false)
                        kotaUpahZona()
                        setJobReadOnly()
                    })
                    .catch((error) => {
                        showDialog(error.statusText)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })
    }

    function viewTrip(Id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'view')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
            `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('View Data Trip (mandor)')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusLongTripOptions(form),
                setStatusGudangSamaOptions(form),
                setStatusUpahZonaOptions(form),
                setStatusLangsirOptions(form),
                setStatusGandenganOptions(form),
                setTampilan(form)
            ])
            .then(() => {
                showTrip(form, Id)
                    .then(Id => {
                        // form.find('.aksi').hide()
                        setFormBindKeys(form)
                        form.find('[name]').attr('disabled', 'disabled').css({
                            background: '#fff'
                        })
                        form.find('[name=id]').prop('disabled', false)

                    })
                    .then(() => {
                        $('#crudModal').modal('show')
                    })
                    .catch((error) => {
                        showDialog(error.statusText)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })
    }


    function showTrip(form, Id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}listtrip/${Id}`,
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

                        (index == 'jobtrucking') ? element.data('current-value', value): '';
                        (index == 'statuscontainer') ? element.data('current-value', value): '';
                        (index == 'trado') ? element.data('current-value', value): '';
                        (index == 'supir') ? element.data('current-value', value): '';
                        (index == 'tarifrincian') ? element.data('current-value', value): '';
                        (index == 'cabang') ? element.data('current-value', value): '';
                        (index == 'upah') ? element.data('current-value', value): '';
                        (index == 'dari') ? element.data('current-value', value): '';
                        (index == 'sampai') ? element.data('current-value', value): '';
                        (index == 'pelanggan') ? element.data('current-value', value): '';
                        (index == 'container') ? element.data('current-value', value): '';
                        (index == 'agen') ? element.data('current-value', value): '';
                        (index == 'jenisorder') ? element.data('current-value', value): '';
                    })
                    if (response.data.statusgandengan = tinggalGandengan) {
                        $(`#crudForm [name="gandenganasal"]`).parents('.form-group').hide()
                    } else {
                        $(`#crudForm [name="gandenganasal"]`).parents('.form-group').show()
                    }
                    statuspelabuhan = response.data.statuspelabuhan
                    statusUpahZona = response.data.statusupahzona
                    containerId = response.data.container_id
                    statuscontainerId = response.data.statuscontainer_id
                    jenisorderId = response.data.jenisorder_id
                    pelangganId = response.data.pelanggan_id
                    gandenganId = response.data.gandengan_id
                    tradoId = response.data.trado_id
                    tarifrincianId = response.data.tarifrincian_id

                    getInfoTrado(response.data.trado_id)
                    if (response.data.statusgudangsama == 204) {
                        if (isTripAsal) {
                            $('.nobukti_tripasal').show()
                        }
                    } else {
                        $('.nobukti_tripasal').hide()
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

    function cekValidasi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}listtrip/${Id}/cekValidasi`,
            method: 'POST',
            dataType: 'JSON',
            beforeSend: request => {
                request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
            },
            data: {
                aksi: Aksi
            },
            success: response => {
                var kondisi = response.kondisi
                if (kondisi == true) {
                    showDialog(response.message['keterangan'])
                } else {
                    if (Aksi == 'EDIT') {
                        editTrip(Id)
                    } else {
                        deleteTrip(Id)
                    }
                }

            }
        })
    }

    function clearJobTrucking(){
        $('#crudForm [name=jobtrucking]').val('')
        $('#crudForm [name=jobtrucking]').data('currentValue', '')
    }
    const setTampilan = function(relatedForm) {
        return new Promise((resolve, reject) => {
            let data = [];
            data.push({
                name: 'grp',
                value: 'UBAH TAMPILAN'
            })
            data.push({
                name: 'text',
                value: 'INPUTTRIP'
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
                            if (field == 'nobukti_tripasal') {
                                isTripAsal = false
                            }
                            $(`.${field}`).hide()
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
    const setStatusGandenganOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statusgandengan]').empty()
            relatedForm.find('[name=statusgandengan]').append(
                new Option('-- PILIH STATUS GANDENGAN --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    filters: JSON.stringify({
                        "groupOp": "AND",
                        "rules": [{
                            "field": "grp",
                            "op": "cn",
                            "data": "STATUS GANDENGAN"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusGandengan => {
                        let option = new Option(statusGandengan.text, statusGandengan.id)
                        statusLongtrip = statusGandengan.id
                        if (statusGandengan.text == "TINGGAL GANDENGAN") {
                            tinggalGandengan = statusGandengan.id
                        }
                        relatedForm.find('[name=statusgandengan]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    const setStatusUpahZonaOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statusupahzona]').empty()
            relatedForm.find('[name=statusupahzona]').append(
                new Option('-- PILIH STATUS UPAH ZONA --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    filters: JSON.stringify({
                        "groupOp": "AND",
                        "rules": [{
                            "field": "grp",
                            "op": "cn",
                            "data": "STATUS UPAH ZONA"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusUpahZona => {
                        let option = new Option(statusUpahZona.text, statusUpahZona.id)
                        if (statusUpahZona.text == "UPAH ZONA") {
                            upahZona = statusUpahZona.id
                        }
                        relatedForm.find('[name=statusupahzona]').append(option).trigger('change')
                    });
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }
    const setStatusLongTripOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statuslongtrip]').empty()
            relatedForm.find('[name=statuslongtrip]').append(
                new Option('-- PILIH STATUS LONG TRIPS --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    filters: JSON.stringify({
                        "groupOp": "AND",
                        "rules": [{
                            "field": "grp",
                            "op": "cn",
                            "data": "STATUS LONGTRIP"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusLongTrip => {
                        let option = new Option(statusLongTrip.text, statusLongTrip.id)
                        statusLongtrip = statusLongTrip.id
                        if (statusLongTrip.text == 'LONGTRIP') {
                            longTripId = statusLongTrip.id;
                        }
                        relatedForm.find('[name=statuslongtrip]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    const setStatusGudangSamaOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statusgudangsama]').empty()
            relatedForm.find('[name=statusgudangsama]').append(
                new Option('-- PILIH STATUS GUDANG SAMA --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    filters: JSON.stringify({
                        "groupOp": "AND",
                        "rules": [{
                            "field": "grp",
                            "op": "cn",
                            "data": "STATUS GUDANG SAMA"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusGudangSama => {
                        let option = new Option(statusGudangSama.text, statusGudangSama.id)

                        relatedForm.find('[name=statusgudangsama]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    const setStatusLangsirOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statuslangsir]').empty()
            relatedForm.find('[name=statuslangsir]').append(
                new Option('-- PILIH STATUS LANGSIR --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    filters: JSON.stringify({
                        "groupOp": "AND",
                        "rules": [{
                            "field": "grp",
                            "op": "cn",
                            "data": "STATUS LANGSIR"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusLangsir => {
                        let option = new Option(statusLangsir.text, statusLangsir.id)

                        relatedForm.find('[name=statuslangsir]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function initLookup() {
        $('.suratpengantar-lookup').lookup({
            title: 'Surat Pengantar Lookup',
            fileName: 'suratpengantar',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {
                    Aktif: 'AKTIF',
                    jenisorder_id: 2
                }
            },
            onSelectRow: (suratpengantar, element) => {
                element.val(suratpengantar.nobukti)
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

        $('.kotadari-lookup').lookup({
            title: 'Kota Dari Lookup',
            fileName: 'kotazona',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {
                    Aktif: 'AKTIF',
                    kotaZona: zonadariId
                }
            },
            onSelectRow: (kota, element) => {
                $('#crudForm [name=dari_id]').first().val(kota.id)
                pilihKotaDariId = kota.id
                getpelabuhan(kota.id)
                element.val(kota.keterangan)
                element.data('currentValue', element.val())
                // getGaji()
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=dari_id]').first().val('')
                pilihKotaDariId = 0
                element.val('')
                element.data('currentValue', element.val())
                // getGaji()
            }
        })

        $('.jobtrucking-lookup').lookup({
            title: 'Job Trucking Lookup',
            fileName: 'jobtrucking',
            beforeProcess: function(test) {

                this.postData = {
                    jenisorder_id: jenisorderId,
                    container_id: containerId,
                    pelanggan_id: pelangganId,
                    gandengan_id: gandenganId,
                    trado_id: tradoId,
                    statuslongtrip: statusLongtrip,
                    tarif_id: tarifrincianId,
                    edit: true,
                    idtrip: $('#crudForm [name=id]').val(),
                    statuscontainer_id: $('#crudForm [name=statuscontainer_id]').val(),
                }
            },
            onSelectRow: (jobtrucking, element) => {
                $('#crudForm [name=jobtrucking]').first().val(jobtrucking.jobtrucking)
                element.val(jobtrucking.jobtrucking)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=jobtrucking]').first().val('')
                element.val('')
                element.data('currentValue', element.val())

            }
        })

        $('.kotasampai-lookup').lookup({
            title: 'Kota Tujuan Lookup',
            fileName: 'kotazona',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

                    Aktif: 'AKTIF',
                    kotaZona: zonasampaiId
                }
            },
            onSelectRow: (kota, element) => {
                $('#crudForm [name=sampai_id]').first().val(kota.id)
                pilihKotaSampaiId = kota.id
                element.val(kota.keterangan)
                element.data('currentValue', element.val())
                // getGaji()
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=sampai_id]').first().val('')

                pilihKotaSampaiId = 0
                element.val('')
                element.data('currentValue', element.val())
                // getGaji()
            }
        })

        $('.pelanggan-lookup').lookup({
            title: 'Shipper Lookup',
            fileName: 'pelanggan',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (pelanggan, element) => {
                $('#crudForm [name=pelanggan_id]').first().val(pelanggan.id)
                pelangganId = pelanggan.id

                element.val(pelanggan.namapelanggan)
                element.data('currentValue', element.val())
                clearJobTrucking()
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=pelanggan_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
                clearJobTrucking()
            }
        })

        $('.container-lookup').lookup({
            title: 'Container Lookup',
            fileName: 'container',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (container, element) => {
                $('#crudForm [name=container_id]').first().val(container.id)
                containerId = container.id
                element.val(container.keterangan)
                element.data('currentValue', element.val())
                clearJobTrucking()
                enabledUpahSupir()
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
                enabledUpahSupir()
            },
            onClear: (element) => {
                $('#crudForm [name=container_id]').first().val('')
                $('#crudForm [name=upah_id]').val('')
                $('#crudForm [name=upah]').val('').data('currentValue', '')
                enabledUpahSupir()
                clearUpahSupir()
                element.val('')
                element.data('currentValue', element.val())
                clearJobTrucking()
            }
        })


        $('.statuscontainer-lookup').lookup({
            title: 'Status Container Lookup',
            fileName: 'statuscontainer',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (statuscontainer, element) => {
                $('#crudForm [name=statuscontainer_id]').first().val(statuscontainer.id)
                statuscontainerId = statuscontainer.id
                kodeStatusContainer = statuscontainer.kodestatuscontainer
                element.val(statuscontainer.keterangan)
                element.data('currentValue', element.val())
                enabledUpahSupir()
                if (statuscontainer.kodestatuscontainer == 'FULL EMPTY') {
                    let jobtrucking = $('#crudForm [name=jobtrucking]')
                    let labeljobtrucking = $('#crudForm [name=labeljobtrucking]')
                    jobtrucking.attr('hidden', true)
                    labeljobtrucking.attr('hidden', true)
                    jobtrucking.parents('.input-group').find('.input-group-append').hide()
                    jobtrucking.parents('.input-group').find('.button-clear').hide()
                } else {

                    clearJobTrucking()
                }
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
                enabledUpahSupir()
            },
            onClear: (element) => {
                $('#crudForm [name=statuscontainer_id]').first().val('')
                $('#crudForm [name=upah_id]').val('')
                $('#crudForm [name=upah]').val('').data('currentValue', '')
                enabledUpahSupir()
                clearUpahSupir()
                element.val('')
                element.data('currentValue', element.val())
                clearJobTrucking()
            }
        })

        $('.trado-lookup').lookup({
            title: 'Trado Lookup',
            fileName: 'trado',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (trado, element) => {
                $('#crudForm [name=trado_id]').first().val(trado.id)
                tradoId = trado.id

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
        $('.absensisupirdetail-lookup').lookup({
            title: 'Trado Lookup',
            fileName: 'absensisupirdetail',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {
                    tgltrip: $('#crudForm [name=tglbukti]').val(),
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (absensi, element) => {
                console.log(absensi);
                $('#crudForm [name=trado_id]').first().val(absensi.trado_id)
                $('#crudForm [name=supir_id]').first().val(absensi.supir_id)
                $('#crudForm [name=absensidetail_id]').first().val(absensi.id)
                tradoId = absensi.trado_id
                element.val(absensi.trado)
                element.data('currentValue', element.val())
                getInfoTrado(tradoId)
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=trado_id]').first().val('')
                $('#crudForm [name=supir_id]').first().val('')
                $('#crudForm [name=absensidetail_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.gandengan-lookup').lookup({
            title: 'Gandengan Lookup',
            fileName: 'gandengan',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (gandengan, element) => {
                $('#crudForm [name=gandengan_id]').first().val(gandengan.id)
                if ($('#crudForm [name=gandenganasal_id]').val() == '') {
                    gandenganId = gandengan.id
                }
                element.val(gandengan.keterangan)
                element.data('currentValue', element.val())
                clearJobTrucking()
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=gandengan_id]').first().val('')
                element.val('')
                if ($('#crudForm [name=gandenganasal_id]').val() == '') {
                    gandenganId = 0
                }
                element.data('currentValue', element.val())
                clearJobTrucking()
            }
        })
        $('.agen-lookup').lookup({
            title: 'Customer Lookup',
            fileName: 'agen',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (agen, element) => {
                $('#crudForm [name=agen_id]').first().val(agen.id)
                element.val(agen.namaagen)
                element.data('currentValue', element.val())
                clearJobTrucking()
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=agen_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
                clearJobTrucking()
            }
        })

        $('.jenisorder-lookup').lookup({
            title: 'Jenis Order Lookup',
            fileName: 'jenisorder',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (jenisorder, element) => {
                $('#crudForm [name=jenisorder_id]').first().val(jenisorder.id)
                jenisorderId = jenisorder.id
                element.val(jenisorder.keterangan)
                element.data('currentValue', element.val())
                enabledUpahSupir()
                clearJobTrucking()
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
                enabledUpahSupir()
            },
            onClear: (element) => {
                $('#crudForm [name=jenisorder_id]').first().val('')
                $('#crudForm [name=upah_id]').val('')
                $('#crudForm [name=upah]').val('').data('currentValue', '')
                enabledUpahSupir()
                clearUpahSupir()
                element.val('')
                element.data('currentValue', element.val())
                clearJobTrucking()
            }
        })

        $('.tarifrincian-lookup').lookup({
            title: 'Tarif Rincian Lookup',
            fileName: 'tarifrincian',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {
                    Aktif: 'AKTIF',
                    container_Id: containerId,
                }
            },
            onSelectRow: (tarifrincian, element) => {
                $('#crudForm [name=tarifrincian_id]').first().val(tarifrincian.id)
                $('#crudForm [name=penyesuaian]').val(tarifrincian.penyesuaian)
                tarifrincianId = tarifrincian.id
                element.val(tarifrincian.tujuan)
                element.data('currentValue', element.val())
                getTarifOmset(tarifrincian.id)
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=tarifrincian_id]').val('')
                $('#crudForm [name=omset]').first().val('')
                $('#crudForm [name=penyesuaian]').val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.upahsupirrincian-lookup').lookup({
            title: 'Upah Supir Lookup',
            fileName: 'upahsupirrincian',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {
                    Aktif: 'AKTIF',
                    container_Id: containerId,
                    statuscontainer_Id: statuscontainerId,
                    jenisorder_Id: jenisorderId,
                    statusUpahZona: statusUpahZona
                }
            },
            onSelectRow: (upahsupir, element) => {
                $('#crudForm [name=upah_id]').val(upahsupir.id)
                if (selectedUpahZona == 'NON UPAH ZONA') {

                    $('#crudForm [name=tarifrincian_id]').val(upahsupir.tarif_id)
                    $('#crudForm [name=tarifrincian]').val(upahsupir.tarif)
                    $('#crudForm [name=penyesuaian]').val(upahsupir.penyesuaian)
                    $('#crudForm [name=dari_id]').val(upahsupir.kotadari_id)
                    $('#crudForm [name=dari]').val(upahsupir.kotadari)
                    $('#crudForm [name=sampai_id]').val(upahsupir.kotasampai_id)
                    $('#crudForm [name=sampai]').val(upahsupir.kotasampai)
                    element.val(`${upahsupir.kotadari} - ${upahsupir.kotasampai}`)

                    tarifrincianId = upahsupir.tarif_id
                    if (kodeStatusContainer != 'FULL EMPTY') {
                        getpelabuhan(upahsupir.kotadari_id)
                    }
                } else {
                    zonadariId = upahsupir.zonadari_id
                    zonasampaiId = upahsupir.zonasampai_id

                    element.val(`${upahsupir.zonadari} - ${upahsupir.zonasampai}`)
                }
                kotaUpahZona()
                clearJobTrucking()
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
                // enabledKota()
            },
            onClear: (element) => {
                $('#crudForm [name=upah_id]').val('')
                clearUpahSupir()
                element.val('')
                element.data('currentValue', element.val())
                clearJobTrucking()
            }
        })

        $('.gandenganasal-lookup').lookup({
            title: 'Gandengan Asal Lookup',
            fileName: 'gandengan',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

                    Aktif: 'AKTIF',
                    Asal: 'YA'
                }
            },
            onSelectRow: (gandengan, element) => {
                $('#crudForm [name=gandenganasal_id]').first().val(gandengan.id)
                gandenganId = gandengan.id

                element.val(gandengan.keterangan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=gandenganasal_id]').first().val('')
                if ($('#crudForm [name=gandengan_id]') != '') {
                    gandenganId = $('#crudForm [name=gandengan_id]').val()
                } else {
                    gandenganId = 0
                }
                element.val('')
                element.data('currentValue', element.val())
            }
        })

    }


    function getpelabuhan(id) {
        $.ajax({
            url: `${apiUrl}suratpengantar/${id}/getpelabuhan`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                'Authorization': `Bearer ${accessToken}`
            },
            success: response => {
                // console.log('test')
                // console.log(response.data.status)
                statuspelabuhan = response.data.status
                setJobReadOnly()

                // console.log(statustas)
            },
            error: error => {
                showDialog(error.statusText)
            }
        })
    }


    function setJobReadOnly() {

        let jobtrucking = $('#crudForm [name=jobtrucking]')
        let labeljobtrucking = $('#crudForm [name=labeljobtrucking]')
        if (statuspelabuhan == '0') {
            // console.log('bukan');
            jobtrucking.attr('hidden', true)
            labeljobtrucking.attr('hidden', true)
            jobtrucking.parents('.input-group').find('.input-group-append').hide()
            jobtrucking.parents('.input-group').find('.button-clear').hide()
        } else {
            labeljobtrucking.attr('hidden', false)
            jobtrucking.attr('hidden', false)
            jobtrucking.parents('.input-group').find('.input-group-append').show()
            jobtrucking.parents('.input-group').find('.button-clear').show()
        }
    }


    function getInfoTrado(trado) {
        $.ajax({
            url: `${apiUrl}inputtrip/getinfo`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                'Authorization': `Bearer ${accessToken}`
            },
            data: {
                trado_id: trado,
                upah_id: $('#crudForm').find(`[name="upah_id"]`).val(),
                statuscontainer_id: $('#crudForm').find(`[name="statuscontainer_id"]`).val()
            },
            success: response => {
                $('.tableInfo').show()
                $('#infoTrado').html('')
                $.each(response.data, (index, detail) => {
                    let detailRow = $(`
              <tr>
                <td> ${detail.status} </td>
                <td> ${detail.kmperjalanan} </td>
                <td> ${detail.kmtotal} </td>
              </tr>
            `)

                    $('#infoTrado').append(detailRow)
                })
            },
            error: error => {
                showDialog(error.statusText)
            }
        })
    }
</script>
@endpush()