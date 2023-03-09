<!-- Grid -->
<div class="container-fluid my-4">
    <div class="row">
        <div class="col-12 col-md-12">
            <table id="detail"></table>
            <div id="detailPager"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let absentradoColModel = []

    function loadDetailGrid(id) {

        let pager = '#detailPager'

        $("#detail").jqGrid({
                url: `{{ config('app.api_url') . 'absentrado/detail' }}?id=${id}`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "local",
                colModel: [{
                        label: 'KEY',
                        name: 'key'
                    },
                    {
                        label: 'VALUE',
                        name: 'value'
                    }
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 350,
                rowNum: 0,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                toolbar: [true, "top"],
                sortable: true,
                pager: pager,
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
                loadBeforeSend: (jqXHR) => {
                    jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
                },
                loadComplete: function() {
                    initResize($(this))
                }
            })

            .jqGrid("navGrid", pager, {
                search: false,
                refresh: false,
                add: false,
                edit: false,
                del: false,
            })
    }

    function loadDetailData(id) {
        $('#detail').setGridParam({
            url: `${apiUrl}absentrado/detail`,
            datatype: "json",
            postData: {
                id: id
            },
            page:1
        }).trigger('reloadGrid')
    }
</script>
@endpush()