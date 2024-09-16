<form id="input-modal-form">
<div class="table-responsive">
    <table class="table table-bordered table-bindkeys" id="bodytTableModal" style="width: 1300px;">
        <thead>
            <tr>
                <th width="3%">KEY <span class="text-danger">*</span></th>
                <th width="8%">VALUE <span class="text-danger">*</span></th>
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

    $(document). on('click', "#addModalinput", function() {
        addModalinput()
    })

  
    var xxxxxx=0
    function addModalinput() {
        let detailRow = (`
        <tr>
            <td>
                <input type="text" name="job_emkl[]" class="form-control ">
            </td>
            
            <td>
                <input type="text" name="nominal[]" class="form-control ">
            </td>
            
            <td class="tbl_aksi">
                <div class='btn btn-danger btn-sm deleteModalRow'>Delete</div>
            </td>
        </tr>`)
                        
        $('#bodytTableModal tbody').append(detailRow)

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
                <input type="text" name="job_emkl[]" class="form-control ">
            </td>
            
            <td>
                <input type="text" name="nominal[]" class="form-control ">
            </td>
            
            <td class="tbl_aksi">
                <div class='btn btn-danger btn-sm deleteModalRow'>Delete</div>
            </td>
        </tr>`)

            detailRow.find(`[name="job_emkl[]"]`).val(detail.job_emkl)
            detailRow.find(`[name="nominal[]"]`).val(detail.nominal)
            
            $('#bodytTableModal tbody').append(detailRow)
            
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
    
    


  
