

@push('scripts')
<script>
  function loadRoleAclGrid() {
    $('#roleAclGrid')
      .jqGrid({
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'roleAclGrid',
        colModel: [{
            label: 'CLASS',
            name: 'class',
            width: (detectDeviceType() == "desktop") ? md_dekstop_3 : md_mobile_3,
            align: 'left'
          },
          {
            label: 'METHOD',
            name: 'method',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
            align: 'left'
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
            align: 'left'
          },          
          {
            label: 'MODIFIED BY',
            name: 'modifiedby',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'UPDATED AT',
            name: 'updated_at',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
        loadBeforeSend: function(jqXHR) {
          jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
          setGridLastRequest($(this), jqXHR)
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
          abortGridLastRequest($(this))

          clearGlobalSearch($('#acoGrid'))
        },
      })

      .customPager()

    loadClearFilter($('#roleAclGrid'))
    loadGlobalSearch($('#roleAclGrid'))
  }

  function loadRoleAclData(roleId) {
    abortGridLastRequest($('#roleAclGrid'))

    $('#roleAclGrid').setGridParam({
      url: `${apiUrl}role/${roleId}/acl`,
      datatype: 'json'
    }).trigger('reloadGrid')
  }
</script>
@endpush