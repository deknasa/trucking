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
                                <div class="input-group">
                                    <input type="text" name="tglbukti" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                <label>
                                    PELANGGAN <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="pelanggan_id">
                                <input type="text" name="pelanggan" class="form-control pelanggan-lookup">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                <label>
                                    DITERIMA DARI <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="diterimadari" class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                <label>
                                    TANGGAL LUNAS <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tgllunas" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                <label>
                                    CABANG <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="cabang_id">
                                <input type="text" name="cabang" class="form-control cabang-lookup">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                <label>
                                    STATUS KAS <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <select name="statuskas" class="form-select select2bs4" style="width: 100%;">
                                    <option value="">-- PILIH STATUS KAS --</option>
                                </select>
                            </div>
                        </div>


                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                <label>
                                    BANK <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="bank_id">
                                <input type="text" name="bank" class="form-control bank-lookup">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                <label>
                                    NO RESI
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="noresi" class="form-control">
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

                        <div class="table-responsive">
                            <table class="table table-bordered table-bindkeys" id="detailList" style="width:2010px;">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th width="5%">Kode Perk</th>
                                        <th width="4%">Tgl jatuh tempo</th>
                                        <th width="4%">No warkat</th>
                                        <th width="7%">Bank Pelanggan</th>
                                        <th width="6%">Keterangan</th>
                                        <th width="6%">Nominal</th>
                                        <th width="5%">No Invoice</th>
                                        <th width="5%">No Bukti Pelunasan</th>
                                        <th width="4%">Jenis Biaya</th>
                                        <th width="4%">Bulan Beban</th>
                                        <th width="1%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body" class="form-group">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6">
                                            <p class="text-right font-weight-bold">TOTAL :</p>
                                        </td>
                                        <td>
                                            <p class="text-right font-weight-bold autonumeric" id="total"></p>
                                        </td>
                                        <td colspan="4"></td>
                                        <td>
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
    let modalBody = $('#crudModal').find('.modal-body').html()
    let type

    $(document).ready(function() {
        $('#crudForm').autocomplete({
            disabled: true
        });
        
        $(document).on('change', '[name=statuskas]', function() {
            if ($(this).val() == 116) {
                type = 'kas'
            } else if ($(this).val() == 117) {
                type = 'bank'
            } else {
                type = null
            }
        })

        $(document).on('click', "#addRow", function() {
            addRow()
        });

        $(document).on('click', '.delete-row', function(event) {
            deleteRow($(this).parents('tr'))
        })

        $(document).on('input', `#table_body [name="nominal_detail[]"]`, function(event) {
            setTotal()
        })

        // $(document).on('click', `#tablePelunasan tbody [name="pelunasan_id[]"]`, function() {
        //     if ($(this).prop("checked") == true) {

        //         let firstRow = $("#detailList tbody").find('#1')
        //         let count = 0;
        //         let row = '';
        //         let arrData = []
        //         $("#detailList tbody tr#1 td").each(function() {
        //             row = $("#detailList tbody tr#1").find(`td:eq(${count}) input`).val()
        //             if (row != '') {
        //                 arrData.push(row)
        //             }
        //             count++
        //             row++
        //         })
        //         let arrSlice = arrData.slice(1, -1)

        //         if (arrSlice.length === 0) {
        //             $("#detailList tbody").find('#1').remove()
        //         }


        //         id = $(this).val()
        //         nobukti = $(this).parent().find(`[name="pelunasan_nobukti[]"]`).val()
        //         let text = nobukti.substr(0, 3)
        //         let table = (text == 'PPT') ? 'pelunasan' : 'giro';
        //         $.ajax({
        //             url: `${apiUrl}penerimaanheader/${id}/${table}/getPelunasan`,
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
        //                             <input type="text" name="coadebet[]"  class="form-control akunpusat-lookup"">
        //                             </td>
        //                             <td>
        //                                 <div class="input-group">
        //                                     <input type="text" name="tgljatuhtempo[]" value="${data.tgljt}" class="form-control datepicker" readonly>   
        //                                 </div>
        //                             </td>
        //                             <td>
        //                             <input type="text" name="nowarkat[]"  class="form-control">
        //                             </td>
        //                             <td>
        //                                 <input type="hidden" name="bankpelanggan_id[]">
        //                                 <input type="text" name="bankpelanggan[]"  class="form-control bankpelanggan-lookup">
        //                             </td>
        //                             <td>
        //                             <input type="text" name="keterangan_detail[]" value="${data.keterangan}" class="form-control" readonly>
        //                             </td>
        //                             <td>
        //                             <input type="text" name="nominal_detail[]" value="${data.nominal}" class="form-control text-right" readonly> 
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
        //                                 <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
        //                             </td>
        //                         </tr>
        //                         `)

        //                     // initDatepicker(detailRow.find('.datepicker'))
        //                     detailRow.find(`[name="tgljatuhtempo[]"]`).val(dateFormat(data.tgljt))

        //                     initAutoNumeric(detailRow.find(`[name="nominal_detail[]"]`))
        //                     $('#detailList tbody').append(detailRow)
        //                     initDatepicker()
        //                     $('.akunpusat-lookup').last().lookup({
        //                         title: 'Kode Perkiraan Lookup',
        //                         fileName: 'akunpusat',
        //                         onSelectRow: (akunpusat, element) => {
        //                             element.val(akunpusat.coa)
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

            let method
            let url
            let form = $('#crudForm')
            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm').serializeArray()

            $('#crudForm').find(`[name="nominal_detail[]"`).each((index, element) => {
                data.filter((row) => row.name === 'nominal_detail[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal_detail[]"]`)[index])
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
                    url = `${apiUrl}penerimaanheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}penerimaanheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}penerimaanheader/${Id}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}penerimaanheader`
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

                    if (id == 0) {
                        $('#detail').jqGrid().trigger('reloadGrid')
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
                        showDialog(error.statusText)
                    }
                },
            }).always(() => {
                $('#loader').addClass('d-none')
                $(this).removeAttr('disabled')
            })
        })
    })

    $('#crudModal').on('shown.bs.modal', () => {
        let form = $('#crudForm')

        setFormBindKeys(form)

        activeGrid = null

        getMaxLength(form)
        initLookup()
        initSelect2()
        initDatepicker()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'

        $('#crudModal').find('.modal-body').html(modalBody)
    })


    // function tarikPelunasan(aksi, id = null) {
    //     let checked = (aksi == 'edit' || aksi == 'delete') ? 'checked' : '';
    //     $.ajax({
    //         url: `${apiUrl}penerimaanheader/${id}/tarikPelunasan`,
    //         method: 'GET',
    //         dataType: 'JSON',
    //         headers: {
    //             Authorization: `Bearer ${accessToken}`
    //         },
    //         success: response => {
    //             if (response.data.length === 0) {
    //                 let tablePelunasan = $(` 
    //                     <tr>
    //                         <td colspan='6'><p><b><center>TIDAK ADA PELUNASAN/GIRO</center></b></p></td>
    //                     </tr>
    //                 `)

    //                 $('#tablePelunasan tbody').append(tablePelunasan)
    //             } else {

    //                 $.each(response.data, (index, data) => {
    //                     let tablePelunasan = $(`
    //                     <tr>
    //                         <td>
    //                             <input name='pelunasan_id[]' type="checkbox" id="checkItem" value="${data.id}" ${checked}>
    //                             <input name='pelunasan_nobukti[]' type="hidden" value="${data.nobukti}">
                                
    //                         </td>
    //                         <td>
    //                             <p>${data.nobukti}</p>
    //                         </td>
    //                         <td>
    //                             <p>${dateFormat(data.tglbukti)}</p>
    //                         </td>
    //                         <td>
    //                             <p id="nominalLunas" class="text-right">${data.nominal}</p>
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
        let nominalDetails = $(`#table_body [name="nominal_detail[]"]`)
        let total = 0

        $.each(nominalDetails, (index, nominalDetail) => {
            total += AutoNumeric.getNumber(nominalDetail)
        });

        new AutoNumeric('#total').set(total)
    }

    function select(element) {
        alert(element)
    }

    function createPenerimaan() {
        let form = $('#crudForm')

        $('#crudModal').find('#crudForm').trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
        form.data('action', 'add')

        $('#crudModalTitle').text('Add Penerimaan')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tgllunas]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        $('#table_body').html('')
        addRow();

        initAutoNumeric(form.find('.nominal'))
        setStatusKasOptions(form)
        // tarikPelunasan('add')
        setTotal()
    }

    function editPenerimaan(id) {
        let form = $('#crudForm')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
        $('#crudModalTitle').text('Edit Penerimaan')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        Promise
            .all([
                setStatusKasOptions(form)
            ])
            .then(() => {
                // tarikPelunasan('edit', id)
                showPenerimaan(form, id)
            })

    }

    function deletePenerimaan(id) {

        let form = $('#crudForm')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
        $('#crudModalTitle').text('Delete Penerimaan')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        Promise
            .all([
                setStatusKasOptions(form)
            ])
            .then(() => {

                // tarikPelunasan('delete', id)
                showPenerimaan(form, id)
            })

    }



    function cekValidasi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}penerimaanheader/${Id}/cekvalidasi`,
            method: 'POST',
            dataType: 'JSON',
            beforeSend: request => {
                request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
            },
            success: response => {
                var kodenobukti = response.kodenobukti
                if (kodenobukti == '1') {
                    var kodestatus = response.kodestatus
                    if (kodestatus == '1') {
                        showDialog(response.message['keterangan'])
                    } else {
                        if (Aksi == 'EDIT') {
                            editPenerimaan(Id)
                        }
                        if (Aksi == 'DELETE') {
                            deletePenerimaan(Id)
                        }
                    }

                } else {
                    showDialog(response.message['keterangan'])
                }
            }
        })
    }

    const setStatusKasOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statuskas]').empty()
            relatedForm.find('[name=statuskas]').append(
                new Option('-- PILIH STATUS KAS --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    limit: 0,
                    filters: JSON.stringify({
                        "groupOp": "AND",
                        "rules": [{
                            "field": "grp",
                            "op": "cn",
                            "data": "STATUS KAS"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusKas => {
                        let option = new Option(statusKas.text, statusKas.id)

                        relatedForm.find('[name=statuskas]').append(option).trigger('change')
                    });

                    resolve()
                }
            })
        })
    }

    function showPenerimaan(form, id) {
        $('#detailList tbody').html('')

        $.ajax({
            url: `${apiUrl}penerimaanheader/${id}`,
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

                    if (index == 'pelanggan') {
                        element.data('current-value', value)
                    }
                    if (index == 'cabang') {
                        element.data('current-value', value)
                    }
                    if (index == 'bank') {
                        element.data('current-value', value)
                    }
                })

                $.each(response.detail, (index, detail) => {
                    let readOnly = (detail.pelunasanpiutang_nobukti != '-') ? 'readonly' : '';
                    let detailRow = $(`
                    <tr class="${detail.pelunasanpiutang_nobukti}">
                        <td></td>
                        <td>
                            <input type="text" name="coadebet[]" data-current-value="${detail.coadebet}" class="form-control akunpusat-lookup">
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="text" name="tgljatuhtempo[]" class="form-control datepicker">   
                            </div>
                        </td>
                        <td>
                            <input type="text" name="nowarkat[]"  class="form-control">
                        </td>
                        <td>
                            <input type="hidden" name="bankpelanggan_id[]">
                            <input type="text" name="bankpelanggan[]" data-current-value="${detail.bankpelanggan}" class="form-control bankpelanggan-lookup">
                        </td>
                        <td>
                            <input type="text" name="keterangan_detail[]"  class="form-control" ${readOnly}>
                        </td>
                        <td>
                            <input type="text" name="nominal_detail[]" class="form-control autonumeric"  ${readOnly}> 
                        </td>
                        <td>
                            <input type="text" name="invoice_nobukti[]"  class="form-control" ${readOnly}>
                        </td>
                        <td>
                            <input type="text" name="pelunasanpiutang_nobukti[]" class="form-control" ${readOnly}>
                        </td>
                        <td>
                            <input type="text" name="jenisbiaya[]" class="form-control">   
                        </td>
                        
                        <td>
                            <div class="input-group">
                                <input type="text" name="bulanbeban[]" class="form-control datepicker">   
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                        </td>
                    </tr>
                    `)

                    detailRow.find(`[name="coadebet[]"]`).val(detail.coadebet)
                    detailRow.find(`[name="nowarkat[]"]`).val(detail.nowarkat)
                    detailRow.find(`[name="bankpelanggan_id[]"]`).val(detail.bankpelanggan_id)
                    detailRow.find(`[name="bankpelanggan[]"]`).val(detail.bankpelanggan)
                    detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
                    detailRow.find(`[name="nominal_detail[]"]`).val(detail.nominal)
                    detailRow.find(`[name="invoice_nobukti[]"]`).val(detail.invoice_nobukti)
                    detailRow.find(`[name="pelunasanpiutang_nobukti[]"]`).val(detail.pelunasanpiutang_nobukti)
                    detailRow.find(`[name="jenisbiaya[]"]`).val(detail.jenisbiaya)

                    initAutoNumeric(detailRow.find(`[name="nominal_detail[]"]`))
                    detailRow.find(`[name="tgljatuhtempo[]"]`).val(dateFormat(detail.tgljatuhtempo))
                    detailRow.find(`[name="bulanbeban[]"]`).val(dateFormat(detail.bulanbeban))

                    $('#detailList tbody').append(detailRow)

                    setTotal();

                    $('.akunpusat-lookup').last().lookup({
                        title: 'Kode Perk. Lookup',
                        fileName: 'akunpusat',
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

                    $('.bankpelanggan-lookup').last().lookup({
                        title: 'Bank Pelanggan Lookup',
                        fileName: 'bankpelanggan',
                        onSelectRow: (bankpelanggan, element) => {
                            element.parents('td').find(`[name="bankpelanggan_id[]"]`).val(bankpelanggan.id)
                            element.val(bankpelanggan.namabank)
                            element.data('currentValue', element.val())
                        },
                        onCancel: (element) => {
                            element.val(element.data('currentValue'))
                        },
                        onClear: (element) => {
                            element.parents('td').find(`[name="bankpelanggan_id[]"]`).val('')
                            element.val('')
                            element.data('currentValue', element.val())
                        }
                    })

                })

                setRowNumbers()
                initDatepicker()
                if (form.data('action') === 'delete') {
                    form.find('[name]').addClass('disabled')
                    initDisabled()
                }
            }
        })
    }

    function addRow() {
        let detailRow = $(`
      <tr>
        <td></td>
        <td>
          <input type="text" name="coadebet[]"  class="form-control akunpusat-lookup">
        </td>
        <td>
          <div class="input-group">
            <input type="text" name="tgljatuhtempo[]" class="form-control datepicker">   
          </div>
        </td>
        <td>
          <input type="text" name="nowarkat[]"  class="form-control">
        </td>
        <td>
            <input type="hidden" name="bankpelanggan_id[]">
            <input type="text" name="bankpelanggan[]"  class="form-control bankpelanggan-lookup">
        </td>
        <td>
          <input type="text" name="keterangan_detail[]"  class="form-control">
        </td>
        <td>
          <input type="text" name="nominal_detail[]" class="form-control autonumeric"> 
        </td>
        <td>
            <input type="text" name="invoice_nobukti[]"  class="form-control" readonly>
        </td>
        <td>
            <input type="text" name="pelunasanpiutang_nobukti[]"  class="form-control" readonly>
        </td>
        <td>
            <input type="text" name="jenisbiaya[]" class="form-control">   
        </td>
        <td>
            <div class="input-group">
                <input type="text" name="bulanbeban[]" class="form-control datepicker">   
            </div>
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
        </td>
      </tr>
    `)

        $('#detailList tbody').append(detailRow)
        $('.akunpusat-lookup').last().lookup({
            title: 'Kode Perkiraan Lookup',
            fileName: 'akunpusat',
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

        $('.bankpelanggan-lookup').last().lookup({
            title: 'Bank Pelanggan Lookup',
            fileName: 'bankpelanggan',
            onSelectRow: (bankpelanggan, element) => {
                $(`#crudForm [name="bankpelanggan_id[]"]`).last().val(bankpelanggan.id)
                element.val(bankpelanggan.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $(`#crudForm [name="bankpelanggan_id[]"]`).last().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        initAutoNumeric(detailRow.find('.autonumeric'))
        // $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find(`[name="tgljatuhtempo[]"]`).val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        initDatepicker()
        setRowNumbers()
    }

    function deleteRow(row) {
        row.remove()

        setRowNumbers()
        setTotal()
    }

    function setRowNumbers() {
        let elements = $('#detailList tbody tr td:nth-child(1)')

        elements.each((index, element) => {
            $(element).text(index + 1)
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
                    showDialog(error.statusText)
                }
            })
        }
    }

    function initLookup() {

        $('.pelanggan-lookup').lookup({
            title: 'Pelanggan Lookup',
            fileName: 'pelanggan',
            onSelectRow: (pelanggan, element) => {
                $('#crudForm [name=pelanggan_id]').first().val(pelanggan.id)
                element.val(pelanggan.namapelanggan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="pelanggan_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })

        $('.cabang-lookup').lookup({
            title: 'Cabang Lookup',
            fileName: 'cabang',
            onSelectRow: (cabang, element) => {
                $('#crudForm [name=cabang_id]').first().val(cabang.id)
                element.val(cabang.namacabang)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="cabang_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })

        $('.bank-lookup').lookup({
            title: 'Bank Lookup',
            fileName: 'bank',
            beforeProcess: function(test) {
                this.postData = {
                    filters: JSON.stringify({
                        "groupOp": "AND",
                        "rules": [{
                            "field": "tipe",
                            "op": "cn",
                            "data": type
                        }]
                    })
                }
            },
            onSelectRow: (bank, element) => {
                $('#crudForm [name=bank_id]').first().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="bank_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()