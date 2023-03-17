<div class="card card-primary">
    <div class="card-header">
    </div>
    <form id="rangeHeader">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                <div class="col-sm-4 mt-2">
                    <div class="input-group">
                        <input type="text" name="tgldariheader" id="tgldariheader" class="form-control datepicker">
                    </div>
                </div>
                <div class="col-sm-1 mt-2 text-center">
                    <label class="mt-2">s/d</label>
                </div>
                <div class="col-sm-4 mt-2">
                    <div class="input-group">
                        <input type="text" name="tglsampaiheader" id="tglsampaiheader" class="form-control datepicker">
                    </div>
                </div>
            </div>
            @stack('addtional-field')
            <div class="row">

                <div class="col-sm-6 mt-4">
                    <a id="btnReload" class="btn btn-secondary mr-2 ">
                        <i class="fas fa-sync"></i>
                        Reload
                    </a>
                </div>
            </div>

        </div>
    </form>
  </div>
  