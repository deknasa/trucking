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
                                    Kelompok <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="kelompok_id">
                                <input type="text" name="kelompok" class="form-control kelompok-lookup">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-12">
                                <button class="btn btn-secondary" type="button" id="btnTampil"><i class="fas fa-sync"></i>
                                    FILTER</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card col-md-6">
                                <div class="col-md-2 mb-2" id="imageMdn">
                                    <img id="imgMedan">
                                </div>
                                <div class="col-md-10">
                                    <table id="tableMedan"></table>
                                </div>
                            </div>
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
    let kelompokId
    let sortnameMdn = 'namastok';
    let sortorderMdn = 'asc';
    let pageMdn = 0;
    let totalRecordMdn
    let limitMdn
    let postDataMdn
    let triggerClickMdn
    let indexRowMdn
    let selectedRowsMdn = []

    $(document).ready(function() {

        $(document).on('click', '#btnTampil', function(event) {
            event.preventDefault()

            $('#tableMedan')
                .jqGrid('setGridParam', {
                    url: `${apiTruckingMdnUrl}stok`,
                    mtype: "GET",
                    datatype: "json",
                    postData: {
                        kelompok_id: kelompokId,
                        aktif: "AKTIF",
                    },
                    loadBeforeSend: function(jqXHR) {
                        jqXHR.setRequestHeader('Authorization', `Bearer ${accessTokenMdn}`)
                    },
                }).trigger('reloadGrid');

        })
        $('#btnSubmit').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let stokPusatId = form.find('[name=id]').val()
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
    })

    function createStokPusat() {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Simpan
        `)
        form.data('action', 'add')
        $('#crudModal').modal('show')
        form.find(`.sometimes`).show()
        $('#crudModalTitle').text('Create Stok Pusat')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        loadGridMedan()
    }


    function loadGridMedan() {
        $("#tableMedan").jqGrid({
                datatype: "local",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                colModel: [{
                        label: '',
                        name: '',
                        width: 30,
                        align: 'center',
                        sortable: false,
                        clear: false,
                        stype: 'input',
                        searchable: false,
                        searchoptions: {
                            type: 'checkbox',
                            clearSearch: false,
                            dataInit: function(element) {
                                let aksi = $('#crudForm').data('action')
                                $(element).attr('id', 'gsMdn')
                                $(element).removeClass('form-control')
                                $(element).parent().addClass('text-center')
                                $(element).on('click', function() {
                                    $(element).attr('disabled', true)

                                    if ($(this).is(':checked')) {
                                        selectAllRows(supirId, dari, sampai, aksi, element)
                                    } else {
                                        clearSelectedRows(element)
                                    }
                                })
                            }
                        },
                        formatter: (value, rowOptions, rowData) => {
                            return `<input type="checkbox" name="stokmdn_id[]" value="${rowData.id}" onchange="checkboxHandler(this)">`
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
                            if ($(this).find(`td input:checkbox`).val() == value) {
                                $(this).addClass('bg-light-blue')
                                $(this).find(`td input:checkbox`).prop('checked', true)
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

    function getGambarMdn(id) {
        $.ajax({
            url: `${apiTruckingMdnUrl}stok/getGambar`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessTokenMdn}`
            },
            data: {
                id: id
            },
            success: response => {
                $('#imgMedan').attr('src', `${apiTruckingMdnUrl}stok/${response.gambar}/medium`)
                    .width('113px').height('113px');
               
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

    function initLookup() {
        $('.kelompok-lookup').lookup({
            title: 'Kelompok Lookup',
            fileName: 'kelompok',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (kelompok, element) => {
                $('#crudForm [name=kelompok_id]').first().val(kelompok.id)
                kelompokId = kelompok.id
                element.val(kelompok.kodekelompok)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=kelompok_id]').first().val('')
                kelompokId = ''
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()