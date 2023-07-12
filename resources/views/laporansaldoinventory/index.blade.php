@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                </div>
                <form id="crudForm">
                    <div class="card-body">
                        <div class=" row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="dari" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-sm-1 mt-2">
                                <h5 class="text-center mt-2">s/d</h5>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="sampai" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Stok<span class="text-danger">*</span></label>

                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="stokdari_id">
                                <input type="text" name="stokdari" class="form-control stokdari-lookup">
                            </div>
                            <div class="col-sm-1 mt-2">
                                <h5 class="text-center mt-2">s/d</h5>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="stoksampai_id">
                                <input type="text" name="stoksampai" class="form-control stoksampai-lookup">
                            </div>
                        </div>

                        <div class="row" id="kategori">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Kategori<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="kategori_id">
                                    <input type="text" name="kategori" class="form-control kategori-lookup">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                           <div class="col-md-6">
                               <div class="row">
                                   
                                   <label class="col-12 col-sm-4 col-form-label mt-2">FILTER<span class="text-danger">*</span></label>
                                       
                                    <div class="col-12 col-sm-8 mt-2">
                                        <select name="filter" id="filter" class="form-select select2bs4" style="width: 100%;">
                                        </select>
                                   </div>
                               </div>
                               <div class="row" id="gudang">
                                   <label class="col-12 col-sm-4 col-form-label mt-2">GUDANG<span class="text-danger">*</span></label>
                                   <div class="col-12 col-sm-8 mt-2">
                                       <div class="input-group">
                                           <input type="hidden" name="gudang_id">
                                           <input type="text" name="gudang" class="form-control gudang-lookup">
                                       </div>
                                   </div>
                               </div>
                               <div class="row" id="trado">
                                   <label class="col-12 col-sm-4 col-form-label mt-2">TRADO<span class="text-danger">*</span></label>
                                   <div class="col-12 col-sm-8 mt-2">
                                       <div class="input-group">
                                           <input type="hidden" name="trado_id">
                                           <input type="text" name="trado" class="form-control trado-lookup">
                                       </div>
                                   </div>
                               </div>
                               <div class="row" id="gandengan">
                                   <label class="col-12 col-sm-4 col-form-label mt-2">GANDENGAN<span class="text-danger">*</span></label>
                                   <div class="col-12 col-sm-8 mt-2">
                                       <div class="input-group">
                                           <input type="hidden" name="gandengan_id">
                                           <input type="text" name="gandengan" class="form-control gandengan-lookup">
                                       </div>
                                   </div>
                               </div>
                           </div>

                           <div class="col-md-6">
                               <div class="row">
                                   <label class="col-12 col-sm-2 col-form-label mt-2">status ban<span class="text-danger">*</span></label>
                                    <div class="col-12 col-sm-8 mt-2">
                                        <select name="statusban" id="statusban" class="form-select select2bs4" style="width: 100%;">
                                        </select>
                                    </div>
                                </div>
                               <div class="row">
                                   <label class="col-12 col-sm-2 col-form-label mt-2">status reuse<span class="text-danger">*</span></label>
                                    <div class="col-12 col-sm-8 mt-2">
                                        <select name="statusreuse" id="statusreuse" class="form-select select2bs4" style="width: 100%;">
                                        </select>
                                    </div>
                                </div>
                           </div>
                       </div>

                        <div class="row">

                            <div class="col-sm-6 mt-4">
                                <a id="btnPreview" class="btn btn-info mr-1 ">
                                    <i class="fas fa-print"></i>
                                    Cetak
                                </a>
                                <a id="btnExport" class="btn btn-warning mr-2 ">
                                    <i class="fas fa-file-export"></i>
                                    Export
                                </a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <table id="jqGrid"></table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    
    $(document).ready(function() {
        initLookup()
        initDatepicker()
        initSelect2($('#crudForm').find('[name=filter]'), false)
        initSelect2($('#crudForm').find('[name=statusban]'), false)
        initSelect2($('#crudForm').find('[name=statusreuse]'), false)

        let form = $("#crudForm");
        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        setFilterOptions(form)
        setStatusBanOptions(form)
        setStatusReuseOptions(form)
    })

    $(document).on('click', `#btnPreview`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let stokdari_id = $('#crudForm').find('[name=stokdari_id]').val()
        let stoksampai_id = $('#crudForm').find('[name=stoksampai_id]').val()
        let kategori_id = $('#crudForm').find('[name=kategori_id]').val()
        let gudang_id = $('#crudForm').find('[name=gudang_id]').val()
        if (dari != '' && sampai != '' && stokdari_id != '' && stoksampai_id != '' && kategori_id != '' & gudang_id != '') {

            window.open(`{{ route('laporankartustok.report') }}?dari=${dari}&sampai=${sampai}&stokdari_id=${stokdari_id}&stoksampai_id=${stoksampai_id}&kategori_id=${kategori_id}&gudang_id=${gudang_id}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })


    $(document).on('click', `#btnExport`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let stokdari_id = $('#crudForm').find('[name=stokdari_id]').val()
        let stoksampai_id = $('#crudForm').find('[name=stoksampai_id]').val()
         let kategori_id = $('#crudForm').find('[name=kategori_id]').val()
         let gudang_id = $('#crudForm').find('[name=gudang_id]').val()
        if (dari != '' && sampai != '' && stokdari_id != '' && stoksampai_id != '' && kategori_id != '' && gudang_id != '') {

            window.open(`{{ route('laporanbukubesar.export') }}?dari=${dari}&sampai=${sampai}&stokdari_id=${stokdari_id}&stoksampai_id=${stoksampai_id}&kategori_id=${kategori_id}&gudang_id=${gudang_id}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    function initLookup() {

        $('.stokdari-lookup').lookup({
            title: 'stok dari lookup',
            fileName: 'stok',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (stok, element) => {
                $('#crudForm [name=stokdari_id]').first().val(stok.id)
                element.val(stok.namastok)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=stokdari_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.stoksampai-lookup').lookup({
            title: 'stok sampai dari lookup',
            fileName: 'stok',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (stok, element) => {
                $('#crudForm [name=stoksampai_id]').first().val(stok.id)
                element.val(stok.namastok)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=stoksampai_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.kategori-lookup').lookup({
            title: 'kategori dari lookup',
            fileName: 'kategori',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (kategori, element) => {
                $('#crudForm [name=kategori_id]').first().val(kategori.id)
                element.val(kategori.kodekategori)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=kategori_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.gudang-lookup').lookup({
            title: 'gudang dari lookup',
            fileName: 'gudang',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (gudang, element) => {
                $('#crudForm [name=gudang_id]').first().val(gudang.id)
                element.val(gudang.gudang)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=gudang_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }

    $(document).on('change', `#crudForm [name="filter"]`, function(event) {
        let filter = $(this).val();
        
        if (filter == '186') {
            $('#gudang').show()
            $('#trado').hide()
            $('#gandengan').hide()
        } else if (filter == '187') {
            $('#trado').show()
            $('#gudang').hide()
            $('#gandengan').hide()
        } else if (filter == '188') {
            $('#gandengan').show()
            $('#gudang').hide()
            $('#trado').hide()
        } else {
            $('#trado').hide()
            $('#gandengan').hide()
            $('#gudang').hide()
        }
    })
        

    const setFilterOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=filter]').empty()
            relatedForm.find('[name=filter]').append(
                new Option('-- SEMUA --', '0', false, true)
            ).trigger('change')

            let data = [];
            data.push({
                name: 'grp',
                value: 'STOK PERSEDIAAN'
            })
            data.push({
                name: 'subgrp',
                value: 'STOK PERSEDIAAN'
            })
            $.ajax({
                url: `${apiUrl}parameter/combo`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {

                    response.data.forEach(stokPersediaan => {
                        let option = new Option(stokPersediaan.text, stokPersediaan.id)
                        relatedForm.find('[name=filter]').append(option).trigger(
                            'change')
                    });

                }
            })
        })
    }

    const setStatusBanOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statusban]').empty()
            relatedForm.find('[name=statusban]').append(
              new Option('-- PILIH STATUS BAN --', '', false, true)
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
                    "data": "STATUS KONDISI BAN"
                  }]
                })
              },
              success: response => {
                response.data.forEach(statusReuse => {
                  let option = new Option(statusReuse.text, statusReuse.id)
      
                  relatedForm.find('[name=statusban]').append(option).trigger('change')
                });
      
                resolve()
              },
              error: error => {
                reject(error)
              }
            })
        })
    }
    const setStatusReuseOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusreuse]').empty()
      relatedForm.find('[name=statusreuse]').append(
        new Option('-- PILIH STATUS REUSE --', '', false, true)
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
              "data": "STATUS REUSE"
            }]
          })
        },
        success: response => {
          response.data.forEach((statusReuse,index) => {
            dataReuse[index] = statusReuse
            // dataReuse[index]['text'] =  statusReuse.text

            let option = new Option(statusReuse.text, statusReuse.id)

            relatedForm.find('[name=statusreuse]').append(option).trigger('change')
          });

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
@endsection