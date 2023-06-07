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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Bulan<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="bulan" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Tahun<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="sampai" class="form-control datepicker">
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">

                            <div class="col-sm-6 mt-4">
                                <a id="btnPreview" class="btn btn-info mr-1 ">
                                    <i class="fas fa-print"></i>
                                    Report
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
        $('#crudForm').find('[name=bulan]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
        $(".datepicker").datepicker({
    dateFormat: "mm-yy",
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    onClose: function(dateText, inst) {
      $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
    }
  });
//   $('.datepicker').focus(function() {
//     $(".ui-datepicker-calendar").hide();
//     $("#ui-datepicker-div").position({
//       my: "center top",
//       at: "center bottom",
//       of: $(this)
//     });
//   });

  $('.datepicker').on('change', function() {
    var month = $(this).datepicker('getDate').getMonth() + 1;
    var year = $(this).datepicker('getDate').getFullYear();
  });

  $('#crudForm').on('submit', function(e) {
    e.preventDefault();
  bulan = $('[name=bulan]').val();
  
   
  });
  
        // initSelect2($('#crudForm').find('[name=bulan]'), false)
        // initSelect2($('#crudForm').find('[name=sampai]'), false)

        // setStatusApprovalOptions($('#crudForm'))
        // setTabelOptions($('#crudForm'))
        // $('#crudForm').find('[name=bulan]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');

        let css_property =
        {
            "color": "#fff",
            "background-color": "rgb(173 180 187)",
            "cursor" : "not-allowed",
            "border-color": "rgb(173 180 187)"
        }
        if (!`{{ $myAuth->hasPermission('laporanaruskas', 'report') }}`) {
            $('#btnPreview').prop('disabled', true)
            $('#btnPreview').css(css_property);
        }

    })

    $(document).on('click', `#btnPreview`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let bulan = $('#crudForm').find('[name=bulan]').val()

        if (bulan != '' && sampai != '') {

            window.open(`{{ route('laporanaruskas.report') }}?sampai=${sampai}&bulan=${bulan}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })



</script>
@endpush()
@endsection