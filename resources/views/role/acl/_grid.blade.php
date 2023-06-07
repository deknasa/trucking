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
        colModel: [
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
          total: 'attributes.totalPages',
          records: 'attributes.totalRows',
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
              indexRow = parseInt($('#roleAclGrid').jqGrid('getInd', id)) - 1
              $(`#roleAclGrid [id="${$('#roleAclGrid').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#roleAclGrid [id="${$('#roleAclGrid').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#roleAclGrid').getDataIDs()[indexRow] == undefined) {
              $(`#roleAclGrid [id="` + $('#roleAclGrid').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#roleAclGrid').setSelection($('#roleAclGrid').getDataIDs()[indexRow])
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
          id: 'editRoleAcl',
          innerHTML: '<i class="fa fa-pen"></i> EDIT',
          class: 'btn btn-success btn-sm',
          onClick: () => {
            let roleId = $('#jqGrid').jqGrid('getGridParam', 'selrow')

            editRoleAcl(roleId)
          }
        }]
      })
      
    loadClearFilter($('#roleAclGrid'))
    loadGlobalSearch($('#roleAclGrid'))
  }

  function loadAclData(roleId) {
    $('#roleAclGrid').setGridParam({
      url: `${apiUrl}role/${roleId}/acl`,
      datatype: 'json'
    }).trigger('reloadGrid')
  }
</script>