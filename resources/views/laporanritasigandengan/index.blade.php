@extends('layouts.master')

@section('content')
<style>
  .ui-datepicker-calendar {
    display: none;
  }
</style>
<!-- Grid -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card card-easyui bordered mb-4">
        <div class="card-header">
        </div>
        <form id="crudForm">
          <div class="card-body">
            <div class="form-group row">
              <div class="col-12 col-sm-2 col-md-2">
                <label class="col-form-label">Periode <span class="text-danger">*</span></label>
              </div>
              <div class="col-sm-4">
                <div class="input-group">
                  <input type="text" name="periode" class="form-control monthpicker">
                </div>
              </div>
            </div>
            <div class="row">

              <div class="col-sm-6 mt-4">
                <button type="button" id="btnExport" class="btn btn-warning mr-1 ">
                  <i class="fas fa-file-export"></i>
                  Export
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  let indexRow = 0;
  let page = 0;
  let pager = '#jqGridPager'
  let popup = "";
  let id = "";
  let triggerClick = true;
  let highlightSearch;
  let totalRecord
  let limit
  let postData
  let sortname = 'nobukti'
  let sortorder = 'asc'
  let autoNumericElements = []
  let rowNum = 10
  let hasDetail = false


  $(document).ready(function() {
    initMonthpicker()
    $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');

    if (!`{{ $myAuth->hasPermission('laporanritasigandengan', 'export') }}`) {
      $('#btnExport').attr('disabled', 'disabled')
    }

  })

  $(document).on('click', `#btnExport`, function(event) {

    let periode = $('#crudForm').find('[name=periode]').val()

    $('#processingLoader').removeClass('d-none')
    $.ajax({
      url: `${apiUrl}laporanritasigandengan/export`,
        // url: `{{ route('laporanritasigandengan.export') }}?periode=${periode}`,
        type: 'GET',
        data : {
          periode : periode
        },
        beforeSend: function(xhr) {
            xhr.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`);
        },
        xhrFields: {
            responseType: 'arraybuffer'
        },
        success: function(response, status, xhr) {
            if (xhr.status === 200) {
                if (response !== undefined) {
                    var blob = new Blob([response], {
                        type: 'cabang/vnd.ms-excel'
                    });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'LAP. RITASI GANDENGAN ' + new Date().getTime() + '.xlsx';
                    link.click();
                }
            }
            
            $('#processingLoader').addClass('d-none')
        },
        error: function(xhr, status, error) {
            $('#processingLoader').addClass('d-none')
            showDialog('TIDAK ADA DATA')
        }
    })    
  })
</script>
@endpush()
@endsection