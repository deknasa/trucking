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
                  KODE PENERIMAAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="penerimaantrucking_id">
                <input type="text" name="penerimaantrucking" id="penerimaantrucking" class="form-control penerimaantrucking-lookup">
              </div>
            </div>

            <div class="row form-group" style="display:none;">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  supir </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" id="supirHaeaderId" name="supirheader_id">
                <input type="text" name="supir" class="form-control supirheader-lookup">
              </div>
            </div>

            <div class="row form-group" style="display:none;">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  karyawan </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" id="karyawanHeaderId" name="karyawanheader_id">
                <input type="text" name="karyawan" class="form-control karyawanheader-lookup">
              </div>
            </div>

            <div class="row form-group" style="display:none;">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  jenisorder <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" id="jenisorder" name="jenisorderan_id">
                <input type="text" name="jenisorder" class="form-control jenisorder-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  TGL DARI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <div class="input-group">
                  <input type="text" name="periodedari" class="form-control datepicker" autocomplete="off">
                </div>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  TGL SAMPAI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <div class="input-group">
                  <input type="text" name="periodesampai" class="form-control datepicker" autocomplete="off">
                </div>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NAMA PERKIRAAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="coa">
                <input type="text" name="keterangancoa" class="form-control akunpusat-lookup">
              </div>
            </div>

            <div class="row form-group" style="display:none;">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  keterangan <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keteranganheader" class="form-control">
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-6 m-1">
                <a id="btnReloadBbtGrid" class="btn btn-primary mr-2 ">
                  <i class="fas fa-sync-alt"></i>
                  Reload
                </a>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-6 m-1">
                <a id="btnReloadPJP" class="btn btn-primary mr-2 ">
                  <i class="fas fa-sync-alt"></i>
                  Reload
                </a>
              </div>
            </div>


            <div class="border p-3">
              <h6>Posting Penerimaan</h6>

              <div class="row form-group">
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    POSTING <span class="text-danger">*</span></label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="hidden" name="bank_id">
                  <input type="text" name="bank" class="form-control bank-lookup">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    NO BUKTI KAS/BANK MASUK </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="text" name="penerimaan_nobukti" id="penerimaan_nobukti" class="form-control" readonly>
                </div>
              </div>
            </div>



            <table id="tablePinjaman"></table>
            <table id="tablePinjamanKaryawan"></table>
            <table id="tablePengembalianTitipan"></table>

            <div class="table-scroll table-responsive">
              <table class="table table-bordered table-bindkeys mt-3" id="detailList" style="width: 1000px;">
                <thead>
                  <tr>
                    <th style="width:5%; max-width: 25px;max-width: 15px" class="">No</th>
                    <th class="data_tbl tbl_checkbox" style="display:none" width="1%">Pilih</th>
                    <th style="width: 20%; min-width: 200px;" class="tbl_supir_id">SUPIR </th>
                    <th style="width: 20%; min-width: 200px;" class="tbl_karyawan_id">KARYAWAN </th>
                    <th style="width: 20%; min-width: 200px;" class="tbl_pengeluarantruckingheader_nobukti">NO BUKTI PENGELUARAN TRUCKING</th>
                    <th style="width: 20%; min-width: 200px;" class="tbl_sisa">Sisa </th>
                    <th style="width: 20%; min-width: 200px;" class="tbl_keterangan">Keterangan</th>
                    <th style="width: 20%; min-width: 200px;" class="tbl_nominal">Nominal</th>
                    <th style="width:5%; max-width: 25px;max-width: 15px" class="tbl_aksi">Aksi</th>
                  </tr>
                </thead>
                <tbody id="table_body" class="form-group">

                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="4" class="colspan">
                      <p class="text-right font-weight-bold">TOTAL :</p>
                    </td>
                    <td id="sisaColFoot" style="display: none">
                      <p class="text-right font-weight-bold autonumeric" id="sisaFoot"></p>
                    </td>
                    <td>
                      <p class="text-right font-weight-bold autonumeric" id="total"></p>
                    </td>
                    <td class="colmn-offset"></td>
                    <td id="tbl_addRow" class="tbl_aksi">
                      <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">Tambah</button>
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
  var KodePenerimaanId
  var listIdPenerimaan = []
  var listKodePenerimaan = []
  var listKeteranganPenerimaan = []
  let isEditTgl

  $(document).ready(function() {

    $("#crudForm [name]").attr("autocomplete", "off");

    $(document).on('click', "#addRow", function() {
      event.preventDefault()

      let method = `POST`
      let url = `${apiUrl}penerimaantruckingheader/addrow`
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()
      $('#crudForm').find(`[name="nominal[]"`).each((index, element) => {
        data.filter((row) => row.name === 'nominal[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[index])
      })
      $.ajax({
          url: url,
          method: method,
          dataType: 'JSON',
          headers: {
            Authorization: `Bearer ${accessToken}`
          },
          data: data,
          success: response => {
            addRow()
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
          },
          error: error => {
            if (error.status === 422) {
              $('.is-invalid').removeClass('is-invalid')
              $('.invalid-feedback').remove()
              setErrorMessages(form, error.responseJSON.errors);
            } else {
              showDialog(error.responseJSON)
            }
          }
        })
        .always(() => {
          $('#processingLoader').addClass('d-none')
          $(this).removeAttr('disabled')
        })
    });

    $(document).on('click', "#btnReloadBbtGrid", function() {
      reloadGrid = null;
      if ($('#crudForm').data('action') == 'edit') {
        reloadGrid = 'reload'
      }
      getDataPengembalianTitipan(reloadGrid).then((response) => {
        // console.log('before', $("#tablePinjamanKaryawan").jqGrid('getGridParam', 'selectedRowIds'))
        let totalBayar = 0
        $('#gs_').prop('checked', false)

        $("#tablePengembalianTitipan")[0].p.selectedRowIds = [];
        $('#tablePengembalianTitipan').jqGrid("clearGridData");
        $.each(response.data, (index, value) => {
          totalBayar += parseFloat(value.nominal_titipan)
        })
        setTimeout(() => {

          $("#tablePengembalianTitipan")
            .jqGrid("setGridParam", {
              datatype: "local",
              data: response.data,
              originalData: response.data,
              rowNum: response.data.length,
              selectedRowIds: []
            })
            .trigger("reloadGrid");
          // initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePengembalianTitipan_nominal_titipan"]`).text(totalBayar))
        }, 100);

      });

    });

    $(document).on('click', "#btnReloadPJP", function() {
      // reloadGrid = null;
      // if ($('#crudForm').data('action') == 'edit') {
      //   reloadGrid = 'reload'
      // }
      $('#btnSubmit').prop('disabled', true)
      $('#btnSaveAdd').prop('disabled', true)
      if (KodePenerimaanId == 'PJP') {

        let supirheader_id = $(`#crudForm [name="supirheader_id"]`).val()

        $('#tablePinjaman').jqGrid("clearGridData");

        setTotalNominal()
        setTotalSisa()
        setTotalPinjaman()
        setTotalBayarPinjaman()
        getDataPinjaman(supirheader_id).then((response) => {

          $("#tablePinjaman")[0].p.selectedRowIds = [];
          setTimeout(() => {

            $("#tablePinjaman")
              .jqGrid("setGridParam", {
                datatype: "local",
                data: response.data,
                originalData: response.data,
                rowNum: response.data.length,
                selectedRowIds: []
              })
              .trigger("reloadGrid");
            $('#btnSubmit').prop('disabled', false)
            $('#btnSaveAdd').prop('disabled', false)
          }, 100);

        });
      }
      if (KodePenerimaanId == 'PJPK') {

        let karyawanheader_id = $(`#crudForm [name="karyawanheader_id"]`).val()

        $('#tablePinjamanKaryawan').jqGrid("clearGridData");

        setTotalNominalKaryawan()
        setTotalSisaKaryawan()
        getDataPinjamanKaryawan(karyawanheader_id).then((response) => {

          $("#tablePinjamanKaryawan")[0].p.selectedRowIds = [];
          setTimeout(() => {

            $("#tablePinjamanKaryawan")
              .jqGrid("setGridParam", {
                datatype: "local",
                data: response.data,
                originalData: response.data,
                rowNum: response.data.length,
                selectedRowIds: []
              })
              .trigger("reloadGrid");
            $('#btnSubmit').prop('disabled', false)
            $('#btnSaveAdd').prop('disabled', false)
          }, 100);

        });
      }
    });

    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $(document).on('input', `#table_body [name="nominal[]"]`, function(event) {
      setTotal()
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

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data
      if (KodePenerimaanId === "PJP") {
        data = []

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
          name: 'penerimaantrucking_id',
          value: form.find(`[name="penerimaantrucking_id"]`).val()
        })
        data.push({
          name: 'penerimaantrucking',
          value: form.find(`[name="penerimaantrucking"]`).val()
        })
        data.push({
          name: 'supirheader_id',
          value: form.find(`[name="supirheader_id"]`).val()
        })
        data.push({
          name: 'supir',
          value: form.find(`[name="supir"]`).val()
        })
        data.push({
          name: 'coa',
          value: form.find(`[name="coa"]`).val()
        })
        data.push({
          name: 'keterangancoa',
          value: form.find(`[name="keterangancoa"]`).val()
        })
        data.push({
          name: 'bank_id',
          value: form.find(`[name="bank_id"]`).val()
        })
        data.push({
          name: 'bank',
          value: form.find(`[name="bank"]`).val()
        })
        data.push({
          name: 'periodedari',
          value: null
        })
        data.push({
          name: 'periodesampai',
          value: null
        })
        data.push({
          name: 'jenisorderan_id',
          value: null
        })
        data.push({
          name: 'penerimaan_nobukti',
          value: form.find(`[name="pengeluaran_nobukti"]`).val()
        })

        let selectedRowsHutang = $("#tablePinjaman").getGridParam("selectedRowIds");
        data.push({
          name: 'jumlahdetail',
          value: selectedRowsHutang.length
        })
        $.each(selectedRowsHutang, function(index, value) {
          dataPinjaman = $("#tablePinjaman").jqGrid("getLocalRow", value);
          let selectedSisa = dataPinjaman.sisa
          let selectedNominal = (dataPinjaman.nominal == undefined) ? 0 : dataPinjaman.nominal;
          data.push({
            name: 'nominal[]',
            value: (isNaN(selectedNominal)) ? parseFloat(selectedNominal.replaceAll(',', '')) : selectedNominal
          })
          data.push({
            name: 'sisa[]',
            value: selectedSisa
          })
          data.push({
            name: 'keterangan[]',
            value: dataPinjaman.keterangan
          })
          data.push({
            name: 'pengeluarantruckingheader_nobukti[]',
            value: dataPinjaman.nobukti
          })
          data.push({
            name: 'supir_id[]',
            value: dataPinjaman.pinj_supirid
          })
          data.push({
            name: 'pjp_id[]',
            value: dataPinjaman.id
          })
        });

      } else if (KodePenerimaanId === "PJPK") {
        data = []

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
          name: 'penerimaantrucking_id',
          value: form.find(`[name="penerimaantrucking_id"]`).val()
        })
        data.push({
          name: 'penerimaantrucking',
          value: form.find(`[name="penerimaantrucking"]`).val()
        })
        data.push({
          name: 'periodedari',
          value: null
        })
        data.push({
          name: 'periodesampai',
          value: null
        })
        data.push({
          name: 'jenisorderan_id',
          value: null
        })
        data.push({
          name: 'karyawanheader_id',
          value: form.find(`[name="karyawanheader_id"]`).val()
        })
        data.push({
          name: 'karyawan',
          value: form.find(`[name="karyawan"]`).val()
        })
        data.push({
          name: 'coa',
          value: form.find(`[name="coa"]`).val()
        })
        data.push({
          name: 'keterangancoa',
          value: form.find(`[name="keterangancoa"]`).val()
        })
        data.push({
          name: 'bank_id',
          value: form.find(`[name="bank_id"]`).val()
        })
        data.push({
          name: 'bank',
          value: form.find(`[name="bank"]`).val()
        })
        data.push({
          name: 'penerimaan_nobukti',
          value: form.find(`[name="pengeluaran_nobukti"]`).val()
        })

        let selectedRowsHutang = $("#tablePinjamanKaryawan").getGridParam("selectedRowIds");
        data.push({
          name: 'jumlahdetail',
          value: selectedRowsHutang.length
        })
        $.each(selectedRowsHutang, function(index, value) {
          dataPinjaman = $("#tablePinjamanKaryawan").jqGrid("getLocalRow", value);
          let selectedSisa = dataPinjaman.sisa
          let selectedNominal = (dataPinjaman.nominal == undefined) ? 0 : dataPinjaman.nominal;
          data.push({
            name: 'nominal[]',
            value: (isNaN(selectedNominal)) ? parseFloat(selectedNominal.replaceAll(',', '')) : selectedNominal
          })
          data.push({
            name: 'sisa[]',
            value: selectedSisa
          })
          data.push({
            name: 'keterangan[]',
            value: dataPinjaman.keterangan
          })
          data.push({
            name: 'pengeluarantruckingheader_nobukti[]',
            value: dataPinjaman.nobukti
          })
          data.push({
            name: 'karyawan_id[]',
            value: dataPinjaman.pinj_karyawanid
          })
          data.push({
            name: 'pjpk_id[]',
            value: dataPinjaman.id
          })
        });
      } else if (KodePenerimaanId === "PBT") {
        data = []

        // console.log(form.find(`[name="jenisorder_id"]`).val());
        data.push({
          name: 'id',
          value: form.find(`[name="id"]`).val()
        })
        data.push({
          name: 'nobukti',
          value: form.find(`[name="nobukti"]`).val()
        })
        data.push({
          name: 'keteranganheader',
          value: form.find(`[name="keteranganheader"]`).val()
        })
        data.push({
          name: 'tglbukti',
          value: form.find(`[name="tglbukti"]`).val()
        })
        data.push({
          name: 'penerimaantrucking_id',
          value: form.find(`[name="penerimaantrucking_id"]`).val()
        })
        data.push({
          name: 'penerimaantrucking',
          value: form.find(`[name="penerimaantrucking"]`).val()
        })
        data.push({
          name: 'karyawanheader_id',
          value: form.find(`[name="karyawanheader_id"]`).val()
        })
        data.push({
          name: 'karyawan',
          value: form.find(`[name="karyawan"]`).val()
        })
        data.push({
          name: 'coa',
          value: form.find(`[name="coa"]`).val()
        })
        data.push({
          name: 'periodedari',
          value: form.find(`[name="periodedari"]`).val()
        })
        data.push({
          name: 'periodesampai',
          value: form.find(`[name="periodesampai"]`).val()
        })
        data.push({
          name: 'keterangancoa',
          value: form.find(`[name="keterangancoa"]`).val()
        })
        data.push({
          name: 'bank_id',
          value: form.find(`[name="bank_id"]`).val()
        })
        data.push({
          name: 'bank',
          value: form.find(`[name="bank"]`).val()
        })
        data.push({
          name: 'penerimaan_nobukti',
          value: form.find(`[name="pengeluaran_nobukti"]`).val()
        })
        data.push({
          name: 'jenisorderan_id',
          value: form.find(`[name="jenisorderan_id"]`).val()
        })
        data.push({
          name: 'jenisorder',
          value: form.find(`[name="jenisorder"]`).val()
        })
        data.push({
          name: 'periodedari',
          value: form.find(`[name="periodedari"]`).val()
        })
        data.push({
          name: 'periodesampai',
          value: form.find(`[name="periodesampai"]`).val()
        })

        let selectedRowsTitipan = $("#tablePengembalianTitipan").getGridParam("selectedRowIds");
        data.push({
          name: 'jumlahdetail',
          value: selectedRowsTitipan.length
        })
        $.each(selectedRowsTitipan, function(index, value) {
          dataPinjaman = $("#tablePengembalianTitipan").jqGrid("getLocalRow", value);
          let selectedNominal = (dataPinjaman.nominal_titipan == undefined) ? 0 : dataPinjaman.nominal_titipan;
          data.push({
            name: 'nominal[]',
            value: (isNaN(selectedNominal)) ? parseFloat(selectedNominal.replaceAll(',', '')) : selectedNominal
          })
          data.push({
            name: 'keterangan[]',
            value: dataPinjaman.keterangan_titipan
          })
          data.push({
            name: 'jenisorder_id[]',
            value: dataPinjaman.jenisorder_id
          })
          data.push({
            name: 'pengeluarantruckingheader_nobukti[]',
            value: dataPinjaman.nobukti_titipan
          })

        });

      } else {
        data = $('#crudForm').serializeArray()

        $('#crudForm').find(`[name="nominal[]"`).each((index, element) => {
          data.filter((row) => row.name === 'nominal[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[index])
        })
        if (KodePenerimaanId === "DPO") {
          data.filter((row) => row.name === 'supirheader_id')[0].value = $(`#crudForm [name="supir_id[]"]`).val()
          data.filter((row) => row.name === 'supir')[0].value = $(`#crudForm [name="supir[]"]`).val()
          data.filter((row) => row.name === 'karyawanheader_id')[0].value = 0
          data.filter((row) => row.name === 'karyawan')[0].value = ''
        }
        if (KodePenerimaanId === "DPOK") {
          data.filter((row) => row.name === 'karyawanheader_id')[0].value = $(`#crudForm [name="karyawan_id[]"]`).val()
          data.filter((row) => row.name === 'karyawan')[0].value = $(`#crudForm [name="karyawandetail[]"]`).val()
          data.filter((row) => row.name === 'supirheader_id')[0].value = 0
          data.filter((row) => row.name === 'supir')[0].value = ''


        }
        // data.push({
        //   name: 'nominal[]',
        //   value: AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[row])
        // })
      }


      data.push({
        name: 'aksi',
        value: action.toUpperCase()
      })
      data.push({
        name: 'button',
        value: button
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
      data.push({
        name: 'penerimaanheader_id',
        value: data.find(item => item.name === "penerimaantrucking_id").value
      })
      // let penerimaanheader_id = $('#kodepenerimaanheader').val();
      let penerimaanheader_id = data.find(item => item.name === "penerimaantrucking_id").value;

      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()
      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}penerimaantruckingheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}penerimaantruckingheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}penerimaantruckingheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&penerimaanheader_id=${penerimaanheader_id}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}penerimaantruckingheader`
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


          if (button == 'btnSubmit') {
            id = response.data.id
            $('#crudModal').modal('hide')
            $('#crudModal').find('#crudForm').trigger('reset')

            $('#penerimaanheader_id').val(response.data.penerimaantrucking_id).trigger('change')
            $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
            $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');
            $('#jqGrid').jqGrid('setGridParam', {
              page: response.data.page,
              postData: {
                proses: 'reload',
                tgldari: dateFormat(response.data.tgldariheader),
                tglsampai: dateFormat(response.data.tglsampaiheader),
                penerimaanheader_id: response.data.penerimaantrucking_id
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
            let penerimaanTruckingVal = $('#crudForm').find('[name="penerimaantrucking"]').val();
            let penerimaanTruckingIdVal = $('#crudForm').find('[name="penerimaantrucking_id"]').val();
            // showSuccessDialog(response.message, response.data.nobukti)
            createPenerimaanTruckingHeader()
            $('#crudForm').find('input[type="text"]').not('[name="penerimaantrucking"]').data('current-value', '')
            $('#crudForm').find('[name="penerimaantrucking"]').val(penerimaanTruckingVal)
            $('#crudForm').find('[name="penerimaantrucking_id"]').val(penerimaanTruckingIdVal)
            $('#crudForm').find('[name=tglbukti]').focus()
            setTampilanForm();
            if (KodePenerimaanId == 'PJP') {
              $("#tablePinjaman")[0].p.selectedRowIds = [];
              $('#tablePinjaman').jqGrid("clearGridData");
              $("#tablePinjaman")
                .jqGrid("setGridParam", {
                  selectedRowIds: []
                })
                .trigger("reloadGrid");
            }
            if (KodePenerimaanId == 'PJPK') {

              $("#tablePinjamanKaryawan")[0].p.selectedRowIds = [];
              $('#tablePinjamanKaryawan').jqGrid("clearGridData");
              $("#tablePinjamanKaryawan")
                .jqGrid("setGridParam", {
                  selectedRowIds: []
                })
                .trigger("reloadGrid");
            }
            if (KodePenerimaanId == 'PBT') {

              $("#tablePengembalianTitipan")[0].p.selectedRowIds = [];
              $('#tablePengembalianTitipan').jqGrid("clearGridData");
              $("#tablePengembalianTitipan")
                .jqGrid("setGridParam", {
                  selectedRowIds: []
                })
                .trigger("reloadGrid");
              initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePengembalianTitipan_nominal_titipan"]`).text(0))
            }
          }
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            if (KodePenerimaanId == "PJP") {
              console.log(error)
              errors = error.responseJSON.errors
              $(".ui-state-error").removeClass("ui-state-error");
              $.each(errors, (index, error) => {
                let indexes = index.split(".");
                let angka = indexes[1]
                selectedRowsHutang = $("#tablePinjaman").getGridParam("selectedRowIds");
                row = parseInt(selectedRowsHutang[angka]) - 1;
                let element;
                if (indexes[0] == 'bank' || indexes[0] == 'pengeluarantrucking' || indexes[0] == 'supir' || indexes[0] == 'pjp_id') {
                  if (indexes.length > 1) {
                    element = form.find(`[name="${indexes[0]}[]"]`)[row];
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
                } else {

                  element = $(`#tablePinjaman tr#${parseInt(selectedRowsHutang[angka])}`).find(`td[aria-describedby="tablePinjaman_${indexes[0]}"]`)
                  $(element).addClass("ui-state-error");
                  console.log(error)
                  $(element).attr("title", error[0].toLowerCase())
                }
              });
            } else if (KodePenerimaanId == "PJPK") {
              console.log(error)
              errors = error.responseJSON.errors
              $(".ui-state-error").removeClass("ui-state-error");
              $.each(errors, (index, error) => {
                let indexes = index.split(".");
                let angka = indexes[1]
                selectedRowsHutang = $("#tablePinjamanKaryawan").getGridParam("selectedRowIds");
                row = parseInt(selectedRowsHutang[angka]) - 1;
                let element;
                if (indexes[0] == 'bank' || indexes[0] == 'pengeluarantrucking' || indexes[0] == 'supir' || indexes[0] == 'pjpk_id') {
                  if (indexes.length > 1) {
                    element = form.find(`[name="${indexes[0]}[]"]`)[row];
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
                } else {

                  element = $(`#tablePinjamanKaryawan tr#${parseInt(selectedRowsHutang[angka])}`).find(`td[aria-describedby="tablePinjamanKaryawan_${indexes[0]}"]`)
                  $(element).addClass("ui-state-error");
                  console.log(error)
                  $(element).attr("title", error[0].toLowerCase())
                }
              });
            } else {
              setErrorMessages(form, error.responseJSON.errors);
            }
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

    if (KodePenerimaanId == 'PJP') {
      $('#btnSubmit').prop('disabled', true)
      $('#btnSaveAdd').prop('disabled', true)

      $("#tablePinjaman")[0].p.selectedRowIds = [];
      $('#tablePinjaman').jqGrid("clearGridData");
      $("#tablePinjaman")
        .jqGrid("setGridParam", {
          selectedRowIds: []
        })
        .trigger("reloadGrid");

      setTotalNominal()
      setTotalSisa()
      setTotalPinjaman()
      setTotalBayarPinjaman()
      getDataPinjaman($('#crudForm [name=supirheader_id]').val()).then((response) => {

        $("#tablePinjaman")[0].p.selectedRowIds = [];
        setTimeout(() => {

          $("#tablePinjaman")
            .jqGrid("setGridParam", {
              datatype: "local",
              data: response.data,
              originalData: response.data,
              rowNum: response.data.length,
              selectedRowIds: []
            })
            .trigger("reloadGrid");
          $('#btnSubmit').prop('disabled', false)
          $('#btnSaveAdd').prop('disabled', false)
        }, 100);

      });
    }
    if (KodePenerimaanId == 'PJPK') {
      $('#btnSubmit').prop('disabled', true)
      $('#btnSaveAdd').prop('disabled', true)
      $('#tablePinjamanKaryawan').jqGrid("clearGridData");
      $("#tablePinjamanKaryawan")
        .jqGrid("setGridParam", {
          selectedRowIds: []
        })
        .trigger("reloadGrid");

      setTotalNominalKaryawan()
      setTotalSisaKaryawan()
      getDataPinjamanKaryawan($('#crudForm [name=karyawanheader_id]').val()).then((response) => {
        $("#tablePinjamanKaryawan")[0].p.selectedRowIds = [];
        setTimeout(() => {

          $("#tablePinjamanKaryawan")
            .jqGrid("setGridParam", {
              datatype: "local",
              data: response.data,
              originalData: response.data,
              rowNum: response.data.length,
              selectedRowIds: []
            })
            .trigger("reloadGrid");
          $('#btnSubmit').prop('disabled', false)
          $('#btnSaveAdd').prop('disabled', false)
        }, 100);

      });
    }

  })

  function setKodePenerimaan(kode) {
    KodePenerimaanId = kode;
    setTampilanForm();
  }

  function setTampilanForm() {
    tampilanall()
    switch (KodePenerimaanId) {
      case 'BBM':
        tampilanBBM()
        break;
      case 'PJP':
        tampilanPJP()
        break;
      case 'DPO':
        tampilanDPO()
        break;
      case 'PJPK':
        tampilanPJPK()
        break;
      case 'PBT':
        tampilanPBT()
        break;
      case 'DPOK':
        tampilanDPOK()
        break;
      default:
        tampilanall()
        break;
    }
  }

  function tampilanBBM() {
    $('#btnReloadBbtGrid').parents('.row').hide()
    $('#btnReloadPJP').parents('.row').hide()
    $('#detailList').show()
    $('#gbox_tablePinjaman').hide()
    $('#gbox_tablePinjamanKaryawan').hide()
    $('#gbox_tablePengembalianTitipan').hide()
    $('[name=keteranganheader]').parents('.form-group').hide()

    $('[name=periodedari]').parents('.form-group').hide()
    $('[name=periodesampai]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('.tbl_supir_id').hide()
    $('.tbl_karyawan_id').hide()
    $('.tbl_sisa').hide()
    $('.colmn-offset').hide()
    $('.tbl_pengeluarantruckingheader_nobukti').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()

    $('#crudModal').find(`#crudForm [name="supir[]"]`).val('')
    $('#crudModal').find(`#crudForm [name="supir_id[]"]`).val('')
    $('#crudModal').find(`#crudForm [name="karyawandetail[]"]`).val('')
    $('#crudModal').find(`#crudForm [name="karyawan_id[]"]`).val('')
    $('.colspan').attr('colspan', 2);
    $('#sisaColFoot').hide()
    $('#sisaFoot').hide()
    $('.tbl_aksi').show()


  }

  function tampilanPJP() {
    $('#btnReloadBbtGrid').parents('.row').hide()
    $('#btnReloadPJP').parents('.row').show()
    $('[name=keteranganheader]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('.tbl_supir_id').hide()
    $('.tbl_karyawan_id').hide()
    $('[name=periodedari]').parents('.form-group').hide()
    $('[name=periodesampai]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').show()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('#gbox_tablePinjaman').show()
    $('#gbox_tablePinjamanKaryawan').hide()
    $('#gbox_tablePengembalianTitipan').hide()

    $('#detailList').hide()
    loadPinjamanGrid()
  }

  function tampilanPJPK() {
    $('#btnReloadBbtGrid').parents('.row').hide()
    $('#btnReloadPJP').parents('.row').show()
    $('[name=keteranganheader]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('.tbl_supir_id').hide()
    $('.tbl_karyawan_id').hide()
    $('[name=periodedari]').parents('.form-group').hide()
    $('[name=periodesampai]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').show()
    $('#gbox_tablePinjaman').hide()
    $('#gbox_tablePinjamanKaryawan').show()
    $('#gbox_tablePengembalianTitipan').hide()
    $('#detailList').hide()
    loadPinjamanKaryawanGrid()
  }

  function tampilanPBT() {
    $('#btnReloadBbtGrid').parents('.row').show()
    $('#btnReloadPJP').parents('.row').hide()
    $('[name=keteranganheader]').parents('.form-group').show()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('.tbl_supir_id').hide()
    $('.tbl_karyawan_id').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=periodedari]').parents('.form-group').show()
    $('[name=periodesampai]').parents('.form-group').show()
    $('[name=jenisorderan_id]').parents('.form-group').show()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('#gbox_tablePinjaman').hide()
    $('#gbox_tablePinjamanKaryawan').hide()
    $('#gbox_tablePengembalianTitipan').show()
    $('#detailList').hide()
    if ($('#crudForm').data('action') == 'delete') {

      $('#btnReloadBbtGrid').parents('.row').hide()
    }

    loadPengembalianTitipanGrid()
  }

  function tampilanDPO() {
    $('#crudModal').find(`#crudForm [name="karyawandetail[]"]`).val('')
    $('#crudModal').find(`#crudForm [name="karyawan_id[]"]`).val('')
    $('#btnReloadBbtGrid').parents('.row').hide()
    $('#btnReloadPJP').parents('.row').hide()
    $('#detailList').show()
    $('#gbox_tablePinjaman').hide()
    $('#gbox_tablePinjamanKaryawan').hide()
    $('#gbox_tablePengembalianTitipan').hide()
    $('[name=periodedari]').parents('.form-group').hide()
    $('[name=periodesampai]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=keteranganheader]').parents('.form-group').hide()
    $('.tbl_supir_id').show()
    $('.tbl_karyawan_id').hide()
    $('.tbl_pengeluarantruckingheader_nobukti').hide()
    $('.tbl_sisa').hide()
    $('.tbl_aksi').show()
    $('.colmn-offset').hide()
    $('.colspan').attr('colspan', 3);
    $('#sisaColFoot').hide()
    $('#sisaFoot').hide()
  }

  function tampilanDPOK() {

    $('#crudModal').find(`#crudForm [name="supir[]"]`).val('')
    $('#crudModal').find(`#crudForm [name="supir_id[]"]`).val('')
    $('#btnReloadBbtGrid').parents('.row').hide()
    $('#btnReloadPJP').parents('.row').hide()
    $('#detailList').show()
    $('#gbox_tablePinjaman').hide()
    $('#gbox_tablePinjamanKaryawan').hide()
    $('#gbox_tablePengembalianTitipan').hide()
    $('[name=periodedari]').parents('.form-group').hide()
    $('[name=periodesampai]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=keteranganheader]').parents('.form-group').hide()
    $('.tbl_supir_id').hide()
    $('.tbl_karyawan_id').show()
    $('.tbl_pengeluarantruckingheader_nobukti').hide()
    $('.tbl_sisa').hide()
    $('.tbl_aksi').show()
    $('.colmn-offset').hide()
    $('.colspan').attr('colspan', 3);
    $('#sisaColFoot').hide()
    $('#sisaFoot').hide()
  }

  function tampilanall() {
    $('#detailList').show()
    $('#btnReloadPJP').parents('.row').hide()
    $('#gbox_tablePinjaman').hide()
    $('#gbox_tablePinjamanKaryawan').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('#btnReloadBbtGrid').parents('.row').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=periodedari]').parents('.form-group').hide()
    $('[name=periodesampai]').parents('.form-group').hide()
    $('.tbl_supir_id').show()
    $('.tbl_karyawan_id').hide()
    $('.tbl_sisa').hide()
    $('.tbl_pengeluarantruckingheader_nobukti').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('.colspan').attr('colspan', 3);
    $('#sisaColFoot').hide()
    $('#sisaFoot').hide()
    $('.colmn-offset').hide()
    $('#tablePinjamanKaryawan').jqGrid("clearGridData").trigger("reloadGrid");
    $('#tablePinjaman').jqGrid("clearGridData").trigger("reloadGrid");
    if ($('#crudForm').data('action') == 'add') {
      $('[name=supirheader_id]').val('')
      $('[name=supir]').val('')
      $('[name=karyawanheader_id]').val('')
      $('[name=karyawan]').val('')
    }
    setTotalNominalKaryawan()
    setTotalSisaKaryawan()
    setTotalNominal()
    setTotalSisa()
  }

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null

    getMaxLength(form)
    initLookup()
    initDatepicker()
    if (form.data('action') == 'add') {
      form.find('#btnSaveAdd').show()
      if ($('#penerimaanheader_id').val() != '') {
        let index = listIdPenerimaan.indexOf($('#penerimaanheader_id').val());
        // setKodePenerimaan(penerimaantrucking.kodepenerimaan)
        KodePenerimaanId = listKodePenerimaan[index];
        setTampilanForm();
        $('#crudForm').find(`[name="penerimaantrucking"]`).val(listKeteranganPenerimaan[index])
        $('#crudForm').find(`[name="penerimaantrucking"]`).data('currentValue', listKeteranganPenerimaan[index])
        $('#crudForm').find(`[name="penerimaantrucking_id"]`).val($('#penerimaanheader_id').val())
      }
    } else {
      form.find('#btnSaveAdd').hide()
    }
    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy($('#crudForm').find('[name=id]').val())
    $('#crudModal').find('.modal-body').html(modalBody)
    initDatepicker('datepickerIndex')
    KodePenerimaanId = "";
  })

  function removeEditingBy(id) {
    let formData = new FormData();


    formData.append('id', id);
    formData.append('aksi', 'BATAL');
    formData.append('table', 'penerimaantruckingheader');

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

  function setTotal() {
    let nominalDetails = $(`#table_body [name="nominal[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)
  }

  function createPenerimaanTruckingHeader() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.data('action', 'add')

    $('#crudModalTitle').text('Add Penerimaan Trucking')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $('#table_body').html('')
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        setDefaultBank(),
        addRow(),
        setTotal()
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        // $('#btnReloadPJP').parents('.row').show()
        $('#crudModal').modal('show')
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })

  }

  function editPenerimaanTruckingHeader(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    $('#crudModalTitle').text('Edit Penerimaan Trucking')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    form.find(`[name="bank"]`).removeClass('bank-lookup')
    form.find(`[name="penerimaantrucking"]`).removeClass('penerimaantrucking-lookup')

    Promise
      .all([
        setTglBukti(form),
        showPenerimaanTruckingHeader(form, id)
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
        $('#btnReloadPJP').parents('.row').hide()
        $('#crudForm [name=supirheader]').attr('readonly', true)
        $('#crudForm [name=supir]').siblings('.input-group-append').remove()
        $('#crudForm [name=supir]').siblings('.button-clear').remove()
        $('#crudForm [name=karyawan]').siblings('.input-group-append').remove()
        $('#crudForm [name=karyawan]').siblings('.button-clear').remove()
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function deletePenerimaanTruckingHeader(id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')


    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-trash"></i>
              Delete
    `)
    $('#crudModalTitle').text('Delete Penerimaan Trucking')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    form.find(`[name="bank"]`).removeClass('bank-lookup')
    form.find(`[name="penerimaantrucking"]`).removeClass('penerimaantrucking-lookup')

    Promise
      .all([
        showPenerimaanTruckingHeader(form, id)
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

  function viewPenerimaanTruckingHeader(id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find('#btnSubmit').prop('disabled', true)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Penerimaan Trucking')

    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    form.find(`[name="bank"]`).removeClass('bank-lookup')
    form.find(`[name="penerimaantrucking"]`).removeClass('penerimaantrucking-lookup')

    Promise
      .all([
        showPenerimaanTruckingHeader(form, id)
      ])
      .then(userId => {
        setFormBindKeys(form)
        initSelect2(form.find('.select2bs4'), true)
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
        form.find('[name=id]').prop('disabled', false)
      })
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
        form.find(`.hasDatepicker`).prop('readonly', true)
        form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
        $('#crudForm').find(`.tbl_aksi`).hide()
        let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
        let nameFind = $('#crudForm').find(`[name]`).parents('.input-group')
        name.attr('disabled', true)
        name.find('.lookup-toggler').remove()
        nameFind.find('button.button-clear').remove()

      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })

  }

  function setDefaultBank() {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}bank`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, bank) => {
            // console.log(index);
            if (bank.id == 1) {
              $('#crudForm [name=bank_id]').first().val(bank.id)
              $('#crudForm [name=bank]').first().val(bank.namabank)
              $('#crudForm [name=bank]').first().data('currentValue', $('#crudForm [name=bank]').first().val())
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
      url: `{{ config('app.api_url') }}penerimaantruckingheader/${Id}/cekvalidasi`,
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
            window.open(`{{ route('penerimaantruckingheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
          } else if (Aksi == 'PRINTER KECIL') {
            window.open(`{{ route('penerimaantruckingheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
          } else {
            cekValidasiAksi(Id, Aksi)
          }
        }

      }
    })
  }

  function cekValidasiAksi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}penerimaantruckingheader/${Id}/cekValidasiAksi`,
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
            editPenerimaanTruckingHeader(Id)
          }
          if (Aksi == 'DELETE') {
            deletePenerimaanTruckingHeader(Id)
          }
        }

      }
    })
  }


  function clearSelectedRowsPinjaman() {
    getSelectedRows = $("#tablePinjaman").getGridParam("selectedRowIds");
    $("#tablePinjaman")[0].p.selectedRowIds = [];
    $.each(getSelectedRows, function(index, value) {
      let originalGridData = $("#tablePinjaman")
        .jqGrid("getGridParam", "originalData")
        .find((row) => row.id == value);

      sisa = 0
      if ($('#crudForm').data('action') == 'edit') {
        sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal))
      } else {
        sisa = originalGridData.sisa
      }

      $("#tablePinjaman").jqGrid(
        "setCell",
        value,
        "sisa",
        sisa
      );
      $("#tablePinjaman").jqGrid("setCell", value, "nominal", 0);
    })
    $('#tablePinjaman').trigger('reloadGrid');
    setTotalNominal()
    setTotalSisa()
  }

  function selectAllRowsPinjaman() {
    let originalData = $("#tablePinjaman").getGridParam("data");
    let getSelectedRows = originalData.map((data) => data.id);
    $("#tablePinjaman")[0].p.selectedRowIds = [];
    $("#tablePinjaman")
      .jqGrid("setGridParam", {
        selectedRowIds: getSelectedRows
      })
      .trigger("reloadGrid");
    setTotalNominal()
    setTotalSisa()
  }

  function loadPinjamanGrid() {
    let disabled = '';
    if ($('#crudForm').data('action') == 'delete') {
      disabled = 'disabled'
    }

    $("#tablePinjaman")
      .jqGrid({
        datatype: 'local',
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        colModel: [{
            label: "",
            name: "",
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

                $(element).removeClass('form-control')
                $(element).parent().addClass('text-center')
                $(element).addClass('checkbox-selectall')
                if (disabled == '') {
                  $(element).on('click', function() {
                    if ($(this).is(':checked')) {
                      selectAllRowsPinjaman()
                    } else {
                      clearSelectedRowsPinjaman()
                    }
                  })
                } else {
                  $(element).attr('disabled', true)
                }

              }
            },
            formatter: function(value, rowOptions, rowData) {
              let disabled = '';
              if ($('#crudForm').data('action') == 'delete') {
                disabled = 'disabled'
              }
              return `<input type="checkbox" class="checkbox-jqgrid" value="${rowData.id}" ${disabled} onChange="checkboxHandler(this, ${rowData.id})">`;
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
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            sortable: true,
          },
          {
            label: "SUPIR_ID",
            name: "pinj_supirid",
            hidden: true,
            search: false
          },
          {
            label: "no bukti pengeluaran TRUCKING",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            name: "nobukti",
            sortable: true,
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
            name: "sisa",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            sortable: true,
            align: "right",
            formatter: currencyFormat,
          },
          {
            label: "NOMINAL",
            index: 'nominal',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            name: "nominal",
            align: "right",
            editable: true,
            editoptions: {
              dataInit: function(element, id) {
                initAutoNumeric($('#crudForm').find(`[id="${id.id}"]`))
              },
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let originalGridData = $("#tablePinjaman")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tablePinjaman").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  let totalSisa
                  localRow.nominal = event.target.value;
                  let nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  if ($('#crudForm').data('action') == 'edit') {
                    totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)) - nominal
                  } else {
                    totalSisa = originalGridData.sisa - nominal
                  }

                  $("#tablePinjaman").jqGrid(
                    "setCell",
                    rowObject.rowId,
                    "sisa",
                    totalSisa
                  );

                  if (totalSisa < 0) {
                    showDialog('sisa tidak boleh minus')
                    $("#tablePinjaman").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "nominal",
                      0
                    );
                    if (originalGridData.sisa == 0) {
                      $("#tablePinjaman").jqGrid("setCell", rowObject.rowId, "sisa", (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)));
                    } else {
                      if ($('#crudForm').data('action') == 'edit') {
                        $("#tablePinjaman").jqGrid("setCell", rowObject.rowId, "sisa", (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)));
                      } else {
                        $("#tablePinjaman").jqGrid("setCell", rowObject.rowId, "sisa", originalGridData.sisa);
                      }
                    }
                  }

                  // nominalDetails = $(`#tablePinjaman tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tablePinjaman_nominal"]`)
                  // ttlBayar = 0
                  // $.each(nominalDetails, (index, nominalDetail) => {
                  //   ttlBayarDetail = parseFloat($(nominalDetail).attr('title').replaceAll(',', ''))
                  //   ttlBayars = (isNaN(ttlBayarDetail)) ? 0 : ttlBayarDetail;
                  //   ttlBayar += ttlBayars
                  // });
                  // ttlBayar += nominal
                  // initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePinjaman_nominal"]`).text(ttlBayar))

                  // setAllTotal()
                  setTotalNominal()
                  setTotalSisa()
                },
              }, ],
            },
            sortable: false,
            sorttype: "int",
          },
          {
            label: "KETERANGAN",
            name: "keterangan",
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
        editableColumns: ["nominal"],
        selectedRowIds: [],
        onCellSelect: function(rowid, iCol, cellcontent, e) {
          // console.log("Selected Cell - Row ID: " + rowid + ", Column Index: " + iCol);
        },
        afterRestoreCell: function(rowId, value, indexRow, indexColumn) {
          let originalGridData = $("#tablePinjaman")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tablePinjaman").jqGrid("getLocalRow", rowId);

          let getBayar = $("#tablePinjaman").jqGrid("getCell", rowId, "nominal")
          let nominal = (getBayar != '') ? parseFloat(getBayar.replaceAll(',', '')) : 0

          sisa = 0
          if ($('#crudForm').data('action') == 'edit') {
            sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)) - nominal
          } else {
            sisa = parseFloat(originalGridData.sisa) - nominal
          }
          if (indexColumn == 9) {

            $("#tablePinjaman").jqGrid(
              "setCell",
              rowId,
              "sisa",
              sisa
              // sisa - nominal - potongan
            );
          }
          setTotalNominal()
          setTotalSisa()
        },
        isCellEditable: function(cellname, iRow, iCol) {
          let rowData = $(this).jqGrid("getRowData")[iRow - 1];
          if ($('#crudForm').data('action') != 'delete') {
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
                $(this)
                  .find(`tr input[value=${selectedRowId}]`)
                  .prop("checked", true);
                initAutoNumeric($(this).find(`td[aria-describedby="tablePinjaman_nominal"]`))
              });
          }, 100);
          setTotalNominal()
          setTotalSisa()
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

          let originalGridData = $("#tablePinjaman")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);
          let totalSisa
          if ($('#crudForm').data('action') == 'edit') {

            totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal))
          } else {
            totalSisa = parseFloat(originalGridData.sisa)
          }
          $("#tablePinjaman").jqGrid(
            "setCell",
            rowId,
            "sisa",
            totalSisa
          );

          $("#tablePinjaman").jqGrid(
            "setCell",
            rowId,
            "nominal",
            0
          );
          setTotalNominal()
          setTotalSisa()

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
      $('#tablePinjaman').jqGrid('saveCell', value, 11); //emptycell
      $('#tablePinjaman').jqGrid('saveCell', value, 9); //nominal
    })

  });
  $(document).on('click', '#gbox_tablePinjaman .ui-jqgrid-hbox .ui-jqgrid-htable thead .ui-search-toolbar th td a.clearsearchclass', function(event) {
    selectedRowsPengembalian = $("#tablePinjaman").getGridParam("selectedRowIds");
    $.each(selectedRowsPengembalian, function(index, value) {
      $('#tablePinjaman').jqGrid('saveCell', value, 11); //emptycell
      $('#tablePinjaman').jqGrid('saveCell', value, 9); //nominal
    })
  })

  function clearSelectedRowsPinjKaryawan() {
    getSelectedRows = $("#tablePinjamanKaryawan").getGridParam("selectedRowIds");
    $("#tablePinjamanKaryawan")[0].p.selectedRowIds = [];
    $.each(getSelectedRows, function(index, value) {
      let originalGridData = $("#tablePinjamanKaryawan")
        .jqGrid("getGridParam", "originalData")
        .find((row) => row.id == value);

      sisa = 0
      if ($('#crudForm').data('action') == 'edit') {
        sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal))
      } else {
        sisa = originalGridData.sisa
      }

      $("#tablePinjamanKaryawan").jqGrid(
        "setCell",
        value,
        "sisa",
        sisa
      );
      $("#tablePinjamanKaryawan").jqGrid("setCell", value, "nominal", 0);
    })
    $('#tablePinjamanKaryawan').trigger('reloadGrid');
    setTotalNominalKaryawan()
    setTotalSisaKaryawan()
  }

  function selectAllRowsPinjKaryawan() {
    let originalData = $("#tablePinjamanKaryawan").getGridParam("data");
    let getSelectedRows = originalData.map((data) => data.id);
    $("#tablePinjamanKaryawan")[0].p.selectedRowIds = [];
    $("#tablePinjamanKaryawan")
      .jqGrid("setGridParam", {
        selectedRowIds: getSelectedRows
      })
      .trigger("reloadGrid");
    setTotalNominalKaryawan()
    setTotalSisaKaryawan()
  }

  function loadPinjamanKaryawanGrid() {
    let disabled = '';
    if ($('#crudForm').data('action') == 'delete') {
      disabled = 'disabled'
    }
    $("#tablePinjamanKaryawan")
      .jqGrid({
        datatype: 'local',
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        colModel: [{
            label: "",
            name: "",
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

                $(element).removeClass('form-control')
                $(element).parent().addClass('text-center')
                $(element).addClass('checkbox-selectall')
                if (disabled == '') {
                  $(element).on('click', function() {
                    if ($(this).is(':checked')) {
                      selectAllRowsPinjKaryawan()
                    } else {
                      clearSelectedRowsPinjKaryawan()
                    }
                  })
                } else {
                  $(element).attr('disabled', true)
                }

              }
            },
            formatter: function(value, rowOptions, rowData) {
              let disabled = '';
              if ($('#crudForm').data('action') == 'delete') {
                disabled = 'disabled'
              }
              return `<input type="checkbox" class="checkbox-jqgrid" value="${rowData.id}" ${disabled} onChange="checkboxHandlerKaryawan(this, ${rowData.id})">`;
            },
          },
          {
            label: "id",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "KARYAWAN",
            name: "pinj_karyawan",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            sortable: true,
          },
          {
            label: "KARYAWAN_ID",
            name: "pinj_karyawanid",
            hidden: true,
            search: false
          },
          {
            label: "no bukti pengeluaran TRUCKING",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            name: "nobukti",
            sortable: true,
          },
          {
            label: "SISA",
            name: "sisa",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            sortable: true,
            align: "right",
            formatter: currencyFormat,
          },
          {
            label: "NOMINAL",
            index: 'nominal',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            name: "nominal",
            align: "right",
            editable: true,
            editoptions: {
              dataInit: function(element, id) {
                initAutoNumeric($('#crudForm').find(`[id="${id.id}"]`))
              },
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let originalGridData = $("#tablePinjamanKaryawan")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tablePinjamanKaryawan").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  let totalSisa
                  localRow.nominal = event.target.value;
                  let nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  if ($('#crudForm').data('action') == 'edit') {
                    totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)) - nominal
                  } else {
                    totalSisa = originalGridData.sisa - nominal
                  }

                  $("#tablePinjamanKaryawan").jqGrid(
                    "setCell",
                    rowObject.rowId,
                    "sisa",
                    totalSisa
                  );

                  if (totalSisa < 0) {
                    showDialog('sisa tidak boleh minus')
                    $("#tablePinjamanKaryawan").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "nominal",
                      0
                    );
                    if (originalGridData.sisa == 0) {
                      $("#tablePinjamanKaryawan").jqGrid("setCell", rowObject.rowId, "sisa", (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)));
                    } else {
                      if ($('#crudForm').data('action') == 'edit') {
                        $("#tablePinjamanKaryawan").jqGrid("setCell", rowObject.rowId, "sisa", (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)));
                      } else {
                        $("#tablePinjamanKaryawan").jqGrid("setCell", rowObject.rowId, "sisa", originalGridData.sisa);
                      }
                    }
                  }

                  // nominalDetails = $(`#tablePinjamanKaryawan tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tablePinjamanKaryawan_nominal"]`)
                  // ttlBayar = 0
                  // $.each(nominalDetails, (index, nominalDetail) => {
                  //   ttlBayarDetail = parseFloat($(nominalDetail).attr('title').replaceAll(',', ''))
                  //   ttlBayars = (isNaN(ttlBayarDetail)) ? 0 : ttlBayarDetail;
                  //   ttlBayar += ttlBayars
                  // });
                  // ttlBayar += nominal
                  // initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePinjamanKaryawan_nominal"]`).text(ttlBayar))

                  // setAllTotal()
                  setTotalNominalKaryawan()
                  setTotalSisaKaryawan()
                },
              }, ],
            },
            sortable: false,
            sorttype: "int",
          },
          {
            label: "KETERANGAN",
            name: "keterangan",
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
        editableColumns: ["nominal"],
        selectedRowIds: [],
        afterRestoreCell: function(rowId, value, indexRow, indexColumn) {
          let originalGridData = $("#tablePinjamanKaryawan")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tablePinjamanKaryawan").jqGrid("getLocalRow", rowId);

          let getBayar = $("#tablePinjamanKaryawan").jqGrid("getCell", rowId, "nominal")
          let nominal = (getBayar != '') ? parseFloat(getBayar.replaceAll(',', '')) : 0

          sisa = 0
          if ($('#crudForm').data('action') == 'edit') {
            sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)) - nominal
          } else {
            sisa = parseFloat(originalGridData.sisa) - nominal
          }
          if (indexColumn == 5) {

            $("#tablePinjamanKaryawan").jqGrid(
              "setCell",
              rowId,
              "sisa",
              sisa
              // sisa - nominal - potongan
            );
          }
          setTotalNominalKaryawan()
          setTotalSisaKaryawan()
        },
        isCellEditable: function(cellname, iRow, iCol) {
          let rowData = $(this).jqGrid("getRowData")[iRow - 1];
          if ($('#crudForm').data('action') != 'delete') {
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
                $(this)
                  .find(`tr input[value=${selectedRowId}]`)
                  .prop("checked", true);
                initAutoNumeric($(this).find(`td[aria-describedby="tablePinjamanKaryawan_nominal"]`))
              });
          }, 100);
          setTotalNominalKaryawan()
          setTotalSisaKaryawan()
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
          let localRow = $("#tablePinjamanKaryawan").jqGrid("getLocalRow", rowId);

          let originalGridData = $("#tablePinjamanKaryawan")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);
          let totalSisa
          if ($('#crudForm').data('action') == 'edit') {

            totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal))
          } else {
            totalSisa = parseFloat(originalGridData.sisa)
          }
          $("#tablePinjamanKaryawan").jqGrid(
            "setCell",
            rowId,
            "sisa",
            totalSisa
          );
          $("#tablePinjamanKaryawan").jqGrid(
            "setCell",
            rowId,
            "nominal",
            0
          );
          setTotalNominalKaryawan()
          setTotalSisaKaryawan()
          return true;
        },
      });
    /* Append clear filter button */
    loadClearFilter($('#tablePinjamanKaryawan'))

    /* Append global search */
    // loadGlobalSearch($('#tablePinjamanKaryawan'))
  }

  $(document).on('click', '#resetdatafilter_tablePinjamanKaryawan', function(event) {
    selectedRowsPengembalian = $("#tablePinjamanKaryawan").getGridParam("selectedRowIds");
    $.each(selectedRowsPengembalian, function(index, value) {
      $('#tablePinjamanKaryawan').jqGrid('saveCell', value, 7); //emptycell
      $('#tablePinjamanKaryawan').jqGrid('saveCell', value, 5); //nominal
    })

  });
  $(document).on('click', '#gbox_tablePinjamanKaryawan .ui-jqgrid-hbox .ui-jqgrid-htable thead .ui-search-toolbar th td a.clearsearchclass', function(event) {
    selectedRowsPengembalian = $("#tablePinjamanKaryawan").getGridParam("selectedRowIds");
    $.each(selectedRowsPengembalian, function(index, value) {
      $('#tablePinjamanKaryawan').jqGrid('saveCell', value, 7); //emptycell
      $('#tablePinjamanKaryawan').jqGrid('saveCell', value, 5); //nominal
    })
  })

  function loadPengembalianTitipanGrid() {
    let disabled = '';
    if ($('#crudForm').data('action') == 'delete') {
      disabled = 'disabled'
    }
    $("#tablePengembalianTitipan")
      .jqGrid({
        datatype: 'local',
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
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
                dari = $('#crudForm').find(`[name="tgldari"]`).val()
                sampai = $('#crudForm').find(`[name="tglsampai"]`).val()
                let aksi = $('#crudForm').data('action')

                $(element).removeClass('form-control')
                $(element).parent().addClass('text-center')
                $(element).addClass('checkbox-selectall')
                if (disabled == '') {
                  $(element).on('click', function() {
                    if ($(this).is(':checked')) {
                      selectAllRowsPBT()
                    } else {
                      clearSelectedRowsPBT()
                    }
                  })
                } else {
                  $(element).attr('disabled', true)
                }

              }
            },
            formatter: function(value, rowOptions, rowData) {
              let disabled = '';
              if ($('#crudForm').data('action') == 'delete') {
                disabled = 'disabled'
              }
              return `<input type="checkbox" class="checkbox-jqgrid" value="${rowData.id}" ${disabled} onChange="checkboxTitipan(this, ${rowData.id})">`;
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
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            name: "nobukti_titipan",
            sortable: true,
          },
          {
            label: 'TGL BUKTI',
            name: 'tglbukti_titipan',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: "nominal",
            name: "nominal_titipan",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            sortable: true,
            align: "right",
            formatter: currencyFormat,
          },

          {
            label: "KETERANGAN",
            name: "keterangan_titipan",
            sortable: false,
            editable: false,
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
          },
          {
            label: "jenis order",
            name: "jenisorder_id",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            sortable: false,
            editable: false,
            // width: 500
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
        // editableColumns: ["nominal"],
        selectedRowIds: [],
        afterRestoreCell: function(rowId, value, indexRow, indexColumn) {
          let originalGridData = $("#tablePengembalianTitipan")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tablePengembalianTitipan").jqGrid("getLocalRow", rowId);

          // let getBayar = $("#tablePengembalianTitipan").jqGrid("getCell", rowId, "nominal")
          // let nominal = (getBayar != '') ? parseFloat(getBayar.replaceAll(',', '')) : 0

          sisa = 0
          if ($('#crudForm').data('action') == 'edit') {
            sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)) - nominal
          } else {
            sisa = originalGridData.sisa
          }
          // console.log(indexColumn)
          // if (indexColumn == 5) {

          //   $("#tablePengembalianTitipan").jqGrid(
          //     "setCell",
          //     rowId,
          //     "sisa",
          //     sisa
          //     // sisa - nominal - potongan
          //   );
          // }
          // setTotalNominalKaryawan()
          // setTotalSisaKaryawan()
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
                // initAutoNumeric($(this).find(`td[aria-describedby="tablePengembalianTitipan_nominal"]`))
              });
          }, 100);
          // setTotalNominalKaryawan()
          // setTotalSisaKaryawan()
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
    /* Append clear filter button */
    loadClearFilter($('#tablePengembalianTitipan'))

    /* Append global search */
    // loadGlobalSearch($('#tablePengembalianTitipan'))
  }


  function getDataPinjaman(supirId, id) {
    aksi = $('#crudForm').data('action')
    supirId = (supirId == '') ? 0 : supirId;
    if (aksi == 'edit') {
      if (id != undefined) {
        url = `${apiUrl}penerimaantruckingheader/${id}/edit/getpengembalianpinjaman`
      } else {
        url = `${apiUrl}penerimaantruckingheader/${supirId}/getpinjaman`
      }
    } else if (aksi == 'delete') {
      url = `${apiUrl}penerimaantruckingheader/${id}/delete/getpengembalianpinjaman`
      attribut = 'disabled'
      forCheckbox = 'disabled'
    } else if (aksi == 'add') {
      url = `${apiUrl}penerimaantruckingheader/${supirId}/getpinjaman`
    }

    return new Promise((resolve, reject) => {
      $.ajax({
        url: url,
        dataType: "JSON",
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          tglbukti: $('#crudForm').find("[name=tglbukti]").val()
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

  function getDataPinjamanKaryawan(karyawanId, id) {
    aksi = $('#crudForm').data('action')
    karyawanId = (karyawanId == '') ? 0 : karyawanId;
    if (aksi == 'edit') {
      if (id != undefined) {
        url = `${apiUrl}penerimaantruckingheader/${id}/edit/getpengembalianpinjamankaryawan`
      } else {
        url = `${apiUrl}penerimaantruckingheader/${karyawanId}/getpinjamankaryawan`
      }
    } else if (aksi == 'delete') {
      url = `${apiUrl}penerimaantruckingheader/${id}/delete/getpengembalianpinjamankaryawan`
      attribut = 'disabled'
      forCheckbox = 'disabled'
    } else if (aksi == 'add') {
      url = `${apiUrl}penerimaantruckingheader/${karyawanId}/getpinjamankaryawan`
    }

    return new Promise((resolve, reject) => {
      $.ajax({
        url: url,
        dataType: "JSON",
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          tglbukti: $('#crudForm').find("[name=tglbukti]").val()
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

  function getDataPengembalianTitipan(reloadGrid = null) {
    aksi = $('#crudForm').data('action')
    let idTitipan = $('#crudForm').find("[name=id]").val()
    if (aksi == 'edit') {
      url = `${apiUrl}penerimaantruckingheader/getpengembaliantitipan`
    } else if (aksi == 'delete' || aksi == 'view') {
      url = `${apiUrl}penerimaantruckingheader/getpengembaliantitipan`
      attribut = 'disabled'
      forCheckbox = 'disabled'
    } else if (aksi == 'add') {
      url = `${apiUrl}penerimaantruckingheader/getpengembaliantitipan`
    }

    periodedari = $('[name=periodedari]').val()
    periodesampai = $('[name=periodesampai]').val()
    jenisorder_id = $('[name=jenisorderan_id]').val()
    if ((periodedari != '') || (periodesampai != '') || (jenisorder_id != '')) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: url,
          dataType: "JSON",
          data: {
            periodedari: periodedari,
            periodesampai: periodesampai,
            jenisorderan_id: jenisorder_id,
            id: idTitipan,
            reloadGrid: reloadGrid
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

    if (aksi !== 'add') {
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
          error: error => {
            reject(error)
          }
        });
      });
    }
  }

  function checkboxHandler(element, rowId) {

    let isChecked = $(element).is(":checked");
    let editableColumns = $("#tablePinjaman").getGridParam("editableColumns");
    let selectedRowIds = $("#tablePinjaman").getGridParam("selectedRowIds");
    let originalGridData = $("#tablePinjaman")
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
          sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal))
        } else {
          sisa = originalGridData.sisa
        }

        $("#tablePinjaman").jqGrid(
          "setCell",
          rowId,
          "sisa",
          sisa
        );

        $("#tablePinjaman").jqGrid("setCell", rowId, "nominal", 0);
        setTotalNominal()
        setTotalSisa()
      } else {
        selectedRowIds.push(rowId);

        let localRow = $("#tablePinjaman").jqGrid("getLocalRow", rowId);

        if ($('#crudForm').data('action') == 'edit') {
          // if (originalGridData.sisa == 0) {

          //   let getNominal = $("#tablePinjaman").jqGrid("getCell", rowId, "nominal")
          //   localRow.nominal = (getNominal != '') ? parseFloat(getNominal.replaceAll(',', '')) : 0
          // } else {
          //   localRow.nominal = originalGridData.sisa
          // }
          localRow.nominal = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal) + parseFloat(originalGridData.potongan))
        }

        $("#tablePinjaman").jqGrid(
          "setCell",
          rowId,
          "nominal",
          0
        );
        initAutoNumeric($(`#tablePinjaman tr#${rowId}`).find(`td[aria-describedby="tablePinjaman_nominal"]`))
        setTotalNominal()
        setTotalSisa()
      }
    });

    $("#tablePinjaman").jqGrid("setGridParam", {
      selectedRowIds: selectedRowIds,
    });

  }

  function checkboxHandlerKaryawan(element, rowId) {

    let isChecked = $(element).is(":checked");
    let editableColumns = $("#tablePinjamanKaryawan").getGridParam("editableColumns");
    let selectedRowIds = $("#tablePinjamanKaryawan").getGridParam("selectedRowIds");
    let originalGridData = $("#tablePinjamanKaryawan")
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
          sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal))
        } else {
          sisa = originalGridData.sisa
        }

        $("#tablePinjamanKaryawan").jqGrid(
          "setCell",
          rowId,
          "sisa",
          sisa
        );

        $("#tablePinjamanKaryawan").jqGrid("setCell", rowId, "nominal", 0);
        setTotalNominalKaryawan()
        setTotalSisaKaryawan()
      } else {
        selectedRowIds.push(rowId);

        let localRow = $("#tablePinjamanKaryawan").jqGrid("getLocalRow", rowId);

        if ($('#crudForm').data('action') == 'edit') {
          // if (originalGridData.sisa == 0) {

          //   let getNominal = $("#tablePinjamanKaryawan").jqGrid("getCell", rowId, "nominal")
          //   localRow.nominal = (getNominal != '') ? parseFloat(getNominal.replaceAll(',', '')) : 0
          // } else {
          //   localRow.nominal = originalGridData.sisa
          // }
          localRow.nominal = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal) + parseFloat(originalGridData.potongan))
        }

        $("#tablePinjamanKaryawan").jqGrid(
          "setCell",
          rowId,
          "nominal",
          0
        );
        initAutoNumeric($(`#tablePinjamanKaryawan tr#${rowId}`).find(`td[aria-describedby="tablePinjamanKaryawan_nominal"]`))
        setTotalNominalKaryawan()
        setTotalSisaKaryawan()
      }
    });

    $("#tablePinjamanKaryawan").jqGrid("setGridParam", {
      selectedRowIds: selectedRowIds,
    });

  }

  function clearSelectedRowsPBT() {

    $("#tablePengembalianTitipan")[0].p.selectedRowIds = [];
    $('#tablePengembalianTitipan').trigger('reloadGrid');
    setTotalNominalTitipan()
  }

  function selectAllRowsPBT(reloadGrid = null) {

    let originalData = $("#tablePengembalianTitipan").getGridParam("data");
    let getSelectedRows = originalData.map((data) => data.id);
    $("#tablePengembalianTitipan")[0].p.selectedRowIds = [];

    setTimeout(() => {
      $("#tablePengembalianTitipan")
        .jqGrid("setGridParam", {
          selectedRowIds: getSelectedRows
        })
        .trigger("reloadGrid");

      setTotalNominalTitipan()
    })
  }

  function checkboxTitipan(element, rowId) {

    let isChecked = $(element).is(":checked");
    let editableColumns = $("#tablePengembalianTitipan").getGridParam("editableColumns");
    let selectedRowIds = $("#tablePengembalianTitipan").getGridParam("selectedRowIds");
    let originalGridData = $("#tablePengembalianTitipan")
      .jqGrid("getGridParam", "originalData")
      .find((row) => row.id == rowId);


    if (!isChecked) {
      for (var i = 0; i < selectedRowIds.length; i++) {
        if (selectedRowIds[i] == rowId) {
          selectedRowIds.splice(i, 1);
        }
      }

    } else {
      selectedRowIds.push(rowId);
    }

    $("#tablePengembalianTitipan").jqGrid("setGridParam", {
      selectedRowIds: selectedRowIds,
    });
    setTotalNominalTitipan()
  }

  function setTotalNominalTitipan() {
    // let nominalDetails = $(`#tablePengembalianTitipan`).find(`td[aria-describedby="tablePengembalianTitipan_nominal_titipan"]`)
    let nominal = 0
    let selectedRowsPinjaman = $("#tablePengembalianTitipan").getGridParam("selectedRowIds");
    $.each(selectedRowsPinjaman, function(index, value) {
      dataPinjaman = $("#tablePengembalianTitipan").jqGrid("getLocalRow", value);
      nominals = (dataPinjaman.nominal_titipan == undefined || dataPinjaman.nominal_titipan == '') ? 0 : dataPinjaman.nominal_titipan;
      getNominal = (isNaN(nominals)) ? parseFloat(nominals.replaceAll(',', '')) : parseFloat(nominals)
      nominal = nominal + getNominal
    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePengembalianTitipan_nominal_titipan"]`).text(nominal))
  }

  function setTotalSisa() {
    // let sisaDetails = $(`#tablePinjaman`).find(`td[aria-describedby="tablePinjaman_sisa"]`)
    let sisa = 0
    // let originalData = $("#tablePinjaman").getGridParam("data");
    // $.each(originalData, function(index, value) {
    //   sisas = value.sisa;
    //   sisas = (isNaN(sisas)) ? parseFloat(sisas.replaceAll(',', '')) : parseFloat(sisas)
    //   sisa += sisas

    // })
    $("#tablePinjaman").find("tbody tr").each(function() {
      $(this).find(`td[aria-describedby="tablePinjaman_sisa"]`).map(function() {
        sisa = sisa + parseFloat($(this).text().replaceAll(',', ''));
      });
    });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePinjaman_sisa"]`).text(sisa))
  }

  function setTotalSisaKaryawan() {
    let sisaDetails = $(`#tablePinjamanKaryawan`).find(`td[aria-describedby="tablePinjamanKaryawan_sisa"]`)
    let sisa = 0
    let originalData = $("#tablePinjamanKaryawan").getGridParam("data");
    $.each(originalData, function(index, value) {
      sisas = value.sisa;
      sisas = (isNaN(sisas)) ? parseFloat(sisas.replaceAll(',', '')) : parseFloat(sisas)
      sisa += sisas

    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePinjamanKaryawan_sisa"]`).text(sisa))
  }

  function showPenerimaanTruckingHeader(form, id) {
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')

      $.ajax({
        url: `${apiUrl}penerimaantruckingheader/${id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          let tgl = response.data.tglbukti
          let kodepenerimaan = response.data.kodepenerimaan

          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }

            if (index == 'penerimaantrucking') {
              element.data('current-value', value).prop('readonly', true)
              element.parent('.input-group').find('.button-clear').remove()
              element.parent('.input-group').find('.input-group-append').remove()
            }
            if (index == 'bank') {
              element.data('current-value', value).prop('readonly', true)
              element.parent('.input-group').find('.button-clear').remove()
              element.parent('.input-group').find('.input-group-append').remove()
            }
            if (kodepenerimaan === "PJP") {
              if (index == 'supir') {
                element.val(value)
                element.data('current-value', value).prop('readonly', true)
                element.parent('.input-group').find('.button-clear').remove()
                element.parent('.input-group').find('.input-group-append').remove()
              }
            }

            if (kodepenerimaan === "PJPK") {
              if (index == 'karyawan') {
                element.data('current-value', value).prop('readonly', true)
              }
            }
            if (index == 'keterangancoa') {
              element.data('current-value', value)
            }
          })
          if (kodepenerimaan === "PJP") {

            getDataPinjaman(response.data.supirheader_id, id).then((response) => {

              let selectedId = []
              let totalBayar = 0

              $.each(response.data, (index, value) => {
                if (value.penerimaantrucking_id != null) {
                  selectedId.push(value.id)
                  totalBayar += parseFloat(value.nominal)
                }
              })
              $('#tablePinjaman').jqGrid("clearGridData");
              setTimeout(() => {

                $("#tablePinjaman")
                  .jqGrid("setGridParam", {
                    datatype: "local",
                    data: response.data,
                    originalData: response.data,
                    rowNum: response.data.length,
                    selectedRowIds: selectedId
                  })
                  .trigger("reloadGrid");
              }, 100);
              initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePinjaman_nominal"]`).text(totalBayar))

            });
          } else if (kodepenerimaan === "PJPK") {

            getDataPinjamanKaryawan(response.data.karyawanheader_id, id).then((response) => {

              let selectedId = []
              let totalBayar = 0

              $.each(response.data, (index, value) => {
                if (value.penerimaantrucking_id != null) {
                  selectedId.push(value.id)
                  totalBayar += parseFloat(value.nominal)
                }
              })
              $('#tablePinjamanKaryawan').jqGrid("clearGridData");
              setTimeout(() => {

                $("#tablePinjamanKaryawan")
                  .jqGrid("setGridParam", {
                    datatype: "local",
                    data: response.data,
                    originalData: response.data,
                    rowNum: response.data.length,
                    selectedRowIds: selectedId
                  })
                  .trigger("reloadGrid");
              }, 100);
              initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePinjamanKaryawan_nominal"]`).text(totalBayar))

            });
          } else if (kodepenerimaan === "PBT") {
            getDataPengembalianTitipan().then((response) => {
              // console.log('before', $("#tablePinjamanKaryawan").jqGrid('getGridParam', 'selectedRowIds'))
              let selectedId = []
              let totalBayar = 0

              $.each(response.data, (index, value) => {
                selectedId.push(value.id)
                totalBayar += parseFloat(value.nominal_titipan)
              })
              setTimeout(() => {

                $("#tablePengembalianTitipan")
                  .jqGrid("setGridParam", {
                    datatype: "local",
                    data: response.data,
                    originalData: response.data,
                    rowNum: response.data.length,
                    selectedRowIds: selectedId
                  })
                  .trigger("reloadGrid");
                initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePengembalianTitipan_nominal_titipan"]`).text(totalBayar))

              }, 100);
            }).catch((error) => {
              showDialog(error.responseJSON)
            })
            // getDataPengembalianTitipan().then((response) => {

            //   let selectedId = []
            //   let totalBayar = 0

            //   $.each(response.data, (index, value) => {
            //     selectedId.push(value.id)
            //     totalBayar += parseFloat(value.nominal)
            //   })
            //   $('#tablePengembalianTitipan').jqGrid("clearGridData");
            //   setTimeout(() => {

            //     $("#tablePengembalianTitipan")
            //       .jqGrid("setGridParam", {
            //         datatype: "local",
            //         data: response.data,
            //         originalData: response.data,
            //         rowNum: response.data.length,
            //         selectedRowIds: selectedId
            //       })
            //       .trigger("reloadGrid");
            //   }, 100);
            //   console.log(response.data)
            //   // initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePinjamanKaryawan_nominal"]`).text(totalBayar))

            // });
          } else {
            $('#detailList tbody').html('')
            $.each(response.detail, (index, detail) => {
              let detailRow = $(`
                <tr>
                    <td></td>
                    <td class="tbl_supir_id">
                        <input type="hidden" name="supir_id[]">
                        <input type="text" name="supir[]" data-current-value="${detail.supir}" class="form-control supir-lookup">
                    </td>
                    <td class="tbl_karyawan_id">
                      <input type="hidden" name="karyawan_id[]">
                      <input type="text" name="karyawandetail[]" data-current-value="${detail.karyawandetail}" class="form-control karyawan-lookup">
                    </td>
                    <td class="tbl_pengeluarantruckingheader_nobukti">
                        <input type="text" name="pengeluarantruckingheader_nobukti[]" data-current-value="${detail.pengeluarantruckingheader_nobukti}" class="form-control pengeluarantruckingheader-lookup">
                    </td>
                    <td class="tbl_keterangan">
                        <input type="text" name="keterangan[]" class="form-control"> 
                    </td>
                    <td class="tbl_nominal">
                        <input type="text" name="nominal[]" class="form-control autonumeric nominal"> 
                    </td>
                    <td  class="tbl_aksi">
                        <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                    </td>
                </tr>
              `)

              detailRow.find(`[name="supir_id[]"]`).val(detail.supir_id)
              detailRow.find(`[name="supir[]"]`).val(detail.supir)
              detailRow.find(`[name="karyawan_id[]"]`).val(detail.karyawan_id)
              detailRow.find(`[name="karyawandetail[]"]`).val(detail.karyawandetail)
              detailRow.find(`[name="pengeluarantruckingheader_nobukti[]"]`).val(detail.pengeluarantruckingheader_nobukti)
              detailRow.find(`[name="keterangan[]"]`).val(detail.keterangan)
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
                  if (KodePenerimaanId == 'DPO') {
                    element.parents('tr').find(`td [name="keterangan[]"]`).val("DEPOSITO SUPIR " + supir.namasupir)
                  }
                },
                onCancel: (element) => {
                  element.val(element.data('currentValue'))
                },
                onClear: (element) => {
                  element.val('')
                  element.parents('td').find(`[name="supir_id[]"]`).val('')
                  element.data('currentValue', element.val())
                }
              })

              $('.karyawan-lookup').last().lookup({
                title: 'Karyawan Lookup',
                fileName: 'karyawan',
                beforeProcess: function(test) {
                  this.postData = {
                    Aktif: 'AKTIF',

                  }
                },
                onSelectRow: (karyawan, element) => {
                  element.parents('td').find(`[name="karyawan_id[]"]`).val(karyawan.id)
                  element.val(karyawan.namakaryawan)
                  element.data('currentValue', element.val())
                  if (KodePenerimaanId == 'DPOK') {
                    element.parents('tr').find(`td [name="keterangan[]"]`).val("DEPOSITO KARYAWAN " + karyawan.namakaryawan)
                  }
                },
                onCancel: (element) => {
                  element.val(element.data('currentValue'))
                },
                onClear: (element) => {
                  element.val('')
                  element.parents('td').find(`[name="karyawan_id[]"]`).val('')
                  element.data('currentValue', element.val())
                }
              })
              $('.pengeluarantruckingheader-lookup').last().lookup({
                title: 'Pengeluaran Trucking Lookup',
                fileName: 'pengeluarantruckingheader',
                beforeProcess: function(test) {
                  this.postData = {
                    Aktif: 'AKTIF',

                  }
                },
                onSelectRow: (pengeluarantruckingheader, element) => {
                  element.val(pengeluarantruckingheader.nobukti)
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


            })
          }
          KodePenerimaanId = kodepenerimaan
          setRowNumbers()
          if (form.data('action') === 'delete') {
            form.find('[name]').addClass('disabled')
            initDisabled()
          }
          setKodePenerimaan(response.data.penerimaantrucking);

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function setTotalPinjaman() {
    let jlhpinj = 0
    $("#tablePinjaman").find("tbody tr").each(function() {
      $(this).find(`td[aria-describedby="tablePinjaman_jlhpinjaman"]`).map(function() {
        jlhpinj = jlhpinj + parseFloat($(this).text().replaceAll(',', ''));
      });
    });
    // let originalData = $("#tablePinjaman").getGridParam("data");
    // $.each(originalData, function(index, value) {
    //   lunas_jlhpinj = value.jlhpinjaman;
    //   jlhpinjs = (isNaN(lunas_jlhpinj)) ? parseFloat(lunas_jlhpinj.replaceAll(',', '')) : parseFloat(lunas_jlhpinj)
    //   jlhpinj += jlhpinjs

    // })
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
    // $.each(originalData, function(index, value) {
    //   // if ($("#tablePinjaman").jqGrid('getRowData', value.id).columnName.includes('filterText')) {
    //   //       console.log(row)
    //   //   }
    //   lunas_bayarpinj = value.totalbayar;
    //   bayarpinjs = (isNaN(lunas_bayarpinj)) ? parseFloat(lunas_bayarpinj.replaceAll(',', '')) : parseFloat(lunas_bayarpinj)
    //   bayarpinj += bayarpinjs

    // })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePinjaman_totalbayar"]`).text(bayarpinj))
  }

  function setTotalNominal() {
    let nominalDetails = $(`#tablePinjaman`).find(`td[aria-describedby="tablePinjaman_nominal"]`)
    let nominal = 0
    selectedRowsPinjaman = $("#tablePinjaman").getGridParam("selectedRowIds");
    $.each(selectedRowsPinjaman, function(index, value) {
      dataPinjaman = $("#tablePinjaman").jqGrid("getLocalRow", value);
      nominals = (dataPinjaman.nominal == undefined || dataPinjaman.nominal == '') ? 0 : dataPinjaman.nominal;
      getNominal = (isNaN(nominals)) ? parseFloat(nominals.replaceAll(',', '')) : parseFloat(nominals)
      nominal = nominal + getNominal
    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePinjaman_nominal"]`).text(nominal))
  }

  function setTotalNominalKaryawan() {
    let nominalDetails = $(`#tablePinjamanKaryawan`).find(`td[aria-describedby="tablePinjamanKaryawan_nominal"]`)
    let nominal = 0
    selectedRowsPinjaman = $("#tablePinjamanKaryawan").getGridParam("selectedRowIds");
    $.each(selectedRowsPinjaman, function(index, value) {
      dataPinjaman = $("#tablePinjamanKaryawan").jqGrid("getLocalRow", value);
      nominals = (dataPinjaman.nominal == undefined || dataPinjaman.nominal == '') ? 0 : dataPinjaman.nominal;
      getNominal = (isNaN(nominals)) ? parseFloat(nominals.replaceAll(',', '')) : parseFloat(nominals)
      nominal = nominal + getNominal
    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePinjamanKaryawan_nominal"]`).text(nominal))
  }

  function getPinjaman() {
    let supirId = $('#supirHaeaderId').val();
    KodePenerimaanId

    let data = {
      "supir": supirId,
    }
    console.log((supirId != ""));
    if ((KodePenerimaanId === "PJP") && (supirId != "")) {
      $.ajax({
        url: `${apiUrl}gajisupirheader/${supirId}/getpinjpribadi`,
        method: 'GET',
        dataType: 'JSON',
        data: {
          limit: 0
        },
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $('#detailList tbody').html('')

          let totalSisa = 0
          $.each(response.data, (index, detail) => {
            let id = detail.id
            totalSisa = totalSisa + parseFloat(detail.sisa);
            let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);
            let detailRow = $(`
                <tr >
                <td>
                  ${id}
                </td>
                <td>
                    <input name='pinjPribadi[]' type="checkbox" id="checkItem" value="${id}">
                    <input name='pinjPribadi_nobukti[]' type="hidden" value="${detail.nobukti}">
                </td>
                <td>${detail.nobukti}</td>
                <td>
                    <p class="text-right sisaPP autonumeric">${sisa}</p>
                    <input type="hidden" name="sisaPP[]" class="autonumeric" value="${sisa}">
                    <input type="hidden" name="sisaAwalPP[]" class="autonumeric" value="${sisa}">
                </td>
                <td id=${id}>
                    <input type="text" name="nominalPP[]" disabled class="form-control bayar text-right">
                </td>
                <td>
                    ${detail.keterangan}
                    <input name='pinjPribadi_keterangan[]' type="hidden" value="${detail.keterangan}">
                </td>
                </tr>
            `)

            initAutoNumeric(detailRow.find(`[name="sisaPP[]"]`))
            initAutoNumeric(detailRow.find(`[name="sisaAwalPP[]"]`))
            initAutoNumeric(detailRow.find(`.sisaPP`))

            $('#detailList tbody').append(detailRow)
            setTotalPP()
          })
          setTampilanForm()
          $(`#detailList tfoot`).show()

        }
      })
    }
  }

  function setTotalPP() {
    let nominalDetails = $(`#table_body [name="nominalPP[]"]:not([disabled])`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)

  }

  $(document).on('click', `#detailList tbody [name="pinjPribadi[]"]`, function() {

    if ($(this).prop("checked") == true) {
      $(this).closest('tr').find(`td [name="nominalPP[]"]`).prop('disabled', false)
      let sisa = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisaPP[]"]`)[0])
      initAutoNumeric($(this).closest('tr').find(`td [name="nominalPP[]"]`))

      // initAutoNumeric($(this).closest('tr').find(`td [name="nominalPP[]"]`).val(sisa))
      // let bayar = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="nominalPP[]"]`)[0])
      // let totalSisa = sisa - bayar

      // $(this).closest("tr").find(".sisaPP").html(totalSisa)
      // $(this).closest("tr").find(`[name="sisaPP[]"]`).val(totalSisa)
      // initAutoNumeric($(this).closest("tr").find(".sisaPP"))
      setTotalPP()
      setSisaPP()
    } else {
      let id = $(this).val()
      $(this).closest('tr').find(`td [name="nominalPP[]"]`).remove();
      let newBayarElement = `<input type="text" name="nominalPP[]" class="form-control text-right" disabled>`
      $(this).closest('tr').find(`#${id}`).append(newBayarElement)

      let sisa = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisaAwalPP[]"]`)[0])

      initAutoNumeric($(this).closest('tr').find(`td [name="sisaPP[]"]`).val(sisa))
      $(this).closest("tr").find(".sisaPP").html(sisa)
      initAutoNumeric($(this).closest("tr").find(".sisaPP"))

      setTotalPP()
      setSisaPP()
    }
  })

  $(document).on('input', `#table_body [name="nominalPP[]"]`, function(event) {
    setTotalPP()
    setSisaDetail(this)
  })

  function setSisaDetail(el) {
    let sisa = AutoNumeric.getNumber($(el).closest("tr").find(`[name="sisaPP[]"]`)[0])
    let sisaAwal = AutoNumeric.getNumber($(el).closest("tr").find(`[name="sisaAwalPP[]"]`)[0])
    let bayar = $(el).val()
    bayar = parseFloat(bayar.replaceAll(',', ''));
    console.log(sisaAwal, bayar);
    bayar = Number.isNaN(bayar) ? 0 : bayar
    totalSisa = sisaAwal - bayar
    $(el).closest("tr").find(".sisaPP").html(totalSisa)
    $(el).closest("tr").find(`[name="sisaPP[]"]`).val(totalSisa)
    initAutoNumeric($(el).closest("tr").find(".sisaPP"))
    let Sisa = $(`#table_body .sisaPP`)
    let total = 0

    $.each(Sisa, (index, SISA) => {
      total += AutoNumeric.getNumber(SISA)
    });
    new AutoNumeric('#sisaFoot').set(total)
  }

  function setSisaPP() {
    let nominalDetails = $(`.sisaPP`)
    let bayar = 0
    $.each(nominalDetails, (index, nominalDetail) => {
      bayar += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#sisaFoot').set(bayar)
  }

  function addRow() {
    let detailRow = $(`
      <tr>
        <td></td>
        <td class="tbl_supir_id">
          <input type="hidden" name="supir_id[]">
          <input type="text" name="supir[]"  class="form-control supir-lookup">
        </td>
        <td class="tbl_karyawan_id">
          <input type="hidden" name="karyawan_id[]">
          <input type="text" name="karyawandetail[]"  class="form-control karyawan-lookup">
        </td>
        <td class="tbl_pengeluarantruckingheader_nobukti">
          <input type="text" name="pengeluarantruckingheader_nobukti[]"  class="form-control pengeluarantruckingheader-lookup">
        </td>
        <td class="tbl_keterangan">
          <input type="text" name="keterangan[]" class="form-control"> 
        </td>
        <td class="tbl_nominal">
          <input type="text" name="nominal[]" class="form-control autonumeric nominal"> 
        </td>
        <td  class="tbl_aksi">
            <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
        </td>
      </tr>
    `)

    // if (KodePenerimaanId == 'DPO') {
    //   detailRow.find(`[name="keterangan[]"]`).val("DEPOSITO SUPIR")
    // }
    // if (KodePenerimaanId == 'DPOK') {
    //   detailRow.find(`[name="keterangan[]"]`).val("DEPOSITO KARYAWAN")
    // }
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

        if (KodePenerimaanId == 'DPO') {
          element.parents('tr').find(`td [name="keterangan[]"]`).val("DEPOSITO SUPIR " + supir.namasupir)
        }
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.parents('td').find(`[name="supir_id[]"]`).val('')
        element.data('currentValue', element.val())
      }
    })

    $('.karyawan-lookup').last().lookup({
      title: 'Karyawan Lookup',
      fileName: 'karyawan',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',

        }
      },
      onSelectRow: (karyawan, element) => {
        element.parents('td').find(`[name="karyawan_id[]"]`).val(karyawan.id)
        element.val(karyawan.namakaryawan)
        element.data('currentValue', element.val())
        if (KodePenerimaanId == 'DPOK') {
          element.parents('tr').find(`td [name="keterangan[]"]`).val("DEPOSITO KARYAWAN " + karyawan.namakaryawan)
        }
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.parents('td').find(`[name="karyawan_id[]"]`).val('')
        element.data('currentValue', element.val())
      }
    })
    $('.pengeluarantruckingheader-lookup').last().lookup({
      title: 'Pengeluaran Trucking Lookup',
      fileName: 'pengeluarantruckingheader',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',

        }
      },
      onSelectRow: (pengeluarantruckingheader, element) => {
        element.val(pengeluarantruckingheader.nobukti)
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

    initAutoNumeric(detailRow.find('.autonumeric'))
    setTampilanForm()
    setRowNumbers()
  }

  function getPengembalianPinjaman(id) {
    $.ajax({
      url: `${apiUrl}penerimaantruckingheader/${id}/getpengembalianpinjaman`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $('#detailList tbody').html('')

        let totalSisa = 0
        $.each(response.data, (index, detail) => {
          let check = ""
          let disbaled = "disabled"
          // let awal = new Intl.NumberFormat('en-US').format(detail.sisa);
          if (detail.bayar !== null) {
            check = "checked"
            disbaled = ""
            detail.sisa = parseFloat(detail.sisa) + parseFloat(detail.bayar)
            console.log(detail.sisa)
          }
          let id = detail.id
          totalSisa = totalSisa + parseFloat(detail.sisa);
          let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);

          let detailRow = $(`
              <tr >
              <td>
                ${id}
              </td>
              <td>
                  <input name='pinjPribadi[]' type="checkbox" ${check} id="checkItem" value="${id}">
                  <input name='pinjPribadi_nobukti[]' type="hidden" value="${detail.nobukti}">
              </td>
              <td>${detail.nobukti}</td>
              <td>
                  <p class="text-right sisaPP autonumeric">${sisa}</p>
                  <input type="hidden" name="sisaPP[]" class="autonumeric" value="${sisa}">
                  <input type="hidden" name="sisaAwalPP[]" class="autonumeric" value="${sisa}">
              </td>
              <td id=${id}>
                  <input type="text" name="nominalPP[]" ${disbaled} value="${detail.bayar}" class="form-control bayar text-right">
              </td>
              <td>
                  ${detail.keterangan}
                  <input name='pinjPribadi_keterangan[]' type="hidden" value="${detail.keterangan}">
              </td>
              </tr>
          `)

          initAutoNumeric(detailRow.find(`[name="sisaPP[]"]`))
          initAutoNumeric(detailRow.find(`[name="sisaAwalPP[]"]`))
          initAutoNumeric(detailRow.find(`.sisaPP`))
          initAutoNumeric(detailRow.find(`.bayar`))
          setSisaDetail(detailRow.find(`[name="nominalPP[]"]`))
          $('#detailList tbody').append(detailRow)
          setTotalPP()
          setSisaPP()
        })
        setTampilanForm()
        $(`#detailList tfoot`).show()

      }

    })

  }

  function deleteRow(row) {
    let countRow = $('.delete-row').parents('tr').length
    row.remove()
    if (countRow <= 1) {
      addRow()
    }

    setRowNumbers()
    setTotal()
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}penerimaantruckingheader/field_length`,
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
    $('.supirheader-lookup').last().lookup({
      title: 'Supir Lookup',
      fileName: 'supir',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',

        }
      },
      onSelectRow: (supir, element) => {
        $(`#crudForm [name="supirheader_id"]`).last().val(supir.id)
        element.val(supir.namasupir)
        element.data('currentValue', element.val())

        $('#btnSubmit').prop('disabled', true)
        $('#btnSaveAdd').prop('disabled', true)
        $("#tablePinjaman")[0].p.selectedRowIds = [];
        $('#tablePinjaman').jqGrid("clearGridData");

        setTotalNominal()
        setTotalSisa()
        setTotalPinjaman()
        setTotalBayarPinjaman()
        getDataPinjaman(supir.id).then((response) => {

          setTimeout(() => {

            $("#tablePinjaman")
              .jqGrid("setGridParam", {
                datatype: "local",
                data: response.data,
                originalData: response.data,
                rowNum: response.data.length,
                selectedRowIds: []
              })
              .trigger("reloadGrid");
            $('#btnSubmit').prop('disabled', false)
            $('#btnSaveAdd').prop('disabled', false)
          }, 100);

        });
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#crudForm [name="supirheader_id"]`).last().val('')
        element.data('currentValue', element.val())
      }
    })
    $('.karyawanheader-lookup').last().lookup({
      title: 'karyawan Lookup',
      fileName: 'karyawan',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',

        }
      },
      onSelectRow: (karyawan, element) => {
        $(`#crudForm [name="karyawanheader_id"]`).last().val(karyawan.id)
        element.val(karyawan.namakaryawan)
        element.data('currentValue', element.val())
        $('#btnSubmit').prop('disabled', true)
        $('#btnSaveAdd').prop('disabled', true)
        $('#tablePinjamanKaryawan').jqGrid("clearGridData");
        $("#tablePinjamanKaryawan")
          .jqGrid("setGridParam", {
            selectedRowIds: []
          })
          .trigger("reloadGrid");

        setTotalNominalKaryawan()
        setTotalSisaKaryawan()
        getDataPinjamanKaryawan(karyawan.id).then((response) => {
          $("#tablePinjamanKaryawan")[0].p.selectedRowIds = [];
          setTimeout(() => {

            $("#tablePinjamanKaryawan")
              .jqGrid("setGridParam", {
                datatype: "local",
                data: response.data,
                originalData: response.data,
                rowNum: response.data.length,
                selectedRowIds: []
              })
              .trigger("reloadGrid");
            $('#btnSubmit').prop('disabled', false)
            $('#btnSaveAdd').prop('disabled', false)
          }, 100);

        });
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#crudForm [name="karyawanheader_id"]`).last().val('')
        element.data('currentValue', element.val())
      }
    })
    $('.jenisorder-lookup').last().lookup({
      title: 'jenis orderan Lookup',
      fileName: 'jenisorder',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',

        }
      },
      onSelectRow: (jenisorder, element) => {
        $(`#crudForm`).find(`[name="jenisorderan_id"]`).val(jenisorder.id)
        element.val(jenisorder.keterangan)
        element.data('currentValue', element.val())
        // $('#tablePinjamanKaryawan').jqGrid("clearGridData");
        // $("#tablePinjamanKaryawan")
        //   .jqGrid("setGridParam", {
        //     selectedRowIds: []
        //   })
        //   .trigger("reloadGrid");

        // getDataPinjamanKaryawan(karyawan.id).then((response) => {

        //   console.log('before', $("#tablePinjamanKaryawan").jqGrid('getGridParam', 'selectedRowIds'))
        //   setTimeout(() => {

        //     $("#tablePinjamanKaryawan")
        //       .jqGrid("setGridParam", {
        //         datatype: "local",
        //         data: response.data,
        //         originalData: response.data,
        //         rowNum: response.data.length,
        //         selectedRowIds: []
        //       })
        //       .trigger("reloadGrid");
        //   }, 100);

        // });
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#crudForm [name="jenisorderan_id"]`).last().val('')
        element.data('currentValue', element.val())
      }
    })
    $('.penerimaantrucking-lookup').lookup({
      title: 'Penerimaan Trucking Lookup',
      fileName: 'penerimaantrucking',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          roleInput: 'role',
          isLookup: true
        }
      },
      onSelectRow: (penerimaantrucking, element) => {
        setKodePenerimaan(penerimaantrucking.kodepenerimaan)
        $('#crudForm [name=penerimaantrucking_id]').first().val(penerimaantrucking.id)
        element.val(penerimaantrucking.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#crudForm [name="penerimaantrucking_id"]`).first().val('')
        element.data('currentValue', element.val())
      }
    })

    // $('.penerimaantrucking-lookup').lookupMaster({
    //   title: 'Penerimaan Trucking Lookup',
    //   fileName: 'penerimaantruckingMaster',
    //   typeSearch: 'ALL',
    //   searching: 1,
    //   beforeProcess: function(test) {
    //     this.postData = {
    //       Aktif: 'AKTIF',
    //       roleInput: 'role',
    //       isLookup: true,
    //       searching: 1,
    //       valueName: 'penerimaantrucking_id',
    //       searchText: 'penerimaantrucking-lookup',
    //       title: 'penerimaan trucking',
    //       typeSearch: 'ALL',
    //     }
    //   },
    //   onSelectRow: (penerimaantrucking, element) => {
    //     setKodePenerimaan(penerimaantrucking.kodepenerimaan)
    //     $('#crudForm [name=penerimaantrucking_id]').first().val(penerimaantrucking.id)
    //     element.val(penerimaantrucking.keterangan)
    //     element.data('currentValue', element.val())
    //   },
    //   onCancel: (element) => {
    //     element.val(element.data('currentValue'))
    //   },
    //   onClear: (element) => {
    //     element.val('')
    //     $(`#crudForm [name="penerimaantrucking_id"]`).first().val('')
    //     element.data('currentValue', element.val())
    //   }
    // })

    $('.bank-lookup').lookup({
      title: 'Bank Lookup',
      fileName: 'bank',
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
        element.val('')
        $(`#crudForm [name="bank_id"]`).first().val('')
        element.data('currentValue', element.val())
      }
    })

    $('.akunpusat-lookup').lookup({
      title: 'Kode Perk. Lookup',
      fileName: 'akunpusat',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',

        }
      },
      onSelectRow: (akunpusat, element) => {
        $('#crudForm [name=coa]').first().val(akunpusat.coa)
        element.val(akunpusat.keterangancoa)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=coa]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
  }

  function penerimaanTrucking(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}penerimaantrucking`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, data) => {
            listIdPenerimaan[index] = data.id;
            listKodePenerimaan[index] = data.kodepenerimaan;
            listKeteranganPenerimaan[index] = data.keterangan;
          })

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
        value: 'PENERIMAAN TRUCKING'
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