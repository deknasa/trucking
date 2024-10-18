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
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">ID</label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="id" class="form-control" readonly>
                            </div>
                        </div> --}}
                        <input type="text" name="id" class="form-control" hidden>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    TANGGAL<span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tgl" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Keterangan<span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="keterangan" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    STATUS AKTIF <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="statusaktif">
                                <input type="text" name="statusaktifnama" id="statusaktifnama" class="form-control lg-form status-lookup">
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
    let modalBody = $('#crudModal').find('.modal-body').html()

    var data_id 
    let dataMaxLength = []

    $(document).ready(function() {
        $('#btnSubmit').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let hariLiburId = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm').serializeArray()

            data.push({
                name: 'sortIndex',
                value: $('#jqGrid').getGridParam().sortname
            })
            data.push({
                name: 'sortOrder',
                value: $('#jqGrid').getGridParam().sortorder
            })
            data.push({
                name: 'filters',
                value: $('#jqGrid').getGridParam('postData').filters
            })
            data.push({
                name: 'info',
                value: info
            })
            data.push({
                name: 'indexRow',
                value: indexRow
            })
            data.push({
                name: 'page',
                value: page
            })
            data.push({
                name: 'limit',
                value: limit
            })

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}harilibur`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}harilibur/${hariLiburId}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}harilibur/${hariLiburId}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}harilibur`
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
                    id = response.data.id
                    $('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')


                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page
                    }).trigger('reloadGrid');

                    if (response.data.grp == 'FORMAT') {
                        updateFormat(response.data)
                    }
                },
                error: error => {
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

    $('#crudModal').on('shown.bs.modal', () => {
        let form = $('#crudForm')

        setFormBindKeys(form)
        data_id = $('#crudForm').find('[name=id]').val();

        activeGrid = null

        // initSelect2($(`[name="statusaktif"]`), true)
        initDatepicker()
        initLookup()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        removeEditingBy(data_id)
        $('#crudModal').find('.modal-body').html(modalBody)
    })

    function removeEditingBy(id) {
        if (id == "") {
            return ;
        }
        // $.ajax({
        //     url: `{{ config('app.api_url') }}bataledit`,
        //     method: 'POST',
        //     dataType: 'JSON',
        //     headers: {
        //         Authorization: `Bearer ${accessToken}`
        //     },
        //     data: {
        //         id: id,
        //         aksi: 'BATAL',
        //         table: 'harilibur'
                
        //     },
        //     success: response => {
        //         $("#crudModal").modal("hide")
        //     },
        //     error: error => {
        //         if (error.status === 422) {
        //             $('.is-invalid').removeClass('is-invalid')
        //             $('.invalid-feedback').remove()
                    
        //             setErrorMessages(form, error.responseJSON.errors);
        //         } else {
        //             showDialog(error.responseJSON)
        //         }
        //     },
        // })
        let formData = new FormData();

       
        formData.append('id', id);
        formData.append('aksi', 'BATAL');
        formData.append('table', 'harilibur');

        fetch(`{{ config('app.api_url') }}removeedit`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${accessToken}`
            },
            body: formData,
            keepalive:true

        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            $("#crudModal").modal("hide");
        })
        .catch(error => {
            // Handle error
            if (error.status === 422) {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
                setErrorMessages(form, error.responseJSON.errors);
            } else {
                showDialog(error.responseJSON);
            }
        });
    }
    
    function createHariLibur() {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
        `)
        form.data('action', 'add')
        form.find(`.sometimes`).show()
        $('#crudModalTitle').text('Add Hari Libur')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        $('#crudForm').find('[name=tgl]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');


        Promise
            .all([
                // setStatusAktifOptions(form),
        getMaxLength(form)
            ])
            .then(() => {
                showDefault(form)
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

    function editHariLibur(id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')


        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
        `)
        $('#crudModalTitle').text('Edit Hari Libur')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()



        Promise
            .all([
                // setStatusAktifOptions(form),
        getMaxLength(form)

            ])
            .then(() => {
                showHariLibur(form, id)
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

    function deleteHariLibur(id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')


        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-trash"></i>
            Delete
        `)
        $('#crudModalTitle').text('Delete Hari Libur')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                // setStatusAktifOptions(form),
        getMaxLength(form)

            ])
            .then(() => {
                showHariLibur(form, id)
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

    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
            return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}harilibur/field_length`,
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

                    dataMaxLength = response.data
            form.attr('has-maxlength', true)
            resolve()
                },
                error: error => {
                    showDialog(error.statusText)
                    reject()
                }
            })
        })
        } else {
            return new Promise((resolve, reject) => {
        $.each(dataMaxLength, (index, value) => {
          if (value !== null && value !== 0 && value !== undefined) {
            form.find(`[name=${index}]`).attr('maxlength', value)

        
          }
        })
        resolve()
      })
        }
    }

    function initLookup() {
        $(`.status-lookup`).lookupV3({
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
                $('#crudForm [name=statusaktif]').first().val('')
                element.val('');
                element.data('currentValue', element.val());
            },
        });
    }

    const setStatusAktifOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statusaktif]').empty()
            relatedForm.find('[name=statusaktif]').append(
                new Option('-- PILIH STATUS AKTIF --', '', false, true)
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
                            "data": "STATUS AKTIF"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusAktif => {
                        let option = new Option(statusAktif.text, statusAktif.id)

                        relatedForm.find('[name=statusaktif]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function showHariLibur(form, id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}harilibur/${id}`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)

                        if (element.is('select')) {
                            element.val(value).trigger('change')
                        } else if (element.hasClass('datepicker')) {
                            element.val(dateFormat(value))
                        } else {
                            element.val(value)
                        }
                    })
                    console.log(form.data('action'))
                    if (form.data('action') === 'delete') {
                        form.find('[name]').addClass('disabled')
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

    function showDefault(form) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}harilibur/default`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
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
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function cekValidasi(id,aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}harilibur/${id}/cekValidasi`,
            method: 'POST',
            dataType: 'JSON',
            beforeSend: request => {
                request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
            },
            data:{
                aksi: aksi,
            },
            success: response => {
                var error = response.error
                if (error == true) {
                    showDialog(response.message)
                } else {
                    if (aksi=="edit") {
                        editHariLibur(id)
                    }else if (aksi=="delete"){
                        deleteHariLibur(id)
                    }
                }
            }
        })
    }

</script>
@endpush()