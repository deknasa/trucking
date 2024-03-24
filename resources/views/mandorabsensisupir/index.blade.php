@extends('layouts.master')

@section('content')
<div class="card card-easyui bordered mb-4">
  <div class="card-header"></div>
  <form id="tglBuka">
    <div class="card-body">
      <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label mt-2">Tgl absensi<span class="text-danger">*</span></label>
        <div class="col-sm-4 mt-2">
          <div class="input-group">
            <input type="text" name="tglbukaabsensi" id="tglbukaabsensi" class="form-control datepickerIndex">
            <input type="text" name="tglshow" id="tglshow" class="form-control " style="display:none">
          </div>
        </div>

      </div>
      <div class="row">

        <div class="col-sm-6 mt-4">
          <a id="btnReload" class="btn btn-primary mr-2 ">
            <i class="fas fa-sync-alt"></i>
            Reload
          </a>
        </div>
      </div>

    </div>
  </form>
</div>
<!-- Grid -->
<div class="row mt-5">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body"  style="height:500px; overflow-y: scroll;">
        <!-- <div class="table-responsive"> -->
        <table class="table table-bordered table-bindkeys" id="detailList" style="width: 1800px;">
          <thead style="background-color:white; border-color: #bad5ff;" >
            <tr>
              <th width="2%">No</th>
              <th width="8%">Trado</th>
              <th width="12%">Supir</th>
              <th width="10%">Status</th>
              <th width="8%">jlh trip</th>
              <th width="15%">Keterangan</th>
              <th width="6%">tgl batas</th>
              <th width="4%">Aksi</th>
            </tr>
            <tr class="filters">
            </tr>
          </thead>
          <tbody id="table_body" class="form-group">
            <tr>
              
            </tr>
          </tbody>
        </table>
        <!-- </div> -->
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <button id="btnSubmitAbsen" class="btn btn-primary">
          <i class="fa fa-save"></i>
          Save
        </button>
      </div>
    </div>
  </div>
</div>
@include('mandorabsensisupir._modal')
@push('scripts')
<script>
  let indexRow = 0;
  let triggerClick = true;
  let id = "";
  var totalPages = 0;
  let itemsPerPage = 10;
  let selectedRowEditAll = null;
  let totalRowsEditAll = 0
  let lastPageEditAll
  let filterObject
  let firstPage = false;
  var currentPage = 0;
  let isTradoMilikSupir =''
  let dataAbsensi = {}

  $(document).ready(function() {
    // setTradoMilikSupir()
    initDatepicker('datepickerIndex')
    // mendapatkan tanggal hari ini
    let today = new Date();
    // let tglBuka = new Date(today.getFullYear(), today.getMonth(), 1);
    let formattedTglBuka = $.datepicker.formatDate('dd-mm-yy', today);
    $('#tglBuka').find('[name=tglbukaabsensi]').val(formattedTglBuka).trigger('change');
    $('#tglshow').val(formattedTglBuka);

    $(document).on('click', '#btnReload', function(event) {
      dataAbsensi = {}
      getAll(1, 0, filterObject)
    //deleted_id

      let dataColumn = ["kodetrado","namasupir","absentrado","jlhtrip","keterangan"] 
      filtersEditAll(dataColumn)
      bindKeyPagerEditAll()
      totalInfoPage()

    })

    getAll(1, 0, filterObject)
    //deleted_id
    let dataColumn = ["kodetrado","namasupir","absentrado","jlhtrip","keterangan"] 
    filtersEditAll(dataColumn)
    bindKeyPagerEditAll()
    totalInfoPage()

    $(document).on('click', '#btnSubmitAbsen', function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let action = form.data('action')
      
      $('.trow').each((index, element) => {
        let idRow = $(element).find(`[name="id[]"]`).val();
        pushToObject(idRow, null, null)
      })

      $('#processingLoader').removeClass('d-none')
      $.ajax({
        url: `${apiUrl}mandorabsensisupir`,
        method: 'POST',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          data: JSON.stringify(dataAbsensi)
        },
        success: response => {
          getAll(1, 0, filterObject)
          //deleted_id

          dataAbsensi = {}
        },
        error: error => {
          $(".ui-state-error").removeClass("ui-state-error");

          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()
          errors = error.responseJSON.errors
          $.each(errors, (index, error) => {
            let indexes = index.split(".");
            let angka = indexes[0]
            let col = indexes[1]
            let element = $(`#row${angka}`).find(`[name="${col}[]"]`);
            if ($(element).length > 0 && !$(element).is(":hidden")) {
              $(element).addClass("is-invalid");
              $(`
              <div class="invalid-feedback">
              ${error[0].toLowerCase()}
              </div>
              `).appendTo($(element).parent());
            } else {
              console.log(error);
              return showDialog(error);
            }
          });
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })



    })

  })

  function getAll(page, limit = 0, filters = [], date = '',deleted_id =0) {
    let data  ={
      page: page,
      limit: limit,
      sortIndex: 'kodetrado',
      sortOrder: 'asc',
      filters: JSON.stringify(filters),
      tglbukaabsensi: $('#tglbukaabsensi').val(),
      deleted_id: deleted_id,
    
    }
    $('#processingLoader').removeClass('d-none')

    let url = 'mandorabsensisupir'
    getIndex(url, data)
    .then((response) => {
      $('#tglshow').val($('#tglBuka').find('[name=tglbukaabsensi]').val());
      $('.is-invalid').removeClass('is-invalid')
      $('.invalid-feedback').remove()
      setTableMandoAbsensi(response)
     
      $('#processingLoader').addClass('d-none')
      
    }).catch((error) => {
      $('#processingLoader').addClass('d-none')
      if (error.status === 422) {
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        setErrorMessages($('#tglBuka'), error.responseJSON.errors);
        $('#jqGrid').setGridParam({
          datatype: "local",
          data: [],
        }).trigger('reloadGrid')

      } else {
        showDialog(error.statusText)
      }
    })
  }
      
  function setTableMandoAbsensi(data) {
    $('#detailList tbody').html('')
    let tradosupir = data.attributes.tradosupir
    $.each(data.data, (index, detail) => {
      let detailRow = $(`
      <tr id="row${detail.id}" class="trow row_id${detail.id} index${index}">
        <td></td>
        <td>
          <input type="hidden" name="id[]" value="${detail.id}">
          <input type="hidden" name="trado_id[]" value="${detail.trado_id}">
          <input type="text" name="kodetrado[]" data-current-value="${detail.kodetrado}" class="form-control" value="${detail.kodetrado}" readonly>
        </td>
        <td>
          <input type="hidden" name="namasupir_old[]" id="supir_old_row_${index}" value="${detail.namasupir_old}">
          <input type="hidden" name="supir_id_old[]" id="supir_old_id_row_${index}" value="${detail.supir_id_old}">

          <input type="hidden" name="supir_id[]" id="supir_id_row_${index}">
          <input type="text" name="namasupir[]" data-current-value="" class="form-control supir-editable supir-lookup-${index}" id="supir_row_${index}" value="">
        </td>
        
        <td>
          <input type="hidden" name="absen_id[]" value="${detail.absen_id}">
          <input type="text" name="absentrado[]"  data-current-value="" class="form-control  absentrado-lookup-${index}" value="">
        </td>
        <td>
          <input type="text" class="form-control autonumeric" name="jlhtrip[]" value="${detail.jlhtrip}" disabled></input>
          <input type="text" class="form-control inputmask-time" hidden name="jam[]" value="${detail.jam}"></input>
        </td>
        <td>
          <input type="text" name="keterangan[]" class="form-control" value="" autocomplete="off">
        </td>
        <td>
          <input type="text" class="form-control autonumeric" name="tglbatas[]" value="${detail.tglbatas}" disabled></input>
        </td>
        <td>
          <button data-trado="${detail.trado_id}" data-supir="${detail.supir_id}" data-id="${detail.id}" class="btn btn-danger btn-sm delete-row"><i class="fa fa-trash"></i> Delete</button>
        </td>
       
        <input type="hidden" name="tglbukti[]" value="${detail.tglbukti}">
        <input type="hidden" name="namasupir_old[]" value="${detail.namasupir_old}">
        <input type="hidden" name="supirold_id[]" value="${detail.supir_id_old}">

      </tr>
      `)
      $('#detailList tbody').append(detailRow)

      detailRow.find(`[name="supir_id[]"]`).val(detail.supir_id)
      if (detail.namasupir) {
        detailRow.find(`[name="namasupir[]"]`).val(detail.namasupir)
        detailRow.find(`[name="namasupir[]"]`).attr("data-current-value", detail.namasupir);
      }
      if (detail.keterangan) {
        detailRow.find(`[name="keterangan[]"]`).val(detail.keterangan)
      }
      if (detail.absentrado) {
        detailRow.find(`[name="absentrado[]"]`).val(detail.absentrado)
        detailRow.find(`[name="absentrado[]"]`).attr("data-current-value", detail.absentrado);
      }
      // console.log(response.attributes.tradosupir);
      initLookupDetail(index, detailRow, detail);

      if (tradosupir === true) {
        $(`.supir-editable`).last().parents('td').children().find('input').attr('readonly',true)
        $(`.supir-editable`).last().parents('td').children().find('.lookup-toggler').attr('disabled', true)
        $(`.supir-editable`).last().parents('td').children().find('.button-clear').attr('disabled', true)
      } else {
        $(`.supir-editable`).last().parents('td').children().find('input').attr('readonly',false)
        $(`.supir-editable`).last().parents('td').children().find('.lookup-toggler').attr('disabled', false)
        $(`.supir-editable`).last().parents('td').children().find('.button-clear').attr('disabled', false)
      }

      // supir
      // absentrado
      // keterangan_detail
      
      pushToObject(detail.id,null,null)

    })
    
    setRowNumbers()
  }

  function pushToObject(id, cell, value) {
    if (dataAbsensi.hasOwnProperty(String(id))) {
      delete dataAbsensi[String(id)];
    }
    let rowElement = $(`#row${id}`)
    dataAbsensi[id] = {
      id: $(rowElement).find(`[name="id[]"]`).val(),
      trado_id: ( $(rowElement).find(`[name="trado_id[]"]`).val() != "null") ? $(rowElement).find(`[name="trado_id[]"]`).val() : 0,
      supir_id: ( $(rowElement).find(`[name="supir_id[]"]`).val() != "null") ? $(rowElement).find(`[name="supir_id[]"]`).val() : 0,
      supirold_id: ( $(rowElement).find(`[name="supirold_id[]"]`).val() != "null") ? $(rowElement).find(`[name="supirold_id[]"]`).val() : 0,
      absen_id: ( $(rowElement).find(`[name="absen_id[]"]`).val() != "null") ? $(rowElement).find(`[name="absen_id[]"]`).val() : 0,
      kodetrado: ( $(rowElement).find(`[name="kodetrado[]"]`).val() != 'null') ? $(rowElement).find(`[name="kodetrado[]"]`).val() :"",
      namasupir: ( $(rowElement).find(`[name="namasupir[]"]`).val() != 'null') ? $(rowElement).find(`[name="namasupir[]"]`).val() :"",
      namasupir_old: ( $(rowElement).find(`[name="namasupir_old[]"]`).val() )? $(rowElement).find(`[name="namasupir_old[]"]`).val() :"",
      absentrado: ( $(rowElement).find(`[name="absentrado[]"]`).val() != 'null') ? $(rowElement).find(`[name="absentrado[]"]`).val() :"",
      keterangan: ( $(rowElement).find(`[name="keterangan[]"]`).val() != 'null') ? $(rowElement).find(`[name="keterangan[]"]`).val() :"",
      tglbukti: ( $(rowElement).find(`[name="tglbukti[]"]`).val() != 'null') ? $(rowElement).find(`[name="tglbukti[]"]`).val() :"",
    }
  }

  function setTradoMilikSupir() {
    $.ajax({
      url: `${apiUrl}parameter/getparamfirst`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        grp: 'ABSENSI SUPIR',
        subgrp: 'TRADO MILIK SUPIR'
      },
      success: response => {
        isTradoMilikSupir = $.trim(response.text)
      }
    })
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  $(document).on('click', '.delete-row', function(event) {
    let tradoId = $(this).data('trado')
    let supirId = $(this).data('supir')
    let id = $(this).data('id')
    // cekValidasi(tradoId, supirId, 'deleteFromAll', id)
    // console.log('test')
    $('.trow').each((index, element) => {
        let idRow = $(element).find(`[name="id[]"]`).val();
        pushToObject(idRow, null, null)
      })

    Promise
      .all([
        deleteFromAll(tradoId, supirId,id)
      ])
      console.log(supirId,id)
  })

  function deleteFromAll(tradoId, supirId,rowId) {
    // $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')
    $.ajax({
      url: `${apiUrl}mandorabsensisupir/${tradoId}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        tanggal: $('#tglshow').val(),
        supir_id: supirId,

      },
      success: response => {

        let msg = `YAKIN HAPUS ABSENSI. `
        let supirtrado = `${response.data.trado}`
        if (response.data.supir) {
          supirtrado += ` - ${response.data.supir}`
        }
        showConfirm(msg, supirtrado)
          .then(function() {
            $('#processingLoader').removeClass('d-none')
            $.ajax({
              url: `${apiUrl}mandorabsensisupir`,
              method: 'POST',
              dataType: 'JSON',
              data: {
                data: JSON.stringify(dataAbsensi),
                deleted_id: rowId
              },
              headers: {
                Authorization: `Bearer ${accessToken}`
              },
              success: response => {
                getAll(1, 0, filterObject,'',rowId)
                //deleted_id
                dataAbsensi = {}

                // deleteStatic(rowId,' ');
              },

              error: error => {
                if (error.status === 422) {
                  $('.is-invalid').removeClass('is-invalid')
                  $('.invalid-feedback').remove()

                  setErrorMessages($("#crudForm"), error.responseJSON.errors);
                } else {
                  showDialog(error.responseJSON)
                }
              },
            }).always(() => {
              $('#processingLoader').addClass('d-none')
            })

          })

      },
      error: error => {
        reject(error)
      }
    }).always(() => {
      $('#processingLoader').addClass('d-none')
    })
    
  }

  function initLookupDetail(index, detailRow, detail) {
    let rowLookup = index;

    $(`.supir-lookup-${rowLookup}`).last().lookup({
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
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
        console.log(element.data('currentValue'));
      },
      onClear: (element) => {
        element.parents('td').find(`[name="supir_id[]"]`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    
    
    $(`.absentrado-lookup-${rowLookup}`).last().lookup({
      title: 'Absen Trado Lookup',
      fileName: 'absentrado',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          trado_id: detail.trado_id,
          supir_id: detail.supir_id,
          supirold_id: detail.supir_id_old,
          tglabsensi: $('#tglbukaabsensi').val(),
          dari: 'mandorabsensisupir',
        }
      },
      onSelectRow: (absentrado, element) => {
        getabsentrado(absentrado.id).then((response) => {
          setSupirEnableIndex(response, index)
        }).catch(() => {
          setSupirEnableIndex(false, index)
        })
        element.parents('td').find(`[name="absen_id[]"]`).val(absentrado.id)
        element.val(absentrado.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.parents('td').find(`[name="absen_id[]"]`).val('')
        element.val('')
        element.data('currentValue', element.val())
        setSupirEnableIndex(false, index)
      }
    })
  }

  function setSupirEnableIndex(kodeabsensitrado, rowId) {
    if (kodeabsensitrado.supir) {
      // console.log(kodeabsensitrado);
      $(`#supir_id_row_${rowId}`).val("");
      $(`.supir-lookup-${rowId}`).last().val("");
    } else {
      let namasupir_old = $(`#supir_old_row_${rowId}`).val();
      let supir_id_old = $(`#supir_old_id_row_${rowId}`).last().val();

      $(`#supir_id_row_${rowId}`).val(supir_id_old);
      $(`.supir-lookup-${rowId}`).last().val(namasupir_old);

    }
  }
</script>
@endpush()
@endsection