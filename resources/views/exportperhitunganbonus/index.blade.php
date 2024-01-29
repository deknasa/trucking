@extends('layouts.master')

@section('content')
<style>
    .ui-datepicker-calendar {
        display: none;
    }
    .ui-datepicker-month{
        display: none;
    }
    .ui-datepicker-next{
        display: none;
    }
    .ui-datepicker-prev{
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
                        <div class="row">
                            
                            <div class="form-group col-6">
                                <div class="row">
                                    <label class="col-4 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                                    <div class="col-8 mt-2">
                                        <select name="periode" id="periode" class="form-select select2" style="width: 100%;">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-6">
                                <div class="row">
                                    <label class="col-3 col-form-label mt-2">Tahun<span class="text-danger">*</span></label>
                                    <div class="col-8 mt-2">
                                        <div class="input-group">
                                            <input type="text" id="tahun" name="tahun" class="form-control datepicker">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-6">
                                <div class="row">
                                    <label class="col-4 col-form-label mt-2">Cabang<span class="text-danger">*</span></label>
    
                                    <div class="col-8 mt-2">
                                        <input type="hidden" name="cabang_id">
                                        <input type="text" name="cabang" class="form-control cabang-lookup">
                                    </div>
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
        initLookup()
        initSelect2($(`#periode`), false)

        $('#tahun').val($.datepicker.formatDate('yy', new Date())).trigger(
            'change');

        $('#tahun').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            showOn: "button",
            dateFormat: 'yy',
            onClose: function(dateText, inst) {
                $(this).datepicker('setDate', new Date(inst.selectedYear, 0));
            }
        })
        .siblings(".ui-datepicker-trigger")
        .wrap(
            `
			<div class="input-group-append">
            </div>
            `
        )
        .addClass("btn btn-easyui text-easyui-dark").html(`
            <i class="fa fa-calendar-alt"></i>
		`);
        


        if (!`{{ $myAuth->hasPermission('exportperhitunganbonus', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('exportperhitunganbonus', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
    })

    $(document).on('click', `#btnExport`, function(event) {
        $('#processingLoader').removeClass('d-none')

        let periode = $('#crudForm').find('[name=periode]').val()
        let tahun = $('#crudForm').find('[name=tahun]').val()
        let cabang_id = $('#crudForm').find('[name=cabang_id]').val()

        if (periode != '' && tahun != '' && cabang_id != '') {

            $.ajax({
                url: `{{ route('exportperhitunganbonus.export') }}`,
                type: 'GET',
                data: {
                    periode :periode,
                    tahun :tahun,
                    cabang_id :cabang_id 
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
                            link.download = `PerHitungan Bonus ${new Date().getTime()}.xlsx`;
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
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    function getCekReport() {

        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}exportperhitunganbonus/report`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    stok: $('#crudForm').find('[name=stok]').val(),
                    stok_id: $('#crudForm').find('[name=stok_id]').val(),
                    isCheck: true,
                },
                success: (response) => {
                    resolve(response);
                },
                error: error => {
                    reject(error)

                },
            });
        });
    }

    function initLookup() {

        $('.cabang-lookup').lookup({
            title: 'Kd. Perkiraan Lookup',
            fileName: 'cabang',
            beforeProcess: function(test) {
                this.postData = {
                    levelcabang: '3',
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (cabang, element) => {
                $('#crudForm [name=cabang_id]').first().val(cabang.id)
                element.val(cabang.namacabang)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=cabang_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
       
    }
</script>
@endpush()
@endsection