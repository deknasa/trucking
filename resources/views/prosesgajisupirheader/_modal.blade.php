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
                            <div class="col-12 col-md-2 col-form-label">
                                <label>
                                NO BUKTI <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="text" name="nobukti" class="form-control" readonly>
                            </div>

                            <div class="col-12 col-md-2 col-form-label">
                                <label>
                                TANGGAL BUKTI <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="text" name="tglbukti" class="form-control datepicker">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-md-2 col-form-label">
                            <label>
                                KETERANGAN <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-10">
                            <input type="text" name="keterangan" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2 col-form-label">
                            <label>
                                PERIODE <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-10">
                            <input type="text" name="periode" class="form-control datepicker">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-md-2 col-form-label">
                                <label>
                                TGL DARI <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="text" name="tgldari" class="form-control datepicker">
                            </div>

                            <div class="col-12 col-md-2 col-form-label">
                                <label>
                                TANGGAL SAMPAI <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="text" name="tglsampai" class="form-control datepicker">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 col-md-2 ">
                                <button class="btn btn-secondary" id="btnTampil">TAMPIL</button>
                            </div>
                        </div>
                        

                        <div class="col-12 col-md-12 mt-5" style="overflow-x:scroll">
                            <table class="table table-bindkeys" id="ricList">
                                <thead class="table-secondary">
                                    <th></th>
                                    <th>RIC</th>
                                    <th>TGL BUKTI</th>
                                    <th>SUPIR</th>
                                    <th>KETERANGAN</th>
                                    <th>TGL DARI</th>
                                    <th>TGL SAMPAI</th>
                                    <th>TOTAL</th>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7"></td>
                                        <td><p id="total" class="text-right font-weight-bold"></p></td>
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
                        <button id="btnBatal" class="btn btn-secondary" data-dismiss="modal">
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

    $(document).ready(function() {

        $('#btnSubmit').click(function(event) {

            let method
            let url
            let form = $('#crudForm')


            event.preventDefault()

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

            console.log(data);

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}gajisupirheader`
                    break;
                // case 'edit':
                //     method = 'PATCH'
                //     url = `${apiUrl}gajisupirheader/${Id}`
                //     break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}gajisupirheader/${Id}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}gajisupirheader`
                    break;
            }

            $(this).attr('disabled', '')
            $('#loader').removeClass('d-none')

            if(action == 'edit') {
                $.ajax({
                    url: `${apiUrl}gajisupirheader/noEdit`,
                    method: 'POST',
                    dataType: 'JSON',
                    beforeSend: request => {
                    request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
                    },
                    success: response => {
                    
                        showDialog(response.message)
                    }
                }).always(() => {
                    $('#loader').addClass('d-none')
                    $(this).removeAttr('disabled')
                })
  
            }else{
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

            }
            
        })
    })

    $('#crudModal').on('shown.bs.modal', () => {
        let form = $('#crudForm')

        setFormBindKeys(form)

        activeGrid = null

        getMaxLength(form)
        initDatepicker()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'

        $('#crudModal').find('.modal-body').html(modalBody)
    })

   



    function createProsesGajiSupirHeader() {
        let form = $('#crudForm')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Simpan
        `)

        form.data('action', 'add')
        $('#crudModalTitle').text('Add Proses Gaji Supir')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        initDatepicker()
        // form.find(`[name="subtotal"]`).addClass('disabled')
    }

    function editGajiSupirHeader(Id) {
        let form = $('#crudForm')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Simpan
        `)
        $('#crudModalTitle').text('Edit Rincian Gaji Supir')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        showGajiSupir(form, Id, 'edit')
        form.find('#btnTampil').prop('disabled', true)
    }

    function deleteGajiSupirHeader(Id) {
        let form = $('#crudForm')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Hapus
        `)
        $('#crudModalTitle').text('Delete Rincian Gaji Supir')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        showGajiSupir(form, Id, 'delete')
        form.find('#btnTampil').prop('disabled', true)

    }

    function showGajiSupir(form, gajiId, aksi) {
        $.ajax({
            url: `${apiUrl}gajisupirheader/${gajiId}`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: response => {
                $.each(response.data, (index, value) => {
                    let element = form.find(`[name="${index}"]`)

                    form.find(`[name="${index}"]`).val(value)

                    if (element.hasClass('datepicker')) {
                        element.val(dateFormat(value))
                    }

                })

               
                form.find('[name]').addClass('disabled')
                initDisabled()
                initAutoNumeric(form.find(`[name="subtotal"]`))
                initAutoNumeric(form.find(`[name="uangmakanharian"]`))
                initAutoNumeric(form.find(`[name="deposito"]`))
                initAutoNumeric(form.find(`[name="pinjamanpribadi"]`))
                initAutoNumeric(form.find(`[name="potonganpinjaman"]`))
                initAutoNumeric(form.find(`[name="potonganpinjamansemua"]`))
                initAutoNumeric(form.find(`[name="bbm"]`))
                initAutoNumeric(form.find(`[name="gajiminus"]`))
                initAutoNumeric(form.find(`[name="total"]`))
                getEditTrip(gajiId, aksi)
            }
        })
    }

    $(document).on('click', '#btnTampil', function(event) {
        event.preventDefault()
        let form = $('#crudForm')
        let data = []
        let tglDari = form.find(`[name="tgldari"]`).val()
        let tglSampai = form.find(`[name="tglsampai"]`).val()
      
        $('#ricList tbody').html('')

        $.ajax({
            url: `${apiUrl}prosesgajisupirheader/getRic/${tglDari}/${tglSampai}`,
            method: 'GET',
            dataType: 'JSON',
            data: data,
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: response => {

                if(response.errors == true) {
                    showDialog(response.message)
                }else{
                    let total = 0
                    $.each(response.data, (index, detail) => {
                    
                        total = parseFloat(total) + parseFloat(detail.total)

                        let detailRow = $(`
                            <tr >
                                <td width="1%" onclick="select(this)"><input name='ric_id[]' type="checkbox" class="checkItem" value="${detail.id}" checked></td>
                                <td width="13%">${detail.nobukti}</td>
                                <td width="10%">${detail.tglbukti}</td>
                                <td width="10%">${detail.namasupir}</td>
                                <td width="10%">${detail.keterangan}</td>
                                <td width="10%">${detail.tgldari}</td>
                                <td width="10%">${detail.tglsampai}</td>
                                <td width="10%" class="total text-right">${detail.total}</td>
                            </tr>
                        `)

                        $('#ricList tbody').append(detailRow)
                        initAutoNumeric(detailRow.find('.total'))
                    })
                    
                    $('#total').append(`${total}`)

                    initAutoNumeric($('#ricList tfoot').find('#total'))

                }
            }
        })

    })

   
    function getEditTrip(gajiId, aksi) {
        $('#gajiSupir').html('')
        $('#gajiKenek').html('')
        $.ajax({
            url: `${apiUrl}gajisupirheader/${gajiId}/getEditTrip`,
            method: 'GET',
            dataType: 'JSON',
            data: {
                limit: 0
            },
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: response => {
            
                let gajiSupir = 0
                let gajiKenek = 0
                $.each(response.data, (index, detail) => {
                    gajiSupir = parseFloat(gajiSupir) + parseFloat(detail.gajisupir)
                    gajiKenek = parseFloat(gajiKenek) + parseFloat(detail.gajikenek)

                    let detailRow = $(`
                        <tr >
                            <td width="5%"><input name='sp_id[]' type="checkbox" id="checkItem" value="${detail.id}" checked disabled></td>
                            <td width="13%">${detail.nobukti}</td>
                            <td width="10%">${detail.tglbukti}</td>
                            <td width="10%">${detail.trado}</td>
                            <td width="10%">${detail.dari}</td>
                            <td width="10%">${detail.sampai}</td>
                            <td width="10%">${detail.nocont}</td>
                            <td width="10%">${detail.nosp}</td>
                            <td width="10%" class="gajiSupir">${detail.gajisupir}</td>
                            <td width="10%" class="gajiKenek">${detail.gajikenek}</td>
                        </tr>
                    `)

                    $('#tripList tbody').append(detailRow)
                    initAutoNumeric(detailRow.find('.gajiSupir'))
                    initAutoNumeric(detailRow.find('.gajiKenek'))
                })
                $('#gajiSupir').append(`${gajiSupir}`)
                $('#gajiKenek').append(`${gajiKenek}`)

                let subTotal = gajiSupir+gajiKenek
                $('#crudForm').find(`[name="subtotal"]`).val(subTotal)
                initAutoNumeric($('#crudForm').find(`[name="subtotal"]`))

                initAutoNumeric($('#tripList tfoot').find('#gajiSupir'))
                initAutoNumeric($('#tripList tfoot').find('#gajiKenek'))

            }
        })
    }

    function select(element) {

        var is_checked = $(element).find(`[name="sp_id[]"]`).is(":checked");

        let gajiSupir = $(element).siblings('td.gajiSupir').text()
        let gjs =  parseFloat(gajiSupir.replaceAll(',',''));

        let totalSupir = $('#gajiSupir').text()
        let ttlSupir = parseFloat(totalSupir.replaceAll(',',''));

        let gajiKenek = $(element).siblings('td.gajiKenek').text()
        let gjk =  parseFloat(gajiKenek.replaceAll(',',''));

        let totalKenek = $('#gajiKenek').text()
        let ttlKenek = parseFloat(totalKenek.replaceAll(',',''));

    
        let total = 0
        let subTotal = 0
        let uangMakan = $('#crudForm').find(`[name="uangmakanharian"]`).val()
        uangMakan = parseFloat(uangMakan.replaceAll(',',''));

        let finalSupir = 0
        let finalKenek = 0
        if(!is_checked) { 

            finalSupir = ttlSupir - gjs;
            finalKenek = ttlKenek - gjk;

            $('#gajiSupir').html('')
            $('#gajiSupir').append(`${finalSupir}`)
            $('#gajiKenek').html('')
            $('#gajiKenek').append(`${finalKenek}`)

            subTotal = finalSupir+finalKenek
            if(uangMakan) {
                total = subTotal + uangMakan
            }else{
                total = subTotal
            }
            console.log(is_checked)
        }else{
       
            finalSupir = ttlSupir + gjs;
            finalKenek = ttlKenek + gjk;
            $('#gajiSupir').html('')
            $('#gajiSupir').append(`${finalSupir}`)
            $('#gajiKenek').html('')
            $('#gajiKenek').append(`${finalKenek}`)

        
            subTotal = finalSupir+finalKenek
            if(uangMakan) {
                total = subTotal + uangMakan
            }else{
                total = subTotal
            }
            console.log(is_checked)
            // $(element).find(`[name="sp_id[]"]`).prop("checked", false);
        }
      
        initAutoNumeric($('#tripList tfoot').find('#gajiSupir'))
        initAutoNumeric($('#tripList tfoot').find('#gajiKenek'))

        $('#crudForm').find(`[name="subtotal"]`).val(subTotal)
        initAutoNumeric($('#crudForm').find(`[name="subtotal"]`))

        $('#crudForm').find(`[name="total"]`).val(total)
        initAutoNumeric($('#crudForm').find(`[name="total"]`))
    }

    function setRowNumbers() {
        let elements = $('#detailList tbody tr td:nth-child(2)')

        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }

    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
        console.log($('#crudForm input:checkbox').find(`[name="sp_id[]"]`).val())
    });
    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
            $.ajax({
                url: `${apiUrl}gajisupirheader/field_length`,
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


</script>
@endpush()