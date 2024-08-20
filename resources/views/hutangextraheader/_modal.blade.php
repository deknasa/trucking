<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="crudForm">
            <div class="modal-content">
                
                <form action="" method="post">

                    <div class="modal-body">
                        <input type="hidden" name="id">

                        <div class="row form-group">
                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">
                                    NO BUKTI <span class="text-danger"></span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4">
                                <input type="text" name="nobukti" class="form-control" readonly>
                            </div>

                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">
                                    TGL BUKTI <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4">
                                <div class="input-group">
                                    <input type="text" name="tglbukti" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    supplier <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="supplier_id">
                                <input type="text" name="supplier" class="form-control supplier-lookup">
                            </div>
                        </div>


                        <div class="table-responsive table-scroll">
                            <table class="table table-bordered table-bindkeys" id="detailList" style="width: 1100px;">
                                <thead>
                                    <tr>
                                        <th scope="col" width="1%">No</th>
                                        <th scope="col" width="55%">Keterangan</th>
                                        <th scope="col" width="18%">Tgl Jatuh Tempo</th>
                                        <th scope="col" width="25%">Total</th>
                                        <th scope="col" class="tbl_aksi" width="1%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body">

                                </tbody>
                                <tfoot>
                                    <tr>

                                        <td colspan="3">
                                            <h5 class="font-weight-bold">TOTAL :</h5>
                                        </td>
                                        <td>
                                            <h5 id="total" class="text-right font-weight-bold"></h5>
                                        </td>
                                        <td class="tbl_aksi">
                                            <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">Tambah</button>
                                        </td>
                                    </tr>
                                </tfoot>

                            </table>
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
    let isEditTgl

    $(document).ready(function() {

        $("#crudForm [name]").attr("autocomplete", "off");

        $(document).on('click', "#addRow", function() {
            event.preventDefault()
            let method = `POST`
            let url = `${apiUrl}hutangextraheader/addrow`
            let form = $('#crudForm')
            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm').serializeArray()
            $('#crudForm').find(`[name="total_detail[]"]`).each((index, element) => {
                data.filter((row) => row.name === 'total_detail[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="total_detail[]"]`)[index])
            })

            $.ajax({
                url: url,
                method: method,
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {
                    addRow()
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()
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
        });

        $(document).on('change', `#crudForm [name="tglbukti"]`, function() {
            $('#crudForm').find(`[name="tgljatuhtempo[]"]`).val($(this).val()).trigger('change');
        });

        $(document).on('input', `#table_body [name="total_detail[]"]`, function(event) {
            setTotal()
        })

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


            $('#crudForm').find(`[name="total_detail[]"]`).each((index, element) => {
                data.filter((row) => row.name === 'total_detail[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="total_detail[]"]`)[index])
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
                name: 'info',
                value: info
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
                    url = `${apiUrl}hutangextraheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}hutangextraheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}hutangextraheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}hutangextraheader`
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
                        $('#detailGrid').jqGrid().trigger('reloadGrid')
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

        })
    })

    $('#crudModal').on('shown.bs.modal', () => {
        let form = $('#crudForm')

        setFormBindKeys(form)

        activeGrid = null

        form.find('#btnSubmit').prop('disabled', false)
        if (form.data('action') == "view") {
            form.find('#btnSubmit').prop('disabled', true)
        }

        initLookup()
        getMaxLength(form)
        initDatepicker()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'

        $('#crudModal').find('.modal-body').html(modalBody)
        initDatepicker('datepickerIndex')
    })

    function setTotal() {
        let nominalDetails = $(`#detailList [name="total_detail[]"]`)
        let total = 0

        $.each(nominalDetails, (index, nominalDetail) => {
            total += AutoNumeric.getNumber(nominalDetail)
        });

        new AutoNumeric('#total').set(total)
    }

    function createHutangExtraHeader() {
        let form = $('#crudForm')

        $('#crudModal').find('#crudForm').trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
        form.data('action', 'add')
        // form.find(`.sometimes`).show()
        $('#crudModalTitle').text('Create Hutang Extra')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        $('#table_body').html('')
        $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        addRow()
        setTotal()
    }

    function editHutangExtraHeader(id) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
                <i class="fa fa-save"></i>
                Save
              `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Edit Hutang Extra')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setTglBukti(form),
                showHutangExtraHeader(form, id)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                if (isEditTgl == 'TIDAK') {
                    form.find(`[name="tglbukti"]`).prop('readonly', true)
                    form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
                }
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function deleteHutangExtraHeader(id) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
                <i class="fa fa-trash"></i>
                Delete
              `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Delete Hutang Extra')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showHutangExtraHeader(form, id)
            ])
            .then(() => {
                $('#crudModal').modal('show')

            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function viewHutangExtraHeader(id) {
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
        $('#crudModalTitle').text('View Hutang Extra')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showHutangExtraHeader(form, id)
            ])
            .then(id => {
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
                $('#crudModal').modal('show')
                form.find(`.hasDatepicker`).prop('readonly', true)
                form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()

                let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
                let nameFind = $('#crudForm').find(`[name]`).parents('.input-group')
                name.attr('disabled', true)
                name.find('.lookup-toggler').remove()
                nameFind.find('button.button-clear').remove()
                $('#crudForm').find(`.tbl_aksi`).hide()

            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
            $.ajax({
                url: `${apiUrl}hutangextraheader/field_length`,
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

    function showHutangExtraHeader(form, hutangId) {
        return new Promise((resolve, reject) => {
            $('#detailList tbody').html('')


            $.ajax({
                url: `${apiUrl}hutangextraheader/${hutangId}`,
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

                        if (index == 'supplier') {
                            element.data('current-value', value)
                        }
                    })
                    $('#detailList tbody').html('')
                    $.each(response.detail, (index, detail) => {
                        let detailRow = $(`
              <tr>
                <td> </td>
                <td>
                    <textarea class="form-control" name="keterangan_detail[]" rows="1" placeholder=""></textarea>
                </td>
                <td>
                  <div class="input-group">
                    <input type="text" name="tgljatuhtempo[]" class="form-control datepicker">
                  </div>
                </td>
                <td>
                    <input type="text" name="total_detail[]" style="text-align:right" class="form-control text-right autonumeric" > 
                </td>
                <td class="tbl_aksi" >
                  <div class='btn btn-danger btn-sm delete-row '>Delete</div>
                </td>
              </tr>
            `)

                        detailRow.find(`[name="tgljatuhtempo[]"]`).val(dateFormat(detail.tgljatuhtempo))
                        detailRow.find(`[name="total_detail[]"]`).val(detail.total)
                        detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)

                        initAutoNumeric(detailRow.find(`[name="total_detail[]"]`))


                        $('#detailList>#table_body').append(detailRow)
                        initDatepicker()
                        setTotal()
                    })

                    setRowNumbers()
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

    function addRow() {
        let detailRow = $(`
      <tr>
          <td> </td>
          <td>
            <textarea class="form-control" name="keterangan_detail[]" rows="1" placeholder=""></textarea>
          </td>
          <td>
            <div class="input-group">
              <input type="text" name="tgljatuhtempo[]" class="form-control datepicker">
            </div>
          </td>
          <td>
              <input type="text" name="total_detail[]" style="text-align:right" class="form-control text-right autonumeric" > 
          </td>
          <td class="tbl_aksi" >
            <div class='btn btn-danger btn-sm delete-row'>Delete</div>
          </td>
      </tr>`)

        tglbukti = $('#crudForm').find(`[name="tglbukti"]`).val()
        detailRow.find(`[name="tgljatuhtempo[]"]`).val(tglbukti).trigger('change');


        $('#detailList>#table_body').append(detailRow)
        initDatepicker()

        initAutoNumeric(detailRow.find('.autonumeric'))

        setRowNumbers()


    }


    function deleteRow(row) {
        let countRow = $('.delete-row').parents('tr').length
        row.remove()
        if (countRow <= 1) {
            addRow()
        }

        setRowNumbers()
        setTotal()
        initDatepicker()
    }

    function setRowNumbers() {
        let elements = $('#detailList>#table_body>tr>td:nth-child(1)')

        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }

    function initLookup() {
        $('.akunpusat-lookup').lookup({
            title: 'Akun Pusat Lookup',
            fileName: 'akunpusat',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    levelCoa: '3',
                }
            },
            onSelectRow: (akunpusat, element) => {
                element.val(akunpusat.coa)
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


        $('.supplier-lookup').lookup({
            title: 'supplier Lookup',
            fileName: 'supplier',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (supplier, element) => {
                $(`#crudForm [name="supplier_id"]`).first().val(supplier.id)
                element.val(supplier.namasupplier)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $(`#crudForm [name="supplier_id"]`).first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

    }


    function cekValidasi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}hutangextraheader/${Id}/cekvalidasi`,
            method: 'POST',
            dataType: 'JSON',
            beforeSend: request => {
                request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
            },
            success: response => {
                var error = response.error
                if (error) {
                    showDialog(response)
                } else {
                    if (Aksi == 'PRINTER BESAR') {
                        window.open(`{{ route('hutangextraheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
                    } else if (Aksi == 'PRINTER KECIL') {
                        window.open(`{{ route('hutangextraheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
                    } else {
                        cekValidasiAksi(Id, Aksi)
                    }
                }
            }
        })
    }


    function cekValidasiAksi(Id, Aksi) {
        $.ajax({
            url: `${apiUrl}hutangextraheader/${Id}/cekValidasiAksi`,
            method: 'POST',
            dataType: 'JSON',
            beforeSend: request => {
                request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
            },
            success: response => {
                var error = response.error
                if (error) {
                    showDialog(response)
                } else {
                    if (Aksi == 'EDIT') {
                        editHutangExtraHeader(Id)
                    }
                    if (Aksi == 'DELETE') {
                        deleteHutangExtraHeader(Id)
                    }
                }

            }
        })
    }

    const setTglBukti = function(form) {
        return new Promise((resolve, reject) => {
            let data = [];
            data.push({
                name: 'grp',
                value: 'EDIT TANGGAL BUKTI'
            })
            data.push({
                name: 'subgrp',
                value: 'HUTANG EXTRA'
            })
            $.ajax({
                url: `${apiUrl}parameter/getparamfirst`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {
                    isEditTgl = $.trim(response.text);
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }


    function approve() {

        event.preventDefault()

        let form = $('#crudForm')
        $(this).attr('disabled', '')
        $('#processingLoader').removeClass('d-none')

        $.ajax({
            url: `${apiUrl}hutangextraheader/approval`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                hutangId: selectedRows
            },
            success: response => {
                $('#crudForm').trigger('reset')
                $('#crudModal').modal('hide')

                $('#jqGrid').jqGrid().trigger('reloadGrid');
                selectedRows = []
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