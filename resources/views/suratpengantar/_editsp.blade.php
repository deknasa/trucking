<div class="modal modal-fullscreen" id="crudModalEditSp" tabindex="-1" aria-labelledby="crudModalEditSpLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="editSpForm">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="crudModalEditSpTitle"></p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>

                <form action="" method="post">

                    <div class="modal-body">
                        <input type="hidden" name="id">

                        <div class="row form-group">
                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">
                                    TGL DARI <span class="text-danger"></span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4">
                                <div class="input-group">
                                    <input type="text" name="tgldarisp" class="form-control datepicker">
                                </div>
                            </div>

                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">
                                    TGL SAMPAI <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4">
                                <div class="input-group">
                                    <input type="text" name="tglsampaisp" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group supir">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    SUPIR
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="supirsp_id">
                                <input type="text" name="supirsp" class="form-control supirsp-lookup">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-4">
                                <a id="btnTampilEditSp" class="btn btn-primary mr-2 mb-2">
                                    <i class="fas fa-sync"></i>
                                    Reload
                                </a>
                            </div>
                        </div>
                        <div id="tes">

                            <table id="tableEditSp"></table>
                        </div>
                        <!-- <table class="table table-bordered table-bindkeys" id="tableEditSp" style="width: 1800px;">
                            <thead style="background-color:white; border-color: #bad5ff;">
                                <tr>
                                    <th width="2%">No</th>
                                    <th width="8%">NO TRIP</th>
                                    <th width="8%">JOB TRUCKING</th>
                                    <th width="8%">TGL TRIP</th>
                                    <th width="10%">NO SP</th>
                                    <th width="10%">NO CONT</th>
                                    <th width="10%">NO CONT 2</th>
                                    <th width="8%">NO SEAL</th>
                                    <th width="8%">NO SEAL 2</th>
                                    <th width="6%">CONTAINER</th>
                                    <th width="6%">STATUS CONTAINER</th>
                                    <th width="6%">JENIS ORDER</th>
                                    <th width="10%">DARI</th>
                                    <th width="10%">SAMPAI</th>
                                    <th width="10%">PENYESUAIAN</th>
                                    <th width="4%" class="kolom-aksi">Aksi</th>
                                </tr>
                                <tr class="filters">

                                </tr>
                            </thead>
                            <tbody id="tableEditSp_body" class="form-group">
                                <tr>

                                </tr>
                            </tbody>
                        </table> -->
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmitEditSp" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Save
                        </button>
                        <button id="btnSaveAddEditSp" class="btn btn-success">
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
    let modalBodyEditSp = $('#crudModalEditSp').find('.modal-body').html()

    $(document).ready(function() {

        $('#btnSubmitEditSp').click(function(event) {
            event.preventDefault()
            submitEditSp($(this).attr('id'))
        })
        $('#btnSaveAddEditSp').click(function(event) {
            event.preventDefault()
            console.log($(this).attr('id'))
            submitEditSp($(this).attr('id'))
        })

        function submitEditSp(button) {

            let method
            let url
            let form = $('#editSpForm')


            event.preventDefault()

            let action = form.data('action')
            let data = []

            data.push({
                name: 'supirsp_id',
                value: form.find(`[name="supirsp_id"]`).val()
            })
            data.push({
                name: 'supirsp',
                value: form.find(`[name="supirsp"]`).val()
            })

            let selectedRows = $("#tableEditSp").getGridParam("selectedRowIds");
            data.push({
                name: 'jumlahdetail',
                value: selectedRows
            })

            let idedit = [];
            let nospedit = [];
            let nocontedit = [];
            let nocont2edit = [];
            let nosealedit = [];
            let noseal2edit = [];
            $.each(selectedRows, function(index, value) {
                dataEditSp = $("#tableEditSp").jqGrid("getLocalRow", value);

                idedit.push(dataEditSp.id)
                nospedit.push(dataEditSp.nospedit)
                nocontedit.push(dataEditSp.nocontedit)
                nocont2edit.push(dataEditSp.nocont2edit)
                nosealedit.push(dataEditSp.nosealedit)
                noseal2edit.push(dataEditSp.noseal2edit)
            });

            let requestDataTrip = {
                'id': idedit,
                'nosp': nospedit,
                'nocont': nocontedit,
                'nocont2': nocont2edit,
                'noseal': nosealedit,
                'noseal2': noseal2edit
            };

            data.push({
                name: 'detail',
                value: JSON.stringify(requestDataTrip)
            })
            data.push({
                name: 'info',
                value: info
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

            data.push({
                name: 'tgldariheader',
                value: $('#tgldariheader').val()
            })
            data.push({
                name: 'tglsampaiheader',
                value: $('#tglsampaiheader').val()
            })
            data.push({
                name: 'button',
                value: button
            })

            let tgldariheader = $('#tgldariheader').val();
            let tglsampaiheader = $('#tglsampaiheader').val()

            $(this).attr('disabled', '')
            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: `${apiUrl}suratpengantar/editsp`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {

                    $('#crudModalEditSp').find('#editSpForm').trigger('reset')
                    if (button == 'btnSubmitEditSp') {
                        $('#crudModalEditSp').modal('hide')
                        $('#jqGrid').jqGrid().trigger('reloadGrid');

                        if (id == 0) {
                            $('#detail').jqGrid().trigger('reloadGrid')
                        }
                    } else {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        $('#editSpForm').find('input[type="text"]').data('current-value', '')

                        $("#tableEditSp")[0].p.selectedRowIds = [];
                        $('#tableEditSp').jqGrid("clearGridData");
                        $("#tableEditSp")
                            .jqGrid("setGridParam", {
                                selectedRowIds: []
                            })
                            $("#tableEditSp").remove()
                            $('#gbox_tableEditSp').remove()
                            $('#tes').append(`<table id="tableEditSp"></table>`)
                        createEditSp();
                    }
                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        errors = error.responseJSON.errors

                        $(".ui-state-error").removeClass("ui-state-error");
                        $.each(errors, (index, error) => {
                            let indexes = index.split(".");
                            let angka = indexes[1]
                            row = parseInt(selectedRows[angka]) - 1;
                            let element;

                            if (indexes[0] == 'alatbayar' || indexes[0] == 'statuspelunasan' || indexes[0] == 'id' || indexes[0] == 'tglbukti' || indexes[0] == 'bank' || indexes[0] == 'nowarkat' || indexes[0] == 'agen' || indexes[0] == 'tgljatuhtempo' || indexes[0] == 'piutang_id' || indexes[0] == 'notadebet_nobukti') {
                                if (indexes.length > 1) {
                                    element = form.find(`[name="${indexes[0]}[]"]`)[row];
                                } else {
                                    element = form.find(`[name="${indexes[0]}"]`)[0];
                                }

                                if ($(element).length > 0 && !$(element).is(":hidden")) {
                                    $(element).addClass("is-invalid");
                                    $(`
                                    <div class="invalid-feedback">
                                    ${error[0].toLowerCase()}
                                    </div>
                                    `).appendTo($(element).parent());
                                } else {
                                    return showDialog(error);
                                }
                            } else {
                                console.log(selectedRows[angka])
                                element = $(`#tablePelunasan tr#${parseInt(selectedRows[angka])}`).find(`td[aria-describedby="tablePelunasan_${indexes[0]}"]`)
                                $(element).addClass("ui-state-error");
                                $(element).attr("title", error[0].toLowerCase())
                            }
                        });
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
    $('#crudModalEditSp').on('shown.bs.modal', () => {
        let form = $('#editSpForm')

        setFormBindKeys(form)

        activeGrid = null
        initLookupEditSp()
        initDatepicker()
    })

    $('#crudModalEditSp').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        $('#crudModalEditSp').find('.modal-body').html(modalBodyEditSp)
        initDatepicker('datepickerIndex')
    })
    let tableData = []
    $(document).on('click', '#btnTampilEditSp', function(event) {

        let supirsp_id = $('#crudModalEditSp').find(`[name=supirsp_id]`).val()
        if (supirsp_id != '') {

            getDataSp(supirsp_id).then((response) => {
                let selectedIdDepo = []

                $.each(response.data, (index, value) => {
                    selectedIdDepo.push(value.id)
                })
                $("#tableEditSp")[0].p.selectedRowIds = [];
                $('#tableEditSp').jqGrid("clearGridData");
                setTimeout(() => {

                    $("#tableEditSp")
                        .jqGrid("setGridParam", {
                            datatype: "local",
                            data: response.data,
                            originalData: response.data,
                            rowNum: response.data.length,
                            selectedRowIds: selectedIdDepo
                        })
                        .trigger("reloadGrid");
                }, 100);
            });

        }
    })


    function createEditSp() {
        let form = $('#editSpForm')
        $('.modal-loader').removeClass('d-none')

        form.trigger('reset')
        form.find('#btnSubmitEditSp').html(`
            <i class="fa fa-save"></i>
            Save
        `)
        form.data('action', 'add')
        $('#crudModalEditSpTitle').text('Edit SP')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        let today = new Date();
        firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        let formattedFirstDay = $.datepicker.formatDate('dd-mm-yy', firstDay);
        lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        formattedLastDay = $.datepicker.formatDate('dd-mm-yy', lastDay);
        $('#editSpForm').find('[name=tgldarisp]').val(formattedFirstDay).trigger('change');
        $('#editSpForm').find('[name=tglsampaisp]').val(formattedLastDay).trigger('change');

        $('#crudModalEditSp').modal('show')
        loadEditSpGrid()
        $('.modal-loader').addClass('d-none')

    }

    function loadEditSpGrid() {
        $("#tableEditSp")
            .jqGrid({
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "local",
                colModel: [{
                        label: "id",
                        name: "id",
                        hidden: true,
                        search: false,
                    },
                    {
                        label: "NO TRIP",
                        name: "nobuktiedit",
                        sortable: true,
                    },
                    {
                        label: "JOB TRUCKING",
                        name: "jobtruckingedit",
                        sortable: true,
                    },
                    {
                        label: "TGL TRIP",
                        name: "tglbuktiedit",
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: "NO SP",
                        name: "nospedit",
                        sortable: false,
                        editable: true,
                        editoptions: {
                            dataEvents: [{
                                type: "keyup",
                                fn: function(event, rowObject) {

                                    let localRow = $("#tableEditSp").jqGrid(
                                        "getLocalRow",
                                        rowObject.rowId
                                    );
                                    localRow.nospedit = event.target.value;
                                },
                            }, ],
                        },
                    },
                    {
                        label: "NO CONT",
                        name: "nocontedit",
                        sortable: false,
                        editable: true,
                        editoptions: {
                            dataEvents: [{
                                type: "keyup",
                                fn: function(event, rowObject) {

                                    let localRow = $("#tableEditSp").jqGrid(
                                        "getLocalRow",
                                        rowObject.rowId
                                    );
                                    localRow.nocontedit = event.target.value;
                                },
                            }, ],
                        },
                    },
                    {
                        label: "NO CONT 2",
                        name: "nocont2edit",
                        sortable: false,
                        editable: true,
                        editoptions: {
                            dataEvents: [{
                                type: "keyup",
                                fn: function(event, rowObject) {

                                    let localRow = $("#tableEditSp").jqGrid(
                                        "getLocalRow",
                                        rowObject.rowId
                                    );
                                    localRow.nocont2edit = event.target.value;
                                },
                            }, ],
                        },
                    },
                    {
                        label: "NO SEAL",
                        name: "nosealedit",
                        sortable: false,
                        editable: true,
                        editoptions: {
                            dataEvents: [{
                                type: "keyup",
                                fn: function(event, rowObject) {

                                    let localRow = $("#tableEditSp").jqGrid(
                                        "getLocalRow",
                                        rowObject.rowId
                                    );
                                    localRow.nosealedit = event.target.value;
                                },
                            }, ],
                        },
                    },
                    {
                        label: "NO SEAL 2",
                        name: "noseal2edit",
                        sortable: false,
                        editable: true,
                        editoptions: {
                            dataEvents: [{
                                type: "keyup",
                                fn: function(event, rowObject) {

                                    let localRow = $("#tableEditSp").jqGrid(
                                        "getLocalRow",
                                        rowObject.rowId
                                    );
                                    localRow.noseal2edit = event.target.value;
                                },
                            }, ],
                        },
                    },
                    {
                        label: "CONTAINER",
                        name: "containeredit",
                        sortable: true,
                    },
                    {
                        label: "STATUS CONTAINER",
                        name: "statuscontaineredit",
                        sortable: true,
                    },
                    {
                        label: "JENIS ORDER",
                        name: "jenisorderedit",
                        sortable: true,
                    },
                    {
                        label: "DARI",
                        name: "dariedit",
                        sortable: true,
                    },
                    {
                        label: "SAMPAI",
                        name: "sampaiedit",
                        sortable: true,
                    },
                    {
                        label: "PENYESUAIAN",
                        name: "penyesuaianedit",
                        sortable: true,
                    },
                    {
                        label: "empty",
                        name: "empty",
                        hidden: true,
                        search: false,
                    },
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 400,
                rownumbers: true,
                rownumWidth: 45,
                footerrow: true,
                userDataOnFooter: true,
                toolbar: [true, "top"],
                pgbuttons: false,
                pginput: false,
                cellEdit: true,
                cellSelect: true,
                cellsubmit: "clientArray",
                editableColumns: ["nosp"],
                selectedRowIds: [],
                afterRestoreCell: function(rowId, value, indexRow, indexColumn) {
                    let originalGridData = $("#tableEditSp")
                        .jqGrid("getGridParam", "originalData")
                        .find((row) => row.id == rowId);

                    let localRow = $("#tableEditSp").jqGrid("getLocalRow", rowId);
                },
                validationCell: function(cellobject, errormsg, iRow, iCol) {
                    console.log(cellobject);
                    console.log(errormsg);
                    console.log(iRow);
                    console.log(iCol);
                },
                loadComplete: function() {
                    setHighlight($(this))
                },
            })
            .jqGrid("setLabel", "rn", "No.")
            .jqGrid("navGrid", "#tablePager", {
                add: false,
                edit: false,
                del: false,
                refresh: false,
                search: false,
            })
            .jqGrid("filterToolbar", {
                searchOnEnter: false,
            })
            .jqGrid("excelLikeGrid", {
                beforeDeleteCell: function(rowId, iRow, iCol, event) {
                    let localRow = $("#tableEditSp").jqGrid("getLocalRow", rowId);
                    console.log(iCol)
                    let originalGridData = $("#tableEditSp")
                        .jqGrid("getGridParam", "originalData")
                        .find((row) => row.id == rowId);


                    return true;
                },
            });

        loadClearFilter($('#tableEditSp'))

    }


    function initLookupEditSp() {

        $('.supirsp-lookup').lookup({
            title: 'Supir Lookup',
            fileName: 'supir',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (supir, element) => {
                $('#editSpForm [name=supirsp_id]').first().val(supir.id)
                element.val(supir.namaalias)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#editSpForm [name=supirsp_id]').first().val('')
                // setTimeout(() => {
                $("#tableEditSp")[0].p.selectedRowIds = [];
                $('#tableEditSp').jqGrid("clearGridData");
                // }, 100);
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }

    function getDataSp(supirId) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}suratpengantar/${supirId}/geteditsp`,
                dataType: "JSON",
                data: {
                    tgldari: $('#editSpForm [name=tgldarisp]').val(),
                    tglsampai: $('#editSpForm [name=tglsampaisp]').val()
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: (response) => {
                    console.log('response', response)
                    resolve(response);
                },
                error: error => {
                    reject(error)
                }
            });
        });
    }
</script>
@endpush()