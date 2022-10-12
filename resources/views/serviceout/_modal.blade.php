<div class="modal fade modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="crudForm">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="crudModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post">

                    <div class="modal-body">
                        <input type="hidden" name="id">

                        <div class="row form-group">
                            <div class="col-12 col-sm-2 col-md-2 col-form-label">
                                <label>
                                    NO BUKTI <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4">
                                <input type="text" name="nobukti" class="form-control" readonly>
                            </div>

                            <div class="col-12 col-sm-2 col-md-2 col-form-label">
                                <label>
                                    TANGGAL BUKTI <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4">
                                <input type="text" name="tglbukti" class="form-control datepicker">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                <label>
                                    TRADO <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-8 col-md-10">
                                <input type="hidden" name="trado_id">
                                <input type="text" name="trado" class="form-control trado-lookup">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-2 col-md-2 col-form-label">
                                <label>
                                    TANGGAL KELUAR <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4">
                                <input type="text" name="tglkeluar" class="form-control datepicker">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                <label>
                                    KETERANGAN <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="keterangan" class="form-control">
                            </div>
                        </div>

                        <table class="table table-bordered table-bindkeys" id="detailList">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nobukti Servicein</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type="text" name="servicein_nobukti[]" class="form-control servicein-lookup">
                                    </td>

                                    <td>
                                        <input type="text" name="keterangan_detail[]" class="form-control">

                                    </td>

                                    <td>
                                        <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                                    </td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">Tambah</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Simpan
                        </button>
                        <button class="btn btn-secondary" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                            Batal
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
    $(document).ready(function() {

        $("#addRow").click(function() {
            addRow()
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
                    url = `${apiUrl}serviceout`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}serviceout/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}serviceout/${Id}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}serviceout`
                    break;
            }
            $(this).attr('disabled', '')
            $('#loader').removeClass('d-none')

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
                    console.log(id)
                    $('#crudModal').modal('hide')
                    $('#crudModal').find('#crudForm').trigger('reset')

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
                        showDialog(error.statusText)
                    }
                },
            }).always(() => {
                $('#loader').addClass('d-none')
                $(this).removeAttr('disabled')
            })
        })
    })

    function createServiceOut() {
        let form = $('#crudForm')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
        form.data('action', 'add')
        $('#crudModalTitle').text('Add Service Out')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
    }

    function editServiceOut(id) {
        let form = $('#crudForm')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
        $('#crudModalTitle').text('Edit Service Out ')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        showServiceOut(form, id)
    }

    function deleteServiceOut(id) {
        let form = $('#crudForm')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Delete Service Out')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        showServiceOut(form, id)
    }

    function showServiceOut(form, id) {
        $('#detailList tbody').html('')

        $.ajax({
            url: `${apiUrl}serviceout/${id}`,
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
                //     element.val(value)
                //     let tglbukti = response.data.tglbukti
                //     // let tglmasuk = response.data.tglmasuk

                //     $('#tglbukti').val(dateFormat(new Date(tglbukti)));
                //     // $('#tglmasuk').val(dateFormat( new Date(tglmasuk)));

                // })

                $.each(response.detail, (index, detail) => {
                    let detailRow = $(`
                    <tr>
                        <td></td>
                        <td>
                            <input type="text" name="servicein_nobukti[]" class="form-control servicein-lookup">
                        </td>
                        <td>
                            <input type="text" name="keterangan_detail[]" class="form-control">
                        </td>
                        <td>
                        <div class='btn btn-danger btn-sm delete-row '>Hapus</div>
                      </td>
                    </tr>`)

                    detailRow.find(`[name="servicein_nobukti[]"]`).val(detail.servicein_nobukti)

                    detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)

                    $('#detailList tbody').append(detailRow)

                    $('#lookup').hide()

                    $('.servicein-lookup').last().lookup({
                        title: 'servicein Lookup',
                        fileName: 'servicein',
                        onSelectRow: (servicein, element) => {
                            element.val(servicein.nobukti)
                        }
                    })

                })
                setRowNumbers()
            }
        })
    }

    function addRow() {
        let detailRow = (`
        <tr>
        <td></td>
        <td>
            <input type="text" name="servicein_nobukti[]" class="form-control servicein-lookup">
        </td>
        <td>
            <input type="text" name="keterangan_detail[]" class="form-control">
        </td>
        <td>
        <div class='btn btn-danger btn-sm delete-row '>Hapus</div>
        </td>
    </tr>`)

        $('#detailList tbody').append(detailRow)

        $('.servicein-lookup').last().lookup({
            title: 'servicein Lookup',
            fileName: 'servicein',
            onSelectRow: (servicein, element) => {
                element.val(servicein.nobukti)
            }
        })

        setRowNumbers()
    }

    function deleteRow(row) {
        row.remove()

        setRowNumbers()
    }

    function setRowNumbers() {
        let elements = $('#detailList tbody tr td:nth-child(1)')

        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }
</script>
@endpush()