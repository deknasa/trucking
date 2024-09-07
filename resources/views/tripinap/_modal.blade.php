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
                        <input type="hidden" name="id">



                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">absensi <span class="text-danger">*</span> </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="absensi_id">
                                <input type="text" name="tglabsensi" id="tglabsensi" class="form-control absensisupir-lookup">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Trado <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="trado_id">
                                <input type="hidden" name="supir_id">
                                <input type="text" name="trado" id="trado" class="form-control absensisupirdetail-lookup">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    surat pengantar no bukti <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" id="suratpengantar_nobukti" name="suratpengantar_nobukti" id="suratpengantar_nobukti" class="form-control suratpengantar-lookup">
                            </div>
                        </div>


                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Tanggal & Jam Masuk <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="datetime-local" class="form-control inputmask-time" name="jammasukinap">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Tanggal & Jam keluar <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="datetime-local" class="form-control inputmask-time" name="jamkeluarinap">
                            </div>
                        </div>



                    </div>
                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Save
                        </button>
                        <button id="btnSaveAdd" class="btn btn-success">
                            <i class="fas fa-file-upload"></i>
                            Save & Add
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
    let isEditTgl
    let absensiId = ''

    $(document).ready(function() {

        $('#btnSubmit').click(function(event) {
            event.preventDefault()
            submit($(this).attr('id'))
        })
        $('#btnSaveAdd').click(function(event) {
            event.preventDefault()
            submit($(this).attr('id'))
        })

        function submit(button) {

            let method
            let url
            let form = $('#crudForm')
            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm').serializeArray()

            data.push({
                name: 'button',
                value: button
            })
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

            let tgldariheader = $('#tgldariheader').val();
            let tglsampaiheader = $('#tglsampaiheader').val()

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}tripinap`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}tripinap/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}tripinap/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}tripinap`
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
                    if (button == 'btnSubmit') {
                        id = response.data.id

                        $('#crudModal').find('#crudForm').trigger('reset')
                        $('#crudModal').modal('hide')

                        $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
                        $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');
                        $('#jqGrid').jqGrid('setGridParam', {
                            page: response.data.page,
                            postData: {
                                tgldari: dateFormat(response.data.tgldariheader),
                                tglsampai: dateFormat(response.data.tglsampaiheader)
                            }
                        }).trigger('reloadGrid');

                        if (id == 0) {
                            $('#detail').jqGrid().trigger('reloadGrid')
                        }
                        if (response.data.grp == 'FORMAT') {
                            updateFormat(response.data)
                        }
                    } else {

                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        // showSuccessDialog(response.message)
                        createTripInap()
                        $('#crudForm').find('input[type="text"]').data('current-value', '')

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
        }
    })

    $('#crudModal').on('shown.bs.modal', () => {
        let form = $('#crudForm')

        setFormBindKeys(form)

        activeGrid = null

        if (form.data('action') == 'add') {
            form.find('#btnSaveAdd').show()
        } else {
            form.find('#btnSaveAdd').hide()
        }
        form.find('#btnSubmit').prop('disabled', false)
        if (form.data('action') == "view") {
            form.find('#btnSubmit').prop('disabled', true)
        }
        initSelect2(form.find('.select2bs4'), true)
        Inputmask("datetime", {
            inputFormat: "HH:MM",
            max: 24
        }).mask(".inputmask-time");

        initLookup()
        initDatepicker()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'

        $('#crudModal').find('.modal-body').html(modalBody)
    })

    function createTripInap() {
        let form = $('#crudForm')

        $('#crudModal').find('#crudForm').trigger('reset')
        form.find('#btnSubmit').html(`
        <i class="fa fa-save"></i>
        Save
        `)
        form.data('action', 'add')
        $('#crudModalTitle').text('Add Trip Inap')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusAktifOptions(form),
            ])
            .then(() => {
                if (selectedRows.length > 0) {
                    clearSelectedRows()
                }
                $('#crudModal').modal('show')
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })

    }

    function editTripInap(id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
        `)
        $('#crudModalTitle').text('Edit Trip Inap')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showTripInap(form, id)
            ])
            .then(() => {
                if (selectedRows.length > 0) {
                    clearSelectedRows()
                }
                $('#crudModal').modal('show')
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })

    }

    function deleteTripInap(id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-trash"></i>
            Delete
        `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Delete Trip Inap')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showTripInap(form, id)
            ])
            .then(() => {
                if (selectedRows.length > 0) {
                    clearSelectedRows()
                }
                $('#crudModal').modal('show')
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })

    }

    function viewTripInap(id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'view')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
          <i class="fa fa-save"></i>
          Save
        `)
        form.find('#btnSubmit').prop('disabled', true)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('View Trip Inap')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showTripInap(form, id)
            ])
            .then(id => {
                setFormBindKeys(form)
                form.find('[name]').removeAttr('disabled')

                form.find('select').each((index, select) => {
                    let element = $(select)

                    if (element.data('select2')) {
                        element.select2('destroy')
                    }
                })
                form.find('[name]').attr('disabled', 'disabled').css({
                    background: '#fff'
                })
                form.find('[name=id]').prop('disabled', false);
            })
            .then(() => {
                if (selectedRows.length > 0) {
                    clearSelectedRows()
                }
                $('#crudModal').modal('show')
                form.find(`.hasDatepicker`).prop('readonly', true)
                form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
                let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
                let nameFind = $('#crudForm').find(`[name]`).parents('.input-group')
                name.attr('disabled', true)
                name.find('.lookup-toggler').remove()
                nameFind.find('button.button-clear').remove()
                $('.tbl_aksi').hide()
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })

    }

    function showTripInap(form, id) {
        return new Promise((resolve, reject) => {
            $('#detailList tbody').html('')

            $.ajax({
                url: `${apiUrl}tripinap/${id}`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)

                        if (element.is('select')) {
                            console.log(index, value);
                            element.val(value).trigger('change')
                        } else if (element.hasClass('datepicker')) {
                            element.val(dateFormat(value))
                        } else {
                            element.val(value)
                        }

                        if (index == 'reminderemail') {
                            element.data('current-value', value)
                        }

                    })

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

    function cekValidasi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}tripinap/${Id}/cekValidasi`,
            method: 'POST',
            data: {
                aksi: Aksi
            },
            dataType: 'JSON',
            beforeSend: request => {
                request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
            },
            success: response => {
                var error = response.error
                if (error == true) {
                    showDialog(response)
                } else {
                    if (Aksi == 'EDIT') {
                        editTripInap(Id)
                    }
                    if (Aksi == 'DELETE') {
                        deleteTripInap(Id)
                    }
                }
            }
        })
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




    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
            $.ajax({
                url: `${apiUrl}tripinap/field_length`,
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
                    showDialog(error.responseJSON)
                }
            })
        }
    }

    function initLookup() {

        $('.absensisupir-lookup').lookup({
            title: 'Absensi Supir',
            fileName: 'absensisupir',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    from: 'tripinap',
                }
            },
            onSelectRow: (absensisupir, element) => {
                absensiId = absensisupir.id

                $('#crudForm [name=absensi_id]').first().val(absensisupir.id)
                element.val(absensisupir.tglbukti)
                element.data('currentValue', element.val())
                $('#crudForm [name=trado_id]').val('')
                $('#crudForm [name=supir_id]').val('')
                $('#crudForm [name=trado]').val('')
                $('#crudForm [name=trado]').data('currentValue', '')
                $('#crudForm [name=suratpengantar_nobukti]').val('')
                $('#crudForm [name=suratpengantar_nobukti]').data('currentValue', '')

            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=absensi_id]').first().val('')
                absensiId = ''
                element.val('')
                element.data('currentValue', element.val())
                $('#crudForm [name=trado_id]').val('')
                $('#crudForm [name=supir_id]').val('')
                $('#crudForm [name=trado]').val('')
                $('#crudForm [name=trado]').data('currentValue', '')
                $('#crudForm [name=suratpengantar_nobukti]').val('')
                $('#crudForm [name=suratpengantar_nobukti]').data('currentValue', '')
            }
        })

        $('.trado-lookup').lookupMaster({
            title: 'trado Lookup',
            fileName: 'tradoMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'trado_id',
                    searchText: 'trado-lookup',
                    title: 'TRADO',
                    typeSearch: 'ALL',
                    absensiId: absensiId
                }
            },
            onSelectRow: (trado, element) => {
                $('#crudForm [name=trado_id]').first().val(trado.id)
                $('#crudForm [name=supir_id]').val(trado.supirid)
                console.log(trado.supir_id, trado.supirid)
                element.val(trado.kodetrado)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=trado_id]').first().val('')
                $('#crudForm [name=supir_id]').val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.supir-lookup').lookupMaster({
            title: 'supir Lookup',
            fileName: 'supirMaster',
            typeSearch: 'ALL',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'supir_id',
                    searchText: 'supir-lookup',
                    title: 'supir',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (supir, element) => {
                $('#crudForm [name=supir_id]').first().val(supir.id)
                element.val(supir.namasupir)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=supir_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.suratpengantar-lookup').lookupV3({
            title: 'Surat Pengantar Lookup',
            fileName: 'suratpengantartripinap',
           // searching: ['tradosupir'],
           labelColumn: false,
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {
                    tglabsensi: $('#crudForm [name=tglabsensi]').first().val(),
                    trado_id: $('#crudForm [name=trado_id]').first().val(),
                    supir_id: $('#crudForm [name=supir_id]').first().val(),
                    from: 'tripinap',
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'suratpengantar_nobukti',
                    searchText: 'suratpengantar-lookup',
                    title: 'Surat Pengantar',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (suratpengantar, element) => {
                element.val(suratpengantar.nobukti)

                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                element.data('currentValue', element.val())

            }
        })

        // $('.suratpengantar-lookup').lookupMaster({
        //     title: 'surat pengantar Lookup',
        //     fileName: 'suratpengantartripinapMaster',
        //     typeSearch: 'ALL',
        //     searching: 1,
        //     beforeProcess: function(test) {
        //         this.postData = {
        //             Aktif: 'AKTIF',
        //             searching: 1,
        //             valueName: 'suratpengantar_nobukti',
        //             searchText: 'suratpengantar-lookup',
        //             title: 'surat pengantar',
        //             typeSearch: 'ALL',
        //             from: 'tripinap',
        //             tglabsensi: $('#crudForm [name=tglabsensi]').first().val(),
        //             trado_id: $('#crudForm [name=trado_id]').first().val(),
        //             supir_id: $('#crudForm [name=supir_id]').first().val(),
        //         }
        //     },
        //     onSelectRow: (suratpengantar, element) => {
        //         element.val(suratpengantar.nobukti)
        //         element.data('currentValue', element.val())
        //     },
        //     onCancel: (element) => {
        //         element.val(element.data('currentValue'))
        //     },
        //     onClear: (element) => {
        //         element.val('')
        //         element.data('currentValue', element.val())
        //     }
        // })

        $('.absensisupirdetail-lookup').lookupV3({
            title: 'Trado Lookup',
            fileName: 'absensisupirdetailV3',
            // searching: ['tradosupir'],
            labelColumn: false,
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();

                this.postData = {
                    Aktif: 'AKTIF',
                    tgltrip: $('#crudForm [name=tglabsensi]').val(),
                    absensi_id: absensiId,
                    from: 'tripinap',
                    tripinap_id: $('#crudForm [name=id]').val(),
                    aksi: $('#crudForm').data('action')
                }
            },
            onSelectRow: (absensi, element) => {
                $('#crudForm [name=trado_id]').first().val(absensi.trado_id)
                $('#crudForm [name=supir_id]').first().val(absensi.supir_id)
                element.val(absensi.tradosupir)
                element.data('currentValue', element.val())
                $('#crudForm [name=suratpengantar_nobukti]').val('')
                $('#crudForm [name=suratpengantar_nobukti]').data('currentValue', '')
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=trado_id]').first().val('')
                $('#crudForm [name=supir_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
                $('#crudForm [name=suratpengantar_nobukti]').val('')
                $('#crudForm [name=suratpengantar_nobukti]').data('currentValue', '')
            }
        })


        // $('.absensisupirdetail-lookup').lookup({
        //     title: 'Trado Lookup',
        //     fileName: 'absensisupirdetail',
        //     beforeProcess: function(test) {
        //         // var levelcoa = $(`#levelcoa`).val();
        //         this.postData = {
        //             tgltrip: $('#crudForm [name=tglabsensi]').val(),
        //             Aktif: 'AKTIF',
        //             absensi_id: absensiId,
        //             from: 'tripinap',
        //             aksi: $('#crudForm').data('action'),
        //         }
        //     },
        //     onSelectRow: (absensi, element) => {
        //         console.log(absensi);
        //         $('#crudForm [name=trado_id]').first().val(absensi.trado_id)
        //         $('#crudForm [name=supir_id]').first().val(absensi.supir_id)
        //         element.val(absensi.tradosupir)
        //         element.data('currentValue', element.val())
        //         getInfoTrado(tradoId)
        //     },
        //     onCancel: (element) => {
        //         element.val(element.data('currentValue'))
        //     },
        //     onClear: (element) => {
        //         tradoId = 0
        //         $('#crudForm [name=trado_id]').first().val('')
        //         $('#crudForm [name=supir_id]').first().val('')
        //         element.val('')
        //         element.data('currentValue', element.val())
        //     }
        // })
    }
</script>
@endpush()