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
        colModel: [
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
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let rows = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= rows) indexRow = (indexRow - rows * (page - 1))
        },
        loadBeforeSend: (jqXHR) => {
          jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()

          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#userRoleGrid').jqGrid('getInd', id)) - 1
              $(`#userRoleGrid [id="${$('#userRoleGrid').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#userRoleGrid [id="${$('#userRoleGrid').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#userRoleGrid').getDataIDs()[indexRow] == undefined) {
              $(`#userRoleGrid [id="` + $('#userRoleGrid').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#userRoleGrid').setSelection($('#userRoleGrid').getDataIDs()[indexRow])
          }
          
          setHighlight($(this))
        }
      })
      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
        beforeSearch: function() {
          clearGlobalSearch($('#acoGrid'))
        },
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
    loadClearFilter($('#userRoleGrid'))
    loadGlobalSearch($('#userRoleGrid'))
  }

  function loadRoleData(userId) {
    $('#userRoleGrid').setGridParam({
      url: `${apiUrl}user/${userId}/role`,
      datatype: 'json'
    }).trigger('reloadGrid')
  }
</script>