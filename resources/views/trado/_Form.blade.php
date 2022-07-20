
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">Form {{ $title }}</div>
                <form action="" method="post">
                    <div class="card-body">
                        @csrf
                        <input type="hidden" name="limit" value="{{ $_GET['limit'] ?? 10 }}">
                        <input type="hidden" name="sortIndex" value="{{ $_GET['sortname'] ?? 'id' }}">
                        <input type="hidden" name="sortOrder" value="{{ $_GET['sortorder'] ?? 'asc' }}">
                        <input type="hidden" name="indexRow" value="{{ $_GET['indexRow'] ?? 1 }}">
                        <input type="hidden" name="page" value="{{ $_GET['page'] ?? 1 }}">

                        <div class="row">
            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="keterangan" class="form-control" value="{{ $trado['keterangan'] ?? '' }}">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <select name="statusaktif" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['status'] as $key => $item) { 
                            $selected = @$trado['statusaktif'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['text'] }}</option>
                        <?php } ?>
                    </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Kilometer Awal <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control text-right number auto-numeric" name="kmawal" value="{{ @(int)$trado->kmawal }}">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl STNK Mati <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <?php 
                        $tglstnkmati = @$trado['tglstnkmati'] ? date('d-m-Y',strtotime(@$trado['tglstnkmati'])) : '';
                        $tglstnkmati = $tglstnkmati=='01-01-1900'?'':$tglstnkmati; 
                    ?>
                    <input type="text" class="form-control formatdate" name="tglstnkmati" value="{{ $tglstnkmati }}">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Asuransi Mati <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <?php 
                        $tglasuransimati = @$trado['tglasuransimati'] ? date('d-m-Y',strtotime(@$trado['tglasuransimati'])) : '';
                        $tglasuransimati = $tglasuransimati=='01-01-1900'?'':$tglasuransimati; 
                    ?>
                  <input type="text" class="form-control formatdate" name="tglasuransimati" value="<?= $tglasuransimati ?>">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tahun <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input pattern="[0-9.]+" type="text" class="form-control numbernoseparate" name="tahun" value="{{ $trado['tahun'] ?? '' }}">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tahun Produksi Akhir <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control numbernoseparate" name="akhirproduksi" value="{{ $trado['akhirproduksi'] ?? '' }}">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Merek <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="merek" value="{{ $trado['merek'] ?? '' }}">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No Rangka <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="norangka" value="{{ $trado['norangka'] ?? '' }}">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No Mesin <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="nomesin" value="{{ $trado['nomesin'] ?? '' }}">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Nama <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nama" value="{{ $trado['nama'] ?? '' }}">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No STNK <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="nostnk" value="{{ $trado['nostnk'] ?? '' }}">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Alamat STNK <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="alamatstnk" value="{{ $trado['alamatstnk'] ?? '' }}">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Standarisasi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <?php 
                        $tglstandarisasi = @$trado['tglstandarisasi'] ? date('d-m-Y',strtotime(@$trado['tglstandarisasi'])) : '';
                        $tglstandarisasi = $tglstandarisasi=='01-01-1900'?'':$tglstandarisasi;
                    ?>
                    <input type="text" class="form-control formatdate" name="tglstandarisasi" value="{{ $tglstandarisasi }}">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Service Opname <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <?php 
                        $tglserviceopname = @$trado['tglserviceopname'] ? date('d-m-Y',strtotime(@$trado['tglserviceopname'])) : '';
                        $tglserviceopname = $tglserviceopname=='01-01-1900'?'':$tglserviceopname;
                    ?>
                    <input type="text" class="form-control formatdate" name="tglserviceopname" value="{{ $tglserviceopname }}">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Status Standarisasi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <select name="statusstandarisasi" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['standarisasi'] as $key => $item) { 
                            $selected = @$trado['statusstandarisasi'] == $item['id'] ? "selected" : "";
                        ?>
                            <option value="<?= $item['id'] ?>" {{ $selected }}><?= $item['text'] ?></option>
                        <?php } ?>
                    </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan Progress Standarisasi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="keteranganprogressstandarisasi" value="{{ $trado['keteranganprogressstandarisasi'] ?? '' }}">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Jenis Plat <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <select name="jenisplat" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['plat'] as $key => $item) { 
                            $selected = @$trado['jenisplat'] == $item['id'] ? "selected" : "";
                        ?>
                            <option value="<?= $item['id'] ?>" {{$selected}}><?= $item['text'] ?></option>
                        <?php } ?>
                    </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Speksi Mati <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <?php 
                        $tglspeksimati = @$trado['tglspeksimati'] ? date('d-m-Y',strtotime(@$trado['tglspeksimati'])) : '';
                        $tglspeksimati = $tglspeksimati=='01-01-1900'?'':$tglspeksimati;
                    ?>
                    <input type="text" class="form-control formatdate" name="tglspeksimati" value="<?= $tglspeksimati ?>">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Pajak STNK <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <?php 
                        $tglpajakstnk = @$trado['tglpajakstnk'] ? date('d-m-Y',strtotime(@$trado['tglpajakstnk'])) : '';
                        $tglpajakstnk = $tglpajakstnk=='01-01-1900'?'':$tglpajakstnk;
                    ?>
                    <input type="text" class="form-control formatdate" name="tglpajakstnk" value="<?= $tglpajakstnk ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Status Mutasi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <select name="statusmutasi" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['mutasi'] as $key => $item) { 
                            $selected = @$trado['statusmutasi'] == $item['id'] ? "selected" : "";
                        ?>
                            <option value="<?= $item['id'] ?>" {{$selected}}><?= $item['text'] ?></option>
                        <?php } ?>
                    </select>
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Status Validasi Kendaraan <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <select name="statusvalidasikendaraan" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['validasikendaraan'] as $key => $item) { 
                            $selected = @$trado['statusvalidasikendaraan'] == $item['id'] ? "selected" : "";
                        ?>
                            <option value="<?= $item['id'] ?>" {{$selected}}><?= $item['text'] ?></option>
                        <?php } ?>
                    </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tipe <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="tipe" value="{{ $trado['tipe'] ?? '' }}">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Jenis <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="jenis" value="{{ $trado['jenis'] ?? ''}}">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Isi Silinder <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control number" name="isisilinder" value="{{ $trado['isisilinder'] ?? '' }}">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Warna <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="warna" value="{{ $trado['warna'] ?? '' }}">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Bahan Bakar <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="bahanbakar" value="{{ $trado['bahanbakar'] ?? '' }}">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Jumlah Sumbu <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control number" name="jlhsumbu" value="{{ $trado['jlhsumbu'] ?? '' }}">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Jumlah Roda <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control number" name="jlhroda" value="{{ $trado['jlhroda'] ?? '' }}">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Model <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="model" value="{{ $trado['model'] ?? '' }}">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No BPKB <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="nobpkb" value="{{ $trado['jlhroda'] ?? '' }}">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Status Mobil Storing <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <select name="statusmobilstoring" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['mobilstoring'] as $key => $item) { 
                            $selected = @$trado['statusmobilstoring'] == $item['id'] ? "selected" : "";
                        ?>
                            <option value="<?= $item['id'] ?>" {{$selected}}><?= $item['text'] ?></option>
                        <?php } ?>
                    </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Milik Mandor <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <select name="mandor_id" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['mandor'] as $key => $item) { 
                            $selected = @$trado['mandor_id'] == $item['id'] ? "selected" : "";
                        ?>
                            <option value="<?= $item['id'] ?>" {{$selected}}><?= $item['namamandor'] ?></option>
                        <?php } ?>
                    </select>
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Jumlah Ban Serap <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control number" name="jlhbanserap" value="{{ $trado['jlhbanserap'] ?? 0 }}">
                </div>
              </div>
            </div>

            <div class="row">
              <!-- <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">App Edit Ban <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <select name="statuseditban" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['appeditban'] as $key => $item) { ?>
                            <option value="<?= $item['id'] ?>"><?= $item['text'] ?></option>
                        <?php } ?>
                    </select>
                </div>
              </div> -->
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Lewat Validasi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <select name="statuslewatvalidasi" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['lewatvalidasi'] as $key => $item) { 
                            $selected = @$trado['statuslewatvalidasi'] == $item['id'] ? "selected" : "";
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['text'] }}</option>
                        <?php } ?>
                    </select>
                </div>
              </div>
            </div>

        <div class="row p-2">
            <div class="col">
                <div class="row mb-2">
                    <div class="col">
                        <label class="col-form-label">Upload Foto Trado</label>
                    </div>
                    <div class="col text-right">
                        <button class="btn btn-info btn-sm" id="uploadTrado" type="button">Upload Trado</button>
                    </div>
                </div>
                <div class="dropzone" id="my-dropzone" data-field="trado">
                    <div class="fallback">
                        <input name="file" type="file" />
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="row mb-2">
                    <div class="col">
                        <label class="col-form-label">Upload Foto BPKB</label>
                    </div>
                    <div class="col text-right">
                        <button class="btn btn-info btn-sm" type="button" id="uploadBpkb">Upload BPKB</button>
                    </div>
                </div>
                <div class="dropzone" id="my-dropzoness" data-field="bpkb">
                    <div class="fallback">
                        <input name="file" type="file" />
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="row mb-2">
                    <div class="col">
                        <label class="col-form-label">Upload Foto STNK</label>
                    </div>
                    <div class="col text-right">
                        <button class="btn btn-info btn-sm" type="button" id="uploadStnk">Upload STNK</button>
                    </div>
                </div>
                <div class="dropzone" id="dropzonestnk" data-field="stnk">
                    <div class="fallback">
                        <input name="file" type="file" />
                    </div>
                </div>
            </div>
        </div>



                    </div>
                    <div class="card-footer">
                        <button type="submit" id="btnSimpan" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            @if(isset($action) && $action == 'delete')
                            Delete
                            @else
                            Simpan
                            @endif
                        </button>
                        <a href="{{ route('trado.index') }}" class="btn btn-danger">
                            <i class="fa fa-window-close"></i>
                            BATAL
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>


    let indexUrl = "{{ route('trado.index') }}"
  let action = "{{ $action }}"

  let actionUrl =  "{{ config('app.api_url') . 'trado' }}" 
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"

  /* Set action url */
  <?php if ($action !== 'add') : ?>
    actionUrl += `/{{ $trado['id'] }}`
  <?php endif; ?>

    /* Set action url */
    <?php if ($action == 'edit') : ?>
        method = "POST"
    <?php elseif ($action == 'delete') : ?>
        method = "POST"
    <?php endif; ?>
    
    Dropzone.autoDiscover = false;

    $(document).ready(function() {
        $('form').submit(function(e) {
            e.preventDefault()
        })

        let attachArray = {
            'trado':{},
            'stnk':{},
            'bpkb':{}
        };
        var baseurl = "http://localhost:8080/trucking-laravel/public";

        const dropzones = []
          $('.dropzone').each(function(i, el){
            const name = 'g_' + $(el).data('field');
            var myDropzone = new Dropzone(el, {
              url: window.location.pathname,
              autoProcessQueue: false,
              uploadMultiple: true,
              parallelUploads: 100,
              maxFiles: 100,
              paramName: name,
              addRemoveLinks: true,
              acceptedFiles: "image/*",
              init: function() {
                    var wrapperThis = this;

                    this.on('removedfile', function(file) {
                        var key = file.upload.uuid;
                        if (attachArray.trado.hasOwnProperty(key) || attachArray.stnk.hasOwnProperty(key) || attachArray.bpkb.hasOwnProperty(key)) {
                          delete attachArray.trado[key];
                          delete attachArray.stnk[key];
                          delete attachArray.bpkb[key];
                        }
                    })

                    if (action=='edit' || action=='delete') {
                        var imgTrado = {!! @$trado['phototrado'] ?: "{}" !!}
                        var imgBpkb = {!! @$trado['photobpkb'] ?: "{}" !!}
                        var imgStnk = {!! @$trado['photostnk'] ?: "{}" !!}

                        if (Object.keys(imgTrado).length>0) {
                            var total = Object.keys(imgTrado).length / 3;
                            var idx=0;
                            for (var i = 1; i <= total; i++) {
                                if (i > 1) {
                                    idx +=3;
                                }
                                // console.log(idx);
                                var obj = {
                                  name: imgTrado[idx],
                                  size: 12345,
                                  upload: {
                                    uuid: (Math.random() + 1).toString(36).substring(7)
                                  }
                                };

                                if (name=='g_trado') {
                                    wrapperThis.emit("addedfile", obj);
                                    wrapperThis.emit("thumbnail", obj, baseurl+'/uploads/trado/' + imgTrado[idx]);
                                    wrapperThis.emit("complete", obj);
                                    wrapperThis.files.push(obj);
                                    attachArray.trado[obj.upload.uuid] = imgTrado[idx];
                                }
                            }
                        }

                        if (Object.keys(imgBpkb).length>0) {
                            var total = Object.keys(imgBpkb).length / 3;
                            var idx=0;
                            for (var i = 1; i <= total; i++) {
                                if (i > 1) {
                                    idx +=3;
                                }

                                var obj = {
                                  name: imgBpkb[idx],
                                  size: 12345,
                                  upload: {
                                    uuid: (Math.random() + 1).toString(36).substring(7)
                                  }
                                };

                                if (name=='g_bpkb') {
                                    wrapperThis.emit("addedfile", obj);
                                    wrapperThis.emit("thumbnail", obj, baseurl+'/uploads/bpkb/' + imgBpkb[idx]);
                                    wrapperThis.emit("complete", obj);
                                    wrapperThis.files.push(obj);
                                    attachArray.bpkb[obj.upload.uuid] = imgBpkb[idx];
                                }
                            }
                        }

                        if (Object.keys(imgStnk).length>0) {
                            var total = Object.keys(imgStnk).length / 3;
                            var idx=0;
                            for (var i = 1; i <= total; i++) {
                                if (i > 1) {
                                    idx +=3;
                                }

                                var obj = {
                                  name: imgStnk[idx],
                                  size: 12345,
                                  upload: {
                                    uuid: (Math.random() + 1).toString(36).substring(7)
                                  }
                                };

                                if (name=='g_stnk') {
                                    wrapperThis.emit("addedfile", obj);
                                    wrapperThis.emit("thumbnail", obj, baseurl+'/uploads/stnk/' + imgStnk[idx]);
                                    wrapperThis.emit("complete", obj);
                                    wrapperThis.files.push(obj);
                                    attachArray.stnk[obj.upload.uuid] = imgStnk[idx];
                                }
                            }
                        }
                    }
                    
                }
            })
            dropzones.push(myDropzone)
        })

        $('#btnSimpan').click(function(e) {
            $(this).attr('disabled', '')

            e.preventDefault();
            e.stopPropagation();

            let form = new FormData($('form')[0]);
            
            $.each($('form').serializeArray(), function( index, value ) {
                form.append(value.name,value.value);
            });

            if (action=='edit') {
                form.append('g_all', JSON.stringify(attachArray))
            }

            dropzones.forEach(dropzone => {
              let  { paramName }  = dropzone.options
              dropzone.files.forEach((file, i) => {
                form.append(paramName + '[' + i + ']', file)
              })
            })

            if(action=='edit') {
                form.append('_method','PUT')
            }

            if(action=='delete') {
                form.append('_method','DELETE')
            }

            $.ajax({
                url: actionUrl,
                method: method,
                dataType: 'JSON',
                // data: $('form').serializeArray(),
                headers: {
                    'Authorization': `Bearer {{ session('access_token') }}`
                },
                data: form,
                processData: false,
                contentType: false,
                success: response => {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()

                    if (response.status) {
                            window.location.href = `${indexUrl}?page=${response.data.page ?? 1}&id=${response.data.id ?? 1}&sortname={{ $_GET['sortname'] ?? '' }}&sortorder={{ $_GET['sortorder'] }}&limit={{ $_GET['limit'] }}`
                    }

                    if (response.errors) {
                        setErrorMessages(response.errors)
                    }
                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        setErrorMessages(error.responseJSON.errors);
                      } else {
                        showDialog(error.statusText)
                      }
                },
            }).always(() => {
                $('#loader').addClass('d-none')
                $(this).removeAttr('disabled')
            })
        })

        /* Get field maxlength */
        $.ajax({
            url: "{{ config('app.api_url') . 'trado/field_length' }}" ,
            method: 'GET',
            dataType: 'JSON',
            headers: {
              'Authorization': `Bearer {{ session('access_token') }}`
            },
            success: response => {
                $.each(response, (index, value) => {
                    if (value !== null && value !== 0 && value !== undefined) {
                        $(`[name=${index}]`).attr('maxlength', value)
                    }
                })
            },
            error: error => {
                alert(error)
            }
        })
    })

</script>
@endpush()