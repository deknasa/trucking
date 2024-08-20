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
                <div class="form-group statuslangsir">
                  <label class="col-sm-12 col-form-label">STATUS LANGSIR</label>
                  <div class="col-sm-12">
                    <select name="statuslangsir" class="form-control select2bs4" id="statuslangsir">
                      <option value="">-- PILIH STATUS LANGSIR--</option>
                    </select>
                  </div>
                </div>

                <div class="form-group statuspenyesuaian">
                  <label class="col-sm-12 col-form-label">STATUS PENYESUAIAN <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <select name="statuspenyesuaian" class="form-control select2bs4" id="statuspenyesuaian">
                      <option value="">-- PILIH STATUS PENYESUAIAN--</option>
                    </select>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label"><em><u>CUSTOMER </u></em><span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="agen_id">
                    <input type="text" name="agen" class="form-control agen-lookup">
                  </div>
                </div>
                <div class="form-group jenisorder">
                  <label class="col-sm-12 col-form-label"><em><u>JENIS ORDERAN </u></em><span class="text-danger">*</span></label>
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
                  <label class="col-sm-12 col-form-label"><em><u>CONTAINER </u></em><span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="container_id">
                    <input type="text" name="container" class="form-control container-lookup">
                  </div>
                </div>

                <div id="tripasalpulanglongtrip">

                </div>
                <div id="kotaLongtrip">

                </div>
                <div class="form-group upahsupir">
                  <label class="col-sm-12 col-form-label">UPAH SUPIR <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="upah_id">
                    <input type="text" name="upah" class="form-control upahsupirrincian-lookup">
                  </div>
                </div>

                <div class="form-group penyesuaian">
                  <label class="col-sm-12 col-form-label">PENYESUAIAN</label>
                  <div class="col-sm-12">
                    <input type="text" name="penyesuaian" class="form-control" readonly>
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

                <div id="tripasalpulanglongtrip">

                </div>
                <div id="kotaTrip">
                  <div class="form-group dari">
                    <label class="col-sm-12 col-form-label">DARI <span class="text-danger">*</span></label>
                    <div class="col-sm-12">
                      <input type="hidden" name="dari_id">
                      <input type="text" name="dari" class="form-control kotadari-lookup" readonly>
                    </div>
                  </div>

                  <div class="form-group sampai">
                    <label class="col-sm-12 col-form-label">SAMPAI <span class="text-danger">*</span></label>
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

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">OMSET <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="omset" class="form-control" readonly>
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
                    <input type="text" name="supir" class="form-control" readonly>
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label"><em><u>SHIPPER </u></em><span class="text-danger">*</span></label>
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
                  <label class="col-sm-12 col-form-label">NO GANDENGAN / CHASIS</label>
                  <div class="col-sm-12">
                    <input type="hidden" name="gandengan_id">
                    <input type="text" name="gandengan" class="form-control gandengan-lookup">
                  </div>
                </div>

                <div class="form-group gudang">
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
                <div class="form-group nocont">
                  <label class="col-sm-12 col-form-label"><em><u>NO CONTAINER (1)</u></em></label>
                  <div class="col-sm-12">
                    <input type="text" name="nocont" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group noseal">
                  <label class="col-sm-12 col-form-label"><em><u>NO SEAL (1)</u></em></label>
                  <div class="col-sm-12">
                    <input type="text" name="noseal" class="form-control" readonly>
                  </div>
                </div>
              </div>
              <div class="col-md-4">

                <div class="col-md-12 statusperalihan">
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
                <div class="form-group nocont2">
                  <label class="col-sm-12 col-form-label"><em><u>NO CONTAINER (2)</u></em></label>
                  <div class="col-sm-12">
                    <input type="text" name="nocont2" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group noseal2">
                  <label class="col-sm-12 col-form-label"><em><u>NO SEAL (2)</u></em></label>
                  <div class="col-sm-12">
                    <input type="text" name="noseal2" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group nojob">
                  <label class="col-sm-12 col-form-label"><em><u>NO JOB (1)</u></em></label>
                  <div class="col-sm-12">
                    <input type="text" name="nojob" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group nojob2">
                  <label class="col-sm-12 col-form-label"><em><u>NO JOB (2)</u></em></label>
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
                <div class="form-group hargaton">
                  <label class="col-sm-12 col-form-label">HARGA PER TON (TARIF)</label>
                  <div class="col-sm-12">
                    <input type="text" name="hargapertontarif" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group qtyton">
                  <label class="col-sm-12 col-form-label">QTY TON<span class="text-danger"></span></label>
                  <div class="col-sm-12">
                    <input type="text" name="qtyton" class="form-control">
                  </div>
                </div>
                <div class="form-group triptangki">
                  <label class="col-sm-12 col-form-label">TRIP TANGKI <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="triptangki_id">
                    <input type="text" name="triptangki" class="form-control triptangki-lookup">
                  </div>
                </div>
                <div class="form-group batalmuat">
                  <label class="col-sm-12 col-form-label">BATAL MUAT<span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <select name="statusbatalmuat" class="form-control select2bs4" id="statusbatalmuat">
                      <option value="">-- PILIH STATUS BATAL MUAT --</option>
                    </select>
                  </div>
                </div>
                <div class="form-group statustolakan">
                  <label class="col-sm-12 col-form-label">STATUS TOLAKAN <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <select name="statustolakan" class="form-control select2bs4">
                      <option value="">-- PILIH STATUS TOLAKAN --</option>
                    </select>
                  </div>
                </div>
                <div id="tripasal">
                  <div class="form-group nobukti_tripasal">
                    <label class="col-sm-12 col-form-label">TRIP ASAL</label>
                    <div class="col-sm-12">
                      <input type="text" name="nobukti_tripasal" class="form-control suratpengantar-lookup">
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="card">
              <div class="card-header bg-info">
                <div class="row">
                  <div class="col-md-6">
                    BIAYA
                  </div>
                  <div class="col-md-6 masterupah">
                    MASTER
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">

                    <div class="row form-group">
                      <div class="col-12 col-md-2">
                        <label class="col-form-label">
                          GAJI SUPIR </label>
                      </div>
                      <div class="col-12 col-md-8">
                        <input type="text" name="gajisupir" id="gajisupir" class="form-control autonumeric" readonly>
                      </div>
                    </div>
                    <div class="row form-group row-gajikenek">
                      <div class="col-12 col-md-2">
                        <label class="col-form-label">
                          GAJI KENEK </label>
                      </div>
                      <div class="col-12 col-md-8 elgajikenek">
                        <input type="text" name="gajikenek" id="gajikenek" class="form-control text-right" readonly>
                      </div>
                    </div>
                    <div class="row form-group row-komisisupir">
                      <div class="col-12 col-md-2">
                        <label class="col-form-label">
                          KOMISI SUPIR </label>
                      </div>
                      <div class="col-12 col-md-8 elkomisisupir">
                        <input type="text" name="komisisupir" id="komisisupir" class="form-control text-right" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 masterupah">

                    <div class="row form-group">
                      <div class="col-12 col-md-2">
                        <label class="col-form-label">
                          GAJI SUPIR </label>
                      </div>
                      <div class="col-12 col-md-8">
                        <input type="text" name="gajisupirmaster" id="gajisupirmaster" class="form-control autonumeric" readonly>
                      </div>
                    </div>
                    <div class="row form-group">
                      <div class="col-12 col-md-2">
                        <label class="col-form-label">
                          GAJI KENEK </label>
                      </div>
                      <div class="col-12 col-md-8">
                        <input type="text" name="gajikenekmaster" id="gajikenekmaster" class="form-control text-right" readonly>
                      </div>
                    </div>
                    <div class="row form-group">
                      <div class="col-12 col-md-2">
                        <label class="col-form-label">
                          KOMISI SUPIR </label>
                      </div>
                      <div class="col-12 col-md-8">
                        <input type="text" name="komisisupirmaster" id="komisisupirmaster" class="form-control text-right" readonly>
                      </div>
                    </div>
                  </div>
                </div>


                <h3 class="text-center biayatambahan">Biaya Tambahan</h3>

                <div class="row biayatambahan">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="detailList" class="table table-bordered table-bindkeys" style="width: 800;">
                        <thead>
                          <tr>
                            <th width="1%">No</th>
                            <th width="60%">Keterangan</th>
                            <th width="19%">Nominal Supir</th>
                            <th width="19%">Nominal Tagih</th>
                            <th class="aksi" width="1%">Aksi</th>
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
                            <td class="aksi">
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
              Save
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
<div class="modal modal-fullscreen" id="crudModalTolakan" tabindex="-1" aria-labelledby="crudModalTolakanLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudFormTolakan">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="crudModalTolakanTitle"></p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>

        <form action="" method="post">
          <div class="modal-body">

            <div class="form-group ">
              <label class="col-sm-12 col-form-label">NO TRANSAKSI </label>
              <div class="col-sm-12">
                <input type="text" name="nobuktitrans" class="form-control" readonly>
              </div>
            </div>
            <div class="form-group ">
              <label class="col-sm-12 col-form-label">JOB TRUCKING </label>
              <div class="col-sm-12">
                <input type="text" name="jobtruckingtrans" class="form-control" readonly>
              </div>
            </div>
            <div class="form-group statustolakan">
              <label class="col-sm-12 col-form-label">STATUS TOLAKAN <span class="text-danger">*</span></label>
              <div class="col-sm-12">
                <select name="statustolakan" class="form-control select2bs4">
                  <option value="">-- PILIH STATUS TOLAKAN --</option>
                </select>
              </div>
            </div>
            <div class="form-group ">
              <label class="col-sm-12 col-form-label">OMSET <span class="text-danger">*</span></label>
              <div class="col-sm-12">
                <input type="text" name="omsettolakan" class="form-control" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12 col-form-label">Nominal Peralihan</label>
              <div class="col-md-12">
                <input type="text" name="nominalperalihantolakan" class="form-control text-right">
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-group">
                <input type="text" name="persentaseperalihantolakan" class="form-control">
                <div class="input-group-append">
                  <span class="input-group-text">%</span>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-start">
            <button type="button" id="btnSubmitTolakan" class="btn btn-primary">
              <i class="fa fa-save"></i>
              Save
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
  let modalBodyTolakan = $('#crudModalTolakan').find('.modal-body').html()
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
  let editStatusPenyesuaian
  let indexDetail = 0
  let isTripAsal = true;
  let isPulangLongtrip;
  let isGudangSama = true;
  let statusJenisKendaran
  let jenisKendaraan

  $(document).ready(function() {
    $('.nobukti_tripasal').hide()

    $(document).on('input', `#crudForm [name="nominalperalihan"]`, function(event) {
      if ($(`#crudForm [name="statuslongtrip"]`).val() != 65) {
        setPersentase()
      }
    })
    $(document).on('input', `#crudForm [name="persentaseperalihan"]`, function(event) {
      setNominal()
    })

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
      event.preventDefault()
      let method = `POST`
      let url = `${apiUrl}suratpengantar/addrow`
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      $('#crudForm').find(`[name="nominal[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominal[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[index])
      })
      $('#crudForm').find(`[name="nominalTagih[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominalTagih[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominalTagih[]"]`)[index])
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
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    });

    // $(document).on('input', `#crudForm [name="qtyton"]`, function(event) {

    //   let qtyton = AutoNumeric.getNumber($(this)[0])
    //   let omset = AutoNumeric.getNumber($(`#crudForm [name="omset"]`)[0])
    //   let total = qtyton * omset

    //   $(`#crudForm [name="totalton"]`).val(total)
    //   initAutoNumeric($(`#crudForm [name="totalton"]`))
    //   console.log(total)
    // })
    $(document).on('change', '#crudForm [name="statustolakan"]', function(event) {
      let status = $(`#crudForm [name="statustolakan"] option:selected`).text()
      if (status == 'APPROVAL') {
        $(`#crudForm [name="nominalperalihan"]`).prop('readonly', false)
        $(`#crudForm [name="persentaseperalihan"]`).prop('readonly', false)
      } else if (status == 'NON APPROVAL') {
        $(`#crudForm [name="nominalperalihan"]`).prop('readonly', true)
        $(`#crudForm [name="persentaseperalihan"]`).prop('readonly', true)
      }
    })

    $(document).on('change', '#statusperalihan', function(event) {
      let status = $("#statusperalihan option:selected").text()

      if (!isShow) {
        if (status == 'PERALIHAN') {
          $(`#crudForm [name="nominalperalihan"]`).prop('readonly', false)
          $(`#crudForm [name="persentaseperalihan"]`).prop('readonly', false)
          //   $(`#crudForm [name="nominalperalihan"]`).remove()
          //   $(`#persentaseInputGroup`).remove()

          //   $('#nominalPeralihanDiv').append(`
          // <input type="text" name="nominalperalihan" class="form-control text-right" readonly>
          // `)
          //   $('#persentasePeralihanDiv').append(`
          //   <div class="input-group" id="persentaseInputGroup">
          //     <input type="text" name="persentaseperalihan" onkeyup="setNominal()" class="form-control">
          //     <div class="input-group-append">
          //       <span class="input-group-text">%</span>
          //     </div>
          //   </div>
          // `)
          //   initAutoNumeric($('#crudForm').find('[name="persentaseperalihan"]'))
        } else if (status == 'BUKAN PERALIHAN') {
          $(`#crudForm [name="nominalperalihan"]`).prop('readonly', true)
          $(`#crudForm [name="persentaseperalihan"]`).prop('readonly', true)

          //   $(`#crudForm [name="nominalperalihan"]`).remove()
          //   $(`#persentaseInputGroup`).remove()

          //   $('#nominalPeralihanDiv').append(`
          // <input type="text" name="nominalperalihan" class="form-control text-right" readonly>
          // `)
          //   $('#persentasePeralihanDiv').append(`
          //   <div class="input-group" id="persentaseInputGroup">
          //     <input type="text" name="persentaseperalihan" onkeyup="setNominal()" class="form-control" readonly>
          //     <div class="input-group-append">
          //       <span class="input-group-text">%</span>
          //     </div>
          //   </div>
          // `)
          //   initAutoNumeric($('#crudForm').find('[name="persentaseperalihan"]'))
        }
      }
    })
    $(document).on('click', '.delete-row', function(event) {
      if (isApprovalBiayaTambahan == 'YA') {
        $.ajax({
          url: `${apiUrl}suratpengantar/deleterow`,
          method: 'POST',
          dataType: 'JSON',
          headers: {
            Authorization: `Bearer ${accessToken}`
          },
          data: {
            id: $(this).parents('tr').find(`[name="tambahan_id[]"]`).val()
          },
          success: response => {
            let status = response.data;
            if (status) {
              deleteRow($(this).parents('tr'))
            } else {
              showDialog('SUDAH DIAPPROVAL')
            }
          },
          error: error => {
            if (error.status === 422) {
              $('.is-invalid').removeClass('is-invalid')
              $('.invalid-feedback').remove()
              setErrorMessages($('#crudForm'), error.responseJSON.errors);
            } else {
              showDialog(error.responseJSON)
            }
          },
        }).always(() => {
          $('#processingLoader').addClass('d-none')
          $(this).removeAttr('disabled')
        })

      } else {
        deleteRow($(this).parents('tr'))
      }
    })


    $(document).on('input', `#detailList [name="nominal[]"]`, function(event) {
      setTotal()
    })

    $(document).on('input', `#detailList [name="nominalTagih[]"]`, function(event) {
      setTotalTagih()
    })
    $(document).on('change', `#crudForm [name="statuskandang"]`, function(event) {
      // if ($(`#crudForm [name="statuskandang"]`).val() == 600){
      $('#crudForm [name=upah]').data('currentValue', '')
      $('#crudForm [name=upah]').val('')
      $('#crudForm [name=upah_id]').val('')
      clearUpahSupir()
      // }
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
        data.push({
          name: 'statuspenyesuaian',
          value: editStatusPenyesuaian
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

      // if ($("#statusperalihan option:selected").text() == 'PERALIHAN') {
      // $('#crudForm').find(`[name="nominalperalihan"]`).each((index, element) => {
      data.filter((row) => row.name === 'nominalperalihan')[0].value = AutoNumeric.getNumber($(`#crudForm [name="nominalperalihan"]`)[0])
      // })

      data.filter((row) => row.name === 'persentaseperalihan')[0].value = AutoNumeric.getNumber($(`#crudForm [name="persentaseperalihan"]`)[0])
      // }
      // $('#crudForm').find(`[name="qtyton"]`).each((index, element) => {
      data.filter((row) => row.name === 'hargapertontarif')[0].value = AutoNumeric.getNumber($(`#crudForm [name="hargapertontarif"]`)[0])
      data.filter((row) => row.name === 'qtyton')[0].value = AutoNumeric.getNumber($(`#crudForm [name="qtyton"]`)[0])
      data.filter((row) => row.name === 'omset')[0].value = AutoNumeric.getNumber($(`#crudForm [name="omset"]`)[0])
      data.filter((row) => row.name === 'komisisupir')[0].value = AutoNumeric.getNumber($(`#crudForm [name="komisisupir"]`)[0])
      data.filter((row) => row.name === 'gajikenek')[0].value = AutoNumeric.getNumber($(`#crudForm [name="gajikenek"]`)[0])
      data.filter((row) => row.name === 'gajisupir')[0].value = AutoNumeric.getNumber($(`#crudForm [name="gajisupir"]`)[0])
      // })

      data.push({
        name: 'statusjeniskendaraan',
        value: $('#crudForm').find(`[name="statusjeniskendaraan"]`).val()
      })
      data.push({
        name: 'statuslongtrip',
        value: $('#crudForm').find(`[name="statuslongtrip"]`).val()
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

      data.push({
        name: 'aksi',
        value: action.toUpperCase()
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

  $(document).on('input', `#crudForm [name="qtyton"]`, function(event) {
    setNominalTangki()
  })

  function setNominalTangki() {

    let qtyton = AutoNumeric.getNumber($(`#crudForm [name="qtyton"]`)[0])
    let hargaTonTarif = AutoNumeric.getNumber($(`#crudForm [name="hargapertontarif"]`)[0])
    let totalTarif = Math.round(qtyton * hargaTonTarif);
    $(`#crudForm [name="omset"]`).val(totalTarif)
    initAutoNumeric($(`#crudForm [name="omset"]`))
  }

  $(document).on('change', `#crudForm [name="statusjeniskendaraan"]`, function(event) {

    let statusjeniskendaraan = $(`#crudForm [name="statusjeniskendaraan"] option:selected`).text()
    statusJenisKendaran = statusjeniskendaraan
    if (statusjeniskendaraan == 'TANGKI') {
      $('.jenissuratpengantar').hide()
      $('.gudangsama').hide()
      $('.statuskandang').hide()
      $('.jenisorder').hide()
      $('.statuscontainer').hide()
      $('.containers').hide()
      $('.jobtrucking').hide()
      $('.gudang').hide()
      $('.nocont').hide()
      $('.noseal').hide()
      $('.statusperalihan').hide()
      $('.nocont2').hide()
      $('.noseal2').hide()
      $('.nojob').hide()
      $('.nojob2').hide()
      $('.batalmuat').hide()
      $('.nobukti_tripasal').hide()
      $('.masterupah').hide()
      $('.row-gajikenek').hide()
      $('.row-komisisupir').hide()
      $('.gandengan').show()
      $('.triptangki').show()
      $('.gandengan').find('label').text('No Tangki')
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
      $('.hargaton').hide()
      $('.qtyton').hide()
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
    }
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
    console.log('berubah longtrip')
    clearUpahSupir()
  })

  $(document).on('change', `#crudForm [name="statuspenyesuaian"]`, function(event) {
    if ($(`#crudForm [name="statuspenyesuaian"]`).val() != '') {
      $('#crudForm [name=upah]').data('currentValue', '')
      $('#crudForm [name=upah]').val('')
      $('#crudForm [name=upah_id]').val('')
      clearUpahSupir()
    }
  })


  $(document).on('change', `#crudForm [name="statusgudangsama"]`, function(event) {
    enableTripAsal()
  })

  function getNominalSupir() {
    totalNominalSupir = nominalPlusBorongan + nominalSupir;

    $('#crudForm [name=gajisupir]').val(totalNominalSupir)
    initAutoNumeric($('#crudForm').find('[name="gajisupir"]'))
  }

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }

    activeGrid = null
    getMaxLength(form)
    initLookup()
    initDatepicker()
    initSelect2(form.find('.select2bs4'), true)
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy($('#crudForm').find('[name=id]').val())
    $('#crudModal').find('.modal-body').html(modalBody)
    initDatepicker('datepickerIndex')
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


  function setPersentase() {
    let nominalDetails = $(`#crudForm [name="nominalperalihan"]`)
    let omset = $(`#crudForm [name="omset"]`).val()
    let total = 0

    total = (AutoNumeric.getNumber(nominalDetails[0]) / parseFloat(omset.replace(/,/g, ''))) * 100;
    let getPersentase = AutoNumeric.getAutoNumericElement($(`#crudForm [name="persentaseperalihan"]`)[0]);
    getPersentase.set(total)
  }

  function setNominal() {
    let persentase = $(`#crudForm [name="persentaseperalihan"]`)
    let omset = $(`#crudForm [name="omset"]`).val()

    totalPersentase = (AutoNumeric.getNumber(persentase[0]) / 100) * parseFloat(omset.replace(/,/g, ''));
    let getNominal = AutoNumeric.getAutoNumericElement($(`#crudForm [name="nominalperalihan"]`)[0]);
    getNominal.set(totalPersentase)
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
    Save
  `)
    form.data('action', 'add')
    $('#crudModalTitle').text('Add Surat Pengantar')
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
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Surat Pengantar')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusJenisKendaraanOptions(form),
        setStatusLongTripOptions(form),
        setStatusTolakanOptions(form),
        setStatusPeralihanOptions(form),
        setStatusGudangSamaOptions(form),
        setStatusBatalMuatOptions(form),
        setStatusGandenganOptions(form),
        // setStatusKandangOptions(form),
        setStatusPenyesuaianOptions(form),
        setStatusLangsirOptions(form),
        setTampilan(form)
      ])
      .then(() => {
        showSuratPengantar(form, id)
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')

            jenisKendaraan = $('#crudForm').find(`[name="statusjeniskendaraan"]`).val()
            $('#crudForm').find('[name=statusjeniskendaraan]').attr('disabled', 'disabled').css({
              background: '#fff'
            })
            $('#crudForm').find('[name=statuslongtrip]').attr('disabled', 'disabled')
            $('#crudForm').find('[name=statuslangsir]').attr('disabled', 'disabled')
            $('#crudForm [name=tglbukti]').attr('readonly', true)
            $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()
            inputReadOnly()
            editValidasi(isAllowEdited);

            // if (statusJenisKendaran == 'TANGKI') {

            $('#crudForm [name=jobtrucking]').attr('readonly', true)
            $('#crudForm [name=jobtrucking]').parents('.input-group').find('.input-group-append').hide()
            $('#crudForm [name=jobtrucking]').parents('.input-group').find('.button-clear').hide()
            // }

            if (accessCabang == 'MEDAN') {
              $('#crudForm [name=gandengan]').attr('readonly', true)
              $('#crudForm [name=gandengan]').parents('.input-group').find('.input-group-append').hide()
              $('#crudForm [name=gandengan]').parents('.input-group').find('.button-clear').hide()
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

  function deleteSuratPengantar(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Surat Pengantar')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusJenisKendaraanOptions(form),
        setStatusLongTripOptions(form),
        setStatusPeralihanOptions(form),
        setStatusTolakanOptions(form),
        setStatusGudangSamaOptions(form),
        setStatusBatalMuatOptions(form),
        setStatusGandenganOptions(form),
        // setStatusKandangOptions(form),
        setStatusPenyesuaianOptions(form),
        setStatusLangsirOptions(form),
        setTampilan(form)
      ])
      .then(() => {
        showSuratPengantar(form, id)
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
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

  function viewSuratPengantar(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Surat Pengantar')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusJenisKendaraanOptions(form),
        setStatusLongTripOptions(form),
        setStatusPeralihanOptions(form),
        setStatusTolakanOptions(form),
        setStatusGudangSamaOptions(form),
        setStatusBatalMuatOptions(form),
        setStatusGandenganOptions(form),
        setStatusPenyesuaianOptions(form),
        setStatusLangsirOptions(form),
        setTampilan(form)
      ])
      .then(() => {
        showSuratPengantar(form, id)
          .then(id => {
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
            moveKotaLangsir($('#crudForm [name=statuslangsir]').val())
            form.find(`.hasDatepicker`).prop('readonly', true)
            form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
            let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
            name.attr('disabled', true)
            name.find('.lookup-toggler').attr('disabled', true)
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
  const setStatusTolakanOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statustolakan]').empty()
      relatedForm.find('[name=statustolakan]').append(
        new Option('-- PILIH STATUS TOLAKAN --', '', false, true)
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
              "field": "grpand",
              "op": "cn",
              "data": "STATUS APPROVAL"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusTolakan => {
            let option = new Option(statusTolakan.text, statusTolakan.id)
            relatedForm.find('[name=statustolakan]').append(option).trigger('change')
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
            (index == 'nobukti_tripasal') ? element.data('current-value', value): '';

          })
          if (parseInt(response.data.persentaseperalihan) > 0) {
            $('#crudForm ').find(`[name="persentaseperalihan"]`).prop('readonly', false)
          }
          // kotaUpahZona()
          statusUpahZona = response.data.statusupahzona
          containerId = response.data.container_id
          statuscontainerId = response.data.statuscontainer_id
          jenisorderId = response.data.jenisorder_id
          nominalSupir = response.data.gajisupir
          getTarifOmset(response.data.tarifrincian_id, response.data.container_id)
          // $('#crudForm ').find(`[name="omset"]`).val(response.data.omset)
          // getGaji(response.data.nominalplusborongan)
          initAutoNumeric(form.find(`[name="hargapertontarif"]`))
          initAutoNumeric(form.find(`[name="nominal"]`))
          initAutoNumeric(form.find(`[name="nominalTagih"]`))
          initAutoNumeric(form.find(`[name="qtyton"]`))
          initAutoNumeric(form.find(`[name="nominalperalihan"]`))
          initAutoNumeric(form.find(`[name="persentaseperalihan"]`))
          initAutoNumeric(form.find(`[name="gajisupir"]`))
          if (isKomisi == 'TIDAK') {
            $(`#crudForm [name="gajikenek"]`).parents('.row-gajikenek').find('.col-form-label').text('KOMISI KENEK')
            form.find(`[name="gajikenek"]`).attr('readonly', false)
            form.find(`[name="komisisupir"]`).attr('readonly', false)
          } else {
            $(`#crudForm [name="gajikenek"]`).parents('.row-gajikenek').find('.col-form-label').text('GAJI KENEK')
            form.find(`[name="gajikenek"]`).attr('readonly', false)

          }
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
                            <input type="hidden" name="tambahan_id[]">
                          </td>
                          <td>
                            <input type="text" name="nominal[]" class="form-control autonumeric">
                          </td>
                          <td>
                            <input type="text" name="nominalTagih[]" class="form-control autonumeric">
                          </td>
                          <td>
                            <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                          </td>
                        </tr>
                      `)

              detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keteranganbiaya)
              detailRow.find(`[name="tambahan_id[]"]`).val(detail.id)

              detailRow.find(`[name="nominal[]"]`).val(detail.nominal)
              detailRow.find(`[name="nominalTagih[]"]`).val(detail.nominaltagih)
              $('#detailList tbody').append(detailRow)

              initAutoNumericMinus(detailRow.find('.autonumeric'))
              if (detail.statusapproval == 3) {
                detailRow.find(`[name="keterangan_detail[]"]`).prop('readonly', true)
                detailRow.find(`[name="nominal[]"]`).prop('readonly', true)
                detailRow.find(`[name="nominalTagih[]"]`).prop('readonly', true)
                $('.aksi').hide()
                $('.delete-row').parents('td').hide()
              }
              $('#detailList tbody').append(detailRow)

              setTotal()
              setTotalTagih()

            })
          }


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
          let statuslongtrip = $(`#crudForm [name="statuslongtrip"]`).val()
          let jenisorder_id = $('#crudForm [name=jenisorder_id]').val()
          let statuscontainer_id = $('#crudForm [name=statuscontainer_id]').val()
          if (statuslongtrip == 66) {
            if ((jenisorder_id == 2 && statuscontainer_id == 2) || (jenisorder_id == 3 && statuscontainer_id == 2) || (jenisorder_id == 1 && statuscontainer_id == 1) || (jenisorder_id == 4 && statuscontainer_id == 1)) {
              $('.nobukti_tripasal').show()
              isPulangLongtrip = true;
            } else {
              $('.nobukti_tripasal').hide()
              isPulangLongtrip = false;
            }
          } else {
            if ((jenisorder_id == 2 && statuscontainer_id == 1) || (jenisorder_id == 3 && statuscontainer_id == 1) || (jenisorder_id == 1 && statuscontainer_id == 2) || (jenisorder_id == 1 && statuscontainer_id == 1) || (jenisorder_id == 4 && statuscontainer_id == 2)) {
              $('.nobukti_tripasal').show()
              $(`#crudForm [name="nominalperalihan"]`).prop('readonly', false)
              isPulangLongtrip = false;
            } else {

              $('.nobukti_tripasal').hide()
              isPulangLongtrip = false;
            }
          }

          isShow = false
          setRowNumbers()
          getDataUpahSupir(true)
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

  function getDataUpahSupirTangki(tarif_id) {
    $.ajax({
      url: `${apiUrl}upahsupirtangki/getrincian`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        idtrip: $('#crudForm').find(`[name="id"]`).val(),
        tarif_id: tarif_id,
        upah_id: $('#crudForm').find(`[name="upah_id"]`).val(),
        triptangki_id: $('#crudForm').find(`[name="triptangki_id"]`).val(),
      },
      success: response => {
        nominalSupir = response.data.nominalsupir
        $('#crudForm').find(`[name="gajisupir"]`).val(response.data.nominalsupir)
        initAutoNumeric($('#crudForm').find(`[name="gajisupir"]`))
        $('#crudForm').find(`[name="hargapertontarif"]`).val(response.data.nominaltarif)
        initAutoNumeric($('#crudForm').find(`[name="hargapertontarif"]`))
        setNominalTangki()
      }
    })
  }

  function getDataUpahSupir(isStatusContainer = false) {
    $.ajax({
      url: `${apiUrl}upahsupir/getrincian`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        statuskandang: $('#crudForm').find(`[name="statuskandang"]`).val(),
        upah_id: $('#crudForm').find(`[name="upah_id"]`).val(),
        container_id: $('#crudForm').find(`[name="container_id"]`).val(),
        statuscontainer_id: $('#crudForm').find(`[name="statuscontainer_id"]`).val(),
      },
      success: response => {
        $('#crudForm').find(`[name="gajisupirmaster"]`).val(response.data.nominalsupir)
        $('#crudForm').find(`[name="gajikenekmaster"]`).val(response.data.nominalkenek)
        $('#crudForm').find(`[name="komisisupirmaster"]`).val(response.data.nominalkomisi)
        if (isStatusContainer) {
          $('#crudForm').find(`[name="gajisupir"]`).val(response.data.nominalsupir)
          initAutoNumeric($('#crudForm').find(`[name="gajisupir"]`))
          setNominalKenek(response.data.nominalkenek, response.data.nominalkomisi)

        }
        initAutoNumeric($('#crudForm').find(`[name="gajisupirmaster"]`))
        initAutoNumeric($('#crudForm').find(`[name="gajikenekmaster"]`))
        initAutoNumeric($('#crudForm').find(`[name="komisisupirmaster"]`))

      }
    })
  }

  function addRow() {
    console.log('addrow')
    let detailRow = $(`
      <tr>
        <td></td>
        <td>
          <input type="text" name="keterangan_detail[]" class="form-control">
          <input type="hidden" name="tambahan_id[]">
        </td>
        <td>
          <input type="text" name="nominal[]" class="form-control autonumeric" value="0">
        </td>
        <td>
          <input type="text" name="nominalTagih[]" class="form-control autonumeric" value="0">
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
        </td>
      </tr>
    `)

    $('#detailList tbody').append(detailRow)

    initAutoNumericMinus(detailRow.find('.autonumeric'))
    setRowNumbers()
  }

  function deleteRow(row) {
    if ($('#detailList tbody').find('tr').length > 1) {
      row.remove()
    } else {
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
          gudangsama: $('#crudForm [name=statusgudangsama]').val(),
          longtrip: $('#crudForm [name=statuslongtrip]').val(),
          idTrip: $('#crudForm [name=id]').val(),
          isGudangSama: isGudangSama
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
          kotaZona: zonasampaiId,
          isLookup: 1,
          url: ($('#crudForm [name=statuslongtrip]').val() == 65) ? `${apiUrl}kota/getlongtrip` : `${apiUrl}kota`,
          statuslongtrip: $('#crudForm [name=statuslongtrip]').val(),
          dari_id: $('#crudForm [name=dari_id]').val(),
          from: 'inputtrip'
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
        clearTripAsal()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=pelanggan_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
        clearTripAsal()
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
        clearTripAsal()
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
        clearTripAsal()
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
        clearUpahSupir()
        // if (statuscontainer.kodestatuscontainer != 'FULL EMPTY') {
        enableTripAsalLongTrip()
        // }
        // getGaji()
        getTarifOmset($('#crudForm [name=tarifrincian_id]').val(), $('#crudForm [name=container_id]').val())
        getNominalSupir()
        getDataUpahSupir(true)
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
        isPulangLongtrip = false;
        clearTripAsal()
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
        kotadariId = upahsupir.kotadari_id
        kotasampaiId = upahsupir.kotasampai_id

        element.val(`${upahsupir.kotadari} - ${upahsupir.kotasampai}`)
        // } else {
        //   zonadariId = upahsupir.zonadari_id
        //   zonasampaiId = upahsupir.zonasampai_id

        //   element.val(`${upahsupir.zonadari} - ${upahsupir.zonasampai}`)
        //   kotaUpahZona()
        // }
        nominalSupir = parseFloat(upahsupir.nominalsupir.replace(/,/g, ""));
        let nominalKenek = parseFloat(upahsupir.nominalkenek.replace(/,/g, ""));
        let nominalKomisi = parseFloat(upahsupir.nominalkomisi.replace(/,/g, ""));

        setNominalKenek(nominalKenek, nominalKomisi)
        element.data('currentValue', element.val())
        getNominalSupir()
        if (statusJenisKendaran == 'TANGKI') {
          getDataUpahSupirTangki(upahsupir.tarif_id)
        } else {
          getDataUpahSupir()
          getTarifOmset(upahsupir.tarif_id, containerId)
        }
        // clearTripAsal()
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
        // clearTripAsal()
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
      onSelectRow: (trado, element) => {
        $('#crudForm [name=trado_id]').first().val(trado.trado_id)
        nominalPlusBorongan = parseFloat(trado.nominalplusborongan.replace(/,/g, ""));
        $('#crudForm [name=absensidetail_id]').first().val(trado.id)
        element.val(trado.trado)
        element.data('currentValue', element.val())
        getNominalSupir()
        $('#crudForm [name=supir_id]').val(trado.supir_id)
        $('#crudForm [name=supir]').val(trado.supir)
        clearTripAsal()
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
        $('#crudForm [name=supir_id]').val('')
        $('#crudForm [name=supir]').val('')
        $('#crudForm [name=supir]').data('currentValue', '')
        clearTripAsal()
      }
    })
    $('.supir-lookup').lookup({
      title: 'Supir Lookup',
      fileName: 'supir',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
          AbsensiId: true,
          trado_id: $('#crudForm [name=trado_id]').val(),
          tgltrip: $('#crudForm [name=tglbukti]').val(),
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
          from: 'suratpengantar'
        }
      },
      onSelectRow: (triptangki, element) => {
        $('#crudForm [name=triptangki_id]').first().val(triptangki.id)
        element.val(triptangki.keterangan)
        element.data('currentValue', element.val())
        getDataUpahSupirTangki($('#crudForm [name=tarifrincian_id]').val())
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
        clearTripAsal()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=agen_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
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
        element.val(jenisorder.keterangan)
        element.data('currentValue', element.val())
        enabledUpahSupir()

        // if ($('#crudForm [name=statuscontainer_id]') != 3) {
        enableTripAsal()
        enableTripAsalLongTrip()
        clearTripAsal()
        // }
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
        element.val(tarifrincian.tujuan)
        element.data('currentValue', element.val())
        getTarifOmset(tarifrincian.id, containerId)
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
      fileName: 'orderantruckingsp',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          container_id: $('#crudForm [name=container_id]').val(),
          agen_id: $('#crudForm [name=agen_id]').val(),
          pelanggan_id: $('#crudForm [name=pelanggan_id]').val(),
          jenisorder_id: $('#crudForm [name=jenisorder_id]').val(),
          trado_id: $('#crudForm [name=trado_id]').val(),
          tglbukti: $('#crudForm [name=tglbukti]').val(),
        }
      },
      onSelectRow: (orderantrucking, element) => {
        element.val(orderantrucking.nobukti)
        element.data('currentValue', element.val())
        getOrderanTrucking(orderantrucking.nobukti)
        // enabledUpahSupir()
        getTarifOmset($('#crudForm [name=tarifrincian_id]').val(), orderantrucking.containerid)

      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        // upahSupirReadOnly()
        // clearUpahSupir()
        // nominalSupir = 0
        // getNominalSupir()
        // $('#crudForm [name=gajikenek]').val(0)
        // $('#crudForm [name=komisisupir]').val(0)
        // kotadariId = 0
        // kotasampaiId = 0
        element.val('')
        // $('#crudForm [name=upah_id]').val('')
        // $('#crudForm [name=upah]').val('').data('currentValue', '')
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
        getDataUpahSupir()
        $('#crudForm').find(`[name="omset"]`).val(0)
        $('#crudForm [name=gajisupir]').val(0)
        initAutoNumeric($('#crudForm').find('[name="omset"]'))
        initAutoNumeric($('#crudForm').find('[name="gajisupir"]'))
        setNominalKenek(0, 0)
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
      // kotaUpahZona()
    } else {
      if (container_id.val() == '') {
        upahSupirReadOnly()
      } else if (statuscontainer_id.val() == '') {
        upahSupirReadOnly()
      } else if (jenisorder_id.val() == '') {
        upahSupirReadOnly()
      } else {

        // kotaUpahZona()
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

    if ($('#crudForm [name=statuslangsir]').val() != 79) {
      if ($('#crudForm [name=statuslongtrip]').val() != 65) {

        $('#crudForm [name=dari_id]').val('')
        $('#crudForm [name=sampai_id]').val('')
        $('#crudForm [name=dari]').val('')
        $('#crudForm [name=sampai]').val('')
      }
    }
    $('#crudForm [name=tarifrincian_id]').val('')
    $('#crudForm [name=tarifrincian]').val('')
    $('#crudForm [name=penyesuaian]').val('')
  }

  function kotaUpahZona() {
    console.log('kotaupahzona')
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
    let dari = $('#crudForm').find(`[name="dari"]`).parents('.input-group')
    let sampai = $('#crudForm').find(`[name="sampai"]`).parents('.input-group')
    let statuscontainer = $('#crudForm').find(`[name="statuscontainer"]`).parents('.input-group')

    if (!edit) {

      editUpahZona = $('#crudForm').find(`[name="statusupahzona"]`).val()
      editStatusPenyesuaian = $('#crudForm').find(`[name="statuspenyesuaian"]`).val()
      $('#crudForm').find(`[name="statusupahzona"]`).prop('disabled', 'disabled')
      $('#crudForm').find(`[name="statuspenyesuaian"]`).prop('disabled', 'disabled')
      // jobtrucking.find('.button-clear').attr('disabled', true)
      // jobtrucking.find('input').attr('readonly', true)
      // jobtrucking.children().find('.lookup-toggler').attr('disabled', true)
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
      $('#crudForm').find(`[name="statuspenyesuaian"]`).prop('disabled', false)
      // jobtrucking.find('.button-clear').attr('disabled', false)
      // jobtrucking.find('input').attr('readonly', false)
      // jobtrucking.children().find('.lookup-toggler').attr('disabled', false)
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
    let dari = $('#crudForm').find(`[name="dari"]`)
    let sampai = $('#crudForm').find(`[name="sampai"]`)
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
    dari.parents('.input-group').find('.input-group-append').hide()
    dari.parents('.input-group').find('.button-clear').hide()
    sampai.parents('.input-group').find('.input-group-append').hide()
    sampai.parents('.input-group').find('.button-clear').hide()
  }


  function getTarifOmset(id, contId) {
    if (id == '') {
      id = 0
    }
    console.log('idtarifomset', id)
    $.ajax({
      url: `${apiUrl}suratpengantar/${id}/getTarifOmset`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      data: {
        container_id: contId,
        statusjeniskendaraan: $('#crudForm [name=statusjeniskendaraan]').val(),
        idtrip: $('#crudForm [name=id]').val()
      },
      success: response => {
        if (response.dataTarif != null) {

          // $('#crudForm [name=lokasibongkarmuat]').first().val(response.dataTarif.tujuan)
          // $('#crudForm [name=hargaperton]').first().val(response.dataTarif.nominalton)
          $('#crudForm ').find(`[name="omset"]`).val(response.dataTarif.nominal)
          initAutoNumeric($('#crudForm ').find(`[name="omset"]`))
          setNominal()
        } else {
          initAutoNumeric($('#crudForm ').find(`[name="omset"]`))
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

        // var kondisi = response.kondisi
        var error = response.error

        // if (!response.edit) {
        isAllowEdited = response.edit;
        // console.log(isAllowEdited);
        // }

        // if (kondisi == true) {
        if (error) {
          showDialog(response)
          // showDialog(response.message['keterangan'])
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

  function setNominalKenek(nominalKenek, nominalKomisi) {
    $('#crudForm [name=gajikenek]').remove()
    $('#crudForm [name=komisisupir]').remove()
    elGajiKenek = $(`<input type="text" name="gajikenek" id="gajikenek" class="form-control text-right" readonly>`)
    elKomisiSupir = $(`<input type="text" name="komisisupir" id="komisisupir" class="form-control text-right" readonly>`)
    $('.elgajikenek').append(elGajiKenek)
    $('.elkomisisupir').append(elKomisiSupir)

    $('#crudForm [name=gajikenek]').val(nominalKenek)
    $('#crudForm [name=komisisupir]').val(nominalKomisi)
    initAutoNumeric($('#crudForm').find('[name="gajikenek"]'))
    initAutoNumeric($('#crudForm').find('[name="komisisupir"]'))

    if (isKomisi == 'TIDAK') {
      $('#crudForm').find(`[name="gajikenek"]`).attr('readonly', false)
      $('#crudForm').find(`[name="komisisupir"]`).attr('readonly', false)
    } else {
      $('#crudForm').find(`[name="gajikenek"]`).attr('readonly', false)

    }
  }

  function clearGajiSupir() {
    $('#crudForm').find(`[name="gajisupir"]`).val('')
    $('#crudForm').find(`[name="gajisupirmaster"]`).val('')
    $('#crudForm').find(`[name="gajikenekmaster"]`).val('')
    $('#crudForm').find(`[name="komisisupirmaster"]`).val('')
  }

  function getOrderanTrucking(nobukti) {
    $.ajax({
      url: `${apiUrl}suratpengantar/getOrderanTrucking`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        nobukti: nobukti
      },
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {
        // getTarifOmset(response.data.tarif_id)
        jenisorderId = response.data.jenisorder_id
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
        getDataUpahSupir(true)
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
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
          isGudangSama = false
        }
      }
    } else {
      $('.nobukti_tripasal').hide()
      clearTripAsal()
      isGudangSama = false
    }
  }

  function clearTripAsal() {
    $('#crudForm [name=nobukti_tripasal]').val('')
    $('#crudForm [name=nobukti_tripasal]').data('currentValue', '')
  }

  function enableTripAsalLongTrip() {
    let statuslongtrip = $(`#crudForm [name="statuslongtrip"]`).val()
    let jenisorder_id = $('#crudForm [name=jenisorder_id]').val()
    let statuscontainer_id = $('#crudForm [name=statuscontainer_id]').val()
    if (statuslongtrip == 66) {
      if ((jenisorder_id == 2 && statuscontainer_id == 2) || (jenisorder_id == 3 && statuscontainer_id == 2) || (jenisorder_id == 1 && statuscontainer_id == 1) || (jenisorder_id == 4 && statuscontainer_id == 1)) {
        $('.nobukti_tripasal').show()
        isPulangLongtrip = true;
      } else {
        $('.nobukti_tripasal').hide()
        clearTripAsal()
        isPulangLongtrip = false;
      }
    } else {
      if ((jenisorder_id == 2 && statuscontainer_id == 1) || (jenisorder_id == 3 && statuscontainer_id == 1) || (jenisorder_id == 1 && statuscontainer_id == 2) || (jenisorder_id == 1 && statuscontainer_id == 1) || (jenisorder_id == 4 && statuscontainer_id == 2)) {
        $('.nobukti_tripasal').show()
        isPulangLongtrip = false;
      } else {

        $('.nobukti_tripasal').hide()
        clearTripAsal()
        isPulangLongtrip = false;
      }
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
      $(".upahsupir").appendTo("#kotaTrip");
      $(".penyesuaian").appendTo("#kotaTrip");
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
      $(".upahsupir").appendTo("#kotaLongtrip");
      $(".penyesuaian").appendTo("#kotaLongtrip");
      $(".nobukti_tripasal").appendTo("#tripasal");
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
      $(".upahsupir").appendTo("#kotaTrip");
      $(".penyesuaian").appendTo("#kotaTrip");
    } else {
      if ($('#crudForm [name=statuslongtrip]').val() == 65) {
        if (isAllowEdited) {
          kotasampai_id.parents('.input-group').find('.input-group-append').show()
          kotasampai_id.parents('.input-group').find('.button-clear').show()
        } else {

          kotadari_id.attr('readonly', true)
          kotasampai_id.attr('readonly', true)
        }
      }
    }
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
  function approvalTolakan(id) {
    event.preventDefault()
    let formTolakan = $('#crudFormTolakan')

    $('.modal-loader').removeClass('d-none')
    formTolakan.trigger('reset')
    formTolakan.find('#btnSubmitTolakan').html(`
    <i class="fa fa-save"></i>
    Save
    `)
    formTolakan.data('action', 'tolakan')
    $('#crudModalTolakanTitle').text('approval/un tolakan')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    Promise
      .all([
        setStatusTolakanOptions(formTolakan)
      ])
      .then(() => {

        showTolakan(formTolakan, id)
          .then(() => {
            $('#crudModalTolakan').modal('show')
          }).catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function showTolakan(form, Id) {
    return new Promise((resolve, reject) => {

      $.ajax({
        url: `${apiUrl}suratpengantar/${Id}/getTolakan`,
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
            } else if (element.hasClass('datepicker')) {
              element.val(value)
            } else {
              element.val(value)
            }

          })
          initAutoNumeric(form.find(`[name="omsettolakan"]`))
          initAutoNumeric(form.find(`[name="nominalperalihantolakan"]`))
          initAutoNumeric(form.find(`[name="persentaseperalihantolakan"]`))
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }
  $('#crudModalTolakan').on('shown.bs.modal', () => {
    let form = $('#crudFormTolakan')

    setFormBindKeys(form)

    activeGrid = null
    initSelect2(form.find('.select2bs4'), true)
  })
  $('#crudModalTolakan').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'

    if (selectedRows.length > 0) {
      clearSelectedRows()
    }
    $('#crudModalTolakan').find('.modal-body').html(modalBodyTolakan)
    initDatepicker('datepickerIndex')
  })


  $(document).on('input', `#crudFormTolakan [name="persentaseperalihantolakan"]`, function(event) {
    setNominalTolakan()
  })

  $(document).on('input', `#crudFormTolakan [name="nominalperalihantolakan"]`, function(event) {
    setPersentaseTolakan()
  })

  function setNominalTolakan() {
    let persentase = $(`#crudFormTolakan [name="persentaseperalihantolakan"]`)
    let omset = $(`#crudFormTolakan [name="omsettolakan"]`).val()

    totalPersentase = (AutoNumeric.getNumber(persentase[0]) / 100) * parseFloat(omset.replace(/,/g, ''));
    let getNominal = AutoNumeric.getAutoNumericElement($(`#crudFormTolakan [name="nominalperalihantolakan"]`)[0]);
    getNominal.set(totalPersentase)
  }

  function setPersentaseTolakan() {
    let nominalDetails = $(`#crudFormTolakan [name="nominalperalihantolakan"]`)
    let omset = $(`#crudFormTolakan [name="omsettolakan"]`).val()
    let total = 0

    total = (AutoNumeric.getNumber(nominalDetails[0]) / parseFloat(omset.replace(/,/g, ''))) * 100;
    let getPersentase = AutoNumeric.getAutoNumericElement($(`#crudFormTolakan [name="persentaseperalihantolakan"]`)[0]);
    getPersentase.set(total)
  }

  $(document).on('click', `#btnSubmitTolakan`, function(event) {
    event.preventDefault()

    let data = $('#crudFormTolakan').serializeArray()
    data.filter((row) => row.name === 'nominalperalihantolakan')[0].value = AutoNumeric.getNumber($(`#crudFormTolakan [name="nominalperalihantolakan"]`)[0])
    // })

    data.filter((row) => row.name === 'persentaseperalihantolakan')[0].value = AutoNumeric.getNumber($(`#crudFormTolakan [name="persentaseperalihantolakan"]`)[0])

    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')
    $.ajax({
      url: `${apiUrl}suratpengantar/approvalTolakan`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: data,
      success: response => {

        $('#crudModalTolakan').modal('hide')
        $('#crudModalTolakan').find('#crudFormTolakan').trigger('reset')
        selectedRows = []
        selectedbukti = []
        $('#jqGrid').jqGrid().trigger('reloadGrid');

      },
      error: error => {
        console.log('postdata ', error)
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()
          setErrorMessages($('#crudFormTolakan'), error.responseJSON.errors);
        } else {
          showDialog(error.responseJSON)
        }
      },
    }).always(() => {
      $('#processingLoader').addClass('d-none')
      $(this).removeAttr('disabled')
    })
  })
</script>
@endpush()