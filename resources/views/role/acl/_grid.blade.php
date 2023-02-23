<table id="roleAclGrid"></table>

@include('role.acl._modal')

<script>
  function loadGrid(roleId) {
    $('#roleAclGrid')
      .jqGrid({
        url: `${apiUrl}role/${roleId}/acl`,
        datatype: 'json',
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        colModel: [{
            label: 'ROLE',
            name: 'role',
            align: 'left',
            hidden: true
          },
          {
            label: 'CLASS',
            name: 'class',
            align: 'left'
          },
          {
            label: 'METHOD',
            name: 'method',
            align: 'left'
          },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
            align: 'center'
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
            align: 'center',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rownumbers: true,
        rownumWidth: 45,
        rowNum: 10,
        rowList: [10, 20, 50, 0],
        toolbar: [true, "top"],
        sortable: true,
        viewrecords: true,
        prmNames: {
          sort: 'sortIndex',
          order: 'sortOrder',
          rows: 'limit'
        },
        jsonReader: {
          root: 'data',
          // total: 'attributes.totalPages',
          // records: 'attributes.totalRows',
        },
        onSelectRow: function(id) {
          activeGrid = $(this)
        },
        loadBeforeSend: (jqXHR) => {
          jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
        }
      })

      .customPager({
        buttons: [{
          id: 'editUserAcl',
          innerHTML: '<i class="fa fa-pen"></i> EDIT',
          class: 'btn btn-success btn-sm',
          onClick: () => {
            let roleId = $('#jqGrid').jqGrid('getGridParam', 'selrow')

            editUserAcl(roleId)
          }
        }]
      })
  }

  function loadAclData(roleId) {
    $('#roleAclGrid').setGridParam({
      url: `${apiUrl}role/${roleId}/acl`,
      datatype: 'json'
    }).trigger('reloadGrid')
  }
</script>