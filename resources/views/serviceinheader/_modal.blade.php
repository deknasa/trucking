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
                                    TANGGAL MASUK <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4">
                                <input type="text" name="tglmasuk" class="form-control datepicker">
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
                                    <th>Mekanik</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type="hidden" name="mekanik_id[]" class="form-control">
                                        <input type="text" name="mekanik[]" class="form-control mekanik-lookup">
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
                    url = `${apiUrl}serviceinheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}serviceinheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}serviceinheader/${Id}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}serviceinheader`
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

    function createServicein() {
        let form = $('#crudForm')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
        form.data('action', 'add')
        $('#crudModalTitle').text('Add Service in')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
    }

    function editServicein(id) {
        let form = $('#crudForm')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
        $('#crudModalTitle').text('Edit Service In ')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        showServicein(form, id)
    }

    function deleteServicein(id) {
        let form = $('#crudForm')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Delete Service in')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        showServicein(form, id)
    }

    function showServicein(form, id) {
        $('#detailList tbody').html('')

        $.ajax({
            url: `${apiUrl}serviceinheader/${id}`,
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
                        console.log(value);
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
                            <input type="hidden" name="mekanik_id[]" class="form-control">
                            <input type="text" name="mekanik[]" class="form-control mekanik-lookup">
                        </td>

                        <td>
                            <input type="text" name="keterangan_detail[]" class="form-control">
                        </td>

                        <td>
                            <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                        </td>
                    </tr>`)

                    detailRow.find(`[name="mekanik[]"]`).val(detail.mekanik)
                    detailRow.find(`[name="mekanik_id[]"]`).val(detail.mekanik_id)

                    detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)

                    //autonumeric
                    //     initAutoNumeric(detailRow.find(`[name="nominal_detail[]"]`))

                    $('#detailList tbody').append(detailRow)

                    $('#lookup').hide()

                    $('.mekanik-lookup').last().lookup({
                        title: 'mekanik Lookup',
                        fileName: 'mekanik',
                        onSelectRow: (mekanik, element) => {
                            $(`#crudForm [name="mekanik_id[]"]`).first().val(mekanik.id)
                            element.val(mekanik.namamekanik)

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
                <input type="hidden" name="mekanik_id[]" class="form-control">
                <input type="text" name="mekanik[]" class="form-control mekanik-lookup">
            </td>

            <td>
                <input type="text" name="keterangan_detail[]" class="form-control">
            </td>

            <td>
                <div class='btn btn-danger btn-sm rmv'>Hapus</div>
            </td>
        </tr>`)

        $('#detailList tbody').append(detailRow)

        $('.mekanik-lookup').last().lookup({
            title: 'mekanik Lookup',
            fileName: 'mekanik',
            onSelectRow: (mekanik, element) => {
                element.parents('td').find(`[name="mekanik_id[]"]`).val(mekanik.id)
                element.val(mekanik.namamekanik)

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