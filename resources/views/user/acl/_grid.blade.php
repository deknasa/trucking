
@push('scripts')
<script>
  function loadUserAclGrid() {
    $('#userAclGrid')
      .jqGrid({
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'userAclGrid',
        colModel: [{
            label: 'CLASS',
            width: (detectDeviceType() == "desktop") ? md_dekstop_3 : md_mobile_3,            
            name: 'class',
          },
          {
            label: 'METHOD',
            name: 'method',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,            
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
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,            
          },
          {
            label: 'UPDATED AT',
            name: 'updated_at',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,            
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
              indexRow = parseInt($('#userAclGrid').jqGrid('getInd', id)) - 1
              $(`#userAclGrid [id="${$('#userAclGrid').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#userAclGrid [id="${$('#userAclGrid').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#userAclGrid').getDataIDs()[indexRow] == undefined) {
              $(`#userAclGrid [id="` + $('#userAclGrid').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#userAclGrid').setSelection($('#userAclGrid').getDataIDs()[indexRow])
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

    loadClearFilter($('#userAclGrid'))
    loadGlobalSearch($('#userAclGrid'))
  }

  function loadUserAclData(userId) {
    abortGridLastRequest($('#userAclGrid'))

    $('#userAclGrid').setGridParam({
      url: `${apiUrl}user/${userId}/acl`,
      datatype: 'json'
    }).trigger('reloadGrid')
  }
</script>
@endpush