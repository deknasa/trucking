
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
                <label for="staticEmail" class="col-sm-4 col-form-label">Nama Supir <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="namasupir" class="form-control" value="{{ $supir['namasupir'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Lahir <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <?php 
                        $tgllahir = @$supir['tgllahir'] ? date('d-m-Y',strtotime(@$supir['tgllahir'])) : '';
                        $tgllahir = $tgllahir=='01-01-1900'?'':$tgllahir; 
                    ?>
                    <input type="text" class="form-control formatdate" name="tgllahir" value="{{ $tgllahir }}">
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Alamat <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="alamat" class="form-control" value="{{ $supir['alamat'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Kota <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="kota" class="form-control" value="{{ $supir['kota'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Telp <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="telp" class="form-control numbernoseparate" value="{{ $supir['telp'] ?? '' }}">
                </div>
            </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <select name="statusaktif" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['status'] as $key => $item) { 
                            $selected = @$supir['statusaktif'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['text'] }}</option>
                        <?php } ?>
                    </select>
                </div>
              </div>


            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Nominal Deposit SA</label>
                <div class="col-sm-8">
                  <input type="text" name="nominaldepositsa" class="form-control text-right" value="{{ $supir['nominaldepositsa'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Deposit Ke</label>
                <div class="col-sm-8">
                  <input type="text" name="depositke" class="form-control text-right" value="{{ $supir['depositke'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <?php 
                        $tgl = @$supir['tgl'] ? date('d-m-Y',strtotime(@$supir['tgl'])) : '';
                        $tgl = $tgl=='01-01-1900'?'':$tgl; 
                    ?>
                    <input type="text" class="form-control formatdate" name="tgl" value="{{ $tgl }}">
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Nominal Pinjaman</label>
                <div class="col-sm-8">
                  <input type="text" name="nominalpinjamansaldoawal" class="form-control text-right" value="{{ $supir['nominalpinjamansaldoawal'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">SUPIR LAMA <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <select name="supirold_id" class="form-control select2bs4">
                        <option value="">PILIH SUPIR</option>
                        <?php foreach ($combo['supir'] as $key => $item) { 
                            $selected = @$supir['supirold_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['namasupir'] }}</option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Terbit SIM<span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <?php 
                        $tglterbitsim = @$supir['tglterbitsim'] ? date('d-m-Y',strtotime(@$supir['tglterbitsim'])) : '';
                        $tglterbitsim = $tglterbitsim=='01-01-1900'?'':$tglterbitsim; 
                    ?>
                    <input type="text" class="form-control formatdate" name="tglterbitsim" value="{{ $tglterbitsim }}">
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Exp SIM <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <?php 
                        $tglexpsim = @$supir['tglexpsim'] ? date('d-m-Y',strtotime(@$supir['tglexpsim'])) : '';
                        $tglexpsim = $tglexpsim=='01-01-1900'?'':$tglexpsim; 
                    ?>
                    <input type="text" class="form-control formatdate" name="tglexpsim" value="{{ $tglexpsim }}">
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No SIM <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="nosim" class="form-control numbernoseparate" value="{{ $supir['nosim'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="keterangan" class="form-control" value="{{ $supir['keterangan'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No KTP <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="noktp" class="form-control numbernoseparate" value="{{ $supir['noktp'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No KK <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="nokk" class="form-control numbernoseparate" value="{{ $supir['nokk'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS UPDATE GBR <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <select name="statusadaupdategambar" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['updategambar'] as $key => $item) { 
                            $selected = @$supir['statusadaupdategambar'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['text'] }}</option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS LUAR KOTA <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <select name="statusluarkota" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['luarkota'] as $key => $item) { 
                            $selected = @$supir['statusluarkota'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['text'] }}</option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS ZONA TERTENTU <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <select name="statuszonatertentu" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['zonatertentu'] as $key => $item) { 
                            $selected = @$supir['statuszonatertentu'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['text'] }}</option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Zona <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="zona_id" class="form-control" value="{{ $supir['zona'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Angsuran Pinjaman <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="angsuranpinjaman" class="form-control" value="{{ $supir['angsuranpinjaman'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Plafon Deposito <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="plafondeposito" class="form-control" value="{{ $supir['plafondeposito'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Berhenti Supir <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <?php 
                        $tglberhentisupir = @$supir['tglberhentisupir'] ? date('d-m-Y',strtotime(@$supir['tglberhentisupir'])) : '';
                        $tglberhentisupir = $tglberhentisupir=='01-01-1900'?'':$tglberhentisupir; 
                    ?>
                    <input type="text" class="form-control formatdate" name="tglberhentisupir" value="{{ $tglberhentisupir }}">
                </div>  
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan Resign <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="keteranganresign" class="form-control" value="{{ $supir['keteranganresign'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS BLACKLIST <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <select name="statusblacklist" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['blacklist'] as $key => $item) { 
                            $selected = @$supir['statusblacklist'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['text'] }}</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row p-2">
            <div class="col-md-4">
                <div class="row mb-2">
                    <div class="col">
                        <label class="col-form-label">Upload Foto Supir</label>
                    </div>
                    <div class="col text-right">
                        <button class="btn btn-info btn-sm" id="uploadsupir" type="button">Upload Supir</button>
                    </div>
                </div>
                <div class="dropzone" id="my-dropzone" data-field="supir">
                    <div class="fallback">
                        <input name="file" type="file" />
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="row mb-2">
                    <div class="col">
                        <label class="col-form-label">Upload Foto KTP</label>
                    </div>
                    <div class="col text-right">
                        <button class="btn btn-info btn-sm" type="button" id="uploadBpkb">Upload KTP</button>
                    </div>
                </div>
                <div class="dropzone" id="my-dropzoness" data-field="ktp">
                    <div class="fallback">
                        <input name="file" type="file" />
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="row mb-2">
                    <div class="col">
                        <label class="col-form-label">Upload Foto SIM</label>
                    </div>
                    <div class="col text-right">
                        <button class="btn btn-info btn-sm" type="button">Upload SIM</button>
                    </div>
                </div>
                <div class="dropzone" id="dropzonestnk" data-field="sim">
                    <div class="fallback">
                        <input name="file" type="file" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row p-2">
            <div class="col-md-4">
                <div class="row mb-2">
                    <div class="col">
                        <label class="col-form-label">Upload Foto KK</label>
                    </div>
                    <div class="col text-right">
                        <button class="btn btn-info btn-sm" id="uploadsupir" type="button">Upload KK</button>
                    </div>
                </div>
                <div class="dropzone" id="my-dropzone" data-field="kk">
                    <div class="fallback">
                        <input name="file" type="file" />
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="row mb-2">
                    <div class="col">
                        <label class="col-form-label">Upload Foto SKCK</label>
                    </div>
                    <div class="col text-right">
                        <button class="btn btn-info btn-sm" type="button" id="uploadBpkb">Upload SKCK</button>
                    </div>
                </div>
                <div class="dropzone" id="my-dropzoness" data-field="skck">
                    <div class="fallback">
                        <input name="file" type="file" />
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="row mb-2">
                    <div class="col">
                        <label class="col-form-label">Upload Foto Domisili</label>
                    </div>
                    <div class="col text-right">
                        <button class="btn btn-info btn-sm" type="button">Upload Domisili</button>
                    </div>
                </div>
                <div class="dropzone" id="dropzonestnk" data-field="domisili">
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
                        <a href="{{ route('supir.index') }}" class="btn btn-danger">
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
    let indexUrl = "{{ route('supir.index') }}"
    let fieldLengthUrl = "{{ route('supir.field_length') }}"
    let action = "{{ $action }}"
    let actionUrl = "{{ route('supir.store') }}"
    let method = "POST"
    let csrfToken = "{{ csrf_token() }}"
    let api = "{{ config('app.api_url') }}"
    api = api.replace('api/','');

    /* Set action url */
    <?php if ($action == 'edit') : ?>
        actionUrl = "{{ route('supir.update', $supir['id']) }}?_method=PUT"
        method = "POST"
    <?php elseif ($action == 'delete') : ?>
        actionUrl = "{{ route('supir.destroy', $supir['id']) }}"
        method = "POST"
    <?php endif; ?>
    
    Dropzone.autoDiscover = false;

    $(document).ready(function() {
        $('form').submit(function(e) {
            e.preventDefault()
        })

        let attachArray = {
            'supir':{},
            'ktp':{},
            'sim':{},
            'kk':{},
            'skck':{},
            'domisili':{}
        };

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
                        if (attachArray.supir.hasOwnProperty(key) || attachArray.ktp.hasOwnProperty(key) || attachArray.sim.hasOwnProperty(key) || attachArray.kk.hasOwnProperty(key) || attachArray.skck.hasOwnProperty(key) || attachArray.domisili.hasOwnProperty(key)) {
                          delete attachArray.supir[key];
                          delete attachArray.ktp[key];
                          delete attachArray.sim[key];
                          delete attachArray.kk[key];
                          delete attachArray.skck[key];
                          delete attachArray.domisili[key];
                        }
                    })

                    if (action=='edit' || action=='delete') {
                        var imgsupir = {!! @$supir['photosupir'] ?: "{}" !!}
                        var imgktp = {!! @$supir['photoktp'] ?: "{}" !!}
                        var imgsim = {!! @$supir['photosim'] ?: "{}" !!}
                        var imgkk = {!! @$supir['photokk'] ?: "{}" !!}
                        var imgskck = {!! @$supir['photoskck'] ?: "{}" !!}
                        var imgdomisili = {!! @$supir['photodomisili'] ?: "{}" !!}

                        if (Object.keys(imgsupir).length>0) {
                            var total = Object.keys(imgsupir).length / 3;
                            var idx=0;
                            for (var i = 1; i <= total; i++) {
                                if (i > 1) {
                                    idx +=3;
                                }
                                // console.log(idx);
                                var obj = {
                                  name: imgsupir[idx],
                                  size: 12345,
                                  upload: {
                                    uuid: (Math.random() + 1).toString(36).substring(7)
                                  }
                                };

                                if (name=='g_supir') {
                                    wrapperThis.emit("addedfile", obj);
                                    wrapperThis.emit("thumbnail", obj, `${api}/uploads/supir/${imgsupir[idx]}`);

                                    wrapperThis.emit("complete", obj);
                                    wrapperThis.files.push(obj);
                                    attachArray.supir[obj.upload.uuid] = imgsupir[idx];
                                }
                            }
                        }

                        if (Object.keys(imgktp).length>0) {
                            var total = Object.keys(imgktp).length / 3;
                            var idx=0;
                            for (var i = 1; i <= total; i++) {
                                if (i > 1) {
                                    idx +=3;
                                }

                                var obj = {
                                  name: imgktp[idx],
                                  size: 12345,
                                  upload: {
                                    uuid: (Math.random() + 1).toString(36).substring(7)
                                  }
                                };

                                if (name=='g_ktp') {
                                    wrapperThis.emit("addedfile", obj);
                                    wrapperThis.emit("thumbnail", obj, `${api}/uploads/ktp/${imgktp[idx]}`);
                                    wrapperThis.emit("complete", obj);
                                    wrapperThis.files.push(obj);
                                    attachArray.ktp[obj.upload.uuid] = imgktp[idx];
                                }
                            }
                        }

                        if (Object.keys(imgsim).length>0) {
                            var total = Object.keys(imgsim).length / 3;
                            var idx=0;
                            for (var i = 1; i <= total; i++) {
                                if (i > 1) {
                                    idx +=3;
                                }

                                var obj = {
                                  name: imgsim[idx],
                                  size: 12345,
                                  upload: {
                                    uuid: (Math.random() + 1).toString(36).substring(7)
                                  }
                                };

                                if (name=='g_sim') {
                                    wrapperThis.emit("addedfile", obj);
                                    wrapperThis.emit("thumbnail", obj, `${api}/uploads/sim/${imgsim[idx]}`);
                                    wrapperThis.emit("complete", obj);
                                    wrapperThis.files.push(obj);
                                    attachArray.sim[obj.upload.uuid] = imgsim[idx];
                                }
                            }
                        }

                        if (Object.keys(imgkk).length>0) {
                            var total = Object.keys(imgkk).length / 3;
                            var idx=0;
                            for (var i = 1; i <= total; i++) {
                                if (i > 1) {
                                    idx +=3;
                                }
                                // console.log(idx);
                                var obj = {
                                  name: imgkk[idx],
                                  size: 12345,
                                  upload: {
                                    uuid: (Math.random() + 1).toString(36).substring(7)
                                  }
                                };

                                if (name=='g_kk') {
                                    wrapperThis.emit("addedfile", obj);
                                    wrapperThis.emit("thumbnail", obj, `${api}/uploads/kk/${imgkk[idx]}`);
                                    wrapperThis.emit("complete", obj);
                                    wrapperThis.files.push(obj);
                                    attachArray.kk[obj.upload.uuid] = imgkk[idx];
                                }
                            }
                        }

                        if (Object.keys(imgskck).length>0) {
                            var total = Object.keys(imgskck).length / 3;
                            var idx=0;
                            for (var i = 1; i <= total; i++) {
                                if (i > 1) {
                                    idx +=3;
                                }

                                var obj = {
                                  name: imgskck[idx],
                                  size: 12345,
                                  upload: {
                                    uuid: (Math.random() + 1).toString(36).substring(7)
                                  }
                                };

                                if (name=='g_skck') {
                                    wrapperThis.emit("addedfile", obj);
                                    wrapperThis.emit("thumbnail", obj, `${api}/uploads/skck/${imgskck[idx]}`);
                                    wrapperThis.emit("complete", obj);
                                    wrapperThis.files.push(obj);
                                    attachArray.skck[obj.upload.uuid] = imgskck[idx];
                                }
                            }
                        }

                        if (Object.keys(imgdomisili).length>0) {
                            var total = Object.keys(imgdomisili).length / 3;
                            var idx=0;
                            for (var i = 1; i <= total; i++) {
                                if (i > 1) {
                                    idx +=3;
                                }

                                var obj = {
                                  name: imgdomisili[idx],
                                  size: 12345,
                                  upload: {
                                    uuid: (Math.random() + 1).toString(36).substring(7)
                                  }
                                };

                                if (name=='g_domisili') {
                                    wrapperThis.emit("addedfile", obj);
                                    wrapperThis.emit("thumbnail", obj,`${api}/uploads/domisili/${imgdomisili[idx]}`);
                                    wrapperThis.emit("complete", obj);
                                    wrapperThis.files.push(obj);
                                    attachArray.domisili[obj.upload.uuid] = imgdomisili[idx];
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

            let form = new FormData($('form')[0])

            if (action=='edit') {
                form.append('g_all', JSON.stringify(attachArray))
            }

            dropzones.forEach(dropzone => {
              let  { paramName }  = dropzone.options
              dropzone.files.forEach((file, i) => {
                form.append(paramName + '[' + i + ']', file)
              })
            })

            if(action=='delete') {
                form.append('_method','DELETE')
            }
            // console.log(form.get('sortIndex'));
            $.ajax({
                url: actionUrl,
                method: method,
                dataType: 'JSON',
                // data: $('form').serializeArray(),
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
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
                    alert(`${error.statusText} | ${error.responseText}`)
                },
            }).always(() => {
                $(this).removeAttr('disabled')
            })
        })

        /* Get field maxlength */
        $.ajax({
            url: fieldLengthUrl,
            method: 'GET',
            dataType: 'JSON',
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