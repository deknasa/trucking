<table id="userRoleGrid"></table>

@include('user.role._modal')

<script>
  function loadGrid(userId) {
    $('#userRoleGrid')
      .jqGrid({
        url: `${apiUrl}user/${userId}/role`,
        datatype: 'json',
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        colModel: [{
            label: 'USER',
            name: 'user',
            align: 'left',
            hidden: true
          },
          {
            label: 'ROLE',
            name: 'rolename',
          },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
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
        },
        onSelectRow: function(id) {
          activeGrid = $(this)
        },
        loadBeforeSend: (jqXHR) => {
          jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()
        }
      })

      .customPager({
        buttons: [{
          id: 'editUserRole',
          innerHTML: '<i class="fa fa-pen"></i> EDIT',
          class: 'btn btn-success btn-sm',
          onClick: () => {
            let userId = $('#jqGrid').jqGrid('getGridParam', 'selrow')

            editUserRole(userId)
          }
        }]
      })
  }

  function loadRoleData(userId) {
    $('#userRoleGrid').setGridParam({
      url: `${apiUrl}user/${userId}/role`,
      datatype: 'json'
    }).trigger('reloadGrid')
  }
</script>