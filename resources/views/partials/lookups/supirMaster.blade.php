<?php
if (isset($id)) { ?>
  <table id="supirLookup<?= $id ?>" class="lookup-grid"></table>
<?php
} else { ?>
  <table id="supirLookup" class="lookup-grid"></table>
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

  selector = $(`#supirLookup{{ isset($id) ? $id : null }} `)


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
        label: 'NAMA',
        name: 'namasupir',
        align: 'left',
      },
      
    ];
  } else {
    column = [
      {
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
          search: false,
          hidden: true
        },
        {
          label: 'NAMA',
          name: 'namasupir',
          align: 'left',
        },
        {
          label: 'TGL LAHIR',
          name: 'tgllahir',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        {
          label: 'ALAMAT',
          name: 'alamat',
          align: 'left'
        },
        {
          label: 'KOTA',
          name: 'kota',
          align: 'left'
        },
        {
          label: 'NO TELEPON',
          name: 'telp',
          align: 'left'
        },
        {
          label: 'STATUS AKTIF',
          name: 'statusaktif',
          align: 'left',
          stype: 'select',
          searchoptions: {
            dataInit: function(element) {
              $(element).select2({
                width: 'resolve',
                theme: "bootstrap4",
                ajax: {
                  url: `${apiUrl}parameter/combo`,
                  dataType: 'JSON',
                  headers: {
                    Authorization: `Bearer ${accessToken}`
                  },
                  data: {
                    grp: 'STATUS AKTIF',
                    subgrp: 'STATUS AKTIF'
                  },
                  beforeSend: () => {
                    // clear options
                    $(element).data('select2').$results.children().filter((index, element) => {
                      // clear options except index 0, which
                      // is the "searching..." label
                      if (index > 0) {
                        element.remove()
                      }
                    })
                  },
                  processResults: (response) => {
                    let formattedResponse = response.data.map(row => ({
                      id: row.text,
                      text: row.text
                    }));

                    formattedResponse.unshift({
                      id: '',
                      text: 'ALL'
                    });

                    return {
                      results: formattedResponse
                    };
                  },
                }
              });
            }
          },
          formatter: (value, options, rowData) => {
            let statusAktif = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusAktif.WARNA}; color: ${statusAktif.WARNATULISAN};">
                  <span>${statusAktif.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusAktif = JSON.parse(rowObject.statusaktif)

            return ` title="${statusAktif.MEMO}"`
          }
        },
        {
          label: 'NOMINAL DEPOSIT',
          name: 'nominaldepositsa',
        },
        {
          label: 'NOM PINJ SALDO AWAL',
          name: 'nominalpinjamansaldoawal',
        },
        {
          label: 'SUPIR LAMA',
          name: 'supirold_id',
        },
        {
          label: 'SIM',
          name: 'nosim',
        },
        {
          label: 'TGL EXP SIM',
          name: 'tglexpsim',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        {
          label: 'TGL TERBIT SIM',
          name: 'tglterbitsim',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
        },
        {
          label: 'KTP',
          name: 'noktp',
        },
        {
          label: 'KK',
          name: 'nokk',
        },
        {
          label: 'STATUS ADA UPDATE GBR',
          name: 'statusadaupdategambar',
          stype: 'select',
          searchoptions: {
            dataInit: function(element) {
              $(element).select2({
                width: 'resolve',
                theme: "bootstrap4",
                ajax: {
                  url: `${apiUrl}parameter/combo`,
                  dataType: 'JSON',
                  headers: {
                    Authorization: `Bearer ${accessToken}`
                  },
                  data: {
                    grp: 'STATUS ADA UPDATE GAMBAR',
                    subgrp: 'STATUS ADA UPDATE GAMBAR'
                  },
                  beforeSend: () => {
                    // clear options
                    $(element).data('select2').$results.children().filter((index, element) => {
                      // clear options except index 0, which
                      // is the "searching..." label
                      if (index > 0) {
                        element.remove()
                      }
                    })
                  },
                  processResults: (response) => {
                    let formattedResponse = response.data.map(row => ({
                      id: row.text,
                      text: row.text
                    }));

                    formattedResponse.unshift({
                      id: '',
                      text: 'ALL'
                    });

                    return {
                      results: formattedResponse
                    };
                  },
                }
              });
            }
          },
          formatter: (value, options, rowData) => {
            let statusAdaUpdateGambar = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusAdaUpdateGambar.WARNA}; color: #fff;">
                  <span>${statusAdaUpdateGambar.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusAdaUpdateGambar = JSON.parse(rowObject.statusadaupdategambar)

            return ` title="${statusAdaUpdateGambar.MEMO}"`
          }
        },
        {
          label: 'STATUS LUAR KOTA',
          name: 'statusluarkota',
          stype: 'select',
          searchoptions: {
            dataInit: function(element) {
              $(element).select2({
                width: 'resolve',
                theme: "bootstrap4",
                ajax: {
                  url: `${apiUrl}parameter/combo`,
                  dataType: 'JSON',
                  headers: {
                    Authorization: `Bearer ${accessToken}`
                  },
                  data: {
                    grp: 'STATUS LUAR KOTA',
                    subgrp: 'STATUS LUAR KOTA'
                  },
                  beforeSend: () => {
                    // clear options
                    $(element).data('select2').$results.children().filter((index, element) => {
                      // clear options except index 0, which
                      // is the "searching..." label
                      if (index > 0) {
                        element.remove()
                      }
                    })
                  },
                  processResults: (response) => {
                    let formattedResponse = response.data.map(row => ({
                      id: row.text,
                      text: row.text
                    }));

                    formattedResponse.unshift({
                      id: '',
                      text: 'ALL'
                    });

                    return {
                      results: formattedResponse
                    };
                  },
                }
              });
            }
          },
          formatter: (value, options, rowData) => {
            let statusLuarKota = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusLuarKota.WARNA}; color: #fff;">
                  <span>${statusLuarKota.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusLuarKota = JSON.parse(rowObject.statusluarkota)

            return ` title="${statusLuarKota.MEMO}"`
          }
        },
        {
          label: 'ZONA TERTENTU',
          name: 'statuszonatertentu',
          stype: 'select',
          searchoptions: {
            dataInit: function(element) {
              $(element).select2({
                width: 'resolve',
                theme: "bootstrap4",
                ajax: {
                  url: `${apiUrl}parameter/combo`,
                  dataType: 'JSON',
                  headers: {
                    Authorization: `Bearer ${accessToken}`
                  },
                  data: {
                    grp: 'ZONA TERTENTU',
                    subgrp: 'ZONA TERTENTU'
                  },
                  beforeSend: () => {
                    // clear options
                    $(element).data('select2').$results.children().filter((index, element) => {
                      // clear options except index 0, which
                      // is the "searching..." label
                      if (index > 0) {
                        element.remove()
                      }
                    })
                  },
                  processResults: (response) => {
                    let formattedResponse = response.data.map(row => ({
                      id: row.text,
                      text: row.text
                    }));

                    formattedResponse.unshift({
                      id: '',
                      text: 'ALL'
                    });

                    return {
                      results: formattedResponse
                    };
                  },
                }
              });
            }
          },
          formatter: (value, options, rowData) => {
            let statusZonaTertentu = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusZonaTertentu.WARNA}; color: #fff;">
                  <span>${statusZonaTertentu.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusZonaTertentu = JSON.parse(rowObject.statuszonatertentu)

            return ` title="${statusZonaTertentu.MEMO}"`
          }
        },
        {
          label: 'ZONA',
          name: 'zona_id',
        },
        {
          label: 'angsuran pinjaman',
          name: 'angsuranpinjaman',
        },
        {
          label: 'plafondeposito',
          name: 'plafondeposito',
        },
        {
          label: 'TGL BERHENTI SUPIR',
          name: 'tglberhentisupir',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        {
          label: 'KET RESIGN',
          name: 'keteranganresign',
        },
        {
          label: 'STATUS BLACKLIST',
          name: 'statusblacklist',
          stype: 'select',
          searchoptions: {
            dataInit: function(element) {
              $(element).select2({
                width: 'resolve',
                theme: "bootstrap4",
                ajax: {
                  url: `${apiUrl}parameter/combo`,
                  dataType: 'JSON',
                  headers: {
                    Authorization: `Bearer ${accessToken}`
                  },
                  data: {
                    grp: 'BLACKLIST SUPIR',
                    subgrp: 'BLACKLIST SUPIR'
                  },
                  beforeSend: () => {
                    // clear options
                    $(element).data('select2').$results.children().filter((index, element) => {
                      // clear options except index 0, which
                      // is the "searching..." label
                      if (index > 0) {
                        element.remove()
                      }
                    })
                  },
                  processResults: (response) => {
                    let formattedResponse = response.data.map(row => ({
                      id: row.text,
                      text: row.text
                    }));

                    formattedResponse.unshift({
                      id: '',
                      text: 'ALL'
                    });

                    return {
                      results: formattedResponse
                    };
                  },
                }
              });
            }
          },
          formatter: (value, options, rowData) => {
            let statusBlacklist = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusBlacklist.WARNA}; color: #fff;">
                  <span>${statusBlacklist.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusBlacklist = JSON.parse(rowObject.statusblacklist)

            return ` title="${statusBlacklist.MEMO}"`
          }
        },
        {
          label: 'MODIFIED BY',
          name: 'modifiedby',
          align: 'left'
        },
        {
          label: 'CREATED AT',
          name: 'created_at',
          align: 'right',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y H:i:s"
          }
        },
        {
          label: 'UPDATED AT',
          name: 'updated_at',
          align: 'right',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y H:i:s"
          }
        },
    ]
  }

  selector.jqGrid({
    url: `{{ config('app.api_url') . 'supir' }}`,
    mtype: "GET",
    styleUI: 'Bootstrap4',
    iconSet: 'fontAwesome',
    datatype: "json",
    postData: {
        aktif: `{!! $Aktif ?? '' !!}`,
        absen: `{!! $AbsensiId ?? '' !!}`,
        supir_id: `{!! $supir_id ?? '' !!}`,
        tgltrip: `{!! $tgltrip ?? '' !!}`,
      },
    idPrefix: 'supirLookup',
    colModel: column,
    height: 350,
    fixed: true,
    rownumbers: false,
    rownumWidth: 0,
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

      console.log('serialize')
      var colModel = $(this).jqGrid("getGridParam", "colModel"),
        l = colModel.length,
        i,
        rules = [],
        searchValue = $(searchText).val(),
        cm;
      currentValue = $(searchText).data('currentValue')

      if (!currentValue) {
        var typeSearch = `{{ $typeSearch ?? '' }}`
        if (typeSearch === 'ALL') {
          for (i = 0; i < l; i++) {
            cm = colModel[i];

            if (cm.search !== false && (cm.stype === undefined || cm.stype === "text")) {
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
          postData.searching = searching;
          postData.searchText = searchText;
        } else {
          cm = colModel[searching];

          if (cm.search !== false && (cm.stype === undefined || cm.stype === "text")) {
            rules.push({
              field: cm.name,
              op: "cn",
              data: searchValue.toUpperCase(),
            });
            postData.filters = JSON.stringify({
              groupOp: "AND",
              rules: rules,
            });
            $(searchText).focus()
          }
          postData.searching = searching;
          postData.searchText = searchText;
        }
      } else {
        $(searchText).on("input", function(event) {
          var typeSearch = `{{ $typeSearch ?? '' }}`
          if (typeSearch === 'ALL') {
            for (i = 0; i < l; i++) {
              cm = colModel[i];
              if (cm.search !== false && (cm.stype === undefined || cm.stype === "text")) {

                postData.filters = JSON.stringify({
                  groupOp: "OR",
                  rules: [{
                    field: cm.name,
                    op: "cn",
                    data: $(searchText).val().toUpperCase()
                  }]
                });
              }
            }
            postData.searching = searching;
            postData.searchText = searchText;
          } else {
            cm = colModel[searching];

            if (cm.search !== false && (cm.stype === undefined || cm.stype === "text")) {

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
        })
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