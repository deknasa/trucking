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
                  KODE PENGELUARAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="pengeluarantrucking_id">
                <input type="text" id="pengeluarantrucking" name="pengeluarantrucking" class="form-control pengeluarantrucking-lookup">
              </div>
            </div>


            <div class="row form-group">
              <div class="col-12 col-sm-2 col-md-2">
                <label class="col-form-label tgldari">
                  TGL DARI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <div class="input-group">
                  <input type="text" name="tgldari" class="form-control datepicker">
                </div>
              </div>

              <div class="col-12 col-sm-2 col-md-2">
                <label class="col-form-label tglsampai">
                  TGL SAMPAI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <div class="input-group">
                  <input type="text" name="tglsampai" class="form-control datepicker">
                </div>
              </div>
            </div>

            <div class="row form-group cabang">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  CABANG <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <select name="statuscabang" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH CABANG --</option>
                </select>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  customer <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="agen_id">
                <input type="text" name="agen" class="form-control agen-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  container <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="containerheader_id">
                <input type="text" name="containerheader" class="form-control containerheader-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  supir <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" id="supirheaderId" name="supirheader_id">
                <input type="text" name="supirheader" class="form-control supirheader-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  karyawan <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" id="karyawanheaderId" name="karyawanheader_id">
                <input type="text" name="karyawanheader" class="form-control karyawanheader-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  trado <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" id="tradoHaeaderId" name="tradoheader_id">
                <input type="text" name="trado" class="form-control tradoheader-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  gandengan <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" id="gandenganHaeaderId" name="gandenganheader_id">
                <input type="text" name="gandengan" class="form-control gandenganheader-lookup">
              </div>
            </div>


            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NAMA PERKIRAAN <span class="text-danger">*</span>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="coa">
                <input type="text" name="keterangancoa" class="form-control akunpusat-lookup">
              </div>
            </div>

            <div class="row form-group" style="display:none;">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  jenisorderan <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" id="jenisorderan" name="jenisorderan_id">
                <input type="text" name="jenisorderan" class="form-control jenisorderan-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-2 col-md-2">
                <label class="col-form-label">
                  periode <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <div class="input-group">
                  <input type="text" name="periode" class="form-control monthpicker">
                </div>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Status posting<span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <select name="statusposting" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS posting --</option>
                </select>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  posting Pinjaman<span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <select name="postingpinjaman" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH posting PInjaman --</option>
                </select>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  pengeluaran trucking no bukti<span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="pengeluarantrucking_nobukti" id="pengeluarantrucking_nobukti" class="form-control" readonly>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-6 m-1">
                <button id="btnReloadOtokGrid" class="btn btn-primary mr-2 ">
                  <i class="fas fa-sync-alt"></i>
                  Reload
                </button>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-6 m-1">
                <button id="btnReloadSumbanganGrid" class="btn btn-primary mr-2 ">
                  <i class="fas fa-sync-alt"></i>
                  Reload
                </button>
              </div>
            </div>

            <div class="border p-3 mb-3 posting-border">
              <h6>Posting Pengeluaran</h6>

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
                  <input type="text" name="pengeluaran_nobukti" id="pengeluaran_nobukti" class="form-control" readonly>
                </div>
              </div>
            </div>

            <div id="detail-tde-section">
              <table id="tableDeposito"></table>
            </div>

            <div id="detail-tdek-section">
              <table id="tableDepositoKaryawan"></table>
            </div>

            <div id="detail-bst-section">
              <table id="tableSumbangan"></table>
              <!-- <div id="modalgridPager"></div> -->
              <!-- <div id="detail-list-grid" style="display:none"></div> -->
            </div>

            <div id="detail-kbbm-section">
              <table id="tablePelunasanbbm"></table>
            </div>

            <div id="detail-bll-section">
              <table id="tableBLL"></table>
            </div>
            <div id="detail-bln-section">
              <table id="tableBLN"></table>
            </div>
            <div id="detail-btu-section">
              <table id="tableBTU"></table>
            </div>
            <div id="detail-btt-section">
              <table id="tableBTT"></table>
            </div>
            <div id="detail-bpt-section">
              <table id="tableBPT"></table>
            </div>
            <div id="detail-bgs-section">
              <table id="tableBGS"></table>
            </div>
            <div id="detail-bit-section">
              <table id="tableBIT"></table>
            </div>
            <div id="detail-bsm-section">
              <table id="tableBSM"></table>
            </div>
            <div id="detail-otok-section">
              <table id="tableOTOK"></table>
            </div>
            <div id="detail-otol-section">
              <table id="tableOTOL"></table>
            </div>

            <div class="row mt-5">
              <div class="col-md-12">
                <div class="card" style="max-height:500px; overflow-y: scroll;">
                  <div class="card-body">
                    <div id="detail-default-section" class="table-scroll table-responsive">
                      <table class="table table-bordered table-bindkeys mt-3" id="detailList">
                        <thead>
                          <tr>
                            <th style="width:5%; min-width: 25px">No</th>
                            <th class="data_tbl tbl_checkbox" style="display:none" width="1%">Pilih</th>
                            <th style="width: 20%; min-width: 200px;" class="data_tbl tbl_karyawan_id">Karyawan</th>
                            <th style="width: 20%; min-width: 200px;" class="data_tbl tbl_supir_id">SUPIR</th>
                            <th style="width: 20%; min-width: 200px;" class="data_tbl tbl_statustitipanemkl kolom_bbt">Titipan EMKL</th>
                            <th style="width: 20%; min-width: 200px;" class="data_tbl tbl_suratpengantar_nobukti kolom_bbt">no bukti Sp</th>
                            <th style="width: 20%; min-width: 200px;" class="data_tbl tbl_trado_id kolom_bbt">trado</th>
                            <th style="width: 20%; min-width: 200px;" class="data_tbl tbl_container_id kolom_bbt">container</th>
                            <th style="width: 20%; min-width: 200px;" class="data_tbl tbl_pelanggan_id kolom_bbt">shipper</th>
                            <th style="width: 20%; min-width: 200px;" class="data_tbl tbl_pengeluaranstokheader_nobukti">no bukti pengeluaran stok</th>
                            <th style="width: 20%; min-width: 200px;" class="data_tbl tbl_penerimaanstokheader_nobukti tbl_tagihklaim">no bukti penerimaan stok</th>
                            <th style="width: 20%; min-width: 200px;" class="data_tbl tbl_stok_id">stok</th>
                            <th class="data_tbl tbl_penerimaantruckingheader" style="width: 20%; min-width: 200px;">NO BUKTI PENERIMAAN TRUCKING</th>
                            <th style="width:10%; min-width: 100px" class="data_tbl tbl_qty">qty</th>
                            <th style="width: 20%; min-width: 200px;" class="tbl_sisa">Sisa</th>
                            <th style="width: 20%; min-width: 200px;" class="data_tbl tbl_harga">harga spk/pg</th>
                            <th style="width: 20%; min-width: 200px;" class="data_tbl tbl_nominal">Nominal</th>
                            <th style="width: 20%; min-width: 200px;" class="data_tbl tbl_nominaltagih kolom_bbt">tagihan</th>
                            <th class="data_tbl tbl_keterangan" style="width: 20%; min-width: 200px;">Keterangan</th>
                            <th style="width: 20%; min-width: 200px;" class="data_tbl tbl_tagihklaim">Nominal Tambahan</th>
                            <th style="width: 20%; min-width: 200px;" class="data_tbl tbl_tagihklaim">Keterangan Tambahan</th>
                            <th style="width: 20%; min-width: 200px;" class="data_tbl tbl_jenisorder kolom_bbt">jenis orderan</th>
                            <th style="width: 20%; min-width: 200px;" class="data_tbl tbl_tagihklaim">total nominal</th>
                            <th style="width:5%; max-width: 25px;max-width: 15px" class="tbl_aksi">Aksi</th>
                          </tr>
                        </thead>
                        <tbody id="table_body" class="form-group">

                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="3" class="colspan">
                              <p class="text-right font-weight-bold">TOTAL :</p>
                            </td>
                            <td id="tagihanColFoot" style="display: none" class="kolom_bbt">
                              <p class="text-right font-weight-bold autonumeric" id="tagihanFoot"></p>
                            </td>
                            <td id="sisaColFoot" style="display: none">
                              <p class="text-right font-weight-bold autonumeric" id="sisaFoot"></p>
                            </td>
                            <td>
                              <p class="text-right font-weight-bold autonumeric" id="total"></p>
                            </td>
                            <td class="colmn-offset"></td>
                            <td class="colmn-offset2" style="display: none"></td>
                            <td class="colmn-offset3" style="display: none">
                              <p class="text-right font-weight-bold autonumeric" id="totalTambahan"></p>
                            </td>
                            <td class="colmn-offset4" style="display: none" colspan="2">
                              <p class="text-right font-weight-bold autonumeric" id="totalKlaim"></p>
                            </td>
                            <td id="tbl_addRow" class="tbl_aksi">
                              <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">Tambah</button>
                            </td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
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
  var KodePengeluaranId
  let selectedRows = [];
  var parameterPosting;
  let sortnameSumbangan = 'noinvoice_detail';
  let sortorderSumbangan = 'asc';
  let pageSumbangan = 0;
  let totalRecordSumbangan
  let limitSumbangan
  let postDataSumbangan
  let triggerClickSumbangan
  let indexRowSumbangan
  let selectedRowsSumbangan = [];
  let selectedRowsSumbanganNobukti = [];
  let selectedRowsSumbanganContainer = [];
  let selectedRowsSumbanganJobtrucking = [];
  let selectedRowsSumbanganKeterangan = [];
  let selectedRowsSumbanganNominal = [];
  var listIdPengeluaran = []
  var listKodePengeluaran = []
  var listKeteranganPengeluaran = []
  let isEditTgl
  let statuscabang = ''
  let urlTNL = ''
  let tokenTNL = ''
  let classHidden = [];

  let sortnameOtok = 'noinvoice_detail';
  let sortorderOtok = 'asc';
  let pageOtok = 0;
  let totalRecordOtok
  let limitOtok
  let postDataOtok
  let triggerClickOtok
  let indexRowOtok
  let selectedRowsOtok = [];
  let selectedRowsOtokNobukti = [];
  let selectedRowsOtokJobtrucking = [];
  let selectedRowsOtokKeterangan = [];
  let selectedRowsOtokNominal = [];

  let sortnameOtol = 'noinvoice_detail';
  let sortorderOtol = 'asc';
  let pageOtol = 0;
  let totalRecordOtol
  let limitOtol
  let postDataOtol
  let triggerClickOtol
  let indexRowOtol
  let selectedRowsOtol = [];
  let selectedRowsOtolNobukti = [];
  let selectedRowsOtolJobtrucking = [];
  let selectedRowsOtolKeterangan = [];
  let selectedRowsOtolNominal = [];

  $(document).ready(function() {

    $("#crudForm [name]").attr("autocomplete", "off");

    $(document).on('click', "#addRow", function(event) {
      event.preventDefault()
      let method = `POST`
      let url = `${apiUrl}pengeluarantruckingheader/addrow`
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      if (KodePengeluaranId != "BST") {
        if (KodePengeluaranId == "BBT") {
          $('#crudForm').find(`[name="nominaltagih[]"`).each((index, element) => {
            if (element.value != "" && AutoNumeric.getAutoNumericElement(element) !== null) {
              data.filter((row) => row.name === 'nominaltagih[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominaltagih[]"]`)[index])
            }
          })
        }

        if (KodePengeluaranId == "KLAIM") {
          $('#crudForm').find(`[name="nominaltambahan[]"`).each((index, element) => {
            data.filter((row) => row.name === 'nominaltambahan[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominaltambahan[]"]`)[index])

          })
        }
        $('#crudForm').find(`[name="nominal[]"`).each((index, element) => {
          if (element.value != "" && AutoNumeric.getAutoNumericElement(element) !== null) {
            data.filter((row) => row.name === 'nominal[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[index])
          }
        })
        $('#crudForm').find(`[name="harga[]"`).each((index, element) => {
          // console.log(AutoNumeric.getAutoNumericElement(element));
          if (element.value != "" && AutoNumeric.getAutoNumericElement(element) !== null) {
            data.filter((row) => row.name === 'harga[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="harga[]"]`)[index])
          }
        })
        $('#crudForm').find(`[name="qty[]"`).each((index, element) => {
          if (element.value != "" && AutoNumeric.getAutoNumericElement(element) !== null) {
            data.filter((row) => row.name === 'qty[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="qty[]"]`)[index])
          }
        })
      }

      $.ajax({
          url: url,
          method: method,
          dataType: 'JSON',
          headers: {
            Authorization: `Bearer ${accessToken}`
          },
          data: data,
          success: response => {

            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
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

    $(document).on('click', '.delete-row', function(event) {
      event.preventDefault()
      deleteRow($(this).parents('tr'))
    })

    $(document).on('input', `#table_body [name="nominal[]"]`, function(event) {
      setTotal()
      if (KodePengeluaranId == 'BBT') {
        $(this).parents("tr").find(`[name="nominaltagih[]"]`).val($(this).val())

        initAutoNumeric($(this).parents("tr").find(`[name="nominaltagih[]"]`))
      }
      if (KodePengeluaranId == 'KLAIM') {
        nominaltambahan = AutoNumeric.getNumber($(this).parents("tr").find(`[name="nominaltambahan[]"]`)[0])
        nominaltagihan = AutoNumeric.getNumber($(this)[0])
        totalklaim = nominaltagihan + nominaltambahan
        new AutoNumeric($(this).parents("tr").find(`[name="totalklaim[]"]`)[0]).set(totalklaim)
        setTotalKlaim()
        setTotalTambahan()
        // initAutoNumeric($(this).parents("tr").find(`[name="nominaltagih[]"]`))
      }
    })


    $(document).on('input', `#table_body [name="nominaltambahan[]"]`, function(event) {
      setTotal()

      nominaltagihan = AutoNumeric.getNumber($(this).parents("tr").find(`[name="nominal[]"]`)[0])
      nominaltambahan = AutoNumeric.getNumber($(this)[0])
      totalklaim = nominaltagihan + nominaltambahan
      new AutoNumeric($(this).parents("tr").find(`[name="totalklaim[]"]`)[0]).set(totalklaim)
      setTotalKlaim()
      setTotalTambahan()
    })

    $(document).on('input', `#table_body [name="qty[]"]`, function(event) {

      harga = AutoNumeric.getNumber($(this).parents("tr").find(`[name="harga[]"]`)[0])
      console.log(harga)
      qty = AutoNumeric.getNumber($(this)[0]) ?? 0;
      totalharga = qty * harga
      new AutoNumeric($(this).parents("tr").find(`[name="totalharga[]"]`)[0]).set(totalharga)
    })


    $(document).on('change', `[name="statuscabang"]`, function(event) {
      statuscabang = $(`[name="statuscabang"] option:selected`).text()
      if (statuscabang == 'TNL') {
        urlTNL = apiTruckingTnlUrl
        tokenTNL = accessTokenTnl
      } else {
        urlTNL = apiUrl
        tokenTNL = accessToken

      }
    })

    function rangeInvoice() {
      var tgldari = $('#crudForm').find(`[name="tgldari"]`).val()
      var tglsampai = $('#crudForm').find(`[name="tglsampai"]`).val()
      // console.log('rangeInvoice')
      if (tgldari !== "" && tglsampai !== "") {
        if (KodePengeluaranId == 'BST') {

          // clearSelectedRowsSumbangan()
          // getDataSumbangan()
          //   .then((response) => {
          //     $('.is-invalid').removeClass('is-invalid')
          //     $('.invalid-feedback').remove()

          //     // $('#tableSumbangan').jqGrid("clearGridData");
          //     $('#tableSumbangan').jqGrid('setGridParam', {
          //       url: `${apiUrl}pengeluarantruckingheader/${response.url}`,
          //       postData: {
          //         tgldari: $('#crudForm').find('[name=tgldari]').val(),
          //         tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
          //         aksi: $('#crudForm').data('action')
          //       },
          //       datatype: "json"
          //     }).trigger('reloadGrid');
          //   })
          //   .catch((errors) => {
          //     setErrorMessages($('#crudForm'), errors)
          //   })

        } else if (KodePengeluaranId == 'KBBM') {
          $('#tablePelunasanbbm').jqGrid("clearGridData");
          // $("#tablePelunasanbbm")
          //   .jqGrid("setGridParam", {
          //     selectedRowIds: []
          //   })
          //   .trigger("reloadGrid");

          getDataPelunasanBBM(tgldari, tglsampai).then((response) => {

            $("#tablePelunasanbbm")[0].p.selectedRowIds = [];
            let selectedId = []
            let totalBayar = 0
            if ($('#crudForm').data('action') == 'edit') {

              $.each(response.data, (index, value) => {
                if (value.pengeluarantruckingheader_id != null) {
                  selectedId.push(value.id)
                  totalBayar += parseFloat(value.nominal)
                }
              })
            }
            setTimeout(() => {

              $("#tablePelunasanbbm")
                .jqGrid("setGridParam", {
                  datatype: "local",
                  data: response.data,
                  originalData: response.data,
                  rowNum: response.data.length,
                  selectedRowIds: selectedId
                })
                .trigger("reloadGrid");
            }, 100);
            initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasanbbm_nominal"]`).text(totalBayar))

          });
        }
      }
    }

    $(document).on("change", `[name=tgldari], [name=tglsampai]`, function(event) {
      rangeInvoice();
    })


    $(document).on('change', `[name=statusposting]`, function(event) {
      let statusposting_id = $('#crudForm').find('[name=statusposting]').val()
      if (parameterPosting == statusposting_id) {
        enabledKas(true);
      } else {
        enabledKas(false);
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
      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data
      if (KodePengeluaranId == "TDE") {
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
          name: 'pengeluarantrucking_id',
          value: form.find(`[name="pengeluarantrucking_id"]`).val()
        })
        data.push({
          name: 'pengeluarantrucking',
          value: form.find(`[name="pengeluarantrucking"]`).val()
        })
        data.push({
          name: 'supirheader_id',
          value: form.find(`[name="supirheader_id"]`).val()
        })
        data.push({
          name: 'supirheader',
          value: form.find(`[name="supirheader"]`).val()
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
          name: 'statusposting',
          value: form.find(`[name="statusposting"]`).val()
        })
        data.push({
          name: 'postingpinjaman',
          value: form.find(`[name="postingpinjaman"]`).val()
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
          name: 'pengeluaran_nobukti',
          value: form.find(`[name="pengeluaran_nobukti"]`).val()
        })
        let selectedRowsDeposito = $("#tableDeposito").getGridParam("selectedRowIds");
        data.push({
          name: 'jumlahdetail',
          value: selectedRowsDeposito
        })
        $.each(selectedRowsDeposito, function(index, value) {
          dataDeposito = $("#tableDeposito").jqGrid("getLocalRow", value);
          let selectedSisa = dataDeposito.sisa
          let selectedNominal = (dataDeposito.nominal == undefined) ? 0 : dataDeposito.nominal;
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
            value: dataDeposito.keterangan
          })
          data.push({
            name: 'penerimaantruckingheader_nobukti[]',
            value: dataDeposito.nobukti
          })
          data.push({
            name: 'supir_id[]',
            value: form.find(`[name="supirheader_id"]`).val()
          })
          data.push({
            name: 'tde_id[]',
            value: dataDeposito.id
          })
        });
      } else if (KodePengeluaranId == "TDEK") {
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
          name: 'pengeluarantrucking_id',
          value: form.find(`[name="pengeluarantrucking_id"]`).val()
        })
        data.push({
          name: 'pengeluarantrucking',
          value: form.find(`[name="pengeluarantrucking"]`).val()
        })
        data.push({
          name: 'karyawanheader_id',
          value: form.find(`[name="karyawanheader_id"]`).val()
        })
        data.push({
          name: 'karyawanheader',
          value: form.find(`[name="karyawanheader"]`).val()
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
          name: 'statusposting',
          value: form.find(`[name="statusposting"]`).val()
        })
        data.push({
          name: 'postingpinjaman',
          value: form.find(`[name="postingpinjaman"]`).val()
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
          name: 'pengeluaran_nobukti',
          value: form.find(`[name="pengeluaran_nobukti"]`).val()
        })
        let selectedRowsDepositoKaryawan = $("#tableDepositoKaryawan").getGridParam("selectedRowIds");
        data.push({
          name: 'jumlahdetail',
          value: selectedRowsDepositoKaryawan.length
        })
        $.each(selectedRowsDepositoKaryawan, function(index, value) {
          dataDepositoKaryawan = $("#tableDepositoKaryawan").jqGrid("getLocalRow", value);
          let selectedSisaDepoKaryawan = dataDepositoKaryawan.sisa
          let selectedNominalDepoKaryawan = (dataDepositoKaryawan.nominal == undefined || dataDepositoKaryawan.nominal == '') ? 0 : dataDepositoKaryawan.nominal;

          data.push({
            name: 'nominal[]',
            value: (isNaN(selectedNominalDepoKaryawan)) ? parseFloat(selectedNominalDepoKaryawan.replaceAll(',', '')) : selectedNominalDepoKaryawan
          })
          data.push({
            name: 'sisa[]',
            value: selectedSisaDepoKaryawan
          })
          data.push({
            name: 'keterangan[]',
            value: dataDepositoKaryawan.keterangan
          })
          data.push({
            name: 'penerimaantruckingheader_nobukti[]',
            value: dataDepositoKaryawan.nobukti
          })
          data.push({
            name: 'karyawan_id[]',
            value: form.find(`[name="karyawanheader_id"]`).val()
          })
          data.push({
            name: 'tdek_id[]',
            value: dataDepositoKaryawan.id
          })
        });
      } else if (KodePengeluaranId == "KBBM") {
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
          name: 'pengeluarantrucking_id',
          value: form.find(`[name="pengeluarantrucking_id"]`).val()
        })
        data.push({
          name: 'pengeluarantrucking',
          value: form.find(`[name="pengeluarantrucking"]`).val()
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
          name: 'statusposting',
          value: form.find(`[name="statusposting"]`).val()
        })
        data.push({
          name: 'postingpinjaman',
          value: form.find(`[name="postingpinjaman"]`).val()
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
          name: 'pengeluaran_nobukti',
          value: form.find(`[name="pengeluaran_nobukti"]`).val()
        })
        let selectedRowsPelunasan = $("#tablePelunasanbbm").getGridParam("selectedRowIds");
        $.each(selectedRowsPelunasan, function(index, value) {
          dataPelunasanBBM = $("#tablePelunasanbbm").jqGrid("getLocalRow", value);
          let selectedSisa = dataPelunasanBBM.sisa
          let selectedNominal = (dataPelunasanBBM.nominal == undefined) ? 0 : dataPelunasanBBM.nominal;
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
            value: dataPelunasanBBM.keterangan
          })
          data.push({
            name: 'penerimaantruckingheader_nobukti[]',
            value: dataPelunasanBBM.nobukti
          })
          data.push({
            name: 'kbbm_id[]',
            value: dataPelunasanBBM.id
          })
        })
      } else if (KodePengeluaranId == "BLL" || KodePengeluaranId == "BLN" || KodePengeluaranId == "BTU" || KodePengeluaranId == "BTT" || KodePengeluaranId == "BPT" || KodePengeluaranId == "BGS" || KodePengeluaranId == "BIT" || KodePengeluaranId == "BSM" || KodePengeluaranId == "BLS" || KodePengeluaranId == "BTK" || KodePengeluaranId == "BTB") {
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
          name: 'pengeluarantrucking_id',
          value: form.find(`[name="pengeluarantrucking_id"]`).val()
        })
        data.push({
          name: 'pengeluarantrucking',
          value: form.find(`[name="pengeluarantrucking"]`).val()
        })
        data.push({
          name: 'statusposting',
          value: form.find(`[name="statusposting"]`).val()
        })
        data.push({
          name: 'bank_id',
          value: form.find(`[name="bank_id"]`).val()
        })
        data.push({
          name: 'bank',
          value: form.find(`[name="bank"]`).val()
        })
        let selectedRowsBLL
        if (KodePengeluaranId == "BSM" || KodePengeluaranId == "BLS" || KodePengeluaranId == "BTK" || KodePengeluaranId == "BTB") {

          data.push({
            name: 'tgldari',
            value: form.find(`[name="tgldari"]`).val()
          })
          data.push({
            name: 'tglsampai',
            value: form.find(`[name="tglsampai"]`).val()
          })
          selectedRowsBLL = $(`#tableBSM`).getGridParam("selectedRowIds");

        } else {
          selectedRowsBLL = $(`#table${KodePengeluaranId}`).getGridParam("selectedRowIds");

          data.push({
            name: 'periode',
            value: form.find(`[name="periode"]`).val()
          })
        }
        let jumlahdetail = 0;
        $.each(selectedRowsBLL, function(index, value) {
          if (KodePengeluaranId == "BSM" || KodePengeluaranId == "BLS" || KodePengeluaranId == "BTK" || KodePengeluaranId == "BTB") {
            dataBLL = $(`#tableBSM`).jqGrid("getLocalRow", value);

          } else {
            dataBLL = $(`#table${KodePengeluaranId}`).jqGrid("getLocalRow", value);

          }

          let selectedNominal = (dataBLL.nominal == undefined) ? 0 : dataBLL.nominal;
          if (selectedNominal != 0) {
            jumlahdetail++
            data.push({
              name: 'nominal[]',
              value: (isNaN(selectedNominal)) ? parseFloat(selectedNominal.replaceAll(',', '')) : selectedNominal
            })
            data.push({
              name: 'keterangan[]',
              value: dataBLL.keteranganbll
            })
            data.push({
              name: 'supir_id[]',
              value: dataBLL.supir_id
            })
          }
        })

        data.push({
          name: 'jumlahdetail',
          value: jumlahdetail
        })
      } else if (KodePengeluaranId == "BST") {
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
          name: 'pengeluarantrucking_id',
          value: form.find(`[name="pengeluarantrucking_id"]`).val()
        })
        data.push({
          name: 'pengeluarantrucking',
          value: form.find(`[name="pengeluarantrucking"]`).val()
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
          name: 'statusposting',
          value: form.find(`[name="statusposting"]`).val()
        })
        data.push({
          name: 'bank_id',
          value: form.find(`[name="bank_id"]`).val()
        })
        data.push({
          name: 'bank',
          value: form.find(`[name="bank"]`).val()
        })
        let bst_nominal = []
        let bst_container_detail = []
        let bst_noinvoice_detail = []
        let bst_nojobtrucking_detail = []
        let bst_keterangan = []

        $.each(selectedRowsSumbanganNominal, function(index, item) {
          bst_nominal.push(parseFloat(item.replaceAll(',', '')))
          bst_keterangan.push('SUMBANGAN SOSIAL')
        });

        let requestData = {
          'id_detail': selectedRowsSumbangan,
          'nominal': bst_nominal,
          'container_detail': selectedRowsSumbanganContainer,
          'noinvoice_detail': selectedRowsSumbanganNobukti,
          'nojobtrucking_detail': selectedRowsSumbanganJobtrucking,
          'keterangan': bst_keterangan,
        };
        data.push({
          name: 'detail',
          value: JSON.stringify(requestData)
        })
      } else if (KodePengeluaranId == "OTOK" || KodePengeluaranId == "OTOL") {
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
          name: 'pengeluarantrucking_id',
          value: form.find(`[name="pengeluarantrucking_id"]`).val()
        })
        data.push({
          name: 'pengeluarantrucking',
          value: form.find(`[name="pengeluarantrucking"]`).val()
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
          name: 'statusposting',
          value: form.find(`[name="statusposting"]`).val()
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
          name: 'agen_id',
          value: form.find(`[name="agen_id"]`).val()
        })
        data.push({
          name: 'agen',
          value: form.find(`[name="agen"]`).val()
        })
        data.push({
          name: 'containerheader_id',
          value: form.find(`[name="containerheader_id"]`).val()
        })
        data.push({
          name: 'containerheader',
          value: form.find(`[name="containerheader"]`).val()
        })
        let oto_nominal = []
        let oto_keterangan = []
        let requestData = {}


        if (KodePengeluaranId == "OTOK") {
          $.each(selectedRowsOtokNominal, function(index, item) {
            oto_nominal.push(parseFloat(item.replaceAll(',', '')))
            oto_keterangan.push('OTOBON KANTOR')
          });
          console.log('tok')
          requestData = {
            'id_detail': selectedRowsOtok,
            'nominal': oto_nominal,
            'noinvoice_detail': selectedRowsOtokNobukti,
            'nojobtrucking_detail': selectedRowsOtokJobtrucking,
            'keterangan': oto_keterangan,
          };

          data.push({
            name: 'jumlahdetail',
            value: selectedRowsOtokNominal.length
          })
        } else {
          $.each(selectedRowsOtolNominal, function(index, item) {
            oto_nominal.push(parseFloat(item.replaceAll(',', '')))
            oto_keterangan.push('OTOBON LAPANGAN')
          });

          requestData = {
            'id_detail': selectedRowsOtol,
            'nominal': oto_nominal,
            'noinvoice_detail': selectedRowsOtolNobukti,
            'nojobtrucking_detail': selectedRowsOtolJobtrucking,
            'keterangan': oto_keterangan,
          };
          data.push({
            name: 'jumlahdetail',
            value: selectedRowsOtolNominal.length
          })
        }
        console.log(requestData)
        data.push({
          name: 'detail',
          value: JSON.stringify(requestData)
        })
      } else {
        data = $('#crudForm').serializeArray()

        if (KodePengeluaranId != "BST") {
          if (KodePengeluaranId == "BBT") {
            $('#crudForm').find(`[name="nominaltagih[]"`).each((index, element) => {
              if (element.value != "" && AutoNumeric.getAutoNumericElement(element) !== null) {
                data.filter((row) => row.name === 'nominaltagih[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominaltagih[]"]`)[index])
              }
            })
          }
          if (KodePengeluaranId == "KLAIM") {
            $('#crudForm').find(`[name="nominaltambahan[]"`).each((index, element) => {
              data.filter((row) => row.name === 'nominaltambahan[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominaltambahan[]"]`)[index])
            })
          }
          $('#crudForm').find(`[name="nominal[]"`).each((index, element) => {
            if (element.value != "" && AutoNumeric.getAutoNumericElement(element) !== null) {
              data.filter((row) => row.name === 'nominal[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[index])
            }
          })
          $('#crudForm').find(`[name="harga[]"`).each((index, element) => {
            // console.log(AutoNumeric.getAutoNumericElement(element));
            if (element.value != "" && AutoNumeric.getAutoNumericElement(element) !== null) {
              data.filter((row) => row.name === 'harga[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="harga[]"]`)[index])
            }
          })
          $('#crudForm').find(`[name="qty[]"`).each((index, element) => {
            if (element.value != "" && AutoNumeric.getAutoNumericElement(element) !== null) {
              data.filter((row) => row.name === 'qty[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="qty[]"]`)[index])
            }
          })
        }


        //   $('#crudForm').find(`[name="detail_qty[]"]`).each((index, element) => {
        //   data.filter((row) => row.name === 'detail_qty[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_qty[]"]`)[index])
        // })
        // $('#crudForm').find(`[name="detail_harga[]"]`).each((index, element) => {
        //   data.filter((row) => row.name === 'detail_harga[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_harga[]"]`)[index])
        // })

      }

      data.push({
        name: 'button',
        value: button
      })
      data.push({
        name: 'sortIndex',
        value: $('#jqGrid').getGridParam().sortname
      })
      data.push({
        name: 'info',
        value: info
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
      data.push({
        name: 'pengeluaranheader_id',
        value: data.find(item => item.name === "pengeluarantrucking_id").value
      })

      // console.log(data);
      // debugger;

      let kodepengeluaranheader = data.find(item => item.name === "pengeluarantrucking_id").value;

      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}pengeluarantruckingheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}pengeluarantruckingheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}pengeluarantruckingheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&pengeluaranheader_id=${kodepengeluaranheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}pengeluarantruckingheader`
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

            $('#pengeluaranheader_id').val(response.data.pengeluarantrucking_id).trigger('change')
            $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
            $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');
            $('#jqGrid').jqGrid('setGridParam', {
              page: response.data.page,
              postData: {
                proses: 'reload',
                tgldari: dateFormat(response.data.tgldariheader),
                tglsampai: dateFormat(response.data.tglsampaiheader),
                penerimaanheader_id: response.data.penerimaantrucking_id,
                pengeluaranheader_id: response.data.pengeluarantrucking_id
              }
            }).trigger('reloadGrid');

            if (id == 0) {
              $('#detail').jqGrid().trigger('reloadGrid')
            }
          } else {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            let pengeluaranTruckingVal = $('#crudForm').find('[name="pengeluarantrucking"]').val();
            let tgldariVal = $('#crudForm').find('[name="tgldari"]').val();
            let tglsampaiVal = $('#crudForm').find('[name="tglsampai"]').val();
            let pengeluaranTruckingIdVal = $('#crudForm').find('[name="pengeluarantrucking_id"]').val();
            // showSuccessDialog(response.message, response.data.nobukti)
            createPengeluaranTruckingHeader()
            $('#crudForm').find('input[type="text"]').not('[name="pengeluarantrucking"]').data('current-value', '')
            $('#crudForm').find('[name="pengeluarantrucking"]').val(pengeluaranTruckingVal)
            $('#crudForm').find('[name="pengeluarantrucking_id"]').val(pengeluaranTruckingIdVal)
            $('#crudForm').find('[name="tgldari"]').val(tgldariVal)
            $('#crudForm').find('[name="tglsampai"]').val(tglsampaiVal)
            $('#crudForm').find('[name=tglbukti]').focus()
            setTampilanForm()

            if (KodePengeluaranId == 'KBBM') {
              $("#tablePelunasanbbm")[0].p.selectedRowIds = [];
              $('#tablePelunasanbbm').jqGrid("clearGridData");
              $("#tablePelunasanbbm")
                .jqGrid("setGridParam", {
                  selectedRowIds: []
                })
                .trigger("reloadGrid");
            }
            if (KodePengeluaranId == 'TDE') {
              $("#tableDeposito")[0].p.selectedRowIds = [];
              $('#tableDeposito').jqGrid("clearGridData");
              $("#tableDeposito")
                .jqGrid("setGridParam", {
                  selectedRowIds: []
                })
                .trigger("reloadGrid");

            }
            if (KodePengeluaranId == 'TDEK') {
              $("#tableDepositoKaryawan")[0].p.selectedRowIds = [];
              $('#tableDepositoKaryawan').jqGrid("clearGridData");
              $("#tableDepositoKaryawan")
                .jqGrid("setGridParam", {
                  selectedRowIds: []
                })
                .trigger("reloadGrid");
            }
          }

          selectedRows = []
          clearSelectedRowsSumbangan()
          clearSelectedRowsOTOK()
          clearSelectedRowsOTOL()

          if (response.data.grp == 'FORMAT') {
            updateFormat(response.data)
          }
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            if (KodePengeluaranId == "TDE" || KodePengeluaranId == "TDEK" || KodePengeluaranId == "BST" || KodePengeluaranId == "KBBM") {
              console.log(error)
              errors = error.responseJSON.errors
              $(".ui-state-error").removeClass("ui-state-error");
              $.each(errors, (index, error) => {
                let indexes = index.split(".");
                let angka = indexes[1]
                row = parseInt(selectedRows[angka]) - 1;

                if (KodePengeluaranId == 'TDE') {
                  tableError = 'tableDeposito'
                  selectedRowsError = $("#tableDeposito").getGridParam("selectedRowIds");
                } else if (KodePengeluaranId == 'TDEK') {
                  tableError = 'tableDepositoKaryawan'
                  selectedRowsError = $("#tableDepositoKaryawan").getGridParam("selectedRowIds");
                } else if (KodePengeluaranId == 'BST') {
                  tableError = 'tableSumbangan'

                } else if (KodePengeluaranId == 'KBBM') {
                  tableError = 'tablePelunasanbbm'
                  selectedRowsError = $("#tablePelunasanbbm").getGridParam("selectedRowIds");
                }

                let element;
                if (indexes[0] == 'bank' || indexes[0] == 'pengeluarantrucking' || indexes[0] == 'statusposting' || indexes[0] == 'supirheader' || indexes[0] == 'karyawanheader' || indexes[0] == 'tde_id' || indexes[0] == 'kbbm_id' || indexes[0] == 'id_detail') {
                  element = form.find(`[name="${indexes[0]}"]`)[0];

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
                  if (KodePengeluaranId == "TDE" || KodePengeluaranId == "TDEK" || KodePengeluaranId == "KBBM") {
                    element = $(`#${tableError} tr#${parseInt(selectedRowsError[angka])}`).find(`td[aria-describedby="${tableError}_${indexes[0]}"]`)
                    $(element).addClass("ui-state-error");
                    $(element).attr("title", error[0].toLowerCase())
                  }
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

    if (KodePengeluaranId == 'TDE' && $('#crudForm [name=supirheader_id]').val() != '') {
      $("#tableDeposito")[0].p.selectedRowIds = [];
      $('#tableDeposito').jqGrid("clearGridData");
      $("#tableDeposito")
        .jqGrid("setGridParam", {
          selectedRowIds: []
        })
        .trigger("reloadGrid");

      getDataDeposito($('#crudForm [name=supirheader_id]').val()).then((response) => {

        setTimeout(() => {

          $("#tableDeposito")
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
    }

    if (KodePengeluaranId == 'TDEK' && $('#crudForm [name=karyawanheader_id]').val() != '') {

      $("#tableDepositoKaryawan")[0].p.selectedRowIds = [];
      $('#tableDepositoKaryawan').jqGrid("clearGridData");
      $("#tableDepositoKaryawan")
        .jqGrid("setGridParam", {
          selectedRowIds: []
        })
        .trigger("reloadGrid");

      getDataDepositoKaryawan($('#crudForm [name=karyawanheader_id]').val()).then((response) => {

        setTimeout(() => {

          $("#tableDepositoKaryawan")
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
    }
  })

  function setKodePengeluaran(kode) {
    console.log('kodepengeluaranid', kode)
    KodePengeluaranId = kode;
    // tampilanall()
    $('#detailList tbody').html('')
    $('#detail-list-grid').html('')
    addRow()
    setTampilanForm();
    // console.log(listKodePengeluaran[0], KodePengeluaranId);
  }

  function setTampilanForm() {
    tampilanall()
    switch (KodePengeluaranId) {
      case 'PJT': //listKodePengeluaran[0]:
        tampilanPJT()
        break;
      case 'TDE': //listKodePengeluaran[1]:
        tampilanTDE()
        break;
      case 'BST': //listKodePengeluaran[2]:
        tampilanBST()
        break;
      case 'BSB': //listKodePengeluaran[3]: 
        tampilanBSB()
        break;
      case 'KBBM': //listKodePengeluaran[4]: 
        tampilanKBBM()
        break;
      case 'KLAIM': //listKodePengeluaran[6]: 
        tampilanKLAIM()
        break;
      case 'PJK': //listKodePengeluaran[7]: 
        tampilanPJK()
        break;
      case 'BBT': //listKodePengeluaran[8]: 
        tampilanBBT()
        break;
      case 'BLL': //listKodePengeluaran[9]: 
        tampilanBLL()
        break;
      case 'BLN': //listKodePengeluaran[10]:
        tampilanBLN()
        break;
      case 'BTU': //listKodePengeluaran[11]:
        tampilanBTU()
        break;
      case 'BTT': //listKodePengeluaran[11]:
        tampilanBTT()
        break;
      case 'BPT': //listKodePengeluaran[12]:
        tampilanBPT()
        break;
      case 'BGS': //listKodePengeluaran[13]:
        tampilanBGS()
        break;
      case 'BIT': //listKodePengeluaran[14]:
        tampilanBIT()
        break;
      case 'TDEK': //listKodePengeluaran[15]:
        tampilanTDEK()
        break;
      case 'OTOK': //listKodePengeluaran[16]:
        tampilanOTOK()
        break;
      case 'OTOL': //listKodePengeluaran[17]:
        tampilanOTOL()
        break;
      case 'BSM': //listKodePengeluaran[17]:
        tampilanBSM()
        break;
      case 'BLS': //listKodePengeluaran[17]:
        tampilanBSM()
        break;
      case 'BTK': //listKodePengeluaran[17]:
        tampilanBSM()
        break;
      case 'BTB': //listKodePengeluaran[17]:
        tampilanBSM()
        break;
      default:
        tampilanall()
        break;
    }
  }

  function tampilanPJT() {
    $('.kolom_bbt').hide()
    $('#btnReloadOtokGrid').hide()
    $('#btnReloadSumbanganGrid').hide()
    $('[name=statusposting]').parents('.form-group').show()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').hide()
    $('[name=containerheader_id]').parents('.form-group').hide()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('[name=periode]').parents('.form-group').hide()
    $('[name=periode]').prop('disabled', true)
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('#detail-bst-section').hide()
    $('#detail-bll-section').hide()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').hide()
    $('#detail-btt-section').hide()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').hide()
    $('#detail-tde-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-bsm-section').hide()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').hide()
    $('#detail-default-section').parents('.card').show()
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_stok_id').hide()
    $('.tbl_qty').hide()
    $('.nominal').prop('readonly', false)
    $('.tbl_harga').hide()
    $('.tbl_checkbox').hide()
    $('.tbl_supir_id').show()
    $('.tbl_karyawan_id').hide()
    $('.tbl_aksi').hide()
    $('.colspan').attr('colspan', 2);
    $('#tbl_addRow').hide()
    $('.colmn-offset2').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('.tbl_tagihklaim').hide()
    $('.cabang').hide()

    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    // $('.colmn-offset').hide()
  }

  function tampilanPJK() {
    $('.kolom_bbt').hide()
    $('#btnReloadOtokGrid').hide()
    $('#btnReloadSumbanganGrid').hide()
    $('[name=statusposting]').parents('.form-group').show()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').hide()
    $('[name=containerheader_id]').parents('.form-group').hide()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('[name=periode]').parents('.form-group').hide()
    $('[name=periode]').prop('disabled', true)
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('#detail-bst-section').hide()
    $('#detail-tde-section').hide()
    $('#detail-bll-section').hide()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').hide()
    $('#detail-btt-section').hide()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-bsm-section').hide()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').hide()
    $('#detail-default-section').parents('.card').show()
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_stok_id').hide()
    $('.tbl_qty').hide()
    $('.nominal').prop('readonly', false)
    $('.tbl_harga').hide()
    $('.tbl_checkbox').hide()
    $('.tbl_supir_id').hide()
    $('.tbl_karyawan_id').show()
    $('.tbl_aksi').hide()
    $('.colspan').attr('colspan', 2);
    $('#tbl_addRow').hide()
    $('.colmn-offset2').hide()
    $('.tbl_tagihklaim').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('.cabang').hide()

    // enabledKas(true);
    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    // $('.colmn-offset').hide()
  }

  function tampilanBBT() { //titipan Emkl

    // enabledKas(true);
    $('.kolom_bbt').show()
    $('#btnReloadOtokGrid').hide()
    $('#btnReloadSumbanganGrid').hide()
    $('[name=statusposting]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').hide()
    $('[name=containerheader_id]').parents('.form-group').hide()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').show()
    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('[name=periode]').parents('.form-group').hide()
    $('[name=periode]').prop('disabled', true)
    $('#detail-bst-section').hide()
    $('#detail-bll-section').hide()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').hide()
    $('#detail-btt-section').hide()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').hide()
    $('#detail-tde-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-bsm-section').hide()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').hide()
    $('#detail-default-section').parents('.card').show()
    $('.tbl_pengeluaranstokheader_nobukti').hide()

    $('.tbl_karyawan_id').hide()
    $('.tbl_supir_id').hide()
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('.tbl_stok_id').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_qty').hide()
    $('.tbl_sisa').hide()
    $('.tbl_harga').hide()
    $('#tagihanColFoot').show()
    $('.tbl_qty').hide()
    $('.tbl_checkbox').hide()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 6);
    $('#tbl_addRow').show()
    $('.colmn-offset2').show()
    $('.tbl_tagihklaim').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('.cabang').hide()
  }

  function tampilanTDE() {
    $('.kolom_bbt').hide()
    // enabledKas(true);
    $('#btnReloadOtokGrid').hide()
    $('#btnReloadSumbanganGrid').hide()
    $('[name=statusposting]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').hide()
    $('[name=containerheader_id]').parents('.form-group').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('.tbl_supir_id').hide()
    $('.tbl_tagihklaim').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').show()
    $('[name=tgldari]').parents('.form-group').hide()
    $('[name=tgldari]').prop('disabled', true)
    $('[name=tglsampai]').prop('disabled', true)
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('[name=periode]').parents('.form-group').hide()
    $('[name=periode]').prop('disabled', true)
    $('.tbl_stok_id').hide()
    $('.tbl_qty').hide()
    $('.nominal').prop('readonly', false)
    $('.tbl_harga').hide()
    $('.cabang').hide()
    $('.tbl_karyawan_id').hide()
    $('#detail-tde-section').show()
    $('#detail-bst-section').hide()
    $('#detail-bll-section').hide()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').hide()
    $('#detail-btt-section').hide()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-bsm-section').hide()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').hide()
    $('#detail-default-section').parents('.card').hide()
    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    loadDepositoGrid()
  }

  function tampilanTDEK() {
    $('.kolom_bbt').hide()
    // enabledKas(true);
    $('#btnReloadOtokGrid').hide()
    $('#btnReloadSumbanganGrid').hide()
    $('[name=statusposting]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').hide()
    $('[name=containerheader_id]').parents('.form-group').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').show()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('.tbl_supir_id').hide()
    $('.tbl_tagihklaim').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('[name=tgldari]').prop('disabled', true)
    $('[name=tglsampai]').prop('disabled', true)
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('[name=periode]').parents('.form-group').hide()
    $('[name=periode]').prop('disabled', true)
    $('.tbl_stok_id').hide()
    $('.tbl_qty').hide()
    $('.nominal').prop('readonly', false)
    $('.tbl_harga').hide()
    $('.cabang').hide()
    $('.tbl_karyawan_id').hide()
    $('#detail-tde-section').hide()
    $('#detail-bst-section').hide()
    $('#detail-bll-section').hide()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').hide()
    $('#detail-btt-section').hide()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').hide()
    $('#detail-bsm-section').hide()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').hide()
    $('#detail-tdek-section').show()
    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    $('#detail-default-section').parents('.card').hide()
    loadDepositoKaryawanGrid()
  }

  function tampilanBST() {
    $('#detailList tbody').html('')
    // enabledKas(true);
    $('#btnReloadOtokGrid').hide()
    $('#btnReloadSumbanganGrid').show()
    $('[name=statusposting]').parents('.form-group').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').hide()
    $('[name=containerheader_id]').parents('.form-group').hide()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').show()
    $(".tgldari").text("TGL DARI ");
    $(".tglsampai").text("TGL SAMPAI ");
    $('[name=tgldari]').prop('disabled', false)
    $('[name=tglsampai]').prop('disabled', false)
    $('[name=periode]').parents('.form-group').hide()
    $('[name=periode]').prop('disabled', true)
    $('#detail-bst-section').show()
    $('#detail-bll-section').hide()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').hide()
    $('#detail-btt-section').hide()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-bsm-section').hide()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').hide()
    $('#detail-default-section').parents('.card').hide()
    $('#detail-tde-section').hide()
    $('.tbl_checkbox').hide()
    $('.tbl_karyawan_id').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('.tbl_stok_id').hide()
    $('.tbl_qty').hide()
    $('.nominal').prop('readonly', false)
    $('.tbl_harga').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 2);
    $('#tbl_addRow').show()
    $('.colmn-offset2').hide()
    $('.kolom_bbt').hide()
    $('.tbl_tagihklaim').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('.cabang').hide()
    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    // $('.colmn-offset').hide()
    loadModalGrid()
  }

  function tampilanKBBM() {
    $('#detailList tbody').html('')
    // enabledKas(true);
    $('#btnReloadOtokGrid').hide()
    $('#btnReloadSumbanganGrid').hide()
    $('[name=statusposting]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').hide()
    $('[name=containerheader_id]').parents('.form-group').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').show()
    $(".tgldari").text("TGL DARI ");
    $(".tglsampai").text("TGL SAMPAI ");
    $('[name=tgldari]').prop('disabled', false)
    $('[name=tglsampai]').prop('disabled', false)
    $('[name=periode]').parents('.form-group').hide()
    $('[name=periode]').prop('disabled', true)
    $('#detail-bst-section').hide()
    $('#detail-bll-section').hide()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').hide()
    $('#detail-btt-section').hide()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-bsm-section').hide()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').hide()
    $('#detail-default-section').parents('.card').hide()
    $('#detail-tde-section').hide()
    $('#detail-kbbm-section').show()
    $('.tbl_checkbox').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('.tbl_stok_id').hide()
    $('.tbl_qty').hide()
    $('.nominal').prop('readonly', false)
    $('.tbl_harga').hide()
    $('.tbl_karyawan_id').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 2);
    $('.kolom_bbt').hide()
    $('.cabang').hide()
    $('.tbl_tagihklaim').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    $('#tbl_addRow').show()
    loadPelunasanBBMGrid()
  }

  function tampilanBSB() {
    // enabledKas(true);
    $('#btnReloadOtokGrid').hide()
    $('#btnReloadSumbanganGrid').hide()
    $('[name=statusposting]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').hide()
    $('[name=containerheader_id]').parents('.form-group').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('[name=tgldari]').prop('disabled', true)
    $('[name=tglsampai]').prop('disabled', true)
    $('[name=periode]').parents('.form-group').hide()
    $('[name=periode]').prop('disabled', true)
    $('#detail-bst-section').hide()
    $('#detail-bll-section').hide()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').hide()
    $('#detail-btt-section').hide()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').hide()
    $('#detail-tde-section').hide()
    $('#detail-kbbm-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-bsm-section').hide()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').hide()
    $('#detail-default-section').parents('.card').show()
    $('.tbl_checkbox').hide()
    $('.tbl_karyawan_id').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('.tbl_stok_id').hide()
    $('.nominal').prop('readonly', false)
    $('.tbl_harga').hide()
    $('.tbl_qty').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 2);
    $('.kolom_bbt').hide()
    $('#tbl_addRow').show()
    $('.tbl_tagihklaim').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('.colmn-offset2').hide()
    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    $('.cabang').hide()
    $('.colmn-offset').show()
  }

  function tampilanKLAIM() {
    // enabledKas(false);
    $('#btnReloadOtokGrid').hide()
    $('#btnReloadSumbanganGrid').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=statusposting]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').hide()
    $('[name=containerheader_id]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').show()
    $('[name=tradoheader_id]').parents('.form-group').show()
    $('[name=gandenganheader_id]').parents('.form-group').show()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=tgldari]').prop('disabled', true)
    $('[name=tglsampai]').prop('disabled', true)
    $('[name=tgldari]').parents('.form-group').hide()
    $('[name=periode]').parents('.form-group').hide()
    $('[name=periode]').prop('disabled', true)
    $('#detail-bst-section').hide()
    $('#detail-tde-section').hide()
    $('#detail-kbbm-section').hide()
    $('#detail-bll-section').hide()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').hide()
    $('#detail-btt-section').hide()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-bsm-section').hide()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').hide()
    $('#detail-default-section').parents('.card').show()
    $('.tbl_checkbox').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_supir_id').hide()
    $('.tbl_nominal').show()
    $('.tbl_karyawan_id').hide()
    $('.tbl_harga').show()
    $('.tbl_stok_id').show()
    $('.tbl_pengeluaranstokheader_nobukti').show()
    $('.tbl_qty').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 6);
    $('.kolom_bbt').hide()
    $('#tbl_addRow').show()
    $('th.tbl_nominal').text('Nominal tagih')
    $('.tbl_tagihklaim').show()
    $('.colmn-offset2').hide()
    $('.colmn-offset3').show()
    $('.colmn-offset4').show()
    $('.cabang').show()
    // $('.colmn-offset').hide()
    if (classHidden.length > 0) {
      input = classHidden.split(',');
      input.forEach(field => {
        field = $.trim(field.toLowerCase());
        $(`.${field}`).hide()
      });
    }
  }


  function tampilanBLL() {
    console.log('bll')
    $('#detailList tbody').html('')
    // enabledKas(true);
    $('#btnReloadOtokGrid').hide()
    $('#btnReloadSumbanganGrid').hide()
    $('[name=statusposting]').parents('.form-group').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').hide()
    $('[name=containerheader_id]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('[name=tgldari]').prop('disabled', true)
    $('[name=tglsampai]').prop('disabled', true)
    $('[name=periode]').parents('.form-group').show()
    $('[name=periode]').prop('disabled', false)
    $('#detail-bll-section').show()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').hide()
    $('#detail-btt-section').hide()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').hide()
    $('#detail-bst-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-bsm-section').hide()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').hide()
    $('#detail-default-section').parents('.card').hide()
    $('#detail-tde-section').hide()
    $('.tbl_checkbox').hide()
    $('.tbl_karyawan_id').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('.tbl_stok_id').hide()
    $('.tbl_qty').hide()
    $('.nominal').prop('readonly', false)
    $('.tbl_harga').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 2);
    $('#tbl_addRow').hide()
    $('.kolom_bbt').hide()
    $('.tbl_tagihklaim').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('.cabang').hide()
    // $('.colmn-offset').hide()

    $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
    loadBLLGrid()
    if ($('#crudForm').data('action') == 'add') {

      getDataBiayaLapangan().then((response) => {
        console.log('before')
        let selectedIdBll = []

        $.each(response.data, (index, value) => {
          selectedIdBll.push(value.id)
        })
        $('#tableBLL').jqGrid("clearGridData");
        setTimeout(() => {

          $("#tableBLL")
            .jqGrid("setGridParam", {
              datatype: "local",
              data: response.data,
              originalData: response.data,
              rowNum: response.data.length,
              selectedRowIds: selectedIdBll
            })
            .trigger("reloadGrid");
        }, 100);
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBLL_nominal"]`).text(0))

      });
    }
  }

  function tampilanBLN() {
    $('#detailList tbody').html('')
    // enabledKas(true);
    $('#btnReloadOtokGrid').hide()
    $('#btnReloadSumbanganGrid').hide()
    $('[name=statusposting]').parents('.form-group').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').hide()
    $('[name=containerheader_id]').parents('.form-group').hide()
    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('[name=tgldari]').prop('disabled', true)
    $('[name=tglsampai]').prop('disabled', true)
    $('[name=periode]').parents('.form-group').show()
    $('[name=periode]').prop('disabled', false)
    $('#detail-bll-section').hide()
    $('#detail-bln-section').show()
    $('#detail-btu-section').hide()
    $('#detail-btt-section').hide()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').hide()
    $('#detail-bst-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-bsm-section').hide()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').hide()
    $('#detail-default-section').parents('.card').hide()
    $('#detail-tde-section').hide()
    $('.tbl_checkbox').hide()
    $('.tbl_karyawan_id').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('.tbl_stok_id').hide()
    $('.tbl_qty').hide()
    $('.nominal').prop('readonly', false)
    $('.tbl_harga').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 2);
    $('#tbl_addRow').hide()
    $('.kolom_bbt').hide()
    $('.tbl_tagihklaim').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('.cabang').hide()
    // $('.colmn-offset').hide()
    $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
    loadBLNGrid()
    if ($('#crudForm').data('action') == 'add') {

      getDataBiayaLapangan().then((response) => {
        let selectedIdBln = []

        $.each(response.data, (index, value) => {
          selectedIdBln.push(value.id)
        })
        $('#tableBLN').jqGrid("clearGridData");
        setTimeout(() => {

          $("#tableBLN")
            .jqGrid("setGridParam", {
              datatype: "local",
              data: response.data,
              originalData: response.data,
              rowNum: response.data.length,
              selectedRowIds: selectedIdBln
            })
            .trigger("reloadGrid");
        }, 100);
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBLN_nominal"]`).text(0))

      });
    }
  }

  function tampilanBTU() {
    $('#detailList tbody').html('')
    // enabledKas(true);
    $('#btnReloadOtokGrid').hide()
    $('#btnReloadSumbanganGrid').hide()
    $('[name=statusposting]').parents('.form-group').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').hide()
    $('[name=containerheader_id]').parents('.form-group').hide()
    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('[name=tgldari]').prop('disabled', true)
    $('[name=tglsampai]').prop('disabled', true)
    $('[name=periode]').parents('.form-group').show()
    $('[name=periode]').prop('disabled', false)
    $('#detail-bll-section').hide()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').show()
    $('#detail-btt-section').hide()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').hide()
    $('#detail-bst-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-bsm-section').hide()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').hide()
    $('#detail-default-section').parents('.card').hide()
    $('#detail-tde-section').hide()
    $('.tbl_checkbox').hide()
    $('.tbl_karyawan_id').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('.tbl_stok_id').hide()
    $('.tbl_qty').hide()
    $('.nominal').prop('readonly', false)
    $('.tbl_harga').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 2);
    $('#tbl_addRow').hide()
    $('.kolom_bbt').hide()
    $('.tbl_tagihklaim').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('.cabang').hide()
    // $('.colmn-offset').hide()
    $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
    loadBTUGrid()
    if ($('#crudForm').data('action') == 'add') {

      getDataBiayaLapangan().then((response) => {
        let selectedIdBtu = []

        $.each(response.data, (index, value) => {
          selectedIdBtu.push(value.id)
        })
        $('#tableBTU').jqGrid("clearGridData");
        setTimeout(() => {

          $("#tableBTU")
            .jqGrid("setGridParam", {
              datatype: "local",
              data: response.data,
              originalData: response.data,
              rowNum: response.data.length,
              selectedRowIds: selectedIdBtu
            })
            .trigger("reloadGrid");
        }, 100);
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBTU_nominal"]`).text(0))

      });
    }
  }


  function tampilanBTT() {
    $('#detailList tbody').html('')
    // enabledKas(true);
    $('#btnReloadOtokGrid').hide()
    $('#btnReloadSumbanganGrid').hide()
    $('[name=statusposting]').parents('.form-group').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').hide()
    $('[name=containerheader_id]').parents('.form-group').hide()
    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('[name=tgldari]').prop('disabled', true)
    $('[name=tglsampai]').prop('disabled', true)
    $('[name=periode]').parents('.form-group').show()
    $('[name=periode]').prop('disabled', false)
    $('#detail-bll-section').hide()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').hide()
    $('#detail-btt-section').show()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').hide()
    $('#detail-bst-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-bsm-section').hide()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').hide()
    $('#detail-default-section').parents('.card').hide()
    $('#detail-tde-section').hide()
    $('.tbl_checkbox').hide()
    $('.tbl_karyawan_id').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('.tbl_stok_id').hide()
    $('.tbl_qty').hide()
    $('.nominal').prop('readonly', false)
    $('.tbl_harga').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 2);
    $('#tbl_addRow').hide()
    $('.kolom_bbt').hide()
    $('.tbl_tagihklaim').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('.cabang').hide()
    // $('.colmn-offset').hide()
    $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
    loadBTTGrid()
    if ($('#crudForm').data('action') == 'add') {

      getDataBiayaLapangan().then((response) => {
        let selectedIdBtt = []

        $.each(response.data, (index, value) => {
          selectedIdBtt.push(value.id)
        })
        $('#tableBTT').jqGrid("clearGridData");
        setTimeout(() => {

          $("#tableBTT")
            .jqGrid("setGridParam", {
              datatype: "local",
              data: response.data,
              originalData: response.data,
              rowNum: response.data.length,
              selectedRowIds: selectedIdBtt
            })
            .trigger("reloadGrid");
        }, 100);
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBTT_nominal"]`).text(0))

      });
    }
  }

  function tampilanBPT() {
    $('#detailList tbody').html('')
    // enabledKas(true);
    $('#btnReloadOtokGrid').hide()
    $('#btnReloadSumbanganGrid').hide()
    $('[name=statusposting]').parents('.form-group').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').hide()
    $('[name=containerheader_id]').parents('.form-group').hide()
    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('[name=tgldari]').prop('disabled', true)
    $('[name=tglsampai]').prop('disabled', true)
    $('[name=periode]').parents('.form-group').show()
    $('[name=periode]').prop('disabled', false)
    $('#detail-bll-section').hide()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').hide()
    $('#detail-btt-section').hide()
    $('#detail-bpt-section').show()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').hide()
    $('#detail-bst-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-bsm-section').hide()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').hide()
    $('#detail-default-section').parents('.card').hide()
    $('#detail-tde-section').hide()
    $('.tbl_checkbox').hide()
    $('.tbl_karyawan_id').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('.tbl_stok_id').hide()
    $('.tbl_qty').hide()
    $('.nominal').prop('readonly', false)
    $('.tbl_harga').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 2);
    $('#tbl_addRow').hide()
    $('.kolom_bbt').hide()
    $('.tbl_tagihklaim').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('.cabang').hide()
    // $('.colmn-offset').hide()
    $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
    loadBPTGrid()
    if ($('#crudForm').data('action') == 'add') {

      getDataBiayaLapangan().then((response) => {
        let selectedIdBpt = []

        $.each(response.data, (index, value) => {
          selectedIdBpt.push(value.id)
        })
        $('#tableBPT').jqGrid("clearGridData");
        setTimeout(() => {

          $("#tableBPT")
            .jqGrid("setGridParam", {
              datatype: "local",
              data: response.data,
              originalData: response.data,
              rowNum: response.data.length,
              selectedRowIds: selectedIdBpt
            })
            .trigger("reloadGrid");
        }, 100);
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBPT_nominal"]`).text(0))

      });
    }
  }


  function tampilanBGS() {
    $('#detailList tbody').html('')
    // enabledKas(true);
    $('#btnReloadOtokGrid').hide()
    $('#btnReloadSumbanganGrid').hide()
    $('[name=statusposting]').parents('.form-group').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').hide()
    $('[name=containerheader_id]').parents('.form-group').hide()
    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('[name=tgldari]').prop('disabled', true)
    $('[name=tglsampai]').prop('disabled', true)
    $('[name=periode]').parents('.form-group').show()
    $('[name=periode]').prop('disabled', false)
    $('#detail-bll-section').hide()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').hide()
    $('#detail-btt-section').hide()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').show()
    $('#detail-bit-section').hide()
    $('#detail-bst-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-bsm-section').hide()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').hide()
    $('#detail-default-section').parents('.card').hide()
    $('#detail-tde-section').hide()
    $('.tbl_checkbox').hide()
    $('.tbl_karyawan_id').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('.tbl_stok_id').hide()
    $('.tbl_qty').hide()
    $('.nominal').prop('readonly', false)
    $('.tbl_harga').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 2);
    $('#tbl_addRow').hide()
    $('.kolom_bbt').hide()
    $('.tbl_tagihklaim').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('.cabang').hide()
    // $('.colmn-offset').hide()
    $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
    loadBGSGrid()
    if ($('#crudForm').data('action') == 'add') {

      getDataBiayaLapangan().then((response) => {
        let selectedIdBgs = []

        $.each(response.data, (index, value) => {
          selectedIdBgs.push(value.id)
        })
        $('#tableBGS').jqGrid("clearGridData");
        setTimeout(() => {

          $("#tableBGS")
            .jqGrid("setGridParam", {
              datatype: "local",
              data: response.data,
              originalData: response.data,
              rowNum: response.data.length,
              selectedRowIds: selectedIdBgs
            })
            .trigger("reloadGrid");
        }, 100);
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBGS_nominal"]`).text(0))
      });
    }
  }

  function tampilanBIT() {
    $('#detailList tbody').html('')
    // enabledKas(true);
    $('#btnReloadOtokGrid').hide()
    $('#btnReloadSumbanganGrid').hide()
    $('[name=statusposting]').parents('.form-group').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').hide()
    $('[name=containerheader_id]').parents('.form-group').hide()
    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('[name=tgldari]').prop('disabled', true)
    $('[name=tglsampai]').prop('disabled', true)
    $('[name=periode]').parents('.form-group').show()
    $('[name=periode]').prop('disabled', false)
    $('#detail-bll-section').hide()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').hide()
    $('#detail-btt-section').hide()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').show()
    $('#detail-bst-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-bsm-section').hide()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').hide()
    $('#detail-default-section').parents('.card').hide()
    $('#detail-tde-section').hide()
    $('.tbl_checkbox').hide()
    $('.tbl_karyawan_id').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('.tbl_stok_id').hide()
    $('.tbl_qty').hide()
    $('.nominal').prop('readonly', false)
    $('.tbl_harga').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 2);
    $('#tbl_addRow').hide()
    $('.kolom_bbt').hide()
    $('.tbl_tagihklaim').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('.cabang').hide()
    // $('.colmn-offset').hide()
    $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
    loadBITGrid()
    if ($('#crudForm').data('action') == 'add') {

      getDataBiayaLapangan().then((response) => {
        let selectedIdBit = []

        $.each(response.data, (index, value) => {
          selectedIdBit.push(value.id)
        })
        $('#tableBIT').jqGrid("clearGridData");
        setTimeout(() => {

          $("#tableBIT")
            .jqGrid("setGridParam", {
              datatype: "local",
              data: response.data,
              originalData: response.data,
              rowNum: response.data.length,
              selectedRowIds: selectedIdBit
            })
            .trigger("reloadGrid");
        }, 100);
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBIT_nominal"]`).text(0))

      });
    }
  }

  function tampilanOTOK() {
    $('#detailList tbody').html('')
    // enabledKas(true);
    $('#btnReloadOtokGrid').show()
    $('#btnReloadSumbanganGrid').hide()
    $('[name=statusposting]').parents('.form-group').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').show()
    $('[name=containerheader_id]').parents('.form-group').show()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').show()
    $(".tgldari").text("PERIODE DARI ");
    $(".tglsampai").text("PERIODE SAMPAI ");
    $('[name=tgldari]').prop('disabled', false)
    $('[name=tglsampai]').prop('disabled', false)
    $('[name=periode]').parents('.form-group').hide()
    $('[name=periode]').prop('disabled', true)
    $('#detail-bst-section').hide()
    $('#detail-bll-section').hide()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').hide()
    $('#detail-btt-section').hide()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-otok-section').show()
    $('#detail-otol-section').hide()
    $('#detail-bsm-section').hide()
    $('#detail-default-section').parents('.card').hide()
    $('#detail-tde-section').hide()
    $('.tbl_checkbox').hide()
    $('.tbl_karyawan_id').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('.tbl_stok_id').hide()
    $('.tbl_qty').hide()
    $('.nominal').prop('readonly', false)
    $('.tbl_harga').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 2);
    $('#tbl_addRow').show()
    $('.colmn-offset2').hide()
    $('.kolom_bbt').hide()
    $('.tbl_tagihklaim').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('.cabang').hide()
    // $('.colmn-offset').hide()
    loadOTOKGrid()
  }

  function tampilanOTOL() {
    $('#detailList tbody').html('')
    // enabledKas(true);
    $('#btnReloadOtokGrid').show()
    $('#btnReloadSumbanganGrid').hide()
    $('[name=statusposting]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').show()
    $('[name=containerheader_id]').parents('.form-group').show()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').show()

    $(".tgldari").text("PERIODE DARI ");
    $(".tglsampai").text("PERIODE SAMPAI ");
    $('[name=tgldari]').prop('disabled', false)
    $('[name=tglsampai]').prop('disabled', false)
    $('[name=periode]').parents('.form-group').hide()
    $('[name=periode]').prop('disabled', true)
    $('#detail-bst-section').hide()
    $('#detail-bll-section').hide()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').hide()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').show()
    $('#detail-bsm-section').hide()
    $('#detail-default-section').parents('.card').hide()
    $('#detail-tde-section').hide()
    $('.tbl_checkbox').hide()
    $('.tbl_karyawan_id').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('.tbl_stok_id').hide()
    $('.tbl_qty').hide()
    $('.nominal').prop('readonly', false)
    $('.tbl_harga').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 2);
    $('#tbl_addRow').show()
    $('.colmn-offset2').hide()
    $('.kolom_bbt').hide()
    $('.tbl_tagihklaim').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('.cabang').hide()
    // $('.colmn-offset').hide()
    loadOTOLGrid()
  }


  function tampilanBSM() {
    $('#detailList tbody').html('')
    // enabledKas(true);
    $('#btnReloadOtokGrid').hide()
    $('#btnReloadSumbanganGrid').hide()
    $('[name=statusposting]').parents('.form-group').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').hide()
    $('[name=containerheader_id]').parents('.form-group').hide()
    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').show()
    $(".tgldari").text("PERIODE DARI ");
    $(".tglsampai").text("PERIODE SAMPAI ");
    $('[name=tgldari]').prop('disabled', false)
    $('[name=tglsampai]').prop('disabled', false)
    $('[name=periode]').parents('.form-group').hide()
    $('[name=periode]').prop('disabled', true)
    $('#detail-bll-section').hide()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').hide()
    $('#detail-btt-section').hide()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').hide()
    $('#detail-bst-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-bsm-section').show()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').hide()
    $('#detail-default-section').parents('.card').hide()
    $('#detail-tde-section').hide()
    $('.tbl_checkbox').hide()
    $('.tbl_karyawan_id').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('.tbl_stok_id').hide()
    $('.tbl_qty').hide()
    $('.nominal').prop('readonly', false)
    $('.tbl_harga').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 2);
    $('#tbl_addRow').hide()
    $('.kolom_bbt').hide()
    $('.tbl_tagihklaim').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('.cabang').hide()
    // $('.colmn-offset').hide()
    $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
    loadBSMGrid()
    if ($('#crudForm').data('action') == 'add') {

      getDataBiayaLapangan().then((response) => {
        let selectedIdBsm = []

        $.each(response.data, (index, value) => {
          selectedIdBsm.push(value.id)
        })
        $('#tableBSM').jqGrid("clearGridData");
        setTimeout(() => {

          $("#tableBSM")
            .jqGrid("setGridParam", {
              datatype: "local",
              data: response.data,
              originalData: response.data,
              rowNum: response.data.length,
              selectedRowIds: selectedIdBsm
            })
            .trigger("reloadGrid");
        }, 100);
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBSM_nominal"]`).text(0))

      });
    }
  }

  function tampilanall() {
    enabledKas(true);
    $('#btnReloadOtokGrid').hide()
    $('#btnReloadSumbanganGrid').hide()
    // if (KodePengeluaranId == 'BLS') {
    //   $('.colmn-offset').show()
    //   $('.tbl_penerimaantruckingheader').show()
    //   $('[name=keterangancoa]').parents('.form-group').show()
    //   $('.colspan').attr('colspan', 3);
    // } else {
    $('.colspan').attr('colspan', 2);
    $('.colmn-offset').show()
    $('.tbl_penerimaantruckingheader').hide()
    $('[name=keterangancoa]').parents('.form-group').hide()
    // }
    $('[name=pengeluarantrucking_nobukti]').parents('.form-group').hide()
    $('[name=statusposting]').parents('.form-group').hide()
    $('.tbl_stok_id').hide()
    $('.tbl_qty').hide()
    $('[name=tradoheader_id]').parents('.form-group').hide()
    $('[name=agen_id]').parents('.form-group').hide()
    $('[name=containerheader_id]').parents('.form-group').hide()
    $('[name=gandenganheader_id]').parents('.form-group').hide()
    $('[name=karyawanheader_id]').parents('.form-group').hide()
    $('[name=postingpinjaman]').parents('.form-group').hide()
    $('[name=jenisorderan_id]').parents('.form-group').hide()
    $('.tbl_supir_id').show()
    $('.tbl_sisa').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('[name=tgldari]').prop('disabled', true)
    $('[name=tglsampai]').prop('disabled', true)
    $('[name=periode]').parents('.form-group').hide()
    $('[name=periode]').prop('disabled', true)
    $('#detail-bst-section').hide()
    $('#detail-tde-section').hide()
    $('#detail-kbbm-section').hide()
    $('#detail-bll-section').hide()
    $('#detail-bln-section').hide()
    $('#detail-btu-section').hide()
    $('#detail-btt-section').hide()
    $('#detail-bpt-section').hide()
    $('#detail-bgs-section').hide()
    $('#detail-bit-section').hide()
    $('#detail-tdek-section').hide()
    $('#detail-otok-section').hide()
    $('#detail-otol-section').hide()
    $('#detail-default-section').parents('.card').show()
    $('#sisaColFoot').hide()
    $('#sisaFoot').hide()
    $('.tbl_karyawan_id').hide()
    $('.tbl_nominal').prop('readonly', false)
    $('.tbl_harga').hide()
    $('.tbl_pengeluaranstokheader_nobukti').hide()
    $('.tbl_suratpengantar_nobukti').hide()
    $('.tbl_trado_id').hide()
    $('.tbl_container_id').hide()
    $('.tbl_pelanggan_id').hide()
    $('.tbl_nominaltagih').hide()
    $('.tbl_jenisorder').hide()
    $('.kolom_bbt').hide()
    $('.tbl_tagihklaim').hide()
    $('.colmn-offset3').hide()
    $('.colmn-offset4').hide()
    $('#tbl_addRow').hide()
    $('.tbl_aksi').hide()
    $('.cabang').hide()

  }

  $(document).on('click', '.checkItem', function(event) {
    enabledRow($(this).data("id"))
  })


  function enabledRow(row) {
    let check = $(`#penerimaantruckingheader_id${row}`)
    if (check.prop("checked") == true) {
      $(`#nominal_${row}`).prop('disabled', false)
      $(`#penerimaantruckingheader_nobukti_detail${row}`).prop('disabled', false)
      $(`#keterangan_detail${row}`).prop('disabled', false)
    } else if (check.prop("checked") == false) {
      $(`#nominal_${row}`).prop('disabled', true)
      $(`#penerimaantruckingheader_nobukti_detail${row}`).prop('disabled', true)
      $(`#keterangan_detail${row}`).prop('disabled', true)
    }
    setTotal()
  }

  function enabledKas(enabled = false) {
    let statusposting_id = $('#crudForm').find('[name=statusposting]').val()
    // console.log(enabled,parameterPosting , statusposting_id);
    // if (statusposting_id) {
    if (KodePengeluaranId != 'KLAIM') {
      if (KodePengeluaranId == 'PJT') {
        console.log('enabled ', enabled)
        if (enabled) {
          $('.posting-border').show()
          setDefaultBank()
        } else {
          $('.posting-border').hide()
          $('#crudForm [name=bank_id]').first().val('')
          $('#crudForm [name=bank]').first().val('')
          $('#crudForm [name=bank]').first().data('currentValue', '')
        }
      } else {
        $('.posting-border').show()
        // setDefaultBank()
      }
    } else {
      $('.posting-border').hide()
      $('#crudForm [name=bank_id]').first().val('')
      $('#crudForm [name=bank]').first().val('')
      $('#crudForm [name=bank]').first().data('currentValue', '')
    }


  }

  $(document).on('click', "#btnReloadSumbanganGrid", function(event) {
    event.preventDefault()
    reloadGrid = null;
    if ($('#crudForm').data('action') == 'edit') {
      reloadGrid = 'reload'
    }

    var tgldari = $('#crudForm').find(`[name="tgldari"]`).val()
    var tglsampai = $('#crudForm').find(`[name="tglsampai"]`).val()
    clearSelectedRowsSumbangan()
    getDataSumbangan()
      .then((response) => {
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        // $('#tableSumbangan').jqGrid("clearGridData");
        $('#tableSumbangan').jqGrid('setGridParam', {
          url: `${apiUrl}pengeluarantruckingheader/${response.url}`,
          postData: {
            tgldari: $('#crudForm').find('[name=tgldari]').val(),
            tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
            aksi: $('#crudForm').data('action'),
            proses: 'reload'
          },
          datatype: "json"
        }).trigger('reloadGrid');
      })
      .catch((errors) => {
        setErrorMessages($('#crudForm'), errors)
      })

  })
  $(document).on('click', "#btnReloadOtokGrid", function(event) {
    event.preventDefault()
    reloadGrid = null;
    if ($('#crudForm').data('action') == 'edit') {
      reloadGrid = 'reload'
    }
    if (KodePengeluaranId == 'OTOK') {
      clearSelectedRowsOTOK()
      getDataOTOK().then((response) => {
        // console.log('before', $("#tablePinjamanKaryawan").jqGrid('getGridParam', 'selectedRowIds'))
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        $('#tableOTOK').jqGrid('setGridParam', {
          url: `${apiUrl}pengeluarantruckingheader/${response.url}`,
          postData: {
            tgldari: $('#crudForm').find('[name=tgldari]').val(),
            tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
            agen_id: $('#crudForm').find('[name=agen_id]').val(),
            container_id: $('#crudForm').find('[name=containerheader_id]').val(),
            aksi: $('#crudForm').data('action')
          },
          datatype: "json"
        }).trigger('reloadGrid');

      }).catch((errors) => {
        setErrorMessages($('#crudForm'), errors)
      });
    } else {

      clearSelectedRowsOTOL()
      getDataOTOL().then((response) => {
        // console.log('before', $("#tablePinjamanKaryawan").jqGrid('getGridParam', 'selectedRowIds'))
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        // console.log(response)
        $('#tableOTOL').jqGrid('setGridParam', {
          url: `${apiUrl}pengeluarantruckingheader/${response.url}`,
          postData: {
            tgldari: $('#crudForm').find('[name=tgldari]').val(),
            tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
            agen_id: $('#crudForm').find('[name=agen_id]').val(),
            container_id: $('#crudForm').find('[name=containerheader_id]').val(),
            aksi: $('#crudForm').data('action')
          },
          datatype: "json"
        }).trigger('reloadGrid');

      }).catch((errors) => {
        setErrorMessages($('#crudForm'), errors)
      });
    }

  });

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null

    getMaxLength(form)
    initLookup()
    initDatepicker()
    initMonthpicker()
    initSelect2(form.find(`[name="statusposting"]`), true)
    // initSelect2(form.find(`[name="postingpinjaman"]`), true)
    initSelect2(form.find(`[name="statuscabang"]`), true)
    if (form.data('action') == 'add') {
      form.find('#btnSaveAdd').show()

      if ($('#pengeluaranheader_id').val() != '') {
        let index = listIdPengeluaran.indexOf($('#pengeluaranheader_id').val());
        setKodePengeluaran(listKodePengeluaran[index]);
        $('#crudForm').find(`[name="pengeluarantrucking"]`).val(listKeteranganPengeluaran[index])
        $('#crudForm').find(`[name="pengeluarantrucking"]`).data('currentValue', listKeteranganPengeluaran[index])
        $('#crudForm').find(`[name="pengeluarantrucking_id"]`).val($('#pengeluaranheader_id').val())
      }
    } else {

      form.find('#btnSaveAdd').hide()
    }
    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }
    // initSelect2()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy($('#crudForm').find('[name=id]').val())
    selectedRows = []
    penerimaanstokheader = ''
    penerimaanstokheader_nobukti = ''
    pengeluaranstokheader = ''
    clearSelectedRowsSumbangan()
    clearSelectedRowsOTOK()
    clearSelectedRowsOTOL()
    classHidden = [];
    $('#crudModal').find('.modal-body').html(modalBody)
    initDatepicker('datepickerIndex')
    KodePengeluaranId = ''
    sortnameSumbangan = 'noinvoice_detail';
    sortorderSumbangan = 'asc';
  })

  function removeEditingBy(id) {
    $.ajax({
      url: `{{ config('app.api_url') }}bataledit`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        id: id,
        aksi: 'BATAL',
        table: 'pengeluarantruckingheader'

      },
      success: response => {
        $("#crudModal").modal("hide")
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
    })
  }

  function setTotal() {
    let nominalDetails = $(`#table_body [name="nominal[]"]:not([disabled])`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });
    new AutoNumeric('#total').set(total)
  }

  function setTotalKlaim() {
    let totalKlaims = $(`#table_body [name="totalklaim[]"]`)
    let total = 0

    $.each(totalKlaims, (index, totalKlaim) => {
      total += AutoNumeric.getNumber(totalKlaim)
    });
    new AutoNumeric('#totalKlaim').set(total)
  }

  function setTotalTambahan() {
    let nominalTambahans = $(`#table_body [name="nominaltambahan[]"]`)
    let total = 0

    $.each(nominalTambahans, (index, nominalTambahan) => {
      total += AutoNumeric.getNumber(nominalTambahan)
    });
    new AutoNumeric('#totalTambahan').set(total)
  }

  function createPengeluaranTruckingHeader() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.data('action', 'add')

    $('#crudModalTitle').text('Add Pengeluaran Trucking')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    $('#table_body').html('')
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=tgldari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=tglsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        setStatusPostingOptions(form),
        // setPostingPinjamanOptions(form),
        setStatusBiayaTitipanOptions(),
        setStatusCabangOptions(form),
        setDefaultBank(),
        addRow(),
        setTotal(),
        setTampilan(form),
      ])
      .then(() => {
        if (selectedRowsIndex.length > 0) {
          clearSelectedRowsIndex()
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

  async function editPengeluaranTruckingHeader(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')
    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    $('#crudModalTitle').text('Edit Pengeluaran Trucking')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    form.find(`[name="bank"]`).removeClass('bank-lookup')
    form.find(`[name="pengeluarantrucking"]`).removeClass('pengeluarantrucking-lookup')

    Promise
      .all([
        setTglBukti(form),
        setStatusBiayaTitipanOptions(),
        setStatusPostingOptions(form),
        // setPostingPinjamanOptions(form),
        setStatusCabangOptions(form),
        setTampilan(form),
      ])
      .then(() => {
        showPengeluaranTruckingHeader(form, id)
          .then(() => {
            if (selectedRowsIndex.length > 0) {
              clearSelectedRowsIndex()
            }
            $('#crudModal').modal('show')
            // $('#crudForm [name=tglbukti]').attr('readonly', true)
            $('#crudForm [name=statusposting]').attr('disabled', true)
            if ($('#crudForm [name=statusposting]').val() == '84') {

              $('.posting-border').hide()
              $('#crudForm [name=bank_id]').first().val('')
              $('#crudForm [name=bank]').first().val('')
              $('#crudForm [name=bank]').first().data('currentValue', '')

            }

            if (KodePengeluaranId === "KLAIM") {
              if (form.find(`[name="trado"]`).val() != '') {
                lookupSelected(`trado`)
              } else {
                lookupSelected(`gandengan`)
              }
            }
            if (isEditTgl == 'TIDAK') {
              form.find(`[name="tglbukti"]`).prop('readonly', true)
              form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
            }
            if (KodePengeluaranId === "TDE") {
              form.find(`[name="supirheader"]`).parent('.input-group').find('.button-clear').remove()
              form.find(`[name="supirheader"]`).parent('.input-group').find('.input-group-append').remove()
            }
            if (KodePengeluaranId === "TDEK") {
              form.find(`[name="karyawanheader"]`).parent('.input-group').find('.button-clear').remove()
              form.find(`[name="karyawanheader"]`).parent('.input-group').find('.input-group-append').remove()
            }
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })

  }

  function deletePengeluaranTruckingHeader(id) {

    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-trash"></i>
              Delete
    `)
    $('#crudModalTitle').text('Delete Pengeluaran Trucking')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    form.find(`[name="bank"]`).removeClass('bank-lookup')
    form.find(`[name="pengeluarantrucking"]`).removeClass('pengeluarantrucking-lookup')


    Promise
      .all([
        setStatusPostingOptions(form),
        // setPostingPinjamanOptions(form),
        setStatusBiayaTitipanOptions(),
        setStatusCabangOptions(form),
        setTampilan(form),
      ])
      .then(() => {
        showPengeluaranTruckingHeader(form, id)
          .then(() => {
            if (selectedRowsIndex.length > 0) {
              clearSelectedRowsIndex()
            }
            $('#crudModal').modal('show')
            $('#btnReloadOtokGrid').prop('disabled', true)
            $('#crudForm [name=statusposting]').attr('disabled', true)
            if ($('#crudForm [name=statusposting]').val() == '84') {

              $('.posting-border').hide()
              $('#crudForm [name=bank_id]').first().val('')
              $('#crudForm [name=bank]').first().val('')
              $('#crudForm [name=bank]').first().data('currentValue', '')

            }


            if (KodePengeluaranId === "KLAIM") {
              if (form.find(`[name="trado"]`).val() != '') {
                lookupSelected(`trado`)
              } else {
                lookupSelected(`gandengan`)
              }
            }

            form.find(`[name="tglbukti"]`).prop('readonly', true)
            form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()

            if (KodePengeluaranId === "TDEK") {
              form.find(`[name="karyawanheader"]`).parent('.input-group').find('.button-clear').remove()
              form.find(`[name="karyawanheader"]`).parent('.input-group').find('.input-group-append').remove()
            }
            if (KodePengeluaranId === "TDE") {
              form.find(`[name="supirheader"]`).parent('.input-group').find('.button-clear').remove()
              form.find(`[name="supirheader"]`).parent('.input-group').find('.input-group-append').remove()
            }
          })
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
    form.find(`[name="postingpinjaman"]`).attr('disabled', true)

  }

  function viewPengeluaranTruckingHeader(id) {

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
    $('#crudModalTitle').text('View Pengeluaran Trucking')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    form.find(`[name="bank"]`).removeClass('bank-lookup')
    form.find(`[name="pengeluarantrucking"]`).removeClass('pengeluarantrucking-lookup')


    Promise
      .all([
        setTglBukti(form),
        setStatusPostingOptions(form),
        // setPostingPinjamanOptions(form),
        setStatusBiayaTitipanOptions(),
        setStatusCabangOptions(form),
        setTampilan(form),
      ])
      .then(() => {
        showPengeluaranTruckingHeader(form, id)
          .then(penerimaanStokHeaderId => {
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
            if (selectedRowsIndex.length > 0) {
              clearSelectedRowsIndex()
            }
            $('#crudModal').modal('show')
            $('#crudForm [name=statusposting]').attr('disabled', true)
            if ($('#crudForm [name=statusposting]').val() == '84') {

              $('.posting-border').hide()
              $('#crudForm [name=bank_id]').first().val('')
              $('#crudForm [name=bank]').first().val('')
              $('#crudForm [name=bank]').first().data('currentValue', '')

            }
            if (KodePengeluaranId === "KLAIM") {
              if (form.find(`[name="trado"]`).val() != '') {
                lookupSelected(`trado`)
              } else {
                lookupSelected(`gandengan`)
              }
            }
            $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', true)

            form.find(`.hasDatepicker`).prop('readonly', true)
            form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
            let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
            let nameFind = $('#crudForm').find(`[name]`).parents('.input-group')
            name.attr('disabled', true)
            name.find('.lookup-toggler').remove()
            nameFind.find('button.button-clear').remove()
            $('.tbl_aksi').hide()

          })
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
    form.find(`[name="postingpinjaman"]`).attr('disabled', true)

  }

  function clearSelectedRowsBBM() {
    getSelectedRows = $("#tablePelunasanbbm").getGridParam("selectedRowIds");
    $("#tablePelunasanbbm")[0].p.selectedRowIds = [];
    $.each(getSelectedRows, function(index, value) {
      let originalGridData = $("#tablePelunasanbbm")
        .jqGrid("getGridParam", "originalData")
        .find((row) => row.id == value);

      sisa = 0
      if ($('#crudForm').data('action') == 'edit') {
        sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal))
      } else {
        sisa = originalGridData.sisa
      }

      $("#tablePelunasanbbm").jqGrid(
        "setCell",
        value,
        "sisa",
        sisa
      );
      $("#tablePelunasanbbm").jqGrid("setCell", value, "nominal", 0);
    })
    $('#tablePelunasanbbm').trigger('reloadGrid');
    setTotalNominalPelunasan()
    setTotalSisaPelunasan()
  }

  function selectAllRowsBBM() {

    let originalData = $("#tablePelunasanbbm").getGridParam("data");
    let getSelectedRows = originalData.map((data) => data.id);
    $("#tablePelunasanbbm")[0].p.selectedRowIds = [];

    setTimeout(() => {
      $("#tablePelunasanbbm")
        .jqGrid("setGridParam", {
          selectedRowIds: getSelectedRows
        })
        .trigger("reloadGrid");

      setTotalNominalPelunasan()
      setTotalSisaPelunasan()
    })
  }

  function loadPelunasanBBMGrid() {

    let disabled = '';
    if ($('#crudForm').data('action') == 'delete') {
      disabled = 'disabled'
    }
    $("#tablePelunasanbbm")
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
                      selectAllRowsBBM()
                    } else {
                      clearSelectedRowsBBM()
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
              return `<input type="checkbox" class="checkbox-jqgrid" value="${rowData.id}" ${disabled} onChange="checkboxPelunasanHandler(this, ${rowData.id})">`;
            },
          },
          {
            label: "id",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "Nobukti PENERIMAAN TRUCKING",
            name: "nobukti",
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
                  let originalGridData = $("#tablePelunasanbbm")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tablePelunasanbbm").jqGrid(
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

                  $("#tablePelunasanbbm").jqGrid(
                    "setCell",
                    rowObject.rowId,
                    "sisa",
                    totalSisa
                  );
                  if (totalSisa < 0) {
                    showDialog('sisa tidak boleh minus')
                    $("#tablePelunasanbbm").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "nominal",
                      0
                    );
                    if (originalGridData.sisa == 0) {
                      $("#tablePelunasanbbm").jqGrid("setCell", rowObject.rowId, "sisa", (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)));
                    } else {
                      if ($('#crudForm').data('action') == 'edit') {
                        $("#tablePelunasanbbm").jqGrid("setCell", rowObject.rowId, "sisa", (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)));
                      } else {
                        $("#tablePelunasanbbm").jqGrid("setCell", rowObject.rowId, "sisa", originalGridData.sisa);
                      }
                    }
                  }
                  // nominalDetails = $(`#tablePelunasanbbm tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tablePelunasanbbm_nominal"]`)
                  // ttlBayar = 0
                  // $.each(nominalDetails, (index, nominalDetail) => {
                  //   ttlBayarDetail = parseFloat($(nominalDetail).attr('title').replaceAll(',', ''))
                  //   ttlBayars = (isNaN(ttlBayarDetail)) ? 0 : ttlBayarDetail;
                  //   ttlBayar += ttlBayars
                  // });
                  // ttlBayar += nominal
                  // initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasanbbm_nominal"]`).text(ttlBayar))

                  // setAllTotal()
                  setTotalNominalPelunasan()
                  setTotalSisaPelunasan()
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
            width: 500
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
          let originalGridData = $("#tablePelunasanbbm")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tablePelunasanbbm").jqGrid("getLocalRow", rowId);

          let getBayar = $("#tablePelunasanbbm").jqGrid("getCell", rowId, "nominal")
          let nominal = (getBayar != '') ? parseFloat(getBayar.replaceAll(',', '')) : 0

          sisa = 0
          if ($('#crudForm').data('action') == 'edit') {
            sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)) - nominal
          } else {
            sisa = originalGridData.sisa - nominal
          }
          if (indexColumn == 5) {

            $("#tablePelunasanbbm").jqGrid(
              "setCell",
              rowId,
              "sisa",
              sisa
              // sisa - nominal - potongan
            );
          }

          setTotalSisaPelunasan()
          setTotalNominalPelunasan()
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
                initAutoNumeric($(this).find(`td[aria-describedby="tablePelunasanbbm_nominal"]`))
              });
          }, 100);
          setTotalSisaPelunasan()
          setTotalNominalPelunasan()
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
          let localRow = $("#tablePelunasanbbm").jqGrid("getLocalRow", rowId);

          $("#tablePelunasanbbm").jqGrid(
            "setCell",
            rowId,
            "sisa",
            parseInt(localRow.sisa) + parseInt(localRow.nominal)
          );

          return true;
        },
      });
    /* Append clear filter button */
    loadClearFilter($('#tablePelunasanbbm'))
  }

  $(document).on('click', '#resetdatafilter_tablePelunasanbbm', function(event) {
    selectedRowsPengembalian = $("#tablePelunasanbbm").getGridParam("selectedRowIds");
    $.each(selectedRowsPengembalian, function(index, value) {
      $('#tablePelunasanbbm').jqGrid('saveCell', value, 7); //emptycell
      $('#tablePelunasanbbm').jqGrid('saveCell', value, 5); //nominal
    })

  });
  $(document).on('click', '#gbox_tablePelunasanbbm .ui-jqgrid-hbox .ui-jqgrid-htable thead .ui-search-toolbar th td a.clearsearchclass', function(event) {
    selectedRowsPengembalian = $("#tablePelunasanbbm").getGridParam("selectedRowIds");
    $.each(selectedRowsPengembalian, function(index, value) {
      $('#tablePelunasanbbm').jqGrid('saveCell', value, 7); //emptycell
      $('#tablePelunasanbbm').jqGrid('saveCell', value, 5); //nominal
    })
  })

  function getDataPelunasanBBM(dari, sampai, id) {
    aksi = $('#crudForm').data('action')
    data = {}
    if (aksi == 'add') {
      urlBBM = `${apiUrl}pengeluarantruckingheader/getpelunasan`
    } else if (aksi == 'delete') {
      urlBBM = `${apiUrl}pengeluarantruckingheader/${id}/delete/geteditpelunasan`
      attribut = 'disabled'
      forCheckbox = 'disabled'
    } else {
      id = $('#crudForm').find(`[name=id]`).val()
      urlBBM = `${apiUrl}pengeluarantruckingheader/${id}/edit/geteditpelunasan`

    }

    return new Promise((resolve, reject) => {
      $.ajax({
        url: urlBBM,
        dataType: "JSON",
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          'tgldari': dari,
          'tglsampai': sampai,
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

  function checkboxPelunasanHandler(element, rowId) {

    let isChecked = $(element).is(":checked");
    let editableColumns = $("#tablePelunasanbbm").getGridParam("editableColumns");
    let selectedRowIds = $("#tablePelunasanbbm").getGridParam("selectedRowIds");
    let originalGridData = $("#tablePelunasanbbm")
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

        $("#tablePelunasanbbm").jqGrid(
          "setCell",
          rowId,
          "sisa",
          sisa
        );

        $("#tablePelunasanbbm").jqGrid("setCell", rowId, "nominal", 0);
        setTotalNominalPelunasan()
        setTotalSisaPelunasan()
      } else {
        selectedRowIds.push(rowId);

        let localRow = $("#tablePelunasanbbm").jqGrid("getLocalRow", rowId);

        if ($('#crudForm').data('action') == 'edit') {
          // if (originalGridData.sisa == 0) {

          //   let getNominal = $("#tablePelunasanbbm").jqGrid("getCell", rowId, "nominal")
          //   localRow.nominal = (getNominal != '') ? parseFloat(getNominal.replaceAll(',', '')) : 0
          // } else {
          //   localRow.nominal = originalGridData.sisa
          // }
          localRow.nominal = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal) + parseFloat(originalGridData.potongan))
        }

        initAutoNumeric($(`#tablePelunasanbbm tr#${rowId}`).find(`td[aria-describedby="tablePelunasanbbm_nominal"]`))
        setTotalNominalPelunasan()
        setTotalSisaPelunasan()
      }
    });

    $("#tablePelunasanbbm").jqGrid("setGridParam", {
      selectedRowIds: selectedRowIds,
    });

  }

  function setTotalNominalPelunasan() {
    let nominalDetails = $(`#tablePelunasanbbm`).find(`td[aria-describedby="tablePelunasanbbm_nominal"]`)
    let nominal = 0
    selectedRowsPinjaman = $("#tablePelunasanbbm").getGridParam("selectedRowIds");
    $.each(selectedRowsPinjaman, function(index, value) {
      dataPinjaman = $("#tablePelunasanbbm").jqGrid("getLocalRow", value);
      nominals = (dataPinjaman.nominal == undefined || dataPinjaman.nominal == '') ? 0 : dataPinjaman.nominal;
      getNominal = (isNaN(nominals)) ? parseFloat(nominals.replaceAll(',', '')) : parseFloat(nominals)
      nominal = nominal + getNominal
    })
    // $.each(nominalDetails, (index, nominalDetail) => {
    //   nominaldetail = parseFloat($(nominalDetail).text().replaceAll(',', ''))
    //   nominals = (isNaN(nominaldetail)) ? 0 : nominaldetail;
    //   nominal += nominals
    // });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasanbbm_nominal"]`).text(nominal))
  }

  function setTotalSisaPelunasan() {
    let sisaDetails = $(`#tablePelunasanbbm`).find(`td[aria-describedby="tablePelunasanbbm_sisa"]`)
    let sisa = 0
    let originalData = $("#tablePelunasanbbm").getGridParam("data");
    $.each(originalData, function(index, value) {
      sisas = value.sisa;
      sisas = (isNaN(sisas)) ? parseFloat(sisas.replaceAll(',', '')) : parseFloat(sisas)
      sisa += sisas

    })
    // $.each(sisaDetails, (index, sisaDetail) => {
    //   sisadetail = parseFloat($(sisaDetail).text().replaceAll(',', ''))
    //   sisas = (isNaN(sisadetail)) ? 0 : sisadetail;
    //   sisa += sisas
    // });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasanbbm_sisa"]`).text(sisa))
  }


  function clearSelectedRowsDeposito() {
    getSelectedRows = $("#tableDeposito").getGridParam("selectedRowIds");
    $("#tableDeposito")[0].p.selectedRowIds = [];
    $.each(getSelectedRows, function(index, value) {
      let originalGridData = $("#tableDeposito")
        .jqGrid("getGridParam", "originalData")
        .find((row) => row.id == value);

      sisa = 0
      if ($('#crudForm').data('action') == 'edit') {
        sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal))
      } else {
        sisa = originalGridData.sisa
      }

      $("#tableDeposito").jqGrid(
        "setCell",
        value,
        "sisa",
        sisa
      );
      $("#tableDeposito").jqGrid("setCell", value, "nominal", 0);
    })
    $('#tableDeposito').trigger('reloadGrid');
    setTotalNominalDeposito()
    setTotalSisaDeposito()
  }

  function selectAllRowsDeposito() {

    let originalData = $("#tableDeposito").getGridParam("data");
    let getSelectedRows = originalData.map((data) => data.id);
    $("#tableDeposito")[0].p.selectedRowIds = [];

    setTimeout(() => {
      $("#tableDeposito")
        .jqGrid("setGridParam", {
          selectedRowIds: getSelectedRows
        })
        .trigger("reloadGrid");

      setTotalNominalDeposito()
      setTotalSisaDeposito()
    })
  }


  function loadDepositoGrid() {

    let disabled = '';
    if ($('#crudForm').data('action') == 'delete') {
      disabled = 'disabled'
    }
    $("#tableDeposito")
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
                      selectAllRowsDeposito()
                    } else {
                      clearSelectedRowsDeposito()
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
              return `<input type="checkbox" class="checkbox-jqgrid" value="${rowData.id}" ${disabled} onChange="checkboxDepositoHandler(this, ${rowData.id})">`;
            },
          },
          {
            label: "id",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "Nobukti PENERIMAAN TRUCKING",
            name: "nobukti",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
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
                  if ($('#crudForm').data('action') == 'edit') {
                    totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)) - nominal
                  } else {
                    totalSisa = originalGridData.sisa - nominal
                  }

                  $("#tableDeposito").jqGrid(
                    "setCell",
                    rowObject.rowId,
                    "sisa",
                    totalSisa
                  );
                  if (totalSisa < 0) {
                    showDialog('sisa tidak boleh minus')
                    $("#tableDeposito").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "nominal",
                      0
                    );
                    if (originalGridData.sisa == 0) {
                      $("#tableDeposito").jqGrid("setCell", rowObject.rowId, "sisa", (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)));
                    } else {
                      if ($('#crudForm').data('action') == 'edit') {
                        $("#tableDeposito").jqGrid("setCell", rowObject.rowId, "sisa", (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)));
                      } else {
                        $("#tableDeposito").jqGrid("setCell", rowObject.rowId, "sisa", originalGridData.sisa);
                      }
                    }
                  }
                  // nominalDetails = $(`#tableDeposito tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tableDeposito_nominal"]`)
                  // ttlBayar = 0
                  // $.each(nominalDetails, (index, nominalDetail) => {
                  //   ttlBayarDetail = parseFloat($(nominalDetail).attr('title').replaceAll(',', ''))
                  //   ttlBayars = (isNaN(ttlBayarDetail)) ? 0 : ttlBayarDetail;
                  //   ttlBayar += ttlBayars
                  // });
                  // ttlBayar += nominal
                  // initAutoNumeric($('.footrow').find(`td[aria-describedby="tableDeposito_nominal"]`).text(ttlBayar))
                  setTotalNominalDeposito()
                  // setAllTotal()
                  setTotalSisaDeposito()
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
            editable: true,
            editoptions: {
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let localRow = $("#tableDeposito").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  localRow.keterangan = event.target.value;
                }
              }]
            },
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
          let originalGridData = $("#tableDeposito")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tableDeposito").jqGrid("getLocalRow", rowId);

          let getBayar = $("#tableDeposito").jqGrid("getCell", rowId, "nominal")
          let nominal = (getBayar != '') ? parseFloat(getBayar.replaceAll(',', '')) : 0

          sisa = 0
          if ($('#crudForm').data('action') == 'edit') {
            sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)) - nominal
          } else {
            sisa = originalGridData.sisa - nominal
          }
          if (indexColumn == 5) {

            $("#tableDeposito").jqGrid(
              "setCell",
              rowId,
              "sisa",
              sisa
              // sisa - nominal - potongan
            );
          }

          setTotalSisaDeposito()
          setTotalNominalDeposito()
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
                initAutoNumeric($(this).find(`td[aria-describedby="tableDeposito_nominal"]`))
              });
          }, 100);
          setTotalNominalDeposito()
          setTotalSisaDeposito()
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

          let originalGridData = $("#tableDeposito")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);
          let totalSisa
          if ($('#crudForm').data('action') == 'edit') {

            totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal))
          } else {
            totalSisa = parseFloat(originalGridData.sisa)
          }
          $("#tableDeposito").jqGrid(
            "setCell",
            rowId,
            "sisa",
            totalSisa
          );

          return true;
        },
      });
    /* Append clear filter button */
    loadClearFilter($('#tableDeposito'))

    /* Append global search */
    // loadGlobalSearch($('#tableDeposito'))
  }

  $(document).on('click', '#resetdatafilter_tableDeposito', function(event) {
    selectedRowsPengembalian = $("#tableDeposito").getGridParam("selectedRowIds");
    $.each(selectedRowsPengembalian, function(index, value) {
      $('#tableDeposito').jqGrid('saveCell', value, 7); //emptycell
      $('#tableDeposito').jqGrid('saveCell', value, 5); //nominal
      $('#tableDeposito').jqGrid('saveCell', value, 6); //keterangan
    })

  });
  $(document).on('click', '#gbox_tableDeposito .ui-jqgrid-hbox .ui-jqgrid-htable thead .ui-search-toolbar th td a.clearsearchclass', function(event) {
    selectedRowsPengembalian = $("#tableDeposito").getGridParam("selectedRowIds");
    $.each(selectedRowsPengembalian, function(index, value) {
      $('#tableDeposito').jqGrid('saveCell', value, 7); //emptycell
      $('#tableDeposito').jqGrid('saveCell', value, 5); //nominal
      $('#tableDeposito').jqGrid('saveCell', value, 6); //keterangan
    })
  })

  function getDataDeposito(supirId, id) {
    aksi = $('#crudForm').data('action')
    data = {}
    if (aksi == 'add') {
      url = `${apiUrl}pengeluarantruckingheader/getdeposito`
    } else if (aksi == 'delete') {
      url = `${apiUrl}pengeluarantruckingheader/${id}/delete/gettarikdeposito`
      attribut = 'disabled'
      forCheckbox = 'disabled'
    } else {
      console.log(id)
      if (id != undefined) {
        url = `${apiUrl}pengeluarantruckingheader/${id}/edit/gettarikdeposito`
      } else {
        url = `${apiUrl}pengeluarantruckingheader/getdeposito`
      }
    }

    return new Promise((resolve, reject) => {
      $.ajax({
        url: url,
        dataType: "JSON",
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          supir: supirId,
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

  function checkboxDepositoHandler(element, rowId) {

    let isChecked = $(element).is(":checked");
    let editableColumns = $("#tableDeposito").getGridParam("editableColumns");
    let selectedRowIds = $("#tableDeposito").getGridParam("selectedRowIds");
    let originalGridData = $("#tableDeposito")
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

        $("#tableDeposito").jqGrid(
          "setCell",
          rowId,
          "sisa",
          sisa
        );

        $("#tableDeposito").jqGrid("setCell", rowId, "nominal", 0);
        setTotalNominalDeposito()
        setTotalSisaDeposito()
      } else {
        selectedRowIds.push(rowId);

        // let localRow = $("#tableDeposito").jqGrid("getLocalRow", rowId);

        // if ($('#crudForm').data('action') == 'edit') {
        //   // if (originalGridData.sisa == 0) {

        //   //   let getNominal = $("#tableDeposito").jqGrid("getCell", rowId, "nominal")
        //   //   localRow.nominal = (getNominal != '') ? parseFloat(getNominal.replaceAll(',', '')) : 0
        //   // } else {
        //   //   localRow.nominal = originalGridData.sisa
        //   // }
        //   localRow.nominal = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)
        // }

        initAutoNumeric($(`#tableDeposito tr#${rowId}`).find(`td[aria-describedby="tableDeposito_nominal"]`))
        setTotalNominalDeposito()
        setTotalSisaDeposito()
      }
    });

    $("#tableDeposito").jqGrid("setGridParam", {
      selectedRowIds: selectedRowIds,
    });

  }

  function setTotalNominalDeposito() {
    let nominalDetails = $(`#tableDeposito`).find(`td[aria-describedby="tableDeposito_nominal"]`)
    let nominal = 0
    selectedRowsPinjaman = $("#tableDeposito").getGridParam("selectedRowIds");
    $.each(selectedRowsPinjaman, function(index, value) {
      dataPinjaman = $("#tableDeposito").jqGrid("getLocalRow", value);
      nominals = (dataPinjaman.nominal == undefined || dataPinjaman.nominal == '') ? 0 : dataPinjaman.nominal;
      console.log('dataPinjaman ', dataPinjaman.nominal)
      getNominal = (isNaN(nominals)) ? parseFloat(nominals.replaceAll(',', '')) : parseFloat(nominals)
      nominal = nominal + getNominal
    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableDeposito_nominal"]`).text(nominal))
  }

  function setTotalSisaDeposito() {
    let sisaDetails = $(`#tableDeposito`).find(`td[aria-describedby="tableDeposito_sisa"]`)
    let sisa = 0
    let originalData = $("#tableDeposito").getGridParam("data");
    $.each(originalData, function(index, value) {
      sisas = value.sisa;
      sisas = (isNaN(sisas)) ? parseFloat(sisas.replaceAll(',', '')) : parseFloat(sisas)
      sisa += sisas

    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableDeposito_sisa"]`).text(sisa))
  }



  function clearSelectedRowsDepositoKaryawan() {
    getSelectedRowsDepoKaryawan = $("#tableDepositoKaryawan").getGridParam("selectedRowIds");
    $("#tableDepositoKaryawan")[0].p.selectedRowIds = [];
    $.each(getSelectedRowsDepoKaryawan, function(index, value) {
      let originalGridData = $("#tableDepositoKaryawan")
        .jqGrid("getGridParam", "originalData")
        .find((row) => row.id == value);

      sisa = 0
      if ($('#crudForm').data('action') == 'edit') {
        sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal))
      } else {
        sisa = originalGridData.sisa
      }

      $("#tableDepositoKaryawan").jqGrid(
        "setCell",
        value,
        "sisa",
        sisa
      );
      $("#tableDepositoKaryawan").jqGrid("setCell", value, "nominal", 0);
    })
    $('#tableDepositoKaryawan').trigger('reloadGrid');
    setTotalNominalDepositoKaryawan()
    setTotalSisaDepositoKaryawan()
  }

  function selectAllRowsDepositoKaryawan() {

    let originalDataDepoKaryawan = $("#tableDepositoKaryawan").getGridParam("data");
    let getSelectedRowsDepoKaryawan = originalDataDepoKaryawan.map((data) => data.id);
    $("#tableDepositoKaryawan")[0].p.selectedRowIds = [];

    setTimeout(() => {
      $("#tableDepositoKaryawan")
        .jqGrid("setGridParam", {
          selectedRowIds: getSelectedRowsDepoKaryawan
        })
        .trigger("reloadGrid");

      setTotalNominalDepositoKaryawan()
      setTotalSisaDepositoKaryawan()
    })
  }


  function loadDepositoKaryawanGrid() {

    let disabled = '';
    if ($('#crudForm').data('action') == 'delete') {
      disabled = 'disabled'
    }
    $("#tableDepositoKaryawan")
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
                      selectAllRowsDepositoKaryawan()
                    } else {
                      clearSelectedRowsDepositoKaryawan()
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
              return `<input type="checkbox" class="checkbox-jqgrid" value="${rowData.id}" ${disabled} onChange="checkboxDepositoKaryawanHandler(this, ${rowData.id})">`;
            },
          },
          {
            label: "id",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "Nobukti PENERIMAAN TRUCKING",
            name: "nobukti",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
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
                  let originalGridData = $("#tableDepositoKaryawan")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tableDepositoKaryawan").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  localRow.nominal = event.target.value;
                  let totalSisa

                  let nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  if ($('#crudForm').data('action') == 'edit') {
                    totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)) - nominal
                  } else {
                    totalSisa = originalGridData.sisa - nominal
                  }

                  $("#tableDepositoKaryawan").jqGrid(
                    "setCell",
                    rowObject.rowId,
                    "sisa",
                    totalSisa
                  );
                  if (totalSisa < 0) {
                    showDialog('sisa tidak boleh minus')
                    $("#tableDepositoKaryawan").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "nominal",
                      0
                    );
                    if (originalGridData.sisa == 0) {
                      $("#tableDepositoKaryawan").jqGrid("setCell", rowObject.rowId, "sisa", (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)));
                    } else {
                      if ($('#crudForm').data('action') == 'edit') {
                        $("#tableDepositoKaryawan").jqGrid("setCell", rowObject.rowId, "sisa", (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)));
                      } else {
                        $("#tableDepositoKaryawan").jqGrid("setCell", rowObject.rowId, "sisa", originalGridData.sisa);
                      }
                    }
                  }
                  // nominalDetails = $(`#tableDepositoKaryawan tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tableDepositoKaryawan_nominal"]`)
                  // ttlBayar = 0
                  // $.each(nominalDetails, (index, nominalDetail) => {
                  //   ttlBayarDetail = parseFloat($(nominalDetail).attr('title').replaceAll(',', ''))
                  //   ttlBayars = (isNaN(ttlBayarDetail)) ? 0 : ttlBayarDetail;
                  //   ttlBayar += ttlBayars
                  // });
                  // ttlBayar += nominal
                  // initAutoNumeric($('.footrow').find(`td[aria-describedby="tableDepositoKaryawan_nominal"]`).text(ttlBayar))
                  setTotalNominalDepositoKaryawan()
                  // setAllTotal()
                  setTotalSisaDepositoKaryawan()
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
            editable: true,
            editoptions: {
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let localRow = $("#tableDepositoKaryawan").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  localRow.keterangan = event.target.value;
                }
              }]
            },
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
          let originalGridData = $("#tableDepositoKaryawan")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tableDepositoKaryawan").jqGrid("getLocalRow", rowId);

          let getBayar = $("#tableDepositoKaryawan").jqGrid("getCell", rowId, "nominal")
          let nominal = (getBayar != '') ? parseFloat(getBayar.replaceAll(',', '')) : 0

          sisa = 0
          if ($('#crudForm').data('action') == 'edit') {
            sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)) - nominal
          } else {
            sisa = originalGridData.sisa - nominal
          }
          if (indexColumn == 5) {

            $("#tableDepositoKaryawan").jqGrid(
              "setCell",
              rowId,
              "sisa",
              sisa
              // sisa - nominal - potongan
            );
          }

          setTotalSisaDepositoKaryawan()
          setTotalNominalDepositoKaryawan()
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
                initAutoNumeric($(this).find(`td[aria-describedby="tableDepositoKaryawan_nominal"]`))
              });
          }, 100);
          setTotalNominalDepositoKaryawan()
          setTotalSisaDepositoKaryawan()
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
          let localRow = $("#tableDepositoKaryawan").jqGrid("getLocalRow", rowId);

          let originalGridData = $("#tableDepositoKaryawan")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);
          let totalSisa
          if ($('#crudForm').data('action') == 'edit') {

            totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal))
          } else {
            totalSisa = parseFloat(originalGridData.sisa)
          }
          $("#tableDepositoKaryawan").jqGrid(
            "setCell",
            rowId,
            "sisa",
            totalSisa
          );
          return true;
        },
      });
    /* Append clear filter button */
    loadClearFilter($('#tableDepositoKaryawan'))

    /* Append global search */
    // loadGlobalSearch($('#tableDepositoKaryawan'))
  }

  $(document).on('click', '#resetdatafilter_tableDepositoKaryawan', function(event) {
    selectedRowsPengembalian = $("#tableDepositoKaryawan").getGridParam("selectedRowIds");
    $.each(selectedRowsPengembalian, function(index, value) {
      $('#tableDepositoKaryawan').jqGrid('saveCell', value, 7); //emptycell
      $('#tableDepositoKaryawan').jqGrid('saveCell', value, 5); //nominal
      $('#tableDepositoKaryawan').jqGrid('saveCell', value, 6); //keterangan
    })

  });
  $(document).on('click', '#gbox_tableDepositoKaryawan .ui-jqgrid-hbox .ui-jqgrid-htable thead .ui-search-toolbar th td a.clearsearchclass', function(event) {
    selectedRowsPengembalian = $("#tableDepositoKaryawan").getGridParam("selectedRowIds");
    $.each(selectedRowsPengembalian, function(index, value) {
      $('#tableDepositoKaryawan').jqGrid('saveCell', value, 7); //emptycell
      $('#tableDepositoKaryawan').jqGrid('saveCell', value, 5); //nominal
      $('#tableDepositoKaryawan').jqGrid('saveCell', value, 6); //keterangan
    })
  })

  function getDataDepositoKaryawan(karyawanId, id) {
    aksi = $('#crudForm').data('action')
    data = {}
    if (aksi == 'add') {
      url = `${apiUrl}pengeluarantruckingheader/getdepositokaryawan`
    } else if (aksi == 'delete') {
      url = `${apiUrl}pengeluarantruckingheader/${id}/delete/gettarikdepositokaryawan`
      attribut = 'disabled'
      forCheckbox = 'disabled'
    } else {
      console.log(id)
      if (id != undefined) {
        url = `${apiUrl}pengeluarantruckingheader/${id}/edit/gettarikdepositokaryawan`
      } else {
        url = `${apiUrl}pengeluarantruckingheader/getdepositokaryawan`
      }
    }

    return new Promise((resolve, reject) => {
      $.ajax({
        url: url,
        dataType: "JSON",
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          karyawan_id: karyawanId,
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

  function checkboxDepositoKaryawanHandler(element, rowId) {

    let isChecked = $(element).is(":checked");
    let editableColumnsDepoKaryawan = $("#tableDepositoKaryawan").getGridParam("editableColumns");
    let selectedRowDepoKaryawanIds = $("#tableDepositoKaryawan").getGridParam("selectedRowIds");
    let originalGridDataDepoKaryawan = $("#tableDepositoKaryawan")
      .jqGrid("getGridParam", "originalData")
      .find((row) => row.id == rowId);

    editableColumnsDepoKaryawan.forEach((editableColumn) => {

      if (!isChecked) {
        for (var i = 0; i < selectedRowDepoKaryawanIds.length; i++) {
          if (selectedRowDepoKaryawanIds[i] == rowId) {
            selectedRowDepoKaryawanIds.splice(i, 1);
          }
        }
        sisaDepoKaryawan = 0
        if ($('#crudForm').data('action') == 'edit') {
          sisaDepoKaryawan = (parseFloat(originalGridDataDepoKaryawan.sisa) + parseFloat(originalGridDataDepoKaryawan.nominal))
        } else {
          sisaDepoKaryawan = originalGridDataDepoKaryawan.sisa
        }

        $("#tableDepositoKaryawan").jqGrid(
          "setCell",
          rowId,
          "sisa",
          sisaDepoKaryawan
        );

        $("#tableDepositoKaryawan").jqGrid("setCell", rowId, "nominal", 0);
        setTotalNominalDepositoKaryawan()
        setTotalSisaDepositoKaryawan()
      } else {
        selectedRowDepoKaryawanIds.push(rowId);

        // let localRow = $("#tableDepositoKaryawan").jqGrid("getLocalRow", rowId);

        // if ($('#crudForm').data('action') == 'edit') {
        //   localRow.nominal = (parseFloat(originalGridDataDepoKaryawan.sisa) + parseFloat(originalGridDataDepoKaryawan.nominal))
        // }

        initAutoNumeric($(`#tableDepositoKaryawan tr#${rowId}`).find(`td[aria-describedby="tableDepositoKaryawan_nominal"]`))
        setTotalNominalDepositoKaryawan()
        setTotalSisaDepositoKaryawan()
      }
    });

    $("#tableDepositoKaryawan").jqGrid("setGridParam", {
      selectedRowIds: selectedRowDepoKaryawanIds,
    });

  }

  function setTotalNominalDepositoKaryawan() {
    let nominalDetails = $(`#tableDepositoKaryawan`).find(`td[aria-describedby="tableDepositoKaryawan_nominal"]`)
    let nominalDepoKaryawan = 0
    selectedRowsDepoKaryawan = $("#tableDepositoKaryawan").getGridParam("selectedRowIds");
    $.each(selectedRowsDepoKaryawan, function(index, value) {
      dataDepoKaryawan = $("#tableDepositoKaryawan").jqGrid("getLocalRow", value);
      nominalDepoKaryawans = (dataDepoKaryawan.nominal == undefined || dataDepoKaryawan.nominal == '') ? 0 : dataDepoKaryawan.nominal;
      getNominalDepoKaryawan = (isNaN(nominalDepoKaryawans)) ? parseFloat(nominalDepoKaryawans.replaceAll(',', '')) : parseFloat(nominalDepoKaryawans)
      nominalDepoKaryawan = nominalDepoKaryawan + getNominalDepoKaryawan
    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableDepositoKaryawan_nominal"]`).text(nominalDepoKaryawan))
  }

  function setTotalSisaDepositoKaryawan() {
    let sisaDetails = $(`#tableDepositoKaryawan`).find(`td[aria-describedby="tableDepositoKaryawan_sisa"]`)
    let sisaDepositoKaryawan = 0
    let originalData = $("#tableDepositoKaryawan").getGridParam("data");
    $.each(originalData, function(index, value) {
      sisaDepositoKaryawans = value.sisa;
      sisaDepositoKaryawans = (isNaN(sisaDepositoKaryawans)) ? parseFloat(sisaDepositoKaryawans.replaceAll(',', '')) : parseFloat(sisaDepositoKaryawans)
      sisaDepositoKaryawan += sisaDepositoKaryawans

    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableDepositoKaryawan_sisa"]`).text(sisaDepositoKaryawan))
  }

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}pengeluarantruckingheader/${Id}/cekvalidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      data: {
        aksi: Aksi
      },
      success: response => {
        var kodenobukti = response.kodenobukti
        var error = response.error
        if (error) {
          showDialog(response)
        } else {
          if (Aksi == 'PRINTER BESAR') {
            window.open(`{{ route('pengeluarantruckingheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
          } else if (Aksi == 'PRINTER KECIL') {
            window.open(`{{ route('pengeluarantruckingheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
          } else {
            cekValidasiAksi(Id, Aksi)
          }
        }
      }
    })
  }

  function cekValidasiAksi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}pengeluarantruckingheader/${Id}/cekValidasiAksi`,
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
            editPengeluaranTruckingHeader(Id)
          }
          if (Aksi == 'DELETE') {
            deletePengeluaranTruckingHeader(Id)
          }
        }

      }
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

  function showPengeluaranTruckingHeader(form, id) {
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')

      // form.find(`[name="tglbukti"]`).prop('readonly', true)
      // form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()

      $.ajax({
        url: `${apiUrl}pengeluarantruckingheader/${id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          let tgl = response.data.tglbukti
          let kodepengeluaran = response.data.kodepengeluaran

          KodePengeluaranId = kodepengeluaran
          console.log(kodepengeluaran)
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            if (element.is('select')) {
              // console.log(index);
              element.val(value)
              element.val(value).trigger('change')
            } else if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }

            if (kodepengeluaran === "TDE") {
              if (index == 'supirheader') {
                element.data('current-value', value).prop('readonly', true)
              }
            } else if (kodepengeluaran === "TDEK") {
              if (index == 'karyawanheader') {
                element.data('current-value', value).prop('readonly', true)
              }
            } else {
              if (index == 'supir') {
                element.data('current-value', value)
              }
            }

            if (index == 'periodedari') {
              form.find(`[name="tgldari"]`).val(dateFormat(value))
            }
            if (index == 'periodesampai') {
              form.find(`[name="tglsampai"]`).val(dateFormat(value))
            }
            if (index == 'periode') {
              form.find(`[name="periode"]`).val(dateFormat(value))
            }

            if (index == 'pengeluarantrucking') {
              element.data('current-value', value).prop('readonly', true)
              element.parent('.input-group').find('.button-clear').remove()
              element.parent('.input-group').find('.input-group-append').remove()
            }
            if (index == 'statusposting') {
              element.data('current-value', value).prop('disabled', true)
            }
            // if (index == 'postingpinjaman') {
            //   element.data('current-value', value).prop('disabled', true)
            // }
            if (index == 'bank') {
              element.data('current-value', value).prop('readonly', true)
              element.parent('.input-group').find('.button-clear').remove()
              element.parent('.input-group').find('.input-group-append').remove()
            }
            if (index == 'trado') {
              element.data('current-value', value)
            }
            if (index == 'agen') {
              element.data('current-value', value)
            }
            if (index == 'containerheader') {
              element.data('current-value', value)
            }
            if (index == 'gandengan') {
              element.data('current-value', value)
            }
            if (index == 'keterangancoa') {
              element.data('current-value', value)
            }
          })

          if (kodepengeluaran === "TDE") {
            getDataDeposito(response.data.supirheader_id, id).then((response) => {

              let selectedId = []
              let totalBayar = 0

              $.each(response.data, (index, value) => {
                if (value.pengeluarantruckingheader_id != null) {
                  selectedId.push(value.id)
                  totalBayar += parseFloat(value.nominal)
                }
              })
              $('#tableDeposito').jqGrid("clearGridData");
              setTimeout(() => {

                $("#tableDeposito")
                  .jqGrid("setGridParam", {
                    datatype: "local",
                    data: response.data,
                    originalData: response.data,
                    rowNum: response.data.length,
                    selectedRowIds: selectedId
                  })
                  .trigger("reloadGrid");
              }, 100);
              console.log(response.data)
              initAutoNumeric($('.footrow').find(`td[aria-describedby="tableDeposito_nominal"]`).text(totalBayar))

            });
          } else if (kodepengeluaran === "TDEK") {
            getDataDepositoKaryawan(response.data.karyawanheader_id, id).then((response) => {

              let selectedIdDepoKaryawan = []
              let totalBayarDepoKaryawan = 0

              $.each(response.data, (index, value) => {
                if (value.pengeluarantruckingheader_id != null) {
                  selectedIdDepoKaryawan.push(value.id)
                  totalBayarDepoKaryawan += parseFloat(value.nominal)
                }
              })
              $('#tableDepositoKaryawan').jqGrid("clearGridData");
              setTimeout(() => {

                $("#tableDepositoKaryawan")
                  .jqGrid("setGridParam", {
                    datatype: "local",
                    data: response.data,
                    originalData: response.data,
                    rowNum: response.data.length,
                    selectedRowIds: selectedIdDepoKaryawan
                  })
                  .trigger("reloadGrid");
              }, 100);
              console.log(response.data)
              initAutoNumeric($('.footrow').find(`td[aria-describedby="tableDepositoKaryawan_nominal"]`).text(totalBayarDepoKaryawan))

            });
          } else if (kodepengeluaran === "BST") {
            $('#detailList tbody').html('')
            $.each(response.detail, (index, detail) => {
              if (detail.pengeluarantrucking_id != null) {
                selectedRowsSumbangan.push(detail.id_detail)
                selectedRowsSumbanganContainer.push(detail.container_detail)
                selectedRowsSumbanganJobtrucking.push(detail.nojobtrucking_detail)
                selectedRowsSumbanganNobukti.push(detail.noinvoice_detail)
                selectedRowsSumbanganNominal.push(detail.nominal_detail)
              }
            })
            // $('#tableSumbangan').jqGrid("clearGridData");
            setTimeout(() => {
              $('#tableSumbangan').jqGrid('setGridParam', {
                url: `${apiUrl}pengeluarantruckingheader/${id}/geteditinvoice`,
                postData: {
                  tgldari: $('#crudForm').find('[name=tgldari]').val(),
                  tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
                  aksi: 'show'
                },
                datatype: "json"
              }).trigger('reloadGrid');
            }, 100);

          } else if (kodepengeluaran === "OTOK") {
            $('#detailList tbody').html('')
            $.each(response.detail, (index, detail) => {
              if (detail.pengeluarantrucking_id != null) {
                selectedRowsOtok.push(detail.id_detail)
                selectedRowsOtokJobtrucking.push(detail.nojobtrucking_detail)
                selectedRowsOtokNobukti.push(detail.noinvoice_detail)
                selectedRowsOtokNominal.push(detail.nominal_detail)
              }
            })
            // $('#tableSumbangan').jqGrid("clearGridData");
            setTimeout(() => {
              $('#tableOTOK').jqGrid('setGridParam', {
                url: `${apiUrl}pengeluarantruckingheader/${id}/geteditotok`,
                postData: {
                  tgldari: $('#crudForm').find('[name=tgldari]').val(),
                  tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
                  agen_id: $('#crudForm').find('[name=agen_id]').val(),
                  container_id: $('#crudForm').find('[name=containerheader_id]').val(),
                  aksi: 'show'
                },
                datatype: "json"
              }).trigger('reloadGrid');
            }, 100);

          } else if (kodepengeluaran === "OTOL") {
            $('#detailList tbody').html('')
            $.each(response.detail, (index, detail) => {
              if (detail.pengeluarantrucking_id != null) {
                selectedRowsOtol.push(detail.id_detail)
                selectedRowsOtolJobtrucking.push(detail.nojobtrucking_detail)
                selectedRowsOtolNobukti.push(detail.noinvoice_detail)
                selectedRowsOtolNominal.push(detail.nominal_detail)
              }
            })
            // $('#tableSumbangan').jqGrid("clearGridData");
            setTimeout(() => {
              $('#tableOTOL').jqGrid('setGridParam', {
                url: `${apiUrl}pengeluarantruckingheader/${id}/geteditotol`,
                postData: {
                  tgldari: $('#crudForm').find('[name=tgldari]').val(),
                  tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
                  agen_id: $('#crudForm').find('[name=agen_id]').val(),
                  container_id: $('#crudForm').find('[name=containerheader_id]').val(),
                  aksi: 'show'
                },
                datatype: "json"
              }).trigger('reloadGrid');
            }, 100);

          } else if (kodepengeluaran === "KBBM") {

            getDataPelunasanBBM(response.data.tgldari, response.data.tglsampai, id).then((response) => {

              let selectedId = []
              let totalBayar = 0

              $.each(response.data, (index, value) => {
                if (value.pengeluarantruckingheader_id != null) {
                  selectedId.push(value.id)
                  totalBayar += parseFloat(value.nominal)
                }
              })
              $('#tablePelunasanbbm').jqGrid("clearGridData");
              setTimeout(() => {

                $("#tablePelunasanbbm")
                  .jqGrid("setGridParam", {
                    datatype: "local",
                    data: response.data,
                    originalData: response.data,
                    rowNum: response.data.length,
                    selectedRowIds: selectedId
                  })
                  .trigger("reloadGrid");
              }, 100);
              console.log(response.data)
              initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasanbbm_nominal"]`).text(totalBayar))

            });

          } else if (kodepengeluaran === "BLL") {

            getDataBiayaLapangan().then((response) => {

              let selectedIdBll = []
              let totalBiaya = 0

              $.each(response.data, (index, value) => {
                selectedIdBll.push(value.id)
                if (value.nominal != null && value.nominal != '' && value.nominal != 'null') {
                  totalBiaya += parseFloat(value.nominal)
                }
              })
              $('#tableBLL').jqGrid("clearGridData");
              setTimeout(() => {

                $("#tableBLL")
                  .jqGrid("setGridParam", {
                    datatype: "local",
                    data: response.data,
                    originalData: response.data,
                    rowNum: response.data.length,
                    selectedRowIds: selectedIdBll
                  })
                  .trigger("reloadGrid");
                initAutoNumeric($('#tableBLL tbody tr').find(`td[aria-describedby="tableBLL_nominal"]`))
              }, 100);
              initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBLL_nominal"]`).text(totalBiaya))

            });

          } else if (kodepengeluaran === "BLN") {

            getDataBiayaLapangan().then((response) => {

              let selectedIdBln = []
              let totalBiaya = 0

              $.each(response.data, (index, value) => {
                selectedIdBln.push(value.id)
                if (value.nominal != null && value.nominal != '' && value.nominal != 'null') {
                  totalBiaya += parseFloat(value.nominal)
                }
              })
              $('#tableBLN').jqGrid("clearGridData");
              setTimeout(() => {

                $("#tableBLN")
                  .jqGrid("setGridParam", {
                    datatype: "local",
                    data: response.data,
                    originalData: response.data,
                    rowNum: response.data.length,
                    selectedRowIds: selectedIdBln
                  })
                  .trigger("reloadGrid");
                initAutoNumeric($('#tableBLN tbody tr').find(`td[aria-describedby="tableBLN_nominal"]`))
              }, 100);
              initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBLN_nominal"]`).text(totalBiaya))

            });

          } else if (kodepengeluaran === "BTU") {

            getDataBiayaLapangan().then((response) => {

              let selectedIdBtu = []
              let totalBiaya = 0

              $.each(response.data, (index, value) => {
                selectedIdBtu.push(value.id)
                if (value.nominal != null && value.nominal != '' && value.nominal != 'null') {
                  totalBiaya += parseFloat(value.nominal)
                }
              })
              $('#tableBTU').jqGrid("clearGridData");
              setTimeout(() => {

                $("#tableBTU")
                  .jqGrid("setGridParam", {
                    datatype: "local",
                    data: response.data,
                    originalData: response.data,
                    rowNum: response.data.length,
                    selectedRowIds: selectedIdBtu
                  })
                  .trigger("reloadGrid");
                initAutoNumeric($('#tableBTU tbody tr').find(`td[aria-describedby="tableBTU_nominal"]`))
              }, 100);
              initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBTU_nominal"]`).text(totalBiaya))

            });

          } else if (kodepengeluaran === "BTT") {

            getDataBiayaLapangan().then((response) => {

              let selectedIdBtt = []
              let totalBiaya = 0

              $.each(response.data, (index, value) => {
                selectedIdBtt.push(value.id)
                if (value.nominal != null && value.nominal != '' && value.nominal != 'null') {
                  totalBiaya += parseFloat(value.nominal)
                }
              })
              $('#tableBTT').jqGrid("clearGridData");
              setTimeout(() => {

                $("#tableBTT")
                  .jqGrid("setGridParam", {
                    datatype: "local",
                    data: response.data,
                    originalData: response.data,
                    rowNum: response.data.length,
                    selectedRowIds: selectedIdBtt
                  })
                  .trigger("reloadGrid");
                initAutoNumeric($('#tableBTT tbody tr').find(`td[aria-describedby="tableBTT_nominal"]`))
              }, 100);
              initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBTT_nominal"]`).text(totalBiaya))

            });

          } else if (kodepengeluaran === "BPT") {

            getDataBiayaLapangan().then((response) => {

              let selectedIdBpt = []
              let totalBiaya = 0

              $.each(response.data, (index, value) => {
                selectedIdBpt.push(value.id)
                if (value.nominal != null && value.nominal != '' && value.nominal != 'null') {
                  totalBiaya += parseFloat(value.nominal)
                }
              })
              $('#tableBPT').jqGrid("clearGridData");
              setTimeout(() => {

                $("#tableBPT")
                  .jqGrid("setGridParam", {
                    datatype: "local",
                    data: response.data,
                    originalData: response.data,
                    rowNum: response.data.length,
                    selectedRowIds: selectedIdBpt
                  })
                  .trigger("reloadGrid");
                initAutoNumeric($('#tableBPT tbody tr').find(`td[aria-describedby="tableBPT_nominal"]`))
              }, 100);
              initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBPT_nominal"]`).text(totalBiaya))

            });

          } else if (kodepengeluaran === "BGS") {

            getDataBiayaLapangan().then((response) => {

              let selectedIdBgs = []
              let totalBiaya = 0

              $.each(response.data, (index, value) => {
                selectedIdBgs.push(value.id)
                if (value.nominal != null && value.nominal != '' && value.nominal != 'null') {
                  totalBiaya += parseFloat(value.nominal)
                }
              })
              $('#tableBGS').jqGrid("clearGridData");
              setTimeout(() => {

                $("#tableBGS")
                  .jqGrid("setGridParam", {
                    datatype: "local",
                    data: response.data,
                    originalData: response.data,
                    rowNum: response.data.length,
                    selectedRowIds: selectedIdBgs
                  })
                  .trigger("reloadGrid");
                initAutoNumeric($('#tableBGS tbody tr').find(`td[aria-describedby="tableBGS_nominal"]`))
              }, 100);
              initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBGS_nominal"]`).text(totalBiaya))

            });

          } else if (kodepengeluaran === "BIT") {

            getDataBiayaLapangan().then((response) => {

              let selectedIdBit = []
              let totalBiaya = 0

              $.each(response.data, (index, value) => {
                selectedIdBit.push(value.id)
                if (value.nominal != null && value.nominal != '' && value.nominal != 'null') {
                  totalBiaya += parseFloat(value.nominal)
                }
              })
              $('#tableBIT').jqGrid("clearGridData");
              setTimeout(() => {

                $("#tableBIT")
                  .jqGrid("setGridParam", {
                    datatype: "local",
                    data: response.data,
                    originalData: response.data,
                    rowNum: response.data.length,
                    selectedRowIds: selectedIdBit
                  })
                  .trigger("reloadGrid");
                initAutoNumeric($('#tableBIT tbody tr').find(`td[aria-describedby="tableBIT_nominal"]`))
              }, 100);
              initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBIT_nominal"]`).text(totalBiaya))

            });

          } else if (kodepengeluaran === "BSM" || kodepengeluaran === "BLS" || KodePengeluaranId == "BTK" || KodePengeluaranId == "BTB") {

            getDataBiayaLapangan().then((response) => {

              let selectedIdBsm = []
              let totalBiaya = 0

              $.each(response.data, (index, value) => {
                selectedIdBsm.push(value.id)
                if (value.nominal != null && value.nominal != '' && value.nominal != 'null') {
                  totalBiaya += parseFloat(value.nominal)
                }
              })
              $('#tableBSM').jqGrid("clearGridData");
              setTimeout(() => {

                $("#tableBSM")
                  .jqGrid("setGridParam", {
                    datatype: "local",
                    data: response.data,
                    originalData: response.data,
                    rowNum: response.data.length,
                    selectedRowIds: selectedIdBsm
                  })
                  .trigger("reloadGrid");
                initAutoNumeric($('#tableBSM tbody tr').find(`td[aria-describedby="tableBSM_nominal"]`))
              }, 100);
              initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBSM_nominal"]`).text(totalBiaya))

            });

          } else {
            $('#detailList tbody').html('')
            $.each(response.detail, (index, detail) => {
              let pengeluaranstokheader;
              let detailRow = $(`
                <tr>
                    <td></td>
                    <td class="data_tbl tbl_supir_id">
                        <input type="hidden" id="supir_id_${index}" name="supir_id[]">
                        <input type="text" id="supir_${index}" name="supir[]" data-current-value="${detail.supir}" class="form-control supir-lookup">
                    </td>
                    <td class="data_tbl tbl_karyawan_id">
                        <input type="hidden" id="karyawan_id_${index}" name="karyawan_id[]">
                        <input type="text" id="karyawan_${index}" name="karyawan[]" data-current-value="${detail.karyawan}" class="form-control karyawan-lookup">
                    </td>
                    <td class="data_tbl tbl_pengeluaranstokheader_nobukti">
                      <input type="text" id="pengeluaranstok_nobukti_${index}" name="pengeluaranstok_nobukti[]" data-current-value="${detail.pengeluaranstok_nobukti}" class="form-control pengeluaranstokheader-lookup">
                    </td>
                    
                    <td class="data_tbl tbl_penerimaanstokheader_nobukti tbl_tagihklaim">
                      <input id="penerimaanstok_nobukti_${index}" type="text" name="penerimaanstok_nobukti[]" data-current-value="${detail.penerimaanstok_nobukti}" class="form-control penerimaanstokheader-lookup">
                    </td>
                    <td class="data_tbl tbl_statustitipanemkl kolom_bbt">
                      <select name="detail_statustitipanemkl[]" class="form-select select2bs4" id="statustitipanemkl${index}" style="width: 100%;">
                        <option value="">-- PILIH TITIPAN EMKL --</option>
                      </select>     
                    </td>
                    <td class="data_tbl tbl_suratpengantar_nobukti kolom_bbt">
                      <input id="suratpengantar_nobukti_${index}" type="text" name="suratpengantar_nobukti[]"  data-current-value="${detail.suratpengantar_nobukti}" class="form-control suratpengantar-lookup">
                    </td>
                    <td class="data_tbl tbl_trado_id kolom_bbt">
                      <input id="trado_id_${index}" type="text" name="trado_id[]"  class="form-control">
                    </td>
                    <td class="data_tbl tbl_container_id kolom_bbt">
                      <input id="container_id_${index}" type="text" name="container_id[]"  class="form-control">
                    </td>
                    <td class="data_tbl tbl_pelanggan_id kolom_bbt">
                      <input id="pelanggan_id_${index}" type="text" name="pelanggan_id[]"  class="form-control">
                    </td>  

                    <td class="data_tbl tbl_stok_id">
                      <input type="hidden" id="stok_id_${index}" name="stok_id[]">
                      <input type="text" id="stok_${index}" name="stok[]" data-current-value="${detail.stok}" class="form-control stok-lookup">
                    </td>
                    <td class="data_tbl tbl_qty">
                      <input type="text" id="qty_${index}" name="qty[]" class="form-control autonumeric qty"> 
                    </td>

                    <td class="data_tbl tbl_penerimaantruckingheader">
                        <input type="text" id="penerimaantruckingheader_nobukti_${index}" name="penerimaantruckingheader_nobukti[]" data-current-value="${detail.penerimaantruckingheader_nobukti}" class="form-control penerimaantruckingheader-lookup">
                    </td>
                    <td class="data_tbl tbl_harga">
                    
                      <input id="totalharga_${indexRow}" readonly type="text" name="totalharga[]" class="form-control autonumeric"> 
                      <input type="hidden" id="harga_${index}" name="harga[]" class="form-control autonumeric nominal"> 
                    </td>
                    <td class="data_tbl tbl_nominal">
                        <input type="text" id="nominal_${index}" name="nominal[]" class="form-control autonumeric nominal" autocomplete="off"> 
                    </td>
                    <td class="data_tbl tbl_nominaltagih kolom_bbt">
                      <input id="nominaltagih_${index}" type="text" name="nominaltagih[]" readonly class="form-control autonumeric nominaltagih"> 
                    </td>
                    <td class="data_tbl tbl_keterangan">
                        <input type="text" id="keterangan_${index}" name="keterangan[]" class="form-control"> 
                    </td>
        
                    <td class="data_tbl tbl_tagihklaim">
                      <input id="nominaltambahan_${index}" type="text" name="nominaltambahan[]" class="form-control autonumeric text-right nominaltambahan"> 
                    </td>
                    <td class="data_tbl tbl_tagihklaim">
                      <input id="keterangantambahan_${index}" type="text" name="keterangantambahan[]" class="form-control"> 
                    </td>
                    <td class="data_tbl tbl_jenisorder kolom_bbt">
                      <input id="jenisorder_${index}" type="text" name="jenisorder_id[]" class="form-control"> 
                    </td>
                    <td class="data_tbl tbl_tagihklaim">
                      <input id="totalklaim_${index}" type="text" name="totalklaim[]" readonly class="form-control text-right totalklaim"> 
                    </td>
                    <td class="tbl_aksi">
                        <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                    </td>
                </tr>
              `)
              // let qtyNumeric = new AutoNumeric(detailRow.find(`[name="qty[]"]`))
              detailRow.find(`[name="supir_id[]"]`).val(detail.supir_id)
              detailRow.find(`[name="supir[]"]`).val(detail.supir)
              detailRow.find(`[name="karyawan_id[]"]`).val(detail.karyawan_id)
              detailRow.find(`[name="karyawan[]"]`).val(detail.karyawan)
              detailRow.find(`[name="pengeluaranstok_nobukti[]"]`).val(detail.pengeluaranstok_nobukti)
              detailRow.find(`[name="penerimaanstok_nobukti[]"]`).val(detail.penerimaanstok_nobukti)
              detailRow.find(`[name="stok_id[]"]`).val(detail.stok_id)
              detailRow.find(`[name="stok[]"]`).val(detail.stok)
              detailRow.find(`[name="qty[]"]`).val(detail.qty)
              detailRow.find(`[name="harga[]"]`).val(detail.harga)
              detailRow.find(`[name="totalharga[]"]`).val(detail.total)
              detailRow.find(`[name="keterangan[]"]`).val(detail.keterangan)
              detailRow.find(`[name="suratpengantar_nobukti[]"]`).val(detail.suratpengantar_nobukti)
              detailRow.find(`[name="trado_id[]"]`).val(detail.trado_id)
              detailRow.find(`[name="container_id[]"]`).val(detail.container_id)
              detailRow.find(`[name="pelanggan_id[]"]`).val(detail.pelanggan_id)
              detailRow.find(`[name="jenisorder_id[]"]`).val(response.data.jenisorderan)
              detailRow.find(`[name="penerimaantruckingheader_nobukti[]"]`).val(detail.penerimaantruckingheader_nobukti)
              if (kodepengeluaran === "KLAIM") {
                detailRow.find(`[name="nominal[]"]`).val(detail.nominaltagih)
              } else {
                detailRow.find(`[name="nominal[]"]`).val(detail.nominal)
              }
              detailRow.find(`[name="nominaltagih[]"]`).val(detail.nominaltagih)
              detailRow.find(`[name="nominaltambahan[]"]`).val(detail.nominaltambahan)
              detailRow.find(`[name="keterangantambahan[]"]`).val(detail.keterangantambahan)
              detailRow.find(`[name="totalklaim[]"]`).val(detail.nominal)

              pengeluaranstokheader = detail.pengeluaranstokheader_id
              penerimaanstokheader = detail.penerimaanstokheader_id
              penerimaanstokheader_nobukti = detail.penerimaanstok_nobukti
              if (detail.pengeluaranstok_nobukti) {
                initAutoNumeric(detailRow.find(`[name="qty[]"]`))
                initAutoNumeric(detailRow.find(`[name="totalharga[]"]`))
                // initAutoNumeric(detailRow.find(`[name="qty[]"]`),{'maximumValue':detail.maxqty})
                initAutoNumeric(detailRow.find(`[name="harga[]"]`))
              }
              if (detail.penerimaanstok_nobukti) {
                initAutoNumeric(detailRow.find(`[name="qty[]"]`))
                initAutoNumeric(detailRow.find(`[name="totalharga[]"]`))
                // initAutoNumeric(detailRow.find(`[name="qty[]"]`),{'maximumValue':detail.maxqty})
                initAutoNumeric(detailRow.find(`[name="harga[]"]`))
              }
              if (detail.suratpengantar_nobukti) {
                initAutoNumeric(detailRow.find(`[name="nominaltagih[]"]`))
                detailRow.find(`[name="suratpengantar_nobukti[]"]`).data('current-value', detail.suratpengantar_nobukti)
                detailRow.find(`[name="trado_id[]"]`).prop('readonly', true)
                detailRow.find(`[name="container_id[]"]`).prop('readonly', true)
                detailRow.find(`[name="pelanggan_id[]"]`).prop('readonly', true)
                detailRow.find(`[name="jenisorder_id[]"]`).prop('readonly', true)

              }

              initAutoNumeric(detailRow.find(`[name="nominal[]"]`))
              initAutoNumeric(detailRow.find(`[name="nominaltambahan[]"]`))
              initAutoNumeric(detailRow.find(`[name="totalklaim[]"]`))
              $('#detailList tbody').append(detailRow)

              if (response.data.kodepengeluaran == 'BBT') {
                initSelect2($(`#statustitipanemkl${index}`), true)
                dataStatusBiaya.forEach(statusBiaya => {
                  let option = new Option(statusBiaya.text, statusBiaya.id)

                  detailRow.find(`#statustitipanemkl${index}`).append(option).trigger('change')
                });
                detailRow.find(`[name="detail_statustitipanemkl[]"]`).val(detail.statustitipanemkl).trigger('change')

              }

              setTotal();
              if (kodepengeluaran === "KLAIM") {
                setTotalKlaim()
                setTotalTambahan()
              }
              $('.supir-lookup').last().lookup({
                title: 'Supir Lookup',
                fileName: 'supir',
                beforeProcess: function(test) {
                  // var levelcoa = $(`#levelcoa`).val();
                  this.postData = {
                    Aktif: 'AKTIF',
                  }
                },
                onSelectRow: (supir, element) => {
                  element.parents('td').find(`[name="supir_id[]"]`).val(supir.id)
                  element.val(supir.namasupir)
                  element.data('currentValue', element.val())
                  if (KodePengeluaranId == 'PJT') {
                    element.parents('tr').find(`td [name="keterangan[]"]`).val("PINJAMAN SUPIR " + supir.namasupir)
                  }
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
              $('.karyawan-lookup').last().lookup({
                title: 'karyawan Lookup',
                fileName: 'karyawan',
                beforeProcess: function(test) {
                  // var levelcoa = $(`#levelcoa`).val();
                  this.postData = {
                    Aktif: 'AKTIF',
                  }
                },
                onSelectRow: (karyawan, element) => {
                  element.parents('td').find(`[name="karyawan_id[]"]`).val(karyawan.id)
                  element.val(karyawan.namakaryawan)
                  element.data('currentValue', element.val())
                  if (KodePengeluaranId == 'PJK') {
                    element.parents('tr').find(`td [name="keterangan[]"]`).val("PINJAMAN KARYAWAN " + karyawan.namakaryawan)
                  }
                },
                onCancel: (element) => {
                  element.val(element.data('currentValue'))
                },
                onClear: (element) => {
                  element.parents('td').find(`[name="karyawan_id[]"]`).val('')
                  element.val('')
                  element.data('currentValue', element.val())
                }
              })

              $('.pengeluaranstokheader-lookup').last().lookup({
                title: 'pengeluaran stok Lookup',
                fileName: 'pengeluaranstokheader',
                beforeProcess: function(test) {
                  // var levelcoa = $(`#levelcoa`).val();
                  this.postData = {
                    cabang: statuscabang,
                    pengeluaranheader_id: 1,
                    Aktif: 'AKTIF',
                    url: urlTNL,
                    token: tokenTNL,
                    from: 'klaim',
                    aksi: $('#crudForm').data('action'),
                    pengeluarantrucking_id: $('#crudForm').find(`[name="id"]`).val()
                  }
                },
                onSelectRow: (stok, element) => {
                  pengeluaranstokheader = stok.id
                  element.val(stok.nobukti)

                  lookupSelectedSpkPG(index, 'SPK')
                  element.data('currentValue', element.val())
                },
                onCancel: (element) => {
                  element.val(element.data('currentValue'))
                },
                onClear: (element) => {
                  detailRow.find(`[name="stok_id[]"]`).val('');
                  detailRow.find(`[name="stok[]"]`).val('');
                  detailRow.find(`[name="stok[]"]`).data('currentValue', element.val(''))

                  // detailRow.find(`[name="harga[]"]`).val('');
                  detailRow.find(`[name="qty[]"]`).val('');

                  detailRow.find(`[name="nominal[]"]`).val('');
                  setTotal();
                  // element.parents('td').find(`[name="stok_id[]"]`).val('')
                  element.val('')
                  element.data('currentValue', element.val())
                  enabledLookupSpkPG(row)
                }
              })
              $('.penerimaanstokheader-lookup').last().lookup({
                title: 'penerimaan stok Lookup',
                fileName: 'penerimaanstokheader',
                beforeProcess: function(test) {
                  // var levelcoa = $(`#levelcoa`).val();
                  this.postData = {
                    cabang: statuscabang,
                    penerimaanstok_id: 5,
                    Aktif: 'AKTIF',
                    url: urlTNL,
                    token: tokenTNL,
                    from: 'klaim',
                    pengeluarantrucking_id: $('#crudForm').find(`[name="id"]`).val()
                  }
                },
                onSelectRow: (stok, element) => {
                  penerimaanstokheader = stok.id
                  penerimaanstokheader_nobukti = stok.nobukti
                  element.val(stok.nobukti)

                  lookupSelectedSpkPG(index, 'PG')
                  element.data('currentValue', element.val())
                },
                onCancel: (element) => {
                  element.val(element.data('currentValue'))
                },
                onClear: (element) => {
                  detailRow.find(`[name="stok_id[]"]`).val('');
                  detailRow.find(`[name="stok[]"]`).val('');
                  detailRow.find(`[name="stok[]"]`).data('currentValue', element.val(''))

                  // detailRow.find(`[name="harga[]"]`).val('');
                  detailRow.find(`[name="qty[]"]`).val('');

                  detailRow.find(`[name="nominal[]"]`).val('');
                  setTotal();
                  // element.parents('td').find(`[name="stok_id[]"]`).val('')
                  element.val('')
                  element.data('currentValue', element.val())
                  enabledLookupSpkPG(row)
                }
              })
              $('.stok-lookup').last().lookup({
                title: 'stok Lookup',
                fileName: 'pengeluaranstokdetail',
                beforeProcess: function(test) {
                  console.log(detail.penerimaanstokheader_nobukti, '5686');
                  // var levelcoa = $(`#levelcoa`).val();
                  this.postData = {
                    cabang: statuscabang,
                    url: urlTNL,
                    token: tokenTNL,
                    penerimaanstokheader_id: detail.penerimaanstokheader_id,
                    penerimaanstokheader_nobukti: detail.penerimaanstokheader_nobukti,
                    pengeluaranstokheader_id: detail.pengeluaranstokheader_id,
                    from: 'klaim',
                    stok_id: detail.stok_id
                  }
                },
                onSelectRow: (stok, element) => {
                  element.parents('td').find(`[name="stok_id[]"]`).val(stok.stok_id)
                  element.val(stok.stok)
                  element.data('currentValue', element.val())
                  console.log(stok.qty);
                  detailRow.find(`[name="qty[]"]`).val(stok.qty);
                  detailRow.find(`[name="harga[]"]`).val(stok.harga);
                  // new AutoNumeric(detailRow.find(`[name="qty[]"]`),{'maximumValue':stok.qty})
                  initAutoNumeric(detailRow.find(`[name="harga[]"]`))
                  // initAutoNumeric(detailRow.find(`[name="qty[]"]`),{'maximumValue':detail.maxqty})
                  totalharga = parseFloat(stok.qty.replace(/,/g, '')) * parseFloat(stok.harga.replace(/,/g, ''));
                  new AutoNumeric(element.parents("tr").find(`[name="totalharga[]"]`)[0]).set(totalharga)




                },
                onCancel: (element) => {
                  element.val(element.data('currentValue'))
                },
                onClear: (element) => {
                  detailRow.find(`[name="harga[]"]`).val('');
                  detailRow.find(`[name="qty[]"]`).val('');
                  // console.log(detailRow.find(`[name="qty[]"]`));
                  detailRow.find(`[name="nominal[]"]`).val('');
                  // initAutoNumeric(detailRow.find(`[name="qty[]"]`))

                  setTotal();
                  element.parents('td').find(`[name="stok_id[]"]`).val('')
                  element.val('')
                  element.data('currentValue', element.val())
                }
              })

              $('.penerimaantruckingheader-lookup').last().lookup({
                title: 'Penerimaan Trucking Lookup',
                fileName: 'penerimaantruckingheader',
                beforeProcess: function(test) {
                  // var levelcoa = $(`#levelcoa`).val();
                  this.postData = {
                    // penerimaanheader_id : $('#pengeluaranheader_id').val(),
                    // penerimaanheader_id : 1,
                    Aktif: 'AKTIF',
                  }
                },
                onSelectRow: (penerimaantruckingheader, element) => {
                  element.val(penerimaantruckingheader.nobukti)
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

              $('.suratpengantar-lookup').last().lookup({
                title: 'surat pengantar Lookup',
                fileName: 'suratpengantar',
                beforeProcess: function(test) {
                  // console.log(index);
                  // var levelcoa = $(`#levelcoa`).val();
                  this.postData = {
                    pengeluarantruckingheader: KodePengeluaranId,
                    jenisorder_id: $('[name=jenisorderan_id]').val(),
                    Aktif: 'AKTIF',
                  }
                },
                onSelectRow: (suratpengantar, element) => {
                  element.val(suratpengantar.nobukti)
                  element.parents('td').find(`[name="suratpengantar_id[]"]`).val(suratpengantar.id)
                  element.parents('tr').find(`[name="trado_id[]"]`).val(suratpengantar.trado_id)
                  element.parents('tr').find(`[name="container_id[]"]`).val(suratpengantar.container_id)
                  element.parents('tr').find(`[name="pelanggan_id[]"]`).val(suratpengantar.pelanggan_id)
                  element.parents('tr').find(`[name="jenisorder_id[]"]`).val(suratpengantar.jenisorder_id)

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

              if (kodepengeluaran === "KLAIM") {
                detailRow.find(`[name="nominal[]"]`).val(detail.nominaltagih)
                if (detail.pengeluaranstok_nobukti) {
                  lookupSelectedSpkPG(index, 'SPK')
                } else if (detail.penerimaanstok_nobukti) {
                  lookupSelectedSpkPG(index, 'PG')
                }
              }
              indexRow = index
            })

          }
          indexRow += 1
          setTampilanForm()
          setRowNumbers()
          if (form.data('action') === 'delete') {
            form.find(`[name="tgldari"]`).prop('readonly', true)
            form.find(`[name="tgldari"]`).parent('.input-group').find('.input-group-append').remove()
            form.find(`[name="tglsampai"]`).prop('readonly', true)
            form.find(`[name="tglsampai"]`).parent('.input-group').find('.input-group-append').remove()
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

  function setTotalDP() {
    let nominalDetails = $(`#table_body [name="nominalDP[]"]:not([disabled])`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)

  }

  function getEditSumbangan(id) {
    aksi = $('#crudForm').data('action')

    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}pengeluarantruckingheader/${id}/geteditinvoice`,
        dataType: "JSON",
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          tgldari: $('#crudForm').find('[name=tgldari]').val(),
          tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
          limit: 0
        },
        success: (response) => {

          $('#tableSumbangan').jqGrid("setGridParam", {
            url: `${apiUrl}pengeluarantruckingheader/${id}/getEditInvoice`,
            postData: {
              tgldari: $('#crudForm').find('[name=tgldari]').val(),
              tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
            },
          }).trigger('reloadGrid');
          resolve();
        },
        error: error => {
          reject(error)
        }
      });
    });
  }

  $(document).on('click', `#detailList tbody [name="pinjPribadi[]"]`, function() {

    if ($(this).prop("checked") == true) {
      $(this).closest('tr').find(`td [name="nominalDP[]"]`).prop('disabled', false)
      let sisa = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisaDP[]"]`)[0])
      initAutoNumeric($(this).closest('tr').find(`td [name="nominalDP[]"]`))

      // initAutoNumeric($(this).closest('tr').find(`td [name="nominalDP[]"]`).val(sisa))
      // let bayar = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="nominalDP[]"]`)[0])
      // let totalSisa = sisa - bayar

      // $(this).closest("tr").find(".sisaDP").html(totalSisa)
      // $(this).closest("tr").find(`[name="sisaDP[]"]`).val(totalSisa)
      // initAutoNumeric($(this).closest("tr").find(".sisaDP"))
      setTotalDP()
      setSisaDP()
    } else {
      let id = $(this).val()
      $(this).closest('tr').find(`td [name="nominalDP[]"]`).remove();
      let newBayarElement = `<input type="text" name="nominalDP[]" class="form-control text-right" disabled>`
      $(this).closest('tr').find(`#${id}`).append(newBayarElement)

      let sisa = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisaAwalDP[]"]`)[0])

      initAutoNumeric($(this).closest('tr').find(`td [name="sisaDP[]"]`).val(sisa))
      $(this).closest("tr").find(".sisaDP").html(sisa)
      initAutoNumeric($(this).closest("tr").find(".sisaDP"))

      setTotalDP()
      setSisaDP()
    }
  })

  $(document).on('input', `#table_body [name="nominalDP[]"]`, function(event) {
    setTotalDP()
    setSisaDetail(this)
  })

  function setSisaDetail(el) {
    let sisa = AutoNumeric.getNumber($(el).closest("tr").find(`[name="sisaDP[]"]`)[0])
    let sisaAwal = AutoNumeric.getNumber($(el).closest("tr").find(`[name="sisaAwalDP[]"]`)[0])
    let bayar = $(el).val()
    bayar = parseFloat(bayar.replaceAll(',', ''));
    // console.log( sisaAwal , bayar );
    bayar = Number.isNaN(bayar) ? 0 : bayar
    totalSisa = sisaAwal - bayar
    $(el).closest("tr").find(".sisaDP").html(totalSisa)
    $(el).closest("tr").find(`[name="sisaDP[]"]`).val(totalSisa)
    initAutoNumeric($(el).closest("tr").find(".sisaDP"))
    let Sisa = $(`#table_body .sisaDP`)
    let total = 0

    $.each(Sisa, (index, SISA) => {
      total += AutoNumeric.getNumber(SISA)
    });
    new AutoNumeric('#sisaFoot').set(total)
  }

  function setSisaDP() {
    let nominalDetails = $(`.sisaDP`)
    let bayar = 0
    $.each(nominalDetails, (index, nominalDetail) => {
      bayar += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#sisaFoot').set(bayar)
  }
  indexRow = 0;

  let pengeluaranstokheader = '';
  let penerimaanstokheader = '';
  let penerimaanstokheader_nobukti = '';

  function addRow() {

    let detailRow = $(`
      <tr>
        <td></td>
        <td class="data_tbl tbl_supir_id">
          <input id="supir_id_${indexRow}" type="hidden" name="supir_id[]">
          <input id="supir_${indexRow}" type="text" name="supir[]"  class="form-control supir-lookup">
        </td>
        <td class="data_tbl tbl_statustitipanemkl kolom_bbt">
          <select name="detail_statustitipanemkl[]" class="form-select select2bs4" id="statustitipanemkl${indexRow}" style="width: 100%;">
            <option value="">-- PILIH TITIPAN EMKL --</option>
          </select>     
        </td>
        <td class="data_tbl tbl_suratpengantar_nobukti kolom_bbt">
          <input id="suratpengantar_nobukti_${indexRow}" type="text" name="suratpengantar_nobukti[]"  class="form-control suratpengantar-lookup">
        </td>
        <td class="data_tbl tbl_trado_id kolom_bbt">
          <input id="trado_id_${indexRow}" type="text" name="trado_id[]"  class="form-control">
        </td>
        <td class="data_tbl tbl_container_id kolom_bbt">
          <input id="container_id_${indexRow}" type="text" name="container_id[]"  class="form-control">
        </td>
        <td class="data_tbl tbl_pelanggan_id kolom_bbt">
          <input id="pelanggan_id_${indexRow}" type="text" name="pelanggan_id[]"  class="form-control">
        </td>  
        <td class="data_tbl tbl_karyawan_id">
          <input id="karyawan_id_${indexRow}" type="hidden" name="karyawan_id[]">
          <input id="karyawawan_${indexRow}" type="text" name="karyawan[]"  class="form-control karyawan-lookup">
        </td>
        <td class="data_tbl tbl_pengeluaranstokheader_nobukti">
          <input id="pengeluaranstok_nobukti_${indexRow}" type="text" name="pengeluaranstok_nobukti[]"  class="form-control pengeluaranstokheader-lookup">
        </td>
        <td class="data_tbl tbl_penerimaanstokheader_nobukti tbl_tagihklaim">
          <input id="penerimaanstok_nobukti_${indexRow}" type="text" name="penerimaanstok_nobukti[]"  class="form-control penerimaanstokheader-lookup">
        </td>
        <td class="data_tbl tbl_stok_id">
          <input id="stok_id_${indexRow}" type="hidden" name="stok_id[]">
          <input id="stok_${indexRow}" type="text" name="stok[]"  class="form-control stok-lookup">
        </td>
        <td class="data_tbl tbl_qty">
          <input id="qty_${indexRow}" type="text" name="qty[]" class="form-control text-right qty"> 
        </td>

        <td class="data_tbl tbl_penerimaantruckingheader">
          <input id="penerimaantruckingheader_nobukti_${indexRow}" type="text" name="penerimaantruckingheader_nobukti[]"  class="form-control penerimaantruckingheader-lookup">
        </td>
        <td class="data_tbl tbl_harga">
          <input id="harga_${indexRow}" readonly type="hidden" name="harga[]" class="form-control autonumeric"> 
          <input id="totalharga_${indexRow}" readonly type="text" name="totalharga[]" class="form-control autonumeric"> 
        </td>
        <td class="data_tbl tbl_nominal">
          <input id="nominal_${indexRow}" type="text" name="nominal[]" class="form-control autonumeric nominal" autocomplete="off"> 
        </td>
        <td class="data_tbl tbl_nominaltagih kolom_bbt">
          <input id="nominaltagih_${indexRow}" type="text" name="nominaltagih[]" readonly class="form-control text-right nominaltagih"> 
        </td>
        <td class="data_tbl tbl_keterangan">
          <input id="keterangan_${indexRow}" type="text" name="keterangan[]" class="form-control"> 
        </td>
        
        <td class="data_tbl tbl_tagihklaim">
          <input id="nominaltambahan_${indexRow}" type="text" name="nominaltambahan[]" class="form-control autonumeric text-right nominaltambahan"> 
        </td>
        <td class="data_tbl tbl_tagihklaim">
          <input id="keterangantambahan_${indexRow}" type="text" name="keterangantambahan[]" class="form-control"> 
        </td>
        <td class="data_tbl tbl_jenisorder kolom_bbt">
          <input id="jenisorder_${indexRow}" type="text" name="jenisorder_id[]" class="form-control"> 
        </td>
        <td class="data_tbl tbl_tagihklaim">
          <input id="totalklaim_${indexRow}" type="text" name="totalklaim[]" readonly class="form-control text-right totalklaim"> 
        </td>
        <td class="tbl_aksi">
            <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
        </td>
      </tr>
    `)
    var row = indexRow;
    $('#detailList tbody').append(detailRow)
    initSelect2($(`#statustitipanemkl${indexRow}`), true)
    dataStatusBiaya.forEach(statusBiaya => {
      let option = new Option(statusBiaya.text, statusBiaya.id)

      detailRow.find(`#statustitipanemkl${indexRow}`).append(option).trigger('change')
    });
    if (listKodePengeluaran[8] == KodePengeluaranId) {

      $(`#trado_id_${indexRow}`).prop('readonly', true);
      $(`#container_id_${indexRow}`).prop('readonly', true);
      $(`#pelanggan_id_${indexRow}`).prop('readonly', true);
      $(`#jenisorder_${indexRow}`).prop('readonly', true);
    }
    $('.supir-lookup').last().lookup({
      title: 'Supir Lookup',
      fileName: 'supir',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (supir, element) => {
        element.parents('td').find(`[name="supir_id[]"]`).val(supir.id)
        element.val(supir.namasupir)
        element.data('currentValue', element.val())
        if (KodePengeluaranId == 'PJT') {
          element.parents('tr').find(`td [name="keterangan[]"]`).val("PINJAMAN SUPIR " + supir.namasupir)
        }
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
    $('.suratpengantar-lookup').last().lookup({
      title: 'surat pengantar Lookup',
      fileName: 'suratpengantar',
      beforeProcess: function(test) {
        console.log(row);
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          pengeluarantruckingheader: KodePengeluaranId,
          jenisorder_id: $('[name=jenisorderan_id]').val(),
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (suratpengantar, element) => {
        element.val(suratpengantar.nobukti)
        element.parents('td').find(`[name="suratpengantar_id[]"]`).val(suratpengantar.id)
        element.parents('tr').find(`[name="trado_id[]"]`).val(suratpengantar.trado_id)
        element.parents('tr').find(`[name="container_id[]"]`).val(suratpengantar.container_id)
        element.parents('tr').find(`[name="pelanggan_id[]"]`).val(suratpengantar.pelanggan_id)
        element.parents('tr').find(`[name="jenisorder_id[]"]`).val(suratpengantar.jenisorder_id)

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
    $('.karyawan-lookup').last().lookup({
      title: 'karyawan Lookup',
      fileName: 'karyawan',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (karyawan, element) => {
        element.parents('td').find(`[name="karyawan_id[]"]`).val(karyawan.id)
        element.val(karyawan.namakaryawan)
        element.data('currentValue', element.val())
        if (KodePengeluaranId == 'PJK') {
          element.parents('tr').find(`td [name="keterangan[]"]`).val("PINJAMAN KARYAWAN " + karyawan.namakaryawan)
        }
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {

        element.parents('td').find(`[name="karyawan_id[]"]`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.penerimaanstokheader-lookup').last().lookup({
      title: 'penerimaan stok Lookup',
      fileName: 'penerimaanstokheader',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          penerimaanstok_id: 5,
          cabang: statuscabang,
          Aktif: 'AKTIF',
          url: urlTNL,
          token: tokenTNL,
          from: 'klaim',
        }
      },
      onSelectRow: (stok, element) => {
        penerimaanstokheader = stok.id
        penerimaanstokheader_nobukti = stok.nobukti
        element.val(stok.nobukti)

        lookupSelectedSpkPG(row, 'PG')
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#stok_id_${row}`).val('');
        $(`#stok_${row}`).val('');
        $(`#stok_${row}`).data('currentValue', element.val(''))
        // AutoNumeric($(`#qty_${row}`)[0]).set(0);
        // $(`#qty_${row}`).val('');
        // AutoNumeric($(`#harga_${row}`)[0]).set(0);
        $(`#harga_${row}`).val('');
        // AutoNumeric($(`#nominal_${row}`)[0]).set(0);
        $(`#nominal_${row}`).val('');
        setTotal();
        // element.parents('td').find(`[name="stok_id[]"]`).val('')
        element.val('')
        penerimaanstokheader = ''
        penerimaanstokheader_nobukti = ''
        element.data('currentValue', element.val())
        enabledLookupSpkPG(row)
      }
    })

    $('.pengeluaranstokheader-lookup').last().lookup({
      title: 'pengeluaran stok Lookup',
      fileName: 'pengeluaranstokheader',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          cabang: statuscabang,
          Aktif: 'AKTIF',
          url: urlTNL,
          token: tokenTNL,
          from: 'klaim',
          aksi: $('#crudForm').data('action')
        }
      },
      onSelectRow: (stok, element) => {
        pengeluaranstokheader = stok.id
        element.val(stok.nobukti)

        lookupSelectedSpkPG(row, 'SPK')
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#stok_id_${row}`).val('');
        $(`#stok_${row}`).val('');
        $(`#stok_${row}`).data('currentValue', element.val(''))
        // AutoNumeric($(`#qty_${row}`)[0]).set(0);
        // $(`#qty_${row}`).val('');
        // AutoNumeric($(`#harga_${row}`)[0]).set(0);
        $(`#harga_${row}`).val('');
        // AutoNumeric($(`#nominal_${row}`)[0]).set(0);
        $(`#nominal_${row}`).val('');
        setTotal();
        // element.parents('td').find(`[name="stok_id[]"]`).val('')
        pengeluaranstokheader = ''
        element.val('')
        element.data('currentValue', element.val())
        enabledLookupSpkPG(row)
      }
    })

    $('.stok-lookup').last().lookup({
      title: 'stok Lookup',
      fileName: 'pengeluaranstokdetail',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        console.log(penerimaanstokheader_nobukti, '6210');
        this.postData = {
          cabang: statuscabang,
          penerimaanstokheader_id: penerimaanstokheader,
          penerimaanstokheader_nobukti: penerimaanstokheader_nobukti,
          pengeluaranstokheader_id: pengeluaranstokheader,
          url: urlTNL,
          token: tokenTNL,
          from: 'klaim',
        }
      },
      onSelectRow: (stok, element) => {
        element.parents('td').find(`[name="stok_id[]"]`).val(stok.stok_id)
        element.val(stok.stok)
        element.data('currentValue', element.val())
        console.log(row, stok.qty, stok.harga)
        $(`#qty_${row}`).val(stok.qty)
        initAutoNumeric($(`#qty_${row}`), {
          'maximumValue': stok.qty
        })
        totalharga = parseFloat(stok.qty.replace(/,/g, '')) * parseFloat(stok.harga.replace(/,/g, ''));
        new AutoNumeric(element.parents("tr").find(`[name="totalharga[]"]`)[0]).set(totalharga)
        new AutoNumeric($(`#harga_${row}`)[0]).set(stok.harga)
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        //  new AutoNumeric($(`#qty_${row}`)[0]).set(0);
        //  $(`#qty_${row}`).val('');
        //  new AutoNumeric($(`#harga_${row}`)[0]).set(0);
        $(`#harga_${row}`).val('');
        //  new AutoNumeric($(`#nominal_${row}`)[0]).set(0);
        $(`#nominal_${row}`).val('');
        setTotal();
        element.parents('td').find(`[name="stok_id[]"]`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.penerimaantruckingheader-lookup').last().lookup({
      title: 'Penerimaan Trucking Lookup',
      fileName: 'penerimaantruckingheader',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (penerimaantruckingheader, element) => {
        element.val(penerimaantruckingheader.nobukti)
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
    indexRow++
  }

  function checkboxHandler(element) {
    let value = $(element).val();
    // console.log(value);
    if (element.checked) {
      selectedRows.push($(element).val());
      $(`#detail_row_${value}`).find(`[name="id_detail[]"]`).attr('disabled', false)
      $(`#detail_row_${value}`).find(`[name="container_detail[]"]`).attr('disabled', false)
      $(`#detail_row_${value}`).find(`[name="noinvoice_detail[]"]`).attr('disabled', false)
      $(`#detail_row_${value}`).find(`[name="nominal[]"]`).attr('disabled', false)
      $(`#detail_row_${value}`).find(`[name="nojobtrucking_detail[]"]`).attr('disabled', false)
      $(`#detail_row_${value}`).find(`[name="keterangan[]"]`).attr('disabled', false)
    } else {
      for (var i = 0; i < selectedRows.length; i++) {
        if (selectedRows[i] == value) {
          selectedRows.splice(i, 1);
        }
      }
      $(`#detail_row_${value}`).find(`[name="id_detail[]"]`).attr('disabled', true)
      $(`#detail_row_${value}`).find(`[name="container_detail[]"]`).attr('disabled', true)
      $(`#detail_row_${value}`).find(`[name="noinvoice_detail[]"]`).attr('disabled', true)
      $(`#detail_row_${value}`).find(`[name="nominal[]"]`).attr('disabled', true)
      $(`#detail_row_${value}`).find(`[name="nojobtrucking_detail[]"]`).attr('disabled', true)
      $(`#detail_row_${value}`).find(`[name="keterangan[]"]`).attr('disabled', true)
    }
  }

  function loadModalGrid() {
    let disabled = '';
    if ($('#crudForm').data('action') == 'delete') {
      disabled = 'disabled'
    }
    $("#tableSumbangan").jqGrid({
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
                dari = $('#crudForm').find(`[name="tgldari"]`).val()
                sampai = $('#crudForm').find(`[name="tglsampai"]`).val()
                let aksi = $('#crudForm').data('action')

                $(element).removeClass('form-control')
                $(element).parent().addClass('text-center')
                $(element).addClass('checkbox-selectall')
                if (disabled == '') {
                  $(element).on('click', function() {
                    if ($(this).is(':checked')) {
                      selectAllRowsSumbangan()
                    } else {
                      clearSelectedRowsSumbangan()
                    }
                  })
                } else {
                  $(element).attr('disabled', true)
                }

              }
            },
            formatter: (value, rowOptions, rowData) => {
              return `<input type="checkbox" class="checkbox-jqgrid" name="sumbanganId[]" value="${rowData.id_detail}" ${disabled} onchange="checkboxSumbanganHandler(this)"><input type="hidden" name="nojobinv[]" value="${rowData.nojobtrucking_detail}" ${disabled}>`
            },
          },
          {
            label: 'no invoice',
            name: 'noinvoice_detail',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'no job',
            name: 'nojobtrucking_detail',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'container',
            name: 'container_detail',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'nominal',
            name: 'nominal_detail',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 400,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        footerrow: true,
        userDataOnFooter: true,
        toolbar: [true, "top"],
        sortable: true,
        sortname: 'noinvoice_detail',
        sortorder: 'asc',
        page: pageSumbangan,
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
          sortnameSumbangan = $(this).jqGrid("getGridParam", "sortname")
          sortorderSumbangan = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordSumbangan = $(this).getGridParam("records")
          limitSumbangan = $(this).jqGrid('getGridParam', 'postData').limit
          postDataSumbangan = $(this).jqGrid('getGridParam', 'postData')
          triggerClickSumbangan = true

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowSumbangan > $(this).getDataIDs().length - 1) {
            indexRowSumbangan = $(this).getDataIDs().length - 1;
          }

          setHighlight($(this))

          $.each(selectedRowsSumbanganJobtrucking, function(key, value) {
            $(grid).find('tbody tr').each(function(row, tr) {
              if ($(this).find(`td input[name="nojobinv[]"]`).val() == value) {
                $(this).addClass('bg-light-blue')
                $(this).find(`td input:checkbox`).prop('checked', true)
              }
            })
          });
          setTotalNominalSumbangan()
          // if (data.attributes) {
          //   $(this).jqGrid('footerData', 'set', {
          //     nominal_detail: data.attributes.totalNominal,
          //   }, true)
          // }

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
              tgldari: $('#crudForm [name=tgldari]').val(),
              tglsampai: $('#crudForm [name=tglsampai]').val(),
            },
          })
          clearGlobalSearch($('#tableSumbangan'))
        },
        afterSearch: function() {
          console.log($(this).getGridParam())
        }
      })
      .customPager({})
    /* Append clear filter button */
    loadClearFilter($('#tableSumbangan'))

    /* Append global search */
    loadGlobalSearch($('#tableSumbangan'))
  }

  function checkboxSumbanganHandler(element) {
    let value = $(element).val();
    if (element.checked) {
      selectedRowsSumbangan.push($(element).val())
      selectedRowsSumbanganNobukti.push($(element).parents('tr').find(`td[aria-describedby="tableSumbangan_noinvoice_detail"]`).text())
      selectedRowsSumbanganContainer.push($(element).parents('tr').find(`td[aria-describedby="tableSumbangan_container_detail"]`).text())
      selectedRowsSumbanganJobtrucking.push($(element).parents('tr').find(`td[aria-describedby="tableSumbangan_nojobtrucking_detail"]`).text())
      selectedRowsSumbanganNominal.push($(element).parents('tr').find(`td[aria-describedby="tableSumbangan_nominal_detail"]`).text())

      $(element).parents('tr').addClass('bg-light-blue')
    } else {
      $(element).parents('tr').removeClass('bg-light-blue')
      for (var i = 0; i < selectedRowsSumbangan.length; i++) {
        if (selectedRowsSumbangan[i] == value) {
          selectedRowsSumbangan.splice(i, 1);
          selectedRowsSumbanganNobukti.splice(i, 1);
          selectedRowsSumbanganContainer.splice(i, 1);
          selectedRowsSumbanganJobtrucking.splice(i, 1);
          selectedRowsSumbanganNominal.splice(i, 1);
        }
      }
    }

    setTotalNominalSumbangan()
  }

  function setTotalNominalSumbangan() {
    let nominal = 0
    $.each(selectedRowsSumbangan, (index, val) => {
      getNominal = selectedRowsSumbanganNominal[index];
      nominals = parseFloat(getNominal.replaceAll(',', ''))
      nominal += nominals

    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableSumbangan_nominal_detail"]`).text(nominal))
  }

  function clearSelectedRowsSumbangan() {
    selectedRowsSumbangan = []
    selectedRowsSumbanganNobukti = [];
    selectedRowsSumbanganContainer = [];
    selectedRowsSumbanganJobtrucking = [];
    selectedRowsSumbanganNominal = [];
    $('#tableSumbangan').trigger('reloadGrid')
  }

  function getDataSumbangan() {
    if ($('#crudForm').data('action') == 'edit') {
      bstId = $(`#crudForm`).find(`[name="id"]`).val()
      urlSumbangan = `${bstId}/geteditinvoice`
    } else {
      urlSumbangan = 'getinvoice'
    }
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}pengeluarantruckingheader/${urlSumbangan}`,
        method: 'GET',
        dataType: 'JSON',
        data: {
          tgldari: $('#crudForm').find('[name=tgldari]').val(),
          tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
          limit: 0,
          proses: 'reload',
          sortIndex: 'noinvoice_detail',
          sortOrder: 'asc'
        },
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          if ($('#crudForm').data('action') == 'edit') {
            response.data.map((data) => {
              if (data.pengeluarantrucking_id != null) {
                selectedRowsSumbangan.push(data.id_detail)
                selectedRowsSumbanganNobukti.push(data.noinvoice_detail)
                selectedRowsSumbanganContainer.push(data.container_detail)
                selectedRowsSumbanganJobtrucking.push(data.nojobtrucking_detail)
                selectedRowsSumbanganNominal.push(data.nominal_detail)
              }
            })
          }
          response.url = urlSumbangan
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

  function selectAllRowsSumbangan() {
    if ($('#crudForm').data('action') == 'edit') {
      bstId = $(`#crudForm`).find(`[name="id"]`).val()
      urlSumbangan = `${bstId}/geteditinvoice`
    } else {
      urlSumbangan = 'getinvoice'
    }
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}pengeluarantruckingheader/${urlSumbangan}`,
        method: 'GET',
        dataType: 'JSON',
        data: {
          tgldari: $('#crudForm').find('[name=tgldari]').val(),
          tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
          limit: 0
        },
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          clearSelectedRowsSumbangan()
          selectedRowsSumbangan = response.data.map((data) => data.id_detail)
          selectedRowsSumbanganNobukti = response.data.map((data) => data.noinvoice_detail)
          selectedRowsSumbanganContainer = response.data.map((data) => data.container_detail)
          selectedRowsSumbanganJobtrucking = response.data.map((data) => data.nojobtrucking_detail)
          selectedRowsSumbanganNominal = response.data.map((data) => data.nominal_detail)

          // $('#tableSumbangan').jqGrid("clearGridData");
          $('#tableSumbangan').jqGrid('setGridParam', {
            url: `${apiUrl}pengeluarantruckingheader/${urlSumbangan}`,
            postData: {
              tgldari: $('#crudForm').find('[name=tgldari]').val(),
              tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
              aksi: $('#crudForm').data('action')
            },
            datatype: "json"
          }).trigger('reloadGrid');
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

  function loadBLLGrid() {
    $("#tableBLL")
      .jqGrid({
        datatype: 'local',
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        colModel: [{
            label: "id",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "supir_id",
            name: "supir_id",
            hidden: true,
            search: false,
          },
          {
            label: "SUPIR",
            name: "supirbiaya",
            sortable: true,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
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
                  let originalGridData = $("#tableBLL")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tableBLL").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  let totalSisa
                  localRow.nominal = event.target.value;

                  let nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])

                  if (nominal < 0) {
                    showDialog('NOMINAL tidak boleh minus')
                    $("#tableBLL").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "nominal",
                      0
                    );
                    nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  }
                  nominalDetails = $(`#tableBLL tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tableBLL_nominal"]`)
                  ttlBayar = 0
                  $.each(nominalDetails, (index, nominalDetail) => {
                    ttlBayarDetail = parseFloat($(nominalDetail).attr('title').replaceAll(',', ''))
                    ttlBayars = (isNaN(ttlBayarDetail)) ? 0 : ttlBayarDetail;
                    ttlBayar += ttlBayars
                  });
                  ttlBayar += nominal
                  initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBLL_nominal"]`).text(ttlBayar))
                },
              }, ],
            },
            sortable: false,
            sorttype: "int",
          },
          {
            label: "KETERANGAN",
            name: "keteranganbll",
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
            sortable: false,
            editable: true,
            editoptions: {
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let localRow = $("#tableBLL").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  localRow.keteranganbll = event.target.value;
                }
              }, ]
            }
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
          let originalGridData = $("#tableBLL")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tableBLL").jqGrid("getLocalRow", rowId);
        },
        validationCell: function(cellobject, errormsg, iRow, iCol) {
          console.log(cellobject);
          console.log(errormsg);
          console.log(iRow);
          console.log(iCol);
        },
        loadComplete: function() {
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
          let localRow = $("#tableBLL").jqGrid("getLocalRow", rowId);

          $("#tableBLL").jqGrid(
            "setCell",
            rowId,
            "sisa",
            parseInt(localRow.sisa) + parseInt(localRow.nominal)
          );

          return true;
        },
      });
    /* Append clear filter button */
    loadClearFilter($('#tableBLL'))

    /* Append global search */
    // loadGlobalSearch($('#tableDeposito'))
  }

  function getDataBiayaLapangan() {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}pengeluarantruckingheader/getbiayalapangan`,
        dataType: "JSON",
        data: {
          id: $('#crudForm').find("[name=id]").val(),
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

  // TABLE BLN
  function loadBLNGrid() {
    $("#tableBLN")
      .jqGrid({
        datatype: 'local',
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        colModel: [{
            label: "id",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "supir_id",
            name: "supir_id",
            hidden: true,
            search: false,
          },
          {
            label: "SUPIR",
            name: "supirbiaya",
            sortable: true,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
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
                  let originalGridData = $("#tableBLN")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tableBLN").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  let totalSisa
                  localRow.nominal = event.target.value;

                  let nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])

                  if (nominal < 0) {
                    showDialog('NOMINAL tidak boleh minus')
                    $("#tableBLN").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "nominal",
                      0
                    );
                    nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  }
                  nominalDetails = $(`#tableBLN tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tableBLN_nominal"]`)
                  ttlBayar = 0
                  $.each(nominalDetails, (index, nominalDetail) => {
                    ttlBayarDetail = parseFloat($(nominalDetail).attr('title').replaceAll(',', ''))
                    ttlBayars = (isNaN(ttlBayarDetail)) ? 0 : ttlBayarDetail;
                    ttlBayar += ttlBayars
                  });
                  ttlBayar += nominal
                  initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBLN_nominal"]`).text(ttlBayar))
                },
              }, ],
            },
            sortable: false,
            sorttype: "int",
          },
          {
            label: "KETERANGAN",
            name: "keteranganbll",
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
            sortable: false,
            editable: true,
            editoptions: {
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let localRow = $("#tableBLN").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  localRow.keteranganbll = event.target.value;
                }
              }, ]
            }
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
          let originalGridData = $("#tableBLN")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tableBLN").jqGrid("getLocalRow", rowId);
        },
        validationCell: function(cellobject, errormsg, iRow, iCol) {
          console.log(cellobject);
          console.log(errormsg);
          console.log(iRow);
          console.log(iCol);
        },
        loadComplete: function() {
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
          let localRow = $("#tableBLN").jqGrid("getLocalRow", rowId);

          $("#tableBLN").jqGrid(
            "setCell",
            rowId,
            "sisa",
            parseInt(localRow.sisa) + parseInt(localRow.nominal)
          );

          return true;
        },
      });
    /* Append clear filter button */
    loadClearFilter($('#tableBLN'))

    /* Append global search */
    // loadGlobalSearch($('#tableDeposito'))
  }

  // TABLE BTU
  function loadBTUGrid() {
    $("#tableBTU")
      .jqGrid({
        datatype: 'local',
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        colModel: [{
            label: "id",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "supir_id",
            name: "supir_id",
            hidden: true,
            search: false,
          },
          {
            label: "SUPIR",
            name: "supirbiaya",
            sortable: true,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          },
          {
            label: "NOMINAL",
            name: "nominal",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: "right",
            editable: true,
            editoptions: {
              dataInit: function(element, id) {
                console.log('here', id)
                initAutoNumeric($('#crudForm').find(`[id="${id.id}"]`))
              },
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let originalGridData = $("#tableBTU")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tableBTU").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  let totalSisa
                  localRow.nominal = event.target.value;

                  let nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])

                  if (nominal < 0) {
                    showDialog('NOMINAL tidak boleh minus')
                    $("#tableBTU").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "nominal",
                      0
                    );
                    // nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  }
                  setTotalNominalBiaya('tableBTU')
                  // nominalDetails = $(`#tableBTU tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tableBTU_nominal"]`)
                  // ttlBayar = 0
                  // $.each(nominalDetails, (index, nominalDetail) => {
                  //   ttlBayarDetail = parseFloat($(nominalDetail).attr('title').replaceAll(',', ''))
                  //   ttlBayars = (isNaN(ttlBayarDetail)) ? 0 : ttlBayarDetail;
                  //   ttlBayar += ttlBayars
                  // });
                  // ttlBayar += nominal
                  // initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBTU_nominal"]`).text(ttlBayar))
                },
              }, ],
            },
            sortable: false,
            sorttype: "int",
          },
          {
            label: "KETERANGAN",
            name: "keteranganbll",
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
            sortable: false,
            editable: true,
            editoptions: {
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let localRow = $("#tableBTU").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  localRow.keteranganbll = event.target.value;
                }
              }, ]
            }
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
        // onCellSelect: function(rowid, iCol, cellcontent, e) {
        //   console.log("Selected Cell - Row ID: " + rowid + ", Column Index: " + iCol);
        // },
        afterRestoreCell: function(rowId, value, indexRow, indexColumn) {
          let originalGridData = $("#tableBTU")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tableBTU").jqGrid("getLocalRow", rowId);
        },
        validationCell: function(cellobject, errormsg, iRow, iCol) {
          console.log(cellobject);
          console.log(errormsg);
          console.log(iRow);
          console.log(iCol);
        },
        loadComplete: function() {
          setTotalNominalBiaya('tableBTU')
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
          let localRow = $("#tableBTU").jqGrid("getLocalRow", rowId);

          $("#tableBTU").jqGrid(
            "setCell",
            rowId,
            "sisa",
            parseInt(localRow.sisa) + parseInt(localRow.nominal)
          );

          return true;
        },
      });
    /* Append clear filter button */
    loadClearFilter($('#tableBTU'))

    /* Append global search */
    // loadGlobalSearch($('#tableDeposito'))
  }

  function loadBTTGrid() {
    $("#tableBTT")
      .jqGrid({
        datatype: 'local',
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        colModel: [{
            label: "id",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "supir_id",
            name: "supir_id",
            hidden: true,
            search: false,
          },
          {
            label: "SUPIR",
            name: "supirbiaya",
            sortable: true,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          },
          {
            label: "NOMINAL",
            name: "nominal",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: "right",
            editable: true,
            editoptions: {
              dataInit: function(element, id) {
                console.log('here', id)
                initAutoNumeric($('#crudForm').find(`[id="${id.id}"]`))
              },
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let originalGridData = $("#tableBTT")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tableBTT").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  let totalSisa
                  localRow.nominal = event.target.value;

                  let nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])

                  if (nominal < 0) {
                    showDialog('NOMINAL tidak boleh minus')
                    $("#tableBTT").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "nominal",
                      0
                    );
                    // nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  }
                  setTotalNominalBiaya('tableBTT')
                  // nominalDetails = $(`#tableBTU tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tableBTU_nominal"]`)
                  // ttlBayar = 0
                  // $.each(nominalDetails, (index, nominalDetail) => {
                  //   ttlBayarDetail = parseFloat($(nominalDetail).attr('title').replaceAll(',', ''))
                  //   ttlBayars = (isNaN(ttlBayarDetail)) ? 0 : ttlBayarDetail;
                  //   ttlBayar += ttlBayars
                  // });
                  // ttlBayar += nominal
                  // initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBTU_nominal"]`).text(ttlBayar))
                },
              }, ],
            },
            sortable: false,
            sorttype: "int",
          },
          {
            label: "KETERANGAN",
            name: "keteranganbll",
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
            sortable: false,
            editable: true,
            editoptions: {
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let localRow = $("#tableBTT").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  localRow.keteranganbll = event.target.value;
                }
              }, ]
            }
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
        // onCellSelect: function(rowid, iCol, cellcontent, e) {
        //   console.log("Selected Cell - Row ID: " + rowid + ", Column Index: " + iCol);
        // },
        afterRestoreCell: function(rowId, value, indexRow, indexColumn) {
          let originalGridData = $("#tableBTT")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tableBTT").jqGrid("getLocalRow", rowId);
        },
        validationCell: function(cellobject, errormsg, iRow, iCol) {
          console.log(cellobject);
          console.log(errormsg);
          console.log(iRow);
          console.log(iCol);
        },
        loadComplete: function() {
          setTotalNominalBiaya('tableBTT')
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
          let localRow = $("#tableBTT").jqGrid("getLocalRow", rowId);

          $("#tableBTT").jqGrid(
            "setCell",
            rowId,
            "sisa",
            parseInt(localRow.sisa) + parseInt(localRow.nominal)
          );

          return true;
        },
      });
    /* Append clear filter button */
    loadClearFilter($('#tableBTT'))

    /* Append global search */
    // loadGlobalSearch($('#tableDeposito'))
  }

  function setTotalNominalBiaya(table) {
    let nominalDetails = $(`#${table}`).find(`td[aria-describedby="${table}_nominal"]`)
    let nominal = 0
    selectedRowsPinjaman = $(`#${table}`).getGridParam("selectedRowIds");
    $.each(selectedRowsPinjaman, function(index, value) {
      dataPinjaman = $(`#${table}`).jqGrid("getLocalRow", value);
      nominals = (dataPinjaman.nominal == undefined || dataPinjaman.nominal == '') ? 0 : dataPinjaman.nominal;
      getNominal = (isNaN(nominals)) ? parseFloat(nominals.replaceAll(',', '')) : parseFloat(nominals)
      nominal = nominal + getNominal
    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="${table}_nominal"]`).text(nominal))
  }

  $(document).on('click', '#resetdatafilter_tableBTU', function(event) {
    selectedRowsBtu = $("#tableBTU").getGridParam("selectedRowIds");
    $.each(selectedRowsBtu, function(index, value) {
      $('#tableBTU').jqGrid('saveCell', value, 5); //emptycell
      $('#tableBTU').jqGrid('saveCell', value, 3); //nominal
      $('#tableBTU').jqGrid('saveCell', value, 4); //keterangan
    })

  });
  $(document).on('click', '#gbox_tableBTU .ui-jqgrid-hbox .ui-jqgrid-htable thead .ui-search-toolbar th td a.clearsearchclass', function(event) {
    selectedRowsBtu = $("#tableBTU").getGridParam("selectedRowIds");
    $.each(selectedRowsBtu, function(index, value) {
      $('#tableBTU').jqGrid('saveCell', value, 5); //emptycell
      $('#tableBTU').jqGrid('saveCell', value, 3); //nominal
      $('#tableBTU').jqGrid('saveCell', value, 4); //keterangan
    })
  })

  $(document).on('click', '#resetdatafilter_tableBTT', function(event) {
    selectedRowsBtt = $("#tableBTT").getGridParam("selectedRowIds");
    $.each(selectedRowsBtt, function(index, value) {
      $('#tableBTT').jqGrid('saveCell', value, 5); //emptycell
      $('#tableBTT').jqGrid('saveCell', value, 3); //nominal
      $('#tableBTT').jqGrid('saveCell', value, 4); //keterangan
    })

  });
  $(document).on('click', '#gbox_tableBTT .ui-jqgrid-hbox .ui-jqgrid-htable thead .ui-search-toolbar th td a.clearsearchclass', function(event) {
    selectedRowsBtt = $("#tableBTT").getGridParam("selectedRowIds");
    $.each(selectedRowsBtt, function(index, value) {
      $('#tableBTT').jqGrid('saveCell', value, 5); //emptycell
      $('#tableBTT').jqGrid('saveCell', value, 3); //nominal
      $('#tableBTT').jqGrid('saveCell', value, 4); //keterangan
    })
  })  
  // TABLE BPT
  function loadBPTGrid() {
    $("#tableBPT")
      .jqGrid({
        datatype: 'local',
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        colModel: [{
            label: "id",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "supir_id",
            name: "supir_id",
            hidden: true,
            search: false,
          },
          {
            label: "SUPIR",
            name: "supirbiaya",
            sortable: true,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
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
                  let originalGridData = $("#tableBPT")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tableBPT").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  let totalSisa
                  localRow.nominal = event.target.value;

                  let nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])

                  if (nominal < 0) {
                    showDialog('NOMINAL tidak boleh minus')
                    $("#tableBPT").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "nominal",
                      0
                    );
                    nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  }
                  nominalDetails = $(`#tableBPT tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tableBPT_nominal"]`)
                  ttlBayar = 0
                  $.each(nominalDetails, (index, nominalDetail) => {
                    ttlBayarDetail = parseFloat($(nominalDetail).attr('title').replaceAll(',', ''))
                    ttlBayars = (isNaN(ttlBayarDetail)) ? 0 : ttlBayarDetail;
                    ttlBayar += ttlBayars
                  });
                  ttlBayar += nominal
                  initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBPT_nominal"]`).text(ttlBayar))
                },
              }, ],
            },
            sortable: false,
            sorttype: "int",
          },
          {
            label: "KETERANGAN",
            name: "keteranganbll",
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
            sortable: false,
            editable: true,
            editoptions: {
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let localRow = $("#tableBPT").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  localRow.keteranganbll = event.target.value;
                }
              }, ]
            }
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
          let originalGridData = $("#tableBPT")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tableBPT").jqGrid("getLocalRow", rowId);
        },
        validationCell: function(cellobject, errormsg, iRow, iCol) {
          console.log(cellobject);
          console.log(errormsg);
          console.log(iRow);
          console.log(iCol);
        },
        loadComplete: function() {
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
          let localRow = $("#tableBPT").jqGrid("getLocalRow", rowId);

          $("#tableBPT").jqGrid(
            "setCell",
            rowId,
            "sisa",
            parseInt(localRow.sisa) + parseInt(localRow.nominal)
          );

          return true;
        },
      });
    /* Append clear filter button */
    loadClearFilter($('#tableBPT'))

    /* Append global search */
    // loadGlobalSearch($('#tableDeposito'))
  }

  // TABLE BGS
  function loadBGSGrid() {
    $("#tableBGS")
      .jqGrid({
        datatype: 'local',
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        colModel: [{
            label: "id",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "supir_id",
            name: "supir_id",
            hidden: true,
            search: false,
          },
          {
            label: "SUPIR",
            name: "supirbiaya",
            sortable: true,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
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
                  let originalGridData = $("#tableBGS")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tableBGS").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  let totalSisa
                  localRow.nominal = event.target.value;

                  let nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])

                  if (nominal < 0) {
                    showDialog('NOMINAL tidak boleh minus')
                    $("#tableBGS").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "nominal",
                      0
                    );
                    nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  }
                  nominalDetails = $(`#tableBGS tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tableBGS_nominal"]`)
                  ttlBayar = 0
                  $.each(nominalDetails, (index, nominalDetail) => {
                    ttlBayarDetail = parseFloat($(nominalDetail).attr('title').replaceAll(',', ''))
                    ttlBayars = (isNaN(ttlBayarDetail)) ? 0 : ttlBayarDetail;
                    ttlBayar += ttlBayars
                  });
                  ttlBayar += nominal
                  initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBGS_nominal"]`).text(ttlBayar))
                },
              }, ],
            },
            sortable: false,
            sorttype: "int",
          },
          {
            label: "KETERANGAN",
            name: "keteranganbll",
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
            sortable: false,
            editable: true,
            editoptions: {
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let localRow = $("#tableBGS").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  localRow.keteranganbll = event.target.value;
                }
              }, ]
            }
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
          let originalGridData = $("#tableBGS")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tableBGS").jqGrid("getLocalRow", rowId);
        },
        validationCell: function(cellobject, errormsg, iRow, iCol) {
          console.log(cellobject);
          console.log(errormsg);
          console.log(iRow);
          console.log(iCol);
        },
        loadComplete: function() {
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
          let localRow = $("#tableBGS").jqGrid("getLocalRow", rowId);

          $("#tableBGS").jqGrid(
            "setCell",
            rowId,
            "sisa",
            parseInt(localRow.sisa) + parseInt(localRow.nominal)
          );

          return true;
        },
      });
    /* Append clear filter button */
    loadClearFilter($('#tableBGS'))

    /* Append global search */
    // loadGlobalSearch($('#tableDeposito'))
  }

  // TABLE BIT
  function loadBITGrid() {
    $("#tableBIT")
      .jqGrid({
        datatype: 'local',
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        colModel: [{
            label: "id",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "supir_id",
            name: "supir_id",
            hidden: true,
            search: false,
          },
          {
            label: "SUPIR",
            name: "supirbiaya",
            sortable: true,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
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
                  let originalGridData = $("#tableBIT")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tableBIT").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  let totalSisa
                  localRow.nominal = event.target.value;

                  let nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])

                  if (nominal < 0) {
                    showDialog('NOMINAL tidak boleh minus')
                    $("#tableBIT").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "nominal",
                      0
                    );
                    nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  }
                  nominalDetails = $(`#tableBIT tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tableBIT_nominal"]`)
                  ttlBayar = 0
                  $.each(nominalDetails, (index, nominalDetail) => {
                    ttlBayarDetail = parseFloat($(nominalDetail).attr('title').replaceAll(',', ''))
                    ttlBayars = (isNaN(ttlBayarDetail)) ? 0 : ttlBayarDetail;
                    ttlBayar += ttlBayars
                  });
                  ttlBayar += nominal
                  initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBIT_nominal"]`).text(ttlBayar))
                },
              }, ],
            },
            sortable: false,
            sorttype: "int",
          },
          {
            label: "KETERANGAN",
            name: "keteranganbll",
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
            sortable: false,
            editable: true,
            editoptions: {
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let localRow = $("#tableBIT").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  localRow.keteranganbll = event.target.value;
                }
              }, ]
            }
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
          let originalGridData = $("#tableBIT")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tableBIT").jqGrid("getLocalRow", rowId);
        },
        validationCell: function(cellobject, errormsg, iRow, iCol) {
          console.log(cellobject);
          console.log(errormsg);
          console.log(iRow);
          console.log(iCol);
        },
        loadComplete: function() {
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
          let localRow = $("#tableBIT").jqGrid("getLocalRow", rowId);

          $("#tableBIT").jqGrid(
            "setCell",
            rowId,
            "sisa",
            parseInt(localRow.sisa) + parseInt(localRow.nominal)
          );

          return true;
        },
      });
    /* Append clear filter button */
    loadClearFilter($('#tableBIT'))

    /* Append global search */
    // loadGlobalSearch($('#tableDeposito'))
  }

  // TABLE BSM
  function loadBSMGrid() {
    $("#tableBSM")
      .jqGrid({
        datatype: 'local',
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        colModel: [{
            label: "id",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "supir_id",
            name: "supir_id",
            hidden: true,
            search: false,
          },
          {
            label: "SUPIR",
            name: "supirbiaya",
            sortable: true,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
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
                  let originalGridData = $("#tableBSM")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tableBSM").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  let totalSisa
                  localRow.nominal = event.target.value;

                  let nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])

                  if (nominal < 0) {
                    showDialog('NOMINAL tidak boleh minus')
                    $("#tableBSM").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "nominal",
                      0
                    );
                    nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  }
                  nominalDetails = $(`#tableBSM tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tableBSM_nominal"]`)
                  ttlBayar = 0
                  $.each(nominalDetails, (index, nominalDetail) => {
                    ttlBayarDetail = parseFloat($(nominalDetail).attr('title').replaceAll(',', ''))
                    ttlBayars = (isNaN(ttlBayarDetail)) ? 0 : ttlBayarDetail;
                    ttlBayar += ttlBayars
                  });
                  ttlBayar += nominal
                  initAutoNumeric($('.footrow').find(`td[aria-describedby="tableBSM_nominal"]`).text(ttlBayar))
                },
              }, ],
            },
            sortable: false,
            sorttype: "int",
          },
          {
            label: "KETERANGAN",
            name: "keteranganbll",
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
            sortable: false,
            editable: true,
            editoptions: {
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let localRow = $("#tableBSM").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  localRow.keteranganbll = event.target.value;
                }
              }, ]
            }
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
          let originalGridData = $("#tableBSM")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tableBSM").jqGrid("getLocalRow", rowId);
        },
        validationCell: function(cellobject, errormsg, iRow, iCol) {
          console.log(cellobject);
          console.log(errormsg);
          console.log(iRow);
          console.log(iCol);
        },
        loadComplete: function() {
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
          let localRow = $("#tableBSM").jqGrid("getLocalRow", rowId);

          $("#tableBSM").jqGrid(
            "setCell",
            rowId,
            "sisa",
            parseInt(localRow.sisa) + parseInt(localRow.nominal)
          );

          return true;
        },
      });
    /* Append clear filter button */
    loadClearFilter($('#tableBSM'))

    /* Append global search */
    // loadGlobalSearch($('#tableDeposito'))
  }


  // TABLE OTOK
  function loadOTOKGrid() {
    let disabled = '';
    if ($('#crudForm').data('action') == 'delete') {
      disabled = 'disabled'
    }
    $("#tableOTOK").jqGrid({
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
                dari = $('#crudForm').find(`[name="tgldari"]`).val()
                sampai = $('#crudForm').find(`[name="tglsampai"]`).val()
                let aksi = $('#crudForm').data('action')

                $(element).removeClass('form-control')
                $(element).parent().addClass('text-center')
                $(element).addClass('checkbox-selectall')
                if (disabled == '') {
                  $(element).on('click', function() {
                    if ($(this).is(':checked')) {
                      selectAllRowsOTOK()
                    } else {
                      clearSelectedRowsOTOK()
                    }
                  })
                } else {
                  $(element).attr('disabled', true)
                }

              }
            },
            formatter: (value, rowOptions, rowData) => {
              return `<input type="checkbox" class="checkbox-jqgrid" name="otokId[]" value="${rowData.id_detail}" ${disabled} onchange="checkboxOTOKHandler(this)">`
            },
          },
          {
            label: 'no invoice',
            name: 'noinvoice_detail',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'no job',
            name: 'nojobtrucking_detail',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'nominal',
            name: 'nominal_detail',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 400,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        footerrow: true,
        userDataOnFooter: true,
        toolbar: [true, "top"],
        sortable: true,
        sortname: sortnameOtok,
        sortorder: sortorderOtok,
        page: pageOtok,
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
          sortnameOtok = $(this).jqGrid("getGridParam", "sortname")
          sortorderOtok = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordOtok = $(this).getGridParam("records")
          limitOtok = $(this).jqGrid('getGridParam', 'postData').limit
          postDataOtok = $(this).jqGrid('getGridParam', 'postData')
          triggerClickOtok = true

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowOtok > $(this).getDataIDs().length - 1) {
            indexRowOtok = $(this).getDataIDs().length - 1;
          }

          setHighlight($(this))

          $.each(selectedRowsOtok, function(key, value) {
            $(grid).find('tbody tr').each(function(row, tr) {
              if ($(this).find(`td input:checkbox`).val() == value) {
                $(this).addClass('bg-light-blue')
                $(this).find(`td input:checkbox`).prop('checked', true)
              }
            })
          });
          setTotalNominalOTOK()

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
              tgldari: $('#crudForm [name=tgldari]').val(),
              tglsampai: $('#crudForm [name=tglsampai]').val(),
            },
          })
          clearGlobalSearch($('#tableOTOK'))
        },
        afterSearch: function() {
          console.log($(this).getGridParam())
        }
      })
      .customPager({})
    /* Append clear filter button */
    loadClearFilter($('#tableOTOK'))

    /* Append global search */
    loadGlobalSearch($('#tableOTOK'))
  }

  function checkboxOTOKHandler(element) {
    let value = $(element).val();
    if (element.checked) {
      selectedRowsOtok.push($(element).val())
      selectedRowsOtokNobukti.push($(element).parents('tr').find(`td[aria-describedby="tableOTOK_noinvoice_detail"]`).text())
      selectedRowsOtokJobtrucking.push($(element).parents('tr').find(`td[aria-describedby="tableOTOK_nojobtrucking_detail"]`).text())
      selectedRowsOtokNominal.push($(element).parents('tr').find(`td[aria-describedby="tableOTOK_nominal_detail"]`).text())

      $(element).parents('tr').addClass('bg-light-blue')
    } else {
      $(element).parents('tr').removeClass('bg-light-blue')
      for (var i = 0; i < selectedRowsOtok.length; i++) {
        if (selectedRowsOtok[i] == value) {
          selectedRowsOtok.splice(i, 1);
          selectedRowsOtokNobukti.splice(i, 1);
          selectedRowsOtokJobtrucking.splice(i, 1);
          selectedRowsOtokNominal.splice(i, 1);
        }
      }
    }

    setTotalNominalOTOK()
  }

  function setTotalNominalOTOK() {
    let nominal = 0
    $.each(selectedRowsOtok, (index, val) => {
      getNominal = selectedRowsOtokNominal[index];
      nominals = parseFloat(getNominal.replaceAll(',', ''))
      nominal += nominals

    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableOTOK_nominal_detail"]`).text(nominal))
  }

  function clearSelectedRowsOTOK() {
    selectedRowsOtok = []
    selectedRowsOtokNobukti = [];
    selectedRowsOtokJobtrucking = [];
    selectedRowsOtokNominal = [];
    $('#tableOTOK').trigger('reloadGrid')
  }

  function getDataOTOK() {
    if ($('#crudForm').data('action') == 'edit') {
      otokId = $(`#crudForm`).find(`[name="id"]`).val()
      urlOtok = `${otokId}/geteditotok`
    } else {
      urlOtok = 'getotok'
    }
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}pengeluarantruckingheader/${urlOtok}`,
        method: 'GET',
        dataType: 'JSON',
        data: {
          tgldari: $('#crudForm').find('[name=tgldari]').val(),
          tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
          agen_id: $('#crudForm').find('[name=agen_id]').val(),
          container_id: $('#crudForm').find('[name=containerheader_id]').val(),
          limit: 0
        },
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          if ($('#crudForm').data('action') == 'edit') {
            response.data.map((data) => {
              if (data.pengeluarantrucking_id != null) {
                selectedRowsOtok.push(data.id_detail)
                selectedRowsOtokNobukti.push(data.noinvoice_detail)
                selectedRowsOtokJobtrucking.push(data.nojobtrucking_detail)
                selectedRowsOtokNominal.push(data.nominal_detail)
              }
            })
          }
          response.url = urlOtok
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

  function selectAllRowsOTOK() {
    if ($('#crudForm').data('action') == 'edit') {
      otokId = $(`#crudForm`).find(`[name="id"]`).val()
      urlOtok = `${otokId}/geteditotok`
    } else {
      urlOtok = 'getotok'
    }
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}pengeluarantruckingheader/${urlOtok}`,
        method: 'GET',
        dataType: 'JSON',
        data: {
          tgldari: $('#crudForm').find('[name=tgldari]').val(),
          tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
          agen_id: $('#crudForm').find('[name=agen_id]').val(),
          container_id: $('#crudForm').find('[name=containerheader_id]').val(),
          limit: 0
        },
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          clearSelectedRowsOTOK()
          selectedRowsOtok = response.data.map((data) => data.id_detail)
          selectedRowsOtokNobukti = response.data.map((data) => data.noinvoice_detail)
          selectedRowsOtokJobtrucking = response.data.map((data) => data.nojobtrucking_detail)
          selectedRowsOtokNominal = response.data.map((data) => data.nominal_detail)

          // $('#tableOTOK').jqGrid("clearGridData");
          $('#tableOTOK').jqGrid('setGridParam', {
            url: `${apiUrl}pengeluarantruckingheader/${urlOtok}`,
            postData: {
              tgldari: $('#crudForm').find('[name=tgldari]').val(),
              tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
              agen_id: $('#crudForm').find('[name=agen_id]').val(),
              container_id: $('#crudForm').find('[name=containerheader_id]').val(),
              aksi: $('#crudForm').data('action')
            },
            datatype: "json"
          }).trigger('reloadGrid');
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
  // END OTOK


  // TABLE OTOL
  function loadOTOLGrid() {
    let disabled = '';
    if ($('#crudForm').data('action') == 'delete') {
      disabled = 'disabled'
    }
    $("#tableOTOL").jqGrid({
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
                dari = $('#crudForm').find(`[name="tgldari"]`).val()
                sampai = $('#crudForm').find(`[name="tglsampai"]`).val()
                let aksi = $('#crudForm').data('action')

                $(element).removeClass('form-control')
                $(element).parent().addClass('text-center')
                $(element).addClass('checkbox-selectall')
                if (disabled == '') {
                  $(element).on('click', function() {
                    if ($(this).is(':checked')) {
                      selectAllRowsOTOL()
                    } else {
                      clearSelectedRowsOTOL()
                    }
                  })
                } else {
                  $(element).attr('disabled', true)
                }

              }
            },
            formatter: (value, rowOptions, rowData) => {
              return `<input type="checkbox" class="checkbox-jqgrid" name="otolId[]" value="${rowData.id_detail}" ${disabled} onchange="checkboxOTOLHandler(this)">`
            },
          },
          {
            label: 'no invoice',
            name: 'noinvoice_detail',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'no job',
            name: 'nojobtrucking_detail',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'nominal',
            name: 'nominal_detail',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 400,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        footerrow: true,
        userDataOnFooter: true,
        toolbar: [true, "top"],
        sortable: true,
        sortname: sortnameOtol,
        sortorder: sortorderOtol,
        page: pageOtol,
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
          sortnameOtol = $(this).jqGrid("getGridParam", "sortname")
          sortorderOtol = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordOtol = $(this).getGridParam("records")
          limitOtol = $(this).jqGrid('getGridParam', 'postData').limit
          postDataOtol = $(this).jqGrid('getGridParam', 'postData')
          triggerClickOtol = true

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowOtol > $(this).getDataIDs().length - 1) {
            indexRowOtol = $(this).getDataIDs().length - 1;
          }

          setHighlight($(this))

          $.each(selectedRowsOtol, function(key, value) {
            $(grid).find('tbody tr').each(function(row, tr) {
              if ($(this).find(`td input:checkbox`).val() == value) {
                $(this).addClass('bg-light-blue')
                $(this).find(`td input:checkbox`).prop('checked', true)
              }
            })
          });
          setTotalNominalOTOL()

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
              tgldari: $('#crudForm [name=tgldari]').val(),
              tglsampai: $('#crudForm [name=tglsampai]').val(),
            },
          })
          clearGlobalSearch($('#tableOTOL'))
        },
        afterSearch: function() {
          console.log($(this).getGridParam())
        }
      })
      .customPager({})
    /* Append clear filter button */
    loadClearFilter($('#tableOTOL'))

    /* Append global search */
    loadGlobalSearch($('#tableOTOL'))
  }

  function checkboxOTOLHandler(element) {
    let value = $(element).val();
    if (element.checked) {
      selectedRowsOtol.push($(element).val())
      selectedRowsOtolNobukti.push($(element).parents('tr').find(`td[aria-describedby="tableOTOL_noinvoice_detail"]`).text())
      selectedRowsOtolJobtrucking.push($(element).parents('tr').find(`td[aria-describedby="tableOTOL_nojobtrucking_detail"]`).text())
      selectedRowsOtolNominal.push($(element).parents('tr').find(`td[aria-describedby="tableOTOL_nominal_detail"]`).text())

      $(element).parents('tr').addClass('bg-light-blue')
    } else {
      $(element).parents('tr').removeClass('bg-light-blue')
      for (var i = 0; i < selectedRowsOtol.length; i++) {
        if (selectedRowsOtol[i] == value) {
          selectedRowsOtol.splice(i, 1);
          selectedRowsOtolNobukti.splice(i, 1);
          selectedRowsOtolJobtrucking.splice(i, 1);
          selectedRowsOtolNominal.splice(i, 1);
        }
      }
    }

    setTotalNominalOTOL()
  }

  function setTotalNominalOTOL() {
    let nominal = 0
    $.each(selectedRowsOtol, (index, val) => {
      getNominal = selectedRowsOtolNominal[index];
      nominals = parseFloat(getNominal.replaceAll(',', ''))
      nominal += nominals

    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableOTOL_nominal_detail"]`).text(nominal))
  }

  function clearSelectedRowsOTOL() {
    selectedRowsOtol = []
    selectedRowsOtolNobukti = [];
    selectedRowsOtolJobtrucking = [];
    selectedRowsOtolNominal = [];
    $('#tableOTOL').trigger('reloadGrid')
  }

  function getDataOTOL() {
    if ($('#crudForm').data('action') == 'edit') {
      otolId = $(`#crudForm`).find(`[name="id"]`).val()
      urlOtol = `${otolId}/geteditotol`
    } else {
      urlOtol = 'getotol'
    }
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}pengeluarantruckingheader/${urlOtol}`,
        method: 'GET',
        dataType: 'JSON',
        data: {
          tgldari: $('#crudForm').find('[name=tgldari]').val(),
          tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
          agen_id: $('#crudForm').find('[name=agen_id]').val(),
          container_id: $('#crudForm').find('[name=containerheader_id]').val(),
          limit: 0
        },
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          if ($('#crudForm').data('action') == 'edit') {

            // console.log('getDataOTOL',response)
            response.data.map((data) => {
              if (data.pengeluarantrucking_id != null) {
                selectedRowsOtol.push(data.id_detail)
                selectedRowsOtolNobukti.push(data.noinvoice_detail)
                selectedRowsOtolJobtrucking.push(data.nojobtrucking_detail)
                selectedRowsOtolNominal.push(data.nominal_detail)
              }
            })
          }
          response.url = urlOtol
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

  function selectAllRowsOTOL() {
    if ($('#crudForm').data('action') == 'edit') {
      otolId = $(`#crudForm`).find(`[name="id"]`).val()
      urlOtol = `${otolId}/geteditotol`
    } else {
      urlOtol = 'getotol'
    }
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}pengeluarantruckingheader/${urlOtol}`,
        method: 'GET',
        dataType: 'JSON',
        data: {
          tgldari: $('#crudForm').find('[name=tgldari]').val(),
          tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
          agen_id: $('#crudForm').find('[name=agen_id]').val(),
          container_id: $('#crudForm').find('[name=containerheader_id]').val(),
          limit: 0
        },
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          clearSelectedRowsOTOL()
          selectedRowsOtol = response.data.map((data) => data.id_detail)
          selectedRowsOtolNobukti = response.data.map((data) => data.noinvoice_detail)
          selectedRowsOtolJobtrucking = response.data.map((data) => data.nojobtrucking_detail)
          selectedRowsOtolNominal = response.data.map((data) => data.nominal_detail)

          // $('#tableOTOK').jqGrid("clearGridData");
          $('#tableOTOL').jqGrid('setGridParam', {
            url: `${apiUrl}pengeluarantruckingheader/${urlOtol}`,
            postData: {
              tgldari: $('#crudForm').find('[name=tgldari]').val(),
              tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
              agen_id: $('#crudForm').find('[name=agen_id]').val(),
              container_id: $('#crudForm').find('[name=containerheader_id]').val(),
              aksi: $('#crudForm').data('action')
            },
            datatype: "json"
          }).trigger('reloadGrid');
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
  // END OTOL
  function resetGrid() {
    $('#detail-list-grid').html('');
    $('#modalgrid').jqGrid('clearGridData')
  }

  function deleteRow(row) {
    let countRow = $('.delete-row').parents('tr').length
    row.remove()
    if (countRow <= 1) {
      addRow()
    }

    setRowNumbers()
    setTotal()
    if (KodePengeluaranId == 'KLAIM') {
      setTotalKlaim()
      setTotalTambahan()
    }
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function lookupSelected(el) {
    switch (el) {
      case 'trado':
        $('#crudForm').find(`[name="gandengan"]`).attr('disabled', true)
        $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().attr('disabled', true)
        $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
        $('#gandenganHaeaderId').attr('disabled', true);
        break;
      case 'gandengan':
        $('#crudForm').find(`[name="trado"]`).attr('disabled', true)
        $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().attr('disabled', true)
        $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
        $('#tradoHaeaderId').attr('disabled', true);
      default:
        break;
    }
  }

  function enabledKorDisable() {
    $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().attr("disabled", false);
    $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().find(`.lookup-toggler`).attr("disabled", false);
    $('#tradoHaeaderId').attr('disabled', false);
    $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().attr("disabled", false);
    $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().find(`.lookup-toggler`).attr("disabled", false);
    $('#gandenganHaeaderId').attr('disabled', false);
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}pengeluarantruckingheader/field_length`,
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

  function cal(element) {
    console.log(element.val())
    // qty = $(`#qty_${id}`)[0];
    // harga = $(`#harga_${id}`)[0];

    // qty = AutoNumeric.getNumber(qty);
    // harga = AutoNumeric.getNumber(harga);
    // console.log(harga);
    // total = qty * harga;
    // // nominaldiscount = total * (discount / 100);
    // // total -= nominaldiscount;
    // // new AutoNumeric($(`#nominal_${id}`)[0]).set(total)
    // $(`#totalharga_${id}`).val(total)
    // initAutoNumeric($(`#totalharga_${id}`))
    // setTotal()
  }

  function initLookup() {

    $('.pengeluarantrucking-lookup').lookup({
      title: 'Pengeluaran Trucking Lookup',
      fileName: 'pengeluarantrucking',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          roleInput: 'role',
          Aktif: 'AKTIF',
          isLookup: true
        }
      },
      onSelectRow: (pengeluarantrucking, element) => {
        setKodePengeluaran(pengeluarantrucking.kodepengeluaran)
        if (pengeluarantrucking.kodepengeluaran == "TDE") {
          deleteRow($('#table_body tr')[0]);
        }
        $('#crudForm [name=coa]').first().val(pengeluarantrucking.coapostingdebet)
        $('#crudForm [name=pengeluarantrucking_id]').first().val(pengeluarantrucking.id)
        element.val(pengeluarantrucking.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        KodePengeluaranId = ""
        $('#crudForm [name=pengeluarantrucking_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    // $('.pengeluarantrucking-lookup').lookupMaster({
    //   title: 'pengeluaran trucking Lookup',
    //   fileName: 'pengeluarantruckingMaster',
    //   typeSearch: 'ALL',
    //   searching: 1,
    //   beforeProcess: function(test) {
    //     this.postData = {
    //       Aktif: 'AKTIF',
    //       searching: 1,
    //       valueName: 'pengeluarantrucking_id',
    //       searchText: 'pengeluarantrucking-lookup',
    //       title: 'Pengeluaran Trucking',
    //       typeSearch: 'ALL',
    //       roleInput: 'role',
    //       isLookup: true
    //     }
    //   },
    //   onSelectRow: (pengeluarantrucking, element) => {
    //     $('#crudForm [name=pengeluarantrucking_id]').first().val(pengeluarantrucking.id)
    //     element.val(pengeluarantrucking.keterangan)
    //     element.data('currentValue', element.val())
    //   },
    //   onCancel: (element) => {
    //     element.val(element.data('currentValue'))
    //   },
    //   onClear: (element) => {
    //     $('#crudForm [name=pengeluarantrucking_id]').first().val('')
    //     element.val('')
    //     element.data('currentValue', element.val())
    //   }
    // })
    $('.bank-lookup').lookup({
      title: 'Bank Lookup',
      fileName: 'bank',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
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
        $('#crudForm [name=bank_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
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
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=agen_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.containerheader-lookup').lookup({
      title: 'Container Lookup',
      fileName: 'container',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (container, element) => {
        $('#crudForm [name=containerheader_id]').first().val(container.id)
        element.val(container.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=containerheader_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.supirheader-lookup').last().lookup({
      title: 'Supir Lookup',
      fileName: 'supir',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (supir, element) => {
        $(`#supirheaderId`).val(supir.id)
        element.val(supir.namasupir)
        element.data('currentValue', element.val())

        $("#tableDeposito")[0].p.selectedRowIds = [];
        $('#tableDeposito').jqGrid("clearGridData");
        $("#tableDeposito")
          .jqGrid("setGridParam", {
            selectedRowIds: []
          })
          .trigger("reloadGrid");

        getDataDeposito(supir.id).then((response) => {

          console.log('before', $("#tableDeposito").jqGrid('getGridParam', 'selectedRowIds'))
          setTimeout(() => {

            $("#tableDeposito")
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
        $(`#supirheaderId`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.karyawanheader-lookup').last().lookup({
      title: 'Karyawan Lookup',
      fileName: 'karyawan',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (karyawan, element) => {
        $(`#karyawanheaderId`).val(karyawan.id)
        element.val(karyawan.namakaryawan)
        element.data('currentValue', element.val())

        $("#tableDepositoKaryawan")[0].p.selectedRowIds = [];
        $('#tableDepositoKaryawan').jqGrid("clearGridData");
        $("#tableDepositoKaryawan")
          .jqGrid("setGridParam", {
            selectedRowIds: []
          })
          .trigger("reloadGrid");

        getDataDepositoKaryawan(karyawan.id).then((response) => {

          console.log('before', $("#tableDepositoKaryawan").jqGrid('getGridParam', 'selectedRowIds'))
          setTimeout(() => {

            $("#tableDepositoKaryawan")
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
        $(`#karyawanheaderId`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.tradoheader-lookup').last().lookup({
      title: 'TRADO Lookup',
      fileName: 'trado',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          cabang: statuscabang,
          Aktif: 'AKTIF',
          url: urlTNL,
          token: tokenTNL,
        }
      },
      onSelectRow: (trado, element) => {
        $(`#tradoHaeaderId`).val(trado.id)
        element.val(trado.kodetrado)
        element.data('currentValue', element.val())
        lookupSelected(`trado`);

      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#tradoHaeaderId`).val('')
        element.val('')
        element.data('currentValue', element.val())
        enabledKorDisable()
      }
    })
    $('.gandenganheader-lookup').last().lookup({
      title: 'gandengan Lookup',
      fileName: 'gandengan',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          cabang: statuscabang,
          Aktif: 'AKTIF',
          url: urlTNL,
          token: tokenTNL,
        }
      },
      onSelectRow: (gandengan, element) => {
        $(`#gandenganHaeaderId`).val(gandengan.id)
        element.val(gandengan.keterangan)
        element.data('currentValue', element.val())
        lookupSelected(`gandengan`);
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#gandenganHaeaderId`).val('')
        element.val('')
        element.data('currentValue', element.val())
        enabledKorDisable()
      }
    })

    $('.pengeluaran-lookup').lookup({
      title: 'Pengeluaran Lookup',
      fileName: 'pengeluaranheader',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (pengeluaranheader, element) => {
        element.val(pengeluaranheader.nobukti)
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

    $('.akunpusat-lookup').lookup({
      title: 'Kode Perk. Lookup',
      fileName: 'akunpusat',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          levelCoa: '3',
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


    $('.jenisorderan-lookup').last().lookup({
      title: 'jenis orderan Lookup',
      fileName: 'jenisorder',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',

        }
      },
      onSelectRow: (jenisorder, element) => {
        $(`#crudForm [name="jenisorderan_id"]`).last().val(jenisorder.id)
        element.val(jenisorder.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#crudForm [name="jenisorderan_id[]"]`).last().val('')
        element.data('currentValue', element.val())
      }
    })
  }
  const setStatusPostingOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusposting]').empty()
      relatedForm.find('[name=statusposting]').append(
        new Option('-- PILIH STATUS Posting --', '', false, true)
      ).trigger('change')
      $.ajax({
        url: `${apiUrl}parameter/combo`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          grp: 'STATUS POSTING',
          subgrp: 'STATUS POSTING',
        },
        success: response => {
          response.data.forEach(statusPosting => {
            let option = new Option(statusPosting.text, statusPosting.id)
            relatedForm.find('[name=statusposting]').append(option).trigger('change')
            if (statusPosting.text === "POSTING") {
              parameterPosting = statusPosting.id
            }
          });
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }
  const setPostingPinjamanOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=postingpinjaman]').empty()
      relatedForm.find('[name=postingpinjaman]').append(
        new Option('-- PILIH Posting Pinjaman --', '', false, true)
      ).trigger('change')
      $.ajax({
        url: `${apiUrl}parameter/combo`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          grp: 'STATUS POSTING',
          subgrp: 'STATUS POSTING',
        },
        success: response => {
          response.data.forEach(postingPinjaman => {
            let option = new Option(postingPinjaman.text, postingPinjaman.id)
            relatedForm.find('[name=postingpinjaman]').append(option).trigger('change')
            if (postingPinjaman.text === "POSTING") {
              parameterPosting = postingPinjaman.id
            }
          });
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  const setStatusCabangOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuscabang]').empty()
      relatedForm.find('[name=statuscabang]').append(
        new Option('-- PILIH CABANG --', '', false, true)
      ).trigger('change')
      $.ajax({
        url: `${apiUrl}parameter/combo`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          grp: 'LIST CABANG',
          subgrp: 'LIST CABANG',
        },
        success: response => {
          response.data.forEach(postingPinjaman => {
            let option = new Option(postingPinjaman.text, postingPinjaman.id)
            relatedForm.find('[name=statuscabang]').append(option).trigger('change')

          });
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function pengeluaranTrucking(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}pengeluarantrucking`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0
        },
        success: response => {
          $.each(response.data, (index, data) => {
            listIdPengeluaran[index] = data.id;
            listKodePengeluaran[index] = data.kodepengeluaran;
            listKeteranganPengeluaran[index] = data.keterangan;
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
        value: 'PENGELUARAN TRUCKING'
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

  let dataStatusBiaya = [];
  const setStatusBiayaTitipanOptions = function() {
    return new Promise((resolve, reject) => {

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
              "data": "BIAYA TITIPAN EMKL"
            }]
          })
        },
        success: response => {
          dataStatusBiaya = response.data
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function lookupSelectedSpkPG(row, el) {
    let spk = $('#crudForm').find(`#pengeluaranstok_nobukti_${row}`).parents('.input-group').children()
    let pg = $('#crudForm').find(`#penerimaanstok_nobukti_${row}`).parents('.input-group').children()
    console.log(spk, pg);
    console.log(row);

    switch (el) {
      case 'SPK':
        pg.attr('disabled', true)
        pg.find('.lookup-toggler').attr('disabled', true)

        break;
      case 'PG':
        spk.attr('disabled', true)
        spk.find('.lookup-toggler').attr('disabled', true)

        break;
      default:
        break;
    }
  }

  function enabledLookupSpkPG(row) {
    let spk = $('#crudForm').find(`#pengeluaranstok_nobukti_${row}`).parents('.input-group').children()
    let pg = $('#crudForm').find(`#penerimaanstok_nobukti_${row}`).parents('.input-group').children()

    spk.attr('disabled', false)
    spk.find('.lookup-toggler').attr('disabled', false)
    pg.attr('disabled', false)
    pg.find('.lookup-toggler').attr('disabled', false)


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
        value: 'PENGELUARAN TRUCKING HEADER'
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
            classHidden = memo;
          }
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