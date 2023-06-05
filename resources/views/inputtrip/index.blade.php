@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">

        <form action="#" id="crudForm">
          <div class=" ">
            <div class="card-header bg-primary">
              <h5 class="card-title" id="crudModalTitle"> {{$title}} </h5>

            </div>
            <form action="" method="post">
              <div class="card-body">

                <div class="form-group ">
                  <label class="col-sm-4 col-form-label">TANGGAL TRIP <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <div class="input-group">
                      <input type="text" name="tglbukti" class="form-control datepicker">
                    </div>
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
                  <label class="col-sm-12 col-form-label">GUDANG SAMA<span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <select name="statusgudangsama" class="form-control select2bs4" id="statusgudangsama">
                      <option value="">-- PILIH STATUS GUDANG SAMA --</option>
                    </select>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">EMKL<span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="agen_id">
                    <input type="text" name="agen" class="form-control agen-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-4 col-form-label">CONTAINER<span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="container_id">
                    <input type="text" name="container" class="form-control container-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">TUJUAN TARIF<span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="tarifrincian_id">
                    <input type="text" name="tarifrincian" class="form-control tarifrincian-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Lokasi BONGKAR/MUAT</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="lokasibongkarmuat" class="form-control" readonly>
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-4 col-form-label">NO POLISI<span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="trado_id">
                    <input type="hidden" name="supir_id">
                    <input type="hidden" name="absensidetail_id">
                    <input type="text" name="trado" class="form-control absensisupirdetail-lookup">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-4 col-form-label">DARI<span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="dari_id">
                    <input type="text" name="dari" class="form-control kotadari-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Sampai<span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="sampai_id">
                    <input type="text" name="sampai" class="form-control kotasampai-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">PELANGGAN<span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="pelanggan_id">
                    <input type="text" name="pelanggan" class="form-control pelanggan-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">NOMOR GANDENGAN / CHASIS<span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="gandengan_id">
                    <input type="text" name="gandengan" class="form-control gandengan-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">JENIS ORDERAN<span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="jenisorder_id">
                    <input type="text" name="jenisorder" class="form-control jenisorder-lookup">
                  </div>
                </div>



                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">FULL / EMPTY<span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="statuscontainer_id">
                    <input type="text" name="statuscontainer" class="form-control statuscontainer-lookup">
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
                  <label class="col-sm-12 col-form-label">GUDANG<span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="gudang" class="form-control">
                  </div>
                </div>

                <div class="table-scroll table-responsive">
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
              <div class="card-footer justify-content-start">
                <button id="btnSubmit" class="btn btn-primary">
                  <i class="fa fa-save"></i>
                  Simpan
                </button>

              </div>
            </form>
          </div>
        </form>

      </div>

    </div>
  </div>
</div>

@push('scripts')

<script>
  let indexRow = 0;
  let triggerClick = true;
  let id = "";
  let jenisorderId
  let containerId
  let tradoId
  let pelangganId
  let gandenganId
  let tarifrincianId
  let statusLongtrip
  var statuspelabuhan

  $(document).ready(function() {

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
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      method = 'POST'
      url = `${apiUrl}inputtrip`

      data.push({
        name: 'indexRow',
        value: indexRow
      })
      data.push({
        name: 'upahritasi',
        value: ''
      })

      $(this).attr('disabled', '')
      $('#loader').removeClass('d-none')

      $.ajax({
        url: url,
        method: method,
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: response => {
          console.log(response.message);
          showSuccessDialog(response.message, response.data.nobukti)
          createSuratPengantar()
        },
        error: error => {
          console.log('postdata ', error)
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            setErrorMessages(form, error.responseJSON.errors);
          } else {
            showDialog(error.statusText)
          }
        },
      }).always(() => {
        $('#loader').addClass('d-none')
        $(this).removeAttr('disabled')
      })

      // $.ajax({
      //   url: url,
      //   method: method,
      //   dataType: 'JSON',
      //   headers: {
      //     Authorization: `Bearer ${accessToken}`
      //   },
      //   data: data,
      //   success: response => {

      //     id = response.data.id
      //     $('#crudModal').modal('hide')
      //     $('#crudModal').find('#crudForm').trigger('reset')

      //     $('#jqGrid').jqGrid('setGridParam', {
      //       page: response.data.page
      //     }).trigger('reloadGrid');

      //     if (response.data.grp == 'FORMAT') {
      //       updateFormat(response.data)
      //     }
      //   },
      //   error: error => {
      //     if (error.status === 422) {
      //       $('.is-invalid').removeClass('is-invalid')
      //       $('.invalid-feedback').remove()

      //       setErrorMessages(form, error.responseJSON.errors);
      //     } else {
      //       showDialog(error.statusText)
      //     }
      //   },
      // }).always(() => {
      //   $('#loader').addClass('d-none')
      //   $(this).removeAttr('disabled')
      // })


    })

    let form = $('#crudForm')
    setFormBindKeys(form)

    activeGrid = null
    createSuratPengantar()
    getMaxLength(form)
    initLookup()
    initDatepicker()
    initSelect2(null, false)
    enabledTarif()
  })

  function enabledTarif() {

    let container_id = $('#crudForm [name=container_id]')
    let tarifrincian = $('#crudForm [name=tarifrincian]')
    // tarifrincian
    if (container_id.val() == '') {
      tarifrincian.attr('readonly', true)
      tarifrincian.parents('.input-group').find('.input-group-append').hide()
      tarifrincian.parents('.input-group').find('.button-clear').hide()
    } else {
      tarifrincian.attr('readonly', false)
      tarifrincian.parents('.input-group').find('.input-group-append').show()
      tarifrincian.parents('.input-group').find('.button-clear').show()
    }
  }


  function createSuratPengantar() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`  <i class="fa fa-save"></i> Simpan `)
    form.data('action', 'add')
    // form.find(`.sometimes`).show()
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    // $('#crudForm').find('[name=tglsp]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    $('#table_body').html('')
    addRow()
    Promise
      .all([
        setStatusLongTripOptions(form),
        setStatusGudangSamaOptions(form),
      ])
      .then(() => {
        setIsDateAvailable(form),
          showDefault(form)
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
            relatedForm.find('[name=statuslongtrip]').append(option).trigger('change')
          });

          resolve()
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
        }
      })
    })
  }
  const setStatusRitasi = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find(`[name="jenisritasi[]"]`).empty()
      relatedForm.find(`[name="jenisritasi[]"]`).append(
        new Option('-- PILIH JENIS RITASI --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter/combo`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          grp: 'STATUS RITASI',
          subgrp: 'STATUS RITASI'
        },
        success: response => {
          response.data.forEach(jenisRitasi => {
            let option = new Option(jenisRitasi.text, jenisRitasi.id)

            relatedForm.find(`[name="jenisritasi[]"]`).append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  function setIsDateAvailable(form) {
    $.ajax({
      url: `${apiUrl}suratpengantarapprovalinputtrip/cektanggal`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let tglbukti = $('#crudForm').find(`[name="tglbukti"]`).parents('.input-group').children()
        if (response.data.length) {
          // $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
          tglbukti.attr('readonly', false);
          tglbukti.find('.ui-datepicker-trigger').attr('disabled', false)
        } else {
          tglbukti.attr('readonly', true);
          tglbukti.find('.ui-datepicker-trigger').attr('disabled', true)
        }

      }
    })
  }

  function showDefault(form) {
    $.ajax({
      url: `${apiUrl}suratpengantar/default`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        containerId = 0
        jenisorderId = 0
        tradoId = 0
        gandenganId = 0
        pelangganId = 0
        taridrincianId = 0
        statusLongtrip = 0
        statuspelabuhan = '1'
        setJobReadOnly()



        $.each(response.data, (index, value) => {
          console.log(value)
          let element = form.find(`[name="${index}"]`)
          // let element = form.find(`[name="statusaktif"]`)

          if (element.is('select')) {
            element.val(value).trigger('change')
          } else {
            element.val(value)
          }
        })


      }
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

  function getTarifOmset(id) {
    $.ajax({
      url: `${apiUrl}suratpengantar/${id}/getTarifOmset`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {
        $('#crudForm [name=lokasibongkarmuat]').first().val(response.dataTarif.tujuan)
        $('#crudForm [name=hargaperton]').first().val(response.dataTarif.nominalton)
        // initAutoNumeric($('#crudForm ').find(`[name="omset"]`))
      },
      error: error => {
        showDialog(error.statusText)
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
      jobtrucking.parents('.input-group').find('.input-group-append').show()
      jobtrucking.parents('.input-group').find('.button-clear').show()
    }
  }




  function initLookup() {
    $('.kotadari-lookup').lookup({
      title: 'Kota Dari Lookup',
      fileName: 'kota',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (kota, element) => {
        $('#crudForm [name=dari_id]').first().val(kota.id)
        kotadariId = kota.id
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
      fileName: 'kota',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (kota, element) => {
        $('#crudForm [name=sampai_id]').first().val(kota.id)
        kotasampaiId = kota.id

        element.val(kota.keterangan)
        element.data('currentValue', element.val())
        // getGaji()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=sampai_id]').first().val('')
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
        pelangganId = pelanggan.id

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
        console.log(containerId)
        element.val(container.keterangan)
        element.data('currentValue', element.val())
        enabledTarif()
        // getGaji()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
        enabledTarif()
      },
      onClear: (element) => {
        $('#crudForm [name=container_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
        enabledTarif()
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

        element.val(statuscontainer.keterangan)
        element.data('currentValue', element.val())
        // getGaji()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=statuscontainer_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
        // getGaji()
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

        element.val(trado.keterangan)
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
        gandenganId = gandengan.id

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
        jenisorderId = jenisorder.id
        element.val(jenisorder.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=jenisorder_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.tarifrincian-lookup').lookup({
      title: 'Tarif Rincian Lookup',
      fileName: 'tarifrincian',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          Aktif: 'AKTIF1',
          container_Id: containerId,
        }
      },
      onSelectRow: (tarifrincian, element) => {
        $('#crudForm [name=tarifrincian_id]').first().val(tarifrincian.id)
        tarifrincianId = tarifrincian.id
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

  }

  function addRow() {
    let detailRow = $(`
      <tr>
        <td></td>
        <td>
            <select name="jenisritasi[]" class="form-control select2bs4">
              <option value="">-- PILIH JENIS RITASI --</option>
            </select>
        </td>
        <td>
          <input type="hidden" name="ritasidari_id[]">
          <input type="text" name="ritasidari[]" class="form-control ritasidari-lookup">
        </td>
        <td>
          <input type="hidden" name="ritasike_id[]">
          <input type="text" name="ritasike[]" class="form-control ritasike-lookup">
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm delete-row">HAPUS</button>
        </td>
      </tr>
    `)

    $('#ritasiList tbody').append(detailRow)
    setStatusRitasi(detailRow)
    initSelect2(detailRow.find(`[name="jenisritasi[]"]`), false)

    $('.ritasidari-lookup').last().lookup({
      title: 'RITASI DARI Lookup',
      fileName: 'kota',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (kota, element) => {
        element.parents('td').find(`[name="ritasidari_id[]"]`).val(kota.id)
        element.val(kota.kodekota)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.parents('td').find(`[name="ritasidari_id[]"]`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.ritasike-lookup').last().lookup({
      title: 'RITASI KE Lookup',
      fileName: 'kota',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (kota, element) => {
        element.parents('td').find(`[name="ritasike_id[]"]`).val(kota.id)
        element.val(kota.kodekota)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.parents('td').find(`[name="ritasike_id[]"]`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    setRowNumbers()
  }

  function deleteRow(row) {
    row.remove()

    setRowNumbers()
    setTotal()
  }

  function setRowNumbers() {
    let elements = $('#ritasiList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }
</script>
@endpush

@endsection