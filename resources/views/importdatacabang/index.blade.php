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
                            <label class="col-12 col-sm-4 col-md-2  col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="periode" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-12 col-sm-4 col-md-2  col-form-label mt-2">Cabang<span class="text-danger">*</span></label>

                            <div class="col-12 col-sm-4 col-md-4">
                                <select name="cabang" id="cabang" class="form-select select2bs4" style="width: 100%;">

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-12 col-sm-4 col-md-2  col-form-label mt-2">tipe import<span class="text-danger">*</span></label>

                            <div class="col-12 col-sm-4 col-md-4">
                                <select name="import" id="import" class="form-select select2bs4" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-4 mt-2">
                                <a id="btnProcess" class="btn btn-primary mr-2 ">
                                    <i class="fas fa-sync"></i>
                                    Process
                                </a>
                                <!-- <button id="btnSubmit" class="btn btn-primary ">
                                    <i class="fa fa-save"></i>
                                    Proses
                                </button> -->
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
    

    $(document).ready(function() {

        initSelect2($('#crudForm').find('[name=cabang]'), false)
        initSelect2($('#crudForm').find('[name=import]'), false)
        setCabangOptions($('#crudForm'))
        setStatusImportOptions($('#crudForm'))

        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');

        $('.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                showOn: "button",
                dateFormat: 'mm-yy',
                onClose: function(dateText, inst) {
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                }
            }).siblings(".ui-datepicker-trigger")
            .wrap(
                `
			<div class="input-group-append">
			</div>
		`
            )
            .addClass("btn btn-easyui text-easyui-dark").html(`
			<i class="fa fa-calendar-alt"></i>
		`);



        $('#btnProcess').click(function(event) {
            event.preventDefault()
            
            let method
            let url
            let form = $('#crudForm')
            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm').serializeArray()

            method = 'POST'
            url = `${apiUrl}importdatacabang`

            data.push({
              name: 'info',
              value: info
            })
          

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
                    console.log(response.message);
                    showSuccessDialog(response.message, response.data.nobukti)
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
     
    const setCabangOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
        relatedForm.find('[name=cabang]').empty()
        relatedForm.find('[name=cabang]').append(
            new Option('-- PILIH CABANG --', '', false, true)
        ).trigger('change')

        $.ajax({
            url: `${apiUrl}cabang`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
            Authorization: `Bearer ${accessToken}`
            },
            data:{
                transferCoa: 'YA'  
            },
            success: response => {
            response.data.forEach(cabang => {
                let option = new Option(cabang.namacabang, cabang.id)

                relatedForm.find('[name=cabang]').append(option).trigger('change')
            });

            resolve()
            },
            error: error => {
            reject(error)
            }
        })
        })
    }

    const setStatusImportOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=import]').empty()
            relatedForm.find('[name=import]').append(
                new Option('-- PILIH STATUS IMPORT --', '', false, true)
            ).trigger('change')
            
            let data = [];
            data.push({
                name: 'grp',
                value: 'STATUSIMPORT'
            })
            data.push({
                name: 'subgrp',
                value: 'STATUSIMPORT'
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
                    response.data.forEach(statusApproval => {
                        let option = new Option(statusApproval.text, statusApproval.id)
                        relatedForm.find('[name=import]').append(option).trigger('change')
                    });
                

                    resolve();
                },
                error: error => {
                    reject(error);
                }
            })
        })
    }
                
    
</script>
@endpush()
@endsection