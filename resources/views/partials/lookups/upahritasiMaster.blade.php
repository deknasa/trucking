<?php
if (isset($id)) { ?>
  <table id="upahritasiLookup<?= $id ?>" class="lookup-grid"></table>
<?php
} else { ?>
  <table id="upahritasiLookup" class="lookup-grid"></table>
<?php } ?>
<div class="loadingMessage">
  <img class="loading-image" src="{{ asset('libraries/tas-lib/img/loading-lookup.gif') }}" alt="Loading">
  <p class="loading-text">Loading data...</p>

</div>

<?php
$idLookup = isset($id) ? $id : null;

?>
<script>
  var idLookup = '{{ $idLookup }}';
  var idTop

  selector = $(`#upahritasiLookup{{ isset($id) ? $id : null }} `)


  var singleColumn = `{{ $singleColumn ?? '' }}`


  //  use this witdh if single column lookup
  if (detectDeviceType() == "desktop" && singleColumn !== '') {
    width = '1600px'
  } else if (detectDeviceType() == "mobile") {
    width = '350px'

  }


  if (singleColumn) {
    column = [{
        label: "ID",
        name: "id",
        width: "50px",
        hidden: true,
        sortable: false,
        search: false,
      },
      {
        label: 'dari',
        name: 'kotadari_id',
        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
      },
    ];
  } else {
    column = [{
        label: "ID",
        name: "id",
        width: "50px",
        hidden: true,
        sortable: false,
        search: false,
      },
      {
        label: 'dari',
        name: 'kotadari_id',
        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
      },
      {
        label: 'tujuan',
        name: 'kotasampai_id',
        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
      },
      {
        label: 'jarak',
        name: 'jarak',
        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
        formatter: currencyFormat
      },
      {
        label: 'status aktif',
        name: 'statusaktif',
        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
        stype: 'select',
      },
      {
        label: 'tgl mulai berlaku',
        name: 'tglmulaiberlaku',
        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
        formatter: "date",
        formatoptions: {
          srcformat: "ISO8601Long",
          newformat: "d-m-Y"
        }
      },
      {
        label: "Modified By",
        name: "modifiedby",
        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
      },
      {
        label: "Created At",
        name: "created_at",
        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
        formatter: "date",
        formatoptions: {
          srcformat: "ISO8601Long",
          newformat: "d-m-Y H:i:s",
        },
        align: 'right',
      },
      {
        label: "Updated At",
        name: "updated_at",
        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
        formatter: "date",
        formatoptions: {
          srcformat: "ISO8601Long",
          newformat: "d-m-Y H:i:s",
        },
        align: 'right',
      },
    ]
  }

  selector.jqGrid({
    url: `{{ config('app.api_url') . 'upahritasi' }}`,
    mtype: "GET",
    styleUI: 'Bootstrap4',
    iconSet: 'fontAwesome',
    datatype: "json",
    // postData: {
    //   aktif: `{!! $Aktif ?? '' !!}`,
    //   roleinput: `{!! $roleInput ?? '' !!}`,
    //   isLookup: `{!! $isLookup ?? '' !!}`,
    // },
    idPrefix: 'upahritasiLookup',
    colModel: column,
    height: 350,
    fixed: true,
    rownumbers: false,
    rownumWidth: 0,
    rowNum: `{!! $limit ?? 11 !!}`,
    rowList: [10, 20, 50, 0],
    sortable: true,
    sortname: 'id',
    sortorder: 'asc',
    page: 1,
    toolbar: [true, "top"],
    viewrecords: true,
    prmNames: {
      sort: 'sortIndex',
      order: 'sortOrder',
      rows: 'limit'
    },
    jsonReader: {
      root: 'data',
      total: 'attributes.totalPages',
      records: 20,
    },
    autowidth: true,
    scrollOffset: 1,
    scrollrows: false,
    shrinkToFit: false,
    scrollLeftOffset: "25%",
    scroll: true,
    height: 350,
    page: 1,
    selectedIndex: 0,
    triggerClick: false,
    search: true,
    serializeGridData: function(postData, searching) {
      searching = `{{ $searching }}`
      searchText = `.{{ $searchText }} `

      aksi = `{!! $aksi ?? '' !!}`

      postData.sort_indexes = [postData.sort_index];
      postData.sort_orders = [postData.sort_order];

      var colModel = $(this).jqGrid("getGridParam", "colModel"),
        l = colModel.length,
        i,
        rules = [],
        searchValue = $(searchText).val(),
        cm;

      input = $(searchText).data('input')

      if (input) {
        var typeSearch = `{{ $typeSearch ?? '' }}`

        if (typeSearch === 'ALL') {

          for (i = 0; i < l; i++) {
            cm = colModel[i];

            if (cm.search !== false && (cm.stype === undefined || cm.stype ===
                "text")) {
              rules.push({
                field: cm.name,
                op: "cn",
                data: searchValue.toUpperCase(),
              });


              postData.filters = JSON.stringify({
                groupOp: "OR",
                rules: rules,
              });
            }

          }

          // $(searchText).focus()

          postData.searching = searching;
          postData.searchText = searchText;

        } else {
          cm = colModel[searching];

          if (cm.search !== false && (cm.stype === undefined || cm.stype ===
              "text")) {

            postData.filters = JSON.stringify({
              groupOp: "AND",
              rules: [{
                field: cm.name,
                op: "cn",
                data: $(searchText).val().toUpperCase()
              }]
            });

            $(searchText).focus()
          }

          postData.searching = searching;
          postData.searchText = searchText;
        }

        delete postData.sort_index;
        delete postData.sort_order;
      }

      return postData;
    },

    loadBeforeSend: function(jqXHR) {
      $('.loadingMessage').show();
      idTop = selector.attr('id')
      $(`#load_${idTop}`).remove()

      if (detectDeviceType() == 'mobile') {

        $('.lookup-grid tr:not(.jqgfirstrow) td').css('padding', '12px')
        $('.lookup-grid tr:not(.jqgfirstrow) td').css('font-size', '1rem')

        $(`#gview_${idTop} .ui-th-column `).css('font-size', '1rem')
        var title = `{{ $title ?? '' }}`
        var label = $("<label>").attr("for", "searchText")
          .css({
            "font-weight": "normal",
            "padding-left": "10px",
            "padding-top": "5px"
          })
          .text(title);

        $(`#gbox_${idTop}`).find('.ui-userdata-top').css({
          "height": "1px",
        })
      } else {
        var title = `{{ $title ?? '' }}`
        var label = $("<label>").attr("for", "searchText")
          .css({
            "font-weight": "normal",
            "padding-left": "10px",
            "padding-top": "1px"
          })
          .text(title);

        $(`#gbox_${idTop}`).find('.ui-jqgrid').css({
          "min-height": "24px!important"
        })

        $(`#gbox_${idTop}`).find('.ui-userdata-top').css({
          "height": "1px",
          "min-height": "25px"
        })
      }

      // Mengecek apakah label belum ada sebelumnya
      if ($(`#t_${idTop} label[for='searchText']`).length === 0) {
        $(`#t_${idTop}`).append(label);
      }

      var hideLabel = `{{ $hideLabel ?? '' }}`

      if (hideLabel) {
        $(`#gbox_${idTop}`).find('.ui-jqgrid-hdiv').hide()
      }
      $('.ui-scroll-popup').addClass('d-none')
      $('.modal-loader-content').addClass('d-none')

      jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
      setGridLastRequest($(this), jqXHR)
    },
    onSelectRow: function(id) {
      activeGrid = this;

      let limit = $(this).jqGrid("getGridParam", "postData").limit;
      let page = $(this).jqGrid("getGridParam", "page");
      let selectedIndex = $(this).jqGrid("getCell", id, "rn") - 1;

      if (selectedIndex >= limit)
        selectedIndex = selectedIndex - limit * (page - 1);

      $(this).jqGrid("setGridParam", {
        selectedIndex,
      });
    },
    loadComplete: function(data) {

      $('.loadingMessage').hide();
      idTop = selector.attr('id')

      var colModel = selector.jqGrid('getGridParam', 'colModel');
      var firstColumnName = colModel[1].name;

      if (detectDeviceType() == 'mobile') {
        $('.lookup-grid tr:not(.jqgfirstrow) td').css('padding', '12px')
        $('.lookup-grid tr:not(.jqgfirstrow) td').css('font-size', '1rem')
        $(`#gview_${idTop} .ui-th-column `).css('font-size', '1rem')
      }

      let modal = $('#crudModal')
      let form = modal.find('form')
      let valueName = `{{ $valueName }}`

      changeJqGridRowListText();

      if (data.data.length === 0) {
        $('#parameterGrid').each((index, element) => {
          abortGridLastRequest($(element))
          clearGridHeader($(element))
        })
      } else {
        $(form).find('.is-invalid').removeClass('is-invalid');
        $(form).find('.invalid-feedback').remove();
      }

      if (detectDeviceType() == 'desktop') {
        $(document).unbind('keydown')
        // setCustomBindKeys($(this))
        initResize($(this))


        let selectedIndex = $(this).jqGrid("getGridParam").selectedIndex;

        if (selectedIndex > $(this).getDataIDs().length - 1) {
          selectedIndex = $(this).getDataIDs().length - 1;
        }

        if ($(this).jqGrid("getGridParam").triggerClick) {

          $(this)
            .find(`tr[id="${$(this).getDataIDs()[selectedIndex]}"]`)
            .click();

          $(this).jqGrid("setGridParam", {
            triggerClick: false,
          });
        } else {

          // $(this).setSelection($(this).getDataIDs()[selectedIndex]);
        }
      }

      $('.clearsearchclass').click(function() {
        clearColumnSearch($(this))
      })
      $(this).setGridWidth($('#lookupCabang').prev().width())
      setHighlight($(this))
    },
  })
</script>

</html>