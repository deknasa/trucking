<table id="userAclGrid"></table>

@include('user.acl._modal')

<script>
  function loadGrid(userId) {
    $('#userAclGrid')
      .jqGrid({
        url: `${apiUrl}user/${userId}/acl`,
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
        rowNum: 0,
        rowList: [10, 20, 50],
        toolbar: [true, "top"],
        sortable: true,
        viewrecords: true,
        prmNames: {
          sort: 'sortIndex',
          order: 'sortOrder',
          rows: 'limit'
        },
        jsonReader: {
          root: 'data'
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
            let userId = $('#jqGrid').jqGrid('getGridParam', 'selrow')

            editUserAcl(userId)
          }
        }]
      })
  }

  function loadAclData(userId) {
    $('#userAclGrid').setGridParam({
      url: `${apiUrl}user/${userId}/acl`,
      datatype: 'json'
    }).trigger('reloadGrid')
  }
</script>