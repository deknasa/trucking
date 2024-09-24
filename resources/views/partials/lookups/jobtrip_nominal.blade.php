<form id="input-modal-form">
<div class="">
    <table class="table table-bordered table-bindkeys" id="bodytTableModal" style="width: 1300px;">
        <thead>
            <tr>
                <th width="8%">Job <span class="text-danger">*</span></th>
                <th width="3%">Nominal <span class="text-danger">*</span></th>
                <th width="2%" class="tbl_aksi">Aksi</th>
            </tr>
        </thead>

        <tbody id="table_bodyModal" class="form-group">
            
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"></td>
                <td class="tbl_aksi">
                    <button type="button" class="btn btn-primary btn-sm my-2" id="addModalinput">Tambah</button>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
</form>

<script>
    $('#bodytTableModal tbody').html('')
    var dataInput = `{{$data}}`;
    if (dataInput != '') {
        showDataModal(dataInput)
        // console.log(dataInput);
    }else{
        addModalinput()
    }

    $("#input-modal-form"). off('click').on('click', "#addModalinput", function() {
        addModalinput()
    })

  
    var xxxxxx=0
    function addModalinput() {
        let detailRow = $(`
        <tr>
            <td>
                <input type="text" name="job_emkl[]" id="jobemkl-${indexModalRow}" class="form-control jobemkl-lookup_${indexModalRow}">
            </td>
            
            <td>
                <input type="text" name="nominal_job[]" style="text-align:right" id="nominal_job_${indexModalRow}" class="form-control nominal">
            </td>
            
            <td class="tbl_aksi">
                <div class='btn btn-danger btn-sm deleteModalRow'>Delete</div>
            </td>
        </tr>`)
                        
        $('#bodytTableModal tbody').append(detailRow)
        initAutoNumericMinus($(`#nominal_job_${indexModalRow}`))
        initModalLookup(indexModalRow)
        // initAutoNumericMinus(detailRow.find(`[name="nominal_job[]"]`))
        indexModalRow++
    }


    function initModalLookup(index) {
        let rowLookup = index

    $(`.jobemkl-lookup_${rowLookup}`).lookupV3({
      title: 'Job Emkl Lookup',
      fileName: 'jobemklV3',
      searching: ['nobukti', 'shipper'],
      labelColumn: true,
      extendSize: md_extendSize_3,
      multiColumnSize: true,
      filterToolbar: true,
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          Aktif: 'AKTIF',
          jenisorder_id:`{{ $jenisorder_id ?? '' }}`,
        }
      },
      onSelectRow: (jobemkl, element) => {
        element.parents('td').find(`[name="nobukti[]"]`).val(jobemkl.coa)
        element.val(jobemkl.nobukti)
        element.data('currentValue', element.val())

      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))

      },
      onClear: (element) => {
        element.parents('td').find(`[name="nobukti[]"]`).val('')
        element.val('')
        element.data('currentValue', element.val())

      }
    })        
    }

    function showDataModal(data) {
        // Ganti entitas &quot; dengan tanda kutip "
        data = data.replace(/&quot;/g, '"');
        // Parse menjadi array JSON
        let jsonArray = JSON.parse(data);
        
        console.log(jsonArray);
        $.each(jsonArray, (index, detail) => {
            let detailRow = $(`
        <tr>
            <td>
                <input type="text" name="job_emkl[]" id="jobemkl-${index}" class="form-control jobemkl-lookup_${index}">
            </td>
            
            <td>
                <input type="text" name="nominal_job[]" style="text-align:right" id="nominal_job_${index}" class="form-control nominal">
            </td>
            
            <td class="tbl_aksi">
                <div class='btn btn-danger btn-sm deleteModalRow'>Delete</div>
            </td>
        </tr>`)

            detailRow.find(`[name="job_emkl[]"]`).val(detail.job_emkl)
            detailRow.find(`[name="job_emkl[]"]`).data('currentValue',detail.job_emkl)
            
            $('#bodytTableModal tbody').append(detailRow)
            detailRow.find(`[name="nominal_job[]"]`).val(detail.nominal)
            initAutoNumericMinus($(`#nominal_job_${index}`))
            initModalLookup(index);
            
          })

    }
    
    $(document).on('click', '.deleteModalRow', function(event) {
        // console.log($(this).parents('tr'))
        deleteRowModal($(this).parents('tr'))
    })

    function deleteRowModal(row) {
        let countRow = $('.deleteModalRow').parents('tr').length
        row.remove()
        if (countRow <= 1) {
            addModalinput()
        }
       
    }
    function setRowNumbersModels() {
        let elements = $('#bodytTableModal>#table_bodyModal>tr>td:nth-child(1)')

        elements.each((index, element) => {
        $(element).text(index + 1)
        })
    }
    
</script>
    
    


  
