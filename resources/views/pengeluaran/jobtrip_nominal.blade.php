<div class="table-responsive">
    <table class="table table-bordered table-bindkeys" id="bodytTableModal" style="width: 1300px;">
        <thead>
            <tr>
                <th width="3%">KEY <span class="text-danger">*</span></th>
                <th width="8%">VALUE <span class="text-danger">*</span></th>
                <th width="2%" class="tbl_aksi">Aksi</th>
            </tr>
        </thead>
        <tbody id="table_body" class="form-group">
            
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

<script>
    addModalinput()
    $(document).on('click', "#addModalinput", function() {
        addModalinput()
    })
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
    
    $(document).on('click', '.deleteModalRow', function(event) {
        deleteRowModal($(this).parents('tr'))
    })

    function deleteRowModal(row) {
        let countRow = $('.deleteModalRow').parents('tr').length
        row.remove()
        if (countRow <= 1) {
          addRow()
        }
        setRowNumbers()
        setTotal()
        
    }
    
</script>
    
    


  
