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
                        {{-- <div class="row form-group">
                        <div class="col-12 col-sm-3 col-md-2" style="display:none">
                        
                        </div>
                        <div class="col-12 col-sm-9 col-md-10">
                            <input type="hidden" name="id" class="form-control" readonly>
                        </div>
                        </div> --}}
                        <input type="text" name="id" class="form-control" hidden>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-3">
                                <label class="col-form-label">
                                Nama Penjual <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-9">
                                <input type="text" name="namapenjual" class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-3">
                                <label class="col-form-label">
                                Alamat <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-9">
                                <input type="text" name="alamat" class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-3">
                                <label class="col-form-label">
                                NO HANDPHONE <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-9">
                                <input type="text" name="nohp" class="form-control numbernoseparate">
                            </div>
                        </div>

                        <!-- <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-3">
                                <label class="col-form-label">
                                KETERANGAN COA <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-8 col-md-9">
                                <div class="input-group">
                                    <input type="hidden" name="coa">
                                    <input type="text" id="ketcoa" name="ketcoa" class="form-control akunpusat-lookup">
                                    <select name="coa" id="coa" class="form-control lg-form"></select>
                                </div>
                            </div>
                        </div> -->

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-3">
                                <label class="col-form-label">
                                KETERANGAN COA <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-9">
                                <!-- <input type="hidden" name="statusaktif">
                                <input type="text" name="statusaktifnama" id="statusaktifnama" class="form-control lg-form statusaktif-lookup"> -->
                                <select name="coa" id="coa" class="form-control lg-form"></select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-3">
                                <label class="col-form-label">
                                STATUS AKTIF <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-9">
                                <input type="hidden" name="statusaktif">
                                <input type="text" name="statusaktifnama" id="statusaktifnama" class="form-control lg-form statusaktif-lookup">
                                <!-- <select name="statusaktif" id="statusaktif" class="form-control lg-form"></select> -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmit" class="btn btn-primary">
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
    let modalBody = $('#crudForm').find('.modal-body').html()
    var data_id

    $(document).ready(function() {
        $('#btnSubmit').click(function(event){
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let penjualId = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm').serializeArray()
            // console.log(penjualId)
            // console.log(action)
            
            
            data.push(
                { name: 'sortIndex', value: $('#jqGrid').getGridParam().sortname },
                { name: 'sortOrder', value: $('#jqGrid').getGridParam().sortorder },
                { name: 'filters', value: $('#jqGrid').getGridParam().filters },
                // { name: 'info', value: info },
                // { name: 'accessTokenTnl', value: accessTokenTnl },
                { name: 'indexRow', value: indexRow },
                { name: 'page', value: page },
                { name: 'limit', value: limit }
            )

            switch (action) {
                case 'add':
                    method = "POST",
                    url = `${apiUrl}penjual`
                    break;
                case 'edit':
                    method = "PATCH",
                    url = `${apiUrl}penjual/${penjualId}`
                    break;
                case 'delete':
                    method = "DELETE",
                    url = `${apiUrl}penjual/${penjualId}`
                    break;
                default:
                    method = "POST",
                    url = `${apiUrl}penjual`
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
                    // console.log(response.data);
                    
                    $('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')
                    $("#statusaktif").html('<option value = "" selected ></option>')
                    $("#coa").html('<option value = "" selected ></option>')

                    id = response.data.id

                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page
                    }).trigger('reloadGrid')
                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        setErrorMessages(form, error.responseJSON.errors);
                    } else {
                        showDialog(error.responseJSON)
                    }
                }
            }).always(() => {
                $('#processingLoader').addClass('d-none')
                $(this).removeAttr('disabled')
            })
        })
    })

    $('#crudModal').on('shown.bs.modal', () => {
        let form = $('#crudForm')
        
        setFormBindKeys(form)

        activeGrid = null
        form.find('#btnSubmit').prop('disabled', false)
        // if (form.data('action') == "view") {
        //     form.find('#btnSubmit').prop('disabled', true)
        // }

        initLookup()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'

        $('#crudModal').find('.modal-body').html(modalBody)
    })

    function createPenjual() {
        let form = $('#crudForm')
        let statusAktifId = $('#statusaktif')
        let coaId = $('#coa')

        $('.modal-loader').removeClass('d-none')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
        `)
        form.data('action', 'add')
        
        form.find(`.sometimes`).show()
        $('#crudModalTitle').text('Add Penjual')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
        .all([
            statusAktifSelect2(statusAktifId, form),
            coaSelect2(coaId, form)
        ])
        .then(() => {
            // .then(() => {
                $('#crudModal').modal('show')
            // })
            // .catch((error) => {
                // showDialog(error.statusText)
            // })
            // .finally(() => {
                $('.modal-loader').addClass('d-none')
            // })
        })
    }

    function editPenjual(penjualId){
        let form = $("#crudForm")
        let statusAktifId = $('#statusaktif')
        let coaId = $('#coa')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'edit')
        form.trigger('reset')
        // console.log(a);
        
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
        `)
        form.find(`.sometimes`).show()

        $('#crudModalTitle').text('Edit Penjual')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
        .all([
            statusAktifSelect2(statusAktifId, form),
            coaSelect2(coaId, form)
        ])
        .then(() => {
            showPenjual(form, penjualId)
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
    }

    function deletePenjual(penjualId) {
        let form = $('#crudForm')
        let statusAktifId = $('#statusaktif')
        let coaId = $('#coa')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-trash"></i>
            Delete
        `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Delete Penjual')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
        .all([
            statusAktifSelect2(statusAktifId, form),
            coaSelect2(coaId, form)
        ])
        .then(() => {
            showPenjual(form, penjualId)
            .then(() => {
                $('#crudModal').modal('show')
                $('#crudForm').find(`.btn.btn-easyui.lookup-toggler`).attr('disabled', true)

            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
        })
    }

    function showPenjual(form, penjualId) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}penjual/${penjualId}`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    // console.log(response.data.statusaktifText);
                    
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)
                        
                        if (index == 'coa') {
                            if (element.is('select')) {
                                $("#coa").html(`<option value=${value} selected>${response.data.coaText}</option>`)
                            }
                        } else if (index == 'statusaktif') {
                            if (element.is('select')) {
                                console.log(value);
                                $("#statusaktif").html(`<option value=${value} selected>${response.data.statusaktifText}</option>`)
                            }
                        } else {
                            element.val(value)
                        }

                        if (index == 'statusaktifText') {
                            element.data('current-value', value)
                        }
                    })
                    console.log(form.data('action'));
                    
                    
                    if (form.data('action') === 'delete') {
                        form.find('[name]').addClass('disabled')
                        form.find('select[name=coa]').attr('disabled', true)
                        form.find('select[name=statusaktif]').attr('disabled', true)
                        // form.find('select[name=coa]').addClass('disabled')
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

    function statusAktifSelect2(statusAktifId, form){
        $(statusAktifId).select2({
            placeholder: "--STATUS AKTIF--",
            allowClear: true,
            dropdownParent: $(form),
            ajax: {
                url: `${apiUrl}penjual/select2StatusAktif`,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term }
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            console.log(item);
                            
                            return {
                                id: item.id,
                                text: item.text
                            };
                        })
                    };
                },
                cache: true
            },
        })
    }

    function coaSelect2(coaId, form){
        $(coaId).select2({
            placeholder: '-- KETERANGAN COA --',
            allowClear: true,
            dropdownParent: form,
            ajax: {
                url: `${apiUrl}penjual/select2Coa`,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term }
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.coa,
                                text: item.keterangancoa
                            };
                        })
                    };
                },
                cache: true
            },
        })
    }

    function initLookup(){
        $(`.statusaktif-lookup`).lookupV3({
            title: 'Status Aktif Lookup',
            fileName: 'parameterV3',
            searching: ['text'],
            labelColumn: false,
            beforeProcess: function() {
                this.postData = {
                    url: `${apiUrl}parameter/combo`,
                    grp: 'STATUS AKTIF',
                    subgrp: 'STATUS AKTIF',
                };
            },
            onSelectRow: (status, element) => {
                $('#crudForm [name=statusaktif]').first().val(status.id)
                element.val(status.text)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let status_id_input = element.parents('td').find(`[name="statusaktif"]`).first();
                status_id_input.val('');
                element.val('');
                element.data('currentValue', element.val());
            },
        })
    }

</script>

@endpush()