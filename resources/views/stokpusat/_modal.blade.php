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

                        <input type="hidden" name="id" class="form-control">
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Nama Pusat <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="namastok" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Kelompok <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="kelompok_id">
                                <input type="text" name="kelompok" id="kelompok" class="form-control kelompok-lookup">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-12">
                                <button class="btn btn-primary" type="button" id="btnTampil"><i class="fas fa-sync"></i>
                                    FILTER</button>
                            </div>
                        </div>
                        <div class="row form-group mt-5">
                            <div class="card col-md-6">
                                <div class="card-body">
                                    <span class="textCard"> Data Stok Medan</span>
                                    <div class="row">
                                        <div class="col-md-3" id="imageMdn">
                                            <div>
                                                <img id="imgMedan" style="border: 1px solid #00000096; width:135px; height:150px">
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <table id="tableMedan"></table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-md-6">
                                <div class="card-body">
                                    <span class="textCard"> Data Stok Surabaya</span>
                                    <div class="row">
                                        <div class="col-md-3" id="imageMdn">
                                            <div>
                                                <img id="imgSby" style="border: 1px solid #00000096; width:135px; height:150px">
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <table id="tableSby"></table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group mt-4">
                            <div class="card col-md-6">
                                <div class="card-body">
                                    <span class="textCard"> Data Stok Jakarta</span>
                                    <div class="row">
                                        <div class="col-md-3" id="imageMdn">
                                            <div>
                                                <img id="imgJkt" style="border: 1px solid #00000096; width:135px; height:150px">
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <table id="tableJkt"></table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-md-6">
                                <div class="card-body">
                                    <span class="textCard"> Data Stok Jakarta TNL</span>
                                    <div class="row">
                                        <div class="col-md-3" id="imageMdn">
                                            <div>
                                                <img id="imgJktTnl" style="border: 1px solid #00000096; width:135px; height:150px">
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <table id="tableJktTnl"></table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row form-group mt-4">

                            <div class="card col-md-6">
                                <div class="card-body">
                                    <span class="textCard"> Data Stok Makassar</span>
                                    <div class="row">
                                        <div class="col-md-3" id="imageMdn">
                                            <div>
                                                <img id="imgMks" style="border: 1px solid #00000096; width:135px; height:150px">
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <table id="tableMks"></table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-md-6">
                                <div class="card-body">
                                    <span class="textCard"> Data Stok Bitung</span>
                                    <div class="row">
                                        <div class="col-md-3" id="imageMdn">
                                            <div>
                                                <img id="imgBtg" style="border: 1px solid #00000096; width:135px; height:150px">
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <table id="tableBtg"></table>
                                        </div>
                                    </div>
                                </div>
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
    let jumlahRow = 0;
    let kelompokId
    let sortnameMdn = 'FKStck';
    let sortorderMdn = 'asc';
    let pageMdn = 0;
    let totalRecordMdn
    let limitMdn
    let postDataMdn
    let triggerClickMdn
    let indexRowMdn
    let selectedRowsMdn = []
    let selectedGbrMdn
    let selectedNamaMdn

    let sortnameJkt = 'namastok';
    let sortorderJkt = 'asc';
    let pageJkt = 0;
    let totalRecordJkt
    let limitJkt
    let postDataJkt
    let triggerClickJkt
    let indexRowJkt
    let selectedRowsJkt = []
    let selectedGbrJkt
    let selectedNamaJkt

    let sortnameJktTnl = 'namastok';
    let sortorderJktTnl = 'asc';
    let pageJktTnl = 0;
    let totalRecordJktTnl
    let limitJktTnl
    let postDataJktTnl
    let triggerClickJktTnl
    let indexRowJktTnl
    let selectedRowsJktTnl = []
    let selectedGbrJktTnl
    let selectedNamaJktTnl

    let sortnameSby = 'FKStck';
    let sortorderSby = 'asc';
    let pageSby = 0;
    let totalRecordSby
    let limitSby
    let postDataSby
    let triggerClickSby
    let indexRowSby
    let selectedRowsSby = []
    let selectedGbrSby
    let selectedNamaSby

    let sortnameMks = 'FKStck';
    let sortorderMks = 'asc';
    let pageMks = 0;
    let totalRecordMks
    let limitMks
    let postDataMks
    let triggerClickMks
    let indexRowMks
    let selectedRowsMks = []
    let selectedGbrMks
    let selectedNamaMks

    let sortnameBtg = 'FKStck';
    let sortorderBtg = 'asc';
    let pageBtg = 0;
    let totalRecordBtg
    let limitBtg
    let postDataBtg
    let triggerClickBtg
    let indexRowBtg
    let selectedRowsBtg = []
    let selectedGbrBtg
    let selectedNamaBtg



    $(document).ready(function() {

        $(document).on('click', '#btnTampil', function(event) {
            event.preventDefault()
            $('#tableMedan')
                .jqGrid('setGridParam', {
                    url: `${apiUrl}stokpusat/datamdn`,
                    mtype: "GET",
                    datatype: "json",
                    postData: {
                        kelompok_id: kelompokId,
                        aktif: "AKTIF",
                    },
                    loadError: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status == 500) {
                            showDialog("SERVER MEDAN TIDAK BISA DIAKSES")
                        }
                    },
                    loadBeforeSend: function(jqXHR) {
                        jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
                    },
                }).trigger('reloadGrid');
            $('#tableMks')
                .jqGrid('setGridParam', {
                    url: `${apiUrl}stokpusat/datamks`,
                    mtype: "GET",
                    datatype: "json",
                    postData: {
                        kelompok_id: kelompokId,
                        aktif: "AKTIF",
                    },
                    loadError: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status == 500) {
                            showDialog("SERVER MAKASSAR TIDAK BISA DIAKSES")
                        }
                    },
                    loadBeforeSend: function(jqXHR) {
                        jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
                    },
                }).trigger('reloadGrid');
            $('#tableSby')
                .jqGrid('setGridParam', {
                    url: `${apiUrl}stokpusat/datasby`,
                    mtype: "GET",
                    datatype: "json",
                    postData: {
                        kelompok_id: kelompokId,
                        aktif: "AKTIF",
                    },
                    loadError: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status == 500) {
                            showDialog("SERVER SURABAYA TIDAK BISA DIAKSES")
                        }
                    },
                    loadBeforeSend: function(jqXHR) {
                        jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
                    },
                }).trigger('reloadGrid');
            $('#tableBtg')
                .jqGrid('setGridParam', {
                    url: `${apiUrl}stokpusat/datamnd`,
                    mtype: "GET",
                    datatype: "json",
                    postData: {
                        kelompok_id: kelompokId,
                        aktif: "AKTIF",
                    },
                    loadError: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status == 500) {
                            showDialog("SERVER BITUNG TIDAK BISA DIAKSES")
                        }
                    },
                    loadBeforeSend: function(jqXHR) {
                        jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
                    },
                }).trigger('reloadGrid');


            if (accessTokenJkt == '') {

                $.ajax({
                    url: `${apiUrl}stokpusat/datajkt`,
                    method: "GET",
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    success: response => {

                        $.ajax({
                            url: `${appUrl}/stokpusat/tokenjkt?token=${response.data}`,
                            method: "GET",
                            dataType: 'JSON',
                            headers: {
                                Authorization: `Bearer ${accessToken}`
                            },
                            success: response => {

                                accessTokenJkt = response.data
                                $('#tableJkt')
                                    .jqGrid('setGridParam', {
                                        url: `${apiTruckingJktUrl}stok`,
                                        mtype: "GET",
                                        datatype: "json",
                                        postData: {
                                            kelompok_id: kelompokId,
                                            aktif: "AKTIF",
                                        },
                                        loadBeforeSend: function(jqXHR) {
                                            jqXHR.setRequestHeader('Authorization', `Bearer ${response.data}`)
                                        },
                                    }).trigger('reloadGrid');
                            }
                        })


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
                })

            } else {
                $('#tableJkt')
                    .jqGrid('setGridParam', {
                        url: `${apiTruckingJktUrl}stok`,
                        mtype: "GET",
                        datatype: "json",
                        postData: {
                            kelompok_id: kelompokId,
                            aktif: "AKTIF",
                        },
                        loadBeforeSend: function(jqXHR) {
                            jqXHR.setRequestHeader('Authorization', `Bearer ${accessTokenJkt}`)
                        },
                    }).trigger('reloadGrid');
            }



            if (accessTokenJktTnl == '') {
                $.ajax({
                    url: `${apiUrl}stokpusat/datajkttnl`,
                    method: "GET",
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    success: response => {
                        $.ajax({
                            url: `${appUrl}/stokpusat/tokenjkttnl?token=${response.data}`,
                            method: "GET",
                            dataType: 'JSON',
                            headers: {
                                Authorization: `Bearer ${accessToken}`
                            },
                            success: response => {

                                accessTokenJktTnl = response.data
                                $('#tableJktTnl')
                                    .jqGrid('setGridParam', {
                                        url: `${apiTruckingJktTnlUrl}stok`,
                                        mtype: "GET",
                                        datatype: "json",
                                        postData: {
                                            kelompok_id: kelompokId,
                                            aktif: "AKTIF",
                                        },
                                        loadBeforeSend: function(jqXHR) {
                                            jqXHR.setRequestHeader('Authorization', `Bearer ${response.data}`)
                                        },
                                    }).trigger('reloadGrid');
                            }
                        })
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
                })
            } else {
                $('#tableJktTnl')
                    .jqGrid('setGridParam', {
                        url: `${apiTruckingJktTnlUrl}stok`,
                        mtype: "GET",
                        datatype: "json",
                        postData: {
                            kelompok_id: kelompokId,
                            aktif: "AKTIF",
                        },
                        loadBeforeSend: function(jqXHR) {
                            jqXHR.setRequestHeader('Authorization', `Bearer ${accessTokenJktTnl}`)
                        },
                    }).trigger('reloadGrid');
            }
        })

        $('#btnSubmit').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let stokPusatId = form.find('[name=id]').val()
            let action = form.data('action')
            let data = []

            data.push({
                name: 'id',
                value: form.find(`[name="id"]`).val()
            })
            data.push({
                name: 'namastok',
                value: form.find(`[name="namastok"]`).val()
            })
            data.push({
                name: 'kelompok',
                value: form.find(`[name="kelompok"]`).val()
            })
            data.push({
                name: 'kelompok_id',
                value: form.find(`[name="kelompok_id"]`).val()
            })
            data.push({
                name: 'jumlahRow',
                value: jumlahRow
            })

            if (selectedRowsMdn.length > 0) {
                data.push({
                    name: 'stok_idmdn',
                    value: selectedRowsMdn[0]
                })
                data.push({
                    name: 'namastokmdn',
                    value: selectedNamaMdn
                })
                data.push({
                    name: 'gambarmdn',
                    value: selectedGbrMdn
                })
            }

            if (selectedRowsJkt.length > 0) {
                data.push({
                    name: 'stok_idjkt',
                    value: selectedRowsJkt[0]
                })
                data.push({
                    name: 'namastokjkt',
                    value: selectedNamaJkt
                })
                data.push({
                    name: 'gambarjkt',
                    value: selectedGbrJkt
                })
            }

            if (selectedRowsJktTnl.length > 0) {
                data.push({
                    name: 'stok_idjkttnl',
                    value: selectedRowsJktTnl[0]
                })
                data.push({
                    name: 'namastokjkttnl',
                    value: selectedNamaJktTnl
                })
                data.push({
                    name: 'gambarjkttnl',
                    value: selectedGbrJktTnl
                })
            }

            if (selectedRowsMks.length > 0) {
                data.push({
                    name: 'stok_idmks',
                    value: selectedRowsMks[0]
                })
                data.push({
                    name: 'namastokmks',
                    value: selectedNamaMks
                })
                data.push({
                    name: 'gambarmks',
                    value: selectedGbrMks
                })
            }

            if (selectedRowsSby.length > 0) {
                data.push({
                    name: 'stok_idsby',
                    value: selectedRowsSby[0]
                })
                data.push({
                    name: 'namastoksby',
                    value: selectedNamaSby
                })
                data.push({
                    name: 'gambarsby',
                    value: selectedGbrSby
                })
            }

            if (selectedRowsBtg.length > 0) {
                data.push({
                    name: 'stok_idbtg',
                    value: selectedRowsBtg[0]
                })
                data.push({
                    name: 'namastokbtg',
                    value: selectedNamaBtg
                })
                data.push({
                    name: 'gambarbtg',
                    value: selectedGbrBtg
                })
            }

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
                    url = `${apiUrl}stokpusat`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}stokpusat/${stokPusatId}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}stokpusat/${stokPusatId}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}stokpusat`
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
                    $('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')

                    id = response.data.id
                    clearSelectedRows()

                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page,
                        postData: {
                            proses: 'reload',
                        }
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

        activeGrid = null

        initLookup()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'

        $('#crudModal').find('.modal-body').html(modalBody)
        clearSelectedRows()
    })

    function createStokPusat() {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
        `)
        form.data('action', 'add')
        $('#crudModal').modal('show')
        form.find(`.sometimes`).show()
        $('#crudModalTitle').text('Add Stok Pusat')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        $('.modal-loader').addClass('d-none')
        loadGridMedan()
        loadGridJakarta()
        loadGridJakartaTNL()
        loadGridMakassar()
        loadGridSurabaya()
        loadGridBitung()
    }

    function editStokPusat(Id) {
        let form = $('#crudForm')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
        `)
        $('#crudModalTitle').text('Edit Stok Pusat')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showStokPusat(form, Id, 'edit')
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

    function deleteStokPusat(Id) {
        let form = $('#crudForm')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-trash"></i>
            Delete
        `)
        $('#btnTampil').prop('disabled', true)
        $('#crudModalTitle').text('Delete Stok Pusat')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showStokPusat(form, Id, 'delete')
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

    function showStokPusat(form, Id, aksi) {

        $.ajax({
            url: `${apiUrl}stokpusat/${Id}`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: response => {
                $.each(response.data, (index, value) => {
                    let element = form.find(`[name="${index}"]`)

                    form.find(`[name="${index}"]`).val(value)
                    if (index == 'kelompok') {
                        element.data('current-value', value)
                    }
                })
                kelompokId = response.data.kelompok_id

                loadGridMedan()
                if (response.mdn != null) {
                    selectedRowsMdn.push(response.mdn.stok_id)
                    selectedGbrMdn = response.mdn.gambar
                    selectedNamaMdn = response.mdn.namastok
                    if (selectedGbrMdn != '') {
                        selectedGbrMdn = JSON.parse(response.mdn.gambar)[0]
                        $('#imgMedan').attr('src', `${apiUrl}stokpusat/mdn/${JSON.parse(response.mdn.gambar)[0]}/gambar`);
                    }
                    jumlahRow++
                }

                $('#tableMedan').jqGrid("clearGridData");
                $('#tableMedan')
                    .jqGrid('setGridParam', {
                        url: `${apiUrl}stokpusat/datamdn`,
                        mtype: "GET",
                        datatype: "json",
                        postData: {
                            kelompok_id: kelompokId,
                            aktif: "AKTIF",
                        },
                        loadBeforeSend: function(jqXHR) {
                            jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
                        },
                    }).trigger('reloadGrid');

                loadGridSurabaya()
                if (response.sby != null) {
                    selectedRowsSby.push(response.sby.stok_id)
                    selectedGbrSby = response.sby.gambar
                    selectedNamaSby = response.sby.namastok
                    if (selectedGbrSby != '') {
                        selectedGbrSby = JSON.parse(response.sby.gambar)[0]
                        $('#imgSby').attr('src', `${apiUrl}stokpusat/sby/${JSON.parse(response.sby.gambar)[0]}/gambar`);
                    }

                    jumlahRow++
                }

                $('#tableSby').jqGrid("clearGridData");
                $('#tableSby')
                    .jqGrid('setGridParam', {
                        url: `${apiUrl}stokpusat/datasby`,
                        mtype: "GET",
                        datatype: "json",
                        postData: {
                            kelompok_id: kelompokId,
                            aktif: "AKTIF",
                        },
                        loadBeforeSend: function(jqXHR) {
                            jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
                        },
                    }).trigger('reloadGrid');

                loadGridJakarta()
                if (response.jkt != null) {
                    selectedRowsJkt.push(response.jkt.stok_id)
                    selectedGbrJkt = response.jkt.gambar
                    selectedNamaJkt = response.jkt.namastok
                    if (selectedGbrJkt != '') {
                        selectedGbrJkt = JSON.parse(response.jkt.gambar)[0]
                        $('#imgJkt').attr('src', `${apiUrl}stokpusat/jkt/${JSON.parse(response.jkt.gambar)[0]}/gambar`);
                    }
                    jumlahRow++
                }

                $('#tableJkt').jqGrid("clearGridData");
                if (accessTokenJkt == '') {

                    $.ajax({
                        url: `${apiUrl}stokpusat/datajkt`,
                        method: "GET",
                        dataType: 'JSON',
                        headers: {
                            Authorization: `Bearer ${accessToken}`
                        },
                        success: response => {

                            $.ajax({
                                url: `${appUrl}/stokpusat/tokenjkt?token=${response.data}`,
                                method: "GET",
                                dataType: 'JSON',
                                headers: {
                                    Authorization: `Bearer ${accessToken}`
                                },
                                success: response => {

                                    accessTokenJkt = response.data
                                    $('#tableJkt')
                                        .jqGrid('setGridParam', {
                                            url: `${apiTruckingJktUrl}stok`,
                                            mtype: "GET",
                                            datatype: "json",
                                            postData: {
                                                kelompok_id: kelompokId,
                                                aktif: "AKTIF",
                                            },
                                            loadBeforeSend: function(jqXHR) {
                                                jqXHR.setRequestHeader('Authorization', `Bearer ${response.data}`)
                                            },
                                        }).trigger('reloadGrid');
                                }
                            })


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
                    })

                } else {
                    $('#tableJkt')
                        .jqGrid('setGridParam', {
                            url: `${apiTruckingJktUrl}stok`,
                            mtype: "GET",
                            datatype: "json",
                            postData: {
                                kelompok_id: kelompokId,
                                aktif: "AKTIF",
                            },
                            loadBeforeSend: function(jqXHR) {
                                jqXHR.setRequestHeader('Authorization', `Bearer ${accessTokenJkt}`)
                            },
                        }).trigger('reloadGrid');
                }

                loadGridJakartaTNL()
                if (response.tnl != null) {
                    selectedRowsJktTnl.push(response.tnl.stok_id)
                    selectedGbrJktTnl = response.tnl.gambar
                    selectedNamaJktTnl = response.tnl.namastok
                    if (selectedGbrJktTnl != '') {
                        selectedGbrJktTnl = JSON.parse(response.tnl.gambar)[0]
                        $('#imgJktTnl').attr('src', `${apiUrl}stokpusat/jkttnl/${JSON.parse(response.tnl.gambar)[0]}/gambar`);
                    }
                    jumlahRow++
                }

                $('#tableJktTnl').jqGrid("clearGridData");

                if (accessTokenJktTnl == '') {
                    $.ajax({
                        url: `${apiUrl}stokpusat/datajkttnl`,
                        method: "GET",
                        dataType: 'JSON',
                        headers: {
                            Authorization: `Bearer ${accessToken}`
                        },
                        success: response => {
                            $.ajax({
                                url: `${appUrl}/stokpusat/tokenjkttnl?token=${response.data}`,
                                method: "GET",
                                dataType: 'JSON',
                                headers: {
                                    Authorization: `Bearer ${accessToken}`
                                },
                                success: response => {

                                    accessTokenJktTnl = response.data
                                    $('#tableJktTnl')
                                        .jqGrid('setGridParam', {
                                            url: `${apiTruckingJktTnlUrl}stok`,
                                            mtype: "GET",
                                            datatype: "json",
                                            postData: {
                                                kelompok_id: kelompokId,
                                                aktif: "AKTIF",
                                            },
                                            loadBeforeSend: function(jqXHR) {
                                                jqXHR.setRequestHeader('Authorization', `Bearer ${response.data}`)
                                            },
                                        }).trigger('reloadGrid');
                                }
                            })
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
                    })
                } else {
                    $('#tableJktTnl')
                        .jqGrid('setGridParam', {
                            url: `${apiTruckingJktTnlUrl}stok`,
                            mtype: "GET",
                            datatype: "json",
                            postData: {
                                kelompok_id: kelompokId,
                                aktif: "AKTIF",
                            },
                            loadBeforeSend: function(jqXHR) {
                                jqXHR.setRequestHeader('Authorization', `Bearer ${accessTokenJktTnl}`)
                            },
                        }).trigger('reloadGrid');
                }

                loadGridMakassar()
                if (response.mks != null) {
                    selectedRowsMks.push(response.mks.stok_id)
                    selectedGbrMks = response.mks.gambar
                    selectedNamaMks = response.mks.namastok
                    if (selectedGbrMks != '') {
                        selectedGbrMks = JSON.parse(response.mks.gambar)[0]
                        console.log(selectedGbrMks)
                        $('#imgMks').attr('src', `${apiUrl}stokpusat/mks/${JSON.parse(response.mks.gambar)[0]}/gambar`);
                    }

                    jumlahRow++
                }

                $('#tableMks').jqGrid("clearGridData");
                $('#tableMks')
                    .jqGrid('setGridParam', {
                        url: `${apiUrl}stokpusat/datamks`,
                        mtype: "GET",
                        datatype: "json",
                        postData: {
                            kelompok_id: kelompokId,
                            aktif: "AKTIF",
                        },
                        loadBeforeSend: function(jqXHR) {
                            jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
                        },
                    }).trigger('reloadGrid');

                loadGridBitung()
                if (response.btg != null) {
                    selectedRowsBtg.push(response.btg.stok_id)
                    selectedGbrBtg = response.btg.gambar
                    selectedNamaBtg = response.btg.namastok
                    if (selectedGbrBtg != '') {
                        selectedGbrBtg = JSON.parse(response.btg.gambar)[0]
                        $('#imgBtg').attr('src', `${apiUrl}stokpusat/btg/${JSON.parse(response.btg.gambar)[0]}/gambar`);
                    }
                    jumlahRow++

                }

                $('#tableBtg').jqGrid("clearGridData");
                $('#tableBtg')
                    .jqGrid('setGridParam', {
                        url: `${apiUrl}stokpusat/datamnd`,
                        mtype: "GET",
                        datatype: "json",
                        postData: {
                            kelompok_id: kelompokId,
                            aktif: "AKTIF",
                        },
                        loadBeforeSend: function(jqXHR) {
                            jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
                        },
                    }).trigger('reloadGrid');


                if (aksi == 'delete') {

                    form.find('[name]').addClass('disabled')
                    initDisabled()
                }

            }
        })
    }

    function loadGridMedan() {
        $("#tableMedan").jqGrid({
                datatype: "local",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                colModel: [{
                        label: 'Pilih',
                        name: 'pilih',
                        width: 70,
                        align: 'center',
                        sortable: false,
                        clear: false,
                        stype: 'input',
                        search: false,
                        formatter: (value, rowOptions, rowData) => {
                            return `<input type="checkbox" name="stokmdn_id[]" value="${rowData.id}" onchange="checkboxHandler(this)">`
                        },
                    }, {
                        label: 'Gambar',
                        name: 'gambar',
                        width: 70,
                        align: 'center',
                        sortable: false,
                        clear: false,
                        stype: 'input',
                        search: false,
                        formatter: (value, rowOptions, rowData) => {
                            if (rowData.gambar == '') {
                                return `<input type="checkbox" name="stokmdn_gbr[]" value="${rowData.gambar}" disabled>`
                            } else {
                                return `<input type="checkbox" name="stokmdn_gbr[]" value="${rowData.gambar}" checked disabled>`
                            }
                        },
                    },
                    {
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '50px',
                        search: false,
                    },
                    {
                        label: 'NAMA',
                        name: 'namastok',
                        align: 'left',
                        width: 200
                    },
                    {
                        label: 'sub kelompok',
                        name: 'subkelompok',
                        align: 'left'
                    }
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 200,
                rowNum: 10,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                footerrow: true,
                userDataOnFooter: true,
                toolbar: [true, "top"],
                sortable: true,
                sortname: sortnameMdn,
                sortorder: sortorderMdn,
                page: pageMdn,
                viewrecords: true,
                prmNames: {
                    sort: 'sortIndex',
                    order: 'sortOrder',
                    rows: 'limit'
                },
                jsonReader: {
                    root: 'data',
                    total: 'attributes.totalPages',
                    records: 'attributes.totalRows',
                },
                loadBeforeSend: function(jqXHR) {
                    jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

                    setGridLastRequest($(this), jqXHR)
                },

                onSelectRow: function(id) {
                    activeGrid = $(this)
                    getGambarMdn(id)
                },
                loadComplete: function(data) {
                    let grid = $(this)
                    changeJqGridRowListText()

                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    /* Set global variables */
                    sortnameMdn = $(this).jqGrid("getGridParam", "sortname")
                    sortorderMdn = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordMdn = $(this).getGridParam("records")
                    limitMdn = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataMdn = $(this).jqGrid('getGridParam', 'postData')
                    triggerClickMdn = true

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowMdn > $(this).getDataIDs().length - 1) {
                        indexRowMdn = $(this).getDataIDs().length - 1;
                    }

                    setHighlight($(this))

                    $.each(selectedRowsMdn, function(key, value) {
                        $(grid).find('tbody tr').each(function(row, tr) {
                            if ($(this).find(`td [name="stokmdn_id[]"]`).val() == value) {
                                $(this).addClass('bg-light-blue')
                                $(this).find(`td [name="stokmdn_id[]"]`).prop('checked', true)
                            }
                        })
                    });

                    $('#gsMdn').attr('disabled', false)
                }
            })

            .jqGrid("setLabel", "rn", "No.")
            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false,
                defaultSearch: 'cn',
                groupOp: 'AND',
                disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
                beforeSearch: function() {

                    clearGlobalSearch($('#tableMedan'))
                },
            })

            .customPager({})



        /* Append clear filter button */
        loadClearFilter($('#tableMedan'))

        /* Append global search */
        loadGlobalSearch($('#tableMedan'))
    }

    function loadGridJakarta() {
        $("#tableJkt").jqGrid({
                datatype: "local",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                postData: {
                    'dari': 'index'
                },
                colModel: [{
                        label: 'Pilih',
                        name: 'pilih',
                        width: 70,
                        align: 'center',
                        sortable: false,
                        clear: false,
                        stype: 'input',
                        search: false,
                        formatter: (value, rowOptions, rowData) => {
                            return `<input type="checkbox" name="stokjkt_id[]" value="${rowData.id}" onchange="checkboxHandlerJkt(this)">`
                        },
                    },
                    {
                        label: 'Gambar',
                        name: 'gambar',
                        width: 70,
                        align: 'center',
                        sortable: false,
                        clear: false,
                        stype: 'input',
                        search: false,
                        formatter: (value, rowOptions, rowData) => {
                            if (value == '') {
                                return `<input type="checkbox" name="stokjkt_gbr[]" value="${rowData.gambar}" disabled>`
                            } else {
                                return `<input type="checkbox" name="stokjkt_gbr[]" value="${JSON.parse(rowData.gambar)[0]}" checked disabled>`
                            }
                        },
                    },
                    {
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '50px',
                        search: false,
                    },
                    {
                        label: 'NAMA',
                        name: 'namastok',
                        align: 'left',
                        width: 200
                    },
                    {
                        label: 'sub kelompok',
                        name: 'subkelompok',
                        align: 'left'
                    }
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 200,
                rowNum: 10,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                footerrow: true,
                userDataOnFooter: true,
                toolbar: [true, "top"],
                sortable: true,
                sortname: sortnameJkt,
                sortorder: sortorderJkt,
                page: pageJkt,
                viewrecords: true,
                prmNames: {
                    sort: 'sortIndex',
                    order: 'sortOrder',
                    rows: 'limit'
                },
                jsonReader: {
                    root: 'data',
                    total: 'attributes.totalPages',
                    records: 'attributes.totalRows',
                },
                loadBeforeSend: function(jqXHR) {
                    jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

                    setGridLastRequest($(this), jqXHR)
                },

                onSelectRow: function(id) {
                    activeGrid = $(this)
                    getGambarJkt(id)
                },
                loadComplete: function(data) {
                    let grid = $(this)
                    changeJqGridRowListText()

                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    /* Set global variables */
                    sortnameJkt = $(this).jqGrid("getGridParam", "sortname")
                    sortorderJkt = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordJkt = $(this).getGridParam("records")
                    limitJkt = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataJkt = $(this).jqGrid('getGridParam', 'postData')
                    triggerClickJkt = true

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowJkt > $(this).getDataIDs().length - 1) {
                        indexRowJkt = $(this).getDataIDs().length - 1;
                    }

                    setHighlight($(this))

                    $.each(selectedRowsJkt, function(key, value) {
                        $(grid).find('tbody tr').each(function(row, tr) {
                            if ($(this).find(`td [name="stokjkt_id[]"]`).val() == value) {
                                $(this).addClass('bg-light-blue')
                                $(this).find(`td [name="stokjkt_id[]"]`).prop('checked', true)
                            }
                        })
                    });

                    $('#gsJkt').attr('disabled', false)
                }
            })

            .jqGrid("setLabel", "rn", "No.")
            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false,
                defaultSearch: 'cn',
                groupOp: 'AND',
                disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
                beforeSearch: function() {

                    clearGlobalSearch($('#tableJkt'))
                },
            })

            .customPager({})



        /* Append clear filter button */
        loadClearFilter($('#tableJkt'))

        /* Append global search */
        loadGlobalSearch($('#tableJkt'))
    }

    function loadGridJakartaTNL() {
        $("#tableJktTnl").jqGrid({
                datatype: "local",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                postData: {
                    'dari': 'index'
                },
                colModel: [{
                        label: 'Pilih',
                        name: 'pilih',
                        width: 70,
                        align: 'center',
                        sortable: false,
                        clear: false,
                        stype: 'input',
                        search: false,
                        formatter: (value, rowOptions, rowData) => {
                            return `<input type="checkbox" name="stokjkttnl_id[]" value="${rowData.id}" onchange="checkboxHandlerJktTnl(this)">`
                        },
                    },
                    {
                        label: 'Gambar',
                        name: 'gambar',
                        width: 70,
                        align: 'center',
                        sortable: false,
                        clear: false,
                        stype: 'input',
                        search: false,
                        formatter: (value, rowOptions, rowData) => {
                            if (value == '') {
                                return `<input type="checkbox" name="stokjkttnl_gbr[]" value="${rowData.gambar}" disabled>`
                            } else {
                                return `<input type="checkbox" name="stokjkttnl_gbr[]" value="${JSON.parse(rowData.gambar)[0]}" checked disabled>`
                            }
                        },
                    },
                    {
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '50px',
                        search: false,
                    },
                    {
                        label: 'NAMA',
                        name: 'namastok',
                        align: 'left',
                        width: 200
                    },
                    {
                        label: 'sub kelompok',
                        name: 'subkelompok',
                        align: 'left'
                    }
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 200,
                rowNum: 10,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                footerrow: true,
                userDataOnFooter: true,
                toolbar: [true, "top"],
                sortable: true,
                sortname: sortnameJktTnl,
                sortorder: sortorderJktTnl,
                page: pageJktTnl,
                viewrecords: true,
                prmNames: {
                    sort: 'sortIndex',
                    order: 'sortOrder',
                    rows: 'limit'
                },
                jsonReader: {
                    root: 'data',
                    total: 'attributes.totalPages',
                    records: 'attributes.totalRows',
                },
                loadBeforeSend: function(jqXHR) {
                    jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

                    setGridLastRequest($(this), jqXHR)
                },

                onSelectRow: function(id) {
                    activeGrid = $(this)
                    getGambarJktTnl(id)
                },
                loadComplete: function(data) {
                    let grid = $(this)
                    changeJqGridRowListText()

                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    /* Set global variables */
                    sortnameJktTnl = $(this).jqGrid("getGridParam", "sortname")
                    sortorderJktTnl = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordJktTnl = $(this).getGridParam("records")
                    limitJktTnl = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataJktTnl = $(this).jqGrid('getGridParam', 'postData')
                    triggerClickJktTnl = true

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowJktTnl > $(this).getDataIDs().length - 1) {
                        indexRowJktTnl = $(this).getDataIDs().length - 1;
                    }

                    setHighlight($(this))

                    $.each(selectedRowsJktTnl, function(key, value) {
                        $(grid).find('tbody tr').each(function(row, tr) {
                            if ($(this).find(`td [name="stokjkttnl_id[]"]`).val() == value) {
                                $(this).addClass('bg-light-blue')
                                $(this).find(`td [name="stokjkttnl_id[]"]`).prop('checked', true)
                            }
                        })
                    });

                    $('#gsJktTnl').attr('disabled', false)
                }
            })

            .jqGrid("setLabel", "rn", "No.")
            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false,
                defaultSearch: 'cn',
                groupOp: 'AND',
                disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
                beforeSearch: function() {

                    clearGlobalSearch($('#tableJktTnl'))
                },
            })

            .customPager({})



        /* Append clear filter button */
        loadClearFilter($('#tableJktTnl'))

        /* Append global search */
        loadGlobalSearch($('#tableJktTnl'))
    }

    function loadGridMakassar() {
        $("#tableMks").jqGrid({
                datatype: "local",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                colModel: [{
                        label: 'Pilih',
                        name: 'pilih',
                        width: 70,
                        align: 'center',
                        sortable: false,
                        clear: false,
                        stype: 'input',
                        search: false,
                        formatter: (value, rowOptions, rowData) => {
                            return `<input type="checkbox" name="stokmks_id[]" value="${rowData.id}" onchange="checkboxHandlerMks(this)">`
                        },
                    },
                    {
                        label: 'Gambar',
                        name: 'gambar',
                        width: 70,
                        align: 'center',
                        sortable: false,
                        clear: false,
                        stype: 'input',
                        search: false,
                        formatter: (value, rowOptions, rowData) => {
                            if (rowData.gambar == '') {
                                return `<input type="checkbox" name="stokmks_gbr[]" value="${rowData.gambar}" disabled>`
                            } else {
                                return `<input type="checkbox" name="stokmks_gbr[]" value="${rowData.gambar}" checked disabled>`
                            }
                        },
                    },
                    {
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '50px',
                        search: false,
                    },
                    {
                        label: 'NAMA',
                        name: 'namastok',
                        align: 'left',
                        width: 200
                    },
                    {
                        label: 'sub kelompok',
                        name: 'subkelompok',
                        align: 'left'
                    }
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 200,
                rowNum: 10,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                footerrow: true,
                userDataOnFooter: true,
                toolbar: [true, "top"],
                sortable: true,
                sortname: sortnameMks,
                sortorder: sortorderMks,
                page: pageMks,
                viewrecords: true,
                prmNames: {
                    sort: 'sortIndex',
                    order: 'sortOrder',
                    rows: 'limit'
                },
                jsonReader: {
                    root: 'data',
                    total: 'attributes.totalPages',
                    records: 'attributes.totalRows',
                },
                loadBeforeSend: function(jqXHR) {
                    jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

                    setGridLastRequest($(this), jqXHR)
                },

                onSelectRow: function(id) {
                    activeGrid = $(this)
                    getGambarMks(id)
                },
                loadComplete: function(data) {
                    let grid = $(this)
                    changeJqGridRowListText()

                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    /* Set global variables */
                    sortnameMks = $(this).jqGrid("getGridParam", "sortname")
                    sortorderMks = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordMks = $(this).getGridParam("records")
                    limitMks = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataMks = $(this).jqGrid('getGridParam', 'postData')
                    triggerClickMks = true

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowMks > $(this).getDataIDs().length - 1) {
                        indexRowMks = $(this).getDataIDs().length - 1;
                    }

                    setHighlight($(this))

                    $.each(selectedRowsMks, function(key, value) {
                        $(grid).find('tbody tr').each(function(row, tr) {
                            if ($(this).find(`td [name="stokmks_id[]"]`).val() == value) {
                                $(this).addClass('bg-light-blue')
                                $(this).find(`td [name="stokmks_id[]"]`).prop('checked', true)
                            }
                        })
                    });
                }
            })

            .jqGrid("setLabel", "rn", "No.")
            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false,
                defaultSearch: 'cn',
                groupOp: 'AND',
                disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
                beforeSearch: function() {

                    clearGlobalSearch($('#tableMks'))
                },
            })

            .customPager({})



        /* Append clear filter button */
        loadClearFilter($('#tableMks'))

        /* Append global search */
        loadGlobalSearch($('#tableMks'))
    }

    function loadGridSurabaya() {
        $("#tableSby").jqGrid({
                datatype: "local",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                colModel: [{
                        label: 'Pilih',
                        name: 'pilih',
                        width: 70,
                        align: 'center',
                        sortable: false,
                        clear: false,
                        stype: 'input',
                        search: false,
                        formatter: (value, rowOptions, rowData) => {
                            return `<input type="checkbox" name="stoksby_id[]" value="${rowData.id}" onchange="checkboxHandlerSby(this)">`
                        },
                    },
                    {
                        label: 'Gambar',
                        name: 'gambar',
                        width: 70,
                        align: 'center',
                        sortable: false,
                        clear: false,
                        stype: 'input',
                        search: false,
                        formatter: (value, rowOptions, rowData) => {
                            if (rowData.gambar == '') {
                                return `<input type="checkbox" name="stoksby_gbr[]" value="${rowData.gambar}" disabled>`
                            } else {
                                return `<input type="checkbox" name="stoksby_gbr[]" value="${rowData.gambar}" checked disabled>`
                            }
                        },
                    },
                    {
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '50px',
                        search: false,
                    },
                    {
                        label: 'NAMA',
                        name: 'namastok',
                        align: 'left',
                        width: 200
                    },
                    {
                        label: 'sub kelompok',
                        name: 'subkelompok',
                        align: 'left'
                    }
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 200,
                rowNum: 10,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                footerrow: true,
                userDataOnFooter: true,
                toolbar: [true, "top"],
                sortable: true,
                sortname: sortnameSby,
                sortorder: sortorderSby,
                page: pageSby,
                viewrecords: true,
                prmNames: {
                    sort: 'sortIndex',
                    order: 'sortOrder',
                    rows: 'limit'
                },
                jsonReader: {
                    root: 'data',
                    total: 'attributes.totalPages',
                    records: 'attributes.totalRows',
                },
                loadBeforeSend: function(jqXHR) {
                    jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

                    setGridLastRequest($(this), jqXHR)
                },

                onSelectRow: function(id) {
                    activeGrid = $(this)
                    getGambarSby(id)
                },
                loadComplete: function(data) {
                    let grid = $(this)
                    changeJqGridRowListText()

                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    /* Set global variables */
                    sortnameSby = $(this).jqGrid("getGridParam", "sortname")
                    sortorderSby = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordSby = $(this).getGridParam("records")
                    limitSby = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataSby = $(this).jqGrid('getGridParam', 'postData')
                    triggerClickSby = true

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowSby > $(this).getDataIDs().length - 1) {
                        indexRowSby = $(this).getDataIDs().length - 1;
                    }

                    setHighlight($(this))

                    $.each(selectedRowsSby, function(key, value) {
                        $(grid).find('tbody tr').each(function(row, tr) {
                            if ($(this).find(`td [name="stoksby_id[]"]`).val() == value) {
                                $(this).addClass('bg-light-blue')
                                $(this).find(`td [name="stoksby_id[]"]`).prop('checked', true)
                            }
                        })
                    });
                }
            })

            .jqGrid("setLabel", "rn", "No.")
            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false,
                defaultSearch: 'cn',
                groupOp: 'AND',
                disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
                beforeSearch: function() {

                    clearGlobalSearch($('#tableSby'))
                },
            })

            .customPager({})



        /* Append clear filter button */
        loadClearFilter($('#tableSby'))

        /* Append global search */
        loadGlobalSearch($('#tableSby'))
    }

    function loadGridBitung() {
        $("#tableBtg").jqGrid({
                datatype: "local",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                colModel: [{
                        label: 'Pilih',
                        name: 'pilih',
                        width: 70,
                        align: 'center',
                        sortable: false,
                        clear: false,
                        stype: 'input',
                        search: false,
                        formatter: (value, rowOptions, rowData) => {
                            return `<input type="checkbox" name="stokbtg_id[]" value="${rowData.id}" onchange="checkboxHandlerBtg(this)">`
                        },
                    },
                    {
                        label: 'Gambar',
                        name: 'gambar',
                        width: 70,
                        align: 'center',
                        sortable: false,
                        clear: false,
                        stype: 'input',
                        search: false,
                        formatter: (value, rowOptions, rowData) => {
                            // console.log('value ', value)
                            if (rowData.gambar == '') {
                                return `<input type="checkbox" name="stokbtg_gbr[]" value="${rowData.gambar}" disabled>`
                            } else {
                                return `<input type="checkbox" name="stokbtg_gbr[]" value="${rowData.gambar}" checked disabled>`
                            }
                        },
                    },
                    {
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '50px',
                        search: false,
                    },
                    {
                        label: 'NAMA',
                        name: 'namastok',
                        align: 'left',
                        width: 200
                    },
                    {
                        label: 'sub kelompok',
                        name: 'subkelompok',
                        align: 'left'
                    }
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 200,
                rowNum: 10,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                footerrow: true,
                userDataOnFooter: true,
                toolbar: [true, "top"],
                sortable: true,
                sortname: sortnameBtg,
                sortorder: sortorderBtg,
                page: pageBtg,
                viewrecords: true,
                prmNames: {
                    sort: 'sortIndex',
                    order: 'sortOrder',
                    rows: 'limit'
                },
                jsonReader: {
                    root: 'data',
                    total: 'attributes.totalPages',
                    records: 'attributes.totalRows',
                },
                loadBeforeSend: function(jqXHR) {
                    jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

                    setGridLastRequest($(this), jqXHR)
                },

                onSelectRow: function(id) {
                    activeGrid = $(this)
                    getGambarBtg(id)
                },
                loadComplete: function(data) {
                    let grid = $(this)
                    changeJqGridRowListText()

                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    /* Set global variables */
                    sortnameBtg = $(this).jqGrid("getGridParam", "sortname")
                    sortorderBtg = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordBtg = $(this).getGridParam("records")
                    limitBtg = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataBtg = $(this).jqGrid('getGridParam', 'postData')
                    triggerClickBtg = true

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowBtg > $(this).getDataIDs().length - 1) {
                        indexRowBtg = $(this).getDataIDs().length - 1;
                    }

                    setHighlight($(this))

                    $.each(selectedRowsBtg, function(key, value) {
                        $(grid).find('tbody tr').each(function(row, tr) {
                            console.log('val', value)
                            if ($(this).find(`td [name="stokbtg_id[]"]`).val() == value) {
                                $(this).addClass('bg-light-blue')
                                $(this).find(`td [name="stokbtg_id[]"]`).prop('checked', true)
                            }
                        })
                    });
                }
            })

            .jqGrid("setLabel", "rn", "No.")
            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false,
                defaultSearch: 'cn',
                groupOp: 'AND',
                disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
                beforeSearch: function() {

                    clearGlobalSearch($('#tableBtg'))
                },
            })

            .customPager({})



        /* Append clear filter button */
        loadClearFilter($('#tableBtg'))

        /* Append global search */
        loadGlobalSearch($('#tableBtg'))
    }

    function getGambarMdn(id, checkRow = false) {
        let gbrmdn = $(`#tableMedan tbody tr#${id}`).find(`td [name="stokmdn_gbr[]"]`).val()
        // if (!checkRow) {
        if (gbrmdn != '') {
            $('#imgMedan').attr('src', `{{ config('app.pic_url_mdn') }}view.php?path=${gbrmdn}`);
        } else {
            $('#imgMedan').attr('src', `{{ config('app.pic_url_mdn') }}no-image.jpg`);
        }
        // }
        if (id == selectedRowsMdn[0]) {
            selectedGbrMdn = gbrmdn
        }
        // $.ajax({
        //     url: `${apiTruckingMdnUrl}stok/getGambar`,
        //     method: 'GET',
        //     dataType: 'JSON',
        //     headers: {
        //         Authorization: `Bearer ${accessTokenMdn}`
        //     },
        //     data: {
        //         id: id
        //     },
        //     success: response => {
        //         if (!checkRow) {
        //             $('#imgMedan').attr('src', `${apiTruckingMdnUrl}stok/${response.gambar}/medium`);
        //         }

        //         if (response.gambar != 'no-image') {
        //             let cekGambarMdn = $(`#tableMedan tbody tr#${selectedRowsMdn[0]}`).find(`td [name="stokmdn_gbr[]"]`).val();
        //             if (cekGambarMdn == response.gambar) {
        //                 selectedGbrMdn = response.gambar
        //             } else {
        //                 if (id == selectedRowsMdn[0]) {
        //                     selectedGbrMdn = response.gambar
        //                 }
        //             }
        //         }
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
    }

    function getGambarJkt(id, checkRow = false) {
        $.ajax({
            url: `${apiTruckingJktUrl}stok/getGambar`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessTokenJkt}`
            },
            data: {
                id: id
            },
            success: response => {
                if (!checkRow) {
                    $('#imgJkt').attr('src', `${apiTruckingJktUrl}stok/${response.gambar}/medium`);
                }
                if (response.gambar != 'no-image') {
                    let cekGambarJkt = $(`#tableJkt tbody tr#${selectedRowsJkt[0]}`).find(`td [name="stokjkt_gbr[]"]`).val();
                    if (cekGambarJkt == response.gambar) {
                        selectedGbrJkt = response.gambar
                    } else {
                        if (id == selectedRowsJkt[0]) {
                            selectedGbrJkt = response.gambar
                        }
                    }
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
        })
    }

    function getGambarJktTnl(id, checkRow = false) {
        $.ajax({
            url: `${apiTruckingJktTnlUrl}stok/getGambar`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessTokenJktTnl}`
            },
            data: {
                id: id
            },
            success: response => {
                if (!checkRow) {
                    $('#imgJktTnl').attr('src', `${apiTruckingJktTnlUrl}stok/${response.gambar}/medium`);
                }

                if (response.gambar != 'no-image') {
                    let cekGambarJktTnl = $(`#tableJktTnl tbody tr#${selectedRowsJktTnl[0]}`).find(`td [name="stokjkttnl_gbr[]"]`).val();
                    if (cekGambarJktTnl == response.gambar) {
                        selectedGbrJktTnl = response.gambar
                    } else {
                        if (id == selectedRowsJktTnl[0]) {
                            selectedGbrJktTnl = response.gambar
                        }
                    }
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
        })
    }


    function getGambarMks(id, checkRow = false) {
        let gbrmks = $(`#tableMks tbody tr#${id}`).find(`td [name="stokmks_gbr[]"]`).val()
        // if (!checkRow) {
        if (gbrmks != '') {
            $('#imgMks').attr('src', `{{ config('app.pic_url_mks') }}view.php?path=${gbrmks}`);
        } else {
            $('#imgMks').attr('src', `{{ config('app.pic_url_mks') }}no-image.jpg`);
        }
        // }
        if (id == selectedRowsMks[0]) {
            selectedGbrMks = gbrmks
        }
        // $.ajax({
        //     url: `${apiTruckingMksUrl}stok/getGambar`,
        //     method: 'GET',
        //     dataType: 'JSON',
        //     headers: {
        //         Authorization: `Bearer ${accessTokenMks}`
        //     },
        //     data: {
        //         id: id
        //     },
        //     success: response => {
        //         if (!checkRow) {
        //             $('#imgMks').attr('src', `${apiTruckingMksUrl}stok/${response.gambar}/medium`);
        //         }

        //         if (response.gambar != 'no-image') {
        //             let cekGambarMks = $(`#tableMks tbody tr#${selectedRowsMks[0]}`).find(`td [name="stokmks_gbr[]"]`).val();
        //             if (cekGambarMks == response.gambar) {
        //                 selectedGbrMks = response.gambar
        //             } else {
        //                 if (id == selectedRowsMks[0]) {
        //                     selectedGbrMks = response.gambar
        //                 }
        //             }
        //         }
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
    }

    function getGambarSby(id, checkRow = false) {
        let gbrsby = $(`#tableSby tbody tr#${id}`).find(`td [name="stoksby_gbr[]"]`).val()
        // if (!checkRow) {
        if (gbrsby != '') {
            $('#imgSby').attr('src', `{{ config('app.pic_url_sby') }}view.php?path=${gbrsby}`);
        } else {
            $('#imgSby').attr('src', `{{ config('app.pic_url_sby') }}no-image.jpg`);
        }
        // }
        if (id == selectedRowsSby[0]) {
            selectedGbrSby = gbrsby
        }
        // if (response.gambar != 'no-image') {
        //     let cekGambarSby = $(`#tableSby tbody tr#${selectedRowsSby[0]}`).find(`td [name="stoksby_gbr[]"]`).val();
        //     if (cekGambarSby == response.gambar) {
        //         selectedGbrSby = response.gambar
        //     } else {
        //         if (id == selectedRowsSby[0]) {
        //             selectedGbrSby = response.gambar
        //         }
        //     }
        // }
        // $.ajax({
        //     url: `${apiTruckingSbyUrl}stok/getGambar`,
        //     method: 'GET',
        //     dataType: 'JSON',
        //     headers: {
        //         Authorization: `Bearer ${accessTokenSby}`
        //     },
        //     data: {
        //         id: id
        //     },
        //     success: response => {
        //         if (!checkRow) {
        //             $('#imgSby').attr('src', `${apiTruckingSbyUrl}stok/${response.gambar}/medium`);
        //         }

        //         if (response.gambar != 'no-image') {
        //             let cekGambarSby = $(`#tableSby tbody tr#${selectedRowsSby[0]}`).find(`td [name="stoksby_gbr[]"]`).val();
        //             if (cekGambarSby == response.gambar) {
        //                 selectedGbrSby = response.gambar
        //             } else {
        //                 if (id == selectedRowsSby[0]) {
        //                     selectedGbrSby = response.gambar
        //                 }
        //             }
        //         }
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
    }

    function getGambarBtg(id, checkRow = false) {
        let gbrbtg = $(`#tableBtg tbody tr#${id}`).find(`td [name="stokbtg_gbr[]"]`).val()
        // if (!checkRow) {
        if (gbrbtg != '') {
            $('#imgBtg').attr('src', `{{ config('app.pic_url_btg') }}view.php?path=${gbrbtg}`);
        } else {
            $('#imgBtg').attr('src', `{{ config('app.pic_url_btg') }}no-image.jpg`);
        }
        // }
        if (id == selectedRowsBtg[0]) {
            selectedGbrBtg = gbrbtg
        }
        // $.ajax({
        //     url: `${apiTruckingBtgUrl}stok/getGambar`,
        //     method: 'GET',
        //     dataType: 'JSON',
        //     headers: {
        //         Authorization: `Bearer ${accessTokenBtg}`
        //     },
        //     data: {
        //         id: id
        //     },
        //     success: response => {
        //         if (!checkRow) {
        //             $('#imgBtg').attr('src', `${apiTruckingBtgUrl}stok/${response.gambar}/medium`);
        //         }

        //         if (response.gambar != 'no-image') {
        //             let cekGambarBtg = $(`#tableBtg tbody tr#${selectedRowsBtg[0]}`).find(`td [name="stokbtg_gbr[]"]`).val();
        //             if (cekGambarBtg == response.gambar) {
        //                 selectedGbrBtg = response.gambar
        //             } else {
        //                 if (id == selectedRowsBtg[0]) {
        //                     selectedGbrBtg = response.gambar
        //                 }
        //             }
        //         }
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
    }

    function clearSelectedRows() {
        selectedRowsMdn = []
        selectedRowsJkt = []
        selectedRowsJktTnl = []
        selectedRowsSby = []
        selectedRowsMks = []
        selectedRowsBtg = []

        selectedGbrMdn = ''
        selectedNamaMdn = ''
        selectedGbrJkt = ''
        selectedNamaJkt = ''
        selectedGbrJktTnl = ''
        selectedNamaJktTnl = ''
        selectedGbrSby = ''
        selectedNamaSby = ''
        selectedGbrMks = ''
        selectedNamaMks = ''
        selectedGbrBtg = ''
        selectedNamaBtg = ''
        jumlahRow = 0
        $('#tableMedan').trigger('reloadGrid')
        $('#tableJkt').trigger('reloadGrid')
        $('#tableJktTnl').trigger('reloadGrid')
        $('#tableSby').trigger('reloadGrid')
        $('#tableMks').trigger('reloadGrid')
        $('#tableBtg').trigger('reloadGrid')
    }

    function checkboxHandler(element) {
        let value = $(element).val();
        if (element.checked) {

            if (selectedRowsMdn.length == 1) {
                selectedRowsMdn[0]
                let mdnElement = $(`#tableMedan tbody tr#${selectedRowsMdn[0]}`).find(`td [name="stokmdn_id[]"]`)
                mdnElement.prop('checked', false)
                selectedRowsMdn.splice(0, 1);
                selectedGbrMdn = ''
                selectedNamaMdn = ''
                $(mdnElement).parents('tr').removeClass('bg-light-blue')
            }

            selectedRowsMdn.push($(element).val())
            getGambarMdn($(element).val(), true)
            selectedNamaMdn = $(element).parents('tr').find(`td[aria-describedby="tableMedan_namastok"]`).text()
            $(element).parents('tr').addClass('bg-light-blue')
            jumlahRow++
        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRowsMdn.length; i++) {
                if (selectedRowsMdn[i] == value) {
                    selectedRowsMdn.splice(i, 1);
                    selectedGbrMdn = ''
                    selectedNamaMdn = ''
                    jumlahRow--
                }
            }
        }

    }

    function checkboxHandlerJkt(element) {
        let value = $(element).val();
        if (element.checked) {
            if (selectedRowsJkt.length == 1) {
                selectedRowsJkt[0]
                let jktElement = $(`#tableJkt tbody tr#${selectedRowsJkt[0]}`).find(`td [name="stokjkt_id[]"]`)
                jktElement.prop('checked', false)
                selectedRowsJkt.splice(0, 1);
                selectedGbrJkt = ''
                selectedNamaJkt = ''
                $(jktElement).parents('tr').removeClass('bg-light-blue')
            }

            selectedRowsJkt.push($(element).val())
            getGambarJkt($(element).val(), true)
            selectedNamaJkt = $(element).parents('tr').find(`td[aria-describedby="tableJkt_namastok"]`).text()
            $(element).parents('tr').addClass('bg-light-blue')
            jumlahRow++
        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRowsJkt.length; i++) {
                if (selectedRowsJkt[i] == value) {
                    selectedRowsJkt.splice(i, 1);
                    selectedGbrJkt = ''
                    selectedNamaJkt = ''
                    jumlahRow--
                }
            }
        }

    }

    function checkboxHandlerJktTnl(element) {
        let value = $(element).val();
        if (element.checked) {
            if (selectedRowsJktTnl.length == 1) {
                selectedRowsJktTnl[0]
                let jktTnlElement = $(`#tableJktTnl tbody tr#${selectedRowsJktTnl[0]}`).find(`td [name="stokjkttnl_id[]"]`)
                jktTnlElement.prop('checked', false)
                selectedRowsJktTnl.splice(0, 1);
                selectedGbrJktTnl = ''
                selectedNamaJktTnl = ''
                $(jktTnlElement).parents('tr').removeClass('bg-light-blue')

            }
            selectedRowsJktTnl.push($(element).val())
            getGambarJktTnl($(element).val(), true)
            selectedNamaJktTnl = $(element).parents('tr').find(`td[aria-describedby="tableJktTnl_namastok"]`).text()
            $(element).parents('tr').addClass('bg-light-blue')
            jumlahRow++
        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRowsJktTnl.length; i++) {
                if (selectedRowsJktTnl[i] == value) {
                    selectedRowsJktTnl.splice(i, 1);
                    selectedGbrJktTnl = ''
                    selectedNamaJktTnl = ''
                    jumlahRow--
                }
            }
        }

    }

    function checkboxHandlerMks(element) {
        let value = $(element).val();
        if (element.checked) {
            if (selectedRowsMks.length == 1) {
                selectedRowsMks[0]
                let mksElement = $(`#tableMks tbody tr#${selectedRowsMks[0]}`).find(`td [name="stokmks_id[]"]`)
                mksElement.prop('checked', false)
                selectedRowsMks.splice(0, 1);
                selectedGbrMks = ''
                selectedNamaMks = ''
                $(mksElement).parents('tr').removeClass('bg-light-blue')

            }
            selectedRowsMks.push($(element).val())
            getGambarMks($(element).val(), true)
            selectedNamaMks = $(element).parents('tr').find(`td[aria-describedby="tableMks_namastok"]`).text()
            $(element).parents('tr').addClass('bg-light-blue')
            jumlahRow++
        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRowsMks.length; i++) {
                if (selectedRowsMks[i] == value) {
                    selectedRowsMks.splice(i, 1);
                    selectedGbrMks = ''
                    selectedNamaMks = ''
                    jumlahRow--
                }
            }
        }

    }

    function checkboxHandlerSby(element) {
        let value = $(element).val();
        if (element.checked) {
            if (selectedRowsSby.length == 1) {
                selectedRowsSby[0]
                let sbyElement = $(`#tableSby tbody tr#${selectedRowsSby[0]}`).find(`td [name="stoksby_id[]"]`)
                sbyElement.prop('checked', false)
                selectedRowsSby.splice(0, 1);
                selectedGbrSby = ''
                selectedNamaSby = ''
                $(sbyElement).parents('tr').removeClass('bg-light-blue')

            }
            selectedRowsSby.push($(element).val())
            getGambarSby($(element).val(), true)
            selectedNamaSby = $(element).parents('tr').find(`td[aria-describedby="tableSby_namastok"]`).text()
            $(element).parents('tr').addClass('bg-light-blue')
            jumlahRow++
        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRowsSby.length; i++) {
                if (selectedRowsSby[i] == value) {
                    selectedRowsSby.splice(i, 1);
                    selectedGbrSby = ''
                    selectedNamaSby = ''
                    jumlahRow--
                }
            }
        }

    }

    function checkboxHandlerBtg(element) {
        let value = $(element).val();
        if (element.checked) {
            if (selectedRowsBtg.length == 1) {
                selectedRowsBtg[0]
                let btgElement = $(`#tableBtg tbody tr#${selectedRowsBtg[0]}`).find(`td [name="stokbtg_id[]"]`)
                btgElement.prop('checked', false)
                selectedRowsBtg.splice(0, 1);
                selectedGbrBtg = ''
                selectedNamaBtg = ''
                $(btgElement).parents('tr').removeClass('bg-light-blue')

            }
            selectedRowsBtg.push($(element).val())
            getGambarBtg($(element).val(), true)
            selectedNamaBtg = $(element).parents('tr').find(`td[aria-describedby="tableBtg_namastok"]`).text()
            $(element).parents('tr').addClass('bg-light-blue')
            jumlahRow++
        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRowsBtg.length; i++) {
                if (selectedRowsBtg[i] == value) {
                    selectedRowsBtg.splice(i, 1);
                    selectedGbrBtg = ''
                    selectedNamaBtg = ''
                    jumlahRow--
                }
            }
        }

    }

    function initLookup() {
        $('.kelompok-lookup').lookupV3({
            title: 'Kelompok Lookup',
            fileName: 'kelompokV3',
            searching: ['kodekelompok'],
            labelColumn: false,
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (kelompok, element) => {
                $('#crudForm [name=kelompok_id]').first().val(kelompok.id)
                if ($('#crudForm').data('action') != 'delete') {
                    clearSelectedRows()
                }
                kelompokId = kelompok.id
                element.val(kelompok.kodekelompok)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                if ($('#crudForm').data('action') != 'delete') {

                    clearSelectedRows()
                    $('#crudForm [name=kelompok_id]').first().val('')
                    kelompokId = ''
                    element.val('')
                    element.data('currentValue', element.val())
                }
            }
        })
    }
</script>
@endpush()