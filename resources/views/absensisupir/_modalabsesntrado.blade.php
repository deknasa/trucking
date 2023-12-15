<div class="modal fade modal-fullscreen" id="cekAbsenTradoModal" tabindex="-1" aria-labelledby="cekAbsenTradoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title" id="crudModalTitle">Cek Absensi Trado</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          
        </button>
      </div>
      <div class="modal-body">
        
        <div class="row form-group">
          
          <div class="col-12 col-sm-3 col-md-2">
            <label class="col-form-label">no bukti </label>
          </div>
          <div class="col-12 col-sm-9 col-md-4">
            <input type="text" readonly name="nobukti" class="form-control">
          </div>
          <div class="col-12 col-sm-3 col-md-2">
            <label class="col-form-label">TGL BUKTI </label>
          </div>
          <div class="col-12 col-sm-9 col-md-4">  
            <div class="input-group">
              <input type="text" name="tglbukti" class="form-control" readonly>
            </div>
          </div>
        </div>
          
        <div class="row form-group">
          <table id="gridStatusAbsen"></table>
        </div>
        
        <div class="row form-group">
          {{-- <div class=" col-12"> --}}
            <table id="modalgrid"></table>
          {{-- </div> --}}
        </div>
          


            

          
        
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  let modalAbsen = $('#cekAbsenTradoModal').find('.modal-body').html()
  let rowNumAbsen = 0
  $(document).ready(function() {


    Inputmask("datetime", {
      inputFormat: "HH:MM",
      max: 24
    }).mask(".inputmask-time");

    $(document).on('click', "#addRow", function() {
      addRow()
    });

    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $(document).on('input', `#table_body [name="uangjalan[]"]`, function(event) {
      setTotal()
    })

  })

  $('#cekAbsenTradoModal').on('shown.bs.modal', () => {
    activeGrid = null
    initDatepicker()
  })

  $('#cekAbsenTradoModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'

    $('#cekAbsenTradoModal').find('.modal-body').html(modalAbsen)
  })

  function cekAbsenTrado(id) {
    $('#cekAbsenTradoModal').modal('show')
    showAbsensiSupirCek($('#cekAbsenTradoModal'), id)
  }

  function loadModalGrid(mydata) {
    $("#modalgrid").jqGrid({
    
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        data:mydata,
        colModel: [{
            label: 'TRADO',
            name: 'trado'
          },
          {
            label: 'SUPIR',
            name: 'supir',
          },
          {
            label: 'STATUS',
            name: 'status',
            formatter: (value, options, rowData) => {
              let statusAbsen = JSON.parse(rowData.memo)
              if (!statusAbsen) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusAbsen.WARNA}; color: #fff;">
                  <span>${value}</span>
                </div>
              `)
              
              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowData) => {
              return ` title="${rowData.statusKeterangan}"`
            }
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan_detail',
          },
          {
            label: 'JAM',
            name: 'jam',
            formatter:'date',
            formatoptions:{
              srcformat: "H:i:s",
              newformat: "H:i",
              // userLocalTime : true
            }
          },
          {
            label: 'UANG JALAN',
            name: 'uangjalan',
            formatter: 'number',
            formatoptions: {
              thousandsSeparator: ",",
              decimalPlaces: 0
            },
            align: "right",
          },
          {
            label: 'JUMLAH TRIP',
            name: 'jumlahtrip',
            formatter: 'number',
            formatoptions: {
              thousandsSeparator: ",",
              decimalPlaces: 0
            },
            align: "right",
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 50,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [0],
        toolbar: [true, "top"],
        sortable: true,
        viewrecords: true,
        footerrow:true,
        
       
        loadComplete: function(data) {
          changeJqGridRowListText()
          initResize($(this))

          let nominals = $(this).jqGrid("getCol", "uangjalan")
          let totalNominal = 0

          if (nominals.length > 0) {
            totalNominal = nominals.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRow > $(this).getDataIDs().length - 1) {
            indexRow = $(this).getDataIDs().length - 1;
          }

          $('#modalgrid').setSelection($('#modalgrid').getDataIDs()[0])
          setHighlight($(this))
          $(this).jqGrid('footerData', 'set', {
            trado: 'Total:',
            uangjalan: totalNominal,
          }, true)
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
          
          clearGlobalSearch($('#detail'))
        },
      })
      .customPager({})
      /* Append clear filter button */
    loadClearFilter($('#modalgrid'))
    
    /* Append global search */
    loadGlobalSearch($('#modalgrid'))
  }
  function loadGridStatusAbsen(mydata) {
    $("#gridStatusAbsen").jqGrid({
    
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        data:mydata,
        colModel: [{
            label: 'kode',
            width:65,
            name: 'kodeabsen'
          },
          {
            label: 'jlh',
            width:65,
            name: 'jumlah',
            formatter: 'number',
            formatoptions: {
              thousandsSeparator: ",",
              decimalPlaces: 0
            },
            align: "right",
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 100,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50],
        toolbar: [true, "top"],
        sortable: true,
        // pager:"#gridStatusAbsenPager",
        viewrecords: true,
        footerrow:true,


       
        loadComplete: function(data) {
          changeJqGridRowListText()
          initResize($(this))

          let nominals = $(this).jqGrid("getCol", "jumlah")
          let total = 0

          if (nominals.length > 0) {
            total = nominals.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }

          $(this).jqGrid('footerData', 'set', {
            kodeabsen: 'Total:',
            jumlah: total,
          }, true)
        }
      }).customPager({})
  }

  function showAbsensiSupirCek(form, absensiId) {
    $('#detailList tbody').html('')
    $.ajax({
      url: `${apiUrl}absensisupirheader/${absensiId}/cekabsensi`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data:{
        absensi_id: absensiId,
        notIndex:"true", 
        limit: 0
      },
      success: response => {
        $.each(response.data, (index, value) => {
          let element = form.find(`[name="${index}"]`)

          if (element.hasClass('datepicker')) {
            element.val(dateFormat(value))
          } else {
            element.val(value)
          }
        })
        let row ="";
        $.each(response.absenTrado, (index, value) => {
          
          row += `
          <div class="row">
            <div class="col-12 col-md-6">
              <label class="col-form-label">${value.kodeabsen}</label>
            </div>
            <div class="col-12 col-md-6">
              <input type="text" value="${value.jumlah}" class="form-control" readonly>
            </div>
          </div>
          `});
        // $("#statusAbsen").html(row);
        loadModalGrid(response.detail)
        loadGridStatusAbsen(response.absenTrado)

      }
    })
  }
  
</script>
@endpush