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
                        <div class="master">
                            <input type="hidden" name="id">

                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        NO BUKTI <span class="text-danger"></span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <input type="text" name="nobukti" class="form-control" readonly>
                                </div>

                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        TGL BUKTI <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="input-group">
                                        <input type="text" name="tglbukti" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        KAS/BANK DARI <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="hidden" name="bankdari_id">
                                    <input type="text" name="bankdari" id="bankdari" class="form-control bankdari-lookup">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        KAS/BANK KE <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="hidden" name="bankke_id">
                                    <input type="text" name="bankke" id="bankke" class="form-control bankke-lookup">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        ALAT BAYAR <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="hidden" name="alatbayar_id">
                                    <input type="text" name="alatbayar" id="alatbayar" class="form-control alatbayar-lookup">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        NO WARKAT
                                    </label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="text" name="nowarkat" class="form-control">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        TGL JATUH TEMPO <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <div class="input-group">
                                        <input type="text" name="tgljatuhtempo" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        NOMINAL <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-10" id="contNominal">
                                    <input type="text" name="nominal" class="form-control text-right">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        KETERANGAN <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="text" name="keterangan" class="form-control">
                                </div>
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
    let bankDariId
    let bankKeId
    let bankId

    $(document).ready(function() {

        $("#crudForm [name]").attr("autocomplete", "off");


        $(document).on('change', `#crudForm [name="tglbukti"]`, function() {
            $('#crudForm').find(`[name="tgljatuhtempo"]`).val($(this).val()).trigger('change');
        });

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

            $('#crudForm').find(`[name="nominal"]`).each((index, element) => {
                data.filter((row) => row.name === 'nominal')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal"]`)[index])
            })

            data.push({
                name: 'button',
                value: button
            })
            data.push({
                name: 'tgldariheader',
                value: $('#tgldariheader').val()
            })
            data.push({
                name: 'tglsampaiheader',
                value: $('#tglsampaiheader').val()
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

            data.push({
                name: 'aksi',
                value: action.toUpperCase()
            })
            let tgldariheader = $('#tgldariheader').val();
            let tglsampaiheader = $('#tglsampaiheader').val()

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}pindahbuku`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}pindahbuku/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}pindahbuku/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}pindahbuku`
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
                    } else {

                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        createPindahBuku()
                        $('#crudForm').find('input[type="text"]').data('current-value', '')
                        showSuccessDialog(response.message, response.data.nobukti)
                        $('#crudForm').find('[name=tglbukti]').val(dateFormat(response.data.tglbukti)).trigger('change');
                        let nominalEl = `<input type="text" name="nominal" class="form-control text-right">`
                        $('#crudForm').find(`[name="nominal"]`).remove()
                        $('#contNominal').append(nominalEl)
                        new AutoNumeric(`#crudForm [name="nominal"]`)

                    }
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
        }
    });

    $('#crudModal').on('shown.bs.modal', () => {
        let form = $('#crudForm')

        setFormBindKeys(form)

        if (form.data('action') == 'add') {
            form.find('#btnSaveAdd').show()
        } else {
            form.find('#btnSaveAdd').hide()
        }
        form.find('#btnSubmit').prop('disabled', false)
        if (form.data('action') == "view") {
            form.find('#btnSubmit').prop('disabled', true)
        }
        activeGrid = null

        initLookup()
        initDatepicker()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        removeEditingBy($('#crudForm').find('[name=id]').val())
        $('#crudModal').find('.modal-body').html(modalBody)

        bankDariId = ''
        bankKeId = ''
        bankId = ''
    })

    function removeEditingBy(id) {
        if (id == "") {
            return ;
        }
        let formData = new FormData();


        formData.append('id', id);
        formData.append('aksi', 'BATAL');
        formData.append('table', 'pindahbuku');

        fetch(`{{ config('app.api_url') }}removeedit`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                },
                body: formData,
                keepalive: true

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
            })
    }

    $(document).on('change', `#crudForm [name="tglbukti"]`, function() {
        if ($(`#crudForm [name="alatbayar"]`).val() != 'GIRO') {
            $('#crudForm').find(`[name="tgljatuhtempo"]`).val($(this).val()).trigger('change');
        }
    });


    function createPindahBuku() {
        let form = $('#crudForm')

        $('#crudModal').find('#crudForm').trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
        form.data('action', 'add')
        // form.find(`.sometimes`).show()
        $('#crudModalTitle').text('Add Pindah Buku')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        $('#table_body').html('')
        $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        initAutoNumeric($('#crudForm').find('[name=nominal]'))
        Promise
            .all([
                showDefault(form)
            ])
            .then(() => {
                if (selectedRows.length > 0) {
                    clearSelectedRows()
                }

                enableTglJatuhTempo(form)
                enableNoWarkat(form)
                $('#crudModal').modal('show')
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function editPindahBuku(pindahId) {
        let form = $('#crudForm')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
        `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Edit Pindah Buku')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        Promise
            .all([
                showPindahBuku(form, pindahId)
            ])
            .then(() => {
                if (selectedRows.length > 0) {
                    clearSelectedRows()
                }
                enableTglJatuhTempo(form)
                enableNoWarkat(form)
                $('#crudModal').modal('show')
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }


    function deletePindahBuku(pindahId) {
        let form = $('#crudForm')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-trash"></i>
            Delete
        `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Delete Pindah Buku')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showPindahBuku(form, pindahId)
            ])
            .then(() => {
                if (selectedRows.length > 0) {
                    clearSelectedRows()
                }
                enableTglJatuhTempo(form)
                enableNoWarkat(form)
                $('#crudModal').modal('show')
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }


    function viewPindahBuku(pindahId) {

        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')
        form.data('action', 'view')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
        <i class="fa fa-save"></i>
        Save
        `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('View Pindah Buku')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()


        Promise
            .all([
                showPindahBuku(form, pindahId)
            ])
            .then(id => {
                // form.find('.aksi').hide()
                setFormBindKeys(form)
                initSelect2(form.find('.select2bs4'), true)
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
                form.find('[name=id]').prop('disabled', false)
            })
            .then(() => {
                if (selectedRows.length > 0) {
                    clearSelectedRows()
                }
                enableTglJatuhTempo(form)
                enableNoWarkat(form)
                $('#crudModal').modal('show')
                form.find(`.hasDatepicker`).prop('readonly', true)
                form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
                let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
                let nameFind = $('#crudForm').find(`[name]`).parents('.input-group')
                name.attr('disabled', true)
                name.find('.lookup-toggler').remove()
                nameFind.find('button.button-clear').remove()
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function showPindahBuku(form, pindahId) {
        return new Promise((resolve, reject) => {

            $.ajax({
                url: `${apiUrl}pindahbuku/${pindahId}`,
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
                        } else {
                            element.val(value)
                        }

                    })

                    bankDariId = response.data.bankdari_id
                    bankId = response.data.bankdari_id
                    bankKeId = response.data.bankke_id
                    form.find(`[name="tglbukti"]`).val(dateFormat(response.data.tglbukti))
                    form.find(`[name="tgljatuhtempo"]`).val(dateFormat(response.data.tgljatuhtempo))

                    form.find(`[name="alatbayar"]`).data('currentValue', response.data.alatbayar)
                    form.find(`[name="bankdari"]`).data('currentValue', response.data.bankdari)
                    form.find(`[name="bankke"]`).data('currentValue', response.data.bankke)
                    initAutoNumeric(form.find(`[name="nominal"]`))
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
                url: `${apiUrl}pindahbuku/default`,
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
                        } else {
                            element.val(value)
                        }
                        if (index == 'alatbayar') {
                            element.data('current-value', value)
                        }
                        if (index == 'bankdari') {
                            element.data('current-value', value)
                        }
                    })
                    resolve()
                    bankId = response.data.bankdari_id
                    bankDariId = response.data.bankdari_id
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function initLookup() {

        // $('.bankdari-lookup').lookup({
        //     title: 'Bank Dari Lookup',
        //     fileName: 'bank',
        //     beforeProcess: function(test) {
        //         this.postData = {
        //             bankExclude: bankKeId,
        //             Aktif: 'AKTIF',
        //         }
        //     },
        //     onSelectRow: (bank, element) => {
        //         bankDariId = bank.id
        //         bankId = bank.id
        //         $('#crudForm [name=bankdari_id]').first().val(bank.id)
        //         element.val(bank.namabank)
        //         element.data('currentValue', element.val())
        //         $('#crudForm [name=alatbayar_id]').first().val('')
        //         $('#crudForm [name=alatbayar]').first().val('')
        //         $('#crudForm [name=alatbayar]').data('currentValue', '')
        //     },
        //     onCancel: (element) => {
        //         element.val(element.data('currentValue'))
        //     },
        //     onClear: (element) => {
        //         $('#crudForm [name=bankdari_id]').first().val('')
        //         element.val('')
        //         element.data('currentValue', element.val())
        //         bankDariId = ''
        //         $('#crudForm [name=alatbayar_id]').first().val('')
        //         $('#crudForm [name=alatbayar]').first().val('')
        //         $('#crudForm [name=alatbayar]').data('currentValue', '')
        //     }
        // })

        $('.bankdari-lookup').lookupV3({
            title: 'Bank dari Lookup',
            fileName: 'bankV3',
            searching: ['namabank'],
            labelColumn: false,
            // filterToolbar:true,
            beforeProcess: function(test) {
                this.postData = {
                    bankExclude: bankKeId,
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (bank, element) => {
                bankDariId = bank.id
                bankId = bank.id
                $('#crudForm [name=bankdari_id]').first().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
                $('#crudForm [name=alatbayar_id]').first().val('')
                $('#crudForm [name=alatbayar]').first().val('')
                $('#crudForm [name=alatbayar]').data('currentValue', '')
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=bankdari_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
                bankDariId = ''
                $('#crudForm [name=alatbayar_id]').first().val('')
                $('#crudForm [name=alatbayar]').first().val('')
                $('#crudForm [name=alatbayar]').data('currentValue', '')
            }
        })

        // $('.bankke-lookup').lookup({
        //     title: 'Bank Sampai Lookup',
        //     fileName: 'bank',
        //     beforeProcess: function(test) {
        //         this.postData = {
        //             bankExclude: bankDariId,
        //             Aktif: 'AKTIF',
        //         }
        //     },
        //     onSelectRow: (bank, element) => {

        //         bankKeId = bank.id
        //         $('#crudForm [name=bankke_id]').first().val(bank.id)
        //         element.val(bank.namabank)
        //         element.data('currentValue', element.val())
        //     },
        //     onCancel: (element) => {
        //         element.val(element.data('currentValue'))
        //     },
        //     onClear: (element) => {
        //         $('#crudForm [name=bankke_id]').first().val('')
        //         element.val('')
        //         element.data('currentValue', element.val())
        //         bankKeId = ''
        //     }
        // })

        $('.bankke-lookup').lookupV3({
            title: 'Bank dari Lookup',
            fileName: 'bankV3',
            searching: ['namabank'],
            labelColumn: false,
            // filterToolbar:true,
            beforeProcess: function(test) {
                this.postData = {
                    bankExclude: bankDariId,
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (bank, element) => {
                bankKeId = bank.id
                $('#crudForm [name=bankke_id]').first().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=bankke_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
                bankKeId = ''
            }
        })

        // $('.alatbayar-lookup').lookup({
        //     title: 'Alat Bayar Lookup',
        //     fileName: 'alatbayar',
        //     beforeProcess: function(test) {
        //         this.postData = {
        //             bank_Id: bankId,
        //             Aktif: 'AKTIF',
        //             from: 'pindahbuku'
        //         }
        //     },
        //     onSelectRow: (alatbayar, element) => {
        //         $('#crudForm [name=alatbayar_id]').first().val(alatbayar.id)
        //         element.val(alatbayar.namaalatbayar)
        //         element.data('currentValue', element.val())
        //         enableTglJatuhTempo($(`#crudForm`))
        //         enableNoWarkat($(`#crudForm`))
        //     },
        //     onCancel: (element) => {
        //         element.val(element.data('currentValue'))
        //     },
        //     onClear: (element) => {
        //         $('#crudForm [name=alatbayar_id]').first().val('')
        //         element.val('')
        //         element.data('currentValue', element.val())
        //     }
        // })

        $('.alatbayar-lookup').lookupV3({
            title: 'Alat Bayar Lookup',
            fileName: 'alatbayarV3',
            searching: ['namaalatbayar'],
            labelColumn: false,
            beforeProcess: function(test) {
                // const bank_ID=0        
                this.postData = {
                    bank_Id: bankId,
                    Aktif: 'AKTIF',
                    from: 'pindahbuku'
                }
            },
            onSelectRow: (alatbayar, element) => {
                $('#crudForm [name=alatbayar_id]').first().val(alatbayar.id)
                element.val(alatbayar.namaalatbayar)
                element.data('currentValue', element.val())
                enableTglJatuhTempo($(`#crudForm`))
                enableNoWarkat($(`#crudForm`))
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=alatbayar_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }


    function enableTglJatuhTempo(el) {
        if ($(`#crudForm [name="alatbayar"]`).val() == 'GIRO') {
            el.find(`[name="tgljatuhtempo"]`).addClass('datepicker')
            el.find(`[name="tgljatuhtempo"]`).attr('readonly', false)
            initDatepicker()
            el.find(`[name="tgljatuhtempo"]`).parent('.input-group').find('.input-group-append').show()
        } else {
            el.find(`[name="tgljatuhtempo"]`).removeClass('datepicker')
            el.find(`[name="tgljatuhtempo"]`).parent('.input-group').find('.input-group-append').hide()
            el.find(`[name="tgljatuhtempo"]`).val($('#crudForm').find(`[name="tglbukti"]`).val()).trigger('change');
            el.find(`[name="tgljatuhtempo"]`).attr('readonly', true)
        }
    }

    function enableNoWarkat(el) {
        if ($(`#crudForm [name="alatbayar"]`).val() != 'TUNAI') {
            el.find(`[name="nowarkat"]`).attr('readonly', false)
        } else {
            el.find(`[name="nowarkat"]`).attr('readonly', true)
            el.find(`[name="nowarkat"]`).val('')
        }
    }


    function approve() {

        event.preventDefault()

        let form = $('#crudForm')
        $(this).attr('disabled', '')
        $('#processingLoader').removeClass('d-none')

        $.ajax({
            url: `${apiUrl}pindahbuku/approval`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                pindahId: selectedRows,
                bukti: selectedbukti,
                table: 'pindahbuku',
                statusapproval: 'statusapproval',
            },
            success: response => {
                $('#crudForm').trigger('reset')
                $('#crudModal').modal('hide')

                $('#jqGrid').jqGrid().trigger('reloadGrid');
                selectedRows = []
                selectedbukti = []
                $('#gs_').prop('checked', false)
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
</script>
@endpush()