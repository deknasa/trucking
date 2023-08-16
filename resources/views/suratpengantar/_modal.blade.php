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
            <div class="row">
              <div class="col-md-4">
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">NO TRANSAKSI </label>
                  <div class="col-sm-12">
                    <input type="text" name="nobukti" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">TGL TRIP <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <div class="input-group">
                      <input type="text" name="tglbukti" class="form-control datepicker">
                    </div>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">JOB TRUCKING <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="jobtrucking" class="form-control orderantrucking-lookup">
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
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">GUDANG SAMA <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <select name="statusgudangsama" class="form-control select2bs4" id="statusgudangsama">
                      <option value="">-- PILIH STATUS GUDANG SAMA --</option>
                    </select>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">UPAH ZONA <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <select name="statusupahzona" class="form-control select2bs4" id="statusupahzona">
                      <option value="">-- PILIH STATUS UPAH ZONA --</option>
                    </select>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">EMKL <span class="text-danger">*</span></label>
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
                  <label class="col-sm-12 col-form-label">CONTAINER <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="container_id">
                    <input type="text" name="container" class="form-control container-lookup">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">UPAH SUPIR <span class="text-danger">*</span></label>
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
                  <label class="col-sm-12 col-form-label">DARI <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="dari_id">
                    <input type="text" name="dari" class="form-control kotadari-lookup" readonly>
                  </div>
                </div>

              </div>
              <div class="col-md-4">
                <!-- <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Ritasi omset<span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <select name="statusritasiomset" class="form-control select2bs4" id="statusritasiomset">
                      <option value="">-- PILIH STATUS RITASI OMSET --</option>
                    </select>
                  </div>
                </div> -->
                <!-- <div class="form-group ">
                  <label class="col-sm-12 col-form-label">NO SP 2</label>
                  <div class="col-sm-12">
                    <input type="text" name="nosp2" class="form-control">
                  </div>
                </div> -->

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">SAMPAI <span class="text-danger">*</span></label>
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
                  <label class="col-sm-12 col-form-label">NO POLISI <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="trado_id">
                    <input type="hidden" name="absensidetail_id">
                    <input type="text" name="trado" class="form-control absensisupirdetail-lookup">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">SUPIR <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="supir_id">
                    <input type="text" name="supir" class="form-control supir-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">PELANGGAN <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="pelanggan_id">
                    <input type="text" name="pelanggan" class="form-control pelanggan-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">STATUS GANDENGAN <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <select name="statusgandengan" class="form-control select2bs4" id="statusgandengan">
                      <option value="">-- PILIH STATUS GANDENGAN --</option>
                    </select>
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">NO GANDENGAN / CHASIS</label>
                  <div class="col-sm-12">
                    <input type="hidden" name="gandengan_id">
                    <input type="text" name="gandengan" class="form-control gandengan-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">GUDANG <span class="text-danger"></span></label>
                  <div class="col-sm-12">
                    <input type="text" name="gudang" class="form-control">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">NO SP <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="nosp" class="form-control">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">NO CONTAINER (1)</label>
                  <div class="col-sm-12">
                    <input type="text" name="nocont" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">NO SEAL (1)</label>
                  <div class="col-sm-12">
                    <input type="text" name="noseal" class="form-control" readonly>
                  </div>
                </div>
              </div>
              <div class="col-md-4">

                <div class="col-md-12">
                  <div class="card mt-3">
                    <div class="card-header bg-info">
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label class="col-sm-12 col-form-label">Status Peralihan<span class="text-danger">*</span></label>
                        <div class="col-sm-12">
                          <select name="statusperalihan" class="form-control select2bs4" id="statusperalihan">
                            <option value="">-- PILIH STATUS PERALIHAN --</option>
                          </select>
                        </div>
                      </div>
                      <div id="peralihan">
                        <div class="form-group">
                          <label class="col-sm-12 col-form-label">Nominal Peralihan</label>
                          <div class="col-md-12" id="nominalPeralihanDiv">
                            <input type="text" name="nominalperalihan" class="form-control text-right" readonly>
                            <input type="hidden" name="omset">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">

                        <div class="col-md-6" id="persentasePeralihanDiv">
                          <div class="input-group" id="persentaseInputGroup">
                            <input type="text" name="persentaseperalihan" onkeyup="setNominal()" class="form-control" readonly>
                            <div class="input-group-append">
                              <span class="input-group-text">%</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">NO CONTAINER (2)</label>
                  <div class="col-sm-12">
                    <input type="text" name="nocont2" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">NO SEAL (2)</label>
                  <div class="col-sm-12">
                    <input type="text" name="noseal2" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">NO JOB (1)</label>
                  <div class="col-sm-12">
                    <input type="text" name="nojob" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">NO JOB (2)</label>
                  <div class="col-sm-12">
                    <input type="text" name="nojob2" class="form-control" readonly>
                  </div>
                </div>
                <!-- <div class="form-group ">
                  <label class="col-sm-12 col-form-label">CABANG</label>
                  <div class="col-sm-12">
                    <input type="hidden" name="cabang_id">
                    <input type="text" name="cabang" class="form-control cabang-lookup">
                  </div>
                </div> -->

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">KETERANGAN</label>
                  <div class="col-sm-12">
                    <input type="text" name="keterangan" class="form-control">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">HARGA PER TON</label>
                  <div class="col-sm-12">
                    <input type="text" name="hargaperton" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">QTY TON<span class="text-danger"></span></label>
                  <div class="col-sm-12">
                    <input type="text" name="qtyton" class="form-control">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">BATAL MUAT<span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <select name="statusbatalmuat" class="form-control select2bs4" id="statusbatalmuat">
                      <option value="">-- PILIH STATUS BATAL MUAT --</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>


            <div class="card">
              <div class="card-header bg-info">
                Biaya
              </div>
              <div class="card-body">
                <div class="row form-group">
                  <div class="col-12 col-md-2">
                    <label class="col-form-label">
                      GAJI SUPIR </label>
                  </div>
                  <div class="col-12 col-md-4">
                    <input type="text" name="gajisupir" id="gajisupir" class="form-control autonumeric" readonly>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-12 col-md-2">
                    <label class="col-form-label">
                      GAJI KENEK </label>
                  </div>
                  <div class="col-12 col-md-4">
                    <input type="text" name="gajikenek" id="gajikenek" class="form-control autonumeric" readonly>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-12 col-md-2">
                    <label class="col-form-label">
                      KOMISI SUPIR </label>
                  </div>
                  <div class="col-12 col-md-4">
                    <input type="text" name="komisisupir" id="komisisupir" class="form-control autonumeric" readonly>
                  </div>
                </div>


                <h3 class="text-center">Biaya Tambahan</h3>

                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="detailList" class="table table-bordered table-bindkeys" style="width: 800;">
                        <thead>
                          <tr>
                            <th width="1%">No</th>
                            <th width="60%">Keterangan</th>
                            <th width="19%">Nominal Supir</th>
                            <th width="19%">Nominal Tagih</th>
                            <th width="1%">Aksi</th>
                          </tr>
                        </thead>
                        <tbody class="form-group">
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="2">
                              <p class="text-right font-weight-bold">TOTAL :</p>
                            </td>
                            <td>
                              <p class="text-right font-weight-bold autonumeric" id="total"></p>
                            </td>
                            <td>
                              <p class="text-right font-weight-bold autonumeric" id="totalTagih"></p>
                            </td>
                            <td>
                              <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">TAMBAH</button>
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
            <button type="button" id="btnSubmit" class="btn btn-primary">
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
  var isAllowEdited;
  let statuscontainerId
  let jenisorderId
  let kotadariId
  let kotasampaiId
  let pilihKotaDariId = 0;
  let pilihKotaSampaiId = 0;
  let containerId
  let nominalPlusBorongan = 0;
  let nominalSupir = 0;
  let totalNominalSupir = 0;
  let statusUpahZona
  let selectedUpahZona
  let zonadariId
  let zonasampaiId
  let isShow = false
  let upahId = 0
  let editUpahZona
  let indexDetail = 0
  $(document).ready(function() {

    // $(document).on('input', `#crudForm [name="nominalperalihan"]`, function(event) {
    //   setPersentase()
    // })
    // $(document).on('input', `#crudForm [name="persentaseperalihan"]`, function(event) {
    //   setNominal()
    // })

    $(document).on('change', `#crudForm [name="statusupahzona"]`, function(event) {
      selectedUpahZona = $(`#crudForm [name="statusupahzona"] option:selected`).text()
      if (selectedUpahZona == 'NON UPAH ZONA' || selectedUpahZona == 'UPAH ZONA') {
        statusUpahZona = $(`#crudForm [name="statusupahzona"]`).val()
        if (!isShow) {
          $('#crudForm [name=upah_id]').val('')
          $('#crudForm [name=upah]').val('').data('currentValue', '')
          enabledUpahSupir()
          clearUpahSupir()
        }
      }
    })
    $("#crudForm [name]").attr("autocomplete", "off");

    $(document).on('click', "#addRow", function() {
      addRow()
    });

    // $(document).on('input', `#crudForm [name="qtyton"]`, function(event) {

    //   let qtyton = AutoNumeric.getNumber($(this)[0])
    //   let omset = AutoNumeric.getNumber($(`#crudForm [name="omset"]`)[0])
    //   let total = qtyton * omset

    //   $(`#crudForm [name="totalton"]`).val(total)
    //   initAutoNumeric($(`#crudForm [name="totalton"]`))
    //   console.log(total)
    // })

    $(document).on('change', '#statusperalihan', function(event) {
      let status = $("#statusperalihan option:selected").text()
      console.log('before', isShow)

      if (!isShow) {
        console.log('isshow', isShow)
        if (status == 'PERALIHAN') {
          // $(`#crudForm [name="nominalperalihan"]`).prop('readonly', false)
          $(`#crudForm [name="persentaseperalihan"]`).prop('readonly', false)
          $(`#crudForm [name="nominalperalihan"]`).remove()
          $(`#persentaseInputGroup`).remove()

          $('#nominalPeralihanDiv').append(`
        <input type="text" name="nominalperalihan" class="form-control text-right" readonly>
        `)
          $('#persentasePeralihanDiv').append(`
          <div class="input-group" id="persentaseInputGroup">
            <input type="text" name="persentaseperalihan" onkeyup="setNominal()" class="form-control">
            <div class="input-group-append">
              <span class="input-group-text">%</span>
            </div>
          </div>
        `)
          initAutoNumeric($('#crudForm').find('[name="persentaseperalihan"]'))
        } else if (status == 'BUKAN PERALIHAN') {
          // $(`#crudForm [name="nominalperalihan"]`).prop('readonly', true)
          $(`#crudForm [name="persentaseperalihan"]`).prop('readonly', true)

          $(`#crudForm [name="nominalperalihan"]`).remove()
          $(`#persentaseInputGroup`).remove()

          $('#nominalPeralihanDiv').append(`
        <input type="text" name="nominalperalihan" class="form-control text-right" readonly>
        `)
          $('#persentasePeralihanDiv').append(`
          <div class="input-group" id="persentaseInputGroup">
            <input type="text" name="persentaseperalihan" onkeyup="setNominal()" class="form-control" readonly>
            <div class="input-group-append">
              <span class="input-group-text">%</span>
            </div>
          </div>
        `)
          initAutoNumeric($('#crudForm').find('[name="persentaseperalihan"]'))
        }
      }
    })
    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })


    $(document).on('input', `#detailList [name="nominal[]"]`, function(event) {
      setTotal()
    })

    $(document).on('input', `#detailList [name="nominalTagih[]"]`, function(event) {
      setTotalTagih()
    })


    $(document).on('click', `#btnSubmit`, function(event) {
      event.preventDefault()
      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      if (!isAllowEdited) {
        data.push({
          name: 'statusupahzona',
          value: editUpahZona
        })
      }
      $('#crudForm').find(`[name="nominal[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominal[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[index])
      })
      $('#crudForm').find(`[name="nominalTagih[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominalTagih[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominalTagih[]"]`)[index])
      })
      // $('#crudForm').find(`[name="nominalperalihan"]`).each((index, element) => {
      //   data.filter((row) => row.name === 'nominalperalihan')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominalperalihan"]:not([disabled])`)[index])
      // })

      if ($("#statusperalihan option:selected").text() == 'PERALIHAN') {
        // $('#crudForm').find(`[name="nominalperalihan"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominalperalihan')[0].value = AutoNumeric.getNumber($(`#crudForm [name="nominalperalihan"]`)[0])
        // })

        data.filter((row) => row.name === 'persentaseperalihan')[0].value = AutoNumeric.getNumber($(`#crudForm [name="persentaseperalihan"]`)[0])
      }
      // $('#crudForm').find(`[name="qtyton"]`).each((index, element) => {
      data.filter((row) => row.name === 'qtyton')[0].value = AutoNumeric.getNumber($(`#crudForm [name="qtyton"]`)[0])
      // })

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
          url = `${apiUrl}suratpengantar`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}suratpengantar/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}suratpengantar/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}suratpengantar`
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

          if (response.data.grp == 'FORMAT') {
            updateFormat(response.data)
          }
        },
        error: error => {
          console.log('postdata ', error)
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

  function getNominalSupir() {
    totalNominalSupir = nominalPlusBorongan + nominalSupir;

    $('#crudForm [name=gajisupir]').val(totalNominalSupir)
    initAutoNumeric($('#crudForm').find('[name="gajisupir"]'))
  }

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null
    getMaxLength(form)
    initLookup()
    initDatepicker()
    initSelect2(form.find('.select2bs4'), true)
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'

    $('#crudModal').find('.modal-body').html(modalBody)
  })


  function setPersentase() {
    let nominalDetails = $(`#crudForm [name="nominalperalihan"]`)
    let omset = $(`#crudForm [name="omset"]`).val()
    let total = 0

    // const autoNumericInstance = AutoNumeric.getAutoNumericElement($(`#crudForm [name="persentaseperalihan"]`));
    // AutoNumeric.isManagedByAutoNumeric(domElementOrSelector);
    // if (autoNumericInstance) {
    //   autoNumericInstance.destroy();
    // }
    total = (AutoNumeric.getNumber(nominalDetails[0]) / omset) * 100;
    console.log(total)
    new AutoNumeric($(`#crudForm [name="persentaseperalihan"]`)[0]).set(total)
    // initAutoNumeric($(`#crudForm [name="persentaseperalihan"]`).val(total))
  }

  function setNominal() {
    let persentase = $(`#crudForm [name="persentaseperalihan"]`)
    let omset = $(`#crudForm [name="omset"]`).val()
    console.log(persentase)
    // console.log(omset,(AutoNumeric.getNumber(persentase[0]) / 100) * omset)

    totalPersentase = (AutoNumeric.getNumber(persentase[0]) / 100) * omset;
    // $(`#crudForm [name="nominalperalihan"]`).val(totalPersentase)

    new AutoNumeric($(`#crudForm [name="nominalperalihan"]`)[0]).set(totalPersentase)
    // initAutoNumeric($(`#crudForm [name="nominalperalihan"]`).val(totalPersentase))
  }

  function setTotal() {
    let nominalDetails = $(`#detailList [name="nominal[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)
  }

  function setTotalTagih() {
    let nominalDetails = $(`#detailList [name="nominalTagih[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#totalTagih').set(total)
  }

  function createSuratPengantar() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    $('#crudModalTitle').text('Create Surat Pengantar')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=tglsp]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        setStatusLongTripOptions(form),
        setStatusPeralihanOptions(form),
        setStatusGudangSamaOptions(form),
        setStatusBatalMuatOptions(form),
        setStatusGandenganOptions(form)
      ])
      .then(() => {
        showDefault(form)
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

    addRow()
    setTotal()
    setTotalTagih()

    initAutoNumeric(form.find(`[name="nominalTagih"]`))
    initAutoNumeric(form.find(`[name="qtyton"]`))
    initAutoNumeric(form.find(`[name="nominalperalihan"]`))
  }

  function editSuratPengantar(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Surat Pengantar')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusLongTripOptions(form),
        setStatusPeralihanOptions(form),
        setStatusGudangSamaOptions(form),
        setStatusBatalMuatOptions(form),
        setStatusGandenganOptions(form),
        setStatusUpahZonaOptions(form)
      ])
      .then(() => {
        showSuratPengantar(form, id)
          .then(() => {
            $('#crudModal').modal('show')
            $('#crudForm [name=tglbukti]').attr('readonly', true)
            $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()
            inputReadOnly()
            editValidasi(isAllowEdited);
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function deleteSuratPengantar(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Surat Pengantar')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusLongTripOptions(form),
        setStatusPeralihanOptions(form),
        setStatusGudangSamaOptions(form),
        setStatusBatalMuatOptions(form)
      ])
      .then(() => {
        showSuratPengantar(form, id)
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

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}suratpengantar/field_length`,
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

  const setStatusPeralihanOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusperalihan]').empty()
      relatedForm.find('[name=statusperalihan]').append(
        new Option('-- PILIH STATUS PERALIHAN --', '', false, true)
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
              "data": "STATUS PERALIHAN"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusPeralihan => {
            let option = new Option(statusPeralihan.text, statusPeralihan.id)

            relatedForm.find('[name=statusperalihan]').append(option).trigger('change')
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

  const setStatusBatalMuatOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusbatalmuat]').empty()
      relatedForm.find('[name=statusbatalmuat]').append(
        new Option('-- PILIH STATUS BATAL MUAT --', '', false, true)
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
              "data": "STATUS BATAL MUAT"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusBatalMuat => {
            let option = new Option(statusBatalMuat.text, statusBatalMuat.id)

            relatedForm.find('[name=statusbatalmuat]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  // function getGaji(plusBorongan) {
  //   let form = $('#crudForm')
  //   let data = []

  //   let dari = form.find(`[name="dari_id"]`).val()
  //   let sampai = form.find(`[name="sampai_id"]`).val()
  //   let container = form.find(`[name="container_id"]`).val()
  //   let statuscontainer = form.find(`[name="statuscontainer_id"]`).val()


  //   $.ajax({
  //     url: `${apiUrl}suratpengantar/getGaji/${dari}/${sampai}/${container}/${statuscontainer}`,
  //     method: 'GET',
  //     dataType: 'JSON',
  //     data: data,
  //     headers: {
  //       Authorization: `Bearer ${accessToken}`
  //     },
  //     success: response => {
  //       totalBorongan = response.data.nominalsupir
  //       if (plusBorongan != undefined) {
  //         plusBorongan = parseInt(parseFloat(plusBorongan.replace(/,/g, '')))
  //         totalBorongan = plusBorongan + parseFloat(response.data.nominalsupir)
  //       }
  //       form.find(`[name="gajisupir"]`).val(totalBorongan)
  //       form.find(`[name="gajikenek"]`).val(response.data.nominalkenek)
  //       form.find(`[name="komisisupir"]`).val(response.data.nominalkomisi)

  //       initAutoNumeric($(form).find('[name="gajisupir"]'))
  //       initAutoNumeric($(form).find('[name="gajikenek"]'))
  //       initAutoNumeric($(form).find('[name="komisisupir"]'))
  //     },
  //     error: error => {
  //       if (error.status === 422) {
  //         $('.is-invalid').removeClass('is-invalid')
  //         $('.invalid-feedback').remove()

  //         setErrorMessages(form, error.responseJSON.errors);
  //         showDialog(error.responseJSON.message)
  //       }
  //     },
  //   })
  // }

  function showSuratPengantar(form, userId) {
    return new Promise((resolve, reject) => {

      $.ajax({
        url: `${apiUrl}suratpengantar/${userId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          isShow = true
          upahId = response.data.upah_id
          $('#detailList tbody').html('')
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)

            if (element.is('select')) {
              element.val(value).trigger('change')
            } else if (element.hasClass('datepicker')) {
              element.val(value)
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
          if (parseInt(response.data.persentaseperalihan) > 0) {
            $('#crudForm ').find(`[name="persentaseperalihan"]`).prop('readonly', false)
          }
          kotaUpahZona()
          statusUpahZona = response.data.statusupahzona
          containerId = response.data.container_id
          statuscontainerId = response.data.statuscontainer_id
          jenisorderId = response.data.jenisorder_id
          getTarifOmset(response.data.tarifrincian_id)
          $('#crudForm ').find(`[name="omset"]`).val(response.data.omset)
          // getGaji(response.data.nominalplusborongan)
          initAutoNumeric(form.find(`[name="nominal"]`))
          initAutoNumeric(form.find(`[name="nominalTagih"]`))
          initAutoNumeric(form.find(`[name="qtyton"]`))
          initAutoNumeric(form.find(`[name="nominalperalihan"]`))
          initAutoNumeric(form.find(`[name="persentaseperalihan"]`))
          initAutoNumeric(form.find(`[name="gajisupir"]`))
          initAutoNumeric(form.find(`[name="gajikenek"]`))
          initAutoNumeric(form.find(`[name="komisisupir"]`))
          if (response.detail.length === 0) {
            addRow()
          } else {
            $('#detailList tbody').html('')
            $.each(response.detail, (index, detail) => {
              let detailRow = $(`
                        <tr>
                          <td></td>
                          <td>
                            <input type="text" name="keterangan_detail[]" class="form-control">
                          </td>
                          <td>
                            <input type="text" name="nominal[]" class="form-control autonumeric">
                          </td>
                          <td>
                            <input type="text" name="nominalTagih[]" class="form-control autonumeric">
                          </td>
                          <td>
                            <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                          </td>
                        </tr>
                      `)

              detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keteranganbiaya)

              detailRow.find(`[name="nominal[]"]`).val(detail.nominal)
              detailRow.find(`[name="nominalTagih[]"]`).val(detail.nominaltagih)
              $('#detailList tbody').append(detailRow)

              initAutoNumeric(detailRow.find('.autonumeric'))

              $('#detailList tbody').append(detailRow)

              setTotal()
              setTotalTagih()

            })
          }

          isShow = false
          setRowNumbers()

          initDatepicker()
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

  function addRow() {
    console.log('addrow')
    let detailRow = $(`
      <tr>
        <td></td>
        <td>
          <input type="text" name="keterangan_detail[]" class="form-control">
        </td>
        <td>
          <input type="text" name="nominal[]" class="form-control autonumeric" value="0">
        </td>
        <td>
          <input type="text" name="nominalTagih[]" class="form-control autonumeric" value="0">
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
        </td>
      </tr>
    `)

    $('#detailList tbody').append(detailRow)

    initAutoNumeric(detailRow.find('.autonumeric'))
    setRowNumbers()
  }

  function deleteRow(row) {
    if($('#detailList tbody').find('tr').length > 1){
      row.remove()
    }else{
      row.remove()
      addRow()
    }

    setRowNumbers()
    setTotal()
    setTotalTagih()
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function initLookup() {
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
      title: 'Pelanggan Lookup',
      fileName: 'pelanggan',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (pelanggan, element) => {
        $('#crudForm [name=pelanggan_id]').first().val(pelanggan.id)
        element.val(pelanggan.namapelanggan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=pelanggan_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
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
        console.log(container.id)
        element.val(container.keterangan)
        element.data('currentValue', element.val())
        enabledUpahSupir()
        // getGaji()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
        enabledUpahSupir()
      },
      onClear: (element) => {
        $('#crudForm [name=container_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
        $('#crudForm [name=upah_id]').val('')
        $('#crudForm [name=upah]').val('').data('currentValue', '')
        enabledUpahSupir()
        clearUpahSupir()
        // getGaji()
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
        element.val(statuscontainer.keterangan)
        element.data('currentValue', element.val())
        enabledUpahSupir()
        // getGaji()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
        enabledUpahSupir()
      },
      onClear: (element) => {
        $('#crudForm [name=statuscontainer_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
        $('#crudForm [name=upah_id]').val('')
        $('#crudForm [name=upah]').val('').data('currentValue', '')
        enabledUpahSupir()
        clearUpahSupir()
        // getGaji()
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
          kotadariId = upahsupir.kotadari_id
          kotasampaiId = upahsupir.kotasampai_id

          element.val(`${upahsupir.kotadari} - ${upahsupir.kotasampai}`)
        } else {
          zonadariId = upahsupir.zonadari_id
          zonasampaiId = upahsupir.zonasampai_id

          element.val(`${upahsupir.zonadari} - ${upahsupir.zonasampai}`)
          kotaUpahZona()
        }
        nominalSupir = parseFloat(upahsupir.nominalsupir.replace(/,/g, ""));
        let nominalKenek = parseFloat(upahsupir.nominalkenek.replace(/,/g, ""));
        let nominalKomisi = parseFloat(upahsupir.nominalkomisi.replace(/,/g, ""));

        $('#crudForm [name=gajikenek]').val(nominalKenek)
        $('#crudForm [name=komisisupir]').val(nominalKomisi)
        initAutoNumeric($('#crudForm').find('[name="gajikenek"]'))
        initAutoNumeric($('#crudForm').find('[name="komisisupir"]'))
        element.data('currentValue', element.val())
        getNominalSupir()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
        // enabledKota()
      },
      onClear: (element) => {
        $('#crudForm [name=upah_id]').val('')
        nominalSupir = 0
        getNominalSupir()
        $('#crudForm [name=gajikenek]').val(0)
        $('#crudForm [name=komisisupir]').val(0)
        kotadariId = 0
        kotasampaiId = 0
        clearUpahSupir()
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

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (trado, element) => {
        $('#crudForm [name=trado_id]').first().val(trado.trado_id)
        nominalPlusBorongan = parseFloat(trado.nominalplusborongan.replace(/,/g, ""));
        $('#crudForm [name=absensidetail_id]').first().val(trado.id)
        element.val(trado.trado)
        element.data('currentValue', element.val())
        getNominalSupir()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=trado_id]').first().val('')
        nominalPlusBorongan = 0;
        element.val('')
        element.data('currentValue', element.val())
        getNominalSupir()
      }
    })
    $('.supir-lookup').lookup({
      title: 'Supir Lookup',
      fileName: 'supir',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
          AbsensiId: true
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
        element.val(gandengan.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=gandengan_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.agen-lookup').lookup({
      title: 'Agen Lookup',
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
        element.val(jenisorder.keterangan)
        element.data('currentValue', element.val())
        enabledUpahSupir()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
        enabledUpahSupir()
      },
      onClear: (element) => {
        $('#crudForm [name=jenisorder_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
        $('#crudForm [name=upah_id]').val('')
        $('#crudForm [name=upah]').val('').data('currentValue', '')
        enabledUpahSupir()
        clearUpahSupir()
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
        element.val(tarifrincian.tujuan)
        element.data('currentValue', element.val())
        getTarifOmset(tarifrincian.id)
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=tarifrincian_id]').first().val('')
        $('#crudForm [name=omset]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.orderantrucking-lookup').lookup({
      title: 'Job Trucking Lookup',
      fileName: 'orderantrucking',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (orderantrucking, element) => {
        element.val(orderantrucking.nobukti)
        element.data('currentValue', element.val())
        getOrderanTrucking(orderantrucking.id)
        enabledUpahSupir()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        upahSupirReadOnly()
        clearUpahSupir()
        nominalSupir = 0
        getNominalSupir()
        $('#crudForm [name=gajikenek]').val(0)
        $('#crudForm [name=komisisupir]').val(0)
        kotadariId = 0
        kotasampaiId = 0
        element.val('')
        $('#crudForm [name=upah_id]').val('')
        $('#crudForm [name=upah]').val('').data('currentValue', '')
        $('#crudForm [name=agen]').val('')
        $('#crudForm [name=agen_id]').val('')
        $('#crudForm [name=container_id]').val('')
        $('#crudForm [name=container]').val('')
        $('#crudForm [name=jenisorder_id]').val('')
        $('#crudForm [name=jenisorder]').val('')
        $('#crudForm [name=pelanggan_id]').val('')
        $('#crudForm [name=pelanggan]').val('')
        $('#crudForm [name=nocont]').val('')
        $('#crudForm [name=nocont2]').val('')
        $('#crudForm [name=nojob]').val('')
        $('#crudForm [name=nojob2]').val('')
        // $('#crudForm [name=omset]').val('')
        // $('#crudForm [name=totalton]').val('')
        element.data('currentValue', element.val())
      }
    })

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

        kotaUpahZona()
        upahsupir.attr('readonly', false)
        upahsupir.parents('.input-group').find('.button-clear').attr('disabled', false)
        upahsupir.parents('.input-group').children().find('.lookup-toggler').attr('disabled', false)
      }
    }
  }

  function upahSupirReadOnly() {
    let upahsupir = $('#crudForm [name=upah]')
    upahsupir.attr('readonly', true)
    // upahsupir.parents('.input-group').find('.input-group-append').hide()
    // upahsupir.parents('.input-group').find('.button-clear').hide()
    upahsupir.parents('.input-group').find('.button-clear').attr('disabled', true)
    upahsupir.parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
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

  function kotaUpahZona() {
    let kotadari_id = $('#crudForm [name=dari]')
    let kotasampai_id = $('#crudForm [name=sampai]')

    if (upahId != 0) {
      if (selectedUpahZona == 'UPAH ZONA') {
        kotadari_id.attr('readonly', false)
        kotasampai_id.attr('readonly', false)
        kotadari_id.parents('.input-group').find('.input-group-append').show()
        kotadari_id.parents('.input-group').find('.button-clear').show()
        kotasampai_id.parents('.input-group').find('.input-group-append').show()
        kotasampai_id.parents('.input-group').find('.button-clear').show()
      } else {
        console.log('heress');
        setTimeout(() => {
          kotadari_id.attr('readonly', true)
          kotasampai_id.attr('readonly', true)

          $('#crudForm [name=dari]').parents('.input-group').find('.input-group-append').hide()
          $('#crudForm [name=dari]').parents('.input-group').find('.button-clear').hide()
          $('#crudForm [name=sampai]').parents('.input-group').find('.input-group-append').hide()
          $('#crudForm [name=sampai]').parents('.input-group').find('.button-clear').hide()
        }, 100);
      }
    } else {
      console.log('waduh')
      kotadari_id.parents('.input-group').find('.input-group-append').hide()
      kotadari_id.parents('.input-group').find('.button-clear').hide()
      kotasampai_id.parents('.input-group').find('.input-group-append').hide()
      kotasampai_id.parents('.input-group').find('.button-clear').hide()
    }
  }

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}suratpengantar/default`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          containerId = -1
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

  function editValidasi(edit) {
    let jobtrucking = $('#crudForm').find(`[name="jobtrucking"]`).parents('.input-group')
    let trado = $('#crudForm').find(`[name="trado"]`).parents('.input-group')
    let supir = $('#crudForm').find(`[name="supir"]`).parents('.input-group')
    let upah = $('#crudForm').find(`[name="upah"]`).parents('.input-group')
    let statuscontainer = $('#crudForm').find(`[name="statuscontainer"]`).parents('.input-group')

    if (!edit) {

      editUpahZona = $('#crudForm').find(`[name="statusupahzona"]`).val()
      $('#crudForm').find(`[name="statusupahzona"]`).prop('disabled', 'disabled')
      jobtrucking.find('.button-clear').attr('disabled', true)
      jobtrucking.find('input').attr('readonly', true)
      jobtrucking.children().find('.lookup-toggler').attr('disabled', true)
      trado.find('.button-clear').attr('disabled', true)
      trado.find('input').attr('readonly', true)
      trado.children().find('.lookup-toggler').attr('disabled', true)
      supir.find('.button-clear').attr('disabled', true)
      supir.find('input').attr('readonly', true)
      supir.children().find('.lookup-toggler').attr('disabled', true)

      upah.find('.button-clear').attr('disabled', true)
      upah.find('input').attr('readonly', true)
      upah.children().find('.lookup-toggler').attr('disabled', true)
      statuscontainer.find('.button-clear').attr('disabled', true)
      statuscontainer.find('input').attr('readonly', true)
      statuscontainer.children().find('.lookup-toggler').attr('disabled', true)

    } else {
      console.log("true");
      $('#crudForm').find(`[name="statusupahzona"]`).prop('disabled', false)
      jobtrucking.find('.button-clear').attr('disabled', false)
      jobtrucking.find('input').attr('readonly', false)
      jobtrucking.children().find('.lookup-toggler').attr('disabled', false)
      trado.find('.button-clear').attr('disabled', false)
      trado.find('input').attr('readonly', false)
      trado.children().find('.lookup-toggler').attr('disabled', false)
      supir.find('.button-clear').attr('disabled', false)
      supir.find('input').attr('readonly', false)
      supir.children().find('.lookup-toggler').attr('disabled', false)

      upah.find('.button-clear').attr('disabled', false)
      upah.find('input').attr('readonly', false)
      upah.children().find('.lookup-toggler').attr('disabled', false)
      statuscontainer.find('.button-clear').attr('disabled', false)
      statuscontainer.find('input').attr('readonly', false)
      statuscontainer.children().find('.lookup-toggler').attr('disabled', false)

    }


  }

  function inputReadOnly() {
    let pelanggan = $('#crudForm').find(`[name="pelanggan"]`).parents('.input-group')
    let container = $('#crudForm').find(`[name="container"]`).parents('.input-group')
    let agen = $('#crudForm').find(`[name="agen"]`).parents('.input-group')
    let jenisorder = $('#crudForm').find(`[name="jenisorder"]`).parents('.input-group')
    pelanggan.find('.button-clear').attr('disabled', true)
    pelanggan.find('input').attr('readonly', true)
    pelanggan.children().find('.lookup-toggler').attr('disabled', true)
    container.find('.button-clear').attr('disabled', true)
    container.find('input').attr('readonly', true)
    container.children().find('.lookup-toggler').attr('disabled', true)
    agen.find('.button-clear').attr('disabled', true)
    agen.find('input').attr('readonly', true)
    agen.children().find('.lookup-toggler').attr('disabled', true)
    jenisorder.find('.button-clear').attr('disabled', true)
    jenisorder.find('input').attr('readonly', true)
    jenisorder.children().find('.lookup-toggler').attr('disabled', true)
  }


  function getTarifOmset(id) {
    $.ajax({
      url: `${apiUrl}suratpengantar/${id}/getTarifOmset`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {
        if (response.dataTarif != null) {

          $('#crudForm [name=lokasibongkarmuat]').first().val(response.dataTarif.tujuan)
          $('#crudForm [name=hargaperton]').first().val(response.dataTarif.nominalton)
          // $('#crudForm ').find(`[name="omset"]`).val(response.dataTarif.nominal)
        }
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  function cekValidasidelete(Id, Aksi, nobukti) {
    $.ajax({
      url: `{{ config('app.api_url') }}suratpengantar/${Id}/cekValidasi`,
      method: 'POST',
      data: {
        aksi: Aksi,
        nobukti: nobukti
      },
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {

        var kondisi = response.kondisi

        // if (!response.edit) {
        isAllowEdited = response.edit;
        // console.log(isAllowEdited);
        // }

        if (kondisi == true) {
          showDialog(response.message['keterangan'])
        } else {
          if (Aksi == 'EDIT') {
            editSuratPengantar(Id)
          } else {
            deleteSuratPengantar(Id)
          }
        }

      }
    })
  }

  function getOrderanTrucking(id) {
    $.ajax({
      url: `${apiUrl}suratpengantar/${id}/getOrderanTrucking`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {
        // getTarifOmset(response.data.tarif_id)
        console.log(response.data)
        containerId = response.data.container_id
        // $('#crudForm [name=statusperalihan]').val(response.data.statusperalihan)
        $('#crudForm [name=agen]').val(response.data.agen)
        $('#crudForm [name=agen_id]').val(response.data.agen_id)
        $('#crudForm [name=container_id]').val(response.data.container_id)
        $('#crudForm [name=container]').val(response.data.container)
        $('#crudForm [name=jenisorder_id]').val(response.data.jenisorder_id)
        $('#crudForm [name=jenisorder]').val(response.data.jenisorder)
        $('#crudForm [name=pelanggan_id]').val(response.data.pelanggan_id)
        $('#crudForm [name=pelanggan]').val(response.data.pelanggan)
        $('#crudForm [name=nocont]').val(response.data.nocont)
        $('#crudForm [name=nocont2]').val(response.data.nocont2)
        $('#crudForm [name=nojob]').val(response.data.nojobemkl)
        $('#crudForm [name=nojob2]').val(response.data.nojobemkl2)
        $('#crudForm [name=noseal]').val(response.data.noseal)
        $('#crudForm [name=noseal2]').val(response.data.noseal2)
        // $('#crudForm [name=statusperalihan]')
        //   .val(response.data.statusperalihan)
        //   .trigger('change')
        //   .trigger('select2:selected');
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }
  // function setDummyOption() {
  //   fetch(`http://dummy.test/server/`)
  //     .then(response => {
  //       console.log(response);
  //     })

  // $.ajax({
  //   url: `http://dummy.test/server/`,
  //   method: 'GET',
  //   dataType: 'JSON',
  //   headers: {
  //     Authorization: `Bearer ${accessToken}`
  //   },
  //   success: response => {
  //     console.log(response);
  //   }
  // })
  // }
</script>
@endpush()