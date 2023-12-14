
@push('scripts')
<script>
  function loadUserRoleGrid() {
    $('#userRoleGrid')
      .jqGrid({
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'userRoleGrid',
        colModel: [{
            label: 'ROLE',
            name: 'rolename',
          },
          {
            label: 'MODIFIED BY',
            name: 'modifiedby',
          },
          {
            label: 'UPDATED AT',
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
        loadBeforeSend: function(jqXHR) {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

          setGridLastRequest($(this), jqXHR)
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
          abortGridLastRequest($(this))

          clearGlobalSearch($('#acoGrid'))
        },
      })

      .customPager()
    loadClearFilter($('#userRoleGrid'))
    loadGlobalSearch($('#userRoleGrid'))
  }

  function loadUserRoleData(userId) {
    abortGridLastRequest($('#userRoleGrid'))

    $('#userRoleGrid').setGridParam({
      url: `${apiUrl}user/${userId}/role`,
      datatype: 'json'
    }).trigger('reloadGrid')
  }
</script>
@endpush