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
                    <!-- TAMBAH INI KHUSUS MASTER DETAIL -->
                    <div class="modal-body modal-master modal-overflow" style="overflow: auto;">
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
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    CUSTOMER <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="agen_id">
                                <input type="text" name="agen" id="agen" class="form-control agen-lookup">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    DITERIMA DARI
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="diterimadari" class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    TGL LUNAS <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tgllunas" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <!-- 
                        <div class="table-responsive">
                            <table class="table table-bordered table-bindkeys" id="tablePelunasan" style="width:800px;">
                                <thead>
                                    <tr>
                                        <th width="1%">PILIH</th>
                                        <th width="2%">NO BUKTI</th>
                                        <th width="2%">TGL</th>
                                        <th width="2%">NOMINAL</th>
                                        <th width="3%">PELANGGAN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div> -->
                        <!-- TAMBAH INI KHUSUS MASTER DETAIL -->
                        <div class="overflow scroll-container mb-2">
                            <div class="table-container">
                                <table class="table table-bordered table-bindkeys " id="detailList">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px; min-width: 10px;">No</th>
                                            <th style="width: 150px; min-width: 150px;">Tgl jatuh tempo</th>
                                            <th style="width: 180px; min-width: 180px;">No warkat</th>
                                            <th style="width: 210px; min-width: 210px;">Bank</th>
                                            <th style="width: 200px; min-width: 200px;">Bank Pelanggan</th>
                                            <th style="width: 350px; min-width: 350px;">Keterangan</th>
                                            <th style="width: 250px; min-width: 250px;">Nominal</th>
                                            <th style="width: 200px; min-width: 200px;">Jenis Biaya</th>
                                            <th style="width: 150px; min-width: 150px;">Bulan Beban</th>
                                            <th style="width: 10px; min-width: 10px;" class="tbl_aksi">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body">
                                    </tbody>
                                    <tfoot>

                                        <tr>
                                            <td colspan="6">
                                                <p class="text-right font-weight-bold">TOTAL :</p>
                                            </td>
                                            <td>
                                                <p class="text-right font-weight-bold autonumeric" id="total"></p>
                                            </td>
                                            <td colspan="2"></td>
                                            <td class="tbl_aksi">
                                                <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">Tambah</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
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
                        <button class="btn btn-batal btn-secondary">
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
    let formattedDate
    let isEditTgl
    let isEdited
    $(document).ready(function() {

        $('#crudForm').autocomplete({
            disabled: true
        });

        $(document).on('click', "#addRow", function() {
            event.preventDefault()
            let method = `POST`
            let url = `${apiUrl}penerimaangiroheader/addrow`
            let form = $('#crudForm')
            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm').serializeArray()
            $('#crudForm').find(`[name="nominal[]"`).each((index, element) => {
                data.filter((row) => row.name === 'nominal[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[index])
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

        $(document).on('change', `#crudForm [name="tgllunas"]`, function() {
            $('#crudForm').find(`[name="tgljatuhtempo[]"]`).val($(this).val()).trigger('change');
        });

        $(document).on('click', '.delete-row', function(event) {
            deleteRow($(this).parents('tr'))
        })
        $(document).on('click', '.btn-batal', function(event) {
            event.preventDefault()
            if ($('#crudForm').data('action') == 'edit') {
                $.ajax({
                    url: `{{ config('app.api_url') }}penerimaangiroheader/editingat`,
                    method: 'POST',
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        id: $('#crudForm').find('[name=id]').val(),
                        btn: 'batal'
                    },
                    success: response => {
                        $("#crudModal").modal("hide")
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
            } else {
                $("#crudModal").modal("hide")
            }
        })


        $(document).on('input', `#table_body [name="nominal[]"]`, function(event) {
            setTotal()
        })

        // $(document).on('click', `#tablePelunasan tbody [name="pelunasan_id[]"]`, function() {
        //     if ($(this).prop("checked") == true) {

        //         let firstRow = $("#detailList tbody").find('#1')
        //         let count = 0;
        //         let row = '';
        //         let arrData = []
        //         $("#detailList tbody tr#1 td").each(function () {
        //             row =$("#detailList tbody tr#1").find(`td:eq(${count}) input`).val()
        //             if(row != '') {arrData.push(row)}
        //             count++
        //             row++
        //         })
        //         let arrSlice = arrData.slice(1,-1)

        //         if(arrSlice.length === 0){
        //             $("#detailList tbody").find('#1').remove()
        //         }

        //         id = $(this).val()
        //         console.log(id)
        //         $.ajax({
        //             url: `${apiUrl}penerimaangiroheader/${id}/getPelunasan`,
        //             method: 'GET',
        //             dataType: 'JSON',
        //             headers: {
        //                 Authorization: `Bearer ${accessToken}`
        //             },
        //             success: response => {
        //                 $.each(response.data, (index, data) => {

        //                     let detailRow = $(`
        //                         <tr class="${data.nobukti}">
        //                             <td></td>
        //                             <td>
        //                                 <div class="input-group">
        //                                     <input type="text" name="tgljatuhtempo[]" value="${data.tgljt}" class="form-control datepicker" readonly>   
        //                                 </div>
        //                             </td>
        //                             <td>
        //                                 <input type="text" name="nowarkat[]"  class="form-control">
        //                             </td>
        //                             <td>
        //                                 <input type="hidden" name="bank_id[]">
        //                                 <input type="text" name="bank[]"  class="form-control bank-lookup">
        //                             </td>
        //                             <td>
        //                                 <input type="hidden" name="bankpelanggan_id[]">
        //                                 <input type="text" name="bankpelanggan[]"  class="form-control bankpelanggan-lookup">
        //                             </td>
        //                             <td>
        //                             <input type="text" name="keterangan_detail[]" value="${data.keterangan}" class="form-control" readonly>
        //                             </td>
        //                             <td>
        //                             <input type="text" name="nominal[]" value="${data.nominal}" class="form-control autonumeric " readonly> 
        //                             </td>
        //                             <td>
        //                                 <input type="text" name="invoice_nobukti[]" value="${data.invoice_nobukti}" class="form-control" readonly>
        //                             </td>
        //                             <td>
        //                                 <input type="text" name="pelunasanpiutang_nobukti[]" value="${data.nobukti}" class="form-control" readonly>
        //                             </td>
        //                             <td>
        //                                 <input type="text" name="jenisbiaya[]" class="form-control">
        //                             </td>
        //                             <td>
        //                                 <div class="input-group">
        //                                     <input type="text" name="bulanbeban[]" class="form-control datepicker">   
        //                                 </div>
        //                             </td>
        //                             <td>
        //                                 <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
        //                             </td>
        //                         </tr>
        //                         `)

        //                     detailRow.find(`[name="tgljatuhtempo[]"]`).val(dateFormat(data.tgljt))
        //                     initAutoNumeric(detailRow.find(`[name="nominal[]"]`))
        //                     $('#detailList tbody').append(detailRow)
        //                     initDatepicker()
        //                     $('.bank-lookup').last().lookup({
        //                         title: 'Bank Lookup',
        //                         fileName: 'bank',
        //                         onSelectRow: (bank, element) => {
        //                             element.parents('td').find(`[name="bank_id[]"]`).val(bank.id)
        //                             element.val(bank.namabank)
        //                             element.data('currentValue', element.val())
        //                         },
        //                         onCancel: (element) => {
        //                             element.val(element.data('currentValue'))
        //                         },
        //                         onClear: (element) => {
        //                             element.val('')
        //                             element.data('currentValue', element.val())
        //                         }
        //                     })
        //                     $('.bankpelanggan-lookup').last().lookup({
        //                         title: 'Bank Pelanggan Lookup',
        //                         fileName: 'bankpelanggan',
        //                         onSelectRow: (bankpelanggan, element) => {
        //                             element.parents('td').find(`[name="bankpelanggan_id[]"]`).val(bankpelanggan.id)
        //                             element.val(bankpelanggan.namabank)
        //                             element.data('currentValue', element.val())
        //                         },
        //                         onCancel: (element) => {
        //                             element.val(element.data('currentValue'))
        //                         },
        //                         onClear: (element) => {
        //                             element.parents('td').find(`[name="bankpelanggan_id[]"]`).val('')
        //                             element.val('')
        //                             element.data('currentValue', element.val())
        //                         }
        //                     })
        //                 })

        //                 setRowNumbers()
        //                 setTotal()
        //             }
        //         })

        //     } else if ($(this).prop("checked") == false) {
        //         id = $(this).val()
        //         nobukti = $(this).parent().find(`[name="pelunasan_nobukti[]"]`).val()
        //         $(`#detailList tbody tr[class="${nobukti}"]`).remove()
        //         setTotal()
        //     }
        // })

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

            $('#crudForm').find(`[name="nominal[]"`).each((index, element) => {
                data.filter((row) => row.name === 'nominal[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[index])
            })

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
            data.push({
                name: 'tgldariheader',
                value: $('#tgldariheader').val()
            })
            data.push({
                name: 'tglsampaiheader',
                value: $('#tglsampaiheader').val()
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
                    url = `${apiUrl}penerimaangiroheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}penerimaangiroheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}penerimaangiroheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}penerimaangiroheader`
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

                    // isAllowedForceEdit = false
                    if (button == 'btnSubmit') {
                        id = response.data.id
                        console.log(id)
                        $('#crudModal').modal('hide')
                        $('#crudModal').find('#crudForm').trigger('reset')

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
                    } else {

                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        // showSuccessDialog(response.message, response.data.nobukti)
                        createPenerimaanGiro()
                        $('#crudForm').find('input[type="text"]').data('current-value', '')

                    }
                    if (response.data.grp == 'FORMAT') {
                        updateFormat(response.data)
                    }
                },
                error: error => {
                    // console.log('isAllowedForceEdit ', isAllowedForceEdit)
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        setErrorMessages(form, error.responseJSON.errors);
                        // if (action == 'edit') {
                        //     console.log('isAllowedForceEdit ', isAllowedForceEdit)
                        //     if (isAllowedForceEdit) {
                        //         $("#dialog-warning-message").dialog({
                        //             close: function(event, ui) {
                        //                 isAllowedForceEdit = true
                        //                 // approveKacab(Id)
                        //                 $('#crudModal').find('#crudForm').trigger('reset')
                        //                 $('#crudModal').modal('hide')

                        //             },
                        //         });
                        //     }
                        // }
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

        if (form.data('action') == 'add') {
            form.find('#btnSaveAdd').show()
        } else {
            form.find('#btnSaveAdd').hide()
        }
        activeGrid = null
        form.find('#btnSubmit').prop('disabled', false)
        if (form.data('action') == "view") {
            form.find('#btnSubmit').prop('disabled', true)
        }
        getMaxLength(form)
        initLookup()
        initSelect2(form.find('.select2bs4'), true)
        initDatepicker()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        removeEditingBy($('#crudForm').find('[name=id]').val())
        $('#crudModal').find('.modal-body').html(modalBody)
        initDatepicker('datepickerIndex')
        // isAllowedForceEdit = false
        // TAMBAH INI
        selectIndex = 0
    })

    function removeEditingBy(id) {

        let formData = new FormData();


        formData.append('id', id);
        formData.append('aksi', 'BATAL');
        formData.append('table', 'penerimaangiroheader');

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


    // function tarikPelunasan(aksi, id = null) {
    //     let checked
    //     (aksi == 'edit' || aksi == 'delete') ? checked = 'checked' : '';
    //     $.ajax({
    //         url: `${apiUrl}penerimaangiroheader/${id}/tarikPelunasan`,
    //         method: 'GET',
    //         dataType: 'JSON',
    //         headers: {
    //             Authorization: `Bearer ${accessToken}`
    //         },
    //         success: response => {
    //             if(response.data.length === 0){
    //                 let tablePelunasan = $(` 
    //                     <tr>
    //                         <td colspan='6'><p><b><center>TIDAK ADA PELUNASAN</center></b></p></td>
    //                     </tr>
    //                 `)

    //                 $('#tablePelunasan tbody').append(tablePelunasan)
    //             }else{
    //                 $.each(response.data, (index, data) => {
    //                     let tablePelunasan = $(`
    //                     <tr>
    //                         <td><input name='pelunasan_id[]' type="checkbox" id="checkItem" value="${data.id}" ${checked}>
    //                             <input name='pelunasan_nobukti[]' type="hidden" value="${data.nobukti}">
    //                         </td>
    //                         <td>
    //                             <p>${data.nobukti}</p>
    //                         </td>
    //                         <td>
    //                             <p>${dateFormat(data.tglbukti)}</p>
    //                         </td>
    //                         <td>
    //                             <p id="nominalLunas">${data.nominal}</p>
    //                         </td>
    //                         <td>
    //                             <p>${data.pelanggan}</p>
    //                         </td>
    //                     </tr>
    //                     `)

    //                     $('#tablePelunasan tbody').append(tablePelunasan)
    //                     initAutoNumeric(tablePelunasan.find('#nominalLunas'))
    //                 })

    //             }
    //         }
    //     })
    // }

    function setTotal() {
        let nominalDetails = $(`#table_body [name="nominal[]"]`)
        let total = 0

        $.each(nominalDetails, (index, nominalDetail) => {
            total += AutoNumeric.getNumber(nominalDetail)
        });

        new AutoNumeric('#total').set(total)
    }

    function select(element) {
        alert(element)
    }

    function createPenerimaanGiro() {
        let form = $('#crudForm')

        $('#crudModal').find('#crudForm').trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
        form.data('action', 'add')

        $('#crudModalTitle').text('Add Penerimaan Giro')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tgllunas]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        $('#table_body').html('')

        if (selectedRows.length > 0) {
            clearSelectedRows()
        }
        addRow()
        initAutoNumeric(form.find('.nominal'))

        setTotal()
    }

    function editPenerimaanGiro(id) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
        `)
        $('#crudModalTitle').text('Edit Penerimaan Giro')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setTglBukti(form),
            ])
            .then(() => {
                showPenerimaanGiro(form, id).then(() => {
                        if (selectedRows.length > 0) {
                            clearSelectedRows()
                        }
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
            })
            .catch((error) => {
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()
                    setErrorMessages(form, error.responseJSON.errors);
                } else {
                    showDialog(error.responseJSON)
                }
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function deletePenerimaanGiro(id) {

        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-trash"></i>
              Delete
    `)
        $('#crudModalTitle').text('Delete Penerimaan Giro')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showPenerimaanGiro(form, id)
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

    function editingAt(id, btn) {
        $.ajax({
            url: `{{ config('app.api_url') }}penerimaangiroheader/editingat`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                id: id,
                btn: btn
            },
            success: response => {
                // isEdited = response.isEdited
                // if (isEdited) {
                //     approveKacab(id)
                // } else {
                editPenerimaanGiro(id)
                // }
            },
            error: error => {
                errors = JSON.parse(error.responseText);
                showConfirmForce(errors.errors.id, id)
            }
        })
    }

    function viewPenerimaanGiro(id) {

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
        $('#crudModalTitle').text('View Penerimaan Giro')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showPenerimaanGiro(form, id)
            ])
            .then(userId => {
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

    function approval(Id) {
        $('#processingLoader').removeClass('d-none')

        $.ajax({
            url: `{{ config('app.api_url') }}penerimaangiroheader/${Id}/approval`,
            method: 'POST',
            dataType: 'JSON',
            beforeSend: request => {
                request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
            },
            success: response => {
                $('#jqGrid').trigger('reloadGrid')
            }
        }).always(() => {
            $('#processingLoader').addClass('d-none')
        })
    }


    function cekValidasi(Id, Aksi, nobukti) {
        $.ajax({
            url: `{{ config('app.api_url') }}penerimaangiroheader/${Id}/cekvalidasi`,
            method: 'POST',
            dataType: 'JSON',
            beforeSend: request => {
                request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
            },
            data: {
                aksi: Aksi,
                nobukti: nobukti
            },
            success: response => {
                var error = response.error
                if (error) {
                    showDialog(response)
                } else {
                    if (Aksi == 'PRINTER BESAR') {
                        window.open(`{{ route('penerimaangiroheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
                    } else if (Aksi == 'PRINTER KECIL') {
                        window.open(`{{ route('penerimaangiroheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
                    } else {
                        cekValidasiAksi(Id, Aksi)
                    }
                }
            }
        })
    }


    function cekValidasiAksi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}penerimaangiroheader/${Id}/cekValidasiAksi`,
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
                        editPenerimaanGiro(Id)
                        // editingAt(Id, 'EDIT')
                    }
                    if (Aksi == 'DELETE') {
                        deletePenerimaanGiro(Id)
                    }
                }

            }
        })
    }

    let lastIndex = 0;
    function showPenerimaanGiro(form, id) {
        return new Promise((resolve, reject) => {
            $('#detailList tbody').html('')

            $.ajax({
                url: `${apiUrl}penerimaangiroheader/${id}`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    let tgl = response.data.tglbukti

                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)
                        if (element.is('select')) {
                            element.val(value).trigger('change')
                        } else if (element.hasClass('datepicker')) {
                            element.val(dateFormat(value))
                        } else {
                            element.val(value)
                        }
                        if (index == 'agen') {
                            element.data('current-value', value)
                        }
                    })
                    $('#detailList tbody').html('')
                    $.each(response.detail, (index, detail) => {
                        // TAMBAHIN INI
                        selectIndex = index;

                        let readOnly = (detail.pelunasanpiutang_nobukti != '-') ? 'readonly' : '';
                        let detailRow = $(`
                        <tr class="${detail.pelunasanpiutang_nobukti}">
                            <td></td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="tgljatuhtempo[]" class="form-control datepicker">   
                                </div>
                            </td>
                            <td>
                                <input type="text" name="nowarkat[]"  class="form-control">
                            </td>
                            <td>
                                <input type="hidden" name="bank_id[]">
                                <input type="text" name="bank[]" id="bank_${index}" data-current-value="${detail.bank}" class="form-control bank-lookup${index}">
                            </td>
                            <td>
                                <input type="hidden" name="bankpelanggan_id[]">
                                <input type="text" name="bankpelanggan[]" id="bankpelanggan_${index}" data-current-value="${detail.bankpelanggan}" class="form-control lg-forms bankpelanggan-lookup${index}">
                            </td>
                            <td>
                                <textarea class="form-control" name="keterangan_detail[]" rows="1" placeholder="" ${readOnly}></textarea>
                            </td>
                            <td>
                                <input type="text" name="nominal[]" class="form-control autonumeric" ${readOnly}> 
                            </td>
                            <td>
                                <input type="text" name="jenisbiaya[]" class="form-control">   
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="bulanbeban[]" class="form-control datepicker">   
                                </div>
                            </td>
                            <td class="tbl_aksi">
                                <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                            </td>
                        </tr>
                        `)

                        detailRow.find(`[name="tgljatuhtempo[]"]`).val(dateFormat(detail.tgljatuhtempo))
                        detailRow.find(`[name="nowarkat[]"]`).val(detail.nowarkat)
                        detailRow.find(`[name="bank_id[]"]`).val(detail.bank_id)
                        detailRow.find(`[name="bank[]"]`).val(detail.bank)
                        detailRow.find(`[name="bankpelanggan_id[]"]`).val(detail.bankpelanggan_id)
                        detailRow.find(`[name="bankpelanggan[]"]`).val(detail.bankpelanggan)
                        detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
                        detailRow.find(`[name="nominal[]"]`).val(detail.nominal)
                        detailRow.find(`[name="invoice_nobukti[]"]`).val(detail.invoice_nobukti)
                        detailRow.find(`[name="jenisbiaya[]"]`).val(detail.jenisbiaya)
                        detailRow.find(`[name="pelunasanpiutang_nobukti[]"]`).val(detail.pelunasanpiutang_nobukti)
                        detailRow.find(`[name="bulanbeban[]"]`).val(dateFormat(detail.bulanbeban))

                        initAutoNumeric(detailRow.find(`[name="nominal[]"]`))
                        $('#detailList>#table_body').append(detailRow)

                        // TAMBAHIN INI
                        initLookupDetail(index);
                        lastIndex = index;

                        setTotal();


                        // $('.bank-lookup').last().lookup({
                        //     title: 'Bank Lookup',
                        //     fileName: 'bank',
                        //     beforeProcess: function(test) {
                        //         this.postData = {
                        //             Aktif: 'AKTIF',
                        //             tipe: 'BANK'

                        //         }
                        //     },
                        //     onSelectRow: (bank, element) => {
                        //         element.parents('td').find(`[name="bank_id[]"]`).val(bank.id)
                        //         element.val(bank.namabank)
                        //         element.data('currentValue', element.val())
                        //     },
                        //     onCancel: (element) => {
                        //         element.val(element.data('currentValue'))
                        //     },
                        //     onClear: (element) => {
                        //         element.parents('td').find(`[name="bank_id[]"]`).val('')
                        //         element.val('')
                        //         element.data('currentValue', element.val())
                        //     }
                        // })
                        // $('.bankpelanggan-lookup').last().lookup({
                        //     title: 'Bank Pelanggan Lookup',
                        //     fileName: 'bankpelanggan',
                        //     beforeProcess: function(test) {
                        //         this.postData = {
                        //             Aktif: 'AKTIF',

                        //         }
                        //     },
                        //     onSelectRow: (bankpelanggan, element) => {
                        //         element.parents('td').find(`[name="bankpelanggan_id[]"]`).val(bankpelanggan.id)
                        //         element.val(bankpelanggan.namabank)
                        //         element.data('currentValue', element.val())
                        //     },
                        //     onCancel: (element) => {
                        //         element.val(element.data('currentValue'))
                        //     },
                        //     onClear: (element) => {
                        //         element.parents('td').find(`[name="bankpelanggan_id[]"]`).val('')
                        //         element.val('')
                        //         element.data('currentValue', element.val())
                        //     }
                        // })

                    })

                    setRowNumbers()
                    initDatepicker()
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

    // let selectIndex = 0;

    function addRow() {

        lastIndex += 1; 

        let detailRow = $(`
      <tr>
        <td></td>
        <td>
            <div class="input-group">
                <input type="text" name="tgljatuhtempo[]" class="form-control datepicker">   
            </div>
        </td>
        <td>
            <input type="text" name="nowarkat[]"  class="form-control">
        </td>
        <td>
            <input type="hidden" name="bank_id[]">
            <input type="text" name="bank[]" id="bank_${lastIndex}" class="form-control bank-lookup${lastIndex}">
        </td>
        <td>
            <input type="hidden" name="bankpelanggan_id[]">
            <input type="text" name="bankpelanggan[]" id="bankpelanggan_${lastIndex}" class="form-control bankpelanggan-lookup${lastIndex}">
        </td>
        <td>
            <textarea class="form-control" name="keterangan_detail[]" rows="1" placeholder="" ></textarea>
        </td>
        <td>
        <input type="text" name="nominal[]" class="form-control autonumeric "> 
        </td>
        <td>
            <input type="text" name="jenisbiaya[]" class="form-control">   
        </td>
        <td>
            <div class="input-group">
                <input type="text" name="bulanbeban[]" class="form-control datepicker">   
            </div>
        </td>
        <td class="tbl_aksi">
            <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
        </td>
      </tr>
    `)

        $('#detailList>#table_body').append(detailRow)
        initLookupDetail(lastIndex);
        initAutoNumeric(detailRow.find('.autonumeric'))
        if ($('#crudForm [name=agen]').val() != '') {
            detailRow.find(`[name="tgljatuhtempo[]"]`).val(formattedDate).trigger('change');
        } else {
            tgllunas = $('#crudForm').find(`[name="tgllunas"]`).val()
            detailRow.find(`[name="tgljatuhtempo[]"]`).val(tgllunas).trigger('change');
        }

        initDatepicker()
        setRowNumbers()

        // selectIndex++;
    }

    function initLookupDetail(index) {
        let rowLookup = index;

        // $(`.bank-lookup${rowLookup}`).lookupMaster({
        //     title: 'Bank Lookup',
        //     fileName: 'bankMaster',
        //     detail: true,
        //     miniSize: true,
        //     typeSearch: 'ALL',
        //     searching: 1,
        //     beforeProcess: function() {
        //         this.postData = {
        //             Aktif: 'AKTIF',
        //             searching: 1,
        //             valueName: `bank_id_${index}`,
        //             searchText: `bank-lookup${rowLookup}`,
        //             title: 'Bank',
        //             tipe: 'BANK',
        //             typeSearch: 'ALL',
        //         };
        //     },
        //     onSelectRow: (bank, element) => {
        //         element.parents('td').find(`[name="bank_id[]"]`).val(bank.id);
        //         element.val(bank.namabank);
        //         element.data('currentValue', element.val());
        //     },
        //     onCancel: (element) => {
        //         element.val(element.data('currentValue'));
        //     },
        //     onClear: (element) => {
        //         element.parents('td').find(`[name="bank_id[]"]`).val('');
        //         element.val('');
        //         element.data('currentValue', element.val());
        //     },
        // });

        $(`.bank-lookup${rowLookup}`).lookupV3({
            title: 'Bank Lookup',
            fileName: 'bankV3',
            searching: ['namabank'],
            labelColumn: false,
            extendSize: md_extendSize_1,
            multiColumnSize:true,
            beforeProcess: function() {
                this.postData = {
                    Aktif: 'AKTIF',
                    tipe: 'BANK',
                };
            },
            onSelectRow: (bank, element) => {
                element.parents('td').find(`[name="bank_id[]"]`).val(bank.id);
                element.val(bank.namabank);
                element.data('currentValue', element.val());
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                element.parents('td').find(`[name="bank_id[]"]`).val('');
                element.val('');
                element.data('currentValue', element.val());
            },
        });

        // $(`.bankpelanggan-lookup${rowLookup}`).lookupMaster({
        //     title: 'Bank Pelanggan Lookup',
        //     fileName: 'bankpelangganMaster',
        //     detail: true,
        //     miniSize: true,
        //     typeSearch: 'ALL',
        //     searching: 1,
        //     beforeProcess: function() {
        //         this.postData = {
        //             Aktif: 'AKTIF',
        //             searching: 1,
        //             valueName: `bankpelanggan_id_${index}`,
        //             searchText: `bankpelanggan-lookup${rowLookup}`,
        //             title: 'Bank Pelanggan',
        //             typeSearch: 'ALL',
        //         };
        //     },
        //     onSelectRow: (bankpelanggan, element) => {
        //         element.parents('td').find(`[name="bankpelanggan_id[]"]`).val(bankpelanggan.id);
        //         element.val(bankpelanggan.namabank);
        //         element.data('currentValue', element.val());
        //     },
        //     onCancel: (element) => {
        //         element.val(element.data('currentValue'));
        //     },
        //     onClear: (element) => {
        //         element.parents('td').find(`[name="bankpelanggan_id[]"]`).val('');
        //         element.val('');
        //         element.data('currentValue', element.val());
        //     },
        // });

        $(`.bankpelanggan-lookup${rowLookup}`).lookupV3({
            title: 'Bank Pelanggan Lookup',
            fileName: 'bankpelangganV3', 
            searching: ['coa','keterangancoa'],
            labelColumn: false,
            extendSize: md_extendSize_3,
            multiColumnSize:true,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (bankpelanggan, element) => {
                element.parents('td').find(`[name="bankpelanggan_id[]"]`).val(bankpelanggan.id);
                element.val(bankpelanggan.namabank);
                element.data('currentValue', element.val());
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.parents('td').find(`[name="bankpelanggan_id[]"]`).val('');
                element.val('');
                element.data('currentValue', element.val());
            }
        })
    }

    function deleteRow(row) {
        let countRow = $('.delete-row').parents('tr').length
        row.remove()

        if (countRow <= 1) {
            // TAMBAH INI
            selectIndex = 0
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

    function approve() {

        event.preventDefault()

        let form = $('#crudForm')
        $(this).attr('disabled', '')
        $('#processingLoader').removeClass('d-none')

        $.ajax({
            url: `${apiUrl}penerimaangiroheader/approval`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                giroId: selectedRows
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

    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
            $.ajax({
                url: `${apiUrl}pengeluaranheader/field_length`,
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

        // $('.agen-lookup').lookupMaster({
        //     title: 'Customer Lookup',
        //     fileName: 'agenMaster',
        //     typeSearch: 'ALL',
        //     searching: 1,
        //     beforeProcess: function(test) {
        //         this.postData = {
        //             Aktif: 'AKTIF',
        //             searching: 1,
        //             valueName: 'agen_id',
        //             searchText: 'agen-lookup',
        //             title: 'Customer',
        //             typeSearch: 'ALL',
        //         }
        //     },
        //     onSelectRow: (agen, element) => {
        //         $('#crudForm [name=agen_id]').first().val(agen.id)
        //         let dateNow = new Date();
        //         dateNow.setDate(dateNow.getDate() + parseInt(agen.top));
        //         let end_date = new Date(dateNow.getFullYear(), dateNow.getMonth(), dateNow.getDate());
        //         formattedDate = end_date.getDate().toString().padStart(2, '0') + '-' + (end_date.getMonth() + 1).toString().padStart(2, '0') + '-' + end_date.getFullYear();

        //         $('#crudForm').find(`[name="tgljatuhtempo[]"]`).val(formattedDate).trigger('change');
        //         element.val(agen.namaagen)
        //         element.data('currentValue', element.val())
        //     },
        //     onCancel: (element) => {
        //         element.val(element.data('currentValue'))
        //     },
        //     onClear: (element) => {
        //         $('#crudForm [name=agen_id]').first().val('')
        //         element.val('')
        //         element.data('currentValue', element.val())
        //     }
        // })
        $(`.agen-lookup`).lookupV3({
            title: 'Customer Lookup',
            fileName: 'agenV3',
            labelColumn: false,
            beforeProcess: function(test) {    
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (agen, element) => {
                $('#crudForm [name=agen_id]').first().val(agen.id)
                let dateNow = new Date();
                dateNow.setDate(dateNow.getDate() + parseInt(agen.top));
                let end_date = new Date(dateNow.getFullYear(), dateNow.getMonth(), dateNow.getDate());
                formattedDate = end_date.getDate().toString().padStart(2, '0') + '-' + (end_date.getMonth() + 1).toString().padStart(2, '0') + '-' + end_date.getFullYear();

                $('#crudForm').find(`[name="tgljatuhtempo[]"]`).val(formattedDate).trigger('change');
                element.val(agen.namaagen)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=agen_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
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
                value: 'PENERIMAAN GIRO'
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

    function approveKacab(id) {
        $('#approveKacab').modal('show')
        $('#formApproveKacab').find('[name=id]').val(id)
    }

    $(document).on('click', `#approvalKacab`, function(event) {
        event.preventDefault()

        let data = [];
        data.push({
            name: 'id',
            value: $('#formApproveKacab').find('[name=id]').val()
        })
        data.push({
            name: 'username',
            value: $('#formApproveKacab').find('[name=username]').val()
        })
        data.push({
            name: 'password',
            value: $('#formApproveKacab').find('[name=password]').val()
        })
        $('#processingLoader').removeClass('d-none')

        $.ajax({
            url: `${apiUrl}penerimaangiroheader/approvalkacab`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: data,
            success: response => {
                if (response.status) {
                    $('#formApproveKacab').trigger("reset");
                    $("#approveKacab").modal('hide');
                    // if (!isAllowedForceEdit) {
                    editPenerimaanGiro($('#formApproveKacab').find('[name=id]').val())
                    // }
                } else {
                    showDialog('TIDAK ADA HAK AKSES')
                }
            },
            error: error => {
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()

                    setErrorMessages($('#formApproveKacab'), error.responseJSON.errors);
                } else {
                    showDialog(error.responseJSON)
                }
            },
        }).always(() => {
            $('#processingLoader').addClass('d-none')
            $(this).removeAttr('disabled')
        })
    })
</script>
@endpush()