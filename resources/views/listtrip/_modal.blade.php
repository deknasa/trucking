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
                        <input type="hidden" name="id">


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
                        <div class="form-group statusjeniskendaraan">
                            <label class="col-sm-12 col-form-label">STATUS JENIS KENDARAAN <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <select name="statusjeniskendaraan" class="form-control select2bs4" id="statusjeniskendaraan">
                                    <option value="">-- PILIH STATUS JENIS KENDARAAN --</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group jenissuratpengantar">
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

                        <div class="form-group gudangsama">
                            <label class="col-sm-12 col-form-label">GUDANG SAMA <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <select name="statusgudangsama" class="form-control select2bs4" id="statusgudangsama">
                                    <option value="">-- PILIH STATUS GUDANG SAMA --</option>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="form-group statuskandang">
                            <label class="col-sm-12 col-form-label">STATUS KANDANG <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <select name="statuskandang" class="form-control select2bs4" id="statuskandang">
                                    <option value="">-- PILIH STATUS KANDANG--</option>
                                </select>
                            </div>
                        </div> -->
                        <div class="form-group statuspenyesuaian">
                            <label class="col-sm-12 col-form-label">STATUS PENYESUAIAN <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <select name="statuspenyesuaian" class="form-control select2bs4" id="statuspenyesuaian">
                                    <option value="">-- PILIH STATUS PENYESUAIAN--</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group ">
                            <label class="col-sm-12 col-form-label">CUSTOMER <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="hidden" name="agen_id">
                                <input type="text" name="agen" class="form-control agen-lookup">
                            </div>
                        </div>

                        <div class="form-group jenisorder">
                            <label class="col-sm-12 col-form-label">JENIS ORDERAN <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="hidden" name="jenisorder_id">
                                <input type="text" name="jenisorder" class="form-control jenisorder-lookup">
                            </div>
                        </div>

                        <div class="form-group statuscontainer">
                            <label class="col-sm-12 col-form-label">FULL / EMPTY <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="hidden" name="statuscontainer_id">
                                <input type="text" name="statuscontainer" class="form-control statuscontainer-lookup">
                            </div>
                        </div>

                        <div class="form-group containers">
                            <label class="col-sm-4 col-form-label">CONTAINER <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="hidden" name="container_id">
                                <input type="text" name="container" class="form-control container-lookup">
                            </div>
                        </div>

                        <div id="tripasalpulanglongtrip">

                        </div>

                        <div id="kotaLongtrip">

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

                        <div id="kotaTrip">
                            <div class="form-group dari">
                                <label class="col-sm-4 col-form-label">DARI <span class="text-danger">*</span></label>
                                <div class="col-sm-12">
                                    <input type="hidden" name="dari_id">
                                    <input type="text" name="dari" class="form-control kotadari-lookup" readonly>
                                </div>
                            </div>

                            <div class="form-group sampai">
                                <label class="col-sm-12 col-form-label">Sampai <span class="text-danger">*</span></label>
                                <div class="col-sm-12">
                                    <input type="hidden" name="sampai_id">
                                    <input type="text" name="sampai" class="form-control kotasampai-lookup" readonly>
                                </div>
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
                        <div class="form-group triptangki">
                            <label class="col-sm-12 col-form-label">TRIP TANGKI <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="hidden" name="triptangki_id">
                                <input type="text" name="triptangki" class="form-control triptangki-lookup">
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

                        <div id="tripasallongtrip">
                            <div class="form-group nobukti_tripasal">
                                <label class="col-sm-12 col-form-label">TRIP ASAL</label>
                                <div class="col-sm-12">
                                    <input type="text" name="nobukti_tripasal" class="form-control suratpengantar-lookup">
                                </div>
                            </div>
                        </div>

                        <div class="form-group jobtrucking">
                            <label name="labeljobtrucking" class="col-sm-12 col-form-label">NO JOB TRUCKING
                                {{-- <span class="text-danger">*</span> --}}
                            </label>
                            <div class="col-sm-12">
                                <input type="text" name="jobtrucking" class="form-control jobtrucking-lookup">
                            </div>
                        </div>

                        <div class="form-group gudang">
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
    let isPulangLongtrip;
    let isGudangSama = true;
    let statusJenisKendaran
    let indexRitasi = 0;


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
                name: 'statusjeniskendaraan',
                value: $('#crudForm').find(`[name="statusjeniskendaraan"]`).val()
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
    $(document).on('change', `#crudForm [name="statusjeniskendaraan"]`, function(event) {

        let statusjeniskendaraan = $(`#crudForm [name="statusjeniskendaraan"] option:selected`).text()
        statusJenisKendaran = statusjeniskendaraan
        if (statusjeniskendaraan == 'TANGKI') {
            $('.jenissuratpengantar').hide()
            $('.gudangsama').hide()
            $('.statuskandang').hide()
            $('.jenisorder').hide()
            $('.jenisorder').find('[name=jenisorder_id]').val('')
            $('.jenisorder').find('[name=jenisorder]').val('')
            $('.statuscontainer').hide()
            $('.statuscontainer').find('[name=statuscontainer_id]').val('')
            $('.statuscontainer').find('[name=statuscontainer]').val('')
            $('.containers').hide()
            $('.containers').find('[name=container_id]').val('')
            $('.containers').find('[name=container]').val('')
            $('.jobtrucking').hide()
            $('.jobtrucking').find('[name=jobtrucking]').val('')
            $('.gudang').hide()
            $('.gudang').find('[name=gudang]').val('')
            $('.gandengan').show()
            $('.gandengan').find('label').text('No Tangki')
            let upahsupir = $('#crudForm [name=upah]')
            upahsupir.val('')
            upahsupir.data('currentValue', '')
            $('#crudForm [name=upah_id]').val('')
            upahsupir.attr('readonly', false)
            upahsupir.parents('.input-group').find('.input-group-append').show()
            upahsupir.parents('.input-group').find('.button-clear').show()
            $('#crudForm [name=dari]').val('')
            $('#crudForm [name=dari_id]').val('')
            $('#crudForm [name=sampai]').val('')
            $('#crudForm [name=sampai_id]').val('')
            $('#crudForm [name=tarifrincian]').val('')
            $('#crudForm [name=tarifrincian_id]').val('')
            $('#crudForm [name=penyesuaian]').val('')
            containerId = 0
            statuscontainerId = 0
            jenisorderId = 0
        }
        if (statusjeniskendaraan == 'GANDENGAN') {

            $('.jenissuratpengantar').show()
            $('.gudangsama').show()
            $('.statuskandang').show()
            $('.jenisorder').show()
            $('.statuscontainer').show()
            $('.containers').show()
            $('.jobtrucking').show()
            $('.gudang').show()
            if (accessCabang != 'MEDAN') {
                $('.gandengan').hide()
            }
            $('.triptangki').hide()
            $('.gandengan').find('label').text('No GANDENGAN / CHASIS')
            if (accessCabang == 'MEDAN') {
                let textDanger = $(`<span class="text-danger">*</span>`)
                textDanger.appendTo($('.gandengan').find('label'))
            }
            let upahsupir = $('#crudForm [name=upah]')

            upahsupir.val('')
            upahsupir.data('currentValue', '')
            $('#crudForm [name=upah_id]').val('')
            upahsupir.attr('readonly', true)
            upahsupir.parents('.input-group').find('.input-group-append').hide()
            upahsupir.parents('.input-group').find('.button-clear').hide()

            $('#crudForm [name=dari]').val('')
            $('#crudForm [name=dari_id]').val('')
            $('#crudForm [name=sampai]').val('')
            $('#crudForm [name=sampai_id]').val('')
            $('#crudForm [name=triptangki]').val('')
            $('#crudForm [name=triptangki_id]').val('')
            $('#crudForm [name=tarifrincian]').val('')
            $('#crudForm [name=tarifrincian_id]').val('')
            $('#crudForm [name=penyesuaian]').val('')
        }
    })
    $(document).on('change', `#crudForm [name="statuspenyesuaian"]`, function(event) {
        if ($(`#crudForm [name="statuspenyesuaian"]`).val() != '') {
            $('#crudForm [name=upah]').data('currentValue', '')
            $('#crudForm [name=upah]').val('')
            $('#crudForm [name=upah_id]').val('')
            clearUpahSupir()
        }
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
        indexRitasi = 0
        removeEditingBy($('#crudForm').find('[name=id]').val())
        $('#crudModal').find('.modal-body').html(modalBody)
    })

    function removeEditingBy(id) {
        let formData = new FormData();


        formData.append('id', id);
        formData.append('aksi', 'BATAL');
        formData.append('table', 'suratpengantar');

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

    $(document).on('change', `#crudForm [name="statusgudangsama"]`, function(event) {
        enableTripAsal()
        setJobReadOnly()
    })

    $(document).on('change', `#crudForm [name="statuskandang"]`, function(event) {
        // if ($(`#crudForm [name="statuskandang"]`).val() == 600){
        $('#crudForm [name=upah]').data('currentValue', '')
        $('#crudForm [name=upah]').val('')
        $('#crudForm [name=upah_id]').val('')
        clearUpahSupir()
        // }
    })

    $(document).on('change', `#crudForm [name="statuslongtrip"]`, function(event) {
        let statuslongtrip = $(`#crudForm [name="statuslongtrip"]`).val()

        if (statuslongtrip == 65) {
            // $('.nobukti_tripasal').hide()
            // clearTripAsal()
            isPulangLongtrip = false;
        }
        moveKotaUpah(statuslongtrip)
        enableTripAsalLongTrip()
        clearUpahSupir()
        setJobReadOnly()
    })

    $(`#crudForm [name="statuslangsir"]`).on('change', function(event) {
        let statuslangsir = $(`#crudForm [name="statuslangsir"]`).val()
        moveKotaLangsir(statuslangsir)
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
            // kotaUpahZona()
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


    function moveKotaUpah(statuslongtrip) {
        let kotadari_id = $('#crudForm [name=dari]')
        let kotasampai_id = $('#crudForm [name=sampai]')
        if (statuslongtrip == 65) {
            $(".nobukti_tripasal").appendTo("#tripasalpulanglongtrip");
            $('.nobukti_tripasal').show()
            $('[name=nobukti_tripasal]').val('')
            $('[name=nobukti_tripasal]').data('currentValue', '')
            kotadari_id.attr('readonly', true)
            kotasampai_id.attr('readonly', false)
            kotadari_id.parents('.input-group').find('.input-group-append').hide()
            kotadari_id.parents('.input-group').find('.button-clear').hide()
            kotasampai_id.parents('.input-group').find('.input-group-append').show()
            kotasampai_id.parents('.input-group').find('.button-clear').show()
            $(".dari").appendTo("#kotaLongtrip");
            $(".sampai").appendTo("#kotaLongtrip");
        }

        if (statuslongtrip == 66) {
            $('[name=nobukti_tripasal]').val('')
            $('[name=nobukti_tripasal]').data('currentValue', '')
            kotadari_id.attr('readonly', true)
            kotasampai_id.attr('readonly', true)
            kotadari_id.parents('.input-group').find('.input-group-append').hide()
            kotadari_id.parents('.input-group').find('.button-clear').hide()
            kotasampai_id.parents('.input-group').find('.input-group-append').hide()
            kotasampai_id.parents('.input-group').find('.button-clear').hide()
            $(".dari").appendTo("#kotaTrip");
            $(".sampai").appendTo("#kotaTrip");

        }

    }


    function moveKotaLangsir(statuslangsir) {
        let kotadari_id = $('#crudForm [name=dari]')
        let kotasampai_id = $('#crudForm [name=sampai]')
        if (statuslangsir == 79) {
            kotadari_id.attr('readonly', false)
            kotasampai_id.attr('readonly', false)
            kotadari_id.parents('.input-group').find('.input-group-append').show()
            kotadari_id.parents('.input-group').find('.button-clear').show()
            kotasampai_id.parents('.input-group').find('.input-group-append').show()
            kotasampai_id.parents('.input-group').find('.button-clear').show()
            $(".dari").appendTo("#kotaLongtrip");
            $(".sampai").appendTo("#kotaLongtrip");
        }

        if (statuslangsir == 80) {
            if ($('#crudForm [name=statuslongtrip]').val() != 65) {

                kotadari_id.attr('readonly', true)
                kotasampai_id.attr('readonly', true)
                kotadari_id.parents('.input-group').find('.input-group-append').hide()
                kotadari_id.parents('.input-group').find('.button-clear').hide()
                kotasampai_id.parents('.input-group').find('.input-group-append').hide()
                kotasampai_id.parents('.input-group').find('.button-clear').hide()
                $(".dari").appendTo("#kotaTrip");
                $(".sampai").appendTo("#kotaTrip");

            }
        }
    }

    function clearUpahSupir() {

        if ($('#crudForm [name=statuslangsir]').val() != 79) {
            $('#crudForm [name=dari_id]').val('')
            $('#crudForm [name=sampai_id]').val('')
            $('#crudForm [name=dari]').val('')
            $('#crudForm [name=sampai]').val('')
        }
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
                setStatusJenisKendaraanOptions(form),
                setStatusLongTripOptions(form),
                setStatusGudangSamaOptions(form),
                setStatusLangsirOptions(form),
                setStatusGandenganOptions(form),
                // setStatusKandangOptions(form),
                setStatusPenyesuaianOptions(form),
                setTampilan(form)
            ])
            .then(() => {
                showTrip(form, Id)
                    .then(() => {
                        $('#crudModal').modal('show')
                        $('#crudForm [name=upah]').attr('readonly', false)
                        // kotaUpahZona()
                        if ($('#crudForm [name=dari]').val() != 'KANDANG') {
                            setJobReadOnly()
                        }
                        $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', true)

                        $('#crudForm').find('[name=statusjeniskendaraan]').attr('disabled', 'disabled').css({
                            background: '#fff'
                        })
                        if ($('#crudForm [name=nobukti_tripasal]').val() != '') {
                            setJobTruckingFromTripAsal()
                            $('#crudForm [name=pelanggan]').parents('.input-group').find('.input-group-append').hide()
                            $('#crudForm [name=pelanggan]').parents('.input-group').find('.button-clear').hide()
                            $('#crudForm [name=gandengan]').parents('.input-group').find('.input-group-append').hide()
                            $('#crudForm [name=gandengan]').parents('.input-group').find('.button-clear').hide()
                            if ($('#crudForm [name=dari]').val() == 'KANDANG') {
                                $('#crudForm [name=pelanggan]').parents('.input-group').find('.input-group-append').show()
                                $('#crudForm [name=pelanggan]').parents('.input-group').find('.button-clear').show()
                                $('#crudForm [name=gandengan]').parents('.input-group').find('.input-group-append').show()
                                $('#crudForm [name=gandengan]').parents('.input-group').find('.button-clear').show()
                            }

                        }
                        if ($('#crudForm [name=statuslongtrip]').val() == 65) {

                            $(".dari").appendTo("#kotaLongtrip");
                            $(".sampai").appendTo("#kotaLongtrip");

                            let kotadari_id = $('#crudForm [name=dari]')
                            let kotasampai_id = $('#crudForm [name=sampai]')

                            kotadari_id.attr('readonly', true)
                            kotasampai_id.attr('readonly', false)
                            kotadari_id.parents('.input-group').find('.input-group-append').hide()
                            kotadari_id.parents('.input-group').find('.button-clear').hide()
                            kotasampai_id.parents('.input-group').find('.input-group-append').show()
                            kotasampai_id.parents('.input-group').find('.button-clear').show()
                        }
                        moveKotaLangsir($('#crudForm [name=statuslangsir]').val())
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
                setStatusJenisKendaraanOptions(form),
                setStatusLongTripOptions(form),
                setStatusGudangSamaOptions(form),
                setStatusLangsirOptions(form),
                setStatusGandenganOptions(form),
                // setStatusKandangOptions(form),
                setStatusPenyesuaianOptions(form),
                setTampilan(form)
            ])
            .then(() => {
                showTrip(form, Id)
                    .then(() => {
                        $('#crudModal').modal('show')
                        $('#crudForm [name=upah]').attr('readonly', false)

                        if ($('#crudForm [name=dari]').val() != 'KANDANG') {
                            kotaUpahZona()
                        }
                        setJobReadOnly()
                        if ($('#crudForm [name=nobukti_tripasal]').val() != '') {
                            setJobTruckingFromTripAsal()
                        }
                        moveKotaLangsir($('#crudForm [name=statuslangsir]').val())
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
                setStatusJenisKendaraanOptions(form),
                setStatusLongTripOptions(form),
                setStatusGudangSamaOptions(form),
                setStatusLangsirOptions(form),
                setStatusGandenganOptions(form),
                // setStatusKandangOptions(form),
                setStatusPenyesuaianOptions(form),
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
                        if ($('#crudForm [name=nobukti_tripasal]').val() != '') {
                            setJobTruckingFromTripAsal()
                        }
                        moveKotaLangsir($('#crudForm [name=statuslangsir]').val())
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
                        (index == 'nobukti_tripasal') ? element.data('current-value', value): '';
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
                    form.find(`[name="jobtrucking"]`).val(response.data.jobtrucking)
                    form.find(`[name="jobtrucking"]`).data('current-value', response.data.jobtrucking)
                    getInfoTrado(response.data.trado_id)
                    if (response.data.statusgudangsama == 204) {
                        if (isTripAsal) {
                            if (jenisorderId == 1 || jenisorderId == 4) {
                                $('.nobukti_tripasal').show()
                            } else {
                                $('.nobukti_tripasal').hide()
                            }
                        }
                    } else {
                        $('.nobukti_tripasal').hide()
                    }
                    if (form.data('action') === 'delete') {
                        form.find('[name]').addClass('disabled')
                        initDisabled()
                    }

                    let statuslongtrip = $(`#crudForm [name="statuslongtrip"]`).val()
                    let jenisorder_id = $('#crudForm [name=jenisorder_id]').val()
                    let statuscontainer_id = $('#crudForm [name=statuscontainer_id]').val()
                    if (statuslongtrip == 66) {
                        if ((jenisorder_id == 2 && statuscontainer_id == 2) || (jenisorder_id == 3 && statuscontainer_id == 2) || (jenisorder_id == 1 && statuscontainer_id == 1) || (jenisorder_id == 4 && statuscontainer_id == 1)) {
                            $(".nobukti_tripasal").appendTo("#tripasalpulanglongtrip");
                            $('.nobukti_tripasal').show()
                            if ($('#crudForm [name=nobukti_tripasal]').val() != '') {

                                $('#crudForm [name=pelanggan]').attr('readonly', true)
                                $('#crudForm [name=gandengan]').attr('readonly', true)
                            }
                            isPulangLongtrip = true;
                        } else {
                            $('.nobukti_tripasal').hide()
                            isPulangLongtrip = false;
                        }
                    } else {
                        if ((jenisorder_id == 2 && statuscontainer_id == 1) || (jenisorder_id == 3 && statuscontainer_id == 1) || (jenisorder_id == 1 && statuscontainer_id == 2) || (jenisorder_id == 1 && statuscontainer_id == 1) || (jenisorder_id == 4 && statuscontainer_id == 2)) {
                            $(".nobukti_tripasal").appendTo("#tripasalpulanglongtrip");
                            $('.nobukti_tripasal').show()
                            isPulangLongtrip = false;
                        } else {

                            $('.nobukti_tripasal').hide()
                            isPulangLongtrip = false;
                        }
                    }

                    if (response.data.dari == 'KANDANG') {
                        $('.nobukti_tripasal').show()
                        $(".nobukti_tripasal").appendTo("#tripasallongtrip");
                    }
                    if (accessCabang == 'MEDAN') {
                        if (response.data.statusgerobak == 246) {
                            $('.gandengan').hide()
                        } else {
                            $('.gandengan').show()
                        }
                    }
                    if (response.detail.length == 0) {
                        addRow()
                    } else {

                        $.each(response.detail, (index, detail) => {
                            let detailRow = $(`   
                            <tr>
                                <td></td>
                                <td>
                                    <input type="hidden" name="jenisritasi_id[]" id="jenisritasi_id_${index}">
                                    <input type="text" name="jenisritasi[]" class="form-control dataritasi-lookup" data-current-value="${detail.jenisritasi}" id="jenisritasi_${index}">
                                </td>
                                <td>
                                    <input type="hidden" name="ritasidari_id[]">
                                    <input type="text" name="ritasidari[]" class="form-control ritasidari-lookup" data-current-value="${detail.ritasidari}" readonly>
                                </td>
                                <td>
                                    <input type="hidden" name="ritasike_id[]">
                                    <input type="text" name="ritasike[]" class="form-control ritasike-lookup" data-current-value="${detail.ritasike}" readonly>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                                </td>
                            </tr>
                            `)
                            detailRow.find(`[name="jenisritasi_id[]"]`).val(detail.jenisritasi_id)
                            detailRow.find(`[name="jenisritasi[]"]`).val(detail.jenisritasi)
                            detailRow.find(`[name="ritasidari_id[]"]`).val(detail.ritasidari_id)
                            detailRow.find(`[name="ritasidari[]"]`).val(detail.ritasidari)
                            detailRow.find(`[name="ritasike_id[]"]`).val(detail.ritasike_id)
                            detailRow.find(`[name="ritasike[]"]`).val(detail.ritasike)

                            $('#ritasiList tbody').append(detailRow)
                            $(`.ritasidari-lookup`).last().lookup({
                                title: 'RITASI DARI Lookup',
                                fileName: 'kota',
                                beforeProcess: function() {
                                    console.log(this)
                                    this.postData = {
                                        Aktif: 'AKTIF',
                                        DataRitasi: dataRitasiId[`jenisritasi_${index}`],
                                        RitasiDariKe: 'dari',
                                        pilihkota_id: pilihKotaSampaiId
                                    }
                                },
                                onSelectRow: (kota, element) => {
                                    element.parents('td').find(`[name="ritasidari_id[]"]`).val(kota.id)
                                    pilihKotaDariId = kota.id
                                    element.val(kota.kodekota)
                                    element.data('currentValue', element.val())
                                },
                                onCancel: (element) => {
                                    element.val(element.data('currentValue'))
                                },
                                onClear: (element) => {
                                    element.parents('td').find(`[name="ritasidari_id[]"]`).val('')
                                    pilihKotaDariId = 0
                                    element.val('')
                                    element.data('currentValue', element.val())
                                }
                            })

                            $(`.ritasike-lookup`).last().lookup({
                                title: 'RITASI KE Lookup',
                                fileName: 'kota',
                                beforeProcess: function(test) {
                                    this.postData = {
                                        Aktif: 'AKTIF',
                                        DataRitasi: dataRitasiId[`jenisritasi_${index}`],
                                        RitasiDariKe: 'ke',
                                        pilihkota_id: pilihKotaDariId
                                    }
                                },
                                onSelectRow: (kota, element) => {
                                    element.parents('td').find(`[name="ritasike_id[]"]`).val(kota.id)
                                    pilihKotaSampaiId = kota.id
                                    element.val(kota.kodekota)
                                    element.data('currentValue', element.val())
                                },
                                onCancel: (element) => {
                                    element.val(element.data('currentValue'))
                                },
                                onClear: (element) => {
                                    element.parents('td').find(`[name="ritasike_id[]"]`).val('')
                                    pilihKotaSampaiId = 0
                                    element.val('')
                                    element.data('currentValue', element.val())
                                }
                            })

                            $('.dataritasi-lookup').last().lookup({
                                title: 'Data Ritasi Lookup',
                                fileName: 'dataritasi',
                                beforeProcess: function(test) {
                                    // var levelcoa = $(`#levelcoa`).val();
                                    this.postData = {

                                        Aktif: 'AKTIF',
                                    }
                                },
                                onSelectRow: (dataRitasi, element) => {
                                    element.parents('td').find(`[name="jenisritasi_id[]"]`).val(dataRitasi.id)
                                    element.val(dataRitasi.statusritasi)
                                    element.data('currentValue', element.val())
                                    getKotaRitasi(dataRitasi.statusritasi_id, element, element.attr("id"))
                                },
                                onCancel: (element) => {
                                    element.val(element.data('currentValue'))
                                },
                                onClear: (element) => {
                                    element.parents('td').find(`[name="jenisritasi_id[]"]`).val('')
                                    element.parents('tr').find(`td [name="ritasidari_id[]"]`).val('')
                                    element.parents('tr').find(`td [name="ritasidari[]"]`).val('').data('currentValue', '').attr("readonly", true)
                                    element.parents('tr').find(`td [name="ritasike_id[]"]`).val('')
                                    element.parents('tr').find(`td [name="ritasike[]"]`).val('').data('currentValue', '').attr("readonly", true)

                                    element.val('')
                                    element.data('currentValue', element.val())
                                    let ritDari = element.parents('tr').find(`td [name="ritasidari[]"]`).parents('.input-group')
                                    ritDari.find('.button-clear').attr('disabled', true)
                                    ritDari.children().find('.lookup-toggler').attr('disabled', true)

                                    let ritKe = element.parents('tr').find(`td [name="ritasike[]"]`).parents('.input-group')
                                    ritKe.find('.button-clear').attr('disabled', true)
                                    ritKe.children().find('.lookup-toggler').attr('disabled', true)

                                }
                            })
                            if (detail.jenisritasi_id == 3) {
                                detailRow.find(`[name="ritasidari[]"]`).prop('readonly', false)
                                detailRow.find(`[name="ritasike[]"]`).prop('readonly', false)
                                let ritDari = detailRow.find(`[name="ritasidari[]"]`).parents('.input-group')
                                ritDari.find('.button-clear').attr('disabled', false)
                                ritDari.children().find('.lookup-toggler').attr('disabled', false)

                                let ritKe = detailRow.find(`[name="ritasike[]"]`).parents('.input-group')
                                ritKe.find('.button-clear').attr('disabled', false)
                                ritKe.children().find('.lookup-toggler').attr('disabled', false)

                            } else {

                                let ritDari = detailRow.find(`[name="ritasidari[]"]`).parents('.input-group')
                                ritDari.find('.button-clear').attr('disabled', true)
                                ritDari.children().find('.lookup-toggler').attr('disabled', true)

                                let ritKe = detailRow.find(`[name="ritasike[]"]`).parents('.input-group')
                                ritKe.find('.button-clear').attr('disabled', true)
                                ritKe.children().find('.lookup-toggler').attr('disabled', true)

                            }
                            indexRitasi = index

                        })

                    }
                    setRowNumbers()
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function getKotaRitasi(ritasiId, element, jenisritasi_id) {
        $.ajax({
            url: `${apiUrl}inputtrip/getKotaRitasi`,
            method: 'GET',
            dataType: 'JSON',
            data: {
                dataritasi_id: ritasiId
            },
            headers: {
                'Authorization': `Bearer ${accessToken}`
            },
            success: response => {
                if (response.data.length != 0) {
                    element.parents('tr').find(`td [name="ritasidari_id[]"]`).val(response.data.dari_id)
                    element.parents('tr').find(`td [name="ritasidari[]"]`).val(response.data.dari).data('currentValue', response.data.dari)
                    element.parents('tr').find(`td [name="ritasike_id[]"]`).val(response.data.sampai_id)
                    element.parents('tr').find(`td [name="ritasike[]"]`).val(response.data.sampai).data('currentValue', response.data.sampai)
                } else {


                    let ritDari = element.parents('tr').find(`td [name="ritasidari[]"]`).parents('.input-group')
                    ritDari.find('.button-clear').attr('disabled', false)
                    ritDari.attr('readonly', false)
                    ritDari.find('input').attr('readonly', false)
                    ritDari.children().find('.lookup-toggler').attr('disabled', false)

                    let ritKe = element.parents('tr').find(`td [name="ritasike[]"]`).parents('.input-group')
                    ritKe.find('.button-clear').attr('disabled', false)
                    ritKe.find('input').attr('readonly', false)
                    ritKe.children().find('.lookup-toggler').attr('disabled', false)
                }
                dataRitasiId[jenisritasi_id] = ritasiId
                console.log(dataRitasiId)
            },
            error: error => {
                showDialog(error.statusText)
            }
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
                    showDialog(response.message)
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

    function clearJobTrucking() {
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

    const setStatusJenisKendaraanOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statusjeniskendaraan]').empty()
            relatedForm.find('[name=statusjeniskendaraan]').append(
                new Option('-- PILIH STATUS JENIS KENDARAAN --', '', false, true)
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
                            "data": "STATUS JENIS KENDARAAN"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusJenisKendaraan => {
                        let option = new Option(statusJenisKendaraan.text, statusJenisKendaraan.id)
                        relatedForm.find('[name=statusjeniskendaraan]').append(option).trigger('change')
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

    const setStatusKandangOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statuskandang]').empty()
            relatedForm.find('[name=statuskandang]').append(
                new Option('-- PILIH STATUS KANDANG --', '', false, true)
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
                            "data": "STATUS KANDANG"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusKandang => {
                        let option = new Option(statusKandang.text, statusKandang.id)
                        relatedForm.find('[name=statuskandang]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    const setStatusPenyesuaianOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statuspenyesuaian]').empty()
            relatedForm.find('[name=statuspenyesuaian]').append(
                new Option('-- PILIH STATUS PENYESUAIAN --', '', false, true)
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
                            "data": "STATUS PENYESUAIAN"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusPenyesuaian => {
                        let option = new Option(statusPenyesuaian.text, statusPenyesuaian.id)
                        relatedForm.find('[name=statuspenyesuaian]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function setJobTruckingFromTripAsal() {

        let jobtrucking = $('#crudForm [name=jobtrucking]')
        jobtrucking.attr('readonly', true)
        jobtrucking.parents('.input-group').find('.input-group-append').hide()
        jobtrucking.parents('.input-group').find('.button-clear').hide()
    }

    function setPulangLongtrip(suratpengantar, aksi) {
        if (aksi == 'select') {
            $('#crudForm [name=pelanggan_id]').val(suratpengantar.pelangganid)
            $('#crudForm [name=pelanggan').val(suratpengantar.pelanggan_id)
            $('#crudForm [name=gandengan_id]').val(suratpengantar.gandenganid)
            $('#crudForm [name=gandengan').val(suratpengantar.gandengan_id)
            $('#crudForm [name=pelanggan]').data('currentValue', suratpengantar.pelanggan_id)
            $('#crudForm [name=gandengan]').data('currentValue', suratpengantar.gandengan_id)

            let pelanggan = $('#crudForm [name=pelanggan]')
            pelanggan.attr('readonly', true)
            pelanggan.parents('.input-group').find('.input-group-append').hide()
            pelanggan.parents('.input-group').find('.button-clear').hide()
            let gandengan = $('#crudForm [name=gandengan]')
            gandengan.attr('readonly', true)
            gandengan.parents('.input-group').find('.input-group-append').hide()
            gandengan.parents('.input-group').find('.button-clear').hide()
        } else {

            $('#crudForm [name=pelanggan_id]').val('')
            $('#crudForm [name=pelanggan').val('')
            $('#crudForm [name=gandengan_id]').val('')
            $('#crudForm [name=gandengan').val('')
            $('#crudForm [name=pelanggan]').data('currentValue', '')
            $('#crudForm [name=gandengan]').data('currentValue', '')

            let pelanggan = $('#crudForm [name=pelanggan]')
            pelanggan.attr('readonly', false)
            pelanggan.parents('.input-group').find('.input-group-append').show()
            pelanggan.parents('.input-group').find('.button-clear').show()
            let gandengan = $('#crudForm [name=gandengan]')
            gandengan.attr('readonly', false)
            gandengan.parents('.input-group').find('.input-group-append').show()
            gandengan.parents('.input-group').find('.button-clear').show()
        }

    }

    function initLookup() {
        $('.suratpengantar-lookup').lookup({
            title: 'Surat Pengantar Lookup',
            fileName: 'suratpengantar',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {
                    Aktif: 'AKTIF',
                    container_id: $('#crudForm [name=container_id]').val(),
                    agen_id: $('#crudForm [name=agen_id]').val(),
                    upah_id: $('#crudForm [name=upah_id]').val(),
                    pelanggan_id: $('#crudForm [name=pelanggan_id]').val(),
                    jenisorder_id: $('#crudForm [name=jenisorder_id]').val(),
                    trado_id: $('#crudForm [name=trado_id]').val(),
                    gandengan_id: $('#crudForm [name=gandengan_id]').val(),
                    dari_id: $('#crudForm [name=dari_id]').val(),
                    sampai_id: $('#crudForm [name=sampai_id]').val(),
                    gudangsama: $('#crudForm [name=statusgudangsama]').val(),
                    longtrip: $('#crudForm [name=statuslongtrip]').val(),
                    idTrip: $('#crudForm [name=id]').val(),
                    isGudangSama: isGudangSama
                }
            },
            onSelectRow: (suratpengantar, element) => {
                element.val(suratpengantar.nobukti)
                element.data('currentValue', element.val())
                if ($('#crudForm [name=statusgudangsama]').val() == 205) {

                    if ($('#crudForm [name=dari]').val() != 'KANDANG') {
                        if ($('#crudForm [name=statuslongtrip]').val() == 66) {
                            $('#crudForm [name=jobtrucking]').val(suratpengantar.jobtrucking)
                            $('#crudForm [name=jobtrucking]').data('currentValue', suratpengantar.jobtrucking)
                            setJobTruckingFromTripAsal()
                            setPulangLongtrip(suratpengantar, 'select')
                            clearUpahSupir()
                            $('#crudForm [name=upah_id]').val('')
                            $('#crudForm [name=upah]').val('')
                            $('#crudForm [name=upah]').data('currentValue', '')
                        }
                    }

                    if ($('#crudForm [name=dari]').val() == 'KANDANG') {
                        $('#crudForm [name=jobtrucking]').attr('hidden', false)
                        $('#crudForm [name=labeljobtrucking]').attr('hidden', false)
                        $('#crudForm [name=jobtrucking]').attr('readonly', true)
                        $('#crudForm [name=jobtrucking]').parents('.input-group').find('.input-group-append').hide()
                        $('#crudForm [name=jobtrucking]').parents('.input-group').find('.button-clear').hide()
                    }
                }

                if ($('#crudForm [name=statuslongtrip]').val() == 65) {
                    $('#crudForm [name=dari_id]').val(suratpengantar.sampaiid)
                    $('#crudForm [name=dari]').val(suratpengantar.sampai_id)
                    $('#crudForm [name=gandengan_id]').val(suratpengantar.gandenganid)
                    $('#crudForm [name=gandengan]').val(suratpengantar.gandengan_id)
                    $('#crudForm [name=gandengan]').attr('readonly', true)
                    $('#crudForm [name=gandengan]').parents('.input-group').find('.input-group-append').hide()
                    $('#crudForm [name=gandengan]').parents('.input-group').find('.button-clear').hide()
                    $('#crudForm [name=upah_id]').val('')
                    $('#crudForm [name=upah]').val('')
                    $('#crudForm [name=upah]').data('currentValue', '')
                }
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                element.data('currentValue', element.val())
                if ($('#crudForm [name=statusgudangsama]').val() == 205) {

                    if ($('#crudForm [name=dari]').val() != 'KANDANG') {

                        if ($('#crudForm [name=statuslongtrip]').val() == 66) {
                            $('#crudForm [name=jobtrucking]').val('')
                            $('#crudForm [name=jobtrucking]').data('currentValue', '')
                            $('#crudForm [name=jobtrucking]').attr('readonly', false)
                            $('#crudForm [name=jobtrucking]').parents('.input-group').find('.input-group-append').show()
                            $('#crudForm [name=jobtrucking]').parents('.input-group').find('.button-clear').show()
                            setPulangLongtrip('', 'clear')
                            clearUpahSupir()

                            $('#crudForm [name=upah_id]').val('')
                            $('#crudForm [name=upah]').val('')
                            $('#crudForm [name=upah]').data('currentValue', '')
                        }
                    }

                    if ($('#crudForm [name=dari]').val() == 'KANDANG') {
                        $('#crudForm [name=jobtrucking]').attr('hidden', false)
                        $('#crudForm [name=labeljobtrucking]').attr('hidden', false)
                        $('#crudForm [name=jobtrucking]').attr('readonly', false)
                        $('#crudForm [name=jobtrucking]').parents('.input-group').find('.input-group-append').show()
                        $('#crudForm [name=jobtrucking]').parents('.input-group').find('.button-clear').show()
                    }
                }

                if ($('#crudForm [name=statuslongtrip]').val() == 65) {
                    $('#crudForm [name=dari_id]').val('')
                    $('#crudForm [name=dari]').val('')
                    $('#crudForm [name=gandengan_id]').val('')
                    $('#crudForm [name=gandengan]').val('')
                    $('#crudForm [name=gandengan]').attr('readonly', false)
                    $('#crudForm [name=gandengan]').parents('.input-group').find('.input-group-append').show()
                    $('#crudForm [name=gandengan]').parents('.input-group').find('.button-clear').show()
                    $('#crudForm [name=upah_id]').val('')
                    $('#crudForm [name=upah]').val('')
                    $('#crudForm [name=upah]').data('currentValue', '')
                }
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
                element.val(kota.kodekota)
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
                    jenisorder_id: $('#crudForm [name=jenisorder_id]').val(),
                    container_id: $('#crudForm [name=container_id]').val(),
                    pelanggan_id: $('#crudForm [name=pelanggan_id]').val(),
                    gandengan_id: $('#crudForm [name=gandengan_id]').val(),
                    trado_id: $('#crudForm [name=trado_id]').val(),
                    statuslongtrip: statusLongtrip,
                    tarif_id: $('#crudForm [name=tarifrincian_id]').val(),
                    edit: true,
                    idtrip: $('#crudForm [name=id]').val(),
                    statuscontainer_id: $('#crudForm [name=statuscontainer_id]').val(),
                    tripasal: $('#crudForm [name=nobukti_tripasal]').val(),
                    tglbukti: $('#crudForm [name=tglbukti]').val(),
                    dari_id: $('#crudForm [name=dari_id]').val(),
                    isPulangLongtrip: isPulangLongtrip
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
                    kotaZona: zonasampaiId,
                    isLookup: 1,
                    url: `${apiUrl}kota/getlongtrip`,
                    statuslongtrip: $('#crudForm [name=statuslongtrip]').val(),
                    dari_id: $('#crudForm [name=dari_id]').val(),
                    from: 'inputtrip'
                }
            },
            onSelectRow: (kota, element) => {
                $('#crudForm [name=sampai_id]').first().val(kota.id)
                pilihKotaSampaiId = kota.id
                element.val(kota.kodekota)
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
                // clearJobTrucking()
                // clearTripAsal()
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=pelanggan_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
                // clearJobTrucking()
                // clearTripAsal()
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
                // clearJobTrucking()
                enabledUpahSupir()
                clearTripAsal()
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
                // clearJobTrucking()
                clearTripAsal()
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
                    enableTripAsalLongTrip()
                } else {

                    // clearJobTrucking()
                    enableTripAsalLongTrip()
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
                // clearJobTrucking()
                isPulangLongtrip = false;
                clearTripAsal()
            }
        })

        $('.triptangki-lookup').lookup({
            title: 'Trip tangki Lookup',
            fileName: 'triptangki',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {
                    Aktif: 'AKTIF',
                    tglbukti: $('#crudForm [name=tglbukti]').val(),
                    statusjeniskendaraan: $('#crudForm [name=statusjeniskendaraan]').val(),
                    trado_id: $('#crudForm [name=trado_id]').val(),
                    supir_id: $('#crudForm [name=supir_id]').val(),
                    from: 'listtrip'
                }
            },
            onSelectRow: (triptangki, element) => {
                $('#crudForm [name=triptangki_id]').first().val(triptangki.id)
                element.val(triptangki.keterangan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=triptangki_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
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
                    from: 'listtrip',
                    trip_id: $('#crudForm [name=id]').val(),
                    statusjeniskendaraan: $('#crudForm [name=statusjeniskendaraan]').val()
                }
            },
            onSelectRow: (absensi, element) => {
                console.log(absensi);
                $('#crudForm [name=trado_id]').first().val(absensi.trado_id)
                $('#crudForm [name=supir_id]').first().val(absensi.supir_id)
                $('#crudForm [name=absensidetail_id]').first().val(absensi.id)
                tradoId = absensi.trado_id
                element.val(absensi.tradosupir)
                element.data('currentValue', element.val())
                getInfoTrado(tradoId)
                // clearTripAsal()
                if (accessCabang == 'MEDAN') {
                    if (absensi.statusgerobak == 246) {
                        $('.gandengan').hide()
                    } else {
                        $('.gandengan').show()
                    }
                }
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
                // clearTripAsal()
                $('.tableInfo').hide()
                if (accessCabang == 'MEDAN') {
                    $('.gandengan').show()
                }
            }
        })

        $('.gandengan-lookup').lookup({
            title: 'Gandengan Lookup',
            fileName: 'gandengan',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

                    Aktif: 'AKTIF',
                    statusjeniskendaraan: $('#crudForm').find(`[name="statusjeniskendaraan"]`).val(),
                }
            },
            onSelectRow: (gandengan, element) => {
                $('#crudForm [name=gandengan_id]').first().val(gandengan.id)
                if ($('#crudForm [name=gandenganasal_id]').val() == '') {
                    gandenganId = gandengan.id
                }
                element.val(gandengan.kodegandengan)
                element.data('currentValue', element.val())

                if (accessCabang == 'MEDAN') {
                    clearJobTrucking()
                }
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
                if (accessCabang == 'MEDAN') {
                    clearJobTrucking()
                }
            }
        })
        $('.agen-lookup').lookup({
            title: 'Customer Lookup',
            fileName: 'agen',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

                    Aktif: 'AKTIF',
                    Invoice: 'UTAMA',
                }
            },
            onSelectRow: (agen, element) => {
                $('#crudForm [name=agen_id]').first().val(agen.id)
                element.val(agen.namaagen)
                element.data('currentValue', element.val())
                // clearJobTrucking()
                clearTripAsal()
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=agen_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
                // clearJobTrucking()
                clearTripAsal()
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
                if ($('#crudForm [name=statuscontainer_id]') != 3) {
                    if ($('#crudForm [name=statuslangsir]').val() != 79) {
                        enableTripAsal()
                        enableTripAsalLongTrip()
                        clearJobTrucking()
                        clearTripAsal()
                    }
                }
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

                if ($('#crudForm [name=statuscontainer_id]') != 3) {
                    clearJobTrucking()
                    isPulangLongtrip = false;
                    clearTripAsal()
                }
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
                    statuskandang_Id: $('#crudForm [name=statuskandang]').val(),
                    statusUpahZona: statusUpahZona,
                    tglbukti: $('#crudForm [name=tglbukti]').val(),
                    longtrip: $('#crudForm [name=statuslongtrip]').val(),
                    dari_id: $('#crudForm [name=dari_id]').val(),
                    sampai_id: $('#crudForm [name=sampai_id]').val(),
                    statuspenyesuaian: $('#crudForm [name=statuspenyesuaian]').val(),
                    statusperalihan: $('#crudForm [name=statusperalihan]').val(),
                    statuslangsir: $('#crudForm [name=statuslangsir]').val(),
                    nobukti_tripasal: $('#crudForm [name=nobukti_tripasal]').val(),
                    statusjeniskendaraan: statusJenisKendaran
                }
            },
            onSelectRow: (upahsupir, element) => {
                $('#crudForm [name=upah_id]').val(upahsupir.upah_id)
                // if (selectedUpahZona == 'NON UPAH ZONA') {

                $('#crudForm [name=tarifrincian_id]').val(upahsupir.tarif_id)
                $('#crudForm [name=tarifrincian]').val(upahsupir.tarif)
                $('#crudForm [name=penyesuaian]').val(upahsupir.penyesuaian)
                $('#crudForm [name=dari_id]').val(upahsupir.kotadari_id)
                $('#crudForm [name=dari]').val(upahsupir.kotadari)
                $('#crudForm [name=sampai_id]').val(upahsupir.kotasampai_id)
                $('#crudForm [name=sampai]').val(upahsupir.kotasampai)
                element.val(`${upahsupir.kotadari} - ${upahsupir.kotasampai}`)

                tarifrincianId = upahsupir.tarif_id
                // if (kodeStatusContainer != 'FULL EMPTY') {
                getpelabuhan(upahsupir.kotadari_id)
                // }
                // } else {
                //     zonadariId = upahsupir.zonadari_id
                //     zonasampaiId = upahsupir.zonasampai_id

                //     element.val(`${upahsupir.zonadari} - ${upahsupir.zonasampai}`)
                // }
                // kotaUpahZona()
                // clearJobTrucking()
                if (upahsupir.kotadari == 'KANDANG') {
                    $('.nobukti_tripasal').show()
                    $(".nobukti_tripasal").appendTo("#tripasal");
                }
                element.data('currentValue', element.val())
                // clearTrado()
                getInfoTrado()
                // clearTripAsal()
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
                // enabledKota()
            },
            onClear: (element) => {
                $('#crudForm [name=upah_id]').val('')

                element.val('')
                element.data('currentValue', element.val())
                // clearJobTrucking()
                // clearTrado()
                if ($('#crudForm [name=statuslongtrip]').val() != 65) {
                    clearUpahSupir()
                }
                // clearTripAsal()
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

                element.val(gandengan.kodegandengan)
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
        let longtrip = $('#crudForm [name=statuslongtrip]').val()
        let gudangsama = $('#crudForm [name=statusgudangsama]').val()
        let langsir = $('#crudForm [name=statuslangsir]').val()
        if (langsir == 79) {

            jobtrucking.attr('hidden', true)
            labeljobtrucking.attr('hidden', true)
            jobtrucking.parents('.input-group').find('.input-group-append').hide()
            jobtrucking.parents('.input-group').find('.button-clear').hide()
        } else {

            if (longtrip != 66) {
                jobtrucking.attr('hidden', true)
                labeljobtrucking.attr('hidden', true)
                jobtrucking.parents('.input-group').find('.input-group-append').hide()
                jobtrucking.parents('.input-group').find('.button-clear').hide()
            } else if (gudangsama == 204) {

                jobtrucking.attr('hidden', true)
                labeljobtrucking.attr('hidden', true)
                jobtrucking.parents('.input-group').find('.input-group-append').hide()
                jobtrucking.parents('.input-group').find('.button-clear').hide()
            } else {
                if (statuspelabuhan == '0') {
                    //bukan tas
                    // console.log('bukan');
                    jobtrucking.attr('hidden', true)
                    labeljobtrucking.attr('hidden', true)
                    jobtrucking.parents('.input-group').find('.input-group-append').hide()
                    jobtrucking.parents('.input-group').find('.button-clear').hide()
                } else {
                    //tas

                    labeljobtrucking.attr('hidden', false)
                    jobtrucking.attr('hidden', false)
                    if ($('#crudForm [name=nobukti_tripasal]') == '') {
                        jobtrucking.parents('.input-group').find('.input-group-append').show()
                        jobtrucking.parents('.input-group').find('.button-clear').show()
                    }
                }
            }

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
                trado_id: $('#crudForm').find(`[name="trado_id"]`).val(),
                upah_id: $('#crudForm').find(`[name="upah_id"]`).val(),
                id: $('#crudForm').find(`[name="id"]`).val(),
                statuscontainer_id: $('#crudForm').find(`[name="statuscontainer_id"]`).val()
            },
            success: response => {
                if (response.data.length > 0) {
                    $('.tableInfo').show()
                    $('#infoTrado').html('')
                    $.each(response.data, (index, detail) => {
                        let detailRow = $(`
                            <tr>
                                <td> ${detail.status} </td>
                                <td> ${numberWithCommas(detail.kmperjalanan)} </td>
                                <td> ${numberWithCommas(detail.kmtotal)} </td>
                            </tr>
                            `)

                        $('#infoTrado').append(detailRow)
                    })
                }
            },
            error: error => {
                showDialog(error.statusText)
            }
        })
    }

    function enableTripAsal() {
        let statusgudangsama = $(`#crudForm [name="statusgudangsama"]`).val()
        let jenisorder_id = $('#crudForm [name=jenisorder_id]').val()
        if (statusgudangsama == 204) {
            if (isTripAsal) {
                if (jenisorder_id == 1 || jenisorder_id == 4) {
                    $('.nobukti_tripasal').show()
                    isGudangSama = true
                } else {
                    $('.nobukti_tripasal').hide()
                    clearTripAsal()
                    $('#crudForm [name=jobtrucking]').data('currentValue', '')
                    $('#crudForm [name=jobtrucking]').val('')
                    isGudangSama = false
                }
            }
        } else {
            $('.nobukti_tripasal').hide()
            clearTripAsal()
            isGudangSama = false

            if (isTripAsal) {
                $('#crudForm [name=jobtrucking]').data('currentValue', '')
                $('#crudForm [name=jobtrucking]').val('')
            }
        }
    }

    function clearTripAsal() {
        $('#crudForm [name=nobukti_tripasal]').val('')
        $('#crudForm [name=nobukti_tripasal]').data('currentValue', '')
        let statuslongtrip = $(`#crudForm [name="statuslongtrip"]`).val()
        let jenisorder_id = $('#crudForm [name=jenisorder_id]').val()
        let statuscontainer_id = $('#crudForm [name=statuscontainer_id]').val()
        if (statuslongtrip == 66) {
            if ((jenisorder_id == 2 && statuscontainer_id == 2) || (jenisorder_id == 3 && statuscontainer_id == 2) || (jenisorder_id == 1 && statuscontainer_id == 1) || (jenisorder_id == 4 && statuscontainer_id == 1)) {
                clearJobTrucking()
            }
        }
    }

    function clearJobTrucking() {
        $('#crudForm [name=jobtrucking]').val('')
        $('#crudForm [name=jobtrucking]').data('currentValue', '')
    }

    function clearTrado() {
        $('#crudForm [name=trado_id]').val('')
        $('#crudForm [name=supir_id]').val('')
        $('#crudForm [name=absensidetail_id]').val('')
        $('#crudForm [name=trado]').val('')
        $('#crudForm [name=trado]').data('currentValue', '')
        $('#infoTrado').html('')
        $('.tableInfo').hide()
    }

    function enableTripAsalLongTrip() {
        let statuslongtrip = $(`#crudForm [name="statuslongtrip"]`).val()
        let jenisorder_id = $('#crudForm [name=jenisorder_id]').val()
        let statuscontainer_id = $('#crudForm [name=statuscontainer_id]').val()

        if ($('#crudForm [name=statuslangsir]').val() != 79) {
            if (statuslongtrip == 66) {
                if ((jenisorder_id == 2 && statuscontainer_id == 2) || (jenisorder_id == 3 && statuscontainer_id == 2) || (jenisorder_id == 1 && statuscontainer_id == 1) || (jenisorder_id == 4 && statuscontainer_id == 1)) {
                    $(".nobukti_tripasal").appendTo("#tripasalpulanglongtrip");
                    $('.nobukti_tripasal').show()
                    isPulangLongtrip = true;
                } else {
                    $('.nobukti_tripasal').hide()
                    clearTripAsal()
                    setPulangLongtrip('', 'clear')
                    isPulangLongtrip = false;
                }
            } else {
                if ((jenisorder_id == 2 && statuscontainer_id == 1) || (jenisorder_id == 3 && statuscontainer_id == 1) || (jenisorder_id == 1 && statuscontainer_id == 2) || (jenisorder_id == 1 && statuscontainer_id == 1) || (jenisorder_id == 4 && statuscontainer_id == 2)) {
                    $(".nobukti_tripasal").appendTo("#tripasalpulanglongtrip");
                    $('.nobukti_tripasal').show()
                    isPulangLongtrip = false;
                } else {

                    $('.nobukti_tripasal').hide()
                    clearTripAsal()
                    isPulangLongtrip = false;
                }
            }
        }
    }

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function addRow() {
        let detailRow = $(`
      <tr>
        <td></td>
        <td>
          <input type="hidden" name="jenisritasi_id[]" id="jenisritasi_id_${indexRitasi}">
          <input type="text" name="jenisritasi[]" class="form-control dataritasi-lookup" id="jenisritasi_${indexRitasi}">
        </td>
        <td>
          <input type="hidden" name="ritasidari_id[]">
          <input type="text" name="ritasidari[]" class="form-control ritasidari-lookup" readonly>
        </td>
        <td>
          <input type="hidden" name="ritasike_id[]">
          <input type="text" name="ritasike[]" class="form-control ritasike-lookup" readonly>
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
        </td>
      </tr>
    `)

        $('#ritasiList tbody').append(detailRow)
        // setStatusRitasi(detailRow)
        // initSelect2(detailRow.find(`[name="jenisritasi[]"]`), false)


        $(`.ritasidari-lookup`).last().lookup({
            title: 'RITASI DARI Lookup',
            fileName: 'kota',
            beforeProcess: function() {
                console.log(this)
                this.postData = {
                    Aktif: 'AKTIF',
                    DataRitasi: dataRitasiId[`jenisritasi_${indexRitasi}`],
                    RitasiDariKe: 'dari',
                    pilihkota_id: pilihKotaSampaiId
                }
            },
            onSelectRow: (kota, element) => {
                element.parents('td').find(`[name="ritasidari_id[]"]`).val(kota.id)
                pilihKotaDariId = kota.id
                element.val(kota.kodekota)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.parents('td').find(`[name="ritasidari_id[]"]`).val('')
                pilihKotaDariId = 0
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $(`.ritasike-lookup`).last().lookup({
            title: 'RITASI KE Lookup',
            fileName: 'kota',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    DataRitasi: dataRitasiId[`jenisritasi_${indexRitasi}`],
                    RitasiDariKe: 'ke',
                    pilihkota_id: pilihKotaDariId
                }
            },
            onSelectRow: (kota, element) => {
                element.parents('td').find(`[name="ritasike_id[]"]`).val(kota.id)
                pilihKotaSampaiId = kota.id
                element.val(kota.kodekota)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.parents('td').find(`[name="ritasike_id[]"]`).val('')
                pilihKotaSampaiId = 0
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.dataritasi-lookup').last().lookup({
            title: 'Data Ritasi Lookup',
            fileName: 'dataritasi',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (dataRitasi, element) => {
                element.parents('td').find(`[name="jenisritasi_id[]"]`).val(dataRitasi.id)
                element.val(dataRitasi.statusritasi)
                element.data('currentValue', element.val())
                getKotaRitasi(dataRitasi.statusritasi_id, element, element.attr("id"))
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.parents('td').find(`[name="jenisritasi_id[]"]`).val('')
                element.parents('tr').find(`td [name="ritasidari_id[]"]`).val('')
                element.parents('tr').find(`td [name="ritasidari[]"]`).val('').data('currentValue', '').attr("readonly", true)
                element.parents('tr').find(`td [name="ritasike_id[]"]`).val('')
                element.parents('tr').find(`td [name="ritasike[]"]`).val('').data('currentValue', '').attr("readonly", true)

                element.val('')
                element.data('currentValue', element.val())
                let ritDari = element.parents('tr').find(`td [name="ritasidari[]"]`).parents('.input-group')
                ritDari.find('.button-clear').attr('disabled', true)
                ritDari.children().find('.lookup-toggler').attr('disabled', true)

                let ritKe = element.parents('tr').find(`td [name="ritasike[]"]`).parents('.input-group')
                ritKe.find('.button-clear').attr('disabled', true)
                ritKe.children().find('.lookup-toggler').attr('disabled', true)

            }
        })

        let ritDari = detailRow.find(`[name="ritasidari[]"]`).parents('.input-group')
        ritDari.find('.button-clear').attr('disabled', true)
        ritDari.children().find('.lookup-toggler').attr('disabled', true)

        let ritKe = detailRow.find(`[name="ritasike[]"]`).parents('.input-group')
        ritKe.find('.button-clear').attr('disabled', true)
        ritKe.children().find('.lookup-toggler').attr('disabled', true)
        indexRitasi++
        setRowNumbers()
    }

    function deleteRow(row) {
        let countRow = $('.delete-row').parents('tr').length
        row.remove()
        indexRitasi--
        if (countRow <= 1) {
            addRow()
        }

        setRowNumbers()
    }

    function setRowNumbers() {
        let elements = $('#ritasiList tbody tr td:nth-child(1)')

        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }
</script>
@endpush()