<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="crudForm">
            <div class="modal-content">
                
                <form action="" method="post">

                    <div class="modal-body">
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
                                    <input type="text" name="tglbukti" autocomplete="off" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    KAS/BANK <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="bank_id">
                                <input type="text" name="bank" autocomplete="off" class="form-control bank-lookup">
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
                                    TGL SAMPAI <span class="text-danger">*</span>
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
                                <button class="btn btn-primary" id="btnTampil"><i class="fas fa-sync"></i>
                                    RELOAD</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div id="tabs" class="dejavu">
                                    <ul>
                                        <li><a href="#tabs-1">Rekap Rincian</a></li>
                                        <li><a href="#tabs-2">Posting Rincian</a></li>
                                        <li><a href="#tabs-3">Posting Pot. pinjaman (semua)</a></li>
                                        <li><a href="#tabs-4">Posting Pot. pinjaman (pribadi)</a></li>
                                        <li><a href="#tabs-5">Posting deposito</a></li>
                                        <li><a href="#tabs-6">Posting bbm</a></li>
                                        <li><a href="#tabs-7">Posting Uang jalan</a></li>
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
                                                <input type="text" name="nobuktiPR" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    TGL bukti</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="tglbuktiPR" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Nominal</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nomPR" class="form-control text-right autonumeric" readonly>
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
                                                <input type="text" name="nobuktiPS" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    TGL bukti</label>
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
                                                <input type="text" name="nomPS" class="form-control text-right autonumeric" readonly>
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
                                                <input type="text" name="nobuktiPP" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    TGL bukti</label>
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
                                                <input type="text" name="nomPP" class="form-control text-right autonumeric" readonly>
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
                                                <input type="text" name="nobuktiDeposito" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    TGL bukti</label>
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
                                                <input type="text" name="nomDeposito" class="form-control text-right autonumeric" readonly>
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
                                                <input type="text" name="nobuktiBBM" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    TGL bukti</label>
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
                                                <input type="text" name="nomBBM" class="form-control text-right autonumeric" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tabs-7">
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    NO BUKTI</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nobuktiUangjalan" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    TGL bukti</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="tglbuktiUangjalan" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Nominal</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nomUangjalan" class="form-control text-right autonumeric" readonly>
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
    let selectedBorongan = [];
    let selectedJalan = [];
    let selectedKomisi = [];
    let selectedMakan = [];
    let selectedMakanBerjenjang = [];
    let selectedPP = [];
    let selectedPS = [];
    let selectedDeposito = [];
    let selectedBBM = [];
    let selectedRIC = [];
    let selectedSupir = [];
    let selectedGajiSupir = [];
    let selectedGajiKenek = [];
    let selectedExtra = [];
    let sortnameRincian = 'nobuktiric'
    let sortorderRincian = 'asc';
    let pageRincian = 0;
    let totalRecordRincian
    let limitRincian
    let postDataRincian
    let triggerClickRincian
    let indexRowRincian
    let isEditTgl

    function checkboxHandler(element) {
        let value = $(element).val();
        if (element.checked) {
            selectedRows.push($(element).val());
            selectedRIC.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_nobuktiric"]`).text());
            selectedSupir.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_supir_id"]`).text());
            selectedPP.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_potonganpinjaman"]`).text());
            selectedPS.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_potonganpinjamansemua"]`).text());
            selectedDeposito.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_deposito"]`).text());
            selectedBBM.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_bbm"]`).text());
            selectedBorongan.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_borongan"]`).text());
            selectedJalan.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_uangjalan"]`).text());
            selectedKomisi.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_komisisupir"]`).text());
            selectedMakan.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_uangmakanharian"]`).text());
            selectedMakanBerjenjang.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_uangmakanberjenjang"]`).text());
            selectedGajiSupir.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_gajisupir"]`).text());
            selectedGajiKenek.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_gajikenek"]`).text());
            selectedExtra.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_extra"]`).text());
            countNominal()
            $(element).parents('tr').addClass('bg-light-blue')
        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRows.length; i++) {
                if (selectedRows[i] == value) {
                    selectedRows.splice(i, 1);
                    selectedRIC.splice(i, 1);
                    selectedSupir.splice(i, 1);
                    selectedPP.splice(i, 1);
                    selectedPS.splice(i, 1);
                    selectedDeposito.splice(i, 1);
                    selectedBBM.splice(i, 1);
                    selectedBorongan.splice(i, 1);
                    selectedJalan.splice(i, 1);
                    selectedKomisi.splice(i, 1);
                    selectedMakan.splice(i, 1);
                    selectedMakanBerjenjang.splice(i, 1);
                    selectedGajiSupir.splice(i, 1);
                    selectedGajiKenek.splice(i, 1);
                    selectedExtra.splice(i, 1);
                }
            }

            countNominal()
        }
    }

    function countNominal() {
        potPribadi = 0;
        potSemua = 0;
        deposito = 0;
        bbm = 0;
        borongan = 0;
        jalan = 0;
        komisi = 0;
        makan = 0;
        berjenjang = 0;
        gajisupir = 0;
        gajikenek = 0;
        extra = 0;
        $.each(selectedPP, function(index, item) {
            potPribadi = potPribadi + parseFloat(item.replace(/,/g, ''))
        });
        $.each(selectedPS, function(index, item) {
            potSemua = potSemua + parseFloat(item.replace(/,/g, ''))
        });
        $.each(selectedDeposito, function(index, item) {
            deposito = deposito + parseFloat(item.replace(/,/g, ''))
        });
        $.each(selectedBBM, function(index, item) {
            bbm = bbm + parseFloat(item.replace(/,/g, ''))
        });
        $.each(selectedBorongan, function(index, item) {
            borongan = borongan + parseFloat(item.replace(/,/g, ''))
        });
        $.each(selectedJalan, function(index, item) {
            jalan = jalan + parseFloat(item.replace(/,/g, ''))
        });
        $.each(selectedKomisi, function(index, item) {
            komisi = komisi + parseFloat(item.replace(/,/g, ''))
        });
        $.each(selectedMakan, function(index, item) {
            makan = makan + parseFloat(item.replace(/,/g, ''))
        });
        $.each(selectedMakanBerjenjang, function(index, item) {
            berjenjang = berjenjang + parseFloat(item.replace(/,/g, ''))
        });
        $.each(selectedGajiSupir, function(index, item) {
            gajisupir = gajisupir + parseFloat(item.replace(/,/g, ''))
        });
        $.each(selectedGajiKenek, function(index, item) {
            gajikenek = gajikenek + parseFloat(item.replace(/,/g, ''))
        });
        $.each(selectedExtra, function(index, item) {
            extra = extra + parseFloat(item.replace(/,/g, ''))
        });

        // postingRincian = borongan + makan
        postingRincian = borongan
        initAutoNumeric($('#crudForm').find(`[name="nomPR"]`).val(postingRincian))
        initAutoNumeric($('#crudForm').find(`[name="nomPS"]`).val(potSemua))
        initAutoNumeric($('#crudForm').find(`[name="nomPP"]`).val(potPribadi))
        initAutoNumeric($('#crudForm').find(`[name="nomDeposito"]`).val(deposito))
        initAutoNumeric($('#crudForm').find(`[name="nomBBM"]`).val(bbm))
        initAutoNumeric($('#crudForm').find(`[name="nomUangjalan"]`).val(jalan))

        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_potonganpinjaman"]`).text(potPribadi))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_potonganpinjamansemua"]`).text(potSemua))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_deposito"]`).text(deposito))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_bbm"]`).text(bbm))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_borongan"]`).text(borongan))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_uangjalan"]`).text(jalan))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_komisisupir"]`).text(komisi))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_uangmakanharian"]`).text(makan))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_uangmakanberjenjang"]`).text(berjenjang))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_gajisupir"]`).text(gajisupir))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_gajikenek"]`).text(gajikenek))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_extra"]`).text(extra))
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
                name: 'tgldari',
                value: form.find(`[name="tgldari"]`).val()
            })
            data.push({
                name: 'tglsampai',
                value: form.find(`[name="tglsampai"]`).val()
            })
            data.push({
                name: 'bank',
                value: form.find(`[name="bank"]`).val()
            })
            data.push({
                name: 'bank_id',
                value: form.find(`[name="bank_id"]`).val()
            })

            $.each(selectedRows, function(index, item) {
                data.push({
                    name: 'rincianId[]',
                    value: item
                })
            });

            $.each(selectedRIC, function(index, item) {
                data.push({
                    name: 'nobuktiRIC[]',
                    value: item
                })
            });

            $.each(selectedSupir, function(index, item) {
                data.push({
                    name: 'supir_id[]',
                    value: item
                })
            });

            $.each(selectedBorongan, function(index, item) {
                data.push({
                    name: 'totalborongan[]',
                    value: parseFloat(item.replaceAll(',', ''))
                })
            });

            $('#crudForm').find(`[name="nomPR"]`).each((index, element) => {
                data.push({
                    name: 'nomPR',
                    value: AutoNumeric.getNumber($(`#crudForm [name="nomPR"]`)[index])
                })
            })

            $('#crudForm').find(`[name="nomPS"]`).each((index, element) => {
                data.push({
                    name: 'nomPS',
                    value: AutoNumeric.getNumber($(`#crudForm [name="nomPS"]`)[index])
                })
            })

            $('#crudForm').find(`[name="nomPP"]`).each((index, element) => {
                data.push({
                    name: 'nomPP',
                    value: AutoNumeric.getNumber($(`#crudForm [name="nomPP"]`)[index])
                })
            })
            $('#crudForm').find(`[name="nomDeposito"]`).each((index, element) => {
                data.push({
                    name: 'nomDeposito',
                    value: AutoNumeric.getNumber($(`#crudForm [name="nomDeposito"]`)[index])
                })
            })
            $('#crudForm').find(`[name="nomBBM"]`).each((index, element) => {
                data.push({
                    name: 'nomBBM',
                    value: AutoNumeric.getNumber($(`#crudForm [name="nomBBM"]`)[index])
                })
            })
            $('#crudForm').find(`[name="nomUangjalan"]`).each((index, element) => {
                data.push({
                    name: 'nomUangjalan',
                    value: AutoNumeric.getNumber($(`#crudForm [name="nomUangjalan"]`)[index])
                })
            })

            data.push({
                name: 'nobuktiUangjalan',
                value: form.find(`[name="nobuktiUangjalan"]`).val()
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
            console.log(data);

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}prosesgajisupirheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}prosesgajisupirheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}prosesgajisupirheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}prosesgajisupirheader`
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

                    $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
                    $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');
                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page,
                        postData: {
                            proses: 'reload',
                            tgldari: dateFormat(response.data.tgldariheader),
                            tglsampai: dateFormat(response.data.tglsampaiheader)
                        }
                    }).trigger('reloadGrid');

                    clearSelectedRows()
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

        $("#tabs").tabs()
        setFormBindKeys(form)

        activeGrid = null
        initLookup()
        initDatepicker()
        getMaxLength(form)
        initAutoNumeric()

        form.find('#btnSubmit').prop('disabled', false)
        if (form.data('action') == "view") {
            form.find('#btnSubmit').prop('disabled', true)
        }
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        selectedRows = []
        selectedPP = [];
        selectedPS = [];
        selectedDeposito = [];
        selectedBBM = [];
        selectedRIC = [];
        selectedBorongan = [];
        selectedKomisi = [];
        selectedJalan = [];
        selectedMakan = [];
        selectedMakanBerjenjang = [];
        selectedGajiKenek = [];
        selectedGajiSupir = [];
        selectedExtra = [];
        $('#crudModal').find('.modal-body').html(modalBody)
        initDatepicker('datepickerIndex')
    })


    function rekapRincian() {
        let disabled = '';
        if ($('#crudForm').data('action') == 'delete') {
            disabled = 'disabled'
        }
        $("#rekapRincian").jqGrid({
                mtype: "GET",
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

                                let tglDari = $('#crudForm').find(`[name="tgldari"]`).val()
                                let tglSampai = $('#crudForm').find(`[name="tglsampai"]`).val()
                                let aksi = $('#crudForm').data('action')
                                $(element).attr('id', 'gsRincian')
                                $(element).removeClass('form-control')
                                $(element).parent().addClass('text-center')
                                $(element).addClass('checkbox-selectall')
                                
                                if (disabled == '') {
                                    $(element).on('click', function() {
                                        $(element).attr('disabled', true)
                                        if ($(this).is(':checked')) {
                                            selectAllRows(tglDari, tglSampai, aksi)
                                        } else {
                                            clearSelectedRows()
                                        }
                                    })
                                } else {
                                    $(element).attr('disabled', true)
                                }
                            }
                        },
                        formatter: (value, rowOptions, rowData) => {
                            return `<input type="checkbox" class="checkbox-jqgrid" name="rincianId[]" value="${rowData.idric}" ${disabled} onchange="checkboxHandler(this)">`
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
                        label: 'NO BUKTI',
                        name: 'nobuktiric',
                        align: 'left'
                    },
                    {
                        label: 'TGL BUKTI',
                        name: 'tglbuktiric',
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'SUPIR ID',
                        name: 'supir_id',
                        align: 'left',
                        hidden: true
                    },
                    {
                        label: 'SUPIR',
                        name: 'supir',
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
                        label: 'BORONGAN SUPIR',
                        name: 'borongan',
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'U. JALAN',
                        name: 'uangjalan',
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'U. BBM',
                        name: 'bbm',
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'UANG MAKAN',
                        name: 'uangmakanharian',
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'U. MAKAN BERJENJANG',
                        name: 'uangmakanberjenjang',
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'POT. PINJAMAN',
                        name: 'potonganpinjaman',
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'POT. PINJAMAN (SEMUA)',
                        width: 210,
                        name: 'potonganpinjamansemua',
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'DEPOSITO',
                        name: 'deposito',
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'GAJI SUPIR',
                        name: 'gajisupir',
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'BIAYA EXTRA',
                        name: 'extra',
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'KOMISI SUPIR',
                        name: 'komisisupir',
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'KOMISI KENEK',
                        name: 'gajikenek',
                        formatter: currencyFormat,
                        align: "right",
                    },


                    {
                        label: 'TOL',
                        name: 'tolsupir',
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
                sortname: sortnameRincian,
                sortorder: sortorderRincian,
                page: pageRincian,
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
                    indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
                    page = $(this).jqGrid('getGridParam', 'page')
                    let limit = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))


                },
                loadComplete: function(data) {
                    let grid = $(this)
                    changeJqGridRowListText()

                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))
                    console.log(selectedRows)
                    $.each(selectedRows, function(key, value) {
                        $(grid).find('tbody tr').each(function(row, tr) {
                            if ($(this).find(`td input:checkbox`).val() == value) {
                                $(this).addClass('bg-light-blue')
                                $(this).find(`td input:checkbox`).prop('checked', true)
                            }
                        })
                    });

                    /* Set global variables */
                    sortnameRincian = $(this).jqGrid("getGridParam", "sortname")
                    sortorderRincian = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordRincian = $(this).getGridParam("records")
                    limitRincian = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataRincian = $(this).jqGrid('getGridParam', 'postData')
                    triggerClickRincian = true

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowRincian > $(this).getDataIDs().length - 1) {
                        indexRowRincian = $(this).getDataIDs().length - 1;
                    }

                    setHighlight($(this))
                    if (disabled == '') {
                        $('#gsRincian').attr('disabled', false)
                    } else {
                        $('#gsRincian').attr('disabled', true)
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
                    $(this).setGridParam({
                        postData: {
                            dari: $('#crudForm').find('[name=tgldari]').val(),
                            sampai: $('#crudForm').find('[name=tglsampai]').val(),
                            aksi: $('#crudForm').data('action'),
                        },
                    })

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

        $('.modal-loader').removeClass('d-none')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Simpan
        `)

        form.data('action', 'add')
        $('#crudModalTitle').text('Add Proses Gaji Supir')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tgldari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglbuktiPR]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglbuktiPS]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglbuktiPP]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglbuktiDeposito]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglbuktiBBM]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglbuktiUangjalan]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        rekapRincian()
        initDatepicker()

        Promise
            .all([
                showDefault(form)
            ])
            .then(() => {
                $('#crudModal').modal('show')
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })

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
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        Promise
            .all([
                setTglBukti(form),
                showProsesGajiSupir(form, Id, 'edit')
            ])
            .then(() => {
                $('#crudModal').modal('show')
                if (isEditTgl == 'TIDAK') {
                    form.find(`[name="tglbukti"]`).prop('readonly', true)
                    form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
                }
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
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
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        form.find('#btnTampil').prop('disabled', true)
        Promise
            .all([
                showProsesGajiSupir(form, Id, 'delete')
            ])
            .then(() => {
                $('#crudModal').modal('show')
                form.find(`[name="tglbukti"]`).prop('readonly', true)
                form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function viewProsesGajiSupirHeader(Id) {
        let form = $('#crudForm')

        form.data('action', 'view')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
          <i class="fa fa-save"></i>
          Save
        `)
        form.find('#btnSubmit').prop('disabled', true)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('View Proses Gaji Supir')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        form.find('#btnTampil').prop('disabled', true)
        Promise
            .all([
                showProsesGajiSupir(form, Id, 'delete')
            ])
            .then(id => {
                setFormBindKeys(form)
                form.find('[name]').removeAttr('disabled')

                form.find('select').each((index, select) => {
                    let element = $(select)

                    if (element.data('select2')) {
                        element.select2('destroy')
                    }
                })
                form.find('[name]').attr('disabled', 'disabled').css({
                    background: '#fff'
                })
                form.find('[name=id]').prop('disabled', false);
            })
            .then(() => {
                $('#crudModal').modal('show')
                clearSelectedRows()
                $('#gs_').prop('checked', false)
                form.find(`.hasDatepicker`).prop('readonly', true)
                form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
                let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
                let nameFind = $('#crudForm').find(`[name]`).parents('.input-group')
                name.attr('disabled', true)
                name.find('.lookup-toggler').remove()
                nameFind.find('button.button-clear').remove()
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
            url: `{{ config('app.api_url') }}prosesgajisupirheader/${Id}/cekvalidasi`,
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
                    if (Aksi == 'PRINTER') {
                        window.open(`{{ route('prosesgajisupirheader.report') }}?id=${Id}`)
                    } else {
                        cekValidasiAksi(Id, Aksi)
                    }
                }
            }
        })
    }

    function cekValidasiAksi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}prosesgajisupirheader/${Id}/cekValidasiAksi`,
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
                        editProsesGajiSupirHeader(Id)
                    }
                    if (Aksi == 'DELETE') {
                        deleteProsesGajiSupirHeader(Id)
                    }
                }

            }
        })
    }

    function showProsesGajiSupir(form, gajiId, aksi) {
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
                    if (index == 'bankPR') {
                        element.data('current-value', value).prop('readonly', true)
                        element.parent('.input-group').find('.button-clear').remove()
                        element.parent('.input-group').find('.input-group-append').remove()
                    }

                    form.find(`[name="tglbuktiPR"]`).val(dateFormat(response.data.tglbukti))
                })

                // url = `${gajiId}/getEdit`
                rekapRincian()
                $.each(response.getTrip, (index, detail) => {

                    selectedRows.push(detail.idric)

                    selectedBorongan.push(detail.borongan)
                    selectedGajiSupir.push(detail.gajisupir)
                    selectedGajiKenek.push(detail.gajikenek)
                    selectedExtra.push(detail.extra)
                    selectedJalan.push(detail.uangjalan)
                    selectedKomisi.push(detail.komisisupir)
                    selectedMakan.push(detail.uangmakanharian)
                    selectedMakanBerjenjang.push(detail.uangmakanberjenjang)
                    selectedPP.push(detail.potonganpinjaman)
                    selectedPS.push(detail.potonganpinjamansemua)
                    selectedDeposito.push(detail.deposito)
                    selectedBBM.push(detail.bbm)
                    selectedRIC.push(detail.nobuktiric)
                    selectedSupir.push(detail.supir_id)

                })

                $('#rekapRincian').jqGrid("clearGridData");
                $('#rekapRincian').jqGrid('setGridParam', {
                    url: `${apiUrl}prosesgajisupirheader/${gajiId}/getEdit`,
                    postData: {
                        tgldari: $('#crudForm').find('[name=tgldari]').val(),
                        tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
                        sortIndex: sortnameRincian,
                        aksi: 'edit'
                    },
                    datatype: "json"
                }).trigger('reloadGrid');


                if (response.potsemua != null) {
                    $.each(response.potsemua, (index, value) => {
                        let element = form.find(`[name="${index}"]`)

                        form.find(`[name="${index}"]`).val(value)
                        if (index == 'bankPS') {
                            element.data('current-value', value).prop('readonly', true)
                            element.parent('.input-group').find('.button-clear').remove()
                            element.parent('.input-group').find('.input-group-append').remove()
                        }

                    })
                    form.find(`[name="tglbuktiPS"]`).val(dateFormat(response.data.tglbukti))

                }
                if (response.potpribadi != null) {
                    $.each(response.potpribadi, (index, value) => {
                        let element = form.find(`[name="${index}"]`)

                        form.find(`[name="${index}"]`).val(value)

                        if (index == 'bankPP') {
                            element.data('current-value', value).prop('readonly', true)
                            element.parent('.input-group').find('.button-clear').remove()
                            element.parent('.input-group').find('.input-group-append').remove()
                        }
                    })
                    form.find(`[name="tglbuktiPP"]`).val(dateFormat(response.data.tglbukti))

                }

                if (response.deposito != null) {
                    $.each(response.deposito, (index, value) => {
                        let element = form.find(`[name="${index}"]`)

                        form.find(`[name="${index}"]`).val(value)

                        if (index == 'bankDeposito') {
                            element.data('current-value', value).prop('readonly', true)
                            element.parent('.input-group').find('.button-clear').remove()
                            element.parent('.input-group').find('.input-group-append').remove()
                        }
                    })
                    form.find(`[name="tglbuktiDeposito"]`).val(dateFormat(response.data.tglbukti))

                }

                if (response.bbm != null) {
                    $.each(response.bbm, (index, value) => {
                        let element = form.find(`[name="${index}"]`)

                        form.find(`[name="${index}"]`).val(value)
                        if (index == 'bankBBM') {
                            element.data('current-value', value).prop('readonly', true)
                            element.parent('.input-group').find('.button-clear').remove()
                            element.parent('.input-group').find('.input-group-append').remove()
                        }
                    })
                    form.find(`[name="tglbuktiBBM"]`).val(dateFormat(response.data.tglbukti))

                }

                if (response.uangjalan != null) {
                    $.each(response.uangjalan, (index, value) => {
                        let element = form.find(`[name="${index}"]`)

                        form.find(`[name="${index}"]`).val(value)
                        if (index == 'bankUangjalan') {
                            element.data('current-value', value).prop('readonly', true)
                            element.parent('.input-group').find('.button-clear').remove()
                            element.parent('.input-group').find('.input-group-append').remove()
                        }
                    })
                    form.find(`[name="tglbuktiUangjalan"]`).val(dateFormat(response.data.tglbukti))

                }


                initAutoNumeric(form.find(`[name="nomPR"]`))
                initAutoNumeric(form.find(`[name="nomPS"]`))
                initAutoNumeric(form.find(`[name="nomPP"]`))
                initAutoNumeric(form.find(`[name="nomDeposito"]`))
                initAutoNumeric(form.find(`[name="nomBBM"]`))

                if (aksi == 'delete') {

                    form.find('[name]').addClass('disabled')
                    initDisabled()
                }

                countNominal()
            }
        })
    }

    $(document).on('click', '#btnTampil', function(event) {
        event.preventDefault()
        let form = $('#crudForm')
        let tglDari = form.find(`[name="tgldari"]`).val()
        let tglSampai = form.find(`[name="tglsampai"]`).val()
        let aksi = form.data('action')
        getAllTrip()
            .then((response) => {
                $('.is-invalid').removeClass('is-invalid')
                $('.invalid-feedback').remove()

                selectedRows = response.data.map((data) => data.idric)
                selectedBorongan = response.data.map((data) => data.borongan)
                selectedGajiSupir = response.data.map((data) => data.gajisupir)
                selectedGajiKenek = response.data.map((data) => data.gajikenek)
                selectedExtra = response.data.map((data) => data.extra)
                selectedJalan = response.data.map((data) => data.uangjalan)
                selectedKomisi = response.data.map((data) => data.komisisupir)
                selectedMakan = response.data.map((data) => data.uangmakanharian)
                selectedMakanBerjenjang = response.data.map((data) => data.uangmakanberjenjang)
                selectedPP = response.data.map((data) => data.potonganpinjaman)
                selectedPS = response.data.map((data) => data.potonganpinjamansemua)
                selectedDeposito = response.data.map((data) => data.deposito)
                selectedBBM = response.data.map((data) => data.bbm)
                selectedRIC = response.data.map((data) => data.nobuktiric)
                selectedSupir = response.data.map((data) => data.supir_id)

                $('#rekapRincian').jqGrid('setGridParam', {
                    url: `${apiUrl}prosesgajisupirheader/${response.url}`,
                    postData: {
                        tgldari: $('#crudForm').find('[name=tgldari]').val(),
                        tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
                        aksi: aksi
                    },
                    datatype: "json"
                }).trigger('reloadGrid');
                countNominal()
            })
            .catch((error) => {
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()

                    setErrorMessages(form, error.responseJSON.errors);
                } else {
                    showDialog(error.responseJSON)
                }
            })
    })

    async function getEdit(gajiId) {
        return await $.ajax({
            url: `${apiUrl}prosesgajisupirheader/${gajiId}/getEdit`,
            method: 'GET',
            dataType: 'JSON',
            data: {
                limit: 0,
                sortIndex: sortnameRincian
            },
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: (response) => {
                return response
            },
            error: (error) => {
                showDialog(error.responseJSON.message)
            }
        })
    }


    function setRowNumbers() {
        let elements = $('#detailList tbody tr td:nth-child(2)')

        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }

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
                    showDialog(error.responseJSON)
                }
            })
        }
    }


    function showDefault(form) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}prosesgajisupirheader/default`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    bankId = response.data.bank_id
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)
                        element.val(value)
                    })
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
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
                $('#crudForm [name=bank_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }

    function clearSelectedRows() {
        selectedRows = [];
        selectedBorongan = [];
        selectedGajiSupir = [];
        selectedExtra = [];
        selectedGajiKenek = [];
        selectedJalan = [];
        selectedKomisi = [];
        selectedMakan = [];
        selectedMakanBerjenjang = [];
        selectedPP = [];
        selectedPS = [];
        selectedDeposito = [];
        selectedBBM = [];
        selectedRIC = [];
        selectedSupir = [];
        $('#rekapRincian').trigger('reloadGrid')
    }

    function getAllTrip() {
        if ($(`#crudForm`).data('action') == 'edit') {
            ricId = $(`#crudForm`).find(`[name="id"]`).val()
            urlTrip = `${ricId}/getEdit`
        } else {
            urlTrip = 'getRic'
        }

        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}prosesgajisupirheader/${urlTrip}`,
                method: 'GET',
                dataType: 'JSON',
                data: {
                    limit: 0,
                    tgldari: $('#crudForm').find('[name=tgldari]').val(),
                    tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
                    aksi: $(`#crudForm`).data('action'),
                    sortIndex: sortnameRincian,
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: (response) => {
                    response.url = urlTrip
                    resolve(response)
                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()


                        errors = error.responseJSON.errors
                        reject(errors)

                    } else {
                        showDialog(error.responseJSON)
                    }
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function selectAllRows(tglDari, tglSampai, aksi) {
        if (aksi == 'edit') {
            ricId = $(`#crudForm`).find(`[name="id"]`).val()
            url = `${ricId}/getEdit`
        } else {
            url = 'getRic'
        }
        $.ajax({
            url: `${apiUrl}prosesgajisupirheader/${url}`,
            method: 'GET',
            dataType: 'JSON',
            data: {
                limit: 0,
                tgldari: $('#crudForm').find('[name=tgldari]').val(),
                tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
                aksi: aksi,
                sortIndex: sortnameRincian,
            },
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: (response) => {
                selectedRows = response.data.map((data) => data.idric)
                selectedBorongan = response.data.map((data) => data.borongan)
                selectedGajiSupir = response.data.map((data) => data.gajisupir)
                selectedGajiKenek = response.data.map((data) => data.gajikenek)
                selectedExtra = response.data.map((data) => data.extra)
                selectedJalan = response.data.map((data) => data.uangjalan)
                selectedKomisi = response.data.map((data) => data.komisisupir)
                selectedMakan = response.data.map((data) => data.uangmakanharian)
                selectedMakanBerjenjang = response.data.map((data) => data.uangmakanberjenjang)
                selectedPP = response.data.map((data) => data.potonganpinjaman)
                selectedPS = response.data.map((data) => data.potonganpinjamansemua)
                selectedDeposito = response.data.map((data) => data.deposito)
                selectedBBM = response.data.map((data) => data.bbm)
                selectedRIC = response.data.map((data) => data.nobuktiric)
                selectedSupir = response.data.map((data) => data.supir_id)

                $('#rekapRincian').jqGrid('setGridParam', {
                    url: `${apiUrl}prosesgajisupirheader/${url}`,
                    postData: {
                        tgldari: $('#crudForm').find('[name=tgldari]').val(),
                        tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
                        aksi: aksi
                    },
                    datatype: "json"
                }).trigger('reloadGrid');
                countNominal()
            }
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
                value: 'PROSES GAJI SUPIR'
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