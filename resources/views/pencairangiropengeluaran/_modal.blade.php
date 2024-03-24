<div class="modal fade" id="tglJatuhTempoModal" tabindex="-1" aria-labelledby="tglJatuhTempoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="crudFormTgl">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="tglJatuhTempoModalLabel">Pilih tanggal</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">

                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label class="col-form-label">TGL JATUH TEMPO</label>
                            </div>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="text" name="tgljatuhtempo" class="form-control datepicker" id="tgljatuhtempo" autofocus>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnSubmitTglJatuhTempo" class="btn btn-primary">
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
    let modalBody = $('#tglJatuhTempoModal').find('.modal-body').html()
    let isEditTgl

    $(document).ready(function() {
        $('#btnSubmitTglJatuhTempo').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let data = []
            data.push({
                name: 'tgljatuhtempo',
                value: $(`#tgljatuhtempo`).val()
            })

            data.push({
                name: 'periode',
                value: form.find(`[name="periode"]`).val()
            })
            data.push({
                name: 'status',
                value: $('#status').find(":selected").val()
            })

            let nobuktiSelected = [];
            $.each(selectedRows, function(index, item) {
                nobuktiSelected.push($(`#jqGrid tr#${item}`).find(`td[aria-describedby="jqGrid_pengeluaran_nobukti"]`).text())
            });
            let requestDataForTgl = {
                'nobukti': nobuktiSelected,
            };

            data.push({
                name: 'jumlahdetail',
                value: selectedRows.length
            })
            data.push({
                name: 'detail',
                value: JSON.stringify(requestDataForTgl)
            })


            $(this).attr('disabled', '')
            $('#processingLoader').removeClass('d-none')
            $.ajax({
                url: `${apiUrl}pencairangiropengeluaranheader/updateTgl`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {
                    
                    $('#tglJatuhTempoModal').modal('hide')
                    selectedRows = []
                    $('#jqGrid').jqGrid('setGridParam', {
                        postData: {
                            periode: $('#crudForm').find('[name=periode]').val(),
                            status: $('#status').find(":selected").val(),
                            proses: 'reload'
                        },
                    }).trigger('reloadGrid');
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()
                },
                error: error => {

                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        $('#crudForm').find('[name=periode]').val(data.periode)
                        setErrorMessages(form, error.responseJSON.errors);
                    } else {
                        showDialog(error.responseJSON)
                    }
                    $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
                },
            }).always(() => {
                $('#processingLoader').addClass('d-none')
                $(this).removeAttr('disabled')
            })
        })
    })

    $('#tglJatuhTempoModal').on('shown.bs.modal', () => {
        let form = $('#crudFormTgl')

        setFormBindKeys(form)

        activeGrid = null
        initDatepicker()
    })

    $('#tglJatuhTempoModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'

        $('#tglJatuhTempoModal').find('.modal-body').html(modalBody)
        // initDatepicker('datepickerIndex')
    })
</script>
@endpush()